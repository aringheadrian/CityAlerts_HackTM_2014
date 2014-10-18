<?php

//Include the common file
require '../common.php';

//Check if the user is logged in
if (!$authentication->loggedIn() || !$authentication->isAdmin()) header("Location: login.php");

//Returns the number of rows
$rowCount = $db->rowCount("SELECT user_id FROM " . cfg('authentication', 'table_users') . " WHERE user_id = '" . $_GET['user_id'] . "'");

//User Data
$userd = $db->fetchRowAssoc("SELECT * FROM " . cfg('authentication', 'table_profiles') . " p, " . cfg('authentication', 'table_users') . " u WHERE p.user_id = '" . $_GET['user_id'] . "' AND p.user_id = u.user_id");

//Check if the form has been submitted
if (isset($_POST['submit'])) {

    $validate->required($_POST['first_name'], 'Introduceti prenume.');
    $validate->required($_POST['last_name'], 'Introduceti numele de familie.');

    if (!empty($_FILES['image']['name'])) {

        $result = $db->fetchRowAssoc("SELECT avatar FROM " . cfg('authentication', 'table_profiles') . " WHERE user_id = '" . $_GET['user_id'] . "'");

        if ($result['avatar']) {

            @unlink(cfg('upload', 'upload_path') . 'images/' . $result['avatar']);

        }

        $image = $upload->uploadImage('image',url($_POST['first_name'].'-'.$_POST['last_name']), 100, 100, true);

    }

    if (!empty($_POST['password'])) {

        $validate->required($_POST['password'], 'Introduceti parola.');
        $validate->matches($_POST['password'], $_POST['confirm_password'], 'Valorile pentru parola si confirmare parola nu se potrivesc.');

    }

    if (!$error->hasErrors()) {

        $additional_data = array(
            'first_name'    => $_POST['first_name'],
            'last_name'    => $_POST['last_name']
        );

        if (isset($image)) {

            $additional_data['avatar'] = $image;

        }

        $parameters = array(
            'user_status' => $_POST['user_status']
        );

        if (!empty($_POST['password']))
            $password = $_POST['password'];
        else
            $password = false;

        $user = $authentication->getUser($_GET['user_id']);

        $authentication->updateUser($_GET['user_id'], $user['user_email'], $password, $additional_data, $parameters);

        $session->set('success', true);

        header('Location: edit_user.php?user_id='.$_GET['user_id']);

    }

}

//Template values
$tpl->set('rowCount', $rowCount);
$tpl->set('userd', $userd);

//Display the template
$tpl->display('admin/edit_user');
