<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>
<p><?php echo esc_html__("Active Refreshing :", "rng-refresh"); ?></p>
<p class="field switch">
    <label class="cb-enable <?php echo ($is_refresh == 'on') ? 'selected' : ''; ?>"><span><?php echo esc_html__("on", "rng-refresh"); ?></span></label>
    <label class="cb-disable <?php echo ($is_refresh == NULL) ? 'selected' : ''; ?>"><span><?php echo esc_html__("off", "rng-refresh"); ?></span></label>
    <input type="checkbox" class="checkbox" name="rngrf_is_refresh_active" <?php echo ($is_refresh == 'on') ? 'selected' : ''; ?>/>
</p>
<p><?php echo esc_html__("Refresh Sycle Time :", "rng-refresh") ?></p>
<input type="text" name="rngrf_refresh_time" class="form-control time-input" value="<?php echo $refresh_time; ?>"><br>
<span><?php echo esc_html__("Pattern: ", "rng-refresh"); ?><strong><?php echo esc_html__("(hour:minutes:second)", "rng-refresh") ?></strong></span>