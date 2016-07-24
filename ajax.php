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

require_once( ABSPATH . '/wp-admin/wp-load.php' );

// Typical headers
header('Content-Type: text/html');
send_nosniff_header();
header('Cache-Control: no-cache');
header('Pragma: no-cache');

$action = esc_attr( $_POST['action'] );

$allowed_actions = array(
  'load_home_form',
);

if( $ajaxAllowed ){
  if( in_array( $action, $allowed_actions ) )
  {
    is_user_logged_in() ? do_action( 'wp_ajax_' . $action ) : do_action( 'wp_ajax_nopriv_' . $action );
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
