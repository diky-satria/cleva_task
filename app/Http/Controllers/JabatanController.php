<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $data = Jabatan::orderBy('id','DESC')->get();

        if(request()->ajax()){
            return datatables()->of($data)
                                ->addColumn('gaji_pokok', function($data){
                                    return format_rupiah($data->gaji_pokok);
                                })
                                ->addColumn('opsi', function($data){
                                    $button = '<button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="component.edit('. $data->id .')">Edit</button>';
                                    $button .= '<button class="btn btn-sm btn-danger ms-1" onclick="component.hapus('. $data->id .')">Hapus</button>';

                                    return $button;
                                })
                                ->rawColumns(['gaji_pokok','opsi'])
                                ->make(true);
        }

        return view('jabatan.jabatan');
    }

    public function show($id)
    {
        $data = Jabatan::find($id);

        return response()->json([
            'data' => $data
        ]);
    }

    public function store()
    {
        request()->validate([
            'nama_jabatan' => 'required',
            'gaji_pokok' => 'required|numeric'
        ],[
            'nama_jabatan.required' => 'Nama harus di isi',
            'gaji_pokok.required' => 'Gaji pokok harus di isi',
            'gaji_pokok.numeric' => 'Data harus angka'
        ]);

        Jabatan::create([
            'nama_jabatan' => ucwords(request('nama_jabatan')),
            'gaji_pokok' => request('gaji_pokok')
        ]);

        return response()->json([
            'message' => 'jabatan berhasil ditambahkan'
        ]);
    }

    public function update($id)
    {
        $data = Jabatan::find($id);

        request()->validate([
            'nama_jabatan' => 'required',
            'gaji_pokok' => 'required|numeric'
        ],[
            'nama_jabatan.required' => 'Nama harus di isi',
            'gaji_pokok.required' => 'Gaji pokok harus di isi',
            'gaji_pokok.numeric' => 'Data harus angka'
        ]);

        $data->update([
            'nama_jabatan' => ucwords(request('nama_jabatan')),
            'gaji_pokok' => request('gaji_pokok')
        ]);

        return response()->json([
            'message' => 'jabatan berhasil di edit'
        ]);
    }

    public function delete($id)
    {
        $data = Jabatan::find($id);

        $data->delete();
        
        return response()->json([
            'message' => 'jabatan berhasil di hapus'
        ]);
    }
}
