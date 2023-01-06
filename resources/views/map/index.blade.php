@extends('layouts.equipment')


@section('content')


	<h1> List of Equipment</h1>

	    <div class="panel panel-default">
	    	<div class="panel-heading clearfix">
	    		<div class="pull-left">
	    			<h4>Map</h4>
	    		</div>


	    	</div>

      </div>
      <div id="map"></div>
      @section('form-script')
      <script>
        var map;
        function initMap() {

          map = new google.maps.Map(document.getElementById('map'), {
            zoom: 14,
            center: new google.maps.LatLng(37.718379, -113.669644),
            mapTypeId: 'satellite'
          });

          // Create a <script> tag and set the USGS URL as the source.
          var script = document.createElement('script');
          // This example uses a local copy of the GeoJSON stored at
          // http://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/2.5_week.geojsonp
          script.src = 'https://developers.google.com/maps/documentation/javascript/examples/json/earthquake_GeoJSONP.js';
          document.getElementsByTagName('head')[0].appendChild(script);
        }

        // Loop through the results array and place a marker for each
        // set of coordinates.
        window.eqfeed_callback = function(results) {
        //   for (var i = 0; i < results.features.length; i++) {
        //     var coords = results.features[i].geometry.coordinates;
        //     var latLng = new google.maps.LatLng(coords[1],coords[0]);
        //     var marker = new google.maps.Marker({
        //       position: latLng,
        //       map: map
        //     });
        //   }


    //
        pivotOptions = {
      strokeColor: '#66FF33',
      strokeWeight: 7,
      fillColor: '#66FF33',
      fillOpacity: 0.35,
      // editable: true,
      clickable: true,
      map: map,
      center: new google.maps.LatLng(37.718294, -113.660744),
      radius: 400
    };
    newPivot = drawSector(37.718379, -113.669644, .25, 350, 338, 1);
    // newPivot = drawSector(37.718294, -113.660744, .25, 350, 369, 1);
    newPivot = new google.maps.Circle(pivotOptions);
    pivotOptions = {
  strokeColor: 'red',
  strokeWeight: 7,
  fillColor: 'red',
  fillOpacity: 0.35,
  // editable: true,
  clickable: true,
  map: map,
  center: new google.maps.LatLng(37.725727, -113.669886),
  radius: 400
  };
  newPivot = new google.maps.Circle(pivotOptions);

  drawArms(420, -113.669886, 37.725727, 400, 1, "PSI: 12", 1);
  drawArms(420, -113.669886, 37.725727, 400, 1, "PSI: 12", 2);
        }
        //Lat, Long, Radius (miles), Offset, degrees around, index
        function drawSector(lat, lng, r, azimuth, width, index) {
    // console.log("azimuth:" + azimuth + " width:" + width);
    var centerPoint = new google.maps.LatLng(lat, lng);
    var PRlat = (r/3963) * (180 / Math.PI); // using 3963 miles as earth's radius
    var PRlng = PRlat/Math.cos(lat*((Math.PI / 180)));
    var PGpoints = [];
    PGpoints.push(centerPoint);

    with (Math) {
      lat1 = lat + (PRlat * cos( ((Math.PI / 180)) * (azimuth  - width/2 )));
      lon1 = lng + (PRlng * sin( ((Math.PI / 180)) * (azimuth  - width/2 )));
      PGpoints.push( new google.maps.LatLng(lat1,lon1));

      lat2 = lat + (PRlat * cos( ((Math.PI / 180)) * (azimuth  + width/2 )));
      lon2 = lng + (PRlng * sin( ((Math.PI / 180)) * (azimuth  + width/2 )));

      var theta = 0;
      var gamma = ((Math.PI / 180)) * (azimuth  + width/2 );

      for (var a = 1; theta < gamma ; a++ ) {
      theta = ((Math.PI / 180)) * (azimuth  - width/2 +a);
      PGlon = lng + (PRlng * sin( theta ));
      PGlat = lat + (PRlat * cos( theta ));

      PGpoints.push(new google.maps.LatLng(PGlat,PGlon));
    }

    PGpoints.push( new google.maps.LatLng(lat2,lon2));
    PGpoints.push(centerPoint);
  }
  var poly = new google.maps.Polygon({
    path:PGpoints,
    strokeColor: 'gray',
    strokeWeight: 7,
    fillColor: 'gray',
    fillOpacity: 0.35,
    clickable: true,
    infoWindowIndex: index,
    map: map
  });

  poly.setMap(map);
  return poly;
  }

  function drawArms(AngleIn, longitude, latitude, radius, water, percent, deviceID){
    var color = "";
    if(water==1){
      color = '#1E90FF';
    }else{
      color = '#2F4F4F';
    }
    if(radius<1){
      radius = radius/0.25*400;
    }
    drawArm(AngleIn, latitude, longitude, radius-20, color, 7, deviceID, percent);
  }

  function drawArm(AngleIn, longitude, latitude, radius, color, stroke, deviceID, percent){


    var angle = -AngleIn * Math.PI / 180;
    var newlatitude = parseFloat(latitude) - (.00453 * radius / 400 * Math.sin(angle));
    var newlongitude = parseFloat(longitude) + (.00357 * radius / 400 * Math.cos(angle));
    var PivotLocation = [
      new google.maps.LatLng(longitude, latitude),
      new google.maps.LatLng(newlongitude, newlatitude)
    ];

    PivotArm = -1;

    if(PivotArm==-1){
      PivotArm = new google.maps.Polyline({
        deviceID: deviceID,
        path: PivotLocation,
        geodesic: true,
        strokeColor: color,
        strokeOpacity: 1.0,
        strokeWeight: stroke
      });
      var myLatLng = {lat: newlongitude, lng: newlatitude};
      var marker = new google.maps.Marker({
      position: myLatLng,
      map: map,
      draggable:true,
      animation: google.maps.Animation.DROP,
      title: 'Hello World!'
    });
    // google.maps.event.addListener(map, 'drag', function(e) {
    //               marker.setPosition(e.latLng);
    //           });
      // marker.addListener('drag', function(event){
      //   document.getElementById('lat').value = event.latLng.lat();
      //   document.getElementById('lng').value = event.latLng.lng();
      // });
      marker.addListener('dragend', function(event){
        PivotArm.setMap(null);
        PivotLocation = [
          // {lat: 37.725727, lng: -113.669886},
          // {lat: 37.772, lng: -122.214}
          new google.maps.LatLng(37.725727, -113.669886),
          new google.maps.LatLng(event.latLng.lat(), event.latLng.lng())
        ];
        PivotArm = new google.maps.Polyline({
        deviceID: deviceID,
        path: PivotLocation,
        geodesic: true,
        strokeColor: color,
        strokeOpacity: 1.0,
        strokeWeight: stroke
      });
      PivotArm.setMap(map);
      console.log(event.latLng.lat());
        // document.getElementById('lat').value = event.latLng.lat();
        // document.getElementById('lng').value = event.latLng.lng();
      });
      PivotArm.setMap(map);
      // arms.push(PivotArm);
    }else{
      PivotArm.setMap(null);
      PivotArm = new google.maps.Polyline({
        deviceID: deviceID,
        path: PivotLocation,
        geodesic: true,
        strokeColor: color,
        strokeOpacity: 1.0,
        strokeWeight: stroke
      });
      PivotArm.setMap(map);
      // arms.push(PivotArm);
    }
    // DrawLabel(AngleIn,longitude,latitude,percent,deviceID);
  }
  function DrawLabel(AngleIn,longitude,latitude,percent,deviceID){
    var side="center";
    Label = -1;

    var fontSizeInput = 14;
    if(percent=="%  psi"){
      percent="!";
      fontSizeInput=50;
      side = 'center';
    }

    if(Label==-1){

      var mapLabel = new MapLabel({
        deviceID:deviceID,
        text: percent,
        position: new google.maps.LatLng(longitude,latitude),
        map: map,
        fontSize: fontSizeInput,
        align: side,
        autoResize: true
      });
      labels.push(mapLabel);
    }else{
      Label.setMap(null);
      var mapLabel = new MapLabel({
        deviceID:deviceID,
        text: percent,
        position: new google.maps.LatLng(longitude,latitude),
        map: map,
        fontSize: fontSizeInput,
        align: side,
        autoResize: true
      });
      labels.push(mapLabel);
    }
  }
      </script>

      <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAs8W86hdyLehWfvAUu6ob4RQvBGI2uXD0&callback=initMap">
      </script>
      @endsection


@endsection
