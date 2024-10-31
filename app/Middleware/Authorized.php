<?php

namespace Ovoads\Middleware;

class Authorized{
    public function filterRequest()
    {
        if (is_user_logged_in()) {
            ovoads_redirect(home_url());
            exit;
        }
    }
}