<?php 
//if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');

/**
 * Autoloading classes
 */
 
function __autoload($className)
{
    $className = ltrim($className, '\\');
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
 
    require $fileName;
}

//Initialize core objects

use TreeWeb\libraries as lib;

$db = new lib\Database();
$authentication = new lib\Authentication();
$error = new lib\Error();
$session = new lib\Session();
$validate = new lib\Validate();
$upload = new lib\Upload();
$tpl = new lib\Template(cfg('template', 'absolute_path'));

//Template values
$tpl->set('db', $db);
$tpl->set('authentication', $authentication);
$tpl->set('error', $error);
$tpl->set('session', $session);

//User Data
$user = $db->fetchRowAssoc("SELECT * FROM " . cfg('authentication', 'table_profiles') . " p, " . cfg('authentication', 'table_users') . " u, " . cfg('authentication', 'table_groups') . " g WHERE u.user_id = '" . $session->get('user_id') . "' AND u.user_id = p.user_id AND g.group_id = u.group_id");

$tpl->set('user', $user);

//AUTHENTICATION

//Check if the form has been submitted
if (isset($_POST['login'])) {

    $validate->email($_POST['email'], 'Email address not valid.');
    $validate->required($_POST['password'], 'Enter your password.');

    if (!$error->hasErrors()) {

        $remember = false;

        if (isset($_POST['remember']))
            $remember = true;

        if ($authentication->login($_POST['email'], $_POST['password'], $remember))
            header("Location: http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        else
            $tpl->set('failed', true);

    } else {

        $tpl->set('failed', true);

    }

}

//Check if register form has been submitted
if (isset($_POST['register'])) {

    $validate->email($_POST['email'], 'Email address not valid.');
    $validate->required($_POST['first_name'], 'Enter your first name.');
    $validate->required($_POST['last_name'], 'Enter your last name.');
	$validate->required($_POST['username'], 'Enter your username.');
    $validate->required($_POST['password'], 'Enter your password.');
    $validate->matches($_POST['password'], $_POST['confirm_password'], 'The password field does not match the confirm password field.');

    if (!empty($_FILES['image']['name'])) {

        $image = $upload->uploadImage('image',url($_POST['first_name'].'-'.$_POST['last_name']), 100, 100, true);

    }

    if (!$error->hasErrors()) {

        if ($authentication->checkEmail($_POST['email'])) {

            $additional_data = array(
                'first_name'    => $_POST['first_name'],
                'last_name'     => $_POST['last_name'],
				'username'      => $_POST['username']
            );

            if (isset($image)) {

                $additional_data['avatar'] = $image;

            }

            $authentication->createUser($_POST['email'], $_POST['password'], $additional_data);

            $tpl->set('success', true);

        } else {

            $tpl->set('failed', true);

        }
    }
}
//Check if update profile form has been submitted
if (isset($_POST['update_profile'])) {

    $validate->required($_POST['first_name'], 'Enter your first name.');
    $validate->required($_POST['last_name'], 'Enter your last name.');
	$validate->required($_POST[''], 'Enter your last name.');

    if (!empty($_POST['password'])) {

        $validate->required($_POST['password'], 'Enter your password.');
        $validate->matches($_POST['password'], $_POST['confirm_password'], 'The password field does not match the confirm password field.');

    }

    if (!empty($_FILES['image']['name'])) {

        $result = $db->fetchRowAssoc("SELECT avatar FROM " . cfg('authentication', 'table_profiles') . " WHERE user_id = '" . $session->get('user_id') . "'");

        if ($result['avatar']) {

            @unlink(cfg('upload', 'upload_path') . 'images/' . $result['avatar']);

        }
        $image = $upload->uploadImage('image',url($_POST['first_name'].'-'.$_POST['last_name']), 100, 100, true);
    }

    if (!$error->hasErrors()) {

        $additional_data = array(
            'first_name'    => $_POST['first_name'],
            'last_name'    => $_POST['last_name'],
			'username'    => $_POST['username']
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

        $user = $authentication->getUser($session->get('user_id'));

        $authentication->updateUser($session->get('user_id'), $user['user_email'], $password, $additional_data, $parameters);

        $session->set('success', true);

        header("Location: http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    }
}
//Check if reset password form has been submitted
if (isset($_POST['reset_password'])) {

    $validate->email($_POST['email'], 'Email address not valid.');

    if (!$error->hasErrors()) {

        if ($authentication->newPassword($_POST['email']))
            $tpl->set('success', true);
        else
            $tpl->set('failed', true);
    }
}
//Logout
if (isset($_GET['logout']) && !$_POST) {

    $authentication->logout();

    header("Location: ". str_replace("?logout","","http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']));
}

/**
 * Load a config file
 */
function config_load($name)
{
    $configuration = array();

    if (!file_exists(dirname(__FILE__) . '/config/' . $name . '.php'))
        die('The file ' . dirname(__FILE__) . '/config/' . $name . '.php does not exist.');

    require dirname(__FILE__) . '/config/' . $name . '.php';

    if (!isset($config) or !is_array($config))
        die('The file ' . dirname(__FILE__) . '/config/' . $name . '.php file does not appear to be formatted correctly.');

    if (isset($config) and is_array($config))
        $configuration = array_merge($configuration, $config);

    return $configuration;

}

/**
 * Load a config item
 */
function cfg($name, $item)
{
    static $cfg = array();

    if (!isset($cfg[$item])) {

        $config = config_load($name);

        if (!isset($config[$item]))
            return FALSE;

        $cfg[$item] = $config[$item];

    }

    return $cfg[$item];

}

function make_path($path)
{
        //test if path exist
        if (is_dir($path) || file_exists($path)) return;
        //no, create it
        mkdir($path, 0777, true);
    }

 //recursive we set chmod to 0777 to all subdir starting from dir given as param
 function fsmodify($obj)
 {
       $chunks = explode('/', $obj);
       chmod($obj, is_dir($obj) ? 0777 : 0644);
    }

 function fsmodifyr($dir)
    {
       if ($objs = glob($dir."/*")) {
           foreach ($objs as $obj) {
               fsmodify($obj);
               if(is_dir($obj)) fsmodifyr($obj);
           }
       }

       return fsmodify($dir);
    }

// ensure $dir ends with a slash

 function delTree($dir)
 {
    $files = glob( $dir . '*', GLOB_MARK );
    foreach ($files as $file) {
        if( substr( $file, -1 ) == '/' )
            delTree( $file );
        else
            unlink( $file );
    }
    rmdir( $dir );
 }

 function url($string)
 {
    $replace = '-';
    $string = trim($string);
    $string = strtolower($string);

    //remove query string
    if (preg_match("#^http(s)?://[a-z0-9-_.]+\.[a-z]{2,4}#i",$string)) {
        $parsed_url = parse_url($string);
        $string = $parsed_url['host'].' '.$parsed_url['path'];

        //if want to add scheme eg. http, https than uncomment next line
        //$string = $parsed_url['scheme'].' '.$string;
    }

    //replace / and . with white space
    $string = preg_replace("/[\/\.+]/", " ", $string);

    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);

    //remove multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);

    //convert whitespaces and underscore to $replace
    $string = preg_replace("/[\s_]/", $replace, $string);

    //slug is generated
    return $string;
}

 function ShortenText($text,$nr)
 {
    // Change to the number of characters you want to display
    $chars =$nr;
    if ($nr<strlen($text)) {    $text = $text." ";
        $text = substr($text,0,$chars);
        $text = substr($text,0,strrpos($text,' '));
        $text = $text."...";
    }

    return $text;
 }

 function Zip($source, $destination)
 {
    if (!extension_loaded('zip') || !file_exists($source)) {
        return false;
    }

    $zip = new ZipArchive();
    if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
        return false;
    }

    $source = str_replace('\\', '/', realpath($source));

    if (is_dir($source) === true) {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

        foreach ($files as $file) {
            $file = str_replace('\\', '/', $file);

            // Ignore "." and ".." folders
            if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
                continue;

            $file = realpath($file);

            if (is_dir($file) === true) {
                $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
            } elseif (is_file($file) === true) {
                $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
            }
        }
    } elseif (is_file($source) === true) {
        $zip->addFromString(basename($source), file_get_contents($source));
    }

    return $zip->close();
 }

/**
 * Save settings
 */
function save_config($config)
{
    define('DIR_APPLICATION', str_replace('\'', '/', realpath(dirname(__FILE__))) . '/');

    $content = "";
    $content .= "<?php if (__FILE__ == \$_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');\n\n";

    $content .= "\$config['table_users'] = 'cta_users';\n";
    $content .= "\$config['table_groups'] = 'cta_user_groups';\n";
    $content .= "\$config['table_profiles'] = 'cta_user_profiles';\n\n";

    $content .= "\$config['site_title'] = '" . filter_var($config['site_title'], FILTER_SANITIZE_STRING) . "';\n\n";

    $content .= "\$config['site_url'] = '" . filter_var($config['site_url'], FILTER_SANITIZE_STRING) . "';\n\n";

    $content .= "\$config['absolute_path'] = '" . DIR_APPLICATION . "';\n\n";

    $content .= "\$config['admin_email'] = '" . $config['admin_email'] . "';\n\n";

    $content .= "\$config['default_group'] = 2;\n\n";

    $content .= "\$config['admin_group'] =  1;\n\n";

    if ($config['type_registration'] == 0) {

        $email_activation = "false";
        $approve_registration = "false";

    } elseif ($config['type_registration'] == 1) {

        $email_activation = "true";
        $approve_registration = "false";

    } elseif ($config['type_registration'] == 2) {

        $email_activation = "false";
        $approve_registration = "true";

    }

    $content .= "\$config['email_activation'] = " . $email_activation . ";\n\n";

    $content .= "\$config['approve_registration'] = " . $approve_registration . ";\n\n";

    $content .= "\$config['email_activation_expire'] = 60 * 60 * 24;\n\n";

    $content .= "\$config['email_subject_1'] = 'Thank you for registering';\n\n";

    $content .= "\$config['email_subject_2'] = 'New password';\n\n";

    $content .= "\$config['email_subject_3'] = 'A new customer has registered';\n\n";

    $content .= "\$config['user_expire'] = 3600 * 24 * 30;\n\n";

    $content .= "\$config['secret_word'] = '" . cfg('authentication', 'secret_word') . "';\n\n";

    $content .= "?>";

    file_put_contents("../config/authentication.php", $content, LOCK_EX);

    $content = "";
    $content .= "<?php if (__FILE__ == \$_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');\n\n";

    $content .= "\$config['table_agencies'] = 'cta_agencies';\n";
	$content .= "\$config['table_alerts'] = 'cta_alerts';\n";
	$content .= "\$config['table_alert_types'] = 'cta_alert_types';\n";
	$content .= "\$config['table_comments'] = 'cta_comments';\n";
	$content .= "\$config['table_pages'] = 'cta_pages';\n";
	$content .= "\$config['table_users_agencies'] = 'cta_users_agencies';\n";
	$content .= "\$config['table_user_settings'] = 'cta_user_settings';\n\n";

    $content .= "\$config['site_title'] = '" . filter_var($config['site_title'], FILTER_SANITIZE_STRING) . "';\n\n";

    $content .= "\$config['site_url'] = '" . filter_var($config['site_url'], FILTER_SANITIZE_STRING) . "';\n\n";

    $content .= "\$config['absolute_path'] = '" .DIR_APPLICATION . "';\n\n";

    $content .= "\$config['per_page_catalog'] = " . $config['per_page_catalog'] . ";\n\n";

    $content .= "\$config['per_page_admin'] = " . $config['per_page_admin'] . ";\n\n";

    $content .= "\$config['log_path'] = '" . DIR_APPLICATION . "logs/';\n\n";

    $content .= "\$config['google_verification'] = '" . $config['google_verification'] . "';\n\n";

    $content .= "\$config['bing_verification'] = '" . $config['bing_verification'] . "';\n\n";

    $content .= "\$config['google_analytics'] = '" . $config['google_analytics'] . "';\n\n";

    $content .= "?>";

    file_put_contents("../config/base.php", $content, LOCK_EX);

    $content = "";
    $content .= "<?php if (__FILE__ == \$_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');\n\n";

    $content .= "\$config['facebook_appid'] = '" . $config['facebook_appid'] . "';\n\n";

    $content .= "\$config['facebook_page'] = '" . $config['facebook_page'] . "';\n\n";

    $content .= "\$config['twitter_page'] = '" . $config['twitter_page'] . "';\n\n";

    $content .= "\$config['googleplus_page'] = '" . $config['googleplus_page'] . "';\n\n";

    $content .= "\$config['youtube_channel'] = '" . $config['youtube_channel'] . "';\n\n";

    $content .= "\$config['pinterest_page'] = '" . $config['pinterest_page'] . "';\n\n";

    $content .= "\$config['pinterest_verification'] = '" . $config['pinterest_verification'] . "';\n\n";

    $content .= "\$config['tumblr_page'] = '" . $config['tumblr_page'] . "';\n\n";

    $content .= "\$config['delicious_page'] = '" . $config['delicious_page'] . "';\n\n";

    $content .= "\$config['stumbleupon_page'] = '" . $config['stumbleupon_page'] . "';\n\n";

    $content .= "\$config['disqus_shortname'] = '" . $config['disqus_shortname'] . "';\n\n";

    $content .= "\$config['comment_system'] = " . $config['comment_system'] . ";\n\n";

    $content .= "?>";

    file_put_contents("../config/social.php", $content, LOCK_EX);
	
	$content = "";
	$content .= "<?php if (__FILE__ == \$_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');\n\n";

	$content .= "\$config['table_social_accounts'] = 'cta_social_accounts';\n\n";
	
	$content .= "\$config['site_url'] = '" . $config['site_url'] . "';\n\n";
	
	$content .= "\$config['hybridauth_path'] = '" . $config['hybridauth_path'] . "';\n\n";
	
	if (isset($config['yahoo_enabled']))
		$yahoo_enabled = 'true';
	else
		$yahoo_enabled = 'false';
	
	$content .= "\$config['yahoo_enabled'] = " . $yahoo_enabled . ";\n\n";

	$content .= "\$config['yahoo_key'] = '" . $config['yahoo_key'] . "';\n\n";
	
	$content .= "\$config['yahoo_secret'] = '" . $config['yahoo_secret'] . "';\n\n";
	
	if (isset($config['google_enabled']))
		$google_enabled = 'true';
	else
		$google_enabled = 'false';
	
	$content .= "\$config['google_enabled'] = " . $google_enabled . ";\n\n";

	$content .= "\$config['google_id'] = '" . $config['google_id'] . "';\n\n";
	
	$content .= "\$config['google_secret'] = '" . $config['google_secret'] . "';\n\n";
	
	if (isset($config['facebook_enabled']))
		$facebook_enabled = 'true';
	else
		$facebook_enabled = 'false';
	
	$content .= "\$config['facebook_enabled'] = " . $facebook_enabled . ";\n\n";

	$content .= "\$config['facebook_id'] = '" . $config['facebook_id'] . "';\n\n";
	
	$content .= "\$config['facebook_secret'] = '" . $config['facebook_secret'] . "';\n\n";
	
	if (isset($config['twitter_enabled']))
		$twitter_enabled = 'true';
	else
		$twitter_enabled = 'false';
	
	$content .= "\$config['twitter_enabled'] = " . $twitter_enabled . ";\n\n";

	$content .= "\$config['twitter_key'] = '" . $config['twitter_key'] . "';\n\n";
	
	$content .= "\$config['twitter_secret'] = '" . $config['twitter_secret'] . "';\n\n";
	
	if (isset($config['linkedin_enabled']))
		$linkedin_enabled = 'true';
	else
		$linkedin_enabled = 'false';
	
	$content .= "\$config['linkedin_enabled'] = " . $linkedin_enabled . ";\n\n";

	$content .= "\$config['linkedin_key'] = '" . $config['linkedin_key'] . "';\n\n";
	
	$content .= "\$config['linkedin_secret'] = '" . $config['linkedin_secret'] . "';\n\n";
	
	$content .= "?>";
	
	file_put_contents("../config/integration.php", $content, LOCK_EX);
	
    $content = "";
	$content .= "<?php if (__FILE__ == \$_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');\n\n";

	$content .= "\$config['contact_address'] = '" . $config['contact_address'] . "';\n\n";
	
	$content .= "\$config['contact_zip_code'] = '" . $config['contact_zip_code'] . "';\n\n";
	
	$content .= "\$config['contact_city'] = '" . $config['contact_city'] . "';\n\n";
	
	$content .= "\$config['contact_county'] = '" . $config['contact_county'] . "';\n\n";
	
	$content .= "\$config['contact_country'] = '" . $config['contact_country'] . "';\n\n";
	
	$content .= "\$config['contact_phone'] = '" . $config['contact_phone'] . "';\n\n";
	
	$content .= "\$config['contact_fax'] = '" . $config['contact_fax'] . "';\n\n";

	$content .= "\$config['contact_email'] = '" . $config['contact_email'] . "';\n\n";
	
	$content .= "\$config['map_latitude'] = '" . $config['map_latitude'] . "';\n\n";
	
	$content .= "\$config['map_longitude'] = '" . $config['map_longitude'] . "';\n\n";
	
	$content .= "?>";

    $content = "";
    $content .= "<?php if (__FILE__ == \$_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');\n\n";

    $content .= "\$config['contact_address'] = '" . $config['contact_address'] . "';\n\n";

    $content .= "\$config['contact_zip_code'] = '" . $config['contact_zip_code'] . "';\n\n";

    $content .= "\$config['contact_city'] = '" . $config['contact_city'] . "';\n\n";

    $content .= "\$config['contact_county'] = '" . $config['contact_county'] . "';\n\n";

    $content .= "\$config['contact_country'] = '" . $config['contact_country'] . "';\n\n";

    $content .= "\$config['contact_phone'] = '" . $config['contact_phone'] . "';\n\n";

    $content .= "\$config['contact_fax'] = '" . $config['contact_fax'] . "';\n\n";

    $content .= "\$config['contact_email'] = '" . $config['contact_email'] . "';\n\n";

    $content .= "\$config['map_latitude'] = '" . $config['map_latitude'] . "';\n\n";

    $content .= "\$config['map_longitude'] = '" . $config['map_longitude'] . "';\n\n";

    $content .= "?>";

    file_put_contents("../config/contact.php", $content, LOCK_EX);

    $content = "";
    $content .= "<?php if (__FILE__ == \$_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');\n\n";

    $content .= "\$config['upload_path'] = '" . DIR_APPLICATION . "uploads/';\n\n";

    $allowed_filetypes = '';

    foreach (cfg('upload', 'allowed_filetypes') as $value) {

            if (end(cfg('upload', 'allowed_filetypes')) === $value)
                $allowed_filetypes .= "'" . $value . "'";
            else
                $allowed_filetypes .= "'" . $value . "', ";

    }

    $content .= "\$config['allowed_filetypes'] = array(" . $allowed_filetypes . ");\n\n";

    $content .= "\$config['max_filesize'] = " . $config['max_filesize'] . ";\n\n";

    $content .= "\$config['max_width_thumbnail'] = " . $config['max_width_thumbnail'] . ";\n\n";

    $content .= "\$config['max_height_thumbnail'] = " . $config['max_height_thumbnail'] . ";\n\n";

    $content .= "\$config['max_width'] = " . $config['max_width'] . ";\n\n";

    $content .= "\$config['max_height'] = " . $config['max_height'] . ";\n\n";

    if (isset($config['crop_thumbnail']))
        $crop_thumbnail = 'true';
    else
        $crop_thumbnail = 'false';

    $content .= "\$config['crop_thumbnail'] = " . $crop_thumbnail . ";\n\n";

    $content .= "?>";

    file_put_contents("../config/upload.php", $content, LOCK_EX);

    $content = "";
    $content .= "<?php if (__FILE__ == \$_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');\n\n";

    $content .= "\$config['languages_path'] = '" . DIR_APPLICATION . "languages/';\n\n";

    $content .= "\$config['site_language'] = '" . $config['site_language'] . "';\n\n";

    $content .= "?>";

    file_put_contents("../config/language.php", $content, LOCK_EX);

    $content = "";
    $content .= "<?php if (__FILE__ == \$_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');\n\n";

    $content .= "\$config['site_url'] = '" . filter_var($config['site_url'], FILTER_SANITIZE_STRING) . "';\n\n";

    $content .= "\$config['absolute_path'] = '" . DIR_APPLICATION . "templates/';\n\n";

    $content .= "\$config['template_extension'] = '.tpl';\n\n";

    $content .= "?>";

    file_put_contents("../config/template.php", $content, LOCK_EX);

}
