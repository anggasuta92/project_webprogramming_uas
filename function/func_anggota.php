<?php
    function tampilDataAnggota($conn, $where, $order){
        if(strlen($where)>0){
            $where = " where " . $where;
        }

        if(strlen($order)>0){
            $order = " order by ". $order;
        }
        $sql = "select  * from m_anggota " . $where . " " . $order;
        $exec = mysqli_query($conn, $sql);
        return $exec;
    }

function findAnggotaById($conn, $id){
        $result = array();
        $sql = "select * from m_anggota where anggota_id='". $id ."'";
        $exec = mysqli_query($conn, $sql);
        if($exec && mysqli_num_rows($exec)>0){
            $data = mysqli_fetch_array($exec);
            $result["anggota_id"] = $data["anggota_id"];
            $result["kode_anggota"] = $data["kode_anggota"];
            $result["nama_anggota"] = $data["nama_anggota"];
            $result["jenis_kelamin_anggota"] = $data["jenis_kelamin_anggota"];
            $result["tempat_lahir_anggota"] = $data["tempat_lahir_anggota"];
            $result["tanggal_lahir_anggota"] = $data["tanggal_lahir_anggota"];
            $result["alamat_anggota"] = $data["alamat_anggota"];
            $result["email_anggota"] = $data["email_anggota"];
            //$result["status"] = $data["status"];
            $result["tgl_menjadi_anggota"] = $data["tgl_menjadi_anggota"];
        }else{
            $result["anggota_id"] = 0;
        }
        return $result;
    }

    function findAnggotaByKode($conn, $kode){
        $result = array();
        $sql = "select * from m_anggota where kode_anggota='". $kode ."'";
        $exec = mysqli_query($conn, $sql);
        if($exec && mysqli_num_rows($exec)>0){
            $data = mysqli_fetch_array($exec);
            $result["anggota_id"] = $data["anggota_id"];
            $result["kode_anggota"] = $data["kode_anggota"];
            $result["nama_anggota"] = $data["nama_anggota"];
            $result["jenis_kelamin_anggota"] = $data["jenis_kelamin_anggota"];
            $result["tempat_lahir_anggota"] = $data["tempat_lahir_anggota"];
            $result["tanggal_lahir_anggota"] = $data["tanggal_lahir_anggota"];
            $result["alamat_anggota"] = $data["alamat_anggota"];
            $result["email_anggota"] = $data["email_anggota"];
            //$result["status"] = $data["status"];
            $result["tgl_menjadi_anggota"] = $data["tgl_menjadi_anggota"];
        }else{
            $result["anggota_id"] = 0;
        }
        return $result;
    }
	
    function getJumlahSemuaAnggota($conn){
        $result = 0;
        $sql = "SELECT COUNT(*) AS jml FROM m_anggota";
        $exec = mysqli_query($conn, $sql);
        $data = mysqli_fetch_array($exec);
        $result = $data["jml"];
    }


    function kodeAnggotaOtomatis($conn){
        $sql = "SELECT RIGHT(CONCAT(\"00000\", IFNULL(IF(MAX(RIGHT(kode_anggota,5))=\"\",1,MAX(RIGHT(kode_anggota,5))+1),1)),5) AS nextNumber FROM m_anggota";
        $exec = mysqli_query($conn, $sql);
        $data = mysqli_fetch_array($exec);
        return "AGT" . $data["nextNumber"];
    }

     function simpanAnggota($conn, $anggota){
        $result = array();

        $sql = "insert into m_anggota (kode_anggota,nama_anggota, jenis_kelamin_anggota, tempat_lahir_anggota, tanggal_lahir_anggota, alamat_anggota, email_anggota, tgl_menjadi_anggota) values 
                ('".$anggota["kode_anggota"]."','".$anggota["nama_anggota"]."','".$anggota["jenis_kelamin_anggota"]."','".$anggota["tempat_lahir_anggota"]."', '".$anggota["tanggal_lahir_anggota"]."', '".$anggota["alamat_anggota"]."', '".$anggota["email_anggota"]."', '".$anggota["tgl_menjadi_anggota"]."')";
        
        if($exec = mysqli_query($conn, $sql)){
            $result["info"] = "sukses";
            $result["detail"] = "anggota berhasil tersimpan.";
            $result["anggota_id"] = mysqli_insert_id($conn);
        }else{
            $result["info"] = "error";
            $result["detail"] = "Anggota gagal disimpan.";
            $result["anggota_id"] = 0;
        }
        return $result;
    }
	
    function tampilDataAnggotaById($conn, $id){
        $result = array();
        $sql = "select * from m_anggota where anggota_id='".$id."'";
        $exec = mysqli_query($conn, $sql);

        if(mysqli_num_rows($exec)>0){
            $data = mysqli_fetch_array($exec);
            $result["anggota_id"] = $data["anggota_id"];
            $result["kode_anggota"] = $data["kode_anggota"];
            $result["nama_anggota"] = $data["nama_anggota"];
            $result["jenis_kelamin_anggota"] = $data["jenis_kelamin_anggota"];
            $result["tempat_lahir_anggota"] = $data["tempat_lahir_anggota"];
            $result["tanggal_lahir_anggota"] = $data["tanggal_lahir_anggota"];
            $result["alamat_anggota"] = $data["alamat_anggota"];
            $result["email_anggota"] = $data["email_anggota"];
            //$result["status"] = $data["status"];
            $result["tgl_menjadi_anggota"] = $data["tgl_menjadi_anggota"];
        }else{
            $result["anggota_id"] = "0";
        }

        return $result;
    }

    function ubahAnggota($conn, $anggota){
        $result = array();

        $sql = "update m_anggota set kode_anggota='".$anggota["kode_anggota"]."', nama_anggota='".$anggota["nama_anggota"]."', jenis_kelamin_anggota='".$anggota["jenis_kelamin_anggota"]."', tempat_lahir_anggota='".$anggota["tempat_lahir_anggota"]."', tanggal_lahir_anggota='".$anggota["tanggal_lahir_anggota"]."', alamat_anggota='".$anggota["alamat_anggota"]."', email_anggota='".$anggota["email_anggota"]."' 
            where anggota_id='". $anggota["anggota_id"] ."'";
        
        if($exec = mysqli_query($conn, $sql)){
            $result["info"] = "sukses";
            $result["detail"] = "Anggota berhasil tersimpan.";
            $result["anggota_id"] = mysqli_insert_id($conn);
        }else{
            $result["info"] = "error";
            $result["detail"] = "Anggota gagal disimpan.";
            $result["anggota_id"] = 0;
        }
        return $result;
    }
	
?>