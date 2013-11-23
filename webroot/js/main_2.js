/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//Map goolge Maps
var map = undefined;
var markers = [];
var infoBubble = {};
var zoom_default;
var base_url=document.domain;


function getMarkerFormId(id){
	for (var i = 0; i < markers.length; i++) {
		if(markers[i].get('id') == id){
			return markers[i];
		}
	}
	return undefined;
}


//var companyLogo = base+'/img/marcador.png';
var companyLogo = new google.maps.MarkerImage('/img/markers/marker.png'
	,new google.maps.Size(48,45)
	,new google.maps.Point(0,0)
	,new google.maps.Point(32,36)
	);
	
function setMarkersBounds(){
	var bounds = new google.maps.LatLngBounds ();
	//  Go through each...
	for (var i = 0; i < markers.length; i++) {
		//  And increase the bounds to take this point
		bounds.extend(markers[i].getPosition());
	}
	//  Fit these bounds to the map
	map.fitBounds (bounds);
	zoom_default = 10;	
}



function addMarker(lat, lng, title, id){
	if(map != undefined){		
		
		//		var shadow = new google.maps.MarkerImage(base+'/images/markers/shadow.png',
		//			new google.maps.Size(29, 23),
		//			new google.maps.Point(0,0),
		//			new google.maps.Point(5, 23)
		//			);
		
		var latlng = new google.maps.LatLng(lat, lng);
		var marker;
		marker = new google.maps.Marker({
			position: latlng, 
			map: map,
			title:title,
			icon: companyLogo,
			zIndex:52
		});
		
		marker.set('id', id);
		//marker.set('content', content);
		markers.push(marker);
		var infowindow; 
		google.maps.event.addListener(marker, 'mouseover', function(){
			//			centerMap(lat, lng, 8,id);

			
			setTimeout(function() {
			
			
				$.ajax({
					url: '/sites/site_info/'+id,			
					dataType:"html",
					type:"POST",
					success:function (data, textStatus) {
						infowindow= new google.maps.InfoWindow({
							content: data,
							maxWidth: 300
						//						minWidth: 600
						});	 
						infowindow.open(map,marker);
					}
				});
			
			}, 500);
			
			
			
		});
		
		google.maps.event.addListener(marker,'mouseout',function(){
			setTimeout(function() {
				infowindow.close();
			}, 1000);

			
		});
		
		google.maps.event.addListener(marker, 'click', function(){
			window.location = "/sites/site_detail/"+id;
		});
	//		
		
		
	}
}

function info_content(id){
	marker = getMarkerFormId(id);
	$.ajax({
		url: '/sites/site_info/'+id,			
		dataType:"html",
		type:"POST",
		success:function (data, textStatus) {
			infowindow.setContent('contenido');
		//		 infowindow = new google.maps.InfoWindow({
		//				content: 'Hola, ¡estoy en Sevilla!'
		//			});
		//			infowindow.open(map, marker);
		}
	});
		
	
	
}



function centerMap(lat, lng, zoom,id){
	if(map != undefined){
		var latlng = new google.maps.LatLng(lat, lng);		
		//map.panTo(latlng);
		map.setCenter(latlng);		
		map.setZoom(zoom);		
	//		bubble(id);
	}
}


$(document).ready(function(){


	function initialize() {
		var myLatlng = new google.maps.LatLng(4.977907255559924, -73.71464306640623);
		var myOptions = {
			zoom: 5,
			center: myLatlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
	
		if($('#near_map_canvas').length > 0){
			myOptions.zoom = 9;
			//			myOptions.disableDefaultUI = true;		
			map = new google.maps.Map(document.getElementById('near_map_canvas'), myOptions);
			//			var position_Bounds = true;
			var n_position= 0;
			$('.location_sites').each(function(index){
				n_position++;
				var title = $(this).attr('data-title');
				var lat   = parseFloat($(this).attr('data-lat'));
				var lng   = parseFloat($(this).attr('data-long'));			
				var id	= $(this).attr('data-id');
				addMarker(lat, lng, title, id);			
			});
			
			setMarkersBounds();
			
		
			if(n_position == 1){	
						setTimeout(function() {
				map.setZoom(10);	
			}, 1000);
				
			}
		

		}
	}

	google.maps.event.addDomListener(window, 'load', initialize);		
});
