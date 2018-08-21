<?php
    function tampilMenulis($conn, $bukuId){
        $sql =  "SELECT m.menulis_id, p.nama_penulis, p.penulis_id, b.buku_id FROM m_buku b
                INNER JOIN r_menulis m ON b.buku_id=m.buku_id
                INNER JOIN m_penulis p ON m.penulis_id=p.penulis_id where b.buku_id='".$bukuId."' order by m.menulis_id asc;";
        $exec = mysqli_query($conn, $sql);
        return $exec;
    }

    function simpanMenulis($conn, $bukuId, $penulisId){
        $result = mysqli_query($conn, "insert into r_menulis (buku_id, penulis_id) values ('".$bukuId."','".$penulisId."');");
        if($result){
            return 1;
        }else{
            return 0;
        }
    }

    function hapusMenulis($conn, $menulisId){
        $sql = "delete from r_menulis where menulis_id='". $menulisId ."'"; 
        if(mysqli_query($conn, $sql)){
            return 1;
        }else{
            return 0;
        }
    }

?>