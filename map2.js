var rId;
var returnedPolyline;
var routeIdToLoad; 
var mypolyline;
//set center to Upland
var center = new GLatLng(40.45916, -85.496243);

function addEvent(elm, evType, fn, useCapture) {
	// cross-browser event handling for IE5+, NS6 and Mozilla
	// By Scott Andrew
	if (elm.addEventListener) {
	elm.addEventListener(evType, fn, useCapture);
	return true;
	} else if (elm.attachEvent) {
	var r = elm.attachEvent('on' + evType, fn);
	EventCache.add(elm, evType, fn);
	return r;
	} else {
	elm['on' + evType] = fn;
	}
}


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
	
function drawMap(){
	if (!document.getElementById) return;
	//if (!Sarissa) return;
	if (GBrowserIsCompatible()) { 
		// Display the map, with some controls and set the initial location to Upland 
		map = new GMap(document.getElementById("div_map")); 
		map.addControl(new GLargeMapControl()); 
		map.addControl(new GMapTypeControl()); 
		map.setCenter(center, 13, G_NORMAL_MAP);
			
		mypolyline = [];
		startmarker = false;
		endmarker = false;
		editline = false;
			
		var tmp = createMarker(new GLatLng(57.0,-5.0), "Marker 1", "loc", "I am not part of the line");
		map.addOverlay(tmp);
		var tmp = createMarker(new GLatLng(50.0,-2.0), "Marker 2", "loc", "I am not part of the line");
		map.addOverlay(tmp);
			
		GEvent.addListener(map, "click", function(overlay, point) { 
			if (point){ 	// background clicked
			mypolyline.push(point); 
			renderLine(); 
			} else if (overlay) {   // marker clicked
				if (overlay.type=="start"){
					mypolyline.shift();
					} else if (overlay.type == "end"){ 
					mypolyline.pop(); 
			} else {	// not a start or end marker
					//overlay.openInfoWindowHtml("I am an address marker");
			}
				renderLine(); 
			} 
		}); 
	} else { 
		alert("Sorry, the Google Maps API is not compatible with this browser"); 
	} 

}
//----------------------------------------------------------------------------------------------------------
//Start clicking stuff
//----------------------------------------------------------------------------------------------------------
//Clicked a link
function clickedDistance(){
	alert(calcDistance());
	return false;
}
function clickedFinish(){
	finishRoute();
	return false;
}
function clickedSave(){
	saveRoute();
	return false;
}

function clickedClear(){
	clearRoute();
	return false;
}
//----------------------------------------------------------------------------------------------------------
//End clicking stuff
//----------------------------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------------------------
//Start geocoder stuff
//----------------------------------------------------------------------------------------------------------
var geocoder = new GClientGeocoder();

function showAddress(address) {
  geocoder.getLatLng(
    address,
    function(point) {
      if (!point) {
        alert(address + " not found");
      } else {
        map.setCenter(point, 13);
        var marker = new GMarker(point);
        map.addOverlay(marker);
      }
    }
  );
}
//----------------------------------------------------------------------------------------------------------
//End geocoder stuff
//----------------------------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------------------------
//Start calculate distance stuff
//----------------------------------------------------------------------------------------------------------
//returns distance of current polyline in miles
function calcDistance(){
	var temp;
	var tempArray = mypolyline;
	var distance = 0;
	var point1;
	var point2;
	var i;
	
	for (i = 0; i < (tempArray.length - 1); i++){
		point1 = tempArray[i];
		point2 = tempArray[i+1];
		distance = distance + point1.distanceFrom(point2);
	}
	distance = distance*0.000621371192;
	
	return distance;
}
//----------------------------------------------------------------------------------------------------------
//End calculate distance stuff
//----------------------------------------------------------------------------------------------------------



//----------------------------------------------------------------------------------------------------------
//Start clear route stuff
//----------------------------------------------------------------------------------------------------------
function clearRoute(){
	mypolyline = [];
	renderLine();
}
//----------------------------------------------------------------------------------------------------------
//End clear route stuff
//----------------------------------------------------------------------------------------------------------



//----------------------------------------------------------------------------------------------------------
//finishing route stuff
//----------------------------------------------------------------------------------------------------------
function finishRoute(){
	if((mypolyline.length > 1) && (mypolyline[0] != mypolyline[mypolyline.length - 1])){
		mypolyline.push(mypolyline[0]);
		renderLine();
	}else{
		alert("Can't finish this route");
	}
}

//----------------------------------------------------------------------------------------------------------
//End finishing route stuff
//----------------------------------------------------------------------------------------------------------


//----------------------------------------------------------------------------------------------------------
//Saving stuff
//Need to add a call to distance function before we save
//----------------------------------------------------------------------------------------------------------
//changes the polyline array into a string for the array
function createPolylineString(){
	tempArray = mypolyline;
	var tString = '';
	
	for (var i = 0; i<tempArray.length; i++){
		
			tString += tempArray[i].lat() + 'a' + tempArray[i].lng();
			
			if (i < tempArray.length - 1) {
			
				tString += 'a';
			
			}
		
		}
		
		return tString;
	
}
//function to save the route
function saveRoute(){
	url = "saveRoute.php" + '?polyline='+createPolylineString()+"&distance="+calcDistance();
	//alert(url);
	//var request = GXmlHttp.create();
	var request = new XMLHttpRequest();
	
	request.open("GET", url, false);		
	request.onreadystatechange = function() {
		if (request.readyState == 4) {
			rId = request.responseText;
		}
	}
	request.send(null);
}
//----------------------------------------------------------------------------------------------------------
//End of save stuff
//----------------------------------------------------------------------------------------------------------

function clickedLoad(id){
	routeIdToLoad = id;
	loadRoute();
	//setTimeout("alert(returnedPolyline);", 5000);
	return false;
}
//----------------------------------------------------------------------------------------------------------
//Loading stuff
//----------------------------------------------------------------------------------------------------------
function loadRoute(){
	url = "getRoute.php" + '?rId='+routeIdToLoad;
	//var request = GXmlHttp.create();
	var request = new XMLHttpRequest();
	
	request.open("GET", url, false);		
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
//----------------------------------------------------------------------------------------------------------
//End of Loading Stuff
//----------------------------------------------------------------------------------------------------------

addEvent(window, 'load', drawMap, false);