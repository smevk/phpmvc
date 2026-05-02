<?php
namespace Php\Mvc\App\Http\Controllers;

use Php\Mvc\App\Facades\UserFacade;
use Php\Mvc\App\Http\Models\User;
use Php\Mvc\App\Http\Services\Request;
use Php\Mvc\App\Providers\Container;

class UserController extends Controller
{


    public function __construct()
    {

        //    var_dump($request);
        //    return;
        // return var_dump($request);
    }

    public function index()
    {

        return view('user_index');
    }

    public function create()
    {

        return view('user_create');
    }


    public function show(Request $request, $user_id)
    {

        // return var_dump($request);
        // var_dump($request);
        // return $request;
        //    return UserFacade::where('id','=',1)->get();
        //   or User::all()

        //   return  env('app_name');
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

        $users = UserFacade::all();

        return view('user_show', compact('users'));
    }

    public function store(Request $request)
    {

        return $request;
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;

        // Save the user
        return $user->save();
    }
}