<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    //
    public function index()
    {
        return view('posts');
    }

    public function getData(Request $request)
    {
        $columns = ['id', 'title', 'content', 'created_at', 'updated_at'];

        $length = $request->input('length');
        $column = $request->input('column'); // Index
        $dir = $request->input('dir'); // asc or desc
        $searchValue = $request->input('search');

        $query = Post::select('id', 'title', 'content', 'created_at', 'updated_at')->orderBy($columns[$column], $dir);

        if ($searchValue) {
            $query->where(function($query) use ($searchValue) {
                $query->where('title', 'like', '%' . $searchValue . '%')
                      ->orWhere('content', 'like', '%' . $searchValue . '%');
            });
        }

        $posts = $query->paginate($length);
        return ['data' => $posts->items(), 'draw' => $request->input('draw'), 'recordsTotal' => $posts->total(), 'recordsFiltered' => $posts->total()];
    }

    public function edit($id)
    {
        $post = Post::find($id);
        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $post->update($request->all());
        return response()->json(['success' => 'Post updated successfully']);
    }
}
