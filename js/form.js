// JavaScript Document
var centro={
    map:false,
    position:false,
    marker:false,
    dragable:true,
    options:{
        
        
    },
    init:function(lat,lng,zoom)
    {
        var styles = [
          {
            stylers: [
              { hue: "#002b06" },
              { saturation: -70 }
            ]
          },{
            featureType: "road",
            elementType: "geometry",
            stylers: [
              { lightness: -10 },
              { visibility: "simplified" }
            ]
          },{
            featureType: "road",
            elementType: "labels",
            stylers: [
              { visibility: "off" }
            ]
          }
        ];
        centro.position={lat: lat, lng: lng};
        
        centro.options={
            zoom:zoom,
            center: centro.position,
    	    mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        
        centro.map = new google.maps.Map(document.getElementById('map'), centro.options);
        //centro.map.setOptions({styles: styles});
        
        
    },
    set_marker:function(position,map,data,url_icon,url)
    {
        
       
        
        var infowindow = new google.maps.InfoWindow();
        
        centro.marker = new google.maps.Marker({
			position: position,
			map: map,
			//title: data.title,
            draggable:centro.dragable,
            icon: url_icon,
            
            
               
			
        });
        if(data)
        {
            google.maps.event.addListener(centro.marker, 'click', function() {
               //location.href = url;
               
               infowindow.setContent('<div><strong>' + data.nombre + '</strong><br>' +
                  'Clave: ' + data.clave + '<br>' +
                  data.domicilio + '<br/><a href="'+url+'">Más información</a></div>');
                  infowindow.open(centro.map, this);
            });
        }
    },
    set_position:function(evt)
    {
        	$('#lat').val(evt.latLng.lat());
		    $('#lng').val(evt.latLng.lng());
    }
}

$(document).ready(function(){
    
    


		// Generate a slug from the title
		if ($('#page-form').data('mode') == 'create') {
			pyro.generate_slug('input[name="titulo"]', 'input[name="slug"]');
		}
        
        centro.init(lat?lat:19.833932192097134,lng?lng:-90.5467695763607,zoom?zoom:8);
        
        centro.set_marker(centro.position,centro.map);
        
        google.maps.event.addListener(centro.marker, 'dragend', function(event) {
		  centro.set_position(event);
		});
        
        google.maps.event.addListener(centro.map, 'zoom_changed', function() {
			$('#zoom').val(centro.map.getZoom());
			
			
		});
        
});
