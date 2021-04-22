<?php

namespace App\Http\Controllers;

use App\Helpers\ConvertNumber;
use App\Models\ActivityLog;
use App\Models\ActivityType;
use App\Models\Fund;
use App\Models\Invoice;
use App\Models\Role;
use App\Models\Service;
use App\Models\User;
use App\Services\Sms;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Session;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('lastname', 'asc')->get();

        return view('new.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        $services = Service::all();
        return view('new.users.form', compact('roles', 'services'));
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('new.users.show', compact('user'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users|min:3',
            'password' => 'required|confirmed|min:6',
            'mobile' => 'required|min:11'
        ]);

        if ($validator->fails()) {
            return redirect('users/create')
                        ->withErrors($validator)
                        ->withInput();
        } else {
            if (!is_null($request['profile_image'])) {
                $file = $request['profile_image'];
                $imageName = str_random(10).time() .'.' . $file->getClientOriginalExtension();

                $file->move('uploads', $imageName);

                $file = $imageName;
            } else {
                $file = null;
            }
            $user = User::create([
                'username' => $request['username'],
                'password' => bcrypt($request['password']),
                'firstname' => $request['firstname'],
                'lastname' => $request['lastname'],
                'name' => $request['firstname']." ".$request['lastname'],
                'national_id' => $request['national_id'],
                'phone' => $request['phone'],
                'personal_code' => $request['personal_code'],
                'address' => $request['address'],
                'father_name' => $request['father_name'],
                'birthday' => $request['birthday'],
                'mobile' => $request['mobile'],
                'email' => $request['email'],
                'role_id' => $request['role_id'],
                'profile_image' => $file,
                'speciality' => $request['speciality'],
                'default_doctor' => $request['default_doctor']
            ]);
            if (!is_null($request['services'])) {
                foreach ($request['services'] as $key => $value) {
                    DB::table('user_services')->insert([
                    'user_id' => $user->id,
                    'service_id' => $value
                ]);
                }
            }

            return redirect('users');
        }
    }

    public function edit($id)
    {
        if ((\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 13)->count() == 1) || $id == Session::get('user_id')) {
            $model = User::find($id);
            $roles = Role::all();
            $services = Service::all();
            return view('new.users.form', compact('roles', 'model', 'services'));
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
                'username' => 'required|min:3',
                'password' => 'required|confirmed|min:6',
                'mobile' => 'required|min:11'
            ]);

        if ($validator->fails()) {
            return redirect('users/'.$id.'/edit')
                        ->withErrors($validator)
                        ->withInput();
        } else {
            if (!is_null($request['profile_image'])) {
                $file = $request['profile_image'];
                $imageName = str_random(10).time() .'.' . $file->getClientOriginalExtension();

                $file->move('uploads', $imageName);

                $file = $imageName;
            } else {
                $file = User::find($id)->profile_image;
            }
            DB::table('user_services')->where('user_id', $id)->delete();
            if (!is_null($request['services'])) {
                foreach ($request['services'] as $key => $value) {
                    DB::table('user_services')->insert([
                    'user_id' => $id,
                    'service_id' => $value
                ]);
                }
            }

            if (is_null($request['password'])) {
                $password = User::find($id)->password;
            } else {
                $password = bcrypt($request['password']);
            }
            if (Session::get('user_id') == $id) {
                $updated_by_user = 1;
            } else {
                $updated_by_user = 0;
            }
            User::where('id', $id)->update([
                'username' => $request['username'],
                'password' => $password,
                'firstname' => $request['firstname'],
                'lastname' => $request['lastname'],
                'name' => $request['firstname']." ".$request['lastname'],
                'national_id' => $request['national_id'],
                'phone' => $request['phone'],
                'personal_code' => $request['personal_code'],
                'address' => $request['address'],
                'father_name' => $request['father_name'],
                'birthday' => $request['birthday'],
                'mobile' => $request['mobile'],
                'email' => $request['email'],
                'role_id' => $request['role_id'],
                'profile_image' => $file,
                'speciality' => $request['speciality'],
                'default_doctor' => $request['default_doctor'],
                'updated_by_user' => $updated_by_user
            ]);

            Sms::send($request['mobile'], $request['firstname']."_".$request['lastname'], $request['username'], $request['password'], 'logininfo');

            if ((\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 13)->count() == 1)) {
                return redirect('users');
            } else {
                return redirect('/');
            }
        }
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->back();
    }

    public function login()
    {
        return view('login');
    }

    public function verify(Request $request)
    {
        $query = User::where('username', $request['username']);

        if ($query->count() > 0) {
            $user = $query->first();
            if ($user->active == 0) {
                return redirect()->back()->withErrors(['حساب شما غیرفعال است.']);
            }

            $password = $user->password;

            if (Hash::check($request['password'], $password)) {
                $role_id = User::find($user->id)->role_id;

                Session::put('logged_in', 'yes');
                Session::put('role', Role::find($role_id)->id);
                Session::put('username', $user->username);
                Session::put('name', $user->name);
                Session::put('user_id', $user->id);

                User::where('id', $user->id)->update([
                    'last_login' => now(),
                    'last_logout' => null,
                    'online' => 1
                ]);

                $activity = ActivityType::where('title', 'login')->first();

                ActivityLog::create([
                    'content' => $activity->name,
                    'activity_type_id' => $activity->id,
                    'user_id' => $user->id
                ]);

                $name = str_replace(' ', "_", $user->name);
                $role = Role::find($user->role_id)->title;

                // Sms::send($user->mobile, $name, $role, '', 'login');

                return redirect(route('home'));
            } else {
                return redirect()->back()->withErrors(['کلمه عبور اشتباه است']);
            }
        } else {
            return redirect()->back()->withErrors(['نام کاربری اشتباه است']);
        }
    }

    public function logout()
    {
        $user = User::where('username', Session::get('username'))->first();
        $user_id = $user->id;

        if (\App\Models\Fund::where('delivered', 2)->where('delivered_to', \Session::get('user_id'))->count() > 0) {
            return redirect('fund/receive');
        } else {
            $count = DB::table('turns')
            ->leftjoin('service_turn', 'turns.id', '=', 'service_turn.turn_id')
            ->where('turns.turn_time', '>', Carbon::today())
            ->where('service_turn.receiver_id', Session::get('user_id'))
            ->count();


            if ($count > 0) {
                return redirect('fund/deliver');
            } else {
                User::where('username', Session::get('username'))->update([
                'last_logout' => now(),
                'online' => 0
            ]);

                $activity = ActivityType::where('title', 'logout')->first();

                ActivityLog::create([
                'content' => $activity->name,
                'activity_type_id' => $activity->id,
                'user_id' => $user_id
            ]);

                $name = str_replace(' ', "_", $user->name);
                $role = Role::find($user->role_id)->title;
                // Sms::send($user->mobile, $name, '', '', 'logout');
                
                Session::flush();
                return redirect(route('home'));
            }
        }
    }

    public function toggle($id)
    {
        if (User::find($id)->active == 0) {
            $active = 1;
        } else {
            $active = 0;
        }

        User::where('id', $id)->update(['active' => $active]);
        return redirect()->back();
    }

    public function onlineUsers()
    {
        $users = User::where('online', 1)->where('username','!=','admin');
        $string = '';

        foreach ($users->get() as $row) {
            $role = Role::find($row->role_id)->title;
            $string.='<p align="right"><a href="'.url('user/logout/'.$row->id).'">'.$row->name.' - <span style="color:black"> '.$role.'</span></a></p>';
        }

        return $string.'|'.ConvertNumber::convertToPersian($users->count());
    }

    public function logoutUser($id)
    {
        User::where('id', $id)->update([
            'online' => 0
        ]);

        return redirect()->back();
    }

    public function sendSMS()
    {
        $query = User::all();
        foreach ($query as $row) {
            $username = str_replace(" ", "-", $row->username);
            User::where('id', $row->id)->update([
                'username' => $username
            ]);
        }
    }

    public function search(Request $request)
    {
        $name = $request['name'];
        $mobile = $request['mobile'];
        $role = $request['role'];

        $query = User::where('name', 'like', "%$name%");

        if (strlen($mobile) > 0) {
            $query->where('mobile', 'like', "%$mobile%");
        }
        if (strlen($role) > 0) {
            $query->where('role_id', 'like', "$role");
        }

        $users = $query->get();

        return view('new.users.index', compact('users'));
    }
}
