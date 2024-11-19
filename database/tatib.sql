create database tatib;

use tatib;

CREATE TABLE Admin (
    AdminID INT IDENTITY PRIMARY KEY,
    Nama VARCHAR(100),
    PasswordAdmin VARCHAR(255)
);

-- Tabel Dosen
CREATE TABLE Dosen (
    DosenID INT IDENTITY PRIMARY KEY,
    Nama VARCHAR(100),
	NIP VARCHAR(20) NOT NULL,
	JenisKelamin VARCHAR(10) NOT NULL,
    PasswordDosen VARCHAR(255)
);

-- Tabel Mahasiswa
CREATE TABLE Mahasiswa (
    MahasiswaID INT IDENTITY PRIMARY KEY,
    Nama VARCHAR(100),
    NIM VARCHAR(20) UNIQUE,
	JenisKelamin VARCHAR(10) NOT NULL,
    PasswordMahasiswa VARCHAR(255),
	Alamat TEXT NOT NULL,
    PoinPelanggaran INT DEFAULT 0,
	EmailOrangTua VARCHAR(100) NOT NULL
);

-- Tabel Notifikasi
CREATE TABLE Notifikasi (
    NotifikasiID INT IDENTITY PRIMARY KEY,
    Pesan VARCHAR(255),
    Tanggal DATETIME DEFAULT GETDATE(),
    PenerimaID INT,
    PenerimaRole VARCHAR(10) CHECK (PenerimaRole IN ('Admin', 'Dosen', 'Mahasiswa'))
);

-- Tabel Pelanggaran
CREATE TABLE Pelanggaran (
    PelanggaranID INT IDENTITY PRIMARY KEY,
    NamaPelanggaran VARCHAR(100),
    Poin INT
);

-- Tabel Pengguna (Autentikasi user)
CREATE TABLE Pengguna (
    PenggunaID INT IDENTITY PRIMARY KEY,
    Role VARCHAR(10) CHECK (Role IN ('Admin', 'Dosen', 'Mahasiswa')),
    RoleID INT,
    FOREIGN KEY (RoleID) REFERENCES Admin(AdminID)
    ON DELETE CASCADE,
    FOREIGN KEY (RoleID) REFERENCES Dosen(DosenID)
    ON DELETE CASCADE,
    FOREIGN KEY (RoleID) REFERENCES Mahasiswa(MahasiswaID)
    ON DELETE CASCADE
);

-- Tabel Surat Pernyataan
CREATE TABLE Surat_Pernyataan (
    SuratID INT IDENTITY PRIMARY KEY,
    MahasiswaID INT,
    Tanggal DATETIME DEFAULT GETDATE(),
    FOREIGN KEY (MahasiswaID) REFERENCES Mahasiswa(MahasiswaID)
    ON DELETE CASCADE
);

-- Tabel Upload Pelanggaran
CREATE TABLE Upload_Pelanggaran (
    UploadID INT IDENTITY PRIMARY KEY,
    DosenID INT,
    MahasiswaID INT,
    PelanggaranID INT,
    FotoPath VARCHAR(255),
    Tanggal DATETIME DEFAULT GETDATE(),
    FOREIGN KEY (DosenID) REFERENCES Dosen(DosenID)
    ON DELETE CASCADE,
    FOREIGN KEY (MahasiswaID) REFERENCES Mahasiswa(MahasiswaID)
    ON DELETE CASCADE,
    FOREIGN KEY (PelanggaranID) REFERENCES Pelanggaran(PelanggaranID)
    ON DELETE CASCADE
);

-- Tabel Tugas
CREATE TABLE Tugas (
    TugasID INT IDENTITY PRIMARY KEY,
    UploadID INT,
    Deskripsi VARCHAR(255),
    Status VARCHAR(20) DEFAULT 'Pending',
    FOREIGN KEY (UploadID) REFERENCES Upload_Pelanggaran(UploadID)
    ON DELETE CASCADE
);

INSERT INTO Admin (Nama, PasswordAdmin)
VALUES 
('Admin Satu', 'passwordadmin1'),
('Admin Dua', 'passwordadmin2'),
('Admin Tiga', 'passwordadmin3');

INSERT INTO Dosen (Nama, NIP, JenisKelamin, PasswordDosen)
VALUES 
('Dosen A', '198512345678901', 'Laki-laki', 'passworddosen1'),
('Dosen B', '198612345678902', 'Perempuan', 'passworddosen2'),
('Dosen C', '198712345678903', 'Laki-laki', 'passworddosen3');

INSERT INTO Mahasiswa (Nama, NIM, JenisKelamin, PasswordMahasiswa, Alamat, EmailOrangTua)
VALUES 
('Mahasiswa X', '123456789', 'Laki-laki', 'passwordmahasiswa1', 'Malang', 'ortu_x@gmail.com'),
('Mahasiswa Y', '987654321', 'Perempuan', 'passwordmahasiswa2', 'Blitar', 'ortu_y@gmail.com'),
('Mahasiswa Z', '192837465', 'Laki-laki', 'passwordmahasiswa3', 'Kediri', 'ortu_z@gmail.com');

INSERT INTO Notifikasi (Pesan, PenerimaID, PenerimaRole)
VALUES 
('Selamat datang, Admin Satu!', 1, 'Admin'),
('Ada laporan pelanggaran baru', 1, 'Dosen'),
('Pelanggaran Anda telah diperbarui', 1, 'Mahasiswa');

INSERT INTO Pelanggaran (NamaPelanggaran, Poin)
VALUES 
('Terlambat Masuk', 5),
('Tidak Memakai Seragam', 10),
('Tidak Membawa Kartu Identitas', 15);

INSERT INTO Pengguna (Role, RoleID)
VALUES 
('Admin', 1),
('Dosen', 1),
('Mahasiswa', 1);

INSERT INTO Surat_Pernyataan (MahasiswaID)
VALUES 
(1),
(2),
(3);

INSERT INTO Upload_Pelanggaran (DosenID, MahasiswaID, PelanggaranID, FotoPath)
VALUES 
(1, 1, 1, 'foto1.jpg'),
(2, 2, 2, 'foto2.jpg'),
(3, 3, 3, 'foto3.jpg');

INSERT INTO Tugas (UploadID, Deskripsi, Status)
VALUES 
(1, 'Mahasiswa harus membuat surat pernyataan.', 'Pending'),
(2, 'Mahasiswa harus memperbaiki atribut seragam.', 'Completed'),
(3, 'Mahasiswa harus membawa kartu identitas ke depan ruang tata usaha.', 'Pending');
