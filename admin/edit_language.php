<?php

//Include the common file
require '../common.php';

//Check if the user is logged in
if (!$authentication->loggedIn() || !$authentication->isAdmin()) header("Location: login.php");

//Returns the number of rows
$rowCount = $db->rowCount("SELECT language_code FROM " . cfg('base', 'table_languages') . " WHERE language_code = '" . $_GET['language_code'] . "'");

$lang = $db->fetchRowAssoc("SELECT language_name, language_status FROM " . cfg('base', 'table_languages') . " WHERE language_code = '" . $_GET['language_code'] . "'");

//Check if the form has been submitted
if (isset($_POST['submit'])) {

     $validate->required($_POST['language_name'], 'Introduceti numele limbii.');

    if (!$error->hasErrors()) {

        $values = array(
            'language_name'            => $_POST['language_name'],
            'language_status'            => $_POST['language_status']
        );

        $where = array(
            'language_code' => $_GET['language_code']
        );

        $db->where($where);
        $db->update(cfg('base', 'table_languages'), $values);

        $session->set('success', true);
        header("Location: edit_language.php?language_code=".$_GET['language_code']."");
    }
}

//Template values
$tpl->set('rowCount', $rowCount);
$tpl->set('lang', $lang);

//Display the template
$tpl->display('admin/edit_language');
