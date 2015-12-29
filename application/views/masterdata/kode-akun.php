<title><?= $title ?></title>
<?= $this->load->view('message') ?>
<script type="text/javascript">
$(function() {
    get_list_rekening();
    $('#tabs').tabs();
    $('#add-rekening').button({
        icons: {
            secondary: 'ui-icon-newwin'
        }
    }).click(function() {
        dialog_rekening('Tambah Rekening');
        get_last_code('rekening', 'id', null,'#kode_rek');
    });;
    $('#reset').button({
        icons: {
            secondary: 'ui-icon-refresh'
        }
    }).click(function() {
        get_list_rekening(1);
    });
});
function get_list_rekening(page) {
    $.ajax({
        url: '<?= base_url('masterdata/manage_rekening') ?>/list/'+page,
        cache: false,
        success: function(data) {
            $('#list_rekening').html(data);
        }
    });
}
</script>
<div class="titling"><h1><?= $title ?></h1></div>
<ol class="breadcrumb">
    <li><a href="#">Home</a></li>
    <li><a href="#">Masterdata</a></li>
    <li class="active">Data Rekening</li>
</ol>
<div class="kegiatan">
    <button class="btn btn-primary" id="add-rekening"><i class="fa fa-plus-circle"></i> Tambah</button>
    <button class="btn" id="reset"><i class="fa fa-refresh"></i> Reload Data</button>
    <div id="list_rekening"></div>
</div>