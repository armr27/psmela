<?php
// Cek Disposisi
$id_surat = mysqli_real_escape_string($config, $_REQUEST['id_surat']);
$result = mysqli_query($config, "SELECT id_disposisi FROM tbl_disposisi WHERE id_surat='$id_surat'");
$cek = mysqli_num_rows($result);
if ($cek == 0) {
    $_SESSION['errorPrint'] = '<strong>ERROR!</strong> Harap Melakukan Disposisi Terlebih Dahulu ';
    header("location: ./admin.php?page=tsm");
    die();
}
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
    header("Location: ./");
    die();
} else {

    echo '
        <style type="text/css">
            table {
                background: #fff;
                padding: 5px;
            }
            tr, td {
                border: table-cell;
                border: 1px  solid #444;
            }
            tr,td {
                vertical-align: top!important;
            }
            #right {
                border-right: none !important;
            }
            #left {
                border-left: none !important;
            }
            .isi {
                height: 300px!important;
            }
            .disp {
                text-align: center;
                padding: 1.5rem 0;
                margin-bottom: .5rem;
            }
            .logodisp {
                float: left;
                position: relative;
                width: 100px;
                height: 90px;
                margin: 0 0 0 5px  ;
            }
            .logodispright {
                float: right;
                position: relative;
                width: 100px;
                height: 90px;
                margin: 0 0 0 5px;
            }

            #lead {
                    width: auto;
                    position: relative;
                    text-align: center;
                    margin: 25px 0 0 65%;
                }
                #lead img{
                    margin-top: -20px;
                    }
                .lead {
                    font-weight: bold;
                    text-decoration: underline;
                    margin-top: -10px;
                }
                .lead1{
                    margin-top: -20px;
                }

            .tgh {
                text-align: center;
            }
            #nama {
                font-size: 2.1rem;
                margin-bottom: -1rem;
            }
            #alamat {
                font-size: 16px;
            }
            .up {
                text-transform: uppercase;
                margin: 0;
                line-height: 2.2rem;
                font-size: 1.5rem;
            }
            .status {
                margin: 0;
                font-size: 1.3rem;
                margin-bottom: .5rem;
            }
            #lbr {
                font-size: 20px;
                font-weight: bold;
            }
            .separator {
                border-bottom: 2px solid #616161;
                margin: -1.3rem 0 1.5rem;
            }
            @media print{
                body {
                    font-size: 12px;
                    color: #212121;
                }
                nav {
                    display: none;
                }
                table {
                    width: 100%;
                    font-size: 12px;
                    color: #212121;
                }
                tr, td {
                    border: table-cell;
                    border: 1px  solid #444;
                    padding: 8px!important;

                }
                tr,td {
                    vertical-align: top!important;
                }
                #lbr {
                    font-size: 20px;
                }
                .isi {
                    height: 200px!important;
                }
                .tgh {
                    text-align: center;
                }
                .disp {
                    text-align: center;
                    margin: -.5rem 0;
                }
                .logodisp {
                    float: left;
                    position: relative;
                    width: 80px;
                    height: 80px;
                    margin: .5rem 0 0 .5rem;
                }
                #lead {
                    width: auto;
                    text-align : center;
                    position: relative;
                    margin: 15px 0 0 65%;
                }
                #lead img{
                    margin-top: -20px;
                    }
                .lead {
                    font-weight: bold;
                    text-decoration: underline;
                    margin-top: -10px;
                }
                .lead1{
                    margin-top: -15px;
                }
                #nama {
                    font-size: 20px!important;
                    font-weight: bold;
                    text-transform: uppercase;
                    margin: -10px 0 -20px 0;
                }
                .up {
                    font-size: 17px!important;
                    font-weight: normal;
                }
                .status {
                    font-size: 17px!important;
                    font-weight: normal;
                    margin-bottom: -.1rem;
                }
                #alamat {
                    margin-top: -15px;
                    font-size: 13px;
                }
                #lbr {
                    font-size: 17px;
                    font-weight: bold;
                }
                .separator {
                    border-bottom: 2px solid #616161;
                    margin: -1rem 0 1rem;
                }

            }
        </style>

        <body onload="window.print()">

        <!-- Container START -->
            <div id="colres">
                <div class="disp">';
    $query2 = mysqli_query($config, "SELECT instansi, nama, status, alamat, logo, email FROM tbl_instansi");
    list($institusi, $nama, $status, $alamat, $logo, $email) = mysqli_fetch_array($query2);
    echo '<img class="logodisp" src="./upload/' . $logo . '"/>';
    echo '<img class="logodispright" src="./upload/logo kesehatan.png"<br>';
    echo '<h6 class="up">' . $institusi . '</h6>';
    echo '<h5 class="up" id="nama">' . $nama . '</h5><br/>';
    echo '<span id="alamat">Jalan Soekarno-Hatta Km 27.5 Dumai - 28843</span><br>';
    echo '<span> ' . $email . ' </span>';
    echo '
                </div>
                <div class="separator"></div>';


    $query = mysqli_query($config, "SELECT * FROM tbl_surat_masuk WHERE id_surat='$id_surat'");

    if (mysqli_num_rows($query) > 0) {
        $no = 0;
        while ($row = mysqli_fetch_array($query)) {

            echo '
                    <table class="bordered" id="tbl">
                        <tbody>
                        
                            <tr>
                                <td class="tgh" id="lbr" colspan="5">LEMBAR DISPOSISI</td>
                            </tr>

                            <tr>
                            <td id="right"><strong>Asal Surat</strong></td>
                            <td id="left" style="border-left: none;">: ' . ($row['asal_surat']) . '</td>
                            <td id="left" border="0"><strong>Tanggal Diterima</strong> : ' . indodate($row['tgl_diterima']) . '</td>
                        </tr>
                            <tr><td id="right"><strong>Tanggal Surat</strong></td>
                                <td id="left" >: ' . indoDate($row['tgl_surat']) . '</td>
                                <td id="left"><strong>No Urut</strong> : ' . $row['no_agenda'] . '</td>
                            </tr>
                            <tr>
                                <td id="right"><strong>Nomor Surat</strong></td>
                                <td id="left" colspan="2">: ' . $row['no_surat'] . '</td>
                            </tr>

                            <tr>
                                <td id="right"><strong>Perihal</strong></td>
                                <td id="left" colspan="2">: ' . $row['isi'] . '</td>
                            </tr>
                            <tr>
                                <td id="right" ><strong>Diterima Tanggal</strong></td>
                                <td id="left" style="border-right: none;" colspan="2">: ' . indoDate($row['tgl_diterima']) . '</td>
                            </tr>
                            <tr>';
            $query3 = mysqli_query($config, "SELECT * FROM tbl_disposisi JOIN tbl_surat_masuk ON tbl_disposisi.id_surat = tbl_surat_masuk.id_surat WHERE tbl_disposisi.id_surat='$id_surat'");

            if (mysqli_num_rows($query3) > 0) {
                $no = 0;
                $row = mysqli_fetch_array($query3); {
                    echo '
                            <tr class="isi">
                                <td colspan="2">
                                    <strong>Isi Disposisi :</strong><br/>' . $row['isi_disposisi'] . '
                                    <div style="height: 50px;"></div>
                                    <div style="height: 25px;"></div>
                                </td>
                                <td><strong>Diteruskan Kepada</strong> : <br/>' . $row['tujuan'] . '</td>
                            </tr>';
                }
            } else {
                echo '
                                <tr class="isi">
                                    <td colspan="2"><strong>Isi Disposisi :</strong>
                                    </td>
                                    <td><strong>Diteruskan Kepada</strong> : </td>
                                </tr>';
            }
        }
        echo '
                </tbody>x
            </table>
            ';
        $query = mysqli_query($config, "SELECT nama,jabatan, ttd, nip FROM `tbl_user` INNER JOIN `tbl_disposisi` on tbl_user.id_user = tbl_disposisi.id_user WHERE id_surat = $id_surat");
        list($nama, $jabatan, $ttd, $nip) = mysqli_fetch_array($query);
        echo ' <div id="lead">';
        if ($jabatan !== 'Kepala Puskesmas Bukit Kayu Kapur') {
            echo '<p> an. Kepala Puskesmas Bukit Kayu Kapur <br>' . $jabatan . ',</p>';
        } else {
            echo '<p>' . $jabatan . '</p>';
        }
        if (!empty($ttd)) {
            echo '<img height="100px" width="150px"src="./upload/' . $ttd . '" alt="" >';
        }
        if (!empty($nama)) {
            echo '<p class="lead">' . $nama . '</p>';
        } else {
            echo '<p class="lead"> - </p>';
        }
        if (!empty($nip)) {
            echo '<p class="lead1">NIP. ' . $nip . '</p>';
        } else {
            echo '<p class="lead1">NIP. -</p>';
        }
        echo '
            </div>
        </div>
        <div class="jarak2"></div>
    <!-- Container END -->

    </body>';
    }
}
