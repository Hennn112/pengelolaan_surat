<?php

namespace App\Http\Controllers;

use App\Models\letter;
use App\Models\result;
use App\Models\user;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'letter_id' => 'required',
            'notes' => 'required',
            'presence_recipients',
        ]);

        $get = $request->presence_recipients;

        if ($get !== null) {
            $arrayDistinct = array_count_values($request->presence_recipients);
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

            result::create([
                'letter_id' => $request->letter_id,
                'notes' => $request->notes,
                'presence_recipients' => $arrayAssoc,
            ]);

            return redirect()->route('guru.data.index')->with('success','Berhasil Mengubah Data');

        }else{
            result::create([
                'letter_id' => $request->letter_id,
                'notes' => $request->notes,
            ]);

            return redirect()->route('guru.data.index')->with('success','Berhasil Mengubah Data');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(result $result)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $results = letter::with('Result')->find($id);
        return view('admin.surat.result', compact('results'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, result $result)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(result $result)
    {
        //
    }
}
