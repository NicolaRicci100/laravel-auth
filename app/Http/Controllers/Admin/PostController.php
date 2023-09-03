<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use GrahamCampbell\ResultType\Success;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::orderBy('updated_at', 'DESC')->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $post = new Post();
        return view('admin.posts.create', compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string|max:50|unique:posts',
                'content' => 'required|string',
                'image' => 'nullable|url'
            ],
            [
                'title.required' => 'Il titolo è obbligatorio',
                'title.max' => 'Il titolo deve essere lungo massimo :max caratteri',
                'title.unique' => "Esiste già un post dal titolo $request->title",
                'content.required' => 'Non può esistere un post senza contenuto',
                'image.url' => "L'url inserito non è valido"
            ]
        );

        $data = $request->all();
        $post = new Post();
        $post->fill($data);
        $post->slug = Str::slug($post->title, '-');
        $post->save();
        return to_route('admin.posts.show', $post)->with('type', 'success')->with('message', 'Post aggiunto');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate(
            [
                'title' => ['required', 'string', 'max:50', Rule::unique('posts')->ignore($post->id)],
                'content' => 'required|string',
                'image' => 'nullable|url'
            ],
            [
                'title.required' => 'Il titolo è obbligatorio',
                'title.max' => 'Il titolo deve essere lungo massimo :max caratteri',
                'title.unique' => "Esiste già un post dal titolo $request->title",
                'content.required' => 'Non può esistere un post senza contenuto',
                'image.url' => "L'url inserito non è valido"
            ]
        );

        $data = $request->all();
        $data['slug'] = Str::slug($data['title'], '-');
        $post->update($data);

        return to_route('admin.posts.show', $post)->with('type', 'success')->with('message', 'Post modificato con successo');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return to_route('admin.posts.index')->with('type', 'success')->with('message', 'Post eliminato con successo');
    }
}
