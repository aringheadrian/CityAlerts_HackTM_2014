<?php
/**
* HybridAuth
* http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
* (c) 2009-2014, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
*/

// ----------------------------------------------------------------------------------------
//	HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------

return 
	array(
		"base_url" => "http://localhost/hybridauth-git/hybridauth/", 

		"providers" => array ( 
			// openid providers
			"OpenID" => array (
				"enabled" => true
			),

			"Yahoo" => array ( 
				"enabled" => true,
				"keys"    => array ( "key" => "dj0yJmk9OUE0VXNnUW9BOVVTJmQ9WVdrOWNtWTJSa05FTm0wbWNHbzlNQS0tJnM9Y29uc3VtZXJzZWNyZXQmeD03Mg--", "secret" => "8ceb50134afee424bb8b6ff9325c2006a9f19874" ),
			),

			"AOL"  => array ( 
				"enabled" => true 
			),

			"Google" => array ( 
				"enabled" => true,
				"keys"    => array ( "id" => "1098506107643-uk1ogmba8vjfea2lnlac1323r7627q7a.apps.googleusercontent.com", "secret" => "SUPUfJtSwZ8dNECR3czhFvxv" ), 
			),

			"Facebook" => array ( 
				"enabled" => true,
				"keys"    => array ( "id" => "794310247279052", "secret" => "adc19443139d246943760409b98f67c1" ),
				"trustForwarded" => false
			),

			"Twitter" => array ( 
				"enabled" => true,
				"keys"    => array ( "key" => "TiypcmGGDWi2bpA9aGo0tOUNL", "secret" => "Wv485Ktpbjdexato62zMRXkLiBC2u0T0GExvS8nQihlyRQw49a" ) 
			),

			// windows live
			"Live" => array ( 
				"enabled" => true,
				"keys"    => array ( "id" => "", "secret" => "" ) 
			),

			"LinkedIn" => array ( 
				"enabled" => true,
				"keys"    => array ( "key" => "8ceb50134afee424bb8b6ff9325c2006a9f198748ceb50134afee424bb8b6ff9325c2006a9f19874", "secret" => "CPpvVOEUdbNoIzWN" ) 
			),

			"Foursquare" => array (
				"enabled" => true,
				"keys"    => array ( "id" => "", "secret" => "" ) 
			),
		),

		// if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
		"debug_mode" => false,

		"debug_file" => "",
	);