<?php

//Include the common file
require '../common.php';

//Check if the user is logged in
if (!$authentication->loggedIn() || !$authentication->isAdmin()) header("Location: login.php");

//Returns the number of rows
$rowCount = $db->rowCount("SELECT breed_id FROM " . cfg('base', 'table_breeds'));

//Pagination
if (isset($_GET['page']))
    $current_page = trim($_GET['page']);
else
    $current_page = 1;

$start = ($current_page -1 ) * cfg('base', 'per_page_admin');

$sql = "SELECT b.breed_id, b.breed_image, b.breed_status, t.breed_name FROM " . cfg('base', 'table_breeds') . " b, " . cfg('base', 'table_breed_translations') . " t WHERE t.language_code = '" . cfg('language', 'site_language') . "' AND b.breed_id = t.breed_id";

$implode = array();

if (isset($_POST['search']) && !empty($_POST['filter_breed_name']))
    $implode[] = " LCASE(breed_name) LIKE '%" . strtolower($_POST['filter_breed_name']) . "%'";
if ($implode)
    $sql .= " AND " . implode(" AND ", $implode);

$sql .= " LIMIT " . $start . ", " . cfg('base', 'per_page_admin') . "";

$pages = ceil($db->rowCount("SELECT breed_id FROM " . cfg('base', 'table_breeds') . "") / cfg('base', 'per_page_admin'));

//article_categories
$breeds = array();

foreach ($db->query($sql) as $row) {

    $breeds[] = array(
        'breed_id'               => $row['breed_id'],
        'breed_name'             => $row['breed_name'],
		'breed_image'            => $row['breed_image'],
        'breed_status'           => $row['breed_status']
    );

}

//Check if the form has been submitted
if (isset($_POST['cb_breed'])) {

    foreach ($_POST['cb_breed'] as $value) {

        $where = array(
            'breed_id' => $value
        );

        $db->where($where);
        $db->delete(cfg('base', 'table_breeds'));
    }

    header("Location: breeds.php");

}

//Template values
$tpl->set('rowCount', $rowCount);
$tpl->set('current_page', $current_page);
$tpl->set('pages', $pages);
$tpl->set('breeds', $breeds);

//Display the template
$tpl->display('admin/breeds');
