retina:{
  el:'',
    init:function( el )
  {
    if( el[0] != undefined )
      this.el = el;
  },
  replace_images:function()
  {
    var retina_src = this.el.data('retina'),
      height     = this.el.attr('height'),
      width      = this.el.attr('width');

    this.el.attr('src', retina_src ).css( 'height', height ).css( 'width', width );
  },
  is_retina: function()
  {
    if( window.matchMedia )
    {
      var mq = window.matchMedia( "only screen and (min--moz-device-pixel-ratio: 1.3), only screen and (-o-min-device-pixel-ratio: 2.6/2), only screen and (-webkit-min-device-pixel-ratio: 1.3), only screen and (min-device-pixel-ratio: 1.3), only screen and (min-resolution: 1.3dppx)" );

      return ( mq && mq.matches || ( window.devicePixelRatio > 1 ) );
    }
  }
}