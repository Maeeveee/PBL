create database tatib;

use tatib;

CREATE TABLE Mahasiswa (
    NIM CHAR(12) PRIMARY KEY,
    Nama VARCHAR(100) NOT NULL,
    Email VARCHAR(100),
    NoTelepon VARCHAR(15),
    Alamat VARCHAR(255),
    TanggalLahir DATE,
    Poin INT DEFAULT 0,
	ProdiID INT FOREIGN KEY REFERENCES ProgramStudi(ProdiID)
);

CREATE TABLE Dosen (
    NIDN CHAR(10) PRIMARY KEY,
    Nama VARCHAR(100) NOT NULL,
    Email VARCHAR(100),
    NoTelepon VARCHAR(15)
);

CREATE TABLE Admin (
    AdminID INT PRIMARY KEY,
    NamaAdmin VARCHAR(100) NOT NULL,
    EmailAdmin VARCHAR(100) UNIQUE NOT NULL,
    NoTelepon VARCHAR(15),
);

CREATE TABLE ProgramStudi (
	ProdiID INT PRIMARY KEY NOT NULL,
	Prodi VARCHAR(50) NOT NULL
);

CREATE TABLE Users (
	UsersID int PRIMARY KEY IDENTITY(1,1),
    Username VARCHAR(50),
	Password VARCHAR(255) NOT NULL,
    Role VARCHAR(20) CHECK (Role IN ('Mahasiswa', 'Dosen', 'Admin')) NOT NULL,
	NIDN CHAR(10),
	AdminID INT,
    FOREIGN KEY (NIDN) REFERENCES Dosen(NIDN) ON DELETE CASCADE,
	FOREIGN KEY (AdminID) REFERENCES Admin(AdminID) ON DELETE CASCADE
);

CREATE TABLE JenisPelanggaran (
    JenisID INT PRIMARY KEY IDENTITY(1,1),
    NamaPelanggaran VARCHAR(100),
    Tingkat CHAR(3)
);

CREATE TABLE Pelanggaran (
    PelanggaranID INT PRIMARY KEY IDENTITY(1,1),
    NIM CHAR(12) FOREIGN KEY REFERENCES Mahasiswa(NIM),
    NIDN CHAR(10) FOREIGN KEY REFERENCES Dosen(NIDN),
    JenisID INT FOREIGN KEY REFERENCES JenisPelanggaran(JenisID),
    TanggalPelanggaran DATE NOT NULL,
    BuktiFoto VARCHAR(255),
	Surat VARCHAR(255),
	Status VARCHAR(20) DEFAULT 'Pending',
	AdminID int,
	Admin int FOREIGN KEY REFERENCES Admin(AdminID),
    TugasID INT,
    FOREIGN KEY (TugasID) REFERENCES Tugas(TugasID)
);

CREATE TABLE Tugas (
    TugasID INT PRIMARY KEY IDENTITY(1,1),
    Deskripsi VARCHAR(255),
	TanggalDibuat DATE,
    TanggalSelesai DATE,
	NIDN CHAR(10),
	NIM CHAR(12),
    TugasID INT,
    FOREIGN KEY (TugasID) REFERENCES Tugas(TugasID),
	FOREIGN KEY (NIDN) REFERENCES Dosen(NIDN) ON DELETE CASCADE,
    FOREIGN KEY (NIM) REFERENCES Mahasiswa(NIM) ON DELETE CASCADE
);

CREATE TABLE DetailPelanggaran (
	NIM CHAR(12) FOREIGN KEY REFERENCES Mahasiswa(NIM),
	PelanggaranID INT FOREIGN KEY REFERENCES Pelanggaran(PelanggaranID),
	Poin INT,
	Tgl Date
);

CREATE TABLE Notifikasi (
    NotifikasiID INT PRIMARY KEY,
    Judul NVARCHAR(100),
    Isi NVARCHAR(255),
	UsersID INT,
	AdminID int,
    FOREIGN KEY (UsersID) REFERENCES Users(UsersID),
	FOREIGN KEY (AdminID) REFERENCES Admin(AdminID)
);

CREATE TRIGGER before_insert_users
ON Users
AFTER INSERT
AS
BEGIN
    UPDATE U
    SET U.Username = CASE 
        WHEN I.Role = 'Mahasiswa' THEN I.NIM
        WHEN I.Role = 'Dosen' THEN I.NIDN
        WHEN I.Role = 'Admin' THEN CAST(I.AdminID AS VARCHAR)
    END
    FROM Users U
    INNER JOIN INSERTED I ON U.UsersID = I.UsersID;
END;

INSERT INTO ProgramStudi (ProdiID, Prodi) VALUES
(1, 'D-IV Teknik Informatika'),
(2, 'D-IV Sistem Informasi Bisnis'),
(3, 'D-II PPLS');

INSERT INTO Mahasiswa (NIM, Nama, Email, NoTelepon, Alamat, TanggalLahir, Poin, ProdiID) VALUES
('210123456789', 'Ahmad Rizky', 'ahmadrizky@email.com', '081234567890', 'Malang', '2000-01-01', 100, 1),  
('210123456790', 'Budi Santoso', 'budi@email.com', '081234567891', 'Surabaya', '2000-02-01', 80, 2),   
('210123456791', 'Citra Dewi', 'citra@email.com', '081234567892', 'Kediri', '2000-03-01', 90, 3);   

INSERT INTO Dosen (NIDN, Nama, Email, NoTelepon) VALUES
('1234567890', 'Dr. John Doe', 'john.doe@university.com', '082345678901'),
('1234567891', 'Prof. Jane Smith', 'jane.smith@university.com', '082345678902'),
('1234567892', 'Dr. Mark Brown', 'mark.brown@university.com', '082345678903');

INSERT INTO Admin (AdminID, NamaAdmin, EmailAdmin, NoTelepon) VALUES
(1234, 'Admin A', 'admina@university.com', '083456789000'),
(6789, 'Admin B', 'adminb@university.com', '083456789001');

INSERT INTO Users (Username, Password, Role, NIM, NIDN, AdminID) VALUES
(NULL, 'password123', 'Mahasiswa', '210123456789', NULL, NULL),  
(NULL, 'password123', 'Mahasiswa', '210123456790', NULL, NULL),
(NULL, 'password123', 'Mahasiswa', '210123456791', NULL, NULL), 
(NULL, 'password123', 'Dosen', NULL, '1234567890', NULL), 
(NULL, 'password123', 'Dosen', NULL, '1234567891', NULL), 
(NULL, 'password123', 'Dosen', NULL, '1234567892', NULL),  
(NULL, 'adminpass', 'Admin', NULL, NULL, 1234), 
(NULL, 'adminpass', 'Admin', NULL, NULL, 6789);

INSERT INTO JenisPelanggaran (NamaPelanggaran, Tingkat) VALUES
('Pelanggaran Ringan', 'I'),
('Pelanggaran Sedang', 'II'),
('Pelanggaran Berat', 'III'),
('Pelanggaran Sangat Berat', 'IV'),
('Pelanggaran Fatal', 'V');

CREATE TABLE PolinemaToday (
    BeritaID INT PRIMARY KEY IDENTITY(1,1),
    Judul VARCHAR(255) NOT NULL,
    Isi TEXT NOT NULL,
    TglDibuat DATETIME NOT NULL,
    Thumbnail VARCHAR(255),
    AdminID INT,
    FOREIGN KEY (AdminID) REFERENCES Admin(AdminID)
);

CREATE TRIGGER SetAdminID
ON PolinemaToday
INSTEAD OF INSERT
AS
BEGIN
    DECLARE @AdminID INT;
    -- Dapatkan AdminID berdasarkan sesi atau pengguna yang sedang login
    SET @AdminID = (SELECT AdminID FROM Users WHERE Username = SYSTEM_USER);

    -- Masukkan data dengan AdminID yang terisi otomatis
    INSERT INTO PolinemaToday (Judul, Isi, TglDibuat, Thumbnail, AdminID)
    SELECT Judul, Isi, TglDibuat, Thumbnail, @AdminID
    FROM INSERTED;
END;

CREATE TRIGGER after_update_pelanggaran_status
ON Pelanggaran
AFTER UPDATE
AS
BEGIN
    DECLARE @Status VARCHAR(20);
    DECLARE @PelanggaranID INT;
    DECLARE @AdminID INT;

    -- Ambil status dan pelanggaran ID dari baris yang baru diupdate
    SELECT @Status = Status, @PelanggaranID = PelanggaranID
    FROM INSERTED;

    -- Ambil AdminID yang melakukan update dari Users
    SET @AdminID = (SELECT AdminID FROM Users WHERE Username = SYSTEM_USER);

    -- Jika status diubah menjadi 'Selesai', lakukan tindakan tambahan
    IF @Status = 'Selesai'
    BEGIN
        -- Mengirim notifikasi dengan AdminID yang sesuai
        INSERT INTO Notifikasi (Judul, Isi, UsersID, AdminID)
        VALUES ('Pelanggaran Selesai', 'Pelanggaran mahasiswa telah selesai diproses.', NULL, @AdminID);
    END;
END;

-- STORE PROCEDURE MENAMPILKAN PELANGGAR TERBANYAK
CREATE PROCEDURE GetTopMahasiswaPelanggar
    @TopN INT -- Parameter untuk jumlah mahasiswa yang ingin ditampilkan
AS
BEGIN
    SELECT TOP (@TopN)
        M.NIM,
        M.Nama,
        COUNT(P.PelanggaranID) AS JumlahPelanggaran
    FROM Mahasiswa M
    LEFT JOIN Pelanggaran P ON M.NIM = P.NIM
    GROUP BY M.NIM, M.Nama
    ORDER BY COUNT(P.PelanggaranID) DESC;
END;

EXEC GetTopMahasiswaPelanggar @TopN = 5;

ALTER TABLE Pelanggaran
ADD FOREIGN KEY (TugasID) REFERENCES Tugas(TugasID);

ALTER TABLE DetailPelanggaran
DROP COLUMN Poin;

ALTER TABLE DetailPelanggaran
DROP COLUMN Tgl;

ALTER TABLE Dosen
ADD Pendidikan VARCHAR(255);

ALTER TABLE Dosen
ADD Pengalaman VARCHAR(255);

ALTER TABLE Mahasiswa
ADD NamaWali VARCHAR(255);


use tatib;

DELETE FROM JenisPelanggaran;

-- Nonaktifkan constraint sementara
ALTER TABLE Pelanggaran NOCHECK CONSTRAINT FK__Pelanggar__Jenis__5070F446;

-- Hapus data di JenisPelanggaran
DELETE FROM JenisPelanggaran;

-- Aktifkan kembali constraint
ALTER TABLE Pelanggaran CHECK CONSTRAINT FK__Pelanggar__Jenis__5070F446;

ALTER TABLE JenisPelanggaran
ALTER COLUMN NamaPelanggaran VARCHAR(MAX);

INSERT INTO JenisPelanggaran (NamaPelanggaran, Tingkat) VALUES
('Berkomunikasi dengan tidak sopan, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, karyawan, atau orang lain', 'V'),
('Berbusana tidak sopan dan tidak rapi. Yaitu antara lain adalah: berpakaian ketat, transparan, memakai t-shirt (baju kaos tidak berkerah), tank top, hipster, you can see, rok mini, backless, celana pendek, celana tiga per empat, legging, model celana atau baju koyak, sandal, sepatu sandal di lingkungan kampus', 'IV'),
('Mahasiswa laki-laki berambut tidak rapi, gondrong yaitu panjang rambutnya melewati batas alis mata di bagian depan, telinga di bagian samping atau menyentuh kerah baju di bagian leher', 'IV'),
('Mahasiswa berambut dengan model punk, dicat selain hitam dan/atau skinned.', 'IV'),
('Makan, atau minum di dalam ruang kuliah/ laboratorium/ bengkel.', 'IV'),
('Melanggar peraturan/ ketentuan yang berlaku di Polinema baik di Jurusan/ Program Studi', 'IV'),
('Tidak menjaga kebersihan di seluruh area Polinema', 'III'),
('Membuat kegaduhan yang mengganggu pelaksanaan perkuliahan atau praktikum yang sedang berlangsung.', 'III'),
('Merokok di luar area kawasan merokok', 'III'),
('Bermain kartu, game online di area kampus', 'III'),
('Mengotori atau mencoret-coret meja, kursi, tembok, dan lain-lain di lingkungan Polinema', 'III'),
('Bertingkah laku kasar atau tidak sopan kepada mahasiswa, dosen, dan/atau karyawan.', 'III'),
('Merusak sarana dan prasarana yang ada di area Polinema', 'III'),
('Tidak menjaga ketertiban dan keamanan di seluruh area Polinema (misalnya: parkir tidak pada tempatnya, konvoi selebrasi wisuda dll)', 'II'),
('Melakukan pengotoran/ pengrusakan barang milik orang lain termasuk milik Politeknik Negeri Malang', 'II'),
('Mengakses materi pornografi di kelas atau area kampus', 'II'),
('Membawa dan/atau menggunakan senjata tajam dan/atau senjata api untuk hal kriminal', 'II'),
('Melakukan perkelahian, serta membentuk geng/ kelompok yang bertujuan negatif.', 'II'),
('Melakukan kegiatan politik praktis di dalam kampus', 'II'),
('Melakukan tindakan kekerasan atau perkelahian di dalam kampus.', 'II'),
('Melakukan penyalahgunaan identitas untuk perbuatan negatif', 'II'),
('Mengancam, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, dan/atau karyawan.', 'II'),
('Mencuri dalam bentuk apapun', 'II'),
('Melakukan kecurangan dalam bidang akademik, administratif, dan keuangan.', 'II'),
('Melakukan pemerasan dan/atau penipuan', 'II'),
('Melakukan pelecehan dan/atau tindakan asusila dalam segala bentuk di dalam dan di luar kampus', 'II'),
('Berjudi, mengkonsumsi minum-minuman keras, dan/ atau bermabuk-mabukan di lingkungan dan di luar lingkungan Kampus Polinema', 'II'),
('Mengikuti organisasi dan atau menyebarkan faham-faham yang dilarang oleh Pemerintah.', 'II'),
('Melakukan pemalsuan data / dokumen / tanda tangan.', 'II'),
('Melakukan plagiasi (copy paste) dalam tugas-tugas atau karya ilmiah', 'II'),
('Tidak menjaga nama baik Polinema di masyarakat dan/ atau mencemarkan nama baik Polinema melalui media apapun', 'I'),
('Melakukan kegiatan atau sejenisnya yang dapat menurunkan kehormatan atau martabat Negara, Bangsa dan Polinema.', 'I'),
('Menggunakan barang-barang psikotropika dan/ atau zat-zat Adiktif lainnya', 'I'),
('Mengedarkan serta menjual barang-barang psikotropika dan/ atau zat-zat Adiktif lainnya', 'I'),
('Terlibat dalam tindakan kriminal dan dinyatakan bersalah oleh Pengadilan', 'I');

ALTER TABLE Pelanggaran
ADD TempatPelanggaran VARCHAR(255);