<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends CI_Controller {
	private $permit;
	function __construct()
	{
		parent::__construct();
		$this->load->model('Main_model');
		if (!$this->ion_auth->logged_in()) {//cek login ga?
            redirect('login','refresh');
        }else{
            if (!$this->ion_auth->in_group('Super User')) {//cek admin ga?
                redirect('login','refresh');
            }
        }
	}

	public function index()
	{
		$data['aktif']			='Dashboard';
		$data['title']			='Brajamarketindo';
		$data['judul']			='Dashboard';
		$data['sub_judul']		='';
		$data['menu']			= $this->permit[0];
		$data['submenu']		= $this->permit[1];
		$data['content']		='content';
		$data['pie_data']=$this->Main_model->GetPie();
		$this->load->view('dashboard',$data);
	}
}
