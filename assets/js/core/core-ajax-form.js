/**
 * @package     Blueacorn/AjaxForm
 * @version     1.0
 * @author      Blue Acorn <code@blueacorn.com>
 * @copyright   Copyright © 2016 Blue Acorn.
 */

(function (root, factory) {
  if (typeof exports === 'object') {
    module.exports = factory( window.jQuery );
  } else if (typeof define === 'function' && define.amd) {
    define(['jquery', 'baCore', 'ajaxJSON', 'validator' ], function( jquery ) {
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
      invalidFields:null
    },
    data: {
      formData: null,
      dataTarget: null
    },
    flags:{
      canSubmit:false
    },
    init: function( form ) {
      if (form.length > 0) {
        this.form.el     = form;
        this.form.submit = form.find('button[type="submit"]');
        this.form.action = form.data('action');

        if( form.data('confirm') !== undefined ){
          this.form.confirm = form.data('confirm');
        }
      }

      // Validate form using native DW $.validator plugin
      var result = validator.initForm( this.form.el );

      if( result.errorList.length <= 0 ){
        this.collectData();
        this.flags.canSubmit = this.confirmFormRequest();
      }

      if( this.flags.canSubmit ){
        this.makeRequest( this, ajax );
      } else {
        $(document).trigger('loader:hide');
      }
    },
    setObservers: function() {
      $(document).on('submit', '[data-ajax-form]', function(e) {
        e.preventDefault();
        var form    = $(this),
          formMsg = form.find('[data-form-msg]');

        $(document).trigger( 'formMsg:init', formMsg );
        AjaxForm.init( $(this) );
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
        url:this.form.action,
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

  $(document).on( "core:load",  function() {
    AjaxForm.setObservers( ajax, validator );
  });

  return AjaxForm;
}));