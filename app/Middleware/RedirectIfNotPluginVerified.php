<?php

namespace Ovoads\Middleware;

class RedirectIfNotPluginVerified
{
    public function filterRequest()
    {
        // if (!VerifiedPlugin::check()) {
        //     ovoads_redirect(home_url('ovoads'.'-activation'));
        // }
    }
}