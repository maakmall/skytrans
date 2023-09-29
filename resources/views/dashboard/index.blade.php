@extends('layouts.main')

@section('title', 'Dashboard')

@push('style')
  <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">

  <style>
    .display-5 {
      font-size: 2em;
    }

    tbody tr {
      cursor: pointer;
    }
  </style>
@endpush

@section('content')
  <div class="card-group">
    <div class="card border-right">
      <div class="card-body">
        <div class="d-flex d-lg-flex d-md-block align-items-center">
          <div>
            <div class="d-inline-flex align-items-center">
              <h2 class="text-dark mb-1 font-weight-medium" id="material">
              </h2>
              <div class="spinner-border mb-2" role="status">
                <span class="sr-only">Loading...</span>
              </div>
            </div>
            <h6
              class="text-muted font-weight-normal mb-0 w-100 text-truncate"
            >
              Material
            </h6>
          </div>
          <div class="ml-auto mt-md-3 mt-lg-0">
            <span class="opacity-7 text-muted"
              ><i class="icon-social-dropbox display-5"></i
            ></span>
          </div>
        </div>
      </div>
    </div>
    <div class="card border-right">
      <div class="card-body">
        <div class="d-flex d-lg-flex d-md-block align-items-center">
          <div>
            <h2 class="text-dark mb-1 font-weight-medium" id="delivery"></h2>
            <div class="spinner-border mb-2" role="status">
              <span class="sr-only">Loading...</span>
            </div>
            <h6
              class="text-muted font-weight-normal mb-0 w-100 text-truncate"
            >
              Pengiriman
            </h6>
          </div>
          <div class="ml-auto mt-md-3 mt-lg-0">
            <span class="opacity-7 text-muted"
              ><i class="icon-arrow-right-circle display-5"></i
            ></span>
          </div>
        </div>
      </div>
    </div>
    <div class="card border-right">
      <div class="card-body">
        <div class="d-flex d-lg-flex d-md-block align-items-center">
          <div>
            <div class="d-inline-flex align-items-center">
              <h2 class="text-dark mb-1 font-weight-medium" id="vehicle"></h2>
              <div class="spinner-border mb-2" role="status">
                <span class="sr-only">Loading...</span>
              </div>
            </div>
            <h6
              class="text-muted font-weight-normal mb-0 w-100 text-truncate"
            >
              Kendaraan
            </h6>
          </div>
          <div class="ml-auto mt-md-3 mt-lg-0">
            <span class="opacity-7 text-muted"
              ><i class="icon-paper-plane display-5"></i
            ></span>
          </div>
        </div>
      </div>
    </div>
    @can('admin')
      <div class="card">
        <div class="card-body">
          <div class="d-flex d-lg-flex d-md-block align-items-center">
            <div>
              <h2 class="text-dark mb-1 font-weight-medium" id="company"></h2>
              <div class="spinner-border mb-2" role="status">
                <span class="sr-only">Loading...</span>
              </div>
              <h6
                class="text-muted font-weight-normal mb-0 w-100 text-truncate"
              >
                Perusahaan
              </h6>
            </div>
            <div class="ml-auto mt-md-3 mt-lg-0">
              <span class="opacity-7 text-muted"
                ><i class="icon-briefcase display-5"></i
              ></span>
            </div>
          </div>
        </div>
      </div>
    @else
      <div class="card">
        <div class="card-body">
          <div class="d-flex d-lg-flex d-md-block align-items-center">
            <div>
              <h2 class="text-dark mb-1 font-weight-medium" id="driver"></h2>
              <div class="spinner-border mb-2" role="status">
                <span class="sr-only">Loading...</span>
              </div>
              <h6
                class="text-muted font-weight-normal mb-0 w-100 text-truncate"
              >
                Driver
              </h6>
            </div>
            <div class="ml-auto mt-md-3 mt-lg-0">
              <span class="opacity-7 text-muted"
                ><i class="icon-people display-5"></i
              ></span>
            </div>
          </div>
        </div>
      </div>
    @endcan
  </div>

  <div class="row" data-message="{{ session('message') }}">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center mb-4">
            <h4 class="card-title">On The Way</h4>
          </div>
          <div class="table-responsive">
            <table class="table table-hover v-middle text-center" id="myTable">
              <thead>
                <tr class="border-0">
                  <th class="border-0 font-14 font-weight-medium text-muted">
                    ID
                  </th>
                  @can('admin')
                    <th class="border-0 font-14 font-weight-medium text-muted px-2">
                      Pengirim
                    </th>
                  @endcan
                  <th class="border-0 font-14 font-weight-medium text-muted">
                    Material
                  </th>
                  <th
                    class="border-0 font-14 font-weight-medium text-muted text-center"
                  >
                    Tanggal Pengiriman
                  </th>
                  @can('admin')
                    <th
                      class="border-0 font-14 font-weight-medium text-muted text-center"
                    >
                      Aksi
                    </th>
                  @endcan
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('script')
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
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

    // Show accept confirmation
    $(document).on('click', '.accept', function () {

      Swal.fire({
        title: 'Apakah anda yakin?',
        text: 'Konfirmasi penerimaan material',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff4f70',
        cancelButtonColor: '#6975e9',
        confirmButtonText: 'Ya, Terima!',
      }).then((result) => {
        if (result.isConfirmed) {
          
          $.ajax({
            url: `/deliveries/${$(this).data('id')}`,
            method: 'POST',
            data: { _token: '{{ csrf_token() }}', _method: 'PUT' },
            success: (data) => {
              Swal.fire({
                title: 'Berhasil!',
                text: data.message,
                icon: 'success',
                timer: 1500
              });

              location.reload();
            }
          });

        }
      });
    });

    $(document).ready(function () {
      $.get('/', function (data) {
        $.each(data, function(key, value) {
          $(`#${key}`).html(value).next().hide()
        })

        $('#myTable').DataTable({
          data: data.deliveriesHasNotBeenReceived,
          columns: [
            { data: 'qr_code' },
            @can('admin') { data: 'company_name' }, @endcan
            {
              data: null,
              render: (data) => `${data.material_code} - ${data.material_name}`
            },
            {
              data: null,
              render: (data) => formatDate(data.date)
            },
            @can('admin')
              {
                data: null,
                className: 'my-action',
                render: (data) => `
                  <button class="btn btn-outline-primary btn-sm accept" data-id="${ data.id }">
                    <span class="far fa-check-circle"></span>
                    Terima
                  </button>`
                ,
              }
            @endcan
          ],
          searching: false,
          paging: false,
          info: false,
          ordering: false,
          createdRow: (tr, data) => {
            $(tr).find('td').each(function() {
              const td = $(this);
              if (!td.hasClass('my-action')) {
                td.on('click', function() {
                  location.href = `/deliveries/${data.id}`
                })
              }
            })
          },
        })
      })
    })
  </script>
@endpush
