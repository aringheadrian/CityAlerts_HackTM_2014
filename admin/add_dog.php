<?php

//Include the common file
require '../common.php';

//Check if the user is logged in
if (!$authentication->loggedIn() || !$authentication->isAdmin()) header("Location: login.php");

//Check if the form has been submitted
if (isset($_POST['submit'])) {

    $validate->required($_POST['breed_id'], 'Selectati rasa.');
    foreach ($languages as $row) {
     $validate->required($_POST['dog_name'.'_'.$row['language_code']], 'Introduceti numele catelului ('.$row['language_code'].').');
    }

    if (!empty($_FILES['image']['name'])) {

        $image = $upload->uploadImage('image',url($_POST['dog_name'.'_'.cfg('language','site_language')]), 728, 438, true, true);
    }

    if (!$error->hasErrors()) {

        $values = array(
        'breed_id'        => $_POST['breed_id'],
		'dog_sex'         => $_POST['dog_sex'],
        'dog_size'        => $_POST['dog_size'],
		'dog_age'         => $_POST['dog_age'],
		'dog_weight'      => $_POST['dog_weight'],
		'dog_pedigree'    => $_POST['dog_pedigree'],
		'dog_price'       => $_POST['dog_price'],
        'dog_status'      => $_POST['dog_status'],
        'date_added'      => date('Y-m-d H:i:s')
        );

        if (isset($image)) {

            $values['dog_image'] = $image;

        }

        $db->insert(cfg('base', 'table_dogs'), $values);
		
		$dog_id = $db->lastInsertId();

        foreach ($languages as $row) {
            $values = array(
                'dog_id'               => $dog_id,
                'language_code'            => $row['language_code'],
                'dog_name'           => $_POST['dog_name'.'_'.$row['language_code']],
                'dog_meta_keywords'    => $_POST['dog_meta_keywords'.'_'.$row['language_code']],
                'dog_meta_description' => $_POST['dog_meta_description'.'_'.$row['language_code']],
                'dog_description'           => $_POST['dog_description'.'_'.$row['language_code']]
            );
         $db->insert(cfg('base', 'table_dog_translations'), $values);
        }

        $tpl->set('success', true);
        header('Location: dogs.php');

    }

}

//Display the template
$tpl->display('admin/add_dog');
