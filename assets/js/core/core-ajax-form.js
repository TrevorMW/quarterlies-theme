/**
 * @package     AjaxForm
 * @version     1.0
 * @author     Trevor Wagner
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
}( this, function ($) {

  var AjaxForm = function(){

    var form  = {
      el: null,
      action: null,
      confirm: false,
      submit: null,
      url:null
    },
      data  = { formData: null },
      flags = { canSubmit:false  };

    return this;
  }

  AjaxForm.prototype.init = function( form, url )
  {
    if( form.length > 0 )
    {
      this.form.el     = form;
      this.form.submit = form.find('button[type="submit"]');
      this.form.action = form.data('action');
      this.form.url    = url;

      if( form.data('confirm') !== undefined )
      {
        this.form.confirm = form.data('confirm');
      }
    }

    this.collectData();

    if( this.confirmFormRequest() ){
      this.makeRequest( this );
    } else {
      $(document).trigger('loader:hide');
    }
  }

  AjaxForm.prototype.setObservers = function( ajax_url )
  {
    $(document).on( 'submit', '[data-ajax-form]', function(e)
    {
      e.preventDefault();

      var form    = $(this),
          formMsg = form.find('[data-form-msg]');

      $(document).trigger( 'formMsg:init', formMsg );
      this.init( $(this), ajax_url );
    });
  }

  AjaxForm.prototype.collectData = function()
  {
    this.data.formData = this.form.el.serialize();
  }

  AjaxForm.prototype.confirmFormRequest = function()
  {
    return this.form.confirm !== false ? confirm( this.form.confirm ) : true ;
  }

  AjaxForm.prototype.makeRequest = function()
  {
    $(document).trigger('loader:show').trigger('formMsg:clear');

    // Ajax POST call using native DW library.
    $.ajax({
      method:'POST',
      action:this.form.action,
      url:this.form.url,
      data:this.data.formData,
      success:this.formSuccess
    });
  }

  AjaxForm.prototype.formSuccess = function()
  {
    $(document).trigger('loader:hide');

    if( typeof resp == 'object' ){
      $(document).trigger('formMsg:show', resp );
    }
  }

  return AjaxForm;

}));