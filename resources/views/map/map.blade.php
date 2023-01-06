@extends('layouts.map')
@section('title', 'Map View')
@section('content')

<!-- <div align="right">
  <span id="clock-since-update"></span> -
  <span id="clock-till-update"></span>
</div> -->
   <div id="map" style="display:inline-block; border:1px solid black; height: 68%;width: 32%;"></div>
   <div id="map-2" style="display:inline-block; border:1px solid black; height: 68%;width: 32%;"></div>
   <div id="map-3" style="display:inline-block; border:1px solid black; height: 68%;width: 32%;"></div>

   <br>
   <div  id="pivot-list"></div>

   <div onclick="reload()">
   <div style="display:inline-block; height: 30%;width: 23%;">
   <table class="table table-striped table-sm" style="font-size: 10px;" id="table-1">
   </table>
 </div>
 <div style="display:inline-block; height: 30%;width: 24%;">
   <table class="table table-striped table-sm" style="font-size: 10px;" id="table-2">
   </table>
 </div>
 <div style="display:inline-block; height: 30%;width: 24%;">
   <table class="table table-striped table-sm" style="font-size: 10px;" id="table-3">
   </table>
 </div>
 <div style="display:inline-block; height: 30%;width: 24%;">
   <table class="table table-striped table-sm" style="font-size: 10px;" id="table-4">
   </table>
 </div>
</div>

@endsection
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAs8W86hdyLehWfvAUu6ob4RQvBGI2uXD0"></script>
<script>

google.maps.event.addDomListener(window, "load", initMap);
var map;
var pivots = {};
var vectors = {};

function initMap() {
  var latitude = getUrlParameter('latitude');
  if(latitude == null){
    latitude=37.686844;
  }
  var longitude = getUrlParameter('longitude');
  if(longitude == null){
    longitude=-113.570636;
  }
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 12,
        center: new google.maps.LatLng(latitude, longitude),
        mapTypeId: 'satellite'
    });

    map_2 = new google.maps.Map(document.getElementById('map-2'), {
        zoom: 12,
        center: new google.maps.LatLng(37.808970, -113.788866),
        mapTypeId: 'satellite'
    });

    map_3 = new google.maps.Map(document.getElementById('map-3'), {
        zoom: 12,
        center: new google.maps.LatLng(37.650831, -113.667151),
        mapTypeId: 'satellite'
    });

    // Create a <script> tag and set the USGS URL as the source.
    var script = document.createElement('script');
    // This example uses a local copy of the GeoJSON stored at
    // http://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/2.5_week.geojsonp
    script.src = 'https://developers.google.com/maps/documentation/javascript/examples/json/earthquake_GeoJSONP.js';
    document.getElementsByTagName('head')[0].appendChild(script);
}

function update_pivot(pivot) {
    if (pivot.drive_status == 'forward') {
        set_fillColor = '#66FF33';
        set_strokeColor = '#66FF33';
    } else if (pivot.drive_status == 'reverse') {
        set_fillColor = 'orange';
        set_strokeColor = 'orange';
    } else {
        set_fillColor = 'red';
        set_strokeColor = 'red';
    }
    pivots[pivot.id].setOptions({
        strokeColor: set_strokeColor,
        fillColor: set_fillColor
    });
    draw_vector(pivot);
}
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
    return null;
};
function secondsToHms(d) {
    d = Number(d);
    var m = Math.floor(d % 3600 / 60);
    var s = Math.floor(d % 3600 % 60);

    var mDisplay = m > 0 ? (m < 10 ? "0" : "") + m + ":" : "00:";
    var sDisplay = s > 0 ? (s < 10 ? "0" : "") + s : "00";
    return mDisplay + sDisplay;
}
// var time=0;
// function update_time(){
//   time = time + 1;
//   var interval = getUrlParameter('interval');
//   if(interval == null){
//     interval=300;
//   }
//   document.getElementById("clock-since-update").innerHTML=secondsToHms(time);
//   document.getElementById("clock-till-update").innerHTML=secondsToHms(interval-time);
//   if(time==interval){
//     location.reload();
//     // update_map();
//   }
// }
function reload(){
  location.reload();
}
function add_pressure(pivot) {
  // $("#pivot-list").append('<a href="" class="list-group-item">' + pivot.name + '<span class="badge">' + pivot.pressure + ' psi</span></a>');
}
function draw_pivot(pivot, first_time) {
    add_pressure(pivot)
    if (pivot.width == 360) {
        if(pivot.is_connected){

          if (pivot.drive_status == 'forward') {
              set_fillColor = '#66FF33';
              set_strokeColor = '#66FF33';
          } else if (pivot.drive_status == 'reverse') {
              set_fillColor = 'orange';
              set_strokeColor = 'orange';
          } else {
              set_fillColor = 'red';
              set_strokeColor = 'red';
          }

          set_strokeColor = pivot.pump_status == "on" ? "rgba(66, 170, 244, 1)" : set_strokeColor;
        }else{
          set_fillColor = 'gray';
          set_strokeColor = 'gray';
        }
        pivotOptions = {
            strokeColor: set_strokeColor,
            strokeWeight: 7,
            fillColor: set_fillColor,
            fillOpacity: 0.35,
            map: map,
            center: new google.maps.LatLng(pivot.lat, pivot.lng),
            radius: pivot.radius / 3.28084
        };
        if(first_time){
          newPivot = new google.maps.Circle(pivotOptions);
          pivotOptions = {
              strokeColor: set_strokeColor,
              strokeWeight: 7,
              fillColor: set_fillColor,
              fillOpacity: 0.35,
              map: map_2,
              center: new google.maps.LatLng(pivot.lat, pivot.lng),
              radius: pivot.radius / 3.28084
          };
          newPivot = new google.maps.Circle(pivotOptions);
          pivotOptions = {
              strokeColor: set_strokeColor,
              strokeWeight: 7,
              fillColor: set_fillColor,
              fillOpacity: 0.35,
              map: map_3,
              center: new google.maps.LatLng(pivot.lat, pivot.lng),
              radius: pivot.radius / 3.28084
          };
          newPivot = new google.maps.Circle(pivotOptions);
        }else{
          pivots[pivot.id].setOptions({
              strokeColor: set_strokeColor,
              fillColor: set_fillColor
          });
        }

        draw_vector(pivot);
    } else {
        newPivot = drawSector(pivot);
        draw_vector(pivot);
    }
    pivots[pivot.id] = newPivot;

    // var mapLabel = new MapLabel({
    //     text: 12,
    //     position: new google.maps.LatLng(37.718294, -113.660744),
    //     map: map,
    //     fontSize: 12,
    //     align: "center",
    //     autoResize: true
    // });
}

function draw_vector(pivot) {
    AngleIn = pivot.angle;
    latitude = pivot.lat;
    longitude = pivot.lng;
    radius = pivot.radius / 3.28084;
    if(pivot.is_connected){
      color = "rgba(255, 246, 0, .7)";
    }else{
      color = "gray";
    }

    stroke = 7;
    percent = 12;

    var angle = -AngleIn * Math.PI / 180;
    var newlongitude = parseFloat(longitude) - (.00453 * radius / 400 * Math.sin(angle));
    var newlatitude = parseFloat(latitude) + (.00357 * radius / 400 * Math.cos(angle));
    var PivotLocation = [
        new google.maps.LatLng(latitude, longitude),
        new google.maps.LatLng(newlatitude, newlongitude)
    ];

    if (pivot.id in vectors) {
        vectors[pivot.id].setMap(null);
        PivotArm = new google.maps.Polyline({
            path: PivotLocation,
            geodesic: true,
            strokeColor: color,
            strokeOpacity: 1.0,
            strokeWeight: stroke
        });
        PivotArm.setMap(map);
        vectors[pivot.id] = PivotArm;
    } else {
        PivotArm = new google.maps.Polyline({
            path: PivotLocation,
            geodesic: true,
            strokeColor: color,
            strokeOpacity: 1.0,
            strokeWeight: stroke
        });
        PivotArm_2 = new google.maps.Polyline({
            path: PivotLocation,
            geodesic: true,
            strokeColor: color,
            strokeOpacity: 1.0,
            strokeWeight: stroke
        });
        PivotArm_3 = new google.maps.Polyline({
            path: PivotLocation,
            geodesic: true,
            strokeColor: color,
            strokeOpacity: 1.0,
            strokeWeight: stroke
        });
        PivotArm.setMap(map);
        PivotArm_2.setMap(map_2);
        PivotArm_3.setMap(map_3);
        vectors[pivot.id] = PivotArm;
    }
}

// Loop through the results array and place a marker for each
// set of coordinates.

window.eqfeed_callback = function(results) {
  update_map();
}

var first_time = true;
function update_map() {

    $.ajax({
        url: "{{ route("map.index") }}",
        method: 'get',
        data: {
            equipment_id: 12,
            _token: $("input[equipment_id=_token]").val()
        },
        context: document.body,
        success: function(pivots) {
          if(first_time){
            // setInterval(function(){ update_time(); }, 1000);
            var obj = jQuery.parseJSON(pivots);
            var parts = obj.length/4;
            for (var i = 0; i < obj.length; i++) {
                draw_pivot(obj[i], true);
                var status_text = '<tr><td>' + obj[i].name + '</td><td>' + obj[i].control_mode + ', ' + obj[i].speed_percent + '%, ' + obj[i].pressure + ' psi</td></tr>';
                if(!obj[i].is_connected){
                  status_text = '<tr><td>' + obj[i].name + '</td><td>Disconnected</td></tr>';
                }
                if(i<parts){
                  $('#table-1').append(status_text);
                }else if(i<parts*2){
                  $('#table-2').append(status_text);
                }else if(i<parts*3){
                  $('#table-3').append(status_text);
                }else if(i<parts*4){
                  $('#table-4').append(status_text);
                }

                // $("#pivot-list").append('<a href="" class="list-group-item">' + pivot.name + '<span class="badge">' + pivot.pressure + ' psi</span></a>');
            }
            first_time=false;
          }else{
            var obj = jQuery.parseJSON(pivots);
            for (var i = 0; i < obj.length; i++) {
                draw_pivot(obj[i], false);
            }
          }

            // obj[0].angle = 200;
            // obj[0].drive_status = "stopped";
            // update_pivot(obj[0]);
        }
    });
}

//Lat, Long, Radius (miles), Offset, degrees around, index
function drawSector(pivot) {
    lat = pivot.lat;
    lng = pivot.lng;
    r = pivot.radius;
    azimuth = pivot.azimuth;
    width = pivot.width;
    index = pivot.id;
    if(pivot.is_connected){

      if (pivot.drive_status == 'forward') {
          set_fillColor = '#66FF33';
          set_strokeColor = '#66FF33';
      } else if (pivot.drive_status == 'reverse') {
          set_fillColor = 'orange';
          set_strokeColor = 'orange';
      } else {
          set_fillColor = 'red';
          set_strokeColor = 'red';
      }

      set_strokeColor = pivot.pump_status == "on" ? "rgba(66, 170, 244, 1)" : set_strokeColor;
    }else{
      set_fillColor = 'gray';
      set_strokeColor = 'gray';
    }
    r = r * 0.000189394;
    // console.log("azimuth:" + azimuth + " width:" + width);
    var centerPoint = new google.maps.LatLng(lat, lng);
    var PRlat = (r / 3963) * (180 / Math.PI); // using 3963 miles as earth's radius
    var PRlng = PRlat / Math.cos(lat * ((Math.PI / 180)));
    var PGpoints = [];
    PGpoints.push(centerPoint);

    with(Math) {
        lat1 = lat + (PRlat * cos(((Math.PI / 180)) * (azimuth - width / 2)));
        lon1 = lng + (PRlng * sin(((Math.PI / 180)) * (azimuth - width / 2)));
        PGpoints.push(new google.maps.LatLng(lat1, lon1));

        lat2 = lat + (PRlat * cos(((Math.PI / 180)) * (azimuth + width / 2)));
        lon2 = lng + (PRlng * sin(((Math.PI / 180)) * (azimuth + width / 2)));

        var theta = 0;
        var gamma = ((Math.PI / 180)) * (azimuth + width / 2);

        for (var a = 1; theta < gamma; a++) {
            theta = ((Math.PI / 180)) * (azimuth - width / 2 + a);
            PGlon = lng + (PRlng * sin(theta));
            PGlat = lat + (PRlat * cos(theta));

            PGpoints.push(new google.maps.LatLng(PGlat, PGlon));
        }

        PGpoints.push(new google.maps.LatLng(lat2, lon2));
        PGpoints.push(centerPoint);
    }
    var poly = new google.maps.Polygon({
        path: PGpoints,
        strokeColor: set_strokeColor,
        strokeWeight: 7,
        fillColor: set_fillColor,
        fillOpacity: 0.35,
        clickable: true,
        infoWindowIndex: index,
        map: map
    });
    var poly_2 = new google.maps.Polygon({
        path: PGpoints,
        strokeColor: set_strokeColor,
        strokeWeight: 7,
        fillColor: set_fillColor,
        fillOpacity: 0.35,
        clickable: true,
        infoWindowIndex: index,
        map: map
    });
    var poly_3 = new google.maps.Polygon({
        path: PGpoints,
        strokeColor: set_strokeColor,
        strokeWeight: 7,
        fillColor: set_fillColor,
        fillOpacity: 0.35,
        clickable: true,
        infoWindowIndex: index,
        map: map
    });

    poly.setMap(map);
    poly_2.setMap(map_2);
    poly_3.setMap(map_3);
    return poly;
}

function DrawLabel(AngleIn, longitude, latitude, percent, deviceID) {
    var side = "center";
    Label = -1;

    var fontSizeInput = 14;
    if (percent == "%  psi") {
        percent = "!";
        fontSizeInput = 50;
        side = 'center';
    }

    if (Label == -1) {

        var mapLabel = new MapLabel({
            text: percent,
            position: new google.maps.LatLng(longitude, latitude),
            map: map,
            fontSize: fontSizeInput,
            align: side,
            autoResize: true
        });
        labels.push(mapLabel);
    } else {
        Label.setMap(null);
        var mapLabel = new MapLabel({
            text: percent,
            position: new google.maps.LatLng(longitude, latitude),
            map: map,
            fontSize: fontSizeInput,
            align: side,
            autoResize: true
        });
        labels.push(mapLabel);
    }
}
</script>
