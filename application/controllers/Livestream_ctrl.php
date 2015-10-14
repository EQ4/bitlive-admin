<?php

use bitcodin\Bitcodin;
use bitcodin\LiveStream;
use bitcodin\EncodingProfile;
use bitcodin\Output;

class Livestream_ctrl extends CI_Controller
{
    public function create($label, $streamKey, $encProfId, $outputId, $timeshift)
    {
        Bitcodin::setApiToken($this->session->api_key);
        try
        {
            Bitcodin::setApiToken($this->session->api_key);

            $encProf = EncodingProfile::get($encProfId);
            $output = Output::get($outputId);

            LiveStream::create($label, $streamKey, $encProf, $output, $timeshift);
        }
        catch(\Exception $ex)
        {
            echo "<div class='top-buffer'></div><div class='alert alert-danger' role='alert'>".$ex->getMessage()."</div>";
        }

        redirect('overview');
    }

    public function delete($liveInstanceId)
    {
        Bitcodin::setApiToken($this->session->api_key);
        try
        {
            LiveStream::delete($liveInstanceId);
        }
        catch(\Exception $ex)
        {
            echo "<div class='top-buffer'></div><div class='alert alert-danger' role='alert'>".$ex->getMessage()."</div>";
        }

        redirect('overview');
    }

    public function update_all()
    {
        Bitcodin::setApiToken($this->session->api_key);
        try
        {
            $liveInstances = LiveStream::getAll();

            if(!isset($liveInstances) or $liveInstances === NULL)
                $liveInstances = array();

            echo
            $data['liveInstances'] = $liveInstances;

            $countError = 0;
            $countRunning = 0;
            $countTerminated = 0;

            foreach($liveInstances as $liveInstance)
            {
                if($liveInstance->status == 'ERROR')
                    $countError ++;
                elseif($liveInstance->status == 'RUNNING' or $liveInstance->status == 'STARTING' or $liveInstance->status == 'STOPPING')
                    $countRunning ++;
                elseif($liveInstance->status == 'TERMINATED')
                    $countTerminated ++;
            }
            $data['count_error'] = $countError;
            $data['count_running'] = $countRunning;
            $data['count_terminated'] = $countTerminated;

            echo json_encode($data);
        }
        catch(\Exception $ex)
        {
            echo "<div class='top-buffer'></div><div class='alert alert-danger' role='alert'>".$ex->getMessage()."</div>";
        }
    }

    public function update_tab($status, $page=0, $selectedId=-1)
    {
        Bitcodin::setApiToken($this->session->api_key);
        try
        {
            $page_limit = $this->session->page_limit;

            if($status == 'RUNNING')
            {
                $liveInstances = LiveStream::getAll(array('RUNNING', 'STARTING', 'STOPPING'));
            }
            else
            {
                $liveInstances = LiveStream::getAll($status, $page_limit, $page_limit * $page);
            }

            if(!isset($liveInstances) or $liveInstances === NULL)
                $liveInstances = array();

            $count = LiveStream::getCount();
            $data['count'] = $count;

            $data['liveInstances'] = $liveInstances;
            $data['status'] = $status;

            $num_pages = 0;
            if($status == 'RUNNING')
                $num_pages = ceil($count->running / $page_limit);
            elseif($status == 'TERMINATED')
                $num_pages = ceil($count->terminated / $page_limit);
            elseif($status == 'ERROR')
                $num_pages = ceil($count->error / $page_limit);

            $data['num_pages'] = $num_pages;
            $data['active_page'] = $page;
            $data['selected_id'] = $selectedId;

            echo $this->load->view('templates/livestreams', $data, TRUE);

            if($selectedId != -1)
            {
                foreach ($liveInstances as $liveInstance)
                {
                    if ($liveInstance->id == $selectedId)
                        $data['selected_instance'] = $liveInstance;
                }
                echo $this->load->view('templates/details.php', $data, TRUE);
            }

        }
        catch(\Exception $ex)
        {
            echo "<div class='top-buffer'></div><div class='alert alert-danger' role='alert'>".$ex->getMessage()."</div>";
        }
    }
}