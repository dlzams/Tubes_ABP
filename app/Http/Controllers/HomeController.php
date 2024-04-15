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
    $this->middleware('auth');
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
      $user = app('firebase.auth')->getUser($uid);
      $users = app('firebase.auth')->listUsers($defaultMaxResults = 1000, $defaultBatchSize = 1000);

      $usersArray = iterator_to_array($users);
      $totalUsers = count($usersArray);
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


      return view('home', compact('user', 'totalUsers', 'pagedPaginator','reference', 'reference1'));
    } catch (\Exception $e) {
      return $e->getmessage();
    }
  }
}
