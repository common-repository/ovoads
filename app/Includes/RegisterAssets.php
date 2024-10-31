<?php

namespace Ovoads\Includes;


class RegisterAssets
{
    public static $styles = [
        'admin' => [
            'vendor/select2.min.css',
            'vendor/select2-bootstrap-5-theme.min.css',
            'app.css',
            'custom.css',
        ],
        'global' => [
            'bootstrap.min.css',
            'all.min.css',
            'line-awesome.min.css',
        ],
        'public' => []
    ];
    public static $scripts = [
        'admin' => [
            'vendor/bootstrap-toggle.min.js',
            'vendor/jquery.slimscroll.min.js',
            'vendor/select2.full.min.js',
            'apexcharts.min.js',
            'chart.min.js',
            'app.js',
            'custom.js',
        ],
        'global' => [
            'bootstrap.bundle.min.js',
      
        ],
        'public' => []
    ];
}                              