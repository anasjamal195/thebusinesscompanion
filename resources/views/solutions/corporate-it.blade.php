<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GoalChaser.co Your AI Project Manager</title>
  <link rel="icon" type="image/png" href="/assets/logo/logo.png" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@400,0..1&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --navy:#1A253A; --navy2:#223048; --navy3:#2E3F5B; --navy4:#3C5072;
      --cyan:#00AFF0; --cyan2:#0091C8;
      --green:#0EB647; --green2:#0A9A3B;
      --gold:#F59E0B; --orange:#F97316;
      --white:#FFFFFF;
      --s1:#F8FAFC; --s2:#F1F5F9; --s3:#E2E8F0; --s4:#CBD5E1;
      --s5:#94A3B8; --s6:#64748B; --s7:#475569; --s8:#475569; --s9:#334155;
    }
    html { font-size:16px; }
    body { font-family:'Inter',sans-serif; background:#fff; color:var(--s9); -webkit-font-smoothing:antialiased; overflow-x:hidden; }

    /* ─── NAV ─── */
    nav { position:fixed; top:0; left:0; right:0; z-index:100; padding:0 2rem; background:transparent; border-bottom:1px solid transparent; }
    nav::before { content:''; position:absolute; inset:0; background:linear-gradient(to bottom, rgba(255,255,255,1) 0%, rgba(255,255,255,0.95) 20%, rgba(255,255,255,0.7) 50%, rgba(255,255,255,0.3) 75%, rgba(255,255,255,0) 100%); z-index:-1; }
    .nav-inner { max-width:1280px; margin:0 auto; height:80px; display:flex; align-items:center; justify-content:space-between; }
    .nav-logo { display:flex; align-items:center; text-decoration:none; }
    .nav-logo img { height:70px; width:auto; display:block; }
    @media(max-width:640px) { .nav-logo img { height:70px; } .nav-inner { height:80px; } .hero { margin-top:-80px; padding-top:80px; } }
    .nav-logo .logo-light { display:none; }
    .nav-logo .logo-dark { display:block; }
    .nav-links { display:flex; align-items:center; gap:2rem; list-style:none; }
    .nav-links a { color:var(--s7); text-decoration:none; font-size:.875rem; font-weight:700; transition:color .2s; }
    .nav-links a:hover { color:var(--cyan); }
    .nav-actions { display:flex; align-items:center; gap:1rem; }
    .nav-actions .btn-ghost { font-family:'Inter',sans-serif; font-size:.875rem; font-weight:700; background:none; border:none; cursor:pointer; text-decoration:none; transition:color .2s; color:var(--s7); }
    .nav-actions .btn-ghost:hover { color:var(--cyan); }
    .nav-actions .btn-primary { font-family:'Inter',sans-serif; font-size:.875rem; font-weight:800; background:var(--s9); border:none; padding:.625rem 1.375rem; border-radius:8px; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:.5rem; transition:background .2s,transform .15s; color:#fff; }
    .nav-actions .btn-primary:hover { background:var(--cyan); transform:translateY(-1px); }

    /* ─── HAMBURGER / MOBILE MENU ─── */
    .nav-hamburger { display:none; background:none; border:none; cursor:pointer; padding:0.25rem; }
    .nav-hamburger svg { width:24px; height:24px; stroke:var(--s9); }
    .mobile-menu { display:none; flex-direction:column; gap:1rem; padding:1.5rem 2rem; background:rgba(255,255,255,.98); backdrop-filter:blur(20px); border-top:1px solid var(--s3); }
    .mobile-menu.open { display:flex; }
    .mobile-menu a { font-weight:700; font-size:.9375rem; color:var(--s7); text-decoration:none; transition:color .2s; }
    .mobile-menu a:hover { color:var(--cyan); }
    .mobile-menu .mobile-actions { display:flex; flex-direction:column; gap:.75rem; padding-top:.75rem; border-top:1px solid var(--s3); }
    .mobile-menu .mobile-actions a { justify-content:center; text-align:center; }
    .mobile-menu .mobile-actions .btn-primary { background:var(--cyan); color:#fff; padding:.75rem; border-radius:12px; font-weight:800; display:flex; align-items:center; gap:.5rem; text-decoration:none; font-family:'Inter',sans-serif; font-size:.875rem; }
    .mobile-menu .mobile-actions .btn-ghost { background:var(--s2); color:var(--s7); padding:.75rem; border-radius:12px; font-weight:700; display:flex; align-items:center; gap:.5rem; text-decoration:none; font-family:'Inter',sans-serif; font-size:.875rem; }
    @media(max-width:900px) {
      .nav-links, .nav-actions { display:none; }
      .nav-hamburger { display:block; }
      nav { padding:0 1rem; }
      .nav-inner { gap:.5rem; }
    }

    /* ─── HERO ─── */
    .hero { position:relative; min-height:100vh; display:flex; align-items:center; overflow:hidden; margin-top:-110px; padding-top:110px; background-size:cover; background-position:center; }
    .hero-overlay { position:absolute; inset:0; background:rgba(255,255,255,0.6); }
    .hero-glow1 { position:absolute; top:25%; left:25%; width:384px; height:384px; border-radius:50%; background:radial-gradient(circle,rgba(0,175,240,.08),transparent 70%); filter:blur(40px); pointer-events:none; }
    .hero-glow2 { position:absolute; bottom:25%; right:25%; width:320px; height:320px; border-radius:50%; background:radial-gradient(circle,rgba(14,182,71,.10),transparent 70%); filter:blur(40px); pointer-events:none; }
    .hero-glow3 { position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); width:600px; height:600px; border-radius:50%; background:radial-gradient(circle,rgba(124,58,237,.05),transparent 70%); filter:blur(60px); pointer-events:none; }

    .hero-inner { max-width:1280px; margin:0 auto; padding:5rem 2rem; width:100%; position:relative; z-index:1; display:grid; grid-template-columns:50% 50%; gap:2rem; align-items:center; }

    /* hero text */
    .hero-eyebrow { display:inline-flex; align-items:center; gap:.5rem; padding:.35rem .9rem; border:1px solid rgba(0,175,240,.3); background:rgba(0,175,240,.08); border-radius:999px; font-size:.7rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:var(--cyan); margin-bottom:1.5rem; }
    .eyebrow-dot { width:6px; height:6px; border-radius:50%; background:var(--green); animation:blink 1.8s ease-in-out infinite; }
    @keyframes blink { 0%,100%{opacity:1;} 50%{opacity:.4;} }

    .hero-h1 { font-family:'Inter',sans-serif; font-size:clamp(2rem,4.2vw,3.4rem); font-weight:700; color:#1a1a2e; line-height:1.1; letter-spacing:-.04em; margin-top:-2rem; margin-bottom:1.5rem; }
    .hero-h1 .c1 { color:var(--cyan); }
    .hero-h1 .c2 { color:var(--green); }

    .hero-sub-big { color:var(--s7); font-size:1.1rem; font-weight:600; max-width:500px; line-height:1.6; margin-bottom:.75rem; }
    .hero-sub { color:var(--s6); font-size:.95rem; max-width:480px; line-height:1.7; margin-bottom:2rem; }

    .hero-actions { display:flex; gap:1rem; flex-wrap:wrap; margin-bottom:2.5rem; }
    .btn-primary { display:inline-flex; align-items:center; gap:.5rem; padding:.85rem 2rem; background:linear-gradient(135deg,var(--cyan),var(--cyan2)); color:#fff; font-weight:700; font-size:.95rem; border-radius:12px; text-decoration:none; border:none; cursor:pointer; box-shadow:0 6px 24px rgba(0,175,240,.35); transition:transform .2s,box-shadow .2s; font-family:inherit; }
    .btn-primary:hover { transform:translateY(-2px); box-shadow:0 10px 32px rgba(0,175,240,.45); }
    .btn-ghost { display:inline-flex; align-items:center; gap:.75rem; padding:.85rem 2rem; background:rgba(255,255,255,.07); border:1px solid rgba(255,255,255,.18); color:#fff; font-weight:700; font-size:.95rem; border-radius:12px; text-decoration:none; cursor:pointer; backdrop-filter:blur(8px); transition:background .2s; font-family:inherit; }
    .btn-ghost:hover { background:rgba(255,255,255,.13); }
    .play-ring { width:32px; height:32px; border-radius:50%; background:rgba(14,182,71,.2); border:1px solid rgba(14,182,71,.4); display:flex; align-items:center; justify-content:center; }

    .hero-chips { display:flex; flex-wrap:wrap; gap:.6rem; }
    .chip { display:flex; align-items:center; gap:.4rem; padding:.35rem .85rem; background:var(--cyan); border-radius:999px; font-size:.75rem; color:#fff; font-weight:600; }
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
    .hcard-active { background:#fff; border-color:rgba(255,255,255,.2); box-shadow:none; z-index:20; overflow:hidden; animation:cardGlow 3s ease-in-out infinite; }
    .hcard-dim { background:var(--navy4); border-color:rgba(255,255,255,.1); opacity:.6; z-index:10; transform:scale(.95); overflow:hidden; }
    @keyframes cardGlow { 0%,100% { box-shadow:none; } 50% { box-shadow:none; } }

    /* CARD 1 content live call */
    .card1-inner { padding:1.5rem; display:flex; flex-direction:column; height:100%; color:var(--navy2); overflow:hidden; }
    .card1-caller { display:flex; align-items:center; gap:.75rem; margin-bottom:1rem; }
    .caller-av { width:48px; height:48px; border-radius:50%; background:linear-gradient(135deg,var(--cyan),var(--green)); display:flex; align-items:center; justify-content:center; color:#fff; box-shadow:0 4px 12px rgba(0,175,240,.3); }
    .caller-av .material-symbols-outlined { font-size:1.5rem; }
    .caller-label { font-size:.6rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:var(--cyan); }
    .caller-name { font-size:1.05rem; font-weight:800; color:var(--navy2); }
    .live-pill { display:flex; align-items:center; gap:.3rem; padding:.25rem .6rem; background:rgba(34,197,94,.12); border:1px solid rgba(34,197,94,.3); border-radius:999px; font-size:.6rem; font-weight:700; color:#16a34a; animation:livefade 2s ease-in-out infinite; }
    @keyframes livefade { 0%,100%{opacity:1;} 50%{opacity:.6;} }
    .live-dot { width:5px; height:5px; border-radius:50%; background:#16a34a; }
    .card1-bubble { flex:1; background:linear-gradient(to bottom,#EBF8FF,#F0FFF4); border:1px solid rgba(0,175,240,.2); border-radius:16px; padding:1rem; }
    .bubble-row { display:flex; align-items:flex-start; gap:.6rem; margin-bottom:.5rem; }
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

    /* CARD 2 progress check */
    .card2-inner { padding:.75rem 1.5rem 1.5rem; display:flex; flex-direction:column; height:100%; overflow:hidden; }
    .card2-header { display:flex; align-items:center; gap:.75rem; margin-bottom:1rem; }
    .card2-av-wrap { position:relative; }
    .card2-av { width:48px; height:48px; border-radius:50%; background:rgba(59,122,158,.1); display:flex; align-items:center; justify-content:center; }
    .card2-av .material-symbols-outlined { color:#3B7A9E; }
    .card2-online { position:absolute; bottom:0; right:0; width:12px; height:12px; background:#22c55e; border:2px solid #fff; border-radius:50%; animation:blink 1.8s ease-in-out infinite; }
    .card2-title-row .sub { font-size:.65rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:#2C5F8A; }
    .card2-title-row .main { font-size:1.1rem; font-weight:800; }
    .task-list { background:rgba(255,255,255,.4); border:1px solid rgba(255,255,255,.4); border-radius:12px; padding:.75rem; flex:1; display:flex; flex-direction:column; gap:.4rem; margin-bottom:.75rem; }
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

    /* CARD 3 call logs */
    .card3-inner { padding:.75rem 1.5rem 1.5rem; display:flex; flex-direction:column; height:100%; overflow:hidden; }
    .card3-title { font-size:1.05rem; font-weight:800; display:flex; align-items:center; gap:.5rem; margin-bottom:.75rem; }
    .log-item { background:rgba(255,255,255,.3); border:1px solid #B8D8EC; border-radius:12px; padding:.6rem .8rem; display:flex; align-items:center; gap:.6rem; margin-bottom:.4rem; }
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
    .card-r1 { padding:.75rem 1.5rem 1.5rem; display:flex; flex-direction:column; height:100%; overflow:hidden; }
    .sched-header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1rem; }
    .sched-label { font-size:.65rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:#2C5F8A; }
    .sched-num { font-size:1.6rem; font-weight:900; color:var(--navy2); }
    .sched-pct { font-size:1.05rem; font-weight:800; color:#3B7A9E; }
    .task-items { flex:1; display:flex; flex-direction:column; gap:.4rem; }
    .ti { display:flex; align-items:center; gap:.5rem; background:#E8F4FC; padding:.5rem .7rem; border-radius:12px; border:1px solid #B8D8EC; }
    .ti .material-symbols-outlined { font-size:1.1rem; flex-shrink:0; }
    .ti-text .ti-name { font-size:.8rem; font-weight:700; color:var(--navy2); }
    .ti-text .ti-meta { font-size:.6rem; color:#4A7B9E; }
    .ti.dim { opacity:.6; background:transparent; border:none; }
    .sched-foot { border-top:1px solid #B8D8EC; padding-top:.75rem; display:flex; justify-content:space-between; font-size:.65rem; font-weight:700; color:#4A7B9E; margin-top:auto; }

    /* card r2 daily report */
    .rpt-inner { padding:.75rem 1.5rem 1.5rem; display:flex; flex-direction:column; height:100%; overflow:hidden; }
    .rpt-title { font-size:1.1rem; font-weight:800; display:flex; align-items:center; gap:.5rem; margin-bottom:1rem; }
    .rpt-box { background:rgba(255,255,255,.4); border:1px solid rgba(255,255,255,.4); border-radius:16px; padding:.75rem; margin-bottom:.6rem; }
    .rpt-row { display:flex; justify-content:space-between; align-items:center; margin-bottom:.5rem; }
    .rpt-row .rl { font-size:.65rem; font-weight:700; color:#2C5F8A; }
    .rpt-row .rv { font-size:1.1rem; font-weight:900; color:#22c55e; }
    .progress-bar { height:8px; background:#B8D8EC; border-radius:4px; overflow:hidden; margin-bottom:.5rem; }
    .progress-fill { height:100%; width:60%; background:#22c55e; border-radius:4px; }
    .rpt-meta { display:flex; justify-content:space-between; font-size:.6rem; color:#4A7B9E; }
    .rpt-preview { background:rgba(255,255,255,.3); border:1px solid rgba(255,255,255,.4); border-radius:12px; padding:.6rem; margin-bottom:.6rem; }
    .rpt-preview .rp-label { font-size:.65rem; font-weight:700; color:var(--navy2); margin-bottom:.3rem; }
    .rpt-preview .rp-text { font-size:.7rem; color:#4A7B9E; font-style:italic; }
    .rpt-btn { background:#3B7A9E; color:#fff; border:none; border-radius:12px; padding:.6rem; font-size:.65rem; font-weight:700; cursor:pointer; letter-spacing:.05em; text-align:center; }

    /* card r3 stats */
    .stats-inner-card { padding:.75rem 1.5rem 1.5rem; display:flex; flex-direction:column; height:100%; overflow:hidden; }
    .stats-grid { display:grid; grid-template-columns:1fr 1fr; gap:.75rem; flex:1; }
    .stat-box { background:rgba(255,255,255,.3); border:1px solid #B8D8EC; border-radius:12px; padding:.75rem; text-align:center; }
    .stat-box .sn { font-size:1.3rem; font-weight:900; color:var(--navy2); font-family:'Inter',sans-serif; }
    .stat-box .sl { font-size:.6rem; font-weight:700; color:#4A7B9E; margin-top:.2rem; }
    .stat-box .sn.green { color:#22c55e; }
    .stat-box .sn.blue { color:#3B7A9E; }
    .procrastination { background:rgba(59,122,158,.05); border:1px solid rgba(59,122,158,.2); border-radius:12px; padding:.75rem; text-align:center; font-size:.65rem; font-weight:700; color:#3B7A9E; letter-spacing:.05em; margin-top:.75rem; }

    /* ─── BUILT FOR TEAMS ─── */
    .built-for-teams { width:100%; padding:2.5rem 2rem; background:rgba(26,37,58,.85); backdrop-filter:blur(14px); -webkit-backdrop-filter:blur(14px); border-top:1px solid rgba(255,255,255,.06); border-bottom:1px solid rgba(255,255,255,.06); text-align:center; }
    .bft-heading { font-family:'Inter',sans-serif; font-size:clamp(1.3rem,2.5vw,1.8rem); font-weight:700; color:#fff; line-height:1.15; letter-spacing:-.03em; margin:0; }

    /* ─── SECTION COMMONS ─── */
    .section { padding:7rem 2rem; overflow-x:hidden; }
    .sec-inner { max-width:1280px; margin:0 auto; }
    .eyebrow { display:inline-flex; align-items:center; gap:.5rem; padding:.35rem .9rem; background:#fff; border:1px solid var(--s3); border-radius:8px; font-size:.7rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:var(--cyan); margin-bottom:1.5rem; box-shadow:0 1px 4px rgba(0,0,0,.06); }
    .eyebrow .material-symbols-outlined { font-size:16px; }
    .eyebrow-dark { background:rgba(255,255,255,.07); border-color:rgba(255,255,255,.12); color:var(--cyan); }
    .sec-h2 { font-family:'Inter',sans-serif; font-size:clamp(2.2rem,4.5vw,3.3rem); font-weight:700; letter-spacing:-.04em; color:var(--s9); margin-bottom:1rem; }
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
    .s4 .step-icon{background:#FFF7ED;color:var(--orange);} .s4:hover{border-color:rgba(249,115,22,.3);} .s4 .step-num{background:rgba(249,115,22,.1);color:var(--orange);}

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

    /* ─── INTEGRATIONS GRID ─── */
    .int-bg { background:var(--s1); }
    .int-grid { display:grid; grid-template-columns:repeat(6,1fr); gap:1.25rem; max-width:1080px; margin:0 auto; }
    .int-card { background:#fff; border:1px solid var(--s3); border-radius:18px; padding:1.5rem 1rem; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:.85rem; text-align:center; transition:border-color .3s,box-shadow .3s,transform .3s; box-shadow:0 1px 6px rgba(0,0,0,.04); }
    .int-card:hover { transform:translateY(-4px); box-shadow:0 10px 30px rgba(0,0,0,.08); border-color:rgba(0,175,240,.3); }
    .ilogo { width:56px; height:56px; display:flex; align-items:center; justify-content:center; opacity:1; }
    .ilogo svg { width:100%; height:100%; }
    .int-name { font-size:.8rem; font-weight:800; color:var(--s7); }
    .fc2 .feat-ico{background:rgba(14,182,71,.1);color:var(--green);} .fc2:hover{border-color:rgba(14,182,71,.3);}
    .fc3 .feat-ico{background:rgba(124,58,237,.1);color:var(--purple);} .fc3:hover{border-color:rgba(124,58,237,.3);}
    .fc4 .feat-ico{background:rgba(249,115,22,.1);color:var(--orange);} .fc4:hover{border-color:rgba(249,115,22,.3);}

    /* ─── BUILT FOR (INDUSTRIES) ─── */
    .ind-bg { background:#fff; }
    .ind-grid { display:grid; grid-template-columns:1fr 1fr; gap:1.5rem; max-width:1100px; margin:0 auto; }
    .ind-card { background:var(--s1); border:1px solid var(--s3); border-radius:24px; padding:2.25rem; display:flex; flex-direction:column; gap:1.25rem; transition:border-color .3s,box-shadow .3s,transform .3s; }
    .ind-card:hover { transform:translateY(-4px); box-shadow:0 14px 40px rgba(0,0,0,.08); border-color:rgba(0,175,240,.3); }
    .ind-head { display:flex; align-items:center; gap:.85rem; }
    .ind-ico { width:48px; height:48px; border-radius:14px; background:var(--cyan); color:#fff; display:flex; align-items:center; justify-content:center; font-size:1.4rem; box-shadow:0 6px 16px rgba(0,175,240,.35); flex-shrink:0; }
    .ind-ico.green { background:var(--green); box-shadow:0 6px 16px rgba(14,182,71,.35); }
    .ind-ico .material-symbols-outlined { font-variation-settings:'FILL' 1; }
    .ind-title { font-size:1.35rem; font-weight:900; color:var(--s9); margin:0; }
    .ind-tag { font-size:.9rem; font-weight:800; color:var(--s6); }
    .ind-desc { font-size:.95rem; color:var(--s6); line-height:1.7; }
    .ind-flow { background:#fff; border:1px solid var(--s3); border-radius:14px; padding:1rem 1.25rem; font-size:.82rem; font-weight:700; color:var(--s7); display:flex; align-items:center; gap:.5rem; flex-wrap:wrap; }
    .ind-flow .dot { width:8px; height:8px; border-radius:50%; background:var(--cyan); flex-shrink:0; }
    .ind-flow .dot.green { background:var(--green); }
    .ind-uses { list-style:none; display:flex; flex-direction:column; gap:.55rem; }
    .ind-uses li { display:flex; align-items:flex-start; gap:.7rem; font-size:.88rem; color:var(--s7); font-weight:600; }
    .ind-uses li::before { content:''; width:16px; height:16px; border-radius:50%; background:rgba(0,175,240,.15); border:1.5px solid rgba(0,175,240,.4); flex-shrink:0; margin-top:2px; }
    .ind-uses.green li::before { background:rgba(14,182,71,.15); border-color:rgba(14,182,71,.4); }
    .gf { position:relative; width:100%; }
    .gf svg { display:block; width:100%; height:auto; overflow:visible; }
    .gf .edge { fill:none; stroke:#CBD5E1; stroke-width:2; }
    .gf .edge.alive { stroke:#00AFF0; stroke-dasharray:6 8; stroke-linecap:round; animation:gfDash 1.3s linear infinite; }
    .gf.green .edge.alive { stroke:#0EB647; }
    .gf .gfline { fill:none; stroke:#E2E8F0; stroke-width:2; stroke-linecap:round; }
    .gf .gf-arr { fill:#00AFF0; }
    .gf.green .gf-arr { fill:#0EB647; }
    .gf-node { display:flex; flex-direction:column; align-items:center; justify-content:center; gap:5px; width:74px; height:100px; padding:8px 6px; border-radius:20px; background:#fff; border:1.5px solid #E2E8F0; box-shadow:0 6px 16px rgba(15,23,42,.06); box-sizing:border-box; text-align:center; }
    .gf-node .gf-ring { width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center; background:rgba(0,175,240,.1); color:#00AFF0; position:relative; margin-bottom:6px; }
    .gf.green .gf-node .gf-ring { background:rgba(14,182,71,.1); color:#0EB647; }
    .gf-node .gf-ring::after { content:''; position:absolute; inset:-3px; border-radius:50%; border:1.5px solid rgba(0,175,240,.35); animation:gfPing 2.6s ease-out infinite; }
    .gf.green .gf-node .gf-ring::after { border-color:rgba(14,182,71,.35); }
    .gf-node .gf-ring .material-symbols-outlined { font-size:20px; }
    .gf-node .gf-name { font-family:'Inter',sans-serif; font-size:11px; font-weight:800; color:#334155; line-height:1.05; }
    .gf-node .gf-stage { font-family:'Inter',sans-serif; font-size:8px; font-weight:800; color:#64748B; letter-spacing:.6px; text-transform:uppercase; }
    .gf-node.gf-hub { width:92px; height:150px; padding:18px 8px; border-radius:28px; border-width:2px; border-color:#CBD5E1; box-shadow:0 10px 26px rgba(0,175,240,.18); }
    .gf.green .gf-node.gf-hub { box-shadow:0 10px 26px rgba(14,182,71,.18); }
    .gf-node.gf-hub .gf-ring { width:52px; height:52px; margin-bottom:8px; }
    .gf-node.gf-hub .gf-ring::before { content:''; position:absolute; inset:-6px; border-radius:50%; border:2px solid rgba(0,175,240,.25); animation:gfSpin 5s linear infinite; }
    .gf.green .gf-node.gf-hub .gf-ring::before { border-top-color:#0EB647; border-left-color:#0EB647; }
    .gf-node.gf-hub .gf-ring .material-symbols-outlined { font-size:26px; }
    .gf-node.gf-hub .gf-name { font-size:13px; }
    @keyframes gfDash { to { stroke-dashoffset:-14; } }
    @keyframes gfPing { 0%{transform:scale(1);opacity:.7} 70%{transform:scale(1.4);opacity:0} 100%{opacity:0} }
    @keyframes gfSpin { to { transform:rotate(360deg); } }
    .btn-green { background:linear-gradient(135deg,var(--green),var(--green2)) !important; box-shadow:0 6px 24px rgba(14,182,71,.35) !important; }
    .btn-green:hover { box-shadow:0 10px 32px rgba(14,182,71,.45) !important; }

    /* ─── AI MANAGER SECTION (dark) ─── */
    .ai-mgr-bg { background:var(--navy); position:relative; overflow:hidden; }
    .ai-mgr-bg::before { content:''; position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); width:800px; height:800px; background:radial-gradient(circle,rgba(0,175,240,.07),transparent 70%); pointer-events:none; }
    .ai-mgr-grid { display:grid; grid-template-columns:1fr 1fr; gap:4rem; align-items:center; }
    .ai-mgr-text h3 { font-family:'Inter',sans-serif; font-size:clamp(1.8rem,3.4vw,2.7rem); font-weight:700; color:#fff; letter-spacing:-.04em; margin-bottom:1rem; }
    .ai-mgr-text h3 span { color:var(--cyan); }
    .ai-mgr-text p { font-size:.95rem; color:rgba(255,255,255,.65); line-height:1.75; margin-bottom:1rem; }
    .ai-mgr-bullets { display:flex; flex-direction:column; gap:.75rem; margin-top:1.5rem; }
    .ai-bullet { display:flex; align-items:flex-start; gap:.75rem; font-size:.875rem; color:rgba(255,255,255,.75); }
    .ai-bullet-icon { width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-top:1px; }
    .ai-bullet-icon .material-symbols-outlined { font-size:1rem; }
    .bi-cyan { background:rgba(0,175,240,.15); color:var(--cyan); }
    .bi-green { background:rgba(14,182,71,.15); color:var(--green); }
    .bi-purple { background:rgba(124,58,237,.15); color:var(--purple); }
    .bi-orange { background:rgba(249,115,22,.15); color:var(--orange); }

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
    .wf-num { font-family:'Inter',sans-serif; font-size:1.5rem; font-weight:900; margin-bottom:.4rem; }
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
    .ri-o { background:rgba(249,115,22,.1); color:var(--orange); }
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
    .rb-o { background:rgba(249,115,22,.15); color:var(--orange); }
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
    .vi4{background:rgba(249,115,22,.15);color:var(--orange);}
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
    .mobile-content h2 { font-family:'Inter',sans-serif; font-size:clamp(2.2rem,4.5vw,3.3rem); font-weight:700; letter-spacing:-.04em; color:var(--s9); margin-bottom:1rem; }
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
    .phone-sub { color:rgba(255,255,255,.3); font-size:9px; }
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
    .faq-bg { }
    .faq-bg .sec-h2 { color:var(--s9); }
    .faq-bg .sec-h2 span { color:var(--cyan); }
    .faq-list { max-width:760px; margin:0 auto; }
    .faq-item { border:1px solid var(--s3); border-radius:14px; overflow:hidden; margin-bottom:.75rem; background:#fff; box-shadow:0 1px 4px rgba(0,0,0,.04); }
    .faq-q { width:100%; padding:1.4rem 1.75rem; display:flex; align-items:center; justify-content:space-between; background:none; border:none; cursor:pointer; text-align:left; font-size:1.05rem; font-weight:600; color:var(--s9); font-family:'Inter',sans-serif; }
    .faq-q .material-symbols-outlined { color:var(--cyan); transition:transform .3s; flex-shrink:0; }
    .faq-q.open .material-symbols-outlined { transform:rotate(45deg); }
    .faq-a { padding:0 1.75rem 1.4rem; font-size:.9rem; color:var(--s6); line-height:1.7; display:none; }
    .faq-a.open { display:block; }

    /* ─── CTA ─── */
    .cta-bg { background:var(--navy); text-align:center; position:relative; overflow:hidden; }
    .cta-bg::before { content:''; position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); width:600px; height:600px; background:radial-gradient(circle,rgba(0,175,240,.12),transparent 70%); pointer-events:none; }
    .cta-inner { position:relative; z-index:1; }
    .cta-h2 { font-family:'Inter',sans-serif; font-size:clamp(2.2rem,4.5vw,3.5rem); font-weight:700; color:var(--s9); letter-spacing:-.04em; margin-bottom:1rem; }
    .cta-h2 span { color:var(--cyan); }
    .cta-sub { font-size:1.05rem; color:var(--s6); margin-bottom:2.5rem; }
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
    .footer-social a { width:36px; height:36px; border-radius:8px; border:1px solid rgba(255,255,255,.15); display:flex; align-items:center; justify-content:center; color:rgba(255,255,255,.3); text-decoration:none; font-size:1rem; transition:border-color .2s,color .2s; }
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
    .modal h3 { font-size:1.8rem; font-weight:700; color:var(--s9); margin-bottom:.5rem; font-family:'Inter',sans-serif; letter-spacing:-.03em; }
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
      .hero { min-height:100vh; min-height:100dvh; width:100%; }
      .hero-inner { grid-template-columns:1fr; text-align:center; justify-items:center; width:100%; }
      .hero-inner > div:first-child { display:flex; flex-direction:column; align-items:center; width:100%; }
      .hero-actions { justify-content:center; width:100%; }
      .hero-sub-big,.hero-sub { max-width:36rem; }
      .hero-visual { display:none; }
      .steps-row,.feat-grid,.voip-steps,.pw-grid,.exec-tiers,.exec-metrics,.int-categories,.roles-grid { grid-template-columns:1fr 1fr; }
      .int-grid { grid-template-columns:repeat(4,1fr); }
      .ai-mgr-grid,.retro-grid { grid-template-columns:1fr; }
      .ind-grid { grid-template-columns:1fr; }
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
      .hero { margin-top:-70px; padding-top:70px; min-height:100vh; min-height:100dvh; width:100vw; max-width:100%; display:flex; align-items:center; justify-content:center; }
      .hero-inner { padding:2.5rem 1.25rem 3rem; gap:0; width:100%; min-height:calc(100vh - 70px); min-height:calc(100dvh - 70px); display:flex; flex-direction:column; justify-content:center; align-items:center; }
      .hero-h1 { font-size:clamp(1.75rem,7vw,2.2rem); line-height:1.15; }
      .hero-sub-big { font-size:.95rem; }
      .footer-grid { grid-template-columns:1fr 1fr; gap:2rem 1.5rem; }
      .hero-chips { gap:.5rem; justify-content:center; }
      .hero-stats { display:none; }
      .stats-bar { padding:1.5rem 1rem; }
      .sb-inner { gap:1rem; }
      .sb-num { font-size:1.2rem; }
      .teams-grid { grid-template-columns:1fr; }
    }
    @media(max-width:640px) {
      .section { padding:3rem 1.25rem; }
      .steps-row,.feat-grid,.voip-steps,.pw-grid,.exec-tiers,.exec-metrics,.int-categories,.roles-grid,.teams-grid { grid-template-columns:1fr; }
      .int-grid { grid-template-columns:repeat(2,1fr); }
      .footer-grid { grid-template-columns:1fr; gap:2rem; }
      .hero { background-position:center top; width:100vw; max-width:100%; min-height:100vh; min-height:100dvh; }
      .hero-inner { padding:3.5rem 1.25rem 3rem; width:100%; min-height:inherit; text-align:left; justify-items:start; align-items:flex-start; gap:1.5rem; }
      .hero-inner > div:first-child { align-items:flex-start; text-align:left; gap:.5rem; }
      .hero-h1 { font-size:clamp(2rem,9vw,2.4rem); margin-bottom:1.25rem; text-align:left; line-height:1.12; }
      .hero-sub-big, .hero-sub { text-wrap:balance; }
      .hero-chips { flex-wrap:wrap; overflow:visible; justify-content:flex-start; align-content:flex-start; padding-bottom:0; width:100%; text-align:left; }
      .chip { white-space:normal; flex-shrink:1; text-align:left; }
      .hero-actions { flex-direction:column; width:100%; max-width:320px; margin:0 0 2rem 0; align-items:flex-start; }
      .hero-chips { margin-top:.5rem; }
      .hero-actions a, .hero-actions button { width:auto; min-width:180px; justify-content:center; min-height:44px; font-size:1rem; }
      .footer-bottom { flex-direction:column; gap:.5rem; text-align:center; }
      .us-banner { flex-direction:column; text-align:center; }
      .us-badge { margin:0 auto; }
      .hero-inner { padding:3.5rem 1.25rem 3rem; }
      .hero-h1 { font-size:clamp(2rem,9vw,2.4rem); }
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
    @media(prefers-reduced-motion:reduce) { *,*::before,*::after { animation-duration:.001ms !important; } .reveal-up,.reveal-left,.reveal-right,.reveal-scale,.reveal-blur,.reveal-rotate,.reveal-flip,.reveal-zoom-bounce,.reveal-clip,.reveal-perspective,.reveal-elastic,.reveal-pop,.stagger-item,.hero-reveal { opacity:1 !important; } .split-inner { transform:none !important; } }

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
    .tc4{background:rgba(249,115,22,.1);color:var(--orange);}
    .team-title { font-size:1rem; font-weight:800; color:var(--s9); margin-bottom:.75rem; }
    .team-desc { font-size:.85rem; color:var(--s6); line-height:1.65; }
    .int-logos-hero { display:flex; justify-content:center; align-items:center; flex-wrap:wrap; gap:2rem; max-width:100%; }
    .int-logo { display:flex; align-items:center; gap:.5rem; font-size:1rem; font-weight:800; color:var(--s7); opacity:.5; transition:opacity .3s; flex-shrink:0; }
    .int-logo:hover { opacity:1; }
    .int-logo img { width:28px; height:28px; flex-shrink:0; }
    .int-logo .material-symbols-outlined { flex-shrink:0; }

    /* ─── SPLIT ALTERNATING SECTIONS ─── */
    .split-section { padding:6rem 2rem; overflow:hidden; }
    .split-inner { max-width:1120px; margin:0 auto; display:grid; grid-template-columns:1fr 1fr; gap:4rem; align-items:center; }
    .split-inner.reverse { direction:rtl; }
    .split-inner.reverse > * { direction:ltr; }
    .split-content .eyebrow-split { display:inline-flex; align-items:center; gap:.5rem; padding:.35rem .9rem; border:1px solid rgba(0,175,240,.25); background:rgba(0,175,240,.06); border-radius:999px; font-size:.7rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:var(--cyan); margin-bottom:1.25rem; }
    .split-content .eyebrow-split .material-symbols-outlined { font-size:1rem; }
    .split-content .eyebrow-split.green { border-color:rgba(14,182,71,.25); background:rgba(14,182,71,.06); color:var(--green); }
    .split-content h2 { font-family:'Inter',sans-serif; font-size:clamp(1.6rem,3vw,2.4rem); font-weight:700; line-height:1.15; letter-spacing:-.03em; margin-bottom:1.25rem; color:var(--s9); }
    .split-content h2 span { color:var(--cyan); }
    .split-content h2 span.green { color:var(--green); }
    .split-content h2 span.gold { color:var(--gold); }
    .split-content h2 span.orange { color:var(--orange); }
    .split-content p { font-size:1.05rem; line-height:1.7; margin-bottom:1.5rem; color:var(--s6); }
    .split-content ul { list-style:none; display:flex; flex-direction:column; gap:.75rem; }
    .split-content ul li { display:flex; align-items:flex-start; gap:.75rem; font-size:.95rem; line-height:1.5; font-weight:600; color:var(--s7); }
    .split-content ul li .li-icon { width:28px; height:28px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; font-size:1rem; }
    .split-content ul li .li-icon.cyan { background:rgba(0,175,240,.15); color:var(--cyan); }
    .split-content ul li .li-icon.green { background:rgba(14,182,71,.15); color:var(--green); }
    .split-content ul li .li-icon.gold { background:rgba(245,158,11,.15); color:var(--gold); }
    .split-content ul li .li-icon.orange { background:rgba(249,115,22,.15); color:var(--orange); }

    /* Split visuals / infographics */
    .split-visual { display:flex; align-items:center; justify-content:center; }
    .split-visual svg { width:100%; max-width:480px; height:auto; }
    .split-visual img { width:100%; max-width:480px; height:auto; border-radius:16px; box-shadow:0 8px 32px rgba(0,0,0,.08); }

    /* Problem icon cards */
    .problem-cards { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
    .pcard { background:#fff; border:1px solid var(--s3); border-radius:16px; padding:1.25rem; text-align:center; transition:transform .2s,box-shadow .2s; }
    .pcard:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(0,0,0,.06); }
    .pcard .pcard-icon { font-size:1.75rem; margin-bottom:.5rem; }
    .pcard .pcard-text { font-size:.8rem; color:var(--s6); line-height:1.4; font-weight:600; }

    /* Hub diagram */
    .hub-wrap { position:relative; width:100%; max-width:420px; margin:0 auto; }
    .hub-center { width:90px; height:90px; border-radius:50%; background:linear-gradient(135deg,var(--cyan),var(--cyan2)); display:flex; align-items:center; justify-content:center; margin:0 auto; position:relative; z-index:2; box-shadow:0 0 40px rgba(0,175,240,.3); }
    .hub-center .material-symbols-outlined { font-size:2.2rem; color:#fff; }
    .hub-spokes { position:absolute; inset:0; }
    .hub-spoke { position:absolute; width:64px; height:64px; border-radius:14px; background:#fff; border:1px solid var(--s3); display:flex; align-items:center; justify-content:center; box-shadow:0 4px 12px rgba(0,0,0,.06); }
    .hub-spoke .material-symbols-outlined { font-size:1.5rem; color:var(--s7); }
    .hub-spoke.s1 { top:0; left:50%; transform:translateX(-50%); }
    .hub-spoke.s2 { top:50%; right:0; transform:translateY(-50%); }
    .hub-spoke.s3 { bottom:0; left:50%; transform:translateX(-50%); }
    .hub-spoke.s4 { top:50%; left:0; transform:translateY(-50%); }

    /* Call flow */
    .flow-steps { display:flex; flex-direction:column; gap:1rem; }
    .flow-step { display:flex; align-items:center; gap:1rem; background:#fff; border:1px solid var(--s3); border-radius:14px; padding:1rem 1.25rem; }
    .flow-step .fs-num { width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:900; font-size:.8rem; flex-shrink:0; color:#fff; }
    .flow-step .fs-num.cyan { background:var(--cyan); }
    .flow-step .fs-num.green { background:var(--green); }
    .flow-step .fs-num.gold { background:var(--gold); }
    .flow-step .fs-text { font-size:.9rem; font-weight:700; color:var(--s9); }
    .flow-step .fs-sub { font-size:.78rem; color:var(--s5); font-weight:600; }
    .flow-arrow { text-align:center; color:var(--s4); font-size:1.2rem; }

    /* Status cards */
    .status-cards { display:flex; flex-direction:column; gap:.75rem; }
    .scard { background:#fff; border:1px solid var(--s3); border-radius:14px; padding:1rem 1.25rem; display:flex; align-items:center; gap:1rem; }
    .scard .sc-dot { width:12px; height:12px; border-radius:50%; flex-shrink:0; }
    .scard .sc-dot.green { background:var(--green); }
    .scard .sc-dot.orange { background:var(--orange); }
    .scard .sc-dot.red { background:#EF4444; }
    .scard .sc-text { font-size:.85rem; font-weight:700; color:var(--s9); }
    .scard .sc-sub { font-size:.75rem; color:var(--s5); }

    /* Flow diagram (left to right) */
    .ltr-flow { display:grid; grid-template-columns:1fr auto 1fr; gap:1.5rem; align-items:center; }
    .ltr-flow-col { display:flex; flex-direction:column; gap:.5rem; }
    .ltr-item { background:#fff; border:1px solid var(--s3); border-radius:10px; padding:.6rem .9rem; font-size:.8rem; font-weight:700; color:var(--s7); display:flex; align-items:center; gap:.5rem; }
    .ltr-item .material-symbols-outlined { font-size:1rem; }
    .ltr-mid { display:flex; flex-direction:column; align-items:center; gap:.25rem; }
    .ltr-mid .mid-box { background:linear-gradient(135deg,var(--cyan),var(--cyan2)); color:#fff; padding:.75rem 1rem; border-radius:12px; font-weight:800; font-size:.8rem; text-align:center; box-shadow:0 4px 16px rgba(0,175,240,.3); }
    .ltr-mid .mid-arrow { color:var(--s4); font-size:1.2rem; }

    /* Feedback mockup */
    .feedback-mock { background:#fff; border:1px solid var(--s3); border-radius:16px; padding:1.5rem; max-width:360px; margin:0 auto; }
    .fm-head { display:flex; align-items:center; gap:.5rem; margin-bottom:1rem; }
    .fm-head .fm-icon { width:32px; height:32px; border-radius:8px; background:rgba(0,175,240,.1); display:flex; align-items:center; justify-content:center; }
    .fm-head .fm-icon .material-symbols-outlined { font-size:1rem; color:var(--cyan); }
    .fm-head span { font-size:.8rem; font-weight:800; color:var(--s9); }
    .fm-stars { display:flex; gap:.25rem; margin-bottom:1rem; }
    .fm-stars .material-symbols-outlined { font-size:1.25rem; color:var(--orange); font-variation-settings:'FILL' 1; }
    .fm-input { width:100%; height:60px; border:1px solid var(--s3); border-radius:10px; padding:.75rem; font-size:.8rem; color:var(--s5); font-family:inherit; resize:none; margin-bottom:.75rem; }
    .fm-badge { display:inline-flex; align-items:center; gap:.35rem; background:rgba(14,182,71,.08); border:1px solid rgba(14,182,71,.2); border-radius:999px; padding:.3rem .75rem; font-size:.7rem; font-weight:700; color:var(--green); }
    .fm-badge .material-symbols-outlined { font-size:.85rem; }

    /* Proof badges */
    .proof-row { display:flex; justify-content:center; gap:1.5rem; flex-wrap:wrap; margin-top:2rem; }
    .proof-badge { background:#fff; border:1px solid var(--s3); border-radius:14px; padding:1rem 1.5rem; display:flex; align-items:center; gap:.75rem; }
    .proof-badge .pb-icon { width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; }
    .proof-badge .pb-icon.green { background:rgba(14,182,71,.1); color:var(--green); }
    .proof-badge .pb-icon.gray { background:var(--s2); color:var(--s5); }
    .proof-badge .pb-text { font-size:.85rem; font-weight:800; color:var(--s9); }
    .proof-badge .pb-sub { font-size:.7rem; color:var(--s5); font-weight:600; }

    /* Before/After */
    .ba-split { display:grid; grid-template-columns:1fr auto 1fr; gap:2rem; align-items:center; max-width:560px; margin:0 auto; }
    .ba-box { border-radius:16px; padding:1.5rem; text-align:center; }
    .ba-box.before { background:rgba(239,68,68,.06); border:1px solid rgba(239,68,68,.15); }
    .ba-box.after { background:rgba(14,182,71,.06); border:1px solid rgba(14,182,71,.15); }
    .ba-box .ba-icon { font-size:2rem; margin-bottom:.5rem; }
    .ba-box .ba-label { font-size:.8rem; font-weight:800; }
    .ba-box.before .ba-label { color:#EF4444; }
    .ba-box.after .ba-label { color:var(--green); }
    .ba-arrow { color:var(--s4); font-size:1.5rem; }

    @media(max-width:768px) {
      .split-inner, .split-inner.reverse { grid-template-columns:1fr; gap:2rem; }
      .split-inner.reverse { direction:ltr; }
      .problem-cards { grid-template-columns:1fr; }
      .ltr-flow { grid-template-columns:1fr; }
      .ltr-mid .mid-arrow { transform:rotate(90deg); }
      .ba-split { grid-template-columns:1fr; }
      .ba-arrow { transform:rotate(90deg); text-align:center; }
      .proof-row { flex-direction:column; align-items:center; }
    }

    /* ─── REVEAL ANIMATIONS ─── */
    @keyframes revealUp { from { opacity:0; transform:translateY(60px); } to { opacity:1; transform:translateY(0); } }
    @keyframes revealRotate { from { opacity:0; transform:rotate(-4deg) translateY(30px); } to { opacity:1; transform:rotate(0) translateY(0); } }
    @keyframes revealFlip { from { opacity:0; transform:perspective(600px) rotateX(-15deg) translateY(20px); } to { opacity:1; transform:perspective(600px) rotateX(0) translateY(0); } }
    @keyframes revealZoomBounce { 0% { opacity:0; transform:scale(0.7); } 60% { opacity:1; transform:scale(1.04); } 100% { opacity:1; transform:scale(1); } }
    @keyframes revealClip { from { clip-path:inset(100% 0 0 0); opacity:0; } to { clip-path:inset(0 0 0 0); opacity:1; } }
    @keyframes revealBlur { from { opacity:0; filter:blur(12px); transform:translateY(16px); } to { opacity:1; filter:blur(0); transform:translateY(0); } }
    @keyframes revealPerspective { from { opacity:0; transform:perspective(800px) rotateY(8deg) translateX(40px); } to { opacity:1; transform:perspective(800px) rotateY(0) translateX(0); } }
    @keyframes revealElastic { 0% { opacity:0; transform:scale(0.6); } 50% { opacity:1; transform:scale(1.06); } 70% { transform:scale(0.97); } 100% { opacity:1; transform:scale(1); } }
    @keyframes revealPop { 0% { opacity:0; transform:scale(0.5) rotate(-6deg); } 60% { opacity:1; transform:scale(1.05) rotate(1deg); } 100% { opacity:1; transform:scale(1) rotate(0); } }
    @keyframes revealAccordion { from { opacity:0; max-height:0; transform:translateY(20px); } to { opacity:1; max-height:600px; transform:translateY(0); } }
    @keyframes heroFadeLeft { from { opacity:0; transform:translateX(-40px); } to { opacity:1; transform:translateX(0); } }
    @keyframes heroFadeRight { from { opacity:0; transform:translateX(40px); } to { opacity:1; transform:translateX(0); } }
    @keyframes heroFadeUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
    @keyframes cardFloat { 0%,100% { transform:translateY(-50%) translateY(0); } 50% { transform:translateY(-50%) translateY(-6px); } }

    .reveal-up, .reveal-left, .reveal-right, .reveal-scale, .reveal-blur, .reveal-rotate, .reveal-flip, .reveal-zoom-bounce, .reveal-clip, .reveal-perspective, .reveal-elastic, .reveal-pop, .stagger-item { opacity:0; }
    .reveal-up.visible { animation:revealUp 1.2s cubic-bezier(0.22,1,0.36,1) forwards; }
    .reveal-left.visible { animation:revealUp 1.2s cubic-bezier(0.22,1,0.36,1) forwards; }
    .reveal-right.visible { animation:revealUp 1.2s cubic-bezier(0.22,1,0.36,1) forwards; }
    .reveal-scale.visible { animation:revealZoomBounce 1.3s cubic-bezier(0.22,1,0.36,1) forwards; }
    .reveal-blur.visible { animation:revealBlur 1.4s cubic-bezier(0.22,1,0.36,1) forwards; }
    .reveal-rotate.visible { animation:revealRotate 1.3s cubic-bezier(0.22,1,0.36,1) forwards; }
    .reveal-flip.visible { animation:revealFlip 1.3s cubic-bezier(0.22,1,0.36,1) forwards; }
    .reveal-zoom-bounce.visible { animation:revealZoomBounce 1.3s cubic-bezier(0.22,1,0.36,1) forwards; }
    .reveal-clip.visible { animation:revealClip 1.2s cubic-bezier(0.22,1,0.36,1) forwards; }
    .reveal-perspective.visible { animation:revealPerspective 1.3s cubic-bezier(0.22,1,0.36,1) forwards; }
    .reveal-elastic.visible { animation:revealElastic 1.4s cubic-bezier(0.22,1,0.36,1) forwards; }
    .reveal-pop.visible { animation:revealPop 1.2s cubic-bezier(0.22,1,0.36,1) forwards; }
    .stagger-item.visible { animation:revealUp .9s cubic-bezier(0.22,1,0.36,1) forwards; }
    .stagger-1 { animation-delay:.15s !important; }
    .stagger-2 { animation-delay:.3s !important; }
    .stagger-3 { animation-delay:.45s !important; }
    .stagger-4 { animation-delay:.6s !important; }

    .hero-reveal { opacity:0; animation:heroFadeLeft 1s cubic-bezier(0.22,1,0.36,1) forwards; }
    .hero-reveal-1 { animation-delay:.2s; }
    .hero-reveal-2 { animation-name:heroFadeRight; animation-delay:.4s; }
    .hero-reveal-3 { animation-name:heroFadeUp; animation-delay:.6s; }

    /* ─── VANTA CLOUDS BACKGROUND ─── */
    #vanta-bg { position:fixed; inset:0; z-index:0; }
    #vanta-bg canvas { display:block; }

    /* ─── SECTION OVERLAYS ─── */
    .hero { position:relative; z-index:2; }
    .split-section { position:relative; z-index:1; }
    .split-section.dark { background:linear-gradient(0deg, rgba(255,255,255,.6) 0%, white 25%, white 75%, rgba(255,255,255,.6) 100%); }
    .split-section.light { background:rgba(255,255,255,.6); backdrop-filter:blur(4px); -webkit-backdrop-filter:blur(4px); }
    .faq-bg { position:relative; z-index:1; background:rgba(255,255,255,.6); backdrop-filter:blur(4px); -webkit-backdrop-filter:blur(4px); }
    .faq-item { background:rgba(255,255,255,.85); }
    .cta-bg { position:relative; z-index:1; background:rgba(255,255,255,0.6); backdrop-filter:blur(4px); backdrop-filter:blur(4px); }
    footer { position:relative; z-index:1; }

    /* 3D scroll depth */
    .split-section { transform-style:preserve-3d; perspective:1200px; }
    .split-inner { will-change:transform; transition:transform .1s linear; }
  </style>
</head>
<body>

<!-- NAV -->
<nav id="navbar">
  <div class="nav-inner">
    <a href="/" class="nav-logo">
      <img src="/assets//logo/logo-dark-full.png" alt="GoalChaser.co" class="logo-light" />
      <img src="/assets//logo/logo-light-full.png" alt="GoalChaser.co" class="logo-dark" />
    </a>
    <ul class="nav-links">
      <li><a href="#how-it-works">How It Works</a></li>
      <li><a href="/goalchaser-for-textile">For Textile</a></li>
      <li><a href="/goalchaser-for-it">For IT</a></li>
      <li><a href="#faq">FAQ</a></li>
    </ul>
    <div class="nav-actions">
      <a href="#" onclick="openModal(event)" class="btn-primary" style="background:#fe904f;box-shadow:0 6px 24px rgba(254,144,79,.35);">Contact Sales</a>
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
    <a href="/goalchaser-for-textile">For Textile</a>
    <a href="/goalchaser-for-it">For IT</a>
    <a href="#faq">FAQ</a>
    <div class="mobile-actions">
      <a href="#" onclick="openModal(event)" class="btn-primary" style="background:#fe904f;box-shadow:0 6px 24px rgba(254,144,79,.35);">Contact Sales</a>
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

      <h1 class="hero-h1 hero-reveal hero-reveal-1" id="heroHeadline">
        Your team's <br> Productivity Partner
      </h1>

      <div class="hero-actions hero-reveal hero-reveal-2">
        <button class="btn-primary" onclick="openModal(event)" style="text-decoration:none;background:#fe904f;box-shadow:0 6px 24px rgba(254,144,79,.35);">
          <span class="material-symbols-outlined" style="font-size:20px;">headset_mic</span>
          Contact Sales
        </button>
      </div>

      <div class="hero-chips hero-reveal hero-reveal-3">
        <span class="chip" style="background:#00AFF0;"><span class="material-symbols-outlined" style="color:#fff;">mic</span>AI Voice Calls</span>
        <span class="chip" style="background:#0EB647;"><span class="material-symbols-outlined" style="color:#fff;">settings_input_antenna</span>Enterprise VoIP</span>
        <span class="chip" style="background:#FBBF24;"><span class="material-symbols-outlined" style="color:#fff;">groups</span>Personal &amp; Teams</span>
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

<!-- VANTA CLOUDS BACKGROUND -->
<div id="vanta-bg" aria-hidden="true"></div>

<!-- BUILT FOR TEAMS -->


<!-- SLIDE 1 -->
<section class="split-section dark">
  <div class="split-inner">
    <div class="split-content reveal-rotate">
      <h2>Running the company shouldn't mean <span>chasing</span> the team</h2>
      <ul>
        <li class="stagger-item stagger-1"><span class="li-icon cyan"><span class="material-symbols-outlined" style="font-size:1rem;">block</span></span>No more running after updates</li>
        <li class="stagger-item stagger-2"><span class="li-icon green"><span class="material-symbols-outlined" style="font-size:1rem;">block</span></span>No more interrupting your team for status</li>
        <li class="stagger-item stagger-3"><span class="li-icon gold"><span class="material-symbols-outlined" style="font-size:1rem;">trending_up</span></span>Lead the company, not the follow-ups</li>
      </ul>
    </div>
    <div class="split-visual reveal-zoom-bounce">
      <img src="/assets/corporate-infographics/1.png" alt="Running the company shouldn't mean chasing the team" loading="lazy" />
    </div>
  </div>
</section>

<!-- SLIDE 2 -->
<section class="split-section light">
  <div class="split-inner reverse">
    <div class="split-content reveal-flip">
      <h2>You shouldn't have to ask for updates <span class="orange">all</span> day</h2>
      <ul>
        <li class="stagger-item stagger-2"><span class="li-icon orange"><span class="material-symbols-outlined" style="font-size:1rem;">chat</span></span>Endless status-checking kills momentum</li>
        <li class="stagger-item stagger-3"><span class="li-icon cyan"><span class="material-symbols-outlined" style="font-size:1rem;">notifications</span></span>Constant pings pull focus from real work</li>
        <li class="stagger-item stagger-4"><span class="li-icon green"><span class="material-symbols-outlined" style="font-size:1rem;">battery_alert</span></span>Manual tracking drains your energy</li>
      </ul>
    </div>
    <div class="split-visual reveal-elastic">
      <img src="/assets/corporate-infographics/2.png" alt="You shouldn't have to ask for updates all day" loading="lazy" />
    </div>
  </div>
</section>

<!-- SLIDE 3 -->
<section class="split-section dark">
  <div class="split-inner">
    <div class="split-content reveal-clip">
      <h2>What if AI could handle the <span class="green">follow-ups</span>?</h2>
      <ul>
        <li class="stagger-item stagger-3"><span class="li-icon green"><span class="material-symbols-outlined" style="font-size:1rem;">smart_toy</span></span>AI checks in with your team, automatically</li>
        <li class="stagger-item stagger-1"><span class="li-icon cyan"><span class="material-symbols-outlined" style="font-size:1rem;">cable</span></span>Covers calls, chats, tasks &amp; reports</li>
        <li class="stagger-item stagger-2"><span class="li-icon gold"><span class="material-symbols-outlined" style="font-size:1rem;">bolt</span></span>One system, zero manual chasing</li>
      </ul>
    </div>
    <div class="split-visual reveal-rotate">
      <img src="/assets/corporate-infographics/3.png" alt="What if AI could handle the follow-ups" loading="lazy" />
    </div>
  </div>
</section>

<!-- SLIDE 4 -->
<section class="split-section light">
  <div class="split-inner reverse">
    <div class="split-content reveal-perspective">
      <h2>Meet GoalChaser <span class="gold">AI</span> powered productivity partner</h2>
      <ul>
        <li class="stagger-item stagger-1"><span class="li-icon gold"><span class="material-symbols-outlined" style="font-size:1rem;">support_agent</span></span>Your team's always-on AI assistant</li>
        <li class="stagger-item stagger-2"><span class="li-icon cyan"><span class="material-symbols-outlined" style="font-size:1rem;">devices</span></span>Works across desktop &amp; mobile</li>
        <li class="stagger-item stagger-3"><span class="li-icon green"><span class="material-symbols-outlined" style="font-size:1rem;">speed</span></span>Built to keep everyone moving forward</li>
      </ul>
    </div>
    <div class="split-visual reveal-zoom-bounce">
      <img src="/assets/corporate-infographics/4.png" alt="Meet GoalChaser AI powered productivity partner" loading="lazy" />
    </div>
  </div>
</section>

<!-- SLIDE 5 -->
<section class="split-section dark">
  <div class="split-inner">
    <div class="split-content reveal-pop">
      <h2>Connect the tools your team <span>already</span> uses</h2>
      <ul>
        <li class="stagger-item stagger-2"><span class="li-icon cyan"><span class="material-symbols-outlined" style="font-size:1rem;">link</span></span>Jira, Trello, Asana, Monday, ClickUp &amp; more</li>
        <li class="stagger-item stagger-3"><span class="li-icon green"><span class="material-symbols-outlined" style="font-size:1rem;">school</span></span>No new tools to learn</li>
        <li class="stagger-item stagger-4"><span class="li-icon orange"><span class="material-symbols-outlined" style="font-size:1rem;">settings_suggest</span></span>Fits right into your existing workflow</li>
      </ul>
    </div>
    <div class="split-visual reveal-flip">
      <img src="/assets/corporate-infographics/5.png" alt="Connect the tools your team already uses" loading="lazy" />
    </div>
  </div>
</section>

<!-- SLIDE 6 -->
<section class="split-section light">
  <div class="split-inner reverse">
    <div class="split-content reveal-rotate">
      <h2>GoalChaser reads what <span class="green">everyone</span> is working on</h2>
      <ul>
        <li class="stagger-item stagger-3"><span class="li-icon green"><span class="material-symbols-outlined" style="font-size:1rem;">task_alt</span></span>Understands tasks, boards &amp; progress</li>
        <li class="stagger-item stagger-1"><span class="li-icon orange"><span class="material-symbols-outlined" style="font-size:1rem;">psychology</span></span>Reads context, not just status labels</li>
        <li class="stagger-item stagger-2"><span class="li-icon cyan"><span class="material-symbols-outlined" style="font-size:1rem;">sync</span></span>Always in sync with real work</li>
      </ul>
    </div>
    <div class="split-visual reveal-clip">
      <img src="/assets/corporate-infographics/6.png" alt="GoalChaser reads what everyone is working on" loading="lazy" />
    </div>
  </div>
</section>

<!-- SLIDE 7 -->
<section class="split-section dark">
  <div class="split-inner">
    <div class="split-content reveal-zoom-bounce">
      <h2>AI follows up with your team through <span class="gold">voice</span> calls</h2>
      <ul>
        <li class="stagger-item stagger-1"><span class="li-icon gold"><span class="material-symbols-outlined" style="font-size:1rem;">call</span></span>Natural voice check-ins, not robotic pings</li>
        <li class="stagger-item stagger-2"><span class="li-icon cyan"><span class="material-symbols-outlined" style="font-size:1rem;">record_voice_over</span></span>Employees respond in real conversation</li>
        <li class="stagger-item stagger-3"><span class="li-icon orange"><span class="material-symbols-outlined" style="font-size:1rem;">favorite</span></span>Feels personal, not intrusive</li>
      </ul>
    </div>
    <div class="split-visual reveal-perspective">
      <img src="/assets/corporate-infographics/7.png" alt="AI follows up with your team through voice calls" loading="lazy" />
    </div>
  </div>
</section>

<!-- SLIDE 8 -->
<section class="split-section light">
  <div class="split-inner reverse">
    <div class="split-content reveal-flip">
      <h2>Finds what's slowing your team down and <span class="orange">resolves</span> it</h2>
      <ul>
        <li class="stagger-item stagger-2"><span class="li-icon orange"><span class="material-symbols-outlined" style="font-size:1rem;">warning</span></span>Detects delays, blockers &amp; bugs early</li>
        <li class="stagger-item stagger-3"><span class="li-icon green"><span class="material-symbols-outlined" style="font-size:1rem;">flag</span></span>Flags what's holding progress back</li>
        <li class="stagger-item stagger-4"><span class="li-icon cyan"><span class="material-symbols-outlined" style="font-size:1rem;">build</span></span>Helps clear the block, not just report it</li>
      </ul>
    </div>
    <div class="split-visual reveal-pop">
      <img src="/assets/corporate-infographics/8.png" alt="Finds what's slowing your team down and resolves it" loading="lazy" />
    </div>
  </div>
</section>

<!-- SLIDE 9 -->
<section class="split-section dark">
  <div class="split-inner">
    <div class="split-content reveal-clip">
      <h2>Turns team updates into progress reports using <span class="green">AI</span></h2>
      <ul>
        <li class="stagger-item stagger-3"><span class="li-icon green"><span class="material-symbols-outlined" style="font-size:1rem;">summarize</span></span>Auto-generated performance reports</li>
        <li class="stagger-item stagger-1"><span class="li-icon gold"><span class="material-symbols-outlined" style="font-size:1rem;">bar_chart</span></span>Task completion, trends &amp; skill breakdowns</li>
        <li class="stagger-item stagger-2"><span class="li-icon cyan"><span class="material-symbols-outlined" style="font-size:1rem;">done_all</span></span>No manual reporting needed</li>
      </ul>
    </div>
    <div class="split-visual reveal-elastic">
      <img src="/assets/corporate-infographics/9.png" alt="Turns team updates into progress reports using AI" loading="lazy" />
    </div>
  </div>
</section>

<!-- SLIDE 10 -->
<section class="split-section light">
  <div class="split-inner reverse">
    <div class="split-content reveal-perspective">
      <h2>Get <span>smart</span> alerts when an employee needs your attention</h2>
      <ul>
        <li class="stagger-item stagger-1"><span class="li-icon cyan"><span class="material-symbols-outlined" style="font-size:1rem;">notification_important</span></span>Know exactly who's falling behind</li>
        <li class="stagger-item stagger-2"><span class="li-icon orange"><span class="material-symbols-outlined" style="font-size:1rem;">visibility</span></span>See real progress, not guesses</li>
        <li class="stagger-item stagger-3"><span class="li-icon green"><span class="material-symbols-outlined" style="font-size:1rem;">touch_app</span></span>Step in only when it truly matters</li>
      </ul>
    </div>
    <div class="split-visual reveal-flip">
      <img src="/assets/corporate-infographics/10.png" alt="Get smart alerts when an employee needs your attention" loading="lazy" />
    </div>
  </div>
</section>

<!-- SLIDE 11 -->
<section class="split-section dark">
  <div class="split-inner">
    <div class="split-content reveal-rotate">
      <h2>See everything clearly. <span class="gold">Act</span> only when needed.</h2>
      <ul>
        <li class="stagger-item stagger-2"><span class="li-icon gold"><span class="material-symbols-outlined" style="font-size:1rem;">dashboard</span></span>One dashboard, full team visibility</li>
        <li class="stagger-item stagger-3"><span class="li-icon green"><span class="material-symbols-outlined" style="font-size:1rem;">group</span></span>Track progress across every employee</li>
        <li class="stagger-item stagger-4"><span class="li-icon orange"><span class="material-symbols-outlined" style="font-size:1rem;">balance</span></span>Stay informed without micromanaging</li>
      </ul>
    </div>
    <div class="split-visual reveal-zoom-bounce">
      <img src="/assets/corporate-infographics/11.png" alt="See everything clearly act only when needed" loading="lazy" />
    </div>
  </div>
</section>

<!-- SLIDE 12 -->
<section class="split-section light">
  <div class="split-inner reverse">
    <div class="split-content reveal-pop">
      <h2>Spend less time chasing. <span class="green">Growing</span>.</h2>
      <ul>
        <li class="stagger-item stagger-3"><span class="li-icon green"><span class="material-symbols-outlined" style="font-size:1rem;">emoji_objects</span></span>Redirect energy toward strategy</li>
        <li class="stagger-item stagger-1"><span class="li-icon cyan"><span class="material-symbols-outlined" style="font-size:1rem;">show_chart</span></span>Focus on growth, not micromanagement</li>
        <li class="stagger-item stagger-2"><span class="li-icon gold"><span class="material-symbols-outlined" style="font-size:1rem;">rocket_launch</span></span>Scale the business, not your to-do list</li>
      </ul>
    </div>
    <div class="split-visual reveal-clip">
      <img src="/assets/corporate-infographics/12.png" alt="Spend less time chasing more time growing" loading="lazy" />
    </div>
  </div>
</section>

<!-- BUILT FOR -->
<!-- CTA -->
<section class="section cta-bg">
  <div class="sec-inner cta-inner reveal-up">
    <h2 class="cta-h2">Interested in an Enterprise Plan?</h2>
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
        <a href="/" class="footer-brand-name"><img src="/assets//logo/logo-dark-full.png" alt="GoalChaser.co" /></a>
        <p style="margin-top:0;">The active AI project manager that calls your team schedules tasks, resolves blockers, monitors performance, and keeps leadership informed automatically.</p>
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
      <h3 style="font-size:1.6rem;font-weight:900;font-family:'Inter',sans-serif;margin-bottom:.5rem;">Message Sent!</h3>
      <p style="font-size:.9rem;color:#64748B;">Our enterprise team will reach out to you within 24 hours.</p>
      <button onclick="closeModal()" style="margin-top:2rem;background:none;border:none;cursor:pointer;font-weight:700;color:#00AFF0;font-family:inherit;">Close</button>
    </div>
  </div>
</div>

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
<script src="https://unpkg.com/vanta@latest/dist/vanta.clouds.min.js"></script>
<script>
  const navbar = document.getElementById('navbar');
  const hamburger = document.getElementById('hamburger');
  const mobileMenu = document.getElementById('mobileMenu');

  window.addEventListener('scroll', () => {}, {passive:true});

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

  /* ─── REVEAL ANIMATIONS ─── */
  const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        revealObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

  document.querySelectorAll('.reveal-up, .reveal-left, .reveal-right, .reveal-scale, .reveal-blur, .reveal-rotate, .reveal-flip, .reveal-zoom-bounce, .reveal-clip, .reveal-perspective, .reveal-elastic, .reveal-pop, .stagger-item').forEach(el => {
    revealObserver.observe(el);
  });

  /* ─── 3D SCROLL DEPTH ─── */
  const splitInners = document.querySelectorAll('.split-inner');
  function updateDepth() {
    const vh = window.innerHeight;
    splitInners.forEach(inner => {
      const rect = inner.getBoundingClientRect();
      const center = rect.top + rect.height / 2;
      const progress = (center - vh / 2) / (vh / 2);
      const clamped = Math.max(-1, Math.min(1, progress));
      const tz = Math.round(clamped * -12);
      const ry = Math.round(clamped * 1.5);
      inner.style.transform = `translateZ(${tz}px) rotateY(${ry}deg)`;
    });
  }
  window.addEventListener('scroll', updateDepth, { passive: true });
  updateDepth();
</script>

<!-- VANTA CLOUDS INIT -->
<script>
  VANTA.CLOUDS({
    el: "#vanta-bg",
    mouseControls: true,
    touchControls: true,
    gyroControls: false,
    minHeight: 200.00,
    minWidth: 200.00,
    speed: 1,
    skyColor: 0x68b8d7,
    cloudColor: 0xadc1de,
    cloudShadowColor: 0x183550,
    sunColor: 0xff9919,
    sunGlareColor: 0xff6633,
    sunlightColor: 0xff9933
  })
</script>
</body>
</html>
