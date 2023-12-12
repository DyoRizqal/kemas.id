@extends('frontend.layouts.app')

@section('title', __('Detail Warga'))

@section('content')
    @push('statis-css')
        <style>
            .profile-item {
                background-color: #f8f9fa;
                border: 1px solid #e9ecef;
                border-radius: 5px;
                padding: 15px;
                margin-bottom: 15px;
            }

            .profile-item p {
                margin: 0 0 10px 0;
            }

            .btn-edit {
                z-index: 2;
                width: 40px;
                height: 40px;
                top: 10px;
                right: 20px;
                border: #002b3a;
                background: #002b3a;
                border-radius: 50%;
                color: #FFFFFF;
                font-size: 1.2em;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.3s ease-in-out;
            }

            .btn-edit:hover {
                background: #FFFFFF;
                border: 1px solid #002b3a;
                color: #002b3a;
                transition: all 0.3s ease-in-out;
            }

            .card.profile-member {
                position: relative;
            }

            th,
            td {
                padding-right: 10px;
                padding-left: 10px;
            }

            @media screen and (max-width: 400px) {
                .container {
                    padding-left: 10px;
                    padding-right: 10px;
                }

                .card-body {
                    padding: 10px;
                }

                .card-body table {
                    font-size: 12px;
                }

                .card-body img {
                    max-width: 100%;
                    height: auto;
                }

                #section-4 .kemas-card {
                    border-radius: 10px;
                    border-color: #fdb33a;
                    background-color: #fdb33a;
                    color: #ffffff;
                    padding: 0 !important;
                }

                #section-4 .kemas-card .card-body {
                    padding: 0 !important;
                }
            }
        </style>
    @endpush
    <x-backend.card>
        <x-slot name="body">
            <div class="modal fade" id="tambahWargaModal" tabindex="-1" role="dialog" aria-labelledby="tambahWargaModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahWargaModalLabel">Tambah Anggota Keluarga</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.add_warga') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nama">Nama <small class="text-danger">*</small> </label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>

                                <div class="form-group">
                                    <label for="alamat">Alamat <small class="text-danger">*</small></label>
                                    <textarea class="form-control" id="alamat" name="alamat" required>{{ $kk->alamat }}</textarea>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="nomorKK">Nomor KK </label>
                                        <input type="text" class="form-control" id="nomorKK" name="nomorKK"
                                            value="{{ $kk->nomorKK }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nomorKTP">Nomor KTP</label>
                                        <input type="text" class="form-control" id="nomorKTP" name="nomorKTP"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="16">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="tempatLahir">Tempat Lahir <small class="text-danger">*</small></label>
                                        <select class="form-control" id="tempatLahir" name="tempatLahir" required>
                                            @foreach ($provinsi['value'] as $prov)
                                                <option value="{{ $prov['name'] }}">{{ $prov['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tanggalLahir">Tanggal Lahir <small class="text-danger">*</small></label>
                                        <input type="date" class="form-control" id="tanggalLahir" name="tanggalLahir"
                                            required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="jenisKelamin">Jenis Kelamin <small class="text-danger">*</small></label>
                                        <select class="form-control" id="jenisKelamin" name="jenisKelamin" required>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="agama">Agama <small class="text-danger">*</small></label>
                                        <select class="form-control" id="agama" name="agama" required>
                                            <option value="Islam">Islam</option>
                                            <option value="Kristen">Kristen</option>
                                            <option value="Budha">Budha</option>
                                            <option value="Hindu">Hindu</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="statusPerkawinan">Status Perkawinan <small
                                                class="text-danger">*</small></label>
                                        <select class="form-control" id="statusPerkawinan" name="statusPerkawinan" required>
                                            <option value="Belum Menikah">Belum Menikah</option>
                                            <option value="Menikah">Menikah</option>
                                            <option value="Duda">Duda</option>
                                            <option value="Janda">Janda</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="statusDiKeluarga">Status di Keluarga <small
                                                class="text-danger">*</small></label>
                                        <select class="form-control" id="statusDiKeluarga" name="statusDiKeluarga"
                                            required>
                                            <option value="Kepala Keluarga">Kepala Keluarga</option>
                                            <option value="Istri">Istri</option>
                                            <option value="Anak">Anak</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="golonganDarah">Golongan Darah</label>
                                        <select class="form-control" id="golonganDarah" name="golonganDarah">
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="AB">AB</option>
                                            <option value="O">O</option>
                                            <option value="Tidak Diketahui">Tidak Diketahui</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="kewarganegaraan">Kewarganegaraan</label>
                                        <select class="form-control" id="kewarganegaraan" name="kewarganegaraan">
                                            <option value="WNI">WNI</option>
                                            <option value="WNA">WNA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pekerjaan">Pekerjaan</label>
                                    <input type="text" class="form-control" id="pekerjaan" name="pekerjaan">
                                </div>

                                <div class="form-group">
                                    <label for="nomorTelepon">Nomor Telepon</label>
                                    <input type="text" class="form-control" id="nomorTelepon" name="nomorTelepon" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email">
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

            <div class="my-5" id="section-4" style="margin-top: 6rem !important">
                <div class="container">
                    <div class="card kemas-card mb-3">
                        <div class="row no-gutters d-flex">
                            <div class="col-md-5 text-center">
                                <img src="{{ asset('img/team/avatar.png') }}" alt="Logo Kemas" style="max-width: 60%">
                            </div>
                            <div class="col-md-7">
                                <div class="card-body">
                                    <h3 class="card-title text-bold">KEPALA KELUARGA</h3>
                                    <p class="card-text text-justify">
                                        @foreach ($wargas as $warga)
                                            <a href="#" class="btn-edit position-absolute" data-toggle="modal"
                                                data-target="#tambahWargaModal" data-warga="{{ json_encode($warga) }}">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            @if ($warga->statusDiKeluarga === 'Kepala Keluarga')
                                                <table>
                                                    <tr>
                                                        <th scope="row">Nama</th>
                                                        <th scope="row">:</th>
                                                        <td>{{ $warga->nama ?: '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Alamat</th>
                                                        <th scope="row">:</th>
                                                        <td>{{ $warga->alamat ?: '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Nomor KK</th>
                                                        <th scope="row">:</th>
                                                        <td>{{ $warga->nomorKK ?: '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">NIK</th>
                                                        <th scope="row">:</th>
                                                        <td>{{ $warga->nomorKTP ?: '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Tempat, Tanggal Lahir</th>
                                                        <th scope="row">:</th>
                                                        <td>{{ $warga->tempatLahir ?: '-' }},
                                                            {{ $warga->tanggalLahir ? date('d F Y', strtotime($warga->tanggalLahir)) : '-' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Jenis Kelamin</th>
                                                        <th scope="row">:</th>
                                                        <td>{{ $warga->jenisKelamin ?: '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Status Perkawinan</th>
                                                        <th scope="row">:</th>
                                                        <td>{{ $warga->statusPerkawinan ?: '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Pekerjaan</th>
                                                        <th scope="row">:</th>
                                                        <td>{{ $warga->pekerjaan ?: '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Nomor Telepon</th>
                                                        <th scope="row">:</th>
                                                        <td>{{ $warga->nomorTelepon ?: '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Email</th>
                                                        <th scope="row">:</th>
                                                        <td>{{ $warga->email ?: '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Status di Keluarga</th>
                                                        <th scope="row">:</th>
                                                        <td>{{ $warga->statusDiKeluarga ?: '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Golongan Darah</th>
                                                        <th scope="row">:</th>
                                                        <td>{{ $warga->golonganDarah ?: '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Kewarganegaraan</th>
                                                        <th scope="row">:</th>
                                                        <td>{{ $warga->kewarganegaraan ?: '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Agama</th>
                                                        <th scope="row">:</th>
                                                        <td>{{ $warga->agama ?: '-' }}</td>
                                                    </tr>
                                                </table>
                                            @endif
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="container">
                    <div class="bg-transparent" id="section-parent">
                        <div class="row mb-3 align-items-center">
                            <div class="col-6 col-md-8 d-flex align-items-center">
                                <h4 class="title-sub mb-0">ANGGOTA KELUARGA</h4>
                            </div>
                            <div class="col-6 col-md-4 d-flex justify-content-end">
                                <a class="lihat-semua" href="#" data-toggle="modal" id="btnTambahWarga"
                                    data-target="#tambahWargaModal"><i class="fas fa-plus mr-1"></i> Tambah Anggota
                                    Keluarga</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            @if (count($istri) > 0)
                                @foreach ($istri as $warga)
                                    <div class="col-md-6 mb-4">
                                        <div class="card position-relative profile-member p-4">
                                            <a href="#" class="btn-edit position-absolute" data-toggle="modal"
                                                data-target="#tambahWargaModal" data-warga="{{ json_encode($warga) }}">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            @include('frontend.auth.includes.card-profile', [
                                                'warga' => $warga,
                                            ])
                                            <button type="button" class="btn btn-sm btn-danger show_confirm"
                                                data-id="{{ $warga->id }}"
                                                data-url="{{ route('home.destroy_keluarga', ['id' => $warga->id]) }}">
                                                <span class="cil-trash btn-icon mr-2"></span>
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            @if (count($anak) > 0)
                                @foreach ($anak as $warga)
                                    <div class="col-md-6 mb-4">
                                        <div class="card position-relative profile-member p-4">
                                            <a href="#" class="btn-edit position-absolute" data-toggle="modal"
                                                data-target="#tambahWargaModal" data-warga="{{ json_encode($warga) }}">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            @include('frontend.auth.includes.card-profile', [
                                                'warga' => $warga,
                                            ])
                                            <button type="button" class="btn btn-sm btn-danger show_confirm"
                                                data-id="{{ $warga->uuid }}"
                                                data-url="{{ route('home.destroy_keluarga', ['id' => $warga->uuid]) }}">
                                                <span class="cil-trash btn-icon mr-2"></span>
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="d-flex align-items-center justify-content-center alert alert-secondary mx-auto"
                                    role="alert">
                                    Tidak ada anak dalam anggota keluarga
                                </div>
                            @endif
                            @if (count($lainnya) > 0)
                                @foreach ($lainnya as $warga)
                                    <div class="col-md-6 mb-4">
                                        <div class="card position-relative profile-member p-4">
                                            <a href="#" class="btn-edit position-absolute" data-toggle="modal"
                                                data-target="#tambahWargaModal" data-warga="{{ json_encode($warga) }}">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            @include('frontend.auth.includes.card-profile', [
                                                'warga' => $warga,
                                            ])
                                            <button type="button" class="btn btn-sm btn-danger show_confirm"
                                                data-id="{{ $warga->uuid }}"
                                                data-url="{{ route('home.destroy_keluarga', ['id' => $warga->uuid]) }}">
                                                <span class="cil-trash btn-icon mr-2"></span>
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="d-flex align-items-center justify-content-center alert alert-secondary mx-auto"
                                    role="alert">
                                    Tidak ada anggota lainnya
                                </div>
                            @endif
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
                });
            });

            $('.show_confirm').click(function(event) {
                var button = $(this);
                var id = button.data('id');
                var url = button.data("url");
                var card = button.closest('.card');
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
                                card.remove();
                                swal.fire('Deleted!', 'Data anggota keluarga berhasil dihapus!.',
                                    'success');
                            },
                            error: function(response) {
                                swal.fire('Error', 'Something went wrong.', 'error');
                            }
                        });
                    }
                })
            });
            $(document).on('click', '#btnTambahWarga', function() {
                $('#tambahWargaModalLabel.modal-title').text('Tambah Anggota Keluarga');
                $('#tambahWargaModal form')[0].reset();
            });

            $(document).on('click', '.btn-edit', function() {
                var warga = $(this).data('warga');
                $('#tambahWargaModalLabel.modal-title').text('Update Detail Warga');
                $('#nama').val(warga.nama);
                $('#alamat').val(warga.alamat);
                $('#nomorKK').val(warga.nomorKK);
                $('#nomorKTP').val(warga.nomorKTP);
                $('#tempatLahir').val(warga.tempatLahir);
                $('#tanggalLahir').val(warga.tanggalLahir);
                $('#jenisKelamin').val(warga.jenisKelamin).trigger('change');
                $('#statusPerkawinan').val(warga.statusPerkawinan).trigger('change');
                $('#pekerjaan').val(warga.pekerjaan);
                $('#nomorTelepon').val(warga.nomorTelepon);
                $('#email').val(warga.email);
                $('#statusDiKeluarga').val(warga.statusDiKeluarga).trigger('change');
                $('#golonganDarah').val(warga.golonganDarah).trigger('change');
                $('#kewarganegaraan').val(warga.kewarganegaraan).trigger('change');
                $('#agama').val(warga.agama).trigger('change');
                $('#tambahWargaModal form').attr('action', '{{ url('admin/warga/update/') }}/' + warga.id);
            });
        </script>
    @endpush
@endsection
