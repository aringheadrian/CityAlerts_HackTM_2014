<?php

//Include the common file
require '../common.php';

//Check if the user is logged in
if (!$authentication->loggedIn() || !$authentication->isAdmin()) header("Location: login.php");

//Check if the form has been submitted
if (isset($_POST['submit'])) {

    foreach ($languages as $row) {
      $validate->required($_POST['breed_name'.'_'.$row['language_code']], 'Introduceti numele rasei ('.$row['language_code'].').');
    }
	
	
    if (!empty($_FILES['image']['name'])) {

        $image = $upload->uploadImage('image',url($_POST['breed_name'.'_'.cfg('language','site_language')]), 728, 438);
    }

    if (!$error->hasErrors()) {

        $values = array(
            'breed_status'            => $_POST['breed_status']
        );
		
		 if (isset($image)) {

            $values['breed_image'] = $image;

        }

        $db->insert(cfg('base', 'table_breeds'), $values);

        $breed_id = $db->lastInsertId();

        foreach ($languages as $row) {
          $values = array(
            'breed_id'    => $breed_id,
            'language_code' => $row['language_code'],
            'breed_name' => $_POST['breed_name'.'_'.$row['language_code']],
            'breed_meta_keywords'    => $_POST['breed_meta_keywords'.'_'.$row['language_code']],
            'breed_meta_description' => $_POST['breed_meta_description'.'_'.$row['language_code']],
			'breed_description' => $_POST['breed_description'.'_'.$row['language_code']]
         );

         $db->insert(cfg('base', 'table_breed_translations'), $values);
        }

        $tpl->set('success', true);
        header('Location: breeds.php');
    }

}


//Display the template
$tpl->display('admin/add_breed');
