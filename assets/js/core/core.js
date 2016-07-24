;(function( $, window, undefined )
{
  // DEFINED GLOBAL EVENTS THAT CAN BE HOOKED INTO THROUGHOUT ALL LOADED JS.
  $(document).ready(function( e ){
    $(document).trigger('core:load', e ).trigger('core:asyncLoad', e );
  });

  $(window).resize(function( e ){
    $(document).trigger('core:resize', e );
  });

})( jQuery, window );
