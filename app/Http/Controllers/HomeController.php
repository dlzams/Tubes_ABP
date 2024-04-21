<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Exception\FirebaseException;
use Carbon\Carbon;
use Kreait\Firebase\Contract\Database;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

use Session;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(Database $database)
  {
    $this->database = $database;
    $this->tablename = 'cars';
    $this->tablename1 = 'image';
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    // FirebaseAuth.getInstance().getCurrentUser();
    try {

      $uid = Session::get('uid');
      if ($uid === null) {
        $user = 'guest';
      } else {
        $user = app('firebase.auth')->getUser($uid);
        $users = app('firebase.auth')->listUsers($defaultMaxResults = 1000, $defaultBatchSize = 1000);

        $usersArray = iterator_to_array($users);
        $totalUsers = count($usersArray);
      }
      $references = $this->database->getReference($this->tablename)->orderByKey()->getValue();
      $reference = array_reverse($references, true);
      $reference1 = $this->database->getReference($this->tablename1)->getValue();

      // Mengatur pagination
      $perPage = 9;
      $currentPage = request()->input('page') ?? 1;

      // Memastikan bahwa reference memiliki data sebelum dilakukan pagination
      if (!empty($reference)) {
        $pagedData = array_slice($reference, ($currentPage - 1) * $perPage, $perPage);
      } else {
        $pagedData = [];
      }

      // Transform array menjadi koleksi Illuminate\Support\Collection
      $pagedCollection = collect($pagedData);

      // Membuat instance dari LengthAwarePaginator
      $pagedPaginator = new LengthAwarePaginator(
        $pagedCollection,
        count($reference),
        $perPage,
        $currentPage,
        ['path' => LengthAwarePaginator::resolveCurrentPath()]
      );


      return view('home', compact('user', 'pagedPaginator', 'reference', 'reference1'));
    } catch (\Exception $e) {
      return $e->getmessage();
    }
  }

  public function search(Request $request)
  {
      $query = $request->input('query');
      $filter = $request->input('filter');

      // jadiin lowercase
      $query = strtolower($query);

      if (!empty($query)) {
          $allReferences = $this->database->getReference($this->tablename)
                              ->orderByChild('merk')
                              ->getValue();

      // nyari yang merknya mengandung kata kunci, nggak peduli huruf besar atau kecil
      $references = array_filter($allReferences, function ($item) use ($query) {
          return strpos(strtolower($item['merk']), $query) !== false;
      });

      // Filter hasil pencarian berdasarkan kondisi jika filter tersedia
      if ($filter) {
        $references = array_filter($references, function ($item) use ($filter) {
          return $item['kondisi'] == $filter;
        });
      }

      // Mengatur pagination dan menampilkan hasil pencarian
      $perPage = 9;
      $currentPage = request()->input('page') ?? 1;
      $pagedPaginator = new LengthAwarePaginator(
        $references,
        count($references),
        $perPage,
        $currentPage,
        ['path' => LengthAwarePaginator::resolveCurrentPath()]
      );

      return view('search_results', compact('pagedPaginator', 'query', 'filter'));
    } else {
      // Jika query kosong, kembalikan ke halaman sebelumnya atau lakukan penanganan sesuai kebutuhan Anda
      return back()->with('status', 'Please enter a search query.');
    }
  }
}
