<?php
/**
 * Created by PhpStorm.
 * User: Trevor
 * Date: 7/24/16
 * Time: 8:23 AM
 */

if ( !defined( 'ABSPATH' ) )
  exit;

define( 'DOING_AJAX', true );

$ajaxAllowed = true;

if( !isset( $_POST['action']) ){
  $ajaxAllowed = false;
}

//relative to where your plugin is located
require_once('../../../../../wp-load.php');

//Typical headers
header('Content-Type: text/html');
send_nosniff_header();

//Disable caching
header('Cache-Control: no-cache');
header('Pragma: no-cache');

$action = esc_attr( $_POST['action'] );

//A bit of security
$allowed_actions = array(
  'load_home_form',
);

if( $ajaxAllowed ){
  if( in_array( $action, $allowed_actions ) )
  {
    if( is_user_logged_in() )
    {
      do_action( 'plugin_name_ajax_' . $action );
    }
    else
    {
      do_action( 'plugin_name_ajax_nopriv_' . $action );
    }
  }
  else
  {
    die(-1);
  }
}
else
{
  die(-1);
}
