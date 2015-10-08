</div> <!-- container -->

<?php if(isset($selected_instance) and $selected_instance != NULL): ?>
    <div class="top-buffer"></div>
    <div class="horizontal-line"></div>
    <div id="details">
        <h3 class="text-center">
            Livestream details
        </h3>
        <table class="table table-responsive">
            <tr>
                <td><b>id:</b></td>
                <td><?php echo $selected_instance->id; ?></td>
            </tr>
            <tr>
                <td><b>label:</b></td>
                <td><?php echo $selected_instance->label; ?></td>
            </tr>
            <tr>
                <td><b>status:</b></td>
                <td><?php echo $selected_instance->status; ?></td>
            </tr>
            <?php if($status == 'RUNNING'): ?>
                <tr>
                    <td><b>rtmp push url:</b></td>
                    <td><a href="<?php echo $selected_instance->rtmpPushUrl; ?>"><?php echo $selected_instance->rtmpPushUrl; ?></a></td>
                </tr>
                <tr>
                    <td><b>hls url:</b></td>
                    <td><a href="<?php echo $selected_instance->hlsUrl; ?>" target="_blank"><?php echo $selected_instance->hlsUrl; ?></a></td>
                </tr>
                <tr>
                    <td><b>mpd url:</b></td>
                    <td><a href="<?php echo $selected_instance->mpdUrl; ?>" target="_blank"><?php echo $selected_instance->mpdUrl; ?></a></td>
                </tr>
            <?php endif; ?>
            <tr>
                <td><b>created at:</b></td>
                <td>
                    <?php
                    if(!is_object($selected_instance->terminatedAt) or is_null($selected_instance->terminatedAt) or !property_exists($selected_instance->terminatedAt, 'date'))
                    {
                        $selected_instance->terminatedAt = new stdClass();
                        $selected_instance->terminatedAt->date = "-";
                    }
                    if(!is_object($selected_instance->createdAt) or is_null($selected_instance->createdAt) or !property_exists($selected_instance->createdAt, 'date'))
                    {
                        $selected_instance->createdAt = new stdClass();
                        $selected_instance->createdAt->date = "-";
                    }

                    echo $selected_instance->createdAt->date;
                    ?>
                </td>
            </tr>
            <tr>
                <td><b>terminated at:</b></td>
                <td><?php echo $selected_instance->terminatedAt->date; ?></td>
            </tr>
        </table>
    </div>
<?php endif; ?>