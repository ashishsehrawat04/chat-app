<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(){


    $user = Auth()->user();

    $all_Users  = User::all();

    $userId = $user->id;


   $friends = DB::table('friends')
    ->join('users', function($join) use ($userId) {
        $join->on('users.id', '=', 'friends.sender_id')
             ->orOn('users.id', '=', 'friends.receiver_id');
    })
    ->where(function($query) use ($userId){
        $query->where('friends.sender_id', $userId)
              ->orWhere('friends.receiver_id', $userId);
    })
    ->where('friends.status', 'accepted')
    ->where('users.id', '!=', $userId)
    ->select('users.*')
    ->get();

    return view('Dashboard.dashboard',compact('user','friends','all_Users'));

    }
}
