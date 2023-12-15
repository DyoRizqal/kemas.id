@extends('backend.layouts.app')

@section('title', __('List Warga'))

@section('content')
    @push('statis-css')
        <style>
            .img-thumbnail {
                max-width: 100px;
                height: auto;
            }

            .search-individu {
                margin-bottom: 5rem;
            }

            .search-individu {
                background: #002b3a;
                color: #FFFFFF;
                border: 2px solid #002b3a;
            }
        </style>
    @endpush
    <x-backend.card>

        <x-slot name="header">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @lang('List Data Warga')
            <div class="card-header-actions">
                <a href="#" data-toggle="modal" data-target="#tambahWargaModal"
                    class="card-header-action btn btn-primary text-white p-1">
                    <i class="c-icon cil-plus"></i> Tambah Warga
                </a>
            </div>
        </x-slot>

        <x-slot name="body">
            <div class="modal fade" id="tambahWargaModal" tabindex="-1" role="dialog"
                aria-labelledby="tambahWargaModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahWargaModalLabel">Tambah Warga</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.store_warga') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="nomorKK">Nomor KK</label>
                                        <input type="text" class="form-control" id="nomorKK" name="nomorKK" required
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="16">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nomorKTP">Nomor KTP</label>
                                        <input type="text" class="form-control" id="nomorKTP" name="nomorKTP" required
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="16">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card search-individu">
                <div class="card-body">
                    <div class="form-group">
                        <form action="{{ route('admin.find_warga') }}" method="GET">
                            <label for="search-key" class="text-bold">Cari Warga</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="keyword" id="keyword"
                                    placeholder="Masukkan kata kunci">
                                <select id="type" name="type" class="custom-select">
                                    <option value="kk">Berdasarkan Nomor KK</option>
                                    <option value="ktp">Berdasarkan Nomor KTP</option>
                                    <option value="nama">Berdasarkan Nama</option>
                                    <option value="telepon">Berdasarkan Nomor Telepon</option>
                                </select>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Pencarian
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="myTable" class="display text-center">
                                <thead>
                                    <tr>
                                        <th>Nomor KK</th>
                                        <th>NIK</th>
                                        <th>Nama Lengkap </th>
                                        <th>Status Keluarga</th>
                                        <th>Alamat</th>
                                        <th>Telepon</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($wargas as $warga)
                                        <tr>
                                            <td> {{ $warga->nomorKK }} </td>
                                            <td> {{ $warga->nomorKTP }} </td>
                                            <td> {{ $warga->nama }} </td>
                                            <td> {{ $warga->statusDiKeluarga ?: '-' }} </td>
                                            <td> {{ $warga->alamat ?: '-' }} </td>
                                            <td> {{ $warga->nomorTelepon ?: '-' }} </td>
                                            <td>
                                                <div class="mb-2">
                                                    <a href="{{ route('admin.view_warga', ['kk' => $warga->nomorKK]) }}"
                                                        id="btnEditNews" class="btn btn-sm btn-info"><span
                                                            class="fas fa-search btn-icon mr-2"></span>
                                                        View</a>
                                                </div>
                                                {{-- <div>
                                                    <button type="button" class="btn btn-sm btn-danger show_confirm"
                                                        data-id="{{ $warga->id }}"
                                                        data-url="{{ route('admin.destroy_warga', ['id' => $warga->id]) }}">
                                                        <span class="cil-trash btn-icon mr-2"></span>
                                                        Hapus
                                                    </button>
                                                </div> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </x-slot>
    </x-backend.card>
    @push('custom-scripts')
        <script>
            $(document).ready(function() {
                $('#myTable').DataTable({
                    "ordering": false,
                    responsive: true
                });
            });

            $('.show_confirm').click(function(event) {
                var button = $(this);
                var id = button.data('id');
                var url = button.data("url");
                var row = button.closest('tr');
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
                                $('#myTable').DataTable().row(row).remove().draw();
                                swal.fire('Deleted!', 'Your file has been deleted.', 'success');
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
