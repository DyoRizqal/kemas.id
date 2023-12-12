@extends('frontend.layouts.app')

@section('title', __('Galeri Kegiatan'))

@section('content')
    <div id="app" class="flex-center position-ref full-height">
        <div class="my-5 bg-transparent" id="section-3">
            <div class="container">
                <div class="row mb-3 align-items-center">
                    <div class="col-6 col-md-8 d-flex align-items-center">
                        <h4 class="title-sub mb-0">GALERI KEGIATAN</h4>
                    </div>
                </div>
                <div class="row my-5">
                    @if (count($gallerys) > 0)
                        @foreach ($gallerys as $uuid => $gallery)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card h-100">
                                    @if ($gallery->count() > 0)
                                        <div style="position: relative; display: block;">
                                            <a href="{{ asset($gallery->first()->path) }}"
                                                data-lightbox="gallery-{{ $uuid }}"
                                                data-title="{{ $gallery->first()->alt }}"
                                                style="position: relative; display: block;">
                                                <img src="{{ asset($gallery->first()->path) }}" class="card-img-top"
                                                    alt="{{ $gallery->first()->alt }}" loading="lazy">
                                            </a>
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $gallery->first()->alt }}</h5>
                                                <p class="card-text">
                                                    {{ date('d F Y', strtotime($gallery->first()->created_at)) }}
                                                </p>
                                            </div>
                                        </div>

                                        @foreach ($gallery->slice(1) as $image)
                                            <a href="{{ asset($image->path) }}" data-lightbox="gallery-{{ $uuid }}"
                                                data-title="{{ $image->alt }}" class="d-none"></a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="d-flex align-items-center justify-content-center alert alert-secondary mx-auto"
                            role="alert">
                            Tidak ada galeri kegiatan
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
