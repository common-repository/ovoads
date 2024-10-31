<?php

namespace Ovoads\Hook;

use Ovoads\Includes\RegisterAssets;

class LoadAssets{
    private $scope;

    private $styles;
    private $scripts;

    public function __construct($scope)
    {
        $this->scope = $scope;

        $this->styles = RegisterAssets::$styles;
        $this->scripts = RegisterAssets::$scripts;
    }

    public function enqueueScripts()
    {
        $globalScripts = RegisterAssets::$scripts['global'];
        foreach ($globalScripts as $script) {
            $name = str_replace('.js', '', $script);
            wp_enqueue_script( $name, esc_url(plugin_dir_url('/') .'ovoads'.  "/assets/global/js/".$script), array('jquery'), OVOADS_PLUGIN_VERSION, 'all' );
        }

        $scripts = $this->scripts[$this->scope];
        foreach ($scripts as $script) {
            $name = str_replace('.js', '', $script);
            wp_enqueue_script( $name, esc_url(plugin_dir_url('/') .'ovoads'.  "/assets/$this->scope/js/".$script), array('jquery'), OVOADS_PLUGIN_VERSION, 'all' );
        }
    }

    public function enqueueStyles()
    {
        $globalStyles = RegisterAssets::$styles['global'];
        foreach ($globalStyles as $style) {
            $name = str_replace('.css', '', $style);
            wp_enqueue_style( $name, esc_url(plugin_dir_url('/') .'ovoads'.  "/assets/global/css/".$style), array(), OVOADS_PLUGIN_VERSION, 'all' );
        }

        $styles = $this->styles[$this->scope];
        foreach ($styles as $style) {
            $name = str_replace('.css', '', $style);
            wp_enqueue_style( $name, esc_url(plugin_dir_url('/') .'ovoads'.  "/assets/$this->scope/css/".$style), array(), OVOADS_PLUGIN_VERSION, 'all' );
        }
    }
}