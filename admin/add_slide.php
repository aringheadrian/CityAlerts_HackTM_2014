<?php

//Include the common file
require '../common.php';

//Check if the user is logged in
if (!$authentication->loggedIn() || !$authentication->isAdmin()) header("Location: login.php");

//Check if the form has been submitted
if (isset($_POST['submit'])) {

    $validate->numeric($_POST['slide_order'], 'Introduceti un numar de ordine.');
    foreach ($languages as $row) {
     $validate->required($_POST['slide_title'.'_'.$row['language_code']], 'Introduceti titlul diapozitivului ('.$row['language_code'].').');
    }

    if (!empty($_FILES['image']['name'])) {

        $image = $upload->uploadImage('image',url($_POST['slide_title'.'_'.cfg('language','site_language')]), 1349, 468, true, true);
    }

    if (!$error->hasErrors()) {

        $values = array(
        'slide_url'               => $_POST['slide_url'],
        'slide_order'           => $_POST['slide_order'],
        'slide_status'           => $_POST['slide_status'],
        'target_blank'         => $_POST['target_blank']
        );

        if (isset($image)) {

            $values['slide_image'] = $image;

        }

        $db->insert(cfg('base', 'table_slides'), $values);

        $slide_id = $db->lastInsertId();

        foreach ($languages as $row) {
            $values = array(
                'slide_id'               => $slide_id,
                'language_code'        => $row['language_code'],
                'slide_title'           => $_POST['slide_title'.'_'.$row['language_code']],
                'slide_info'           => $_POST['slide_info'.'_'.$row['language_code']]
            );
         $db->insert(cfg('base', 'table_slide_translations'), $values);
        }

        $tpl->set('success', true);
        header('Location: slides.php');

    }

}

//Display the template
$tpl->display('admin/add_slide');
