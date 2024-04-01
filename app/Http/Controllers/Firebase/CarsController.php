<?php

namespace App\Http\Controllers\Firebase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use Session;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Contract\Storage;


class CarsController extends Controller
{
    public function __construct(Database $database, Storage $storage)
    {
        $this->database = $database;
        $this->tablename = 'cars';
        $this->storage = $storage;
    }

    public function index()
    {
        $email_penjual = auth()->user()->email;
        $references = $this->database->getReference($this->tablename)->orderByKey()->getValue();
        $reference = array_reverse($references, true);
        return view('adminpage.cars', compact('reference', 'email_penjual'));
    }

    public function show($id)
    {
        // Mengambil data mobil dari Firebase berdasarkan ID atau kunci mobil
        $car = $this->database->getReference($this->tablename . '/' . $id)->getValue();

        // Jika data mobil tidak ditemukan, redirect ke halaman lain atau tampilkan pesan kesalahan
        if (!$car) {
            return redirect('/home/cars')->with('status', 'Car not found');
        }

        // Mengirim data mobil ke view 'product_details.blade.php'
        return view('product_details', compact('car'));
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $email_penjual = auth()->user()->email;

        $post_data = [
            'image' => 'https://community.gamedev.tv/uploads/db2322/original/3X/9/7/9780f0418136d061a49edef8a94c8d88e1ad1642.jpeg',
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
            Session::flash('message', 'Add Cars Success');
            return redirect('/home/cars')->with('status', 'Success');
        } else {
            return redirect('/home/cars')->with('status', 'error');
        }
    }

    public function delete_cars($id)
    {
        $key = $id;
        $del_cars = $this->database->getReference($this->tablename . '/' . $key)->remove();
        if ($del_cars) {
            Session::flash('delete', 'Delete Cars Success');
            return redirect('/home/cars');
        } else {
            return redirect('/home/cars')->with('status', 'Delete not Success');
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
            Session::flash('edit', 'Edit Cars Success');
            return redirect('/home/cars')->with('status', 'updated');
        } else {
            return redirect('adminpage.cars')->with('status', 'error');
        }
    }

    public function storeimage(Request $request, $id)
    {
        // Validasi request untuk memastikan file gambar telah disertakan
        $request->validate([
            'image' => 'required|image',
        ]);

        $key = $id;

        // Ambil file gambar dari request
        $image = $request->file('image');

        // Path penyimpanan di Firebase Storage
        $storagePath = 'Images/';

        // Generate nama file unik
        $fileName = uniqid() . '.' . $image->getClientOriginalExtension();

        // Simpan file gambar ke Firebase Storage
        $this->storage->getBucket()->upload(
            file_get_contents($image->getRealPath()),
            [
                'name' => $storagePath . $fileName,
            ]
        );

        $signedUrl = $this->storage->getBucket()->object($storagePath . $fileName)->signedUrl(new \DateTime('+5 minutes'));

        $post_data = [
            'image' => $signedUrl
        ];

        $res_updated = $this->database->getReference($this->tablename . '/' . $key)->update($update_data);
        if ($res_updated) {
            Session::flash('message', 'New Cars Created');
            return back()->withInput()->with('status', 'Success');
        } else {
            return redirect('/home')->with('status', 'error');
        }

        // Tambahkan pesan sukses ke sesi
        Session::flash('message', 'Successfully Uploaded');

        // Redirect kembali ke halaman sebelumnya
        return back();
    }
}
