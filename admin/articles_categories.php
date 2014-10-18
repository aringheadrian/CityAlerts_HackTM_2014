<?php

//Include the common file
require '../common.php';

//Check if the user is logged in
if (!$authentication->loggedIn() || !$authentication->isAdmin()) header("Location: login.php");

//Returns the number of rows
$rowCount = $db->rowCount("SELECT category_id FROM " . cfg('base', 'table_articles_categories'));

//Pagination
if (isset($_GET['page']))
    $current_page = trim($_GET['page']);
else
    $current_page = 1;

$start = ($current_page -1 ) * cfg('base', 'per_page_admin');

$sql = "SELECT c.category_id, c.category_status, t.category_name FROM " . cfg('base', 'table_articles_categories') . " c, " . cfg('base', 'table_articles_category_translations') . " t WHERE t.language_code = '" . cfg('language', 'site_language') . "' AND c.category_id = t.category_id";

$implode = array();

if (isset($_POST['search']) && !empty($_POST['filter_category_name']))
    $implode[] = " LCASE(category_name) LIKE '%" . strtolower($_POST['filter_category_name']) . "%'";
if ($implode)
    $sql .= " AND " . implode(" AND ", $implode);

$sql .= " LIMIT " . $start . ", " . cfg('base', 'per_page_admin') . "";

$pages = ceil($db->rowCount("SELECT category_id FROM " . cfg('base', 'table_articles_categories') . "") / cfg('base', 'per_page_admin'));

//article_categories
$articles_categories = array();

foreach ($db->query($sql) as $row) {

    $articles_categories[] = array(
        'category_id'               => $row['category_id'],
        'category_name'             => $row['category_name'],
        'category_status'           => $row['category_status']
    );

}

//Check if the form has been submitted
if (isset($_POST['cb_category'])) {

    foreach ($_POST['cb_category'] as $value) {

        $where = array(
            'category_id' => $value
        );

        $db->where($where);
        $db->delete(cfg('base', 'table_articles_categories'));
    }

    header("Location: articles_categories.php");

}

//Template values
$tpl->set('rowCount', $rowCount);
$tpl->set('current_page', $current_page);
$tpl->set('pages', $pages);
$tpl->set('articles_categories', $articles_categories);

//Display the template
$tpl->display('admin/articles_categories');
