CREATE DATABASE perpustakaan;
USE perpustakaan;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    email VARCHAR(100),
    password VARCHAR(255),
    role ENUM('admin','user')
);

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200),
    penulis VARCHAR(150),
    kategori VARCHAR(100),
    tahun_terbit INT(4),
    stok INT
);

CREATE TABLE peminjaman (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    book_id INT,
    nama_peminjam VARCHAR(100),
    nim VARCHAR(30),
    tanggal_pinjam DATE,
    tanggal_kembali DATE,
    denda INT DEFAULT 0,
    status VARCHAR(50)
);


INSERT INTO users (nama, email, password, role)
VALUES
(
    'Admin',
    'admin12@gmail.com',
    '$admin12',
    'admin'
),
(
    'inayatul hamida',
    'inayatulhamida@gmail.com',
    '$inayatul123',
    'user'
);

INSERT INTO books (judul, penulis, kategori, tahun_terbit, stok)
VALUES
('Laskar Pelangi', 'Andrea Hirata', 'Novel', 2005, 10),
('Bumi', 'Tere Liye', 'Fantasi', 2014, 7),
('Atomic Habits', 'James Clear', 'Motivasi', 2018, 5),
('Pemrograman PHP', 'Abdul Kadir', 'Teknologi', 2020, 12),
('Algoritma dan Pemrograman', 'Rinaldi Munir', 'Pendidikan', 2019, 8),
('Negeri 5 Menara', 'Ahmad Fuadi', 'Novel', 2009, 6),
('Rich Dad Poor Dad', 'Robert Kiyosaki', 'Keuangan', 1997, 4),
('Belajar MySQL', 'Bunafit Nugroho', 'Teknologi', 2021, 9),
('Dilan 1990', 'Pidi Baiq', 'Romantis', 2014, 11),
('Dasar Dasar Java', 'Rosa A.S', 'Pemrograman', 2022, 7);

DROP DATABASE perpustakaan;
