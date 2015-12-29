<table cellspacing="0" width="100%" class="list-data">
    <tr>
        <th width="10%">Sakter</th>
        <th width="5%">Program</th>
        <th width="5%">Kegiatan</th>
        <th width="5%">Sub. Keg.</th>
        <th width="5%">Uraian</th>
        <th width="5%">Sub Uraian</th>
        <th width="5%">Kode</th>
        <th width="25%">Sub Sub Uraian</th>
        <th width="10%">Data Kuat<br/>Organisasi</th>
        <th width="5%">&Sigma; Orang</th>
        <th width="10%">&Sigma; Hari/Bulan</th>
        <th width="7%">Harga Satuan</th>
        <th width="5%">Jumlah Biaya</th>
        <th width="3%">Aksi</th>
    </tr>
    <?php 
    $satker = "";
    $program = "";
    foreach ($list_data as $key => $data) { 
        $str = $data->id.'#'.$data->id_satker.'#'.$data->status.'#'.$data->id_uraian.'#'.
               $data->uraian.'#'.$data->keterangan.'#'.$data->data_kuat_org.'#'.$data->vol_orang.'#'.$data->vol_hari_perbulan.'#'.rupiah($data->harga_satuan).'#'.$data->code;
        ?>
    <tr class="<?= ($key%2==1)?'even':'odd' ?>">
        
        <td><?= ($satker !== $data->satker)?$data->satker.' ('.$data->status.')':NULL ?></td>
        <td align="center" title="<?= $data->nama_program ?>"><?= (($satker !== $data->satker) or ($program !== $data->id_program))?$data->kode_program:NULL ?></td>
        <td align="center" title="<?= $data->nama_kegiatan ?>"><?= $data->kode_kegiatan ?></td>
        <td align="center" title="<?= $data->nama_sub_kegiatan ?>"><?= $data->kode_sub_kegiatan ?></td>
        <td align="center"><?= $data->code ?></td>
        <td align="center"><?= $data->kode_su ?></td>
        <td align="center"><?= $data->kode_ssu ?></td>
        <td><?= ucwords(strtolower($data->keterangan)) ?></td>
        <td align="center"><?= $data->data_kuat_org ?></td>
        <td align="center"><?= $data->vol_orang ?></td>
        <td align="center"><?= $data->vol_hari_perbulan ?></td>
        <td align="right"><?= rupiah($data->harga_satuan) ?></td>
        <td align="right"><?= rupiah($data->sub_total) ?></td>
        <td class="aksi" align="center">
            <a class='edition' onclick="edit_sub_uraian('<?= $str ?>');" title="Klik untuk edit unit">&nbsp;</a>
            <a class='deletion' onclick="delete_sub_uraian('<?= $data->id ?>', '<?= $page ?>');" title="Klik untuk hapus unit">&nbsp;</a>
        </td>
    </tr>
    <?php 
    $satker = $data->satker;
    $program= $data->id_program;
    } ?>
</table>
<?= $paging ?><br/><br/>