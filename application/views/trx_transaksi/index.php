<?php
    $this->load->view('template/atas');
?>

<section class="content-header">
    {pesan}
</section>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Transaksi
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <!--filter data-->
    <div class="row">
        <div class="col-lg-4 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <div class="box-body">  
                        <form role="form" action="{url_cari}" method="POST">
                            <div class="box-body">
                                <div class="form-group">
                                    <label >Nama</label>
                                    <input type="text" class="form-control" name="cari[nama]" placeholder="nama" value="{nama}">
                                </div>
                                <div class="form-group">
                                    <label >Jenis</label>
                                    <select name="cari[id_kategori]" class="form-control">
                                        <option value="">pilih</option>
                                        {ref_kategori}
                                        <option value="{id}" {selected}>{nama}</option>
                                        {/ref_kategori}
                                      </select>
                                </div>
                                <div class="form-group">
                                    <label >Awal</label>
                                    <input type="date" class="form-control" name="cari[awal]" placeholder="awal" value="{awal}">
                                </div>
                                <div class="form-group">
                                    <label >Akhir</label>
                                    <input type="date" class="form-control" name="cari[akhir]" placeholder="akhir" value="{akhir}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-4 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <div class="box-body">  
                            <div class="box-body">
                                <div class="form-group">
                                    <label >Total</label>
                                    <input type="text" class="form-control" disabled value="{total}">
                                </div>
                                <div class="form-group">
                                    <label >Total Penambahan</label>
                                    <input type="text" class="form-control" disabled value="{total_penambahan}">
                                </div>
                                <div class="form-group">
                                    <label >Total Pengurangan</label>
                                    <input type="text" class="form-control" disabled value="{total_pengurangan}">
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div><!-- ./col -->
    </div>
    <!--end filter data-->

    <div class="box">
        <div class="box-header with-border">
            <div class="col-lg-2 ">
                <a href="{url_add}"><button type="button" class="btn btn-block btn-default ">Tambah</button></a>
            </div>
            <div class="box-tools">
                    total data: {total_data}
                <?php 
                    echo $this->pagination->create_links();
                ?>
            </div>
        </div>
        <div class="box-body table-responsive">  
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Jenis Kategori</th>
                        <th scope="col">Nominal</th>
                        <th scope="col">Status</th>
                        <th scope="col">Insert</th>
                        <th scope="col">Update</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {data}
                    <tr>
                        <th scope="row">{no}</th>
                        <td>{nama}</td>
                        <td>{deskripsi}</td>
                        <td>{jenis}</td>
                        <td>{nominal_label}</td>
                        <td>{status}</td>
                        <td>{insert_time}</td>
                        <td>{update_time}</td>
                        <td>{aksi}</td>
                    </tr>
                    {/data}
                    <?php
                        if(empty($data)){
                            echo '
                                <tr>
                                    <th rowspan="99">Data Kosong</td>
                                </tr>
                            ';
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="box-footer">
        </div>
    </div><!-- /.box -->
    

</section><!-- /.content -->


<?php
$this->load->view('template/bawah');
?>