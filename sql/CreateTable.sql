create schema sirima;

set search_path to sirima;

create table akun(
username varchar(50),
role boolean not null,
password varchar(20) not null,
primary key (username)
);

create table periode_penerimaan(
nomor smallint,
tahun char(4),
status_aktif boolean,
primary key (nomor, tahun)
);

create table jenjang(
nama char(2),
primary key (nama)
);

create table program_studi(
kode serial,
nama varchar(100) not null,
jenis_kelas varchar(50) not null,
nama_fakultas varchar(50) not null,
jenjang char(2) not null,
primary key (kode),
foreign key (jenjang) references jenjang (nama) on update cascade on delete cascade
);

create table penerimaan_prodi(
nomor_periode int,
tahun_periode char(4),
kode_prodi int,
kuota int not null,
jumlah_pelamar int,
jumlah_diterima int,
primary key (nomor_periode, tahun_periode, kode_prodi),
foreign key (nomor_periode, tahun_periode) references periode_penerimaan (nomor, tahun) on update cascade on delete cascade,
foreign key (kode_prodi) references program_studi (kode) on update cascade on delete cascade
);

create table pelamar(
username varchar(50),
nama_lengkap varchar(100) not null,
alamat text not null,
jenis_kelamin char(1) not null,
tanggal_lahir date not null,
no_ktp char(16) not null,
email varchar(100) not null unique,
primary key (username),
foreign key (username) references akun (username) on update cascade on delete cascade
);

create table pendaftaran(
id serial,
status_lulus boolean,
status_verifikasi boolean,
npm char(10),
pelamar varchar(50) not null,
nomor_periode smallint not null,
tahun_periode char(4) not null,
primary key (id),
foreign key (pelamar) references pelamar (username) on update cascade on delete cascade,
foreign key (nomor_periode, tahun_periode) references periode_penerimaan (nomor, tahun) on update cascade on delete cascade
);

create table pendaftaran_uui(
id_pendaftaran int,
rapot varchar(100) not null,
surat_rekomendasi varchar(100) not null,
asal_sekolah varchar(100) not null,
jenis_sma varchar(50) not null,
alamat_sekolah text not null,
nisn varchar(10) not null,
tgl_lulus date not null,
nilai_uan numeric(10, 2) not null,
primary key (id_pendaftaran),
foreign key (id_pendaftaran) references pendaftaran (id) on update cascade on delete cascade
);

create table rekomendasi(
tgl_review date,
id_pendaftaran int,
status boolean not null,
nilai int not null,
komentar text not null,
primary key (tgl_review, id_pendaftaran),
foreign key (id_pendaftaran) references pendaftaran_uui (id_pendaftaran) on update cascade on delete cascade
);

create table lokasi_ujian(
kota varchar(100),
tempat varchar(150),
primary key (kota, tempat)
);

create table pendaftaran_semas(
id_pendaftaran int,
status_hadir boolean,
nilai_ujian int,
no_kartu_ujian char(10),
lokasi_kota varchar(100) not null,
lokasi_tempat varchar(150) not null,
primary key (id_pendaftaran),
foreign key (id_pendaftaran) references pendaftaran (id) on update cascade on delete cascade,
foreign key (lokasi_kota, lokasi_tempat) references lokasi_ujian (kota, tempat) on update cascade on delete cascade
);

create table pendaftaran_semas_sarjana(
id_pendaftaran int,
asal_sekolah varchar(100) not null,
jenis_sma varchar(50) not null,
alamat_sekolah text not null,
nisn varchar(10) not null,
tgl_lulus date not null,
nilai_uan numeric(10, 2) not null,
primary key (id_pendaftaran),
foreign key (id_pendaftaran) references pendaftaran (id) on update cascade on delete cascade
);

create table pendaftaran_semas_pascasarjana(
id_pendaftaran int,
nilai_tpa int not null,
nilai_toefl int not null,
jenjang_terakhir char(2) not null,
asal_univ varchar(100) not null,
alamat_univ text not null,
prodi_terakhir varchar(100) not null,
nilai_ipk numeric(10, 2) not null,
no_ijazah varchar(50) not null,
tgl_lulus date not null,
jenjang char(2) not null,
nama_rekomender varchar(100),
prop_penelitian varchar(100),
primary key (id_pendaftaran),
foreign key (id_pendaftaran) references pendaftaran (id) on update cascade on delete cascade,
foreign key (jenjang_terakhir) references jenjang (nama) on update cascade on delete cascade,
foreign key (jenjang) references jenjang (nama) on update cascade on delete cascade
);

create table ruang_ujian(
kota varchar(100),
tempat varchar(150),
id smallint,
primary key (kota, tempat, id),
foreign key (kota, tempat) references lokasi_ujian (kota, tempat) on update cascade on delete cascade
);

create table pengawas(
nomor_induk varchar(16),
nama varchar(100) not null,
no_telp text not null,
lokasi_kota varchar(100) not null,
lokasi_tempat varchar(150) not null,
lokasi_id smallint not null,
primary key (nomor_induk),
foreign key (lokasi_kota, lokasi_tempat, lokasi_id) references ruang_ujian (kota, tempat, id) on update cascade on delete cascade
);

create table pendaftaran_prodi(
id_pendaftaran int,
kode_prodi int,
status_lulus boolean,
primary key (id_pendaftaran, kode_prodi),
foreign key (id_pendaftaran) references pendaftaran (id) on update cascade on delete cascade,
foreign key (kode_prodi) references program_studi (kode) on update cascade on delete cascade
);

create table pembayaran(
id serial,
waktu_bayar timestamp not null,
jumlah_bayar numeric(10, 2) not null,
id_pendaftaran int not null,
primary key (id),
foreign key (id_pendaftaran) references pendaftaran_semas (id_pendaftaran) on update cascade on delete cascade
);

create table jadwal_penting(
nomor smallint,
tahun char(4),
jenjang char(2),
waktu_mulai timestamp, 
waktu_selesai timestamp not null,
deskripsi varchar(150) not null,
primary key (nomor, tahun, jenjang, waktu_mulai),
foreign key (nomor, tahun) references periode_penerimaan (nomor, tahun) on update cascade on delete cascade,
foreign key (jenjang) references jenjang (nama) on update cascade on delete cascade
);

create table lokasi_jadwal(
kota varchar(100),
tempat varchar(150),
nomor_periode smallint not null,
tahun_periode char(4) not null,
jenjang char(2) not null,
waktu_awal timestamp not null,
primary key (kota, tempat,nomor_periode,tahun_periode,jenjang,waktu_awal),
foreign key (kota,tempat) references lokasi_ujian (kota,tempat) on update cascade on delete cascade,
foreign key (nomor_periode, tahun_periode, jenjang, waktu_awal) references jadwal_penting (nomor, tahun, jenjang, waktu_mulai) on update cascade on delete cascade
);