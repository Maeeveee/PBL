use tatib;

CREATE TABLE Users (
    Username VARCHAR(50) PRIMARY KEY NOT NULL,
	Password VARCHAR(255) NOT NULL,
    Role VARCHAR(20) CHECK (Role IN ('Mahasiswa', 'Dosen', 'Admin')) NOT NULL
);

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
    Poin INT DEFAULT 0,
    Username VARCHAR(50) FOREIGN KEY REFERENCES Users(Username),
	ProdiID INT FOREIGN KEY REFERENCES ProgramStudi(ProdiID)
);

CREATE TABLE Dosen (
    NIDN CHAR(10) PRIMARY KEY,
    Nama VARCHAR(100) NOT NULL,
    Email VARCHAR(100),
    NoTelepon VARCHAR(15),
    Username VARCHAR(50) FOREIGN KEY REFERENCES Users(Username)
);

CREATE TABLE Admin (
    AdminID INT PRIMARY KEY IDENTITY(1,1),
    NamaAdmin VARCHAR(100) NOT NULL,
    EmailAdmin VARCHAR(100) UNIQUE NOT NULL,
    NoTelepon VARCHAR(15),
    UserID VARCHAR(50) FOREIGN KEY REFERENCES Users(Username)
);

CREATE TABLE JenisPelanggaran (
    JenisID INT PRIMARY KEY IDENTITY(1,1),
    NamaPelanggaran VARCHAR(100),
    Tingkat CHAR(2)
);

CREATE TABLE Pelanggaran (
    PelanggaranID INT PRIMARY KEY IDENTITY(1,1),
    NIM CHAR(12) FOREIGN KEY REFERENCES Mahasiswa(NIM),
    NIDN CHAR(10) FOREIGN KEY REFERENCES Dosen(NIDN),
    JenisID INT FOREIGN KEY REFERENCES JenisPelanggaran(JenisID),
    TanggalPelanggaran DATE NOT NULL,
    BuktiFoto VARCHAR(255)
);

CREATE TABLE Tugas (
    TugasID INT PRIMARY KEY IDENTITY(1,1),
    PelanggaranID INT UNIQUE FOREIGN KEY REFERENCES Pelanggaran(PelanggaranID),
    Deskripsi VARCHAR(255),
	TanggalDibuat DATE,
    TanggalSelesai DATE
);

CREATE TABLE DetailPelanggaran (
	NIM CHAR(12) FOREIGN KEY REFERENCES Mahasiswa(NIM),
	PelanggaranID INT FOREIGN KEY REFERENCES Pelanggaran(PelanggaranID),
	Poin INT,
	Tgl Date
);

INSERT INTO ProgramStudi (ProdiID, Prodi)
VALUES
(1, 'D-IV Teknik Informatika'),
(2, 'D-IV Sistem Informasi Bisnis'),
(3, 'D-II Fast Track');

INSERT INTO Users (Username, Password, Role)
VALUES
('mahasiswa1', 'password123', 'Mahasiswa'),
('mahasiswa2', 'password123', 'Mahasiswa'),
('mahasiswa3', 'password123', 'Mahasiswa'),
('dosen1', 'password123', 'Dosen'),
('dosen2', 'password123', 'Dosen'),
('dosen3', 'password123', 'Dosen'),
('admin1', 'password123', 'Admin'),
('admin2', 'password123', 'Admin'),
('admin3', 'password123', 'Admin');

INSERT INTO Mahasiswa (NIM, Nama, Email, NoTelepon, Alamat, TanggalLahir, Poin, Username, ProdiID)
VALUES
('202400000001', 'Mahasiswa Satu', 'mahasiswa1@email.com', '081234567890', 'Malang', '2000-01-01', 0, 'mahasiswa1', 1),
('202400000002', 'Mahasiswa Dua', 'mahasiswa2@email.com', '081234567891', 'Suarabaya', '2000-02-01', 0, 'mahasiswa2', 2),
('202400000003', 'Mahasiswa Tiga', 'mahasiswa3@email.com', '081234567892', 'Blitar', '2000-03-01', 0, 'mahasiswa3', 3);

INSERT INTO Dosen (NIDN, Nama, Email, NoTelepon, Username)
VALUES
('1000000001', 'Dosen Satu', 'dosen1@email.com', '081234567893', 'dosen1'),
('1000000002', 'Dosen Dua', 'dosen2@email.com', '081234567894', 'dosen2'),
('1000000003', 'Dosen Tiga', 'dosen3@email.com', '081234567895', 'dosen3');

INSERT INTO Admin (NamaAdmin, EmailAdmin, NoTelepon, UserID)
VALUES
('Admin Satu', 'admin1@email.com', '081234567896', 'admin1'),
('Admin Dua', 'admin2@email.com', '081234567897', 'admin2'),
('Admin Tiga', 'admin3@email.com', '081234567898', 'admin3');

INSERT INTO JenisPelanggaran (NamaPelanggaran, Tingkat)
VALUES
('Tidak membawa kartu mahasiswa', 'L1'),
('Terlambat masuk kelas', 'L1'),
('Melanggar kode etik mahasiswa', 'L2');

INSERT INTO Pelanggaran (NIM, NIDN, JenisID, TanggalPelanggaran, BuktiFoto)
VALUES
('202400000001', '1000000001', 1, '2024-12-01', 'foto1.jpg'),
('202400000002', '1000000002', 2, '2024-12-02', 'foto2.jpg'),
('202400000003', '1000000003', 3, '2024-12-03', 'foto3.jpg');

INSERT INTO Tugas (PelanggaranID, Deskripsi, TanggalDibuat, TanggalSelesai)
VALUES
(1, 'Menulis surat permohonan maaf kepada dosen', '2024-12-01', '2024-12-05'),
(2, 'Membuat presentasi tentang etika mahasiswa', '2024-12-02', '2024-12-06'),
(3, 'Menyelesaikan tugas tambahan dari dosen', '2024-12-03', '2024-12-07');

INSERT INTO DetailPelanggaran (NIM, PelanggaranID, Poin, Tgl)
VALUES
('202400000001', 1, 5, '2024-12-01'),
('202400000002', 2, 10, '2024-12-02'),
('202400000003', 3, 15, '2024-12-03');

ALTER TABLE Pelanggaran
ADD Surat VARCHAR(255);

CREATE TABLE Notifikasi (
    NotifikasiID INT PRIMARY KEY,
    Judul NVARCHAR(100),
    Isi NVARCHAR(MAX),
    Username VARCHAR(50) FOREIGN KEY REFERENCES Users(Username)
);

ALTER TABLE Pelanggaran
ADD Status VARCHAR(20) DEFAULT 'Pending';

ALTER TABLE Pelanggaran
ADD AdminID INT;

ALTER TABLE Pelanggaran
ADD CONSTRAINT FK_Pelanggaran_Admin
FOREIGN KEY (AdminID) REFERENCES Admin(AdminID);
