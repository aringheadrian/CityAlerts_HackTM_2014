<?php

//Include the common file
require '../common.php';

//Check if the user is logged in
if (!$authentication->loggedIn() || !$authentication->isAdmin()) header("Location: login.php");

$page = $db->fetchRowAssoc("SELECT * FROM " . cfg('base', 'table_pages') . " p, " . cfg('base', 'table_page_translations') . " t  WHERE p.page_id = t.page_id AND p.page_id = ".$_GET['page_id']."");

//Page details
function page($language, $string)
{

 global $db;
 $page = $db->fetchRowAssoc("SELECT * FROM " . cfg('base', 'table_pages') . " p, " . cfg('base', 'table_page_translations') . " t  WHERE p.page_id = t.page_id AND p.page_id = ".$_GET['page_id']." AND t.language_code = '" . $language . "'");

 return $page[$string];
}

//Check if the form has been submitted
if (isset($_POST['submit'])) {

    if (!$error->hasErrors()) {

    //Returns the number of rows
    $rowCount = $db->rowCount("SELECT page_id FROM " . cfg('base', 'table_pages') . " WHERE page_id = '" . $_GET['page_id'] . "'");

    foreach ($languages as $row) {
        $rowCount_tr = $db->rowCount("SELECT page_id FROM " . cfg('base', 'table_page_translations') . " WHERE page_id = '" . $_GET['page_id'] . "' AND language_code = '" . $row['language_code'] . "'");

        if ($rowCount <= 0) {
         $values = array(
            'page_id'              => $_GET['page_id'],
        );
        $db->insert(cfg('base', 'table_pages'), $values);
        }
        if ($rowCount_tr <= 0) {
         $values = array(
            'page_title'              => $_POST['page_title'.'_'.$row['language_code']],
            'page_meta_keywords'      => $_POST['page_meta_keywords'.'_'.$row['language_code']],
            'page_meta_description'   => $_POST['page_meta_description'.'_'.$row['language_code']],
            'page_content'            => $_POST['page_content'.'_'.$row['language_code']],
            'page_id'                 => $_GET['page_id'],
            'language_code'           => $row['language_code']
        );
         $db->insert(cfg('base', 'table_page_translations'), $values);
        } else {
            $values = array(
            'page_title'              => $_POST['page_title'.'_'.$row['language_code']],
            'page_meta_keywords'      => $_POST['page_meta_keywords'.'_'.$row['language_code']],
            'page_meta_description'   => $_POST['page_meta_description'.'_'.$row['language_code']],
            'page_content'            => $_POST['page_content'.'_'.$row['language_code']]
            );

            $where = array(
                'page_id'                 => $_GET['page_id'],
                'language_code'           => $row['language_code']
            );

            $db->where($where);
            $db->update(cfg('base', 'table_page_translations'), $values);
        }
    }
        $session->set('success', true);

        header('Location: pages.php?page_id='.$_GET['page_id']);

    }
}

//Template values
$tpl->set('page', $page);

//Display the template
$tpl->display('admin/pages');
