<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Barang_model extends CI_Model
{

    public $table = 'wp_barang';
    public $id = 'id';
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

    function get_all_gudang()
    {
      $this->db->select('wp_barang.*, wp_suplier.*');
      $this->db->join('wp_stok', 'wp_stok.wp_barang_id = wp_barang.id', 'inner');
      $this->db->join('wp_gudang', 'wp_gudang.id = wp_stok.wp_gudang_id', 'inner');
      $this->db->join('wp_suplier', 'wp_suplier.id = wp_barang.wp_suplier_id', 'inner');
      $this->db->where('wp_gudang.username', $this->session->identity);
      return $this->db->get('wp_barang')->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id', $q);
      	$this->db->or_like('id_barang', $q);
      	$this->db->or_like('nama_barang', $q);
      	$this->db->or_like('harga_beli', $q);
      	$this->db->or_like('harga_jual', $q);
        $this->db->or_like('satuan', $q);
      	$this->db->or_like('wp_suplier_id', $q);
      	$this->db->or_like('created_at', $q);
      	$this->db->or_like('updated_at', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
	$this->db->or_like('id_barang', $q);
	$this->db->or_like('nama_barang', $q);
	$this->db->or_like('harga_beli', $q);
	$this->db->or_like('harga_jual', $q);
  $this->db->or_like('satuan', $q);
	$this->db->or_like('wp_suplier_id', $q);
	$this->db->or_like('created_at', $q);
	$this->db->or_like('updated_at', $q);
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
          $this->db->select('RIGHT(wp_barang.id_barang, 2) as kode', FALSE);
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
          $kodejadi = "NB0".$kodemax;    // hasilnya ODJ-9921-0001 dst.
          return $kodejadi;
    }

    function get_coba(){
        $this->db->select("wp_barang.wp_suplier_id,wp_suplier.nama_suplier");
        $this->db->from($this->table);
        $this->db->join('wp_suplier', 'wp_suplier.id = wp_barang.wp_suplier_id');
        $this->db->order_by('wp_suplier_id', $this->order);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->result();
        } else {
          return FALSE;
        }
    }

    function get_data(){
        $this->db->select("wp_barang.id, wp_barang.id_barang, wp_barang.nama_barang, wp_barang.harga_beli, wp_barang.harga_jual, wp_barang.satuan, wp_barang.wp_suplier_id, wp_barang.created_at, wp_barang.updated_at, wp_suplier.nama_suplier, wp_suplier.id_suplier");
        $this->db->from($this->table);
        $this->db->join('wp_suplier', 'wp_suplier.id = wp_barang.wp_suplier_id');
        //$this->db->join('wp_gudang', 'wp_gudang.id = wp_barang.wp_gudang_id');
        $this->db->order_by('id_barang', $this->order);
        return $query = $this->db->get()->result();
    }

    function cek_kode_stok($id){
      $this->db->where('wp_barang_id', $id);
      $cek = $this->db->get('wp_stok');
      if ($cek->num_rows() > 0) {
          return TRUE;
      } else return FALSE;
    }


}

/* End of file Wp_barang_model.php */
/* Location: ./application/models/Wp_barang_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-03-06 08:15:05 */
/* http://harviacode.com */
