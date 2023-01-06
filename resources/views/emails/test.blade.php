Daily Maintenance Report
@foreach ($equipments as $equipment)
@if($equipment->upcoming || $equipment->current || $equipment->overdue)

({{ $equipment->unit_number }}) {{ $equipment->name }}
@foreach ($equipment->intervals as $interval)
@if($interval->meter_status=="Upcomming")
    {{ $interval->name }} is due in {{ $interval->meter_due - $equipment->current_meter }} hours
@endif
@if($interval->date_status=="Upcomming")
    {{ $interval->name }} is due in {{ $interval->date_due_in_days }} days
@endif
@if($interval->meter_status=="Current")
    {{ $interval->name }} is overdue by {{ $equipment->current_meter - $interval->meter_due }} hours
@endif
@if($interval->date_status=="Current")
    {{ $interval->name }} is overdue by {{ $interval->date_due_in_days }} days
@endif
@if($interval->meter_status=="Overdue")
    {{ $interval->name }} is overdue by {{ $equipment->current_meter - $interval->meter_due }} hours
@endif
@if($interval->date_status=="Overdue")
    {{ $interval->name }} is overdue by {{ $interval->date_due_in_days }} days
@endif
@endforeach
@endif
@endforeach
