<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Debt_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    function get_month()
    {
        $month = array(
            array ('key' => 1, 'month' => 'Januari'),
            array ('key' => 2, 'month' => 'Februari'),
            array ('key' => 3, 'month' => 'Maret'),
            array ('key' => 4, 'month' => 'April'),
            array ('key' => 5, 'month' => 'Mei'),
            array ('key' => 6, 'month' => 'Juni'),
            array ('key' => 7, 'month' => 'Juli'),
            array ('key' => 8, 'month' => 'Agustus'),
            array ('key' => 9, 'month' => 'September'),
            array ('key' => 10, 'month' => 'Oktober'),
            array ('key' => 11, 'month' => 'November'),
            array ('key' => 12, 'month' => 'Desember'),
        );
        return $month;
    }

    function get_customer_jadwal($date, $id_karyawan)
    {
        $this->db->select('count(id) as t');
        $this->db->where('DATE(start)', $date);
        if($id_karyawan != 'semua')
        {
            $this->db->where('wp_karyawan_id_karyawan', $id_karyawan);
        }
        $this->db->from('wp_jadwal');
        $count = $this->db->get()->row();
        return $count->t;
        
    }

    function get_customer_actual($date, $id_karyawan)
    {
        $this->db->select('count(wp_transaksi.id) as t');
        if($id_karyawan != 'semua')
        {
            $this->db->join('wp_pelanggan', 'wp_pelanggan.id = wp_transaksi.wp_pelanggan_id', 'inner');
            $this->db->where('wp_pelanggan.wp_karyawan_id_karyawan', $id_karyawan);
        }
        $this->db->where('DATE(wp_transaksi.tgl_transaksi)', $date);
        $this->db->from('wp_transaksi');
        $count = $this->db->get()->row();
        return $count->t;
    }

    function get_barang($date, $id_karyawan)
    {
        $this->db->select('
        (muat_krat + muat_dust) as muat,
        (terkirim_krat + terkirim_btl) as terkirim,
        (kembali_krat + kembali_btl) as kembali, retur_krat
        ');
        if($id_karyawan != 'semua')
        {
            $this->db->where('username', $id_karyawan);
        }
        $this->db->where('DATE(created_at)', $date);
        $result = $this->db->get('wp_debt_muat')->row();
        $resArray = array();
        if ($result) {
            $resArray = array(
                'muat' => $result->muat,
                'terkirim' => $result->terkirim,
                'kembali' => $result->kembali,
                'return' => $result->retur_krat,
                'rusak' => 0,
            );
        } else {
            $resArray = array(
                'muat' => 0,
                'terkirim' => 0,
                'kembali' => 0,
                'return' => 0,
                'rusak' => 0,
            );
        }
        return $resArray;
    }
    
    function get_target()
    {
        $this->db->select('target');
        $this->db->where('nama', 'Debt');
        $result = $this->db->get('wp_target')->row();
        return $result->target;
    }

    function get_qty($date, $id_karyawan)
    {
        $this->db->select('count(qty) as t');
        $this->db->where('DATE(tgl_transaksi)', $date);
        if($id_karyawan != 'semua')
        {
            $this->db->join('wp_pelanggan', 'wp_pelanggan.id = wp_transaksi.wp_pelanggan_id', 'inner');
            $this->db->where('wp_pelanggan.wp_karyawan_id_karyawan', $id_karyawan);
        }
        $this->db->from('wp_transaksi');
        $count = $this->db->get()->row();
        return $count->t;
    }

    function get_penarikan($date, $id_karyawan)
    {
        $this->db->select('wp_penarikan.bayar_krat as krat, wp_penarikan.bayar_uang as value');
        $this->db->where('tgl_penarikan', $date);
        if($id_karyawan != 'semua')
        {
            $this->db->join('wp_asis_debt', 'wp_asis_debt.id = wp_penarikan.wp_asis_debt_id', 'inner');
            $this->db->where('wp_asis_debt.username', $id_karyawan);
        }
        $this->db->from('wp_penarikan');
        $result = $this->db->get()->row();
        $resArray = array();
        if ($result) {
            $cek = strpos($result->krat,'.');
            $botol = 0;
            $krat = 0;
            if ($cek) {
                $result->krat -= 0.5;
                $botol = 12;
            }
            $resArray = array(
                'krat' => $result->krat,
                'botol' => $botol,
                'value' => $result->value,
            );
        } else {
            $resArray = array(
                'krat' => 0,
                'botol' => 0,
                'value' => 0,
            );
        }
        return $resArray;
    }

    

}

/* End of file Debt_model.php */
