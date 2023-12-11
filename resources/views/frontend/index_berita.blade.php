@extends('frontend.layouts.app')

@section('title', __('Berita Terkini'))

@section('content')
    @push('statis-css')
        <style>
            .custom-card {
                border: none;
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
            }

            .custom-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            }

            .card-header {
                background-color: #002b3a;
                color: #fdb33a;
                padding: 15px 20px;
                font-size: 1.2em;
                font-weight: bold;
                letter-spacing: 1px;
            }

            .fas.fa-chevron-down {
                color: #fdb33a;
                transition: transform 0.5s ease;
            }

            .custom-card[aria-expanded="true"] .fa-chevron-down {
                transform: rotate(180deg);
            }

            .list-group-item {
                border: none;
                transition: background-color 0.3s;
                text-transform: uppercase;
            }

            .list-group-item {
                color: #002b3a !important;
                transition: color 0.3s;
            }

            .list-group-item:hover {
                background-color: #fdb33a;
                color: white !important;
                text-decoration: none !important;
            }

            .li-news:hover {
                color: white !important;
                text-decoration: none !important;
            }
        </style>
    @endpush
    <div id="app" class="flex-center position-ref full-height">
        <div class="my-5 bg-transparent" id="section-3">
            <div class="container">
                <div class="row mb-3 align-items-center">
                    <div class="col-6 col-md-8 d-flex align-items-center">
                        <h4 class="title-sub mb-0">BERITA TERKINI</h4>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        @foreach ($endpoints as $endpoint)
                            <div class="col-md-4 mb-4">
                                <div class="card custom-card" data-toggle="collapse"
                                    data-target="#collapse{{ $loop->index }}" aria-expanded="false"
                                    aria-controls="collapse{{ $loop->index }}">
                                    <div class="card-header text-uppercase">
                                        {{ $endpoint['name'] }}
                                        <i class="fas fa-chevron-down float-right"></i>
                                    </div>
                                    <div id="collapse{{ $loop->index }}" class="collapse">
                                        <ul class="list-group list-group-flush">
                                            @foreach ($endpoint['paths'] as $path)
                                                <a href="{{ route('home.index_berita_kategori', ['sumber' => $endpoint['name'], 'kategori' => $path['name']]) }}"
                                                    class="li-news">
                                                    <li class="list-group-item">
                                                        {{ $path['name'] }}
                                                    </li>
                                                </a>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('custom-scripts')
        <script>
            $(document).ready(function() {
                $('.custom-card').click(function() {
                    var collapseElementId = $(this).data('target');
                    $(collapseElementId).collapse('toggle');
                });

                $('.custom-card .list-group-item a').click(function(e) {
                    e.stopPropagation();
                });
            });
        </script>
    @endpush
@endsection
