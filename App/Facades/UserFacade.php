<?php
namespace Php\Mvc\App\Facades;

use Php\Mvc\App\Http\Models\User;

class UserFacade extends Facade {

    public static function getFacadeAccessor(){
        return User::class;
    }

}