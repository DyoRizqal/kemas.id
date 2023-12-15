@extends('backend.layouts.app')

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
        </style>
    @endpush
    <x-backend.card>
        <x-slot name="header">
            <div class="d-flex justify-content-between align-items-center">
                <h3>Detail Warga Nomor KK : <b>{{ $kk->nomorKK }}</b></h3>
                <div class="card-header-actions">
                    <a href="#" data-toggle="modal" data-target="#tambahWargaModal"
                        class="card-header-action btn btn-primary text-white p-1">
                        <i class="c-icon cil-plus"></i> Tambah Anggota Keluarga
                    </a>
                </div>
            </div>

        </x-slot>

        <x-slot name="body">
            <div class="modal fade" id="tambahWargaModal" tabindex="-1" role="dialog"
                aria-labelledby="tambahWargaModalLabel" aria-hidden="true">
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
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>

                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" required>{{ $kk->alamat }}</textarea>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="nomorKK">Nomor KK</label>
                                        <input type="text" class="form-control" id="nomorKK" name="nomorKK"
                                            value="{{ $kk->nomorKK }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nomorKTP">Nomor KTP</label>
                                        <input type="text" class="form-control" id="nomorKTP" name="nomorKTP" required
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="tempatLahir">Tempat Lahir</label>
                                        <select class="form-control" id="tempatLahir" name="tempatLahir">
                                            @foreach ($provinsi['value'] as $prov)
                                                <option value="{{ $prov['name'] }}">{{ $prov['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tanggalLahir">Tanggal Lahir</label>
                                        <input type="date" class="form-control" id="tanggalLahir" name="tanggalLahir"
                                            required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="jenisKelamin">Jenis Kelamin</label>
                                        <select class="form-control" id="jenisKelamin" name="jenisKelamin" required>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="agama">Agama</label>
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
                                        <label for="statusPerkawinan">Status Perkawinan</label>
                                        <select class="form-control" id="statusPerkawinan" name="statusPerkawinan" required>
                                            <option value="Belum Menikah">Belum Menikah</option>
                                            <option value="Menikah">Menikah</option>
                                            <option value="Duda">Duda</option>
                                            <option value="Janda">Janda</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="statusDiKeluarga">Status di Keluarga</label>
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
                                    <input type="text" class="form-control" id="nomorTelepon" name="nomorTelepon">
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


            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Kepala Keluarga</h5>
                                </div>
                                <div class="card-body position-relative">
                                    @foreach ($wargas as $warga)
                                        @if ($warga->statusDiKeluarga === 'Kepala Keluarga')
                                            <div class="position-relative profile-member">
                                                <a href="#" class="btn-edit position-absolute" data-toggle="modal"
                                                    data-target="#tambahWargaModal"
                                                    data-warga="{{ json_encode($warga) }}">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                @include('backend.includes.partials.card-profile', [
                                                    'warga' => $warga,
                                                ])
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Anggota Keluarga</h5>
                                </div>
                                <div class="card-body">
                                    @foreach ($istri as $warga)
                                        <div class="card position-relative profile-member">
                                            <a href="#" class="btn-edit position-absolute" data-toggle="modal"
                                                data-target="#tambahWargaModal" data-warga="{{ json_encode($warga) }}">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            @include('backend.includes.partials.card-profile', [
                                                'warga' => $warga,
                                            ])
                                        </div>
                                    @endforeach
                                    @foreach ($anak as $warga)
                                        <div class="card position-relative profile-member">
                                            <a href="#" class="btn-edit position-absolute" data-toggle="modal"
                                                data-target="#tambahWargaModal" data-warga="{{ json_encode($warga) }}">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            @include('backend.includes.partials.card-profile', [
                                                'warga' => $warga,
                                            ])
                                        </div>
                                    @endforeach
                                </div>
                            </div>
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

            $(document).on('click', '.btn-edit', function() {
                var warga = $(this).data('warga');
                $('#tambahWargaModalLabel').text('Edit Warga ' + warga.nama);
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
