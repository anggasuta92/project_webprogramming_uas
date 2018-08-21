<?php

    function daftarPenerbit($conn, $where, $order){
        if(strlen($where)>0){
            $where = " where " . $where;
        }
        if(strlen($order)>0){
            $order = " order by ". $order;
        }
        $sql = "select  * from m_penerbit " . $where . " " . $order;
        $exec = mysqli_query($conn, $sql);
        return $exec;
    }

    function cekPenerbitDiDataBuku($conn, $penerbitId){
        $sql = "select * from r_menerbitkan where penerbit_id='". $penerbitId ."'";
        $exec = mysqli_query($conn, $sql);
        if(mysqli_num_rows($exec)>0){
            return 1;
        }else{
            return 0;
        }
    }

    function hapusPenerbit($conn, $penerbitId){
        $sql = "delete from m_penerbit where penerbit_id='". $penerbitId ."'"; 
        if(mysqli_query($conn, $sql)){
            return 1;
        }else{
            return 0;
        }
    }

    function tampilDataPenerbitById($conn, $id){
        $result = array();
        $sql = "select * from m_penerbit where penerbit_id='".$id."'";
        $exec = mysqli_query($conn, $sql);

        if(mysqli_num_rows($exec)>0){
            $data = mysqli_fetch_array($exec);
            $result["penerbit_id"] = $data["penerbit_id"];
            $result["nama_penerbit"] = $data["nama_penerbit"];
            $result["alamat_penerbit"] = $data["alamat_penerbit"];
        }else{
            $result["penerbit_id"] = "0";
        }

        return $result;
    }

    function ubahPenerbit($conn, $penerbit){
        $result = array();
        $sql = "update m_penerbit set nama_penerbit='". $penerbit["nama_penerbit"] ."', alamat_penerbit='". $penerbit["alamat_penerbit"] ."' 
                where penerbit_id='". $penerbit["penerbit_id"] ."'";
        
        if($exec = mysqli_query($conn, $sql)){
            $result["info"] = "sukses";
            $result["detail"] = "Penerbit berhasil tersimpan.";
            $result["penerbit_id"] = mysqli_insert_id($conn);
        }else{
            $result["info"] = "error";
            $result["detail"] = "Penerbit gagal disimpan.";
            $result["penerbit_id"] = 0;
        }
        return $result;
    }

    function simpanPenerbit($conn, $penerbit){
        $result = array();

        $sql = "insert into m_penerbit (nama_penerbit, alamat_penerbit) values 
                ('". $penerbit["nama_penerbit"] ."', '". $penerbit["alamat_penerbit"] ."')";
        
        if($exec = mysqli_query($conn, $sql)){
            $result["info"] = "sukses";
            $result["detail"] = "Penerbit berhasil tersimpan.";
            $result["penerbit_id"] = mysqli_insert_id($conn);
        }else{
            $result["info"] = "error";
            $result["detail"] = "Penerbit gagal disimpan.";
            $result["penerbit_id"] = 0;
        }
        return $result;
    }

?>