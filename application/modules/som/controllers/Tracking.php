<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Tracking extends CI_Controller {

    private $permit;
    function __construct()
    {
        parent::__construct();
        $this->load->model('Model_tracking','model');
        $this->load->model('pelanggan/Daerah_model','daerah');
        if (!$this->ion_auth->logged_in()) {//cek login ga?
			redirect('login','refresh');
			}else{
					if (!$this->ion_auth->in_group('SOM')) {//cek admin ga?
							redirect('login','refresh');
					}
		}
    }

    function index()
    {
        $data = array(
            'aktif'			=>'Tracking',
            'title'			=>'Brajamarketindo',
            'judul'			=>'Dashboard',
            'sub_judul'	    =>'Tracking',
            'content'		=>'tracking/view',
            'bulan' => $this->model->get_month(),
            'list_kota' => $this->daerah->get_kota(),
            'list_marketing' => $this->model->get_marketing(),
        );
        $data['menu']			= $this->permit[0];
        $data['submenu']		= $this->permit[1];
        $this->load->view('dashboard', $data);
    }

    public function ajax_list()
    {
        $tahun = 'semua';
        if($this->input->post('tahun')){
            $tahun = $this->input->post('tahun');
        }
        $list = $this->model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        $this_month = date('n');
        $warna = $this->input->post('warna');
        
        $temp = array();
        if ($warna == "all") {
            $temp = $this->cekidot($list, $this_month, $tahun);
        } else {
            $temp = $this->cekidotdot($list, $this_month, $tahun, $warna);
        }

        foreach ($temp as $record) {
            $utang = $this->model->laporan_pelanggan_utang($record['id_pelanggan'], $tahun);
            $no++;
            $row = array();
            $row[] = $no;
            $temp = 0;
            
            $row[] = $this->warna($record['warna'], $record['id_pelanggan']);
            $row[] = $this->warna($record['warna'], $record['nama_pelanggan']);
            $row[] = $this->warna($record['warna'], $record['no_telp']);
            $row[] = $this->warna($record['warna'], $record['kota']);
            $row[] = $this->warna($record['warna'], $record['kecamatan']);
            $row[] = $this->warna($record['warna'], $record['kelurahan']);
            $row[] = $this->warna($record['warna'], $record['nama']);
            $row[] = $this->warna($record['warna'], $record['utang']);

            for ($i=1; $i <= 12; $i++) { 
                $count_trx = $this->model->laporan_pelanggan_trx($record['id_pelanggan'], $i, $tahun);
                $count_qty = $this->model->laporan_pelanggan_qty($record['id_pelanggan'], $i, $tahun);
                $row[] = $this->warna($record['warna'], angka($count_trx));
                $row[] = $this->warna($record['warna'], angka($count_qty));
            }
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->model->count_all(),
                        "recordsFiltered" => $this->model->count_filtered(),
                        "data" => $data
                );
        echo json_encode($output);
    }

    function get_jumlah_customer($month, $year)
    {
        $this->db->where('', $Value);
        
    }

    // excel
    function download_excel($year, $kota, $kecamatan, $warna, $id_karyawan)
    {
        $kota =str_ireplace("%20"," ",$kota);
        $kecamatan =str_ireplace("%20"," ",$kecamatan);
        $this->load->helper('exportexcel');
        $namaFile = "tracking_pelanggan.xls";
        $judul = "TrackingPelanggan";
        $tablehead = 6;
        $tablebody = 7;
        $nourut = 1;
        $bulan = $this->model->get_month();
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
        xlsWriteLabel(0, 0, "Laporan");
        xlsWriteLabel(0, 1, "Tracking Pelanggan");

        xlsWriteLabel(1, 0, "Tahun");
        xlsWriteLabel(1, 1, $year);

        xlsWriteLabel(2, 0, "Kota");
        xlsWriteLabel(2, 1, $kota);

        xlsWriteLabel(3, 0, "Kecamatan");
        xlsWriteLabel(3, 1, $kecamatan);

        xlsWriteLabel(4, 0, "Warna");
        xlsWriteLabel(4, 1, $warna);

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
        xlsWriteLabel($tablehead, $kolomhead++, "ID CUSTOMER");
        xlsWriteLabel($tablehead, $kolomhead++, "NAMA CUSTOMER");
        xlsWriteLabel($tablehead, $kolomhead++, "TELPON");
        xlsWriteLabel($tablehead, $kolomhead++, "KOTA");
        xlsWriteLabel($tablehead, $kolomhead++, "KECAMATAN");
        xlsWriteLabel($tablehead, $kolomhead++, "KELURAHAN");
        xlsWriteLabel($tablehead, $kolomhead++, "SURVEYOUR");
        xlsWriteLabel($tablehead, $kolomhead++, "PIUTANG");
        
        $i = 0;
        $j = 1;

        for ($i == 0; $i < 12 ; $i++) {
            if ($i == 0) {
                xlsWriteLabel($tablehead, ($kolomhead++), $bulan[$i]['month']);
            } else {
                xlsWriteLabel($tablehead, (($kolomhead++) + $j), $bulan[$i]['month']);
                $j++;
            }
        }
        $kolomhead = 9;
        
        for ($i = 0; $i < 12; $i++) {
            xlsWriteLabel($tablehead+1, $kolomhead++, 'TRX');
            xlsWriteLabel($tablehead+1, $kolomhead++, 'QTY');
        }
        
        $this_month = date('n');
            
        $tablebody++;
        $list = $this->model->get_laporan_excel($kota, $kecamatan, $id_karyawan);
        $temp = array();
        
        if ($list){
            if ($warna == "all") {
                $temp = $this->cekidot($list, $this_month, $year);
            } else {
                $temp = $this->cekidotdot($list, $this_month, $year, $warna);
            }
            if ($temp) {
                foreach ($temp as $data) {
                    $kolombody = 0;
                    xlsWriteNumber($tablebody, $kolombody++, $nourut);
                    xlsWriteLabel($tablebody, $kolombody++, $data['id_pelanggan']);
                    xlsWriteLabel($tablebody, $kolombody++, $data['nama_pelanggan']);
                    xlsWriteLabel($tablebody, $kolombody++, $data['no_telp']);
                    xlsWriteLabel($tablebody, $kolombody++, $data['kota']);
                    xlsWriteLabel($tablebody, $kolombody++, $data['kecamatan']);
                    xlsWriteLabel($tablebody, $kolombody++, $data['kelurahan']);
                    xlsWriteLabel($tablebody, $kolombody++, $data['nama']);
                    xlsWriteLabel($tablebody, $kolombody++, $data['utang']);
                    for ($i=1; $i <= 12; $i++) { 
                        $trx = $this->model->laporan_pelanggan_trx($data['id_pelanggan'], $i, $year);
                        $qty = $this->model->laporan_pelanggan_qty($data['id_pelanggan'], $i, $year);
        
                        xlsWriteNumber($tablebody, $kolombody++, $trx);
                        xlsWriteNumber($tablebody, $kolombody++, $qty);
                    }
                    $tablebody++;
                    $nourut++;
                }
            }
        }
        xlsEOF();
        exit();
    }

    function tes()
    {
        $list = $this->model->get_laporan_excel('all','all');
        $this_month = date('n');
        $temp = array();
        $warna = 'biru';
        if ($warna == "all") {
            $temp = $this->cekidot($list, $this_month, 2018);
        } else {
            $temp = $this->cekidotdot($list, $this_month, 2018, $warna);
        }
        
        echo "<pre>";
        print_r ($list);
        print_r ($temp);
        echo "</pre>";
        

    }
    
    function warna($color, $value)
    {
        $result = "";
        switch ($color) {
            case 'biru':
                $result = '<span class="label label-biru">'.$value.'</span>';
                break;
            case 'merah' :
                $result = '<span class="label label-merah">'.$value.'</span>';
                break;
            case 'hijau' :
                $result = '<span class="label label-hijau">'.$value.'</span>';
                break;
            case 'kuning' :
                $result = '<span class="label label-kuning">'.$value.'</span>';
                break;
            case 'jingga' :
                $result = '<span class="label label-jingga">'.$value.'</span>';
                break;
            case 'hijau-muda' :
                $result = '<span class="label label-hijau-muda">'.$value.'</span>';
                break;
            case 'orange' :
                $result = '<span class="label label-warning">'.$value.'</span>';
                break;
            default:
                $result = '<span class="label label-default">'.$value.'</span>';
                break;
        }
        return $result;
    }

    function cekidot($list, $this_month, $tahun)
    {
        $temp = array();
        foreach ($list as $record) {
            $a = "";
            $utang = $this->model->laporan_pelanggan_utang($record->id_pelanggan, $tahun);
            $cek = $this->model->laporan_pelanggan_trx($record->id_pelanggan, $this_month, $tahun);
            if ($cek > 0) {
                $temp[] = array(
                    'id_pelanggan' => $record->id_pelanggan,
                    'nama_pelanggan' => $record->nama_pelanggan,
                    'no_telp' => $record->no_telp,
                    'kota' => $record->kota,
                    'kecamatan' => $record->kecamatan,
                    'kelurahan' => $record->kelurahan,
                    'nama' => $record->nama,
                    'utang' => angka($utang),
                    'warna' => 'hijau',
                );
            } else {
                $cek = $this->model->laporan_pelanggan_trx($record->id_pelanggan, $this_month-1, $tahun);
                if ($cek > 0) {
                    $temp[] = array(
                        'id_pelanggan' => $record->id_pelanggan,
                        'nama_pelanggan' => $record->nama_pelanggan,
                        'no_telp' => $record->no_telp,
                        'kota' => $record->kota,
                        'kecamatan' => $record->kecamatan,
                        'kelurahan' => $record->kelurahan,
                        'nama' => $record->nama,
                        'utang' => angka($utang),
                        'warna' => 'biru',
                    );
                } else {
                    $cek = $this->model->laporan_pelanggan_trx($record->id_pelanggan, $this_month-2, $tahun);
                    if ($cek > 0) {
                        $temp[] = array(
                            'id_pelanggan' => $record->id_pelanggan,
                            'nama_pelanggan' => $record->nama_pelanggan,
                            'no_telp' => $record->no_telp,
                            'kota' => $record->kota,
                            'kecamatan' => $record->kecamatan,
                            'kelurahan' => $record->kelurahan,
                            'nama' => $record->nama,
                            'utang' => angka($utang),
                            'warna' => 'kuning',
                        );
                    } else {
                        $cek = $this->model->laporan_pelanggan_trx($record->id_pelanggan, $this_month-3, $tahun);
                        if ($cek > 0) {
                            $temp[] = array(
                                'id_pelanggan' => $record->id_pelanggan,
                                'nama_pelanggan' => $record->nama_pelanggan,
                                'no_telp' => $record->no_telp,
                                'kota' => $record->kota,
                                'kecamatan' => $record->kecamatan,
                                'kelurahan' => $record->kelurahan,
                                'nama' => $record->nama,
                                'utang' => angka($utang),
                                'warna' => 'orange',
                            );
                        } else {
                            $cek = $this->model->laporan_pelanggan_trx($record->id_pelanggan, $this_month-4, $tahun);
                            if ($cek > 0) {
                                $temp[] = array(
                                    'id_pelanggan' => $record->id_pelanggan,
                                    'nama_pelanggan' => $record->nama_pelanggan,
                                    'no_telp' => $record->no_telp,
                                    'kota' => $record->kota,
                                    'kecamatan' => $record->kecamatan,
                                    'kelurahan' => $record->kelurahan,
                                    'nama' => $record->nama,
                                    'utang' => angka($utang),
                                    'warna' => 'jingga',
                                );
                            } else {
                                $temp[] = array(
                                    'id_pelanggan' => $record->id_pelanggan,
                                    'nama_pelanggan' => $record->nama_pelanggan,
                                    'no_telp' => $record->no_telp,
                                    'kota' => $record->kota,
                                    'kecamatan' => $record->kecamatan,
                                    'kelurahan' => $record->kelurahan,
                                    'nama' => $record->nama,
                                    'utang' => angka($utang),
                                    'warna' => 'hijau-muda',
                                );
                            }
                        }
                    }
                }   
            }
        }
        return $temp;
    }

    function cekidotdot($list, $this_month, $tahun, $color)
    {
        $temp = array();
        foreach ($list as $record) {
            $a = "";
            $utang = $this->model->laporan_pelanggan_utang($record->id_pelanggan, $tahun);
            $cek = $this->model->laporan_pelanggan_trx($record->id_pelanggan, $this_month, $tahun);
            if ($cek > 0) {
                if ($color == "hijau") {
                    $temp[] = array(
                        'id_pelanggan' => $record->id_pelanggan,
                        'nama_pelanggan' => $record->nama_pelanggan,
                        'no_telp' => $record->no_telp,
                        'kota' => $record->kota,
                        'kecamatan' => $record->kecamatan,
                        'kelurahan' => $record->kelurahan,
                        'nama' => $record->nama,
                        'utang' => angka($utang),
                        'warna' => 'hijau',
                    );
                }
            } else {
                $cek = $this->model->laporan_pelanggan_trx($record->id_pelanggan, $this_month-1, $tahun);
                if ($cek > 0) {
                    if ($color == "biru") {
                        $temp[] = array(
                            'id_pelanggan' => $record->id_pelanggan,
                            'nama_pelanggan' => $record->nama_pelanggan,
                            'no_telp' => $record->no_telp,
                            'kota' => $record->kota,
                            'kecamatan' => $record->kecamatan,
                            'kelurahan' => $record->kelurahan,
                            'nama' => $record->nama,
                            'utang' => angka($utang),
                            'warna' => 'biru',
                        );
                    }
                } else {
                    $cek = $this->model->laporan_pelanggan_trx($record->id_pelanggan, $this_month-2, $tahun);
                    if ($cek > 0) {
                        if ($color == "kuning") {
                            $temp[] = array(
                                'id_pelanggan' => $record->id_pelanggan,
                                'nama_pelanggan' => $record->nama_pelanggan,
                                'no_telp' => $record->no_telp,
                                'kota' => $record->kota,
                                'kecamatan' => $record->kecamatan,
                                'kelurahan' => $record->kelurahan,
                                'nama' => $record->nama,
                                'utang' => angka($utang),
                                'warna' => 'kuning',
                            );
                        }
                    } else {
                        $cek = $this->model->laporan_pelanggan_trx($record->id_pelanggan, $this_month-3, $tahun);
                        if ($cek > 0) {
                            if ($color == "orange") {
                                $temp[] = array(
                                    'id_pelanggan' => $record->id_pelanggan,
                                    'nama_pelanggan' => $record->nama_pelanggan,
                                    'no_telp' => $record->no_telp,
                                    'kota' => $record->kota,
                                    'kecamatan' => $record->kecamatan,
                                    'kelurahan' => $record->kelurahan,
                                    'nama' => $record->nama,
                                    'utang' => angka($utang),
                                    'warna' => 'orange',
                                );
                            }
                        } else {
                            $cek = $this->model->laporan_pelanggan_trx($record->id_pelanggan, $this_month-4, $tahun);
                            if ($cek > 0) {
                                if ($color == "jingga") {
                                    $temp[] = array(
                                        'id_pelanggan' => $record->id_pelanggan,
                                        'nama_pelanggan' => $record->nama_pelanggan,
                                        'no_telp' => $record->no_telp,
                                        'kota' => $record->kota,
                                        'kecamatan' => $record->kecamatan,
                                        'kelurahan' => $record->kelurahan,
                                        'nama' => $record->nama,
                                        'utang' => angka($utang),
                                        'warna' => 'jingga',
                                    );
                                }
                            } else {
                                if ($color == "hijau-muda") {
                                    $temp[] = array(
                                        'id_pelanggan' => $record->id_pelanggan,
                                        'nama_pelanggan' => $record->nama_pelanggan,
                                        'no_telp' => $record->no_telp,
                                        'kota' => $record->kota,
                                        'kecamatan' => $record->kecamatan,
                                        'kelurahan' => $record->kelurahan,
                                        'nama' => $record->nama,
                                        'utang' => angka($utang),
                                        'warna' => 'hijau-muda',
                                    );
                                }
                            }
                        }
                    }
                }   
            }
        }
        return $temp;
    }

}

/* End of file Tracking.php */
