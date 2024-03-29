<?php 

    require __DIR__ . '/vendor/autoload.php'; 
    require plugin_dir_path( dirname( __FILE__ ) ).'/partials/custom-functions/chmg-woo-google-utils.php';

?>
<?php
    
    if(isset($_POST['chmg_wapu_disconnect'])){
        delete_option('chmg_wapu_sheet_id_el');
        delete_option('chmg_wapu_default_sheet_names_el');
        delete_option('sheet_access_token');
        delete_option('chmg_wapu_api_token_el');
    }

    function getAccessToken(){
        
        $client = new Google_Client();
        $client->setApplicationName('Google Sheets API PHP Quickstart');
        $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
        $client->setAuthConfig(plugin_dir_path( dirname( __FILE__ ) ).'partials/credentials.json');
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                // Request authorization from the user.
                $authUrl = $client->createAuthUrl();
            }

            echo "<h1 class='blink_me'><a target='_blank' class='authorize' href='".$authUrl."'> Click here to get access token</a></h1>";
            echo "<h3> <strong>Note:</strong> Paste the token code from google in the box above. &#8593;</h3>";
        }

    }

?>

<div class="wrap">
    
    <?php settings_errors(); ?>
    <h1><?php echo get_admin_page_title(); ?></h1>

    <?php
        $chmg_wapu_access_token = get_option('chmg_wapu_api_token_el');
    ?>

     <form method="post" action="options.php">
        <?php 
            settings_fields($this->plugin_name.'_integration');
            do_settings_sections($this->plugin_name.'_integration');
            submit_button('Connect Google Sheet'); 
        ?>
    </form>
    
      
     <?php 
        if(strlen($chmg_wapu_access_token) <= 0){
            getAccessToken();
        }else{
            if(confirmSheetSync()){

                $sheetID = get_option('chmg_wapu_sheet_id_el');
                ?>
                    <hr><a target="_blank" class="chmg_wapu_synced" href="https://docs.google.com/spreadsheets/d/<?php echo $sheetID; ?>/edit#"> &#8651;: Successfully synced with google sheet</a>
                <?php
            }
        }

    ?>
 <form method="post" action="">
            <?php  
             //if(strlen($chmg_wapu_access_token) > 0 && confirmSheetSync()){
                $other_attributes = array( 'id' => 'chmg_wapu_disconnect' );
                submit_button( 'Disconnect Google Sheet', 'delete', 'chmg_wapu_disconnect', true, $other_attributes );

                
            // }
            ?>
            
        </form>

</div>

