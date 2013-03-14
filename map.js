var routeIdToLoad;


function createMarker(point,name,type,html) { 
		var marker = new GMarker(point); 
		marker.name = name;
		marker.type = type;
		marker.html = html;
		return marker; 
	}
	function renderLine(){ 
		map.removeOverlay(startmarker); 
		map.removeOverlay(endmarker); 
		map.removeOverlay(editline);
		if (mypolyline.length){
			editline = new GPolyline(mypolyline,"#0000FF", 2, 1)
			map.addOverlay(editline);
			startmarker=new GMarker(mypolyline[0]); 
			startmarker.type="start"; 
			map.addOverlay(startmarker); 
			endmarker=new GMarker(mypolyline[mypolyline.length-1]); 
			endmarker.type="end"; 
			map.addOverlay(endmarker); 
		}
	} 
	
	function drawMap(id){
		routeIdToLoad = id;
		
		if (GBrowserIsCompatible()) { 
			// Display the map, with some controls and set the initial location to Upland 
			map = new GMap(document.getElementById("div_map")); 
			map.addControl(new GLargeMapControl()); 
			map.addControl(new GMapTypeControl()); 
			map.setCenter(new GLatLng(40.476725355504186, -85.49903869628906), 13, G_NORMAL_MAP);
			
			mypolyline = [];
			startmarker = false;
			endmarker = false;
			editline = false;
			
			var tmp = createMarker(new GLatLng(57.0,-5.0), "Marker 1", "loc", "I am not part of the line");
			map.addOverlay(tmp);
			var tmp = createMarker(new GLatLng(50.0,-2.0), "Marker 2", "loc", "I am not part of the line");
			map.addOverlay(tmp);
			
			loadRoute();
		} else { 
			alert("Sorry, the Google Maps API is not compatible with this browser"); 
		} 
	}
	
function loadRoute(){
	var url = "getRoute.php" + '?rId='+routeIdToLoad;
	//var request = GXmlHttp.create();
	var request = new XMLHttpRequest();
	
	request.open("GET", url, true);		
	request.onreadystatechange = function() {
		if (request.readyState == 4) {
			drawSavedPolyline(request.responseText);
		}
	}
	request.send(null);
}

function drawSavedPolyline(tempPolyline){
	var tempArray = new Array();
	var tempArrayPoints = new Array();
	
	
	tempArray = tempPolyline.split("a");

	for( var i = 0; i < tempArray.length; i += 2){
		tempArrayPoints.push(new GLatLng(tempArray[i],tempArray[i+1])); 
	}
	mypolyline = tempArrayPoints;
	renderLine();
	map.setCenter(mypolyline[0], 13);
}
