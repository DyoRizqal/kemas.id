<div class="form-container" id="form-surat">
    @php
        $kk = App\Models\Warga::where('uuid', Auth::user()->uuid)->first();
        $kandidats = App\Models\Warga::where('nomorKK', $kk->nomorKK)
            ->where('statusDiKeluarga', '!=', 'Kepala Keluarga')
            ->where('nomorKTP', null)
            ->get();
    @endphp
    <form action="{{ route('home.store_surat', ['jenis' => 'surat-ktp']) }}" method="post">
        @csrf
        <div class="form-group">
            <label class="text-bold">Nomor KK - Kepala Keluarga</label>
            <input type="text" name="nomor_ktp_kk" class="form-control" value="{{ $kk->nomorKK }} - {{ $kk->nama }}"
                disabled>
        </div>
        <div class="form-group">
            <label class="text-bold">Pemohon</label>
            <select name="pemohon" class="form-control" required>
                @if (count($kandidats) > 0)
                    @foreach ($kandidats as $kandidat)
                        <option value="{{ $kandidat->uuid }}"> {{ $kandidat->nama }}</option>
                    @endforeach
                @else
                    <option value="#" disabled>Semua anggota keluarga sudah memiliki KTP</option>
                @endif
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Ajukan Permintaan</button>
    </form>
</div>
@push('statis-css')
    <style>
        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
            color: #333;
        }

        input[type="text"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            color: #333;
        }

        ::placeholder {
            color: #999;
        }

        .btn-primary {
            width: 100%;
            padding: 10px 0;
            border: none;
            border-radius: 4px;
            background-color: #0056b3;
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #003d82;
        }

        @media (max-width: 768px) {
            .form-container {
                padding: 15px;
            }

            .form-group label {
                font-size: 14px;
            }

            input[type="text"],
            input[type="date"],
            textarea {
                padding: 8px 12px;
                font-size: 14px;
            }

            .btn-primary {
                padding: 8px 0;
                font-size: 16px;
            }
        }
    </style>
@endpush