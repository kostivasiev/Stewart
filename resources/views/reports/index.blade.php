@extends('layouts.reports')


@section('content')

	<h1> Report</h1>

	    <div class="panel panel-default" id="report-container" style="display:none">
				<div class="panel-heading clearfix">
				  <div class="pull-left">
				    <h4 id='report-name'>Fuel Report</h4>
				  </div>

				  <div class="pull-right">
				    <a class="btn btn-default" onclick="EditReport()">
				      <i class="glyphicon glyphicon-edit"></i>
				      Edit
				    </a>
				    <!-- Split button -->
				    <div class="btn-group">
				      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    Export <span class="caret"></span>
				  </button>
				      <ul class="dropdown-menu">
				        <li><a onclick="ExcelReport('xls')">Excel</a></li>
				        <li style="display:none"><a onclick="ExcelReport('pdf')">PDF</a></li>
				        <li><a onclick="ExcelReport('csv')">CSV</a></li>
				      </ul>
				    </div>
				    <a class="btn btn-circle btn-default btn-xs" title="Print">
				      <i class="glyphicon glyphicon-print"></i>
				    </a>
				  </div>

				</div>
				<div id="report-table-container"></div>
      </div>

@endsection
