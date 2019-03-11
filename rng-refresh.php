<?php
/*
  Plugin Name: rng-refresh
  Description: WordPress Plugin that refreshes the single template of public post types with a synchronism time period.
  Version: 1.0
  Author: Abolfazl Sabagh
  Author URI: http://asabagh.ir
  License: GPLv2 or later
  Text Domain: rng-refresh
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

define(RNGRF_PRU,plugin_basename( __FILE__ ));  
define(RNGRF_PDU, plugin_dir_url(__FILE__));   //http://localhost:8888/rng-plugin/wp-content/plugins/rng-refresh/
define(RNGRF_PRT, basename(__DIR__));          //rng-refresh.php
define(RNGRF_PDP, plugin_dir_path(__FILE__));  //Applications/MAMP/htdocs/rng-plugin/wp-content/plugins/rng-refresh
define(RNGRF_TMP, RNGRF_PDP . "/public/");     // view OR templates System for public 
define(RNGRF_ADM, RNGRF_PDP . "/admin/");      // view OR templates System for admin panel


require_once 'includes/class.init.php';
$refresh_init = new refresh_init(0.5,'rng-refresh');