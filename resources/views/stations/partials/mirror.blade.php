@extends('layouts.generic')

@section('content')
          <div class="panel panel-default">
            <div class="panel-heading">
              <strong>Mirror Station</strong>
            </div>
            <div id="lcd_screen" style="height: 100px;width: 200px;background-color: green"></div>
            <div id="keypad">
              <table class="table">
                <tr>
                  <td><button class="btn" onclick="key_press('A')">^</button></td>
                  <td><button class="btn" onclick="key_press('B')">^</button></td>
                  <td><button class="btn" onclick="key_press('C')">^</button></td>
                  <td><button class="btn" onclick="key_press('D')">^</button></td>
                </tr>
                <tr>
                  <td><button class="btn" onclick="key_press('1')">1</button></td>
                  <td><button class="btn" onclick="key_press('2')">2</button></td>
                  <td><button class="btn" onclick="key_press('3')">3</button></td>
                  <td><button class="btn btn-danger" onclick="key_press('E')">Can</button></td>
                </tr>
                <tr>
                  <td><button class="btn" onclick="key_press('4')">4</button></td>
                  <td><button class="btn" onclick="key_press('5')">5</button></td>
                  <td><button class="btn" onclick="key_press('6')">6</button></td>
                  <td><button class="btn btn-warning" onclick="key_press('F')">Clr</button></td>
                </tr>
                <tr>
                  <td><button class="btn" onclick="key_press('7')">7</button></td>
                  <td><button class="btn" onclick="key_press('8')">8</button></td>
                  <td><button class="btn" onclick="key_press('9')">9</button></td>
                  <td><button class="btn btn-primary" onclick="key_press('G')">?</button></td>
                </tr>
                <tr>
                  <td><button class="btn" onclick="key_press('#')">#</button></td>
                  <td><button class="btn" onclick="key_press('0')">0</button></td>
                  <td><button class="btn" onclick="key_press('*')">*</button></td>
                  <td><button class="btn btn-success" onclick="key_press('H')">Ent</button></td>
                </tr>
              </table>
            </div>
            <div>
              <table class="table">
                <tr>
                  <td>Pump 1</td>
                  <td>Pump 2</td>
                  <td>Pump 3</td>
                </tr>
                <tr>
                  <td id='pump_1_relay'>Off</td>
                  <td id='pump_2_relay'>Off</td>
                  <td id='pump_3_relay'>Off</td>
                </tr>
                <tr>
                  <td id='pump_1_pulses'>0</td>
                  <td id='pump_2_pulses'>0</td>
                  <td id='pump_3_pulses'>0</td>
                </tr>
                <tr>
                  <td><input type='number' id='pump_1_pulses_input'><br><button class="btn btn-success" onclick="send_pulses(1)">Send</button></td>
                  <td><input type='number' id='pump_2_pulses_input'><br><button class="btn btn-success" onclick="send_pulses(2)">Send</button></td>
                  <td><input type='number' id='pump_3_pulses_input'><br><button class="btn btn-success" onclick="send_pulses(3)">Send</button></td>
                </tr>
              </table>
            </div>

          </div>
          <script>
          // var connection = new WebSocket('ws://localhost:8080');

          // connection.onopen = function () {
          //   connection.send('Ping'); // Send the message 'Ping' to the server
          // };
          // connection.onmessage = function (data) {
          //   console.log(data);
          //   // connection.send('Ping'); // Send the message 'Ping' to the server
          // };

          function key_press(key){
            var str = JSON.stringify({
              "event" : "key_press",
              "key" : key
            });
            console.log(str);
          }
          function send_pulses(pump_num){

            var str = JSON.stringify({
              "event" : "send_pulses",
              "pump" : pump_num,
              "pulses" : $('#pump_' + pump_num + '_pulses_input').val()
            });
            console.log(str);
          }
          </script>

@endsection
