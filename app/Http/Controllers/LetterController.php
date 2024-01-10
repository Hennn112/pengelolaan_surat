<?php

namespace App\Http\Controllers;

use App\Exports\SuratExport;
use App\Models\letter;
use App\Models\letter_type;
use App\Models\result;
use App\Models\user;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataGuru = user::where('role', 'guru')->count();
        $dataStaff = user::where('role', 'staff')->count();
        $dataKlasifikasi = Letter_type::count();
        $dataSurat = letter::count();

        return view('admin.index',compact('dataGuru','dataStaff','dataKlasifikasi','dataSurat'));
    }

    public function indexSurat()
    {
        $surats = letter::with('Letter','Result')->get();
        return view('admin.surat.index',compact('surats',));
    }

    public function indexGuru()
    {
        $surats = letter::with('Letter')->get();
        return view('admin.surat.index',compact('surats'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type = letter_type::all();
        $role = user::where('role','guru')->get();
        return view('admin.surat.create',compact('type','role'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'letter_perihal' => 'required',
            'letter_type_id' => 'required',
            'recipients' => 'required',
            'content' => 'required',
            'attachment',
            'notulis' => 'required'
        ]);

        $arrayDistinct = array_count_values($request->recipients);
        // menyiapkan array kosong untuk menampung format array baru
        $arrayAssoc = [];

        foreach ($arrayDistinct as $id => $count) {
            $user = user::find($id);

            $arrayitem = [
                'id' => $id,
                'name' => $user->name,
            ];

            array_push($arrayAssoc,$arrayitem);
        }

        letter::create([
            'letter_perihal' => $request->letter_perihal,
            'letter_type_id' => $request->letter_type_id,
            'recipients' => $arrayAssoc,
            'content' => $request->content,
            'notulis' => $request->notulis
        ]);

        return redirect()->route('admin.surat.index')->with('success','Berhasil Menambah Data');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $rslt = result::where('letter_id', $id)->get();

        $data = Letter::with('Letter')->find($id);
        return view('admin.surat.print',compact('rslt','data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $surats = letter::find($id);
        $type = letter_type::all();
        $role = user::where('role','guru')->get();
        return view('admin.surat.edit', compact('surats','type','role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $letter = letter::find($id);

        if (!$letter) {
            return redirect()->route('user.home')->with('error', 'Data tidak ditemukan.');
        }

        $request->validate([
            'letter_perihal' => 'required',
            'letter_type_id' => 'required',
            'recipients' => 'required',
            'content' => 'required',
            'attachment',
            'notulis' => 'required'
        ]);

        // menyiapkan array kosong untuk menampung format array baru
        $arrayAssoc = [];

        foreach ($request->recipients as $id) {
            $user = user::find($id);

            $arrayitem = [
                'id' => $id,
                'name' => $user->name,
            ];
            array_push($arrayAssoc,$arrayitem);
        }


        $letter->update([
            'letter_perihal' => $request->letter_perihal,
            'letter_type_id' => $request->letter_type_id,
            'recipients' => $arrayAssoc,
            'content' => $request->content,
            'notulis' => $request->notulis
        ]);

        return redirect()->route('admin.surat.index')->with('success','Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        letter::where('id', $id)->delete();
        return redirect()->back()->with('deleted', 'Berhasil Menghapus data!');
    }


    public function exportExcel(){
        $file_name = 'Data_Letter'.'.xlsx';
        return Excel::download(new SuratExport, $file_name);
    }

    public function surat(){
        $surats = letter::onlyTrashed()->get();
        return view('admin.restore.surat',compact('surats',));
    }

    public function surats($id){
        letter::withTrashed()->where('id',$id)->restore();
        return redirect()->back()->with('success', 'Berhasil mengembalikan data');
    }

    public function deletesurat($id){
        letter::onlyTrashed()->where('id',$id)->forceDelete();
        return redirect()->back()->with('deleted', 'Berhasil Menghapus Data');
    }
}
