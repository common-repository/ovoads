<?php

namespace Ovoads\Controllers\Admin;

use Ovoads\BackOffice\Request;
use Ovoads\Controllers\Controller;
use Ovoads\Models\AdDomainList;
use Ovoads\Models\AdKeyword;

class AdDomainListController extends Controller
{
    // listed domain list
    public function index()
    {
        $pageTitle = 'Ad Domain List';
        $search = sanitize_text_field(ovoads_request()->search);
        if ($search != '') {
            $domains = AdDomainList::searchable('domain_name')->orderBy('created_at', 'desc')->paginate(20);
        }else{
            $domains = AdDomainList::orderBy('created_at', 'desc')->paginate(20);
        }
        $activeKeywords = AdKeyword::where('status',1)->get();
        $this->view('admin/domain/index', compact('pageTitle', 'domains','activeKeywords'));
    }

    // store into database
    public function store()
    {
        $request = new Request;
        $request->validate([
            'domain_name' => 'required|unique:ovoads_domain_lists, domain_name'
        ]);
        $parsedUrl = wp_parse_url($request->domain_name);
        if (isset($parsedUrl['scheme'])) {
            $notify[] = ['error', 'Remove https// or http// from the url.'];
            ovoads_back($notify);
        }
       
        AdDomainList::insert([
            'domain_name' => sanitize_text_field($request->domain_name),
            'keywords' => wp_json_encode($request->keywords)
        ]);
        $notify[] = ['success', 'Domain has been added.'];
        ovoads_back($notify);
        
    }

    // update the data
    public function update()
    {
        $request = new Request;
        $request->validate([
            'domain_name' => 'required'
        ]);
        
        $parsedUrl = wp_parse_url($request->domain_name);
        if (isset($parsedUrl['scheme'])) {
            $notify[] = ['error', 'Remove https// or http// from the url.'];
            ovoads_back($notify);
        }
       
        AdDomainList::where('id', $request->id)->update([
            'domain_name' => sanitize_text_field($request->domain_name),
            'keywords' => wp_json_encode($request->keywords)
        ]);
        $notify[] = ['success', 'Domain has been updated.'];
        ovoads_back($notify);
    }

    // permanently deleted
    public function status()
    {
        $request = new Request;
        $row = AdDomainList::where('id', $request->id)->first();
        AdDomainList::where('id', $row->id)->update([
            'status' => $row->status == 1 ? 0 : 1
        ]);
        $notify[] = ['success', 'Status has been updated.'];
        ovoads_back($notify);
    }
}
