<?php 	
	//sitewide error reporting
	error_reporting(0);
    ini_set('display_errors', 'off');
		
	//Get User IP and location of user
		$client_ip = getenv('HTTP_CLIENT_IP')?:
		getenv('HTTP_X_FORWARDED_FOR')?:
		getenv('HTTP_X_FORWARDED')?:
		getenv('HTTP_FORWARDED_FOR')?:
		getenv('HTTP_FORWARDED')?:
		getenv('REMOTE_ADDR');
	
	//URL Parameters for basic url and canonical links
		$request = parse_url($_SERVER['REQUEST_URI']);
		$path = $request["path"];	
		preg_match("/[^\/]+$/", $path, $matches);
		//$plink = $matches[0]; 
	
		$urlmain = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$urlp = parse_url($urlmain);
		$url = $urlp['host'];
		
	
	//get base url and load files appropriately based on host(local or remote)
		if(
			( $_SERVER['REMOTE_ADDR'] == '::1' ) || ( $_SERVER['REMOTE_ADDR'] == '127.0.0.1' )
		){ 		
			$baseurl = 'http://localhost/komecare';			
		}  else {			
			$baseurl = getenv('APP_URL');
		}
	//main url for SEO configurations
	$main_url = getenv('APP_URL');
    $sweet_url = getenv('APP_DOMAIN');
    $noreply_password = getenv('MAIL_PASSWORD');
	//main website configuration settings
		$settings = (object) array(
			'active' => 'active',
			'siteTitle' => 'Kome Care',
			'siteTagline' => 'Kome Care - Health and Social Care',
			'siteDescription' => 'We are a service provider of home care and staffing services. Kome Care is committed to providing quality and cost effective medical staffing solutions; in terms of enhancing the quality of life in professional manner for all our service users.',
			'phoneNumber' => '',
			'address' => '',
			'email' => 'info@komerec.com',
			'email2' => 'career@komerec.com',
			'email3' => 'support@komerec.com',
			'email4' => 'sales@komerec.com',
			'facebook' => 'https://www.facebook.com/',
			'twitter' => 'javascript:void()',
			'whatsapp' => 'https://wa.me/',
			'linkedin' => 'javascript:void()',
			'themeColor' => '#f58637',
			'siteLogo' => 'assets/img/logo/logo.png',
			'liteLogo' => 'assets/img/logo/logo-light.png',
			'googleMapAPI' => '',
			'toolbox' => false,
			'toolboxMain' => false,
			'preLoader' => true,
			'siteSearch' => true,
			'homeSlider' => true,
			'pageBanner' => true,
			'homeTestimonials' => false,
			'sideNav' => false,
			'breadCrumbs' => true,
			'copyRight' => true,
			'footerSocials' => true,
			'topBar' => true,
			'toTop' => true,
			'og_locale' => 'en_US'
		);
		
		$time = date('h:i:s A');
		$date = date('jS M, Y');
		$year = date('Y');
		
		//$page_types = array('Home', 'About Us', 'About', 'How It Works', 'Contact Us', 'Contacts', 'Get Listed');
	
	//Configure and display error messages
	GLOBAL $errors;
	GLOBAL $successes;
	function resultBlock($errors,$successes){
		//Error block
		if(count($errors) > 0)
		{
			echo "<div class='alert alert-danger'>
			<button aria-hidden='true' data-dismiss='alert' class='close' type='button'><i class='fa fa-close'></i></button>
			";
			foreach($errors as $error)
			{
				echo "<p><i class='icon-exclamation-sign' style='margin-right:7px'></i>".$error."</p>";
			}
			
			echo "</div>";
		}
		//Success block
		if(count($successes) > 0)
		{
			echo "<div class='alert alert-success'>
			<button aria-hidden='true' data-dismiss='alert' class='close' type='button'><i class='fa fa-close'></i></button>
			";
			foreach($successes as $success)
			{
				echo "<p><i class='icon-checkmark' style='margin-right:7px'></i>".$success."</span></p>";
			}
			
			echo "</div>";
		}
	}

	function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
		$output = NULL;
		if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
			$ip = $_SERVER["REMOTE_ADDR"];
			if ($deep_detect) {
				if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
					$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
				if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
					$ip = $_SERVER['HTTP_CLIENT_IP'];
			}
		}
		$purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
		$support    = array("country", "countrycode", "state", "region", "city", "location", "address");
		$continents = array(
			"AF" => "Africa",
			"AN" => "Antarctica",
			"AS" => "Asia",
			"EU" => "Europe",
			"OC" => "Australia (Oceania)",
			"NA" => "North America",
			"SA" => "South America"
		);
		if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
			$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
			if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
				switch ($purpose) {
					case "location":
						$output = array(
							"city"           => @$ipdat->geoplugin_city,
							"state"          => @$ipdat->geoplugin_regionName,
							"country"        => @$ipdat->geoplugin_countryName,
							"country_code"   => @$ipdat->geoplugin_countryCode,
							"continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
							"continent_code" => @$ipdat->geoplugin_continentCode
						);
						break;
					case "address":
						$address = array($ipdat->geoplugin_countryName);
						if (@strlen($ipdat->geoplugin_regionName) >= 1)
							$address[] = $ipdat->geoplugin_regionName;
						if (@strlen($ipdat->geoplugin_city) >= 1)
							$address[] = $ipdat->geoplugin_city;
						$output = implode(", ", array_reverse($address));
						break;
					case "city":
						$output = @$ipdat->geoplugin_city;
						break;
					case "state":
						$output = @$ipdat->geoplugin_regionName;
						break;
					case "region":
						$output = @$ipdat->geoplugin_regionName;
						break;
					case "country":
						$output = @$ipdat->geoplugin_countryName;
						break;
					case "countrycode":
						$output = @$ipdat->geoplugin_countryCode;
						break;
				}
			}
		}
		return $output;
	}
	
	//current menu item - main menu
	$cmi_mm = 'active';
	
	
	//remove html spaces and comments, merge to one line2-close
	function sanitize_output($buffer) {
		$search = array(
			'/\>[^\S ]+/s',     // strip whitespaces after tags, except space
			'/[^\S ]+\</s',     // strip whitespaces before tags, except space
			'/(\s)+/s',         // shorten multiple whitespace sequences
			'/<!--(.|\s)*?-->/' // Remove HTML comments
		);
		$replace = array( '>', '<', '\\1', '' );
		$buffer = preg_replace($search, $replace, $buffer);
		return $buffer;
	}

	//ob_start("sanitize_output");


	/**
	  * SEO Friendly URLS
	 **/

	function seoUrl($string) {
		
    	//Lower case everything
    	$string = strtolower($string);

	    //Make alphanumeric (removes all other characters)
	    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);

	    //Clean up multiple dashes or whitespaces
	    $string = preg_replace("/[\s-]+/", " ", $string);

	    //Convert whitespaces and underscore to dash
	    $string = preg_replace("/[\s_]/", "-", $string);
	    
	return $string;
}

date_default_timezone_set('America/Chicago'); // set it to the right value

$weAreOpen = areWeOpen(date('l'), date('G'), date('i'));

function areWeOpen($day, $hour, $minutes) {
$hour = (int)$hour;
switch($day) {
    case 'Monday':
        if($hour >= 9 && $hour < 17) {
            return true;
        }
        break;
    case 'Tuesday':
        if($hour >= 9 && $hour < 17) {
            return true;
        }
        break;
    case 'Wednesday':
        if($hour >= 9 && $hour < 17) {
            return true;
        }
        break;
    case 'Thursday':
        if($hour >= 9 && $hour < 17) {
            return true;
        }
        break;
    case 'Friday':
        if($hour >= 9 && $hour < 17) {
            return true;
        }
        break;
    case 'Saturday':
        if($hour >= 8 && $hour < 13) {
            return true;
        }
        break;
    case 'Sunday':
        if($hour >= 0 && $hour < 24) {
            return false;
        }
        break;
}
return false;
}
?>
	