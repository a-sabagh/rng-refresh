<p><?php echo __("Active Refreshing :","rng-refresh"); ?></p>
<p class="field switch">
    <label class="cb-enable <?php echo ($is_refresh == 'on') ? 'selected' : ''; ?>"><span><?php echo __("on","rng-refresh"); ?></span></label>
    <label class="cb-disable <?php echo ($is_refresh == NULL) ? 'selected' : ''; ?>"><span><?php echo __("off","rng-refresh"); ?></span></label>
    <input type="checkbox" class="checkbox" name="rngrf_is_refresh_active" <?php echo ($is_refresh == 'on') ? 'selected' : ''; ?>/>
</p>
<p><?php echo __("Refresh Sycle Time :") ?></p>
<input type="text" name="rngrf_refresh_time" class="form-control time-input" value="<?php echo $refresh_time; ?>">
<span><?php echo __("Pattern: ","rng-refresh"); ?><strong><?php echo __("(hour:minutes:second)","rng-refresh") ?></strong></span>
