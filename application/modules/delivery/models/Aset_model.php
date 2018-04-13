<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aset_model extends CI_Model
{

    public $table = 'wp_asis_debt';
    public $id = 'wp_asis_debt.id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->select('wp_asis_debt.*, wp_pelanggan.id as `id_pel`, wp_pelanggan.nama_pelanggan');
        $this->db->order_by($this->id, $this->order);
        $this->db->join('wp_pelanggan', 'wp_pelanggan.id = wp_asis_debt.wp_pelanggan_id', 'left');
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        $this->db->select('wp_asis_debt.*, wp_pelanggan.id as `id_pel`, wp_pelanggan.nama_pelanggan');
        $this->db->join('wp_pelanggan', 'wp_pelanggan.id = wp_asis_debt.wp_pelanggan_id', 'inner');
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('wp_asis_debt.id', $q);
      	$this->db->or_like('tanggal', $q);
      	$this->db->or_like('jam', $q);
      	$this->db->or_like('turun_krat', $q);
      	$this->db->or_like('turun_btl', $q);
      	$this->db->or_like('naik_krat', $q);
      	$this->db->or_like('naik_btl', $q);
      	$this->db->or_like('aset_krat', $q);
      	$this->db->or_like('aset_btl', $q);
      	$this->db->or_like('bayar', $q);
      	$this->db->or_like('wp_asis_debt.keterangan', $q);
      	$this->db->or_like('username', $q);
      	$this->db->or_like('wp_pelanggan_id', $q);
        $this->db->select('wp_asis_debt.*, wp_pelanggan.id as `id_pel`, wp_pelanggan.nama_pelanggan');
        $this->db->join('wp_pelanggan', 'wp_pelanggan.id = wp_asis_debt.wp_pelanggan_id', 'inner');
      	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('wp_asis_debt.id', $q);
      	$this->db->or_like('tanggal', $q);
      	$this->db->or_like('jam', $q);
      	$this->db->or_like('turun_krat', $q);
      	$this->db->or_like('turun_btl', $q);
      	$this->db->or_like('naik_krat', $q);
      	$this->db->or_like('naik_btl', $q);
      	$this->db->or_like('aset_krat', $q);
      	$this->db->or_like('aset_btl', $q);
      	$this->db->or_like('bayar', $q);
      	$this->db->or_like('wp_asis_debt.keterangan', $q);
      	$this->db->or_like('username', $q);
      	$this->db->or_like('wp_pelanggan_id', $q);
        $this->db->select('wp_asis_debt.*, wp_pelanggan.id as `id_pel`, wp_pelanggan.nama_pelanggan');
        $this->db->join('wp_pelanggan', 'wp_pelanggan.id = wp_asis_debt.wp_pelanggan_id', 'inner');
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

    // get data Pelanggan
    function get_pelanggan()
    {
      return $this->db->get('wp_pelanggan')->result();
    }

}

/* End of file Aset_model.php */
/* Location: ./application/models/Aset_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-04-12 04:37:16 */
/* http://harviacode.com */