<?php

//Include the common file
require('../common.php');

//Check if the user is logged in
if (!$authentication->loggedIn() || !$authentication->isAdmin()) header("Location: login.php");


$dog = $db->fetchRowAssoc("SELECT dog_id,dog_name FROM " . cfg('base', 'table_dog_translations') . " WHERE dog_id = '" . $_GET['dog_id'] . "'");
$sql = "SELECT dog_id, dog_name  FROM " . cfg('base', 'table_dog_translations') . " WHERE language_code = '" . cfg('language', 'site_language') . "'";

//dogs
$dogs = array();

foreach ($db->query($sql) as $row) {
	
	$dogs[] = array(
		'dog_id'               => $row['dog_id'],
	    'dog_name'             => $row['dog_name']
	);

}


$sql = "SELECT * FROM " . cfg('base', 'table_dog_images') . " WHERE dog_id = '" . $_GET['dog_id'] . "'";
//dog_img
$dog_img = array();

foreach ($db->query($sql) as $row) {
	
	$dog_img[] = array(
		'image_id'              => $row['image_id'],
		'dog_id'               => $row['dog_id'],
	    'image'			        => $row['image']
	);

}


if (isset($_POST['upload'])) {

  $validate->required($_POST['dog'], 'Select dog.');
  $validate->required($_POST['index'], 'Please add an index.');
  $validate->numeric($_POST['index'], 'Please enter a valid number for index.');

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
					
			        $img = url($dog['dog_name'])."-".str_pad($index, 3, "0", STR_PAD_LEFT);
					//1234x487
					$image = $upload->uploadImage($file, $img, 728, 438, true, true);

					$values = array(
						'dog_id' 	    => $dog['dog_id'], 
						'image'			=> $image
					); 	
							
					$db->insert(cfg('base', 'table_dog_images'), $values);
				    $index++;
				}
			
			}
			
        }
        $tpl->set('success', true);
        header("Location: dog_images.php?dog_id=".$_GET['dog_id']);
	  }
	}
 
 if(isset($_POST['delete'])){
  foreach ($_POST['image'] as $value) {
		
		if ($db->fetchRowAssoc("SELECT image_id FROM " . cfg('base', 'table_dog_images') . " WHERE image_id = '" . $value . "'") > 0) {
			
			foreach ($db->query("SELECT image FROM " . cfg('base', 'table_dog_images') . " WHERE image_id = '" . $value . "'") as $row) {
				
				@unlink(cfg('upload', 'upload_path') . 'images/' . $row['image']);
			
			}
		
		}
		
		$where = array(
			'image_id' => $value
		);
		
		$db->where($where);
		$db->delete(cfg('base', 'table_dog_images'));
		
	}
    header("Location: dog_images.php?dog_id=".$_GET['dog_id']."");
}
 
//Template values
$tpl->set('dogs', $dogs);
$tpl->set('dog_img', $dog_img);


//Display the template
$tpl->display('admin/dog_images');

?>
