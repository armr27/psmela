<?php
ob_start();
//cek session
session_start();

if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {
?>

    <!doctype html>
    <html lang="en">

    <!-- Include Head START -->
    <?php include('include/head.php'); ?>
    <!-- Include Head END -->

    <!-- Body START -->

    <body >

        <!-- Header START -->
        <header>

            <!-- Include Navigation START -->
            <?php include('include/menu.php'); ?>
            <!-- Include Navigation END -->

        </header>
        <!-- Header END -->

        <!-- Main START -->
        <main>

            <!-- container START -->
            <div class="container">

                <?php
                if (isset($_REQUEST['page'])) {
                    $page = $_REQUEST['page'];
                    switch ($page) {
                        case 'tsm':
                            include "page/transaksi_surat_masuk.php";
                            break;
                        case 'ctk':
                            include "page/cetak_disposisi.php";
                            break;
                        case 'tsk':
                            include "page/transaksi_surat_keluar.php";
                            break;
                        case 'asm':
                            include "page/agenda_surat_masuk.php";
                            break;
                        case 'ask':
                            include "page/agenda_surat_keluar.php";
                            break;
                            // case 'ref':
                            //     include "referensi.php";
                            //     break;
                        case 'sett':
                            include "page/pengaturan.php";
                            break;
                        case 'pro':
                            include "page/profil.php";
                            break;
                        case 'gsm':
                            include "page/galeri_sm.php";
                            break;
                        case 'gsk':
                            include "page/galeri_sk.php";
                            break;
                    }
                } else {
                ?>
                    <!-- Row START -->
                    <div class="row">

                        <!-- Include Header Instansi START -->
                        <?php include('include/header_instansi.php'); ?>
                        <!-- Include Header Instansi END -->

                        <!-- Welcome Message START -->
                        <div class="col s12">
                            <div class="card">
                                <div class="card-content">
                                    <h4>Selamat Datang <?php echo $_SESSION['nama']; ?></h4>
                                    <p class="description">Anda login sebagai
                                        <?php
                                        echo '<strong>'.$_SESSION['jabatan'].'.</strong> Berikut adalah Statistik data yang tersimpan dalam sistem';
                                     ?></p>
                                </div>
                            </div>
                        </div>
                        <!-- Welcome Message END -->

                        <?php
                        //menghitung jumlah surat masuk
                        $count1 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_surat_masuk"));

                        //menghitung jumlah surat masuk
                        $count2 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_surat_keluar"));

                        //menghitung jumlah surat masuk
                        $count3 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_disposisi"));

                        //menghitung jumlah klasifikasi
                        $count4 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_klasifikasi"));

                        //menghitung jumlah pengguna
                        $count5 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_user"));

                        // menghitung Jumlah Surat Yang Belum Disposisi
                        $count6 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_surat_masuk WHERE notif = 0"));
                        ?>

                        <!-- Info Statistic START -->
                        <div class="col s12 m4">
                            <div class="card cyan">
                                <div class="card-content">
                                    <span class="card-title white-text"><i class="material-icons md-36">mail</i> Jumlah Surat Masuk</span>
                                    <?php echo '<h5 class="white-text link">' . $count1 . ' Surat Masuk</h5>'; ?>
                                </div>
                            </div>
                        </div>
                    <?php if ($_SESSION['admin'] != 5) { 
                        echo'
                        <div class="col s12 m4">
                            <div class="card lime darken-1">
                                <div class="card-content">
                                    <span class="card-title white-text"><i class="material-icons md-36">drafts</i> Jumlah Surat Keluar</span>
                                    <h5 class="white-text link">' . $count2 . ' Surat Keluar</h5>
                                </div>
                            </div>
                        </div>
                    ';} ?>
                        <div class="col s12 m4">
                            <div class="card yellow darken-3">
                                <div class="card-content">
                                    <span class="card-title white-text"><i class="material-icons md-36">description</i> Jumlah Disposisi</span>
                                    <?php echo '<h5 class="white-text link">' . $count3 . ' Disposisi</h5>'; ?>
                                </div>
                            </div>
                        </div>

                        <?php if ($count6 != 0 && $_SESSION['admin'] == 4) { ?>
                            <div class="col s12 m4">
                                <div class="card red">
                                    <div class="card-content">
                                        <span class="card-title white-text" style="font-size: 18px; font-weight: bold;"><i class="material-icons md-36">warning</i> Ada Surat Yang Belum Disposisi</span>
                                        <?php echo '<h5 class="white-text link"> <a href = "admin.php?page=tsm" style="text-decoration:none; color:white;">' . $count6 . ' Belum di Disposisi</h5></a>'; ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <!-- <div class="col s12 m4">
                            <div class="card deep-orange">
                                <div class="card-content">
                                    <span class="card-title white-text"><i class="material-icons md-36">class</i> Jumlah Klasifikasi Surat</span>
                                    <?php echo '<h5 class="white-text link">' . $count4 . ' Klasifikasi Surat</h5>'; ?>
                                </div>
                            </div>
                        </div> -->

                        <?php
                        if ($_SESSION['id_user'] == 1 || $_SESSION['admin'] == 2) { ?>
                            <div class="col s12 m4">
                                <div class="card blue accent-2">
                                    <div class="card-content">
                                        <span class="card-title white-text"><i class="material-icons md-36">people</i> Jumlah Pengguna</span>
                                        <?php echo '<h5 class="white-text link">' . $count5 . ' Pengguna</h5>'; ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Info Statistic START -->
                        <?php
                        }
                        ?>

                    </div>
                    <!-- Row END -->
                <?php
                }
                ?>
            </div>
            <!-- container END -->

        </main>
        <!-- Main END -->

        <!-- Include Footer START -->
        <?php include('include/footer.php'); ?>
        <!-- Include Footer END -->

    </body>
    <!-- Body END -->

    </html>

<?php
}
?>