<?php

//Include the common file
require '../common.php';

//Check if the user is logged in
if (!$authentication->loggedIn() || !$authentication->isAdmin()) header("Location: login.php");

//Returns the number of rows
$rowCount = $db->rowCount("SELECT slide_id FROM " . cfg('base', 'table_slides') . " WHERE slide_id = '" . $_GET['slide_id'] . "'");

$slide = $db->fetchRowAssoc("SELECT * FROM " . cfg('base', 'table_slides') . " WHERE slide_id = '" . $_GET['slide_id'] . "'");

function slide($language, $string)
{

 global $db;
 $slide = $db->fetchRowAssoc("SELECT * FROM " . cfg('base', 'table_slides') . " s, " . cfg('base', 'table_slide_translations') . " t WHERE s.slide_id = t.slide_id AND t.language_code = '" . $language . "' AND s.slide_id = '" . $_GET['slide_id'] . "'");

 return $slide[$string];
}

//Check if the form has been submitted
if (isset($_POST['submit'])) {

    $validate->numeric($_POST['slide_order'], 'Introduceti un numar de ordine.');
    foreach ($languages as $row) {
     $validate->required($_POST['slide_title'.'_'.$row['language_code']], 'Introduceti titlul diapozitivului ('.$row['language_code'].').');
    }

    if ($_FILES['image']['name']) {

        $result = $db->fetchRowAssoc("SELECT slide_image FROM " . cfg('base', 'table_slides') . " WHERE slide_id = '" . $_GET['slide_id'] . "'");

        if ($result['slide_image']) {

            @unlink(cfg('upload', 'upload_path') . 'images/' . $result['slide_image']);

        }

        $image = $upload->uploadImage('image',url($_POST['slide_title'.'_'.cfg('language','site_language')]), 1349, 468, true, true);

    }

    if (!$error->hasErrors()) {

        $values = array(
        'slide_url'               => $_POST['slide_url'],
        'slide_order'           => $_POST['slide_order'],
        'slide_status'           => $_POST['slide_status'],
        'target_blank'           => $_POST['target_blank']
        );

        if (isset($image)) {

            $values['slide_image'] = $image;

        }

        $where = array(
            'slide_id' => $_GET['slide_id']
        );

        $db->where($where);
        $db->update(cfg('base', 'table_slides'), $values);

        foreach ($languages as $row) {
            $count = $db->rowCount("SELECT slide_id FROM " . cfg('base', 'table_slide_translations') . " WHERE language_code = '" . $row['language_code'] . "'");

            if ($count > 0) {
                $values = array(
                    'slide_title'               => $_POST['slide_title'.'_'.$row['language_code']],
                    'slide_info'               => $_POST['slide_info'.'_'.$row['language_code']]
                );

                $where = array(
                    'slide_id'       => $_GET['slide_id'],
                    'language_code'    => $row['language_code']
                );

                $db->where($where);
                $db->update(cfg('base', 'table_slide_translations'), $values);
            } else {
                $values = array(
                'slide_id'                   => $_GET['slide_id'],
                'language_code'            => $row['language_code'],
                'slide_title'               => $_POST['slide_title'.'_'.$row['language_code']],
                'slide_info'               => $_POST['slide_info'.'_'.$row['language_code']]
                );
                $db->insert(cfg('base', 'table_slide_translations'), $values);
            }
        }

        $session->set('success', true);
        header("Location: edit_slide.php?slide_id=".$_GET['slide_id']."");

    }

}

//Template values
$tpl->set('rowCount', $rowCount);
$tpl->set('slide', $slide);

//Display the template
$tpl->display('admin/edit_slide');
