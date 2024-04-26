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
include('classes/departemen.php');
include('classes/Jabatan.php');
include('classes/Karyawan.php');
include('classes/Status.php');
include('classes/Template.php');

// membuat instance karyawan
$karyawan = new Karyawan($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$karyawan->open();

// membuat instance departemen
$departemen = new Departemen ($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$departemen->open();

// membuat instance jabatan
$jabatan = new Jabatan ($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$jabatan->open();

// membuat instance status karyawan
$status = new Status_karyawan ($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$status->open();

$data = nulL;
    
$departemen->getdepartemen();
$jabatan->getJabatan();
$status->getStatus_karyawan();

// menampilkan form tambah data
$data .=   '<div class="card-header text-center">
<h1 class="my-0">Tambah Data karyawan </h1>
</div>
<div class="card-body text-end">
    <form action="#" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_karyawan">
        <div class="row mb-5">
            <div class="col-3">
                <div class="row justify-content-center">
                    <input type="file" name="foto_karyawan">
                </div>
            </div>
            <div class="col-9">
                <div class="card px-3">
                    <table border="0" class="text-start">
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td><input type="text" name="nama" class="form-control me-2"></td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>:</td>
                            <td>
                                <select name ="jenis_kelamin" class="form-control me-2">
                                    <option value="Perempuan">Perempuan</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Besar Gaji</td>
                            <td>:</td>
                            <td><input type="text" name="gaji"  class="form-control me-2"></td>
                        </tr>
                        <tr>
                            <td>Tahun Masuk</td>
                            <td>:</td>
                            <td><input type="text" name="tahun_masuk"  class="form-control me-2"></td>
                        </tr>
                        <tr>
                            <td>Nama Departemen</td>
                            <td>:</td>
                            <td>
                                <select name="id_dept" class="form-control me-2">';
                                $no = 1;
                                while ($div = $departemen->getResult()) {
                                    $data .= "<option value=" . $div['id_dept'] . ">" . $div['nama_dept'] . "</option>";
                                    $no++;
                                }                                        
                                $data .= '</select>
                            
                            </td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td>:</td>
                            <td>
                                <select name="id_jabatan" class="form-control me-2">';
                                $i = 1;
                                while ($job = $jabatan->getResult()) {
                                    $data .= "<option value=" . $job['id_jabatan'] . ">" . $job['nama_jabatan'] . "</option>";
                                    $i++;
                                }                                        
                                $data .= '</select>
                            </td>
                        </tr>
                        <tr>
                            <td>Status Karyawan</td>
                            <td>:</td>
                            <td>
                                <select name="id_status" class="form-control me-2">';
                                $i = 1;
                                while ($ket = $status->getResult()) {
                                    $data .= "<option value=" . $ket['id_status'] . ">" . $ket['status_karyawan'] . "</option>";
                                    $i++;
                                }                                        
                                $data .= '</select>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-success text-white" name="btn-add">Tambah Data</button>
        </div>
    </form>
</div>';

// menambahkan data kedalam database      
if (isset($_POST['btn-add'])) {
    $data = array(  // menampung data kedalam array
        'nama' => $_POST['nama'], 
        'gaji' => $_POST['gaji'],
        'tahun_masuk' => $_POST['tahun_masuk'],
        'jenis_kelamin' => $_POST['jenis_kelamin'],
        'id_jabatan' => $_POST['id_jabatan'],
        'id_dept' => $_POST['id_dept'],
        'id_status' => $_POST['id_status']
    );

    $targetDirectory = "assets/images/";  // direktori untuk menyimpan file
    if ($_FILES['foto_karyawan']['name']) {
       
        $targetFilePath = $targetDirectory . basename($_FILES['foto_karyawan']['name']);
        if (move_uploaded_file($_FILES['foto_karyawan']['tmp_name'], $targetFilePath)) {
            $file = array(
                'foto_karyawan' => basename($_FILES['foto_karyawan']['name'])
            );
        }
    } else {
        $file = array(); 
    }

    $result = $karyawan->addData($data, $file);

    if ($result) { // kondisi jika berhasil memasukan data
        echo "<script>
        alert('Data berhasil ditambah!');
        document.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal ditambah!');
            document.location.href = 'index.php';
        </script>";
    }
}
   
$karyawan->close();
$detail = new Template('templates/skinform.html');
$detail->replace('DATA_KARYAWAN', $data);
$detail->write();
