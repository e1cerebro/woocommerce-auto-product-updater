


<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Chmg_Woo_Auto_Product_Updater
 * @subpackage Chmg_Woo_Auto_Product_Updater/admin/partials
 */

require __DIR__ . '/vendor/autoload.php';
?>
 
 <?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Chmg_Woo_Auto_Product_Updater
 * @subpackage Chmg_Woo_Auto_Product_Updater/admin/partials
 */

require __DIR__ . '/vendor/autoload.php';
?>


<?php
/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getCClient()
{
    $client = new Google_Client();
    $client->setApplicationName('Google Sheets API PHP Quickstart');
    $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
    $client->setAuthConfig(plugin_dir_path( dirname( __FILE__ ) ).'partials/credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    $chmg_wapu_access_token = get_option('chmg_wapu_api_token_el');
    $access_token           = get_option('sheet_access_token', false);

    if(false == $access_token){
        // Exchange authorization code for an access token.
        $accessToken = $client->fetchAccessTokenWithAuthCode($chmg_wapu_access_token);
         
        update_option( 'sheet_access_token', $accessToken, true);

        echo "False: ";
        print_r($accessToken);
    }else{
        $accessToken  = get_option( 'sheet_access_token' );
        echo "True: ";
        print_r($accessToken);
    }
      
    

    $client->setAccessToken($accessToken);

    // Check to see if there was an error.
    if (array_key_exists('error', $accessToken)) {
        throw new Exception(join(', ', $accessToken));
    }

    return $client;
}


// Get the API client and construct the service object.
$client = getCClient();
$service = new Google_Service_Sheets($client);

// Prints the names and majors of students in a sample spreadsheet:
// https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
//$spreadsheetId = '1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms';
$spreadsheetId = '16kMF5aJ-aZNlpu22Q7khmhFZqVuGy4ijC2SdEIt_EZY';
//$range = 'Class Data!A2:E';
$range = 'Power Wheelchairs';
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$values = $response->getValues();

if (empty($values)) {
    print "No data found.\n";
} else {
    print "Name, Major:\n";
    echo "<pre>"; 
        print_r($values);
    echo "</pre>";

    /* foreach ($values as $row) {
        // Print columns A and E, which correspond to indices 0 and 4.
        printf("%s, %s\n", $row[0], $row[4]);
    } */
}

 ?>



<?php

       /*  function getAccessToken(){
    
        }




       function getXClient()
        {
            $client = new Google_Client();
            $client->setApplicationName('Google Sheets API PHP Quickstart');
            $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
            $client->setAuthConfig(plugin_dir_path( dirname( __FILE__ ) ).'partials/credentials.json');
            $client->setAccessType('offline');
            $client->setPrompt('select_account consent');
        
            // Load previously authorized token from a file, if it exists.
            // The file token.json stores the user's access and refresh tokens, and is
            // created automatically when the authorization flow completes for the first
            // time.
            $tokenPath = 'token.json';
            if (file_exists($tokenPath)) {
                $accessToken = json_decode(file_get_contents($tokenPath), true);
                $client->setAccessToken($accessToken);
            }
            
            // If there is no previous token or it's expired.
            if ($client->isAccessTokenExpired()) {
                // Refresh the token if possible, else fetch a new one.
                if ($client->getRefreshToken()) {
                    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                } else {
                    // Request authorization from the user.
                    $authUrl = $client->createAuthUrl();
                    echo "<a href='".$authUrl."'> Click here to authorize this plugin to access you google sheets</a>";

                    //$authCode = trim(fgets(STDIN));
        
                    // Exchange authorization code for an access token.
                    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                    $client->setAccessToken($accessToken);
        
                    // Check to see if there was an error.
                    if (array_key_exists('error', $accessToken)) {
                        throw new Exception(join(', ', $accessToken));
                    }
                }
                // Save the token to a file.
                if (!file_exists(dirname($tokenPath))) {
                    mkdir(dirname($tokenPath), 0700, true);
                }
                file_put_contents($tokenPath, json_encode($client->getAccessToken()));
            }
            return $client;
        }
 */
        // Get the API client and construct the service object.
        //$client = getClient();
