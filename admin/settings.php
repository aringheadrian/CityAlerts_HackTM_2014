<?php

//Include the common file
require '../common.php';

//Check if the user is logged in
if (!$authentication->loggedIn() || !$authentication->isAdmin()) header("Location: login.php");

//Check if the form has been submitted
if (isset($_POST['submit'])) {

    $validate->required($_POST['site_title'], 'Titlul site-ului este obligatoriu.');
    $validate->required($_POST['site_url'], 'URL-ul site-ului este obligatoriu.');
    $validate->required($_POST['map_latitude'], 'Latitudinea este obligatorie.');
    $validate->required($_POST['map_longitude'], 'Longitudinea este obligatorie.');
    $validate->email($_POST['admin_email'], 'Adresa de e-mail nu este valida.');

    $validate->numeric($_POST['per_page_catalog'], 'Numarul de elemente pe pagina este obligatoriu.');
    $validate->numeric($_POST['per_page_admin'], 'Numarul de elemente pe pagina din panoul de admin este obligatoriu.');

    $validate->numeric($_POST['max_filesize'], 'Dimensiunea maxima a fisiereleor de uploadat.');
    $validate->numeric($_POST['max_width_thumbnail'], 'Latimea maxima a thumbnail-ului este obligatorie.');
    $validate->numeric($_POST['max_height_thumbnail'], 'Inaltimea maxima a thumbnail-ului este obligatorie.');
    $validate->numeric($_POST['max_width'], 'Latimea maxima a imaginilor este obligatorie.');
    $validate->numeric($_POST['max_height'], 'Inaltimea maxima a imaginilor este obligatorie.');

    if (!$error->hasErrors()) {

        save_config($_POST);

        $tpl->set('success', true);
        header("Location: settings.php");
    }

}

//Display the template
$tpl->display('admin/settings');
