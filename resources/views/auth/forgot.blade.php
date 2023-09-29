@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
  <div class="registration-form">
    <form action="/forgot-password" method="POST">
      @csrf
      <div class="form-icon">
        <span><i class="icon icon-user"></i></span>
      </div>
      <div class="login-text">
        <label>Reset Password</label>
      </div>
      <p class="text-center" id="message"></p>
      <div class="form-group">
        <input
          type="text"
          class="form-control item"
          id="username"
          name="username"
          placeholder="Username"
        />
        <div class="invalid-feedback"></div>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-block create-account" id="button">
          Reset
        </button>
      </div>
    </form>
    <div class="social-media">
      <p>
        Belum punya akun? <a href="/daftar">Daftar</a>
      </p>
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
          $('#button').html('Reset')
          $('.is-invalid').removeClass('is-invalid')
          $('#message').html(data.message)
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

          $('#button').attr('disabled', false).html('Reset')
        },
      })
    })
  </script>
@endpush
