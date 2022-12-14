<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\comment;
use App\Models\post;

class PostController extends Controller
{
    public function index(){
        $datas = post::paginate('3');
        // return $datas;
        return view('post.home', compact('datas'));
    }

    public function addCreate(){
        return view('post.upload');
    }

    public function addStore(Request $request){
        $data = $request->validate([
            'konten' => 'min:1',
            'img' => 'required',
            'title' => 'required',
        ]);
        $data['img'] =  $request->file("img")->store('post-images', 'public');
        $data['user_id'] = auth()->user()->id;

        post::create($data);
        return redirect('/home');
    }


    public function detailCreate(){
        $data = post::where('id', $id)->get();
        return $data;
    }
    
    public function detail($id){
        // $comment = comment::with('User')->get();
        $datas = post::where('id', $id)->with('comment.User', 'comment.reply.User')->get();
        // return $datas;
        return view('post.detail', compact('datas'));
    }


}
