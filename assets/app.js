const cd=document.getElementById('cd');if(cd){setInterval(()=>{const d=new Date(cd.dataset.date)-new Date();cd.textContent=d<=0?'Hari Tari Nasional dimulai!':Math.floor(d/86400000)+' hari '+Math.floor((d%86400000)/3600000)+' jam';},1000)}
const menuBtn=document.getElementById('menuBtn');menuBtn?.addEventListener('click',()=>document.querySelector('.nav nav').classList.toggle('open'));
