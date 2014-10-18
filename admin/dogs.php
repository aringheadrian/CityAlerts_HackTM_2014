<?php

//Include the common file
require '../common.php';

//Check if the user is logged in
if (!$authentication->loggedIn() || !$authentication->isAdmin()) header("Location: login.php");

//Returns the number of rows
$rowCount = $db->rowCount("SELECT dog_id FROM " . cfg('base', 'table_dogs'));

//Pagination
if (isset($_GET['page']))
    $current_page = trim($_GET['page']);
else
    $current_page = 1;

$start = ($current_page -1 ) * cfg('base', 'per_page_admin');

$sql = "SELECT * FROM " . cfg('base', 'table_dogs') . " d, " . cfg('base', 'table_breed_translations') . " b, " . cfg('base', 'table_dog_translations') . " t WHERE d.dog_id = t.dog_id AND d.breed_id = b.breed_id AND b.language_code = '" . cfg('language', 'site_language') . "' AND t.language_code = '" . cfg('language', 'site_language') . "'";

$implode = array();

if (isset($_POST['search']) && !empty($_POST['filter_dog_name']))
    $implode[] = " LCASE(dog_name) LIKE '%" . strtolower($_POST['filter_dog_name']) . "%'";
	
if (isset($_POST['search']) && !empty($_POST['filter_breed_name']))
    $implode[] = " LCASE(breed_name) LIKE '%" . strtolower($_POST['filter_breed_name']) . "%'";

if ($implode)
    $sql .= " AND " . implode(" AND ", $implode);

$sql .= " ORDER BY d.dog_id DESC LIMIT " . $start . ", " . cfg('base', 'per_page_admin') . "";

$pages = ceil($db->rowCount("SELECT dog_id FROM " . cfg('base', 'table_dogs') . "") / cfg('base', 'per_page_admin'));

//dog
$dogs = array();

foreach ($db->query($sql) as $row) {

    $dogs[] = array(
        'dog_id'               => $row['dog_id'],
        'dog_name'               => $row['dog_name'],
        'dog_image'               => $row['dog_image'],
		'breed_name'               => $row['breed_name'],
        'dog_status'           => $row['dog_status'],
        'date_added'               => $row['date_added'],
		'views'                    => $row['views']
    );

}

//Check if the form has been submitted
if (isset($_POST['cb_dog'])) {

    foreach ($_POST['cb_dog'] as $value) {

        $result = $db->fetchRowAssoc("SELECT dog_image FROM " . cfg('base', 'table_dogs') . " WHERE dog_id = '" . $value . "'");

        if ($result['dog_image']) {

            @unlink(cfg('upload', 'upload_path') . 'images/' . $result['dog_image']);

        }

        $where = array(
            'dog_id' => $value
        );

        $db->where($where);
        $db->delete(cfg('base', 'table_dogs'));
    }

    header("Location: dogs.php");

}

//Template values
$tpl->set('rowCount', $rowCount);
$tpl->set('current_page', $current_page);
$tpl->set('pages', $pages);
$tpl->set('dogs', $dogs);

//Display the template
$tpl->display('admin/dogs');
