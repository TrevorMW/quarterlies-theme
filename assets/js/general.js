;(function( $, window, undefined )
{

  // GENERIC TOOLSETS FOR BADASSERY IN FRONT END

  $.fn.popup = {
    el:'',
    id:'',
    popup_exists:false,
    popup_open:false,
    halt_popup:false,
    set_data:function( popup_id )
    {
      if( popup_id != undefined )
      {
        var el = $('[data-popup='+ popup_id +']');
        if( el[0] != undefined )
        {
          this.id = popup_id;
          this.el = el;
          this.popup_exists = true;
          if( el.data('halt-popup') )
          {
            this.halt_popup = true;
          }
        }
      }
    },
    fire_popup:function( form, func )
    {
      this.el.addClass('active-popup');
      $('body').addClass('lock');
      this.popup_open = true;

      typeof func == 'function' ? func( form ) : '' ;
    },
    hide_popup:function( func )
    {
      this.el.removeClass('active-popup');
      $('body').removeClass('lock');
      this.popup_open = false;
      typeof func == 'function' ? func() : '' ;
    },
    continue_hide_popup:function( el, func )
    {
      this.el.removeClass('active-popup');
      $('body').removeClass('lock');
      this.popup_open = false;
      typeof func == 'function' ? func( form ) : '' ;
    },
    fill_popup_body:function( data )
    {
      this.el.find('[data-popup-addons-container]').html( data );
    }
  }

  $.fn.animation = {
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
  }

  $.fn.hero = {
    el:'',
    aspect_ratio: .3,
    init:function( el )
    {
      if( el[0] != undefined )
        this.el = el;

      this.resize_hero();

      $(window).resize( this, function( e )
      {
        e.data.resize_hero();
      })
    },
    resize_hero:function()
    {
      setTimeout(function( data )
      {
        data.el.css('height', data.get_aspect_ratio_width() )
      }, 300, this )
    },
    get_aspect_ratio_width:function()
    {
      return parseInt( $(window).width() * this.aspect_ratio );
    }
  }


  // NORMAL DOC READY SCOPE

  $(document).ready(function()
  {
    if( $('[data-hero]')[0] != undefined )
    {
      $.fn.hero.init( $('[data-hero]') );
    }

    if( $('[data-animation]')[0] != undefined )
    {
      $('[data-animation]').waypoint( function( direction )
      {
        $.fn.animation.init( $( $(this)[0].element ) );

        if( direction == 'down' )
        {
          $.fn.animation.fire_animation();
        }

      }, { offset: '90%' } )
    }

    if( $('[data-ajax-form]')[0] != undefined )
    {
      $('[data-ajax-form]').submit( function( e )
      {
        e.preventDefault();
        wp_ajax.init( $(this) );
        wp_ajax.make_request( wp_ajax );
      })
    }

    // INSTAFEED.JS SCRIPT

    if( $('#instafeed')[0] != undefined )
		{
			var feed = new Instafeed({
					get: 'user',
					userId:'2138532368',
					accessToken: $('#instafeed').data('instagram-id'),
					template: '<li data-animation data-fx="fadeInUp"><a href="{{link}}"><img src="{{image}}" alt="{{caption}}" /></a></li>',
					limit:'4',
					resolution:'standard_resolution',
					after:function()
					{
  					$('[data-animation]').waypoint( function( direction )
            {
              animation.init( $( $(this)[0].element ) );

              if( direction == 'down' )
              {
                animation.fire_animation();
              }

            }, { offset: '90%' } )
					}
			});

			feed.run();
		}

		if( $('[data-sticky]')[0] != undefined )
    {
      $('[data-sticky]').fixedsticky();
      $('[data-sticky]').parent().css('width', $('[data-sticky]').parent().width() )
    }

  });


  // AJAX FORM TOOLS

  $.fn.ajax_msg = {
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

  $.fn.wp_ajax = {
    el:'',
    action:'',
    init:function( el )
    {
      if( el[0] != undefined )
      {
        this.el           = el;
        this.action       = el.data('action');
        this.pre_callback = el.data('pre-callback')
      }
    },
    make_request: function( instance )
    {
      var formData = this.el.serializeArray();

      data = {};

      for( var i = 0; formData.length > i; i++ )
      {
        data[formData[i].name] = formData[i].value;
      }

      data.action  = this.action;
      data.referer = data._wp_http_referer

      if( this.pre_callback != '' && $.fn.callback_bank.pre_callbacks.hasOwnProperty( this.pre_callback ) )
        data = $.fn.callback_bank.pre_callbacks[this.pre_callback]( data );

      if( this.el.find('[data-progress]') != '' )
        progress.init( this.el.find('[data-progress]') );
        progress.show_progress();

      $.post( ajax_url, data, function( response )
      {
        var new_data = $.parseJSON( response );

        if( instance != undefined )
          new_data.form_msg = instance.el.find('[data-form-msg]')

        if( progress.el[0] != undefined )
          new_data.progress = progress;

          console.log( $.fn.callback_bank.callbacks.hasOwnProperty( new_data.callback ), new_data.callback )

        if( $.fn.callback_bank.callbacks.hasOwnProperty( new_data.callback ) )
          $.fn.callback_bank.callbacks[new_data.callback]( new_data );

        typeof after_request == 'function' ? after_request( data, new_data ) : '' ;
      });
    }
  }

  $.fn.callback_bank = {
    pre_callbacks:
    { // PRE_CALLBACKS **ALWAYS** NEED TO RETURN FORM DATA, REGARDLESS OF DOING ANYTHING WITH IT.
      before_form_submit:function( form_data )
      {
        return data;
      }
    },
    callbacks:
    {
      ajax_login:function( resp )
      {

      }
    }
  }

)( jQuery, window );