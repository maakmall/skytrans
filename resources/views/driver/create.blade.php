@extends('layouts.main')

@section('title', 'Tambah Driver')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title"></h4>
          <form action="/drivers" method="POST" id="driver">
            @csrf
            <div class="container">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="name">Nama Lengkap</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <input
                        type="text"
                        class="form-control"
                        id="name"
                        name="name"
                        placeholder="Masukan Nama Lengkap"
                      />
                      <div class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="contact">Kontak</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <input
                        type="text"
                        class="form-control"
                        id="contact"
                        name="contact"
                        placeholder="Masukan No. Telepon"
                      />
                      <div class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>

                @can('admin')
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
                @endcan

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
    // On submit event driver form
    $('#driver').on('submit', function(e) {
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

          window.location.href = '/drivers'
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
