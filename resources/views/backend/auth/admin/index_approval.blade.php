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

            table.dataTable thead th,
            table.dataTable thead td,
            table.dataTable tfoot th,
            table.dataTable tfoot td {
                text-align: center !important;
            }
        </style>
    @endpush
    <x-backend.card>
        <x-slot name="header">
            @if (request()->routeIs('admin.index_approval'))
                @lang('List Pengajuan Surat')
                <div class="card-header-actions">
                    <a href="{{ route('admin.list_approval') }}" class="card-header-action btn btn-primary text-white p-1">
                        <i class="fas fa-book mr-2"></i> List Surat Yang Sudah Disetujui
                    </a>
                </div>
            @else
                @lang('List Pengajuan Surat Yang Sudah Disetujui')
                <div class="card-header-actions">
                    <a href="{{ route('admin.index_approval') }}" class="card-header-action btn btn-primary text-white p-1">
                        <i class="fas fa-chevron-left mr-2"></i> Kembali
                    </a>
                </div>
            @endif
        </x-slot>

        <x-slot name="body">
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="myTable" class="display text-center">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Jenis Surat</th>
                                        <th>Nomor Tiket</th>
                                        <th>NIK / KK</th>
                                        <th>Pemohon</th>
                                        <th>Tujuan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($surats as $surat)
                                        @php
                                            $kk = App\Models\Warga::where('nomorKK', $surat->nomor_ktp_kk)->first();
                                            $pemohon = App\Models\Warga::where('uuid', $surat->uuid_user)->first();
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}.</td>
                                            <td class="text-uppercase"> {{ ucwords(str_replace('-', ' ', $surat->jenis)) }}
                                            </td>
                                            <td> {{ $surat->uuid_antrian }} <br>
                                                <b> {{ date('d F Y', strtotime($surat->tanggal_buat)) }}</b>
                                            </td>
                                            <td> <a href="{{ route('admin.view_warga', ['kk' => $surat->nomor_ktp_kk]) }}"
                                                    target="_blank">
                                                    {{ $surat->nomor_ktp_kk }}
                                                </a><br> <b> {{ $kk->nama }} </b></td>
                                            <td> {{ $surat->nama }} <br> <b> {{ $pemohon->statusDiKeluarga ?? '-' }}</td>
                                            <td> {{ $surat->tujuan ?: '-' }} </td>
                                            <td>
                                                @if ($surat->ttd == 0)
                                                    <div class="item-status">
                                                        <span class="badge badge-warning text-white mb-2">Menunggu Tanda
                                                            Tangan</span>
                                                    </div>
                                                    <div class="item-actions row">
                                                        <div class="col-md-6 mb-2">
                                                            <a href="#" id="btnApprovalSurat"
                                                                class="btn btn-sm btn-success" data-toggle="modal"
                                                                data-target="#nomorModal" data-uuid="{{ $surat->uuid }}"
                                                                data-id="{{ $surat->id }}">
                                                                <span class="fas fa-check btn-icon"></span> Approve
                                                            </a>
                                                        </div>

                                                        <div class="col-md-6 mb-2">
                                                            <form
                                                                action="{{ route('admin.reject_approval', ['id' => $surat->uuid]) }}"
                                                                method="POST" class="w-100">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-danger show_confirm">
                                                                    <span class="fas fa-times"></span> Reject
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="item-status">
                                                        <small class="text-bold">Nomor Surat:
                                                            {{ $surat->nomor }}</small><br>
                                                        <span class="badge badge-success">Sudah Ditanda Tangan</span>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="nomorModal" tabindex="-1" role="dialog" aria-labelledby="nomorModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="nomorModalLabel">Input Nomor</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="nomorForm">
                                <input type="hidden" id="suratUuid" name="uuid">
                                <div class="form-group">
                                    <label for="nomorInput">Nomor:</label>
                                    <input type="text" class="form-control" id="nomorInput" name="nomor"
                                        placeholder="Nomor/Jenis Surat/Bulan Romawi/Tahun">
                                    <small>No./[KTP],[DMS],[STKM],[SPN],[SKCK]/Bulan Romawi/Tahun</small>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
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
            $(document).on('click', '#btnApprovalSurat', function() {
                var uuid = $(this).data('uuid');
                var id = $(this).data('id');
                $('#suratUuid').val(uuid);
                $('#nomorModal').modal('show');
            });
            $('#nomorForm').on('submit', function(e) {
                e.preventDefault();
                var uuid = $('#suratUuid').val();
                var nomor = $('#nomorInput').val();

                $.ajax({
                    url: '/admin/approval/approve/' + uuid,
                    type: 'POST',
                    data: {
                        nomor: nomor,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        swal.fire({
                            title: 'Berhasil!',
                            text: 'Surat berhasil disetujui!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#nomorModal').modal('hide');
                                location.reload();
                            }
                        });
                    },
                    error: function(error) {
                        swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan, coba lagi.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        </script>
    @endpush
@endsection
