<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>Login | {{ \App\Models\Settings::site_title() }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />

        @php
            $favIcon = \App\Models\Settings::shop_fav();
        @endphp
        @if(!is_null($favIcon))
            <link rel="icon" href="{{ asset($favIcon->fav_icon) }}" type="image/png" />
        @endif
        <!-- Bootstrap Css -->
        <link href="{{asset('backend/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{asset('backend/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{asset('backend/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
        {{-- <link href="{{asset('backend/css/custom.css')}}" id="app-style" rel="stylesheet" type="text/css" /> --}}

        <style>
            #logo{
                width: 100px;
                border-radius: 50%;
                height: 100px;
                object-fit: cover;
            }
        </style>
    </head>

    <body class="auth-body-bg" style="background-image: url('{{ asset('backend/images/agent-auth-bg.jpg') }}');margin-top: 200px;
">
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
                                       <img src="{{asset($logo->logo)}}" id="logo" class="logo-dark mx-auto" alt="" style="background: black;">
                                       <img src="{{asset($logo->logo)}}" height="30" class="logo-light mx-auto" alt="">
                                   @endif


                               </a>
                            </div>
                        </div>

                        <h4 class="text-muted text-center font-size-18"><b>Sign In</b></h4>

                        <div class="p-3">
                           <form method="POST" action="{{ route('agent.login') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <input class="form-control @error('email_agent') is-invalid @enderror" type="text" placeholder="Email" name="email_agent" value="{{ old('email_agent') }}" required>
                            @error('email_agent')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" class="form-control @error('password_agent') is-invalid @enderror" placeholder="Password" name="password_agent" required>
                            @error('password_agent')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group text-center mt-3">
                            <button class="btn btn-info w-100" type="submit">Log In</button>
                        </div>
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
        <!-- end -->
    </body>
</html>
