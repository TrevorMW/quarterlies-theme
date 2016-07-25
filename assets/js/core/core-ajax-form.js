/**
 * @package     AjaxForm
 * @version     1.0
 * @author     Trevor Wagner
 */

;(function ( $, window, undefined ) {

  var AjaxForm = function(){

    this.form = {
      el: null,
      action: null,
      confirm: false,
      submit: null,
      url:null
    };
    this.data  = { formData: null };
    this.flags = { canSubmit:false  };

    return this;
  };

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

    if( this.confirmFormRequest() )
    {
      this.makeRequest( this );
    }
    else
    {
      $(document).trigger('core:loader:hide');
    }
  };

  AjaxForm.prototype.setObservers = function( inst, ajaxUrl )
  {
    $(document).on( 'submit', '[data-ajax-form]', { inst : inst, ajaxUrl : ajaxUrl }, function( e )
    {
      e.preventDefault();

      var form    = $(this),
          formMsg = form.find('[data-form-msg]');

      $(document).trigger( 'core:message:init', formMsg );
      inst.init( form, ajaxUrl );
    });
  };

  AjaxForm.prototype.collectData = function()
  {
    this.data.formData = this.form.el.serialize();
  };

  AjaxForm.prototype.confirmFormRequest = function()
  {
    return this.form.confirm !== false ? confirm( this.form.confirm ) : true ;
  };

  AjaxForm.prototype.makeRequest = function()
  {
    $(document).trigger('core:loader:show').trigger('core:message:clear');

    // Ajax POST call using native DW library.
    $.ajax({
      method:'POST',
      action:this.form.action,
      url:this.form.url,
      data:this.data.formData,
      success:this.formSuccess
    });
  };

  AjaxForm.prototype.formSuccess = function()
  {
    $(document).trigger('core:loader:hide');

    if( typeof resp == 'object' ){
      $(document).trigger('core:message:show', resp );
    }
  };

  $(document).on( 'core:load', function( e ){
    var ajaxForm = new AjaxForm( core.ajaxUrl );
    ajaxForm.setObservers( ajaxForm, core.ajaxUrl );
  })

})( jQuery, window );