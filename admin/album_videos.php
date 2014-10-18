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

function vid($language, $string, $id)
{

 global $db;
 $vid = $db->fetchRowAssoc("SELECT * FROM " . cfg('base', 'table_album_videos') . " v, " . cfg('base', 'table_album_video_translations') . " t WHERE v.video_id = t.video_id AND t.language_code = '" . $language . "' AND v.video_id = '" . $id . "'");

 return $vid[$string];
}


function album($language, $string, $id)
{

 global $db;
 $album = $db->fetchRowAssoc("SELECT * FROM " . cfg('base', 'table_album_translations') . " WHERE language_code = '" . $language . "' AND album_id = '" . $id . "'");

 return $album[$string];
}


$sql = "SELECT * FROM " . cfg('base', 'table_album_videos') . " v, " . cfg('base', 'table_album_video_translations') . " t WHERE v.video_id = t.video_id AND t.language_code = '" . cfg('language', 'site_language') . "' AND v.album_id = '" . $_GET['album_id'] . "'";
//album_vid
$album_vid = array();

foreach ($db->query($sql) as $row) {
	
	$album_vid[] = array(
		'video_id'              => $row['video_id'],
		'album_id'               => $row['album_id'],
	    'embed_code'			        => $row['embed_code'],
		'video_title'            => $row['video_title']
	);

}


if (isset($_POST['upload'])) {

  $validate->required($_POST['album'], 'Selectati albumul.');
  $validate->required($_POST['index'], 'Introduceti un index.');
  $validate->numeric($_POST['index'], 'Va rugem introduceti un numar valid pentru index.');
  $validate->required($_POST['embed_code'], 'Introduceti codul pentru video.');

  if (!$error->hasErrors()) {
    $index=$_POST['index'];
   
	$values = array(
		'album_id' 	    => $album['album_id'], 
		'embed_code'	=> $_POST['embed_code']
	); 	
			
	$db->insert(cfg('base', 'table_album_videos'), $values);
	
	$video_id = $db->lastInsertId();

	foreach ($languages as $row) {
	  
	  $values = array(
		'video_id'    => $video_id,
		'language_code' => $row['language_code']
	  );
	  
	  if($_POST['video_title'.'_'.$row['language_code']]){
			$values['video_title'] = $_POST['video_title'.'_'.$row['language_code']]." - ".str_pad($index, 3, "0", STR_PAD_LEFT);
	  } else{ 
			$values['video_title'] = album($row['language_code'],'album_title',$album['album_id'])." - ".str_pad($index, 3, "0", STR_PAD_LEFT);
	  }
	 $db->insert(cfg('base', 'table_album_video_translations'), $values);
	 
	}
	
	$index++;
	
	$tpl->set('success', true);
	header("Location: album_videos.php?album_id=".$_GET['album_id']);
	
   }
}
 
 if(isset($_POST['delete'])){
  foreach ($_POST['video'] as $value) {
		
		$where = array(
			'video_id' => $value
		);
		
		$db->where($where);
		$db->delete(cfg('base', 'table_album_videos'));
		
	}
    header("Location: album_videos.php?album_id=".$_GET['album_id']."");
}
 
//Template values
$tpl->set('albums', $albums);
$tpl->set('album_vid', $album_vid);


//Display the template
$tpl->display('admin/album_videos');

?>
