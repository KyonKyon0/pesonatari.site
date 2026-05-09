<?php
session_start();
$pdo = new PDO('mysql:host=127.0.0.1;dbname=sql_pesonatari_site;charset=utf8mb4','sql_pesonatari_site','dcbf4afe83baa8',[
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

if (isset($_GET['ajax']) && $_GET['ajax']==='tari') {
  $q = '%' . trim($_GET['q'] ?? '') . '%';
  $st = $pdo->prepare('SELECT nama_tari,provinsi,kategori,gambar FROM tari WHERE nama_tari LIKE ? ORDER BY id DESC LIMIT 12');
  $st->execute([$q]);
  header('Content-Type: application/json');
  echo json_encode($st->fetchAll());
  exit;
}

$popular = $pdo->query('SELECT * FROM tari ORDER BY id DESC LIMIT 6')->fetchAll();
$events = $pdo->query('SELECT * FROM event ORDER BY tanggal ASC LIMIT 6')->fetchAll();
$regions = [
 ['k'=>'sumatera','n'=>'Sumatera','t'=>'Tari Saman','d'=>'Tari kolosal penuh energi dan kekompakan.','i'=>'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?auto=format&fit=crop&w=900&q=70'],
 ['k'=>'jawa','n'=>'Jawa','t'=>'Tari Serimpi','d'=>'Gerak lembut dan filosofis dari tradisi keraton.','i'=>'https://images.unsplash.com/photo-1516280440614-37939bbacd81?auto=format&fit=crop&w=900&q=70'],
 ['k'=>'kalimantan','n'=>'Kalimantan','t'=>'Tari Hudoq','d'=>'Representasi ritual Dayak yang sakral.','i'=>'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=900&q=70'],
 ['k'=>'sulawesi','n'=>'Sulawesi','t'=>'Tari Pakarena','d'=>'Anggun dan tenang dengan nilai spiritual.','i'=>'https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=900&q=70'],
 ['k'=>'bali','n'=>'Bali','t'=>'Tari Kecak','d'=>'Dramatik dengan paduan vokal cak khas Bali.','i'=>'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=900&q=70'],
 ['k'=>'papua','n'=>'Papua','t'=>'Tari Yospan','d'=>'Penuh semangat persaudaraan masyarakat pesisir.','i'=>'https://images.unsplash.com/photo-1526779259212-939e64788e3c?auto=format&fit=crop&w=900&q=70']
];
?><!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Langit Biru Nusantara</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <header class="topbar">
    <div class="wrap nav">
      <h1>Langit Biru Nusantara</h1>
      <button id="menuBtn" class="menu-btn">☰ Menu</button><nav>
        <a href="#tari">Tari</a>
        
        <a href="#event">Festival</a>
        <a href="tiket.php">Tiket</a>
      </nav>
    </div>
  </header>

  <section class="hero">
    <div class="wrap hero-grid">
      <div>
        <h2>Hari Tari Nasional Indonesia</h2>
        <p>Portal budaya nasional modern dengan tampilan corporate, elegan, dan interaktif.</p>
        <div class="actions">
          <a href="#tari" class="btn primary">Jelajahi Tari</a>
          <a href="#event" class="btn">Lihat Festival</a>
          <a href="tiket.php" class="btn">Order Tiket</a>
        </div>
        <div class="count">Countdown: <b id="cd" data-date="2026-11-20"></b></div>
      </div>
      <div class="video">
        <iframe src="https://www.youtube.com/embed/oqQeB9cIps4?autoplay=1&mute=1&loop=1&playlist=oqQeB9cIps4&controls=1" allow="autoplay; encrypted-media"></iframe>
      </div>
    </div>
  </section>

  <section class="wrap section">
    <h3>Budaya Dalam Angka</h3>
    <div class="stat-grid">
      <div class="stat"><b>38</b><div>Provinsi</div></div>
      <div class="stat"><b>100+</b><div>Tari Nusantara</div></div>
      <div class="stat"><b>50+</b><div>Festival</div></div>
      <div class="stat"><b>5000+</b><div>Pelestari</div></div>
    </div>
  </section>

  <section id="tari" class="wrap section"><h3>Tari Populer</h3><div class="slider" id="slider"><button class="slide-btn prev" id="prevSlide">‹</button><div class="slides" id="slides"><?php foreach($popular as $t): ?><article class="card slide"><img src="<?=htmlspecialchars($t['gambar'])?>" loading="lazy"><div><h4><?=htmlspecialchars($t['nama_tari'])?></h4><small><?=htmlspecialchars($t['provinsi'])?> • <?=htmlspecialchars($t['kategori'])?></small></div></article><?php endforeach; ?></div><button class="slide-btn next" id="nextSlide">›</button></div><div class="dots-nav" id="dotsNav"></div></section>

  

  <section class="wrap section">
    <h3>Perwakilan Tari Tiap Pulau</h3>
    <div class="cards">
      <?php foreach($regions as $r): ?>
        <article class="card region" data-k="<?=$r['k']?>" id="<?=$r['k']?>">
          <img src="<?=$r['i']?>" loading="lazy">
          <div>
            <h4><?=$r['n']?> — <?=$r['t']?></h4>
            <p><?=$r['d']?></p>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="wrap section">
    <h3>Timeline Perkembangan Tari</h3>
    <div class="timeline">
      <div class="step">Era Kerajaan</div>
      <div class="step">Era Tradisional</div>
      <div class="step">Era Modern</div>
      <div class="step">Era Digital Budaya</div>
    </div>
  </section>

  <section id="event" class="wrap section">
    <h3>Event Festival</h3>
    <div class="cards">
      <?php foreach($events as $e): ?>
        <article class="card">
          <img src="<?=htmlspecialchars($e['poster'])?>" loading="lazy">
          <div>
            <h4><?=htmlspecialchars($e['nama_event'])?></h4>
            <p><?=htmlspecialchars($e['lokasi'])?> | <?=htmlspecialchars($e['tanggal'])?></p>
            <a class="btn primary" href="tiket.php?event_id=<?=$e['id']?>">Pesan Tiket</a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </section>

  <footer class="footer">
    <div class="wrap">
      <h4>Sponsor Festival</h4>
      <div class="sponsors">
        <span>Kementerian Kebudayaan RI</span>
        <span>Indonesia Creative Hub</span>
        <span>Nusantara Art Foundation</span>
      </div>
      <p>GitHub: <a href="https://github.com/yourusername" target="_blank">https://github.com/yourusername</a></p>
    </div>
  </footer>

  <script src="assets/app.js" defer></script>
</body>
</html>
