<?php

//Include the common file
require('../common.php');

//Check if the user is logged in
if (!$authentication->loggedIn() || !$authentication->isAdmin()) header("Location: login.php");


$album = $db->fetchRowAssoc("SELECT album_id,album_title FROM " . cfg('base', 'table_album_translations') . " WHERE album_id = '" . $_GET['album_id'] . "'");
$sql = "SELECT a.album_id, t.album_title FROM " . cfg('base', 'table_albums') . " a, " . cfg('base', 'table_album_translations') . " t WHERE a.album_id = t.album_id AND a.album_type = 1 AND t.language_code = '" . cfg('language', 'site_language') . "'";

//albums
$albums = array();

foreach ($db->query($sql) as $row) {
	
	$albums[] = array(
		'album_id'               => $row['album_id'],
	    'album_title'             => $row['album_title']
	);

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

function img($language, $string, $id)
{

 global $db;
 $img = $db->fetchRowAssoc("SELECT * FROM " . cfg('base', 'table_album_images') . " i, " . cfg('base', 'table_album_image_translations') . " t WHERE i.image_id = t.image_id AND t.language_code = '" . $language . "' AND i.image_id = '" . $id . "'");

 return $img[$string];
}


function album($language, $string, $id)
{

 global $db;
 $album = $db->fetchRowAssoc("SELECT * FROM " . cfg('base', 'table_album_translations') . " WHERE language_code = '" . $language . "' AND album_id = '" . $id . "'");

 return $album[$string];
}


$sql = "SELECT * FROM " . cfg('base', 'table_album_images') . " WHERE album_id = '" . $_GET['album_id'] . "'";
//album_img
$album_img = array();

foreach ($db->query($sql) as $row) {
	
	$album_img[] = array(
		'image_id'              => $row['image_id'],
		'album_id'               => $row['album_id'],
	    'image'			        => $row['image']
	);

}


if (isset($_POST['upload'])) {

  $validate->required($_POST['album'], 'Selectati albumul.');
  $validate->required($_POST['index'], 'Introduceti un index.');
  $validate->numeric($_POST['index'], 'Va rugem introduceti un numar valid pentru index.');

  if (!$error->hasErrors()) {
    $index=$_POST['index'];
    if (isset($_FILES['files'])) {
				
			$files = array();
			
			foreach ($_FILES['files'] as $key => $values) {
				
				foreach ($values as $i => $value)
					$files[$i][$key] = $value;

			}

			foreach ($files as $file) {
				
				if (!empty($file['name'])) {
					
			        $img = url(album(cfg('languages', 'site_language'),'album_title',$album['album_id']))."-".str_pad($index, 3, "0", STR_PAD_LEFT);
					//1234x487
					$image = $upload->uploadImage($file, $img, 728, 438, true, true);

					$values = array(
						'album_id' 	    => $album['album_id'], 
						'image'			=> $image
					); 	
							
					$db->insert(cfg('base', 'table_album_images'), $values);
					
					$image_id = $db->lastInsertId();

					foreach ($languages as $row) {
					  
					  $values = array(
						'image_id'    => $image_id,
						'language_code' => $row['language_code']
					  );
					  
					  if($_POST['image_title'.'_'.$row['language_code']]){
					        $values['image_title'] = $_POST['image_title'.'_'.$row['language_code']]." - ".str_pad($index, 3, "0", STR_PAD_LEFT);
					  } else{ 
						    $values['image_title'] = album($row['language_code'],'album_title',$album['album_id'])." - ".str_pad($index, 3, "0", STR_PAD_LEFT);
					  }
					 $db->insert(cfg('base', 'table_album_image_translations'), $values);
					 
					}
					
					$index++;
				}
			
			}
			
        }
        $tpl->set('success', true);
        header("Location: album_images.php?album_id=".$_GET['album_id']);
	  }
	}
 
 if(isset($_POST['delete'])){
  foreach ($_POST['image'] as $value) {
		
		if ($db->fetchRowAssoc("SELECT image_id FROM " . cfg('base', 'table_album_images') . " WHERE image_id = '" . $value . "'") > 0) {
			
			foreach ($db->query("SELECT image FROM " . cfg('base', 'table_album_images') . " WHERE image_id = '" . $value . "'") as $row) {
				
				@unlink(cfg('upload', 'upload_path') . 'images/' . $row['image']);
			
			}
		
		}
		
		$where = array(
			'image_id' => $value
		);
		
		$db->where($where);
		$db->delete(cfg('base', 'table_album_images'));
		
	}
    header("Location: album_images.php?album_id=".$_GET['album_id']."");
}
 
//Template values
$tpl->set('albums', $albums);
$tpl->set('album_img', $album_img);


//Display the template
$tpl->display('admin/album_images');

?>
