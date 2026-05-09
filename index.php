<?php
session_start();
$pdo = new PDO('mysql:host=127.0.0.1;dbname=sql_pesonatari_site;charset=utf8mb4','sql_pesonatari_site','dcbf4afe83baa8',[
 PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
 PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC
]);
$popular = $pdo->query('SELECT * FROM tari ORDER BY id DESC LIMIT 8')->fetchAll();
if(!$popular){$popular=[['nama_tari'=>'Tari Saman','provinsi'=>'Aceh','kategori'=>'Tradisional','gambar'=>'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?auto=format&fit=crop&w=900&q=70'],['nama_tari'=>'Tari Kecak','provinsi'=>'Bali','kategori'=>'Pertunjukan','gambar'=>'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=900&q=70'],['nama_tari'=>'Tari Yospan','provinsi'=>'Papua','kategori'=>'Modern Tradisi','gambar'=>'https://images.unsplash.com/photo-1526779259212-939e64788e3c?auto=format&fit=crop&w=900&q=70']];}
$events = $pdo->query('SELECT * FROM event ORDER BY tanggal ASC LIMIT 6')->fetchAll();
?><!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Langit Biru Nusantara</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <div class="bg-layer"></div>
  <header class="topbar">
    <div class="container nav">
      <a href="#hero" class="brand">Langit Biru Nusantara</a>
      <button id="menuBtn" class="menu-btn" aria-label="Menu">☰</button>
      <nav id="mainNav">
        <a href="#tari">Tari</a>
        <a href="#festival">Festival</a>
        <a href="#timeline">Timeline</a>
        <a href="tiket.php" class="cta-link">Order Tiket</a>
      </nav>
    </div>
  </header>

  <section id="hero" class="hero container">
    <div class="hero-left reveal">
      <p class="eyebrow">Hari Tari Nasional Indonesia</p>
      <h1>Gerakan Nusantara untuk Masa Depan Budaya Indonesia</h1>
      <p class="lead">Portal budaya digital modern dengan nuansa profesional, halus, dan dinamis.</p>
      <div class="hero-actions">
        <a class="btn btn-primary" href="#tari">Jelajahi Tari</a>
        <a class="btn" href="#festival">Lihat Festival</a>
        <a class="btn" href="tiket.php">Pesan Tiket</a>
      </div>
      <div class="countdown">Countdown: <b id="cd" data-date="2026-11-20"></b></div>
    </div>
    <div class="hero-right reveal">
      <div class="video-card">
        <iframe src="https://www.youtube.com/embed/oqQeB9cIps4?autoplay=1&mute=1&loop=1&playlist=oqQeB9cIps4&controls=1" allow="autoplay; encrypted-media"></iframe>
      </div>
    </div>
  </section>

  <section class="container stats reveal">
    <article><h3>38</h3><p>Provinsi</p></article>
    <article><h3>100+</h3><p>Tari Nusantara</p></article>
    <article><h3>50+</h3><p>Festival Budaya</p></article>
    <article><h3>5000+</h3><p>Pelestari</p></article>
  </section>

  <section id="tari" class="container section reveal">
    <div class="section-head"><h2>Tari Populer</h2><p>Auto slider modern, lembut, dan responsif.</p></div>
    <div class="slider" id="slider">
      <button id="prevSlide" class="slide-btn">‹</button>
      <div id="slides" class="slides">
        <?php foreach($popular as $t): ?>
        <article class="dance-card">
          <img src="<?=htmlspecialchars($t['gambar']?:'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?auto=format&fit=crop&w=900&q=70')?>" alt="<?=htmlspecialchars($t['nama_tari'])?>" loading="lazy">
          <div class="dance-body">
            <h4><?=htmlspecialchars($t['nama_tari'])?></h4>
            <small><?=htmlspecialchars($t['provinsi'])?> • <?=htmlspecialchars($t['kategori'])?></small>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
      <button id="nextSlide" class="slide-btn">›</button>
    </div>
    <div id="dotsNav" class="dots-nav"></div>
  </section>

  <section id="timeline" class="container section reveal">
    <div class="section-head"><h2>Timeline Perkembangan Tari</h2><p>Dari tradisi kerajaan hingga era digital budaya.</p></div>
    <div class="timeline">
      <div class="step">Era Kerajaan</div><div class="step">Era Tradisional</div><div class="step">Era Modern</div><div class="step">Era Digital Budaya</div>
    </div>
  </section>

  <section id="festival" class="container section reveal">
    <div class="section-head"><h2>Festival Budaya</h2><p>Pilih event dan lanjutkan pemesanan tiket.</p></div>
    <div class="event-grid">
      <?php foreach($events as $e): ?>
      <article class="event-card">
        <img src="<?=htmlspecialchars($e['poster'])?>" alt="<?=htmlspecialchars($e['nama_event'])?>" loading="lazy">
        <div class="event-body">
          <h4><?=htmlspecialchars($e['nama_event'])?></h4>
          <p><?=htmlspecialchars($e['lokasi'])?> • <?=htmlspecialchars($e['tanggal'])?></p>
          <a class="btn btn-primary" href="tiket.php?event_id=<?=$e['id']?>">Order Tiket</a>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </section>

  <footer class="footer">
    <div class="container footer-grid">
      <div><h4>Langit Biru Nusantara</h4><p>Portal budaya digital Indonesia modern.</p></div>
      <div><h4>Sponsor</h4><ul><li>Kementerian Kebudayaan RI</li><li>Indonesia Creative Hub</li><li>Nusantara Art Foundation</li></ul></div>
      <div><h4>Tautan</h4><a href="tiket.php">Order Tiket</a><br><a href="#hero">Kembali ke atas</a></div>
    </div>
  </footer>
  <script src="assets/app.js" defer></script>
</body>
</html>
