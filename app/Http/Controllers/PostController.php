<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    /**
     * Replaces spaces with full text search wildcards
     *
     * @param string $term
     * @return string
     */
    protected function fullTextWildcards($term)
    {
        // removing symbols used by MySQL
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
        $term = str_replace($reservedSymbols, '', $term);
 
        $words = explode(' ', $term);
 
        foreach ($words as $key => $word) {
            /*
             * applying + operator (required word) only big words
             * because smaller ones are not indexed by mysql
             */
            if (strlen($word) >= 2) {
                $words[$key] = '+' . $word . '*';
            }
        }
 
        $searchTerm = implode(' ', $words);
 
        return $searchTerm;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $linhvuc = Category::where('published',1)->get();
        $validatedFilter = $request->validate([
            'category_id'   => 'nullable|numeric',
            'ngaybanhanh'   => 'nullable|date',
            'kyhieu'        => 'nullable|string',
            'keyword'       => 'nullable|string'
        ]);
        $vbnnFilter = [['published','=','1'],['post_type_2','like','vbnn']];
        $vbtFilter = [['published','=','1'],['post_type_2','like','vbt']];
        
        foreach($request->only(['category_id','ngaybanhanh','kyhieu']) as $key=>$item) {
            if($request->filled($key)) {
                $vbnnFilter = array_merge($vbnnFilter,array([$key,$item]));
                $vbtFilter  = array_merge($vbtFilter,array([$key,$item]));
            }
        }
        
        if($request->filled('keyword')) {
            $key = $this->fullTextWildcards($request->get('keyword'));
            $vbnn = Post::where($vbnnFilter)->whereRaw("((MATCH (name) AGAINST (? IN BOOLEAN MODE)) > 0 OR (MATCH (body) AGAINST (? IN BOOLEAN MODE)) > 0)",[$key,$key])->orderByRaw("(MATCH (name) AGAINST (? IN BOOLEAN MODE)) ASC,(MATCH (body) AGAINST (? IN BOOLEAN MODE)) ASC",[$key,$key])->paginate(15,['*'],'vbnn');
            $vbt  = Post::where($vbtFilter)->whereRaw("((MATCH (name) AGAINST (? IN BOOLEAN MODE)) > 0 OR (MATCH (body) AGAINST (? IN BOOLEAN MODE)) > 0)",[$key,$key])->orderByRaw("(MATCH (name) AGAINST (? IN BOOLEAN MODE)) ASC, (MATCH (body) AGAINST (? IN BOOLEAN MODE)) ASC",[$key,$key])->paginate(15,['*'],'vbt');
        }else{
            $vbnn = Post::where($vbnnFilter)->paginate(15,['*'],'vbnn');
            $vbt = Post::where($vbtFilter)->paginate(15,['*'],'vbt');
        }        

        return view('bk.index',compact('vbnn','vbt','linhvuc'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->load('category');
        $tmp = explode('.',$post->vanban);
        $post->extension = end($tmp);
        return view('bk.detail',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
