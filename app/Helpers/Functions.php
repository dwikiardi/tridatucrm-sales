<?php
namespace App\Helpers;
 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use App\Models\Roles;
 
class Functions {
    public static function get_roles($id) {
        
        // $id=auth()->user()->roleid;
        $roles=Roles::get()->where('id','=',$id);
        //echo $roles;
        foreach($roles as $role){
            return $role->rolename;
        }
        //return $roles[0]->rolename;
    }
}