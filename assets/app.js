const cd=document.getElementById('cd');if(cd){setInterval(()=>{const d=new Date(cd.dataset.date)-new Date();cd.textContent=d<=0?'Hari Tari Nasional dimulai!':Math.floor(d/86400000)+' hari '+Math.floor((d%86400000)/3600000)+' jam';},1000)}
const menuBtn=document.getElementById('menuBtn');menuBtn?.addEventListener('click',()=>document.getElementById('mainNav').classList.toggle('open'));

function initSlider(){
  const slidesWrap=document.getElementById('slides');
  if(!slidesWrap) return;
  let cards=[...slidesWrap.children];
  if(cards.length===0) return;

  // clone a few cards so desktop auto-scroll always has room
  const cloneCount=Math.min(3,cards.length);
  for(let i=0;i<cloneCount;i++) slidesWrap.appendChild(cards[i].cloneNode(true));
  cards=[...slidesWrap.children];

  const dots=document.getElementById('dotsNav');
  dots.innerHTML='';
  let idx=0;
  const baseCount=cards.length-cloneCount;
  for(let i=0;i<baseCount;i++){const b=document.createElement('button');b.className='dot-nav'+(i===0?' active':'');b.onclick=()=>go(i);dots.appendChild(b)}

  function cardW(){return cards[0].offsetWidth+14}
  function syncDots(){[...dots.children].forEach((d,j)=>d.classList.toggle('active',j===idx%baseCount));}
  function go(i,instant=false){idx=(i+baseCount)%baseCount;slidesWrap.scrollTo({left:idx*cardW(),behavior:instant?'auto':'smooth'});syncDots();}

  document.getElementById('nextSlide')?.addEventListener('click',()=>go(idx+1));
  document.getElementById('prevSlide')?.addEventListener('click',()=>go(idx-1));

  let auto=setInterval(()=>{idx++;slidesWrap.scrollTo({left:idx*cardW(),behavior:'smooth'});syncDots();if(idx>=baseCount){setTimeout(()=>{idx=0;go(0,true)},700)}},2600);
  slidesWrap.addEventListener('mouseenter',()=>clearInterval(auto));
  slidesWrap.addEventListener('mouseleave',()=>{auto=setInterval(()=>{idx++;slidesWrap.scrollTo({left:idx*cardW(),behavior:'smooth'});syncDots();if(idx>=baseCount){setTimeout(()=>{idx=0;go(0,true)},700)}},2600)});
}
window.addEventListener('load',initSlider);
