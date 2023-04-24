<?php
namespace Php\Mvc\App\Http\Controllers;

use Php\Mvc\App\Http\Services\Request;

class UserController extends Controller {

    public function index(){

        return view('user_index');
    }

    public function create(){

        return view('user_create');
    }

    public function show(Request $request){

       return $request;
    //     return;
        // $target_dir = "";
        // if($request->another_is_multiple){

        //     foreach ($request->another as $file) {
        //         $target_file = $target_dir . basename($file["name"]);
        //         move_uploaded_file($file['tmp_name'], $target_file);
        //     }
        // }else{
        //     $target_file = $target_dir . basename($request->another["name"]);
        //         move_uploaded_file($request->another['tmp_name'], $target_file);

        // }
       
        
    

        return view('user_show');
    }

}