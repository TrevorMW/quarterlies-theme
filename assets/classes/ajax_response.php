<?php

class ajax_response
{
  public $status;
  public $message;
  public $data;
  public $qty_in_cart;

  public function __construct()
  {
    $this->status  = false;
    $this->message = null;
    $this->data    = null;
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
    return json_encode( array( 'status' => $this->status, 'message' => $this->message, 'data' => $this->data ) );
  }

  public function set_product_qty( $qty )
  {
    $this->qty_in_cart = $qty;
  }
}