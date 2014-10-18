<?php

//Include the common file
require '../common.php';

//Check if the user is logged in
if (!$authentication->loggedIn() || !$authentication->isAdmin()) header("Location: login.php");

//Returns the number of rows
$rowCount = $db->rowCount("SELECT category_id FROM " . cfg('base', 'table_articles_categories') . " WHERE category_id = '" . $_GET['category_id'] . "'");

$cat = $db->fetchRowAssoc("SELECT * FROM " . cfg('base', 'table_articles_categories') . " WHERE category_id = '" . $_GET['category_id'] . "'");

//Category details
function cat($language, $string)
{

 global $db;
 $cat = $db->fetchRowAssoc("SELECT * FROM " . cfg('base', 'table_articles_categories') . " c, " . cfg('base', 'table_articles_category_translations') . " t WHERE c.category_id = t.category_id AND t.language_code = '" . $language . "' AND c.category_id = '" . $_GET['category_id'] . "'");

 return $cat[$string];
}

//Check if the form has been submitted
if (isset($_POST['submit'])) {

    foreach ($languages as $row) {
      $validate->required($_POST['category_name'.'_'.$row['language_code']], 'Introduceti numele categoriei ('.$row['language_code'].').');
    }

    if (!$error->hasErrors()) {

        $values = array(
            'category_status'            => $_POST['category_status']
        );

        $where = array(
            'category_id' => $_GET['category_id']
        );

        $db->where($where);
        $db->update(cfg('base', 'table_articles_categories'), $values);

        foreach ($languages as $row) {

          $count = $db->rowCount("SELECT category_id FROM " . cfg('base', 'table_articles_category_translations') . " WHERE language_code = '" . $row['language_code'] . "'");
          if ($count > 0) {
                  $values = array(
                    'category_name' => $_POST['category_name'.'_'.$row['language_code']],
                    'category_meta_keywords'    => $_POST['category_meta_keywords'.'_'.$row['language_code']],
                    'category_meta_description' => $_POST['category_meta_description'.'_'.$row['language_code']]
                  );

                 $where = array(
                    'category_id'   => $_GET['category_id'],
                    'language_code' => $row['language_code'],
                 );

                $db->where($where);
                $db->update(cfg('base', 'table_articles_category_translations'), $values);

                $session->set('success', true);
           } else {
                $values = array(
                'category_id'    => $_GET['category_id'],
                'language_code' => $row['language_code'],
                'category_name' => $_POST['category_name'.'_'.$row['language_code']],
                'category_meta_keywords'    => $_POST['category_meta_keywords'.'_'.$row['language_code']],
                'category_meta_description' => $_POST['category_meta_description'.'_'.$row['language_code']]
                );

                $db->insert(cfg('base', 'table_articles_category_translations'), $values);

               $session->set('success', true);
           }
        }

     header("Location: edit_articles_category.php?category_id=".$_GET['category_id']."");

    }
}

//Template values
$tpl->set('rowCount', $rowCount);
$tpl->set('cat', $cat);

//Display the template
$tpl->display('admin/edit_articles_category');
