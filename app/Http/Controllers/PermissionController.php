<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
    	$permissions = Permission::orderBy('sort','asc')->get();
    	$roles = Role::all();

    	return view('permissions.index', compact('permissions','roles'));
    }

    public function update(Request $request)
    {
        \DB::table('permission_roles')->delete();
    	$permissions_last_id = Permission::orderBy('id','desc')->first()->id;
    	$roles_last_id = Role::orderBy('id','desc')->first()->id;

    	for($i=1; $i<=$roles_last_id; $i++) {
    		for($j=1; $j<=$permissions_last_id; $j++) {
    			if($request['permissions_'.$i.'_'.$j]) {
    				\DB::table('permission_roles')->insert([
    					'permission_id' => $j,
    					'role_id' => $i
    				]);
    			}
    		}
    	}

    	return redirect()->back();
    }
}
