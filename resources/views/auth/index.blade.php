@extends('layouts.auth')

@section('title', 'Login')

@section('content')
  <div class="registration-form">
    <form action="/login" method="POST">
      @csrf
      <div class="form-icon">
        <span><i class="icon icon-user"></i></span>
      </div>
      <div class="login-text">
        <label>LOGIN</label>
      </div>
      <div class="form-group">
        <input
          type="text"
          class="form-control item @error('username') is-invalid @enderror"
          id="username"
          name="username"
          placeholder="Username"
          value="{{ old('username') }}"
        />
        <div class="invalid-feedback">
          @error('username') {{ $message }} @enderror
        </div>
      </div>
      <div class="form-group">
        <input
          type="password"
          class="form-control item @error('password') is-invalid @enderror"
          id="password"
          name="password"
          placeholder="Password"
        />
        <div class="invalid-feedback">
          @error('password') {{ $message }} @enderror
        </div>
        <div class="text-center mt-1">
          @error('login') {{ $message }} @enderror
        </div>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-block create-account">
          Masuk
        </button>
      </div>
    </form>
    <div class="social-media">
      <p>
        <a href="/forgot-password">Lupa Password?</a> <br>
        Belum punya akun? <a href="/daftar">Daftar</a>
      </p>
    </div>
  </div>
@endsection
