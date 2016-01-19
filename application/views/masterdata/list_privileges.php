<table class="list-data" id="table" width="100%" cellspacing="0">
    <thead>
    <tr>
        <th width="5%">No</th>
        <th width="15%">Modul</th>
        <th width="30%">Nama Form</th>
        <th width="50%"></th>
    </tr>
    </thead>
    <tbody>
    <?php 
    $modul = "";
    $no = 1;
    foreach ($privilege as $key => $rows) : ?>
        <tr class="<?= ($key % 2 == 1) ? 'even' : 'odd' ?>">
            <td align="center"><?= ($modul !== $rows->modul)?$no:NULL ?></td>
            <td><?= ($modul !== $rows->modul)?'<b>'.$rows->modul.'</b>':NULL ?></a></td>
            <td><?= $rows->form_nama ?></td>
            <td>
                <?php $check = in_array($rows->id, $user_priv);                 ?>
                <div class="checkbox" style="float: left; margin-right: 10px; width: 70px;">
                    <label>
                        <input type="checkbox" name="data[]" value="<?= $rows->id ?>" <?= (empty($check))?'':'checked' ?> > View 
                    </label>
                </div>
                <?php 
                $action = substr_count($rows->detail, ',');
                if ($action > 0) { 
                    $access = explode(',' ,$rows->detail);
                    $extend = explode('-' ,$rows->extend_privileges);
                    for ($i = 0; $i <= $action; $i++) { 
                        $checked = '';
                        $value = '0';
                        if (($rows->extend_privileges !== '') and isset($extend[$i]) and ($extend[$i] === '1')) {
                            $checked = 'checked';
                            $value = '1';
                        }
                        ?>
                        <div class="checkbox" style="float: left; margin-right: 10px; width: 70px;">
                            <label>
                                <input type="checkbox" name="detail[<?= $key ?>][]" value="<?= $rows->id ?>" <?= $checked ?> />  <?= ucfirst($access[$i]) ?>
                                <input type="hidden" name="detail_hidden[<?= $rows->id ?>][]" value="<?= $value ?>" />
                            </label>
                        </div>
                    <?php 
                    }
                }
                ?>
                
            </td>
        </tr>
    <?php
    if ($modul !== $rows->modul) {
        $no++;
    }
    $modul = $rows->modul;
    endforeach; ?>
    </tbody>
</table>