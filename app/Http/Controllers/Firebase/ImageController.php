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
        $this->tablename = 'image';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // Path gambar di Firebase Storage
        $imagePath = 'Images/defT5uT7SDu9K5RFtIdl.png';

        // Dapatkan URL tanda tangan yang ditandatangani untuk gambar
        $image = $this->storage->getBucket()->object($imagePath)->signedUrl(new \DateTime('+5 minutes'));

        // URL tanda tangan berhasil diambil
        return view('firebase.contact.index', compact('image'));
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
