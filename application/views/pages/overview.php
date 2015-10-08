<script>

    $(function() {

        var timeout = undefined;
        var status = 'RUNNING';
        var activePage = 0;
        var selectedId = -1;

        $("#details").hide();

        updateAllLivestream = function (status) {
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url("livestream-ctrl/update-all"); ?>'
            });
        };

        clearUpdateTimeout = function() {
            if(typeof timeout != 'undefined'){
                clearTimeout(timeout);
            }
        };

        updateLivestreams = function (status) {

            if(typeof timeout != 'undefined'){
                clearTimeout(timeout);
            }

            timeout = setTimeout(function(){
                ZeroClipboard.destroy();
                updateLivestreams(status);
            }, 10000);

            $.ajax({
                type: 'GET',
                url: '<?php echo site_url("livestream-ctrl/update-tab"); ?>/' + status + '/' + activePage + '/' + selectedId,
                success: function (data) {
                    $('#ajax-loader').hide();
                    ZeroClipboard.config({swfPath: "<?php echo base_url('assets/zeroclipboard/ZeroClipboard.swf'); ?>" });
                    ZeroClipboard.create();
                    $('#livestreams').html(data).show();
                }
            });
        };

        updateLivestreams(status);

        createLiveStream = function () {
            var label = $("#livestream-name").val();
            var streamkey = $("#streamkey").val();
            var timeshift = $("#timeshift").val();
            var encProfId = $("#encProfSelect").val();
            var outputId = $("#outputSelect").val();

            $.ajax({
                type: 'POST',
                url: '<?php echo site_url("livestream-ctrl/create"); ?>/' + label + '/' + streamkey + '/' + encProfId + '/' + outputId + '/' + timeshift,
                success: function () {
                    updateLivestreams(status);
                    updateCounts();
                }
            });
        };

        deleteLiveStream = function(liveStreamId) {
            clearUpdateTimeout();
            $.ajax({
                type: 'DELETE',
                url: '<?php echo site_url("livestream-ctrl/delete"); ?>/' + liveStreamId,
                success: function () {
                    selectedId = -1;
                    updateLivestreams(status);
                    updateCounts();
                }
            });
        };

        selectInstance = function(element, id) {
            $("#details").hide();
            $("#ajax-loader").show();
            $("#livestreams table tr").removeClass("active");

            $(element).addClass('active');
            selectedId = id;
            updateLivestreams(status);
        };

        changeApiKey = function(){
            updateLivestreams(status);
        };

        updateCounts = function(count_running, count_terminated, count_error)
        {
            $("#count-running").text(count_running);
            $("#count-terminated").text(count_terminated);
            $("#count-error").text(count_error);
        };

        updateCounts();

        changePage = function(page){
            activePage = page;
            selectedId = -1;
            updateLivestreams(status);
        };

        $("#tab-running").on("click", function () {
            $("#details").hide();
            $("#livestreams").hide();
            $("#ajax-loader").show();
            $("#tab-terminated").removeClass('active');
            $("#tab-error").removeClass('active');
            $(this).addClass('active');
            status = 'RUNNING';
            activePage = 0;
            selectedId = -1;
            updateLivestreams(status);
        });

        $("#tab-terminated").on("click", function () {
            $("#details").hide();
            $("#livestreams").hide();
            $("#ajax-loader").show();
            $("#tab-running").removeClass('active');
            $("#tab-error").removeClass('active');
            $(this).addClass('active');
            status = 'TERMINATED';
            activePage = 0;
            selectedId = -1;
            updateLivestreams(status);
        });

        $("#tab-error").on("click", function () {
            $("#details").hide();
            $("#livestreams").hide();
            $("#ajax-loader").show();
            $("#tab-terminated").removeClass('active');
            $("#tab-running").removeClass('active');
            $(this).addClass('active');
            status = 'ERROR';
            activePage = 0;
            selectedId = -1;
            updateLivestreams(status);
        });

    });
</script>

<div class="row">
    <div class="col-sm-12">
        <h2 class="text-center">Overview of your live streams</h2>
    </div>
</div>

<div class="top-buffer"></div>

<div class="row">
    <form class="col-sm-12">
        <div class="form-group col-sm-8">
            <label for="livestream-name">Live stream name</label>
            <input id="livestream-name" class="form-control" type="text" placeholder="Name of live stream">
            <label for="streamkey">Stream key</label>
            <input id="streamkey" class="form-control" type="text" placeholder="Stream key">
            <label for="timeshift">Timeshift</label>
            <input id="timeshift" class="form-control" type="number" placeholder="Timeshift">
        </div>
        <div class="form-group col-sm-4">
            <label for="encProfSelect">Encoding Profile</label>
            <select class="form-control" id="encProfSelect">
                <?php foreach($encodingProfiles as $encodingProfile): ?>
                    <option value="<?php echo $encodingProfile->encodingProfileId; ?>"><?php echo $encodingProfile->encodingProfileId." - ".$encodingProfile->name; ?></option>
                <?php endforeach; ?>
            </select>
            <label for="outputSelect">Output</label>
            <select class="form-control" id="outputSelect">
                <?php foreach($outputs as $output): ?>
                    <option value="<?php echo $output->outputId; ?>"><?php echo $output->outputId." - ".$output->name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group col-sm-12">
            <button type="submit" class="btn btn-default" onclick="createLiveStream()">Create Live stream</button>
        </div>
    </form>
</div>

<div class="top-buffer"></div>

<div class="row">
    <div class="col-sm-12">
        <ul class="nav nav-tabs nav-justified">
            <li id="tab-running" role="presentation" class="active"><a href="#">Running <span id="count-running" class="badge">N/A</span></a></li>
            <li id="tab-terminated" role="presentation"><a href="#">Terminated <span id="count-terminated" class="badge">N/A</span></a></li>
            <li id="tab-error" role="presentation"><a href="#">Error <span id="count-error" class="badge">N/A</span></a></li>
        </ul>
        <div id="livestreams"></div>
        <div id="no-livestreams"></div>
        <div id="ajax-loader">
            <div class="top-buffer"></div>
            <div class="top-buffer"></div>
            <img src="<?php echo img_url('ajax-loader.gif'); ?>" class="center-block">
        </div>
    </div>
</div>