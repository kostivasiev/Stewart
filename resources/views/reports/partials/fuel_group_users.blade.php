
    <table class="table table-striped table-hover table-bordered">
      <tr>
        <th>User</th>
        <th>Fuel Group</th>
      </tr>
      @foreach ($users as $user)
        <tr>

          <td>{{ $user->last_name }}, {{ $user->first_name }}</td>
          <td>{{ !empty($user->fuel_group()->first()) ? $user->fuel_group()->first()->name : "Unassigned" }}</td>
        </tr>
      @endforeach
    </table>
