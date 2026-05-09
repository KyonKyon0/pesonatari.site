<?php
session_start();
$pdo=new PDO('mysql:host=127.0.0.1;dbname=sql_pesonatari_site;charset=utf8mb4','sql_pesonatari_site','dcbf4afe83baa8',[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);
if(empty($_SESSION['csrf']))$_SESSION['csrf']=bin2hex(random_bytes(32));
if($_SERVER['REQUEST_METHOD']==='POST' && hash_equals($_SESSION['csrf'],$_POST['csrf']??'')){
  $tot=(int)$_POST['jumlah']*(int)$_POST['harga'];
  $pdo->prepare('INSERT INTO tiket(event_id,nama,email,jumlah,total_harga,status) VALUES(?,?,?,?,?,?)')->execute([(int)$_POST['event_id'],$_POST['nama'],$_POST['email'],(int)$_POST['jumlah'],$tot,'pending']);
  $id=$pdo->lastInsertId();
  header('Location:tiket.php?ok=1&id='.$id);exit;
}
$events=$pdo->query('SELECT * FROM event ORDER BY tanggal ASC')->fetchAll();
?><!doctype html><html><head><meta charset='utf-8'><meta name='viewport' content='width=device-width,initial-scale=1'><title>Order Tiket</title><style>body{font-family:Inter,Arial;background:#071a33;color:#fff;margin:0}.wrap{width:min(900px,92%);margin:30px auto}.card{background:#ffffff12;border:1px solid #78e7ff55;border-radius:14px;padding:16px;margin-bottom:14px}input{width:100%;padding:10px;border-radius:9px;border:1px solid #7fe9ff55;background:#0e2f50;color:#fff}button{background:#38ddff;border:none;padding:10px 14px;border-radius:10px;color:#003a54;font-weight:700}</style></head><body><div class='wrap'><h1>Order Tiket Festival</h1><?php if(isset($_GET['ok'])): ?><div class='card'>Pesanan berhasil dibuat. ID Tiket #<?=intval($_GET['id'])?>.</div><?php endif; ?><?php foreach($events as $e):?><div class='card'><h3><?=$e['nama_event']?></h3><p><?=$e['lokasi']?> | <?=$e['tanggal']?> | Rp<?=number_format($e['harga_tiket'])?></p><form method='post'><input type='hidden' name='csrf' value='<?=$_SESSION['csrf']?>'><input type='hidden' name='event_id' value='<?=$e['id']?>'><input type='hidden' name='harga' value='<?=$e['harga_tiket']?>'><input name='nama' required placeholder='Nama'><br><br><input name='email' required placeholder='Email'><br><br><input type='number' name='jumlah' value='1' min='1'><br><br><button>Pesan Tiket</button></form></div><?php endforeach;?><a href='index.php' style='color:#8defff'>← Kembali ke Homepage</a></div></body></html>
