<?php

//Include the common file
require '../common.php';

//Check if the user is logged in
if (!$authentication->loggedIn() || !$authentication->isAdmin()) header("Location: login.php");

//Returns the number of rows
$rowCount = $db->rowCount("SELECT slide_id FROM " . cfg('base', 'table_slides'). "");

//Pagination
if (isset($_GET['page']))
    $current_page = trim($_GET['page']);
else
    $current_page = 1;

$start = ($current_page -1 ) * cfg('base', 'per_page_admin');

$sql = "SELECT * FROM " . cfg('base', 'table_slides') . " s, " . cfg('base', 'table_slide_translations') . " t WHERE s.slide_id = t.slide_id AND t.language_code = '" . cfg('language', 'site_language') . "'";

$implode = array();

if (isset($_POST['search']) && !empty($_POST['filter_slide_title']))
    $implode[] = " LCASE(t.slide_title) LIKE '%" . strtolower($_POST['filter_slide_title']) . "%'";

if ($implode)
    $sql .= " AND " . implode(" AND ", $implode);

$sql .= " ORDER BY s.slide_id DESC LIMIT " . $start . ", " . cfg('base', 'per_page_admin') . "";

$pages = ceil($db->rowCount("SELECT slide_id FROM " . cfg('base', 'table_slides') . "") / cfg('base', 'per_page_admin'));

//slide
$slides = array();

foreach ($db->query($sql) as $row) {

    $slides[] = array(
        'slide_id'               => $row['slide_id'],
        'slide_title'           => $row['slide_title'],
        'slide_info'             => $row['slide_info'],
        'slide_image'           => $row['slide_image'],
        'slide_url'               => $row['slide_url'],
        'target_blank'           => $row['target_blank'],
        'slide_status'           => $row['slide_status'],
        'slide_order'          => $row['slide_order']
    );

}

//Check if the form has been submitted
if (isset($_POST['cb_slide'])) {

    foreach ($_POST['cb_slide'] as $value) {

        $result = $db->fetchRowAssoc("SELECT slide_image FROM " . cfg('base', 'table_slides') . " WHERE slide_id = '" . $value . "'");

        if ($result['slide_image']) {

            @unlink(cfg('upload', 'upload_path') . 'images/' . $result['slide_image']);

        }

        $where = array(
            'slide_id' => $value
        );

        $db->where($where);
        $db->delete(cfg('base', 'table_slides'));

    }

    header("Location: slides.php");

}

//Template values
$tpl->set('rowCount', $rowCount);
$tpl->set('current_page', $current_page);
$tpl->set('pages', $pages);
$tpl->set('slides', $slides);

//Display the template
$tpl->display('admin/slides');
