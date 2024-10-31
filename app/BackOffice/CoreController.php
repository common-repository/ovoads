<?php

namespace Ovoads\BackOffice;

class CoreController{
    public function view($view,$data = [])
    {
        ob_start();
        extract($data);
        include $this->viewPath.'/'.$view.'.php';
        $this->clearFlashSession();
    }

    public function clearFlashSession()
    {
        if( empty(session_id()) && !headers_sent()){
            session_start();
        }
        $sessions = isset($_SESSION) ? $_SESSION : [];
        foreach ($sessions as $key => $session) {
            $isFlash = @explode('.____',$key)[1];
            if ($isFlash && $isFlash == 'flash') {
                ovoads_session()->forget($key);
            }
        }
    }

}