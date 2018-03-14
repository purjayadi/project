<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Wp_barang extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Wp_barang_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'wp_barang/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'wp_barang/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'wp_barang/index.html';
            $config['first_url'] = base_url() . 'wp_barang/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Wp_barang_model->total_rows($q);
        $wp_barang = $this->Wp_barang_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'wp_barang_data' => $wp_barang,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('wp_barang/wp_barang_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Wp_barang_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'id_barang' => $row->id_barang,
		'nama_barang' => $row->nama_barang,
		'harga_beli' => $row->harga_beli,
		'harga_jual' => $row->harga_jual,
		'wp_suplier_id' => $row->wp_suplier_id,
		'created_at' => $row->created_at,
		'updated_at' => $row->updated_at,
	    );
            $this->load->view('wp_barang/wp_barang_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('wp_barang'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('wp_barang/create_action'),
	    'id' => set_value('id'),
	    'id_barang' => set_value('id_barang'),
	    'nama_barang' => set_value('nama_barang'),
	    'harga_beli' => set_value('harga_beli'),
	    'harga_jual' => set_value('harga_jual'),
	    'wp_suplier_id' => set_value('wp_suplier_id'),
	    'created_at' => set_value('created_at'),
	    'updated_at' => set_value('updated_at'),
	);
        $this->load->view('wp_barang/wp_barang_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'id_barang' => $this->input->post('id_barang',TRUE),
		'nama_barang' => $this->input->post('nama_barang',TRUE),
		'harga_beli' => $this->input->post('harga_beli',TRUE),
		'harga_jual' => $this->input->post('harga_jual',TRUE),
		'wp_suplier_id' => $this->input->post('wp_suplier_id',TRUE),
		'created_at' => $this->input->post('created_at',TRUE),
		'updated_at' => $this->input->post('updated_at',TRUE),
	    );

            $this->Wp_barang_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('wp_barang'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Wp_barang_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('wp_barang/update_action'),
		'id' => set_value('id', $row->id),
		'id_barang' => set_value('id_barang', $row->id_barang),
		'nama_barang' => set_value('nama_barang', $row->nama_barang),
		'harga_beli' => set_value('harga_beli', $row->harga_beli),
		'harga_jual' => set_value('harga_jual', $row->harga_jual),
		'wp_suplier_id' => set_value('wp_suplier_id', $row->wp_suplier_id),
		'created_at' => set_value('created_at', $row->created_at),
		'updated_at' => set_value('updated_at', $row->updated_at),
	    );
            $this->load->view('wp_barang/wp_barang_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('wp_barang'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'id_barang' => $this->input->post('id_barang',TRUE),
		'nama_barang' => $this->input->post('nama_barang',TRUE),
		'harga_beli' => $this->input->post('harga_beli',TRUE),
		'harga_jual' => $this->input->post('harga_jual',TRUE),
		'wp_suplier_id' => $this->input->post('wp_suplier_id',TRUE),
		'created_at' => $this->input->post('created_at',TRUE),
		'updated_at' => $this->input->post('updated_at',TRUE),
	    );

            $this->Wp_barang_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('wp_barang'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Wp_barang_model->get_by_id($id);

        if ($row) {
            $this->Wp_barang_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('wp_barang'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('wp_barang'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('id_barang', 'id barang', 'trim|required');
	$this->form_validation->set_rules('nama_barang', 'nama barang', 'trim|required');
	$this->form_validation->set_rules('harga_beli', 'harga beli', 'trim|required');
	$this->form_validation->set_rules('harga_jual', 'harga jual', 'trim|required');
	$this->form_validation->set_rules('wp_suplier_id', 'wp suplier id', 'trim|required');
	$this->form_validation->set_rules('created_at', 'created at', 'trim|required');
	$this->form_validation->set_rules('updated_at', 'updated at', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "wp_barang.xls";
        $judul = "wp_barang";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Id Barang");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Barang");
	xlsWriteLabel($tablehead, $kolomhead++, "Harga Beli");
	xlsWriteLabel($tablehead, $kolomhead++, "Harga Jual");
	xlsWriteLabel($tablehead, $kolomhead++, "Wp Suplier Id");
	xlsWriteLabel($tablehead, $kolomhead++, "Created At");
	xlsWriteLabel($tablehead, $kolomhead++, "Updated At");

	foreach ($this->Wp_barang_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->id_barang);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_barang);
	    xlsWriteLabel($tablebody, $kolombody++, $data->harga_beli);
	    xlsWriteLabel($tablebody, $kolombody++, $data->harga_jual);
	    xlsWriteNumber($tablebody, $kolombody++, $data->wp_suplier_id);
	    xlsWriteLabel($tablebody, $kolombody++, $data->created_at);
	    xlsWriteLabel($tablebody, $kolombody++, $data->updated_at);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=wp_barang.doc");

        $data = array(
            'wp_barang_data' => $this->Wp_barang_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('wp_barang/wp_barang_doc',$data);
    }

}

/* End of file Wp_barang.php */
/* Location: ./application/controllers/Wp_barang.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-03-06 08:15:05 */
/* http://harviacode.com */