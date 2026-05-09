const cd=document.getElementById('cd');if(cd){setInterval(()=>{const d=new Date(cd.dataset.date)-new Date();cd.textContent=d<=0?'Hari Tari Nasional dimulai!':Math.floor(d/86400000)+' hari '+Math.floor((d%86400000)/3600000)+' jam';},1000)}
const mapData={all:'Menampilkan semua pulau dan tari perwakilan Nusantara.',sumatera:'Sumatera • Tari Saman — kekompakan gerak cepat.',jawa:'Jawa • Tari Serimpi — elegan dan filosofis.',kalimantan:'Kalimantan • Tari Hudoq — ritual adat Dayak.',sulawesi:'Sulawesi • Tari Pakarena — anggun dan sakral.',bali:'Bali • Tari Kecak — dramatik vokal cak.',papua:'Papua • Tari Yospan — semangat persaudaraan.'};
function filterRegion(k){document.querySelectorAll('.region').forEach(c=>c.style.display=(k==='all'||c.dataset.k===k)?'block':'none');pulseInfo.textContent=mapData[k]||mapData.all;}
document.querySelectorAll('.dot').forEach(b=>b.onclick=()=>filterRegion(b.dataset.k));
filterRegion('all');
const menuBtn=document.getElementById('menuBtn');menuBtn?.addEventListener('click',()=>document.querySelector('.nav nav').classList.toggle('open'));
const track=document.getElementById('tariTrack');if(track){let dir=1;setInterval(()=>{track.scrollBy({left:dir*320,behavior:'smooth'});if(track.scrollLeft+track.clientWidth>=track.scrollWidth-5)dir=-1;if(track.scrollLeft<=5)dir=1;},2500)}
