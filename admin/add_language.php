<?php

//Include the common file
require '../common.php';

//Check if the user is logged in
if (!$authentication->loggedIn() || !$authentication->isAdmin()) header("Location: login.php");

//Check if the form has been submitted
if (isset($_POST['submit'])) {

    $validate->required($_POST['language_code'], 'Introduceti codul pentru limba.');
    $validate->required($_POST['language_name'], 'Introduceti numele limbii.');

    if (!$error->hasErrors()) {

        $values = array(
            'language_code'                => $_POST['language_code'],
            'language_name'            => $_POST['language_name'],
            'language_status'            => $_POST['language_status']
        );

        $db->insert(cfg('base', 'table_languages'), $values);

        $tpl->set('success', true);
        header('Location: languages.php');
    }

}

//Display the template
$tpl->display('admin/add_language');
