<?php if(count($liveInstances) <= 0): ?>
    <h3 class='text-center'>Nothing to show!</h3>
<?php else: ?>
<table class='table text-center'>
    <tr>
        <th class="text-center">ID</th>
        <th class="text-center">Name</th>
        <th class="text-center">Status</th>
        <?php if($status == 'RUNNING'): ?>
            <th class="text-center">RTMP push URL</th>
            <th class="text-center">Action</th>
        <?php endif; ?>
    </tr>

    <?php foreach($liveInstances as $liveInstance): ?>
        <?php if((($status == 'RUNNING' and $liveInstance->status == 'STARTING') or ($status == 'RUNNING' and $liveInstance->status == 'STOPPING')) or $liveInstance->status == $status): ?>
        <tr onclick="selectInstance(this, <?php echo $liveInstance->id; ?>)" <?php
            if($liveInstance->id == $selected_id){
                echo "class='active'";
            } ?>
            style="cursor: pointer;">
            <td>
                <?php echo $liveInstance->id; ?>
            </td>
            <td>
                <?php echo $liveInstance->label; ?>
            </td>
            <td>
                <?php if($liveInstance->status == 'STARTING'): ?>
                    <span class="label label-primary"><?php echo $liveInstance->status; ?></span>
                <?php endif; ?>
                <?php if($liveInstance->status == 'STOPPING'): ?>
                    <span class="label label-warning"><?php echo $liveInstance->status; ?></span>
                <?php endif; ?>
                <?php if($liveInstance->status == 'RUNNING'): ?>
                    <span class="label label-success"><?php echo $liveInstance->status; ?></span>
                <?php endif; ?>
                <?php if($liveInstance->status == 'TERMINATED'): ?>
                    <span class="label label-default"><?php echo $liveInstance->status; ?></span>
                <?php endif; ?>
                <?php if($liveInstance->status == 'ERROR'): ?>
                    <span class="label label-danger"><?php echo $liveInstance->status; ?></span>
                <?php endif; ?>
            </td>
            <?php if($status == 'RUNNING'): ?>
                <td>
                    <?php if(sizeof($liveInstance->rtmpPushUrl) > 0 ): ?><input type="text" readonly="true" value="<?php echo $liveInstance->rtmpPushUrl; ?>" onclick="event.stopPropagation(); $(this).select();"><?php endif; ?>
                </td>
                <td>
                    <button onclick="event.stopPropagation(); deleteLiveStream(<?php echo $liveInstance->id; ?>)" class="btn btn-danger">Terminate</button>
                </td>
            <?php endif; ?>
        </tr>
        <?php endif; ?>
    <?php endforeach; ?>
</table>

<nav class="text-center">
    <ul class="pagination">
        <?php for($i = 0; $i < $num_pages and $num_pages > 1; $i++): ?>
        <li <?php if($i == $active_page){ echo "class='active'"; } ?> ><a href="#" onclick="changePage(<?php echo $i; ?>)"><?php echo $i + 1; ?></a></li>
        <?php endfor; ?>
    </ul>
</nav>
<?php endif; ?>
<script>
    updateCounts(<?php echo $count->running.','.$count->terminated.','.$count->error; ?>)
</script>
