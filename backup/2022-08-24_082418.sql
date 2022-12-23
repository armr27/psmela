DROP TABLE tbl_disposisi;

CREATE TABLE `tbl_disposisi` (
  `id_disposisi` int(10) NOT NULL AUTO_INCREMENT,
  `tujuan` varchar(250) NOT NULL,
  `isi_disposisi` mediumtext NOT NULL,
  `sifat` varchar(100) NOT NULL,
  `batas_waktu` date NOT NULL,
  `catatan` varchar(250) NOT NULL,
  `id_surat` int(10) NOT NULL,
  `id_user` tinyint(2) NOT NULL,
  PRIMARY KEY (`id_disposisi`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO tbl_disposisi VALUES("7","Tata Usaha","Teruskan ke dinas kesehatan","","0000-00-00","","12","3");
INSERT INTO tbl_disposisi VALUES("8","Pj Kesling","Pelatihan penginputan dan peningkatan program stbm","","0000-00-00","","11","3");
INSERT INTO tbl_disposisi VALUES("9","Pj Bikor, Bidan desa, Gizi, Darbin","Bimtek terintegrasi jampersal dan e-kohort","","0000-00-00","","10","3");



DROP TABLE tbl_instansi;

CREATE TABLE `tbl_instansi` (
  `id_instansi` tinyint(1) NOT NULL,
  `institusi` varchar(150) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `status` varchar(150) NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `kepsek` varchar(50) NOT NULL,
  `nip` varchar(25) NOT NULL,
  `website` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `logo` varchar(250) NOT NULL,
  `id_user` tinyint(2) NOT NULL,
  PRIMARY KEY (`id_instansi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO tbl_instansi VALUES("1","Dinas Kesehatan","PUSKESMAS BUKIT KAYU KAPUR","Puskesmas Daerah","Jl Soekarno-Hatta KM 27,5 Dumai - 28843","dr. Esra Dumatang Tampubolon","196911022010011001","https://dinkes.dumaikota.go.id","puskk.bkk@gmail.com","logo.png","1");



DROP TABLE tbl_klasifikasi;

CREATE TABLE `tbl_klasifikasi` (
  `id_klasifikasi` int(5) NOT NULL AUTO_INCREMENT,
  `kode` varchar(30) NOT NULL,
  `nama` varchar(250) NOT NULL,
  `uraian` mediumtext NOT NULL,
  `id_user` tinyint(2) NOT NULL,
  PRIMARY KEY (`id_klasifikasi`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO tbl_klasifikasi VALUES("1","01","Pemberitahuan","Surat Pemberitahuan","1");
INSERT INTO tbl_klasifikasi VALUES("2","02","Pengajuan","Surat Pengajuan","1");



DROP TABLE tbl_sett;

CREATE TABLE `tbl_sett` (
  `id_sett` tinyint(1) NOT NULL,
  `surat_masuk` tinyint(2) NOT NULL,
  `surat_keluar` tinyint(2) NOT NULL,
  `referensi` tinyint(2) NOT NULL,
  `id_user` tinyint(2) NOT NULL,
  PRIMARY KEY (`id_sett`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO tbl_sett VALUES("1","10","10","10","1");



DROP TABLE tbl_surat_keluar;

CREATE TABLE `tbl_surat_keluar` (
  `id_surat` int(10) NOT NULL AUTO_INCREMENT,
  `no_agenda` int(10) NOT NULL,
  `tujuan` varchar(250) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `isi` mediumtext NOT NULL,
  `kode` varchar(30) NOT NULL,
  `tgl_surat` date NOT NULL,
  `tgl_catat` date NOT NULL,
  `file` varchar(250) NOT NULL,
  `keterangan` varchar(250) NOT NULL,
  `id_user` tinyint(2) NOT NULL,
  PRIMARY KEY (`id_surat`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO tbl_surat_keluar VALUES("8","1","Kelurahan Gurun Panjang","005/479/DINKES-PKMBKK /2022","Rapat Koordinasi Program Kesehatan Lingkungan","","2022-06-04","2022-08-22","1359-UNDANGAN KESLING.docx","Tata Usaha","1");
INSERT INTO tbl_surat_keluar VALUES("9","2","Bank Mandiri Dumai","900/234/DINKES-PKMBKK","Permohonan Ganti Speciment Tanda Tangan","","2022-02-07","2022-08-22","8814-GANTI SPECIMEN TANDA TANGAN MANDIRI.docx","Tata Usaha","1");



DROP TABLE tbl_surat_masuk;

CREATE TABLE `tbl_surat_masuk` (
  `id_surat` int(10) NOT NULL AUTO_INCREMENT,
  `no_agenda` int(10) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `asal_surat` varchar(250) NOT NULL,
  `isi` mediumtext NOT NULL,
  `kode` varchar(30) NOT NULL,
  `indeks` varchar(30) NOT NULL,
  `tgl_surat` date NOT NULL,
  `tgl_diterima` date NOT NULL,
  `file` varchar(250) NOT NULL,
  `keterangan` varchar(250) NOT NULL,
  `id_user` tinyint(2) NOT NULL,
  PRIMARY KEY (`id_surat`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

INSERT INTO tbl_surat_masuk VALUES("10","1","443/949/DINKES.3","Dinas Kesehatan","Bimtek terintegrasai jaminan persalinan dan e-kohort","","","2022-08-13","2022-08-22","1223-Bimtek Terintegrasi Jaminan Persalinan d.pdf","","1");
INSERT INTO tbl_surat_masuk VALUES("11","2","443/930/DINKES.3","Dinas Kesehatan","Pemanggilan peserta pelatihan penginputan dan peningkatan program STBM","","","2022-08-09","2022-08-22","2073-Pemanggilan Peserta Pelatihan Penginputa.pdf","","1");
INSERT INTO tbl_surat_masuk VALUES("12","3","-","Melani Hariyanti","Surat Pengunduran Diri","","","2022-08-22","2022-08-22","9302-Surat Pengunduran Diri Melani Hariyanti.pdf","","1");



DROP TABLE tbl_user;

CREATE TABLE `tbl_user` (
  `id_user` tinyint(2) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(35) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nip` varchar(25) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO tbl_user VALUES("1","admin","21232f297a57a5a743894a0e4a801fc3","Administrator","-","1");
INSERT INTO tbl_user VALUES("3","kapus","11f4475cfbb3d0ecab95029d42eb3024","dr. Esra Dumatang Tampubolon","196911022010011001","4");



