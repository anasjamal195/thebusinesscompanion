<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GoalChaser.co — Your AI Project Manager</title>
  <link rel="icon" type="image/png" href="/assets/logo/logo-small-light.png" />
  <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@400,0..1&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --navy:#1A253A; --navy2:#223048; --navy3:#2E3F5B; --navy4:#3C5072;
      --cyan:#00AFF0; --cyan2:#0091C8;
      --green:#0EB647; --green2:#0A9A3B;
      --purple:#7C3AED; --orange:#EA580C;
      --white:#FFFFFF;
      --s1:#F8FAFC; --s2:#F1F5F9; --s3:#E2E8F0; --s4:#CBD5E1;
      --s5:#94A3B8; --s6:#64748B; --s7:#475569; --s8:#475569; --s9:#334155;
    }
    html { font-size:16px; }
    body { font-family:'Nunito',sans-serif; background:#fff; color:var(--s9); -webkit-font-smoothing:antialiased; overflow-x:hidden; }

    /* ─── NAV ─── */
    nav { position:fixed; top:0; left:0; right:0; z-index:100; padding:0 2rem; background:rgba(255,255,255,0); border-bottom:1px solid transparent; transition:background .3s,border-color .3s,box-shadow .3s; }
    nav.scrolled { background:rgba(255,255,255,.97); backdrop-filter:blur(12px); border-bottom-color:var(--s3); box-shadow:0 1px 16px rgba(45,55,72,0.05); }
    .nav-inner { max-width:1280px; margin:0 auto; height:110px; display:flex; align-items:center; justify-content:space-between; }
    .nav-logo { display:flex; align-items:center; text-decoration:none; }
    .nav-logo img { height:100px; width:auto; display:block; }
    @media(max-width:640px) { .nav-logo img { height:70px; } .nav-inner { height:80px; } .hero { margin-top:-80px; padding-top:80px; } }
    .nav-logo .logo-light { display:block; }
    .nav-logo .logo-dark { display:none; }
    nav.scrolled .nav-logo .logo-light { display:none; }
    nav.scrolled .nav-logo .logo-dark { display:block; }
    .nav-links { display:flex; align-items:center; gap:2rem; list-style:none; }
    .nav-links a { color:rgba(255,255,255,.75); text-decoration:none; font-size:.875rem; font-weight:700; transition:color .2s; }
    nav.scrolled .nav-links a { color:var(--s6); }
    .nav-links a:hover { color:var(--white); }
    nav.scrolled .nav-links a:hover { color:var(--cyan); }
    .nav-actions { display:flex; align-items:center; gap:1rem; }
    .nav-actions .btn-ghost { font-family:'Nunito',sans-serif; font-size:.875rem; font-weight:700; background:none; border:none; cursor:pointer; text-decoration:none; transition:color .2s; color:rgba(255,255,255,.75); }
    nav.scrolled .nav-actions .btn-ghost { color:var(--s6); }
    .nav-actions .btn-ghost:hover { color:var(--white); }
    nav.scrolled .nav-actions .btn-ghost:hover { color:var(--cyan); }
    .nav-actions .btn-primary { font-family:'Nunito',sans-serif; font-size:.875rem; font-weight:800; background:var(--cyan); border:none; padding:.625rem 1.375rem; border-radius:8px; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:.5rem; transition:background .2s,transform .15s; box-shadow:0 4px 14px rgba(0,175,240,.3); color:#fff; }
    nav.scrolled .nav-actions .btn-primary { background:var(--s9); color:#fff; box-shadow:none; }
    nav.scrolled .nav-actions .btn-primary:hover { background:var(--cyan); }
    .nav-actions .btn-primary:hover { background:var(--cyan2); transform:translateY(-1px); }

    /* ─── HAMBURGER / MOBILE MENU ─── */
    .nav-hamburger { display:none; background:none; border:none; cursor:pointer; padding:0.25rem; }
    .nav-hamburger svg { width:24px; height:24px; stroke:rgba(255,255,255,.8); transition:stroke .35s; }
    nav.scrolled .nav-hamburger svg { stroke:var(--s9); }
    .mobile-menu { display:none; flex-direction:column; gap:1rem; padding:1.5rem 2rem; background:rgba(255,255,255,.98); backdrop-filter:blur(20px); border-top:1px solid var(--s3); }
    .mobile-menu.open { display:flex; }
    .mobile-menu a { font-weight:700; font-size:.9375rem; color:var(--s7); text-decoration:none; transition:color .2s; }
    .mobile-menu a:hover { color:var(--cyan); }
    .mobile-menu .mobile-actions { display:flex; flex-direction:column; gap:.75rem; padding-top:.75rem; border-top:1px solid var(--s3); }
    .mobile-menu .mobile-actions a { justify-content:center; text-align:center; }
    .mobile-menu .mobile-actions .btn-primary { background:var(--cyan); color:#fff; padding:.75rem; border-radius:12px; font-weight:800; display:flex; align-items:center; gap:.5rem; text-decoration:none; font-family:'Nunito',sans-serif; font-size:.875rem; }
    .mobile-menu .mobile-actions .btn-ghost { background:var(--s2); color:var(--s7); padding:.75rem; border-radius:12px; font-weight:700; display:flex; align-items:center; gap:.5rem; text-decoration:none; font-family:'Nunito',sans-serif; font-size:.875rem; }
    @media(max-width:900px) {
      .nav-links, .nav-actions { display:none; }
      .nav-hamburger { display:block; }
      nav { padding:0 1rem; }
      .nav-inner { gap:.5rem; }
    }

    /* ─── HERO ─── */
    .hero { position:relative; min-height:100vh; display:flex; align-items:center; overflow:hidden; margin-top:-110px; padding-top:110px; background-image:url('assets/background.png'); background-size:cover; background-position:center; }
    .hero-overlay { position:absolute; inset:0; background:linear-gradient(135deg,rgba(10,15,25,.95) 0%,rgba(15,20,30,.90) 50%,rgba(5,10,15,.85) 100%); }
    .hero-glow1 { position:absolute; top:25%; left:25%; width:384px; height:384px; border-radius:50%; background:radial-gradient(circle,rgba(0,175,240,.12),transparent 70%); filter:blur(40px); pointer-events:none; }
    .hero-glow2 { position:absolute; bottom:25%; right:25%; width:320px; height:320px; border-radius:50%; background:radial-gradient(circle,rgba(14,182,71,.10),transparent 70%); filter:blur(40px); pointer-events:none; }
    .hero-glow3 { position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); width:600px; height:600px; border-radius:50%; background:radial-gradient(circle,rgba(124,58,237,.05),transparent 70%); filter:blur(60px); pointer-events:none; }

    .hero-inner { max-width:1280px; margin:0 auto; padding:5rem 2rem; width:100%; position:relative; z-index:1; display:grid; grid-template-columns:50% 50%; gap:2rem; align-items:center; }

    /* hero text */
    .hero-eyebrow { display:inline-flex; align-items:center; gap:.5rem; padding:.35rem .9rem; border:1px solid rgba(0,175,240,.3); background:rgba(0,175,240,.08); border-radius:999px; font-size:.7rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:var(--cyan); margin-bottom:1.5rem; }
    .eyebrow-dot { width:6px; height:6px; border-radius:50%; background:var(--green); animation:blink 1.8s ease-in-out infinite; }
    @keyframes blink { 0%,100%{opacity:1;} 50%{opacity:.4;} }

    .hero-toggle { display:inline-flex; align-items:center; padding:4px; background:rgba(255,255,255,.10); border:1px solid rgba(255,255,255,.2); border-radius:999px; margin-bottom:1.5rem; }
    .hero-toggle-opt { padding:.35rem 1rem; border-radius:999px; font-size:.75rem; font-weight:700; cursor:pointer; transition:all .2s; color:rgba(255,255,255,.6); }
    .hero-toggle-opt.active { background:var(--cyan); color:#fff; }

    .hero-h1 { font-family:'Nunito',sans-serif; font-size:clamp(2.2rem,4.5vw,3.6rem); font-weight:900; color:#fff; line-height:1.05; letter-spacing:-.04em; margin-bottom:1.5rem; }
    .hero-h1 .c1 { color:var(--cyan); }
    .hero-h1 .c2 { color:var(--green); }

    .hero-sub-big { color:rgba(255,255,255,.9); font-size:1.1rem; font-weight:600; max-width:500px; line-height:1.6; margin-bottom:.75rem; }
    .hero-sub { color:rgba(255,255,255,.65); font-size:.95rem; max-width:480px; line-height:1.7; margin-bottom:2rem; }

    .hero-actions { display:flex; gap:1rem; flex-wrap:wrap; margin-bottom:2.5rem; }
    .btn-primary { display:inline-flex; align-items:center; gap:.5rem; padding:.85rem 2rem; background:linear-gradient(135deg,var(--cyan),var(--cyan2)); color:#fff; font-weight:700; font-size:.95rem; border-radius:12px; text-decoration:none; border:none; cursor:pointer; box-shadow:0 6px 24px rgba(0,175,240,.35); transition:transform .2s,box-shadow .2s; font-family:inherit; }
    .btn-primary:hover { transform:translateY(-2px); box-shadow:0 10px 32px rgba(0,175,240,.45); }
    .btn-ghost { display:inline-flex; align-items:center; gap:.75rem; padding:.85rem 2rem; background:rgba(255,255,255,.07); border:1px solid rgba(255,255,255,.18); color:#fff; font-weight:700; font-size:.95rem; border-radius:12px; text-decoration:none; cursor:pointer; backdrop-filter:blur(8px); transition:background .2s; font-family:inherit; }
    .btn-ghost:hover { background:rgba(255,255,255,.13); }
    .play-ring { width:32px; height:32px; border-radius:50%; background:rgba(14,182,71,.2); border:1px solid rgba(14,182,71,.4); display:flex; align-items:center; justify-content:center; }

    .hero-chips { display:flex; flex-wrap:wrap; gap:.6rem; }
    .chip { display:flex; align-items:center; gap:.4rem; padding:.35rem .85rem; background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.12); border-radius:999px; font-size:.75rem; color:rgba(255,255,255,.75); font-weight:600; }
    .chip .material-symbols-outlined { font-size:15px; }

    /* ─── HERO VISUAL (original sliding cards) ─── */
    .hero-visual { position:relative; width:100%; height:700px; display:flex; justify-content:flex-start; align-items:center; overflow:hidden; mask-image:linear-gradient(to bottom,transparent 0%,black 2%,black 98%,transparent 100%); -webkit-mask-image:linear-gradient(to bottom,transparent 0%,black 2%,black 98%,transparent 100%); }
    .cards-wrap { position:relative; width:130%; height:100%; display:flex; }

    /* SVG connecting lines */
    .hero-svg { position:absolute; inset:0; width:100%; height:100%; pointer-events:none; z-index:0; transition:opacity .5s; }
    @keyframes heroPulse { from{stroke-dashoffset:400;} to{stroke-dashoffset:0;} }
    @keyframes heroPulseRev { from{stroke-dashoffset:-400;} to{stroke-dashoffset:0;} }
    .hp-base { stroke:rgba(255,255,255,.15); stroke-width:2.5; fill:none; stroke-dasharray:4 4; }
    .hp-flow { stroke:var(--cyan); stroke-width:4; fill:none; stroke-linecap:round; stroke-dasharray:40 360; animation:heroPulse 3s linear infinite; filter:drop-shadow(0 0 6px rgba(0,175,240,.5)); }
    .hp-flow-rev { stroke:var(--green); stroke-width:4; fill:none; stroke-linecap:round; stroke-dasharray:40 360; animation:heroPulseRev 3s linear infinite; filter:drop-shadow(0 0 6px rgba(14,182,71,.5)); }
    .hn { fill:#fff; stroke:var(--cyan); stroke-width:2; }
    .hn-p { fill:var(--cyan); opacity:.35; }

    /* card columns */
    .card-col { position:relative; width:50%; padding:0 1rem; height:100%; transition:transform 700ms ease-in-out; }
    .card-col-2 { transition-duration:1000ms; }

    .hcard { position:absolute; left:1rem; right:1rem; height:380px; border-radius:14px; border:1px solid; overflow:hidden; transition:all .5s; }

    /* ghost cards */
    .hcard-ghost { background:var(--navy4); border-color:rgba(255,255,255,.1); opacity:.4; padding:1.5rem; display:flex; flex-direction:column; gap:1rem; }
    .gh-row { display:flex; align-items:center; gap:.75rem; }
    .gh-av { width:40px; height:40px; border-radius:50%; background:rgba(255,255,255,.1); flex-shrink:0; }
    .gh-lines { display:flex; flex-direction:column; gap:.5rem; flex:1; }
    .gh-line { height:8px; background:rgba(255,255,255,.1); border-radius:4px; }
    .gh-box { height:96px; background:rgba(255,255,255,.05); border-radius:12px; margin-top:1rem; }
    .gh-foot { display:flex; flex-direction:column; gap:.5rem; margin-top:auto; }

    /* active white card */
    .hcard-active { background:#fff; border-color:rgba(255,255,255,.2); box-shadow:0 20px 60px rgba(0,0,0,.35); z-index:20; overflow:visible; }
    .hcard-dim { background:var(--navy4); border-color:rgba(255,255,255,.1); opacity:.6; z-index:10; transform:scale(.95); overflow:hidden; }

    /* CARD 1 content — live call */
    .card1-inner { padding:2rem; display:flex; flex-direction:column; height:100%; color:var(--navy2); }
    .card1-caller { display:flex; align-items:center; gap:.75rem; margin-bottom:1.25rem; }
    .caller-av { width:48px; height:48px; border-radius:50%; background:linear-gradient(135deg,var(--cyan),var(--green)); display:flex; align-items:center; justify-content:center; color:#fff; box-shadow:0 4px 12px rgba(0,175,240,.3); }
    .caller-av .material-symbols-outlined { font-size:1.5rem; }
    .caller-label { font-size:.6rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:var(--cyan); }
    .caller-name { font-size:1.05rem; font-weight:800; color:var(--navy2); }
    .live-pill { display:flex; align-items:center; gap:.3rem; padding:.25rem .6rem; background:rgba(34,197,94,.12); border:1px solid rgba(34,197,94,.3); border-radius:999px; font-size:.6rem; font-weight:700; color:#16a34a; animation:livefade 2s ease-in-out infinite; }
    @keyframes livefade { 0%,100%{opacity:1;} 50%{opacity:.6;} }
    .live-dot { width:5px; height:5px; border-radius:50%; background:#16a34a; }
    .card1-bubble { flex:1; background:linear-gradient(to bottom,#EBF8FF,#F0FFF4); border:1px solid rgba(0,175,240,.2); border-radius:16px; padding:1.25rem; }
    .bubble-row { display:flex; align-items:flex-start; gap:.6rem; margin-bottom:.75rem; }
    .bubble-av { width:30px; height:30px; border-radius:50%; background:rgba(0,175,240,.1); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .bubble-av .material-symbols-outlined { font-size:1rem; color:var(--cyan); }
    .bubble-text { font-size:.75rem; font-weight:700; color:var(--navy2); }
    .bubble-time { font-size:.6rem; color:#4A7B9E; font-weight:500; margin-top:2px; }
    .wave-row { display:flex; align-items:center; gap:2px; padding:.5rem 0; }
    .wb { width:3px; border-radius:999px; animation:wv 1.2s ease-in-out infinite; }
    .wb:nth-child(1){height:8px;animation-delay:0s;background:var(--cyan);}
    .wb:nth-child(2){height:14px;animation-delay:.2s;background:var(--cyan);}
    .wb:nth-child(3){height:6px;animation-delay:.4s;background:var(--cyan);}
    .wb:nth-child(4){height:18px;animation-delay:.6s;background:var(--cyan);}
    .wb:nth-child(5){height:10px;animation-delay:.0s;background:var(--cyan);}
    .wb:nth-child(6){height:16px;animation-delay:.2s;background:var(--green);}
    .wb:nth-child(7){height:8px;animation-delay:.4s;background:var(--green);}
    .wb:nth-child(8){height:20px;animation-delay:.6s;background:var(--cyan);}
    @keyframes wv { 0%,100%{transform:scaleY(.4);} 50%{transform:scaleY(1);} }
    .wave-label { font-size:.6rem; font-weight:700; color:var(--cyan); margin-left:.4rem; }
    .card1-foot { display:flex; align-items:center; gap:.5rem; margin-top:auto; padding-top:.75rem; }
    .status-dot { width:8px; height:8px; border-radius:50%; background:var(--green); animation:blink 1.8s ease-in-out infinite; }
    .status-text { font-size:.65rem; font-weight:700; color:var(--green); }
    .live-badge { position:absolute; top:-1rem; right:-2rem; background:#22c55e; border-radius:12px; padding:.35rem .8rem; display:flex; align-items:center; gap:.4rem; z-index:30; animation:blink 2s ease-in-out infinite; }
    .live-badge span { font-size:.6rem; color:#fff; font-weight:700; letter-spacing:.08em; }

    /* CARD 2 — progress check */
    .card2-inner { padding:2rem; display:flex; flex-direction:column; height:100%; }
    .card2-header { display:flex; align-items:center; gap:1rem; margin-bottom:1.5rem; }
    .card2-av-wrap { position:relative; }
    .card2-av { width:48px; height:48px; border-radius:50%; background:rgba(59,122,158,.1); display:flex; align-items:center; justify-content:center; }
    .card2-av .material-symbols-outlined { color:#3B7A9E; }
    .card2-online { position:absolute; bottom:0; right:0; width:12px; height:12px; background:#22c55e; border:2px solid #fff; border-radius:50%; animation:blink 1.8s ease-in-out infinite; }
    .card2-title-row .sub { font-size:.65rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:#2C5F8A; }
    .card2-title-row .main { font-size:1.1rem; font-weight:800; }
    .task-list { background:rgba(255,255,255,.4); border:1px solid rgba(255,255,255,.4); border-radius:12px; padding:1rem; flex:1; display:flex; flex-direction:column; gap:.6rem; margin-bottom:1rem; }
    .task-row { display:flex; align-items:center; gap:.6rem; font-size:.8rem; }
    .task-row .material-symbols-outlined { font-size:1.1rem; }
    .task-row .task-label { flex:1; font-weight:700; color:var(--navy2); }
    .task-status { font-size:.6rem; font-weight:700; }
    .ts-done { color:#22c55e; }
    .ts-prog { color:#3B7A9E; }
    .ts-over { color:#EF4444; }
    .card2-foot { display:flex; align-items:center; gap:.5rem; font-size:.7rem; font-weight:700; color:#3B7A9E; }
    .ping-dot { width:8px; height:8px; border-radius:50%; background:#3B7A9E; animation:ping2 1.5s ease-in-out infinite; }
    @keyframes ping2 { 0%,100%{opacity:1;transform:scale(1);} 50%{opacity:.3;transform:scale(1.5);} }

    /* CARD 3 — call logs */
    .card3-inner { padding:2rem; display:flex; flex-direction:column; height:100%; }
    .card3-title { font-size:1.05rem; font-weight:800; display:flex; align-items:center; gap:.5rem; margin-bottom:1rem; }
    .log-item { background:rgba(255,255,255,.6); border:1px solid #B8D8EC; border-radius:12px; padding:.75rem 1rem; display:flex; align-items:center; gap:.75rem; margin-bottom:.5rem; }
    .log-item.dim { opacity:.7; }
    .log-icon { width:32px; height:32px; border-radius:50%; background:rgba(59,122,158,.1); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .log-icon .material-symbols-outlined { font-size:1rem; color:#3B7A9E; }
    .log-label { font-size:.75rem; font-weight:700; color:var(--navy2); }
    .log-time { font-size:.6rem; color:#4A7B9E; }
    .log-badge { font-size:.6rem; font-weight:700; flex-shrink:0; }
    .lb-done { color:#22c55e; }
    .lb-miss { color:#EF4444; }
    .card3-foot { display:flex; justify-content:space-between; font-size:.6rem; font-weight:700; color:#3B7A9E; margin-top:.5rem; }
    .card3-foot .count { background:rgba(59,122,158,.1); padding:.25rem .6rem; border-radius:999px; }

    /* RIGHT column cards */
    .card-r1 { padding:2rem; display:flex; flex-direction:column; height:100%; }
    .sched-header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1.5rem; }
    .sched-label { font-size:.65rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:#2C5F8A; }
    .sched-num { font-size:1.6rem; font-weight:900; color:var(--navy2); }
    .sched-pct { font-size:1.05rem; font-weight:800; color:#3B7A9E; }
    .task-items { flex:1; display:flex; flex-direction:column; gap:.5rem; }
    .ti { display:flex; align-items:center; gap:.6rem; background:#E8F4FC; padding:.65rem .85rem; border-radius:12px; border:1px solid #B8D8EC; }
    .ti .material-symbols-outlined { font-size:1.1rem; flex-shrink:0; }
    .ti-text .ti-name { font-size:.8rem; font-weight:700; color:var(--navy2); }
    .ti-text .ti-meta { font-size:.6rem; color:#4A7B9E; }
    .ti.dim { opacity:.6; background:transparent; border:none; }
    .sched-foot { border-top:1px solid #B8D8EC; padding-top:.75rem; display:flex; justify-content:space-between; font-size:.65rem; font-weight:700; color:#4A7B9E; margin-top:auto; }

    /* card r2 — daily report */
    .rpt-inner { padding:2rem; display:flex; flex-direction:column; height:100%; }
    .rpt-title { font-size:1.1rem; font-weight:800; display:flex; align-items:center; gap:.5rem; margin-bottom:1rem; }
    .rpt-box { background:rgba(255,255,255,.4); border:1px solid rgba(255,255,255,.4); border-radius:16px; padding:1rem; margin-bottom:.75rem; }
    .rpt-row { display:flex; justify-content:space-between; align-items:center; margin-bottom:.5rem; }
    .rpt-row .rl { font-size:.65rem; font-weight:700; color:#2C5F8A; }
    .rpt-row .rv { font-size:1.1rem; font-weight:900; color:#22c55e; }
    .progress-bar { height:8px; background:#B8D8EC; border-radius:4px; overflow:hidden; margin-bottom:.5rem; }
    .progress-fill { height:100%; width:60%; background:#22c55e; border-radius:4px; }
    .rpt-meta { display:flex; justify-content:space-between; font-size:.6rem; color:#4A7B9E; }
    .rpt-preview { background:rgba(255,255,255,.3); border:1px solid rgba(255,255,255,.4); border-radius:12px; padding:.75rem; margin-bottom:.75rem; }
    .rpt-preview .rp-label { font-size:.65rem; font-weight:700; color:var(--navy2); margin-bottom:.3rem; }
    .rpt-preview .rp-text { font-size:.7rem; color:#4A7B9E; font-style:italic; }
    .rpt-btn { background:#3B7A9E; color:#fff; border:none; border-radius:12px; padding:.75rem; font-size:.65rem; font-weight:700; cursor:pointer; letter-spacing:.05em; text-align:center; }

    /* card r3 — stats */
    .stats-inner-card { padding:2rem; display:flex; flex-direction:column; height:100%; }
    .stats-grid { display:grid; grid-template-columns:1fr 1fr; gap:.75rem; flex:1; }
    .stat-box { background:rgba(255,255,255,.6); border:1px solid #B8D8EC; border-radius:12px; padding:1rem; text-align:center; }
    .stat-box .sn { font-size:1.5rem; font-weight:900; color:var(--navy2); font-family:'Nunito',sans-serif; }
    .stat-box .sl { font-size:.6rem; font-weight:700; color:#4A7B9E; margin-top:.2rem; }
    .stat-box .sn.green { color:#22c55e; }
    .stat-box .sn.blue { color:#3B7A9E; }
    .procrastination { background:rgba(59,122,158,.05); border:1px solid rgba(59,122,158,.2); border-radius:12px; padding:.75rem; text-align:center; font-size:.65rem; font-weight:700; color:#3B7A9E; letter-spacing:.05em; margin-top:.75rem; }

    /* ─── STATS BAR ─── */
    .stats-bar { background:linear-gradient(90deg,var(--navy) 0%,#001432 50%,var(--navy) 100%); border-top:1px solid rgba(255,255,255,.05); border-bottom:1px solid rgba(255,255,255,.05); padding:2rem; }
    .sb-inner { max-width:1280px; margin:0 auto; display:flex; justify-content:space-around; flex-wrap:wrap; gap:1.5rem; }
    .sb-item { text-align:center; }
    .sb-num { font-family:'Nunito',sans-serif; font-size:1.6rem; font-weight:900; color:#fff; letter-spacing:-.03em; }
    .sb-label { font-size:.7rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:var(--cyan); margin-top:.2rem; }

    /* ─── SECTION COMMONS ─── */
    .section { padding:7rem 2rem; overflow-x:hidden; }
    .sec-inner { max-width:1280px; margin:0 auto; }
    .eyebrow { display:inline-flex; align-items:center; gap:.5rem; padding:.35rem .9rem; background:#fff; border:1px solid var(--s3); border-radius:8px; font-size:.7rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:var(--cyan); margin-bottom:1.5rem; box-shadow:0 1px 4px rgba(0,0,0,.06); }
    .eyebrow .material-symbols-outlined { font-size:16px; }
    .eyebrow-dark { background:rgba(255,255,255,.07); border-color:rgba(255,255,255,.12); color:var(--cyan); }
    .sec-h2 { font-family:'Nunito',sans-serif; font-size:clamp(2rem,4vw,3rem); font-weight:900; letter-spacing:-.04em; color:var(--s9); margin-bottom:1rem; }
    .sec-h2 span { color:var(--cyan); }
    .sec-h2.light { color:#fff; }
    .sec-sub { font-size:1.05rem; color:var(--s6); line-height:1.7; max-width:640px; }
    .sec-sub.cx { margin:0 auto; }
    .tc { text-align:center; }
    .mb12 { margin-bottom:3rem; }
    .mb16 { margin-bottom:4rem; }
    .mb20 { margin-bottom:5rem; }

    /* ─── HOW IT WORKS ─── */
    .how-bg { background:linear-gradient(160deg,#f8fafc 0%,#f0f9ff 50%,#f5f3ff 100%); }
    .steps-row { display:grid; grid-template-columns:repeat(4,1fr); gap:1.5rem; }
    .step-card { background:#fff; border:1px solid var(--s3); border-radius:20px; padding:2rem 1.5rem; display:flex; flex-direction:column; align-items:center; text-align:center; transition:border-color .3s,box-shadow .3s,transform .3s; }
    .step-card:hover { box-shadow:0 12px 40px rgba(0,0,0,.08); transform:translateY(-4px); }
    .step-icon { width:72px; height:72px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:1.25rem; }
    .step-icon .material-symbols-outlined { font-size:2.2rem; }
    .step-num { font-size:.65rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; padding:.25rem .7rem; border-radius:999px; margin-bottom:.85rem; }
    .step-title { font-size:1rem; font-weight:800; color:var(--s9); margin-bottom:.75rem; }
    .step-desc { font-size:.85rem; color:var(--s6); line-height:1.65; }
    .s1 .step-icon{background:#EFF9FF;color:var(--cyan);} .s1:hover{border-color:rgba(0,175,240,.3);} .s1 .step-num{background:rgba(0,175,240,.1);color:var(--cyan);}
    .s2 .step-icon{background:#F0FDF4;color:var(--green);} .s2:hover{border-color:rgba(14,182,71,.3);} .s2 .step-num{background:rgba(14,182,71,.1);color:var(--green);}
    .s3 .step-icon{background:#FAF5FF;color:var(--purple);} .s3:hover{border-color:rgba(124,58,237,.3);} .s3 .step-num{background:rgba(124,58,237,.1);color:var(--purple);}
    .s4 .step-icon{background:#FFF7ED;color:var(--orange);} .s4:hover{border-color:rgba(234,88,12,.3);} .s4 .step-num{background:rgba(234,88,12,.1);color:var(--orange);}

    /* ─── VS SECTION ─── */
    .vs-bg { background:#fff; }
    .ba-grid { display:grid; grid-template-columns:1fr 1fr; gap:1.5rem; max-width:900px; margin:0 auto 4rem; }
    .ba-card { border-radius:20px; padding:2rem; }
    .ba-before { background:var(--s1); border:1px solid var(--s3); }
    .ba-after { background:#EFF9FF; border:1px solid rgba(0,175,240,.2); box-shadow:0 8px 32px rgba(0,175,240,.08); }
    .ba-head { display:flex; align-items:center; gap:.85rem; margin-bottom:1.5rem; }
    .ba-ico { width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center; }
    .ba-before .ba-ico { background:#FEE2E2; color:#EF4444; }
    .ba-after .ba-ico { background:var(--cyan); color:#fff; }
    .ba-title { font-size:1rem; font-weight:800; }
    .ba-list { list-style:none; }
    .ba-list li { display:flex; align-items:flex-start; gap:.7rem; padding:.6rem 0; font-size:.875rem; border-bottom:1px solid rgba(0,0,0,.05); color:var(--s7); }
    .ba-list li:last-child { border:none; }
    .ba-list .material-symbols-outlined { margin-top:2px; flex-shrink:0; }

    /* ─── AI FEATURES GRID ─── */
    .feat-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:1.25rem; }
    .feat-card { background:#fff; border:1px solid var(--s2); border-radius:18px; padding:1.75rem 1.5rem; display:flex; flex-direction:column; align-items:center; text-align:center; box-shadow:0 1px 6px rgba(0,0,0,.04); transition:border-color .3s,box-shadow .3s,transform .3s; }
    .feat-card:hover { transform:translateY(-3px); box-shadow:0 8px 28px rgba(0,0,0,.08); }
    .feat-ico { width:52px; height:52px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:1rem; }
    .feat-ico .material-symbols-outlined { font-size:1.5rem; }
    .feat-title { font-size:.9rem; font-weight:800; color:var(--s9); margin-bottom:.5rem; }
    .feat-desc { font-size:.8rem; color:var(--s6); line-height:1.6; }
    .fc1 .feat-ico{background:rgba(0,175,240,.1);color:var(--cyan);} .fc1:hover{border-color:rgba(0,175,240,.3);}
    .fc2 .feat-ico{background:rgba(14,182,71,.1);color:var(--green);} .fc2:hover{border-color:rgba(14,182,71,.3);}
    .fc3 .feat-ico{background:rgba(124,58,237,.1);color:var(--purple);} .fc3:hover{border-color:rgba(124,58,237,.3);}
    .fc4 .feat-ico{background:rgba(234,88,12,.1);color:var(--orange);} .fc4:hover{border-color:rgba(234,88,12,.3);}

    /* ─── AI MANAGER SECTION (dark) ─── */
    .ai-mgr-bg { background:var(--navy); position:relative; overflow:hidden; }
    .ai-mgr-bg::before { content:''; position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); width:800px; height:800px; background:radial-gradient(circle,rgba(0,175,240,.07),transparent 70%); pointer-events:none; }
    .ai-mgr-grid { display:grid; grid-template-columns:1fr 1fr; gap:4rem; align-items:center; }
    .ai-mgr-text h3 { font-family:'Nunito',sans-serif; font-size:clamp(1.6rem,3vw,2.4rem); font-weight:900; color:#fff; letter-spacing:-.04em; margin-bottom:1rem; }
    .ai-mgr-text h3 span { color:var(--cyan); }
    .ai-mgr-text p { font-size:.95rem; color:rgba(255,255,255,.65); line-height:1.75; margin-bottom:1rem; }
    .ai-mgr-bullets { display:flex; flex-direction:column; gap:.75rem; margin-top:1.5rem; }
    .ai-bullet { display:flex; align-items:flex-start; gap:.75rem; font-size:.875rem; color:rgba(255,255,255,.75); }
    .ai-bullet-icon { width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-top:1px; }
    .ai-bullet-icon .material-symbols-outlined { font-size:1rem; }
    .bi-cyan { background:rgba(0,175,240,.15); color:var(--cyan); }
    .bi-green { background:rgba(14,182,71,.15); color:var(--green); }
    .bi-purple { background:rgba(124,58,237,.15); color:var(--purple); }
    .bi-orange { background:rgba(234,88,12,.15); color:var(--orange); }

    /* ─── CALL UI REPLACING CONVO-CARD ─── */
    .call-card { background:linear-gradient(180deg, rgba(26,37,58,0.95), rgba(11,20,38,0.98)); border:1px solid rgba(255,255,255,.08); border-radius:24px; padding:2rem; position:relative; overflow:hidden; display:flex; flex-direction:column; align-items:center; box-shadow:0 24px 48px rgba(0,0,0,0.4); }
    .call-header { width:100%; display:flex; justify-content:space-between; align-items:center; margin-bottom:2.5rem; }
    .call-status { display:flex; align-items:center; gap:6px; font-size:0.75rem; font-weight:800; color:var(--green); background:rgba(14,182,71,.15); border:1px solid rgba(14,182,71,.3); padding:4px 12px; border-radius:999px; letter-spacing:.05em; text-transform:uppercase; }
    .call-status .live-dot { width:6px; height:6px; border-radius:50%; background:var(--green); animation:blink 1.5s infinite; }
    .call-time { font-size:0.9rem; font-weight:800; color:rgba(255,255,255,.7); font-variant-numeric: tabular-nums; letter-spacing:.05em; }

    .call-center { display:flex; flex-direction:column; align-items:center; margin-bottom:2.5rem; }
    .call-avatar-wrapper { position:relative; width:100px; height:100px; display:flex; align-items:center; justify-content:center; margin-bottom:1.5rem; }
    .call-avatar { position:relative; z-index:2; width:84px; height:84px; border-radius:50%; background:linear-gradient(135deg,var(--cyan),var(--green)); display:flex; align-items:center; justify-content:center; box-shadow:0 0 24px rgba(0,175,240,.5); }
    .call-avatar .material-symbols-outlined { font-size:2.8rem; color:#fff; }
    .pulse-ring { position:absolute; inset:0; border-radius:50%; background:rgba(0,175,240,.25); animation:callPulse 2.5s cubic-bezier(0.215, 0.61, 0.355, 1) infinite; }
    .pr2 { animation-delay: 1.25s; }
    @keyframes callPulse { 0% { transform:scale(0.8); opacity:1; } 100% { transform:scale(2.2); opacity:0; } }

    .call-name { font-size:1.4rem; font-weight:900; color:#fff; margin-bottom:0.25rem; }
    .call-role { font-size:0.85rem; color:rgba(255,255,255,.5); font-weight:600; }

    .call-waveform { display:flex; align-items:center; gap:5px; height:48px; margin-bottom:2.5rem; }
    .wave-bar { width:5px; border-radius:999px; background:var(--cyan); animation:waveBounce 1s ease-in-out infinite alternate; }
    .wave-bar:nth-child(1) { height:16px; animation-delay:0.0s; }
    .wave-bar:nth-child(2) { height:32px; animation-delay:0.1s; }
    .wave-bar:nth-child(3) { height:48px; animation-delay:0.2s; background:var(--green); }
    .wave-bar:nth-child(4) { height:24px; animation-delay:0.3s; background:var(--green); }
    .wave-bar:nth-child(5) { height:40px; animation-delay:0.4s; }
    .wave-bar:nth-child(6) { height:28px; animation-delay:0.5s; background:var(--cyan); }
    .wave-bar:nth-child(7) { height:16px; animation-delay:0.6s; }
    @keyframes waveBounce { 0% { transform:scaleY(0.2); opacity:0.5; } 100% { transform:scaleY(1); opacity:1; } }

    .call-transcript { width:100%; background:rgba(255,255,255,.05); border-radius:16px; padding:1.25rem; height:84px; overflow:hidden; position:relative; margin-bottom:2rem; border:1px solid rgba(255,255,255,.08); }
    .transcript-line { position:absolute; width:calc(100% - 2.5rem); text-align:center; font-size:0.9rem; line-height:1.5; font-weight:700; color:rgba(255,255,255,.9); opacity:0; transform:translateY(15px); animation:transcriptCycle 12s infinite; }
    .tl-1 { animation-delay:0s; }
    .tl-2 { animation-delay:4s; color:var(--cyan); }
    .tl-3 { animation-delay:8s; }
    @keyframes transcriptCycle {
      0%, 5% { opacity:0; transform:translateY(15px); }
      10%, 25% { opacity:1; transform:translateY(0); }
      30%, 100% { opacity:0; transform:translateY(-15px); }
    }

    .call-controls { display:flex; gap:1.5rem; align-items:center; }
    .cc-btn { width:52px; height:52px; border-radius:50%; background:rgba(255,255,255,.1); display:flex; align-items:center; justify-content:center; color:#fff; cursor:pointer; transition:background .2s, transform .2s; border:1px solid rgba(255,255,255,.15); }
    .cc-btn:hover { background:rgba(255,255,255,.2); transform:scale(1.05); }
    .cc-btn .material-symbols-outlined { font-size:1.5rem; }
    .cc-btn.end-call { background:#EF4444; box-shadow:0 8px 24px rgba(239,68,68,.3); border:none; width:60px; height:60px; }
    .cc-btn.end-call .material-symbols-outlined { font-size:2rem; }
    .cc-btn.end-call:hover { background:#DC2626; }

    /* ─── PERFORMANCE WATCH ─── */
    .pw-section { background:var(--s1); border-top:1px solid var(--s3); border-bottom:1px solid var(--s3); }
    .pw-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:1.5rem; }
    .pw-card { background:#fff; border:1px solid var(--s3); border-radius:20px; padding:2rem; transition:border-color .3s,box-shadow .3s; }
    .pw-card:hover { border-color:rgba(0,175,240,.2); box-shadow:0 8px 28px rgba(0,0,0,.06); }
    .pw-ico-wrap { width:52px; height:52px; border-radius:14px; display:flex; align-items:center; justify-content:center; margin-bottom:1.25rem; }
    .pw-ico-wrap .material-symbols-outlined { font-size:1.5rem; }
    .pw-icon-c { background:rgba(0,175,240,.1); color:var(--cyan); }
    .pw-icon-g { background:rgba(14,182,71,.1); color:var(--green); }
    .pw-icon-p { background:rgba(124,58,237,.1); color:var(--purple); }
    .pw-title { font-size:1rem; font-weight:800; color:var(--s9); margin-bottom:.6rem; }
    .pw-desc { font-size:.875rem; color:var(--s6); line-height:1.65; }

    .watch-flow { display:grid; grid-template-columns:1fr auto 1fr auto 1fr; gap:1rem; align-items:center; margin-top:3rem; }
    .wf-item { background:#fff; border:1px solid var(--s3); border-radius:16px; padding:1.5rem; text-align:center; }
    .wf-num { font-family:'Nunito',sans-serif; font-size:1.5rem; font-weight:900; margin-bottom:.4rem; }
    .wf-label { font-size:.75rem; font-weight:700; color:var(--s6); }
    .wf-arrow { color:var(--s4); font-size:1.5rem; text-align:center; }
    .wf1 { color:var(--cyan); }
    .wf2 { color:var(--purple); }
    .wf3 { color:var(--green); }

    /* ─── Exec View (dark) ─── */
    .exec-bg { background:var(--navy2); }
    .exec-tiers { display:grid; grid-template-columns:repeat(3,1fr); gap:1.5rem; margin-bottom:4rem; }
    .exec-tier { border-radius:20px; padding:2rem; border:1px solid; }
    .et1 { background:rgba(0,175,240,.06); border-color:rgba(0,175,240,.2); }
    .et2 { background:rgba(14,182,71,.06); border-color:rgba(14,182,71,.2); }
    .et3 { background:rgba(124,58,237,.06); border-color:rgba(124,58,237,.2); }
    .tier-header { display:flex; align-items:center; gap:.75rem; margin-bottom:1rem; }
    .tier-icon { width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; }
    .ti-c { background:rgba(0,175,240,.2); color:var(--cyan); }
    .ti-g { background:rgba(14,182,71,.2); color:var(--green); }
    .ti-p { background:rgba(124,58,237,.2); color:var(--purple); }
    .tier-title { font-size:.9rem; font-weight:800; color:#fff; }
    .tier-sub { font-size:.65rem; color:rgba(255,255,255,.5); margin-top:.1rem; }
    .tier-list { list-style:none; }
    .tier-list li { padding:.45rem 0; font-size:.82rem; color:rgba(255,255,255,.65); border-bottom:1px solid rgba(255,255,255,.06); display:flex; align-items:center; gap:.5rem; }
    .tier-list li:last-child { border:none; }
    .tier-list .material-symbols-outlined { font-size:.9rem; flex-shrink:0; }

    .exec-metrics { display:grid; grid-template-columns:repeat(2,1fr); gap:1.5rem; }
    .exec-metric { background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.08); border-radius:16px; padding:1.75rem; }
    .em-label { font-size:.65rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:rgba(255,255,255,.4); margin-bottom:.5rem; }
    .em-title { font-size:1rem; font-weight:800; color:#fff; margin-bottom:.5rem; }
    .em-desc { font-size:.85rem; color:rgba(255,255,255,.55); line-height:1.6; }

    /* ─── INTEGRATIONS ─── */
    .int-section { background:#fff; }
    .int-categories { display:grid; grid-template-columns:repeat(3,1fr); gap:1.5rem; margin-bottom:3rem; }
    .int-cat { background:var(--s1); border:1px solid var(--s3); border-radius:18px; padding:1.75rem; }
    .int-cat-title { font-size:.75rem; font-weight:800; letter-spacing:.1em; text-transform:uppercase; color:var(--s6); margin-bottom:1rem; }
    .int-logos-row { display:flex; flex-wrap:wrap; gap:.65rem; }
    .int-chip { display:flex; align-items:center; gap:.5rem; padding:.4rem .8rem; background:#fff; border:1px solid var(--s3); border-radius:999px; font-size:.8rem; font-weight:700; color:var(--s7); }
    .int-chip img { width:18px; height:18px; }
    .int-chip .material-symbols-outlined { font-size:1rem; }

    /* ─── RETRO ─── */
    .retro-section { background:linear-gradient(160deg,#f8fafc,#f0f9ff); }
    .retro-grid { display:grid; grid-template-columns:1fr 1fr; gap:4rem; align-items:center; }
    .retro-items { display:flex; flex-direction:column; gap:1rem; }
    .retro-item { display:flex; align-items:flex-start; gap:1rem; padding:1.25rem; background:#fff; border:1px solid var(--s3); border-radius:16px; transition:border-color .3s,box-shadow .3s; }
    .retro-item:hover { border-color:rgba(0,175,240,.25); box-shadow:0 6px 20px rgba(0,0,0,.06); }
    .retro-icon { width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .retro-icon .material-symbols-outlined { font-size:1.2rem; }
    .ri-c { background:rgba(0,175,240,.1); color:var(--cyan); }
    .ri-g { background:rgba(14,182,71,.1); color:var(--green); }
    .ri-p { background:rgba(124,58,237,.1); color:var(--purple); }
    .ri-o { background:rgba(234,88,12,.1); color:var(--orange); }
    .retro-content h4 { font-size:.9rem; font-weight:800; color:var(--s9); margin-bottom:.3rem; }
    .retro-content p { font-size:.82rem; color:var(--s6); line-height:1.6; }

    /* ─── ROLES ─── */
    .roles-section { background:var(--s9); }
    .roles-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; }
    .role-card { background:rgba(255,255,255,.05); border:1px solid rgba(255,255,255,.08); border-radius:16px; padding:1.5rem; transition:background .3s,border-color .3s; }
    .role-card:hover { background:rgba(255,255,255,.08); border-color:rgba(255,255,255,.15); }
    .role-badge { display:inline-block; padding:.2rem .65rem; border-radius:999px; font-size:.65rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; margin-bottom:.85rem; }
    .rb-c { background:rgba(0,175,240,.15); color:var(--cyan); }
    .rb-g { background:rgba(14,182,71,.15); color:var(--green); }
    .rb-p { background:rgba(124,58,237,.15); color:var(--purple); }
    .rb-o { background:rgba(234,88,12,.15); color:var(--orange); }
    .rb-y { background:rgba(251,191,36,.15); color:#FBBF24; }
    .rb-s { background:rgba(148,163,184,.15); color:var(--s5); }
    .role-title { font-size:.95rem; font-weight:800; color:#fff; margin-bottom:.5rem; }
    .role-desc { font-size:.8rem; color:rgba(255,255,255,.55); line-height:1.6; }

    /* ─── VOICE / VOIP ─── */
    .voip-bg { background:var(--navy); }
    .voip-steps { display:grid; grid-template-columns:repeat(4,1fr); gap:1.5rem; }
    .voip-card { background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.08); border-radius:20px; padding:2rem 1.5rem; display:flex; flex-direction:column; align-items:center; text-align:center; transition:border-color .3s,background .3s; }
    .voip-card:hover { background:rgba(255,255,255,.07); border-color:rgba(0,175,240,.25); }
    .voip-card.feat { background:rgba(0,175,240,.08); border-color:rgba(0,175,240,.25); box-shadow:0 0 40px rgba(0,175,240,.1); }
    .voip-icon { width:72px; height:72px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:1.25rem; }
    .voip-icon .material-symbols-outlined { font-size:2rem; }
    .vi1{background:rgba(0,175,240,.15);color:var(--cyan);}
    .vi2{background:var(--green);color:#fff;box-shadow:0 0 0 4px rgba(14,182,71,.15);}
    .vi3{background:rgba(124,58,237,.15);color:var(--purple);}
    .vi4{background:rgba(234,88,12,.15);color:var(--orange);}
    .voip-title { font-size:1rem; font-weight:800; color:#fff; margin-bottom:.75rem; }
    .voip-desc { font-size:.85rem; color:rgba(255,255,255,.55); line-height:1.65; }

    /* US banner */
    .us-banner { margin-top:4rem; padding:2rem; border-radius:20px; background:#EFF9FF; border:1px solid rgba(0,175,240,.2); display:flex; align-items:center; gap:2rem; }
    .us-ico { width:56px; height:56px; border-radius:50%; background:rgba(0,175,240,.1); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .us-ico .material-symbols-outlined { font-size:2rem; color:var(--cyan); }
    .us-text h4 { font-size:1rem; font-weight:800; color:var(--s9); margin-bottom:.3rem; }
    .us-text p { font-size:.9rem; color:var(--s6); line-height:1.6; }
    .us-badge { margin-left:auto; white-space:nowrap; padding:.6rem 1.2rem; background:rgba(0,175,240,.1); border:1px solid rgba(0,175,240,.25); color:var(--cyan); font-size:.8rem; font-weight:700; border-radius:12px; }

    /* ─── MOBILE APP ─── */
    .mobile-bg { background:linear-gradient(160deg,#f8fafc,#f0f9ff); }
    .mobile-grid { display:grid; grid-template-columns:1fr 1fr; gap:4rem; align-items:center; }
    .mobile-content h2 { font-family:'Nunito',sans-serif; font-size:clamp(2rem,4vw,3rem); font-weight:900; letter-spacing:-.04em; color:var(--s9); margin-bottom:1rem; }
    .mobile-content h2 span { color:var(--cyan); }
    .mobile-content p { font-size:1.05rem; color:var(--s6); line-height:1.7; margin-bottom:1.5rem; max-width:500px; }
    .mobile-dl-btn { display:inline-flex; align-items:center; gap:.5rem; padding:.85rem 2rem; background:linear-gradient(135deg,var(--cyan),var(--cyan2)); color:#fff; font-weight:700; font-size:.95rem; border-radius:12px; text-decoration:none; border:none; cursor:pointer; box-shadow:0 6px 24px rgba(0,175,240,.35); transition:transform .2s,box-shadow .2s; font-family:inherit; }
    .mobile-dl-btn:hover { transform:translateY(-2px); box-shadow:0 10px 32px rgba(0,175,240,.45); }
    .mobile-infographic { display:flex; flex-direction:column; align-items:center; gap:1.5rem; }
    .phone-frame { position:relative; width:260px; height:500px; flex-shrink:0; }
    .phone-frame-inner { position:absolute; inset:0; background:var(--navy); border-radius:2.8rem; border:4px solid rgba(255,255,255,.15); box-shadow:0 24px 60px rgba(0,0,0,.25); overflow:hidden; }
    .phone-notch { position:absolute; top:0; left:50%; transform:translateX(-50%); width:90px; height:22px; background:var(--navy); border-radius:0 0 10px 10px; z-index:10; }
    .phone-screen { position:absolute; inset:6px; background:#fff; border-radius:2.4rem; overflow:hidden; display:flex; flex-direction:column; }
    .phone-hd { background:var(--navy); padding:1.25rem 1rem .75rem; }
    .phone-brand { display:flex; align-items:center; gap:.35rem; margin-bottom:.5rem; }
    .phone-brand-dot { width:18px; height:18px; border-radius:50%; background:var(--cyan); display:flex; align-items:center; justify-content:center; }
    .phone-brand-dot span { color:#fff; font-size:8px; font-weight:900; }
    .phone-brand-text { color:#fff; font-size:8px; font-weight:700; letter-spacing:-.02em; }
    .phone-greeting { color:#fff; font-size:1rem; font-weight:900; }
    .phone-sub { color:rgba(255,255,255,.6); font-size:9px; }
    .phone-body { flex:1; background:#E8F4FC; padding:.65rem; display:flex; flex-direction:column; gap:.45rem; }
    .phone-card { background:#fff; border:1px solid #B8D8EC; border-radius:10px; padding:.5rem .65rem; display:flex; align-items:center; gap:.45rem; box-shadow:0 1px 4px rgba(0,0,0,.04); }
    .phone-ci { width:24px; height:24px; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .phone-ci .material-symbols-outlined { font-size:12px; }
    .pci-call { background:rgba(0,175,240,.1); color:var(--cyan); }
    .pci-done { background:rgba(14,182,71,.1); color:var(--green); }
    .pci-miss { background:rgba(239,68,68,.1); color:#EF4444; }
    .phone-ct { flex:1; }
    .phone-ct-title { font-size:8px; font-weight:700; color:var(--navy2); }
    .phone-ct-meta { font-size:7px; color:#4A7B9E; }
    .phone-cs { font-size:7px; font-weight:700; }
    .pcs-done { color:#22c55e; }
    .pcs-miss { color:#EF4444; }
    .pcs-prog { color:var(--cyan); }
    .phone-pulse { width:5px; height:5px; border-radius:50%; background:#22c55e; animation:blink 1.8s infinite; flex-shrink:0; }
    .phone-nav { display:flex; justify-content:space-around; padding:.35rem .75rem; background:#fff; border-top:1px solid #B8D8EC; }
    .phone-nav .material-symbols-outlined { font-size:14px; }
    .phone-glow { position:absolute; inset:-16px; background:radial-gradient(circle,rgba(0,175,240,.1),transparent 70%); border-radius:4rem; filter:blur(24px); z-index:-1; }
    .mobile-features { display:grid; grid-template-columns:1fr 1fr; gap:.75rem; margin-top:1.5rem; width:100%; max-width:420px; }
    .mobile-feat { display:flex; align-items:flex-start; gap:.65rem; padding:.75rem 1rem; background:#fff; border:1px solid var(--s3); border-radius:12px; }
    .mobile-feat .material-symbols-outlined { font-size:1.2rem; flex-shrink:0; }
    .mobile-feat-text h4 { font-size:.75rem; font-weight:800; color:var(--s9); margin-bottom:.15rem; }
    .mobile-feat-text p { font-size:.68rem; color:var(--s6); line-height:1.5; margin:0; max-width:none; }
    .mfc1 { color:var(--cyan); }
    .mfc2 { color:var(--green); }
    .mfc3 { color:var(--purple); }
    .mfc4 { color:var(--orange); }

    @media(max-width:1024px) {
      .mobile-grid { grid-template-columns:1fr; }
      .mobile-infographic { order:-1; }
    }
    @media(max-width:640px) {
      .mobile-features { grid-template-columns:1fr; }
      .phone-frame { width:220px; height:440px; }
    }

    /* ─── FAQ ─── */
    .faq-bg { background:var(--s1); }
    .faq-list { max-width:760px; margin:0 auto; }
    .faq-item { border:1px solid var(--s3); border-radius:14px; overflow:hidden; margin-bottom:.75rem; background:#fff; box-shadow:0 1px 4px rgba(0,0,0,.04); }
    .faq-q { width:100%; padding:1.4rem 1.75rem; display:flex; align-items:center; justify-content:space-between; background:none; border:none; cursor:pointer; text-align:left; font-size:1rem; font-weight:700; color:var(--s9); font-family:'Nunito',sans-serif; }
    .faq-q .material-symbols-outlined { color:var(--cyan); transition:transform .3s; flex-shrink:0; }
    .faq-q.open .material-symbols-outlined { transform:rotate(45deg); }
    .faq-a { padding:0 1.75rem 1.4rem; font-size:.9rem; color:var(--s6); line-height:1.7; display:none; }
    .faq-a.open { display:block; }

    /* ─── CTA ─── */
    .cta-bg { background:var(--navy); text-align:center; position:relative; overflow:hidden; }
    .cta-bg::before { content:''; position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); width:600px; height:600px; background:radial-gradient(circle,rgba(0,175,240,.12),transparent 70%); pointer-events:none; }
    .cta-inner { position:relative; z-index:1; }
    .cta-h2 { font-family:'Nunito',sans-serif; font-size:clamp(2rem,4vw,3.25rem); font-weight:900; color:#fff; letter-spacing:-.04em; margin-bottom:1rem; }
    .cta-h2 span { color:var(--cyan); }
    .cta-sub { font-size:1.05rem; color:rgba(255,255,255,.6); margin-bottom:2.5rem; }
    .cta-actions { display:flex; gap:1rem; justify-content:center; flex-wrap:wrap; }

    /* ─── FOOTER ─── */
    footer { background:var(--navy2); color:rgba(255,255,255,.85); border-top:1px solid rgba(255,255,255,.08); padding:4rem 2rem 2rem; }
    .footer-inner { max-width:1280px; margin:0 auto; }
    .footer-grid { display:grid; grid-template-columns:2fr 1fr 1fr 1fr 1fr; gap:2rem; margin-bottom:3rem; }
    .footer-grid > div > p { color:rgba(255,255,255,.7); line-height:1.7; max-width:280px; }
    .footer-brand-name { display:block; margin-bottom:1rem; text-decoration:none; }
    .footer-brand-name img { height:100px; width:auto; display:block; }
    @media(max-width:640px) { .footer-brand-name img { height:70px; } }
    .footer-social { display:flex; gap:.75rem; margin-top:1rem; }
    .footer-social a { width:36px; height:36px; border-radius:8px; border:1px solid rgba(255,255,255,.15); display:flex; align-items:center; justify-content:center; color:rgba(255,255,255,.6); text-decoration:none; font-size:1rem; transition:border-color .2s,color .2s; }
    .footer-social a:hover { border-color:var(--cyan); color:var(--cyan); }
    .footer-col h5 { font-size:.7rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:rgba(255,255,255,.7); margin-bottom:1rem; }
    .footer-col ul { list-style:none; }
    .footer-col ul li { margin-bottom:.6rem; }
    .footer-col ul li a { font-size:.875rem; color:rgba(255,255,255,.85); text-decoration:none; transition:color .2s; }
    .footer-col ul li a:hover { color:var(--cyan); }
    .footer-bottom { border-top:1px solid rgba(255,255,255,.07); padding-top:1.5rem; display:flex; justify-content:space-between; align-items:center; font-size:.8rem; color:rgba(255,255,255,.7); }
    .footer-bottom a { color:rgba(255,255,255,.85); text-decoration:none; }
    .footer-bottom a:hover { color:var(--cyan); }

    /* ─── MODAL ─── */
    .modal-overlay { position:fixed; inset:0; z-index:200; background:rgba(5,14,30,.7); backdrop-filter:blur(8px); display:none; align-items:center; justify-content:center; padding:1rem; }
    .modal-overlay.open { display:flex; }
    .modal { background:#fff; border-radius:24px; padding:3rem; max-width:480px; width:100%; position:relative; box-shadow:0 40px 80px rgba(0,0,0,.3); animation:modal-in .3s ease; }
    @keyframes modal-in { from{opacity:0;transform:scale(.96) translateY(8px);} to{opacity:1;transform:none;} }
    .modal-close { position:absolute; top:1.25rem; right:1.25rem; background:var(--s2); border:none; border-radius:8px; cursor:pointer; width:36px; height:36px; display:flex; align-items:center; justify-content:center; color:var(--s6); transition:background .2s; }
    .modal-close:hover { background:var(--s3); }
    .modal-icon { width:60px; height:60px; border-radius:16px; background:rgba(0,175,240,.1); display:flex; align-items:center; justify-content:center; margin-bottom:1.5rem; }
    .modal-icon .material-symbols-outlined { font-size:1.75rem; color:var(--cyan); }
    .modal h3 { font-size:1.6rem; font-weight:900; color:var(--s9); margin-bottom:.5rem; font-family:'Nunito',sans-serif; letter-spacing:-.03em; }
    .modal p { font-size:.9rem; color:var(--s6); line-height:1.6; margin-bottom:1.5rem; }
    .modal input[type=email] { width:100%; padding:.85rem 1.1rem; background:var(--s1); border:1px solid var(--s3); border-radius:12px; font-size:.95rem; font-family:inherit; color:var(--s9); margin-bottom:1rem; outline:none; transition:border-color .2s,box-shadow .2s; }
    .modal input[type=email]:focus { border-color:var(--cyan); box-shadow:0 0 0 3px rgba(0,175,240,.1); }
    .modal-submit { width:100%; padding:.9rem; background:var(--cyan); color:#fff; font-weight:700; font-size:.95rem; border:none; border-radius:12px; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:.5rem; font-family:inherit; transition:background .2s,transform .15s; box-shadow:0 4px 16px rgba(0,175,240,.3); }
    .modal-submit:hover { background:var(--cyan2); transform:translateY(-1px); }
    .success-state { text-align:center; padding:2rem 0; display:none; }
    .success-icon { width:72px; height:72px; border-radius:50%; background:#DCFCE7; display:flex; align-items:center; justify-content:center; margin:0 auto 1.5rem; }
    .success-icon .material-symbols-outlined { font-size:2.2rem; color:var(--green); }

    /* ─── RESPONSIVE ─── */
    @media(max-width:1024px) {
      .hero-inner { grid-template-columns:1fr; }
      .hero-visual { display:none; }
      .steps-row,.feat-grid,.voip-steps,.pw-grid,.exec-tiers,.exec-metrics,.int-categories,.roles-grid { grid-template-columns:1fr 1fr; }
      .ai-mgr-grid,.retro-grid { grid-template-columns:1fr; }
      .ba-grid { grid-template-columns:1fr; }
      .footer-grid { grid-template-columns:2fr 1fr 1fr; gap:2rem; }
      .watch-flow { grid-template-columns:1fr; }
      .wf-arrow { display:none; }
      .teams-grid { grid-template-columns:1fr 1fr; }
      .hero-h1 { font-size:clamp(1.8rem,5vw,2.6rem); }
      .hero-sub-big { font-size:1rem; }
      .hero-inner { padding:3rem 1.5rem; }
    }
    @media(max-width:768px) {
      .footer-grid { grid-template-columns:1fr 1fr; gap:2rem 1.5rem; }
      .hero-chips { display:none; }
      .hero-stats { display:none; }
      .stats-bar { padding:1.5rem 1rem; }
      .sb-inner { gap:1rem; }
      .sb-num { font-size:1.2rem; }
      .teams-grid { grid-template-columns:1fr; }
    }
    @media(max-width:640px) {
      .section { padding:3rem 1.25rem; }
      .steps-row,.feat-grid,.voip-steps,.pw-grid,.exec-tiers,.exec-metrics,.int-categories,.roles-grid,.teams-grid { grid-template-columns:1fr; }
      .footer-grid { grid-template-columns:1fr; gap:2rem; }
      .hero-actions { flex-direction:column; width:100%; }
      .hero-actions a { width:100%; justify-content:center; }
      .footer-bottom { flex-direction:column; gap:.5rem; text-align:center; }
      .us-banner { flex-direction:column; text-align:center; }
      .us-badge { margin:0 auto; }
      .hero-inner { padding:2rem 1rem; }
      .hero-h1 { font-size:1.75rem; }
      .hero-sub-big { font-size:.95rem; }
      .hero-sub { font-size:.85rem; }
      .hero-toggle { margin-top:.5rem; }
      .hero-toggle-opt { padding:.3rem .75rem; font-size:.7rem; }
      .sec-h2 { font-size:1.5rem; }
      .exec-tiers { gap:1rem; }
      .exec-tier { padding:1.25rem; }
      .team-card { padding:1.25rem 1rem; }
      .team-icon { width:56px; height:56px; }
      .team-icon .material-symbols-outlined { font-size:1.5rem; }
      .int-logos-hero { gap:.75rem; }
      .int-logo { font-size:.8rem; }
      .teams-bg [style*="margin-top:4rem"] { margin-top:2rem !important; }
      .call-card { padding:1rem; }
      .call-name { font-size:1.1rem; }
      .call-transcript { height:60px; }
      .voip-card { padding:1.25rem; }
      .pw-card { padding:1.25rem; }
      .stats-bar { padding:1rem; }
    }
    @media(prefers-reduced-motion:reduce) { *,*::before,*::after { animation-duration:.001ms !important; } }

    /* teams section */
    .teams-bg { background:#fff; border-top:1px solid var(--s3); border-bottom:1px solid var(--s3); overflow-x:hidden; }
    .teams-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:1.5rem; }
    .team-card { background:var(--s1); border:1px solid var(--s3); border-radius:20px; padding:2rem 1.5rem; display:flex; flex-direction:column; align-items:center; text-align:center; transition:border-color .3s,box-shadow .3s,transform .3s; word-break:break-word; overflow-wrap:break-word; }
    .team-card:hover { transform:translateY(-3px); box-shadow:0 8px 28px rgba(0,0,0,.07); }
    .team-card.feat { border-color:rgba(14,182,71,.3); box-shadow:0 0 30px rgba(14,182,71,.07); background:#fff; }
    .team-icon { width:72px; height:72px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:1.25rem; }
    .team-icon .material-symbols-outlined { font-size:2rem; }
    .tc1{background:rgba(0,175,240,.1);color:var(--cyan);}
    .tc2{background:var(--green);color:#fff;}
    .tc3{background:rgba(124,58,237,.1);color:var(--purple);}
    .tc4{background:rgba(234,88,12,.1);color:var(--orange);}
    .team-title { font-size:1rem; font-weight:800; color:var(--s9); margin-bottom:.75rem; }
    .team-desc { font-size:.85rem; color:var(--s6); line-height:1.65; }
    .int-logos-hero { display:flex; justify-content:center; align-items:center; flex-wrap:wrap; gap:2rem; max-width:100%; }
    .int-logo { display:flex; align-items:center; gap:.5rem; font-size:1rem; font-weight:800; color:var(--s7); opacity:.5; transition:opacity .3s; flex-shrink:0; }
    .int-logo:hover { opacity:1; }
    .int-logo img { width:28px; height:28px; flex-shrink:0; }
    .int-logo .material-symbols-outlined { flex-shrink:0; }
  </style>
</head>
<body>

<!-- NAV -->
<nav id="navbar">
  <div class="nav-inner">
    <a href="/" class="nav-logo">
      <img src="/assets/logo-light-new.png" alt="GoalChaser.co" class="logo-light" />
      <img src="/assets/logo-dark.png" alt="GoalChaser.co" class="logo-dark" />
    </a>
    <ul class="nav-links">
      <li><a href="#how-it-works">How It Works</a></li>
      <li><a href="#ai-manager">AI Manager</a></li>
      <li><a href="#features">Features</a></li>
      <li><a href="#exec-pulse">Exec View</a></li>
      <li><a href="#teams">For Teams</a></li>
      <li><a href="#mobile-app">Mobile App</a></li>
      <li><a href="#faq">FAQ</a></li>
    </ul>
    <div class="nav-actions">
      <a href="/login" class="btn-ghost">Sign in</a>
      <a href="/login" class="btn-primary">Get Started →</a>
    </div>
    <button class="nav-hamburger" id="hamburger" aria-label="Open menu">
      <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round">
        <line x1="3" y1="7" x2="21" y2="7"/>
        <line x1="3" y1="12" x2="21" y2="12"/>
        <line x1="3" y1="17" x2="21" y2="17"/>
      </svg>
    </button>
  </div>
  <div class="mobile-menu" id="mobileMenu">
    <a href="#how-it-works">How It Works</a>
    <a href="#ai-manager">AI Manager</a>
    <a href="#features">Features</a>
    <a href="#exec-pulse">Exec View</a>
    <a href="#teams">For Teams</a>
    <a href="#mobile-app">Mobile App</a>
    <a href="#faq">FAQ</a>
    <div class="mobile-actions">
      <a href="/login" class="btn-ghost">Sign in</a>
      <a href="/login" class="btn-primary">Get Started →</a>
    </div>
  </div>
</nav>

<!-- HERO -->
<section class="hero" id="hero-section"
  x-data="{ active:0, scrolling:false }"
  x-init="setInterval(()=>{ scrolling=true; setTimeout(()=>{ active=(active+1)%3; setTimeout(()=>{ scrolling=false; },1000); },300); },4000)">
  <div class="hero-overlay"></div>
  <div class="hero-glow1"></div>
  <div class="hero-glow2"></div>
  <div class="hero-glow3"></div>

  <div class="hero-inner">
    <!-- LEFT: text -->
    <div>

      <div class="hero-toggle" id="heroToggle">
        <span class="hero-toggle-opt active" data-mode="personal">For you</span>
        <span class="hero-toggle-opt" data-mode="team">For your team</span>
      </div>

      <h1 class="hero-h1" id="heroHeadline">
        Your personal <span class="c1">procrastination killer</span><br>
        — one call at a time
      </h1>

      <p class="hero-sub-big" id="heroSubBig">Your AI accountability partner.</p>
      <p class="hero-sub" id="heroSub">GoalChaser calls you daily, learns what matters, and keeps you accountable — so you stop procrastinating and start finishing. No dashboards, no distractions, just results.</p>

      <div class="hero-actions">
        <a href="/login" class="btn-primary" style="text-decoration:none;">
          Start for Free
          <span class="material-symbols-outlined" style="font-size:20px;">arrow_forward</span>
        </a>
        <a href="#how-it-works" class="btn-ghost">
          <div class="play-ring">
            <span class="material-symbols-outlined" style="font-size:18px;color:#0EB647;margin-left:2px;">play_arrow</span>
          </div>
          See how it works
        </a>
      </div>

      <div class="hero-chips">
        <span class="chip"><span class="material-symbols-outlined" style="color:#00AFF0;">mic</span>AI Voice Calls</span>
        <span class="chip"><span class="material-symbols-outlined" style="color:#0EB647;">settings_input_antenna</span>Enterprise VoIP</span>
        <span class="chip"><span class="material-symbols-outlined" style="color:#0EB647;">check_circle</span>No dashboards needed</span>
        <span class="chip"><span class="material-symbols-outlined" style="color:#FBBF24;">groups</span>Personal &amp; Teams</span>
      </div>
    </div>

    <!-- RIGHT: original sliding card visual -->
    <div class="hero-visual">
      <div class="cards-wrap">

        <!-- SVG lines -->
        <svg class="hero-svg" viewBox="0 0 1000 700" preserveAspectRatio="none" :style="!scrolling ? 'opacity:1' : 'opacity:0'">
          <path class="hp-base" d="M 480 105 L 730 105 Q 750 105 750 125 L 750 255"/>
          <path class="hp-flow" d="M 480 105 L 730 105 Q 750 105 750 125 L 750 255"/>
          <path class="hp-base" d="M 250 435 L 250 565 Q 250 585 270 585 L 520 585"/>
          <path class="hp-flow-rev" d="M 250 435 L 250 565 Q 250 585 270 585 L 520 585"/>
          <g><circle class="hn-p" cx="480" cy="105" r="8"><animate attributeName="r" values="6;10;6" dur="2s" repeatCount="indefinite"/></circle><circle class="hn" cx="480" cy="105" r="4"/></g>
          <g><circle class="hn-p" cx="750" cy="255" r="8"><animate attributeName="r" values="6;10;6" dur="2s" repeatCount="indefinite"/></circle><circle class="hn" cx="750" cy="255" r="4"/></g>
          <g><circle class="hn-p" cx="250" cy="435" r="8"><animate attributeName="r" values="6;10;6" dur="2s" repeatCount="indefinite"/></circle><circle class="hn" cx="250" cy="435" r="4"/></g>
          <g><circle class="hn-p" cx="520" cy="585" r="8"><animate attributeName="r" values="6;10;6" dur="2s" repeatCount="indefinite"/></circle><circle class="hn" cx="520" cy="585" r="4"/></g>
        </svg>

        <!-- COL 1 -->
        <div class="card-col" :style="`transform:translateY(-${active*410}px)`">
          <!-- ghost before -->
          <div class="hcard hcard-ghost" style="top:calc(50% - 95px - 820px);transform:translateY(-50%);">
            <div class="gh-row"><div class="gh-av"></div><div class="gh-lines"><div class="gh-line" style="width:33%"></div><div class="gh-line" style="width:50%"></div></div></div>
            <div class="gh-box"></div><div class="gh-foot"><div class="gh-line"></div><div class="gh-line" style="width:75%"></div></div>
          </div>
          <div class="hcard hcard-ghost" style="top:calc(50% - 95px - 410px);transform:translateY(-50%);">
            <div class="gh-row"><div class="gh-av"></div><div class="gh-lines"><div class="gh-line" style="width:33%"></div><div class="gh-line" style="width:50%"></div></div></div>
            <div class="gh-box"></div>
          </div>

          <!-- CARD 1 ACTIVE: LIVE CALL -->
          <div class="hcard" style="top:calc(50% - 95px);transform:translateY(-50%);"
            :class="(active===0&&!scrolling)?'hcard-active':'hcard-dim'">
            <!-- ghost state -->
            <div class="absolute inset-0 p-6 flex flex-col gap-4" :class="(active===0&&!scrolling)?'opacity-0':'opacity-100'" style="position:absolute;inset:0;padding:1.5rem;display:flex;flex-direction:column;gap:1rem;">
              <div class="gh-row"><div class="gh-av"></div><div class="gh-lines"><div class="gh-line" style="width:33%"></div><div class="gh-line" style="width:50%"></div></div></div>
              <div class="gh-box"></div>
            </div>
            <!-- active state: live call -->
            <div class="card1-inner" style="position:absolute;inset:0;" :class="(active===0&&!scrolling)?'':''" :style="(active===0&&!scrolling)?'opacity:1':'opacity:0;pointer-events:none'">
              <div class="live-badge" style="position:absolute;top:-1rem;right:-2rem;">
                <span style="width:8px;height:8px;border-radius:50%;background:#fff;display:inline-block;"></span>
                <span>Live Call</span>
              </div>
              <div class="card1-caller">
                <div class="caller-av"><span class="material-symbols-outlined">call</span></div>
                <div>
                  <div class="caller-label">AI Voice Call · VoIP</div>
                  <div class="caller-name">GoalChaser.co AI</div>
                </div>
              </div>
              <div class="card1-bubble">
                <div class="bubble-row">
                  <div class="bubble-av"><span class="material-symbols-outlined">smart_toy</span></div>
                  <div>
                    <div class="bubble-text">"Good morning! Ready to plan your day?"</div>
                    <div class="bubble-time">GoalChaser AI · VoIP Call · Just now</div>
                  </div>
                </div>
                <div style="height:1px;background:rgba(0,175,240,.15);margin:.5rem 0;"></div>
                <div class="wave-row">
                  <div class="wb"></div><div class="wb"></div><div class="wb"></div><div class="wb"></div>
                  <div class="wb"></div><div class="wb"></div><div class="wb"></div><div class="wb"></div>
                  <span class="wave-label">AI Speaking via VoIP…</span>
                </div>
              </div>
              <div class="card1-foot">
                <span class="status-dot"></span>
                <span class="status-text">Live VoIP · Encrypted · Crystal Clear</span>
              </div>
            </div>
          </div>

          <!-- CARD 2: progress check -->
          <div class="hcard" style="top:calc(50% - 95px + 410px);transform:translateY(-50%);"
            :class="(active===1&&!scrolling)?'hcard-active':'hcard-dim'">
            <div style="position:absolute;inset:0;padding:1.5rem;opacity:1;" :style="(active===1&&!scrolling)?'opacity:0':'opacity:1'">
              <div class="gh-av"></div>
            </div>
            <div class="card2-inner" style="position:absolute;inset:0;" :style="(active===1&&!scrolling)?'opacity:1':'opacity:0;pointer-events:none'">
              <div class="card2-header">
                <div class="card2-av-wrap">
                  <div class="card2-av"><span class="material-symbols-outlined">notifications_active</span></div>
                  <div class="card2-online"></div>
                </div>
                <div class="card2-title-row">
                  <div class="sub">Follow-up</div>
                  <div class="main">Progress Check</div>
                </div>
              </div>
              <div class="task-list">
                <div class="task-row"><span class="material-symbols-outlined" style="color:#22c55e;">check_circle</span><span class="task-label">Draft proposal</span><span class="task-status ts-done">Done</span></div>
                <div class="task-row"><span class="material-symbols-outlined" style="color:#3B7A9E;">radio_button_unchecked</span><span class="task-label">Review Q3 budget</span><span class="task-status ts-prog">In Progress</span></div>
                <div class="task-row"><span class="material-symbols-outlined" style="color:#EF4444;">radio_button_unchecked</span><span class="task-label">Call client back</span><span class="task-status ts-over">Overdue</span></div>
              </div>
              <div class="card2-foot"><span class="ping-dot"></span>AI calling back in 30 min…</div>
            </div>
          </div>

          <!-- CARD 3: call logs -->
          <div class="hcard" style="top:calc(50% - 95px + 820px);transform:translateY(-50%);"
            :class="(active===2&&!scrolling)?'hcard-active':'hcard-dim'">
            <div style="position:absolute;inset:0;padding:1.5rem;" :style="(active===2&&!scrolling)?'opacity:0':'opacity:1'">
              <div class="gh-av"></div>
            </div>
            <div class="card3-inner" style="position:absolute;inset:0;" :style="(active===2&&!scrolling)?'opacity:1':'opacity:0;pointer-events:none'">
              <div class="card3-title"><span class="material-symbols-outlined" style="color:#3B7A9E;">history</span>Call Logs</div>
              <div class="log-item"><div class="log-icon"><span class="material-symbols-outlined">call_received</span></div><div style="flex:1"><div class="log-label">Morning Planning</div><div class="log-time">Today, 8:30 AM • 12 min</div></div><span class="log-badge lb-done">Completed</span></div>
              <div class="log-item"><div class="log-icon"><span class="material-symbols-outlined">call_received</span></div><div style="flex:1"><div class="log-label">Follow-up Check</div><div class="log-time">Today, 11:15 AM • 5 min</div></div><span class="log-badge lb-done">Completed</span></div>
              <div class="log-item dim"><div class="log-icon"><span class="material-symbols-outlined">call_missed</span></div><div style="flex:1"><div class="log-label">Afternoon Update</div><div class="log-time">Today, 2:00 PM • Missed</div></div><span class="log-badge lb-miss">Missed</span></div>
              <div class="card3-foot"><span>View all transcripts →</span><span class="count">3 calls today</span></div>
            </div>
          </div>

          <!-- ghost after -->
          <div class="hcard hcard-ghost" style="top:calc(50% - 95px + 1230px);transform:translateY(-50%);">
            <div class="gh-row"><div class="gh-av"></div><div class="gh-lines"><div class="gh-line" style="width:33%"></div><div class="gh-line" style="width:50%"></div></div></div>
            <div class="gh-box"></div>
          </div>
        </div>

        <!-- COL 2 -->
        <div class="card-col card-col-2" :style="`transform:translateY(-${active*410}px)`">
          <div class="hcard hcard-ghost" style="top:calc(50% + 95px - 820px);transform:translateY(-50%);">
            <div class="gh-row"><div class="gh-av"></div><div class="gh-lines"><div class="gh-line" style="width:33%"></div><div class="gh-line" style="width:50%"></div></div></div>
            <div class="gh-box"></div>
          </div>
          <div class="hcard hcard-ghost" style="top:calc(50% + 95px - 410px);transform:translateY(-50%);">
            <div class="gh-row"><div class="gh-av"></div><div class="gh-lines"><div class="gh-line" style="width:33%"></div><div class="gh-line" style="width:50%"></div></div></div>
            <div class="gh-box"></div>
          </div>

          <!-- RIGHT CARD 1: today's schedule -->
          <div class="hcard" style="top:calc(50% + 95px);transform:translateY(-50%);"
            :class="(active===0&&!scrolling)?'hcard-active':'hcard-dim'">
            <div style="position:absolute;inset:0;padding:1.5rem;" :style="(active===0&&!scrolling)?'opacity:0':'opacity:1'">
              <div class="gh-av"></div><div class="gh-lines" style="margin-top:.5rem;"><div class="gh-line" style="width:50%"></div></div>
            </div>
            <div class="card-r1" style="position:absolute;inset:0;" :style="(active===0&&!scrolling)?'opacity:1':'opacity:0;pointer-events:none'">
              <div class="sched-header">
                <div><div class="sched-label">Today's Schedule</div><div class="sched-num">5 Tasks</div></div>
                <div style="text-align:right"><div class="sched-label">Progress</div><div class="sched-pct">60%</div></div>
              </div>
              <div class="task-items">
                <div class="ti"><span class="material-symbols-outlined" style="color:#22c55e;">check_circle</span><div class="ti-text"><div class="ti-name">Draft Q4 proposal</div><div class="ti-meta">Due: Today • High priority</div></div></div>
                <div class="ti"><span class="material-symbols-outlined" style="color:#3B7A9E;">radio_button_unchecked</span><div class="ti-text"><div class="ti-name">Review team updates</div><div class="ti-meta">Due: Today • Medium</div></div></div>
                <div class="ti"><span class="material-symbols-outlined" style="color:#3B7A9E;">radio_button_unchecked</span><div class="ti-text"><div class="ti-name">Call Johnson &amp; Co.</div><div class="ti-meta">Due: Today • High priority</div></div></div>
                <div class="ti dim"><span class="material-symbols-outlined" style="color:#4A7B9E;">radio_button_unchecked</span><div class="ti-text"><div class="ti-name">Prepare presentation</div><div class="ti-meta">Due: Tomorrow</div></div></div>
              </div>
              <div class="sched-foot"><span>2 completed • 3 remaining</span><span style="color:#3B7A9E;">View all →</span></div>
            </div>
          </div>

          <!-- RIGHT CARD 2: daily report -->
          <div class="hcard" style="top:calc(50% + 95px + 410px);transform:translateY(-50%);"
            :class="(active===1&&!scrolling)?'hcard-active':'hcard-dim'">
            <div style="position:absolute;inset:0;padding:1.5rem;" :style="(active===1&&!scrolling)?'opacity:0':'opacity:1'"><div class="gh-av"></div></div>
            <div class="rpt-inner" style="position:absolute;inset:0;" :style="(active===1&&!scrolling)?'opacity:1':'opacity:0;pointer-events:none'">
              <div class="rpt-title"><span class="material-symbols-outlined" style="color:#22c55e;">summarize</span>Daily Report</div>
              <div class="rpt-box">
                <div class="rpt-row"><span class="rl">Tasks Completed</span><span class="rv">3/5</span></div>
                <div class="progress-bar"><div class="progress-fill"></div></div>
                <div class="rpt-meta"><span>Hours logged: 4.5h</span><span>Calls: 3</span></div>
              </div>
              <div class="rpt-preview">
                <div class="rp-label">Transcript Preview</div>
                <div class="rp-text">"Draft proposal completed. Moving to budget review…"</div>
              </div>
              <button class="rpt-btn">View Full Report</button>
            </div>
          </div>

          <!-- RIGHT CARD 3: stats -->
          <div class="hcard" style="top:calc(50% + 95px + 820px);transform:translateY(-50%);"
            :class="(active===2&&!scrolling)?'hcard-active':'hcard-dim'">
            <div style="position:absolute;inset:0;padding:1.5rem;" :style="(active===2&&!scrolling)?'opacity:0':'opacity:1'"><div class="gh-av"></div></div>
            <div class="stats-inner-card" style="position:absolute;inset:0;" :style="(active===2&&!scrolling)?'opacity:1':'opacity:0;pointer-events:none'">
              <div class="rpt-title"><span class="material-symbols-outlined" style="color:#3B7A9E;">bar_chart</span>Your Stats</div>
              <div class="stats-grid">
                <div class="stat-box"><div class="sn">12</div><div class="sl">Tasks This Week</div></div>
                <div class="stat-box"><div class="sn green">9</div><div class="sl">Completed</div></div>
                <div class="stat-box"><div class="sn blue">75%</div><div class="sl">Completion Rate</div></div>
                <div class="stat-box"><div class="sn">8h</div><div class="sl">Focused Time</div></div>
              </div>
              <div class="procrastination">Procrastination Score: 15% ↓</div>
            </div>
          </div>

          <div class="hcard hcard-ghost" style="top:calc(50% + 95px + 1230px);transform:translateY(-50%);">
            <div class="gh-row"><div class="gh-av"></div></div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<!-- STATS BAR -->
<div class="stats-bar">
  <div class="sb-inner">
    <div class="sb-item"><div class="sb-num">10,000+</div><div class="sb-label">Early Signups</div></div>
    <div class="sb-item"><div class="sb-num">100K+</div><div class="sb-label">Tasks Completed</div></div>
    <div class="sb-item"><div class="sb-num">5,000+</div><div class="sb-label">Blockers Resolved</div></div>
    <div class="sb-item"><div class="sb-num">24/7</div><div class="sb-label">AI Follow-ups</div></div>
    <div class="sb-item"><div class="sb-num">US</div><div class="sb-label">Phone Numbers</div></div>
  </div>
</div>

<!-- HOW IT WORKS -->
<section class="section how-bg" id="how-it-works">
  <div class="sec-inner">
    <div class="tc mb16">
      <div class="eyebrow"><span class="material-symbols-outlined">explore</span>The Workflow</div>
      <h2 class="sec-h2">How <span>GoalChaser.co</span> Works</h2>
      <p class="sec-sub cx">Your AI gives you a quick call, understands your goals, and follows up to help you finish them.</p>
    </div>
    <div class="steps-row">
      <div class="step-card s1">
        <div class="step-icon"><span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">phone_callback</span></div>
        <div class="step-num">Step 01</div>
        <div class="step-title">Quick Morning Call</div>
        <p class="step-desc">GoalChaser gives you or your team a quick call to talk about what needs to be done today. No meetings needed.</p>
      </div>
      <div class="step-card s2">
        <div class="step-icon"><span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">checklist</span></div>
        <div class="step-num">Step 02</div>
        <div class="step-title">Plan the Day</div>
        <p class="step-desc">Just talk naturally. The AI organizes your goals and sets up your daily tasks automatically.</p>
      </div>
      <div class="step-card s3">
        <div class="step-icon"><span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">notifications_active</span></div>
        <div class="step-num">Step 03</div>
        <div class="step-title">Friendly Reminders</div>
        <p class="step-desc">Get helpful nudges and reminders before deadlines so you never fall behind.</p>
      </div>
      <div class="step-card s4">
        <div class="step-icon"><span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">summarize</span></div>
        <div class="step-num">Step 04</div>
        <div class="step-title">Clear Updates</div>
        <p class="step-desc">See exactly what you and your team accomplished with simple, auto-generated reports.</p>
      </div>
    </div>
  </div>
</section>

<!-- VS COMPARISON + FEATURES -->
<section class="section vs-bg" id="features">
  <div class="sec-inner">
    <div class="tc mb16">
      <h2 class="sec-h2">A tool that <span>works for you</span></h2>
      <p class="sec-sub cx">Most tools just sit there waiting for you to update them. GoalChaser actively helps you get things done.</p>
    </div>

    <div class="ba-grid">
      <div class="ba-card ba-before">
        <div class="ba-head">
          <div class="ba-ico"><span class="material-symbols-outlined" style="font-size:1.2rem;">close</span></div>
          <span class="ba-title" style="color:#1E293B;">Passive tools (Jira / Trello / Asana)</span>
        </div>
        <ul class="ba-list">
          <li><span class="material-symbols-outlined" style="color:#CBD5E1;">do_not_disturb_on</span>Someone has to remember to log in and update</li>
          <li><span class="material-symbols-outlined" style="color:#CBD5E1;">do_not_disturb_on</span>Deadlines slip silently — no one warns you</li>
          <li><span class="material-symbols-outlined" style="color:#CBD5E1;">do_not_disturb_on</span>Zero intelligence about your team as people</li>
          <li><span class="material-symbols-outlined" style="color:#CBD5E1;">do_not_disturb_on</span>Someone must manually write every status report</li>
          <li><span class="material-symbols-outlined" style="color:#CBD5E1;">do_not_disturb_on</span>Blocked tasks sit unnoticed for days</li>
        </ul>
      </div>
      <div class="ba-card ba-after">
        <div class="ba-head">
          <div class="ba-ico"><span class="material-symbols-outlined" style="font-size:1.2rem;">check</span></div>
          <span class="ba-title" style="color:#0F172A;">GoalChaser.co — Active AI Manager</span>
        </div>
        <ul class="ba-list">
          <li><span class="material-symbols-outlined" style="color:#00AFF0;">check_circle</span>AI calls your team — no login required</li>
          <li><span class="material-symbols-outlined" style="color:#00AFF0;">check_circle</span>Pre-deadline warnings before anything slips</li>
          <li><span class="material-symbols-outlined" style="color:#00AFF0;">check_circle</span>Baseline-aware performance monitoring per person</li>
          <li><span class="material-symbols-outlined" style="color:#00AFF0;">check_circle</span>Reports auto-generated from call transcripts</li>
          <li><span class="material-symbols-outlined" style="color:#00AFF0;">check_circle</span>Blockers escalated and resolved in real time</li>
        </ul>
      </div>
    </div>

    <div class="feat-grid">
      <div class="feat-card fc1">
        <div class="feat-ico"><span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">alarm_on</span></div>
        <div class="feat-title">Friendly Reminders</div>
        <p class="feat-desc">Get helpful warnings before a deadline so you have time to finish your work comfortably.</p>
      </div>
      <div class="feat-card fc2">
        <div class="feat-ico"><span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">support_agent</span></div>
        <div class="feat-title">Help When Stuck</div>
        <p class="feat-desc">When you hit a roadblock, GoalChaser can suggest solutions or connect you with the right person on your team.</p>
      </div>
      <div class="feat-card fc3">
        <div class="feat-ico"><span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">monitoring</span></div>
        <div class="feat-title">Personal Progress</div>
        <p class="feat-desc">Track your own growth and productivity over time, so you can celebrate your personal wins.</p>
      </div>
      <div class="feat-card fc4">
        <div class="feat-ico"><span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">notifications_active</span></div>
        <div class="feat-title">Stays on Top</div>
        <p class="feat-desc">GoalChaser remembers everything so you don't have to, keeping tasks organized until they are done.</p>
      </div>
      <div class="feat-card fc1">
        <div class="feat-ico"><span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">groups</span></div>
        <div class="feat-title">Team Harmony</div>
        <p class="feat-desc">When your work affects a teammate, GoalChaser automatically updates them so everyone stays perfectly in sync.</p>
      </div>
      <div class="feat-card fc2">
        <div class="feat-ico"><span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">auto_awesome</span></div>
        <div class="feat-title">Smart Planning</div>
        <p class="feat-desc">GoalChaser looks at your upcoming tasks and makes sure you aren't overwhelmed before the week begins.</p>
      </div>
      <div class="feat-card fc3">
        <div class="feat-ico"><span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">history</span></div>
        <div class="feat-title">Clear Records</div>
        <p class="feat-desc">Every chat is securely saved, so you can easily review what was agreed upon without taking notes.</p>
      </div>
      <div class="feat-card fc4">
        <div class="feat-ico"><span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">import_contacts</span></div>
        <div class="feat-title">Knows Your Style</div>
        <p class="feat-desc">Teach GoalChaser your personal or team guidelines, and it will adapt its check-ins to match your way of working.</p>
      </div>
    </div>
  </div>
</section>

<!-- AI MANAGER LAYER -->
<section class="section ai-mgr-bg" id="ai-manager">
  <div class="sec-inner">
    <div class="eyebrow eyebrow-dark" style="margin-bottom:3rem;"><span class="material-symbols-outlined">smart_toy</span>The AI Manager</div>
    <div class="ai-mgr-grid">
      <div class="ai-mgr-text">
        <h3>An <span>inspiring companion</span> that understands you and your work</h3>
        <p>GoalChaser reaches out with a friendly daily call. No forms to fill. Just a natural conversation that automatically updates your progress and notes any challenges.</p>
        <p>If you're stuck, GoalChaser acts as a helpful guide, offering suggestions or bringing in the right teammate so you're never blocked for long.</p>
        <div class="ai-mgr-bullets">
          <div class="ai-bullet">
            <div class="ai-bullet-icon bi-cyan"><span class="material-symbols-outlined">call</span></div>
            <span><strong style="color:#fff;">Friendly Check-ins</strong> — A quick chat to organize your day and update your to-do list.</span>
          </div>
          <div class="ai-bullet">
            <div class="ai-bullet-icon bi-green"><span class="material-symbols-outlined">support_agent</span></div>
            <span><strong style="color:#fff;">Helpful Guidance</strong> — Offers immediate solutions when you hit a roadblock.</span>
          </div>
          <div class="ai-bullet">
            <div class="ai-bullet-icon bi-purple"><span class="material-symbols-outlined">escalator_warning</span></div>
            <span><strong style="color:#fff;">Seamless Teamwork</strong> — Automatically connects you with the right person when you need extra help.</span>
          </div>
          <div class="ai-bullet">
            <div class="ai-bullet-icon bi-orange"><span class="material-symbols-outlined">sync</span></div>
            <span><strong style="color:#fff;">Steady Progress</strong> — Keeps track of longer projects so you always know where you stand.</span>
          </div>
        </div>
      </div>
      <div>
        <div class="call-card">
          <div class="call-header">
            <div class="call-status"><span class="live-dot"></span> Live</div>
            <div class="call-time" x-data="{ time: 64 }" x-init="setInterval(() => time++, 1000)" x-text="Math.floor(time/60).toString().padStart(2, '0') + ':' + (time%60).toString().padStart(2, '0')">01:04</div>
          </div>

          <div class="call-center">
            <div class="call-avatar-wrapper">
              <div class="pulse-ring pr1"></div>
              <div class="pulse-ring pr2"></div>
              <div class="call-avatar"><span class="material-symbols-outlined">smart_toy</span></div>
            </div>
            <div class="call-name">GoalChaser AI</div>
            <div class="call-role">Morning Check-in • Marketing Team</div>
          </div>

          <div class="call-waveform">
            <div class="wave-bar"></div>
            <div class="wave-bar"></div>
            <div class="wave-bar"></div>
            <div class="wave-bar"></div>
            <div class="wave-bar"></div>
            <div class="wave-bar"></div>
            <div class="wave-bar"></div>
          </div>

          <div class="call-transcript">
            <div class="transcript-line tl-1">"Hey there! Did you get a chance to finish the campaign draft?"</div>
            <div class="transcript-line tl-2">"Yes, just wrapped it up. Moving on to the email sequence next."</div>
            <div class="transcript-line tl-3">"Perfect, I've updated the project. Let me know if you get stuck!"</div>
          </div>

          <div class="call-controls">
            <div class="cc-btn"><span class="material-symbols-outlined">mic_off</span></div>
            <div class="cc-btn end-call"><span class="material-symbols-outlined">call_end</span></div>
            <div class="cc-btn"><span class="material-symbols-outlined">volume_up</span></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- PERFORMANCE WATCH -->
<section class="section pw-section" id="performance">
  <div class="sec-inner">
    <div class="tc mb16">
      <div class="eyebrow"><span class="material-symbols-outlined">shield</span>Performance Watch</div>
      <h2 class="sec-h2">Fair accountability. <span>Not surveillance.</span></h2>
      <p class="sec-sub cx">GoalChaser learns each person's natural pace over 2–3 sprints and measures against their own baseline — not a generic company standard. One bad day changes nothing. Sustained patterns trigger a private signal.</p>
    </div>
    <div class="pw-grid">
      <div class="pw-card">
        <div class="pw-ico-wrap pw-icon-c"><span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">analytics</span></div>
        <div class="pw-title">Personal Baseline Learning</div>
        <p class="pw-desc">For the first 2–3 sprints, GoalChaser observes — completion rate, estimate accuracy, response consistency, blocker patterns. This becomes each person's benchmark.</p>
      </div>
      <div class="pw-card">
        <div class="pw-ico-wrap pw-icon-g"><span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">visibility</span></div>
        <div class="pw-title">Watch State (Private)</div>
        <p class="pw-desc">If a pattern emerges, the person enters a private Watch State. The AI gives a 5–7 day window to self-correct. If they pick back up, it clears silently with no record in management view.</p>
      </div>
      <div class="pw-card">
        <div class="pw-ico-wrap pw-icon-p"><span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">flag</span></div>
        <div class="pw-title">Targeted Manager Flag</div>
        <p class="pw-desc">If performance doesn't recover, the direct manager — not HR, not the CEO — receives a flag with specific examples, likely causes (workload? blockers? burnout?), and full context to have a human conversation.</p>
      </div>
    </div>

    <div class="watch-flow">
      <div class="wf-item"><div class="wf-num wf1">Sprint 1–3</div><div class="wf-label">Baseline learning<br>No flags possible</div></div>
      <div class="wf-arrow">→</div>
      <div class="wf-item"><div class="wf-num wf2">Pattern detected</div><div class="wf-label">Watch State begins<br>Private, self-correcting</div></div>
      <div class="wf-arrow">→</div>
      <div class="wf-item"><div class="wf-num wf3">5–7 days</div><div class="wf-label">Self-corrects: cleared silently<br>Doesn't: manager notified</div></div>
    </div>
  </div>
</section>

<!-- EXECUTIVE PULSE -->
<section class="section exec-bg" id="exec-pulse">
  <div class="sec-inner">
    <div class="tc mb16">
      <div class="eyebrow eyebrow-dark"><span class="material-symbols-outlined">leaderboard</span>Executive Pulse</div>
      <h2 class="sec-h2 light">Leadership gets the <span>right information</span><br>at the right level</h2>
      <p class="sec-sub cx" style="color:rgba(255,255,255,.6);">No more chasing updates. No more status meetings. No more manual reporting. The right data, pushed to the right person, automatically.</p>
    </div>

    <div class="exec-tiers">
      <div class="exec-tier et1">
        <div class="tier-header">
          <div class="tier-icon ti-c"><span class="material-symbols-outlined" style="font-size:1.2rem;">person</span></div>
          <div><div class="tier-title">Team Lead</div><div class="tier-sub">Granular task-level view</div></div>
        </div>
        <ul class="tier-list">
          <li><span class="material-symbols-outlined" style="color:var(--cyan);">chevron_right</span>Individual task statuses &amp; owners</li>
          <li><span class="material-symbols-outlined" style="color:var(--cyan);">chevron_right</span>Who is blocked and for how long</li>
          <li><span class="material-symbols-outlined" style="color:var(--cyan);">chevron_right</span>Sprint burndown in real time</li>
          <li><span class="material-symbols-outlined" style="color:var(--cyan);">chevron_right</span>Daily AI standup summaries</li>
          <li><span class="material-symbols-outlined" style="color:var(--cyan);">chevron_right</span>Flags and escalations for their team</li>
        </ul>
      </div>
      <div class="exec-tier et2">
        <div class="tier-header">
          <div class="tier-icon ti-g"><span class="material-symbols-outlined" style="font-size:1.2rem;">groups</span></div>
          <div><div class="tier-title">Department Head</div><div class="tier-sub">Rolled-up sprint health</div></div>
        </div>
        <ul class="tier-list">
          <li><span class="material-symbols-outlined" style="color:var(--green);">chevron_right</span>Sprint on-track / at-risk overview</li>
          <li><span class="material-symbols-outlined" style="color:var(--green);">chevron_right</span>Active blockers count &amp; severity</li>
          <li><span class="material-symbols-outlined" style="color:var(--green);">chevron_right</span>Which tasks are in danger</li>
          <li><span class="material-symbols-outlined" style="color:var(--green);">chevron_right</span>Team member flags in department</li>
          <li><span class="material-symbols-outlined" style="color:var(--green);">chevron_right</span>Sprint health score per team</li>
        </ul>
      </div>
      <div class="exec-tier et3">
        <div class="tier-header">
          <div class="tier-icon ti-p"><span class="material-symbols-outlined" style="font-size:1.2rem;">domain</span></div>
          <div><div class="tier-title">C-Level / Executive</div><div class="tier-sub">Org-wide macro view</div></div>
        </div>
        <ul class="tier-list">
          <li><span class="material-symbols-outlined" style="color:var(--purple);">chevron_right</span>All projects: on track / at risk / delayed</li>
          <li><span class="material-symbols-outlined" style="color:var(--purple);">chevron_right</span>Department delivery comparisons</li>
          <li><span class="material-symbols-outlined" style="color:var(--purple);">chevron_right</span>Top recurring blockers org-wide</li>
          <li><span class="material-symbols-outlined" style="color:var(--purple);">chevron_right</span>6-month delivery rate trend</li>
          <li><span class="material-symbols-outlined" style="color:var(--purple);">chevron_right</span>Headcount productivity index</li>
        </ul>
      </div>
    </div>

    <div class="exec-metrics">
      <div class="exec-metric">
        <div class="em-label">How it's delivered</div>
        <div class="em-title">Weekly AI Digest, Every Monday</div>
        <p class="em-desc">Plain-English summary written by the AI, with key numbers embedded. No charts to decode. Pushed to email and WhatsApp before the week begins.</p>
      </div>
      <div class="exec-metric">
        <div class="em-label">Natural language queries</div>
        <div class="em-title">"How is the payments team doing this quarter?"</div>
        <p class="em-desc">Ask the AI directly. "Which project is most at risk?" "Show me everyone flagged in the last 30 days." Answers in plain English with data behind them.</p>
      </div>
      <div class="exec-metric">
        <div class="em-label">Top recurring blockers</div>
        <div class="em-title">Systemic issues surface automatically</div>
        <p class="em-desc">If three teams are blocked on third-party API integrations, GoalChaser flags it as an org-level problem — not just individual tickets.</p>
      </div>
      <div class="exec-metric">
        <div class="em-label">Always-on dashboard</div>
        <div class="em-title">Log in anytime for the current state</div>
        <p class="em-desc">The on-demand dashboard gives a live view of every project, team, and person — no stale data, no manual refreshes needed.</p>
      </div>
    </div>
  </div>
</section>

<!-- TEAMS -->
<section class="section teams-bg" id="teams">
  <div class="sec-inner">
    <div class="tc mb16">
      <h2 class="sec-h2">Built for <span>teams</span></h2>
      <p class="sec-sub cx">Scale from one person to an entire enterprise. The same AI that manages your day manages your sprint, your department, your org.</p>
    </div>
    <div class="teams-grid">
      <div class="team-card">
        <div class="team-icon tc1"><span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">groups</span></div>
        <div class="team-title">Team Standups</div>
        <p class="team-desc">AI calls each member individually to sync. No more long, disruptive morning meetings that pull everyone off work.</p>
      </div>
      <div class="team-card feat">
        <div class="team-icon tc2"><span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">visibility</span></div>
        <div class="team-title">Performance Watch</div>
        <p class="team-desc">Personal baselines per person. Identifies sustained drops or blockers — without surveillance or micromanagement.</p>
      </div>
      <div class="team-card">
        <div class="team-icon tc3"><span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">account_tree</span></div>
        <div class="team-title">Manager Flags</div>
        <p class="team-desc">If issues aren't self-corrected, team leads are alerted with task-level detail and AI-suggested causes to act on.</p>
      </div>
      <div class="team-card">
        <div class="team-icon tc4"><span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">public</span></div>
        <div class="team-title">Org Reporting</div>
        <p class="team-desc">Executives get a rolled-up org health check — delivery rates, top blockers, flag summary — pushed automatically.</p>
      </div>
    </div>

    <div style="margin-top:4rem;">
      <p style="font-size:.75rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--s5);text-align:center;margin-bottom:1.5rem;">Plays well with your existing tools</p>
      <div class="int-logos-hero">
        <div class="int-logo"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/jira/jira-original.svg" alt="Jira"> Jira</div>
        <div class="int-logo"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/trello/trello-plain.svg" alt="Trello"> Trello</div>
        <div class="int-logo"><span class="material-symbols-outlined" style="font-size:28px;color:#EF4444;">task_alt</span> Asana</div>
        <div class="int-logo"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/github/github-original.svg" alt="GitHub"> GitHub</div>
        <div class="int-logo"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/slack/slack-original.svg" alt="Slack"> Slack</div>
        <div class="int-logo"><span class="material-symbols-outlined" style="font-size:28px;color:#7C3AED;">groups</span> Teams</div>
      </div>
    </div>
  </div>
</section>

<!-- USER ROLES -->
<section class="section roles-section">
  <div class="sec-inner">
    <div class="tc mb12">
      <div class="eyebrow eyebrow-dark"><span class="material-symbols-outlined">manage_accounts</span>User Roles</div>
      <h2 class="sec-h2 light">The right view for <span>every level</span></h2>
      <p class="sec-sub cx" style="color:rgba(255,255,255,.6);">GoalChaser adapts what each person sees and receives — so everyone has exactly the context they need.</p>
    </div>
    <div class="roles-grid">
      <div class="role-card">
        <div class="role-badge rb-c">Org Admin</div>
        <div class="role-title">Org Admin</div>
        <p class="role-desc">Sets up the workspace, manages billing, configures tech stack, ingests SOP docs, controls global settings.</p>
      </div>
      <div class="role-card">
        <div class="role-badge rb-p">C-Level / Executive</div>
        <div class="role-title">Executive</div>
        <p class="role-desc">Org-wide pulse, all projects, all teams, escalation summary, delivery trends, weekly AI digest.</p>
      </div>
      <div class="role-card">
        <div class="role-badge rb-g">Department Head</div>
        <div class="role-title">Department Head</div>
        <p class="role-desc">All teams under them, department-level health score, drill-in to any team or member on request.</p>
      </div>
      <div class="role-card">
        <div class="role-badge rb-o">Team Lead / PM</div>
        <div class="role-title">Project Manager</div>
        <p class="role-desc">Full team detail, sprint management, blocker flags, escalation inbox, individual progress reports.</p>
      </div>
      <div class="role-card">
        <div class="role-badge rb-y">Developer</div>
        <div class="role-title">Team Member</div>
        <p class="role-desc">Receives AI check-in calls, updates tasks through conversation, sees their own tasks and progress report.</p>
      </div>
      <div class="role-card">
        <div class="role-badge rb-s">Viewer</div>
        <div class="role-title">Stakeholder Viewer</div>
        <p class="role-desc">Read-only access for stakeholders who need visibility without managing work. No check-in calls.</p>
      </div>
    </div>
  </div>
</section>

<!-- RETROSPECTIVES -->
<section class="section retro-section">
  <div class="sec-inner">
    <div class="retro-grid">
      <div>
        <div class="eyebrow"><span class="material-symbols-outlined">psychology</span>Auto Retrospectives</div>
        <h2 class="sec-h2" style="max-width:400px;">Sprint retros, <span>written themselves</span></h2>
        <p style="font-size:1rem;color:var(--s6);line-height:1.7;margin-bottom:1rem;">At the end of every sprint, GoalChaser auto-generates a full retrospective from call transcripts and task data. No meeting required. No one has to write it.</p>
        <p style="font-size:1rem;color:var(--s6);line-height:1.7;">Over time, the AI gets better at sprint planning for that specific team — because it learns their real velocity, their common blockers, and their patterns. Every sprint makes the next one smarter.</p>
      </div>
      <div class="retro-items">
        <div class="retro-item">
          <div class="retro-icon ri-c"><span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">fact_check</span></div>
          <div class="retro-content"><h4>Delivery Rate</h4><p>Completed vs planned — how many tasks were finished, and what fell off and why.</p></div>
        </div>
        <div class="retro-item">
          <div class="retro-icon ri-g"><span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">block</span></div>
          <div class="retro-content"><h4>Blocker Analysis</h4><p>What blocked the team, how long blockers lasted, which ones were resolved on-call vs escalated.</p></div>
        </div>
        <div class="retro-item">
          <div class="retro-icon ri-p"><span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">schedule</span></div>
          <div class="retro-content"><h4>Estimate Accuracy</h4><p>How accurate were estimates per person and per team — and is this improving sprint over sprint?</p></div>
        </div>
        <div class="retro-item">
          <div class="retro-icon ri-o"><span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">lightbulb</span></div>
          <div class="retro-content"><h4>AI Recommendation</h4><p>What to carry over, what to reduce, what patterns to watch — in plain English, ready for the team.</p></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- VOIP SYSTEM -->
<section class="section voip-bg" id="voice">
  <div class="sec-inner">
    <div class="tc mb16">
      <div class="eyebrow eyebrow-dark"><span class="material-symbols-outlined">settings_input_antenna</span>The Technology</div>
      <h2 class="sec-h2 light">Smart VoIP <span>Calling System</span></h2>
      <p class="sec-sub cx" style="color:rgba(255,255,255,.6);">No screens, no typing — a proactive AI that calls your team to plan, check progress, resolve blockers, and drive every task to completion.</p>
    </div>
    <div class="voip-steps">
      <div class="voip-card">
        <div class="voip-icon vi1"><span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">alarm</span></div>
        <div class="voip-title">Morning Call</div>
        <p class="voip-desc">The AI calls at each person's configured time. Standup in under 5 minutes. Tasks parsed, schedule updated.</p>
      </div>
      <div class="voip-card feat">
        <div class="voip-icon vi2"><span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">call</span></div>
        <div class="voip-title">Voice Scheduling</div>
        <p class="voip-desc">Just talk. The AI parses tasks, deadlines, dependencies, and notes into a live project. No typing, no dashboard.</p>
      </div>
      <div class="voip-card">
        <div class="voip-icon vi3"><span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">sync</span></div>
        <div class="voip-title">Smart Follow-ups</div>
        <p class="voip-desc">Persistent accountability. Calls back at set intervals until tasks are closed. Escalates if no response after retry.</p>
      </div>
      <div class="voip-card">
        <div class="voip-icon vi4"><span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">summarize</span></div>
        <div class="voip-title">Daily Report</div>
        <p class="voip-desc">End-of-day summary compiled from calls. Tasks, hours, blockers, progress. Full transcripts available instantly.</p>
      </div>
    </div>

    <div class="us-banner" style="margin-top:4rem;">
      <div class="us-ico"><span class="material-symbols-outlined" style="font-size:2rem;color:var(--cyan);font-variation-settings:'FILL' 1;">phone_in_talk</span></div>
      <div class="us-text">
        <h4>US Phone Numbers Only — For Now</h4>
        <p>Currently serving US-based phone numbers with premium VoIP infrastructure. Crystal-clear calls, minimal latency, enterprise-grade reliability.</p>
      </div>
      <div class="us-badge"><span class="material-symbols-outlined" style="font-size:14px;vertical-align:middle;margin-right:4px;font-variation-settings:'FILL' 1;">star</span>More regions coming soon</div>
    </div>
  </div>
</section>

<!-- MOBILE APP -->
<section class="section mobile-bg" id="mobile-app">
  <div class="sec-inner">
    <div class="mobile-grid">
      <div class="mobile-content">
        <div class="eyebrow"><span class="material-symbols-outlined">phone_android</span>Mobile App</div>
        <h2>GoalChaser <span>On the Go</span></h2>
        <p>The full GoalChaser experience in your pocket. Manage calls, tasks, and daily reports from anywhere in the world — no US phone number needed.</p>
        <a href="#" class="mobile-dl-btn" style="display:inline-flex;text-decoration:none;">
          <span class="material-symbols-outlined" style="font-size:20px;">download</span>
          Download APK
        </a>

        <div class="mobile-features">
          <div class="mobile-feat">
            <span class="material-symbols-outlined mfc1" style="font-variation-settings:'FILL' 1;">call</span>
            <div class="mobile-feat-text"><h4>Receive Calls</h4><p>Answer AI check-ins directly on your phone.</p></div>
          </div>
          <div class="mobile-feat">
            <span class="material-symbols-outlined mfc2" style="font-variation-settings:'FILL' 1;">checklist</span>
            <div class="mobile-feat-text"><h4>Manage Tasks</h4><p>View and complete tasks with a single tap.</p></div>
          </div>
          <div class="mobile-feat">
            <span class="material-symbols-outlined mfc3" style="font-variation-settings:'FILL' 1;">history</span>
            <div class="mobile-feat-text"><h4>Call Logs</h4><p>Browse transcripts and call history.</p></div>
          </div>
          <div class="mobile-feat">
            <span class="material-symbols-outlined mfc4" style="font-variation-settings:'FILL' 1;">bar_chart</span>
            <div class="mobile-feat-text"><h4>Daily Reports</h4><p>Get productivity stats on the go.</p></div>
          </div>
        </div>
      </div>

      <div class="mobile-infographic">
        <div class="phone-frame">
          <div class="phone-glow"></div>
          <div class="phone-frame-inner">
            <div class="phone-notch"></div>
            <div class="phone-screen">
              <div class="phone-hd">
                <div class="phone-brand">
                  <div class="phone-brand-dot"><span>G</span></div>
                  <span class="phone-brand-text">GoalChaser</span>
                </div>
                <div class="phone-greeting">Good morning!</div>
                <div class="phone-sub">Ready to plan your day?</div>
              </div>
              <div class="phone-body">
                <div class="phone-card">
                  <div class="phone-ci pci-call"><span class="material-symbols-outlined">call</span></div>
                  <div class="phone-ct"><div class="phone-ct-title">Morning Planning Call</div><div class="phone-ct-meta">8:30 AM &bull; Incoming</div></div>
                  <span class="phone-pulse"></span>
                </div>
                <div class="phone-card">
                  <div class="phone-ci pci-done"><span class="material-symbols-outlined">check_circle</span></div>
                  <div class="phone-ct"><div class="phone-ct-title">Draft proposal</div><div class="phone-ct-meta">Completed</div></div>
                  <span class="phone-cs pcs-done">Done</span>
                </div>
                <div class="phone-card">
                  <div class="phone-ci pci-call"><span class="material-symbols-outlined">radio_button_unchecked</span></div>
                  <div class="phone-ct"><div class="phone-ct-title">Review budget</div><div class="phone-ct-meta">In Progress</div></div>
                  <span class="phone-cs pcs-prog">1:30 PM</span>
                </div>
                <div class="phone-card">
                  <div class="phone-ci pci-miss"><span class="material-symbols-outlined">call_missed</span></div>
                  <div class="phone-ct"><div class="phone-ct-title">Follow-up Check</div><div class="phone-ct-meta">Missed &bull; Will retry</div></div>
                  <span class="phone-cs pcs-miss">Missed</span>
                </div>
              </div>
              <div class="phone-nav">
                <span class="material-symbols-outlined" style="color:var(--cyan);">home</span>
                <span class="material-symbols-outlined" style="color:#4A7B9E;">list_alt</span>
                <span class="material-symbols-outlined" style="color:#4A7B9E;">history</span>
                <span class="material-symbols-outlined" style="color:#4A7B9E;">person</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FAQ -->
<section class="section faq-bg" id="faq">
  <div class="sec-inner">
    <div class="tc mb16">
      <h2 class="sec-h2">Everything you <span>need to know</span></h2>
    </div>
    <div class="faq-list">
      <div class="faq-item"><button class="faq-q" onclick="toggleFaq(this)">What is GoalChaser.co?<span class="material-symbols-outlined">add</span></button><div class="faq-a">GoalChaser.co is an active AI project manager that calls your team via VoIP. It schedules work, tracks progress, resolves blockers, auto-generates reports, and keeps leadership informed — all without anyone logging into a dashboard.</div></div>
      <div class="faq-item"><button class="faq-q" onclick="toggleFaq(this)">How is this different from Jira, Trello, or Asana?<span class="material-symbols-outlined">add</span></button><div class="faq-a">Those tools are passive — they wait for someone to log in. GoalChaser is active. It calls your team, parses their updates, flags blockers, escalates problems, and writes reports. It acts like a manager, not a noticeboard.</div></div>
      <div class="faq-item"><button class="faq-q" onclick="toggleFaq(this)">Does it work for teams and enterprises?<span class="material-symbols-outlined">add</span></button><div class="faq-a">Yes. GoalChaser scales from a single person to an entire enterprise. It handles individual daily check-ins, team standups, department health monitoring, and executive-level org-wide pulse — all from the same system.</div></div>
      <div class="faq-item"><button class="faq-q" onclick="toggleFaq(this)">Is the performance monitoring surveillance?<span class="material-symbols-outlined">add</span></button><div class="faq-a">No. GoalChaser measures each person against their own personal baseline — not a company-wide standard. It uses a private Watch State before any manager is notified, and flags go to the direct manager only. GoalChaser surfaces signals; humans make decisions.</div></div>
      <div class="faq-item"><button class="faq-q" onclick="toggleFaq(this)">How does the AI know about our tech stack and processes?<span class="material-symbols-outlined">add</span></button><div class="faq-a">During onboarding, you configure your tech stack (languages, frameworks, APIs, cloud providers) and upload internal SOP documents. The AI indexes all of this so it can give specific, contextual help during check-in calls — not generic advice.</div></div>
      <div class="faq-item"><button class="faq-q" onclick="toggleFaq(this)">Can I import projects from Jira, Trello or Asana?<span class="material-symbols-outlined">add</span></button><div class="faq-a">Yes. GoalChaser supports full project and task import from Jira, Trello, and Asana. You don't have to start from scratch — migration is a first-class feature.</div></div>
      <div class="faq-item"><button class="faq-q" onclick="toggleFaq(this)">What communication channels does GoalChaser use?<span class="material-symbols-outlined">add</span></button><div class="faq-a">Voice calls are primary — higher response rate and harder to ignore. WhatsApp is used for async preference or as follow-up when a call isn't answered. Email handles reports, digests, and formal escalation notifications. All interactions are logged in one place.</div></div>
      <div class="faq-item"><button class="faq-q" onclick="toggleFaq(this)">Is it available internationally?<span class="material-symbols-outlined">add</span></button><div class="faq-a">Currently, GoalChaser.co is for US-based phone numbers only. Join the waitlist to get notified when your region is supported.</div></div>
      <div class="faq-item"><button class="faq-q" onclick="toggleFaq(this)">How much does it cost?<span class="material-symbols-outlined">add</span></button><div class="faq-a">We're in private beta with a free tier. Join the waitlist for early access pricing when paid plans launch.</div></div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="section cta-bg">
  <div class="sec-inner cta-inner">
    <h2 class="cta-h2">Interested in an <span>Enterprise Plan?</span></h2>
    <p class="cta-sub">Reach out to scale GoalChaser across your entire organization with dedicated support and custom integrations.</p>
    <div class="cta-actions">
      <button class="btn-primary" onclick="openModal(event)">
        <span class="material-symbols-outlined" style="font-size:20px;">headset_mic</span>
        Contact Sales
      </button>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="footer-inner">
    <div class="footer-grid">
      <div class="footer-brand">
        <a href="/" class="footer-brand-name"><img src="/assets/logo-light-new.png" alt="GoalChaser.co" /></a>
        <p style="margin-top:0;">The active AI project manager that calls your team — schedules tasks, resolves blockers, monitors performance, and keeps leadership informed automatically.</p>
        <div class="footer-social">
          <a href="mailto:support@goalchaser.co" aria-label="Email"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg></a>
          <a href="https://egeniuscare.com" target="_blank" aria-label="Website"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;"><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg></a>
        </div>
      </div>
      <div class="footer-col">
        <h5>Product</h5>
        <ul>
          <li><a href="#how-it-works">How It Works</a></li>
          <li><a href="#ai-manager">AI Manager</a></li>
          <li><a href="#exec-pulse">Exec View</a></li>
          <li><a href="#voice">Call System</a></li>
          <li><a href="#mobile-app">Mobile App</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h5>Company</h5>
        <ul>
          <li><a href="#">About</a></li>
          <li><a href="#">Careers</a></li>
          <li><a href="#faq">FAQ</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h5>Contact</h5>
        <ul>
          <li><a href="mailto:support@goalchaser.co">Email Support</a></li>
          <li><a href="mailto:sales@goalchaser.co">Sales Inquiries</a></li>
          <li><a href="mailto:info@goalchaser.co">General Info</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h5>Legal</h5>
        <ul>
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Terms of Service</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <span>© 2026 GoalChaser.co. All rights reserved.</span>
      <span>Powered by <a href="https://egeniuscare.com" target="_blank">eGeniusCare</a></span>
    </div>
  </div>
</footer>

<!-- MODAL -->
<div class="modal-overlay" id="waitlist-modal" onclick="closeModalIfOutside(event)">
  <div class="modal" id="modal-box">
    <button class="modal-close" onclick="closeModal()"><span class="material-symbols-outlined" style="font-size:20px;">close</span></button>
    <div id="modal-form">
      <div class="modal-icon"><span class="material-symbols-outlined">headset_mic</span></div>
      <h3>Contact Enterprise Sales</h3>
      <p>Let us know your business email and our team will be in touch shortly to discuss a custom plan.</p>
      <input type="email" id="waitlist-email" placeholder="Enter your business email" />
      <button class="modal-submit" onclick="submitWaitlist()">Send Message <span class="material-symbols-outlined" style="font-size:18px;">send</span></button>
    </div>
    <div class="success-state" id="modal-success">
      <div class="success-icon"><span class="material-symbols-outlined">check_circle</span></div>
      <h3 style="font-size:1.6rem;font-weight:900;font-family:'Nunito',sans-serif;margin-bottom:.5rem;">Message Sent!</h3>
      <p style="font-size:.9rem;color:#64748B;">Our enterprise team will reach out to you within 24 hours.</p>
      <button onclick="closeModal()" style="margin-top:2rem;background:none;border:none;cursor:pointer;font-weight:700;color:#00AFF0;font-family:inherit;">Close</button>
    </div>
  </div>
</div>

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
  const navbar = document.getElementById('navbar');
  const hamburger = document.getElementById('hamburger');
  const mobileMenu = document.getElementById('mobileMenu');

  window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 40);
  }, {passive:true});

  hamburger.addEventListener('click', () => {
    mobileMenu.classList.toggle('open');
  });

  mobileMenu.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => mobileMenu.classList.remove('open'));
  });

  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const target = document.querySelector(a.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior:'smooth', block:'start' });
      }
    });
  });

  /* FAQ toggle */
  function toggleFaq(btn) {
    const isOpen = btn.classList.contains('open');
    document.querySelectorAll('.faq-q').forEach(b => { b.classList.remove('open'); b.nextElementSibling.classList.remove('open'); });
    if (!isOpen) { btn.classList.add('open'); btn.nextElementSibling.classList.add('open'); }
  }

  /* Hero toggle — For You / For Team */
  const toggleOpts = document.querySelectorAll('.hero-toggle-opt');
  const heroH1 = document.getElementById('heroHeadline');
  const heroSubBig = document.getElementById('heroSubBig');
  const heroSub = document.getElementById('heroSub');

  const toggleContent = {
    personal: {
      h1: 'Your personal <span class="c1">procrastination killer</span><br>— one call at a time',
      subBig: 'Your AI accountability partner.',
      sub: 'GoalChaser calls you daily, learns what matters, and keeps you accountable — so you stop procrastinating and start finishing. No dashboards, no distractions, just results.'
    },
    team: {
      h1: 'Your team\'s <span class="c1">productivity engine</span><br>without the endless meetings',
      subBig: 'Coordinate your entire team effortlessly.',
      sub: 'GoalChaser runs AI-powered standups, tracks every task, resolves blockers in real time, and delivers executive summaries — all through natural voice calls. Your team stays aligned without a single status meeting.'
    }
  };

  toggleOpts.forEach(opt => {
    opt.addEventListener('click', function() {
      toggleOpts.forEach(o => o.classList.remove('active'));
      this.classList.add('active');
      const mode = this.dataset.mode;
      const content = toggleContent[mode];
      heroH1.innerHTML = content.h1;
      heroSubBig.textContent = content.subBig;
      heroSub.textContent = content.sub;
    });
  });

  /* Modal */
  function openModal(e) { e.preventDefault(); document.getElementById('waitlist-modal').classList.add('open'); }
  function closeModal() {
    document.getElementById('waitlist-modal').classList.remove('open');
    setTimeout(() => { document.getElementById('modal-form').style.display=''; document.getElementById('modal-success').style.display='none'; }, 300);
  }
  function closeModalIfOutside(e) { if (e.target.id === 'waitlist-modal') closeModal(); }
  document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

  async function submitWaitlist() {
    const email = document.getElementById('waitlist-email').value;
    if (!email || !email.includes('@')) return;
    try { await fetch('/waitlist', { method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify({email}) }); } catch(e) {}
    document.getElementById('modal-form').style.display = 'none';
    document.getElementById('modal-success').style.display = 'block';
  }
</script>
</body>
</html>
