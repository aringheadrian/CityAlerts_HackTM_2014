<?php

//Include the common file
require '../common.php';

//Check if the user is logged in
if (!$authentication->loggedIn() || !$authentication->isAdmin()) header("Location: login.php");


//albums
function albums($parent_id,$language,$type) {
	
	global $db;
	
	$albums = array();
	foreach ($db->query("SELECT a.album_id, a.album_status, t.album_title FROM " . cfg('base', 'table_albums') . " a, " . cfg('base', 'table_album_translations') . " t WHERE a.album_id = t.album_id AND a.album_type = '". $type . "' AND t.language_code = '" . $language ."' AND a.parent_id = '" . $parent_id . "' ORDER BY a.album_id ASC") as $value) {
							
		$albums[] = array(
			'album_id'	    => $value['album_id'],
			'album_status'	=> $value['album_status'],
			'album_title'	    => get_path($value['album_id'],$language,$type)
		);
		
		$albums = array_merge($albums, albums($value['album_id'],$language,$type));
		
	}	
	
	return $albums;
}

function get_path($album_id,$language,$type) {

	global $db;
	
	$result = $db->fetchRowAssoc("SELECT a.album_id, a.parent_id, t.album_title FROM " . cfg('base', 'table_albums') . " a, " . cfg('base', 'table_album_translations') . " t WHERE a.album_id = t.album_id AND a.album_type = '". $type . "' AND t.language_code = '" . $language ."' AND a.album_id = '" . $album_id . "' ORDER BY a.album_id ASC");
	
	if ($result['parent_id'])
		return get_path($result['parent_id'],$language,$type) .' > '. $result['album_title'];
	else
		return $result['album_title'];	

}

//Check if the form has been submitted
if (isset($_POST['submit'])) {

    $validate->required($_POST['album_type'], 'Selectati tipul albumului.');
	foreach ($languages as $row) {
      $validate->required($_POST['album_title'.'_'.$row['language_code']], 'Introduceti titlul albumului ('.$row['language_code'].').');
    }

    if (!$error->hasErrors()) {

        $values = array(
            'parent_id' 		      => $_POST['parent_id'],
			'album_type'              => $_POST['album_type'],
			'album_status'            => $_POST['album_status'],
			'date_added'              => date('Y-m-d H:i:s')
        );
		


        $db->insert(cfg('base', 'table_albums'), $values);

        $album_id = $db->lastInsertId();

        foreach ($languages as $row) {
          $values = array(
            'album_id'    => $album_id,
            'language_code' => $row['language_code'],
            'album_title' => $_POST['album_title'.'_'.$row['language_code']],
            'album_meta_keywords'    => $_POST['album_meta_keywords'.'_'.$row['language_code']],
            'album_meta_description' => $_POST['album_meta_description'.'_'.$row['language_code']],
			'album_description' => $_POST['album_description'.'_'.$row['language_code']]
         );

         $db->insert(cfg('base', 'table_album_translations'), $values);
        }

        $tpl->set('success', true);
        header('Location: albums.php');
    }

}


//Display the template
$tpl->display('admin/add_album');
