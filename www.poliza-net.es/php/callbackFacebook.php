<?php

// actualizado a 14 abr 2016 
include_once "vendor/autoload.php";

$provider = new League\OAuth2\Client\Provider\Facebook(array(
    'clientId'  =>  '1399828410324602',
    'clientSecret'  =>  'd873d45825e3818dca6b8c289510c051',
    'redirectUri'   =>  'https://www.poliza-net.es/php/callbackFacebook.php',
    'graphApiVersion'   => 'v2.6'
));



if ( ! isset($_GET['code'])) {

	// If we don't have an authorization code then get one
    $provider->authorize();

} else {

    try {

        // Try to get an access token (using the authorization code grant)
        $t = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
        ]);
        
    	// Try to get an access token (using the authorization code grant)
        //$t = $provider->getAccessToken('authorization_code', array('code' => $_GET['code']));

        try {

            // We got an access token, let's now get the user's details
            $user = $provider->getResourceOwner($t);
            $email = $user->getEmail();
            $name = $user->getName();
            $locale = $user->getLocale();
            $link = $user->getLink();
            $gender = $user->getGender();
            /*
            // We got an access token, let's now get the user's details
            $userDetails = $provider->getUserDetails($t);

            $data = array();
            foreach ($userDetails as $attribute => $value) {
                $data[$attribute]=$value;
                //var_dump($attribute, $value) . PHP_EOL . PHP_EOL;
            }*/
            
            $params='name='.$name.'&email='.$email.'&locale='.$locale.'&gender=' .$gender. '&link='.$link;
            var_dump($params);
            //header('Location: ../ServletAltaIdentidadFederada.servlet?'.$params);

        } catch (Exception $e) {

            // Failed to get user details
            echo 'Failed to get user details';

        }

    } catch (Exception $e) {

        // Failed to get access token
        echo 'Failed to get access token';
    }
}


?>