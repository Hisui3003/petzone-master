{{-- @extends('layouts.app')

@section('title' , 'Login')

@section('content')
    <div class="login-area login-s2">
        <div class="container">
            <div class="login-box ptb--100">
                <form action="{{ route('login') }}" method="POST">
                @csrf
                    <div class="login-form-head">
                        <h4>Log in</h4>
                    </div>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <input name="email" type="email" placeholder="Email Address">
                            @error('email')
                                <span class="valid-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-gp">
                            <input name="password" type="password" placeholder="Password">
                            @error('password')
                                <span class="valid-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="submit-btn-area">
                            <button type="submit">Login</button>
                        </div>
                        <div class="form-footer text-center mt-5">
                            <p class="text-muted">Don't have an account? <a href="{{ route('register') }}">Register</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection --}}

@extends('layout')

@section('content')
<main class="login-form">
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header">Login</div>
                  <div class="card-body">

                      <form action="{{ route('login.post') }}" method="POST" id="handleAjax">
                          @csrf

                          <div id="errors-list"></div>

                          <div class="form-group row">
                              <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                              <div class="col-md-6">
                                  <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                  @if ($errors->has('email'))
                                      <span class="text-danger">{{ $errors->first('email') }}</span>
                                  @endif
                              </div>
                          </div>

                          <div class="form-group row">
                              <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                              <div class="col-md-6">
                                  <input type="password" id="password" class="form-control" name="password">
                                  @if ($errors->has('password'))
                                      <span class="text-danger">{{ $errors->first('password') }}</span>
                                  @endif
                              </div>
                          </div>

                          <div class="form-group row">
                              <div class="col-md-6 offset-md-4">
                                  <div class="checkbox">
                                      <label>
                                          <input type="checkbox" name="remember"> Remember Me
                                      </label>
                                  </div>
                              </div>
                          </div>

                          <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                  Login
                              </button>
                          </div>
                      </form>

                  </div>
              </div>
          </div>
      </div>
  </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
  $(function() {
      $(document).on("submit", "#handleAjax", function(event) {
          event.preventDefault();

          var e = this;
          $(this).find("[type='submit']").html("Login...");

          $.ajax({
              url: $(this).attr('action'),
              data: $(this).serialize(),
              type: "POST",
              dataType: 'json',
              success: function (data) {
                $(e).find("[type='submit']").html("Login");

                if (data.status) {

                    window.location.href = data.redirect;
                } else {
                    $(".alert").remove();
                    $.each(data.errors, function (key, val) {
                        $("#errors-list").append("<div class='alert alert-danger'>" + val + "</div>");
                    });
                }
              },
              error: function () {
                  $(e).find("[type='submit']").html("Login");
                  $("#errors-list").append("<div class='alert alert-danger'>An error occurred. Please try again.</div>");
              }
          });

          return false;
      });
  });
</script>
@endsection
