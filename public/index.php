<?php
require_once __DIR__ . '/../app/config/database.php';
require_once __DIR__ . '/../app/helpers/common.php';
$route = $_GET['r'] ?? 'home';
csrf_check();

function view($file, $data=[]){ extract($data); require __DIR__ . '/../app/views/' . $file . '.php'; }

if ($route === 'home') {
    $popular = db()->query("SELECT * FROM tari ORDER BY id DESC LIMIT 6")->fetchAll();
    $events = db()->query("SELECT * FROM event ORDER BY tanggal ASC LIMIT 6")->fetchAll();
    $topVote = db()->query("SELECT t.*, COUNT(v.id) vote_count FROM tari t LEFT JOIN vote v ON v.tari_id=t.id GROUP BY t.id ORDER BY vote_count DESC LIMIT 5")->fetchAll();
    view('user/home', compact('popular','events','topVote'));
    exit;
}
if ($route === 'tari') {
    $q = trim($_GET['q'] ?? ''); $kategori=trim($_GET['kategori'] ?? '');
    $page=(int)($_GET['page']??1); [$offset,$limit]=paginate($page,8);
    $sql="SELECT * FROM tari WHERE 1=1"; $params=[];
    if($q!==''){ $sql.=" AND nama_tari LIKE ?"; $params[]="%$q%"; }
    if($kategori!==''){ $sql.=" AND kategori=?"; $params[]=$kategori; }
    $sql.=" ORDER BY id DESC LIMIT $offset,$limit";
    $stmt=db()->prepare($sql); $stmt->execute($params); $rows=$stmt->fetchAll();
    if(isset($_GET['ajax'])){ header('Content-Type: application/json'); echo json_encode($rows); exit; }
    view('user/tari', ['rows'=>$rows]); exit;
}
if ($route === 'vote' && $_SERVER['REQUEST_METHOD']==='POST') {
    $stmt=db()->prepare('INSERT INTO vote (tari_id,session_key) VALUES (?,?)');
    $stmt->execute([(int)$_POST['tari_id'], session_id()]);
    redirect('?r=home#top-vote');
}
if ($route === 'event') { $rows=db()->query('SELECT * FROM event ORDER BY tanggal ASC')->fetchAll(); view('user/event',['rows'=>$rows]); exit; }
if ($route === 'checkout' && $_SERVER['REQUEST_METHOD']==='POST') {
    $stmt=db()->prepare('INSERT INTO tiket (event_id,nama,email,jumlah,total_harga,status) VALUES (?,?,?,?,?,?)');
    $total=(int)$_POST['jumlah']*(int)$_POST['harga_tiket'];
    $stmt->execute([(int)$_POST['event_id'],$_POST['nama'],$_POST['email'],(int)$_POST['jumlah'],$total,'pending']);
    $id=(int)db()->lastInsertId(); redirect('?r=payment&id='.$id);
}
if ($route === 'payment') {
    $id=(int)($_GET['id']??0);
    if($_SERVER['REQUEST_METHOD']==='POST'){
        $bukti=upload_image('bukti','bukti');
        $stmt=db()->prepare('INSERT INTO pembayaran (tiket_id,metode,bukti,status) VALUES (?,?,?,?)');
        $stmt->execute([$id,$_POST['metode'],$bukti,'menunggu']);
        db()->prepare("UPDATE tiket SET status='menunggu verifikasi' WHERE id=?")->execute([$id]);
        redirect('?r=payment&id='.$id.'&ok=1');
    }
    $stmt=db()->prepare('SELECT t.*,e.nama_event FROM tiket t JOIN event e ON e.id=t.event_id WHERE t.id=?');
    $stmt->execute([$id]); $trx=$stmt->fetch(); view('user/payment',['trx'=>$trx]); exit;
}
if ($route === 'admin') { $t=(int)db()->query('SELECT COUNT(*) c FROM tari')->fetch()['c']; $e=(int)db()->query('SELECT COUNT(*) c FROM event')->fetch()['c']; $k=(int)db()->query('SELECT COUNT(*) c FROM tiket')->fetch()['c']; view('admin/dashboard',compact('t','e','k')); exit; }
if ($route === 'admin_tari') { 
    if($_SERVER['REQUEST_METHOD']==='POST'){
        $gambar=upload_image('gambar','tari');
        $stmt=db()->prepare('INSERT INTO tari (nama_tari,daerah,provinsi,kategori,deskripsi,sejarah,filosofi,properti_tari,pakaian_adat,alat_musik,video_url,gambar,created_at) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,NOW())');
        $stmt->execute([$_POST['nama_tari'],$_POST['daerah'],$_POST['provinsi'],$_POST['kategori'],$_POST['deskripsi'],$_POST['sejarah'],$_POST['filosofi'],$_POST['properti_tari'],$_POST['pakaian_adat'],$_POST['alat_musik'],$_POST['video_url'],$gambar]);
        redirect('?r=admin_tari');
    }
    $rows=db()->query('SELECT * FROM tari ORDER BY id DESC')->fetchAll(); view('admin/tari',['rows'=>$rows]); exit;
}
if ($route === 'delete_tari') { db()->prepare('DELETE FROM tari WHERE id=?')->execute([(int)$_GET['id']]); redirect('?r=admin_tari'); }
if ($route === 'admin_event') {
    if($_SERVER['REQUEST_METHOD']==='POST'){
        $poster=upload_image('poster','event');
        db()->prepare('INSERT INTO event (nama_event,lokasi,tanggal,harga_tiket,kuota,deskripsi,poster) VALUES (?,?,?,?,?,?,?)')->execute([$_POST['nama_event'],$_POST['lokasi'],$_POST['tanggal'],(int)$_POST['harga_tiket'],(int)$_POST['kuota'],$_POST['deskripsi'],$poster]);
        redirect('?r=admin_event');
    }
    $rows=db()->query('SELECT * FROM event ORDER BY tanggal DESC')->fetchAll(); view('admin/event',['rows'=>$rows]); exit;
}
http_response_code(404); echo '404';
