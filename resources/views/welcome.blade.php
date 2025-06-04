<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Login | {{ \App\Models\Settings::site_title() }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @php
        $favIcon = \App\Models\Settings::shop_fav();
        $logo = \App\Models\Settings::shop_logo();
    @endphp
    @if(!is_null($favIcon))
        <link rel="icon" href="{{ asset($favIcon->fav_icon) }}" type="image/png" />
    @endif

    <link href="{{ asset('backend/css/bootstrap.min.css') }}" rel="stylesheet" />

    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }
        .container-box {
            width: 100%;
            max-width: 1000px;
        }
        .heading {
            text-align: center;
            margin-bottom: 40px;
            font-size: 32px;
            font-weight: 700;
            color: #333;
        }
        .login-box {
            background: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            height: 100%;
        }
        #logo {
            display: block;
            margin: 0 auto 20px auto;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            background-color: #000;
        }
        .login-title {
            text-align: center;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 25px;
        }
        .btn-login {
            background-color: #007bff;
            color: white;
            font-weight: 600;
            padding: 10px;
            width: 100%;
            border-radius: 6px;
            transition: 0.3s;
        }
        .btn-login:hover {
            background-color: #0056b3;
        }
        .form-control {
            height: 42px;
            font-size: 15px;
        }
        @media (max-width: 767.98px) {
            .login-col {
                margin-bottom: 30px;
            }
        }
    </style>
</head>
<body>

<div class="container container-box">
    @if(!is_null($logo))
        <img src="{{ asset($logo->logo) }}" id="logo" alt="Logo">
    @endif

    <div class="heading">Welcome {{ \App\Models\Settings::site_title() }} </div>

    <div class="row">
        <div class="col-md-6 login-col">
            <div class="login-box">
                <div class="login-title">Admin Login</div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <input class="form-control @error('email') is-invalid @enderror" type="text" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <button class="btn btn-login" type="submit">Log In</button>
                </form>
            </div>
        </div>

        <div class="col-md-6 login-col">
            <div class="login-box">
                <div class="login-title">Agent Login</div>
                <form method="POST" action="{{ route('agent.login') }}">
                    @csrf
                    <div class="mb-3">
                        <input class="form-control @error('email_agent') is-invalid @enderror" type="text" placeholder="Email" name="email_agent" value="{{ old('email_agent') }}" required>
                        @error('email_agent')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control @error('password_agent') is-invalid @enderror" placeholder="Password" name="password_agent" required>
                        @error('password_agent')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <button class="btn btn-login" type="submit">Log In</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('backend/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
