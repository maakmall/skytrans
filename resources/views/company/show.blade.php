@extends('layouts.main')

@section('title', 'Detail Perusahaan')

@section('content')
  <div class="row" data-message="{{ session('message') }}">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title mb-4">Detail</h4>
          <div class="row">
            <div class="col-2">Username</div>
            <div class="col">: {{ $company->user?->username }}</div>
          </div>
          <div class="row">
            <div class="col-2">Nama</div>
            <div class="col">: {{ $company->name }}</div>
          </div>
          <div class="row">
            <div class="col-2">Alamat</div>
            <div class="col">: {{ $company->address }}</div>
          </div>
          <div class="row mt-4">
            <h4 class="card-title w-100 mb-3 d-flex justify-content-between align-items-center">
              List Material
              <button type="button" class="btn btn-primary" id="addMaterial">
                + Tambah Material
              </button>
            </h4>
            <table class="table table-striped table-bordered no-wrap text-center">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode</th>
                  <th>Material</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($company->materials as $material)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $material->material->code ?? '-' }}</td>
                    <td>{{ $material->material->name ?? '-' }}</td>
                    <td>
                      <form
                        action="/companies/materials/{{ $material->id }}"
                        method="POST"
                        class="d-inline delete"
                      >
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">
                          <i class="far fa-trash-alt"></i>
                          Hapus
                        </button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('script')
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

    // Show delete confirmation
    $('.delete').on('submit', function (e) {
      e.preventDefault();

      Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data yang sudah dihapus tidak bisa dikembalikan lagi",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff4f70',
        cancelButtonColor: '#6975e9',
        confirmButtonText: 'Ya, Hapus!',
      }).then((result) => {
        if (result.isConfirmed) {
          this.submit()
        }
      });
    });

    $('#addMaterial').on('click', async function () {

      Swal.fire({
        title: 'Tambah Material',
        html: `
          <select class="custom-select mb-3 auto" id="name"></select>
          <input class="form-control auto" id="code">
        `,
        showCancelButton: true,
        showLoaderOnConfirm: true,
        willOpen: () => {
          Swal.showLoading()

          $.get('/materials', function (data) {
            const select = $('#name');
            select.empty();

            select.append($('<option value="" selected disabled>--Pilih Material--</option>'))
            $.each(data, function(index, option) {
              select.append($('<option></option>')
                    .attr('value', option.id)
                    .text(option.name));
            });

            Swal.hideLoading()
          })
        },
        didOpen: () => {
          $(Swal.getHtmlContainer()).on('change', '.auto', function (e) {
            const auto = this.id == 'name';
            const url = `/materials/${auto ? this.value : `code/${this.value}`}`;
            const element = auto ? 'code' : 'name'

            $.get(url, (data) => {
              $(`#${element}`).val(auto ? data.code : data.id);
            });
          });
        },
        preConfirm: () => {

          $.post('/companies/{{ $company->id }}/materials', {
            _token: '{{ csrf_token() }}',
            material_id: $('#name').val(),
          })
            .done((res) => {
              Swal.fire('Berhasil', res.message, 'success')
              location.reload()
            })
            .fail((err) => {
              Swal.fire('Gagal', err.responseJSON.message, 'error')
            })
        }
      })

    })
  </script>
@endpush
