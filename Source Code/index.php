<?php

// Saya Nabilla Assyfa Ramadhani [2205297] 
// mengerjakan TP3
// dalam mata Desain dan Pemograman Berorientasi Objek 
// untuk keberkahanNya maka saya tidak melakukan kecurangan 
// seperti yang telah dispesifikasikan. 
// Aamiin

include('config/db.php');
include('classes/DB.php');
include('classes/Departemen.php');
include('classes/Template.php');
include('classes/Karyawan.php');

// buat instance pengurus
$listDepartemen = new Departemen($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// buka koneksi
$listDepartemen->open();
// tampilkan data Departemen
$listDepartemen->getDepartemen();


// cari departemen
if (isset($_POST['btn-cari'])) {
   $listDepartemen->searchDept($_POST['cari']);
}

$data = null;

// menampilkan data departemen
while ($row = $listDepartemen->getResult()) {
    $data .= '<div class="col gx-2 gy-3 justify-content-center">' .
        '<div class="card pt-4 px-2 pengurus-thumbnail">
        <a href="karyawan.php?id=' . $row['id_dept'] . '">
            <div class="row justify-content-center">
                <img src="assets/images/' . $row['foto_dept'] . '" class="card-img-top" alt="' . $row['foto_dept'] . '">
            </div>
            <div class="card-body">
                <p class="card-text pengurus-nama my-0">' . $row['nama_dept'] . '</p>
            </div>
        </a>
    </div>    
    </div>';
}

// tutup koneksi
$listDepartemen->close();

// buat instance template
$home = new Template('templates/skin.html');

// simpan data ke template
$home->replace('DATA_PENGURUS', $data);
$home->write();
