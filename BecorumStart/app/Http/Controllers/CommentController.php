<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;


class CommentController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function store(Topic $topic, Request $request){

    }
}
