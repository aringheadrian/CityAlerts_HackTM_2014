<?php

//Include the common file
require '../common.php';

//Check if the user is logged in
if (!$authentication->loggedIn() || !$authentication->isAdmin()) header("Location: login.php");

//Returns the number of rows
$rowCount = $db->rowCount("SELECT dog_id FROM " . cfg('base', 'table_dogs') . " WHERE dog_id = '" . $_GET['dog_id'] . "'");

$dog = $db->fetchRowAssoc("SELECT * FROM " . cfg('base', 'table_dogs') . " WHERE dog_id = '" . $_GET['dog_id'] . "'");

function dog($language, $string)
{

 global $db;
 $dog = $db->fetchRowAssoc("SELECT * FROM " . cfg('base', 'table_dogs') . " d, " . cfg('base', 'table_dog_translations') . " t WHERE d.dog_id = t.dog_id AND t.language_code = '" . $language . "' AND d.dog_id = '" . $_GET['dog_id'] . "'");

 return $dog[$string];
}


//Check if the form has been submitted
if (isset($_POST['submit'])) {

    $validate->required($_POST['breed_id'], 'Selectati rasa.');
    foreach ($languages as $row) {
     $validate->required($_POST['dog_name'.'_'.$row['language_code']], 'Introduceti numele catelului ('.$row['language_code'].').');
    }

    if ($_FILES['image']['name']) {

        $result = $db->fetchRowAssoc("SELECT dog_image FROM " . cfg('base', 'table_dogs') . " WHERE dog_id = '" . $_GET['dog_id'] . "'");

        if ($result['dog_image']) {

            @unlink(cfg('upload', 'upload_path') . 'images/' . $result['dog_image']);

        }

        $image = $upload->uploadImage('image',url($_POST['dog_title'.'_'.cfg('language','site_language')]), 728, 438, true, true);

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
			'views'           => $_POST['views']
        );

        if (isset($image)) {

            $values['dog_image'] = $image;

        }

        $where = array(
            'dog_id' => $_GET['dog_id']
        );

        $db->where($where);
        $db->update(cfg('base', 'table_dogs'), $values);

        foreach ($languages as $row) {
            $count = $db->rowCount("SELECT dog_id FROM " . cfg('base', 'table_dog_translations') . " WHERE language_code = '" . $row['language_code'] . "'");

            if ($count > 0) {
                $values = array(
                    'dog_name'           => $_POST['dog_name'.'_'.$row['language_code']],
                    'dog_meta_keywords'    => $_POST['dog_meta_keywords'.'_'.$row['language_code']],
                    'dog_meta_description' => $_POST['dog_meta_description'.'_'.$row['language_code']],
                    'dog_description'           => $_POST['dog_description'.'_'.$row['language_code']]
                );

                $where = array(
                    'dog_id'       => $_GET['dog_id'],
                    'language_code'    => $row['language_code']
                );

                $db->where($where);
                $db->update(cfg('base', 'table_dog_translations'), $values);
            } else {
                $values = array(
                'dog_id'                   => $_GET['dog_id'],
                'language_code'                => $row['language_code'],
                'dog_name'           => $_POST['dog_name'.'_'.$row['language_code']],
                'dog_meta_keywords'    => $_POST['dog_meta_keywords'.'_'.$row['language_code']],
                'dog_meta_description' => $_POST['dog_meta_description'.'_'.$row['language_code']],
                'dog_description'           => $_POST['dog_description'.'_'.$row['language_code']]
                );
                $db->insert(cfg('base', 'table_dog_translations'), $values);
            }
        }

        $session->set('success', true);
        header("Location: edit_dog.php?dog_id=".$_GET['dog_id']."");

    }
}

//Template values
$tpl->set('rowCount', $rowCount);
$tpl->set('dog', $dog);

//Display the template
$tpl->display('admin/edit_dog');
