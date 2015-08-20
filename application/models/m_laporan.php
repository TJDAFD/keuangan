<?php

class M_laporan extends CI_Model {
    
    function get_data_realisasi($limit = null, $start = null, $search = null) {
        $q = null;
        if ($search['key'] !== 'undefined') {
            $q.=" and rk.keterangan like '%".$search['key']."%'";
        }
        if ($search['id'] !== 'undefined') {
            $q.=" and rk.id_renbut = '".$search['id']."'";
        }
        if (($search['bulan'] !== '') and ($search['bulan'] !== 'undefined-undefined')) {
            $q.=" and rk.tanggal like ('%".$search['bulan']."%')";
        }
        if (($search['satker'] !== '') and ($search['satker'] !== 'undefined')) {
            $q.=" and s.id = '".$search['satker']."'";
        }
        $q.=" order by rk.tanggal asc";
        $sql = "select rk.*, s.nama as satker, CONCAT_WS('',p.kode,k.kode,sk.kode,u.kode) as ma_proja from rencana_kebutuhan rk
            join uraian u on (rk.id_uraian = u.id)
            join sub_kegiatan sk on (u.id_sub_kegiatan = sk.id)
            join kegiatan k on (sk.id_kegiatan = k.id)
            join program p on (k.id_program = p.id)
            join satker s on (p.id_satker = s.id) where rk.id is not NULL";
        $limitation = null;
        $limitation.=" limit $start , $limit";
        $query = $this->db->query($sql . $q . $limitation);
        //echo $sql . $q . $limitation;
        $queryAll = $this->db->query($sql . $q);
        $data['data'] = $query->result();
        $data['jumlah'] = $queryAll->num_rows();
        return $data;
    }
    
    function load_satker($param) {
        $q = "";
        $tahun = date("Y");
        if ($param['tahun'] !== '') {
            $tahun = $param['tahun'];
        }
        if ($param['satker'] !== '') {
            $q.=" and p.id_satker = '".$param['satker']."'";
        }
        $sql = "select sum(ks.sub_total) as pagu, s.kode, s.nama, s.id as id_satker, ks.tahun,
            u.id as id_uraian
            from uraian u 
            left join sub_uraian ks on (ks.id_uraian = u.id)
            join sub_kegiatan sk on (u.id_sub_kegiatan = sk.id)
            join kegiatan k on (sk.id_kegiatan = k.id)
            join program p on (k.id_program = p.id)
            join satker s on (p.id_satker = s.id)
            where ks.tahun = '$tahun' $q
                group by s.id order by s.kode asc";
        //echo $sql;
        $result = $this->db->query($sql)->result();
        foreach ($result as $key => $value) {
            $sql_child = "select IFNULL(sum(ks.pengeluaran),0) as total 
            from kasir ks
            join uraian u on (ks.id_uraian = u.id)
            join sub_kegiatan sk on (u.id_sub_kegiatan = sk.id)
            join kegiatan k on (sk.id_kegiatan = k.id)
            join program p on (k.id_program = p.id)
            join satker s on (p.id_satker = s.id)
            where s.id = '".$value->id_satker."' 
                and ks.tanggal like ('".($param['tahun']+1)."%') 
                and ks.tahun_anggaran = '".($param['tahun'])."'
                and ks.jenis = 'BKK'";
            //echo $sql_child;
            $result[$key]->next_year = $this->db->query($sql_child)->row()->total;
        }
        $data['list_data'] = $result;
        return $data;
    }
    
    function get_data_pencairan_normal($limit, $start, $search) {
        $q = null;
        if ($search['bulan'] !== '') {
            $q.=" and rk.tanggal like ('%".$search['bulan']."%')";
        }
        if ($search['satker'] !== '') {
            $q.=" and s.id = '".$search['satker']."'";
        }
        if ($search['proja'] !== '') {
            $q.=" and u.kode = '".$search['proja']."'";
        }
        if ($search['pjawab'] !== '') {
            $q.=" and rk.penerima like ('%".$search['pjawab']."%')";
        }
        $q.=" order by rk.tanggal asc";
        $sql = "select rk.*, s.nama as satker, u.kode as ma_proja from rencana_kebutuhan rk
            join uraian u on (rk.id_uraian = u.id)
            join sub_kegiatan sk on (u.id_sub_kegiatan = sk.id)
            join kegiatan k on (sk.id_kegiatan = k.id)
            join program p on (k.id_program = p.id)
            join satker s on (p.id_satker = s.id)
            where rk.status = 'Disetujui' and rk.cashbon = '0'";
        $limitation = null;
        $limitation.=" limit $start , $limit";
        $query = $this->db->query($sql . $q . $limitation);
        //echo $sql . $q . $limitation;
        $queryAll = $this->db->query($sql . $q);
        $data['data'] = $query->result();
        $data['jumlah'] = $queryAll->num_rows();
        return $data;
    }
    
    function get_data_cashbon($limit, $start, $search) {
        $q = null;
        if ($search['key'] !== 'undefined') {
            $q.=" and rk.keterangan like '%".$search['key']."%'";
        }
        if ($search['id'] !== 'undefined') {
            $q.=" and rk.id_renbut = '".$search['id']."'";
        }
        if (($search['bulan'] !== '') and ($search['bulan'] !== 'undefined-undefined')) {
            $q.=" and rk.tanggal like ('%".$search['bulan']."%')";
        }
        if (($search['satker'] !== '') and ($search['satker'] !== 'undefined')) {
            $q.=" and s.id = '".$search['satker']."'";
        }
        if (($search['proja'] !== '') and ($search['proja'] !== 'undefined')) {
            $q.=" having ma_proja like ('%".$search['proja']."%')";
        }
        if (($search['pjawab'] !== '') and ($search['pjawab'] !== 'undefined')) {
            $q.=" and rk.penerima like ('%".$search['pjawab']."%')";
        }
        $q.=" order by rk.tanggal asc";
        $sql = "select rk.*, s.nama as satker, u.kode as ma_proja from rencana_kebutuhan rk
            join uraian u on (rk.id_uraian = u.id)
            join sub_kegiatan sk on (u.id_sub_kegiatan = sk.id)
            join kegiatan k on (sk.id_kegiatan = k.id)
            join program p on (k.id_program = p.id)
            join satker s on (p.id_satker = s.id)
            where rk.status = 'Disetujui' and rk.cashbon != '0'";
        $limitation = null;
        $limitation.=" limit $start , $limit";
        $query = $this->db->query($sql . $q . $limitation);
        //echo $sql . $q . $limitation;
        $queryAll = $this->db->query($sql . $q);
        $data['data'] = $query->result();
        $data['jumlah'] = $queryAll->num_rows();
        return $data;
    }
    
    function grafik_penggunaan_load_data($bulan, $satker) {
        $tahun = substr($bulan, 0, 4);
        $sql = "select s.nama as satker, sum(ks.pengeluaran) as realisasi, 
            YEAR(ks.tanggal) as tahun, 
            ks.tanggal as bulan,
            (select (pagu/12) from pagu_anggaran where tahun = '$tahun' and id_satker = '$satker') as rata_pagu
            from kasir ks
            join uraian u on (ks.id_uraian = u.id)
            join sub_kegiatan sk on (u.id_sub_kegiatan = sk.id)
            join kegiatan k on (sk.id_kegiatan = k.id)
            join program p on (k.id_program = p.id)
            join satker s on (p.id_satker = s.id)
            where YEAR(ks.tanggal) = '$tahun' 
                and s.id = '$satker' 
                and ks.tahun_anggaran = '$tahun' 
                and ks.jenis = 'BKK'
                GROUP BY s.id, YEAR(ks.tanggal), MONTH(ks.tanggal) ASC
            ";
        //echo "<pre>".$sql."</pre>";
        return $this->db->query($sql);
    }
    
    function get_data_kas_bank($param) {
        /*$sql = "select j.*, s.nama as nama_rekening, u.uraian
            from jurnal j
            join sub_sub_sub_sub_rekening s on (j.id_rekening = s.id)
            join uraian u on (j.id_uraian = u.id)
            where j.tanggal like ('%$bulan%')";*/
        $q = NULL; $r = NULL;
        if ($param['awal'] !== '' and $param['akhir'] !== '') {
            $q.=" and k.tanggal between '".$param['awal']."' and '".$param['akhir']."'";
            $r.=" and tanggal < '".$param['awal']."'";
        }
        if ($param['norekening'] !== '') {
            $q.=" and (k.id_rekening like ('%".$param['norekening']."%') or k.id_rekening_pwk like ('%".$param['norekening']."%'))";
            $r.=" and (id_rekening like ('%".$param['norekening']."%') or id_rekening_pwk like ('%".$param['norekening']."%'))";
        }
        if ($param['norekening'] === '') {
            $sql = "select id, id_rekening, uraian, rekening from 
                    (select s.id, k.id_rekening as id_rekening, u.uraian, s.nama as rekening 
                    from kasir k 
                    left join uraian u on (k.id_uraian = u.id)
                    left join sub_sub_sub_sub_rekening s on (k.id_rekening = s.id)
                    where k.id_rekening is not NULL $q group by s.id
                    UNION ALL
                    select s.id, k.id_rekening_pwk as id_rekening, u.uraian, s.nama as rekening 
                    from kasir k 
                    left join uraian u on (k.id_uraian = u.id)
                    left join sub_sub_sub_sub_rekening s on (k.id_rekening_pwk = s.id)
                    where k.id_rekening_pwk is not NULL $q group by s.id
                    ) t group by id_rekening";
            //echo "<pre>".$sql."</pre>";
            $result = $this->db->query($sql)->result();
        } else {
            $sql = "select id, nama as rekening from sub_sub_sub_sub_rekening 
                where id = '".$param['norekening']."'
                ";
            $result = $this->db->query($sql)->result();
        }
        foreach ($result as $key => $value) {
            $sql_child = "select k.*, u.uraian, s.nama as rekening
            from kasir k
            left join uraian u on (k.id_uraian = u.id)
            left join sub_sub_sub_sub_rekening s on (k.id_rekening = s.id)
            where k.id is not NULL and (k.id_rekening = '".$value->id."' or k.id_rekening_pwk = '".$value->id."')
                and k.tanggal between '".$param['awal']."' and '".$param['akhir']."'
                ";
            //echo $sql_child;
            $result[$key]->detail = $this->db->query($sql_child)->result();
            
            /*$sql_saldo = "select 
            (select sum(pengeluaran) from kasir where jenis != 'BKK' and tanggal < '".$param['awal']."' and (id_rekening like ('%".$value->id."%') or id_rekening_pwk like ('%".$value->id."%')))
                -
            (select sum(pengeluaran) from kasir where jenis = 'BKK' and tanggal < '".$param['awal']."' and (id_rekening like ('%".$value->id."%') or id_rekening_pwk like ('%".$value->id."%'))) as awal
                ";*/
            
            $date = explode('-', $param['awal']);
            $date2= mktime(0, 0, 0, $date[1], $date[2], $date[0]);
            $akhir= date("Y-m-d", $date2);
            
            $sql_saldo_awal = "select k.*, u.uraian, s.nama as rekening
            from kasir k
            left join uraian u on (k.id_uraian = u.id)
            left join sub_sub_sub_sub_rekening s on (k.id_rekening = s.id)
            where k.id is not NULL and (k.id_rekening = '".$value->id."' or k.id_rekening_pwk = '".$value->id."')
                and k.tanggal < '".$akhir."'
                ";
            $array_data = $this->db->query($sql_saldo_awal)->result();
            $result[$key]->child = $array_data;
            $sisa  = 0;
            foreach ($array_data as $i => $data) {
                if ($data->jenis === 'BKK' and $data->id_rekening_pwk === $value->id) {
                    $sisa += $data->pengeluaran;
                } 
                else if ($data->jenis === 'BKK' and $data->id_rekening === $value->id) {
                    $sisa -= $data->pengeluaran;
                }
                else if ($data->jenis === 'MTS' and $data->id_rekening_pwk === $value->id) {
                    $sisa -= $data->pengeluaran;
                }
                else if ($data->jenis === 'MTS' and $data->id_rekening === $value->id) {
                    $sisa += $data->pengeluaran;
                }
                else if ($data->jenis === 'BKM' and $data->id_rekening_pwk === $value->id) {
                    $sisa -= $data->pengeluaran;
                }
                else if ($data->jenis === 'BKM' and $data->id_rekening === $value->id) {
                    $sisa += $data->pengeluaran;
                }
            }
        
            $result[$key]->saldo = $sisa;
            $result[$key]->what = $sisa;
        }
        $return['list_data'] = $result;
        
        //die(json_encode($data));
        return $return;
    }
    
    function get_saldo_awal_kas($bulan) {
        $ext = explode('-', $bulan);
        $prev= mktime(0, 0, 0, $ext[1]-1, date("d") , $ext[0]);
        $new_prev = date("Y-m-31", $prev);
        $sql = "select sum(pemasukkan)-(select sum(pengeluaran) from kasir where tanggal <= '$new_prev') as saldo_sisa from penerimaan where tanggal <= '$new_prev'";
        //echo $sql;
        return $this->db->query($sql);
    }
    
    function get_data_renbut($limit = null, $start = null, $search = null) {
        $q = null;
        if ($search['awal'] !== '' and $search['akhir'] !== '') {
            $q.=" and rk.tanggal_renbut between '".$search['awal']."' and '".$search['akhir']."'";
        }
        if ($search['awal_keg'] !== '' and $search['akhir_keg'] !== '') {
            $q.=" and rk.tanggal_kegiatan between '".$search['awal_keg']."' and '".$search['akhir_keg']."'";
        }
        if ($search['jenis'] !== '') {
            if ($search['jenis'] === 'murni') {
                $q.=" and rk.kode_cashbon = ''";
            }
            if ($search['jenis'] === 'cashbon') {
                $q.=" and rk.kode_cashbon != ''";
            }
        }
        if ($search['kegiatan'] !== '') {
            $q.=" and rk.keterangan like ('%".$search['kegiatan']."%')";
        }
        if ($search['satker'] !== '') {
            $q.=" and s.id = '".$search['satker']."'";
        }
        $q.=" order by rk.id_renbut desc";
        $sql = "select rk.*, s.nama as satker, u.kode as ma_proja,
            CONCAT_WS(' / ',s.nama, p.status, p.nama_program, k.nama_kegiatan, sk.nama_sub_kegiatan) as detail
            from rencana_kebutuhan rk
            left join uraian u on (rk.id_uraian = u.id)
            left join sub_kegiatan sk on (u.id_sub_kegiatan = sk.id)
            left join kegiatan k on (sk.id_kegiatan = k.id)
            left join program p on (k.id_program = p.id)
            left join satker s on (p.id_satker = s.id)
            where rk.kode != ''
            ";
        $limitation = null;
        if ($limit !== null) {
            $limitation =" limit $start , $limit";
        }
        $query = $this->db->query($sql . $q . $limitation);
        //echo $sql . $q . $limitation;
        $queryAll = $this->db->query($sql . $q);
        $data['data'] = $query->result();
        $data['jumlah'] = $queryAll->num_rows();
        return $data;
    }
    
    function load_data_grafik_pengeluaran($perwabku) {
        $sql = "select sum(pengeluaran) as pengeluaran, perwabku from kasir where perwabku = '$perwabku' and tanggal like ('".date("Y-m")."%') and jenis = 'BKK'";
        //echo $sql;
        return $this->db->query($sql)->row();
    }
    
    function load_detail_ma_satker($search) {
        $monthNames = array($search['tahun'].'-01', $search['tahun'].'-02', $search['tahun'].'-03', $search['tahun'].'-04'
            , $search['tahun'].'-05', $search['tahun'].'-06', $search['tahun'].'-07', $search['tahun'].'-08'
            , $search['tahun'].'-09', $search['tahun'].'-10', $search['tahun'].'-11', $search['tahun'].'-12');
        $sql = "select sum(ks.sub_total) as pagu, s.kode, s.nama, 
            s.id as id_satker, ks.tahun, u.id as id_uraian, u.kode as ma_proja, u.uraian 
            from uraian u 
            left join sub_uraian ks on (ks.id_uraian = u.id) 
            join sub_kegiatan sk on (u.id_sub_kegiatan = sk.id) 
            join kegiatan k on (sk.id_kegiatan = k.id) 
            join program p on (k.id_program = p.id) 
            join satker s on (p.id_satker = s.id) 
            where ks.tahun = '".$search['tahun']."' 
            and s.id = '".$search['satker']."' 
            group by u.id order by u.kode asc
                ";
        $result = $this->db->query($sql)->result();
        foreach ($result as $i => $val) {
            $sql_child = "select (select IFNULL(sum(ks.pengeluaran),0)
                    from kasir ks 
                    join uraian u on (ks.id_uraian = u.id)
                    join sub_kegiatan sk on (u.id_sub_kegiatan = sk.id)
                    join kegiatan k on (sk.id_kegiatan = k.id)
                    join program p on (k.id_program = p.id)
                    join satker s on (p.id_satker = s.id)
                    where s.id = '".$search['satker']."' 
                        and ks.id_uraian = '".$val->id_uraian."' 
                        and ks.tanggal like ('".($search['tahun']+1)."%')
                        and ks.jenis = 'BKK' and ks.tahun_anggaran = '".$search['tahun']."') - 
                    (select IFNULL(sum(ks.pengeluaran),0)
                    from kasir ks 
                    join uraian u on (ks.id_uraian = u.id)
                    join sub_kegiatan sk on (u.id_sub_kegiatan = sk.id)
                    join kegiatan k on (sk.id_kegiatan = k.id)
                    join program p on (k.id_program = p.id)
                    join satker s on (p.id_satker = s.id)
                    where s.id = '".$search['satker']."' 
                        and ks.id_uraian = '".$val->id_uraian."' 
                        and ks.tanggal like ('".($search['tahun']+1)."%')
                        and ks.jenis = 'BKM' and ks.tahun_anggaran = '".$search['tahun']."') as realisasi
                    ";
            $query_child = $this->db->query($sql_child)->row();
            $result[$i]->next_year = $query_child->realisasi;
            foreach ($monthNames as $key => $name) {
                $sql_real = "select (select IFNULL(sum(ks.pengeluaran),0)
                    from kasir ks 
                    join uraian u on (ks.id_uraian = u.id)
                    join sub_kegiatan sk on (u.id_sub_kegiatan = sk.id)
                    join kegiatan k on (sk.id_kegiatan = k.id)
                    join program p on (k.id_program = p.id)
                    join satker s on (p.id_satker = s.id)
                    where s.id = '".$search['satker']."' 
                        and ks.id_uraian = '".$val->id_uraian."' 
                        and ks.tanggal like ('".$name."%')
                        and ks.jenis = 'BKK' 
                        and ks.tahun_anggaran = '".$search['tahun']."') - 
                    (select IFNULL(sum(ks.pengeluaran),0)
                    from kasir ks 
                    join uraian u on (ks.id_uraian = u.id)
                    join sub_kegiatan sk on (u.id_sub_kegiatan = sk.id)
                    join kegiatan k on (sk.id_kegiatan = k.id)
                    join program p on (k.id_program = p.id)
                    join satker s on (p.id_satker = s.id)
                    where s.id = '".$search['satker']."' 
                        and ks.id_uraian = '".$val->id_uraian."' 
                        and ks.tanggal like ('".$name."%')
                        and ks.jenis = 'BKM'
                        and ks.tahun_anggaran = '".$search['tahun']."') as realisasi
                    ";
                $child_real = $this->db->query($sql_real)->row();
                $result[$i]->rincian[$key] = $child_real->realisasi;
            }
        }
        $data['list_data'] = $result;
        //die(json_encode($data));
        return $data;
        
    }
    
    function total_realisasi_perbulan_persatker($satker, $bname) {
        $sql_real = "select (select IFNULL(sum(ks.pengeluaran),0) 
                    from kasir ks 
                    join uraian u on (ks.id_uraian = u.id)
                    join sub_kegiatan sk on (u.id_sub_kegiatan = sk.id)
                    join kegiatan k on (sk.id_kegiatan = k.id)
                    join program p on (k.id_program = p.id)
                    join satker s on (p.id_satker = s.id)
                    where s.id = '$satker' 
                        and ks.tanggal like ('".$bname."%') and ks.tahun_anggaran = '".substr($bname, 0, 4)."'
                        and ks.jenis = 'BKK') - (select IFNULL(sum(ks.pengeluaran),0)
                    from kasir ks 
                    join uraian u on (ks.id_uraian = u.id)
                    join sub_kegiatan sk on (u.id_sub_kegiatan = sk.id)
                    join kegiatan k on (sk.id_kegiatan = k.id)
                    join program p on (k.id_program = p.id)
                    join satker s on (p.id_satker = s.id)
                    where s.id = '$satker' 
                        and ks.tanggal like ('".$bname."%') and ks.tahun_anggaran = '".substr($bname, 0, 4)."'
                        and ks.jenis = 'BKM') as realisasi
                    ";
        //echo $sql_real;
        return $this->db->query($sql_real);
    }
    
    function load_realisasi_total_satker($bulan, $id_satker = NULL) {
        $q = NULL;
        if ($id_satker !== NULL) {
            $q = "and s.id = '$id_satker'";
        }
        $sql = "select (select IFNULL(sum(ks.pengeluaran),0)
            from kasir ks
            join uraian u on (ks.id_uraian = u.id)
            join sub_kegiatan sk on (u.id_sub_kegiatan = sk.id)
            join kegiatan k on (sk.id_kegiatan = k.id)
            join program p on (k.id_program = p.id)
            join satker s on (p.id_satker = s.id)
            where ks.tanggal like ('".$bulan."%') and ks.tahun_anggaran = '".substr($bulan, 0, 4)."'
                and ks.jenis = 'BKK'
                $q) - (select IFNULL(sum(ks.pengeluaran),0) as total 
            from kasir ks
            join uraian u on (ks.id_uraian = u.id)
            join sub_kegiatan sk on (u.id_sub_kegiatan = sk.id)
            join kegiatan k on (sk.id_kegiatan = k.id)
            join program p on (k.id_program = p.id)
            join satker s on (p.id_satker = s.id)
            where ks.tanggal like ('".$bulan."%') and ks.tahun_anggaran = '".substr($bulan, 0, 4)."'
                and ks.jenis = 'BKM'
                $q) as total";
        //echo $sql."<br/>";
        return $this->db->query($sql);
    }
    
    function get_list_data_rincian_realisasi($limit, $start, $search) {
        $q = NULL;
        if ($search['awal'] !== '' and $search['akhir'] !== '') {
            $q.=" and pg.tanggal between '".$search['awal']."' and '".$search['akhir']."'";
        }
        if ($search['jenis'] !== '') {
            $q.=" and p.status = '".$search['jenis']."'";
        }
        if ($search['satker'] !== '') {
            $q.=" and s.id = '".$search['satker']."'";
        }
        if ($search['tahun'] !== '') {
            $q.=" and pg.tahun_anggaran = '".$search['tahun']."'";
        }
        if ($search['kodema'] !== '') {
            $q.=" and pg.id_uraian = '".$search['kodema']."'";
        }
        if ($search['perwabku'] !== '') {
            $q.=" and pg.perwabku = '".$search['perwabku']."'";
        }
        if ($search['sts_kd_perkiraan'] !== '') {
            if ($search['sts_kd_perkiraan'] === 'Kosong') {
                $q.=" and pg.id_rekening is NULL";
            } else {
                $q.=" and pg.id_rekening is not NULL";
            }
        }
        if ($search['sts_kd_perkiraan_pwk'] !== '') {
            if ($search['sts_kd_perkiraan_pwk'] === 'Kosong') {
                $q.=" and pg.id_rekening_pwk is NULL";
            } else {
                $q.=" and pg.id_rekening_pwk is not NULL";
            }
        }
        $sql = "select pg.id, pg.kode, pg.sumberdana, pg.tanggal, pg.id_rekening, pg.id_renbut, pg.posted, s.nama as satker,
                pg.id_uraian, u.kode as kode_ma, pg.pengeluaran as nominal, pg.penerima as penanggung_jwb, pg.perwabku, substr(pg.kode,1,3) as kode_trans, 
                u.uraian as keterangan, IFNULL(pg.id_renbut,'') as renbut, pg.keterangan as keterangan_kasir, pg.jenis 
                from kasir pg
                left join uraian u on (pg.id_uraian = u.id)
                join sub_kegiatan sk on (u.id_sub_kegiatan = sk.id)
                join kegiatan k on (sk.id_kegiatan = k.id)
                join program p on (k.id_program = p.id)
                join satker s on (p.id_satker = s.id)
                where pg.jenis in ('BKK','BKM') $q order by pg.id desc";
        $limitation = null;
        if ($limit !== NULL) {
            $limitation = " limit $start , $limit";
        }
        $query = $this->db->query($sql . $limitation);
        //echo $sql . $q . $limitation;
        $queryAll = $this->db->query($sql);
        $data['data'] = $query->result();
        $data['jumlah'] = $queryAll->num_rows();
        return $data;
    }
}
?>
