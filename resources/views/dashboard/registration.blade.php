@extends('layouts.main')

@section('title', 'Registrasi')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <form
            action="/register"
            method="POST"
            id="registration"
            enctype="multipart/form-data"
          >
            @csrf
            <div class="container">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="companyName">Nama Perusahaan</label>
                    </div>
                  </div>
                  <div class="col-md-10">
                    <div class="form-group">
                      <input
                        type="text"
                        class="form-control"
                        id="companyName"
                        name="company_name"
                        placeholder="Masukkan Nama Perusahaan"
                        value="{{ Auth::user()->company?->name }}"
                      />
                      <div class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="companyAddress">Alamat Perusahaan</label>
                    </div>
                  </div>
                  <div class="col-md-10">
                    <div class="form-group">
                      <input
                        type="text"
                        id="companyAddress"
                        class="form-control"
                        name="company_address"
                        placeholder="Masukkan Alamat Perusahaan"
                        value="{{ Auth::user()->company?->address }}"
                      />
                      <div class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>

                <div class="row" id="material">
                  <div class="col-md-2">
                    <div class="input-group-prepend">
                      <label>Material</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Nama Material</label>
                      <select
                        class="custom-select auto"
                        name="materials[0][name]"
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
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Kode Material</label>
                      <input
                        type="text"
                        class="form-control auto"
                        name="materials[0][code]"
                        placeholder="Masukkan Kode Material"
                      />
                      <div class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="col-md-1">
                    <div class="form-group h-100 d-flex align-items-center">
                      <button
                        data-target="material"
                        type="button"
                        data-toggle="tooltip"
                        title="Tambah Material"
                        class="btn btn-primary btn-circle"
                        style="box-shadow: 0px 4px 30px rgba(0, 0, 0, 0.175);"
                      >
                        +
                      </button>
                    </div>
                  </div>
                </div>

                <div class="row" id="vehicle">
                  <div class="col-md-2">
                    <div class="input-group-prepend">
                      <label>Kendaraan</label>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>No Plat</label>
                      <input
                        type="text"
                        class="form-control"
                        name="vehicles[0][plat_number]"
                        placeholder="No Kendaraan"
                      />
                      <div class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Jenis</label>
                      <select
                        class="custom-select"
                        name="vehicles[0][type]"
                      >
                        <option value="" disabled selected>--Pilih Jenis Kendaraan--</option>
                        <option>Pick Up</option>
                        <option>Colt Diesel</option>
                        <option>Truck Fuso</option>
                        <option>Tronton</option>
                        <option>Trintin</option>
                        <option>Trinton</option>
                        <option>Trailer</option>
                        <option>Wingbox</option>
                        <option>Container</option>
                        <option>Dump Truck</option>
                        <option>Tanki Truck</option>
                      </select>
                      <div class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Kap. Maks(Kg)</label>
                      <select
                        class="custom-select"
                        name="vehicles[0][max_capacity]"
                      >
                        <option value="" disabled selected>--Pilih Kapasitas Max--</option>
                        <option>1.500</option>
                        <option>5.000</option>
                        <option>8.000</option>
                        <option>20.000</option>
                        <option>30.000</option>
                        <option>60.000</option>
                        <option>10.000</option>
                        <option>13.500</option>
                        <option>15.000</option>
                      </select>
                      <div class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="stnk">STNK</label>
                      <input
                        type="file"
                        class="form-control-file"
                        name="vehicles[0][stnk]"
                      />
                      <div class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="col-md-1">
                    <div class="form-group h-100 d-flex align-items-center">
                      <button
                        type="button"
                        data-target="vehicle"
                        data-toggle="tooltip"
                        title="Tambah Kendaraan"
                        class="btn btn-primary btn-circle"
                        style="box-shadow: 0px 4px 30px rgba(0, 0, 0, 0.175);"
                      >
                        +
                      </button>
                    </div>
                  </div>
                </div>

                <div class="row" id="driver">
                  <div class="col-md-2">
                    <div class="input-group-prepend">
                      <label>Supir</label>
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="form-group">
                      <label>Nama Supir</label>
                      <input
                        type="text"
                        class="form-control"
                        name="drivers[0][name]"
                        placeholder="Masukkan Nama"
                      />
                      <div class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>No Telepon</label>
                      <input
                        type="text"
                        class="form-control"
                        name="drivers[0][contact]"
                        placeholder="Masukkan No Telepon"
                      />
                      <div class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="col-md-1">
                    <div class="form-group h-100 d-flex align-items-center">
                      <button
                        type="button"
                        data-target="driver"
                        data-toggle="tooltip"
                        title="Tambah Supir"
                        class="btn btn-primary btn-circle"
                        style="box-shadow: 0px 4px 30px rgba(0, 0, 0, 0.175);"
                      >
                        +
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-actions">
                <div class="text-left">
                  <button type="submit" class="btn btn-info" id="register">
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
    // const addButtons = document.querySelectorAll('button[type="button"]')
    // addButtons.forEach(addButton => {
    //   addButton.addEventListener('click', function(e) {
    //     const currentRow = document.getElementById(e.target.dataset.target)
    //     const rowDiv = currentRow.cloneNode(true);

    //     rowDiv.querySelectorAll('label, input, select, [type="button"]').forEach(e => {
    //       if (e.tagName == 'INPUT' || e.tagName == 'SELECT') {
    //         let i = +e.name.match(/\d/g)[0]
    //         e.name = e.name.replace(/\d/, ++i)
    //         e.value = ''
    //       } else {
    //         e.remove()
    //       }
    //     })

    //     currentRow.after(rowDiv)
    //     currentRow.removeAttribute('id')
    //   })
    // })

    // Add dynamic input row (material, vehicle and driver)
    $('[type="button"]').on('click', function (e) {
      const currentRow = $(`#${$(this).data('target')}`);
      const rowDiv = currentRow.clone(true);

      rowDiv.find('label, input, select, [type="button"]').each(function () {
        if ($(this).is('input') || $(this).is('select')) {
          let i = +$(this).attr('name').match(/\d/g)[0];
          $(this).attr('name', $(this).attr('name').replace(/\d/, ++i)).val('');
        } else {
          $(this).remove();
        }
      });

      currentRow.after(rowDiv).removeAttr('id');
    });

    // On submit event registration form
    $('#registration').on('submit', function(e) {
      e.preventDefault();

      $.ajax({
        url: this.action,
        method: this.method,
        data: new FormData(this),
        processData: false,
        contentType: false,
        beforeSend: () => {
          $('#register').attr('disabled', true)
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
        },
        error: (err) => {
          const errors = err.responseJSON.errors

          $('input, select').each(function(i, e) {
            let element = e.name.replace(/(\w+)\[(\d+)\]\[(\w+)\]/g, "$1.$2.$3")
            if (element in errors) {
              $(e).addClass('is-invalid').next().html(errors[element])
            } else {
              $(e).removeClass('is-invalid');
            }
          });
        },
        complete: () => {
          $('.spinner-border').addClass('d-none').next().html('Submit')
          $('#register').attr('disabled', false)
        }
      });
    })

    // Automatic name or material code
    $(document).on('change', '.auto', function (e) {
      const auto = this.name.includes('name');
      const url = `/materials/${auto ? this.value : `code/${this.value}`}`;
      const element = auto
        ? this.name.replace('name', 'code')
        : this.name.replace('code', 'name');

      $.ajax({
        url,
        success: (data) => {
          $(`[name='${element}']`).val(auto ? data.code : data.id);
        },
      });
    });
  </script>
@endpush
