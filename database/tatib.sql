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
    Username VARCHAR(50) PRIMARY KEY NOT NULL,
	Password VARCHAR(255) NOT NULL,
    Role VARCHAR(20) CHECK (Role IN ('Mahasiswa', 'Dosen', 'Admin')) NOT NULL,
	NIM CHAR(12),
	NIDN CHAR(10),
	AdminID INT,
	FOREIGN KEY (NIM) REFERENCES Mahasiswa(NIM) ON DELETE CASCADE,
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
	Admin int FOREIGN KEY REFERENCES Admin(AdminID)
);

CREATE TABLE Tugas (
    TugasID INT PRIMARY KEY IDENTITY(1,1),
    Deskripsi VARCHAR(255),
	TanggalDibuat DATE,
    TanggalSelesai DATE,
	NIDN CHAR(10),
	NIM CHAR(12),
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
	Username VARCHAR(50),
	AdminID int,
    FOREIGN KEY (Username) REFERENCES Users(Username),
	FOREIGN KEY (AdminID) REFERENCES Admin(AdminID)
);

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
('ahmadrizky', 'password123', 'Mahasiswa', '210123456789', NULL, NULL),  
('budisantoso', 'password123', 'Mahasiswa', '210123456790', NULL, NULL),
('citradewi', 'password123', 'Mahasiswa', '210123456791', NULL, NULL),  
('john_doe', 'password123', 'Dosen', NULL, '1234567890', NULL), 
('jane_smith', 'password123', 'Dosen', NULL, '1234567891', NULL), 
('mark_brown', 'password123', 'Dosen', NULL, '1234567892', NULL),  
('admina', 'adminpass', 'Admin', NULL, NULL, 1234), 
('adminb', 'adminpass', 'Admin', NULL, NULL, 6789);

INSERT INTO JenisPelanggaran (NamaPelanggaran, Tingkat) VALUES
('Pelanggaran Ringan', 'I'),
('Pelanggaran Sedang', 'II'),
('Pelanggaran Berat', 'III'),
('Pelanggaran Sangat Berat', 'IV'),
('Pelanggaran Fatal', 'V');