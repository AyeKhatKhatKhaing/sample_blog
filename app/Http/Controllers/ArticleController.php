<?php

namespace App\Http\Controllers;

use App\article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;
use App\Photo;
use Illuminate\Support\Facades\Gate;


class ArticleController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        // $this->middleware('isAdmin')->except('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if(Auth::user()->role == 0){
        //     $articles=Article::orderBy('id','desc')->paginate(10);
        // }
        // else{
        //     $articles=Article::where('user_id',Auth::user()->id)->orderBy('id','desc')->paginate(10);
        // }

        $articles=Article::when(Auth::user()->role != 0,function($query){
            $query->where('user_id',Auth::user()->id);
        })->when(request()->search,function($query){
            $searchKey=request()->search;
            $query->where('title',"like","%$searchKey%")->orWhere('description','like',"%$searchKey%");
        })->with(['getUser','getPhotos'])->orderBy('id','desc')->paginate(150);
        return view('article.index',compact('articles'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('article.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            "title"=>"required|min:10|max:255",
            "description"=>"required|min:10",
            "photo.*"=>"mimetypes:image/jpg,image/jpeg,image/png"
        ]);
        //multiple file save
        if($request->hasFile('photo')){
            $fileNameArr=[];
            foreach($request->file('photo') as $file){
                $newFileName=uniqid().'_Profile_'.$file->getClientOriginalName();
                array_push($fileNameArr,$newFileName);
                $dir="/public/article";
                $file->storeAs($dir,$newFileName);
            }
        }
        
        if($request->hasFile('photo')){
            $article=new Article();
            $article->title = $request->title;
            $article->description = $request->description;
            $article->user_id=Auth::id();
            $article->save();

            foreach($fileNameArr as $f){
                $photo=new Photo();
                $photo->article_id = $article->id;
                $photo->location=$f;
                $photo->save();
            }
        }
        return redirect()->route('article.create')->with('status',"<b>$request->title</b> is added");
        //multiple file save end

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(article $article)
    {
        return view('article.show',compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(article $article)
    {
        return view('article.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, article $article)
    {
        $request->validate([
            "title"=>"required|min:10|max:255",
            "description"=>"required|min:10"
        ]);
        $article->title = $request->title;
        $article->description = $request->description;
        $article->save();
        return redirect()->route('article.index')->with('update_status',"<b>$request->title</b> is updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(article $article)
    {
        if(Gate::allows('ArticleDelete',$article)){
            $dir="/public/article/";
            if(isset($article->getPhotos)){
                foreach($article->getPhotos as $p){
                    Storage::delete($dir.$p->location);
                }
                $toDel= $article->getPhotos->pluck('id');
                Photo::destroy($toDel);
            }
            $article->delete();
            return redirect()->route('article.index')->with('status',"<b>$article->title</b> is deleted");
        }
        else{
            return abort('404');
        }
    }
    
    // public function search(Request $request){
    //     $searchKey=$request->search;
    //     $articles=Article::where('title',"like","%$searchKey%")->orWhere('description','like',"%$searchKey%")->paginate(5);
    //     return view('article.search',compact('articles'));
    // }
}