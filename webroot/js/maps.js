var map;
var marker;
var selectedMarker;
var servicepoint= new Array();
var centerMarker;
var markers= new Array();
var flightPath;


function map_places() {
	var latlng = null;
	var latitude = null;
	var longitude = null;
	var geo = false;
	var z = 10;
	var all_items = null;
	
	latlng = new google.maps.LatLng(41.38792, 2.16992);
	
	
	var myOptions = {
		zoom: z,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	
	all_items= jQuery(".item-place");
	
	for (i = 0; i < all_items.length; i++) {
		
		//Agrego los marcadores que se muestran en la lista de lugares
		latitude=jQuery(all_items[i]).attr('lat');
		longitude=jQuery(all_items[i]).attr('long');
		
		latlng = new google.maps.LatLng(latitude, longitude);
		marker= new google.maps.Marker({
			position: latlng,
			map: map
		});
		markers.push(marker);
		
		
		//Tooltips/ ventaja de mensaje que contiene la informacion del lugar
		var infowindow;
			
		google.maps.event.addListener(marker,'mouseover',function(event){

			latitude=	event.latLng.lat();
			longitude=	event.latLng.lng();
			
			if(infowindow != null){
				infowindow.close();
			}
			
			for(j=0;j<markers.length;j++){
				var aux=markers[j].getPosition();
				
				if(aux.lat()==latitude && aux.lng()==longitude){
					
					marker=markers[j];
					//img= jQuery(all_items[j]).contents().find(".item-place").html();
					
					item = jQuery(all_items[j]);
					img = jQuery(item[0]).children('.image-place')[0].src;
					
					//console.log(img);
					
					name=jQuery(all_items[j]).contents().find(".item-place-title").text();
					info_place=jQuery(item[0]).children('.item-place-info');
					text_place= jQuery(info_place[0]).html();
					
					link_place =jQuery(item[0]).children('.red_view_all');
					link= jQuery(link_place[0]).html();
					
					console.log(link);
					
					contentString=
					"<div class='info-window'>"+
					"<img class='inforwindow-image' src='"+img+"'>"+
					"<p class='infowindow-title'>"+name+"</p>"+
					"<div class='infowindow-info'>"+text_place+"</div>"+
					"<div class='link-locale'>"+link+"</div>"+
					"</div>";
					//alert(contentStrig);
					infowindow = new google.maps.InfoWindow({
						content: contentString,
						pixelOffset: new google.maps.Size(0, 10)
					});
					infowindow.open(map,marker);
					break;
				}
			}			
		});
		
	}	
}

function initialize_view() {
	var ll = jQuery('#map_canvas').attr('geo');
	var latlng = null;
	var geo = false;
	var z = 10;
	if(ll != undefined){
		geo = true;
		ll = ll.split(",");
		latlng = new google.maps.LatLng(ll[0], ll[1]);
		z = 16;
	}else if(jQuery(".latitude").length > 0) {
		latlng = new google.maps.LatLng(jQuery(".latitude").val(), jQuery(".longitude").val());
		
		if(latlng.lat() == 0 && latlng.lng() == 0){
			z = 2;
		} else {
			z = 14;
		}
	}
	else {
		latlng = new google.maps.LatLng(40.371, -3.718);
	}
	

	var myOptions = {
		zoom: 15,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	var map = new google.maps.Map(document.getElementById("map_canvas"),
		myOptions);		

	var site = new google.maps.MarkerImage('/img/markers/marker.png'
		//		,new google.maps.Size(48,45)
		//		,new google.maps.Point(0,0)
		//		,new google.maps.Point(32,36)
		);
	centerMarker = new google.maps.Marker({
		position: map.getCenter(),
		map: map,
		icon:site
		
		
	}); 
	if(latlng.lat() != 41.38792 && latlng.lng() != 2.16992){
		setSelectedMarker(latlng);
	}
} 

function initialize() {
	var ll = jQuery('#map_canvas').attr('geo');
	var latlng = null;
	var geo = false;
	var z = 10;
	if(ll != undefined){
		geo = true;
		ll = ll.split(",");
		latlng = new google.maps.LatLng(ll[0], ll[1]);
		z = 16;
	}else if(jQuery(".latitude").length > 0) {
		latlng = new google.maps.LatLng(jQuery(".latitude").val(), jQuery(".longitude").val());
		
		if(latlng.lat() == 0 && latlng.lng() == 0){
			z = 2;
		} else {
			z = 14;
		}
	}
	else {
		latlng = new google.maps.LatLng(40.371, -3.718);
	}
	//	
	//	//mio
	//latlng = new google.maps.LatLng(41.389, 2.170);
	var myOptions = {
		zoom: 6,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	var map = new google.maps.Map(document.getElementById("map_canvas"),
		myOptions);
		
	centerMarker = new google.maps.Marker({
		position: map.getCenter(),
		map: map
	});
	if(!geo){
		google.maps.event.addListener(map,'center_changed',function(){
			centerMarker.setPosition(map.getCenter());
		});
	}
	
	if(latlng.lat() != 41.38792 && latlng.lng() != 2.16992){
		setSelectedMarker(latlng);
	}

	google.maps.event.addListener(centerMarker,'click',function(){
		if(confirm("Esta es la ubiciacion deseada?")){
			var location=centerMarker.getPosition();
			var lat=location.lat();
			var lng=location.lng();
			jQuery(".latitude").val(lat);
			jQuery(".longitude").val(lng);
			setSelectedMarker(location);
		}
	});
}
function setSelectedMarker(latlng){
	if(selectedMarker != undefined){
		selectedMarker.setMap(null);
		selectedMarker = undefined;
	}
	
	selectedMarker = new google.maps.Marker({
		position: latlng,
		icon: "http://www.google.com/intl/en_us/mapfiles/ms/micons/yellow-dot.png",
		map: map
	});
}


function geocode(address){
	//alert(baseurl+'proxies/geocode/'+address);
	jQuery.ajax({
		url: baseurl+'proxies/geocode',
		data: ({
			address:address
		}),
		crossDomain : false,
		success: function(data) {
			
			if(data.results.length > 0){
				centerMarker.setVisible(true);
				for (i = 0; i < data.results.length; i++) {
					var latlng = new google.maps.LatLng(data.results[i].geometry.location.lat, data.results[i].geometry.location.lng);
					var title = data.results[i].formatted_address;
					
					var image = "http://www.google.com/intl/en_us/mapfiles/ms/micons/blue-dot.png";
					
					marker = new google.maps.Marker({
						position: latlng,
						title: title,
						map: map,
						icon: image
					});
					
					google.maps.event.addListener(marker,'click',function(){
						if(confirm("Esta es la ubiciacion deseada?")){
							var location = this.getPosition();
							var lat=location.lat();
							var lng=location.lng();
							jQuery(".latitude").val(lat);
							jQuery(".longitude").val(lng);
							setSelectedMarker(location);
						}
					});
					
					markers.push(marker);
				}
				
				var bounds = new google.maps.LatLngBounds();
				for (i = 0; i < markers.length; i++ ){
					bounds.extend( markers[i].getPosition());
				}
				map.fitBounds(bounds);
			} else {
				centerMarker.setVisible(true);
			}
		}
	});
}

function getMapPlace(lat, lon){
	
	var myOptions = {
		zoom: 16,
		center: new google.maps.LatLng(lat, lon),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	map = new google.maps.Map(document.getElementById("map-place"), myOptions);
	
	marker= new google.maps.Marker({
		position: new google.maps.LatLng(lat, lon),
		map: map
	});
}

function getMapEvent(lat, lon){
	
	var myOptions = {
		zoom: 16,
		center: new google.maps.LatLng(lat, lon),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	map = new google.maps.Map(document.getElementById("map-event"), myOptions);
	
	marker= new google.maps.Marker({
		position: new google.maps.LatLng(lat, lon),
		map: map
	});
}