@extends('layouts.main')

@section('title', 'Setting')

@section('content')
<div class="row" data-message="{{ session('message') }}">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"></h4>
        <form action="/setting/{{ $user->id }}" method="POST">
          @csrf
          @method('PUT')
          <div class="container">
            <div class="form-body">

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="username">Username</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input
                      type="text"
                      class="form-control @error('username') is-invalid @enderror"
                      id="username"
                      name="username"
                      placeholder="Masukan Username"
                      value="{{ old('username', $user->username) }}"
                    />
                    <div class="invalid-feedback">
                      @error('username') {{ $message }} @enderror
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="phone">No. Telepon</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input
                      type="text"
                      class="form-control @error('phone') is-invalid @enderror"
                      id="phone"
                      name="phone"
                      placeholder="Masukan No. Telepon"
                      value="{{ old('phone', $user->phone) }}"
                    />
                    <div class="invalid-feedback">
                      @error('phone') {{ $message }} @enderror
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="password">Password</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input
                      type="password"
                      class="form-control password @error('password') is-invalid @enderror"
                      id="password"
                      name="password"
                      placeholder="Masukan password"
                    />
                    <div class="invalid-feedback">
                      @error('password') {{ $message }} @enderror
                    </div>
                  </div>
                </div>
                <div class="col-md-3 pl-0">
                  <div class="form-group">
                    <button type="button" class="btn btn-outline-primary show-hide" data-toggle="tooltip" title="Lihat / Sembunyikan">
                      <i class="fas fa-eye"></i>
                    </button>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="passwordConfirmation">Konfirmasi Password</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input
                      type="password"
                      class="form-control password"
                      id="passwordConfirmation"
                      name="password_confirmation"
                      placeholder="Masukan Konfirmasi Password"
                    />
                  </div>
                </div>
              </div>

            </div>
            <div class="form-actions">
              <div class="text-right">
                <button type="submit" class="btn btn-info">Edit</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('script')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    // Show message from flashdata if exists
    const message = $('[data-message]').data('message');
    if (message) {
      Swal.fire({
        title: 'Berhasil!',
        text: message,
        icon: 'success',
        timer: 1500
      });
    }

    // Toggle show/hide password
    $('.show-hide').on('click', function() {
      const icon = $('i', this);

      $('.password').each(function () {
        const fieldType = $(this).attr('type');
        if (fieldType === 'password') {
          icon.removeClass('fa-eye').addClass('fa-eye-slash');
          $(this).attr('type', 'text');
        } else {
          icon.removeClass('fa-eye-slash').addClass('fa-eye');
          $(this).attr('type', 'password');
        }
      });
    });
  </script>
@endpush
