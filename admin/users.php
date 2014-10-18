<?php

//Include the common file
require '../common.php';

//Check if the user is logged in
if (!$authentication->loggedIn() || !$authentication->isAdmin()) header("Location: login.php");

//Returns the number of rows
$rowCount = $db->rowCount("SELECT user_id FROM " . cfg('authentication', 'table_users') . " WHERE group_id != 1");

//Pagination
if (isset($_GET['page']))
    $current_page = trim($_GET['page']);
else
    $current_page = 1;

$start = ($current_page -1 ) * cfg('base', 'per_page_admin');

$sql = "SELECT * FROM " . cfg('authentication', 'table_profiles') . " p, " . cfg('authentication', 'table_users') . " u WHERE p.user_id = u.user_id";

$implode = array();

if (isset($_POST['search']) && !empty($_POST['filter_name']))
    $implode[] = " CONCAT(p.first_name, ' ', p.last_name) LIKE '%" . $_POST['filter_name'] . "%'";

if (isset($_POST['search']) && !empty($_POST['filter_email']))
    $implode[] = " u.user_email LIKE '%" . $_POST['filter_email'] . "%'";

if ($implode)
    $sql .= " AND " . implode(" AND ", $implode);

$sql .= " AND u.group_id != 1 ORDER BY u.user_id DESC";

$sql .= " LIMIT " . $start . ", " . cfg('base', 'per_page_admin') . "";

$pages = ceil($db->rowCount("SELECT user_id FROM " . cfg('authentication', 'table_users') . " WHERE group_id != 1") / cfg('base', 'per_page_admin'));

//Users
$users = array();

foreach ($db->query($sql) as $row) {

    $users[] = array(
        'user_id'            => $row['user_id'],
        'first_name'        => $row['first_name'],
        'last_name'            => $row['last_name'],
        'user_email'        => $row['user_email'],
		'user_created'        => $row['user_created'],
        'user_status'        => $row['user_status']
    );
}

//Check if the form has been submitted
if (isset($_POST['cb_user'])) {

    foreach ($_POST['cb_user'] as $value) {

        $result = $db->fetchRowAssoc("SELECT avatar FROM " . cfg('authentication', 'table_profiles') . " WHERE user_id = '" . $value . "'");

        if ($result['avatar']) {

            @unlink(cfg('upload', 'upload_path') . 'images/' . $result['avatar']);

        }

        $where = array(
            'user_id' => $value
        );

        $db->where($where);
        $db->delete(cfg('authentication', 'table_users'));
        $db->delete(cfg('authentication', 'table_profiles'));

    }

    header("Location: users.php");

}

//Template values
$tpl->set('rowCount', $rowCount);
$tpl->set('current_page', $current_page);
$tpl->set('pages', $pages);
$tpl->set('users', $users);

//Display the template
$tpl->display('admin/users');
