<?php 
    $session =  $this->session->userdata('access'); 
    if (!empty($session)) {
        $access = explode('-', $session);
    }
    echo $access;
?>
<table class="list-data" width="100%" cellspacing="0">
    <thead>
    <tr>
        <th width="3%">No.</th>
        <th width="87%">Nama</th>
        <th width="10%">Aksi</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($user as $key => $rows) : ?>
        <tr class="<?= ($key % 2 == 1) ? 'even' : 'odd' ?>" ondblclick="edit_user('<?= $rows->id ?>')">
            <td align="center"><?= (++$key + (($page - 1) * $limit)) ?></td>
            <td><?= $rows->nama ?></td>
            <td align="right"> 
                
            <?php if (isset($access[3]) and $access[3] === '1') { ?>
                <button class="btn btn-xs" onclick="edit_privileges('<?= $rows->id ?>', '<?= $rows->nama ?>');"><i class="fa fa-user-md"></i></button>
            <?php } ?>
            <?php if (isset($access[1]) and $access[1] === '1') { ?>
                <button class="btn btn-xs" onclick="edit_group('<?= $rows->id ?>', '<?= $rows->nama ?>');"><i class="fa fa-pencil"></i></button>
            <?php } ?>
            <?php if (isset($access[2]) and $access[2] === '1') { ?>
                <button class="btn btn-xs" onclick="delete_group('<?= $rows->id ?>');"><i class="fa fa-trash-o"></i></button>
            <?php } ?>
            </td>  
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?= $infopage ?>
<?= $paging ?>

<br/><br/>
