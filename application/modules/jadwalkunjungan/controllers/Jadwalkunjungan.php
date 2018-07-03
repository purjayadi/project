<?php
    defined('BASEPATH') OR exit('No direct access script allowed');

    class Jadwalkunjungan extends CI_Controller {

        private $permit;
        public function __construct()
        {
            parent::__construct();
            //Codeigniter : Write Less Do More
            $this->load->model('Ion_auth_model');
            $this->permit = $this->Ion_auth_model->permission($this->session->identity);
            $this->load->model('M_jadwalkunjungan', 'm_jadwal');

            if (!$this->ion_auth->logged_in()) {//cek login ga?
                redirect('login','refresh');
            }
        }

        function index(){
            $data = array(
                'aktif'      => 'Jadwal Kunjungan',
                'menu'       => $this->permit[0],
                'submenu'	   => $this->permit[1],
                'content'    => 'list_jadwal',
                'judul'      => 'Dashboard',
                'sub_judul'  => 'Jadwal Kunjungan',
                'jadwal'     => $this->m_jadwal->getall()
            );

            $this->load->view('panel/dashboard', $data);
        }

        function form(){
            $data = array(
                'aktif'      => 'Jadwal Kunjungan',
                'menu'       => $this->permit[0],
                'submenu'	   => $this->permit[1],
                'content'    => 'form_jadwal',
                'judul'      => 'Dashboard',
                'sub_judul'  => 'Jadwal Kunjungan'
            );
            $this->load->view('panel/dashboard', $data);
        }

        public function create()
        {
            $cek = get_permission('Jadwal Kunjungan', $this->permit[1]);
            if (!$cek) {//cek admin ga?
                redirect('panel','refresh');
            }
            $data = array(
              'button'     => 'Tambah',
              'action'     => site_url('jadwalkunjungan/create_action'),
        	    'id_jadwal'  => set_value('id_jadwal'),
        	    'nama_pel'   => set_value('nama_pel'),
        	    'validator'  => set_value('validator'),
        	    'tanggal'    => set_value('tanggal'),
                'sumber_data'  => set_value('sumber_data'),
                'ket'        => set_value('ket'),
              'aktif'      => 'Jadwal Kunjungan',
              'menu'       => $this->permit[0],
              'submenu'	   => $this->permit[1],
              'content'    => 'form_jadwal',
              'judul'      => 'Dashboard',
              'sub_judul'  => 'Jadwal Kunjungan',
              'pelanggan'  => $this->m_jadwal->get_data_pelanggan(),
              'm_validator'  => $this->m_jadwal->get_data_karyawan()
    	       );

            $this->load->view('panel/dashboard', $data);
        }

        public function create_action()
        {
            $cek = get_permission('Jadwal Kunjungan', $this->permit[1]);
            if (!$cek) {//cek admin ga?
                redirect('panel','refresh');
            }
            $this->_rules();

            if ($this->form_validation->run() == FALSE) {
                $this->create();
                echo 'gagal';
            } else {

                $data = array(
            		'id_pelanggan' => $this->input->post('nama_pel',TRUE),
            		'id_karyawan' => $this->input->post('validator',TRUE),
                    'tanggal_kunjungan' => $this->input->post('tanggal',TRUE),
                    'sumber_data' => $this->input->post('sumber_data',TRUE),
            		'keterangan' => $this->input->post('ket',TRUE),
            	  );

                $this->m_jadwal->insert($data);
                $this->session->set_flashdata('message', 'Simpan Data Success');
                redirect(site_url('jadwalkunjungan'));
            }
        }

        public function update($id)
        {
            $cek = get_permission('Jadwal Kunjungan', $this->permit[1]);
            if (!$cek) {//cek admin ga?
                redirect('panel','refresh');
            }
            $row = $this->m_jadwal->get_by_id($id);

            if ($row) {
              $data = array(
                'button'     => 'Update',
                'action'     => site_url('jadwalkunjungan/update_action'),
          	    'id_jadwal'  => set_value('id_jadwal', $row->id_jadwal),
          	    'nama_pel'   => set_value('nama_pel', $row->id_pelanggan),
          	    'validator'  => set_value('validator', $row->id_karyawan),
                  'tanggal'    => set_value('tanggal', $row->tanggal_kunjungan),
                  'sumber_data'    => set_value('sumber_data', $row->sumber_data),
          	    'ket'        => set_value('ket', $row->keterangan),
                'aktif'      => 'Jadwal Kunjungan',
                'menu'       => $this->permit[0],
                'submenu'	   => $this->permit[1],
                'content'    => 'form_jadwal',
                'judul'      => 'Dashboard',
                'sub_judul'  => 'Jadwal Kunjungan',
                'pelanggan'  => $this->m_jadwal->get_data_pelanggan(),
                'm_validator'  => $this->m_jadwal->get_data_karyawan()
      	       );

                $this->load->view('panel/dashboard', $data);
            } else {
                $this->session->set_flashdata('msg', 'Data Tidak Ada');
                redirect(site_url('jadwalkunjungan'));
            }
        }


        public function update_action()
        {
            $cek = get_permission('Jadwal Kunjungan', $this->permit[1]);
            if (!$cek) {//cek admin ga?
                redirect('panel','refresh');
            }
            $this->_rules();

            if ($this->form_validation->run() == FALSE) {
                $this->update($this->input->post('id_jadwal', TRUE));
            } else {
              $data = array(
              'id_pelanggan' => $this->input->post('nama_pel',TRUE),
              'id_karyawan' => $this->input->post('validator',TRUE),
              'tanggal_kunjungan' => $this->input->post('tanggal',TRUE),
              'sumber_data' => $this->input->post('sumber_data',TRUE),
              'keterangan' => $this->input->post('ket',TRUE),
              );

                $this->m_jadwal->update($this->input->post('id_jadwal', TRUE), $data);
                $this->session->set_flashdata('message', 'Update Record Success');
                redirect(site_url('jadwalkunjungan'));
            }
        }

        public function delete($id)
        {
            $cek = get_permission('Jadwal Kunjungan', $this->permit[1]);
            if (!$cek) {//cek admin ga?
                redirect('panel','refresh');
            }
            $row = $this->m_jadwal->get_by_id($id);

            if ($row) {
                $this->m_jadwal->delete($id);
                $this->session->set_flashdata('message', 'Hapus Data Success');
                redirect(site_url('jadwalkunjungan'));
            } else {
                $this->session->set_flashdata('msg', 'Data Tidak Ada');
                redirect(site_url('jadwalkunjungan'));
            }
        }

        public function _rules()
        {
        	$this->form_validation->set_rules('nama_pel', 'nama_pel', 'trim|required');
        	$this->form_validation->set_rules('validator', 'validator', 'trim|required');
        	// $this->form_validation->set_rules('tanggal', 'tanggal', 'regex_match[(0[1-9]|1[0-9]|2[0-9]|3(0|1))-(0[1-9]|1[0-2])-\d{4}]'); 
            $this->form_validation->set_rules('ket', 'ket', 'trim|required');
            $this->form_validation->set_rules('sumber_data', 'sumber_data', 'trim|required');
        	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
        }

    }
