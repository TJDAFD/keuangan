<script type="text/javascript">
    $(function() {
        get_user_list(1);
        $('#add-user-account').click(function() {
            $('#datamodal_user_account').modal('show');
            $('#datamodal_user_account #modal_title').html('Tambah Pengguna Sistem');
            reset_form();
        });
        
        $('#reset-user-account').click(function() {
            get_user_list(1);
        });
        
        $('.form-control').change(function() {
            if ($(this).val() !== '') {
                dc_validation_remove(this);
            }
        });
    });
    
    function save_data_user_account() {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('api/masterdata/user_account') ?>',
            data: $('#save_user_account').serialize(),
            dataType: 'json',
            success: function(data) {
                var page = $('.noblock').html();
                if (data.status === true) {
                    if (data.act === 'add') {
                        message_add_success();
                        get_user_list(1, data.id);
                        reset_form();
                    } else {
                        $('#datamodal_user_account').modal('hide');
                        message_edit_success();
                        get_user_list(page);
                    }
                }
            }
        });
    }
    
    function get_user_list(p){
        $.ajax({
            type : 'POST',
            url: '<?= base_url('masterdata/manage_user') ?>/list/'+p,
            data: $('#form').serialize(),
            cache: false,
            success: function(data) {
                $('#user_list').html(data);
            }
        });
    }

    function edit_user(str){
        var arr = str.split('#');
        $('#datamodal_user_account').modal('show');
        $('#datamodal_user_account #modal_title').html('Edit Pengguna Sistem');
        $('#nama').val(arr[2]);
        $('#username').val(arr[1]);
        $('#group-user').val(arr[3]);
        $('#id_user_account').val(arr[0]);
    }
    
    function confirm_save_user_account() {
        if ($('#nama').val() === '') {
            dc_validation('#nama','Nama user tidak boleh kosong !'); return false;
        }
        if ($('#username').val() === '') {
            dc_validation('#username','Username tidak boleh kosong !'); return false;
        }
        if ($('#group-user').val() === '') {
            dc_validation('#group-user','Group user harus dipilih !'); return false;
        }
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
                save_data_user_account();
              }
            }
          }
        });
    }

    function delete_user(id){  
        bootbox.dialog({
          message: "Anda yakin akan menghapus data ini?",
          title: "Hapus Data",
          buttons: {
            batal: {
              label: '<i class="fa fa-refresh"></i> Batal',
              className: "btn-default",
              callback: function() {
                
              }
            },
            hapus: {
              label: '<i class="fa fa-trash-o"></i>  Ya',
              className: "btn-primary",
              callback: function() {
                $.ajax({
                    type : 'DELETE',
                    url: '<?= base_url('api/masterdata/user_account') ?>/id/'+id,
                    cache: false,
                    success: function(data) {
                        var page = $('.noblock').html();
                        get_user_list(page);
                        message_delete_success();
                    }
                });
              }
            }
          }
        });
    }

    function resetpassword(id, str) {
        bootbox.dialog({
          message: "Anda yakin akan mereset password menjadi 1234?",
          title: "Konfirmasi Reset Password",
          buttons: {
            batal: {
              label: '<i class="fa fa-refresh"></i> Batal',
              className: "btn-default",
              callback: function() {
                
              }
            },
            hapus: {
              label: '<i class="fa fa-unlock"></i>  Ya',
              className: "btn-primary",
              callback: function() {
                $.ajax({
                    type : 'GET',
                    url: '<?= base_url('masterdata/manage_user') ?>/reset_password/'+$('.noblock').html(),
                    data :'id='+id,
                    success: function(data) {
                        get_user_list($('.noblock').html());
                        message_edit_success();
                    }
                });
              }
            }
          }
        });
    }


</script>
<?php 
    $session =  $this->session->userdata('access'); 
    if (!empty($session)) {
        $access = explode('-', $session);
    }
?>
<?php if (isset($access[0]) and $access[0] === '1') { ?>
<button id="add-user-account" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah User</button>
<?php } ?>
<button id="reset-user-account" class="btn"><i class="fa fa-refresh"></i> Reload Data</button>
<div id="user_list"></div>
<div id="datamodal_user_account" class="modal fade">
    <div class="modal-dialog" style="width: 600px;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="modal_title"></h4>
        </div>
        <div class="modal-body">
        <form id="save_user_account" class="form-horizontal" role="form">
            <input type="hidden" name="id_user_account" id="id_user_account" />
            <div class="form-group">
                <label class="col-lg-3 control-label">Nama:</label>
                <div class="col-lg-8">
                    <?= form_input('nama', NULL, 'id=nama class="form-control"') ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">Username:</label>
                <div class="col-lg-8">
                    <?= form_input('username', NULL, 'id=username class="form-control"') ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">User Group</label>
                <div class="col-lg-8">
                    <select name="group" id="group-user" class="form-control"><option value="">Pilih ...</option><?php foreach ($user_group as $data) { ?><option value="<?= $data->id ?>"><?= $data->nama ?></option><?php } ?></select>
                </div>
            </div>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Batal</button>
          <button type="button" class="btn btn-primary" id="save" onclick="confirm_save_user_account();"><i class="fa fa-save"></i> Simpan</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->