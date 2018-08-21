<?php
    function simpanPeminjaman($conn, $peminjaman){
        $sql = "insert into t_peminjaman (tanggal_pinjam, anggota_id, buku_id, lama_pinjam, pinjam_pengguna_id) values 
                ('".$peminjaman["tanggal_pinjam"]."','".$peminjaman["anggota_id"]."','".$peminjaman["buku_id"]."',
                '".$peminjaman["lama_pinjam"]."','".$peminjaman["pinjam_pengguna_id"]."')";
        if(mysqli_query($conn, $sql)){
            return 1;
        }else{
            return 0;
        }
    }

    function cekBukuTerpinjam($conn, $bukuId, $anggotaId){
        $sql = "SELECT * FROM t_peminjaman WHERE anggota_id='".$anggotaId."' AND buku_id='".$bukuId."' AND tanggal_kembali IS NULL";
        if($exec = mysqli_query($conn, $sql)){
            if(mysqli_num_rows($exec)>0){
                return 1;
            }else{
                return 0;
            }
        }
    }

    function daftarPeminjaman($conn, $where, $order){
        if(strlen($where)>0){
            $where = " where " . $where;
        }
        if(strlen($order)>0){
            $order = " order by ". $order;
        }
        $sql = "select  * from t_peminjaman " . $where . " " . $order;
        $exec = mysqli_query($conn, $sql);
        return $exec;
    }

    function selisihtanggal($kembali, $pinjam){
        $arr1 = explode("-", $kembali);
        $arr2 = explode("-", $pinjam);
        $date1 = $arr1[0] . "/" . $arr1[1] . "/" . $arr1[2];
        $date2 = $arr2[0] . "/" . $arr2[1] . "/" . $arr2[2];

        $selisih = ((abs(strtotime ($date1) - strtotime ($date2)))/(60*60*24));
        return $selisih;
    }

    function getInfoPinjam($conn, $pinjamId){
        $result= array();
        $sql = "select * from t_peminjaman where peminjaman_id='".$pinjamId."'";
        $exec = mysqli_query($conn, $sql);
        if(mysqli_num_rows($exec)){
            $data = mysqli_fetch_array($exec);
            $result["peminjaman_id"] = $data["peminjaman_id"];
            $result["tanggal_pinjam"] = $data["tanggal_pinjam"];
            $result["lama_pinjam"] = $data["lama_pinjam"];
            $result["buku_id"] = $data["buku_id"];
        }else{
            $result["peminjaman_id"] = 0;
        }
        return $result;
    }


    function simpanPengembalian($conn, $peminjaman){
        $sql = "UPDATE t_peminjaman SET tanggal_kembali='".$peminjaman["tanggal_kembali"]."', denda='".$peminjaman["denda"]."', kembali_pengguna_id='".$peminjaman["kembali_pengguna_id"]."'
                WHERE peminjaman_id='".$peminjaman["peminjaman_id"]."'";
        mysqli_query($conn, $sql);
    }

?>