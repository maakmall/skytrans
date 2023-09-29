@extends('layouts.main')

@section('title', 'User')

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
  </style>
@endpush

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title mb-4 d-flex justify-content-between align-items-center">
            Tabel User
            <a href="/users/create" class="btn btn-primary">
              + Tambah User
            </a>
          </h4>
          <div class="table-responsive">
            <table
              class="table table-striped table-bordered no-wrap text-center"
              id="myTable"
            >
              <thead>
                <tr>
                  <th>No</th>
                  <th>Username</th>
                  <th>No. Telepon</th>
                  <th>Perusahaan</th>
                  <th>Aksi</th>
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
        url: '/users',
        dataSrc: ''
      },
      columns: [
        {
          data: null,
          render: (data, type, row, meta) => meta.row + 1
        },
        { data: 'username' },
        { data: 'phone' },
        { data: 'company.name' },
        {
          data: null,
          render: (data) => `
            <a href="/users/${ data.id }/edit" class="btn btn-warning">
              <i class="far fa-edit"></i>
              Edit
            </a>
            <button class="btn btn-danger delete" data-id="${ data.id }">
              <i class="far fa-trash-alt"></i>
              Hapus
            </button>`
          ,
          searchable: false,
          orderable: false
        },
      ],
    });

    // Show delete confirmation
    $(document).on('click', '.delete', function () {

      Swal.fire({
        title: 'Apakah anda yakin?',
        text: 'Data yang sudah dihapus tidak bisa dikembalikan lagi',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff4f70',
        cancelButtonColor: '#6975e9',
        confirmButtonText: 'Ya, Hapus!',
      }).then((result) => {
        if (result.isConfirmed) {
          $(this).attr('disabled', true);

          $.ajax({
            url: `/users/${$(this).data('id')}`,
            method: 'POST',
            data: { _token: '{{ csrf_token() }}', _method: 'DELETE' },
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
  </script>
@endpush
