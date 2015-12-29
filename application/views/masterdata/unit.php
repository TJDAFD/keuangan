<title><?= $title ?></title>
<?= $this->load->view('message') ?>
<script type="text/javascript">
    $(function() {
        $('#tabs').tabs();
        get_list_unit(1);
        $('#add_unit').click(function() {
            reset_form();
            $('#datamodal').modal('show');
            $('#datamodal h4').html('Tambah Data Unit Satuan Kerja');
        });

        $('#reload_unit').click(function() {
            get_list_unit();
        });
        
        $('.form-control').change(function() {
            if ($(this).val() !== '')  {
                dc_validation_remove($(this));
            }
        });
    });
    function get_list_unit(page, src, id) {
        $.ajax({
            url: '<?= base_url('masterdata/manage_unit') ?>/list/'+page,
            data: 'search='+src+'&id='+id,
            cache: false,
            success: function(data) {
                $('#result').html(data);
            }
        });
    }
    
    function reset_form() {
        $('input[type=text], input[type=hidden]').val('');
    }

    function save_satker() {
        if ($('#kode').val() === '') {
            dc_validation('#kode','Kode Satuan Kerja tidak boleh kosong !'); return false;
        }
        if ($('#nama').val() === '') {
            dc_validation('#nama','Nama Satuan Kerja tidak boleh kosong !'); return false;
        }
        var cek_id = $('#id_unit').val();
        $.ajax({
            url: '<?= base_url('masterdata/manage_unit/save') ?>',
            type: 'POST',
            dataType: 'json',
            data: $('#form_unit').serialize(),
            cache: false,
            success: function(data) {
                if (data.status === true) {
                    if (cek_id === '') {
                        message_add_success();
                        reset_form();
                        get_list_unit('1','',data.id_unit);
                    } else {
                        message_edit_success();
                        $('#datamodal').modal('hide');
                        get_list_unit($('.noblock').html(),'');
                    }
                }
            }
        });
    }

    function edit_unit(str) {
        var arr = str.split('#');
        $('#datamodal').modal('show');
        $('#id_unit').val(arr[0]);
        $('#nama').val(arr[1]);
        $('#kode').val(arr[2]);
        $('#datamodal h4').html('Edit Data Unit Satuan Kerja');
    }

    function paging(page, tab, search) {
        get_list_unit(page, search);
    }

    function delete_unit(id, page) {
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
              label: '<i class="fa fa-trash-o"></i>  Hapus',
              className: "btn-primary",
              callback: function() {
                $.ajax({
                    url: '<?= base_url('masterdata/manage_unit/delete') ?>?id='+id,
                    cache: false,
                    success: function() {
                        get_list_unit(page);
                        message_delete_success();
                    },
                    error: function() {
                        message_delete_failed();
                    }
                });
              }
            }
          }
        });
    }
</script>
<div class="titling"><h1><?= $title ?></h1></div>
<ol class="breadcrumb">
    <li><a href="#">Home</a></li>
    <li><a href="#">Masterdata</a></li>
    <li class="active">Data Unit</li>
</ol>
<div class="kegiatan">
    <button class="btn btn-primary" id="add_unit"><i class="fa fa-plus-circle"></i> Tambah Data</button>
    <button class="btn btn-default" id="reload_unit"><i class="fa fa-refresh"></i> Reload Data</button>
    <div id="result"></div>
</div>
<div id="datamodal" class="modal fade">
<div class="modal-dialog" style="width: 600px;">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title" id="modal_title"></h4>
    </div>
    <div class="modal-body">
    <form action="" id="form_unit" role="form" class="form-horizontal">
        <input type="hidden" name="id_unit" id="id_unit" />
        <div class="form-group">
            <label class="col-lg-3 control-label">Kode Satker:</label>
            <div class="col-lg-8">
                <input type="text" name="kode" id="kode" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Nama Satker:</label>
            <div class="col-lg-8">
                <input type="text" name="nama" id="nama" class="form-control"onKeyup="javascript:this.value=this.value.toUpperCase();"/>
            </div>
        </div>
    </form>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Batal</button>
      <button type="button" class="btn btn-primary" id="save" onclick="save_satker();"><i class="fa fa-save"></i> Simpan</button>
    </div>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
