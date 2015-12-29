<title><?= $title ?></title>
<?= $this->load->view('message') ?>
<script type="text/javascript">
$(function() {
    get_list_normal(1);
    $('#add_normal').button({
        icons: {
            secondary: 'ui-icon-newwin'
        }
    }).click(function() {
        form_normal();
    });
    $('#cari_button').button({
        icons: {
            secondary: 'ui-icon-search'
        }
    }).click(function() {
        form_searching();
    });
    $('#reload_normal').button({
        icons: {
            secondary: 'ui-icon-refresh'
        }
    }).click(function() {
        get_list_normal(1);
    });
});
function get_list_normal(page, src, id) {
    $.ajax({
        url: '<?= base_url('laporan/manage_pencairan_normal') ?>/list/'+page,
        data: $('#searching_dropping').serialize(),
        cache: false,
        success: function(data) {
            $('#result').html(data);
        }
    });
}

function form_searching() {
    //var str = '';
    $('#dialog_dropping').dialog({
        title: 'Cari dropping',
        autoOpen: true,
        width: 480,
        autoResize:true,
        hide: 'explode',
        show: 'blind',
        position: ['center',47],
        buttons: {
            "Cancel": function() {
                $(this).dialog('close')
            },
            "Cari": function() {
                get_list_normal(1);
            }
        }, close: function() {
            $(this).dialog('close')
        }, open: function() {
            $('#uraian').focus();
        }
    });
    $('#uraian').autocomplete("<?= base_url('autocomplete/ma_proja') ?>",
    {
        parse: function(data){
            var parsed = [];
            for (var i=0; i < data.length; i++) {
                parsed[i] = {
                    data: data[i],
                    value: data[i].nama_sub_kegiatan // nama field yang dicari
                };
            }
            return parsed;
        },
        formatItem: function(data,i,max){
            var str = '<div class=result>'+pad(data.ma_proja,5)+' <br/> '+data.keterangan+'</div>';
            return str;
        },
        width: 400, // panjang tampilan pencarian autocomplete yang akan muncul di bawah textbox pencarian
        dataType: 'json', // tipe data yang diterima oleh library ini disetup sebagai JSON
        cacheLength: 0,
        max: 100
    }).result(
    function(event,data,formated){
        $(this).val(pad(data.ma_proja,5));
        $('#id_uraian').val(data.id);
        $('#keterangan').val(data.uraian);
    });
}

function edit_normal(str) {
    var arr = str.split('#');
    form_normal();
    $('#id_normal').val(arr[0]);
    $('#uraian').val(arr[1]);
    $('#keterangan').val(arr[2]);
    $('#jml_normal').val(arr[3]);
    $('#penerima').val(arr[4]);
    $('#id_uraian').val(arr[5]);
    $('#tanggal').val(arr[6]);
    $('#dialog_normal').dialog({ title: 'Edit normal satuan kerja' });
}

function print_normal(id) {
    var wWidth = $(window).width();
    var dWidth = wWidth * 1;
    var wHeight= $(window).height();
    var dHeight= wHeight * 1;
    var x = screen.width/2 - dWidth/2;
    var y = screen.height/2 - dHeight/2;
    window.open('<?= base_url('laporan/manage_normal') ?>/print?id='+id, 'normal Cetak', 'width='+dWidth+', height='+dHeight+', left='+x+',top='+y);
}

function paging(page, tab, search) {
    get_list_normal(page, search);
}
</script>
<div class="kegiatan">
    <button id="cari_button">Cari Data</button>
    <button id="reload_normal">Refresh</button>
    <div id="result" style="overflow-x: auto;">

    </div>
</div>
<div id="dialog_dropping" class="nodisplay">
    <form action="" id="searching_dropping">
    <table width=100% cellpadding=0 cellspacing=0 class=inputan>
        <tr><td width=25%>Tanggal Kegiatan:</td><td><select name=bln id=bln style="width: 74px;"><?php foreach ($bulan as $bln) { ?> <option value="<?= $bln[0] ?>" <?= (($bln[0] == date("m"))?'selected':NULL) ?>><?= $bln[1] ?></option><?php } ?></select><select name="year" id="year" style="width: 72px;"><option value="">Select Year ....</option><?php for($i = 2010; $i <= date("Y"); $i++) { ?> <option value="<?= $i ?>" <?php if ($i == date("Y")) echo "selected"; else echo ""; ?>><?= $i ?></option><?php } ?></select></td></tr>
        <tr><td>Satuan Kerja:</td><td><select name=id_satker id=id_satker><option value="">Semua Satker ...</option><?php foreach ($satker as $data) { ?><option value="<?= $data->id ?>"><?= $data->nama ?></option><?php } ?></select></td></tr>
        <tr><td width=40%>MA Proja:</td><td><?= form_input('uraian', NULL, 'id=uraian size=60') ?><?= form_hidden('id_uraian', NULL, 'id=id_uraian') ?></td></tr>
        <tr><td width=40%>Keterangan:</td><td><?= form_input('keterangan', NULL, 'id=keterangan size=60') ?></td></tr>
        <tr><td>Penanggung Jawab:</td><td><?= form_input('png_jawab', NULL, 'id=png_jawab size=60') ?></td></tr>
    </table>
    </form>
</div>