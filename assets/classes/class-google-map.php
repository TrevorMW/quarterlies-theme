<?php

class Google_Map
{
  public $map_address;
  public $map_latitude;
  public $map_longitude;
  public $map_theme;
  public $map_zoom = 14;
  public $map_points;
  public $custom_icon;

  public $build_map = false;

  /**
   * __construct function.
   *
   * @access public
   * @return void
   */
  public function __construct( $id, $field_name, $use_post_id, $points )
  {
    if( is_int( $id ) && $field_name != '' )
    {
      $this->map_theme = get_field( 'google_maps_theme', 'option' );

      $use_post_id ? $data = get_field( $field_name, $id ) : $data = get_field( $field_name, 'option' );

      $icon = get_field( 'google_maps_custom_icon', 'option' );

      if( $data )
      {
        $this->build_map = true;

        $this->map_address   = $data['address'];
        $this->map_latitude  = $data['lat'];
        $this->map_longitude = $data['lng'];

        $this->custom_icon  = $icon['url'];
      }

      if( is_array( $points ) && !empty( $points ) )
        $this->map_points = $points;
    }
  }

  /**
   * build_map_html function.
   *
   * @access public
   * @return void
   */
  public function build_map_html()
  {
    $html = '';

    if( $this->build_map )
    {
      $data['map']['center']      = json_encode( array( 'lat' => $this->map_latitude, 'lng' => $this->map_longitude ) );
      $data['map']['theme']       = $this->map_theme;
      $data['map']['map_points']  = json_encode( $this->map_points );
      $data['map']['custom_icon'] = $this->custom_icon;

      ob_start();

      get_template_part_with_data( 'template','google-map', $data );

      $html .= ob_get_contents();

      ob_get_clean();
    }

    return $html;
  }
}