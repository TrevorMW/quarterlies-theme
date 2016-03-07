;(function( $, window, undefined )
{
  // Extend jQuery object with custom object toolsets for building cool things & keeping things neat.

  $.extend({
    ajax_form:{
      el:'',
      action:'',
      init:function( el )
      {
        // SET BASIC PARAMETERS FOR JAVASCRIPT FORM SUBMISSION
        if( el[0] != undefined )
        {
          this.el           = el;
          this.action       = el.data('action');
          this.pre_callback = el.data('pre-callback')
        }
      },
      make_request: function( instance )
      {
        // MAKE AN OBJECT OUT OF ALL FORM DATA
        var formData = this.el.serializeArray(),
            data = {};

        for( var i = 0; formData.length > i; i++ )
        {
          data[formData[i].name] = formData[i].value;
        }

        data.action  = this.action;
        data.referer = data._wp_http_referer

        // FIRE OFF POST CALL
        $.post( ajax_url, data, function( response )
        {
          // PARSE THE RESPONSE FROM PHP SCRIPT. SHOULD BE AN INSTANCE OF AJAX_RESPONSE
          var new_data = $.parseJSON( response );

          // DETECT IF AJAX_RESPONSE HAS A CALLBACK METHOD SET, AND IF SO, FIND IT IN $.fn.callback_bank AND CALL THAT CALLBACK AND PASS IT THE FORM AND RESPONSE DATA
          if( $.fn.callback_bank.callbacks.hasOwnProperty( new_data.callback ) )
            $.fn.callback_bank.callbacks[new_data.callback]( new_data );
        });
      }
    },
    hero:{
      el:'',
      aspect_ratio: '',
      init:function( el )
      {
        if( el[0] != undefined )
          this.el = el;

        this.aspect_ratio = this.initial_ratio();

        if( this.aspect_ration != '' )
        {
          this.resize_hero();

          $(window).resize( this, function( e )
          {
            $(window).width() <= 768 ? e.data.remove_height() : e.data.resize_hero() ;
          })
        }
      },
      resize_hero:function( func )
      {
        setTimeout(function( data )
        {
          data.el.css('height', data.get_aspect_ratio_width() );

          data.el.addClass('active')

        }, 300, this )
      },
      get_aspect_ratio_width:function()
      {
        return parseInt( $(window).width() * this.aspect_ratio );
      },
      remove_hero_size:function()
      {
        setTimeout(function( data )
        {
          data.el.css('height','' );
        }, 300, this )
      },
      initial_ratio:function()
      {
        var img = this.el.closest('.hero-parent').find('[data-hero-img] img');

        return parseFloat( img.attr('height') / img.attr('width') );
      },
      remove_height:function()
      {
        this.el.css( 'height', '' );
      }
    },
    animation:{
      el:'',
      fx:'',
      init:function( el )
      {
        if( el[0] != undefined )
          this.el = el;
          this.fx = this.el.data('fx')
      },
      fire_animation:function()
      {
        this.el.addClass('animated ' + this.fx )
      }
    },
    callback_bank:{
      callbacks:
      {
        ajax_login:function( resp )
        {

        }
      }
    },
    wp_get:{
      action:'',
      init:function( action )
      {
        if( action != null )
        {
          this.action = action;
        }
      },
      make_request: function( before, after_request )
      {
        data        = {};
        data.action = this.action;

        if( typeof before == 'function' )
          data = before( data )

        $.post( ajax_url, data, function( response )
        {
          typeof after_request == 'function' ? after_request( data, $.parseJSON( response ) ) : '' ;
        });
      }
    },
    ajax_msg:{
      el:'',
      set_data:function( el )
      {
        if( el[0] != undefined )
        {
          this.el = el;
        }
      },
      fire_msg:function( msg, klass )
      {
        this.el.addClass( klass )
        this.el.html( msg );
        this.el.fadeIn();
      },
      reset_msg:function()
      {
        this.el.removeClass()
        this.el.hide();
      }
    }
  })

  // NORMAL DOC READY SCOPE

  $(document).ready(function()
  {
    if( $('[data-hero]')[0] != undefined )
      $.fn.hero.init( $('[data-hero]') );

    // CAPTURE FORM SUBMITS FROM ANY AJAX FORM
    if( $('[data-ajax-form]')[0] != undefined )
    {
      $('[data-ajax-form]').submit( function( e )
      {
        e.preventDefault();
        $.fn.ajax_form.init( $(this) );
        $.fn.ajax_form.make_request( $.fn.ajax_form );
      })
    }

  });

)( jQuery, window );