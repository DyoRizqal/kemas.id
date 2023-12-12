@extends('backend.layouts.app')

@section('title', __('Gallery Kegiatan'))

@section('content')
    @push('statis-css')
        <style>
            .image-title {
                position: absolute;
                top: 10px;
                left: 10px;
                background-color: rgba(0, 0, 0, 0.5);
                color: #fff;
                padding: 5px 10px;
                border-radius: 5px;
                font-size: 0.9rem;
                font-weight: bold;
            }
        </style>
    @endpush
    <x-backend.card>
        <x-slot name="header">
            @lang('Gallery Slideshow')
        </x-slot>

        <x-slot name="body">
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="mb-4">
                        <h5>Tambah Gambar</h5>
                        <form action="{{ route('images.store_gallery') }}" method="POST" enctype="multipart/form-data"
                            id="my-awesome-dropzone" class="dropzone">
                            @csrf
                            <div class="form-group">
                                <label for="title">Judul:</label>
                                <input type="text" name="title" class="form-control" id="title" required>
                            </div>
                            <div class="dz-message" data-dz-message><span>Drop gambar di sini atau klik untuk
                                    mengunggah</span>
                            </div>
                        </form>
                    </div>
                    <button id="submit-all" class="btn btn-primary">Upload Gambar</button>

                    <div class="row mt-4">
                        @foreach ($images as $uuid => $images)
                            <div class="col-md-3">
                                <div class="card mb-4">
                                    @if ($images->count() > 0)
                                        <div style="position: relative; display: block;">
                                            <a href="{{ asset($images->first()->path) }}"
                                                data-lightbox="gallery-{{ $uuid }}"
                                                data-title="{{ $images->first()->alt }}"
                                                style="position: relative; display: block;">
                                                <img src="{{ asset($images->first()->path) }}" class="card-img-top"
                                                    alt="{{ $images->first()->alt }}">
                                            </a>
                                            <h5 class="image-title">{{ $images->first()->alt }}</h5>
                                            <button type="button" class="btn btn-danger show_confirm"
                                                data-id="{{ $images->first()->id }}" data-name="{{ $images->first()->alt }}"
                                                data-url="{{ route('images.destroy_gallery', ['id' => $images->first()->uuid]) }}"
                                                style="position: absolute; bottom: 10px; right: 10px;"
                                                onclick="stopLightbox(event);">
                                                Hapus
                                            </button>
                                        </div>

                                        @foreach ($images->slice(1) as $image)
                                            <a href="{{ asset($image->path) }}"
                                                data-lightbox="gallery-{{ $uuid }}"
                                                data-title="{{ $image->alt }}" class="d-none"></a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </x-slot>
    </x-backend.card>
    @push('custom-scripts')
        <script>
            lightbox.option({
                'resizeDuration': 200,
                'wrapAround': true,
            });

            function stopLightbox(event) {
                event.stopPropagation();
            }
            Dropzone.options.myAwesomeDropzone = {
                uploadMultiple: true,
                autoProcessQueue: false,
                paramName: "file",
                maxFilesize: 2,
                acceptedFiles: 'image/*',
                parallelUploads: 5,
                addRemoveLinks: true,
                init: function() {
                    var myDropzone = this;
                    document.getElementById("submit-all").addEventListener("click", function() {
                        myDropzone.processQueue();
                    });

                    this.on("queuecomplete", function() {
                        if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                            window.location.reload();
                        }
                    });
                }
            };
            $('.show_confirm').click(function(event) {
                var button = $(this);
                var id = button.data('id');
                var name = button.data("name");
                var url = button.data("url");
                event.preventDefault();

                swal.fire({
                    title: 'Apakah kamu yakin ingin menghapus data ?',
                    text: "Kamu tidak dapat mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                button.closest('.col-md-3').remove();
                                swal.fire('Deleted!', 'Your file has been deleted.', 'success');
                            },
                            error: function(response) {
                                swal.fire('Error', 'Something went wrong.', 'error');
                            }
                        });
                    }
                })
            });
            $('.show_confirm_status').click(function(event) {
                var button = $(this);
                var id = button.data('id');
                var url = button.data("url");
                event.preventDefault();

                swal.fire({
                    title: 'Apakah kamu yakin ?',
                    text: "Untuk mengubah status gambar ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Ganti!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                if (response.status == 1) {
                                    button.text('Nonaktifkan');
                                } else {
                                    button.text('Aktifkan');
                                }
                                swal.fire('Changed!', 'Status gambar telah diubah.', 'success');
                            },
                            error: function(response) {
                                swal.fire('Error', 'Something went wrong.', 'error');
                            }
                        });
                    }
                })
            });
        </script>
    @endpush
@endsection
