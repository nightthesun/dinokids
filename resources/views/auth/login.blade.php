@extends('layouts.app')

@section('content')
<div class="container-fluid login">
    <div class="row justify-content-center d-flex align-items-center">
        <div class="col-md-4 col-sm-6">
            <div class="card">
                <div class="card-body p-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row mb-3 justify-content-center">
                            <label for="name" class="col-md-6 col-form-label ">Numero CI</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4 justify-content-center">
                            <label for="password" class="col-md-6 col-form-label">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-md-6 d-flex justify-content-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        Recuerdame
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary">
                                    ENTRAR
                                </button>

                                @if (Route::has('password.request'))
                                    <!--a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('¿Olvidaste tu contraseña?') }}
                                    </a-->
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
