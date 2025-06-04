<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Login | {{ \App\Models\Settings::site_title() }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $favIcon = \App\Models\Settings::shop_fav();
        $logo = \App\Models\Settings::shop_logo();
    @endphp
    @if(!is_null($favIcon))
        <link rel="icon" href="{{ asset($favIcon->fav_icon) }}" type="image/png" />
    @endif

    <link href="{{ asset('backend/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/css/icons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/css/app.min.css') }}" rel="stylesheet" />
    <style>
        body.auth-body-bg {
            background-image: url('{{ asset('backend/images/agent-auth-bg.jpg') }}');
            background-size: cover;
            background-position: center;
        }
        #logo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            background: black;
        }
        .login-box {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
        }
        .login-title {
            font-weight: bold;
            font-size: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>

<body class="auth-body-bg">
    <div class="bg-overlay"></div>
    <div class="container py-5">
        <div class="text-center" style="position: relative; margin-bottom: 40px;">
            @if(!is_null($logo))
                <img src="{{ asset($logo->logo) }}" id="logo" alt="Logo">
            @endif
        </div>

        <div class="row justify-content-center g-4">
            <div class="col-md-5">
                <div class="login-box">
                    <div class="login-title">User Login</div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <input class="form-control @error('email') is-invalid @enderror" type="text" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" required>
                            @error('password')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group text-center mt-3">
                            <button class="btn btn-info w-100" type="submit">Log In</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-5">
                <div class="login-box">
                    <div class="login-title">Agent Login</div>
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
            </div>
        </div>
    </div>
</body>
</html>
