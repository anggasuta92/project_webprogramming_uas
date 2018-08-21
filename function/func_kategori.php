<?php

    function getNamaKategori($conn, $idkategori){
        $sql = "select nama_kategori from m_kategori_buku where kategori_buku_id='". $idkategori ."'";
        $exec = mysqli_query($conn, $sql);
        $data = mysqli_fetch_array($exec);
        return $data["nama_kategori"];
    }

    function tampilDataKategoriBuku($conn, $where, $order){
        if(strlen($where)>0){
            $where = " where " . $where;
        }

        if(strlen($order)>0){
            $order = " order by ". $order;
        }
        $sql = "select  * from m_kategori_buku " . $where . " " . $order;
        $exec = mysqli_query($conn, $sql);
        return $exec;
    }

    function cekKategoriDiBuku($conn, $idKategori){
        $sql = "select * from m_buku where kategori_buku_id='". $idKategori ."'";
        $exec = mysqli_query($conn, $sql);
        if(mysqli_num_rows($exec)>0){
            return 1;
        }else{
            return 0;
        }
    }

    function hapusKategori($conn, $kategoriId){
        $sql = "delete from m_kategori_buku where kategori_buku_id='". $kategoriId ."'"; 
        if(mysqli_query($conn, $sql)){
            return 1;
        }else{
            return 0;
        }
    }

    function ubahKategori($conn, $kategori){
        $result = array();
        $sql = "update m_kategori_buku set nama_kategori='". $kategori["nama_kategori"] ."'
                where kategori_buku_id='". $kategori["kategori_buku_id"] ."'";
        
        if($exec = mysqli_query($conn, $sql)){
            $result["info"] = "sukses";
            $result["detail"] = "Kategori berhasil tersimpan.";
            $result["kategori_buku_id"] = mysqli_insert_id($conn);
        }else{
            $result["info"] = "error";
            $result["detail"] = "Kategori gagal disimpan.";
            $result["kategori_buku_id"] = 0;
        }
        return $result;
    }

    function tampilDataKategoriById($conn, $id){
        $result = array();
        $sql = "select * from m_kategori_buku where kategori_buku_id='".$id."'";
        $exec = mysqli_query($conn, $sql);

        if(mysqli_num_rows($exec)>0){
            $data = mysqli_fetch_array($exec);
            $result["kategori_buku_id"] = $data["kategori_buku_id"];
            $result["nama_kategori"] = $data["nama_kategori"];
        }else{
            $result["kategori_buku_id"] = "0";
        }

        return $result;
    }

    function simpanKategori($conn, $kategori){
        $result = array();

        $sql = "insert into m_kategori_buku (nama_kategori) values 
                ('". $kategori["nama_kategori"] ."')";
        
        if($exec = mysqli_query($conn, $sql)){
            $result["info"] = "sukses";
            $result["detail"] = "Kategori berhasil tersimpan.";
            $result["kategori_buku_id"] = mysqli_insert_id($conn);
        }else{
            $result["info"] = "error";
            $result["detail"] = "Kategori gagal disimpan.";
            $result["kategori_buku_id"] = 0;
        }
        return $result;
    }

?>