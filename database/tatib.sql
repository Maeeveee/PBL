create database tatib;

use tatib;

CREATE TABLE ProgramStudi (
	ProdiID INT PRIMARY KEY NOT NULL,
	Prodi VARCHAR(50) NOT NULL
);

CREATE TABLE Mahasiswa (
    NIM CHAR(12) PRIMARY KEY,
    Nama VARCHAR(100) NOT NULL,
    Email VARCHAR(100),
    NoTelepon VARCHAR(15),
    Alamat VARCHAR(255),
    TanggalLahir DATE,
	ProdiID INT FOREIGN KEY REFERENCES ProgramStudi(ProdiID),
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

CREATE TABLE Konfirmasi (
    KonfirmasiID INT PRIMARY KEY IDENTITY(1,1),
    BuktiPenyelesaian VARCHAR(255),
    TanggalPelaksanaan DATE,
    NIM CHAR(12) FOREIGN KEY REFERENCES Mahasiswa(NIM),
    AdminID INT FOREIGN KEY REFERENCES Admin(AdminID),
);

CREATE TABLE Users (
	UsersID INT PRIMARY KEY IDENTITY(1,1),
    Username VARCHAR(50),
	Password VARCHAR(255) NOT NULL,
    Role VARCHAR(20) CHECK (Role IN ('Mahasiswa', 'Dosen', 'Admin')) NOT NULL,
	NIDN CHAR(10),
    AdminID INT,  
    NIM CHAR(12),  
    FOREIGN KEY (NIDN) REFERENCES Dosen(NIDN) ON DELETE CASCADE,
	FOREIGN KEY (AdminID) REFERENCES Admin(AdminID) ON DELETE CASCADE,
    FOREIGN KEY (NIM) REFERENCES Mahasiswa(NIM) ON DELETE CASCADE
);

CREATE TABLE JenisPelanggaran (
    JenisID INT PRIMARY KEY IDENTITY(1,1),
    NamaPelanggaran VARCHAR(MAX),
    Tingkat CHAR(3),
    Poin INT
);

CREATE TABLE Tugas (
    TugasID INT PRIMARY KEY IDENTITY(1,1),
    Deskripsi VARCHAR(255),
	NIDN CHAR(10),
	FOREIGN KEY (NIDN) REFERENCES Dosen(NIDN) ON DELETE CASCADE,
);

CREATE TABLE Pelanggaran (
    PelanggaranID INT PRIMARY KEY IDENTITY(1,1),
    NIM CHAR(12) FOREIGN KEY REFERENCES Mahasiswa(NIM),
    NIDN CHAR(10) FOREIGN KEY REFERENCES Dosen(NIDN),
    JenisID INT FOREIGN KEY REFERENCES JenisPelanggaran(JenisID),
    TanggalPelanggaran DATE NOT NULL,
    TempatPelanggaran VARCHAR(255) NOT NULL,
    BuktiFoto VARCHAR(255),
	Surat VARCHAR(255),
	Status VARCHAR(20) DEFAULT 'Pending',
	AdminID INT,
	Admin INT FOREIGN KEY REFERENCES Admin(AdminID),
    TugasID INT,
    FOREIGN KEY (TugasID) REFERENCES Tugas(TugasID)
);

CREATE TABLE DetailPelanggaran (
	NIM CHAR(12) FOREIGN KEY REFERENCES Mahasiswa(NIM),
	PelanggaranID INT FOREIGN KEY REFERENCES Pelanggaran(PelanggaranID),
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

CREATE TABLE PolinemaToday (
    BeritaID INT PRIMARY KEY IDENTITY(1,1),
    Judul VARCHAR(255) NOT NULL,
    Isi TEXT NOT NULL,
    TglDibuat DATETIME NOT NULL,
    Thumbnail VARCHAR(255),
    AdminID INT,
    FOREIGN KEY (AdminID) REFERENCES Admin(AdminID)
);

CREATE TABLE Pendidikan (
    PendidikanID INT PRIMARY KEY IDENTITY(1,1),
    NIDN CHAR(10),
    Universitas VARCHAR(255),
    TahunMasuk INT,
    TahunLulus INT,
    FOREIGN KEY (NIDN) REFERENCES Dosen(NIDN)
);

CREATE TABLE Pengalaman (
    PengalamanID INT PRIMARY KEY IDENTITY(1,1),
    NIDN CHAR(10),
    Deskripsi VARCHAR(255),
    FOREIGN KEY (NIDN) REFERENCES Dosen(NIDN)
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

CREATE TRIGGER after_insert_pelanggaran
ON Pelanggaran
AFTER INSERT
AS
BEGIN
    -- Deklarasi variabel untuk NIM dan PelanggaranID
    DECLARE @NIM CHAR(12);
    DECLARE @PelanggaranID INT;

    -- Ambil NIM dan PelanggaranID dari baris yang baru dimasukkan
    SELECT @NIM = NIM, @PelanggaranID = PelanggaranID
    FROM INSERTED;

    -- Masukkan data ke dalam tabel DetailPelanggaran
    INSERT INTO DetailPelanggaran (NIM, PelanggaranID)
    VALUES (@NIM, @PelanggaranID);
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

INSERT INTO ProgramStudi (ProdiID, Prodi) VALUES
(1, 'D-IV Teknik Informatika'),
(2, 'D-IV Sistem Informasi Bisnis'),
(3, 'D-II PPLS');

INSERT INTO Mahasiswa (NIM, Nama, Email, NoTelepon, Alamat, TanggalLahir, ProdiID) VALUES
('210123456789', 'Ahmad Rizky', 'ahmadrizky@email.com', '081234567890', 'Malang', '2000-01-01', 1),
('210123456790', 'Budi Santoso', 'budi@email.com', '081234567891', 'Surabaya', '2000-02-01', 2),
('210123456791', 'Citra Dewi', 'citra@email.com', '081234567892', 'Kediri', '2000-03-01', 3);
  

INSERT INTO Dosen (NIDN, Nama, Email, NoTelepon) VALUES
('1234567890', 'Dr. John Doe', 'john.doe@university.com', '082345678901'),
('1234567891', 'Prof. Jane Smith', 'jane.smith@university.com', '082345678902'),
('1234567892', 'Dr. Mark Brown', 'mark.brown@university.com', '082345678903');

INSERT INTO Admin (AdminID, NamaAdmin, EmailAdmin, NoTelepon) VALUES
(1234, 'Admin A', 'admina@university.com', '083456789000'),
(6789, 'Admin B', 'adminb@university.com', '083456789001');

INSERT INTO Users (Username, Password, Role, NIM, NIDN, AdminID) VALUES
('210123456789', 'password123', 'Mahasiswa', '210123456789', NULL, NULL),  
('210123456790', 'password123', 'Mahasiswa', '210123456790', NULL, NULL),
('210123456791', 'password123', 'Mahasiswa', '210123456791', NULL, NULL), 
(NULL, 'password123', 'Dosen', NULL, '1234567890', NULL), 
(NULL, 'password123', 'Dosen', NULL, '1234567891', NULL), 
(NULL, 'password123', 'Dosen', NULL, '1234567892', NULL),  
(NULL, 'adminpass', 'Admin', NULL, NULL, 1234), 
(NULL, 'adminpass', 'Admin', NULL, NULL, 6789);

INSERT INTO JenisPelanggaran (NamaPelanggaran, Tingkat, Poin) VALUES
('Berkomunikasi dengan tidak sopan, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, karyawan, atau orang lain', 'V', 3),
('Berbusana tidak sopan dan tidak rapi. Yaitu antara lain adalah: berpakaian ketat, transparan, memakai t-shirt (baju kaos tidak berkerah), tank top, hipster, you can see, rok mini, backless, celana pendek, celana tiga per empat, legging, model celana atau baju koyak, sandal, sepatu sandal di lingkungan kampus', 'IV', 6),
('Mahasiswa laki-laki berambut tidak rapi, gondrong yaitu panjang rambutnya melewati batas alis mata di bagian depan, telinga di bagian samping atau menyentuh kerah baju di bagian leher', 'IV', 6),
('Mahasiswa berambut dengan model punk, dicat selain hitam dan/atau skinned.', 'IV', 6),
('Makan, atau minum di dalam ruang kuliah/ laboratorium/ bengkel.', 'IV', 6),
('Melanggar peraturan/ ketentuan yang berlaku di Polinema baik di Jurusan/ Program Studi', 'IV', 6),
('Tidak menjaga kebersihan di seluruh area Polinema', 'III', 12),
('Membuat kegaduhan yang mengganggu pelaksanaan perkuliahan atau praktikum yang sedang berlangsung.', 'III', 12),
('Merokok di luar area kawasan merokok', 'III', 12),
('Bermain kartu, game online di area kampus', 'III', 12),
('Mengotori atau mencoret-coret meja, kursi, tembok, dan lain-lain di lingkungan Polinema', 'III', 12),
('Bertingkah laku kasar atau tidak sopan kepada mahasiswa, dosen, dan/atau karyawan.', 'III', 12),
('Merusak sarana dan prasarana yang ada di area Polinema', 'III', 12),
('Tidak menjaga ketertiban dan keamanan di seluruh area Polinema (misalnya: parkir tidak pada tempatnya, konvoi selebrasi wisuda dll)', 'II', 24),
('Melakukan pengotoran/ pengrusakan barang milik orang lain termasuk milik Politeknik Negeri Malang', 'II', 24),
('Mengakses materi pornografi di kelas atau area kampus', 'II', 24),
('Membawa dan/atau menggunakan senjata tajam dan/atau senjata api untuk hal kriminal', 'II', 24),
('Melakukan perkelahian, serta membentuk geng/ kelompok yang bertujuan negatif.', 'II', 24),
('Melakukan kegiatan politik praktis di dalam kampus', 'II', 24),
('Melakukan tindakan kekerasan atau perkelahian di dalam kampus.', 'II', 24),
('Melakukan penyalahgunaan identitas untuk perbuatan negatif', 'II', 24),
('Mengancam, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, dan/atau karyawan.', 'II', 24),
('Mencuri dalam bentuk apapun', 'II', 24),
('Melakukan kecurangan dalam bidang akademik, administratif, dan keuangan.', 'II', 24),
('Melakukan pemerasan dan/atau penipuan', 'II', 24),
('Melakukan pelecehan dan/atau tindakan asusila dalam segala bentuk di dalam dan di luar kampus', 'II', 24),
('Berjudi, mengkonsumsi minum-minuman keras, dan/ atau bermabuk-mabukan di lingkungan dan di luar lingkungan Kampus Polinema', 'II', 24),
('Mengikuti organisasi dan atau menyebarkan faham-faham yang dilarang oleh Pemerintah.', 'II', 24),
('Melakukan pemalsuan data / dokumen / tanda tangan.', 'II', 24),
('Melakukan plagiasi (copy paste) dalam tugas-tugas atau karya ilmiah', 'II', 24),
('Tidak menjaga nama baik Polinema di masyarakat dan/ atau mencemarkan nama baik Polinema melalui media apapun', 'I', 48),
('Melakukan kegiatan atau sejenisnya yang dapat menurunkan kehormatan atau martabat Negara, Bangsa dan Polinema.', 'I',48),
('Menggunakan barang-barang psikotropika dan/ atau zat-zat Adiktif lainnya', 'I', 48),
('Mengedarkan serta menjual barang-barang psikotropika dan/ atau zat-zat Adiktif lainnya', 'I', 48),
('Terlibat dalam tindakan kriminal dan dinyatakan bersalah oleh Pengadilan', 'I', 48);


-- Menambahkan riwayat pendidikan
INSERT INTO Pendidikan (NIDN, Universitas, TahunMasuk, TahunLulus) VALUES
('1234567890', 'University of A', 2000, 2004),
('1234567890', 'University of B', 2005, 2008),
('1234567891', 'University of C', 1995, 1999),
('1234567891', 'University of D', 2000, 2004),
('1234567892', 'University of E', 2003, 2007),
('1234567892', 'University of F', 2008, 2012);

-- Menambahkan pengalaman dosen dengan deskripsi yang sesuai
INSERT INTO Pengalaman (NIDN, Deskripsi) VALUES
('1234567890', 'World History'),
('1234567890', 'Philosophy'),
('1234567891', 'Prehistoric'),
('1234567891', 'Culture'),
('1234567892', 'Ancient History'),
('1234567892', 'World History');
