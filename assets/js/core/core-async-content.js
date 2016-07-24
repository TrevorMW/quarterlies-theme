/**
 * @package     core-async-content
 * @version     1.0
 * @author      Trevor Wagner
 */

(function (root, factory)
{
  if (typeof exports === 'object')
  {
    module.exports = factory( window.jQuery );
  }
  else if ( typeof define === 'function' && define.amd )
  {
    define( ['jquery'], function( jquery ) {
      return (factory( jquery ));
    });
  }
}(this, function ($) {

  var asyncLoad = {

  };

  $(document).on("core:load",function()
  {
    asyncLoad.setObservers();
  });

  return asyncLoad;
}));