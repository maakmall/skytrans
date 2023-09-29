@extends('layouts.main')

@section('title', 'Pengiriman')

@push('style')
  <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">

  <style>
    .form-control {
      display: block;
      width: 30%;
      height: calc(1.5em + 0.75rem + 2px);
      padding: 0.375rem 0.75rem;
      font-size: 1rem;
      font-weight: 400;
      line-height: 1.5;
      color: #4f5467;
      background-color: #fff;
      background-clip: padding-box;
      border: 2px solid #e9ecef;
      border-radius: 20px;
      transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    @media (prefers-reduced-motion: reduce) {
      .form-control {
        transition: none;
      }
    }

    .form-control::-ms-expand {
      background-color: transparent;
      border: 0;
    }

    .form-control:focus {
      color: #4f5467;
      background-color: #fff;
      border-color: #5f76e8;
      outline: 0;
      box-shadow: transparent;
    }

    .form-control::placeholder {
      color: #b8c3d5;
      opacity: 1;
    }

    .form-control:disabled,
    .form-control[readonly] {
      background-color: #e9ecef;
      opacity: 1;
    }

    .form-control-file,
    .form-control-range {
      display: block;
      width: 100%;
    }

    .qrPreviewVideo {
      max-width: 100%;
      position: absolute;
      top: 0;
    }

    @media (min-width: 992px) {
      .qrPreviewVideo {
        max-height: 100%;
        max-width: none;
      }
    }

    tr[role="row"] { cursor: pointer; }
  </style>
@endpush

@section('content')
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title mb-4 d-flex justify-content-between align-items-center">
            Riwayat Pengiriman
            <div>
              @if (Auth::user()->company_id || Auth::user()->is_admin)
                <a href="/deliveries/create" class="btn btn-primary">
                  + Pengiriman
                </a>
              @endif
            </div>
          </h4>
          <div class="table-responsive">
            <table
              id="myTable"
              class="table table-hover table-bordered no-wrap text-center"
            >
              <thead>
                <tr>
                  <th>ID</th>
                  @can('admin') <th id="1">Pengirim</th> @endcan
                  <th>Material</th>
                  <th>Tanggal Pengiriman</th>
                  <th>Status</th>
                  @can('admin') <th>Aksi</th> @endcan
                </tr>
              </thead>
              <tbody>
              </tbody>
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

    // Datatables
    $('#myTable').DataTable({
      ajax: {
        url: '/deliveries',
        dataSrc: ''
      },
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
      columns: [
        { data: 'qr_code' },
        @can('admin') { data: 'company_name' }, @endcan
        {
          data: null,
          render: (data) => `${data.material_code} - ${data.material_name}`
        },
        {
          data: null,
          render: (data) => formatDate(data.date),
        },
        {
          data: null,
          render: (data) =>
            `<span
              class="badge ${data.status == 'Dikirim' ? 'bg-warning' : 'bg-success'} text-white font-weight-medium badge-pill"
            >
              ${data.status}
            </span>`,
        },
        @can('admin')
        {
          data: null,
          className: 'my-action',
          render: (data) => {
            const isTrue = document.getElementById('1');
            const confirmButton = `
              <button class="btn btn-outline-primary btn-sm accept" data-id="${ data.id }">
                <span class="far fa-check-circle"></span>
                Terima
              </button>`

            return isTrue && data.status == 'Dikirim' ? confirmButton : ''
          },
          searchable: false,
          orderable: false
        },
        @endcan
      ]
    });
  </script>
@endpush
