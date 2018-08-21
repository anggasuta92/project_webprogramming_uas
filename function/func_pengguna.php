<?php
	
	function tampilPengguna($conn, $where, $order){
        if(strlen($where)>0){
            $where = " where " . $where;
        }

        if(strlen($order)>0){
            $order = " order by ". $order;
        }
        $sql = "select  * from m_pengguna " . $where . " " . $order;
        $exec = mysqli_query($conn, $sql);
        return $exec;
    }
	
	function tampilPenggunaById($conn, $id){
		$result = array();
        $sql = "select * from m_pengguna where pengguna_id='".$id."'";
        $exec = mysqli_query($conn, $sql);

        if(mysqli_num_rows($exec)>0){
            $data = mysqli_fetch_array($exec);
            $result["pengguna_id"] = $data["pengguna_id"];
			$result["username"] = $data["username"];
			$result["password"] = $data["password"];
			$result["nama_lengkap"] = $data["nama_lengkap"];
			$result["hak_akses"] = $data["hak_akses"];
			$result["tanggal_terdaftar"] = $data["tanggal_terdaftar"];
			$result["aktif"] = $data["aktif"];

        }else{
            $result["pengguna_id"] = "0";
        }

        return $result;
	}
	
	function ubahPengguna($conn, $pengguna){
		$strupdatepass = "";
		if($pengguna["password"]!=""){
			$strupdatepass = "PASSWORD='".$pengguna["password"]."',";
		}
		
		$sql = "UPDATE m_pengguna SET
				username='".$pengguna["username"]."', ". $strupdatepass ." nama_lengkap='".$pengguna["nama_lengkap"]."',
				hak_akses='".$pengguna["hak_akses"]."', aktif='".$pengguna["aktif"]."'
				WHERE pengguna_id='".$pengguna["pengguna_id"]."';";
				
        if($exec = mysqli_query($conn, $sql)){
            $result["info"] = "sukses";
            $result["detail"] = "Pengguna berhasil tersimpan.";
            $result["pengguna_id"] = $pengguna["pengguna_id"];
        }else{
            $result["info"] = "error";
            $result["detail"] = "Pengguna gagal disimpan.";
            $result["pengguna_id"] = 0;
        }
        return $result;
	}
	
	function simpanPengguna($conn, $pengguna){
		$sql = "INSERT INTO m_pengguna (username, password, nama_lengkap, hak_akses, tanggal_terdaftar, aktif) VALUES
				('".$pengguna["username"]."','".$pengguna["password"]."','".$pengguna["nama_lengkap"]."',
				'".$pengguna["hak_akses"]."','".$pengguna["tanggal_terdaftar"]."','".$pengguna["aktif"]."')";
				
        if($exec = mysqli_query($conn, $sql)){
            $result["info"] = "sukses";
            $result["detail"] = "Pengguna berhasil tersimpan.";
            $result["pengguna_id"] = mysqli_insert_id($conn);
        }else{
            $result["info"] = "error";
            $result["detail"] = "Pengguna gagal disimpan.";
            $result["pengguna_id"] = 0;
        }
        return $result;
		
	}

?>