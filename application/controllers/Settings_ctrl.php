<?php

class Settings_ctrl extends CI_Controller
{
    public function update_settings_session()
    {
        $api_key = $this->input->post('bitcodin-api-key');
        $page_limit = $this->input->post('page-limit');
        $data = array(
            "api_key" => $api_key,
            "page_limit" => $page_limit
        );

        $this->session->set_userdata($data);

        redirect('settings');
    }

    public function update_settings_model()
    {
        $api_key = $this->input->post('bitcodin-api-key');
        $page_limit = $this->input->post('page-limit');
        $data = array(
            "api_key" => $api_key,
            "page_limit" => $page_limit
        );

        $this->Settings->update($data);

        redirect('settings');
    }

}