<?php

use bitcodin\Bitcodin;
use bitcodin\EncodingProfile;
use bitcodin\Output;

class Pages_ctrl extends CI_Controller
{
    public function view($page = 'overview')
    {
        if ( ! file_exists(APPPATH.'/views/pages/'.$page.'.php'))
        {
            show_404();
        }

        $data['title'] = ucfirst($page);
        $data['api_key'] = $this->session->api_key;
        $data['api_url'] = Bitcodin::getBaseUrl();

        if(!isset($this->session->page_limit) or !is_numeric($this->session->page_limit))
        {
            $this->session->page_limit = 10;
        }

        $data['page_limit'] = $this->session->page_limit;

        $page_files = get_filenames(APPPATH.'/views/pages');

        $menu_items = array();
        foreach($page_files as $file)
        {
            $name = basename($file, '.php');
            $menu_items[] = ucfirst($name);
        }

        $index = array_search('Home', $menu_items);
        $home = $menu_items[$index];
        unset($menu_items[$index]);
        array_unshift($menu_items, $home);

        if($page == 'overview')
        {
            Bitcodin::setApiToken($this->session->api_key);
            $encodingProfiles = EncodingProfile::getListAll();
            if(count($encodingProfiles) <= 0)
                $encodingProfiles[] = array("No encoding profiles found");

            $outputs = Output::getListAll();
            if(count($outputs) <= 0)
                $outputs = array("No outputs found");

            $data['encodingProfiles'] = $encodingProfiles;
            $data['outputs'] = $outputs;
        }

        $data['menu_items'] = $menu_items;
        $this->load->view('templates/header', $data);
        $this->load->view('pages/'.$page, $data);
        $this->load->view('templates/footer', $data);
    }
}