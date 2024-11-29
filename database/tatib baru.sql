create database tatib;

use tatib;

CREATE TABLE Users (
    UserID INT PRIMARY KEY IDENTITY(1,1),
    Username VARCHAR(50) UNIQUE NOT NULL,
    Password VARCHAR(255) NOT NULL,
    Role VARCHAR(20) CHECK (Role IN ('Mahasiswa', 'Dosen', 'Admin')) NOT NULL,
    Email VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE Mahasiswa (
    NIM CHAR(10) PRIMARY KEY,
    Nama VARCHAR(100) NOT NULL,
    ProgramStudi VARCHAR(100),
    Email VARCHAR(100),
    NoTelepon VARCHAR(15),
    Alamat VARCHAR(255),
    TanggalLahir DATE,
    Poin INT DEFAULT 0,
    UserID INT UNIQUE FOREIGN KEY REFERENCES Users(UserID)
);

CREATE TABLE Dosen (
    NIP CHAR(18) PRIMARY KEY,
    Nama VARCHAR(100) NOT NULL,
    Email VARCHAR(100),
    NoTelepon VARCHAR(15),
    Fakultas VARCHAR(100),
    UserID INT UNIQUE FOREIGN KEY REFERENCES Users(UserID)
);

CREATE TABLE Admin (
    AdminID INT PRIMARY KEY IDENTITY(1,1),
    NamaAdmin VARCHAR(100) NOT NULL,
    EmailAdmin VARCHAR(100) UNIQUE NOT NULL,
    NoTelepon VARCHAR(15),
    UserID INT UNIQUE FOREIGN KEY REFERENCES Users(UserID)
);


CREATE TABLE JenisPelanggaran (
    JenisID INT PRIMARY KEY IDENTITY(1,1),
    NamaPelanggaran VARCHAR(100),
    Poin INT
);

CREATE TABLE Pelanggaran (
    PelanggaranID INT PRIMARY KEY IDENTITY(1,1),
    NIM CHAR(10) FOREIGN KEY REFERENCES Mahasiswa(NIM),
    NIP CHAR(18) FOREIGN KEY REFERENCES Dosen(NIP),
    JenisID INT FOREIGN KEY REFERENCES JenisPelanggaran(JenisID),
    TanggalPelanggaran DATE NOT NULL,
    BuktiFoto VARCHAR(255),
    StatusVerifikasi BIT DEFAULT 0
);

CREATE TABLE Tugas (
    TugasID INT PRIMARY KEY IDENTITY(1,1),
    PelanggaranID INT UNIQUE FOREIGN KEY REFERENCES Pelanggaran(PelanggaranID),
    Deskripsi VARCHAR(MAX),
    StatusTugas BIT DEFAULT 0, -- 0: Belum selesai, 1: Selesai
    TanggalSelesai DATE
);

CREATE TABLE RiwayatPoin (
    RiwayatID INT PRIMARY KEY IDENTITY(1,1),
    NIM CHAR(10) FOREIGN KEY REFERENCES Mahasiswa(NIM),
    Poin INT,
    Tanggal DATE,
    Keterangan VARCHAR(255)
);

CREATE TABLE Session (
    SessionID UNIQUEIDENTIFIER PRIMARY KEY DEFAULT NEWID(),
    UserID INT FOREIGN KEY REFERENCES Users(UserID),
    CreatedAt DATETIME DEFAULT GETDATE(),
    ExpiresAt DATETIME
);
