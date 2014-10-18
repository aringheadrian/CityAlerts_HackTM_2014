<?php

//Include the common file
require '../common.php';

//Check if the user is logged in
if (!$authentication->loggedIn() || !$authentication->isAdmin()) header("Location: login.php");

//Categories
function categories($parent_id,$language)
{
    global $db;

    $categories = array();
    foreach ($db->query("SELECT c.category_id, c.category_status, t.category_name FROM " . cfg('base', 'table_articles_categories') . " c, " . cfg('base', 'table_articles_category_translations') . " t WHERE c.category_id = t.category_id AND t.language_code = '" . $language ."' AND c.parent_id = '" . $parent_id . "' ORDER BY c.category_id ASC") as $value) {

        $categories[] = array(
            'category_id'        => $value['category_id'],
            'category_status'    => $value['category_status'],
            'category_name'        => get_path($value['category_id'],$language)
        );

        $categories = array_merge($categories, categories($value['category_id'],$language));

    }

    return $categories;
}

function get_path($category_id,$language)
{
    global $db;

    $result = $db->fetchRowAssoc("SELECT c.category_id, c.parent_id, t.category_name FROM " . cfg('base', 'table_articles_categories') . " c, " . cfg('base', 'table_articles_category_translations') . " t WHERE c.category_id = t.category_id AND t.language_code = '" . $language ."' AND c.category_id = '" . $category_id . "' ORDER BY c.category_id ASC");

    if ($result['parent_id'])
        return get_path($result['parent_id'],$language) .' > '. $result['category_name'];
    else
        return $result['category_name'];

}

//Check if the form has been submitted
if (isset($_POST['submit'])) {

    $validate->required($_POST['category_id'], 'Selectati categoria.');
    foreach ($languages as $row) {
     $validate->required($_POST['article_title'.'_'.$row['language_code']], 'Introduceti titlul articolului ('.$row['language_code'].').');
     $validate->required($_POST['article_content'.'_'.$row['language_code']], 'Introduceti continutul articolului ('.$row['language_code'].').');
    }

    if (!empty($_FILES['image']['name'])) {

        $image = $upload->uploadImage('image',url($_POST['article_title'.'_'.cfg('language','site_language')]), 726, 426, true, true);
    }

    if (!$error->hasErrors()) {

        $values = array(
        'article_video'               => $_POST['article_video'],
        'article_source'           => $_POST['article_source'],
        'article_status'           => $_POST['article_status'],
        'date_added'               => date('Y-m-d H:i:s')
        );

        if (isset($image)) {

            $values['article_image'] = $image;

        }

        $db->insert(cfg('base', 'table_articles'), $values);

        $article_id = $db->lastInsertId();

        $values = array(
            'article_id'    => $article_id,
            'category_id'    => $_POST['category_id']
        );

        $db->insert(cfg('base', 'table_category_articles'), $values);

        foreach ($languages as $row) {
            $values = array(
                'article_id'               => $article_id,
                'language_code'            => $row['language_code'],
                'article_title'           => $_POST['article_title'.'_'.$row['language_code']],
                'article_meta_keywords'    => $_POST['article_meta_keywords'.'_'.$row['language_code']],
                'article_meta_description' => $_POST['article_meta_description'.'_'.$row['language_code']],
                'article_content'           => $_POST['article_content'.'_'.$row['language_code']]
            );
         $db->insert(cfg('base', 'table_article_translations'), $values);
        }

        $tpl->set('success', true);
        header('Location: articles.php');

    }

}

//Display the template
$tpl->display('admin/add_article');
