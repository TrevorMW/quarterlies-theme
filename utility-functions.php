<?php

function get_current_template( $echo = false )
{
  if( !isset( $GLOBALS['current_theme_template'] ) )
      return false;
  if( $echo )
      echo $GLOBALS['current_theme_template'];
  else
      return $GLOBALS['current_theme_template'];
}

function get_excerpt_by_id( $post_id, $length = 35 )
{
  $new_post       = get_post( $post_id ); //Gets post ID
  $the_excerpt    = strip_tags( $new_post->post_content ); //Strips tags and images
  $words          = explode(' ', $the_excerpt, $length + 1);

  if(count($words) > $length) :

    array_pop($words);
    array_push($words, '…');
    $the_excerpt = implode(' ', $words);

  endif;

  return apply_filters( 'the_content', $the_excerpt );
}

function build_pagination( $loop, $paged )
{
  global $wp;

  $args = array(
  	'format'     => 'page/%#%',
  	'total'      => $loop->max_num_pages,
  	'current'    => max( 1, $paged ),
  	'prev_text'  => __('<i data-previous class="fa fa-caret-left"></i>'),
  	'next_text'  => __('<i data-next     class="fa fa-caret-right"></i>'),
  	'type'       => 'array'
  );

  return formatted_pagination( paginate_links( $args ) );
}

function formatted_pagination( $data )
{
  $html = '';

  if( count( $data ) > 0 )
  {
    $html .= '<ul class="pagination">';

    foreach( $data as $link )
    {
      $class = '';
      strpos( $link, 'current' ) != false ? $class = 'active' : '' ;
      $html .= '<li class="'.$class.'">'.$link.'</li>';
    }

    $html .= '</ul>';
  }

  return $html;
}

function get_template_part_with_data($slug = null, $name = null, array $params = array())
{
  global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

  do_action("get_template_part_{$slug}", $slug, $name);

  $templates = array();
  if (isset($name))
      $templates[] = "/views/{$slug}-{$name}.php";

  $templates[] = "/views/{$slug}.php";

  $_template_file = locate_template($templates, false, false);

  if (is_array($wp_query->query_vars))
  {
    extract($wp_query->query_vars, EXTR_SKIP);
  }
  extract($params, EXTR_SKIP);

  require($_template_file);
}

function __is_blog()
{
  global $post;
  $posttype = get_post_type( $post );
  return ( ( ( is_archive() ) || ( is_home() ) ) && ( $posttype == 'post' )  ) ? true : false ;
}

function get_post_term_links_by_count( $id, $cat, $count = 10 )
{
  $html = array();

  if( is_int( $id ) && $cat != null )
  {
    $terms = wp_get_post_terms( $id , $cat );

    if( count( $terms ) > 0 )
    {
      $i = 1;

      foreach( $terms as $term )
      {
        if( $i <= $count )
        {
          if( $term->slug != 'uncategorized' )
          {
            $html[] = '<a href="'.get_term_link( $term, 'category').'">'.$term->name.'</a>';
          }
        }

        $i++;
      }
    }
  }

  return $html;
}

function get_array_from_object( $array = array() )
{
  $result = array();

  if( is_array( $array ) )
  {
    foreach( $array as $obj )
    {
      $result[$obj->ID] = $obj->post_title;
    }
  }

  return $result;
}


add_editor_style('css/editor-style.css');

function custom_tinymce_styles( $settings )
{
  $style_formats = array(
    array(
        'title' => 'Huge Blue Text',
        'selector' => 'h1,h2,h3,h4,h5,h6',
        'classes' => 'huge blue ',
    ),
    array(
        'title' => 'Blue Text',
        'selector' => 'h1,h2,h3,h4,h5,h6',
        'classes' => 'blue',
    ),
    array(
        'title' => 'Gray Text',
        'selector' => 'h1,h2,h3,h4,h5,h6',
        'classes' => 'gray',
    ),
    array(
        'title' => 'White Text',
        'selector' => 'h1,h2,h3,h4,h5,h6',
        'classes' => 'white',
    )
  );

  $settings['style_formats'] = json_encode( $style_formats );

  if ( ! isset( $settings['extended_valid_elements'] ) )
  {
    $settings['extended_valid_elements'] = '';
  }
  else
  {
    $settings['extended_valid_elements'] .= ',';
  }

  if ( ! isset( $settings['custom_elements'] ) )
  {
    $settings['custom_elements'] = '';
  }
  else
  {
    $settings['custom_elements'] .= ',';
  }

  $settings['extended_valid_elements'] .= 'div[class|id|style|data-animation|data-fx]';
  $settings['custom_elements']         .= 'div[class|id|style|data-animation|data-fx]';

  return $settings;
}
add_filter( 'tiny_mce_before_init', 'custom_tinymce_styles' );

function add_tinymce_styles_dropdown( $buttons )
{
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
add_filter('mce_buttons_2', 'add_tinymce_styles_dropdown');

function allow_data_attributes_in_tinymce()
{
  global $allowedposttags;

  $tags = array( 'div' );
  $new_attributes = array( 'contenteditable' => array(), 'data-animation' => array(), 'data-fx' => array() );

  foreach ( $tags as $tag )
  {
    if ( isset( $allowedposttags[ $tag ] ) && is_array( $allowedposttags[ $tag ] ) )
        $allowedposttags[ $tag ] = array_merge( $allowedposttags[ $tag ], $new_attributes );
  }
}
add_action( 'init', 'allow_data_attributes_in_tinymce' );


add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

function var_template_include( $t )
{
  $GLOBALS['current_theme_template'] = basename($t);
  return $t;
}
add_filter( 'template_include', 'var_template_include', 1000 );

if( function_exists('acf_add_options_page') )
{
	acf_add_options_page(array(
		'page_title' 	=> 'Global Settings',
		'menu_title'	=> 'Global Settings',
		'menu_slug' 	=> 'global-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}


class Action_Name
{
  public $type;

  public function __construct( $post )
  {
    if( is_object( $post ) )
    {
      if( $post->post_type == 'page' )
      {
        $type = str_replace( '-', '_', $post->post_name ).'_';
      }
      else if( is_shop() )
      {
        $type = 'shop_';
      }
      else
      {
        $type = str_replace( '-', '_', $post->post_type ).'_';
      }

      is_front_page() ? $type = 'front_' : '';

      $this->type = $type;
    }
  }
}


////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// END UTILITY FUNCTIONS /////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////


/**
 *
 * ENQUEUE CSS, LESS, & SCSS STYLESHEETS
 *
 */
function add_style_sheets()
{
	if( !is_admin() )
	{
		wp_enqueue_style( 'reset', get_template_directory_uri().'/style.css', 'screen'  );
		wp_enqueue_style( 'fontawesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', 'screen' );
		wp_enqueue_style( 'main', get_template_directory_uri().'/assets/css/style.less', 'screen' );
	}
}

add_action('wp_enqueue_scripts', 'add_style_sheets');



function load_custom_wp_admin_style()
{
  wp_enqueue_style( 'admin-fixes', get_template_directory_uri().'/assets/css/admin-fixes.css', 'screen'  );
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );

/**
 *
 * ENQUEUE JAVASCRIPT FILES
 *
 */
function add_javascript()
{
  global $post;

	if( !is_admin() )
	{
		wp_enqueue_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js' );
		wp_enqueue_script( 'genericJS', get_template_directory_uri().'/assets/js/general.js');
		wp_enqueue_script( 'waypoints', get_template_directory_uri().'/assets/js/waypoints.js');
		wp_enqueue_script( 'instafeed', get_template_directory_uri().'/assets/js/instafeed.js');

		is_page('press') ? wp_enqueue_script( 'sticky', get_template_directory_uri().'/assets/js/sticky.js') : '';
	}
}

add_action('wp_enqueue_scripts', 'add_javascript');




function mgt_dequeue_styles_and_scripts()
{
  if ( class_exists( 'woocommerce' ) )
  {
    wp_dequeue_style( 'select2' );
    wp_deregister_style( 'select2' );

    wp_dequeue_script( 'select2');
    wp_deregister_script('select2');
  }
}
add_action( 'wp_enqueue_scripts', 'mgt_dequeue_stylesandscripts', 100 );



/**
 *
 * TAKE GLOBAL DESCRIPTION OUT OF HEADER.PHP AND GENERATE IT FROM A FUNCTION
 *
 */
function site_global_description()
{
	global $page, $paged;
	wp_title( '|', true, 'right' );
}


/**
 * REMOVE UNWANTED CAPITAL <P> TAGS
 */
remove_filter( 'the_content', 'capital_P_dangit' );
remove_filter( 'the_title', 'capital_P_dangit' );
remove_filter( 'comment_text', 'capital_P_dangit' );


/**
 * REGISTER NAV MENUS FOR HEADER FOOTER AND UTILITY
 */
register_nav_menus( array(
	'primary' => __( 'Primary Menu', 'themename' ),
	'utility' => __( 'Utility Menu', 'themename' ),
	'footer' => __( 'Footer Menu', 'themename' ),

) );


/**
 * DEFAULT COMMENTS & RSS LINKS IN HEAD
 */
add_theme_support( 'automatic-feed-links' );


/**
 * THEME SUPPORTS THUMBNAILS
 */
add_theme_support( 'post-thumbnails' );


/**
 *	THEME SUPPORTS EDITOR STYLES
 */
add_editor_style("/css/layout-style.css");


/**
 *	ADD TINY IMAGE SIZE FOR ACF FIELDS, BETTER USABILITY
 */
add_image_size( 'mini-thumbnail', 50, 50 );


/**
 *	REPLACE THE HOWDY
 */
function admin_bar_replace_howdy($wp_admin_bar)
{
    $account = $wp_admin_bar->get_node('my-account');
    $replace = str_replace('Howdy,', 'Welcome,', $account->title);
    $wp_admin_bar->add_node(array('id' => 'my-account', 'title' => $replace));
}
add_filter('admin_bar_menu', 'admin_bar_replace_howdy', 25);


/**
 * REGISTER SIDEBARS
 */
function handcraftedwp_widgets_init()
{
	register_sidebar( array (
		'name' => __( 'Sidebar', 'themename' ),
		'id' => 'sidebar',
		'before_widget' => '<aside class="widget %2$s" role="complementary">',
		'after_widget' => "</aside>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );
}
add_action( 'init', 'handcraftedwp_widgets_init' );


function change_search_form( $form )
{
  global $post;

  $form = '<form role="search" method="get" data-search-form action="' . esc_url( home_url( '/' ) ) . '">
              <input type="hidden" name="page_identifier" value="'.$post->ID.'" />
              <ul class="inline">
                <li class="inline-input">
                  <label class="acc">' . _x( 'Search for:', 'label' ) . '</label>
                  <input type="search" class="search-field" placeholder="' . esc_attr_x( 'Search &hellip;', 'placeholder' ) . '" value="' . get_search_query() . '" name="s" title="' . esc_attr_x( 'Search for:', 'label' ) . '" />
                </li>
                <li class="inline-trigger">
                  <button type="submit"><i class="fa fa-fw fa-search"></i></button>
                </li>
              </ul>
      		 </form>';

  return $form;
}
add_filter( 'get_search_form', 'change_search_form' );



/**
 * Provides a simple login form for use anywhere within WordPress. By default, it echoes
 * the HTML immediately. Pass array('echo'=>false) to return the string instead.
 *
 * @since 3.0.0
 *
 * @param array $args Configuration options to modify the form output.
 * @return string|void String when retrieving.
 */
function custom_login_form( $args = array() )
{
	$defaults = array(
		'echo' => true,
		'redirect' => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], // Default redirect is back to the current page
		'remember' => true,
		'value_username' => '',
		'value_remember' => false, // Set this to true to default the "Remember me" checkbox to checked
	);

	/**
	 * Filter the default login form output arguments.
	 *
	 * @since 3.0.0
	 *
	 * @see wp_login_form()
	 *
	 * @param array $defaults An array of default login form arguments.
	 */
	$args = wp_parse_args( $args, apply_filters( 'login_form_defaults', $defaults ) );

	$form = '<form data-ajax-form data-action="ajax_login" autocomplete="off">
	          <span data-form-msg></span>
      			<ul>
      			  <li class="full login-username">
        				<input type="text" name="log" value="' . esc_attr( $args['value_username'] ) . '" placeholder="' . esc_html( $args['label_username'] ) . '" autocomplete="off"/>
        			</li>
        			<li class="full login-password">
        				<input type="password" name="pwd" value="" placeholder="' . esc_html( $args['label_password'] ) . '" autocomplete="off" />
        			</li>
        			<li class="submit submit-right">
        				<button type="submit" name="wp-submit" class="btn"><i data-progress class="fa fa-fw fa-spin fa-spinner"></i> ' . esc_attr( $args['label_log_in'] ) . '</button>
        				<input type="hidden" name="redirect_to" value="' . esc_url( $args['redirect'] ) . '" />
        				'.wp_nonce_field( 'ajax-login-nonce', 'security' ).'
        			</li>
      			</ul>
      		</form>';

	if ( $args['echo'] )
		echo $form;
	else
		return $form;
}



/**
 * Outputs a checkout/address form field.
 *
 * @subpackage  Forms
 * @param string $key
 * @param mixed $args
 * @param string $value (default: null)
 * @todo This function needs to be broken up in smaller pieces
 */
function woocommerce_form_field( $key, $args, $value = null )
{
  $after = '';

  $defaults = array(
    'type'              => 'text',
    'label'             => '',
    'description'       => '',
    'placeholder'       => '',
    'maxlength'         => false,
    'required'          => false,
    'id'                => $key,
    'class'             => array(),
    'label_class'       => array(),
    'input_class'       => array(),
    'return'            => false,
    'options'           => array(),
    'custom_attributes' => array(),
    'validate'          => array(),
    'default'           => '',
  );

  $args = wp_parse_args( $args, $defaults );
  $args = apply_filters( 'woocommerce_form_field_args', $args, $key, $value );

  if ( $args['required'] )
  {
    $args['class'][] = 'validate-required';
    $required        = ' <abbr class="required" title="' . esc_attr__( 'required', 'woocommerce'  ) . '">*</abbr>';
  }
  else
  {
    $required = '';
  }

  $args['maxlength'] = ( $args['maxlength'] ) ? 'maxlength="' . absint( $args['maxlength'] ) . '"' : '';

  if ( is_string( $args['label_class'] ) )
  {
    $args['label_class'] = array( $args['label_class'] );
  }

  if ( is_null( $value ) )
  {
    $value = $args['default'];
  }

  // Custom attribute handling
  $custom_attributes = array();

  if ( ! empty( $args['custom_attributes'] ) && is_array( $args['custom_attributes'] ) )
  {
    foreach ( $args['custom_attributes'] as $attribute => $attribute_value )
    {
      $custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
    }
  }

  if ( ! empty( $args['validate'] ) )
  {
    foreach( $args['validate'] as $validate )
    {
      $args['class'][] = 'validate-' . $validate;
    }
  }

  $field    = '';
  $label_id = $args['id'];
  $field_container = '<li class="%1$s" id="%2$s">%3$s</li>';

  switch ( $args['type'] )
  {
    case 'country' :

      $countries = $key == 'shipping_country' ? WC()->countries->get_shipping_countries() : WC()->countries->get_allowed_countries();

      if ( sizeof( $countries ) == 1 )
      {
        $field .= '<strong>' . current( array_values( $countries ) ) . '</strong>';
        $field .= '<input type="hidden" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="' . current( array_keys($countries ) ) . '" ' . implode( ' ', $custom_attributes ) . ' class="country_to_state" />';
      }
      else
      {
        $field = '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="country_to_state country_select ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" ' . implode( ' ', $custom_attributes ) . '>'
                . '<option value="">'.__( 'Select a country&hellip;', 'woocommerce' ) .'</option>';

        foreach ( $countries as $ckey => $cvalue )
        {
          $field .= '<option value="' . esc_attr( $ckey ) . '" '.selected( $value, $ckey, false ) .'>'.__( $cvalue, 'woocommerce' ) .'</option>';
        }

        $field .= '</select>';
        $field .= '<noscript><input type="submit" name="woocommerce_checkout_update_totals" value="' . esc_attr__( 'Update country', 'woocommerce' ) . '" /></noscript>';
      }

    break;

    case 'state' :

      /* Get Country */
      $country_key = $key == 'billing_state' ? 'billing_country' : 'shipping_country';
      $current_cc  = WC()->checkout->get_value( $country_key );
      $states      = WC()->countries->get_states( $current_cc );

      if ( is_array( $states ) && empty( $states ) )
      {
        $field_container = '<p class="form-row %1$s" id="%2$s" style="display: none">%3$s</p>';
        $field          .= '<input type="hidden"
                                   class="hidden"
                                   name="' . esc_attr( $key )  . '"
                                   id="' . esc_attr( $args['id'] ) . '"
                                   value="" ' . implode( ' ', $custom_attributes ) . '
                                   placeholder="' . esc_attr( $args['placeholder'] ) . '" />';
      }
      elseif ( is_array( $states ) )
      {
        $field .= '<select name="' . esc_attr( $key ) . '"
                           id="' . esc_attr( $args['id'] ) . '"
                           class="state_select ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" ' . implode( ' ', $custom_attributes ) . '
                           placeholder="' . esc_attr( $args['placeholder'] ) . '">

                    <option value="">'.__( 'Select a state&hellip;', 'woocommerce' ) .'</option>';

        foreach ( $states as $ckey => $cvalue )
        {
          $field .= '<option value="' . esc_attr( $ckey ) . '" '.selected( $value, $ckey, false ) .'>'.__( $cvalue, 'woocommerce' ) .'</option>';
        }

        $field .= '</select>';
      }
      else
      {
        $field .= '<input type="text"
                          class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'"
                          value="' . esc_attr( $value ) . '"
                          placeholder="' . esc_attr( $args['placeholder'] ) . '"
                          name="' . esc_attr( $key ) . '"
                          id="' . esc_attr( $args['id'] ) . '" ' . implode( ' ', $custom_attributes ) . ' />';

      }

    break;


    case 'textarea' :

      $field .= '<textarea name="' . esc_attr( $key ) . '"
                           class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'"
                           id="' . esc_attr( $args['id'] ) . '"
                           placeholder="' . esc_attr( $args['placeholder'] ) . '" '. implode( ' ', $custom_attributes ) . '>'. esc_textarea( $value  ) .'</textarea>';

    break;


    case 'checkbox' :

      $field = '<label class="checkbox ' . implode( ' ', $args['label_class'] ) .'" ' . implode( ' ', $custom_attributes ) . '>
                <input type="' . esc_attr( $args['type'] ) . '"
                       class="input-checkbox ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'"
                       name="' . esc_attr( $key ) . '"
                       id="' . esc_attr( $args['id'] ) . '"
                       value="1" '.checked( $value, 1, false ) .' /> '. $args['label'] . $required . '</label>';

    break;


    case 'password' :

      $field .= '<input type="password"
                        class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'"
                        name="' . esc_attr( $key ) . '"
                        id="' . esc_attr( $args['id'] ) . '"
                        placeholder="' . esc_attr( $args['placeholder'] ) . '"
                        value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' />';

    break;


    case 'text' :

      $field .= '<input type="text"
                        class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'"
                        name="' . esc_attr( $key ) . '"
                        id="' . esc_attr( $args['id'] ) . '"
                        placeholder="' . esc_attr( $args['placeholder'] ) . '" '.$args['maxlength'].'
                        value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . '
                        placeholder="' . esc_attr( $args['placeholder'] ) . '" />';

    break;


    case 'email' :

      $field .= '<input type="email"
                        class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'"
                        name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '"
                        placeholder="' . esc_attr( $args['placeholder'] ) . '" '.$args['maxlength'].'
                        value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . '
                        placeholder="' . esc_attr( $args['placeholder'] ) . '" />';

    break;


    case 'tel' :

      $field .= '<input type="tel"
                        class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'"
                        name="' . esc_attr( $key ) . '"
                        id="' . esc_attr( $args['id'] ) . '"
                        placeholder="' . esc_attr( $args['placeholder'] ) . '" '.$args['maxlength'].'
                        value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . '
                        placeholder="' . esc_attr( $args['placeholder'] ) . '" />';

    break;


    case 'select' :

      $options = $field = '';

      if ( ! empty( $args['options'] ) )
      {
        foreach ( $args['options'] as $option_key => $option_text )
        {
          if ( "" === $option_key )
          {
            // If we have a blank option, select2 needs a placeholder
            if ( empty( $args['placeholder'] ) )
            {
              $args['placeholder'] = $option_text ? $option_text : __( 'Choose an option', 'woocommerce' );
            }

            $custom_attributes[] = 'data-allow_clear="true"';
          }

          $options .= '<option value="' . esc_attr( $option_key ) . '" '. selected( $value, $option_key, false ) . '>' . esc_attr( $option_text ) .'</option>';
        }

        $field .= '<select name="' . esc_attr( $key ) . '"
                           id="' . esc_attr( $args['id'] ) . '"
                           class="select '.esc_attr( implode( ' ', $args['input_class'] ) ) .'" ' . implode( ' ', $custom_attributes ) . '
                           placeholder="' . esc_attr( $args['placeholder'] ) . '">' . $options . '</select>';
      }

    break;


    case 'radio' :

      $label_id = current( array_keys( $args['options'] ) );

      if ( ! empty( $args['options'] ) )
      {
        foreach ( $args['options'] as $option_key => $option_text )
        {
          $field .= '<input type="radio"
                            class="input-radio ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'"
                            value="' . esc_attr( $option_key ) . '"
                            name="' . esc_attr( $key ) . '"
                            id="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '"' . checked( $value, $option_key, false ) . ' />';

          $field .= '<label for="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '"
                            class="radio ' . implode( ' ', $args['label_class'] ) .'">' . $option_text . '</label>';
        }
      }

    break;


  }

  if ( ! empty( $field ) )
  {
    $field_html = '';

    if ( $args['label'] && 'checkbox' != $args['type'] )
    {
      //$field_html .= '<label for="' . esc_attr( $label_id ) . '" class="' . esc_attr( implode( ' ', $args['label_class'] ) ) .'">' . $args['label'] . $required . '</label>';
    }

    $field_html .= $field;

    if ( $args['description'] )
    {
      $field_html .= '<span class="description">' . esc_html( $args['description'] ) . '</span>';
    }

    $container_class = esc_attr( implode( ' ', $args['class'] ) );
    $container_id    = esc_attr( $args['id'] ) . '_field';


    $field = sprintf( $field_container, $container_class, $container_id, $field_html ) . $after;
  }

  $field = apply_filters( 'woocommerce_form_field_' . $args['type'], $field, $key, $args, $value );

  if ( $args['return'] )
  {
    return $field;
  }
  else
  {
    echo $field;
  }
}

class Woo_form_field
{
  private static $defaults;

  public $args;
  public $required = false;

  public function __construct( $key, $value = null, $args )
  {
    $this->defaults = array(
      'type'              => 'text',
      'label'             => '',
      'description'       => '',
      'placeholder'       => '',
      'maxlength'         => false,
      'required'          => false,
      'id'                => $key,
      'class'             => array(),
      'label_class'       => array(),
      'input_class'       => array(),
      'return'            => false,
      'options'           => array(),
      'custom_attributes' => array(),
      'validate'          => array(),
      'default'           => '',
    );

    if( $args )
    {
      $this->args = apply_filters( 'woocommerce_form_field_args', wp_parse_args( $args, $defaults ), $key, $value );
    }

  }

  public function build_field( $key, $value = null )
  {

  }

  public function set_required( $required )
  {
    $this->required = $required;
  }

  public function is_required()
  {
    return $this->required;
  }
}

