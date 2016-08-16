/**
 * @package     AjaxForm
 * @version     1.0
 * @author     Trevor Wagner
 */

;(function ( $, window, undefined )
{
  var hero = function(){
    this.heros = [];
    this.hero = {
      el:'',
      img:'',
      aspect_ratio:''
    }
  };

  hero.prototype.init = function(){

    var heros = $('[data-hero]'),
        self  = this;

    if( heros.length > 0 ){
      self.heros = heros;
      heros.each(function(){
        self.el = $(this);
        self.aspect_ratio = self.initial_ratio();

        self.setObservers( $(this) );
      })
    }
  };

  hero.prototype.setObservers = function( el ){

    var self = this;

    $(document).on( 'core:resize', this, function(){
      self.resize_hero();
    })
  };


  hero.prototype.resize_hero = function( func ){
    setTimeout( function( data ){
      var height = data.img.height() <= data.get_aspect_ratio_width() ? data.img.height() : data.get_aspect_ratio_width();

      data.el.css( 'height', height );

      setTimeout( function( data ){
        data.el.addClass( 'active' )
      }, 300, data )

    }, 300, this )
  }

  hero.prototype.get_aspect_ratio_width = function(){
    return parseInt( $( window ).width() * this.aspect_ratio );
  }

  hero.prototype.remove_hero_size = function(){
    setTimeout( function( data )
    {
      data.el.css( 'height', '' );
    }, 250, this )
  }

  hero.prototype.initial_ratio = function(){
    this.img = this.el.closest( '.hero-parent' ).find( '[data-hero-img] img' );

    return parseFloat( this.img.attr( 'height' ) / this.img.attr( 'width' ) );
  }

  hero.prototype.remove_height = function(){
    this.el.css( 'height', '' );
  }

  $(document).on( 'core:load', function(){
    hero.init();
  })

})(jquery, window );