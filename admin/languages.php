<?php

//Include the common file
require '../common.php';

//Check if the user is logged in
if (!$authentication->loggedIn() || !$authentication->isAdmin()) header("Location: login.php");

//Returns the number of rows
$rowCount = $db->rowCount("SELECT language_code FROM " . cfg('base', 'table_languages'));

//Pagination
if (isset($_GET['page']))
    $current_page = trim($_GET['page']);
else
    $current_page = 1;

$start = ($current_page -1 ) * cfg('base', 'per_page_admin');

$sql = "SELECT * FROM " . cfg('base', 'table_languages') . "";

$implode = array();

if (isset($_POST['search']) && !empty($_POST['filter_language_name']))
    $implode[] = " LCASE(language_name) LIKE '%" . strtolower($_POST['filter_language_name']) . "%'";
if ($implode)
    $sql .= " WHERE " . implode(" AND ", $implode);

$sql .= " LIMIT " . $start . ", " . cfg('base', 'per_page_admin') . "";

$pages = ceil($db->rowCount("SELECT language_code FROM " . cfg('base', 'table_languages') . "") / cfg('base', 'per_page_admin'));

//languages
$languages = array();

foreach ($db->query($sql) as $row) {

    $languages[] = array(
        'language_code'            => $row['language_code'],
        'language_name'            => $row['language_name'],
        'language_status'          => $row['language_status']
    );

}

//Check if the form has been submitted
if (isset($_POST['cb_language'])) {

    foreach ($_POST['cb_language'] as $value) {

        $where = array(
            'language_code' => $value
        );

        $db->where($where);
        $db->delete(cfg('base', 'table_languages'));
    }

    header("Location: languages.php");

}

//Template values
$tpl->set('rowCount', $rowCount);
$tpl->set('current_page', $current_page);
$tpl->set('pages', $pages);
$tpl->set('languages', $languages);

//Display the template
$tpl->display('admin/languages');
