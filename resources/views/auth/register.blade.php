@extends('layouts.app')

@section('content')
<style>


.stripe-form form {
  width: 480px;
  margin: 20px auto;
}

.stripe-form .group {
  background: white;
  box-shadow: 0 7px 14px 0 rgba(49,49,93,0.10),
              0 3px 6px 0 rgba(0,0,0,0.08);
  border-radius: 4px;
  margin-bottom: 20px;
}

.stripe-form label {
  position: relative;
  color: #8898AA;
  font-weight: 300;
  height: 40px;
  line-height: 40px;
  margin-left: 20px;
  display: block;
}

.stripe-form .group label:not(:last-child) {
  border-bottom: 1px solid #F0F5FA;
}

.stripe-form label > span {
  width: 20%;
  text-align: right;
  float: left;
}

.stripe-form .field {
  background: transparent;
  font-weight: 300;
  border: 0;
  color: #31325F;
  outline: none;
  padding-right: 10px;
  padding-left: 10px;
  cursor: text;
  width: 70%;
  height: 40px;
  float: right;
}

.stripe-form .field::-webkit-input-placeholder { color: #CFD7E0; }
.stripe-form .field::-moz-placeholder { color: #CFD7E0; }
.stripe-form .field:-ms-input-placeholder { color: #CFD7E0; }

.stripe-form button {
  float: left;
  display: block;
  background: #666EE8;
  color: white;
  box-shadow: 0 7px 14px 0 rgba(49,49,93,0.10),
              0 3px 6px 0 rgba(0,0,0,0.08);
  border-radius: 4px;
  border: 0;
  margin-top: 20px;
  font-size: 15px;
  font-weight: 400;
  width: 100%;
  height: 40px;
  line-height: 38px;
  outline: none;
}

.stripe-form button:focus {
  background: #555ABF;
}

.stripe-form button:active {
  background: #43458B;
}

.stripe-form .outcome {
  float: left;
  width: 100%;
  padding-top: 8px;
  min-height: 24px;
  text-align: center;
}

.stripe-form .success, .error {
  display: none;
  font-size: 13px;
}

.stripe-form .success.visible, .error.visible {
  display: inline;
}

.stripe-form .error {
  color: #E4584C;
}

.stripe-form .success {
  color: #666EE8;
}

.stripe-form .success .token {
  font-weight: 500;
  font-size: 13px;
}
</style>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          @if (count($errors))
          <div class="alert alert-danger">
           <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
            <h1>Step 1: Create a Company</h1>
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Company</h3>
              </div>
                <div class="panel-body">
                        {{ csrf_field() }}
                  <div id="company-errors" class="alert alert-danger" style="display:none"></div>
                    <div id="company-form">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Company Name</label>

                            <div class="col-md-6">
                                <input id="company_name" type="text" class="form-control" name="company_name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Company E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="company_email" type="email" class="form-control" name="company_email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                      </div>
                </div>
                <div class="panel-footer">
                  <div class="row">
                    <div class="col-md-10">
                      <div class="row">
                        <div class="col-md-offset-10 col-md-6">
                          <button type="button" class="btn btn-primary" id="create-company-btn" onclick="Create_Company()">
                            <!-- <i class="glyphicon glyphicon-check"></i> -->
                            Create
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <h1>Step 2: Create the first user</h1>
            <div class="panel panel-default" style="display:none" id="create-user-form">
                <div class="panel-heading">
                <h3 class="panel-title">User</h3>
              </div>
                <div class="panel-body">
                  <div id="user-errors" class="alert alert-danger" style="display:none"></div>
                    <div id="user-form" style="display:none">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">First  Name</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Last  Name</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Cell Number</label>

                            <div class="col-md-6">
                                <input id="cell_number" type="number" class="form-control" name="cell_number" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Cell Provider</label>

                            <div class="col-md-6">
                                <input id="cell_provider" type="text" class="form-control" name="cell_provider" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                      </div>
                </div>
                <div class="panel-footer" id="create-user-btn" style="display:none">
                  <div class="row">
                    <div class="col-md-10">
                      <div class="row">
                        <div class="col-md-offset-10 col-md-6">
                          <button type="button" class="btn btn-primary" onclick="Create_User()">
                            <!-- <i class="glyphicon glyphicon-check"></i> -->
                            Create
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <h1>Step 3: Order your subscription</h1>
            <div class="panel panel-default" id="order-subscription-form" style="display:none">
              <div class="panel-heading">
                <h3 class="panel-title">Subscription</h3>
              </div>
                <div class="panel-body">
                  <div id="subscription-errors"></div>
                <div class='stripe-form' id="subscription-form">
                  <form class="form-horizontal" role="form" method="POST" action="{{ route('register.order_subscription') }}">
                     {{ csrf_field() }}

                     <div class="group">
                      <label>
                        <span>Name</span>
                        <input name="cardholder-name" class="field" placeholder="Jane Doe" />
                      </label>
                    </div>
                    <div class="group">
                      <label>
                        <span>Card</span>
                        <div id="card-element" class="field"></div>
                      </label>
                    </div>
                    <button type="submit" id="create-subscription-btn">Order Subscription</button>
                    <button type="button" onclick="order_trial()" id="create-trail-btn">Just a Trial Please!</button>

                    <div class="outcome">
                      <div class="error" role="alert"></div>
                      <div class="success">
                        Success! Your Stripe token is <span class="token"></span>
                      </div>
                    </div>
                  </form>
                </div>
                </div>
            </div>
          </form>
          <h1>Step 4: Login</h1>
          <div class="panel panel-default" id="successful-registration" style="display:none">
            <div class="panel-heading">
              <h3 class="panel-title">Congratulations!</h3>
            </div>
              <div class="panel-body">
                  <h4>Congratulations! You now have access to your account. Click the login button
                  below to login and begin using your system.</h4>
                  <a class="btn btn-primary" href="{{ route('login') }}" style="float:right">Login</a>
              </div>
          </div>
          <br><br>
        </div>
    </div>
</div>
@endsection

@section('form-script')
<script src="https://js.stripe.com/v3/"></script>
<script>
var company_id = 0;
function Create_Company(){
  var company_errors = $("#company-errors");
  company_errors.html("");
  company_errors.hide(500);
  $("#create-company-btn").hide(500);
  $.ajax({
    url: "{{ route("company.store") }} ",
    method: 'post',
    data: {
      name: $("#company_name").val(),
      email: $("#company_email").val(),
      _token: $("input[name=_token]").val()
    },
    success: function (company){
      console.log(company.name);
      company_id = company.id;
      $("#order-form-company-id").val(company.id);
      $("#company-form").hide(500);
      company_errors.append('<p>Company successfully created!</p>');
      company_errors.append('<p>Company ID: Az14.' + company.id + '</p>');
      company_errors.append('<p>Name: ' + company.name + '</p>');
      company_errors.append('<p>Email: ' + company.email + '</p>');
      company_errors.attr('class', 'alert alert-success');
      company_errors.show(500);
      $("#user-form").show(500);
      $("#create-user-btn").show(500);
      $("#create-user-form").show(500);
    },
    error: function (xhr){
      company_errors.show(500);
      $("#create-company-btn").show(500);
      console.log(xhr);
      var errors = xhr.responseJSON;
      $.each(errors, function() {
        $.each(this, function(k, error_message) {
          company_errors.append('<p>' + error_message + '</p>');
        });
      });
    }
  });
}
function Create_User(){
  var user_errors = $("#user-errors");
  user_errors.html("");
  user_errors.hide(500);
  $("#create-user-btn").hide(500);
  $.ajax({
    url: "{{ route("register.store_user") }} ",
    method: 'post',
    data: {
      first_name: $("#first_name").val(),
      last_name: $("#last_name").val(),
      cell_number: $("#cell_number").val(),
      cell_provider: $("#cell_provider").val(),
      password: $("#password").val(),
      company_id: company_id,
      _token: $("input[name=_token]").val()
    },
    success: function (user){
      // console.log(user);
      $("#user-form").hide(500);
      user_errors.append('<p>User successfully created!</p>');
      user_errors.append('<p>Name: ' + user.first_name + ' ' + user.last_name + '</p>');
      user_errors.append('<p>Cell Number: ' + user.cell_number + '</p>');
      user_errors.append('<p>Cell Provider: ' + user.cell_provider + '</p>');
      user_errors.attr('class', 'alert alert-success');
      user_errors.show(500);
      $("#order-subscription-form").show(500);
    },
    error: function (xhr){
      user_errors.show(500);
      $("#create-user-btn").show(500);
      console.log(xhr);
      var errors = xhr.responseJSON;
      $.each(errors, function() {
        $.each(this, function(k, error_message) {
          user_errors.append('<p>' + error_message + '</p>');
        });
      });
    }
  });
}

function order_subscription(token){
    var subscription_errors = $("#subscription-errors");
    $("#create-subscription-btn").hide(500);
    $.ajax({
      url: "{{ route("register.order_subscription") }} ",
      method: 'post',
      data: {
        stripeToken: token.id,
        company_id: company_id,
        _token: $("input[name=_token]").val()
      },
      success: function (user){
        // subscription_errors.hide(500);
        subscription_errors.html("");
        console.log(user);
        $("#subscription-form").hide(500);
        subscription_errors.append('<p>Payment Accepted!</p>');
        subscription_errors.append('<p>Subscription successfully set up.</p>');
        subscription_errors.attr('class', 'alert alert-success');
        subscription_errors.show(500);
        $("#successful-registration").show(500);
      },
      error: function (xhr){
        subscription_errors.show(500);
        $("#create-subscription-btn").show(500);
        console.log(xhr);
        var errors = xhr.responseJSON;
        $.each(errors, function() {
          $.each(this, function(k, error_message) {
            subscription_errors.append('<p>' + error_message + '</p>');
          });
        });
      }
    });
}
function order_trial(){
    var subscription_errors = $("#subscription-errors");
    $("#create-subscription-btn").hide(500);
    $("#create-trail-btn").hide(500);
    $.ajax({
      url: "{{ route("register.order_trial") }} ",
      method: 'post',
      data: {
        company_id: company_id,
        _token: $("input[name=_token]").val()
      },
      success: function (user){
        // subscription_errors.hide(500);
        subscription_errors.html("");
        console.log(user);
        $("#subscription-form").hide(500);
        subscription_errors.append('<p>Trial Ready!</p>');
        subscription_errors.attr('class', 'alert alert-success');
        subscription_errors.show(500);
        $("#successful-registration").show(500);
      },
      error: function (xhr){
        subscription_errors.show(500);
        $("#create-subscription-btn").show(500);
        $("#create-trail-btn").show(500);
        console.log(xhr);
        var errors = xhr.responseJSON;
        $.each(errors, function() {
          $.each(this, function(k, error_message) {
            subscription_errors.append('<p>' + error_message + '</p>');
          });
        });
      }
    });
}
      var stripe = Stripe('pk_test_LR6W5Y0pvzDi4pqVqsZWiUdT');
      var elements = stripe.elements();

      var card = elements.create('card', {
        style: {
          base: {
            iconColor: '#666EE8',
            color: '#31325F',
            lineHeight: '40px',
            fontWeight: 300,
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSize: '15px',

            '::placeholder': {
              color: '#CFD7E0',
            },
          },
        }
      });
      card.mount('#card-element');

      function setOutcome(result) {
        var subscription_errors = $("#subscription-errors");
        var successElement = document.querySelector('.success');
        var errorElement = document.querySelector('.error');
        successElement.classList.remove('visible');
        errorElement.classList.remove('visible');

        if (result.token) {
          // Use the token to create a charge or a customer
          // https://stripe.com/docs/charges
          order_subscription(result.token);
          $("#subscription-form").hide(500);
          subscription_errors.html('<p>Processing</p>');
          subscription_errors.attr('class', 'alert alert-warning');
          subscription_errors.show(500);
          // successElement.querySelector('.token').textContent = result.token.id;
          // successElement.classList.add('visible');
        } else if (result.error) {
          subscription_errors.html(result.error.message);
          subscription_errors.attr('class', 'alert alert-danger');
          subscription_errors.show(500);
          // errorElement.textContent = result.error.message;
          // errorElement.classList.add('visible');
        }
      }

      card.on('change', function(event) {
        setOutcome(event);
      });

      document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        var form = document.querySelector('form');
        var extraDetails = {
          name: form.querySelector('input[name=cardholder-name]').value,
        };
        stripe.createToken(card, extraDetails).then(setOutcome);
      });
      </script>

      @endsection
