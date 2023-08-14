<!doctype html>

<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tri Datu Web App - @yield('title')</title>
    <!-- CSS files -->
    <link href="{{asset('public/css/tabler.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('public/css/tabler-flags.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('public/css/tabler-payments.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('public/css/tabler-vendors.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('public/css/demo.min.css')}}" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>  
    @yield('add_css')
    @stack('css')
  </head>
  <body >
    <div class="wrapper">
      <div class="sticky-top">
        <header class="navbar navbar-expand-md navbar-light sticky-top d-print-none" style="margin-bottom:0!important">
          <div class="container-xl">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
              <span class="navbar-toggler-icon"></span>
            </button>
            <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
              <a href=".">
                <img src="{{ asset('public/img/themes/logo.svg')}}" width="110" height="32" alt="Tabler" class="navbar-brand-image">
              </a>
            </h1>
            <div class="navbar-nav flex-row order-md-last">
              <div class="nav-item d-none d-md-flex me-3">
              </div>
              <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
                <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" /></svg>
              </a>
              <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
                <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="4" /><path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" /></svg>
              </a>
              <div class="nav-item dropdown d-none d-md-flex me-3">
                <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
                  <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" /><path d="M9 17v1a3 3 0 0 0 6 0v-1" /></svg>
                  <span class="badge bg-red"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-card">
                  <div class="card">
                    <div class="card-body">
                      Notif here
                    </div>
                  </div>
                </div>
              </div>
              <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                  <span class="avatar avatar-sm" style="background-image: url(./static/avatars/asn.jpg)"></span>
                  <div class="d-none d-xl-block ps-2">
                    <div>{{ Auth::user()->first_name }}</div>
                    <div class="mt-1 small text-muted">{{ FunctionsHelp::get_roles(Auth::user()->roleid)}}</div>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <a href="#" class="dropdown-item">Set status</a>
                  <a href="#" class="dropdown-item">Profile & account</a>
                  <a href="#" class="dropdown-item">Feedback</a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">Settings</a>
                  <a href="{{ route('actionlogout')}}" class="dropdown-item">Logout</a>
                </div>
              </div>
            </div>
          </div>
        </header>
        <div class="navbar-expand-md">
          <div class="collapse navbar-collapse" id="navbar-menu">
            <div class="navbar navbar-light">
              <div class="container-xl">
                <ul class="navbar-nav menuheader">
                  <li class="nav-item active">
                    <a class="nav-link" href="{{route('home')}}" >
                      <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="5 12 3 12 12 3 21 12 19 12" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                      </span>
                      <span class="nav-link-title">
                        Home
                      </span>
                    </a>
                  </li>
                  <li class="nav-item dropdown crm">
                    <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                      <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-book-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M19 4v16h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12z"></path><path d="M19 16h-12a2 2 0 0 0 -2 2"></path><path d="M9 8h6"></path></svg>
                      </span>
                      <span class="nav-link-title">
                        CRM
                      </span>
                    </a>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="{{url('leads')}}" >
                        Lead's
                      </a>
                      <a class="dropdown-item" href="{{url('quotes')}}" >
                        Quote's
                      </a>
                      <a class="dropdown-item" href="{{url('surveys')}}" >
                        Survey's
                      </a>
                      <a class="dropdown-item" href="{{url('installasi')}}" >
                        Instalations
                      </a>
                      <a class="dropdown-item" href="{{url('revocation')}}" >
                        Revocation
                      </a>
                      <a class="dropdown-item" href="{{url('meetings')}}" >
                        Meetings
                      </a>
                      
                      <hr style="padding:0!important;margin:0!important">
                      <a class="dropdown-item" href="{{url('accounts')}}" >
                        Accounts's
                      </a>
                      <a class="dropdown-item" href="{{url('contacts')}}" >
                        Customer's
                      </a>
                      <!-- <a class="dropdown-item" href="{{url('property')}}" >
                        Properties
                      </a> -->
                      <a class="dropdown-item" href="{{url('maintenance')}}" >
                        Maintenance's
                      </a>
                      <a class="dropdown-item" href="{{url('billing')}}" >
                        Bill's
                      </a>
                      <hr style="padding:0!important;margin:0!important">
                      <a class="dropdown-item" href="{{url('deals')}}" >
                        Deals
                      </a>
                      <a class="dropdown-item" href="{{url('leads')}}" >
                        Task
                      </a>
                      <a class="dropdown-item" href="{{url('accounts')}}" >
                        Calls
                      </a>
                    </div>
                  </li>
                  <li class="nav-item dropdown inventory">
                    <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                      <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-topology-star-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M14 20a2 2 0 1 0 -4 0a2 2 0 0 0 4 0z"></path>
                        <path d="M14 4a2 2 0 1 0 -4 0a2 2 0 0 0 4 0z"></path>
                        <path d="M6 12a2 2 0 1 0 -4 0a2 2 0 0 0 4 0z"></path>
                        <path d="M22 12a2 2 0 1 0 -4 0a2 2 0 0 0 4 0z"></path>
                        <path d="M14 12a2 2 0 1 0 -4 0a2 2 0 0 0 4 0z"></path>
                        <path d="M6 12h4"></path>
                        <path d="M14 12h4"></path>
                        <path d="M12 6v4"></path>
                        <path d="M12 14v4"></path>
                      </svg>
                      </span>
                      <span class="nav-link-title">
                        Inventory
                      </span>
                    </a>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="{{url('vendors')}}" > 
                        Vendors
                      </a>
                      <a class="dropdown-item" href="{{ url('services') }}" >
                        Service / Package
                      </a> 
                      <hr style="padding:0!important;margin:0!important">
                      <a class="dropdown-item" href="{{ url('category') }}" >
                        Product Category
                      </a>
                      <a class="dropdown-item" href="{{ url('product') }}" >
                        Products
                      </a>
                      <hr style="padding:0!important;margin:0!important">
                      <a class="dropdown-item" href="{{url('ipaddress')}}" >
                        IP Address
                      </a>
                      <a class="dropdown-item" href="{{url('pops')}}" >
                        Lokasi POP
                      </a>
                      <hr style="padding:0!important;margin:0!important">
                      <!-- <a class="dropdown-item" href="{{url('po')}}" >
                        Purchase Orders
                      </a> -->
                      <a class="dropdown-item" href="{{url('order')}}" >
                      Purchase Orders
                      </a>
                      <a class="dropdown-item" href="{{url('refund')}}" >
                        Purchase Return
                      </a>
                      <a class="dropdown-item" href="{{url('return')}}" >
                        Revocation Return
                      </a>
                      <a class="dropdown-item" href="{{url('report')}}" >
                        Inventory Reports
                      </a>
                    </div>
                  </li>
                  <li class="nav-item dropdown activity">
                    <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                      <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-book-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M19 4v16h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12z"></path><path d="M19 16h-12a2 2 0 0 0 -2 2"></path><path d="M9 8h6"></path></svg>
                      </span>
                      <span class="nav-link-title">
                        Activities
                      </span>
                    </a>
                    
                  </li>
                  
                 
                  <li class="nav-item dropdown support">
                    <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                      <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-book-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M19 4v16h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12z"></path><path d="M19 16h-12a2 2 0 0 0 -2 2"></path><path d="M9 8h6"></path></svg>
                      </span>
                      <span class="nav-link-title">
                        Support
                      </span>
                    </a>
                    <div class="dropdown-menu">
                          <a class="dropdown-item" href="{{url('tikets')}}" >
                            Tiket
                          </a>
                    </div>
                  </li>
                  <li class="nav-item dropdown users">
                  <a class="nav-link dropdown-toggle" href="#navbar-layout" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                      <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/file-text -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                      </svg></span>
                      <span class="nav-link-title"> 
                        User's
                      </span>
                    </a>
                    <div class="dropdown-menu">
                          <a class="dropdown-item" href="./staff.php" >
                          Staff
                          </a>
                          <a class="dropdown-item" href="./departemen.php" >
                          Departemen
                          </a>
                    </div>
                  </li>

                  <li class="nav-item settings">
                    <a class="nav-link" href="{{route('home')}}" >
                      <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings-cog" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12.003 21c-.732 .001 -1.465 -.438 -1.678 -1.317a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c.886 .215 1.325 .957 1.318 1.694"></path>
                        <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                        <path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                        <path d="M19.001 15.5v1.5"></path>
                        <path d="M19.001 21v1.5"></path>
                        <path d="M22.032 17.25l-1.299 .75"></path>
                        <path d="M17.27 20l-1.3 .75"></path>
                        <path d="M15.97 17.25l1.3 .75"></path>
                        <path d="M20.733 20l1.3 .75"></path>
                      </svg>
                      </span>
                      <span class="nav-link-title">
                        Settings
                      </span>
                    </a>
                  </li>

                </ul>
                <!-- <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last">
                  <form action="." method="get">
                    <div class="input-icon">
                      <span class="input-icon-addon">
                       
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="10" cy="10" r="7" /><line x1="21" y1="21" x2="15" y2="15" /></svg>
                      </span>
                      <input type="text" class="form-control" placeholder="Search…" aria-label="Search in website">
                    </div>
                  </form>
                </div> -->
              </div>
            </div>
          </div>
        </div>
      </div> <!-- END Header -->