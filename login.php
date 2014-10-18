<?php 
    
	//Include the common file
    require_once('common.php');
	
	// change the following paths if necessary 
	//$config = config_item('integration', 'hybridauth_path').'config.php';
	//require_once(config_item('integration', 'hybridauth_path').'Hybrid/Auth.php' );

	// check for erros and whatnot
	$error = "";
	
	if( isset( $_GET["error"] ) ){
		$error = '<b style="color:red">' . trim( strip_tags(  $_GET["error"] ) ) . '</b><br /><br />';
	}

	// if user select a provider to login with
		// then inlcude hybridauth config and main class
		// then try to authenticate te current user
		// finally redirect him to his profile page
	if( isset( $_GET["provider"] ) && $_GET["provider"] ):
		
	$providers = array(
		  'facebook' => 'id',
		  'google' => 'id',
		  'twitter' => 'key',
		  'yahoo' => 'key',
		  'linkedin' => 'key'
		  );
	  
	  $config = array( 
		'base_url'  => config_item('base', 'site_url').'hybridauth/',  
		'providers' => array (
		    ucfirst($_GET['provider'])   => array ( 
			'enabled'   => config_item('integration', 'facebook_enabled'),
			'keys'      => array ( $providers[$_GET['provider']] => config_item('integration', $_GET['provider'].'_'.$providers[$_GET['provider']]), 'secret' => config_item('integration', $_GET['provider'].'_secret'))
         )));
    
        require_once(config_item('integration', 'hybridauth_path').'Hybrid/Auth.php' );
		
		try{
			// create an instance for Hybridauth with the configuration file path as parameter
			$hybridauth = new Hybrid_Auth( $config );
 
			// logout the user from $provider
		    //$hybridauth->logoutAllProviders(); 
			
			// set selected provider name 
			$provider = @ trim( strip_tags( $_GET["provider"] ) );

			// try to authenticate the selected $provider
			$adapter = $hybridauth->authenticate( $provider );
			$user_profile = $adapter->getUserProfile(); 
            $session->set('provider',$_GET["provider"]);
			$session->set('provider_id',$user_profile->identifier);
			$session->set('provider_email',$user_profile->email);
			$session->set('provider_first_name',$user_profile->firstName);
			$session->set('provider_last_name',$user_profile->lastName);
			// if okey, we will redirect to user profile page 
			
				$user_count = $db->row_count("SELECT user_id FROM " . config_item('integration', 'table_social_accounts') . " WHERE " . $session->get('provider')." = '" . $session->get('provider_id') . "'");
				if($user_count > 0)
				{
				 $user_id = $db->fetch_row_assoc("SELECT user_id FROM " . config_item('integration', 'table_social_accounts') . " WHERE " . $session->get('provider')." = '" . $session->get('provider_id') . "'");
				 $authentication->social_login($session->get('provider'),$session->get('provider_id'));
				 $hybridauth->redirect( config_item('base', 'site_url'));
				}
				else
				{ 
				 if($session->get('user_id')&& $_GET['user'] == $session->get('user_id')){
						$count = $db->row_count("SELECT user_id FROM " . config_item('integration', 'table_social_accounts') . " WHERE user_id = '" . $session->get('user_id') . "'");
						if($count > 0)
						{	$values = array(
								 $session->get('provider')      => $session->get('provider_id')
							); 			
						
							$where = array(
							'user_id' => $session->get('user_id')
							);
							
							$db->where($where);
							$db->update(config_item('integration', 'table_social_accounts'), $values);
						} 
						else
						{	$values = array(
								'user_id'                       => $session->get('user_id'),
								 $session->get('provider')      => $session->get('provider_id')

							); 			
						
							$db->insert(config_item('integration', 'table_social_accounts'), $values); 
						}	 
					}
				 $hybridauth->redirect( config_item('base', 'site_url'));
			    }
		}
		catch( Exception $e ){
			// In case we have errors 6 or 7, then we have to use Hybrid_Provider_Adapter::logout() to 
			// let hybridauth forget all about the user so we can try to authenticate again.

			// Display the recived error, 
			// to know more please refer to Exceptions handling section on the userguide
			switch( $e->getCode() ){ 
				case 0 : $error = "Unspecified error."; break;
				case 1 : $error = "Hybriauth configuration error."; break;
				case 2 : $error = "Provider not properly configured."; break;
				case 3 : $error = "Unknown or disabled provider."; break;
				case 4 : $error = "Missing provider application credentials."; break;
				case 5 : $error = "Authentication failed. The user has canceled the authentication or the provider refused the connection."; break;
				case 6 : $error = "User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again."; 
					     $adapter->logout(); 
					     break;
				case 7 : $error = "User not connected to the provider."; 
					     $adapter->logout(); 
					     break;
			} 

			// well, basically your should not display this to the end user, just give him a hint and move on..
			$error .= "<br /><br /><b>Original error message:</b> " . $e->getMessage(); 
			$error .= "<hr /><pre>Trace:<br />" . $e->getTraceAsString() . "</pre>";
		}
    endif;
?>


<?php
	// if we got an error then we display it here
	if( $error ){
		echo '<p><h3 style="color:red">Error!</h3>' . $error . '</p>';
		echo "<pre>Session:<br />" . print_r( $_SESSION, true ) . "</pre><hr />";
	}
?>
<?php 
	// try to get already authenticated provider list
	try{
		$hybridauth = new Hybrid_Auth( $config );

		$connected_adapters_list = $hybridauth->getConnectedProviders(); 

		if( count( $connected_adapters_list ) ){
?> 
<?php
		}
	}
	catch( Exception $e ){
		echo "Ooophs, we got an error: " . $e->getMessage();

		echo " Error code: " . $e->getCode();

		echo "<br /><br />Please try again.";

		echo "<hr /><h3>Trace</h3> <pre>" . $e->getTraceAsString() . "</pre>"; 
	}
?> 
