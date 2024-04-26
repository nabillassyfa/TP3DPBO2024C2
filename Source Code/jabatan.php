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
include('classes/Jabatan.php');
include('classes/Template.php');
echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css' rel= 'stylesheet' integrity='sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ' crossorigin='anonymous'>";


// membuat instance jabatan
$jabatan = new Jabatan($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
// membuka koneksi
$jabatan->open();
// menampilkan data jabatan
$jabatan->getjabatan();

//tombol tambah jabatan
echo "<button class='button' data-bs-toggle='modal' data-bs-target='#staticBackdrop'> Tambah Jabatan </button>";

// Menambahkan data jabatan
if (!isset($_GET['id'])) {
    echo '<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="jabatan.php" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Jabatan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-6">
                        <label for="exampleFormControlInput1" class="form-label">Nama Jabatan</label>
                        <input type="text" class="form-control" name="nama_jabatan" id="exampleFormControlInput1">
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
            'nama_jabatan' => $_POST['nama_jabatan']
        );
        $result = $jabatan->addJabatan($data);
        if ($result) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'jabatan.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'jabatan.php';
            </script>";
        }
    }
    $btn = 'Tambah';
    $title = 'Tambah';
}

$view = new Template('templates/skintabel.html');

$mainTitle = 'jabatan';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Nama jabatan</th>
<th scope="row">Aksi</th>
</tr>';
$data = null;
$no = 1;
$formLabel = 'jabatan';

// pencarian jabatan
if (isset($_POST['btn-cari'])) {
    $jabatan->searchJabatan($_POST['cari']);
}

// pengurutan secara asc atau desc
if (isset($_POST['asc'])) {
    $jabatan->JabatanASC();
}elseif(isset($_POST['desc'])){
    $jabatan->JabatanDESC();
}

// menampilkan data
while ($job = $jabatan->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $job['nama_jabatan'] . '</td>
    <td style="font-size: 22px;">
        <a href="jabatan.php?id=' . $job['id_jabatan'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;
        <a href="jabatan.php?hapus=' . $job['id_jabatan'] . '" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')" title="Delete Data" >
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
        $jabatan->getjabatanById($id);
        $row = $jabatan->getResult();

        echo '<div class="modal-dialog">
        <form action="#" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Ubah Jabatan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-6">
                        <label for="exampleFormControlInput1" class="form-label">Nama Jabatan</label>
                        <input type="text" class="form-control" name="nama_jabatan" value="'.$row['nama_jabatan'].'">
                    </div>
                <div class="modal-footer">
                    <a href ="jabatan.php" type="button" class="btn btn-danger" name ="batal" >Batal</a>
                    <button type="submit" class="btn btn-primary" name="submit">Ubah</button>
                </div>
            </div>
        </form>
    </div>
    </div>';

        $btn = 'Simpan';
        $title = 'Ubah';

        if (isset($_POST['submit'])) {
            $data = array(
                'nama_jabatan' => $_POST['nama_jabatan']
            );
            $result = $jabatan->updateJabatan($id, $data);
            if ($result) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'jabatan.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'jabatan.php';
            </script>";
            }
        }elseif(isset($_POST['batal'])){
            header("Location: jabatan.php");
            exit();
        }
    }
}


// Hapus data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($jabatan->deletejabatan($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'jabatan.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'jabatan.php';
            </script>";
        }
    }
}

$jabatan->close();

$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->write();
