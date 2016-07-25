;(function( $, window, undefined )
{
  // DEFINED GLOBAL EVENTS THAT CAN BE HOOKED INTO THROUGHOUT ALL LOADED JS.
  $(document).ready(function( e ){
    $(document).trigger('core:load').delay(500).trigger('core:load:async');
  });

  $(window).resize(function( e ){
    $(window).trigger('core:resize', e);
  });

})(jQuery, window );


