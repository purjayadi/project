<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Main_model');
		// $this->load->model('Ion_auth_model');
        // $permit = $this->Ion_auth_model->permission($this->session->identity);
        // if (!$this->ion_auth->logged_in()) {//cek login ga?
        //     redirect('login','refresh');
		// } 
		// else{
        //     if (!$this->ion_auth->in_group($permit)) {//cek admin ga?
        //         redirect('login','refresh');
        //     }
        // }
		// if (!$this->ion_auth->logged_in()) {//cek login ga?
        //     redirect('login','refresh');
        // }else{
        //     if (!$this->ion_auth->in_group('admin') AND !$this->ion_auth->in_group('members')) {//cek admin ga?
        //         redirect('login','refresh');
        //     }
        // }
	}

	public function index()
	{
		$this->load->model('Ion_auth_model');
		$permit = $this->Ion_auth_model->permission($this->session->identity);
		$data['menu']			= $permit[0];
		$data['submenu']		= $permit[1];
		$data['aktif']			='Dashboard';
		$data['title']			='Brajamarketindo';
		$data['judul']			='Dashboard';
		$data['sub_judul']		='';
		
		$data['content']		='content';
		$data['pie_data']=$this->Main_model->GetPie();
		$this->load->view('dashboard',$data);
	}
}
