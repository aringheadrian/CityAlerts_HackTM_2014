<?php

//Include the common file
require '../common.php';

//Check if the user is logged in
if (!$authentication->loggedIn() || !$authentication->isAdmin()) header("Location: login.php");

//Returns the number of rows
$rowCount = $db->rowCount("SELECT article_id FROM " . cfg('base', 'table_articles') . " WHERE article_id = '" . $_GET['article_id'] . "'");

$art = $db->fetchRowAssoc("SELECT * FROM " . cfg('base', 'table_articles') . " WHERE article_id = '" . $_GET['article_id'] . "'");

function art($language, $string)
{

 global $db;
 $art = $db->fetchRowAssoc("SELECT * FROM " . cfg('base', 'table_articles') . " a, " . cfg('base', 'table_article_translations') . " t, " . cfg('base', 'table_category_articles') . " ca WHERE a.article_id = t.article_id AND a.article_id = ca.article_id AND t.language_code = '" . $language . "' AND a.article_id = '" . $_GET['article_id'] . "'");

 return $art[$string];
}

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

    if ($_FILES['image']['name']) {

        $result = $db->fetchRowAssoc("SELECT article_image FROM " . cfg('base', 'table_articles') . " WHERE article_id = '" . $_GET['article_id'] . "'");

        if ($result['article_image']) {

            @unlink(cfg('upload', 'upload_path') . 'images/' . $result['article_image']);

        }

        $image = $upload->uploadImage('image',url($_POST['article_title'.'_'.cfg('language','site_language')]), 726, 426, true, true);

    }

    if (!$error->hasErrors()) {

        $values = array(
        'article_video'               => $_POST['article_video'],
        'article_source'           => $_POST['article_source'],
        'article_status'           => $_POST['article_status'],
        );

        if (isset($image)) {

            $values['article_image'] = $image;

        }

        $where = array(
            'article_id' => $_GET['article_id']
        );

        $db->where($where);
        $db->update(cfg('base', 'table_articles'), $values);

        $where = array(
            'article_id' => $_GET['article_id']
        );

        $db->where($where);
        $db->delete(cfg('base', 'table_category_articles'));

        $values = array(
            'article_id'    => $_GET['article_id'],
            'category_id'    => $_POST['category_id']
        );

        $db->insert(cfg('base', 'table_category_articles'), $values);

        foreach ($languages as $row) {
            $count = $db->rowCount("SELECT article_id FROM " . cfg('base', 'table_article_translations') . " WHERE language_code = '" . $row['language_code'] . "'");

            if ($count > 0) {
                $values = array(
                    'article_title'               => $_POST['article_title'.'_'.$row['language_code']],
                    'article_meta_keywords'        => $_POST['article_meta_keywords'.'_'.$row['language_code']],
                    'article_meta_description'     => $_POST['article_meta_description'.'_'.$row['language_code']],
                    'article_content'               => $_POST['article_content'.'_'.$row['language_code']]
                );

                $where = array(
                    'article_id'       => $_GET['article_id'],
                    'language_code'    => $row['language_code']
                );

                $db->where($where);
                $db->update(cfg('base', 'table_article_translations'), $values);
            } else {
                $values = array(
                'article_id'                   => $_GET['article_id'],
                'language_code'                => $row['language_code'],
                'article_title'               => $_POST['article_title'.'_'.$row['language_code']],
                'article_meta_keywords'        => $_POST['article_meta_keywords'.'_'.$row['language_code']],
                'article_meta_description'     => $_POST['article_meta_description'.'_'.$row['language_code']],
                'article_content'               => $_POST['article_content'.'_'.$row['language_code']]
                );
                $db->insert(cfg('base', 'table_article_translations'), $values);
            }
        }

        $session->set('success', true);
        header("Location: edit_article.php?article_id=".$_GET['article_id']."");

    }
}

//Template values
$tpl->set('rowCount', $rowCount);
$tpl->set('art', $art);

//Display the template
$tpl->display('admin/edit_article');
