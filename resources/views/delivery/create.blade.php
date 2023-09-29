@extends('layouts.main')

@section('title', 'Pengiriman Material')

@push('style')
  <style>
    .autocomplete-items {
      position: absolute;
      border: 1px solid #d4d4d4;
      border-bottom: none;
      border-top: none;
      z-index: 99;
      top: 100%;
      left: 0;
      right: 0;
    }

    .autocomplete-items div {
      padding: 0.375rem 0.75rem;
      cursor: pointer;
      background-color: #fff;
      border-bottom: 1px solid #d4d4d4;
    }

    /*when hovering an item:*/
    .autocomplete-items div:hover {
      background-color: #e9e9e9;
    }

    /*when navigating through the items using the arrow keys:*/
    .autocomplete-active {
      background-color: DodgerBlue !important;
      color: #ffffff;
    }
  </style>
@endpush

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title"></h4>
          <form action="/deliveries" method="POST" id="deliveries">
            @csrf
            <div class="container">
              <div class="form-body">

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="sender">Pengirim</label>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="form-group position-relative">
                      <input
                        type="hidden"
                        name="company_id"
                        value="{{ Auth::user()->company_id }}"
                      />
                      @can('admin')
                        <input
                          type="text"
                          class="form-control"
                          id="sender"
                          name="company_name"
                          placeholder="Masukkan Nama Pengirim"
                        />
                        <div class="invalid-feedback"></div>
                      @else
                        <p>{{ Auth::user()->company->name }}</p>
                      @endcan
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="no">No Surat Jalan</label>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="form-group">
                      <input
                        type="text"
                        class="form-control"
                        id="no"
                        name="no"
                        placeholder="No Surat Jalan"
                      />
                      <div class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="input-group-prepend">
                      <label for="materialName">Material</label>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="form-group">
                      <select
                        class="custom-select material"
                        id="materialName"
                        name="material_id"
                      >
                        <option value="" disabled selected>--Pilih Material--</option>
                        @foreach ($materials as $material)
                          <option value="{{ $material->material_id }}">
                            {{ $material->material->name }}
                          </option>
                        @endforeach
                      </select>
                      <div class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="materialCode">Kode Material</label>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="form-group">
                      <select
                        class="custom-select material"
                        id="materialCode"
                        name="material_id"
                      >
                        <option value="" disabled selected>--Pilih Kode Material--</option>
                        @foreach ($materials as $material)
                          <option value="{{ $material->material_id }}">
                            {{ $material->material->code }}
                          </option>
                        @endforeach
                      </select>
                      <div class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="vehiclePlatNumber">No Kendaraan</label>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="form-group">
                      <select
                        class="custom-select"
                        id="vehiclePlatNumber"
                        name="vehicle_id"
                      >
                        <option value="" disabled selected>--Pilih No Kendaraan--</option>
                        @foreach ($vehicles as $vehicle)
                          <option value="{{ $vehicle->id }}">
                            {{ $vehicle->plat_number }}
                          </option>
                        @endforeach
                      </select>
                      <div class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="vehicleType">Jenis Kendaraan</label>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="form-group">
                      <select
                        class="custom-select"
                        id="vehicleType"
                        name="vehicle_id"
                      >
                        <option value="" disabled selected>--Pilih Jenis Kendaraan--</option>
                        @foreach ($vehicles as $vehicle)
                          <option value="{{ $vehicle->id }}">
                            {{ $vehicle->type }}
                          </option>
                        @endforeach
                      </select>
                      <div class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="vehicleMaxCapacity">Kapasitas Max Kendaraan (Kg)</label>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="form-group">
                      <select
                        class="custom-select"
                        id="vehicleMaxCapacity"
                        name="vehicle_id"
                      >
                        <option value="" disabled selected>--Pilih Kapasitas--</option>
                        @foreach ($vehicles as $vehicle)
                          <option value="{{ $vehicle->id }}">
                            {{ $vehicle->max_capacity }}
                          </option>
                        @endforeach
                      </select>
                      <div class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="driverName">Nama Supir</label>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="form-group">
                      <select
                        class="custom-select"
                        id="driverName"
                        name="driver_id"
                      >
                        <option value="" disabled selected>--Pilih Nama Supir--</option>
                        @foreach ($drivers as $driver)
                          <option value="{{ $driver->id }}">
                            {{ $driver->name }}
                          </option>
                        @endforeach
                      </select>
                      <div class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="date">Tanggal Kirim</label>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="form-group">
                      <input
                        type="date"
                        class="form-control"
                        id="date"
                        name="date"
                      />
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
    // On submit event delivery form
    $('#deliveries').on('submit', function(e) {
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
          this.reset()

          Swal.fire({
            title: 'Berhasil!',
            text: data.message,
            icon: 'success',
            timer: 1500
          });

          window.location.href = `/deliveries`
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

    // Autocomplete company search on admin
    function autocomplete(inp) {
      let currentFocus;
      inp.on('input', function (e) {
        const val = inp.val();
        closeAllLists();
        if (!val) return false;

        currentFocus = -1;
        const a = $('<div>')
          .attr('id', `${inp.attr('id')}autocomplete-list`)
          .addClass('autocomplete-items');
        inp.parent().append(a);

        $.get(`/companies/search?name=${val}`, function (data) {
          for (let i = 0; i < data.length; i++) {
            if (
              data[i].name.substr(0, val.length).toUpperCase() ==
              val.toUpperCase()
            ) {
              const b = $('<div>')
                .html(
                  `<strong>${data[i].name.substr(0, val.length)}</strong>${data[i].name.substr(val.length)}<input type="hidden" value="${data[i].name}" data-id="${data[i].id}">`
                )
                .on('click', function (e) {
                  const input = $(this).find('input')[0];
                  inp.val(input.value);
                  $('input[name="company_id"]').val(input.dataset.id);
                  closeAllLists();
                });
              a.append(b);
            }
          }
        });
      });

      inp.on('keydown', function (e) {
        const x = $(`#${inp.attr('id')}autocomplete-list`).find('div');
        if (e.keyCode == 40) {
          currentFocus++;
          addActive(x);
        } else if (e.keyCode == 38) {
          currentFocus--;
          addActive(x);
        } else if (e.keyCode == 13) {
          e.preventDefault();
          if (currentFocus > -1) {
            x[currentFocus].click();
          }
        }
      });

      function addActive(x) {
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = x.length - 1;
        x[currentFocus].classList.add('autocomplete-active');
      }

      function removeActive(x) {
        x.removeClass('autocomplete-active');
      }

      $(document).on('click', function (e) {
        closeAllLists(e.target);
      });

      function closeAllLists(elmnt) {
        $('.autocomplete-items').not(elmnt).not(inp).remove();
      }
    }

    const sender = $('#sender');
    if (sender.length) {
      autocomplete(sender);
    }

    // Automatic input material
    $('.material').on('change', function () {
      const el = $(this).attr('id').includes('Name')
        ? $(this).attr('id').replace('Name', 'Code')
        : $(this).attr('id').replace('Code', 'Name');

      $.ajax({
        url: `/materials/${this.value}`,
        success: (data) => $(`#${el}`).val(data.id),
      });
    });

    // Automatic input vehicle
    $('#vehiclePlatNumber').on('change', function(e) {
      $.ajax({
        url: `/vehicles/${e.target.value}`,
        success: (data) => {
          $('#vehicleType').val(data.id)
          $('#vehicleMaxCapacity').val(data.id)
        }
      });
    });
  </script>
@endpush
