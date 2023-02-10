@extends('../layout')
@section('title')
    Login
@endsection
@section('page')
    <section class="login_page">
        <div class="container pt-4">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">{{ __('Winks') }}</div>
                        <div class="card-body px-3 pt-0">
                            <div class="row pb-3" style="background:#7c563cf0;">
                                <div class=" text-center ">
                                    <!--  <img style="width: 75%; margin: auto;height: 200px;" src="images/logo.png"> -->
                                    <h2 class="py-3 text-light text-center">L O G O</h2>
                                </div>
                                <div>
                                    <h4 style="font-weight: 400;color:#f7f7f7b8;" class="text-center  py-2">Sub Reddit login</h4>
                                    <h5 style="font-weight: 400;color:#f7f7f7b8;" class="text-center py-2 ">
                                        </h5>
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-white">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="font-weight-bold">{{ __('Email') }}</label>
                                        <input id="email" type="email"
                                            class="form-control mt-2 @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="font-weight-bold">{{ __('Password') }}</label>

                                        <div class="col-md-11">
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                required autocomplete="current-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- <div class="row mb-3">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div> -->
                                    <div class="row mb-0">
                                        <div class="col-md-7 ">
                                            <button type="submit" class="px-3 py-2 btn float-left btn-primary">
                                                {{ __('Login') }}
                                            </button>
                                        </div>
                                        <div class="col-md-5  d-none">
                                            @if (Route::has('password.request'))
                                                <a class="text-secondary btn btn-link"
                                                    href="{{ route('forgot', 'email') }}">
                                                    {{ __('Forgot Your Password?') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="d-flex mt-2">
                                        <p class="me-2">Don't have an account?</p>
                                        <a href="register">
                                            {{ __('Register') }}
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
