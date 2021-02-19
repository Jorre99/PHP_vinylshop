<?php

namespace App\Http\Controllers\Admin;

use App\Genre;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Json;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $genres = Genre::orderBy('name')
            ->withCount('records')
            ->get();
        $result = compact('genres');
        Json::dump($result);
        return view('admin.genres.index', $result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genre = new Genre();
        $result = compact('genre');
        return view('admin.genres.create', $result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|min:3|unique:genres,name'
        ]);

        $genre = new Genre();
        $genre->name = $request->name;
        $genre->save();
        session()->flash('success', "The genre <b>$genre->name</b> has been added");
        return redirect('admin/genres');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Genre  $genre
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function show(Genre $genre)
    {
        return redirect('admin/genres');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Genre  $genre
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Genre $genre)
    {
        $result = compact('genre');
        Json::dump($result);
        return view('admin.genres.edit', $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Genre $genre)
    {
        $this->validate($request,[
            'name' => 'required|min:3|unique:genres,name,' . $genre->id
        ]);
        $genre->name = $request->name;
        $genre->save();
        session()->flash('success', 'The genre has been updated');
        return redirect('admin/genres');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function destroy(Genre $genre)
    {
        $genre->delete();
        session()->flash('success', "The genre <b>$genre->name</b> has been deleted");
        return redirect('admin/genres');
    }
}
