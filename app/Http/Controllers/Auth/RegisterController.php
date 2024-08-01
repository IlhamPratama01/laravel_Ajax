<?php

namespace App\Http\Controllers\Auth;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Psy\Readline\Hoa\Console;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Auth/registrasi', ['title' => 'Register']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|max:255',
            'email' => ['required', 'unique:users'],
            'password' => ['required', 'min:8', ' max:255']

        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role_id' => $request->input('role_id', 1),
            'password' => Hash::make($request->password),
        ]);

        return redirect('/')->with('status', 'Registration  successfull! Please login');
    }

    public function storeAjax(Request $request)
    {
        // return 'Registration  successfull! Please login';

        //define validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => ['required', 'unique:users', 'email'],
        ], [
            'name.required' => 'Wajib di Isi',
            'email.required' => 'Wajib di Isi',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json(['gagal' => "Gagal melakukan update data"], 422);
        }

        $data = [
            'name' => $request->name,
            'username' => $request->name,
            'email' => $request->email,
            'role_id' => $request->input('role_id', 3),
            'password' => Hash::make($request->password),
        ];
        //create post
        User::create($data);
        return response()->json(['Success' => "Berhasil"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = User::where('id', $id)->first();
        return response()->json(['edit' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email wajib benar',
        ]);

        if ($validasi->fails()) {
            return response()->json(['gagal' => "Gagal melakukan update data"], 422);
        } else {
            $data = [
                'name' => $request->name,
                'email' => $request->email
            ];
            User::where('id', $id)->update($data);
            return response()->json(['Success' => "Berhasil melakukan update data"]);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);

        // Jika user ditemukan
        if ($user) {
            // Hapus semua posts yang berhubungan dengan user ini
            Post::where('author_id', $user->id)->delete();

            // Hapus user
            $user->delete();
        }
        return response()->json(['Success' => "Berhasil melakukan update data"]);
    }
}
