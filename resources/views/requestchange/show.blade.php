@extends('layouts.main')

@section('title', 'Detail Pengajuan')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title mb-3">Pengaju</h4>
          <div class="row justify-content-between align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
              <div class="row">
                <span class="col col-md-5">Username</span>
                <span class="col">: {{ $request->user->username }}</span>
              </div>
              <div class="row my-2">
                <span class="col col-md-5">Perusahaan</span>
                <span class="col">: {{ $request->user->company->name }}</span>
              </div>
              <div class="row">
                <span class="col col-md-5">Aksi</span>
                <span class="col">: {{ $request->action }}</span>
              </div>
              <div class="row my-2">
                <span class="col col-md-5">Data</span>
                <span class="col">: {{ $request->data }}</span>
              </div>
              <div class="row mb-2">
                <span class="col col-md-5">Tanggal Pengajuan</span>
                <span class="col">:
                  {{ formatDate(date('Y-m-d', strtotime($request->created_at))) }}
                </span>
              </div>
              <div class="row">
                <span class="col col-md-5">Status</span>
                <span class="col">:
                  <span @class([
                    'badge',
                    'badge-pill',
                    'badge-primary' => $request->status == 'Pending',
                    'badge-danger' => $request->status == 'Ditolak',
                    'badge-success' => $request->status == 'Disetujui',
                  ])>
                    {{ $request->status }}
                  </span>
                </span>
              </div>
            </div>
            @if ($request->status == 'Pending' && Auth::user()->is_admin)
              <div class="col-md-5">
                <button
                  class="btn btn-primary btn-rounded btn-block mb-2 confirm"
                  data-id="{{ $request->id }}"
                  data-approve="1"
                >
                  <i class="fas fa-check"></i>
                  <span class="spinner-border spinner-border-sm mr-1 d-none" role="status" aria-hidden="true"></span>
                  Setuju
                </button>
                <button
                  class="btn btn-danger btn-rounded btn-block confirm"
                  data-id="{{ $request->id }}"
                  data-approve="0"
                >
                  <i class="fas fa-times"></i>
                  <span class="spinner-border spinner-border-sm mr-1 d-none" role="status" aria-hidden="true"></span>
                  Tolak
                </button>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title mb-4">Data</h4>
          @if ($request->data == 'Kendaraan')
            <div class="row mb-2">
              <span class="col">No. Plat</span>
              <span class="col">: {{ $data->plat_number }}</span>
            </div>
            <div class="row mb-2">
              <span class="col">Jenis</span>
              <span class="col">: {{ $data->type }}</span>
            </div>
            <div class="row mb-2">
              <span class="col">Kapasitas Maksimal</span>
              <span class="col">: {{ $data->max_capacity }}</span>
            </div>
            <div class="row mb-2">
              <span class="col">STNK</span>
              <span class="col">:</span>
              <img
                src="/{{ $data->stnk }}"
                onerror="this.src='/assets/images/default-image.jpg';this.onerror='';"
                class="img-fluid mt-3"
                alt="STNK"
              />
            </div>
          @elseif ($request->data == 'Driver')
            <div class="row mb-2">
              <span class="col">Nama</span>
              <span class="col">: {{ $data->name }}</span>
            </div>
            <div class="row mb-2">
              <span class="col">Kontak</span>
              <span class="col">: {{ $data->contact }}</span>
            </div>
          @else
            <div class="row mb-2">
              <span class="col">Kode</span>
              <span class="col">: {{ $data->code ?? '-'}}</span>
            </div>
            <div class="row mb-2">
              <span class="col">Material</span>
              <span class="col">: {{ $data->name ?? '-' }}</span>
            </div>
          @endif
        </div>
      </div>
    </div>
    @if ($request->action == 'Update')
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">Data Perubahan</h4>
            @if ($request->data == 'Kendaraan')
              <div class="row mb-2">
                <span class="col">No. Plat</span>
                <span class="col">: {{ $data_change->plat_number }}</span>
              </div>
              <div class="row mb-2">
                <span class="col">Jenis</span>
                <span class="col">: {{ $data_change->type }}</span>
              </div>
              <div class="row mb-2">
                <span class="col">Kapasitas Maksimal</span>
                <span class="col">: {{ $data_change->max_capacity }}</span>
              </div>
              <div class="row mb-2">
                <span class="col">STNK</span>
                <span class="col">:</span>
                <img
                  src="/{{ $data_change->stnk }}"
                  onerror="this.src='/assets/images/default-image.jpg';this.onerror='';"
                  class="img-fluid mt-3"
                  alt="STNK"
                />
              </div>
            @elseif ($request->data == 'Driver')
              <div class="row mb-2">
                <span class="col">Nama</span>
                <span class="col">: {{ $data_change->name }}</span>
              </div>
              <div class="row mb-2">
                <span class="col">Kontak</span>
                <span class="col">: {{ $data_change->contact }}</span>
              </div>
            @else
              <div class="row mb-2">
                <span class="col">Kode</span>
                <span class="col">: {{ $data_change->code ?? '-' }}</span>
              </div>
              <div class="row mb-2">
                <span class="col">Material</span>
                <span class="col">: {{ $data_change->name ?? '-' }}</span>
              </div>
            @endif
          </div>
        </div>
      </div>
    @endif
  </div>
@endsection

@push('script')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    // Show delete confirmation
    $('.confirm').on('click', function () {

      Swal.fire({
        title: 'Apakah anda yakin?',
        text: 'Data yang sudah dikonfirmasi tidak bisa diubah lagi',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya',
      }).then((result) => {
        if (result.isConfirmed) {
          const { id, approve } = $(this).data();

          $(this).attr('disabled', true)
            .find('.spinner-border')
            .removeClass('d-none')
            .prev().hide()

          $.ajax({
            url: `/requests/${id}/confirm?approve=${approve}`,
            method: 'POST',
            data: { _token: '{{ csrf_token() }}', _method: 'PUT' },
            success: (data) => {
              Swal.fire({
                title: 'Berhasil!',
                text: data.message,
                icon: 'success',
                timer: 1500
              });

              location.reload()
            }
          });
        }
      });
    });
  </script>
@endpush
