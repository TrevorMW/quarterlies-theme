;(function($, window, undefined )
{
  var form_msg = {
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

  var popup = {
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

  var wp_ajax = {
    el:'',
    action:'',
    set_data:function( el )
    {
      if( el[0] != undefined )
      {
        this.el     = el;
        this.action = el.data('action');
      }
    },
    make_request: function( before_submit, after_request )
    {
      typeof before_submit == 'function' ? before_submit() : '' ;

      var formData = this.el.serializeArray();

      data = {};

      for( var i = 0; formData.length > i; i++)
      {
        data[formData[i].name] = formData[i].value;
      }

      data.action  = this.action;
      data.referer = data._wp_http_referer

      $.post( ajax_url, data, function(response)
      {
        var new_data = $.parseJSON( response );

        typeof after_request == 'function' ? after_request( new_data ) : '' ;
      });
    }
  }

  var wp_ajax_get = {
    action:'',
    set_data:function( action )
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

      typeof before_submit == 'function' ? before() : '' ;

      $.post( ajax_url, data, function( response )
      {
        var new_data = $.parseJSON( response );

        typeof after_request == 'function' ? after_request( new_data ) : '' ;
      });
    }
  }


  $(document).ready(function()
  {


  });


)( jQuery, window );