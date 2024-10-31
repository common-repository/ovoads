<?php

namespace Ovoads\Controllers\Admin;

use Ovoads\BackOffice\Request;
use Ovoads\Controllers\Controller;

class GeneralSettingController extends Controller
{
    public function index()
    {
        $pageTitle = "General Setting";
        $this->view('admin/setting/index', compact('pageTitle'));
    }

    public function store()
    {
        $request = new Request();
        $request->validate([
            'ovoads_apikey' => 'required',
        ]);

        update_option('ovoads_apikey', sanitize_text_field($request->ovoads_apikey));

        $notify[] = ['success', 'General setting updated successfully'];
        ovoads_back($notify);
    }
   
}
