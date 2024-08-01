<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Post;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Category;

class BlogController extends Controller
{

    public function index()
    {
        return view('template/Blog', ['title' => 'Artikel Ilmiah', 'posts' => Post::all()]); //belogsto ada pada tampilan
    }

    public function detail(Post $post)
    {
        return view('template/Detail', ['title' => 'Detail Blog', 'post' => $post]); //belogsto ada pada tampilan
    }

    public function username(User $user)
    {
        return view('template/Blog', ['title' => count($user->unggah) . '  Artikel By . ' . $user->name, 'posts' => $user->unggah]); //hasmany
    }

    public function role(User $user)
    {
        $aturan = $user->role;
        return view('template/Blog', ['title' => count($user->unggah) . '  Role . ' . $aturan->pangkat, 'posts' => $user->unggah]); //hasmany
    }

    public function kategori(Category $category)
    {
        $kategori = $category->posts;
        return view('template/Blog', ['title' => count($kategori) . ' Kategori . ' . $category->kategori, 'posts' => $kategori]); //hasmany
    }
}
