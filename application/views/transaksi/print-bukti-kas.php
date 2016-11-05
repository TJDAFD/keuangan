<link rel="stylesheet" href="<?= base_url('assets/css/print-A4-half.css') ?>" media="all" />
<script type="text/javascript">
    function cetak() {
        window.print();
        setTimeout(function(){ window.close();},300);
    }
</script>
<style type="text/css" media="all">
    *, body { background: #fff; font-family: Arial, "Trebuchet MS"; font-size: 10px; }
</style>
<?php
foreach ($list_data as $detail);
if ($detail->kode_awal === 'BKM') {
    $kode_status = 'MASUK';
    $status_uang = 'Telah Terima Dari';
    $label_coa_d = 'Diterima pada '.(($detail->jenis === 'BKK')?'(K)':'(D)');
    $label_coa_k = 'Sumber penerimaan '.(($detail->jenis === 'BKK')?'(D)':'(K)');
}
if ($detail->kode_awal === 'BKK') {
    $kode_status = 'KELUAR';
    $status_uang = 'Harap Membayar Kepada';
    $label_coa_d = 'Untuk membayar '.(($detail->jenis === 'BKK')?'(K)':'(D)');
    $label_coa_k = 'Sumber pembayaran '.(($detail->jenis === 'BKK')?'(D)':'(K)');
}
if ($detail->kode_awal === 'MTS') {
    $kode_status = 'MUTASI';
    $status_uang = 'Telah Terima Dari';
    $label_coa_d = 'Diterima pada '.(($detail->jenis === 'BKK')?'(K)':'(D)');
    $label_coa_k = 'Dipindahkan dari '.(($detail->jenis === 'BKK')?'(D)':'(K)');
}
?>
<body onload="cetak();">
    <div class="page">
    <table width="100%" cellspacing="0" style="margin-bottom: 2px;">
        <tr>
            <td width="15%"></td>
            <td align="center" width="57%">&nbsp;</td><td width="25%" valign="top" align="right">
                <table>
                    <tr><td style="border: none;">&nbsp;</td><td style="border: none; text-align: right;"><?= $detail->kode ?></td></tr>
                    <tr><td style="border: none;"></td><td style="border: none;"><?= datefmysql($detail->tanggal) ?></td></tr>
                </table>
            </td>
            <td width="3%">&nbsp;</td>
        </tr>
        <tr>
            <td width="100%"  align="center"><?= $kode_status ?></td>
        </tr>
    </table>
    <table width="100%" cellspacing="0" style="margin-bottom: 2px;">
        <tr>
            <td width="20%"><?= $status_uang ?></td><td width="1%">:</td><td colspan="2"><?= $detail->penerima ?></td>
        </tr>
        <tr>
            <td width="20%">Uraian Kegiatan</td><td width="1%">:</td><td colspan="2"><?= $detail->keterangan ?></td>
        </tr>
        <tr>
            <td width="20%"><?= $label_coa_d ?></td><td width="1%">:</td><td><?= $detail->rekening ?></td><td>Satker: <?= $detail->satker ?></td>
        </tr>
        <tr>
            <td width="20%"><?= $label_coa_k ?></td><td width="1%">:</td><td colspan="2"><?= $detail->rekening_pwk ?></td>
        </tr>
    </table>
    <table width="100%" cellspacing="0">
        <tr>
            <th width="2%">&nbsp;</th>
            <th width="15%">&nbsp;</th>
            <th width="38%">&nbsp;</th>
            <th width="20%">&nbsp;</th>
            <th width="15%">&nbsp;</th>
        </tr>
        <?php
        $total = 0;
        foreach ($list_data as $key => $data) { 
            ?>
        <tr valign="top">
            <td align="center"></td>
            <td><?= $data->ma_proja ?></td>
            <td><?= $data->uraian ?></td>
            <td align="center"></td>
            <td align="right"><?= rupiah($data->nominal) ?></td>
        </tr>
        <tr valign="top">
            <td align="center"></td>
            <td></td>
            <td><?= $data->keterangan ?></td>
            <td align="right"></td>
            <td align="center"></td>
        </tr>
        <tr valign="top">
            <td align="center"></td>
            <td></td>
            <td>&nbsp;</td>
            <td align="right"></td>
            <td align="center"></td>
        </tr>
        <tr valign="top">
            <td align="center"></td>
            <td></td>
            <td>&nbsp;</td>
            <td align="right"></td>
            <td align="center"></td>
        </tr>
        <?php 
        $total = $total + $data->nominal;
        } 
        for ($i = 1; $i <= (5-$key); $i++) { ?>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <?php }
        ?>
        <tr>
            <td colspan="4" align="right">&nbsp;</td>
            <td align="right"><?= rupiah($total) ?></td>
        </tr>
        <tr>
            <td rowspan="2" valign="top">&nbsp;</td><td colspan="3"><?= ucwords(toTerbilang($total)) ?> rupiah</td>
        </tr>
        <tr>
            <td rowspan="2" valign="top">&nbsp;</td><td colspan="3"></td>
        </tr>
    </table>
    <table width="100%" cellspacing="0">
        <tr>
            <th width="30%">&nbsp;</th>
            <th width="15%">&nbsp;</th>
            <th width="15%">&nbsp;</th>
            <th width="20%">&nbsp;</th>
            <th width="20%">&nbsp;</th>
        </tr>
        <?php for ($i = 1; $i <= 2; $i++) { ?>
        <tr>
            <td colspan="6">&nbsp;</td>
        </tr>
        <?php } ?>
        <tr>
            <td align="right">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center"> <?= $this->session->userdata('nama') ?></td>
            <td align="center"> <?= $detail->penerima ?></td>
        </tr>
    </table>
    </div>
</body>