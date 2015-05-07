<br/>
<b>Kode Rekening: <?= (get_safe('kode_perkiraan') !== '')?$nama_rek->id:$data->id_rekening ?> <?= (get_safe('kode_perkiraan') !== '')?$nama_rek->nama:$data->rekening ?></b>
<table class="list-data" width="100%">
    <thead>
    <tr>
        <th width="3%">NO.</th>
        <th width="7%">NO. BUKTI</th>
        <th width="5%">TGL</th>
        <th width="32%" class="left">Keterangan</th>
        <th width="9%" class="right">DEBET</th>
        <th width="9%" class="right">KREDIT</th>
        <th width="9%" class="right">SALDO</th>
    </tr>
    </thead>
    <tbody>
    <tr class="odd">
        <td></td>
        <td></td>
        <td></td>
        <td>SALDO AWAL</td>
        <td></td>
        <td></td>
        <td align="right"><?= rupiah($saldo->awal) ?></td>
    </tr>

    <?php 
    $saldo = 0;
    $sisa  = $what->awal;
    $debet = ''; $kredit = '';
    foreach ($list_data as $key => $data) { 
        if ($data->jenis === 'BKK' and $data->id_rekening_pwk === get_safe('kode_perkiraan')) {
            $sisa += $data->pengeluaran;
            $debet = rupiah($data->pengeluaran); // bertambah
            $kredit= '';
        } 
        else if ($data->jenis === 'BKK' and $data->id_rekening === get_safe('kode_perkiraan')) {
            $sisa += $data->pengeluaran;
            $debet = '';
            $kredit= rupiah($data->pengeluaran);
        }
        else if ($data->jenis === 'MTS' and $data->id_rekening_pwk === get_safe('kode_perkiraan')) {
            $sisa -= $data->pengeluaran;
            $debet = '';
            $kredit= rupiah($data->pengeluaran); // bertambah
        }
        else if ($data->jenis === 'MTS' and $data->id_rekening === get_safe('kode_perkiraan')) {
            $sisa += $data->pengeluaran;
            $debet = rupiah($data->pengeluaran); // bertambah
            $kredit= '';
        }
        else if ($data->jenis === 'BKM' and $data->id_rekening_pwk === get_safe('kode_perkiraan')) {
            $sisa -= $data->pengeluaran;
            $debet = '';
            $kredit= rupiah($data->pengeluaran); // bertambah
        }
        else if ($data->jenis === 'BKM' and $data->id_rekening === get_safe('kode_perkiraan')) {
            $sisa += $data->pengeluaran;
            $debet = rupiah($data->pengeluaran); // bertambah
            $kredit= '';
        }
//        else {
//            $sisa+=$data->pengeluaran;
//        }
        ?>
        <tr class="<?= ($key%2===0)?'odd':'even' ?>">
            <td align="center"><?= ++$key ?></td>
            <td align="center"><?= $data->kode ?></td>
            <td align="center"><?= datefmysql($data->tanggal) ?></td>
            <td><?= ($data->keterangan !== '')?'<i>'.$data->keterangan.'</i>':$data->uraian ?></td>
            <td align="right"><?= $debet ?></td>
            <td align="right"><?= $kredit ?></td>
            <td align="right"><?= rupiah($sisa) ?></td>
        </tr>
    <?php
    } ?>
        </tbody>
</table>