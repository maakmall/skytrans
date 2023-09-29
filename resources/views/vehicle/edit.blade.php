@extends('layouts.main')

@section('title', 'Edit Kendaraan')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title"></h4>
          <form
            action="/vehicles/{{ $vehicle->id }}"
            method="POST"
            enctype="multipart/form-data"
            id="vehicles"
          >
            @csrf
            @method('PUT')
            <div class="container">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="platNumber">No. Kendaraan</label>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <input
                        type="text"
                        class="form-control"
                        id="platNumber"
                        name="plat_number"
                        placeholder="No. Kendaraan"
                        value="{{ $vehicle->plat_number }}"
                      />
                      <div class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="type">Jenis Kendaraan</label>
                    </div>
                  </div>
                  <div class="col-md-9">
                    <div class="form-group">
                      <select
                        class="custom-select"
                        name="type"
                        id="type"
                      >
                        <option value="" disabled selected>--Pilih Jenis Kendaraan--</option>
                        <option @selected($vehicle->type == "Pick Up")>
                          Pick Up
                        </option>
                        <option @selected($vehicle->type == "Colt Diesel")>
                          Colt Diesel
                        </option>
                        <option @selected($vehicle->type == "Truck Fuso")>
                          Truck Fuso
                        </option>
                        <option @selected($vehicle->type == "Tronton")>
                          Tronton
                        </option>
                        <option @selected($vehicle->type == "Trintin")>
                          Trintin
                        </option>
                        <option @selected($vehicle->type == "Trinton")>
                          Trinton
                        </option>
                        <option @selected($vehicle->type == "Trailer")>
                          Trailer
                        </option>
                        <option @selected($vehicle->type == "Wingbox")>
                          Wingbox
                        </option>
                        <option @selected($vehicle->type == "Dump Truck")>
                          Dump Truck
                        </option>
                        <option @selected($vehicle->type == "Container")>
                          Container
                        </option>
                        <option @selected($vehicle->type == "Tanki Truck")>
                          Tanki Truck
                        </option>
                      </select>
                      <div class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="maxCapacity">Kapasitas Maksimal</label>
                    </div>
                  </div>
                  <div class="col-md-9">
                    <div class="form-group">
                      <select
                        class="custom-select"
                        name="max_capacity"
                        id="maxCapacity"
                      >
                        <option value="" disabled selected>--Pilih Kapasitas Maksimal--</option>
                        <option @selected($vehicle->max_capacity == 1.500)>
                          1.500
                        </option>
                        <option @selected($vehicle->max_capacity == 5.000)>
                          5.000
                        </option>
                        <option @selected($vehicle->max_capacity == 8.000)>
                          8.000
                        </option>
                        <option @selected($vehicle->max_capacity == 10.000)>
                          10.000
                        </option>
                        <option @selected($vehicle->max_capacity == 13.500)>
                          13.500
                        </option>
                        <option @selected($vehicle->max_capacity == 15.000)>
                          15.000
                        </option>
                        <option @selected($vehicle->max_capacity == 20.000)>
                          20.000
                        </option>
                        <option @selected($vehicle->max_capacity == 30.000)>
                          30.000
                        </option>
                        <option @selected($vehicle->max_capacity == 60.000)>
                          60.000
                        </option>
                      </select>
                      <div class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="stnk">STNK</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="custom-file">
                        <input
                          type="file"
                          class="custom-file-input"
                          id="stnk"
                          name="stnk"
                        />
                        <div class="invalid-feedback"></div>
                        <label class="custom-file-label" for="stnk">Pilih file</label>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <img
                      src="/{{ $vehicle->stnk }}"
                      class="img-fluid img-preview"
                      onerror="this.src='/assets/images/default-image.jpg';this.onerror='';"
                    />
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
                            <option
                              value="{{ $company->id }}"
                              @selected($vehicle->company_id == $company->id)
                            >
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
              <div class="form-actions mt-3">
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
    $('.custom-file-input').on('change', function(e) {
      const file = new FileReader();
      file.readAsDataURL(this.files[0]);
      file.onload = (e) => {
        $('.custom-file-label').html(this.files[0].name)
        $('.img-preview').attr('src', e.target.result)
      };

    })

    $('#vehicles').on('submit', function(e) {
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

          location.href = '/vehicles'
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
    });
  </script>
@endpush
