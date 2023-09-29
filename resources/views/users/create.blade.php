@extends('layouts.main')

@section('title', 'Tambah User')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title"></h4>
          <form action="/users" method="POST" id="users">
            @csrf
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
                        class="form-control"
                        id="username"
                        name="username"
                        placeholder="Masukan Username"
                      />
                      <div class="invalid-feedback"></div>
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
                        class="form-control"
                        id="phone"
                        name="phone"
                        placeholder="Masukan No. Telepon"
                      />
                      <div class="invalid-feedback"></div>
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
                        class="form-control password"
                        id="password"
                        name="password"
                        placeholder="Masukan Password"
                      />
                      <div class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="col-md-3 pl-0">
                    <div class="form-group">
                      <button type="button" class="btn btn-outline-primary show-hide" data-toggle="tooltip" title="Lihat / Sembunyikan">
                        <i class="fas fa-eye fa-lg"></i>
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
                      <div class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="companyId">Perusahaan</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <select
                        class="custom-select"
                        id="companyId"
                        name="company_id"
                      >
                        <option value="" disabled selected>--Pilih Perusahaan--</option>
                        @foreach ($companies as $company)
                          <option value="{{ $company->id }}">
                            {{ $company->name }}
                          </option>
                        @endforeach
                      </select>
                      <div class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>

              </div>
              <div class="form-actions">
                <div class="text-right">
                  <button type="submit" class="btn btn-info" id="button">
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    <span>Submit</span>
                  </button>
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
    // Toggle show/hide password
    $('.show-hide').on('click', function() {
      const icon = $('i', this);

      $('.password').each(function () {
        const fieldType = $(this).attr('type');
        if (fieldType === 'password') {
          icon.removeClass('fa-eye').addClass('fa-eye-slash')
          $(this).attr('type', 'text');
        } else {
          icon.removeClass('fa-eye-slash').addClass('fa-eye')
          $(this).attr('type', 'password');
        }
      })
    })

    // On submit event user form
    $('#users').on('submit', function(e) {
      e.preventDefault();

      $.ajax({
        url: this.action,
        method: this.method,
        data: new FormData(this),
        processData: false,
        contentType: false,
        beforeSend: () => {
          $('#button').attr('disabled', true)
          $('.spinner-border').removeClass('d-none').next().html('Loading...')
        },
        success: (data) => {
          $('.is-invalid').removeClass('is-invalid')

          Swal.fire({
            title: 'Berhasil!',
            text: data.message,
            icon: 'success',
            timer: 1500
          });

          window.location.href = '/users'
        },
        error: (err) => {
          const errors = err.responseJSON.errors

          $('input, select').each(function(i, e) {
            if (e.name in errors) {
              $(e).addClass('is-invalid').next().html(errors[e.name])
            } else {
              $(e).removeClass('is-invalid');
            }
          });

          $('#button').attr('disabled', false)
        },
        complete: () => {
          $('.spinner-border').addClass('d-none').next().html('Submit')
        }
      });
    })
  </script>
@endpush
