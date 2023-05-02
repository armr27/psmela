<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {
    if (isset($_REQUEST['submit'])) {

        //validasi form kosong
        if (
            $_REQUEST['username'] == "" || $_REQUEST['password'] == "" || $_REQUEST['nama'] == "" || $_REQUEST['nip'] == "" || $_REQUEST['admin'] == "" || $_REQUEST['jabatan'] == ""
        ) {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi!';
            header("Location: ./admin.php?page=sett&sub=usr&act=add");
            die();
        } else {

            $username = $_REQUEST['username'];
            $password = $_REQUEST['password'];
            $nama = $_REQUEST['nama'];
            $nip = $_REQUEST['nip'];
            $admin = $_REQUEST['admin'];
            $ttd = $_REQUEST['ttd'];
            $jabatan = $_REQUEST['jabatan'];



            //validasi input data
            if (!preg_match("/^[a-zA-Z0-9_]*$/", $username)) {
                $_SESSION['uname'] = 'Form Username hanya boleh mengandung karakter huruf, angka dan underscore (_)';
                echo '<script language="javascript">window.history.back();</script>';
            } else {

                if (!preg_match("/^[a-zA-Z., ]*$/", $nama)) {
                    $_SESSION['namauser'] = 'Form Nama hanya boleh mengandung karakter huruf, spasi, titik(.) dan koma(,)';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {

                    if (!preg_match("/^[0-9. -]*$/", $nip)) {
                        $_SESSION['nipuser'] = 'Form NIP hanya boleh mengandung karakter angka, spasi dan minus(-)';
                        echo '<script language="javascript">window.history.back();</script>';
                    } else {

                        if (!preg_match("/^[2-5]*$/", $admin)) {
                            $_SESSION['tipeuser'] = 'Form Tipe User hanya boleh mengandung karakter angka 2 atau 3';
                            echo '<script language="javascript">window.history.back();</script>';
                        } else {

                            $cek = mysqli_query($config, "SELECT * FROM tbl_user WHERE username='$username'");
                            $result = mysqli_num_rows($cek);

                            if ($result > 0) {
                                $_SESSION['errUsername'] = 'Username sudah terpakai, gunakan yang lain!';
                                echo '<script language="javascript">window.history.back();</script>';
                            } else {

                                if (strlen($username) < 5) {
                                    $_SESSION['errUser5'] = 'Username minimal 5 karakter!';
                                    echo '<script language="javascript">window.history.back();</script>';
                                } else {

                                    if (strlen($password) < 5) {
                                        $_SESSION['errPassword'] = 'Password minimal 5 karakter!';
                                        echo '<script language="javascript">window.history.back();</script>';
                                    } else {
                                        $ekstensi = array('png');
                                        $ttd = $_FILES['ttd']['name'];

                                        $x = explode('.', $ttd);
                                        $eks = strtolower(end($x));
                                        $ukuran = $_FILES['ttd']['size'];
                                        $target_dir = "upload/";

                                        if (!is_dir($target_dir)) {
                                            mkdir($target_dir, 0755, true);
                                        }

                                        //jika form ttd tidak kosong akan mengeksekusi script dibawah ini
                                        if (!empty($ttd)) {
                                            $rand = rand(1, 9999);
                                            $nttd = $rand . $ttd;
                                            //validasi gambar
                                            if (in_array($eks, $ekstensi) == true) {
                                                if ($ukuran < 2000000) {

                                                    move_uploaded_file($_FILES['ttd']['tmp_name'], $target_dir . $nttd);

                                                    $query = mysqli_query($config, "INSERT INTO tbl_user(username,password,nama,nip,jabatan,ttd,admin) VALUES('$username',MD5('$password'),'$nama','$nip','$jabatan','$nttd','$admin')");
                                                    if ($query == true) {
                                                        $_SESSION['succEdit'] = 'SUKSES! Data User berhasil Ditambahkan';
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
                                        } else {
                                            //jika form ttd kosong akan mengeksekusi script dibawah ini
                                            $query = mysqli_query($config, "INSERT INTO tbl_user(username,password,nama,nip,jabatan,admin) VALUES('$username',MD5('$password'),'$nama','$nip','$jabatan','$admin')");

                                            if ($query == true) {
                                                $_SESSION['succAdd'] = 'SUKSES! Data User berhasil ditambahkan';
                                                header("Location: ././admin.php?page=sett&sub=usr");
                                                die();
                                            } else {
                                                $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                                echo '<script language="javascript">window.history.back();</script>';
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    } else { ?>

        <!-- Row Start -->
        <div class="row">
            <!-- Secondary Nav START -->
            <div class="col s12">
                <nav class="secondary-nav">
                    <div class="nav-wrapper blue-grey darken-1">
                        <ul class="left">
                            <li class="waves-effect waves-light"><a href="?page=sett&sub=usr&act=add" class="judul"><i class="material-icons">person_add</i> Tambah User</a></li>
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
        if (isset($_SESSION['errEmpty'])) {
            $errEmpty = $_SESSION['errEmpty'];
            echo '<div id="alert-message" class="row">
                            <div class="col m12">
                                <div class="card red lighten-5">
                                    <div class="card-content notif">
                                        <span class="card-title red-text"><i class="material-icons md-36">clear</i> ' . $errEmpty . '</span>
                                    </div>
                                </div>
                            </div>
                        </div>';
            unset($_SESSION['errEmpty']);
        }
        ?>

        <!-- Row form Start -->
        <div class="row jarak-form">

            <!-- Form START -->
            <form class="col s12" method="post" action="?page=sett&sub=usr&act=add" enctype="multipart/form-data">

                <!-- Row in form START -->
                <div class="row">
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">account_circle</i>
                        <input id="username" type="text" class="validate" name="username" required>
                        <?php
                        if (isset($_SESSION['uname'])) {
                            $uname = $_SESSION['uname'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $uname . '</div>';
                            unset($_SESSION['uname']);
                        }
                        if (isset($_SESSION['errUsername'])) {
                            $errUsername = $_SESSION['errUsername'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errUsername . '</div>';
                            unset($_SESSION['errUsername']);
                        }
                        if (isset($_SESSION['errUser5'])) {
                            $errUser5 = $_SESSION['errUser5'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errUser5 . '</div>';
                            unset($_SESSION['errUser5']);
                        }
                        ?>
                        <label for="username" class="active">Username</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">text_fields</i>
                        <input id="nama" type="text" class="validate" name="nama" required>
                        <?php
                        if (isset($_SESSION['namauser'])) {
                            $namauser = $_SESSION['namauser'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $namauser . '</div>';
                            unset($_SESSION['namauser']);
                        }
                        ?>
                        <label for="nama" class="active">Nama</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">lock</i>
                        <input id="password" type="password" class="validate" name="password" required>
                        <?php
                        if (isset($_SESSION['errPassword'])) {
                            $errPassword = $_SESSION['errPassword'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errPassword . '</div>';
                            unset($_SESSION['errPassword']);
                        }
                        ?>
                        <label for="password" class="active">Password</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">looks_one</i>
                        <input id="nip" type="text" class="validate" name="nip"  required>
                        <?php
                        if (isset($_SESSION['nipuser'])) {
                            $nipuser = $_SESSION['nipuser'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $nipuser . '</div>';
                            unset($_SESSION['nipuser']);
                        }
                        ?>
                        <label for="nip" class="active">NIP</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">supervisor_account</i><label>Pilih Tampilan User</label><br />
                        <div class="input-field col s11 right">
                            <select class="browser-default validate" name="admin" id="admin" required>
                                <!-- <option value="3">User Biasa</option> -->
                                <!-- <option value="2">Administrator</option> -->
                                <option value="4">Kepala Bagian/intansi</option>
                                <option value="5">Staff</option>
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
                        <i class="material-icons prefix md-prefix">assignment_ind</i>
                        <input id="jabatan" type="text" class="validate" name="jabatan" required>
                        <label for="jabatan" class="active">jabatan</label>
                    </div>

                    <div class="input-field col s6 tooltipped" data-position="top" data-tooltip="Pastikan File Tanda Tangan Jelas">
                        <div class="file-field input-field">
                            <div class="btn light-green darken-1">
                                <span>File</span>
                                <input type="file" id="ttd" name="ttd">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder="Upload Tanda Tangan">
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
                <br />
                <!-- Row in form END -->
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
?>