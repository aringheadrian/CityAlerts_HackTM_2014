<?php 

namespace TreeWeb\libraries;

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');
/**
 * Language class
 */
class Language
{
    /**
	 * Config
	 *
	 * @access private
	 */
    private static $config;

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
	 * Error
	 *
	 * @access private
	 */
    private $error;

    /**
	 * Language
	 *
	 * @access public
	 */

    public $language;

    /**
	 * Constructor
	 *
	 * @access public
	 */

    public function __construct()
    {
        self::$config = config_load('language');

        $this->db = new Database();
        $this->session = new Session();
        $this->error = new Error();

        if ($_GET['lang'])
            $this->languageSession();
        if($this->session->get('lang'))
            $this->language = $this->session->get('lang');
        else
            $this->language = self::$config['site_language'];
    }

    /**
	 * Generates the session of the language
	 *
	 * @access private
	 */
    private function languageSession()
    {
        $this->session->set('lang', $_GET['lang']);
    }

    public function languageCode()
    {
        return $this->language;
    }

    public function languageUrl()
    {
       if($this->language == self::$config['site_language'])

        return '';
       else
        return $this->language.'/';
    }

    /*public function language_file() {

	$langFile = self::$config['languages_path'].'lang.'. $this->language . '.php';
    if (!file_exists($langFile)) {
        $this->error->setError('Language file could not be loaded.');
    } else
	    include $langFile;
    }*/
}
