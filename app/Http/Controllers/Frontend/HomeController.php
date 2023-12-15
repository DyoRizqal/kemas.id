<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Models\Images;
use App\Models\Inbox;
use App\Models\News;
use App\Models\Surat;
use App\Models\Warga;
use Auth;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Http;
use PDF;
use Redirect;
use Str;

/**
 * Class HomeController.
 */
class HomeController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data['slideshow'] = Images::where('jenis', 'slideshow')->where('status', 1)->get();
        $image = Images::where('jenis', 'gallery')->orderBy('id', 'DESC')->where('status', 1)->take(6)->get();
        $data['gallerys'] = $image->groupBy('uuid');

        $client = new Client(['verify' => false]);
        $urls = [
            'cnn' => 'https://api-berita-indonesia.vercel.app/cnn/terbaru/',
            'republika' => 'https://api-berita-indonesia.vercel.app/republika/terbaru/',
            'cnbc' => 'https://api-berita-indonesia.vercel.app/cnbc/terbaru/'
        ];

        $newsInfo = [];

        foreach ($urls as $source => $url) {
            $response = $client->request('GET', $url);

            if ($response->getStatusCode() == 200) {
                $apiData = json_decode($response->getBody()->getContents(), true);
                $imagePath = asset('img/news/' . $source . '.jpg');
                $newsInfo[$source] = [
                    'link' => $apiData['data']['link'] ?? null,
                    'description' => $apiData['data']['description'] ?? null,
                    'title' => $apiData['data']['title'] ?? null,
                    'image' => $imagePath
                ];
            }
        }

        $data['newsInfo'] = $newsInfo;
        return view('frontend.index', $data);
    }
    public function index_galeri()
    {
        $image = Images::where('jenis', 'gallery')->orderBy('id', 'DESC')->where('status', 1)->get();
        $data['gallerys'] = $image->groupBy('uuid');
        return view('frontend.index_galeri', $data);
    }
    public function index_berita()
    {
        $client = new Client(['verify' => false]);
        $response = $client->request('GET', 'https://api-berita-indonesia.vercel.app');
        $data = json_decode($response->getBody()->getContents(), true);
        // $data['news'] = News::orderBy('id', 'DESC')->paginate(9);
        return view(
            'frontend.index_berita',
            ['endpoints' => $data['endpoints']]
        );
    }
    public function index_berita_kategori($sumber, $kategori)
    {
        // $url = "https://api-berita-indonesia.vercel.app/{$sumber}/{$kategori}/";
        // $response = Http::get($url);
        // $url = "https://api-berita-indonesia.vercel.app/{$sumber}/{$kategori}/";
        // $response = Http::get($url);

        $client = new Client(['verify' => false]);
        $response = $client->request('GET', 'https://api-berita-indonesia.vercel.app/' . $sumber . '/' . $kategori);

        if ($response->getStatusCode() == 200) {
            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['data']) && isset($data['data']['posts'])) {
                return view('frontend.index_berita_kategori', ['news' => $data['data']['posts']]);
            } else {
                return view('frontend.index_berita_kategori', ['news' => null]);
            }
        $client = new Client(['verify' => false]);
        $response = $client->request('GET', 'https://api-berita-indonesia.vercel.app/' . $sumber . '/' . $kategori);

        if ($response->getStatusCode() == 200) {
            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['data']) && isset($data['data']['posts'])) {
                return view('frontend.index_berita_kategori', ['news' => $data['data']['posts']]);
            } else {
                return view('frontend.index_berita_kategori', ['news' => null]);
            }
        } else {
            return back()->withErrors('Tidak dapat mengambil data dari API.');
        }
    }
    public function index_tentang()
    {
        $data['team_members'] = [
            [
                'name' => 'Dyo Rizqal Pahlevi',
                'university' => 'STMIK Jayakarta',
                'position' => 'Project Manager, Full Stack Developer',
                'photo' => asset('img/team/dyo.jpg'),
            ],
            [
                'name' => 'Maulana Fikri Ash-Shidiq',
                'university' => 'Universitas Bina Sarana Informatika',
                'position' => 'Front-End Developer, Document Master',
                'photo' => asset('img/team/maulana.png'),
            ],
            [
                'name' => 'Kevin Wilbert Sachio',
                'university' => 'Universitas Palangka Raya',
                'position' => 'Front-End Developer, UI/UX Designer',
                'photo' => asset('img/team/kevin.jpg'),
            ],
            [
                'name' => 'M. Kharis Rizki Mubarok',
                'university' => 'Universitas Islam Lamongan',
                'position' => 'Front-End Developer, UI/UX Designer',
                'photo' => asset('img/team/kharis.jpg'),
            ],
            [
                'name' => 'Devran Perdana Malik',
                'university' => 'Universitas Pramita Indonesia',
                'position' => 'Back-End Developer, System Analyst',
                'photo' => asset('img/team/devran.png'),
            ],
        ];
        return view('frontend.index_tentang', $data);
    }
    public function index_keluarga()
    {
        $response = Http::withOptions(['verify' => false])->get('https://api.binderbyte.com/wilayah/provinsi', [
            'api_key' => '7f48ea088bdff205419549c88f93d211651e74f643a77fff2d9f56f33d5b2909'
        ]);

        if ($response->successful()) {
            $data['kkNomor']  = Warga::where('uuid', Auth::user()->uuid)->where('statusDiKeluarga', 'Kepala Keluarga')->select('nomorKK')->first();
            $data['kk']       = Warga::where('nomorKK', $data['kkNomor']->nomorKK)->where('statusDiKeluarga', 'Kepala Keluarga')->first();
            $data['istri']    = Warga::where('nomorKK', $data['kkNomor']->nomorKK)->where('statusDiKeluarga', 'Istri')->get();
            $data['anak']     = Warga::where('nomorKK', $data['kkNomor']->nomorKK)->where('statusDiKeluarga', 'Anak')->get();
            $data['lainnya']  = Warga::where('nomorKK', $data['kkNomor']->nomorKK)->where('statusDiKeluarga', 'Lainnya')->get();
            $data['provinsi'] = $response->json();
            $data['wargas'] = Warga::where('nomorKK', $data['kkNomor']->nomorKK)->orderBy('id', 'DESC')->get();
            return view('frontend.index_keluarga', $data);
        } else {
            return response()->json(['error' => 'Tidak dapat mengambil data dari API'], 500);
        }
    }
    public function destroy_keluarga($id)
    {
        $wargas = Warga::where('uuid', $id)->first();
        $wargas->delete();
        return response()->json(null, 204);
    }
    public function index_surat()
    {
        $data['news'] = News::orderBy('id', 'DESC')->paginate(9);
        return view('frontend.user.surat.index_surat', $data);
    }
    public function add_surat($jenis)
    {
        $data['jenis'] = $jenis;
        return view('frontend.user.surat.add_surat', $data);
    }
    public function store_surat(Request $request, $jenis)
    {
        if ($request->has('checkAnggota')) {
            $uuidKandidat = $request->pemohon;
            $warga = Warga::where('uuid', $uuidKandidat)->first();
        } else {
            $warga = Warga::where('uuid', Auth::user()->uuid)->first();
        }
        $surat = new Surat;
        $surat->uuid = Str::uuid()->toString();
        $surat->uuid_user = $warga->uuid;
        $surat->jenis = $jenis;

        switch ($jenis) {
            case 'surat-ktp':
                $surat->uuid_antrian = 'KTP-' . Str::random(12);
                $surat->tujuan = 'kelengkapan pengurusan KTP (Kartu Tanda Penduduk)';
                break;
            case 'surat-domisili':
                $surat->uuid_antrian = 'DMS-' . Str::random(12);
                $surat->tujuan = $request->tujuan;
                break;
            case 'surat-sktm':
                $surat->uuid_antrian = 'SKTM-' . Str::random(12);
                $surat->tujuan = $request->tujuan;
                break;
            case 'surat-nikah':
                $surat->uuid_antrian = 'SPN-' . Str::random(12);
                $surat->tujuan = 'melengkapi persyaratan untuk menikah';
                break;
            case 'surat-skck':
                $surat->uuid_antrian = 'SKCK-' . Str::random(12);
                $surat->tujuan = 'persyaratan Surat Keterangan Catatan Kepolisian (SKCK)';
                break;
            default:
                $surat->uuid_antrian = 'UNK-' . Str::random(12);
        }
        $surat->nomor = null;
        $surat->nama = $warga->nama;
        $surat->tempat_lahir = $warga->tempatLahir;
        $surat->tanggal_lahir = $warga->tanggalLahir;
        $surat->nomor_ktp_kk = $warga->nomorKK;
        $surat->alamat = $warga->alamat;
        $surat->tanggal_buat = Carbon::now()->toDateString();
        $surat->ttd = 0;
        $surat->save();
        $nomorTiket = $surat->uuid_antrian;
        session()->flash('success', 'Pengajuan Surat berhasil dikirim dengan Tiket No : ' . $nomorTiket);
        return Redirect::back()->withFlashSuccess(__('Pengajuan Surat berhasil dikirim dengan Tiket No : ' . $nomorTiket));
    }
    public function index_pengajuan()
    {
        $nomorKK  = Warga::where('uuid', Auth::user()->uuid)->where('statusDiKeluarga', 'Kepala Keluarga')->select('nomorKK')->first();
        $data['surats'] = Surat::where('nomor_ktp_kk', $nomorKK->nomorKK)->orderBy('tanggal_buat', 'DESC')->get();
        return view('frontend.user.surat.index_pengajuan', $data);
    }
    public function delete_pengajuan($uuid)
    {
        $surats = Surat::where('uuid', $uuid)->first();
        $surats->delete();
        return response()->json(null, 204);
    }
    public function generate_surat($jenis, $uuid)
    {
        $data['surat'] = Surat::where('uuid', $uuid)->firstOrFail();
        $data['warga'] = Warga::where('uuid', $data['surat']->uuid_user)->first();
        $view = '';
        switch ($data['surat']->jenis) {
            case 'surat-ktp':
                $view = 'frontend.user.surat.pdf.surat_ktp';
                break;
            case 'surat-domisili':
                $view = 'frontend.user.surat.pdf.surat_domisili';
                break;
            case 'surat-skck':
                $view = 'frontend.user.surat.pdf.surat_skck';
                break;
            case 'surat-nikah':
                $view = 'frontend.user.surat.pdf.surat_nikah';
                break;
            case 'surat-sktm':
                $view = 'frontend.user.surat.pdf.surat_sktm';
                break;
            default:
                abort(404, 'Jenis surat tidak dikenali.');
        }
        $pdf = PDF::loadView($view, $data);
        $pdf->setPaper('A4', 'portrait');
        $fileName = 'Surat Pengantar - ' . ucwords(str_replace('-', ' ', $data['surat']->jenis)) . ' - ' .  $data['surat']->nomor . '.pdf';
        // return view($view, compact('surat'));
        return $pdf->download($fileName);
    }
    public function store_message(Request $request)
    {
        $message = new Inbox;
        $message->uuid = Str::uuid()->toString();
        $message->tanggal = Carbon::now()->toDateString();
        $message->dari = Auth::user()->uuid;
        $message->message = $request->message;
        $message->ready_by = 0;
        $message->save();
        return response()->json(['success' => 'Pesan berhasil terkirim']);
    }
}
