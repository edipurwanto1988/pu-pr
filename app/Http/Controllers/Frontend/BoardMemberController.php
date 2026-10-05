<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BoardMember;
use Illuminate\Http\Request;

class BoardMemberController extends Controller
{
    public function index()
    {
        $members = BoardMember::orderBy('order')->get();
        return view('frontend.dewan-pengurus', compact('members'));
    }
}
