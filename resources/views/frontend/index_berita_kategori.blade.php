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
            }

            .list-group-item a {
                color: #002b3a;
                transition: color 0.3s;
            }

            .list-group-item:hover {
                background-color: #fdb33a;
            }

            .list-group-item:hover a {
                color: white;
            }

            .image-container {
                position: relative;
                width: 100%;
                height: 500px;
                background: #f0f0f0;
                overflow: hidden;
            }

            .image-container img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                opacity: 0;
                transition: opacity 0.5s ease-in-out;
            }

            .image-container img.loaded {
                opacity: 1;
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
                    <div class="col-6 col-md-4 d-flex justify-content-end">
                        <a href="{{ route('home.index_berita') }}" class="lihat-semua">Kembali Ke Menu </a>
                    </div>
                </div>
                <div class="row my-5">
                    @if (is_array($news) && count($news) > 0)
                        @foreach ($news as $new)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <a href="{{ $new['link'] }}" target="_blank">
                                    <div class="card h-100">
                                        <div class="image-container">
                                            <img src="{{ $new['thumbnail'] }}" alt="{{ $new['title'] }}" loading="lazy"
                                                class="lazy-load">
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title" style="font-size: 12pt">{{ $new['title'] }}</h5>
                                            <p class="card-text">{{ date('d F Y', strtotime($new['pubDate'])) }}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="d-flex align-items-center justify-content-center alert alert-secondary mx-auto"
                            role="alert">
                            Tidak ada data berita
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    @push('custom-scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const images = document.querySelectorAll('.lazy-load');

                images.forEach(img => {
                    img.onload = () => img.classList.add('loaded');
                });
            });
        </script>
    @endpush
@endsection
