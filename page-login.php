<?php
/**
 * Template Name: Login Page
 * Description: Generic Sub Page Template
 *
 * @package WordPress
 * @subpackage themename
 */

get_header('login'); ?>

<main class="">
  <div class="loginLogo">
    <img src="<?php echo get_template_directory_uri() ?>/assets/static/images/pineapple.png" alt=""/>
    <h1>Lowcountry Reservations Generator</h1>
  </div>

  <div class="loginOrRegister">
    
    <div>
      <div class="login active">
        <form data-ajax-form class="stackedForm">
          <div data-form-msg></div>
          <input type="hidden" name="action" value="lrsgen_login" />
          <fieldset>
            <div class="full">
              <label for="username">User Name:</label>
              <input id="username" type="text" name="username" value="" placeholder="User Name..."/>
            </div>

            <div class="full">
              <label for="password">Password:</label>
              <input id="password" type="password" name="password" value="" placeholder="Password..." />
            </div>

            <div class="alignRight">
              <button class="btn btn-primary btn-small">Login</button>
            </div>

          </fieldset>
          
        </form>
      </div>
      
    </div>
  </div>
  <a href="" data-forgot-password>
    <span class="forgotPassword">Forgot your password? </span>
  </a>
</main>

<?php get_footer('login'); ?>
