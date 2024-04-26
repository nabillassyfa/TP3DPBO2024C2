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
include('classes/Departemen.php');
include('classes/Template.php');
echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css' rel= 'stylesheet' integrity='sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ' crossorigin='anonymous'>";


// membuat instance departemen
$departemen = new Departemen($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
// membuka koneksi
$departemen->open();
// menampilkan data departemen
$departemen->getDepartemen();

// tombol untuk menanmbahkan data
echo "<button class='button' data-bs-toggle='modal' data-bs-target='#staticBackdrop'> Tambah Departemen </button>";

// Menambahkan data departemen
if (!isset($_GET['id'])) {
    // memuat form tambah data
    echo '<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah departemen</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-6> 
                        <div class="row justify-content-center">
                            <label class="form-label">Foto departemen</label>
                            <input type="file" class="form-control" name="foto_dept">
                        </div>
                    <div class="mb-6">
                        <label class="form-label">Nama departemen</label>
                        <input type="text" class="form-control" name="nama_dept" id="exampleFormControlInput1">
                    </div>
                    
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" name="add">Tambah</button>
                </div>
            </div>
        </form>
    </div>
    </div>
    </div>
    ';
    if (isset($_POST['add'])) {
        $data = array(
            'nama_dept' => $_POST['nama_dept']
        );
        $targetDirectory = "assets/images/";
         if (isset($_FILES['foto_dept']['name']) && $_FILES['foto_dept']['name']) {
            $targetFilePath = $targetDirectory . basename($_FILES['foto_dept']['name']);

            
            if (move_uploaded_file($_FILES['foto_dept']['tmp_name'], $targetFilePath)) {
                $file = array(
                    'foto_dept' => basename($_FILES['foto_dept']['name'])
                );
            }
        } else {
            $file = array(); // kondisi jika tidak ada file gambar yang diunggah
        }

        $result = $departemen->addDepartemen($data, $file);
        if ($result) {  // kondisi jika berhasil add data
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'departemen.php';
            </script>";
        } else {  // kondisi jika tidak berhasil
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'departemen.php';
            </script>";
        }
    }
    $btn = 'Tambah';
    $title = 'Tambah';
}

$view = new Template('templates/skintabel.html');

$mainTitle = 'departemen';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Nama departemen</th>
<th scope="row">Aksi</th>
</tr>';
$data = null;
$no = 1;
$formLabel = 'departemen';

// pencarian data
if (isset($_POST['btn-cari'])) {
    $departemen->searchDept($_POST['cari']);
}

// pengurutan data
if (isset($_POST['asc'])) {
    $departemen->DeptASC();
}elseif(isset($_POST['desc'])){
    $departemen->DeptDESC();
}

// menampilkan data
while ($job = $departemen->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $job['nama_dept'] . '</td>
    <td style="font-size: 22px;">
        <a href="departemen.php?id=' . $job['id_dept'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;
        <a href="departemen.php?hapus=' . $job['id_dept'] . '" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')" title="Delete Data" >
            <i class="bi bi-trash-fill text-danger"></i>
        </a>
        </td>
    </tr>';
    $no++;
}

// Ubah data
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) { 
        $departemen->getDepartemenById($id);
        $row = $departemen->getResult();

        // menampilkan form ubah data
        echo '<div class="modal-dialog">
        <form action="#" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Ubah departemen</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <input type="hidden" name="id_dept" value="' . $row['id_dept'] . '">
                    <div class="mb-6">
                    <div class="mb-6> 
                        <div class="row justify-content-center">
                            <label class="form-label">Foto departemen</label>
                            <img src="assets/images/' . $row['foto_dept'] . '" class="img-thumbnail" alt="' . $row['foto_dept'] . '" width="60">
                            <input type="file" class="form-control" name="foto_dept">
                        </div>
                    </div>
                    <div class="mb-6">
                        <label for="exampleFormControlInput1" class="form-label">Nama departemen</label>
                        <input type="text" class="form-control" name="nama_dept" value="'.$row['nama_dept'].'">
                    </div>
                <div class="modal-footer">
                    <a href ="departemen.php" type="button" class="btn btn-danger" name ="batal" >Batal</a>
                    <button type="submit" class="btn btn-primary" name="submit">Ubah</button>
                </div>
            </div>
        </form>
    </div>
    </div>';

        $btn = 'Simpan';
        $title = 'Ubah';

        if (isset($_POST['submit'])) {
    
            $id = $_POST['id_dept'];
            $data = array(
                'nama_dept' => $_POST['nama_dept']
            );
            $targetDirectory = "assets/images/";
            if (isset($_FILES['foto_dept']) && $_FILES['foto_dept']['name'] && $_FILES['foto_dept']['error'] === UPLOAD_ERR_OK){
                // path menyimpan file
                $targetFilePath = $targetDirectory . basename($_FILES['foto_dept']['name']);

                if (move_uploaded_file($_FILES['foto_dept']['tmp_name'], $targetFilePath)) {
                    $file = array(
                        'foto_dept' => basename($_FILES['foto_dept']['name'])
                    );
                }
            } else {
                $file = array(); 
            }
            $result = $departemen->updateDept($id, $data, $file);

            if ($result) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'departemen.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'departemen.php';
            </script>";
            }
        }
    }
}


// Hapus data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($departemen->deletedepartemen($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'departemen.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'departemen.php';
            </script>";
        }
    }
}

$departemen->close();

$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->write();
