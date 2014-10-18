<?php 

namespace TreeWeb\libraries;

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');

/** 
 * Integration class
 */ 
class Integration {

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
	 * Constructor
	 * 
	 * @access public 
	 */	  
	private $authentication;
	
	/**
	 * Enabled methods 
	 *
	 * @access public 
	 */	
	public $enabledMethods;
	
	/**
	 * Social networks 
	 *
	 * @access public 
	 */	
	public static $socialLogin = array(
		'twitter',
		'facebook',
		'google',
		'yahoo',
		'linkedin'
	);
    
	/**
	 * result
	 *
	 * @access private 
	 */	
	private $result;
	
	/**
	 * num
	 *
	 * @access private 
	 */	
	private $num;
	
	/**
	 * Constructor
	 * 
	 * @access public 
	 */	
	public function __construct() {
		
		self::$config = config_load('integration');
		
		$this->db = new Database();
		$this->session = new Session();
		$this->authentication = new Authentication();
		
		
		$this->enabledMethods = $this->findEnabledMethods();

		if (in_array('google', $this->enabledMethods) || in_array('yahoo', $this->enabledMethods) || in_array('facebook', $this->enabledMethods) || in_array('twitter', $this->enabledMethods) || in_array('linkedin', $this->enabledMethods)) {
			require( self::$config['hybridauth_path']."Hybrid/Auth.php" );
		}

		/** If the user is logged out, we'll treat them as a guest. */
		if (!$this->session->get('user_id')) {
			//$this->guestLogin();
			return false;
		}

		$this->retrieveInfo();

		/** User wants to unlink his account from a social method. */
		if ($_GET['unlink']) {
			$this->unlink($_GET['unlink']);
			$this->retrieveInfo();
		}

		if ($_GET['link']) {
			$this->link_account($_GET['link']);
			$this->retrieveInfo();
		}
		
	}
	
		/** Check if this method is already in linked or not. */
	public function isUsed($method) {

		return $this->result[$method];

	}

	private function retrieveInfo() {

		$this->num = $this->db->row_count("SELECT * FROM " . self::$config['table_social_accounts'] . " WHERE user_id = '" . $this->session->get('user_id') . "'");
		$this->result = $this->db->fetch_row_assoc("SELECT * FROM " . self::$config['table_social_accounts'] . " WHERE user_id = '" . $this->session->get('user_id') . "'");

	}

	private function findEnabledMethods() {

		$methods = array();

		foreach ( self::$socialLogin as $method )
			if ( self::$config[$method.'_enable'] )
				$methods[] = $method;

		return $methods;

	}

	public function link_account($link, $login = false) {

		/** Make sure we only allow specific social links. */
		if ( !in_array($link, self::$socialLogin) )
			return false;

		/** Check if user is already linked. */
		if ($this->result[$link]) {
			//parent::displayMessage(sprintf('<div class="alert alert-warning">' . _('Your account is already linked with %s!') . '</div>', ucwords($link)), false);
			return false;
		}

		/** See if the link was successful. */
		if ($this->session->get($link) ) {
			if (!$login) $this->connect($link);
			return false;
		}

		switch ($link) :

			case 'facebook' :
					header( 'Location: ' . $this->facebook_url() );
					exit();
				break;

			case 'twitter' :
					header( 'Location: ' . $this->twitter_url() );
					exit();
				break;
			case 'google' :
					header( 'Location: ' . $this->google_url() );
					exit();
			break;
            case 'yahoo' :
					header( 'Location: ' . $this->yahoo_url() );
					exit();
			break;
            case 'linkedin' :
					header( 'Location: ' . $this->linkedin_url() );
					exit();
			break;				
			default :
					$this->openid_url($link);
				break;

		endswitch;

	}

	private function connect($link) {

		if (!$this->session->get('user_id'))
			return false;
		
		

		if ($this->num < 1)
		{	$values = array(
				'user_id'       => $this->session->get('user_id'),
				$link           => $this->session->get($link)
			);
			$this->db->insert(self::$config['table_social_accounts'], $values);
		}	
		else
	    {	
     		$values = array(
				$link         => $this->session->get($link)
			);
			$where = array(
			  $link => $this->session->get('user_id')
		    );
			$this->db->where($where);
		    $this->db->update(self::$config['table_social_accounts'], $values);
        }
		//parent::displayMessage(sprintf('<div class="alert alert-success">%s</div>', _('Successfully linked with ' . ucwords($link))), false);

	}

	private function unlink($provider) {

		if ( !in_array($provider, self::$socialLogin) )
			return false;

		if ( empty($this->result[$provider]) ) {
			//parent::displayMessage(sprintf('<div class="alert alert-warning">' . _('You are not yet linked with %s') . '</div>', ucwords($provider)), false);
			return false;
		}
		
		$values = array(
		   $provider  => ''
		);
		$where = array(
		  $link   => $this->session->get('user_id')
		);
		$this->db->where($where);
		$this->db->update(self::$config['table_social_accounts'], $values);

		$this->session->delete($provider);

		//parent::displayMessage(sprintf('<div class="alert alert-success">' . _('Successfully unlinked from %s') . '</div>', ucwords($provider)), false);

	}

	public function twitter_url() {

		if ($this->session->get('twitter'))
			return false;
  
		 $config = array( 
			'base_url'  => self::$config['site_url'].'hybridauth/',  
			'providers' => array (
			'Twitter'   => array ( 
			'enabled'   => true,
			'keys'      => array ( 'key' => self::$config['twitter_key'], 'secret' => self::$config['twitter_secret'])
         )));
    
    $hybridauth = new Hybrid_Auth( $config );
    
    $adapter = $hybridauth->authenticate( "Twitter" );  
    
    $user_profile = $adapter->getUserProfile(); 

		if ($user_profile) :
		  try {
			$this->session->set('twitter', $user_profile->identifier);
			$this->session->set('twitter_email',$user_profile->email);
			$this->session->set('twitter_first_name',$user_profile->firstName);
			$this->session->set('twitter_last_name',$user_profile->lastName);
		  } catch (TwitterApiException $e) {
			error_log($e);
			$user_profile = null;
		  }

		endif;

		$params = array(
		  'redirect_uri' => self::$config['site_url'] . '?link=twitter'
		);
		return $user_profile ? '#' : $twitter->getLoginUrl($params);

	}
	
	public function google_url() {

		if ($this->session->get('google'))
			return false;
  
		 $config = array( 
			'base_url'  => self::$config['site_url'].'hybridauth/',  
			'providers' => array (
			'Google'   => array ( 
			'enabled'   => true,
			'keys'      => array ( 'id' => self::$config['google_id'], 'secret' => self::$config['google_secret'])
         )));
    
    $hybridauth = new Hybrid_Auth( $config );
    
    $adapter = $hybridauth->authenticate( "Google" );  
    
    $user_profile = $adapter->getUserProfile(); 

		if ($user_profile) :
		  try {
			$this->session->set('google', $user_profile->identifier);
			$this->session->set('google_email',$user_profile->email);
			$this->session->set('google_first_name',$user_profile->firstName);
			$this->session->set('google_last_name',$user_profile->lastName);
		  } catch (GoogleApiException $e) {
			error_log($e);
			$user_profile = null;
		  }

		endif;

		$params = array(
		  'redirect_uri' => self::$config['site_url'] . '?link=google'
		);
		return $user_profile ? '#' : $google->getLoginUrl($params);

	}
	
	public function facebook_url() {

		if ($this->session->get('facebook'))
			return false;
  
		 $config = array( 
			'base_url'  => self::$config['site_url'].'hybridauth/',  
			'providers' => array (
			'Facebook'   => array ( 
			'enabled'   => true,
			'keys'      => array ( 'id' => self::$config['facebook_id'], 'secret' => self::$config['facebook_secret'])
         )));
    
    $hybridauth = new Hybrid_Auth( $config );
    
    $adapter = $hybridauth->authenticate( "Facebook" );  
    
    $user_profile = $adapter->getUserProfile(); 

		if ($user_profile) :
		  try {
			$this->session->set('facebook', $user_profile->identifier);
			$this->session->set('facebook_email',$user_profile->email);
			$this->session->set('facebook_first_name',$user_profile->firstName);
			$this->session->set('facebook_last_name',$user_profile->lastName);
		  } catch (GoogleApiException $e) {
			error_log($e);
			$user_profile = null;
		  }

		endif;

		$params = array(
		  'redirect_uri' => self::$config['site_url'] . '?link=facebook'
		);
		return $user_profile ? '#' : $facebook->getLoginUrl($params);

	}
	
	public function yahoo_url() {

		if ($this->session->get('yahoo'))
			return false;
  
		 $config = array( 
			'base_url'  => self::$config['site_url'].'hybridauth/',  
			'providers' => array (
			'Yahoo'   => array ( 
			'enabled'   => true,
			'keys'      => array ( 'key' => self::$config['yahoo_key'], 'secret' => self::$config['yahoo_secret'])
         )));
    
    $hybridauth = new Hybrid_Auth( $config );
    
    $adapter = $hybridauth->authenticate( "Yahoo" );  
    
    $user_profile = $adapter->getUserProfile(); 

		if ($user_profile) :
		  try {
			$this->session->set('yahoo', $user_profile->identifier);
			$this->session->set('yahoo_email',$user_profile->email);
			$this->session->set('yahoo_first_name',$user_profile->firstName);
			$this->session->set('yahoo_last_name',$user_profile->lastName);
		  } catch (GoogleApiException $e) {
			error_log($e);
			$user_profile = null;
		  }

		endif;

		$params = array(
		  'redirect_uri' => self::$config['site_url'] . '?link=yahoo'
		);
		return $user_profile ? '#' : $yahoo->getLoginUrl($params);

	}
	
	public function linkedin_url() {

		if ($this->session->get('linkedin'))
			return false;
  
		 $config = array( 
			'base_url'  => self::$config['site_url'].'hybridauth/',  
			'providers' => array (
			'LinkedIn'   => array ( 
			'enabled'   => true,
			'keys'      => array ( 'key' => self::$config['linkedin_key'], 'secret' => self::$config['linkedin_secret'])
         )));
    
    $hybridauth = new Hybrid_Auth( $config );
    
    $adapter = $hybridauth->authenticate( "LinkedIn" );  
    
    $user_profile = $adapter->getUserProfile(); 

		if ($user_profile) :
		  try {
			$this->session->set('linkedin', $user_profile->identifier);
			$this->session->set('linkedin_email',$user_profile->email);
			$this->session->set('linkedin_first_name',$user_profile->firstName);
			$this->session->set('linkedin_last_name',$user_profile->lastName);
		  } catch (GoogleApiException $e) {
			error_log($e);
			$user_profile = null;
		  }

		endif;

		$params = array(
		  'redirect_uri' => self::$config['site_url'] . '?link=linkedin'
		);
		return $user_profile ? '#' : $linkedin->getLoginUrl($params);

	}
		
}

?>
