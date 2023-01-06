@extends('layouts.reports')
  @section('content')


    <h1> Report</h1>

        <div class="panel panel-default" id="report-container">

        </div>


                <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
                <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

                <!-- optional: mobile support with jqueryui-touch-punch -->
                <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>


                <script type="text/javascript">
            // This example is the most basic usage of pivotUI()

            $(function(){
                $("#report-container").pivotUI(
                    [
                      @foreach($logs as $log)
                      {user: "{{ !empty($log->user()->first()->first_name) ? $log->user()->first()->last_name : "" }}, {{ !empty($log->user()->first()->first_name) ? $log->user()->first()->first_name : "" }}", equipment: "{{ !empty($log->equipment()->first()->name) ? $log->equipment()->first()->name : "" }}", gallons: {{ $log->consumed_gallons }} },
                      @endforeach
                      {user: 1, equipment: 1, gallons: 1}
                    ],
                    {
                        rows: ["user", "equipment"]
                    }
                );
             });
                </script>


  @endsection
