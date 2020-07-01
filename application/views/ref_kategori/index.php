<?php
    $this->load->view('template/atas');
?>

<section class="content-header">
    {pesan}
</section>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Kategori
    </h1>
</section>

<!-- Main content -->
<section class="content">
    
<div class="box">
    <div class="box-header with-border">
        <div class="col-lg-3">
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
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {data}
                <tr>
                    <th scope="row">{no}</th>
                    <td>{nama}</td>
                    <td>{deskripsi}</td>
                    <td>{status}</td>
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