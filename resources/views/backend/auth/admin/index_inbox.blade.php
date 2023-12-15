@extends('backend.layouts.app')

@section('title', __('Pengumuman'))

@section('content')
    @push('statis-css')
        <style>
            .td-fixed:nth-child(2) {
                width: 5%;
                text-align: center;
            }

            table {
                background-color: transparent !important;
                text-align: left;
            }

            tbody tr:hover {
                background-color: transparent !important;
            }
        </style>
    @endpush
    <x-backend.card>
        <x-slot name="header">
            @lang('Tambah Berita')
        </x-slot>

        <x-slot name="body">
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="myTable" class="display text-center">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Dari</th>
                                        <th>Pesan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inboxs as $announces)
                                        @php
                                            $warga = App\Models\Warga::where('uuid', $announces->dari)
                                                ->withTrashed()
                                                ->first();
                                        @endphp
                                        <tr>
                                            <td> {{ date('d F Y', strtotime($announces->tanggal)) }}</td>
                                            <td> {{ $warga->nama }}</td>
                                            <td> {!! substr($announces->message, 0, 100) !!}{!! strlen($announces->message) > 100 ? '...' : '' !!}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editAnnounceModal" tabindex="-1" role="dialog"
                aria-labelledby="editAnnounceModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editAnnounceModalLabel">Edit Pengumuman</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="editAnnounceForm" action="" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="edit-type">Jenis</label>
                                    <select class="form-control" id="edit-type" name="type">
                                        <option value="info">Informasi</option>
                                        <option value="danger">Peringatan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="edit-message">Pesan</label>
                                    <textarea id="edit-message" name="message" class="areaDetail" rows="4"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="edit-starts-at">Tanggal Mulai</label>
                                    <input type="datetime-local" id="edit-starts-at" name="starts_at" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="edit-ends-at">Tanggal Berakhir</label>
                                    <input type="datetime-local" id="edit-ends-at" name="ends_at" class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
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
                });
            });
        </script>
    @endpush
@endsection
