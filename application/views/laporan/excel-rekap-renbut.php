<?php 
    header_excel('rekap-renbut-'.get_safe('awal').' s.d '.  get_safe('akhir').'.xls');
?>
<table width="100%">
    <tr>
        <td colspan="10">REKAP RENCANA KEBUTUHAN <?= get_safe('awal').' s.d '.  get_safe('akhir') ?></td>
    </tr>
</table>
<table cellspacing="0" width="100%" border="1">
    <tr>
        <th width="3%" rowspan="2">No.</th>
        <th width="5%" rowspan="2">Tanggal Renbut</th>
        <th width="5%" rowspan="2">No. Renbut</th>
        <th width="5%" rowspan="2">No. BKK</th>
        <th width="40%" rowspan="2">Kegiatan</th>
        <th width="5%" rowspan="2">Unit</th>
        <th width="5%" rowspan="2">MA<br/>Proja</th>
        <th width="5%" colspan="3">Jumlah</th>
        <th width="10%" rowspan="2">Penerima /<br/> Penanggungjawab</th>
    </tr>
    <tr>
        <th width="7%" style="border-top: 1px solid #6eb7ff;">Nominal</th>
        <th width="7%" style="border-top: 1px solid #6eb7ff;">Cash Bon</th>
        <th width="7%" style="border-top: 1px solid #6eb7ff;">Jml Renbut</th>
    </tr>
    <?php foreach ($list_data as $key => $data) { 
        $str = $data->id_renbut.'#'.$data->ma_proja.'#'.$data->keterangan.'#'.$data->jml_renbut.'#'.$data->penerima.'#'.$data->id_uraian.'#'.datefmysql($data->tanggal_kegiatan).'#'.$data->detail.'#'.$data->kode;
        ?>
    <tr class="<?= ($key%2==1)?'even':'odd' ?>">
        <td align="center"><?= $auto++ ?></td>
        <td align="center"><?= datefmysql($data->tanggal_renbut) ?></td>
        <td><?= $data->kode ?></td>
        <td><?= $data->kode_cashbon ?></td>
        <td><?= $data->keterangan ?></td>
        <td><?= $data->satker ?></td>
        <td align="center"><?= $data->ma_proja ?></td>
        <td align="right"><?= $data->nominal ?></td>
        <td align="right"><?= $data->cashbon ?></td>
        <td align="right"><?= $data->jml_renbut ?></td>
        <td><?= $data->penerima ?></td>
    </tr>
    <?php } ?>
</table>