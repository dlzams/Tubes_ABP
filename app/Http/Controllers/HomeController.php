<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Exception\FirebaseException;
use Carbon\Carbon;
use Kreait\Firebase\Contract\Database;

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

      return view('home', compact('user', 'totalUsers', 'reference', 'reference1'));
    } catch (\Exception $e) {
      return $e->getmessage();
    }
  }
}
