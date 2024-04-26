<?php


// Saya Nabilla Assyfa Ramadhani [2205297] 
// mengerjakan TP3
// dalam mata Desain dan Pemograman Berorientasi Objek 
// untuk keberkahanNya maka saya tidak melakukan kecurangan 
// seperti yang telah dispesifikasikan. 
// Aamiin

class Jabatan extends DB
{
    function getJabatan()
    {
        $query = "SELECT * FROM jabatan";
        return $this->execute($query);
    }

    function getJabatanById($id)
    {
        $query = "SELECT * FROM jabatan WHERE id_jabatan=$id";
        return $this->execute($query);
    }

    function addJabatan($data)
    {
        $nama_jabatan = $data['nama_jabatan'];
        $query = "INSERT INTO jabatan VALUES('', '$nama_jabatan')";
        return $this->executeAffected($query);
    }

    function updateJabatan($id, $data)
    {
        $nama_jabatan = $data['nama_jabatan'];
        $query = "UPDATE jabatan SET nama_jabatan = '$nama_jabatan' WHERE id_jabatan = '$id'";
        return $this->executeAffected($query);
    }

    function deleteJabatan($id)
    {
        $query = "DELETE FROM jabatan WHERE id_jabatan = $id";
        return $this->executeAffected($query);
    }

    function searchJabatan ($keyword){
        $query = "SELECT * FROM jabatan WHERE nama_jabatan LIKE '%$keyword%'";
        return $this->execute($query);
    }

    function JabatanASC (){
        $query = "SELECT * FROM Jabatan ORDER BY nama_jabatan ASC";
        return $this->execute($query);
    }

    function JabatanDESC (){
        $query = "SELECT * FROM Jabatan ORDER BY nama_jabatan DESC";
        return $this->execute($query);
    }
}
