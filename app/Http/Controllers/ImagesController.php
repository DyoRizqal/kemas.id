<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Images;
use Auth;
use Redirect;
use Str;

class ImagesController extends Controller
{
    public function index_slideshow()
    {
        $data['images'] = Images::where('jenis', 'slideshow')->orderBy('id', 'DESC')->get();
        return view('backend.auth.admin.index_slideshow', $data);
    }
    public function store_slideshow(Request $request)
    {
        if ($request->hasfile('file')) {
            $file = $request->file('file');
            $destinationPath = public_path('/storage/slideshow');
            $fileName = $file->getClientOriginalName();
            $file->move($destinationPath, $fileName);
            $path = '/storage/slideshow/' . $fileName;
            $evidence = new Images();
            $evidence->uuid =  Str::uuid()->toString();
            $evidence->jenis = 'slideshow';
            $evidence->alt = $file->getClientOriginalName();
            $evidence->path = $path;
            $evidence->status = 1;
            $evidence->upload_by = auth()->user()->name;
            $evidence->save();
            return Redirect::back()->withFlashSuccess(__('Slideshow berhasil diunggah.'));
        }
        return redirect()->back()->with('error', 'Tidak ada gambar yang diunggah.');
    }
    public function destroy_slideshow($id)
    {
        $image = Images::findOrFail($id);
        $image->delete();

        return response()->json(null, 204);
    }
    public function status_slideshow($id)
    {
        $image = Images::findOrFail($id);
        $image->status = $image->status == 1 ? 0 : 1;
        $image->save();

        return response()->json(['status' => $image->status]);
    }

    public function index_gallery()
    {
        $image = Images::where('jenis', 'gallery')->orderBy('id', 'DESC')->get();
        $data['images'] = $image->groupBy('uuid');
        return view('backend.auth.admin.index_gallery', $data);
    }
    public function store_gallery(Request $request)
    {
        $uuid = Str::uuid()->toString();
        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $file) {
                $destinationPath = 'gallery';
                $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
                $file->storeAs($destinationPath, $filename, 'public');

                $image = new Images;
                $image->uuid = $uuid;
                $image->jenis = 'gallery';
                $image->alt = $request->title;
                $image->path = "storage/{$destinationPath}/{$filename}";
                $image->status = 1;
                $image->upload_by = Auth::user()->name;
                $image->save();
            }
        }
    }
    public function destroy_gallery($id)
    {
        $images = Images::where('uuid', $id)->get();
        foreach ($images as $image) {
            $filePath = str_replace('storage/', '', $image->path);

            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            } else {
            }
        }
        Images::where('uuid', $id)->delete();
        return response()->json(null, 204);
    }
}
