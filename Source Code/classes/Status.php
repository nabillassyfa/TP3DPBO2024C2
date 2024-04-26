<?php


// Saya Nabilla Assyfa Ramadhani [2205297] 
// mengerjakan TP3
// dalam mata Desain dan Pemograman Berorientasi Objek 
// untuk keberkahanNya maka saya tidak melakukan kecurangan 
// seperti yang telah dispesifikasikan. 
// Aamiin

class Status_karyawan extends DB
{
    function getStatus_karyawan()
    {
        $query = "SELECT * FROM status";
        return $this->execute($query);
    }

    function getStatus_karyawanById($id)
    {
        $query = "SELECT * FROM status WHERE id_status=$id";
        return $this->execute($query);
    }
}
