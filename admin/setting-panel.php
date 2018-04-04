<?php
if(!current_user_can("manage_options")){
    return;
}
if(isset($_GET['settings-updated']) and $_GET['settings-updated'] == TRUE){
    add_settings_error("refresh_general_setting", "refresh_general_setting" , __("Settings saved","rng-refresh") , "updated");
}elseif(isset($_GET['settings-updated']) and $_GET['settings-updated'] == FALSE){
    add_settings_error("refresh_general_setting", "refresh_general_setting" , __("Error with saving","rng-refresh"));
}
?>
<div class="wrap">
    <h1><?php echo get_admin_page_title(); ?></h1>
    <form action="options.php" method="post">
        <?php 
        settings_fields("refresh_general_setting");
        do_settings_sections("refresh_general_setting");
        submit_button(__("save","rng-refresh"));
        ?>
    </form>
</div>

