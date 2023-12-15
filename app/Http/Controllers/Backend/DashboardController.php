<?php

namespace App\Http\Controllers\Backend;

use App\Models\Inbox;
use App\Models\Surat;
use App\Models\Warga;
use DB;

/**
 * Class DashboardController.
 */
class DashboardController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {

        $data['jumlahKK'] = Warga::where('statusDiKeluarga', 'Kepala Keluarga')->count();
        $data['jumlahWarga'] = Warga::count();
        $data['jumlahSurat'] = Surat::where('ttd', '=', 0)->count();
        $data['jumlahInbox'] = Inbox::count();
        $data['messages']    = Inbox::orderBy('id', 'DESC')->take(8)->get();
        return view('backend.dashboard', $data);
    }
}
