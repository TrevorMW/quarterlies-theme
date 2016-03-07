<?php

class ajax_response
{
  public $status;
  public $message;
  public $data;
  public $qty_in_cart;
  public $action;


  /**
   * __construct function.
   *
   * Builds out a simple response object for sending data back from wp_ajax calls.
   * Use "status" as a boolean for true/false operations within callbacks after the ajax request has been completed, "messages" for any custom messages/user feedback
   * And use "data" as an array to send back html or custom data that can be acted on with javascript.
   *
   * @access public
   * @param mixed $action (default: null)
   * @param mixed $has_callback
   * @return void
   */
  public function __construct( $action = null, $has_callback )
  {
    $this->status  = false;
    $this->message = null;
    $this->data    = null;

    if( $action != null )
      $this->action = $action;

    if( $has_callback )
      $this->callback = $action;
  }


  /**
   * set_action_id function.
   *
   * Used to set a ajax callback. This a link to the javascript scope to effect changes on the DOM.
   * The action ID is defined as the wp_ajax_* method, for simplicity.
   *
   * @access public
   * @param mixed $action
   * @return void
   */
  public function set_action_id( $action )
  {
    $this->action = $action;
  }


  /**
   * set_message function.
   *
   * Need to send user feedback through to the ajax callback? send that here.
   * You can pass individual strings, or you can pass an array if you need with multiple messages.
   *
   * @access public
   * @param mixed $msg
   * @return void
   */
  public function set_message( $msg )
  {
    $this->message = $msg;
  }


  /**
   * set_data function.
   *
   * Send back response data from wp_ajax_ call.
   *
   *
   * @access public
   * @param array $data (default: array())
   * @return void
   */
  public function set_data( $data = array() )
  {
    $this->data = $data;
  }

  public function set_status( $status )
  {
    $this->status = $status;
  }


  /**
   * encode_response function.
   *
   * Encodes PHP array as valid JSON to be sent back to callback javascript scope.
   *
   * @access public
   * @return void
   */
  public function encode_response()
  {
    return json_encode( array( 'status' => $this->status, 'message' => $this->message, 'data' => $this->data, 'action_id' => $this->action, 'callback' => $this->callback ) );
  }
}
