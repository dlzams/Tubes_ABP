<?php

namespace App\Http\Controllers\Firebase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use Session;
use Kreait\Firebase\Exception\FirebaseException;



class CarsController extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->tablename = 'cars';
    }

    public function index()
    {
        $email_penjual = auth()->user()->email;
        $reference = $this->database->getReference($this->tablename)->getValue();
        return view('adminpage.cars', compact('reference', 'email_penjual'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $email_penjual = auth()->user()->email;

        $post_data = [
            'merk' => $request->merk,
            'model' => $request->model,
            'harga' => $request->harga,
            'tahun_pembuatan' => $request->tahun_pembuatan,
            'kondisi' => $request->kondisi,
            'bahan_bakar' => $request->bahan_bakar,
            'transmisi' => $request->transmisi,
            'warna' => $request->warna,
            'deskripsi' => $request->deskripsi,
            'kontak_penjual' => $request->kontak_penjual,
            'email_penjual' => $email_penjual,
        ];
        $postRef = $this->database->getReference($this->tablename)->push($post_data);
        if ($postRef) {
            Session::flash('message', 'New Cars Created');
            return redirect('/home/cars')->with('status', 'Success');
        } else {
            return redirect('/home/admin')->with('status', 'error');
        }
    }

    public function delete_cars($id)
    {
        $key = $id;
        $del_cars = $this->database->getReference($this->tablename . '/' . $key)->remove();
        if ($del_cars) {
            Session::flash('message', 'Delete Cars Success');
            return redirect('/home/cars');
        } else {
            return redirect('/home/admin')->with('status', 'Delete not Success');
        }
    }

    public function edit_cars($id)
    {
        $key = $id;
        $editdata = $this->database->getReference($this->tablename)->getChild($key)->getValue();
        if ($editdata) {
            return view('adminpage.edit', compact('editdata', 'key'));
        } else {
            return redirect('adminpage.cars')->with('status', 'error');
        }
    }

    public function update_cars(Request $request, $id)
    {
        $key = $id;
        $update_data = [
            'merk' => $request->merk,
            'model' => $request->model,
            'harga' => $request->harga,
            'tahun_pembuatan' => $request->tahun_pembuatan,
            'kondisi' => $request->kondisi,
            'bahan_bakar' => $request->bahan_bakar,
            'transmisi' => $request->transmisi,
            'warna' => $request->warna,
            'deskripsi' => $request->deskripsi,
            'kontak_penjual' => $request->kontak_penjual,
        ];
        $res_updated = $this->database->getReference($this->tablename . '/' . $key)->update($update_data);
        if ($res_updated) {
            return redirect('/home/cars')->with('status', 'updated');
        } else {
            return redirect('adminpage.cars')->with('status', 'error');
        }
    }
}
