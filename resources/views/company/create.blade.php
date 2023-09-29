@extends('layouts.main')

@section('title', 'Tambah Perusahaan')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title"></h4>
          <form action="/companies" method="POST" id="companies">
            @csrf
            <div class="container">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="name">Nama</label>
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="form-group">
                      <input
                        type="text"
                        class="form-control"
                        id="name"
                        name="name"
                        placeholder="Nama Perusahaan"
                      />
                      <div class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="address">Alamat</label>
                    </div>
                  </div>
                  <div class="col-md-9">
                    <div class="form-group">
                      <textarea
                        class="form-control"
                        rows="3"
                        id="address"
                        name="address"
                        placeholder="Alamat Perusahaan"
                      ></textarea>
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
    // On submit event company form
    $('#companies').on('submit', function(e) {
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

          window.location.href = '/companies'
        },
        error: (err) => {
          const errors = err.responseJSON.errors

          $('input, textarea').each(function(i, e) {
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
