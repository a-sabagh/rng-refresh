<?php

defined('ABSPATH') || exit;

class refresh_init {

    /**
     * plugin version
     * @var Integer
     */
    public $version;

    /**
     * plugin slug
     * @var String
     */
    public $slug;
    /**
     * mapping version and slug and Hooks
     * @param Integer $version
     * @param String $slug
     */
    public function __construct($version, $slug) {
        $this->version = $version;
        $this->slug = $slug;
        add_action('plugins_loaded', array($this, 'plugins_loaded'));
        add_action('admin_enqueue_scripts', array($this, 'admin_enequeue_scripts'));
        $this->load_modules();
    }

    /**
     * localization action for plugin
     */
    public function plugins_loaded() {
        load_plugin_textdomain($this->slug, false, RNGRF_PRT . "/languages");
        require_once trailingslashit(__DIR__) . "translate.php";
    }

    /**
     * admin enqueue script
     */
    public function admin_enequeue_scripts($hook) {
        if ($hook !== 'post.php') {
			return;
		}
		wp_enqueue_style('rngrf-admin-style', RNGRF_PDU . 'assets/css/admin-style.css');
		wp_enqueue_script('rngrf-admin-script', RNGRF_PDU . 'assets/js/admin-script.js', array('jquery'), '', TRUE);
    }

    /**
     * Plugin Bootstrap Modules
     */
    public function load_modules() {
        require_once 'class.controller.refresh.php';
        require_once 'class.controller.settings.php';
    }

}
