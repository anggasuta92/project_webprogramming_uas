<?php
    function tampilMenerbitkan($conn, $bukuId){
        $sql =  "SELECT m.menerbitkan_id, p.nama_penerbit, p.penerbit_id, m.tahun_terbit, b.buku_id FROM m_buku b
                INNER JOIN r_menerbitkan m ON b.buku_id=m.buku_id
                INNER JOIN m_penerbit p ON m.penerbit_id=p.penerbit_id where b.buku_id='".$bukuId."' order by m.menerbitkan_id asc;";
        $exec = mysqli_query($conn, $sql);
        return $exec;
    }

    function simpanMenerbitkan($conn, $bukuId, $penerbitId, $tahunTerbit){
        $result = mysqli_query($conn, "insert into r_menerbitkan (buku_id, penerbit_id, tahun_terbit) values ('".$bukuId."','".$penerbitId."', '".$tahunTerbit."');");
        if($result){
            return 1;
        }else{
            return 0;
        }
    }

    function hapusMenerbitkan($conn, $menerbitkanId){
        $sql = "delete from r_menerbitkan where menerbitkan_id='". $menerbitkanId ."'"; 
        if(mysqli_query($conn, $sql)){
            return 1;
        }else{
            return 0;
        }
    }

?>