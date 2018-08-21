<?php
    function cekLoginMember($conn, $username, $password){
        $result = array();
        $username = mysqli_escape_string($conn, $username);     //cek karakter aneh
        $password = mysqli_escape_string($conn, $password);     //cek karakter aneh

        $sql = "select * from m_pengguna where username='". $username ."' and password=md5('". $password ."')";
        $exec = mysqli_query($conn, $sql);
        
        if($exec){
            $data = mysqli_fetch_array($exec);
            if($data["aktif"]==1){
                $result["info"] = "sukses";
                $result["pesan"] = "";
                $_SESSION["user"] = $data["pengguna_id"];
                if($data["hak_akses"]=="admin"){
                    $_SESSION["uid"] = $data["pengguna_id"];
                }
            }else{
                if(mysqli_num_rows($exec)>0){
                    $result["info"] = "error";
                    $result["pesan"] = "User anda tidak aktif.";
                }else{
                    $result["info"] = "error";
                    $result["pesan"] = "Anda belum terdaftar.";
                }
            }
            $result["pesan"] = "Anda belum terdaftar." . $data["hak_akses"];
        }else{
            $result["info"] = "error";
            $result["pesan"] = "Terjadi kesalahan.";
        }
        return $result;
    }

    function cekStatusLoginMember(){
        $result = false;
        if(isset($_SESSION["user"])){
            $result = true;
        }
        return $result;
    }

    function getNamaPenggunaMember($conn, $penggunaId){
        $result = "";
        
        $sql = "select pengguna_id, username from m_pengguna where pengguna_id='". $penggunaId ."'";
        $exec = mysqli_query($conn, $sql);
        $data = mysqli_fetch_array($exec);
        $result = $data["username"];

        return $result;
    }

?>