;(function( $, window, undefined )
{
  // DEFINED GLOBAL EVENTS THAT CAN BE HOOKED INTO THROUGHOUT ALL LOADED JS.
  $(document).ready(function( e ){
    console.log( e)
    $(document).trigger('core:load', e).delay(500).trigger('core:asyncLoad', e);
  });

  $(window).resize(function( e ){
    $(document).trigger('core:resize', e);
  });

  $(document).on( 'core:load', function(){
    alert('core loaded');
  });

  $(document).on( 'core:asyncLoad', function(){
    alert('core loaded');
  })

})( jQuery, window );
