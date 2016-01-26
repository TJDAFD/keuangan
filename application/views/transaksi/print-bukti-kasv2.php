<link rel="stylesheet" href="<?= base_url('assets/css/print-A4-half.css') ?>" media="all" />
<script type="text/javascript">
    function cetak() {
        window.print();
        setTimeout(function(){ window.close();},300);
    }
</script>
<style type="text/css" media="print">
    *, body { background: #fff; font-family: Arial, "Trebuchet MS"; font-size: 10px; }
</style>
<?php
foreach ($list_data as $detail);
?>
<body onload="cetak();">
    <div class="page">
    <?php
        $label_debet = "Diterima Pada (D)"; // default BKM&MTS
        $label_kredit= "Dipindahkan dari (K)"; //default MTS
        $kode_rek_debet = $row->id_rekening;
        $kode_rek_kredit= $row->id_rekening_pwk;
        $nama_rek_debet = $row->rekening;
        $nama_rek_kredit= $row->rekening_pwk;
        $bukti_kas = 'MUTASI'; $dinamic = 'Penyetor';
        if ($row->jenis === 'BKK') {
            $label_debet = "Untuk Membayar (D)";
            $label_kredit= "Sumber Pembayaran (K)";
            $kode_rek_debet = $row->id_rekening_pwk;
            $kode_rek_kredit= $row->id_rekening;
            $nama_rek_debet = $row->rekening_pwk;
            $nama_rek_kredit= $row->rekening;
            $bukti_kas = 'KELUAR'; $dinamic = 'Penerima';
        }
        if ($row->jenis === 'BKM') {
            $label_kredit= "Sumber Penerimaan (K)";
            $bukti_kas = 'MASUK'; $dinamic = 'Penyetor';
        }
    ?>
    <table width="100%" cellspacing="0" cellpadding="0" style="margin-bottom: 1px; border-bottom: 1px double #000;">
        <tr>
            <td valign="top" width="12%"><img src="<?= base_url('assets/images/'.$header->logo) ?>" width="50px" height="45px;" /></td>
            <td valign="top" width="63%" style="font-weight: bold;">
                <b><h1><?= strtoupper($header->nama) ?></h1></b>
                <b>Kampus: <?= $header->alamat ?> Telp. <?= $header->telp ?> Fax. <?= $header->fax ?></b><br/>
                <b><i>BUKTI KAS / BANK <?= $bukti_kas ?></i></b>
            </td>
            <td width="25%" valign="top" style="border-left: 1px solid #000;">
                <table>
                    <tr><td style="border: none;">No.</td><td style="border: none;">: <?= $detail->kode ?></td></tr>
                    <tr><td style="border: none;">Tgl.</td><td style="border: none;">: <?= datefmysql($detail->tanggal) ?></td></tr>
                </table>
            </td>
        </tr>
    </table>
    
    <table width="100%">
        <tr>
            <td width="19%" colspan="2">Harap Membayar Kpd</td>
            <td width="1%">:</td>
            <td colspan="3" width="80%"><?= $row->penerima ?></td>
        </tr>
        <tr>
            <td width="19%" colspan="2">Uraian Kegiatan</td>
            <td width="1%">:</td>
            <td colspan="3" width="80%"> <i style="font-style: italic;"> <?= $row->keterangan ?> </i></td>
        </tr>
        <tr>
            <td width="19%" colspan="2" style="white-space: nowrap;"><?= $label_debet ?></td>
            <td width="1%">:</td>
            <td width="48%"><?= $kode_rek_debet ?> <?= $nama_rek_debet ?></td>
            <td colspan="2" width="32%"><?= ($row->jenis === 'BKK')?'Satker: '.$row->satker:'' ?> </td>
        </tr>
        <tr>
            <td width="19%" colspan="2" style="white-space: nowrap;"><?= $label_kredit ?></td>
            <td width="1%">:</td>
            <td width="48%"><?= $kode_rek_kredit ?> <?= $nama_rek_kredit ?></td>
            <td colspan="2" width="32%"><?= ($row->jenis === 'BKM')?'Satker: '.$row->satker:'' ?> </td>
        </tr>
    </table>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-list-data" style="border-top: 1px solid #000;">
        
        <tr>
            <th width="4%">NO</th>
            <th width="16%">KODE MA</th>
            <th width="48%">URAIAN MA</th>
            <th width="16%">SATKER</th>
            <th width="16%">JUMLAH</th>
        </tr>
        <?php
        $total = 0;
        $no = 0;
        foreach ($list_data as $key => $data) { 
            ?>
        <tr valign="top">
            <td align="center"><?= ++$key ?></td>
            <td><?= $data->ma_proja ?></td>
            <td><?= $data->uraian ?></td>
            <td>&nbsp;</td>
            <td align="right"><?= rupiah($data->nominal) ?></td>
        </tr>
        <!--<tr valign="top">
            <td align='center'></td>
            <td></td>
            <td style="padding-left: 10px;"><?= $data->keterangan ?></td>
            <td align="right"></td>
            <td>&nbsp;</td>
        </tr>-->
        <?php 
        $total = $total + $data->nominal;
        } 
        //for ($i = 1; $i <= (7-$no); $i++) { 
        ?>
        <!--<tr>
            <td align='center'><?= ++$key ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>-->
        <?php //}
        ?>
        <tr>
            <td colspan="3" align="right">&nbsp;</td>
            <td align='center'>TOTAL</td>
            <td align="right"><?= rupiah($total) ?></td>
        </tr>
        <tr>
            <td rowspan="2" valign="top">&nbsp;</td><td colspan="4">Terbilang: <i style="font-style: italic;"><?= ucwords(toTerbilang($total)) ?> rupiah </i></td>
        </tr>
        <tr>
            <td rowspan="2" valign="top">&nbsp;</td><td colspan="4"></td>
        </tr>
    </table>
        <br/>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-list-data" style="border-top: 1px solid #000;">
        
        <tr>
            <th width="4%"></th>
            <th width="16%">Ka. BiKeu</th>
            <th width="16%">-</th>
            <th width="16%">Kabag. Akuntansi</th>
            <th width="16%">Kasir</th>
            <th width="16%"><?= $dinamic ?></th>
            <th width="16%">Telah Dibukukan</th>
        </tr>
        <tr>
            <td style="height: 40px;">&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td align='center'>&nbsp;</td>
            <td align='center'><?= $header->kabikeu ?></td>
            <td align='center'></td>
            <td align='center'><?= $header->kaakuntansi ?></td>
            <td align='center'><?= (empty($row->kasir)?'-':$row->kasir) ?></td>
            <td align='center'><?= $detail->penerima ?></td>
            <td align='center'></td>
        </tr>
    </table>
    </div>
</body>