@extends('layouts.main')

@section('title', 'Tambah Material')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <form
            action="{{ Auth::user()->is_admin
              ? '/materials'
              : '/companies/'. Auth::user()->company_id .'/materials' }}"
            method="POST"
            id="materials"
          >
            @csrf
            <div class="container">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="code">Kode</label>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <input
                        type="text"
                        class="form-control auto"
                        id="code"
                        name="code"
                        placeholder="Kode Material"
                      />
                      <div class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>

                @can('admin')
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="name">Nama</label>
                      </div>
                    </div>
                    <div class="col-md-9">
                      <div class="form-group">
                        <input
                          type="text"
                          class="form-control"
                          id="name"
                          name="name"
                          placeholder="Nama Material"
                        />
                        <div class="invalid-feedback"></div>
                      </div>
                    </div>
                  </div>
                @else
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="name">Nama</label>
                      </div>
                    </div>
                    <div class="col-md-9">
                      <div class="form-group">
                        <select
                          class="custom-select auto"
                          name="material_id"
                          id="name"
                        >
                          <option value="" disabled selected>--Pilih Material--</option>
                          @foreach ($materials as $material)
                            <option value="{{ $material->id }}">
                              {{ $material->name }}
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
    // On submit event material form
    $('#materials').on('submit', function(e) {
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

          location.href = '/materials'
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

@pushIf(!Auth::user()->is_admin, 'script')
  <script>
    // Automatic name or material code
    $(document).on('change', '.auto', function (e) {
      const auto = this.id == 'name';
      const url = `/materials/${auto ? this.value : `code/${this.value}`}`;
      const element = auto ? 'code' : 'name'

      $.get(url, (data) => {
        $(`#${element}`).val(auto ? data.code : data.id);
      });
    });
  </script>
@endPushIf
