<?php 
    $session =  $this->session->userdata('access'); 
    if (!empty($session)) {
        $access = explode('-', $session);
    }
?>
<table cellspacing="0" width="100%" class="list-data">
    <tr>
        <th width="3%">No.</th>
        <th width="7%">Tanggal</th>
        <th width="10%">No. Bukti</th>
        <th width="7%" class="left">Rekening</th>
        <th width="17%" class="left">Nama Rekening</th>
        <th width="33%" class="left">Keterangan</th>
        <th width="10%" class="right">Debet</th>
        <th width="10%" class="right">Kredit</th>
        <th width="3%"></th>
    </tr>
    <?php foreach ($list_data as $key => $data) { ?>
    <tr class="<?= ($key%2==1)?'even':'odd' ?>">
        <td align="center"><?= $auto++ ?></td>
        <td align="center"><?= datefmysql($data->tanggal) ?></td>
        <td align="center"><?= $data->kode_nota ?></td>
        <td><?= $data->id_rekening ?></td>
        <td><?= $data->nama ?></td>
        <td><?= $data->keterangan ?></td>
        <td align="right"><?= rupiah($data->debet) ?></td>
        <td align="right"><?= rupiah($data->kredit) ?></td>
        <td align="right">
            <?php if (isset($access[3]) and $access[3] === '1') { ?>
            <button type="button" class="btn btn-default btn-xs" onclick="delete_jurnal('<?= $data->id ?>', '<?= $page ?>');" title="Klik untuk hapus"><i class="fa fa-trash-o"></i></button>
            <?php } ?>
        </td>
    </tr>
    <?php } ?>
</table>
<?= $paging ?><br/><br/>