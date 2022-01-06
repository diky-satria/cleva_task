<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $data = Karyawan::orderBy('id', 'DESC')->get();

        if(request()->ajax()){
            return datatables()->of($data)
                                ->addColumn('jabatan', function($data){
                                    return $data->jabatan->nama_jabatan;
                                })
                                ->addColumn('opsi', function($data){
                                    $button = '<button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#staticBackdropCv" onclick="component.cv('. $data->id .')">CV</button>';
                                    $button .= '<button class="btn btn-sm btn-success mx-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="component.edit('. $data->id .')">Edit</button>';
                                    $button .= '<button class="btn btn-sm btn-danger" onclick="component.hapus('. $data->id .')">Hapus</button>';

                                    return $button;
                                })
                                ->rawColumns(['jabatan','opsi'])
                                ->make(true);
        }

        return view('karyawan.karyawan');
    }

    public function data_jabatan()
    {
        $data = Jabatan::orderBy('nama_jabatan', 'ASC')->get();

        return response()->json([
            'data' => $data
        ]);
    }

    public function store()
    {
        request()->validate([
            'nip' => 'required|unique:karyawans,nip',
            'nama_karyawan' => 'required',
            'jabatan' => 'required',
            'jenis_kelamin' => 'required',
            'telepon' => 'required|numeric',
            'cv' => 'required|mimes:pdf|max:2048'
        ],[
            'nip.required' => 'NIP harus di isi',
            'nip.unique' => 'NIP sudah terdaftar',
            'nama_karyawan.required' => 'Nama harus di isi',
            'jabatan.required' => 'Jabatan harus di pilih',
            'jenis_kelamin.required' => 'Jabatan harus di pilih',
            'telepon.required' => 'Telepon harus di isi',
            'telepon.numeric' => 'Data harus angka',
            'cv.required' => 'CV harus di isi',
            'cv.mimes' => 'Format file harus PDF',
            'cv.max' => 'Ukuran file maximal 2 MB'
        ]);

        //upload file
        $cv = request()->file('cv');
        $extension = $cv->getClientOriginalExtension();
        $upload = time() .'.'. $extension;
        $cv->move(public_path('cv/'), $upload);

        Karyawan::create([
            'id_jabatan' => request('jabatan'),
            'nip' => request('nip'),
            'nama_karyawan' => ucwords(request('nama_karyawan')),
            'jenis_kelamin' => request('jenis_kelamin'),
            'telepon' => request('telepon'),
            'cv' => $upload
        ]);

        return response()->json([
            'message' => 'karyawan berhasil ditambahkan'
        ]);
    }

    public function show($id)
    {
        $data = Karyawan::find($id);

        return response()->json([
            'data' => $data
        ]);
    }

    public function update($id)
    {
        $data = Karyawan::find($id);

        request()->validate([
            'nip' => request('nip') == $data->nip ? 'required' : 'required|unique:karyawans,nip',
            'nama_karyawan' => 'required',
            'telepon' => 'required|numeric'
        ],[
            'nip.required' => 'NIP harus di isi',
            'nip.unique' => 'NIP sudah terdaftar',
            'nama_karyawan.required' => 'Nama harus di isi',
            'telepon.required' => 'Telepon harus di isi',
            'telepon.numeric' => 'Data harus angka'
        ]);

        $cv = request()->file('cv');
        if($cv){
            // jika ada cv maka lakukan langkah dibawah ini ------------------------------------------
            request()->validate([
                'cv' => 'mimes:pdf|max:2048'
            ],[
                'cv.mimes' => 'Format file harus PDF',
                'cv.max' => 'Ukuran file maximal 2 MB'
            ]);

            // jika ada cv yang akan diedit maka hapus cv lama
            $cv_lama = $data->cv;
            if($cv_lama){
                unlink('cv/'. $cv_lama);
            }

            // upload cv dengan yang baru
            $extension = $cv->getClientOriginalExtension();
            $upload = time() .'.'. $extension;
            $cv->move(public_path('cv/'), $upload);

            // insert ke database
            $data->update([
                'id_jabatan' => request('jabatan'),
                'nip' => request('nip'),
                'nama_karyawan' => ucwords(request('nama_karyawan')),
                'jenis_kelamin' => request('jenis_kelamin'),
                'telepon' => request('telepon'),
                'cv' => $upload
            ]);
        }else{
            // jika tidak ada cv maka lakukan langkah dibawah ini ---------------------------------------
            // insert ke database
            $data->update([
                'id_jabatan' => request('jabatan'),
                'nip' => request('nip'),
                'nama_karyawan' => ucwords(request('nama_karyawan')),
                'jenis_kelamin' => request('jenis_kelamin'),
                'telepon' => request('telepon'),
            ]);
        }
    }

    public function delete($id)
    {
        $data = Karyawan::find($id);

        // hapus file cv nya yang ada di dalam folder public/cv/
        $cv_lama = $data->cv;
        if($cv_lama){
            unlink('cv/'. $cv_lama);
        }

        $data->delete();

        return response()->json([
            'message' => 'karyawan berhasil di hapus'
        ]);
    }
}
