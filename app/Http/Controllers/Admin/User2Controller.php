<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Json;

class User2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $huidige_user = User::findOrFail(auth()->id());
        $name_email = '%' . $request->input('user') . '%'; // OR $artist_title = '%' . $request->artist . '%';
        $order = $request->input('order') ?? '%';
        $x = "";
        $y = "";
        switch ($order){
            case "%":
                $x = 'id';
                $y = 'asc';
                break;
            case "nameA":
                $x = 'name';
                $y = 'asc';
                break;
            case "nameZ":
                $x = 'name';
                $y = 'desc';
                break;
            case "emailA":
                $x = 'email';
                $y = 'asc';
                break;
            case "emailZ":
                $x = 'email';
                $y = 'desc';
                break;
            case "notActive":
                $x = 'active';
                $y = 'asc';
                break;
            case "admin":
                $x = 'admin';
                $y = 'desc';
                break;
        }
        $users = User::orderBy($x, $y)
            ->where(function ($query) use ($name_email) {
                $query->where('name', 'like', $name_email);
            })
            ->orWhere(function ($query) use ($name_email) {
                $query->where('email', 'like', $name_email);
            })
            ->paginate(10);
        $result = compact('users', 'huidige_user');
        Json::dump($result);
        return view('admin.users2.index', $result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users2.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return view('admin.users2.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return redirect('admin/users2');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return redirect('admin/users2');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request,[
            'name' => 'required|min:3',
            'email' => 'required|email'
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        if (isset($request->admin)) {
            $user->admin=1;
        }
        if (!isset($request->admin)){
            $user->admin=0;
        }
        if (isset($request->active)) {
            $user->active=1;
        }
        if (!isset($request->active)){
            $user->active=0;
        }
        $user->save();
        return response()->json([
            'type' => 'success',
            'text' => "The user <b>$user->name</b> has been updated",
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'active' => $user->active,
            'admin' => $user->admin,

        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'type' => 'success',
            'text' => "The User <b>$user->name</b> has been deleted"
        ]);
    }
}
