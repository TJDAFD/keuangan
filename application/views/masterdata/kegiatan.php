<title><?= $title ?></title>
<?= $this->load->view('message') ?>
<div class="titling">
    <h1>Entri Data <?= $title ?></h1>
</div>
<script type="text/javascript">
$(function() {
    $('#tabs a:first').tab('show');
    load_my_fucking_page('<?= base_url('masterdata/program') ?>','#tabs-1');
});
function load_my_fucking_page(url, el) {
    if ($(el).html() === '') {
        $.ajax({
            url: url,
            beforeSend: function () {
                
            },
            success: function(data) {
                $(el).html(data);
            }
        });
    }
}


function paging(page, tab, search) {
    var active = $('#tabs-instansi').tabs('option','active');
    paginate(page, tab, search, active);
    //load_data_barang(page, search);
}

function paginate(page, tab, search, active) {
    if (active === 0) {
        load_data_pabrik(page, search);
    }
    if (active === 1) {
        load_data_supplier(page, search);
    }
    if (active === 2) {
        load_data_instansi(page, search);
    }
    if (active === 3) {
        load_data_asuransi(page, search);
    }
    if (active === 4) {
        load_data_bank(page, search);
    }
}
</script>
<ol class="breadcrumb">
    <li><a href="#">Home</a></li>
    <li><a href="#">Masterdata</a></li>
    <li class="active">Data Pagu Kegiatan</li>
</ol>
<div class="kegiatan">
    
    <ul id="tabs" class="nav nav-tabs">
        <li class="link_tab" id="tabs1"><a href="#tabs-1" data-toggle="tab" onclick="load_my_fucking_page('<?= base_url('masterdata/program') ?>','#tabs-1');">Program</a></li>
        <li class="link_tab" id="tabs2"><a href="#tabs-2" data-toggle="tab" onclick="load_my_fucking_page('<?= base_url('masterdata/keg_program') ?>','#tabs-2');">Kegiatan</a></li>
        <li class="link_tab" id="tabs3"><a href="#tabs-3" data-toggle="tab" onclick="load_my_fucking_page('<?= base_url('masterdata/sub_kegiatan') ?>','#tabs-3');">Sub Kegiatan</a></li>
        <li class="link_tab" id="tabs4"><a href="#tabs-4" data-toggle="tab" onclick="load_my_fucking_page('<?= base_url('masterdata/uraian') ?>','#tabs-4');">Uraian</a></li>
        <!--<li><a href="#tabs-5" onclick="load_my_fucking_page('<?= base_url('masterdata/sub_uraian') ?>','#tabs-5');">Sub Uraian</a></li>-->
<!--            <li><a href="#tabs-6" onclick="load_my_fucking_page('<?= base_url('masterdata/sub_sub_uraian') ?>','#tabs-6');">Sub Sub Uraian</a></li>-->
        <li class="link_tab" id="tabs5"><a href="#tabs-5" data-toggle="tab" onclick="load_my_fucking_page('<?= base_url('masterdata/kegiatan_preview') ?>','#tabs-5');">Preview</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" id="tabs-1"></div>
        <div class="tab-pane" id="tabs-2"></div>
        <div class="tab-pane" id="tabs-3"></div>
        <div class="tab-pane" id="tabs-4"></div>
        <!--<div id="tabs-5"></div>-->
    <!--        <div id="tabs-6"></div>-->
        <div class="tab-pane" id="tabs-5"></div>
    </div>
</div>