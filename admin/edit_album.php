<?php

//Include the common file
require '../common.php';

//Check if the user is logged in
if (!$authentication->loggedIn() || !$authentication->isAdmin()) header("Location: login.php");

//Returns the number of rows
$rowCount = $db->rowCount("SELECT album_id FROM " . cfg('base', 'table_albums') . " WHERE album_id = '" . $_GET['album_id'] . "'");

$album = $db->fetchRowAssoc("SELECT * FROM " . cfg('base', 'table_albums') . " WHERE album_id = '" . $_GET['album_id'] . "'");

//album details
function album($language, $string)
{

 global $db;
 $album = $db->fetchRowAssoc("SELECT * FROM " . cfg('base', 'table_albums') . " a, " . cfg('base', 'table_album_translations') . " t WHERE a.album_id = t.album_id AND t.language_code = '" . $language . "' AND a.album_id = '" . $_GET['album_id'] . "'");

 return $album[$string];
}

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

    foreach ($languages as $row) {
      $validate->required($_POST['album_title'.'_'.$row['language_code']], 'Introduceti titlul albumului ('.$row['language_code'].').');
    }
	
    if (!$error->hasErrors()) {

        $values = array(
            'parent_id' 		        => $_POST['parent_id'],
			'album_status'            => $_POST['album_status']
        );

        $where = array(
            'album_id' => $_GET['album_id']
        );

        $db->where($where);
        $db->update(cfg('base', 'table_albums'), $values);

        foreach ($languages as $row) {

          $count = $db->rowCount("SELECT album_id FROM " . cfg('base', 'table_album_translations') . " WHERE language_code = '" . $row['language_code'] . "'");
          if ($count > 0) {
                  $values = array(
                    'album_title' => $_POST['album_title'.'_'.$row['language_code']],
                    'album_meta_keywords'    => $_POST['album_meta_keywords'.'_'.$row['language_code']],
                    'album_meta_description' => $_POST['album_meta_description'.'_'.$row['language_code']],
					'album_description' => $_POST['album_description'.'_'.$row['language_code']]
                  );

                 $where = array(
                    'album_id'   => $_GET['album_id'],
                    'language_code' => $row['language_code'],
                 );

                $db->where($where);
                $db->update(cfg('base', 'table_album_translations'), $values);

                $session->set('success', true);
           } else {
                $values = array(
                'album_id'    => $_GET['album_id'],
                'language_code' => $row['language_code'],
                'album_title' => $_POST['album_title'.'_'.$row['language_code']],
                'album_meta_keywords'    => $_POST['album_meta_keywords'.'_'.$row['language_code']],
                'album_meta_description' => $_POST['album_meta_description'.'_'.$row['language_code']],
				'album_description' => $_POST['album_description'.'_'.$row['language_code']]
                );

                $db->insert(cfg('base', 'table_album_translations'), $values);

               $session->set('success', true);
           }
        }

     header("Location: edit_album.php?album_id=".$_GET['album_id']."");

    }
}

//Template values
$tpl->set('rowCount', $rowCount);
$tpl->set('album', $album);

//Display the template
$tpl->display('admin/edit_album');
