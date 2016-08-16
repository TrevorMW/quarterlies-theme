maps:{
  el:'',
    map:'',
    center:'',
    theme:'',
    zoom:15,
    load_map:false,
    point_data:null,
    icon_url:'',
    init:function( el, center, theme, point_data )
  {
    if( el[0] != undefined )
    {
      this.el         = el
      this.center     = new google.maps.LatLng({ lat: parseFloat( center.lat ), lng: parseFloat( center.lng ) })
      this.theme      = new google.maps.StyledMapType( theme )
      this.point_data = point_data
      this.icon_url   = el.data('map-icon')
      this.load_map   = true
    }

    if( this.el[0] != undefined && this.load_map )
      this.render_map();

    $(window).resize( this, function( e )
    {
      setTimeout( function( maps )
      {
        maps.map.setCenter( maps.center );
      }, 300, e.data );
    })
  },
  render_map:function()
  {
    this.map = new google.maps.Map( this.el[0], { center:this.center, zoom:this.zoom })

    this.map.mapTypes.set( 'custom_theme', this.theme );
    this.map.setMapTypeId( 'custom_theme' );

    if( this.point_data != null )
    {
      this.place_points();
    }
    else
    {
      new google.maps.Marker({
        position: this.center,
        map: this.map,
        icon:this.icon_url
      });
    }
  },
  place_points:function()
  {
    if( typeof this.point_data == 'object' )
    {
      var bounds = new google.maps.LatLngBounds();

      for( var i = 0; this.point_data.length > i; i++ )
      {
        if( typeof this.point_data[i] == 'object' && this.point_data[i].place_id != '' )
        {
          var point        = this.point_data[i],
            point_coords = new google.maps.LatLng({ lat: parseFloat( point.lat ), lng: parseFloat( point.lng ) })

          var marker = new google.maps.Marker({
            position: point_coords,
            map: this.map,
            icon:this.icon_url
          });

          bounds.extend( marker.getPosition() )

          this.set_place_data( point.place_id, marker );
        }
      }
    }

    this.map.fitBounds( bounds )
    this.map.setCenter( bounds.getCenter() );
  },
  set_place_data:function( id, marker )
  {
    var service    = new google.maps.places.PlacesService( this.map ),
      infowindow = new google.maps.InfoWindow();

    service.getDetails( { placeId: id }, function( place, status )
    {
      if( status == google.maps.places.PlacesServiceStatus.OK )
      {
        google.maps.event.addListener( marker, 'click', function()
        {
          infowindow.setContent( place.name );
          infowindow.open( this.map, this );
        });
      }
    });
  }
},