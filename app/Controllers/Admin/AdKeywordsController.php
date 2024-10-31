<?php

namespace Ovoads\Controllers\Admin;

use Ovoads\BackOffice\Request;
use Ovoads\Controllers\Controller;
use Ovoads\Models\AdKeyword;

class AdKeywordsController extends Controller
{
    public function index(){
        $pageTitle = "Keywords";
        $keywords = AdKeyword::searchable('keyword')->orderBy('created_at', 'desc')->paginate(20);
        $this->view('admin/advertise/keyword', compact('pageTitle','keywords'));
    }

    public function store(){
        $request = new Request;
        $request->validate([
            'keyword' => 'required|unique:ovoads_keywords, keyword'
        ]);
        AdKeyword::insert([
            'keyword' => sanitize_text_field($request->keyword)
        ]);
        $notify[] = ['success', 'Keyword has been added'];
        ovoads_back($notify);
    }

    public function update(){
        $request = new Request;
        $request->validate([
            'keyword' => 'required|unique:ovoads_keywords, keyword'
        ]);
        AdKeyword::where('id',$request->id)->update([
            'keyword' => sanitize_text_field($request->keyword)
        ]);
        $notify[] = ['success', 'Keyword has been updated'];
        ovoads_back($notify);
    }

    public function status(){
        $request = new Request;
        $getRow = AdKeyword::where('id', $request->id)->first();
        AdKeyword::where('id', $getRow->id)->update([
            'status' => $getRow->status == 1 ? 0 : 1
        ]);
        $notify[] = ['success', 'Status has been updated'];
        ovoads_back($notify);
    }
}