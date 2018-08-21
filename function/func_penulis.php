<?php

    function daftarPenulis($conn, $where, $order){
        if(strlen($where)>0){
            $where = " where " . $where;
        }

        if(strlen($order)>0){
            $order = " order by ". $order;
        }

        $sql = "select  * from m_penulis " . $where . " " . $order;
        $exec = mysqli_query($conn, $sql);
        return $exec;
    }

    function tampilDataPenulisById($conn, $id){
        $result = array();
        $sql = "select * from m_penulis where penulis_id='".$id."'";
        $exec = mysqli_query($conn, $sql);

        if(mysqli_num_rows($exec)>0){
            $data = mysqli_fetch_array($exec);
            $result["penulis_id"] = $data["penulis_id"];
            $result["nama_penulis"] = $data["nama_penulis"];
            $result["jenis_kelamin"] = $data["jenis_kelamin"];
            $result["alamat"] = $data["alamat"];
            $result["tanggal_lahir"] = $data["tanggal_lahir"];
        }else{
            $result["penulis_id"] = "0";
        }

        return $result;
    }

    function simpanPenulis($conn, $penulis){
        $result = array();

        $sql = "insert into m_penulis (nama_penulis, jenis_kelamin, alamat, tanggal_lahir) values 
                ('".$penulis["nama_penulis"]."','".$penulis["jenis_kelamin"]."','".$penulis["alamat"]."','".$penulis["tanggal_lahir"]."')";
        
        if($exec = mysqli_query($conn, $sql)){
            $result["info"] = "sukses";
            $result["detail"] = "Penulis berhasil tersimpan.";
            $result["penulis_id"] = mysqli_insert_id($conn);
        }else{
            $result["info"] = "error";
            $result["detail"] = "Penulis gagal disimpan.";
            $result["penulis_id"] = 0;
        }
        return $result;
    }

    function ubahPenulis($conn, $penulis){
        $result = array();
        $sql = "update m_penulis set nama_penulis='". $penulis["nama_penulis"] ."',
                jenis_kelamin='". $penulis["jenis_kelamin"] ."', alamat='". $penulis["alamat"] ."', tanggal_lahir='". $penulis["tanggal_lahir"] ."' 
                where penulis_id='". $penulis["penulis_id"] ."'";
        
        if($exec = mysqli_query($conn, $sql)){
            $result["info"] = "sukses";
            $result["detail"] = "Penulis berhasil tersimpan.";
            $result["penulis_id"] = mysqli_insert_id($conn);
        }else{
            $result["info"] = "error";
            $result["detail"] = "Penulis gagal disimpan.";
            $result["penulis_id"] = 0;
        }
        return $result;
    }

    function cekPenulisDiDataBuku($conn, $penulisId){
        $sql = "select * from r_menulis where penulis_id='". $penulisId ."'";
        $exec = mysqli_query($conn, $sql);
        if(mysqli_num_rows($exec)>0){
            return 1;
        }else{
            return 0;
        }
    }

    function hapusPenulis($conn, $penulisId){
        $sql = "delete from m_penulis where penulis_id='". $penulisId ."'"; //hapus detailnya dulu
        if(mysqli_query($conn, $sql)){
            return 1;
        }else{
            return 0;
        }
    }

?>