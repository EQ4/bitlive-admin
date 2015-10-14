<h2 class="text-center">Settings</h2>
<div class="top-buffer"></div>
<div class="row">
    <div class="col-sm-6">
        <?php echo form_open("settings-ctrl/update-settings-session"); ?>
        <div class="form-group">
            <label>bitcodin-api-key:</label>
            <input id="bitcodin-api-key" name="bitcodin-api-key" class="form-control" type="password" placeholder="bitcodin-api-key" value="<?php echo $api_key; ?>">
            <p class="help-block">Current API key:
                <?php
                $num = ceil(strlen($api_key) / 4);
                $key_shown = substr($api_key, 0, $num);

                while(strlen($key_shown) < strlen($api_key)-$num)
                    $key_shown .= "*";

                $key_shown = implode( array($key_shown, substr($api_key, strlen($api_key) - $num)));

                if(strlen($key_shown) > 0)
                    echo "<p class='text-info'>$key_shown</p>";
                else
                    echo "<p class='text-danger'>Not set!</p>";
                ?>
            </p>
        </div>

        <div class="form-group">
            <label>Live instances per page:</label>
            <input id="page-limit" name="page-limit" class="form-control" type="number" placeholder="Instances per page" value="<?php echo $page_limit; ?>">

        </div>
        <button type="submit" class="btn btn-default">Save Settings</button>

        <?php echo form_close(); ?>
    </div>

    <div class="col-sm-6">
        <p class="help-block">
            Current API URL: <p class="text-info"><?php echo $api_url; ?></p>
        </p>
    </div>
</div>