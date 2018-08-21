<?php
    function getJumlahSemuaBuku($conn){
        $result = 0;
        $sql = "SELECT COUNT(*) AS jml FROM m_buku b INNER JOIN m_buku_detail bd ON b.buku_id=bd.buku_detail_id";
        $exec = mysqli_query($conn, $sql);
        $data = mysqli_fetch_array($exec);
        $result = $data["jml"];
    }

    function daftarBuku($conn, $where, $order){
        if(strlen($where)>0){
            $where = " where " . $where;
        }

        if(strlen($order)>0){
            $order = " order by ". $order;
        }

        $sql = "select  * from m_buku " . $where . " " . $order;
        $exec = mysqli_query($conn, $sql);
        return $exec;
    }

    function tampilDataBukuById($conn, $id){
        $result = array();
        $sql = "select * from m_buku where buku_id='".$id."'";
        $exec = mysqli_query($conn, $sql);

        if(mysqli_num_rows($exec)>0){
            $data = mysqli_fetch_array($exec);
            $result["buku_id"] = $data["buku_id"];
            $result["kode_buku"] = $data["kode_buku"];
            $result["nama_buku"] = $data["nama_buku"];
            $result["barcode"] = $data["barcode"];
            $result["isbn"] = $data["isbn"];
            $result["nama_rak"] = $data["nama_rak"];
            $result["stok_buku"] = $data["stok_buku"];
            $result["url_ebook"] = $data["url_ebook"];
            $result["kategori_buku_id"] = $data["kategori_buku_id"];
        }else{
            $result["buku_id"] = "0";
        }

        return $result;
    }

    function tampilUrlEbookByBukuId($conn, $id){
        $sql = "select url_ebook from m_buku where buku_id='".$id."'";
        $exec = mysqli_query($conn, $sql);

        if(mysqli_num_rows($exec)>0){
            $data = mysqli_fetch_array($exec);
            return $data["url_ebook"];
        }else{
            return "";
        }
    }

    function simpanBuku($conn, $buku){
        $result = array();

        $sql = "insert into m_buku (kode_buku, nama_buku, barcode, isbn, kategori_buku_id, nama_rak, stok_buku) values 
                ('".$buku["kode_buku"]."','".$buku["nama_buku"]."','".$buku["barcode"]."','".$buku["isbn"]."',
                '".$buku["kategori_buku_id"]."', '".$buku["nama_rak"]."', '".$buku["stok_buku"]."')";
        
        if($exec = mysqli_query($conn, $sql)){
            $result["info"] = "sukses";
            $result["detail"] = "Buku berhasil tersimpan.";
            $result["buku_id"] = mysqli_insert_id($conn);
        }else{
            $result["info"] = "error";
            $result["detail"] = "Buku gagal disimpan.";
            $result["buku_id"] = 0;
        }
        return $result;
    }

    function ubahBuku($conn, $buku){
        $result = array();

        $sql = "update m_buku set kode_buku='".$buku["kode_buku"]."', nama_buku='".$buku["nama_buku"]."', 
                barcode='".$buku["barcode"]."', isbn='".$buku["isbn"]."', kategori_buku_id='".$buku["kategori_buku_id"]."',
                nama_rak='".$buku["nama_rak"]."', stok_buku='".$buku["stok_buku"]."'
                where buku_id='". $buku["buku_id"] ."'";
        
        if($exec = mysqli_query($conn, $sql)){
            $result["info"] = "sukses";
            $result["detail"] = "Buku berhasil tersimpan.";
            $result["buku_id"] = mysqli_insert_id($conn);
        }else{
            $result["info"] = "error";
            $result["detail"] = "Buku gagal disimpan.";
            $result["buku_id"] = 0;
        }
        return $result;
    }

    function kodeBukuOtomatis($conn){
        $sql = "SELECT RIGHT(CONCAT(\"00000\", IFNULL(IF(MAX(RIGHT(kode_buku,5))=\"\",1,MAX(RIGHT(kode_buku,5))+1),1)),5) AS nextNumber FROM m_buku";
        $exec = mysqli_query($conn, $sql);
        $data = mysqli_fetch_array($exec);
        return "BK" . $data["nextNumber"];
    }

    function cekDataPeminjamanBuku($idbuku, $conn){   // ada apa tidak 
        $result = 0;
        $sql = "SELECT b.buku_id FROM t_peminjaman p " .
                "INNER JOIN m_buku_detail bd ON p.buku_detail_id=bd.buku_detail_id ".
                "INNER JOIN m_buku b ON bd.buku_id=b.buku_id where b.buku_id='". $idbuku ."'";
        
        $exec = mysqli_query($conn, $sql);
        if(mysqli_num_rows($exec)>0){
            $result = 1;
        }
        return $result;
    }

    function hapusBuku($conn, $bukuId){
        $sql = "delete from m_buku_detail where buku_id='". $bukuId ."'"; //hapus detailnya dulu
        if(mysqli_query($conn, $sql)){
            $sql = "delete from m_buku where buku_id='". $bukuId ."'";  // hapus detailnya setelahnya
            if(mysqli_query($conn, $sql)){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }

    function perbaharuiLinkEbook($conn, $filename, $buku){
        $sql = "update m_buku set url_ebook='". $filename ."' where buku_id='".$buku["buku_id"]."';";
        if(mysqli_query($conn, $sql)){
            return 1;
        }else{
            return 0;
        }
    }

    function ubahStokBuku($conn, $penambahan, $bukuId){
        $sql = "UPDATE m_buku SET stok_buku=stok_buku+".$penambahan." WHERE buku_id='".$bukuId ."'";
        mysqli_query($conn, $sql);
    }
?>