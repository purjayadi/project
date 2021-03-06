<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Muat_model extends CI_Model
{

    public $table = 'wp_debt_muat';
    public $id = 'wp_debt_muat.id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        $this->db->select('wp_debt_muat.*, wp_barang.id_barang, wp_barang.nama_barang, wp_gudang.nama_gudang');
        $this->db->join('wp_barang', 'wp_barang.id = wp_debt_muat.wp_barang_id', 'inner');
        $this->db->join('wp_gudang', 'wp_gudang.id = wp_debt_muat.wp_gudang_id', 'inner');
        $this->db->where('wp_debt_muat.username', $this->session->identity);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        $this->db->select('wp_debt_muat.*, wp_barang.id_barang, wp_barang.nama_barang, wp_gudang.nama_gudang');
        $this->db->join('wp_barang', 'wp_barang.id = wp_debt_muat.wp_barang_id', 'inner');
        $this->db->join('wp_gudang', 'wp_gudang.id = wp_debt_muat.wp_gudang_id', 'inner');
        $this->db->where('wp_debt_muat.username', $this->session->identity);
        return $this->db->get($this->table)->row();
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

    function get_barang()
    {
      return $this->db->get('wp_barang')->result();
    }

    function get_gudang()
    {
      return $this->db->get('wp_gudang')->result();
    }

}

/* End of file Muat_model.php */
/* Location: ./application/models/Muat_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-04-12 08:06:03 */
/* http://harviacode.com */
