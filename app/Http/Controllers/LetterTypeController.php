<?php

namespace App\Http\Controllers;

use App\Exports\OrderExport;
use App\Models\letter;
use App\Models\letter_type;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LetterTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $klasifikasi = letter_type::with('letterType')->get();
        return view('admin.klasifikasi.index',compact('klasifikasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.klasifikasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'letter_code' => 'required',
            'name_type' => 'required',
        ]);

        $countLetterType = letter_type::count();
        $letter_code = $request->letter_code . "-" . ($countLetterType + 1);

        letter_type::create([
            'letter_code' => $letter_code,
            'name_type' => $request->name_type,
        ]);

        // atau jika seluruh data input akan dimasukkan langsung ke db bisa dengan perintah Medicine::create($request->all());
        return redirect()->route('admin.klasifikasi.index')->with('success', 'Berhasil Menambahkan !');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = letter_type::find($id);
        // dd($datas);
        return view('admin.klasifikasi.print',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $klasifikasi = letter_type::find($id);

        return view('admin.klasifikasi.edit', compact('klasifikasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $types = letter_type::find($id);

        if (!$types) {
            return redirect()->route('user.home')->with('error', 'Akun tidak ditemukan.');
        }

        $request->validate([
            'letter_code' => 'required',
            'name_type' => 'required'
        ]);

        // Menggabungkan $baseLetterCode dengan $countLetterType
        $letter_code = explode("-",$types['letter_code']);
        $data = $letter_code[1];
        $code = $request->letter_code . '-' . $data;

        $types->update([
            'letter_code' => $code,
            'name_type' => $request->name_type,
        ]);

        return redirect()->route('admin.klasifikasi.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        letter_type::where('id', $id)->delete();
        return redirect()->back()->with('deleted', 'Berhasil Menghapus data!');
    }

    public function exportExcel(){
        $file_name = 'Data_Letter'.'.xlsx';
        return Excel::download(new OrderExport, $file_name);
    }

    public function pdf($id){
        $data = letter::with('Letter')->find($id);
        return view('admin.klasifikasi.pdf',compact('data'));
    }

    public function downloadPDF(Request $request, $id){
        //ambil data yang diperlukan, dan pastikan data berformat array
        $data = Letter::with('Letter')->find($id)->toArray();
        view()->share('data', $data);

        // panggil blade yang akan didownload
        $pdf = PDF::loadView('admin.klasifikasi.download',$data);
        // Kembalikan atau hasilkan pdf dengan nama tertentu
        return $pdf->download('Rapat.pdf');
    }

    public function klasifikasi(){
        $klasifikasi = letter_type::onlyTrashed()->get();
        return view('admin.restore.klasifikasi',compact('klasifikasi'));
    }

    public function klasifikasis($id = null)
    {
        if ($id != null) {
            $letterType = letter_type::withTrashed()->find($id);

            if ($letterType) {
                $letterType->restore();
                return redirect()->back()->with('success', 'Berhasil mengembalikan data');
            } else {
                return redirect()->back()->with('failed', 'Data tidak ditemukan');
            }
        } else {
            $deletedLetterTypes = letter_type::onlyTrashed()->get();

            if ($deletedLetterTypes->isEmpty()) {
                return redirect()->back()->with('failed', 'Tidak ada data yang tersedia untuk dikembalikan');
            } else {
                letter_type::onlyTrashed()->restore();
                return redirect()->back()->with('success', 'Berhasil mengembalikan semua data');
            }
        }
    }


    public function deletetype($id = null){
        if ($id != null) {
            letter_type::onlyTrashed()->where('id',$id)->forceDelete();
        }else{
            $deletedLetterTypes = letter_type::onlyTrashed()->get();
            if ($deletedLetterTypes->isEmpty()) {
                return redirect()->back()->with('failed', 'Data tidak tersedia');
                exit;
            }else{
                letter_type::onlyTrashed()->forceDelete();
            }
        }
        return redirect()->back()->with('deleted', 'Berhasil Menghapus Data');
    }
}
