<?php 
    $session =  $this->session->userdata('access'); 
    if (!empty($session)) {
        $access = explode('-', $session);
    }
?>
<table cellspacing="0" width="100%" class="list-data">
    <tr>
        <th width="3%" rowspan="2">No.</th>
        <th width="5%" rowspan="2">Tanggal Renbut</th>
        <th width="5%" rowspan="2">No. Renbut</th>
        <th width="40%" rowspan="2">Kegiatan</th>
        <th width="5%" rowspan="2">Unit</th>
        <th width="5%" rowspan="2">MA<br/>Proja</th>
        <th width="5%" colspan="3">Jumlah</th>
        <th width="10%" rowspan="2">Penerima /<br/> Penanggungjawab</th>
        <th width="3%" rowspan="2">Aksi</th>
    </tr>
    <tr>
        <th width="7%" style="border-top: 1px solid #6eb7ff;">Nominal</th>
        <th width="7%" style="border-top: 1px solid #6eb7ff;">Cash Bon</th>
        <th width="7%" style="border-top: 1px solid #6eb7ff;">Jml Renbut</th>
    </tr>
    <?php foreach ($list_data as $key => $data) { 
        $str = $data->id_renbut.'#'.$data->ma_proja.'#'.$data->keterangan.'#'.$data->jml_renbut.'#'.$data->penerima.'#'.$data->id_uraian.'#'.datefmysql($data->tanggal_kegiatan).'#'.$data->detail.'#'.$data->kode.'#'.$data->kode_cashbon.'#'.$data->id_pengeluaran.'#'.  datefmysql($data->tanggal_renbut);
        ?>
    <tr class="<?= ($key%2==1)?'even':'odd' ?>">
        <td align="center"><?= $auto++ ?></td>
        <td align="center"><?= datefmysql($data->tanggal_renbut) ?></td>
        <td align="center"><?= $data->kode ?></td>
        <td><?= $data->keterangan ?></td>
        <td class="nowrap"><?= $data->satker ?></td>
        <td align="center"><?= $data->ma_proja ?></td>
        <td align="right"><?= rupiah($data->nominal) ?></td>
        <td align="right"><?= rupiah($data->cashbon) ?></td>
        <td align="right"><?= rupiah($data->jml_renbut) ?></td>
        <td><?= $data->penerima ?></td>
        <td class="aksi" align="center">
            <?php if (isset($access[3]) and $access[3] === '1') { ?>
            <button type="button" class="btn btn-default btn-xs" onclick="print_renbut('<?= $data->id_renbut ?>');" title="Klik untuk print"><i class="fa fa-print"></i></button>
            <?php } ?>
            <?php if (isset($access[1]) and $access[1] === '1') { ?>
            <button type="button" class="btn btn-default btn-xs" onclick="edit_renbut('<?= $str ?>');" title="Klik untuk edit"><i class="fa fa-pencil"></i></button>
            <?php } ?>
            <?php if (isset($access[2]) and $access[2] === '1') { ?>
            <button type="button" class="btn btn-default btn-xs" onclick="delete_renbut('<?= $data->id_renbut ?>', '<?= $page ?>');" title="Klik untuk hapus"><i class="fa fa-trash-o"></i></button>
            <?php } ?>
        </td>
    </tr>
    <?php } ?>
</table>
<?= $paging ?>
<?= $infopage ?>
<br/><br/>