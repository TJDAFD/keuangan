<title><?= $title ?></title>
<?= $this->load->view('message') ?>
<script type="text/javascript">
    $(function() {
        $('.form-control').change(function() {
            if ($(this).val() !== '')  {
                dc_validation_remove($(this));
            }
        });
    });
    
    function reset_form() {
        $('input[type=text], input[type=hidden], input[type=password]').val('');
    }
    
    function save_data() {
        var passlama = $('#passlama').val();
        var passbaru = $('#passbaru').val();
        var passconf = $('#passconfirm').val();
        if (passlama === '') {
            dc_validation('#passlama','Password lama tidak boleh kosong !'); return false;
        }
        if (passbaru === '') {
            dc_validation('#passbaru','Password baru tidak boleh kosong !'); return false;
        }
        if (passconf === '') {
            dc_validation('#passconf','Password konfirmasi tidak boleh kosong !'); return false;
        }
        if (passbaru !== passconf) {
            dc_validation('#passbaru','Password baru dan password konfirmasi tidak sama!'); 
            dc_validation('#passconfirm','Password baru dan password konfirmasi tidak sama!');
            return false;
        }
        $.ajax({
            url: '<?= base_url('masterdata/save_ubah_password') ?>',
            type: 'POST',
            dataType: 'json',
            data: $('#formedit').serialize(),
            success: function(data) {
                if (data.status === true) {
                    message_edit_success();
                    reset_form();
                } else {
                    message_edit_failed();
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
    <li class="active">Ubah Password</li>
</ol>
<div class="kegiatan">
    <div class="col-lg-6">
    <form id="formedit" class="form-horizontal">
        <div class="form-group">
            <label class="col-lg-4 control-label">Password Lama:</label>
            <div class="col-lg-8">
                <input type="password" name="passlama" id="passlama" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-4 control-label">Password Baru:</label>
            <div class="col-lg-8">
                <input type="password" name="passbaru" id="passbaru" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-4 control-label">Password Confirm:</label>
            <div class="col-lg-8">
                <input type="password" name="passconfirm" id="passconfirm" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-4 control-label"></label>
            <div class="col-lg-8">
                <button type="button" class="btn btn-primary" onclick="save_data();"><i class="fa fa-save"></i> Ubah Password</button>
                <button type="button" class="btn"><i class="fa fa-refresh"></i> Reset Data</button>
            </div>
        </div>
    </form>
    </div>
</div>