<?php
    $this->load->view('template/atas');
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Form Transaksi
    </h1>
</section>

<!-- Main content -->
<section class="content">
    
<div class="box">
    <div class="box-header with-border">
    </div>
    <div class="box-body">  
        <form role="form" action="{url_save}" method="POST">
            <input type="hidden" class="form-control" id="id" name="id" value="{id}" >
            <div class="box-body">
                <div class="form-group">
                    <label >Jenis</label>
                    <select name="id_kategori" class="form-control">
                        <option value="">pilih</option>
                        {ref_kategori}
                        <option value="{id}" {selected}>{nama}</option>
                        {/ref_kategori}
                    </select>
                </div>
                <div class="form-group">
                    <label >Nama</label>
                    <input required type="text" class="form-control" id="nama" name="nama" placeholder="Nama" value="{nama}">
                </div>
                <div class="form-group">
                    <label >Deskripsi</label>
                    <textarea required class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi" >{deskripsi}</textarea>
                </div>
                <div class="form-group">
                    <label >Nominal</label>
                    <input type="number" require min="0" class="form-control" id="nominal" name="nominal" placeholder="Nominal" value="{nominal}">
                </div>
                <div class="form-group">
                    <label >Pengurang</label>
                    <input class="form-check-input position-static" type="checkbox" id="is_pengurangan" name="is_pengurangan" value="1" {status_pengurangan} aria-label="...">
                </div>
            </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <button type="reset" class="btn btn-default">Reset</button>
          <button type="submit" class="btn btn-primary">Submit</button>
          <hr >
          <p>nb* Bila Kategori tersebut dijadikan Penambah Uncheck (Pengurangan)</p>
        </div>
        </form>
    </div>
    <div class="box-footer">
    </div>
</div><!-- /.box -->
    

</section><!-- /.content -->


<?php
$this->load->view('template/bawah');
?>