/**
 * @package     Blueacorn/AjaxForm
 * @version     1.0
 * @author      Blue Acorn <code@blueacorn.com>
 * @copyright   Copyright © 2016 Blue Acorn.
 */

(function (root, factory) {
  if (typeof exports === 'object') {
    module.exports = factory( window.jQuery );
  } else if ( typeof define === 'function' && define.amd ) {
    define(['jquery' ], function( jquery ) {
      return (factory( jquery ));
    });
  }
}(this, function ($) {

  var AjaxForm = {
    form: {
      el: null,
      action: null,
      confirm: false,
      submit: null,
      url:null,
    },
    data: {
      formData: null
    },
    flags:{
      canSubmit:false
    },
    init: function( form, url ) {
      if (form.length > 0) {
        this.form.el     = form;
        this.form.submit = form.find('button[type="submit"]');
        this.form.action = form.data('action');
        this.form.url    = url;

        if( form.data('confirm') !== undefined ){
          this.form.confirm = form.data('confirm');
        }
      }

      this.collectData();

      if( this.confirmFormRequest() ){
        this.makeRequest( this );
      } else {
        $(document).trigger('loader:hide');
      }
    },
    setObservers: function( ajax_url ) {
      $(document).on('submit', '[data-ajax-form]', function(e) {
        e.preventDefault();
        var form    = $(this),
          formMsg = form.find('[data-form-msg]');

        $(document).trigger( 'formMsg:init', formMsg );
        AjaxForm.init( $(this), ajax_url );
      });
    },
    collectData: function() {
      this.data.formData = this.form.el.serialize();
    },
    confirmFormRequest: function() {
      return this.form.confirm !== false ? confirm( this.form.confirm ) : true ;
    },
    makeRequest: function( inst, ajax ) {
      $(document).trigger('loader:show').trigger('formMsg:clear');

      // Ajax POST call using native DW library.
      $.ajax({
        method:'POST',
        action:this.form.action,
        url:this.form.url,
        data:this.data.formData,
        success:this.formSuccess
      });
    },
    formSuccess:function( resp ){
      $(document).trigger('loader:hide');

      if( typeof resp == 'object' ){
        $(document).trigger('formMsg:show', resp );
      }
    }
  };

  $(document).on( "core:load core:asyncLoad", function() {
    console.log( wpAjax );
    AjaxForm.setObservers( wpAjax );
  });

  return AjaxForm;
}));