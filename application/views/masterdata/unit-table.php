<?php 
    $session =  $this->session->userdata('access'); 
    if (!empty($session)) {
        $access = explode('-', $session);
    }
?>
<table cellspacing="0" width="100%" class="list-data">
    <tr>
        <th width="5%">No.</th>
        <th width="5%">Kode</th>
        <th width="85%">Nama Unit</th>
        <th width="5%">Aksi</th>
    </tr>
    <?php foreach ($list_data as $key => $data) { 
        $str = $data->id.'#'.$data->nama.'#'.$data->kode;
        ?>
    <tr class="<?= ($key%2==1)?'even':'odd' ?>">
        <td align="center"><?= $auto++ ?></td>
        <td align="center"><?= $data->kode ?></td>
        <td><?= $data->nama ?></td>
        <td align="right">
            <?php if (isset($access[1]) and $access[1] === '1') { ?>
            <button class="btn btn-default btn-xs" onclick="edit_unit('<?= $str ?>');" title="Klik untuk edit unit"><i class="fa fa-pencil"></i></button>
            <?php } ?>
            <?php if (isset($access[2]) and $access[2] === '1') { ?>
            <button class="btn btn-default btn-xs" onclick="delete_unit('<?= $data->id ?>', '<?= $page ?>');" title="Klik untuk hapus unit"><i class="fa fa-trash-o"></i></button>
            <?php } ?>
        </td>
    </tr>
    <?php } ?>
</table>
<?= $infopage ?>
<?= $paging ?><br/><br/>