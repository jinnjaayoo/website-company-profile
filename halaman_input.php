<?php
include("inc_header.php");

$judul   = "";
$kutipan = "";
$isi     = "";
$error   = "";
$sukses  = "";

if (isset ($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = "";

}

if ($id != "") {
    // Jika ID ada, ambil data dari database
    $sql1 = "SELECT * FROM halaman WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);
    $judul   = $r1['judul'];
    $kutipan = $r1['kutipan'];
    $isi     = $r1['isi'];

    if($isi == ''){
        $error = "Data tidak ditemukan";

    }
}

// Jika tombol simpan ditekan
if (isset($_POST['simpan'])) {
    $judul   = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $kutipan = mysqli_real_escape_string($koneksi, $_POST['kutipan']);
    $isi     = mysqli_real_escape_string($koneksi, $_POST['isi']);
    $tgl     = date("Y-m-d H:i:s"); // tambahkan tanggal otomatis

    // Validasi
    if ($judul == '' || $isi == '') {
        $error = "Silakan masukkan semua data yakni judul dan isi.";
    }

    // Jika tidak ada error
    if (empty($error)) {
        if($id !=''){
            // Jika ID ada, lakukan update
            $sql1 = "UPDATE halaman SET judul = '$judul', kutipan = '$kutipan', isi = '$isi', tgl_isi = '$tgl' WHERE id = '$id'";
        } else {
        $sql1 = "INSERT INTO halaman (judul, kutipan, isi, tgl_isi) 
                 VALUES ('$judul', '$kutipan', '$isi', '$tgl')";
           
        }

        $q1 = mysqli_query($koneksi, $sql1);

        if ($q1) { 
            $sukses = "Sukses memasukkan data!";
        } else {
            $error = "Gagal memasukkan data: " . mysqli_error($koneksi);
        }
    }
}
?>

<h1>Halaman Admin Input Data</h1>

<div class="mb-3 row">
    <a href="halaman.php">
        &lt;&lt; kembali ke halaman admin
    </a>
</div>

<?php if ($error) { ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error ?>
    </div>
<?php } ?>

<?php if ($sukses) { ?>
    <div class="alert alert-primary" role="alert">
        <?php echo $sukses ?>
    </div>
<?php } ?>

<form action="" method="post">
    <div class="mb-3 row">
        <label for="judul" class="col-sm-2 col-form-label">Judul</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="judul" 
                   value="<?php echo $judul ?>" name="judul">
        </div>
    </div>

    <div class="mb-3 row">
        <label for="kutipan" class="col-sm-2 col-form-label">Kutipan</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="kutipan" 
                   value="<?php echo $kutipan ?>" name="kutipan">
        </div>
    </div>

    <div class="mb-3 row">
        <label for="isi" class="col-sm-2 col-form-label">Isi</label>
        <div class="col-sm-10">
            <textarea name="isi" class="form-control" id="summernote"><?php echo $isi ?></textarea>
        </div>
    </div>

    <div class="mb-3 row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
        </div>
    </div>
</form>

<?php include("inc_footer.php") ?>