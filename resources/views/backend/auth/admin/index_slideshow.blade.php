@extends('backend.layouts.app')

@section('title', __('Gallery Slideshow'))

@section('content')

    <x-backend.card>
        <x-slot name="header">
            @lang('Gallery Slideshow')
        </x-slot>

        <x-slot name="body">
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="mb-4">
                        <h5>Tambah Gambar</h5>
                        <form method="POST" action="{{ route('images.store_slideshow') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="file" name="file" class="form-control">
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                            <i class="small-text text-muted">*Disarankan upload gambar dengan resolusi 1280x720 pixel</i>
                        </form>
                    </div>

                    <div class="row">
                        @foreach ($images as $file)
                            <div class="col-md-3 mb-4">
                                <div class="card" style="height: 100%">
                                    <a href="{{ asset($file->path) }}" target="_blank">
                                        <img src="{{ asset($file->path) }}" class="card-img-top" alt="File"
                                            onclick="showImagePreview('{{ asset($file->path) }}')">
                                    </a>
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $file->alt }}</h6>
                                        <p class="card-text">{{ $file->size }}</p>
                                        @if ($file->upload_by == Auth::user()->name)
                                            <button type="button" class="btn btn-info show_confirm_status mb-2"
                                                data-id="{{ $file->id }}" data-name="{{ $file->alt }}"
                                                data-url="{{ route('images.status_slideshow', ['id' => $file->id]) }}">
                                                @if ($file->status == 1)
                                                    Nonaktifkan
                                                @else
                                                    Aktifkan
                                                @endif
                                            </button>
                                            <button type="button" class="btn btn-danger show_confirm mb-2"
                                                data-id="{{ $file->id }}" data-name="{{ $file->alt }}"
                                                data-url="{{ route('images.destroy_slideshow', ['id' => $file->id]) }}">
                                                Hapus
                                            </button>
                                        @endif
                                    </div>
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
