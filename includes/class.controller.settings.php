<?php

defined('ABSPATH') || exit;

class refresh_setting {

    public function __construct() {
        if (is_admin()) {
            add_action("admin_init", array($this, "general_settings_init"));
            add_action("admin_menu", array($this, "admin_menu"));
            add_action("admin_notices", array($this, "configuration_notices"));
            add_action("admin_init", array($this, "dismiss_configuration"));
            add_filter('plugin_action_links_' . RNGRF_PRU, array($this, 'add_setting_link'));
        }
    }

    /**
     * Show settings description
     * @param Array $args
     */
    public function general_setting_section_top($args) {
        esc_html_e("check post types you want to show refresh metabox in edit panels", "rng-refresh");
    }

    /**
     * callback function of allowed post types for refresh action
     * @param Array $args
     */
    public function general_setting_active_post_type($args) {
        $option = get_option("refresh_general_setting_option");

        $values = (isset($option) and ! empty($option)) ? $option[$args['name']] : array('page');
        $pt_args = array('public' => TRUE);
        $post_types = get_post_types($pt_args, 'names');
        $key = array_search("attachment", $post_types);
        unset($post_types[$key]);
        foreach ($post_types as $post_type):
            ?>
            <label>
                <?php echo $post_type ?>&nbsp;<input type="checkbox" name="refresh_general_setting_option[<?php echo $args['name']; ?>][]" <?php echo (in_array($post_type, $values)) ? "checked" : ""; ?> value="<?php echo $post_type; ?>" >
            </label>
            <br>
            <?php
        endforeach;
    }

    /**
     * general setting initialize method
     */
    public function general_settings_init() {
        register_setting("refresh_general_setting", "refresh_general_setting_option");
        add_settings_section(
                "refresh-general-settings-top", esc_html__("refresh plugin settings", "rng-refresh"), array($this, "general_setting_section_top"), "refresh_general_setting"
        );
        add_settings_field(
                "refresh-active-post-type", esc_html__("Refresh permission", "rng-refresh"), array($this, "general_setting_active_post_type"), "refresh_general_setting", "refresh-general-settings-top", array(
            "label_for" => "refrsh-active-post-type",
            "name" => "refresh-active-post-type",
            "class" => "regular-text",
            "custom_data" => "refresh-active-post-type"
                )
        );
    }

    /**
     * Refresh settings submenu init
     */
    public function admin_menu() {
        add_submenu_page('options-general.php', esc_html__("Refresh Settings", "rng-refresh"), esc_html__("Refresh Settings", "rng-refresh"), 'administrator', 'refresh-settings', array($this, "refresh_setting_panel"));
    }

    /**
     * callback function of refresh setting content screen
     */
    public function refresh_setting_panel() {
        require_once RNGRF_ADM . 'setting-panel.php';
    }

    /**
     * add notification in order to plugin configuration when plugin install
     */
    public function configuration_notices() {
        $dismiss = get_option("rng_refresh_configure_dismiss");
        if (!$dismiss) {
            $output = '<div class="updated"><p>' . esc_html__('RNG_refresh is activated, you may need to configure it to work properly.', 'rng-refresh') . ' <a href="' . admin_url('admin.php?page=refresh-settings') . '">' . esc_html__('Go to Settings page', 'rng-refresh') . '</a> &ndash; <a href="' . add_query_arg('rng_refres_dismis_notice', 'true') . '">' . esc_html__('Dismiss', 'rng-refresh') . '</a></p></div>';
            echo $output;
        }
    }
    /**
     * dissmiss configuration notice action
     */ 
    public function dismiss_configuration() {
        if ((isset($_GET['rng_refres_dismis_notice']) and $_GET['rng_refres_dismis_notice'] == "true") or ( isset($_GET['page']) and $_GET['page'] == "refresh-settings" )) {
            update_option("rng_refresh_configure_dismiss", 1);
        }
    }
    /**
     * add setting link to plugins screen list
     * @param Array $links
     * @return Array
     */
    public function add_setting_link($links) {
        $mylinks = array(
            '<a href="' . admin_url('options-general.php?page=refresh-settings') . '">' . esc_html__("Settings", "rng-refresh") . '</a>',
        );
        return array_merge($links, $mylinks);
    }

}

$refresh_settings = new refresh_setting();
