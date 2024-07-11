{{-- @extends('layouts.app')

@section('title' , 'Register')

@section('content')
<div class="login-area login-s2">
    <div class="container">
        <div class="login-box ptb--100">
            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="login-form-head">
                    <h4>Register</h4>
                </div>
                <div class="login-form-body">
                    <div class="form-gp">
                        <input name="name" placeholder="Full Name" type="text">
                        @error('name')
                        <span class="valid-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-gp">
                        <input name="email" placeholder="Email address" type="email">
                        @error('email')
                        <span class="valid-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-gp">
                        <input name="password" placeholder="Password" type="password">
                        @error('password')
                        <span class="valid-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-gp">
                        <input name="password_confirmation" placeholder="Confirm Password" type="password">
                    </div>
                    <div class="form-gp">
                        <input type="file" name="image_path" accept="image/*">
                    </div>
                    <div class="submit-btn-area">
                        <button type="submit">Submit</button>
                    </div>
                    <div class="form-footer text-center mt-5">
                        <p class="text-muted">Do have an account? <a href="{{ route('login') }}">Log in</a></p>
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
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-body">

                        <form action="{{ route('register.post') }}" method="POST" id="handleAjax">

                            @csrf

                            <div id="errors-list"></div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                                <div class="col-md-6">
                                    <input type="text" id="name" class="form-control" name="name" required autofocus>
                                    @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone_number" class="col-md-4 col-form-label text-md-right">Phone Number</label>
                                <div class="col-md-6">
                                    <input type="text" id="phone_number" class="form-control" name="phone_number" required
                                        autofocus>
                                    @if ($errors->has('phone_number'))
                                    <span class="text-danger">{{ $errors->first('phone_number') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-md-4 col-form-label text-md-right">Address</label>
                                <div class="col-md-6">
                                    <input type="text" id="address" class="form-control" name="address" required
                                        autofocus>
                                    @if ($errors->has('address'))
                                    <span class="text-danger">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail
                                    Address</label>
                                <div class="col-md-6">
                                    <input type="text" id="email_address" class="form-control" name="email" required
                                        autofocus>
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
                                <label for="confirm_password" class="col-md-4 col-form-label text-md-right">Confirm
                                    Password</label>
                                <div class="col-md-6">
                                    <input type="password" id="confirm_password" class="form-control"
                                        name="confirm_password" required>
                                    @if ($errors->has('confirm_password'))
                                    <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
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
                                    Register
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

      /*------------------------------------------
      --------------------------------------------
      Submit Event
      --------------------------------------------
      --------------------------------------------*/
      $(document).on("submit", "#handleAjax", function(event) {
         event.preventDefault();
          var e = this;

          $(this).find("[type='submit']").html("Register...");

          $.ajax({
              url: $(this).attr('action'),
              data: $(this).serialize(),
              type: "POST",
              dataType: 'json',
              success: function (data) {

                $(e).find("[type='submit']").html("Register");

                if (data.status) {
                    window.location = data.redirect;
                }else{

                    $(".alert").remove();
                    $.each(data.errors, function (key, val) {
                        $("#errors-list").append("<div class='alert alert-danger'>" + val + "</div>");
                    });
                }

              }
          });

          return false;
      });

    });

</script>
@endsection
