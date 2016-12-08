<link rel="stylesheet" href="<?= base_url('assets/css/printing-A4-half.css') ?>" media="all" />
<script type="text/javascript">
    function cetak() {
        window.print();
        setTimeout(function(){ window.close();},300);
    }
</script>
<style type="text/css">
    table td { font-size: 14px; }
</style>
<body onload="cetak();">
    <div class="page">
    
    <h3 style="text-align: center; padding-bottom: 10px; margin-bottom: 10px; margin-top: 10px; border-bottom: 1px solid #000; font-size: 16px; font-weight: bold">RENCANA KEBUTUHAN<br/>UNIVERSITAS BHAYANGKARA SURABAYA</h3>
    <table width="100%" style="line-height: 14px;">
        <tr><td width="20%">No.</td><td width="1%">:</td><td width="79%"><?= $data->kode ?></td></tr>
        <tr><td>Tanggal Renbut</td><td>:</td><td><?= indo_tgl($data->tanggal_renbut) ?></td></tr>
        <tr><td>Tanggal Kegiatan</td><td>:</td><td><?= indo_tgl($data->tanggal_kegiatan) ?></td></tr>
        <tr><td>Tahun Anggaran</td><td>:</td><td><?= $data->tahun_anggaran ?></td></tr>
        <tr><td>Kode Unit Kerja</td><td>:</td><td><?= $data->kode_satker ?></td></tr>
        <tr><td>Unit Kerja</td><td>:</td><td><?= $data->satker ?></td></tr>
        <tr><td>Jenis Pengeluaran</td><td>:</td><td><?= $data->status_pengeluaran ?></td></tr>
        <tr><td>MA</td><td>:</td><td><?= $data->ma_proja ?></td></tr>
        <tr><td>Program</td><td>:</td><td><?= $data->nama_program ?></td></tr>
        <tr><td>Kegiatan</td><td>:</td><td><?= $data->nama_kegiatan ?></td></tr>
        <tr><td>Sub Kegiatan</td><td>:</td><td><?= $data->nama_sub_kegiatan ?></td></tr>
        <tr><td>Uraian Kegiatan</td><td>:</td><td><?= $data->uraian ?></td></tr>
        <tr><td>Keterangan</td><td>:</td><td><?= $data->keterangan ?></td></tr>
        <tr><td>Jumlah Dana</td><td>:</td><td><?= rupiah($data->jml_renbut) ?></td></tr>
        <tr><td>Penanggung Jawab</td><td>:</td><td><?= $data->penerima ?></td></tr>
        <tr><td>Kelengkapan</td><td>:</td><td></td></tr>
        <tr><td>Catatan</td><td>:</td><td></td></tr>
    </table>
    <br/>
    <table width="100%" style="float: left;">
        <tr><td width="50%"><b>Pemeriksa I</b></td><td width="50%" align="right"><b>Pemeriksa II</b></td></tr>
        <tr><td style="height: 50px;">&nbsp;</td><td align="right" style="height: 50px;">&nbsp;</td></tr>
        <tr><td>Ali Rasyidi</td><td align="right">Ni Luh Ketut Novita, SE</td></tr>
    </table>
    </div>
</body>