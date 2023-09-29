@extends('layouts.main')

@section('title', 'Notifikasi')

@push('style')
  <style>
    .card {
      border-radius: 0;
      box-shadow:0 3px 5px 0 rgba(40 44 47 / 15%);
      margin-bottom: 10px;
      transition: 0.3s;

    }

    .card:hover{
      background-color: #fff !important;
      opacity: 0.7;

    }

  </style>
@endpush

@section('content')
  <div class="row">
    <div class="col">
      @foreach ($notifications as $notification)
        <a href="{{ $notification->link }}?notif={{ $notification->id }}">
          <div @class(['card', 'bg-light' => !$notification->is_read])>
            <div class="card-body d-flex align-item-center">
              <div class="btn btn-{{ $notification->color }} rounded-circle btn-circle d-flex">
                <i class="fas {{ $notification->icon }} m-auto"></i>
              </div>
              <div class="w-75 d-inline-block v-middle pl-5">
                <h4 class="card-title">
                  {{ $notification->title }}
                  <code class="badge bg-danger text-white font-weight-medium badge-pill">
                    {{ timeAgo($notification->created_at) }}
                  </code>
                </h4>
                <h6 class="card-subtitle">{{ $notification->description }}</h6>
              </div>
            </div>
          </div>
        </a>
      @endforeach
    </div>
  </div>
@endsection
