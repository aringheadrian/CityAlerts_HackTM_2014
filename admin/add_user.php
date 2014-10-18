<?php

//Include the common file
require '../common.php';

//Check if the user is logged in
if (!$authentication->loggedIn() || !$authentication->isAdmin()) header("Location: login.php");

//Check if the form has been submitted
if (isset($_POST['submit'])) {

    $validate->required($_POST['first_name'], 'Introduceti prenume.');
    $validate->required($_POST['last_name'], 'Introduceti numele de familie.');
    $validate->email($_POST['email'], 'Adresa de e-mail nu este valida.');
    $validate->required($_POST['password'], 'Introduceti parola.');
    $validate->matches($_POST['password'], $_POST['confirm_password'], 'Valorile pentru parola si confirmare parola nu se potrivesc.');

    if (!empty($_FILES['image']['name'])) {

        $image = $upload->uploadImage('image',url($_POST['first_name'].'-'.$_POST['last_name']), 100, 100, true);

    }

    if (!$error->hasErrors()) {

        if ($authentication->checkEmail($_POST['email'])) {

            $additional_data = array(
                'first_name'    => $_POST['first_name'],
                'last_name'    => $_POST['last_name']
            );

            if (isset($image)) {

            $additional_data['avatar'] = $image;

           }

            $parameters = array(
                'user_status'    => $_POST['user_status']
            );

            if (isset($_POST['send_email']))
                $parameters['send_email'] = $_POST['send_email'];

            $authentication->createUser($_POST['email'], $_POST['password'], $additional_data, $parameters);

            $tpl->set('success', true);

            header('Location: users.php');

        } else {

            $tpl->set('failed', true);

        }

    }

}

//Display the template
$tpl->display('admin/add_user');
