<?php

//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if ($_REQUEST['id_user'] == 1) {
        echo '<script language="javascript">
                    window.alert("ERROR! Super Admin tidak boleh diedit");
                    window.location.href="./admin.php?page=sett&sub=usr";
                  </script>';
    } else {

        if ($_REQUEST['id_user'] == $_SESSION['id_user']) {
            echo '<script language="javascript">
                        window.alert("ERROR! Anda tidak diperbolehkan mengedit tipe akun Anda sendiri. Hubungi super admin untuk mengeditnya");
                        window.location.href="./admin.php?page=sett&sub=usr";
                      </script>';
        } else {

            if (isset($_REQUEST['submit'])) {

                $id_user = $_REQUEST['id_user'];
                $admin = $_REQUEST['admin'];
                $nip = $_REQUEST['nip'];
                $nama = $_REQUEST['nama'];
                $jabatan = $_REQUEST['jabatan'];
                $username = $_REQUEST['username'];


                if ($id_user == $_SESSION['id_user']) {
                    echo '<script language="javascript">
                                window.alert("ERROR! Anda tidak boleh mengedit akun Anda sendiri. Hubungi super admin untuk mengeditnya");
                                window.location.href="./admin.php?page=sett&sub=usr";
                              </script>';
                } else {

                    if (!preg_match("/^[2-4]*$/", $admin)) {
                        $_SESSION['tipeuser'] = 'Form Tipe User hanya boleh mengandung karakter angka 2 atau 3';
                        echo '<script language="javascript">window.history.back();</script>';
                    } else {

                        if (!preg_match("/^[0-9. -]*$/", $nip)) {
                            $_SESSION['nipuser'] = 'Form NIP hanya boleh mengandung karakter angka, spasi dan minus(-)';
                            echo '<script language="javascript">window.history.back();</script>';
                        } else {
                            // upload file ttd
                            $queryttd = mysqli_query($config, "SELECT ttd FROM tbl_user WHERE id_user='$id_user'");
                            $datattd = mysqli_fetch_array($queryttd);
                            unlink('upload/' . $datattd['ttd'] . '');

                            $ekstensi = array('png');
                            $ttd = $_FILES['ttd']['name'];
                            $x = explode('.', $ttd);
                            $eks = strtolower(end($x));
                            $ukuran = $_FILES['ttd']['size'];
                            $target_dir = "upload/";

                            if (!is_dir($target_dir)) {
                                mkdir($target_dir, 0755, true);
                            }

                            $rand = rand(1, 10000);
                            $nttd = $rand . "-" . $ttd;
                            //validasi gambar
                            if (in_array($eks, $ekstensi) == true) {
                                if ($ukuran < 2000000) {


                                    move_uploaded_file($_FILES['ttd']['tmp_name'], $target_dir . $nttd);

                                    $query = mysqli_query($config, "UPDATE tbl_user SET username='$username', admin='$admin', nama='$nama', nip='$nip', jabatan='$jabatan', ttd='$nttd' WHERE id_user='$id_user'");
                                    if ($query == true) {
                                        $_SESSION['succEdit'] = 'SUKSES! Data User berhasil Dirubah';
                                        header("Location: ././admin.php?page=sett&sub=usr");
                                        die();
                                    } else {
                                        $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                        echo '<script language="javascript">window.history.back();</script>';
                                    }
                                } else {
                                    $_SESSION['errSize'] = 'Ukuran file yang diupload terlalu besar!<br/><br/>';
                                    echo '<script language="javascript">window.history.back();</script>';
                                    die;
                                }
                            } else {
                                $_SESSION['errFormat'] = 'Format file gambar yang diperbolehkan hanya *.PNG!<br/><br/>';
                                echo '<script language="javascript">window.history.back();</script>';
                                die;
                            }
                        }
                    }
                }
            } else {

                $id_user = mysqli_real_escape_string($config, $_REQUEST['id_user']);
                $query = mysqli_query($config, "SELECT * FROM tbl_user WHERE id_user='$id_user'");
                if (mysqli_num_rows($query) > 0) {
                    $no = 1;
                    while ($row = mysqli_fetch_array($query)) { ?>

                        <!-- Row Start -->
                        <div class="row">
                            <!-- Secondary Nav START -->
                            <div class="col s12">
                                <nav class="secondary-nav">
                                    <div class="nav-wrapper blue-grey darken-1">
                                        <ul class="left">
                                            <li class="waves-effect waves-light  tooltipped" data-position="right" data-tooltip="Menu ini hanya untuk mengedit tipe user. Username dan password bisa diganti lewat menu profil"><a href="#" class="judul"><i class="material-icons">mode_edit</i> Edit User</a></li>
                                        </ul>
                                    </div>
                                </nav>
                            </div>
                            <!-- Secondary Nav END -->
                        </div>
                        <!-- Row END -->

                        <?php
                        if (isset($_SESSION['errQ'])) {
                            $errQ = $_SESSION['errQ'];
                            echo '<div id="alert-message" class="row">
                                        <div class="col m12">
                                            <div class="card red lighten-5">
                                                <div class="card-content notif">
                                                    <span class="card-title red-text"><i class="material-icons md-36">clear</i> ' . $errQ . '</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                            unset($_SESSION['errQ']);
                        }
                        ?>

                        <!-- Row form Start -->
                        <div class="row jarak-form">

                            <!-- Form START -->
                            <form class="col s12" method="post" action="?page=sett&sub=usr&act=edit" enctype="multipart/form-data">

                                <!-- Row in form START -->
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input type="hidden" value="<?php echo $row['id_user']; ?>" name="id_user">
                                        <i class="material-icons prefix md-prefix">account_circle</i>
                                        <input id="username" name="username" type="text" value="<?php echo $row['username']; ?>">

                                        <label for="username">Username</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <i class="material-icons prefix md-prefix">text_fields</i>
                                        <input id="username" type="text" name="nama" value="<?php echo $row['nama']; ?>" required>
                                        <label for="username">Nama</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <i class="material-icons prefix md-prefix">supervisor_account</i><label>Pilih Tampilan user</label><br />
                                        <div class="input-field col s11 right">
                                            <select class="browser-default" name="admin" id="admin" required>
                                                <option value="<?php echo $row['admin']; ?>">
                                                    <?php
                                                    if ($row['admin'] == 2) {
                                                        echo 'Administrator';
                                                    } else if ($row['admin'] == 3) {
                                                        echo 'User Biasa';
                                                    } else {
                                                        echo 'Kepala Bagian/Instansi';
                                                    }
                                                    ?>
                                                </option>
                                                <!-- <option value="3">User Biasa</option> -->
                                                <option value="2">Administrator</option>
                                                <option value="4">Kepala Bagian/intansi</option>
                                            </select>
                                        </div>
                                        <?php
                                        if (isset($_SESSION['tipeuser'])) {
                                            $tipeuser = $_SESSION['tipeuser'];
                                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tipeuser . '</div>';
                                            unset($_SESSION['tipeuser']);
                                        }
                                        ?>

                                    </div>
                                    <div class="input-field col s6">
                                        <i class="material-icons prefix md-prefix">looks_one</i>
                                        <input id="nip" type="text" class="validate" name="nip" value="<?= $row['nip']; ?>" required>
                                        <?php
                                        if (isset($_SESSION['nipuser'])) {
                                            $nipuser = $_SESSION['nipuser'];
                                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $nipuser . '</div>';
                                            unset($_SESSION['nipuser']);
                                        }
                                        ?>
                                        <label for="nip">NIP</label>
                                    </div>

                                    <div class="input-field col s6">
                                        <i class="material-icons prefix md-prefix">assignment_ind</i>
                                        <input id="jabatan" type="text" class="validate" name="jabatan" value="<?= $row['jabatan'] ?>" required>
                                        <label for="jabatan">jabatan</label>
                                    </div>

                                    <div class="input-field col s6 tooltipped" data-position="top" data-tooltip="Pastikan File Tanda Tangan Jelas">
                                        <div class="file-field input-field">
                                            <div class="btn light-green darken-1">
                                                <span>File</span>
                                                <input type="file" id="ttd" name="ttd" value="<?= $row['ttd'] ?>">
                                            </div>
                                            <div class="file-path-wrapper">
                                                <input class="file-path validate" type="text" value="<?= $row['ttd'] ?>" placeholder="Upload Tanda Tangan">
                                            </div>
                                            <?php
                                            if (isset($_SESSION['errSize'])) {
                                                $errSize = $_SESSION['errSize'];
                                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errSize . '</div>';
                                                unset($_SESSION['errSize']);
                                            }
                                            if (isset($_SESSION['errFormat'])) {
                                                $errFormat = $_SESSION['errFormat'];
                                                echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errFormat . '</div>';
                                                unset($_SESSION['errFormat']);
                                            }
                                            ?>
                                            <small class="red-text">*Format file yang diperbolehkan *.PNG dan ukuran maksimal file 2 MB. Jika Anda belum merubah format tanda tangan silahkan klik <a href="https://www.remove.bg/" target="_blank">Link Berikut!!</a></small>
                                        </div>
                                    </div>
                                </div>
                                <!-- Row in form END -->
                                <br />
                                <div class="row">
                                    <div class="col 6">
                                        <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                                    </div>
                                    <div class="col 6">
                                        <a href="?page=sett&sub=usr" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                                    </div>
                                </div>

                            </form>
                            <!-- Form END -->

                        </div>
                        <!-- Row form END -->

<?php
                    }
                }
            }
        }
    }
}
?>