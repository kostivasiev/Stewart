
    <table class="table table-striped table-hover table-bordered">
      <tr>
        <th>Last Name</th>
        <th>First Name</th>
        <th>Email</th>
        <th>PIN</th>
        <th>Cell Number</th>
        <th>Cell Provider</th>
        <th>Login Account</th>
        <th>Fuel Group</th>
        <th>Send Text</th>
        <th>Send Email</th>
      </tr>
      @foreach ($users as $user)
        <tr>

          <td>{{ $user->last_name }}</td>
          <td>{{ $user->first_name }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->PIN }}</td>
          <td>{{ $user->cell_number }}</td>
          @if($user->cell_provider==0)
            <td>Verizon</td>
          @elseif($user->cell_provider==1)
            <td>AT&T</td>
          @elseif($user->cell_provider==-1)
            <td></td>
          @else
            <td>err: {{ $user->cell_provider }}</td>
          @endif
          <td>{{ !empty($user->login_account()->first()) ? $user->login_account()->first()->name : "Unassigned" }}</td>
          <td>{{ !empty($user->fuel_group()->first()) ? $user->fuel_group()->first()->name : "Unassigned" }}</td>
          <td>{{ $user->send_text_at_fueling ? "Yes" : "No" }}</td>
          <td>{{ $user->send_email_at_fueling ? "Yes" : "No" }}</td>
        </tr>
      @endforeach
    </table>
