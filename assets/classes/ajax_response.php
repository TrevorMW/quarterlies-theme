<?php

class ajax_response
{
  public $status;
  public $message;
  public $data;
  public $qty_in_cart;
  public $action;

  public function __construct( $action = null, $has_callback )
  {
    $this->status  = false;
    $this->message = null;
    $this->data    = null;

    if( $action != null )
    {
      $this->action = $action;
    }

    if( $has_callback )
    {
      $this->callback = $action;
    }
  }

  public function set_action_id( $action )
  {
    $this->action = $action;
  }

  public function set_message( $msg )
  {
    $this->message = $msg;
  }

  public function set_data( $data = array() )
  {
    $this->data = $data;
  }

  public function set_status( $status )
  {
    $this->status = $status;
  }

  public function encode_response()
  {
    return json_encode( array( 'status' => $this->status, 'message' => $this->message, 'data' => $this->data, 'action_id' => $this->action, 'callback' => $this->callback ) );
  }
}