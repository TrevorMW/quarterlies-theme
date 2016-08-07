<?php
/**
 * @package WordPress
 * @subpackage themename
 */

// LOAD CLASSES JIT
spl_autoload_register( function( $className )
{
  $classDir  = get_template_directory() . '/assets/classes/';
  $classFile = 'class-' . str_replace( '_', '-', strtolower( $className ) ) . '.php';

  if( file_exists( $classDir . $classFile ) )
  {
    require_once $classDir . $classFile;
  }
});

////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// START UTILITY FUNCTIONS ///////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////


function addBodyClass( $classes ){
  $classes[] = 'table';
  return $classes;
}

add_filter( 'body_class', 'addBodyClass' );

function loadHomeForm()
{
  $resp = '';

  if( $_POST['action'] != null )
  {
    $data = $_POST;
    $resp = new Ajax_Response( $data['action'], true );
  }

  echo $resp->encodeResponse();

  die;
}

add_action( 'wp_ajax_load_home_form', 'loadHomeForm' );
add_action( 'wp_ajax_nopriv_load_home_form', 'loadHomeForm' );

////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// END UTILITY FUNCTIONS /////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////

require_once( 'utility-functions.php' );

