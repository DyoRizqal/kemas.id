@extends('backend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
    @push('statis-css')
        <style>
            .card-header {
                font-size: 1rem;
                font-weight: bold;
            }

            .fas {
                margin-right: 10px;
            }

            #tab-box .card {
                transition: transform .2s;
            }

            #tab-box .card:hover {
                transform: scale(1.05);
            }
        </style>
    @endpush
    <div class="row" id="tab-box">
        <div class="col-md-3">
            <x-backend.card class="card border-left-primary shadow h-100 py-2">
                <x-slot name="header" class="text-primary">
                    <i class="fas fa-users fa-2x"></i> Jumlah KK
                </x-slot>

                <x-slot name="body" class="font-weight-bold text-primary">
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahKK }} Kepala Keluarga</div>
                    <a href="{{ route('admin.index_warga') }}" class="stretched-link"></a>
                </x-slot>
            </x-backend.card>
        </div>

        <div class="col-md-3">
            <x-backend.card class="card border-left-success shadow h-100 py-2">
                <x-slot name="header" class="text-success">
                    <i class="fas fa-user-friends fa-2x"></i>Jumlah Warga
                </x-slot>

                <x-slot name="body" class="font-weight-bold text-success">
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahWarga }} Orang</div>
                    <a href="{{ route('admin.index_warga') }}" class="stretched-link"></a>
                </x-slot>
            </x-backend.card>
        </div>

        <div class="col-md-3">
            <x-backend.card class="card border-left-info shadow h-100 py-2">
                <x-slot name="header" class="text-info">
                    <i class="fas fa-envelope-open-text fa-2x"></i> Pengajuan Menunggu Approve
                </x-slot>

                <x-slot name="body" class="font-weight-bold text-info">
                    <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $jumlahSurat }} Pengajuan</div>
                    <a href="{{ route('admin.index_approval') }}" class="stretched-link"></a>
                </x-slot>
            </x-backend.card>
        </div>

        <div class="col-md-3">
            <x-backend.card class="card border-left-warning shadow h-100 py-2">
                <x-slot name="header" class="text-warning">
                    <i class="fas fa-envelope fa-2x"></i> Jumlah Kotak Saran
                </x-slot>

                <x-slot name="body" class="font-weight-bold text-warning">
                    <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $jumlahInbox }} Inbox</div>
                    <a href="{{ route('admin.index_inbox') }}" class="stretched-link"></a>
                </x-slot>
            </x-backend.card>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <x-backend.card>
                <x-slot name="body">
                    <div id="clock" class="clock-container"></div>
                    <div id="calendar"></div>
                </x-slot>
            </x-backend.card>
        </div>
        <div class="col-md-6">
            <x-backend.card>
                <x-slot name="body">
                    <h4 class="text-bold mb-3">Pesan / Inbox Terbaru</h4>
                    <div class="list-group">
                        @foreach ($messages as $message)
                            @php
                                $user = App\Models\Warga::where('uuid', $message->dari)->first();
                            @endphp
                            <li class="list-group-item list-group-item-action flex-column align-items-start">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1 text-bold">{{ $user->nama }}</h5>
                                    <small class="text-muted">{{ date('d F Y', strtotime($message->tanggal)) }}</small>
                                </div>
                                <p class="mb-1">{{ $message->message }}</p>
                            </li>
                        @endforeach
                    </div>
                </x-slot>
            </x-backend.card>
        </div>
    </div>

    @push('after-scripts')
        <script src="{{ asset('js/moment.min.js') }}"></script>
        <script src='{{ asset('js/index.global.min.js') }}'></script>

        <script>
            function updateClock() {
                document.getElementById('clock').innerHTML = moment().format('HH:mm:ss');
            }

            $(document).ready(function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth'
                });
                calendar.render();

                setInterval(updateClock, 1000);
            });
        </script>
    @endpush
@endsection
