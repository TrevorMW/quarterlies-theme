<?php
/**
 *
 * @package WordPress
 * @subpackage themename
 */

get_header(); the_post(); ?>

<div data-load-async="load_home_form" data-load-on="core:load:async"></div>

<?php echo Template_Helper::loadView( 'template-form.php' )?>



<div data-load-async="load_home_post" data-load-on="core:form:success"></div>

<?php get_footer(); ?>
