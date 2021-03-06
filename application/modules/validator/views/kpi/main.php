<div class="x_panel">
  <div class="x_title">
    <h2>Activity</h2>
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
      <form action="#" id="form-tracking">
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
          <div class="input-group">
            <span class="input-group-addon">Bulan <img id="loading" src="<?=base_url();?>assets/ajax-loader.gif" alt="" style="text-align:center; display:none"></span>
            <select class="form-control" id="bulan-eff">
              <option value="semua">--Pilih Bulan --</option>
              <?php $i = 1; foreach ($month as $key): ?>
                <option value="<?php echo $i++;?>"><?php echo $key?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="col-lg-9 col-md-4 col-sm-6 col-xs-12 text-right">
          <button type="button" id="btn-filter-eff" class="btn btn-success"><i class="fa fa-search"></i> Filter</button>
          <button type="button" id="btn-reset-eff" class="btn btn-info"><i class="fa fa-refresh"></i> Reload</button>
        </div>
      </form>
    </div>

    <div class="table-responsive">
      <table class="table table-striped jambo_table table-bordered nowrap">
        <thead>
            <tr>
                <th rowspan = 3 class="wider_kecamatan text-center">Tanggal</th>
                <th colspan = 21 class="text-center">ACTIFITY</th>
                <th colspan = <?php echo $count_barang ?> class="text-center">Nama Barang</th>
                <th rowspan = 3 class="wider_kecamatan text-center">Jumlah</th>
            </tr>
            <tr>
              <th colspan = 3 class="text-center">Due Date</th>
              <th colspan = 3 class="text-center">Hijau</th>
              <th colspan = 3 class="text-center">Biru</th>
              <th colspan = 3 class="text-center">Kuning</th>
              <th colspan = 3 class="text-center">Orange</th>
              <th colspan = 3 class="text-center">Jingga</th>
              <th colspan = 3 class="text-center">Hijau Muda</th>
              <?php foreach ($barang as $key) {?>
                    <th rowspan = 3 class="wider_kecamatan"><?php echo $key->nama_barang ?></th>
              <?php } ?>
            </tr>
            <tr>
              <?php for ($i = 0 ; $i < 7 ; $i++): ?>
                <th>TO</th>
                <th>STOK</th>
                <th>FOLLOW UP</th>
              <?php endfor ?>
            </tr>
          </thead>
          <tbody id="tbody-kpi-val">
          </tbody>
      </table>
    </div>

  </div>
</div>
