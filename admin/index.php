<?php

//Include the common file
require '../common.php';

//Check if the user is logged in
if (!$authentication->loggedIn() || !$authentication->isAdmin()) header("Location: login.php");

//Logout
if (isset($_GET['logout'])) {

    $authentication->logout('admin/login.php');

    header("Location: login.php");

}

//Template values
$tpl->set('rowCount', $rowCount);
$tpl->set('top_sellers', $top_sellers);
$tpl->set('latest_orders', $latest_orders);

//Display the template
$tpl->display('admin/index');
