<div class="row">
  <form action="#" id="form_transaksi3" class="form-horizontal">
  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
    <select name="id_barang" id="id_barang" class="e1 form-control" required>
    <option disabled selected>--Pilih Nama Barang--</option>
        <?php
          $users = $this->db->query("SELECT * FROM wp_barang");
          foreach($users->result() as $value):
          $selected= '';?>
          <option  value="<?php echo $value->id_barang; ?>"  <?php echo $selected;?> >
          <?php echo $value->id_barang; ?> - <?php echo $value->nama_barang; ?>
          </option>
    <?php endforeach ?>
    </select>
  </div>
   
  <input type="hidden" name="id_transaksi" id="id_transaksi" value="<?php echo $id_transaksi; ?>">     
  <?php $this->session->set_userdata('id_transaksi_sess', $id_transaksi) ?>

  <input type="hidden" name="id" id="id" class="form-control">
  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
      <input type="text" name="nama_barang" id="nama_barang" placeholder="Nama Barang" readonly class="form-control">
  </div>
  <div class="col-md-1 col-sm-12 col-xs-12 form-group">
      <input type="number" name="qty" value="1" placeholder="QTY" class="form-control">
  </div>
  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
      <input type="text" name="harga_jual" id="harga_jual" placeholder="Harga" readonly class="form-control">
  </div>
  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
      <input type="text" name="satuan" id="satuan" placeholder="Satuan" readonly class="form-control">
  </div>
  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
      <input type="text" class="form-control" name="diskon" id="diskon" placeholder="input diskon (Rp.)" autocomplete="off" onkeyup="FormatCurrency(this)" >
  </div>
     
    <!-- <input type="hidden" name="id_pelanggan" id="id_pelanggan" value="<?php echo $id_pelanggan; ?>" placeholder="Id Pelanggan" readonly class="form-control">
    <input type="hidden" name="wp_pelanggan_id" id="wp_pelanggan_id" value="<?php echo $wp_pelanggan_id; ?>" placeholder="Pelanggan Id" readonly class="form-control">
    <input type="hidden" name="nama_pelanggan" id="nama_pelanggan" value="<?php echo $nama_pelanggan; ?>" placeholder="Nama Pelanggan" readonly class="form-control">
    <input type="hidden" name="alamat" id="alamat" value="<?php echo $alamat; ?>" placeholder="Alamat" readonly class="form-control">
    <input type="hidden" name="nama_dagang" id="nama_dagang" value="<?php echo $nama_dagang; ?>" placeholder="Nama Dagang" readonly class="form-control">
    <input type="hidden" name="no_telp" id="no_telp" value="<?php echo $no_telp; ?>" placeholder="No Telp" readonly class="form-control">
    <input type="hidden" name="bayar" id="bayar" value="<?php echo $bayar; ?>" placeholder="Bayar" readonly class="form-control"> -->

  <div class="col-md-12 col-sm-12 col-xs-12 form-group text-right">
      <button type="button"  class="add_cart3 btn btn-success"><i class="fa fa-shopping-cart"></i> Tambah</button>
  </div>

</form>
</div>
  <div class="row">
        <div class="col-md-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Transaksi <small>Braja Marketindo</small></h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Settings 1</a>
                    </li>
                    <li><a href="#">Settings 2</a>
                    </li>
                  </ul>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <section class="content invoice">
                <!-- title row -->
                <!-- Table row -->
                <div class="row">
                  <div class="col-md-12 col-xs-12 table-responsive">
                    <table class="table table-striped jambo_table dt-responsive nowrap">
                      <thead>
                        <tr>
                          <th>ID Produk</th>
                          <th>Product</th>
                          <th>Harga (Rp.)</th>
                          <th>QTY</th>
                          <th>Satuan</th>
                          <th>Diskon (Rp.)</th>
                          <th>Subtotal (Rp.)</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody id="detail_cart3">
                      </tbody>
                    </table>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
                <!-- this row will not appear when printing -->
                <div class="row no-print">
                  <form method="POST" action="<?php echo site_url('transaksi/checkout');?>">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <button type="submit" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Checkout</button>
                    <button type="button" class="hapus_cart3 btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-upload"></i> Hapus Semua</button>
                  </div>
                  <form>
                </div>
              </section>
            </div>
          </div>
        </div>
      </div>
