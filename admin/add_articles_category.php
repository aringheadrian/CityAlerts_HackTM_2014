<?php

//Include the common file
require '../common.php';

//Check if the user is logged in
if (!$authentication->loggedIn() || !$authentication->isAdmin()) header("Location: login.php");

//Check if the form has been submitted
if (isset($_POST['submit'])) {

    foreach ($languages as $row) {
      $validate->required($_POST['category_name'.'_'.$row['language_code']], 'Introduceti numele categoriei ('.$row['language_code'].').');
    }

    if (!$error->hasErrors()) {

        $values = array(
            'parent_id'                => $_POST['parent_id'],
            'category_status'            => $_POST['category_status']
        );

        $db->insert(cfg('base', 'table_articles_categories'), $values);

        $category_id = $db->lastInsertId();

        foreach ($languages as $row) {
          $values = array(
            'category_id'    => $category_id,
            'language_code' => $row['language_code'],
            'category_name' => $_POST['category_name'.'_'.$row['language_code']],
            'category_meta_keywords'    => $_POST['category_meta_keywords'.'_'.$row['language_code']],
            'category_meta_description' => $_POST['category_meta_description'.'_'.$row['language_code']]
         );

         $db->insert(cfg('base', 'table_articles_category_translations'), $values);
        }

        $tpl->set('success', true);
        header('Location: articles_categories.php');
    }

}

//Display the template
$tpl->display('admin/add_articles_category');
