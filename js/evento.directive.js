(function () {
    'use strict';
    
    angular.module('app.eventos')
    .directive('gMap',['$rootScope','gMapService',gMap])
    .factory('gMapService',[FactMap]);
    
    
    function FactMap()
    {
        
        var map = {
            zoom:0,
            lng:0,
            lat:0,
            
        }
        var data= {
            
            zoom:12,
            lng:0,
            lat:0,
            getLngLat :function()
            {
                return map;
            },
            setLngLat : function(lng,lat)
            {
                
               map.lng = lng;
               map.lat = lat;
                
            },
            setZoom :function(zoom)
            {
                map.zoom = zoom;
               
            }
        }
         return data;
    }
    function gMap($rootScope,gMapService)
    {
        
        return {
               
               
               
                restrict: 'A',
                scope:{
                    zoom:'=',
                    lng:'=',
                    lat:'=',
                    map:'='
                },
                ///template:'<div  id="map"  class="col-sm-6" style="height: 400px;">as</div>',
                controller:'InputCtrl',
                //controllerAs:'vm',
                 
                link:function propiedades(scope,element,attr){
                    
                    //console.log(document.getElementById('map'));
                    scope.zoom = 25;
                    
                    var position = {
                        lat:  parseFloat(attr.glat), lng: parseFloat(attr.glng)
                    };
                    var options = {
                        zoom:parseInt(attr.gzoom),
                        center: position,
                	    mapTypeId: google.maps.MapTypeId.ROADMAP
                    };
                    
                    
                    var map = new google.maps.Map(element.context, options);
                    
                    var marker = new google.maps.Marker({
            			position: position,
            			map: map,
            			//title: data.title,
                        draggable:true,
                        //icon: url_icon,
                        
                        
                           
            			
                    });
                    
                     google.maps.event.addListener(marker, 'dragend', function(event) {
            		        //console.log(event.latLng.lng());
                           // scope.lng = event.latLng.lng();
                           // scope.lat = event.latLng.lat();
                            
                           // gMapService.setLngLat(event.latLng.lng(),event.latLng.lat());
                            
                            
                            //scope.zoom = gMapService.zoom;
                            
            		 });
                     
                     google.maps.event.addListener(map, 'zoom_changed', function() {
            			//gMapService.setZoom(map.getZoom());
                        //console.log(gMapService.getLngLat());
                        //scope.lat =0.5;
                        //scope.gzoom = map.getZoom();
            			///console.log( map.getZoom());
                        
                        $rootScope.zoom = map.getZoom();
            			//gMapService.zoom = map.getZoom();
            		});
                }
           };
        
    }
    
    
})();