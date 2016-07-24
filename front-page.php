<?php
/**
 *
 * @package WordPress
 * @subpackage themename
 */

get_header(); the_post(); ?>

<div data-load-async="load_home_form" data-load-on="async:load"></div>

<form data-ajax-form data-action="load_home_form" data-confirm="true">
  <input type="text" name="hello" value="" />
  <button type="submit">Help</button>
</form>

<?php get_footer(); ?>
