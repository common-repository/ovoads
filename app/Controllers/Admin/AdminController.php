<?php

namespace Ovoads\Controllers\Admin;

use Ovoads\Controllers\Controller;
use Ovoads\Lib\CurlRequest;
use Ovoads\Models\Advertise;

class AdminController extends Controller{

    public function dashboard()
    {
        global $wpdb;
        $pageTitle = 'Dashboard';
        $totalAds = Advertise::count('id');
        $activeAds = Advertise::where('status',1)->count();
        $inactiveAds = Advertise::where('status',0)->count();
        $totalClicks = Advertise::sum('clicks');
        $this->view('admin/dashboard', compact('pageTitle', 'totalAds','activeAds','inactiveAds','totalClicks'));
    }
    
    public function getSupport(){
        ovoads_redirect('https://ovosolution.com');
    }

}