@extends('layouts.auth')

@section('title', 'Register')

@section('content')
  <div class="registration-form">
    <form action="/daftar" method="POST">
      @csrf
      <div class="form-icon">
        <span><i class="icon icon-user"></i></span>
      </div>
      <div class="login-text">
        <label>Registrasi</label>
      </div>
      <p id="message" class="text-center"></p>
      <div class="form-group">
        <input
          type="text"
          class="form-control item"
          name="username"
          placeholder="Username"
        />
        <div class="invalid-feedback"></div>
      </div>
      <div class="form-group">
        <input
          type="text"
          class="form-control item"
          name="phone"
          placeholder="No. Telepon"
        />
        <div class="invalid-feedback"></div>
      </div>
      <div class="form-group">
        <input
          type="password"
          class="form-control item"
          name="password"
          placeholder="Password"
        />
        <div class="invalid-feedback"></div>
      </div>
      <div class="form-group">
        <input
          type="password"
          class="form-control item"
          name="password_confirmation"
          placeholder="Konfirmasi Password"
        />
        <div class="invalid-feedback"></div>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-block create-account" id="button">
          Daftar
        </button>
      </div>
    </form>
    <div class="social-media">
      <p>Sudah punya akun? <a href="/login">Login</a></p>
    </div>
  </div>
@endsection

@push('script')
  <script>
    $('form').on('submit', function(e) {
      e.preventDefault()

      $.ajax({
        url: this.action,
        method: this.method,
        data: new FormData(this),
        processData: false,
        contentType: false,
        beforeSend: () => {
          $('#button').attr('disabled', true).html('Loading...')
        },
        success: (data) => {
          $('#button').html('Daftar')
          $('.is-invalid').removeClass('is-invalid')
          $('#message').html(data.message)
          window.location.href = '/login'
        },
        error: (err) => {
          const errors = err.responseJSON.errors

          $('input').each(function(i, e) {
            if (e.name in errors) {
              $(e).addClass('is-invalid').next().html(errors[e.name])
            } else {
              $(e).removeClass('is-invalid');
            }
          });

          $('#button').attr('disabled', false).html('Daftar')
        },
      })
    })
  </script>
@endpush
