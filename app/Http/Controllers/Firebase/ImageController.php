<?php

namespace App\Http\Controllers\Firebase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Auth\SignInResult\SignInResult;
use Kreait\Firebase\Exception\FirebaseException;
use Google\Cloud\Firestore\FirestoreClient;
use Kreait\Firebase\Contract\Storage;
use Kreait\Firebase\Contract\Database;
use Session;


class ImageController extends Controller
{
    public function __construct(Database $database, Storage $storage)
    {
        $this->database = $database;
        $this->storage = $storage;
        $this->tablename = 'cars';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {

        $key = $id;
        $editdata = $this->database->getReference($this->tablename)->getChild($key)->getValue();
        if ($editdata) {
            return view('adminpage.upload_image', compact('editdata', 'key'));
        } else {
            return redirect('adminpage.cars')->with('status', 'error');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi request untuk memastikan file gambar telah disertakan
        $request->validate([
            'image' => 'required|image',
        ]);

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

        $postRef = $this->database->getReference($this->tablename)->push($post_data);
        if ($postRef) {
            Session::flash('message', 'New Cars Created');
            return back()->withInput()->with('status', 'Success');
        } else {
            return redirect('/home/admin')->with('status', 'error');
        }

        // Tambahkan pesan sukses ke sesi
        Session::flash('message', 'Successfully Uploaded');

        // Redirect kembali ke halaman sebelumnya
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

        $signedUrl = $this->storage->getBucket()->object($storagePath . $fileName)->signedUrl(new \DateTime('300 years'));

        $post_data = [
            'image' => $signedUrl
        ];

        $res_updated = $this->database->getReference($this->tablename . '/' . $key)->update($post_data);
        if ($res_updated) {
            Session::flash('photo', 'Photo updated successfully');
            return redirect('/home/cars')->with('status', 'Success');
        } else {
            return redirect('/home')->with('status', 'error');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $imageDeleted = app('firebase.storage')->getBucket()->object("Images/defT5uT7SDu9K5RFtIdl.png")->delete();
        Session::flash('message', 'Image Deleted');
        return back()->withInput();
    }
}
