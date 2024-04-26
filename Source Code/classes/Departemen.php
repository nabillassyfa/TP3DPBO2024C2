<?php

// Saya Nabilla Assyfa Ramadhani [2205297] 
// mengerjakan TP3
// dalam mata Desain dan Pemograman Berorientasi Objek 
// untuk keberkahanNya maka saya tidak melakukan kecurangan 
// seperti yang telah dispesifikasikan. 
// Aamiin

class Departemen extends DB
{
    function getDepartemen()
    {
        $query = "SELECT * FROM departemen";
        return $this->execute($query);
    }

    function getDepartemenById($id)
    {
        $query = "SELECT * FROM departemen WHERE id_dept=$id";
        return $this->execute($query);
    }

    // fungsi memasukan data
    function addDepartemen($data, $file)
    {
        $nama_dept = $data['nama_dept'];
        $foto_dept = $file['foto_dept'];

        if (!empty($nama_dept) && !empty($foto_dept)){
            $query = "INSERT INTO departemen VALUES('', '$nama_dept', '$foto_dept')";
            return $this->executeAffected($query);
        }
    }

    // fungsi update data
    function updateDept($id, $data, $file){
        $nama = $data['nama_dept'];
        
        if (isset($file['foto_dept'])) {   // kondisi jika ada foto yang akan diubah
            $foto_dept = $file['foto_dept']; 
            $query = "UPDATE departemen SET foto_dept = '$foto_dept', nama_dept='$nama' WHERE id_dept = '$id'";
        } else {
            $query = "UPDATE departemen SET nama_dept='$nama' WHERE id_dept = '$id'";
        }
        return $this->executeAffected($query);
    }

    // fungsi untuk menghapus departemen berdasarkan id
    function deleteDepartemen($id)
    {
        $query = "DELETE FROM departemen WHERE id_dept = $id";
        return $this->executeAffected($query);
    }

    // fungsi pencarian berdasarkan nama
    function searchDept ($keyword){
        $query = "SELECT * FROM departemen WHERE nama_dept LIKE '%$keyword%'";
        return $this->execute($query);

    }

    // fungsi untuk mengurutkan secara asc
    function DeptASC (){
        $query = "SELECT * FROM departemen ORDER BY nama_dept ASC";
        return $this->execute($query);
    }

    // fungsi untuk mengurutkan secera desc
    function DeptDESC (){
        $query = "SELECT * FROM departemen ORDER BY nama_dept DESC";
        return $this->execute($query);
    }
}
