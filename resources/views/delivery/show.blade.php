@extends('layouts.main')

@section('title', 'Pengiriman Material')

@section('content')
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title text-center mb-5">Surat Jalan</h4>

          <div class="row justify-content-around">
            <div class="col-lg-5">
              <div class="row">
                <label class="col col-md-5">No. Surat Jalan</label>
                <p class="col">: {{ $delivery->no }}</p>
              </div>
              <div class="row">
                <label class="col col-md-5">Pengirim</label>
                <p class="col">: {{ $delivery->company_name }}</p>
              </div>
              <div class="row">
                <label class="col col-md-5">Material</label>
                <p class="col">: {{ $delivery->material_name }}</p>
              </div>
              <div class="row">
                <label class="col col-md-5">Kode Material</label>
                <p class="col">: {{ $delivery->material_code }}</p>
              </div>
              <div class="row">
                <label class="col col-md-5">Tanggal Kirim</label>
                <p class="col">: {{ formatDate($delivery->date) }}</p>
              </div>
              <div class="row">
                <label class="col col-md-5">Status</label>
                <p class="col">
                  :
                  <span @class([
                    'badge', 'font-weight-medium', 'badge-pill', 'text-white',
                    'bg-success' => $delivery->status == 'Diterima',
                    'bg-warning' => $delivery->status == 'Dikirim'
                  ])>
                    {{ $delivery->status }}
                  </span>
                </p>
              </div>
            </div>
            <div class="col-lg-5">
              <div class="row">
                <label class="col">No. Kendaraan</label>
                <p class="col">: {{ $delivery->vehicle_plat_number }}</p>
              </div>
              <div class="row">
                <label class="col">Jenis Kendaraan</label>
                <p class="col">: {{ $delivery->vehicle_type }}</p>
              </div>
              <div class="row">
                <label class="col">Kapasitas Maksimal</label>
                <p class="col">: {{ $delivery->vehicle_max_capacity }} (Kg)</p>
              </div>
              <div class="row">
                <label class="col">Nama Supir</label>
                <p class="col">: {{ $delivery->driver_name }}</p>
              </div>
              <div class="row">
                <label class="col">Kontak Supir</label>
                <p class="col">: {{ $delivery->driver_contact }}</p>
              </div>
              <div class="row mt-4 justify-content-end text-center">
                <div class="col">
                  {!! QrCode::size(150)->generate($qrCode) !!}
                  <p class="mt-2 font-weight-bold">{{ $delivery->qr_code }}</p>
                  <a
                    href="/deliveries/{{ $delivery->id }}/download"
                    class="btn btn-primary"
                  >
                    <i class="icon-cloud-download"></i>
                    Pdf
                  </a>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
@endsection
