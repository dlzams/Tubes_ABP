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
      $reference = $this->database->getReference($this->tablename)->getValue();

      return view('home', compact('user', 'totalUsers', 'reference'));
    } catch (\Exception $e) {
      return $e->getmessage();
    }
  }
}
