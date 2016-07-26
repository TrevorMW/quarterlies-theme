<?php
/**
 *
 * @package WordPress
 * @subpackage themename
 */

get_header(); the_post(); ?>

<div data-load-async="load_home_form" data-load-on="core:load:async"></div>

<form data-ajax-form>
  <input type="hidden" name="action" value="load_home_form" />
  <input type="text" name="hello" value="" />
  <button type="submit">Help</button>
</form>

<div data-load-async="load_home_post" data-load-on="core:form:success"></div>

<?php get_footer(); ?>
