<!doctype html>

<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Welcome to Tridatu CRM</title>
    <!-- CSS files -->
    <link href="{{asset('public/css/tabler.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('public/css/tabler-flags.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('public/css/tabler-payments.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('public/css/tabler-vendors.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('public/css/demo.min.css')}}" rel="stylesheet"/>
  </head>
  <body  class=" border-top-wide border-primary d-flex flex-column">
    <div class="page page-center">
      <div class="container-tight py-4">
        <div class="text-center mb-4">
          <a href="." class="navbar-brand navbar-brand-autodark"><img src="{{asset('public/img/themes/logo.svg')}}" height="36" alt=""></a>
        </div>
        @if(session('error'))
          <div class="alert alert-danger">
              <b>Opps!</b> {{session('error')}}
          </div>
          @endif
          <form action="{{ route('actionlogin') }}" method="post">
        @csrf
          <div class="card-body">
            <h2 class="card-title text-center mb-4">Login to your account</h2>
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="input" class="form-control" name="username" placeholder="Enter Username">
              
            </div>
            <div class="mb-2">
              <label class="form-label">
                Password
                <span class="form-label-description">
                  <a href="{{ url('forgot-password')}}">I forgot password</a>
                </span>
              </label>
              <div class="input-group input-group-flat">
                <input type="password" class="form-control" name="password" placeholder="Password"  autocomplete="off">
                
                <span class="input-group-text">
                  <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg>
                  </a>
                </span>
              </div>
            </div>
            <div class="form-footer">
              <button type="submit" class="btn btn-primary w-100">Sign in</button>
            </div>
          </div>
          
        </form>
        <div class="text-center text-muted mt-3">
          Don't have account yet? <a href="./sign-up.html" tabindex="-1">Sign up</a>
        </div>
      </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="{{asset('public/js/tabler.min.js')}}"></script>
    <script src="{{asset('public/js/demo.min.js')}}"></script>
  </body>
</html>