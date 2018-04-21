<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_laporan extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  function laporan_harian($day)
  {
    $this->db->select('id_transaksi, wp_barang.nama_barang,
      harga, qty, subtotal, tgl_transaksi,
      wp_pelanggan.nama_pelanggan, wp_status.nama_status');
    $this->db->where('wp_transaksi.tgl_transaksi', $day);
    $this->db->join('wp_barang', 'wp_barang.id = wp_transaksi.wp_barang_id', 'inner');
    $this->db->join('wp_pelanggan', 'wp_pelanggan.id = wp_transaksi.wp_pelanggan_id', 'inner');
    $this->db->join('wp_status', 'wp_status.id = wp_transaksi.wp_status_id', 'inner');
    return $this->db->get('wp_transaksi')->result();
  }

  function laporan_bulanan($from, $to, $year)
  {
    $this->db->select('id_transaksi, wp_barang.nama_barang,
      harga, qty, subtotal, tgl_transaksi,
      wp_pelanggan.nama_pelanggan, wp_status.nama_status');
    $this->db->where('month(wp_transaksi.tgl_transaksi) >=', $from);
    $this->db->where('month(wp_transaksi.tgl_transaksi) <=', $to);
    $this->db->where('year(wp_transaksi.tgl_transaksi)', $year);
    $this->db->join('wp_barang', 'wp_barang.id = wp_transaksi.wp_barang_id', 'inner');
    $this->db->join('wp_pelanggan', 'wp_pelanggan.id = wp_transaksi.wp_pelanggan_id', 'inner');
    $this->db->join('wp_status', 'wp_status.id = wp_transaksi.wp_status_id', 'inner');
    return $this->db->get('wp_transaksi')->result();
  }

  function laporan_tahunan($year)
  {
    $this->db->select('id_transaksi, wp_barang.nama_barang,
      harga, qty, subtotal, tgl_transaksi,
      wp_pelanggan.nama_pelanggan, wp_status.nama_status');
    $this->db->where('year(wp_transaksi.tgl_transaksi)', $year);
    $this->db->join('wp_barang', 'wp_barang.id = wp_transaksi.wp_barang_id', 'inner');
    $this->db->join('wp_pelanggan', 'wp_pelanggan.id = wp_transaksi.wp_pelanggan_id', 'inner');
    $this->db->join('wp_status', 'wp_status.id = wp_transaksi.wp_status_id', 'inner');
    return $this->db->get('wp_transaksi')->result();
  }

  function laporan_produk($year, $id_barang)
  {
    $this->db->select('id_transaksi, wp_barang.nama_barang,
      harga, qty, subtotal, tgl_transaksi,
      wp_pelanggan.nama_pelanggan, wp_status.nama_status');
    $this->db->where('year(wp_transaksi.tgl_transaksi)', $year);
    $this->db->where('wp_barang.id', $id_barang);
    $this->db->join('wp_barang', 'wp_barang.id = wp_transaksi.wp_barang_id', 'inner');
    $this->db->join('wp_pelanggan', 'wp_pelanggan.id = wp_transaksi.wp_pelanggan_id', 'inner');
    $this->db->join('wp_status', 'wp_status.id = wp_transaksi.wp_status_id', 'inner');
    return $this->db->get('wp_transaksi')->result();
  }

  function laporan_area($year, $area, $berdasarkan)
  {
    $this->db->select('id_transaksi, wp_barang.nama_barang,
      harga, qty, subtotal, tgl_transaksi,
      wp_pelanggan.nama_pelanggan, wp_status.nama_status');
    $this->db->where('year(wp_transaksi.tgl_transaksi)', $year);
    $this->db->where('wp_pelanggan.'.$berdasarkan, $area);
    $this->db->join('wp_barang', 'wp_barang.id = wp_transaksi.wp_barang_id', 'inner');
    $this->db->join('wp_pelanggan', 'wp_pelanggan.id = wp_transaksi.wp_pelanggan_id', 'inner');
    $this->db->join('wp_status', 'wp_status.id = wp_transaksi.wp_status_id', 'inner');
    return $this->db->get('wp_transaksi')->result();
  }

}