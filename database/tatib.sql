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

ALTER TABLE Mahasiswa
ADD TugasID INT NULL,
    FOREIGN KEY (TugasID) REFERENCES Tugas(TugasID);

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
