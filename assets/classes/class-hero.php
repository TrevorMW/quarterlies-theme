<?php

class Hero extends WP_ACF_CPT
{
  public $page_has_hero;
  public $hero_image;
  public $hero_tagline;
  public $hero_icon;

  public $build_hero = false;

  /**
   * __construct function.
   *
   * @access public
   * @param mixed $id (default: null)
   * @return void
   */
  public function __construct( $id = null )
  {
    if( is_int( $id ) )
      parent::__construct( $id );

    if( is_array( $this->hero_image ) )
      $this->build_hero = true;
  }

  /**
   * init_actions function.
   *
   * @access public
   * @return void
   */
  public function init_actions()
  {
    add_action( 'page_hero', array( $this, 'get_page_hero'    ), 10, 1 );
    add_action( 'page_hero', array( $this, 'get_page_tagline' ), 20, 1 );
  }

  /**
   * build_hero_skeleton function.
   *
   * @access public
   * @return void
   */
  public function build_hero_skeleton()
  {
    global $post;

    $html = '';

    is_single() && $post->post_type == 'post' ? $data['hero']['post'] = $post : '' ;

    $data['hero']['img']        = $this->hero_image;
    $data['hero']['hero_title'] = $this->hero_tagline != '' ? $this->hero_tagline : $post->post_title;
    $data['hero']['hero_icon']  = $this->hero_icon;

    ob_start();

    get_template_part_with_data( 'template','hero', $data );

    $html .= ob_get_contents();

    ob_get_clean();

    return $html;
  }

  /**
   * get_page_hero function.
   *
   * @access public
   * @param mixed $post
   * @return void
   */
  public function get_page_hero( $id )
  {
    $html = '';

    if( is_int( $id ) )
    {
      $has_hero = get_field( 'page_has_hero', $id );
      $post = get_post( $id );

      if( $has_hero )
      {
        $hero = new Hero( $id );

        if( $hero->build_hero )
        {
          $html .= $hero->build_hero_skeleton();
        }
        else if ( is_single( $post ) )
        {
          $html .= $hero->build_single_page_hero_header( $post );
        }
        else
        {

        }
      }
    }

    echo $html;
  }


  public function build_single_page_hero_header( $post )
  {
    $html = '';

    if( $post instanceOf WP_Post )
    {
      $data['hero_header'] = $post;

      ob_start();

      get_template_part_with_data( 'template','alt-hero-header', $data );

      $html .= ob_get_contents();

      ob_get_clean();
    }

    return $html;
  }

  /**
   * get_page_tagline function.
   *
   * @access public
   * @return void
   */
  public function get_page_tagline( $id )
  {
    $html = '';

    if( is_int( $id ) )
    {
      $tagline = get_field( 'sub_hero_tagline', $id );

      if( $tagline )
      {
        $data['tagline'] = $tagline;

        ob_start();

        get_template_part_with_data( 'template', 'tagline', $data );

        $html .= ob_get_contents();

        ob_get_clean();
      }
    }

    echo $html;
  }
}
