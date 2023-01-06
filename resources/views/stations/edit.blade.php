@extends('layouts.stations')

@section('content')
          <div class="panel panel-default">
            <div class="panel-heading">
              <strong>Edit Station</strong>
            </div>
            {!! Form::model($station, ['files' => true, 'route' => ['stations.update', $station->id], 'method' => 'PATCH']) !!}

            @include("stations.form")

            {!! Form::close() !!}
          </div>
          <script>

          var connection;
          var ws_connected=false;
          // var reconnect_interval = setInterval(ws_init, 2000);
          function ws_init(){

            if(!ws_connected){
              connection = new WebSocket('ws://localhost:8080');
            }else{
              clearInterval(reconnect_interval);
            }

            connection.onopen = function () {
              ws_connected=true;
              connection.send(
                JSON.stringify(
                  {event: "user_connected",
                  user_id: {{ Auth::user()->id }},
                  station_id_: {{ $station->id }},
                  station_id: 9}
              )); // Send the message 'Ping' to the server

            };
            connection.onmessage = function (data) {
              console.log(data.data);
              try{
                var json_obj = JSON.parse(data.data);
                if(json_obj.event == "report_state"){
                  $('#line1').html(json_obj.line1);
                  $('#line2').html(json_obj.line2);
                  $('#line3').html(json_obj.line3);
                  $('#line4').html(json_obj.line4);
                }else if("station_status"){
                  if(json_obj.connected){
                    $('#station_status').html("Connected");
                  }else{
                    $('#station_status').html("Disconnected");
                  }

                }
              }catch(e){

              }

              // connection.send('Ping'); // Send the message 'Ping' to the server
            };

            connection.onclose = function (data){
              console.log("closed");
              ws_connected=false;
              reconnect_interval = setInterval(ws_init, 2000)
            }
          }



          function key_press(key){
            var json_str = JSON.stringify({
              event: "key_press",
              key: key,
              station_id: 9
            });
            connection.send(json_str);
          }

          function sync_now(){
            console.log("synch");
            connection.send(
              JSON.stringify(
                {event: "sync",
                user_id: {{ Auth::user()->id }},
                station_id_: {{$station->id}},
                station_id: 9
              }
            ));
          }
          function mirror_now(){
            console.log("report");
            $('#fuel_mirror').show();
            connection.send(
              JSON.stringify(
                {event: "report",
                user_id: 4,
                station_id_: {{$station->id}},
                station_id: 9,
                value: "true"
              }
            ));
          }
          function check_status(){
            console.log("report");
            connection.send(
              JSON.stringify(
                {event: "check_status",
                user_id: 4,
                station_id_: {{$station->id}},
                station_id: 9,
                value: "true"
              }
            ));
          }
          </script>

@endsection
