;(function( $, window, undefined )
{
  // DEFINED GLOBAL EVENTS THAT CAN BE HOOKED INTO THROUGHOUT ALL LOADED JS.
  $(document).ready(function()
  {
    $(document).trigger('core:load').trigger('core:asyncLoad');
  });

  $(window).resize(function()
  {
    $(document).trigger('core:resize');
  });

})( jQuery, window );
