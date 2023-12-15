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
                    <div class="card mb-4">
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.store_announce') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="type" class="form-label">Jenis :</label>
                                            <select class="form-control" id="type" name="type">
                                                <option value="Info">Informasi</option>
                                                <option value="Peringatan">Peringatan</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="tanggalMulai" class="form-label">Ditampilkan pada :</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control" id="tanggalMulai"
                                                    name="tanggalMulai" min="{{ date('Y-m-d') }}" required>
                                                <input type="time" class="form-control" id="jamMulai" name="jamMulai"
                                                    required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="tanggalAkhir" class="form-label">Berakhir pada :</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control" id="tanggalAkhir"
                                                    name="tanggalAkhir" min="{{ date('Y-m-d') }}" required>
                                                <input type="time" class="form-control" id="jamAkhir" name="jamAkhir"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="detail" class="form-label">Detail :</label>
                                    <textarea name="detail" id="detail" class="areaDetail form-control" rows="4"
                                        placeholder="Masukkan detail di sini" required></textarea>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Tambah Pengumuman </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table id="myTable" class="display text-center">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Tipe</th>
                                        <th>Detail</th>
                                        <th>Tanggal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($announce as $announces)
                                        <tr>
                                            <td> {{ date('d F Y', strtotime($announces->created_at)) }}</td>
                                            <td>
                                                @if ($announces->type == 'info')
                                                    <span class="badge badge-info"> Informasi </span>
                                                @else
                                                    <span class="badge badge-danger"> Peringatan </span>
                                                @endif
                                            </td>
                                            <td> {!! substr($announces->message, 0, 100) !!}{!! strlen($announces->message) > 100 ? '...' : '' !!}</td>
                                            <td>
                                                <table id="date-announce-display" class="mx-auto">
                                                    <tbody>
                                                        <tr>
                                                            <td>Ditampilkan pada</td>
                                                            <td class="td-fixed"> : </td>
                                                            <td>{{ date('d F Y, H:i:s', strtotime($announces->starts_at)) }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Berakhir pada </td>
                                                            <td class="td-fixed"> : </td>
                                                            <td>{{ date('d F Y, H:i:s', strtotime($announces->ends_at)) }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td>
                                                <div class="mb-2">
                                                    <a href="#" data-toggle="modal" data-target="#editAnnounceModal"
                                                        id="btnEditAnnounce" class="btn btn-sm btn-primary"
                                                        data-announce="{{ json_encode($announces) }}"><span
                                                            class="cil-pencil btn-icon mr-2"></span>
                                                        Edit</a>
                                                </div>
                                                <div>
                                                    <button type="button" class="btn btn-sm btn-danger show_confirm"
                                                        data-id="{{ $announces->uuid }}" data-name="{{ $announces->alt }}"
                                                        data-url="{{ route('admin.destroy_announce', ['id' => $announces->uuid]) }}">
                                                        <span class="cil-trash btn-icon mr-2"></span>
                                                        Hapus
                                                    </button>
                                                </div>
                                            </td>
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
                                    <input type="datetime-local" id="edit-starts-at" name="starts_at"
                                        min="{{ date('Y-m-d\TH:i') }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="edit-ends-at">Tanggal Berakhir</label>
                                    <input type="datetime-local" id="edit-ends-at" name="ends_at"
                                        min="{{ date('Y-m-d\TH:i') }}" class="form-control">
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
                    responsive: true
                });
            });
            $(document).on('click', '#btnEditAnnounce', function() {
                var announce = $(this).data('announce');
                var url = "{{ route('admin.update_announce', ['id' => ':id']) }}".replace(':id', announce.id);

                $('#edit-type').val(announce.type).trigger('change');
                CKEDITOR.instances['edit-message'].setData(announce.message);
                var startsAt = new Date(announce.starts_at).toISOString().slice(0, 16);
                var endsAt = new Date(announce.ends_at).toISOString().slice(0, 16);
                $('#edit-starts-at').val(startsAt);
                $('#edit-ends-at').val(endsAt);

                $('#editAnnounceForm').attr('action', url);
                $('#editAnnounceModal').modal('show');
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
                                swal.fire('Deleted!', 'Your announces has been deleted.',
                                    'success');
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
