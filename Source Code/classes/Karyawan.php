<?php


// Saya Nabilla Assyfa Ramadhani [2205297] 
// mengerjakan TP3
// dalam mata Desain dan Pemograman Berorientasi Objek 
// untuk keberkahanNya maka saya tidak melakukan kecurangan 
// seperti yang telah dispesifikasikan. 
// Aamiin

class Karyawan extends DB
{
    function getKaryawanJoin()
    {
        $query = "SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan=jabatan.id_jabatan JOIN departemen ON karyawan.id_dept=departemen.id_dept JOIN status ON karyawan.id_status=status.id_status ORDER BY karyawan.id_karyawan";

        return $this->execute($query);
    }

    function getKaryawan()
    {
        $query = "SELECT * FROM karyawan";
        return $this->execute($query);
    }

    function getKaryawanById($id)
    {
        $query = "SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan=jabatan.id_jabatan JOIN departemen ON karyawan.id_dept=departemen.id_dept JOIN status ON karyawan.id_status=status.id_status WHERE id_karyawan=$id";
        return $this->execute($query);
    }

    function getKaryawanByDept($id)
    {
        $query = "SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan=jabatan.id_jabatan JOIN departemen ON karyawan.id_dept=departemen.id_dept JOIN status ON karyawan.id_status=status.id_status WHERE karyawan.id_dept=$id";
        return $this->execute($query);
    }

    function searchKaryawan($keyword, $id)
    {
        $query = "SELECT karyawan.*, departemen.nama_dept, jabatan.nama_jabatan, status.status_karyawan 
        FROM karyawan 
        JOIN departemen ON karyawan.id_dept=departemen.id_dept 
        JOIN jabatan ON karyawan.id_jabatan=jabatan.id_jabatan 
        JOIN status ON karyawan.id_status=status.id_status 
        WHERE karyawan.nama LIKE '%$keyword%' AND karyawan.id_dept = '$id'
        ";

        return $this->execute($query);
    }

    function addData($data, $file)
    {
        $nama = $data['nama'];
        $jenis_kelamin = $data['jenis_kelamin'];
        $gaji = $data['gaji'];
        $tahun_masuk = $data['tahun_masuk'];
        $id_jabatan = $data['id_jabatan'];
        $id_dept = $data['id_dept'];
        $id_status= $data['id_status'];
        $foto = $file['foto_karyawan'];

        if (!empty($nama) && !empty($jenis_kelamin) && !empty($id_status) && !empty($gaji) && !empty($id_jabatan) && !empty($id_dept) && !empty($foto)) {
            $query = "INSERT INTO karyawan VALUES ('', '$id_jabatan', '$id_dept', '$id_status', '$nama', '$jenis_kelamin', '$tahun_masuk', '$gaji', '$foto')";
            return $this->executeAffected($query);
        }
    }

    function updateData($id, $data, $file)
    {
        $nama = $data['nama'];
        $jenis_kelamin = $data['jenis_kelamin'];
        $gaji = $data['gaji'];
        $tahun_masuk = $data['tahun_masuk'];
        $id_jabatan = $data['id_jabatan'];
        $id_dept = $data['id_dept'];
        $id_status= $data['id_status'];
        
        if (isset($file['foto_karyawan'])) {
            $foto_karyawan = $file['foto_karyawan']; 
            $query = "UPDATE karyawan SET foto_karyawan = '$foto_karyawan', gaji = '$gaji', nama = '$nama', jenis_kelamin = '$jenis_kelamin', id_dept = '$id_dept', id_jabatan='$id_jabatan', id_status='$id_status', tahun_masuk='$tahun_masuk' WHERE id_karyawan = '$id'";
        }else{
            $query = "UPDATE karyawan SET gaji = '$gaji', nama = '$nama', jenis_kelamin = '$jenis_kelamin', id_dept = '$id_dept', id_jabatan='$id_jabatan', id_status='$id_status', tahun_masuk='$tahun_masuk' WHERE id_karyawan = '$id'";
        }
        

        return $this->executeAffected($query);
    }

    function deleteData($id)
    {
        $query = "DELETE FROM karyawan WHERE id_karyawan = $id";
        return $this->executeAffected($query);
    }
}
