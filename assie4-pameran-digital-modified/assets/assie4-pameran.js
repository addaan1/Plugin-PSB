/* ═══════════════════════════════════════════════════════
   ASSIE IV 2026 — Pameran Digital · WordPress JS v2.6
   ═══════════════════════════════════════════════════════ */
(function () {
  'use strict';

  /* ══════════════════════════════════════════════════════
     DATA MASTER — default, akan di-override dari ASSIE4_DB
     ═══════════════════════════════════════════════════════ */
  var DATA = {
    info:    { date:'14–16 Mei 2026', location:'Grand City Convention Hall, Surabaya', org:'PASINBIS Universitas Airlangga', timeOpen:'08:00', timeClose:'20:00' },
    slides:  [
      { title:'ASSIE IV 2026', subtitle:'Airlangga Startup Summit & Innovation Expo', desc:'Ajang pameran startup & inovasi terbesar di Jawa Timur. 3 hari penuh inovasi.', cta:'Jelajahi Pameran', link:'#denah', bg:'linear-gradient(135deg,#03050e 0%,#0c1a40 100%)' },
      { title:'Inovasi Tanpa Batas', subtitle:'Grand City Convention Hall · Surabaya', desc:'Temui inovator muda dan ekosistem startup Jawa Timur.', cta:'Lihat Denah Booth', link:'#denah', bg:'linear-gradient(135deg,#03050e 0%,#0d200e 100%)' },
      { title:'Dukung Startup Lokal', subtitle:'TokoUA · tokoua.unair.ac.id', desc:'Beli produk tenant pameran secara online melalui TokoUA.', cta:'Kunjungi TokoUA', link:'https://tokoua.unair.ac.id/', bg:'linear-gradient(135deg,#03050e 0%,#1a0a00 100%)' },
    ],
    ticker:  ['Selamat datang di ASSIE IV 2026','14–16 Mei 2026 · Grand City Convention Hall Surabaya','Booth startup & inovasi','Belanja produk tenant online di tokoua.unair.ac.id','Presensi digital tersedia di setiap booth','PASINBIS Universitas Airlangga'],
    rundown: {
      days:   [{ label:"Jum'at, 14 Nov" },{ label:'Sabtu, 15 Nov' },{ label:'Minggu, 16 Nov' }],
      events: [
        { day:0,time:'13.00',end:'15.30',name:'Airlangga Business Matching 2025',  type:'keynote',    loc:'Ruang Business Matching' },
        { day:0,time:'15.30',end:'17.00',name:'Opening Ceremony + Launching Produk',type:'keynote',   loc:'Main Stage' },
        { day:0,time:'17.00',end:'17.30',name:'Break',                              type:'break',     loc:'—' },
        { day:0,time:'17.30',end:'19.30',name:'Roblox Competition',                 type:'workshop',  loc:'Hall' },
        { day:0,time:'19.45',end:'20.45',name:'Acoustic Band Performance',          type:'networking',loc:'Main Stage' },
        { day:0,time:'21.00',end:'21.30',name:'Closing Day 1',                      type:'award',     loc:'Main Stage' },
        { day:1,time:'10.00',end:'10.30',name:'Opening',                            type:'keynote',   loc:'Main Stage' },
        { day:1,time:'10.30',end:'13.40',name:'Workshop Beregu Startup ATAVI',      type:'workshop',  loc:'Hall' },
        { day:1,time:'13.50',end:'18.00',name:'Mozilla Legend E-Sport Competition', type:'workshop',  loc:'Hall' },
        { day:1,time:'19.40',end:'20.40',name:'Acoustic Band Perform',              type:'networking',loc:'Main Stage' },
        { day:1,time:'20.40',end:'21.10',name:'Closing Day 2',                      type:'award',     loc:'Main Stage' },
        { day:2,time:'10.00',end:'10.05',name:'Opening',                            type:'keynote',   loc:'Main Stage' },
        { day:2,time:'10.05',end:'12.35',name:'ASSIE El Got Talent',                type:'networking',loc:'Main Stage' },
        { day:2,time:'13.05',end:'15.05',name:'Talkshow Science Behind Glowing Skin',type:'panel',    loc:'Main Stage' },
        { day:2,time:'15.35',end:'16.35',name:'El Got Talent',                      type:'networking',loc:'Main Stage' },
        { day:2,time:'16.35',end:'18.55',name:'Acoustic Band Perform',              type:'networking',loc:'Main Stage' },
        { day:2,time:'18.55',end:'20.00',name:'Closing Ceremony',                   type:'award',     loc:'Main Stage' },
      ]
    },
    denah:   [],
    tenants: [],
  };

  /* ══════════════════════════════════════════════════════
     MERGE dari ASSIE4_DB (injected via wp_add_inline_script)
     ═══════════════════════════════════════════════════════ */
  (function() {
    var db = window.ASSIE4_DB;
    if (!db) { return; }
    function normTenant(t) {
      return { id:t.id||'', area:t.area||'A', name:t.name||'', cat:t.cat||'', desc:t.desc||'',
        tags:Array.isArray(t.tags)?t.tags:(t.tags||'').split(',').map(function(s){return s.trim();}).filter(Boolean),
        logo:t.logo||'', contact:t.contact||'', web:t.web||'', instagram:t.instagram||'', facebook:t.facebook||'', twitter:t.twitter||'' };
    }
    if (db.info    && typeof db.info==='object')              DATA.info    = db.info;
    if (db.slides  && db.slides.length)                       DATA.slides  = db.slides;
    if (db.ticker  && db.ticker.length)                       DATA.ticker  = db.ticker;
    if (db.rundown && db.rundown.events && db.rundown.events.length) DATA.rundown = db.rundown;
    if (db.denah   && Array.isArray(db.denah))                DATA.denah   = db.denah;
    if (db.tenants && Array.isArray(db.tenants) && db.tenants.length > 0) {
      DATA.tenants = db.tenants.map(normTenant);
    }
  })();

  /* ── HELPERS ── */
  function escH(s){return String(s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');}

  /* ══════════════════════════════════════════════════════
     CLOCK
     ═══════════════════════════════════════════════════════ */
  setInterval(function(){var el=document.getElementById('a4Clock');if(el)el.textContent=new Date().toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit',second:'2-digit'});},1000);

  /* ══════════════════════════════════════════════════════
     NAV
     ═══════════════════════════════════════════════════════ */
  var navBtns = document.querySelectorAll('.a4-nb');
  window.a4GoTo = function(id){
    var el=document.getElementById(id);
    if(el) el.scrollIntoView({behavior:'smooth'});
    navBtns.forEach(function(b){b.classList.remove('on');});
    var a=document.querySelector('.a4-nb[onclick*="\''+id+'\'"]');
    if(a) a.classList.add('on');
  };

  /* ══════════════════════════════════════════════════════
     INFO STRIP
     ═══════════════════════════════════════════════════════ */
  function renderInfo(){
    var I=DATA.info;
    function s(id,v){var el=document.getElementById(id);if(el)el.textContent=v;}
    s('a4iDate',I.date||'—'); s('a4iLoc',I.location||'—'); s('a4iOrg',I.org||'—');
    s('a4iTime',(I.timeOpen||'08:00')+' – '+(I.timeClose||'20:00'));
  }

  /* ══════════════════════════════════════════════════════
     HERO SLIDER — support image URL background
     ═══════════════════════════════════════════════════════ */
  var curSl=0, slTimer;
  function renderSlider(){
    var wrap=document.getElementById('a4SlWrap'), dots=document.getElementById('a4SlDots');
    if(!wrap||!dots) return;
    wrap.innerHTML=''; dots.innerHTML='';
    DATA.slides.forEach(function(s,i){
      var div=document.createElement('div');
      div.className='a4-sl'+(i===0?' on':'');
      var bg    = s.bg||'#03050e';
      var isImg = /^https?:\/\//i.test(bg.trim());
      // Untuk URL gambar: gunakan langsung tanpa escH agar URL tidak rusak
      var bgCss = isImg
        ? 'background-image:url(' + bg.replace(/[()]/g,'') + ');background-size:cover;background-position:center center;background-repeat:no-repeat'
        : 'background:' + bg;
      var bgCls = isImg ? 'a4-sl-bg a4-sl-bg-img' : 'a4-sl-bg';
      div.innerHTML =
        '<div class="'+bgCls+'" style="'+bgCss+'"></div>'+
        '<div class="a4-sl-overlay"></div>'+
        '<div class="a4-sl-content">'+
          '<div class="a4-sl-eyebrow">'+escH(s.subtitle||'ASSIE IV 2026')+'</div>'+
          '<h1 class="a4-sl-h1">'+escH(s.title||'')+'</h1>'+
          '<p class="a4-sl-p">'+escH(s.desc||'')+'</p>'+
          '<a href="'+escH(s.link||'#denah')+'" class="a4-sl-cta">'+escH(s.cta||'Selengkapnya')+' &#8594;</a>'+
        '</div>';
      wrap.appendChild(div);
      var dot=document.createElement('button');
      dot.className='a4-dot'+(i===0?' on':'');
      dot.setAttribute('aria-label','Slide '+(i+1));
      dot.onclick=(function(idx){return function(){goSlide(idx);};})(i);
      dots.appendChild(dot);
    });
    startSliderTimer();
  }
  function goSlide(n){
    var slides=document.querySelectorAll('.a4-sl'),dots=document.querySelectorAll('.a4-dot');
    slides.forEach(function(s){s.classList.remove('on');});
    dots.forEach(function(d){d.classList.remove('on');});
    curSl=(n+DATA.slides.length)%DATA.slides.length;
    slides[curSl].classList.add('on'); dots[curSl].classList.add('on');
  }
  window.a4SlMove=function(dir){clearInterval(slTimer);goSlide(curSl+dir);startSliderTimer();};
  function startSliderTimer(){clearInterval(slTimer);slTimer=setInterval(function(){goSlide(curSl+1);},5500);}

  /* ══════════════════════════════════════════════════════
     TICKER
     ═══════════════════════════════════════════════════════ */
  function renderTicker(){
    var el=document.getElementById('a4Ticker'); if(!el) return;
    var items=DATA.ticker.concat(DATA.ticker);
    el.innerHTML=items.map(function(t){return '<span class="a4-ticker-item">'+escH(t)+'</span>';}).join('');
  }

  /* ══════════════════════════════════════════════════════
     RUNDOWN
     ═══════════════════════════════════════════════════════ */
  var activeDay=0;
  function renderRundown(){
    var tabs=document.getElementById('a4DayTabs'); if(!tabs) return;
    tabs.innerHTML=DATA.rundown.days.map(function(d,i){
      return '<button class="a4-dt'+(i===activeDay?' on':'')+'" onclick="a4SwitchDay('+i+')">'+escH(d.label)+'</button>';
    }).join('');
    renderTimeline();
  }
  window.a4SwitchDay=function(i){activeDay=i;renderRundown();};
  var typeMap={keynote:{cls:'a4-eb-keynote',lbl:'Keynote'},panel:{cls:'a4-eb-panel',lbl:'Panel'},workshop:{cls:'a4-eb-workshop',lbl:'Workshop'},break:{cls:'a4-eb-break',lbl:'Break'},networking:{cls:'a4-eb-networking',lbl:'Hiburan'},award:{cls:'a4-eb-award',lbl:'Penutupan'}};
  function renderTimeline(){
    var tl=document.getElementById('a4Timeline'); if(!tl) return;
    var now=new Date(), nowMin=now.getHours()*60+now.getMinutes();
    var evs=DATA.rundown.events.filter(function(e){return e.day===activeDay;});
    tl.innerHTML=evs.map(function(e){
      var tm=typeMap[e.type]||typeMap.break;
      var eMin=parseInt((e.time||'0').split('.')[0])*60+parseInt((e.time||'0').split('.')[1]||0);
      var endMin=e.end?parseInt(e.end.split('.')[0])*60+parseInt(e.end.split('.')[1]||0):eMin+60;
      var isnow=(nowMin>=eMin&&nowMin<endMin);
      return '<div class="a4-tli"><div class="a4-tli-dot'+(isnow?' now':'')+'"></div>'+
        '<div class="a4-tl-card'+(isnow?' now':'')+'">'+
        '<div class="a4-tl-time"><span class="a4-ev-badge '+tm.cls+'">'+tm.lbl+'</span>'+escH(e.time)+(e.end?' – '+escH(e.end):'')+'</div>'+
        '<div class="a4-tl-name">'+escH(e.name)+'</div>'+
        (e.loc&&e.loc!=='—'?'<div class="a4-tl-meta">&#128205; '+escH(e.loc)+'</div>':'')+
        '</div></div>';
    }).join('');
  }

  /* ══════════════════════════════════════════════════════
     AREA FILTERS & TENANT GRID
     ═══════════════════════════════════════════════════════ */
  var activeArea='all';
  function renderAreaFilters(){
    var el=document.getElementById('a4AreaFilters'); if(!el) return;
    var areas=[{key:'all',lbl:'Semua',cls:'a4-af-all'},{key:'A',lbl:'Area A – UNAIR',cls:'a4-af-a'},{key:'B',lbl:'Area B – Mitra',cls:'a4-af-b'},{key:'C',lbl:'Area C – Eksternal',cls:'a4-af-c'},{key:'D',lbl:'Area D – Startup',cls:'a4-af-d'},{key:'E',lbl:'Area E – Institusi',cls:'a4-af-e'}];
    el.innerHTML=areas.map(function(a){return '<button class="a4-af '+a.cls+(activeArea===a.key?' on':'')+'" onclick="a4FilterArea(\''+a.key+'\')">'+a.lbl+'</button>';}).join('');
  }
  window.a4FilterArea=function(area){activeArea=area;renderAreaFilters();renderTenants();};

  function renderTenants(){
    var grid=document.getElementById('a4TenantGrid'); if(!grid) return;
    var list=activeArea==='all'?DATA.tenants:DATA.tenants.filter(function(t){return t.area===activeArea;});
    var areaClrCard={A:'#3b82f6',B:'#22c55e',C:'#f59e0b',D:'#a855f7',E:'#06b6d4'};
    grid.innerHTML=list.map(function(t){
      var c=areaClrCard[t.area]||'#d4a843';
      var icons='';
      if(t.web) icons+='<span class="a4-tc-ico" title="Website">&#127760;</span>';
      if(t.instagram) icons+='<span class="a4-tc-ico" title="Instagram">&#128247;</span>';
      if(t.facebook) icons+='<span class="a4-tc-ico" title="Facebook">&#128077;</span>';
      if(t.twitter) icons+='<span class="a4-tc-ico" title="X/Twitter">&#128038;</span>';
      if(t.contact) icons+='<span class="a4-tc-ico" title="'+escH(t.contact)+'">&#128231;</span>';
      return '<div class="a4-tc" onclick="a4OpenModal(\''+escH(t.id)+'\')">'+
        '<div class="a4-tc-top">'+
          '<div class="a4-tc-logo">'+(t.logo?'<img src="'+escH(t.logo)+'" alt="'+escH(t.name)+'" style="width:100%;height:100%;object-fit:contain;border-radius:8px">':'&#127970;')+'</div>'+
          '<div class="a4-tc-area-badge" style="background:'+c+'22;color:'+c+';border:1px solid '+c+'44">Area '+escH(t.area)+'</div>'+
        '</div>'+
        '<div class="a4-tc-num" style="color:'+c+'">'+escH(t.id)+'</div>'+
        '<div class="a4-tc-name">'+escH(t.name)+'</div>'+
        '<div class="a4-tc-cat">'+escH(t.cat)+'</div>'+
        (t.desc?'<div class="a4-tc-desc">'+escH(t.desc)+'</div>':'')+
        '<div class="a4-tc-tags">'+(t.tags||[]).map(function(g){return '<span class="a4-tag">'+escH(g)+'</span>';}).join('')+'</div>'+
        (icons?'<div class="a4-tc-icons">'+icons+'</div>':'')+
        '<div class="a4-tc-cta">Lihat Detail &#8594;</div>'+
      '</div>';
    }).join('');
    var stEl=document.getElementById('a4stTenant'),stEl2=document.getElementById('a4stTotal');
    if(stEl) stEl.textContent=DATA.tenants.length;
    if(stEl2) stEl2.textContent=DATA.tenants.length;
  }

  /* ══════════════════════════════════════════════════════
     DENAH SVG — area-grouped, sinkron dari tenant DB + PASINBIS
     ═══════════════════════════════════════════════════════ */
  var areaClr={
    A:{fill:'#1e3a6e',stroke:'#3b82f6',label:'Area A — UNAIR'},
    B:{fill:'#14532d',stroke:'#22c55e',label:'Area B — Mitra'},
    C:{fill:'#78350f',stroke:'#f59e0b',label:'Area C — Eksternal'},
    D:{fill:'#4c1d95',stroke:'#a855f7',label:'Area D — Startup'},
    E:{fill:'#0c4a6e',stroke:'#06b6d4',label:'Area E — Institusi'},
  };
  var denahActiveArea='all';

  function renderDenahFilters(){
    var el=document.getElementById('a4DenahFilters'); if(!el) return;
    var areas=[{key:'all',lbl:'Semua Area',clr:'#d4a843'}];
    Object.keys(areaClr).forEach(function(k){areas.push({key:k,lbl:areaClr[k].label,clr:areaClr[k].stroke});});
    el.innerHTML=areas.map(function(a){
      var on=denahActiveArea===a.key;
      return '<button class="a4-df-btn'+(on?' on':'')+'" style="'+(on?'background:'+a.clr+'22;border-color:'+a.clr+';color:'+a.clr:'')+'" onclick="a4SetDenahArea(\''+a.key+'\')">'+escH(a.lbl)+'</button>';
    }).join('');
  }
  window.a4SetDenahArea=function(area){denahActiveArea=area;renderDenahFilters();renderMap();};

  function renderMapLegend(){
    var el=document.getElementById('a4MapLegend'); if(!el) return;
    el.innerHTML=Object.keys(areaClr).map(function(k){
      var c=areaClr[k];
      return '<span class="a4-ml"><span class="a4-ml-box" style="background:'+c.fill+';border:1px solid '+c.stroke+'"></span>'+escH(c.label)+'</span>';
    }).join('');
  }

  function renderMap(){
    var svg=document.getElementById('a4FloorMap'); if(!svg) return;
    var cfg         = window.ASSIE4_CFG||{};
    var pb          = cfg.pasinbis||{};
    // Nama dan sub-label PASINBIS dari admin — SINKRON otomatis
    var pasinbisNama= pb.nama||'PASINBIS UNAIR';
    var pasinbisDesk= pb.desk||'pasinbis.unair.ac.id';
    var pasinbisUrl = pb.url ||'https://pasinbis.unair.ac.id';

    // Kelompokkan tenant per area
    var tenants=DATA.tenants||[];
    var byArea={A:[],B:[],C:[],D:[],E:[]};
    tenants.forEach(function(t){
      if(byArea[t.area]!==undefined&&(denahActiveArea==='all'||t.area===denahActiveArea)) byArea[t.area].push(t);
    });

    var BW=58,BH=42,GAP=6,PAD=14;
    var AREA_ORDER=['A','B','C','D','E'];
    var areaLayouts={};
    var totalH=PAD;
    AREA_ORDER.forEach(function(area){
      var booths=byArea[area];
      if(!booths.length){areaLayouts[area]={y:totalH,rows:0,h:0};return;}
      var cols=Math.min(booths.length,Math.floor((940-PAD*2)/(BW+GAP)));
      cols=Math.max(cols,1);
      var rows=Math.ceil(booths.length/cols);
      var h=20+rows*(BH+GAP)+PAD;
      areaLayouts[area]={y:totalH,rows:rows,cols:cols,h:h};
      totalH+=h+8;
    });
    // Stage + PASINBIS row
    var stageY=totalH+8;
    totalH=stageY+60+PAD;

    var VW=960;
    svg.setAttribute('viewBox','0 0 '+VW+' '+totalH);
    svg.setAttribute('width','100%');
    svg.setAttribute('height',totalH);
    svg.style.minHeight = totalH + 'px';
    var html='<rect width="'+VW+'" height="'+totalH+'" fill="#060b18"/>';

    AREA_ORDER.forEach(function(area){
      var info=areaLayouts[area];
      if(!info||!info.rows) return;
      var c=areaClr[area],booths=byArea[area],y0=info.y,cols=info.cols;
      html+='<rect x="'+PAD+'" y="'+y0+'" width="'+(VW-PAD*2)+'" height="'+info.h+'" fill="'+c.fill+'18" stroke="'+c.stroke+'44" stroke-width="1" rx="8"/>';
      html+='<text x="'+(PAD+10)+'" y="'+(y0+15)+'" font-size="10" font-weight="800" font-family="Syne,sans-serif" fill="'+c.stroke+'" opacity=".85">'+escH(areaClr[area].label.toUpperCase())+'</text>';
      booths.forEach(function(t,i){
        var col=i%cols,row=Math.floor(i/cols);
        var bx=PAD+col*(BW+GAP),by=y0+20+row*(BH+GAP);
        var isPasinbis=(t.id==='PASINBIS'||(t.name&&t.name.toLowerCase().indexOf('pasinbis')>=0));
        var clickFn=isPasinbis?'a4BoothClickPasinbis()':'a4OpenModal(\''+escH(t.id)+'\')';
        var fill=isPasinbis?'#1a2a1a':c.fill, sw=isPasinbis?'2':'0.8', sc=isPasinbis?'#d4a843':c.stroke;
        var dataAttr = isPasinbis ? 'data-fn="pasinbis"' : 'data-id="'+escH(t.id)+'"';
        html+='<g class="a4-booth" '+dataAttr+' style="cursor:pointer" onmouseenter="a4ShowTip(event,\''+escH(t.id)+'\')" onmouseleave="a4HideTip()">';
        html+='<rect x="'+bx+'" y="'+by+'" width="'+BW+'" height="'+BH+'" rx="5" fill="'+fill+'" stroke="'+sc+'" stroke-width="'+sw+'" style="transition:all .15s"/>';
        var idLabel=t.id.length>5?t.id.substring(0,5):t.id;
        html+='<text x="'+(bx+BW/2)+'" y="'+(by+BH/2-3)+'" font-size="8" font-weight="700" fill="rgba(255,255,255,.9)" text-anchor="middle" font-family="Syne,sans-serif">'+escH(idLabel)+'</text>';
        var sName=t.name?t.name.split(' ').slice(0,2).join(' '):'';
        if(sName.length>12) sName=sName.substring(0,10)+'…';
        if(sName) html+='<text x="'+(bx+BW/2)+'" y="'+(by+BH/2+8)+'" font-size="5.5" fill="rgba(255,255,255,.65)" text-anchor="middle" font-family="Plus Jakarta Sans,sans-serif">'+escH(sName)+'</text>';
        html+='</g>';
      });
    });

    // STAGE — gunakan data-fn untuk event delegation
    html+='<g class="a4-booth" data-fn="stage" style="cursor:pointer">';
    html+='<rect x="'+PAD+'" y="'+stageY+'" width="240" height="52" rx="8" fill="#3a0808" stroke="#dc2626" stroke-width="2"/>';
    html+='<text x="'+(PAD+120)+'" y="'+(stageY+22)+'" font-size="12" font-weight="800" fill="#fca5a5" text-anchor="middle" font-family="Syne,sans-serif" pointer-events="none">&#127908; MAIN STAGE</text>';
    html+='<text x="'+(PAD+120)+'" y="'+(stageY+38)+'" font-size="9" fill="rgba(252,165,165,.7)" text-anchor="middle" font-family="Plus Jakarta Sans,sans-serif" pointer-events="none">Klik untuk lihat jadwal acara</text>';
    html+='</g>';

    // BOOTH PASINBIS — gunakan data-fn untuk event delegation
    var pbX=PAD+260,pbY=stageY;
    var pbLabel=pasinbisNama.length>18?pasinbisNama.substring(0,16)+'…':pasinbisNama;
    var pbSub  =pasinbisDesk.length>30?pasinbisDesk.substring(0,28)+'…':pasinbisDesk;
    html+='<g class="a4-booth" data-fn="pasinbis" style="cursor:pointer">';
    html+='<rect x="'+pbX+'" y="'+pbY+'" width="200" height="52" rx="8" fill="#1a2a1a" stroke="#d4a843" stroke-width="2"/>';
    html+='<text x="'+(pbX+100)+'" y="'+(pbY+21)+'" font-size="11" font-weight="800" fill="#d4a843" text-anchor="middle" font-family="Syne,sans-serif" pointer-events="none">&#127962; '+escH(pbLabel)+'</text>';
    html+='<text x="'+(pbX+100)+'" y="'+(pbY+37)+'" font-size="8" fill="rgba(212,168,67,.65)" text-anchor="middle" font-family="Plus Jakarta Sans,sans-serif" pointer-events="none">'+escH(pbSub)+'</text>';
    html+='</g>';

    svg.innerHTML=html;

    // FIX: SVG onclick via innerHTML tidak reliable di semua browser
    // Gunakan event delegation pada wrapper
    var wrap = document.getElementById('a4MapWrap');
    if (wrap && !wrap._a4delegated) {
      wrap._a4delegated = true;
      wrap.addEventListener('click', function(e) {
        var target = e.target;
        // Naik ke parent g element
        while (target && target !== wrap) {
          if (target.classList && target.classList.contains('a4-booth')) {
            var fn = target.getAttribute('data-fn');
            if (fn === 'stage')    { window.a4OpenStage(); break; }
            if (fn === 'pasinbis') { window.a4BoothClickPasinbis(); break; }
            var tid = target.getAttribute('data-id');
            if (tid) { window.a4OpenModal(tid); break; }
          }
          target = target.parentNode;
        }
      });
    }
  }

  /* ── Stage Modal — jadwal acara ── */
  window.a4OpenStage=function(){
    var head=document.getElementById('a4ModalHead'),body=document.getElementById('a4ModalBody');
    if(!head||!body) return;
    head.innerHTML='<button class="a4-m-close" onclick="a4CloseModal()">&#x2715;</button>'+
      '<div class="a4-m-num" style="color:#ef4444">&#127908;</div>'+
      '<div class="a4-m-name">Main Stage</div>'+
      '<div class="a4-m-area">Grand City Convention Hall</div>';
    var now=new Date(),nowMin=now.getHours()*60+now.getMinutes();
    var events=DATA.rundown&&DATA.rundown.events?DATA.rundown.events:[];
    var dayMap={};
    events.forEach(function(e){if(!dayMap[e.day])dayMap[e.day]=[];dayMap[e.day].push(e);});
    var days=DATA.rundown&&DATA.rundown.days?DATA.rundown.days:[];
    var html='<div class="a4-m-section-label">&#128203; Jadwal Acara</div>';
    Object.keys(dayMap).sort().forEach(function(d){
      var dayLbl=(days[d]&&days[d].label)?days[d].label:'Hari '+(parseInt(d)+1);
      html+='<div style="font-size:11px;font-weight:700;color:var(--a4-gold);margin:12px 0 6px;text-transform:uppercase;letter-spacing:1px">'+escH(dayLbl)+'</div>';
      dayMap[d].forEach(function(e){
        var tm=typeMap[e.type]||typeMap.break;
        var eMin=parseInt((e.time||'0').split('.')[0])*60+parseInt((e.time||'0').split('.')[1]||0);
        var endMin=e.end?parseInt(e.end.split('.')[0])*60+parseInt(e.end.split('.')[1]||0):eMin+60;
        var isnow=(nowMin>=eMin&&nowMin<endMin);
        html+='<div class="a4-tl-card'+(isnow?' now':'')+'" style="margin-bottom:8px;padding:10px 14px">';
        html+='<div class="a4-tl-time"><span class="a4-ev-badge '+tm.cls+'">'+tm.lbl+'</span>'+escH(e.time)+(e.end?' – '+escH(e.end):'')+(isnow?' <span style="color:#22c55e;font-weight:700">&#9679; BERLANGSUNG</span>':'')+'</div>';
        html+='<div class="a4-tl-name">'+escH(e.name)+'</div>';
        if(e.loc&&e.loc!=='—') html+='<div class="a4-tl-meta">&#128205; '+escH(e.loc)+'</div>';
        html+='</div>';
      });
    });
    body.innerHTML=html;
    var modal=document.getElementById('a4Modal');
    if(modal){modal.classList.add('on');document.body.style.overflow='hidden';}
  };

  /* ── Booth PASINBIS — modal info dari admin (sinkron) ── */
  window.a4BoothClickPasinbis=function(){
    var cfg=window.ASSIE4_CFG||{},pb=cfg.pasinbis||{};
    var url=pb.url||'https://pasinbis.unair.ac.id',nama=pb.nama||'PASINBIS UNAIR',
        desk=pb.desk||'',logo=pb.logo||'',ig=pb.ig||'',web=pb.web||'';
    var head=document.getElementById('a4ModalHead'),body=document.getElementById('a4ModalBody');
    if(!head||!body){window.open(url,'_blank');return;}
    head.innerHTML=
      '<button class="a4-m-close" onclick="a4CloseModal()">&#x2715;</button>'+
      '<div class="a4-m-head-top">'+
        (logo?'<img src="'+escH(logo)+'" class="a4-m-logo-img" alt="'+escH(nama)+'">':'<div class="a4-m-logo-ph">&#127962;</div>')+
        '<div>'+
          '<div class="a4-m-num" style="color:#d4a843">PASINBIS</div>'+
          '<div class="a4-m-name">'+escH(nama)+'</div>'+
          '<div class="a4-m-area"><span class="a4-m-area-badge" style="background:#d4a84322;color:#d4a843;border:1px solid #d4a84344">Booth Resmi Penyelenggara</span></div>'+
        '</div></div>';
    var igUrl=ig?(ig.indexOf('http')===0?ig:'https://instagram.com/'+ig.replace('@','')):'' ;
    var kHtml='';
    if(url||ig||web){
      kHtml='<div class="a4-m-section-label">&#128241; Kontak & Media Sosial</div><div class="a4-m-kontak-list">';
      if(url) kHtml+='<div class="a4-m-kr"><span class="a4-m-ki">&#127760;</span><span class="a4-m-kl">Website</span><a href="'+escH(url)+'" target="_blank" class="a4-m-kv">'+escH(url.replace(/^https?:\/\//,''))+'</a></div>';
      if(ig)  kHtml+='<div class="a4-m-kr"><span class="a4-m-ki">&#128247;</span><span class="a4-m-kl">Instagram</span><a href="'+escH(igUrl)+'" target="_blank" class="a4-m-kv">'+escH(ig)+'</a></div>';
      if(web) kHtml+='<div class="a4-m-kr"><span class="a4-m-ki">&#128722;</span><span class="a4-m-kl">TokoUA</span><a href="'+escH(web)+'" target="_blank" class="a4-m-kv">'+escH(web.replace(/^https?:\/\//,''))+'</a></div>';
      kHtml+='</div>';
    }
    body.innerHTML=(desk?'<div class="a4-m-desc">'+escH(desk)+'</div>':'')+kHtml+
      '<hr class="a4-m-divider"><div style="display:flex;gap:10px;flex-wrap:wrap">'+
      '<a href="'+escH(url)+'" target="_blank" class="a4-m-shop">&#127760; Buka Website PASINBIS</a>'+
      (web?'<a href="'+escH(web)+'" target="_blank" class="a4-btn-out" style="font-size:13px">&#128722; TokoUA</a>':'')+
      '</div>';
    var modal=document.getElementById('a4Modal');
    if(modal){modal.classList.add('on');document.body.style.overflow='hidden';}
  };

  /* ── Zoom / Pan ── */
  var mapScale=1;
  window.a4ZoomMap=function(f){var svg=document.getElementById('a4FloorMap');if(!svg)return;mapScale=Math.min(3,Math.max(0.4,mapScale*f));svg.style.transform='scale('+mapScale+')';svg.style.transformOrigin='top left';};
  window.a4ResetZoom=function(){var svg=document.getElementById('a4FloorMap');if(svg){mapScale=1;svg.style.transform='';svg.style.transformOrigin='';}};

  /* ══════════════════════════════════════════════════════
     DENAH GAMBAR UPLOAD
     ═══════════════════════════════════════════════════════ */
  var lbImages=[],lbIdx=0;
  function renderDenahImgs(){
    var imgs=DATA.denah||[],wrap=document.getElementById('a4DenahImgs'),gal=document.getElementById('a4DenahGallery');
    if(!wrap||!gal) return;
    if(!imgs.length){wrap.style.display='none';return;}
    lbImages=imgs; wrap.style.display='block';
    gal.innerHTML=imgs.map(function(img,i){
      return '<div class="a4-denah-card" onclick="a4OpenLightbox('+i+')">'+
        '<div class="a4-denah-img-wrap"><img src="'+escH(img.url)+'" alt="'+escH(img.caption||('Denah '+(i+1)))+'" loading="lazy">'+
        '<div class="a4-denah-overlay"><span>Perbesar</span></div></div>'+
        (img.caption?'<div class="a4-denah-caption">'+escH(img.caption)+'</div>':'')+
        '</div>';
    }).join('');
  }
  window.a4OpenLightbox=function(i){
    lbIdx=i;var lb=document.getElementById('a4Lightbox'),img=document.getElementById('a4LbImg'),cap=document.getElementById('a4LbCaption');
    if(!lb||!img) return;
    img.src=lbImages[i].url; cap.textContent=lbImages[i].caption||'';
    document.getElementById('a4LbPrev').style.display=lbImages.length>1?'flex':'none';
    document.getElementById('a4LbNext').style.display=lbImages.length>1?'flex':'none';
    lb.classList.add('on'); document.body.style.overflow='hidden';
  };
  window.a4CloseLightbox=function(){var lb=document.getElementById('a4Lightbox');if(lb)lb.classList.remove('on');document.body.style.overflow='';};
  window.a4LbNav=function(d){lbIdx=(lbIdx+d+lbImages.length)%lbImages.length;window.a4OpenLightbox(lbIdx);};

  /* ══════════════════════════════════════════════════════
     TOOLTIP
     ═══════════════════════════════════════════════════════ */
  var ttEl=document.getElementById('a4Tooltip');
  window.a4ShowTip=function(e,id){
    var t=DATA.tenants.find(function(x){return x.id===id;});
    if(!t||!ttEl) return;
    ttEl.innerHTML='<div class="a4-tt-num">'+escH(t.id)+'</div><div class="a4-tt-name">'+escH(t.name)+'</div><div class="a4-tt-cat">'+escH(t.cat)+'</div>';
    ttEl.style.left=(e.clientX+14)+'px'; ttEl.style.top=(e.clientY-10)+'px'; ttEl.style.opacity='1';
  };
  window.a4HideTip=function(){if(ttEl) ttEl.style.opacity='0';};

  /* ══════════════════════════════════════════════════════
     MODAL DETAIL BOOTH
     ═══════════════════════════════════════════════════════ */
  var areaClrFull={A:'#3b82f6',B:'#22c55e',C:'#f59e0b',D:'#a855f7',E:'#06b6d4'};
  var presUrl=(window.ASSIE4_CFG&&ASSIE4_CFG.presensiUrl)||'/presensi-booth-assie4/';
  window.a4OpenModal=function(id){
    var t=DATA.tenants.find(function(x){return x.id===id;});
    if(!t) return;
    t={id:t.id||'',area:t.area||'',name:t.name||'',cat:t.cat||'',desc:t.desc||'',tags:Array.isArray(t.tags)?t.tags:[],logo:t.logo||'',contact:t.contact||'',web:t.web||'',instagram:t.instagram||'',facebook:t.facebook||'',twitter:t.twitter||''};
    var c=areaClrFull[t.area]||'#d4a843';
    var head=document.getElementById('a4ModalHead'),body=document.getElementById('a4ModalBody');
    if(!head||!body) return;
    head.innerHTML='<button class="a4-m-close" onclick="a4CloseModal()">&#x2715;</button>'+
      '<div class="a4-m-head-top">'+
        (t.logo?'<img src="'+escH(t.logo)+'" class="a4-m-logo-img" alt="'+escH(t.name)+'">':'<div class="a4-m-logo-ph">&#127962;</div>')+
        '<div>'+
          '<div class="a4-m-num" style="color:'+c+'">'+escH(t.id)+'</div>'+
          '<div class="a4-m-name">'+escH(t.name)+'</div>'+
          '<div class="a4-m-area">'+
            '<span class="a4-m-area-badge" style="background:'+c+'22;color:'+c+';border:1px solid '+c+'44">Area '+escH(t.area)+'</span>'+
            (t.cat?' <span class="a4-m-cat">'+escH(t.cat)+'</span>':'')+
          '</div>'+
        '</div></div>';
    var identitas='<div class="a4-m-section-label">&#128203; Identitas Booth</div>'+
      '<div class="a4-m-grid">'+
        '<div class="a4-mg-item"><div class="a4-mg-label">1. Kode Booth</div><div class="a4-mg-val" style="color:'+c+'">'+escH(t.id)+'</div></div>'+
        '<div class="a4-mg-item"><div class="a4-mg-label">2. Area</div><div class="a4-mg-val">Area '+escH(t.area)+'</div></div>'+
        '<div class="a4-mg-item"><div class="a4-mg-label">3. Nama Tenant</div><div class="a4-mg-val">'+escH(t.name)+'</div></div>'+
        '<div class="a4-mg-item"><div class="a4-mg-label">4. Kategori</div><div class="a4-mg-val">'+(t.cat?escH(t.cat):'—')+'</div></div>'+
      '</div>'+
      (t.desc?'<div class="a4-mg-item" style="margin-top:8px"><div class="a4-mg-label">5. Deskripsi</div><div class="a4-mg-val" style="font-size:13px;font-weight:400;line-height:1.6">'+escH(t.desc)+'</div></div>':'');
    var tagsRow=t.tags.length?'<div class="a4-mg-item" style="margin-top:8px"><div class="a4-mg-label">6. Tags</div><div style="display:flex;gap:4px;flex-wrap:wrap;margin-top:4px">'+t.tags.map(function(g){return '<span class="a4-m-tag">'+escH(g)+'</span>';}).join('')+'</div></div>':'';
    var logoRow=t.logo?'<div class="a4-mg-item" style="margin-top:8px"><div class="a4-mg-label">7. Logo</div><div style="margin-top:4px"><img src="'+escH(t.logo)+'" style="max-height:40px;border-radius:6px"></div></div>':'';
    var igUrl='',twUrl='';
    if(t.instagram) igUrl=t.instagram.indexOf('http')===0?t.instagram:'https://instagram.com/'+t.instagram.replace('@','');
    if(t.twitter)   twUrl=t.twitter.indexOf('http')===0?t.twitter:'https://x.com/'+t.twitter.replace('@','');
    var hasKontak=t.contact||t.web||t.instagram||t.facebook||t.twitter;
    var kHtml='';
    if(hasKontak){
      kHtml='<div class="a4-m-section-label">&#128241; Kontak & Media Sosial</div><div class="a4-m-kontak-list">';
      if(t.contact) kHtml+='<div class="a4-m-kr"><span class="a4-m-ki">&#128231;</span><span class="a4-m-kl">8. Email</span><a href="mailto:'+escH(t.contact)+'" class="a4-m-kv">'+escH(t.contact)+'</a></div>';
      if(t.web)     kHtml+='<div class="a4-m-kr"><span class="a4-m-ki">&#127760;</span><span class="a4-m-kl">9. Website</span><a href="'+escH(t.web)+'" target="_blank" class="a4-m-kv">'+escH(t.web.replace(/^https?:\/\//,''))+'</a></div>';
      if(t.instagram) kHtml+='<div class="a4-m-kr"><span class="a4-m-ki">&#128247;</span><span class="a4-m-kl">10. Instagram</span><a href="'+escH(igUrl)+'" target="_blank" class="a4-m-kv">'+escH(t.instagram)+'</a></div>';
      if(t.facebook)  kHtml+='<div class="a4-m-kr"><span class="a4-m-ki">&#128077;</span><span class="a4-m-kl">11. Facebook</span><a href="'+escH(t.facebook)+'" target="_blank" class="a4-m-kv">'+escH(t.facebook.replace(/^https?:\/\//,''))+'</a></div>';
      if(t.twitter)   kHtml+='<div class="a4-m-kr"><span class="a4-m-ki">&#128038;</span><span class="a4-m-kl">12. X/Twitter</span><a href="'+escH(twUrl)+'" target="_blank" class="a4-m-kv">'+escH(t.twitter)+'</a></div>';
      kHtml+='</div>';
    }
    var sosmedBtns='';
    if(t.web) sosmedBtns+='<a href="'+escH(t.web)+'" target="_blank" class="a4-social-btn">&#127760; Website</a>';
    if(t.instagram) sosmedBtns+='<a href="'+escH(igUrl)+'" target="_blank" class="a4-social-btn a4-sb-ig">&#128247; Instagram</a>';
    if(t.facebook) sosmedBtns+='<a href="'+escH(t.facebook)+'" target="_blank" class="a4-social-btn a4-sb-fb">&#128077; Facebook</a>';
    if(t.twitter) sosmedBtns+='<a href="'+escH(twUrl)+'" target="_blank" class="a4-social-btn a4-sb-tw">&#128038; X/Twitter</a>';
    body.innerHTML=identitas+tagsRow+logoRow+(kHtml||'')+(sosmedBtns?'<div class="a4-m-sosmed" style="margin-top:14px">'+sosmedBtns+'</div>':'')+
      '<hr class="a4-m-divider"><div style="display:flex;gap:10px;flex-wrap:wrap">'+
      '<a href="https://tokoua.unair.ac.id/" target="_blank" class="a4-m-shop">&#128722; Beli di TokoUA</a>'+
      '<a href="'+escH(presUrl)+'" class="a4-btn-out" style="font-size:13px">&#128203; Presensi</a>'+
      '</div>';
    var modal=document.getElementById('a4Modal');
    if(modal){modal.classList.add('on');document.body.style.overflow='hidden';}
  };
  window.a4CloseModal=function(){var m=document.getElementById('a4Modal');if(m){m.classList.remove('on');document.body.style.overflow='';}};

  /* ══════════════════════════════════════════════════════
     STATS
     ═══════════════════════════════════════════════════════ */
  function refreshStats(){
    var cfg=window.ASSIE4_CFG||{};
    if(!cfg.ajaxUrl) return;
    var xhr=new XMLHttpRequest();
    xhr.open('GET',cfg.ajaxUrl+'?action=assie4_get_stats&_wpnonce='+(cfg.nonce||''));
    xhr.onload=function(){
      try{
        var d=JSON.parse(xhr.responseText);
        if(d&&d.today!==undefined){
          var sT=document.getElementById('a4stToday'),sA=document.getElementById('a4stAll');
          if(sT) sT.textContent=d.today; if(sA) sA.textContent=d.total;
          renderLeaderboard(d.top||[]);
        }
      }catch(e){}
    };
    xhr.send();
  }
  function renderLeaderboard(top){
    var el=document.getElementById('a4LbGrid'); if(!el) return;
    if(!top.length){el.innerHTML='<p class="a4-muted-note">Belum ada presensi hari ini.</p>';return;}
    var medals=['&#127945;','&#127946;','&#127947;'];
    el.innerHTML=top.slice(0,6).map(function(item,i){
      return '<div class="a4-lbc"><div class="a4-lb-r">'+(i<3?medals[i]:'#'+(i+1))+'</div>'+
        '<div class="a4-lb-info"><div class="a4-lb-b">Booth '+escH(item.booth)+' — '+(item.name?escH(item.name):'')+'</div>'+
        '<div class="a4-lb-c">'+item.count+' pengunjung</div></div></div>';
    }).join('');
  }

  /* ══════════════════════════════════════════════════════
     BERITA — RSS pasinbis via AJAX proxy
     ═══════════════════════════════════════════════════════ */
  function loadBerita(){
    var grid=document.getElementById('a4NewsGrid'); if(!grid) return;
    var cfg=window.ASSIE4_CFG||{},ajax=cfg.ajaxUrl||'/wp-admin/admin-ajax.php',nonce=cfg.nonce||'';
    fetch(ajax+'?action=assie4_news&_wpnonce='+nonce)
      .then(function(r){return r.json();})
      .then(function(items){
        if(!items||!items.length){
          grid.innerHTML='<div class="a4-news-empty">&#128240; Belum ada berita. <a href="https://pasinbis.unair.ac.id/category/assie-4-tahun-2026/" target="_blank" style="color:var(--a4-gold)">Kunjungi pasinbis.unair.ac.id &#8594;</a></div>';
          return;
        }
        grid.innerHTML=items.map(function(item){
          var ds='';
          try{var d=new Date(item.date);ds=d.toLocaleDateString('id-ID',{day:'numeric',month:'long',year:'numeric'});}catch(e){ds=item.date||'';}
          var thumb=item.thumb
            ?'<div class="a4-nc-img"><img src="'+escH(item.thumb)+'" alt="" loading="lazy" onerror="this.className+=\' a4-nc-img-err\'"></div>'
            :'<div class="a4-nc-img a4-nc-img-ph"><span>&#128240;</span></div>';
          return '<a href="'+escH(item.link)+'" target="_blank" class="a4-news-card" title="Baca selengkapnya">'+thumb+
            '<div class="a4-nc-body"><div class="a4-nc-date">'+escH(ds)+'</div>'+
            '<div class="a4-nc-title">'+escH(item.title)+'</div>'+
            (item.desc?'<div class="a4-nc-desc">'+escH(item.desc)+'</div>':'')+
            '</div></a>';
        }).join('');
      })
      .catch(function(){
        grid.innerHTML='<div class="a4-news-empty">Gagal memuat berita. <a href="https://pasinbis.unair.ac.id/category/assie-4-tahun-2026/" target="_blank" style="color:var(--a4-gold)">Buka langsung &#8594;</a></div>';
      });
  }

  /* ══════════════════════════════════════════════════════
     INIT
     ═══════════════════════════════════════════════════════ */
  function init(){
    renderInfo();
    renderSlider();
    renderTicker();
    renderRundown();
    renderAreaFilters();
    renderTenants();
    renderDenahFilters();
    renderMapLegend();
    renderMap();
    renderDenahImgs();
    loadBerita();
    refreshStats();
  }

  if(document.readyState==='loading'){
    document.addEventListener('DOMContentLoaded',init);
  } else {
    init();
  }
  setInterval(refreshStats,60000);
})();

/* ── TokoUA Modal ─────────────────────────────────────── */
(function(){
  window.a4OpenTokoUA = function(){
    var modal = document.getElementById('a4TokoUAModal');
    if(!modal) return;
    modal.classList.add('open');
    document.body.style.overflow = 'hidden';
  };

  window.a4CloseTokoUA = function(){
    var modal = document.getElementById('a4TokoUAModal');
    if(modal) modal.classList.remove('open');
    document.body.style.overflow = '';
  };

  document.addEventListener('keydown', function(e){
    if(e.key === 'Escape') a4CloseTokoUA();
  });
})();
