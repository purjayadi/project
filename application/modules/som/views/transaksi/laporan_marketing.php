


<div class="x_panel">
  <div class="x_title">
    <h2>Laporan Transaksi <small>Per Produk</small></h2>
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
    <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="input-group">
          <span class="input-group-addon">Tahun </span>
          <select class="form-control" id="tahun-marketing">
            <?php for ($tahun=(date('Y')-4); $tahun <= date('Y'); $tahun++) {
              echo '<option selected value="'.$tahun.'">'.$tahun.'</option>';
            } ?>
          </select>
        </div>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="input-group">
          <span class="input-group-addon">Berdasarkan </span>
          <select class="form-control" id="berdasarkan-marketing">
            <option value="semua">Semua Marketing</option>
            <option value="marketing">Per Marketing</option>
          </select>
        </div>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="input-group">
          <span class="input-group-addon">Nama Marketing <img id="loading-combo" src="<?=base_url();?>assets/ajax-loader.gif" alt="" style="text-align:center; display:none"></span>
          <select class="form-control" id="nama-marketing">
            <option value="semua">Semua</option>
          </select>
        </div>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <button type="button" class="btn btn-success" id="btn-marketing"><i class="fa fa-search"></i> Search</button>
        <img id="loading" src="<?=base_url();?>assets/ajax-loader.gif" alt="" style="text-align:center; display:none">
        <button type="button" id="excel_marketing" class="btn btn-primary"><i class="fa fa-download"></i> Excel</button>
        <button type="button" id="btn-refresh" class="btn btn-info"><i class="fa fa-refresh fa-spin"></i> Reload</button>
      </div>
    </div>
    <div class="table-responsive">
      <table id="datatable-buttons_wrapper" class="table table-striped jambo_table table-bordered dt-responsive nowrap">
          <thead>
            <tr>
              <th>No</th>
              <th>No Faktur</th>
              <th>Tgl Kirim</th>
              <th>Jatuh Tempo</th>
              <th>ID Pelanggan</th>
              <th>Nama Pelanggan</th>
              <th>Nama Barang</th>
              <th>QTY</th>
              <th>Satuan</th>
              <th>Kota</th>
              <th>Kecamatan</th>
              <th>Kelurahan</th>
              <th>No Telpon</th>
              <th>Surveyor</th>
              <th>Debt</th>
              <th>Jumlah</th>
            </tr>
          </thead>
          <tbody id="tbody">

          </tbody>
      </table>
    </div>
  </div>
</div>
