<?php

// Saya Nabilla Assyfa Ramadhani [2205297] 
// mengerjakan TP3
// dalam mata Desain dan Pemograman Berorientasi Objek 
// untuk keberkahanNya maka saya tidak melakukan kecurangan 
// seperti yang telah dispesifikasikan. 
// Aamiin

// deklarasi library
include('config/db.php');
include('classes/DB.php');
include('classes/Karyawan.php');
include('classes/Template.php');

$karyawan = new karyawan($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$karyawan->open();  // membuka koneksi

$data = nulL;

if (isset($_GET['id'])) {  
    $id = $_GET['id'];
    if ($id > 0) {
        $karyawan->getKaryawanById($id);
        $row = $karyawan->getResult();

        // menampilkan data
        $data .= '<div class="card-header text-center">
        <h3 class="my-0">Detail ' . $row['nama'] . '</h3>
        </div>
        <div class="card-body text-end">
        <form action="#" method="POST">
            <div class="row mb-5">
                <div class="col-3">
                    <div class="row justify-content-center">
                        <img src="assets/images/' . $row['foto_karyawan'] . '" class="img-thumbnail" alt="' . $row['foto_karyawan'] . '" width="60">
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="card px-3">
                            <table border="0" class="text-start">
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>' . $row['nama'] . '</td>
                                </tr>
                                <tr>
                                    <td>Divisi</td>
                                    <td>:</td>
                                    <td>' . $row['jenis_kelamin'] . '</td>
                                </tr>
                                <tr>
                                    <td>NIM</td>
                                    <td>:</td>
                                    <td>' . $row['nama_dept'] . '</td>
                                </tr>
                                <tr>
                                    <td>Semester</td>
                                    <td>:</td>
                                    <td>' . $row['nama_jabatan'] . '</td>
                                </tr>
                                <tr>
                                    <td>Jabatan</td>
                                    <td>:</td>
                                    <td>' . $row['tahun_masuk'] . '</td>
                                </tr>
                                <tr>
                                    <td>Jabatan</td>
                                    <td>:</td>
                                    <td>' . $row['gaji'] . '</td>
                                </tr>
                                <tr>
                                    <td>Jabatan</td>
                                    <td>:</td>
                                    <td>' . $row['status_karyawan'] . '</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
            <a href="ubah.php?id=' . $row['id_karyawan'] . '"><button type="button" class="btn btn-success text-white">Ubah Data</button></a>
            <a href="index.php" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')"><button type="submit" class="btn btn-danger" name="btn-hapus">Hapus</button></a>
            </form>
            </div>';

        // Mengahapus data
        if (isset($_POST['btn-hapus'])) {
            if ($id > 0) {
                if ($karyawan->deleteData($id) > 0) {
                    echo "<script>
                        alert('Data berhasil dihapus!');
                        document.location.href = 'index.php';
                    </script>";
                } else {
                    echo "<script>
                        alert('Data gagal dihapus!');
                        document.location.href = 'index.php';
                    </script>";
                }
            }
        }
    }
}

$karyawan->close();
$detail = new Template('templates/skinform.html');
$detail->replace('DATA_KARYAWAN', $data);
$detail->write();
