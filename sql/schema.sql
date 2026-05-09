CREATE DATABASE IF NOT EXISTS langit_biru_nusantara CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE langit_biru_nusantara;
CREATE TABLE tari (id INT AUTO_INCREMENT PRIMARY KEY,nama_tari VARCHAR(100),daerah VARCHAR(100),provinsi VARCHAR(100),kategori VARCHAR(50),deskripsi TEXT,sejarah TEXT,filosofi TEXT,properti_tari VARCHAR(150),pakaian_adat VARCHAR(150),alat_musik VARCHAR(150),video_url VARCHAR(255),gambar VARCHAR(255),created_at DATETIME,INDEX idx_nama (nama_tari),INDEX idx_kategori (kategori),INDEX idx_provinsi (provinsi));
CREATE TABLE event (id INT AUTO_INCREMENT PRIMARY KEY,nama_event VARCHAR(100),lokasi VARCHAR(120),tanggal DATE,harga_tiket INT,kuota INT,deskripsi TEXT,poster VARCHAR(255),INDEX idx_tanggal (tanggal));
CREATE TABLE tiket (id INT AUTO_INCREMENT PRIMARY KEY,event_id INT,nama VARCHAR(100),email VARCHAR(100),jumlah INT,total_harga INT,status VARCHAR(40),created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,FOREIGN KEY (event_id) REFERENCES event(id) ON DELETE CASCADE,INDEX idx_event(event_id));
CREATE TABLE pembayaran (id INT AUTO_INCREMENT PRIMARY KEY,tiket_id INT,metode VARCHAR(40),bukti VARCHAR(255),status VARCHAR(40),created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,FOREIGN KEY (tiket_id) REFERENCES tiket(id) ON DELETE CASCADE);
CREATE TABLE vote (id INT AUTO_INCREMENT PRIMARY KEY,tari_id INT,session_key VARCHAR(128),created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,FOREIGN KEY (tari_id) REFERENCES tari(id) ON DELETE CASCADE,INDEX idx_vote_tari(tari_id));
INSERT INTO tari (nama_tari,daerah,provinsi,kategori,deskripsi,sejarah,filosofi,properti_tari,pakaian_adat,alat_musik,video_url,gambar,created_at) VALUES
('Tari Saman','Gayo','Aceh','Tradisional','Tari kekompakan dari Aceh','Berkembang dari dakwah ulama Gayo','Persatuan dan disiplin','Alas duduk','Busana kerawang','Tepuk tangan','https://www.youtube.com/watch?v=example','assets/img/saman.webp',NOW()),
('Tari Kecak','Ubud','Bali','Pertunjukan','Pertunjukan vokal cak massal','Diadaptasi dari ritual Sanghyang','Kolaborasi manusia dan spiritual','Obor','Kain poleng','Vokal cak','https://www.youtube.com/watch?v=example2','assets/img/kecak.webp',NOW());
INSERT INTO event (nama_event,lokasi,tanggal,harga_tiket,kuota,deskripsi,poster) VALUES
('Festival Langit Biru Jakarta','Taman Ismail Marzuki','2026-11-20',150000,500,'Perayaan lintas komunitas tari Nusantara.','assets/img/event1.webp');
