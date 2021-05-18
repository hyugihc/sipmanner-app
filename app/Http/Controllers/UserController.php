<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use Redirect,Response;

class UserController extends Controller{

   public function getUser($id=0){

    if($id==0){ 
        $user = User::orderby('id','asc')->select('*')->get(); 
     }else{   
        $user = User::select('*')->where('id', $id)->get(); 
     }
     // Fetch all records
     $userData['data'] = $user;

     echo json_encode($userData);
     exit;

    
  }
}