
if (typeof jQuery === 'function') {
  define( 'jquery', function ()
  {
    return jQuery;
  });
}

requirejs.config({
  baseUrl: core.baseUrl,
  deps: [ "AjaxForm" ],
  paths: {
    AjaxForm: "core-ajax-form",
  }
});


define( ["jquery"], function( $ )
{
  var ajax = require('AjaxForm');


  // DEFINED GLOBAL EVENTS THAT CAN BE HOOKED INTO THROUGHOUT ALL LOADED JS.
  $(document).ready(function( e ){
    console.log( e )
    $(document).trigger('core:load', e).delay(500).trigger('core:asyncLoad', e);
  });

  $(window).resize(function( e ){
    $(document).trigger('core:resize', e);
  });

  $(document).on( 'core:load core:asyncLoad', function( e ) {
    var ajaxForm = new AjaxForm( wpAjax );
    ajaxForm.setObservers();
  });
});


