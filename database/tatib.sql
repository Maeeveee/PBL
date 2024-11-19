create database tatib;

use tatib;

CREATE TABLE Admin (
    AdminID INT IDENTITY PRIMARY KEY,
    Nama VARCHAR(100),
    PasswordHash VARCHAR(255)
);

-- Tabel Dosen
CREATE TABLE Dosen (
    DosenID INT IDENTITY PRIMARY KEY,
    Nama VARCHAR(100),
    PasswordHash VARCHAR(255)
);

-- Tabel Mahasiswa
CREATE TABLE Mahasiswa (
    MahasiswaID INT IDENTITY PRIMARY KEY,
    Nama VARCHAR(100),
    NIM VARCHAR(20) UNIQUE,
    PasswordHash VARCHAR(255),
    PoinPelanggaran INT DEFAULT 0
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