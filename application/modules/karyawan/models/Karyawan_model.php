<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Karyawan_model extends CI_Model
{

    public $table = 'wp_karyawan';
    public $id = 'id_karyawan';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id_karyawan', $q);
	$this->db->or_like('nama', $q);
	$this->db->or_like('alamat', $q);
	$this->db->or_like('no_telp', $q);
	$this->db->or_like('photo', $q);
	$this->db->or_like('status', $q);
	$this->db->or_like('wp_jabatan_id', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_karyawan', $q);
	$this->db->or_like('nama', $q);
	$this->db->or_like('alamat', $q);
	$this->db->or_like('no_telp', $q);
	$this->db->or_like('photo', $q);
	$this->db->or_like('status', $q);
	$this->db->or_like('wp_jabatan_id', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    function buat_kode(){
          $this->db->select('RIGHT(wp_karyawan.id_karyawan, 2) as kode', FALSE);
          $this->db->order_by($this->id, $this->order);
          $this->db->limit(1);
          $query = $this->db->get($this->table, $this->id);      //cek dulu apakah ada sudah ada kode di tabel.
          if($query->num_rows() <> 0){
           //jika kode ternyata sudah ada.
           $data = $query->row();
           $kode = intval($data->kode) + 1;
          }
          else {
           //jika kode belum ada
           $kode = 1;
          }
          $kodemax = str_pad($kode, 2, "0", STR_PAD_LEFT); // angka 2 menunjukkan jumlah digit angka 0
          $kodejadi = "KR0".$kodemax;    // hasilnya ODJ-9921-0001 dst.
          return $kodejadi;
    }

    function get_data(){
        $this->db->select("wp_karyawan.id_karyawan, wp_karyawan.nama, wp_karyawan.alamat, wp_karyawan.no_telp, wp_karyawan.photo, wp_karyawan.status, wp_karyawan.wp_jabatan_id, wp_jabatan.nama_jabatan");
        $this->db->from($this->table);
        $this->db->join('wp_jabatan', 'wp_jabatan.id = wp_karyawan.wp_jabatan_id');
        $this->db->order_by($this->id, $this->order);
        $query = $this->db->get();
        return $query->result();
    }

    function cek_id_jabatan($id){
      $this->db->where('wp_jabatan_id', $id);
      $cek = $this->db->get('wp_jabatan');
      if ($cek->num_rows() > 0) {
          return TRUE;
      } else return FALSE;
    }
}

/* End of file Wp_karyawan_model.php */
/* Location: ./application/models/Wp_karyawan_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-03-09 07:12:23 */
/* http://harviacode.com */
