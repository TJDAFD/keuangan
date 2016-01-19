<?php $this->load->view('message') ?>
<title><?= $title ?></title>
    <script type="text/javascript">
        $(function() {
            get_group_list(1);
            $('#add-user-group').click(function() {
                reset_form();
                $('#datamodal').modal('show');
                $('#datamodal h4.modal-title').html('Tambah group user');
            });
            $('#reset-user-group').click(function() {
                reset_form();
                get_group_list(1);
            });
            $('#simpan').click(function(){
                $('#form_group').submit();
            });
            
            $('#all').click(function(){
                $(".check").each( function() {
                    $(this).attr("checked",'checked');
                });
            }).click(function() {
                $('input[type=checkbox]').attr('checked','checked');
            });
            
            $('.form-control').change(function() {
                if ($(this).val() !== '') {
                    dc_validation_remove(this);
                }
            });
            
            $('#uncek').click(function(){
                $('input[type=checkbox]').removeAttr('checked');
            });
            
            $('input[type=checkbox]').live("change",function(){
                var target = $(this).next('input[type=hidden]').val();
                var targ = 0;
                if(target === '0') {
                    targ = 1;
                }
                $(this).next('input[type=hidden]').val(targ);
            });
        });
        
        function confirm_save_group() {
            if ($('#nama_group').val() === '') {
                dc_validation('#nama_group','Nama group tidak boleh kosong !'); return false;
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
                      save_data();
                    }
                  }
                }
            });
        }
        
        function save_data() {
            var Url = '<?= base_url("masterdata/manage_group") ?>/post/';
            var id = $('input[name=id]').val();
            $.ajax({
                type : 'POST',
                url: Url+$('.noblock').html(),               
                data: $('#form_group').serialize(),
                cache: false,
                success: function(data) {
                    var page = $('.noblock').html();
                    if (id === '') {
                        message_add_success();
                        reset_form();
                        get_group_list(1, data);
                    } else {
                        message_edit_success();
                        get_group_list(page);
                        $('#datamodal').modal('hide');
                    }
                }
            });
        }
        
        function edit_privileges(id, nama) {
            $('#datamodal-privileges').modal('show');
            $('#datamodal-privileges h4.modal-title').html('Edit Privileges');
            get_privileges_list(id);
            $('#nama_group_priv').html(nama);
            $('input[name=id_group]').val(id);
        }
        
        function save_data_privileges() {
            $.ajax({
                type : 'POST',
                url: '<?= base_url('api/masterdata/grant_privileges') ?>',
                data: $('#form_priv').serialize(),
                cache: false,
                success: function(data) {
                    if (data.status === true) {
                        message_edit_success();
                    }
                },
                error: function() {
                    message_edit_failed();
                }
            });
        }
        
        function reset_form() {
            $('input[type=text], input[type=hidden], select, textarea').val('');
        }
    
        function reset_group(){
            $('#loaddata').load('<?= base_url('masterdata/account') ?>');
        }
    
        function get_group_list(p){
            $.ajax({
                type : 'POST',
                url: '<?= base_url("masterdata/manage_group") ?>/list/'+p,
                data: $('#form_group').serialize(),
                cache: false,
                success: function(data) {
                    $('#group_list').html(data);
                }
            });
        }
    
        function get_privileges_list(id){
            $.ajax({
                type : 'GET',
                url: '<?= base_url("masterdata/manage_privileges") ?>/list',
                data :'id='+id,
                cache: false,
                success: function(data) {
                    $('#list').html(data);
                    //reset_group();
                }
            });
        }
        function edit_group(id,nama){
            $('#datamodal').modal('show');
            $('#datamodal h4.modal-title').html('Edit User Group');
            $('#id').val(id);
            $('#nama_group').val(nama);
        }
    
    function delete_group(id){
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
                    type : 'GET',
                    url: '<?= base_url("masterdata/manage_group") ?>/delete/'+$('.noblock').html(),
                    data :'id='+id,
                    cache: false,
                    success: function(data) {
                        var page = $('.noblock').html();
                        get_group_list(page);
                        message_delete_success();
                    }
                });
              }
            }
          }
        });
    }
        
        
        
        
    </script>
    <button id="add-user-group" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah User Group</button>
    <button id="reset-user-group" class="btn btn-default"><i class="fa fa-refresh"></i> Reload Data</button>
    <div id="group_list"></div>

    <div id="datamodal" class="modal fade">
    <div class="modal-dialog" style="width: 600px;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="modal_title"></h4>
        </div>
        <div class="modal-body">
        <form action="" id="form_group" role="form" class="form-horizontal">
            <input type="hidden" id="id" name="id" />
            <div class="form-group">
                <label class="col-lg-3 control-label">Nama Group:</label>
                <div class="col-lg-8">
                    <input type="text" name="nama_group" id="nama_group" class="form-control" />
                </div>
            </div>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Batal</button>
          <button type="button" class="btn btn-primary" id="save" onclick="confirm_save_group();"><i class="fa fa-save"></i> Simpan</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
    <div id="datamodal-privileges" class="modal fade">
    <div class="modal-dialog" style="width: 90%;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="modal_title"></h4>
        </div>
        <div class="modal-body">
            <button class="btn btn-primary" id="all"><i class="fa fa-check-square-o"></i> Check All</button>
            <button class="btn btn-primary" id="uncek"><i class="fa fa-square-o"></i> Uncheck All</button>
        <form action="" id="form_priv" role="form" class="form-horizontal">
            <br/>
            <?= form_hidden('id_group', '') ?>
            <table width="100%" class="table table-striped">
                <tr><td width="20%">Nama Profesi:</td><td id="nama_group_priv"></td> </tr>
            </table>
            <div id="list"></div>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Batal</button>
          <button type="button" class="btn btn-primary" id="save" onclick="save_data_privileges();"><i class="fa fa-save"></i> Simpan</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
