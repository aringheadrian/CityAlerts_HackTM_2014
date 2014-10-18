<?php

//Include the common file
require '../common.php';

//Check if the user is logged in
if (!$authentication->loggedIn() || !$authentication->isAdmin()) header("Location: login.php");

//Returns the number of rows
$rowCount = $db->rowCount("SELECT album_id FROM " . cfg('base', 'table_albums'));

//Pagination
if (isset($_GET['page']))
    $current_page = trim($_GET['page']);
else
    $current_page = 1;

$start = ($current_page -1 ) * cfg('base', 'per_page_admin');

$sql = "SELECT a.album_id, a.album_type, a.album_status, t.album_title FROM " . cfg('base', 'table_albums') . " a, " . cfg('base', 'table_album_translations') . " t WHERE t.language_code = '" . cfg('language', 'site_language') . "' AND a.album_id = t.album_id";

$implode = array();

if (isset($_POST['search']) && !empty($_POST['filter_album_name']))
    $implode[] = " LCASE(album_name) LIKE '%" . strtolower($_POST['filter_album_name']) . "%'";
if ($implode)
    $sql .= " AND " . implode(" AND ", $implode);

$sql .= " LIMIT " . $start . ", " . cfg('base', 'per_page_admin') . "";

$pages = ceil($db->rowCount("SELECT album_id FROM " . cfg('base', 'table_albums') . "") / cfg('base', 'per_page_admin'));

//article_categories
$albums = array();

foreach ($db->query($sql) as $row) {

    $albums[] = array(
        'album_id'               => $row['album_id'],
        'album_title'             => $row['album_title'],
		'album_type'            => $row['album_type'],
        'album_status'           => $row['album_status']
    );

}

//Check if the form has been submitted
if (isset($_POST['cb_album'])) {

    foreach ($_POST['cb_album'] as $value) {

        $where = array(
            'album_id' => $value
        );

        $db->where($where);
        $db->delete(cfg('base', 'table_albums'));
		
		foreach ($db->query("SELECT album_id FROM " . cfg('cart', 'table_albums') . " WHERE parent_id = '" . $value . "'") as $row) {

			$where = array(
				'album_id' => $row['album_id']
			);
			
			$db->where($where);
			$db->delete(cfg('base', 'table_albums'));
		}
    }

    header("Location: albums.php");

}

//Template values
$tpl->set('rowCount', $rowCount);
$tpl->set('current_page', $current_page);
$tpl->set('pages', $pages);
$tpl->set('albums', $albums);

//Display the template
$tpl->display('admin/albums');
