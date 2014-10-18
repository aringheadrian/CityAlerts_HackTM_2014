<?php

//Include the common file
require '../common.php';

//Check if the user is logged in
if (!$authentication->loggedIn() || !$authentication->isAdmin()) header("Location: login.php");

//Returns the number of rows
$rowCount = $db->rowCount("SELECT breed_id FROM " . cfg('base', 'table_breeds') . " WHERE breed_id = '" . $_GET['breed_id'] . "'");

$breed = $db->fetchRowAssoc("SELECT * FROM " . cfg('base', 'table_breeds') . " WHERE breed_id = '" . $_GET['breed_id'] . "'");

//breed details
function breed($language, $string)
{

 global $db;
 $breed = $db->fetchRowAssoc("SELECT * FROM " . cfg('base', 'table_breeds') . " b, " . cfg('base', 'table_breed_translations') . " t WHERE b.breed_id = t.breed_id AND t.language_code = '" . $language . "' AND b.breed_id = '" . $_GET['breed_id'] . "'");

 return $breed[$string];
}

//Check if the form has been submitted
if (isset($_POST['submit'])) {

    foreach ($languages as $row) {
      $validate->required($_POST['breed_name'.'_'.$row['language_code']], 'Introduceti numele rasei ('.$row['language_code'].').');
    }

	if ($_FILES['image']['name']) {

        $result = $db->fetchRowAssoc("SELECT breed_image FROM " . cfg('base', 'table_breeds') . " WHERE breed_id = '" . $_GET['breed_id'] . "'");

        if ($result['breed_image']) {

            @unlink(cfg('upload', 'upload_path') . 'images/' . $result['breed_image']);

        }

        $image = $upload->uploadImage('image',url($_POST['breed_name'.'_'.cfg('language','site_language')]), 728, 438);

    }
	
    if (!$error->hasErrors()) {

        $values = array(
            'breed_status'            => $_POST['breed_status']
        );
		
		if (isset($image)) {

            $values['breed_image'] = $image;

        }

        $where = array(
            'breed_id' => $_GET['breed_id']
        );

        $db->where($where);
        $db->update(cfg('base', 'table_breeds'), $values);

        foreach ($languages as $row) {

          $count = $db->rowCount("SELECT breed_id FROM " . cfg('base', 'table_breed_translations') . " WHERE language_code = '" . $row['language_code'] . "'");
          if ($count > 0) {
                  $values = array(
                    'breed_name' => $_POST['breed_name'.'_'.$row['language_code']],
                    'breed_meta_keywords'    => $_POST['breed_meta_keywords'.'_'.$row['language_code']],
                    'breed_meta_description' => $_POST['breed_meta_description'.'_'.$row['language_code']],
					'breed_description' => $_POST['breed_description'.'_'.$row['language_code']]
                  );

                 $where = array(
                    'breed_id'   => $_GET['breed_id'],
                    'language_code' => $row['language_code'],
                 );

                $db->where($where);
                $db->update(cfg('base', 'table_breed_translations'), $values);

                $session->set('success', true);
           } else {
                $values = array(
                'breed_id'    => $_GET['breed_id'],
                'language_code' => $row['language_code'],
                'breed_name' => $_POST['breed_name'.'_'.$row['language_code']],
                'breed_meta_keywords'    => $_POST['breed_meta_keywords'.'_'.$row['language_code']],
                'breed_meta_description' => $_POST['breed_meta_description'.'_'.$row['language_code']],
				'breed_description' => $_POST['breed_description'.'_'.$row['language_code']]
                );

                $db->insert(cfg('base', 'table_breed_translations'), $values);

               $session->set('success', true);
           }
        }

     header("Location: edit_breed.php?breed_id=".$_GET['breed_id']."");

    }
}

//Template values
$tpl->set('rowCount', $rowCount);
$tpl->set('breed', $breed);

//Display the template
$tpl->display('admin/edit_breed');
