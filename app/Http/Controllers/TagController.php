<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;

class TagController extends Controller
{
  private $rules = [
      'name' => ['required']
    ];

  public function __construct(){
    $this->middleware('auth');
  }

  public function index(Request $request){
    $tags = $request->user()->company()->first()->tags()->orderBy('name')->paginate(10);;
    return view('tags.index', compact('tags'));
  }
  public function create(Request $request)
  {
    return view("tags.create");
  }
  public function store(Request $request)
  {
    $this->validate($request, $this->rules);

    $data = $request->all();
    $request->user()->company()->first()->tags()->create($data);

    return redirect('tags')->with('message', 'Tag Saved!');
  }

  public function edit($id, Request $request)
  {

    $tag = Tag::findOrFail($id);
    if($request->user()->cant('modify', $tag)){
      return redirect('tags')->with('error_message', 'Unauthorized for updating tags!');
    }
    return view("tags.edit", compact('tag'));
  }

  public function update ($id, Request $request){
    $this->validate($request, $this-> rules);
    $tag = Tag::findOrFail($id);
    $data = $request->all();
    $tag->update($data);
    return redirect('tags')->with('message', 'Tag Updated!');
  }
}
