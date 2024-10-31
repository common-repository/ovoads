<?php

namespace Ovoads\Controllers;

use Ovoads\Controllers\Controller;
use Ovoads\Lib\VerifiedPlugin;

class ActivationController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $current_user = wp_get_current_user();
        if (!user_can( $current_user, 'administrator' )) {
            ovoads_back();
        }
    }

    public function activate()
    {
        if (VerifiedPlugin::check()) {
            ovoads_redirect(admin_url('/admin.php?page='.'ovoads'));
        }
        $this->view('activation');
    }

}