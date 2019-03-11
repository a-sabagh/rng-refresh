<?php

defined('ABSPATH') || exit;

class refresh_controller {

    public function __construct() {
        if (is_admin()) {
            add_action('add_meta_boxes', array($this, 'metaboxes_init'));
            add_action('save_post', array($this, 'metaboxes_save'));
        } else {
            add_action('wp_head', array($this, 'refresh_public'));
        }
    }

    /**
     * check is refresh action allowed or not
     * @param Integer $post_id
     * @return boolean
     */
    public function is_allowed_refresh($post_id) {
        $post_type = get_post_type($post_id);
        $option = get_option("refresh_general_setting_option");
        $allowed_post_type = (isset($option) and ! empty($option)) ? $option['refresh-active-post-type'] : array('page');

        return in_array($post_type, $allowed_post_type);
    }

    /**
     * check is refresh action active or not
     * @param type $post_id
     * @return boolean
     */
    public function is_active_refresh($post_id) {
        $is_allowed_refresh = $this->is_allowed_refresh($post_id);
        $is_refresh = get_post_meta($post_id, "rngrf_is_refresh_active", TRUE);
        return ($is_allowed_refresh and $is_refresh);
    }

    /**
     * add refresh meta tag if allowed
     * @global Object $post
     */
    public function refresh_public() {
        global $post;
        $post_id = (int) $post->ID;
        $active_refresh = $this->is_active_refresh($post_id);
        
        if ($active_refresh) {
            $refresh_time = get_post_meta($post_id, "rngrf_refresh_time", TRUE);
            echo '<meta http-equiv="refresh" content="' . $refresh_time . '">';
        }
    }

    /**
     * initialize refresh metabox in admin panel
     */
    public function metaboxes_init() {
        $post_id = intval($_GET['post']);

        if ($this->is_allowed_refresh($post_id)) {
            add_meta_box("refresh_init", esc_html__("Refresh Settings", "rng-refresh"), array($this, 'refresh_metabox_input'), $post_types, "side", "low");
        }
    }

    /**
     * get string time from metabox and convert to second
     * @param String $string
     * @return 
     */
    public function splite_second($string) {
        $time_arr = array_map('intval', explode(":", $string));
        $hour = current($time_arr);
        $miniutes = next($time_arr);
        $seconds = next($time_arr);
        $output = ($hour * 3600 ) + ( $miniutes * 60) + ($seconds);
        return $output;
    }

    /**
     * get second from database and convert to string
     * @param Integer $seconds
     * @return String
     */
    private function splite_second_reverse($seconds) {
        $second = $seconds % 60;
        $miniute = floor(($seconds % 3600 ) / 60);
        $hour = floor($seconds / 3600);
        return "{$hour}:{$miniute}:{$second}";
    }

    /**
     * content of metabox in single post admin screen
     * @param Object $post
     */
    public function refresh_metabox_input($post) {
        $post_id = $post->ID;
        wp_nonce_field(basename(__FILE__), 'rng_refresh');
        $is_refresh = get_post_meta($post_id, "rngrf_is_refresh_active", TRUE);
        $refresh_time = $this->splite_second_reverse(get_post_meta($post_id, "rngrf_refresh_time", TRUE));
        require_once RNGRF_ADM . 'metabox-refresh.php';
    }

    /**
     * update refresh metabox callback
     * @param Integer $post_id
     */
    public function metaboxes_save($post_id) {

        $refresh_time = sanitize_text_field($_POST['rngrf_refresh_time']);
        $refresh_active = sanitize_text_field($_POST['rngrf_is_refresh_active']);

        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);
        $is_valid_nonce = (isset($_POST['rng_refresh']) && wp_verify_nonce($_POST['rng_refresh'], basename(__FILE__))) ? TRUE : FALSE;

        if (!$is_autosave and !$is_revision and $is_valid_nonce) {
            $refresh_time = $this->splite_second($refresh_time);
            update_post_meta($post_id, 'rngrf_is_refresh_active', $refresh_active);
            update_post_meta($post_id, 'rngrf_refresh_time', $refresh_time);
        }
    }

}

$controller_refresh = new refresh_controller();
