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


$Karyawan = new Karyawan($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$Karyawan->open();  // buka koneksi

$data = nulL;

// tombol untuk tambah karyawan
echo "<a href='tambah.php'><button class='button'>Tambah Data Staff</button> </a><br><br>";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        $Karyawan->getKaryawanByDept($id);

        // pencarian data karyawan berdasarkan departemen
        if (isset($_POST['btn-cari'])) {
            $Karyawan->searchKaryawan($_POST['cari'], $id);
        }

        // menampilkan data karyawan
        while ($row = $Karyawan->getResult()) {
            $data .= '<div class="col gx-2 gy-3 justify-content-center">' .
                '<div class="card pt-4 px-2 pengurus-thumbnail">
                <a href="detail.php?id=' . $row['id_karyawan'] . '">
                    <div class="row justify-content-center">
                        <img src="assets/images/' . $row['foto_karyawan'] . '" class="card-img-top" alt="' . $row['foto_karyawan'] . '">
                    </div>
                    <div class="card-body">
                        <p class="card-text pengurus-nama my-0">' . $row['nama'] . '</p>
                        <p class="card-text divisi-nama">' . $row['nama_dept'] . '</p>
                        <p class="card-text jabatan-nama my-0">' . $row['nama_jabatan'] . '</p>
                    </div>
                </a>
            </div>    
            </div>';
        }
    }
}

$Karyawan->close();
$detail = new Template('templates/skin.html');
$detail->replace('DATA_PENGURUS', $data);
$detail->write();
