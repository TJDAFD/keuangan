<title><?= $title ?></title>
<div class="titling"><h1><?= $title ?></h1></div>
<script type="text/javascript">
    $(function() {
        get_data_kas_bank(1);
        $('#tabss').tabs();
        $('#awal_kasbank, #akhir_kasbank').datepicker({
            changeYear: true,
            changeMonth: true
        });
        $('#cari_kasbank').button({
            icons: {
                secondary: 'ui-icon-search'
            }
        }).click(function() {
            $('#dialog_kasbank_search').dialog({
                title: 'Cari Data',
                autoOpen: true,
                width: 480,
                autoResize:true,
                modal: true,
                hide: 'explode',
                show: 'blind',
                position: ['center',47],
                buttons: {
                    "Cancel": function() {
                        $('#dialog_kasbank_search').dialog('close');
                    },
                    "Cari": function() {
                        $('#dialog_kasbank_search').dialog('close');
                        get_data_kas_bank(1);
                    } 
                }, close: function() {
                    $('#dialog_kasbank_search').dialog('close');
                }, open: function() {
                    //$('#awal_kasbank, #akhir_kasbank').datepicker('hide');
                    //$('#kode_perkiraan').focus();
                }
            });
        });
        $('#reload_kasbank').button({
            icons: {
                secondary: 'ui-icon-refresh'
            }
        }).click(function() {
            $('#loaddata').load('<?= base_url('laporan/kasbank') ?>');
        });
        
        $('#excel_kasbank').button({
            icons: {
                secondary: 'ui-icon-print'
            }
        }).click(function() {
            location.href='<?= base_url('laporan/excel_kas_bank') ?>/?'+$('#search_kasbank').serialize();
        });
    });
    
    function get_data_kas_bank() {
        $.ajax({
            url: '<?= base_url('laporan/get_data_kas_bank') ?>',
            data: $('#search_kasbank').serialize(),
            success: function(data) {
                $('#result').html(data);
            }
        });
    }
</script>
<div class="kegiatan">
    <div id="tabss">
        <ul>
            <li><a href="#tabss-1">Parameter</a></li>
        </ul>
        <div id="tabss-1">
            <button id="cari_kasbank">Cari</button>
            <button id="excel_kasbank">Export Excel</button>
            <button id="reload_kasbank">Reload Data</button>
        <div id="result">

        </div>
        </div>
    </div>
    <div id="dialog_kasbank_search" class="nodisplay">
        <form action="" id="search_kasbank">
            <table width=100% cellpadding=0 cellspacing=0 class=inputan>
                <tr><td>Range Tanggal:</td><td><input type="text" name="awal" id="awal_kasbank" value="<?= date("01/m/Y") ?>" size="10" /> s.d <input type="text" name="akhir" id="akhir_kasbank" value="<?= date("d/m/Y") ?>" /></td></tr>
                <tr><td>Kode Rekening*:</td><td><?= form_input('kode_perkiraan', NULL, 'id=kode_perkiraan') ?></td></tr>
            </table>
        </form>
    </div>
</div>