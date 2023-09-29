@extends('layouts.main')

@section('title', 'Pengajuan')

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

    tbody tr { cursor: pointer; }
  </style>
@endpush

@section('content')
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title mb-4">
            Tabel Pengajuan
          </h4>
          <div class="table-responsive">
            <table
              class="table table-hover table-bordered no-wrap text-center"
              id="myTable"
            >
              <thead>
                <tr>
                  <th>User</th>
                  <th>Aksi</th>
                  <th>Data</th>
                  <th>Tanggal</th>
                  <th>Status</th>
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
    $('#myTable').DataTable({
      ajax: {
        url: '/requests',
        dataSrc: ''
      },
      columns: [
        { data: 'user.username' },
        { data: 'action' },
        { data: 'data' },
        {
          data: null,
          render: (data) => formatDate(data.created_at),
        },
        {
          data: null,
          render: (data) =>
            `<span
              class="badge ${data.status == 'Pending'
                ? 'bg-primary'
                : (data.status == 'Ditolak') ? 'bg-danger' : 'bg-success'}
                text-white font-weight-medium badge-pill"
            >
              ${data.status}
            </span>`,
        },
      ],
      createdRow: (tr, data) => {
        $(tr).on('click', function() {
          location.href = `/requests/${data.id}`
        })
      }
    });
  </script>
@endpush
