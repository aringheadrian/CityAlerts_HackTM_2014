<?php 

namespace TreeWeb\libraries;

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');

/**
 * Authentication class
 */
class Authentication
{
    /**
	 * Config
	 *
	 * @access private
	 */
    private static $config;

    /**
	 * Social
	 *
	 * @access private
	 */
    private static $social;

    /**
	 * Database
	 *
	 * @access private
	 */
    private $db;

    /**
	 * Session
	 *
	 * @access private
	 */
    private $session;

    /**
	 * Constructor
	 *
	 * @access public
	 */
    public function __construct()
    {
        self::$config = config_load('authentication');
        self::$social = config_load('integration');

        $this->db = new Database();
        $this->session = new Session();

        $this->autoLogin();
        $this->deleteInactiveUsers();

    }

    /**
	 * Create user
	 *
	 * @access public
	 */
    public function createUser($email, $password, $additional_data = null, $parameters = null)
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $password = filter_var($password, FILTER_SANITIZE_STRING);

        $values = array(
                'user_email'    => $email,
                'user_password' => sha1($password),
                'user_created'    => date('Y-m-d H:i:s'),
                'group_id'        => self::$config['default_group']
        );

        if (isset($parameters)) {

            if (isset($parameters['user_status']))
                $values['user_status'] = $parameters['user_status'];

            $values['user_approved'] = 1;

            if (isset($parameters['group_id']))
                $values['group_id'] = $parameters['group_id'];

        } else {

            if (self::$config['email_activation'] && !self::$config['approve_registration']) {

                $code = sha1(md5(microtime()));
                $values['user_status'] = 0;
                $values['user_approved'] = 1;
                $values['activation_code'] = $code;

            } elseif (!self::$config['email_activation'] && self::$config['approve_registration']) {

                $values['user_status'] = 0;
                $values['user_approved'] = 0;

            } else {

                $values['user_status'] = 1;
                $values['user_approved'] = 1;

            }

        }

        $this->db->insert(self::$config['table_users'], $values);

        $user_id = $this->db->lastInsertId();

        if ($additional_data) {

            $additional_data['user_id'] = $user_id;

            $this->db->insert(self::$config['table_profiles'], $additional_data);

            $where = array(
                'profile_id' => $this->db->lastInsertId()
            );

            $this->db->where($where);
            $this->db->update(self::$config['table_profiles'], array('user_id' => $user_id));

        }

        if (isset($parameters)) {

            if (isset($parameters['send_email'])) {

                $headers  = 'From: ' . self::$config['site_title'] . '<' . self::$config['admin_email'] . '>' . "\r\n";
                $headers .=    'Reply-To: ' . self::$config['admin_email'] . "\r\n";
                $headers .=    'X-Mailer: PHP/' . phpversion();
                $headers .= 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

                $message = file_get_contents(self::$config['absolute_path'] . 'templates/mail/welcome.tpl');
                $message = str_replace('%%FIRST_NAME%%', $additional_data['first_name'], $message);
                $message = str_replace('%%LAST_NAME%%', $additional_data['last_name'], $message);
                $message = str_replace('%%EMAIL%%', $email, $message);
                $message = str_replace('%%SITE_TITLE%%', self::$config['site_title'], $message);
                $message = str_replace('%%SITE_URL%%', self::$config['site_url'], $message);

                mail($email, self::$config['email_subject_1'], $message, $headers);

            }

        } else {

            if (self::$config['email_activation'] && !self::$config['approve_registration']) {

                $headers  = 'From: ' . self::$config['site_title'] . '<contact@xtendradio.ro>' . "\r\n";
                $headers .=    'Reply-To: ' . self::$config['admin_email'] . "\r\n";
                $headers .=    'X-Mailer: PHP/' . phpversion();
                $headers .= 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

                $message = file_get_contents(self::$config['absolute_path'] . 'templates/mail/activate.tpl');
                $message = str_replace('%%FIRST_NAME%%', $additional_data['first_name'], $message);
                $message = str_replace('%%LAST_NAME%%', $additional_data['last_name'], $message);
                $message = str_replace('%%EMAIL%%', $email, $message);
                $message = str_replace('%%CODE%%', $code, $message);
                $message = str_replace('%%SITE_TITLE%%', self::$config['site_title'], $message);
                $message = str_replace('%%SITE_URL%%', self::$config['site_url'], $message);

                mail($email, self::$config['email_subject_1'], $message, $headers);

            } elseif (!self::$config['email_activation'] && self::$config['approve_registration']) {

                $headers  = 'From: ' . self::$config['site_title'] . '<' . self::$config['admin_email'] . '>' . "\r\n";
                $headers .=    'Reply-To: ' . self::$config['admin_email'] . "\r\n";
                $headers .=    'X-Mailer: PHP/' . phpversion();
                $headers .= 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

                $message = file_get_contents(self::$config['absolute_path'] . 'templates/mail/approval.tpl');
                $message = str_replace('%%FIRST_NAME%%', $additional_data['first_name'], $message);
                $message = str_replace('%%LAST_NAME%%', $additional_data['last_name'], $message);
                $message = str_replace('%%SITE_TITLE%%', self::$config['site_title'], $message);
                $message = str_replace('%%SITE_URL%%', self::$config['site_url'], $message);

                mail($email, self::$config['email_subject_1'], $message, $headers);

                $message = file_get_contents(self::$config['absolute_path'] . 'templates/mail/approve_user.tpl');
                $message = str_replace('%%FIRST_NAME%%', $additional_data['first_name'], $message);
                $message = str_replace('%%LAST_NAME%%', $additional_data['last_name'], $message);
                $message = str_replace('%%EMAIL%%', $email, $message);
                $message = str_replace('%%SITE_TITLE%%', self::$config['site_title'], $message);
                $message = str_replace('%%SITE_URL%%', self::$config['site_url'], $message);

                mail(self::$config['admin_email'], self::$config['email_subject_3'], $message, $headers);

            } else {

                $headers  = 'From: ' . self::$config['site_title'] . '<' . self::$config['admin_email'] . '>' . "\r\n";
                $headers .=    'Reply-To: ' . self::$config['admin_email'] . "\r\n";
                $headers .=    'X-Mailer: PHP/' . phpversion();
                $headers .= 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

                $message = file_get_contents(self::$config['absolute_path'] . 'templates/mail/welcome.tpl');
                $message = str_replace('%%FIRST_NAME%%', $additional_data['first_name'], $message);
                $message = str_replace('%%LAST_NAME%%', $additional_data['last_name'], $message);
                $message = str_replace('%%EMAIL%%', $email, $message);
                $message = str_replace('%%SITE_TITLE%%', self::$config['site_title'], $message);
                $message = str_replace('%%SITE_URL%%', self::$config['site_url'], $message);

                mail($email, self::$config['email_subject_1'], $message, $headers);

            }
        }

    }

    /**
	 * Update user
	 *
	 * @access public
	 */
    public function updateUser($user_id, $email, $password = false, $additional_data = null, $parameters = null)
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $password = filter_var($password, FILTER_SANITIZE_STRING);

        $values = array(
            'user_email' => $email
        );

        if ($password)
            $values['user_password'] = sha1($password);

        if (isset($parameters)) {

            if (isset($parameters['user_status'])) {

                $values['user_status'] = $parameters['user_status'];
                $values['user_approved'] = $parameters['user_status'];

            }

            if (isset($parameters['group_id']))
                $values['group_id'] = $parameters['group_id'];

        }

        $where = array(
            'user_id' => $user_id
        );

        $this->db->where($where);
        $this->db->update(self::$config['table_users'], $values);

        if (isset($additional_data)) {

            $where = array(
                'user_id' => $user_id
            );

            $this->db->where($where);
            $this->db->update(self::$config['table_profiles'], $additional_data);

        }

    }

    /**
	 * Delete user
	 *
	 * @access public
	 */
    public function deleteUser($user_id)
    {
        $where = array(
            'user_id' => $user_id
        );

        $this->db->where($where);
        $this->db->delete(self::$config['table_users']);
        $this->db->delete(self::$config['table_profiles']);

    }

    /**
	 * Delete inactive users
	 *
	 * @access private
	 */
    private function deleteInactiveUsers()
    {
        foreach ($this->db->query("SELECT * FROM " . self::$config['table_users'] . " WHERE user_status = 0 AND activation_code != '' AND user_created < '" . time() . "' - '" . self::$config['email_activation_expire'] . "'") as $row) {

            $where = array(
                'user_id' => $row['user_id']
            );

            $this->db->where($where);
            $this->db->delete(self::$config['table_users']);

        }

    }

    /**
	 * Get user
	 *
	 * @access public
	 */
    public function getUser($user_id)
    {
        foreach ($this->db->query("SELECT * FROM " . self::$config['table_users'] . " users, " . self::$config['table_profiles'] . " profiles WHERE users.user_id = '" . $user_id . "' AND profiles.user_id = '" . $user_id . "'") as $row) {

            $user = array(
                'user_id'        => $row['user_id'],
                'group_id'        => $row['group_id'],
                'first_name'    => $row['first_name'],
                'last_name'        => $row['last_name'],
                'avatar'        => $row['avatar'],
                'user_email'    => $row['user_email'],
                'user_status'    => $row['user_status']
            );

        }

        return $user;

    }

    /**
	 * Get active users
	 *
	 * @access public
	 */
    public function getActiveUsers()
    {
        foreach ($this->db->query("SELECT * FROM " . self::$config['table_users'] . " users, " . self::$config['table_profiles'] . " profiles WHERE profiles.user_id = users.user_id AND users.user_status = 1") as $row) {

            $users[] = array(
                'user_id'        => $row['user_id'],
                'first_name'    => $row['first_name'],
                'last_name'        => $row['last_name'],
                'user_email'    => $row['user_email']
            );

        }

        if (isset($users))
            return $users;

    }

    /**
	 * Get inactive users
	 *
	 * @access public
	 */
    public function getInactiveUsers()
    {
        foreach ($this->db->query("SELECT * FROM " . self::$config['table_users'] . " users, " . self::$config['table_profiles'] . " profiles WHERE profiles.user_id = users.user_id AND users.user_status = '0'") as $row) {

            $users[] = array(
                'user_id'        => $row['user_id'],
                'first_name'    => $row['first_name'],
                'last_name'        => $row['last_name'],
                'user_email'    => $row['user_email']
            );

        }

        if (isset($users))
            return $users;

    }

    /**
	 * Get newest users
	 *
	 * @access public
	 */
    public function getNewestUsers($limit = 10)
    {
        foreach ($this->db->query("SELECT * FROM " . self::$config['table_users'] . " users, " . self::$config['table_profiles'] . " profiles WHERE profiles.user_id = users.user_id AND users.user_status = 1 ORDER BY user_created DESC LIMIT " . $limit . "") as $row) {

            $users[] = array(
                'user_id'        => $row['user_id'],
                'first_name'    => $row['first_name'],
                'last_name'        => $row['last_name'],
                'user_email'    => $row['user_email'],
                'user_status'    => $row['user_status'],
                'last_login'    => $row['last_login']
            );

        }

        if (isset($users))
            return $users;

    }

    /**
	 * Activate user
	 *
	 * @access public
	 */
    public function activateUser($email, $code)
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $code = filter_var($code, FILTER_SANITIZE_STRING);

        if ($this->db->rowCount("SELECT activation_code FROM " . self::$config['table_users'] ." WHERE user_email = '" . $email . "' AND activation_code = '" . $code . "'")) {

            $values = array(
                'activation_code'    => '',
                'user_status'        => 1,
                'user_approved'    => 1
            );

            $where = array(
                'user_email' => $email
            );

            $this->db->where($where);
            $this->db->update(self::$config['table_users'], $values);

            return true;

        } else {
            return false;

        }

    }

    /**
	 * Token
	 *
	 * @access private
	 */
    private function token()
    {
        return md5(self::$config['secret_word'] . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);

    }

    /**
	 * Login
	 *
	 * @access public
	 */
    public function login($email, $password, $remember = false)
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $password = filter_var($password, FILTER_SANITIZE_STRING);

        $sql = "SELECT * FROM " . self::$config['table_users'] . " u, " . self::$config['table_profiles'] . " p WHERE u.user_email = '" . $email . "' AND u.user_password = '" . sha1($password) . "' AND u.user_status = 1 AND u.user_approved = 1 AND p.user_id = u.user_id";

        if ($this->db->rowCount($sql)) {

            session_regenerate_id(true);
            $this->session->set('token', $this->token());
            $this->session->set('logged_in', true);

            $result = $this->db->fetchRowAssoc($sql);
            $this->session->set('user_id', $result['user_id']);
            $this->session->set('group_id', $result['group_id']);
            $this->session->set('user_email', $result['user_email']);
            $this->session->set('user_status', $result['user_status']);
            $this->session->set('last_login', $result['last_login']);
            $this->session->set('last_ip', $result['last_ip']);
            $this->session->set('first_name', $result['first_name']);
            $this->session->set('last_name', $result['last_name']);
            $this->session->set('avatar', $result['avatar']);
            $this->session->set('user_level', $result['user_level']);
            $this->session->set('user_access', $result['user_acces']);

            $where = array(
                'user_id' => $result['user_id']
            );

            $this->db->where($where);
            $this->db->update(self::$config['table_users'], array('last_login' => time(), 'last_ip' => $_SERVER['REMOTE_ADDR']));

            $group_row = $this->db->fetchRowAssoc("SELECT group_name FROM " . self::$config['table_groups'] . " WHERE group_id = '" . $result['group_id'] . "'");
            $this->session->set('group_name', $group_row['group_name']);

            if ($remember)
                $this->remeberUser($result['user_id'], $email, $password);

            return true;

        } else {
            return false;

        }

    }

    /**
	 * Login
	 *
	 * @access public
	 */
    public function socialLogin($provider, $provider_id)
    {
        $provider = filter_var($provider, FILTER_SANITIZE_EMAIL);
        $provider_id = filter_var($provider_id, FILTER_SANITIZE_STRING);

        $sql = "SELECT * FROM " . self::$config['table_users'] . " u, " . self::$config['table_profiles'] . " p, ".  self::$social['table_social_accounts'] . " s WHERE " . $provider . " = '" . $provider_id . "' AND u.user_status = 1 AND u.user_approved = 1 AND p.user_id = u.user_id AND u.user_id = s.user_id";

        if ($this->db->rowCount($sql)) {

            session_regenerate_id(true);
            $this->session->set('token', $this->token());
            $this->session->set('logged_in', true);

            $result = $this->db->fetchRowAssoc($sql);
            $this->session->set('user_id', $result['user_id']);
            $this->session->set('group_id', $result['group_id']);
            $this->session->set('user_email', $result['user_email']);
            $this->session->set('user_status', $result['user_status']);
            $this->session->set('last_login', $result['last_login']);
            $this->session->set('last_ip', $result['last_ip']);
            $this->session->set('first_name', $result['first_name']);
            $this->session->set('last_name', $result['last_name']);
            $this->session->set('avatar', $result['avatar']);
            $this->session->set('user_level', $result['user_level']);
            $this->session->set('user_access', $result['user_acces']);

            $where = array(
                'user_id' => $result['user_id']
            );

            $this->db->where($where);
            $this->db->update(self::$config['table_users'], array('last_login' => date('Y-m-d H:i:s'), 'last_ip' => $_SERVER['REMOTE_ADDR']));

            $group_row = $this->db->fetchRowAssoc("SELECT group_name FROM " . self::$config['table_groups'] . " WHERE group_id = '" . $result['group_id'] . "'");
            $this->session->set('group_name', $group_row['group_name']);

            return true;

        } else {
            return false;

        }

    }

    /**
	 * Remember user
	 *
	 * @access public
	 */
    public function remeberUser($user_id, $email, $password)
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $password = filter_var($password, FILTER_SANITIZE_STRING);

        $key = $email . $password;

        $where = array(
            'user_id' => $user_id
        );

        $this->db->where($where);
        $this->db->update(self::$config['table_users'], array('remember_code' => sha1($key)));

        setcookie('remember_code', sha1($key), time() + self::$config['user_expire']);

    }

    /**
	 * Logged in
	 *
	 * @access public
	 */
    public function loggedIn()
    {
        if ($this->session->get('logged_in') && $this->session->get('token') == $this->token()) {
            return true;

        }

        return false;

    }

    /**
	 * Auto login
	 *
	 * @access public
	 */
    public function autoLogin()
    {
        if (!$this->loggedIn() and !$this->loggedIn(false)) {

            if (isset($_COOKIE['remember_code'])) {

                $sql = "SELECT * FROM " . self::$config['table_users'] . " u, " . self::$config['table_profiles'] . " p WHERE u.remember_code = '" . $_COOKIE['remember_code'] . "' AND p.user_id = u.user_id";

                if ($this->db->rowCount($sql)) {

                    session_regenerate_id(true);
                    $this->session->set('token', $this->token());
                    $this->session->set('logged_in', true);

                    $result = $this->db->fetchRowAssoc($sql);
                    $this->session->set('user_id', $result['user_id']);
                    $this->session->set('group_id', $result['group_id']);
                    $this->session->set('user_email', $result['user_email']);
                    $this->session->set('user_status', $result['user_status']);
                    $this->session->set('last_login', $result['last_login']);
                    $this->session->set('last_ip', $result['last_ip']);
                    $this->session->set('first_name', $result['first_name']);
                    $this->session->set('last_name', $result['last_name']);
                    $this->session->set('avatar', $result['avatar']);

                    $group_row = $this->db->fetchRowAssoc("SELECT group_name FROM " . self::$config['table_groups'] . " WHERE group_id = '" . $result['group_id'] . "'");
                    $this->session->set('group_name', $group_row['group_name']);

                }

            }

        }

        return false;

    }

    /**
	 * Logout
	 *
	 * @access public
	 */
    public function logout()
    {
        $this->session->destroy();
        unset($_COOKIE['remember_code']);
        setcookie('remember_code', '', time() - 1);

    }

    /**
	 * New password
	 *
	 * @access public
	 */
    public function newPassword($email)
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if ($this->db->rowCount("SELECT user_email FROM " . self::$config['table_users'] ." WHERE user_email = '" . $email . "'")) {

            $password = substr(md5(uniqid(rand())), 0, 8);

            $where = array(
                'user_email' => $email
            );

            $this->db->where($where);
            $this->db->update(self::$config['table_users'], array('user_password' => sha1($password)));

            $headers  = 'From: ' . self::$config['site_title'] . '<' . self::$config['admin_email'] . '>' . "\r\n";
            $headers .=    'Reply-To: ' . self::$config['admin_email'] . "\r\n";
            $headers .=    'X-Mailer: PHP/' . phpversion();
            $headers .= 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

            $message = file_get_contents(self::$config['absolute_path'] . 'templates/mail/newPassword.tpl');
            $message = str_replace('%%PASSWORD%%', $password, $message);
            $message = str_replace('%%SITE_TITLE%%', self::$config['site_title'], $message);
            $message = str_replace('%%SITE_URL%%', self::$config['site_url'], $message);

            mail($email, self::$config['email_subject_2'], $message, $headers);

            return true;

        } else {
            return false;

        }

    }

    /**
	 * Is admin
	 *
	 * @access public
	 */
    public function isAdmin()
    {
        if ($this->session->get('group_id')) {

            if (self::$config['admin_group'] == $this->session->get('group_id'))
                return true;

        }

        return false;

    }

    /**
	 * Is group
	 *
	 * @access public
	 */
    public function isGroup($group)
    {
        if (is_array($group)) {
            return in_array($this->session->get('group_name'), $group);

        }

        return $this->session->get('group_name') == $group;

    }

    /**
	 * Check email
	 *
	 * @access public
	 */
    public function checkEmail($email)
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if ($this->db->rowCount("SELECT user_email FROM " . self::$config['table_users'] . " WHERE user_email = '" . $email . "'")) {
            return false;

        } else {
            return true;

        }

    }

    /**
	 * Add group
	 *
	 * @access public
	 */
    public function addGroup($name, $description)
    {
        $values = array(
                'group_name'        => $name,
                'group_description'    => $description
        );

        $this->db->insert(self::$config['table_groups'], $values);

    }

    /**
	 * Update group
	 *
	 * @access public
	 */
    public function updateGroup($group_id, $name, $description)
    {
        $values = array(
            'group_id'            => $group_id,
            'group_name'        => $name,
            'group_description' => $description
        );

        $where = array(
            'group_id' => $group_id
        );

        $this->db->where($where);
        $this->db->update(self::$config['table_groups'], $values);

    }

    /**
	 * Delete group
	 *
	 * @access public
	 */
    public function deleteGroup($group_id)
    {
        $where = array(
            'group_id' => $group_id
        );

        $this->db->where($where);
        $this->db->delete(self::$config['table_groups']);

    }

    /**
	 * Get group
	 *
	 * @access public
	 */
    public function getGroup($group_id)
    {
        foreach ($this->db->query("SELECT * FROM " . self::$config['table_groups'] . " WHERE group_id = '" . $group_id . "'") as $row) {

            $group = array(
                'group_id'            => $row['group_id'],
                'group_name'        => $row['group_name'],
                'group_description' => $row['group_description']
            );

        }

        return $group;

    }

    /**
	 * Get groups
	 *
	 * @access public
	 */
    public function getGroups()
    {
        foreach ($this->db->query("SELECT * FROM " . self::$config['table_groups'] . "") as $row) {

            $groups[] = array(
                'group_id'            => $row['group_id'],
                'group_name'        => $row['group_name'],
                'group_description'    => $row['group_description']
            );

        }

        if (isset($groups))
            return $groups;

    }

}
