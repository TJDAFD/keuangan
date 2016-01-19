<?php 
    $session =  $this->session->userdata('access'); 
    if (!empty($session)) {
        $access = explode('-', $session);
    }
?>
<table cellspacing="0" width="100%" class="list-data">
    <tr>
        <th width="5%">Tahun</th>
        <th width="5%">No.</th>
        <th width="75%">Nama Unit</th>
        <th width="10%">Pagu</th>
        <th width="5%">Aksi</th>
    </tr>
    <?php 
    $tahun = "";
    foreach ($list_data as $key => $data) { 
        $str = $data->id.'#'.$data->tahun.'#'.$data->id_satker.'#'.rupiah($data->pagu);
        ?>
    <tr class="<?= ($key%2==1)?'even':'odd' ?>">
        <td align="center"><?= ($tahun !== $data->tahun)?$data->tahun:NULL ?></td>
        <td align="center"><?= $auto++ ?></td>
        <td><?= $data->satker ?></td>
        <td align="right"><?= rupiah($data->pagu) ?></td>
        <td  align="right">
            <?php if (isset($access[1]) and $access[1] === '1') { ?>
            <button class="btn btn-default btn-xs" onclick="edit_pagu('<?= $str ?>');" title="Klik untuk edit pagu"><i class="fa fa-pencil"></i></button>
            <?php } ?>
            <?php if (isset($access[2]) and $access[2] === '1') { ?>
            <button class="btn btn-default btn-xs" onclick="delete_pagu('<?= $data->id ?>', '<?= $page ?>');" title="Klik untuk hapus pagu"><i class="fa fa-trash-o"></i></button>
            <?php } ?>
        </td>
    </tr>
    <?php 
    $tahun = $data->tahun;
    } ?>
</table>
<?= $paging ?><br/><br/>