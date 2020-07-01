<?php
$this->load->view('template/atas');
?>


<!-- Content Header (Page header) -->

<section class="content-header">
    {pesan}
</section>
<section class="content-header">
</section>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-6 col-xs-6" >
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{transaksi_terakhir}</h3>
                    <p>Pengeluaran Terakhir (jenis: {jenis})</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{saldo}</h3>
                    <p>Saldo</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{total_pemasukan}</h3>
                    <p>Total Pemasukan (all time)</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{total_pengeluaran}</h3>
                    <p>Total Pengeluaran (all time)</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div><!-- ./col -->
    </div><!-- /.row -->
</section><!-- /.content -->


<?php
$this->load->view('template/bawah');
?>      