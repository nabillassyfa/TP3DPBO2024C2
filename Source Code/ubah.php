<?php

// Saya Nabilla Assyfa Ramadhani [2205297] 
// mengerjakan TP3
// dalam mata Desain dan Pemograman Berorientasi Objek 
// untuk keberkahanNya maka saya tidak melakukan kecurangan 
// seperti yang telah dispesifikasikan. 
// Aamiin


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

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        $karyawan->getkaryawanById($id);
        $departemen->getdepartemen();
        $jabatan->getJabatan();
        $status->getStatus_karyawan();
        
        $row = $karyawan->getResult();

        // menampilkan data karyawan yang akan diubah
        $data .=   '<div class="card-header text-center">
        <h1 class="my-0">Ubah Data karyawan </h1>
        </div>
        <div class="card-body text-end">
            <form action="#" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_karyawan" value="' . $row['id_karyawan'] . '">
                <div class="row mb-5">
                    <div class="col-3">
                        <div class="row justify-content-center">
                            <img src="assets/images/' . $row['foto_karyawan'] . '" class="img-thumbnail" alt="' . $row['foto_karyawan'] . '" width="60">
                            <input type="file" name="foto_karyawan">
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="card px-3">
                            <table border="0" class="text-start">
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td><input type="text" name="nama" value="' . $row['nama'] . '" class="form-control me-2"></td>
                                </tr>
                                <tr>
                                    <td>Jenis Kelamin</td>
                                    <td>:</td>
                                    <td>
                                        <select name="jenis_kelamin" class="form-control me-2">';
                                            $data .= "<option value=". $row['jenis_kelamin'] ." selected >Perempuan</option>";
                                            $data .= "<option value=". $row['jenis_kelamin'] ." selected >Laki-laki</option>";
                                        $data.= '</select>
                                    </td>
                                </tr> 
                                <tr>
                                    <td>Besar Gaji</td>
                                    <td>:</td>
                                    <td><input type="text" name="gaji" value="' . $row['gaji'] . '" class="form-control me-2"></td>
                                </tr>
                                <tr>
                                    <td>Tahun masuk</td>
                                    <td>:</td>
                                    <td><input type="text" name="tahun_masuk" value="' . $row['tahun_masuk'] . '" class="form-control me-2"></td>
                                </tr>
                                <tr>
                                    <td>Nama Departemen</td>
                                    <td>:</td>
                                    <td>
                                        <select name="id_dept" class="form-control me-2">';
                                        $no = 1;
                                        while ($div = $departemen->getResult()) {
                                            if ($div['id_dept'] == $row['id_dept']) {
                                                $data .= "<option value=" . $div['id_dept'] . " selected>" . $div['nama_dept'] . "</option>";
                                            } else {
                                                $data .= "<option value=" . $div['id_dept'] . ">" . $div['nama_dept'] . "</option>";
                                            }
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
                                            if ($job['id_jabatan'] == $row['id_jabatan']) {
                                                $data .= "<option value=" . $job['id_jabatan'] . " selected>" . $job['nama_jabatan'] . "</option>";
                                            } else {
                                                $data .= "<option value=" . $job['id_jabatan'] . ">" . $job['nama_jabatan'] . "</option>";
                                            }
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
                                            if ($ket['id_status'] == $row['id_status']) {
                                                $data .= "<option value=" . $ket['id_status'] . " selected>" . $ket['status_karyawan'] . "</option>";
                                            } else {
                                                $data .= "<option value=" . $ket['id_status'] . ">" . $ket['status_karyawan'] . "</option>";
                                            }
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
                    <button type="submit" class="btn btn-success text-white" name="btn-update">Update Data</button>
                </div>
            </form>
        </div>';

        // mengubah data karyawan
        if (isset($_POST['btn-update'])) {
            $id = $_POST['id_karyawan'];
            $data = array(
                'nama' => $_POST['nama'],
                'gaji' => $_POST['gaji'],
                'tahun_masuk' => $_POST['tahun_masuk'],
                'jenis_kelamin' => $_POST['jenis_kelamin'],
                'id_jabatan' => $_POST['id_jabatan'],
                'id_dept' => $_POST['id_dept'],
                'id_status' => $_POST['id_status']
            );

            $targetDirectory = "assets/images/";

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
            $result = $karyawan->updateData($id, $data, $file);
            if ($result) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'index.php';
                </script>";
            } else {
                echo "<script>
                    alert('Data gagal diubah!');
                    document.location.href = 'index.php';
                </script>";
            }
        }
       
    }
    
}
$karyawan->close();
$detail = new Template('templates/skinform.html');
$detail->replace('DATA_KARYAWAN', $data);
$detail->write();
