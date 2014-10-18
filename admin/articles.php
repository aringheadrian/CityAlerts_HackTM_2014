<?php

//Include the common file
require '../common.php';

//Check if the user is logged in
if (!$authentication->loggedIn() || !$authentication->isAdmin()) header("Location: login.php");

//Returns the number of rows
$rowCount = $db->rowCount("SELECT article_id FROM " . cfg('base', 'table_articles'));

//Pagination
if (isset($_GET['page']))
    $current_page = trim($_GET['page']);
else
    $current_page = 1;

$start = ($current_page -1 ) * cfg('base', 'per_page_admin');

$sql = "SELECT * FROM " . cfg('base', 'table_articles') . " a, " . cfg('base', 'table_article_translations') . " t WHERE a.article_id = t.article_id AND t.language_code = '" . cfg('language', 'site_language') . "'";

$implode = array();

if (isset($_POST['search']) && !empty($_POST['filter_article_title']))
    $implode[] = " LCASE(article_title) LIKE '%" . strtolower($_POST['filter_article_title']) . "%'";

if ($implode)
    $sql .= " AND " . implode(" AND ", $implode);

$sql .= " ORDER BY a.article_id DESC LIMIT " . $start . ", " . cfg('base', 'per_page_admin') . "";

$pages = ceil($db->rowCount("SELECT article_id FROM " . cfg('base', 'table_articles') . "") / cfg('base', 'per_page_admin'));

//article
$articles = array();

foreach ($db->query($sql) as $row) {

    $articles[] = array(
        'article_id'               => $row['article_id'],
        'article_title'               => $row['article_title'],
        'article_meta_keywords'       => $row['article_meta_keywords'],
        'article_meta_description' => $row['article_meta_description'],
        'article_content'             => $row['article_content'],
        'article_image'               => $row['article_image'],
        'article_video'               => $row['article_video'],
        'article_source'           => $row['article_source'],
        'article_status'           => $row['article_status'],
        'date_added'               => $row['date_added']
    );

}

//Check if the form has been submitted
if (isset($_POST['cb_article'])) {

    foreach ($_POST['cb_article'] as $value) {

        $result = $db->fetchRowAssoc("SELECT article_image FROM " . cfg('base', 'table_articles') . " WHERE article_id = '" . $value . "'");

        if ($result['article_image']) {

            @unlink(cfg('upload', 'upload_path') . 'images/' . $result['article_image']);

        }

        $where = array(
            'article_id' => $value
        );

        $db->where($where);
        $db->delete(cfg('base', 'table_articles'));
    }

    header("Location: articles.php");

}

//Template values
$tpl->set('rowCount', $rowCount);
$tpl->set('current_page', $current_page);
$tpl->set('pages', $pages);
$tpl->set('articles', $articles);

//Display the template
$tpl->display('admin/articles');
