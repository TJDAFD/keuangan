<title><?= $title ?></title>
<?= $this->load->view('message') ?>
<script type="text/javascript">
    $(function() {
        get_data_instansi();
        $('.form-control').change(function() {
            if ($(this).val() !== '')  {
                dc_validation_remove($(this));
            }
        });
    });
    
    function reset_form() {
        $('input[type=text], input[type=hidden], input[type=password]').val('');
    }
    
    function konfirmasi_simpan() {
        bootbox.dialog({
          message: "Anda yakin akan menyimpan data ini?",
          title: "Konfirmasi Simpan",
          buttons: {
            batal: {
              label: '<i class="fa fa-refresh"></i> Batal',
              className: "btn-default",
              callback: function() {
                
              }
            },
            ya: {
              label: '<i class="fa fa-check-square-o"></i>  Ya',
              className: "btn-primary",
              callback: function() {
                save_data();
              }
            }
          }
        });
    }
    
    function get_data_instansi() {
        $.ajax({
            type: 'GET',
            url: '<?= base_url('api/configuration/instansi') ?>',
            success: function(data) {
                if (parseFloat(data.jumlah) > 0) {
                    $('#id').val(data.id);
                    $('#nama_instansi').val(data.nama);
                    $('#alamat').val(data.alamat);
                    $('#telp').val(data.telp);
                    $('#fax').val(data.fax);
                    $('#kabikeu').val(data.kabikeu);
                    $('#kaakuntansi').val(data.kaakuntansi);
                }
            }
        });
    }
    
    function save_data() {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('api/configuration/instansi') ?>',
            data: $('#formedit').serialize(),
            success: function(data) {
                if (data.act === 'add') {
                    message_edit_success();
                    get_data_instansi();
                } else {
                    message_add_success();
                    get_data_instansi();
                }
            }
        });
        return false;
    }

</script>
<div class="titling"><h1><?= $title ?></h1></div>
<ol class="breadcrumb">
    <li><a href="#">Home</a></li>
    <li><a href="#">Masterdata</a></li>
    <li class="active"><?= $title ?></li>
</ol>
<div class="kegiatan">
    <div class="col-lg-6">
    <form id="formedit" class="form-horizontal">
        <input type="hidden" name="id" id="id" />
        <div class="form-group">
            <label class="col-lg-4 control-label">Nama Instansi:</label>
            <div class="col-lg-8">
                <input type="text" name="nama_instansi" id="nama_instansi" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-4 control-label">Alamat:</label>
            <div class="col-lg-8">
                <input type="text" name="alamat" id="alamat" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-4 control-label">Telepon:</label>
            <div class="col-lg-8">
                <input type="text" name="telp" id="telp" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-4 control-label">Fax:</label>
            <div class="col-lg-8">
                <input type="text" name="fax" id="fax" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-4 control-label">Ka. Bikeu:</label>
            <div class="col-lg-8">
                <input type="text" name="kabikeu" id="kabikeu" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-4 control-label">Ka. Akuntansi:</label>
            <div class="col-lg-8">
                <input type="text" name="kaakuntansi" id="kaakuntansi" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-4 control-label"></label>
            <div class="col-lg-8">
                <button type="button" class="btn btn-primary" onclick="konfirmasi_simpan();"><i class="fa fa-save"></i> Simpan Perubahan</button>
            </div>
        </div>
    </form>
    </div>
</div>