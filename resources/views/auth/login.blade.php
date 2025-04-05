<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>Login | {{ \App\Models\Settings::site_title() }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('backend/images/favicon.ico')}}">

        <!-- Bootstrap Css -->
        <link href="{{asset('backend/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{asset('backend/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{asset('backend/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
        <link href="{{asset('backend/css/custom.css')}}" id="app-style" rel="stylesheet" type="text/css" />

        <style>
            #logo{
                width: 100px;
                border-radius: 50%;
                height: 100px;
                object-fit: cover;
            }
        </style>

    </head>

    <body class="auth-body-bg">
        <div class="bg-overlay"></div>
        <div class="wrapper-page">
            <div class="container-fluid p-0">
                <div class="card">
                    <div class="card-body">

                        <div class="text-center mt-4">
                            <div class="mb-3">
                                <a href="" class="auth-logo">
                                     <!--logo-->
                                    @php
                                        $logo = \App\Models\Settings::shop_logo();
                                    @endphp
                                    @if(!is_null($logo))
                                        <img src="{{asset($logo->logo)}}" id="logo" class="logo-dark mx-auto" alt="">
                                        <img src="{{asset($logo->logo)}}" height="30" class="logo-light mx-auto" alt="">
                                    @endif
                                    
                                    
                                </a>
                            </div>
                        </div>
    
                        <h4 class="text-muted text-center font-size-18"><b>Log In</b></h4>
    
                        <div class="p-3">
                            <form class="form-horizontal mt-3" action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                        <input class="form-control @error('email') is-invalid @enderror" type="text" required="" placeholder="Username" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            
                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                        <input type="password" required="" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            
                                <div class="form-group mb-3 text-center row mt-3 pt-1">
                                    <div class="col-12">
                                        <button class="btn btn-info w-100 waves-effect waves-light" type="submit" >Log In</button>
                                    </div>
                                </div>
                            
                                {{-- <div class="form-group mb-0 row mt-2">
                                    <div class="col-sm-6 mt-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mt-3">
                                        @if (Route::has('password.request'))
                                            <a class="text-muted" href="{{ route('password.request') }}">
                                                <i class="mdi mdi-lock"></i> Forgot your password?
                                            </a>
                                        @endif
                                    </div>
                                </div> --}}
                            </form>
                        </div>
                        <!-- end -->
                    </div>
                    <!-- end cardbody -->
                </div>
                <!-- end card -->
            </div>
            <!-- end container -->
        </div>
    </body>
</html>