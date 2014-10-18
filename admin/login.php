<?php

//Include the common file
//require_once "WindowsAzure/WindowsAzure.php";
echo "nu e eroare aici !";
//require '/../common.php';
$tpl = new lib\Template(cfg('template', 'absolute_path'));

//Template values
$tpl->set('db', $db);
$tpl->set('authentication', $authentication);
$tpl->set('error', $error);
$tpl->set('session', $session);


//Check if the user is logged in and is admin
if ($authentication->loggedIn() && $authentication->isAdmin()) header("Location: index.php");

 //Check if the form has been submitted
if (isset($_POST['submit'])) {

    $validate->email($_POST['email'], 'Email address not valid.');
    $validate->required($_POST['password'], 'Enter your password.');

    if (!$error->hasErrors()) {

        $remember = false;

        if (isset($_POST['remember']))
             $remember = true;

         if ($authentication->login($_POST['email'], $_POST['password'], $remember))
             header("Location: index.php");
         else
             $tpl->set('failed', true);

     }

 }

//Display the template
$tpl->display('admin/login');
?>