<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GoalChaser for Corporate IT — Your AI Project Manager</title>
  <link rel="icon" type="image/png" href="/assets/logo/logo.png" />
  <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@400,0..1&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --navy:#1A253A; --navy2:#223048; --navy3:#2E3F5B; --navy4:#3C5072;
      --cyan:#00AFF0; --cyan2:#0091C8;
      --green:#0EB647; --green2:#0A9A3B;
      --purple:#7C3AED; --orange:#EA580C; --amber:#F59E0B;
      --white:#FFFFFF;
      --s1:#F8FAFC; --s2:#F1F5F9; --s3:#E2E8F0; --s4:#CBD5E1;
      --s5:#94A3B8; --s6:#64748B; --s7:#475569; --s9:#334155;
    }
    html { font-size:16px; }
    body { font-family:'Nunito',sans-serif; background:#fff; color:var(--s9); -webkit-font-smoothing:antialiased; overflow-x:hidden; }

    /* ─── NAV ─── */
    nav { position:fixed; top:0; left:0; right:0; z-index:100; padding:0 2rem; background:rgba(255,255,255,0); border-bottom:1px solid transparent; transition:background .3s,border-color .3s,box-shadow .3s; }
    nav.scrolled { background:rgba(255,255,255,.97); backdrop-filter:blur(12px); border-bottom-color:var(--s3); box-shadow:0 1px 16px rgba(45,55,72,0.05); }
    .nav-inner { max-width:1280px; margin:0 auto; height:80px; display:flex; align-items:center; justify-content:space-between; }
    .nav-logo { display:flex; align-items:center; text-decoration:none; }
    .nav-logo img { height:60px; width:auto; display:block; }
    @media(max-width:640px) { .nav-logo img { height:60px; } .nav-inner { height:80px; } .hero { margin-top:-80px; padding-top:80px; } }
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
    .nav-hamburger { display:none; background:none; border:none; cursor:pointer; color:#fff; }
    nav.scrolled .nav-hamburger { color:var(--s9); }
    .nav-hamburger svg { width:28px; height:28px; }
    @media(max-width:900px){ .nav-links, .nav-actions .btn-ghost { display:none; } .nav-hamburger { display:block; } }
    .mobile-menu { display:none; background:#fff; border-top:1px solid var(--s3); box-shadow:0 10px 30px rgba(0,0,0,.08); }
    .mobile-menu.open { display:flex; flex-direction:column; padding:1rem 0; }
    .mobile-menu a { padding:.9rem 2rem; text-decoration:none; color:var(--s7); font-weight:700; font-size:.95rem; border-bottom:1px solid var(--s2); }
    .mobile-actions { display:flex; gap:.75rem; padding:1.25rem 2rem; }
    .mobile-actions .btn-primary { background:var(--cyan); color:#fff; padding:.75rem; border-radius:12px; font-weight:800; display:flex; align-items:center; justify-content:center; gap:.5rem; text-decoration:none; font-family:'Nunito',sans-serif; font-size:.875rem; flex:1; }
    .mobile-actions .btn-ghost { background:var(--s2); color:var(--s7); padding:.75rem; border-radius:12px; font-weight:700; display:flex; align-items:center; justify-content:center; gap:.5rem; text-decoration:none; font-family:'Nunito',sans-serif; font-size:.875rem; flex:1; }

    /* ─── HERO (compact) ─── */
    .hero { position:relative; height:100vh; min-height:680px; display:flex; align-items:center; overflow:hidden; padding-top:110px; padding-bottom:110px; background-color:#0d1626; }
    .hero-overlay { position:absolute; inset:0; background:
      radial-gradient(900px 500px at 20% 15%, rgba(0,175,240,.18), transparent 60%),
      radial-gradient(800px 500px at 85% 85%, rgba(14,182,71,.12), transparent 60%),
      linear-gradient(135deg,#0B121F 0%,#0d192b 50%,#0a1424 100%); }
    .hero-grid-bg { position:absolute; inset:0; opacity:.5; background-image:linear-gradient(rgba(0,175,240,.06) 1px,transparent 1px),linear-gradient(90deg,rgba(0,175,240,.06) 1px,transparent 1px); background-size:44px 44px; -webkit-mask-image:radial-gradient(circle at center,black,transparent 75%); mask-image:radial-gradient(circle at center,black,transparent 75%); }
    .hero-glow1 { position:absolute; top:20%; left:15%; width:360px; height:360px; border-radius:50%; background:radial-gradient(circle,rgba(0,175,240,.16),transparent 70%); filter:blur(40px); pointer-events:none; }
    .hero-glow2 { position:absolute; bottom:15%; right:18%; width:320px; height:320px; border-radius:50%; background:radial-gradient(circle,rgba(14,182,71,.12),transparent 70%); filter:blur(40px); pointer-events:none; }

    .hero-inner { max-width:1240px; margin:0 auto; padding:4rem 2rem; width:100%; position:relative; z-index:1; display:grid; grid-template-columns:56% 44%; gap:2.5rem; align-items:center; }
    .hero-eyebrow { display:inline-flex; align-items:center; gap:.5rem; padding:.35rem .9rem; border:1px solid rgba(0,175,240,.3); background:rgba(0,175,240,.08); border-radius:999px; font-size:.68rem; font-weight:800; letter-spacing:.1em; text-transform:uppercase; color:var(--cyan); margin-bottom:1.25rem; }
    .hero-h1 { font-family:'Nunito',sans-serif; font-size:clamp(2.2rem,4.4vw,3.3rem); font-weight:900; color:#fff; line-height:1.08; letter-spacing:-.04em; margin-bottom:1rem; }
    .hero-h1 .c1 { color:var(--cyan); }
    .hero-sub { color:rgba(255,255,255,.65); font-size:1.05rem; max-width:480px; line-height:1.7; margin-bottom:1.75rem; }
    .hero-actions { display:flex; gap:1rem; flex-wrap:wrap; margin-bottom:1.5rem; }
    .btn-primary { display:inline-flex; align-items:center; gap:.5rem; padding:.85rem 2rem; background:linear-gradient(135deg,var(--cyan),var(--cyan2)); color:#fff; font-weight:800; font-size:.95rem; border-radius:12px; text-decoration:none; border:none; cursor:pointer; box-shadow:0 6px 24px rgba(0,175,240,.35); transition:transform .2s,box-shadow .2s; font-family:inherit; }
    .btn-primary:hover { transform:translateY(-2px); box-shadow:0 10px 32px rgba(0,175,240,.45); }
    .btn-ghost { display:inline-flex; align-items:center; gap:.75rem; padding:.85rem 2rem; background:rgba(255,255,255,.07); border:1px solid rgba(255,255,255,.18); color:#fff; font-weight:700; font-size:.95rem; border-radius:12px; text-decoration:none; cursor:pointer; backdrop-filter:blur(8px); transition:background .2s; font-family:inherit; }
    .btn-ghost:hover { background:rgba(255,255,255,.13); }
    .hero-shorthand { display:flex; align-items:center; gap:.55rem; flex-wrap:wrap; font-size:.8rem; font-weight:700; color:rgba(255,255,255,.5); }
    .hero-shorthand b { color:var(--cyan); font-weight:800; }
    .hero-shorthand .hs-dot { width:20px; height:20px; border-radius:50%; background:rgba(0,175,240,.15); color:var(--cyan); display:inline-flex; align-items:center; justify-content:center; font-size:11px; }

    /* hero mini workflow visual */
    .hf { display:flex; flex-direction:column; gap:.6rem; max-width:360px; }
    .hf-node { display:flex; align-items:center; gap:.85rem; background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.12); border-radius:15px; padding:.75rem .9rem; position:relative; transition:border-color .3s,background .3s; }
    .hf-node.hub { background:rgba(255,255,255,.06); border-color:rgba(255,255,255,.22); }
    .hf-ico { width:40px; height:40px; border-radius:11px; display:flex; align-items:center; justify-content:center; flex-shrink:0; color:#fff; }
    .hf-node.c1 .hf-ico { background:linear-gradient(135deg,#38BDF8,#0EA5E9); box-shadow:0 6px 14px rgba(56,189,248,.32); }
    .hf-node.c2 .hf-ico { background:linear-gradient(135deg,#A78BFA,#8B5CF6); box-shadow:0 6px 14px rgba(167,139,250,.32); }
    .hf-node.c3 .hf-ico { background:linear-gradient(135deg,#FBBF24,#F59E0B); box-shadow:0 6px 14px rgba(251,191,36,.32); }
    .hf-node.c4 .hf-ico { background:linear-gradient(135deg,#0EB647,#0A9A3B); box-shadow:0 6px 14px rgba(14,182,71,.32); }
    .hf-label { color:#fff; font-weight:800; font-size:.9rem; }
    .hf-sub { color:rgba(255,255,255,.55); font-size:.72rem; }
    .hf-step { position:absolute; top:.5rem; right:.55rem; font-size:.58rem; font-weight:800; color:rgba(255,255,255,.4); border:1px solid rgba(255,255,255,.14); border-radius:999px; padding:.12rem .5rem; }
    .hf-arrow { text-align:center; line-height:0; color:rgba(255,255,255,.3); }
    .hf-arrow .material-symbols-outlined { font-size:18px; }
    @media(max-width:900px){ .hero-inner { grid-template-columns:1fr; padding-top:3.5rem; gap:2rem; } .hero-visual { order:2; margin-left:0; } .hf { margin-left:0; max-width:none; } }
    @media(max-width:640px){ .hero-inner { padding:2rem 1.25rem; } .hero-h1 { font-size:2.2rem; } }

    /* ─── SECTIONS ─── */
    .section { padding:6rem 2rem; overflow-x:hidden; position:relative; }
    .sec-inner { max-width:1240px; margin:0 auto; }
    .bg-white { background:#fff; }
    .bg-soft { background:var(--s1); }
    .sec-head { max-width:720px; margin:0 auto 2.5rem; text-align:center; }
    .eyebrow { display:inline-flex; align-items:center; gap:.5rem; padding:.35rem .9rem; background:#fff; border:1px solid var(--s3); border-radius:8px; font-size:.68rem; font-weight:800; letter-spacing:.1em; text-transform:uppercase; color:var(--cyan); margin-bottom:1.25rem; box-shadow:0 1px 4px rgba(0,0,0,.06); }
    .sec-h2 { font-family:'Nunito',sans-serif; font-size:clamp(1.9rem,3.6vw,2.8rem); font-weight:900; letter-spacing:-.04em; color:var(--s9); margin-bottom:1rem; }
    .sec-h2 span { color:var(--cyan); }
    .sec-sub { font-size:1.05rem; color:var(--s6); line-height:1.7; }

/* ─── PRIMARY WORKFLOW (alternating spine) ─── */
    .workflow { position:relative; max-width:980px; margin:0 auto; }
    .workflow::before { content:''; position:absolute; top:36px; bottom:36px; left:50%; transform:translateX(-50%); width:3px; border-radius:3px; background:linear-gradient(180deg,var(--s4) 0%,var(--cyan) 45%,var(--green) 100%); opacity:.7; }
    .wf-step { position:relative; width:50%; padding:1rem 3.25rem 1rem 0; }
    .wf-step.right { margin-left:50%; padding:1rem 0 1rem 3.25rem; }
    .wf-step::before { content:attr(data-num); position:absolute; top:50%; transform:translateY(-50%); width:48px; height:48px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:900; color:#fff; background:var(--cyan); border:4px solid #fff; box-shadow:0 4px 14px rgba(0,175,240,.35); z-index:1; }
    .wf-step.work::before, .wf-step.human::before { background:var(--s9); box-shadow:0 4px 14px rgba(51,65,85,.3); }
    .wf-step.done::before { background:var(--green); box-shadow:0 4px 14px rgba(14,182,71,.35); }
    .wf-step.warn::before { background:var(--amber); box-shadow:0 4px 14px rgba(245,158,11,.3); }
    .wf-step:not(.right)::before { right:-24px; }
    .wf-step.right::before { left:-24px; }
    .wf-row { margin:1.4rem 0; background:#fff; border:1px solid var(--s3); border-radius:18px; padding:1.15rem 1.4rem; display:flex; align-items:center; gap:1.25rem; transition:transform .3s,box-shadow .3s,border-color .3s; }
    .wf-row:hover { box-shadow:0 12px 30px rgba(0,0,0,.06); border-color:rgba(0,175,240,.35); }
    .wf-step:not(.right) .wf-row:hover { transform:translateX(-4px); }
    .wf-step.right .wf-row:hover { transform:translateX(4px); }
    .wf-row.ai { background:linear-gradient(0deg,rgba(0,175,240,.05),rgba(0,175,240,.02)); border-color:rgba(0,175,240,.25); }
    .wf-ico { width:42px; height:42px; border-radius:11px; background:rgba(0,175,240,.12); color:var(--cyan); display:flex; align-items:center; justify-content:center; flex-shrink:0; font-size:1.3rem; }
    .wf-row.ai .wf-ico { background:var(--cyan); color:#fff; }
    .wf-row.done .wf-ico { background:rgba(14,182,71,.12); color:var(--green); }
    .wf-copy { flex:1; min-width:0; }
    .wf-title { font-size:1.08rem; font-weight:900; color:var(--s9); }
    .wf-sub { font-size:.85rem; color:var(--s6); margin-top:2px; }
    .wf-note { font-size:.72rem; font-weight:800; letter-spacing:.05em; text-transform:uppercase; color:var(--s5); flex-shrink:0; display:flex; align-items:center; gap:.4rem; }
    .wf-note .material-symbols-outlined { font-size:16px; }
    .wf-chat { flex:1; min-width:0; }
    .wf-chat .who { font-size:.66rem; font-weight:800; text-transform:uppercase; letter-spacing:.06em; color:var(--s5); margin-bottom:.3rem; display:flex; align-items:center; gap:.4rem; }
    .wf-chat .msg { font-size:.9rem; font-weight:700; color:var(--s9); background:var(--s2); border:1px solid var(--s3); border-radius:14px 14px 14px 4px; padding:.7rem 1rem; line-height:1.5; }
    .wf-chat .msg b { color:var(--cyan); }
    .wf-chat.ai .msg { background:rgba(0,175,240,.08); border-color:rgba(0,175,240,.28); }
    .wf-chat.emp .msg { background:rgba(14,182,71,.08); border-color:rgba(14,182,71,.28); }
    .wf-chat.warn .msg { background:#fffcf2; border-color:rgba(245,158,11,.4); }
    .wf-chat.human .msg { background:#F1F5F9; border-color:var(--s4); }
    @media(max-width:900px){
      .workflow::before { left:24px; transform:none; top:36px; bottom:36px; }
      .wf-step, .wf-step.right { width:100%; margin-left:0; padding:1rem 0 1rem 64px; }
      .wf-step::before, .wf-step.right::before { left:0; right:auto; width:48px; height:48px; }
    }

    /* ─── MINI FLOW (examples/scenario) ─── */
    .mini { display:flex; flex-direction:column; max-width:820px; margin:0 auto; }
    .mini-item { display:flex; align-items:center; gap:1.1rem; background:#fff; border:1px solid var(--s3); border-radius:14px; padding:1rem 1.3rem; }
    .mini-ico { width:40px; height:40px; border-radius:11px; display:flex; align-items:center; justify-content:center; flex-shrink:0; background:rgba(0,175,240,.12); color:var(--cyan); }
    .mini-item.tool .mini-ico { background:#F1F5F9; color:var(--s9); }
    .mini-item.ai .mini-ico { background:var(--cyan); color:#fff; }
    .mini-item.emp .mini-ico { background:rgba(14,182,71,.14); color:var(--green); }
    .mini-item.warn .mini-ico { background:rgba(245,158,11,.14); color:var(--amber); }
    .mini-item.done .mini-ico { background:rgba(14,182,71,.14); color:var(--green); }
    .mini-label { font-weight:800; color:var(--s9); font-size:.95rem; }
    .mini-tag { font-size:.7rem; font-weight:800; text-transform:uppercase; letter-spacing:.05em; color:var(--s5); margin-left:auto; flex-shrink:0; display:flex; align-items:center; gap:.35rem; }
    .mini-desc { font-size:.78rem; color:var(--s6); margin-top:2px; font-weight:600; }
    .mini-arrow { text-align:center; color:var(--cyan); line-height:0; padding:.25rem 0; opacity:.7; }

    /* character/bubble line inside mini (employee speech) */
    .bubble { font-size:.85rem; color:var(--s9); background:var(--s2); border:1px solid var(--s3); border-radius:12px; padding:.55rem .9rem; font-weight:600; flex:1; }
    .bubble b { color:var(--cyan); }

    /* ─── INTEGRATIONS ─── */
    .int-bg { background:var(--s1); }
    .int-grid { display:grid; grid-template-columns:repeat(6,1fr); gap:1.25rem; max-width:1080px; margin:0 auto; }
    .int-card { background:#fff; border:1px solid var(--s3); border-radius:18px; padding:1.5rem 1rem; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:.85rem; text-align:center; transition:border-color .3s,box-shadow .3s,transform .3s; box-shadow:0 1px 6px rgba(0,0,0,.04); }
    .int-card:hover { transform:translateY(-4px); box-shadow:0 10px 30px rgba(0,0,0,.08); border-color:rgba(0,175,240,.3); }
    .ilogo { width:56px; height:56px; display:flex; align-items:center; justify-content:center; opacity:1; }
    .ilogo svg { width:100%; height:100%; }
    .int-name { font-size:.8rem; font-weight:800; color:var(--s7); }
    @media(max-width:900px){ .int-grid { grid-template-columns:repeat(4,1fr); } }
    @media(max-width:640px){ .int-grid { grid-template-columns:repeat(2,1fr); } }

    /* ─── ZOOM-IN COMPONENT ROWS ─── */
    .zoom { display:grid; grid-template-columns:1fr 1fr; gap:3rem; align-items:center; max-width:1080px; margin:0 auto 4rem; }
    .zoom:last-child { margin-bottom:0; }
    .zoom-step { display:inline-flex; align-items:center; gap:.45rem; padding:.32rem .85rem; border:1px solid var(--s3); border-radius:999px; background:#fff; font-size:.72rem; font-weight:800; color:var(--s6); letter-spacing:.04em; margin-bottom:1rem; }
    .zoom-step b { color:var(--cyan); }
    .zoom h3 { font-size:1.75rem; font-weight:900; color:var(--s9); letter-spacing:-.02em; margin-bottom:.6rem; }
    .zoom p { color:var(--s6); font-size:.98rem; line-height:1.65; max-width:420px; }
    #voice .zoom h3, #blockers .zoom h3, #reports .zoom h3, #mgt .zoom h3 { font-size:clamp(2.1rem,3.4vw,2.6rem); }
    .zoom-media { position:relative; }
    .zoom-media.right { order:-1; }
    @media(max-width:900px){ .zoom { grid-template-columns:1fr; gap:2rem; } .zoom-media, .zoom-media.right { order:0; } }

    /* shared mini UI cards used in zoom media */
    .ui { background:var(--s1); border:1px solid var(--s3); border-radius:18px; padding:1.5rem; max-width:420px; margin:0 auto; box-shadow:0 16px 40px rgba(0,0,0,.06); }
    .ui.right { margin:0 auto; }

    /* mobile app mockup frame */
    .app-phone { width:292px; margin:0 auto; background:#12191f; border:5px solid #0e1418; border-radius:40px; padding:10px; box-shadow:0 30px 70px rgba(0,0,0,.32); }
    .app-screen { position:relative; background:var(--s1); border-radius:32px; overflow:hidden; min-height:430px; padding:2.2rem 1.05rem 1.2rem; display:flex; align-items:center; }
    .app-notch { position:absolute; top:9px; left:50%; transform:translateX(-50%); width:96px; height:22px; background:#0e1418; border-radius:999px; z-index:2; }
    .app-screen .ui { max-width:none; width:100%; margin:0; box-shadow:none; }
    .ui-hd { display:flex; align-items:center; gap:.6rem; margin-bottom:1.1rem; }
    .ui-hd .material-symbols-outlined { color:var(--cyan); font-size:1.4rem; }
    .ui-hd b { font-size:.9rem; font-weight:900; color:var(--s9); }
    .ui-hd .uist { margin-left:auto; font-size:.62rem; font-weight:800; text-transform:uppercase; letter-spacing:.05em; color:var(--green); background:rgba(14,182,71,.12); border:1px solid rgba(14,182,71,.3); padding:.15rem .6rem; border-radius:999px; }
    .ui-line { display:flex; align-items:center; gap:.75rem; background:#fff; border:1px solid var(--s3); border-radius:12px; padding:.75rem .9rem; margin-bottom:.6rem; }
    .ui-line:last-child { margin-bottom:0; }
    .ui-ic { width:34px; height:34px; border-radius:9px; background:rgba(0,175,240,.12); color:var(--cyan); display:flex; align-items:center; justify-content:center; font-size:1.05rem; flex-shrink:0; }
    .ui-line .t { font-size:.8rem; font-weight:800; color:var(--s9); }
    .ui-line .s { font-size:.72rem; color:var(--s6); }
    .ui-line .st { margin-left:auto; font-size:.62rem; font-weight:800; flex-shrink:0; }
    .st.done { color:var(--green); } .st.acc { color:var(--cyan); } .st.warn { color:var(--amber); } .st.slate { color:var(--s5); }

    /* ─── OUTCOME BAND ─── */
    .outcome-bg { background:linear-gradient(160deg,var(--navy),var(--navy2)); position:relative; overflow:hidden; text-align:center; }
    .outcome-bg::before { content:''; position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); width:640px; height:640px; background:radial-gradient(circle,rgba(0,175,240,.14),transparent 70%); pointer-events:none; }
    .outcome-inner { position:relative; z-index:1; }
    .outcome-h { font-size:clamp(1.8rem,3.4vw,2.6rem); font-weight:900; color:#fff; letter-spacing:-.03em; margin-bottom:.75rem; }
    .outcome-h span { color:var(--cyan); }
    .chain-x { display:flex; align-items:center; justify-content:center; flex-wrap:wrap; gap:.75rem; margin:1.75rem auto 0; }
    .chain-x .cx-item { display:flex; align-items:center; gap:.5rem; background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.14); border-radius:999px; padding:.6rem 1.3rem; color:#fff; font-weight:800; font-size:.9rem; }
    .chain-x .cx-item .material-symbols-outlined { color:var(--cyan); }
    .chain-x .cx-arrow { color:rgba(255,255,255,.5); }
    .chain-x .cx-item.hl { background:var(--cyan); border-color:var(--cyan); }

    /* ─── FOOTER ─── */
    footer { background:var(--navy); color:rgba(255,255,255,.7); border-top:1px solid rgba(255,255,255,.08); padding:4rem 2rem 2rem; }
    .footer-inner { max-width:1240px; margin:0 auto; }
    .footer-grid { display:grid; grid-template-columns:2fr 1fr 1fr 1fr 1fr; gap:2.5rem; margin-bottom:3rem; }
    .footer-brand-name { font-size:1.35rem; font-weight:900; color:#fff; letter-spacing:-.5px; text-decoration:none; display:block; margin-bottom:1rem; }
    .footer-brand-name span { color:var(--cyan); }
    .footer-brand p { font-size:.88rem; line-height:1.7; margin-top:1.25rem; max-width:340px; color:rgba(255,255,255,.6); }
    .footer-social { display:flex; gap:.75rem; margin-top:1.5rem; }
    .footer-social a { width:38px; height:38px; border-radius:10px; border:1px solid rgba(255,255,255,.14); display:flex; align-items:center; justify-content:center; color:rgba(255,255,255,.7); transition:all .2s; }
    .footer-social a:hover { border-color:var(--cyan); color:var(--cyan); }
    .footer-col h5 { font-size:.78rem; font-weight:800; text-transform:uppercase; letter-spacing:.08em; color:#fff; margin-bottom:1.1rem; }
    .footer-col ul { list-style:none; display:flex; flex-direction:column; gap:.6rem; }
    .footer-col a { color:rgba(255,255,255,.6); text-decoration:none; font-size:.88rem; transition:color .2s; }
    .footer-col a:hover { color:var(--cyan); }
    .footer-bottom { border-top:1px solid rgba(255,255,255,.1); padding-top:1.75rem; display:flex; justify-content:space-between; flex-wrap:wrap; gap:1rem; font-size:.82rem; color:rgba(255,255,255,.5); }
    .footer-bottom a { color:rgba(255,255,255,.7); text-decoration:none; }
    @media(max-width:900px){ .footer-grid { grid-template-columns:1fr 1fr; } .footer-brand{ grid-column:1/-1; } }
    @media(max-width:640px){ .footer-grid { grid-template-columns:1fr; } .section { padding:4rem 1.25rem; } }

    /* ─── CTA ─── */
    .cta-bg { background:var(--navy); text-align:center; position:relative; overflow:hidden; }
    .cta-bg::before { content:''; position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); width:600px; height:600px; background:radial-gradient(circle,rgba(0,175,240,.14),transparent 70%); pointer-events:none; }
    .cta-inner { position:relative; z-index:1; }
    .cta-h2 { font-family:'Nunito',sans-serif; font-size:clamp(2rem,4vw,3.1rem); font-weight:900; color:#fff; letter-spacing:-.04em; margin-bottom:1rem; }
    .cta-h2 span { color:var(--cyan); }
    .cta-sub { font-size:1.05rem; color:rgba(255,255,255,.6); max-width:620px; margin:0 auto 2.5rem; line-height:1.7; }
    .cta-actions { display:flex; gap:1rem; justify-content:center; flex-wrap:wrap; }

    /* ─── MODAL ─── */
    .modal-overlay { position:fixed; inset:0; z-index:200; display:flex; align-items:center; justify-content:center; padding:1rem; background:rgba(15,23,42,.6); backdrop-filter:blur(4px); opacity:0; pointer-events:none; transition:opacity .3s; }
    .modal-overlay.open { opacity:1; pointer-events:auto; }
    .modal { position:relative; max-width:440px; width:100%; background:#fff; border-radius:20px; padding:2.25rem; text-align:center; transform:translateY(20px); transition:transform .3s; box-shadow:0 30px 80px rgba(0,0,0,.3); }
    .modal-overlay.open .modal { transform:translateY(0); }
    .modal-close { position:absolute; top:1rem; right:1rem; background:none; border:none; cursor:pointer; color:var(--s6); }
    .modal-icon { width:60px; height:60px; border-radius:16px; background:rgba(0,175,240,.1); color:var(--cyan); display:flex; align-items:center; justify-content:center; margin:0 auto 1.1rem; font-size:2rem; }
    .modal h3 { font-size:1.5rem; font-weight:900; color:var(--s9); margin-bottom:.5rem; font-family:'Nunito',sans-serif; }
    .modal p { font-size:.9rem; color:var(--s6); line-height:1.6; margin-bottom:1.5rem; }
    .modal input { width:100%; padding:.85rem 1rem; border:1px solid var(--s3); border-radius:12px; font-size:.9rem; font-family:'Nunito',sans-serif; margin-bottom:.9rem; outline:none; transition:border-color .2s; }
    .modal input:focus { border-color:var(--cyan); }
    .modal-submit { width:100%; padding:.9rem; border:none; border-radius:12px; background:linear-gradient(135deg,var(--cyan),var(--cyan2)); color:#fff; font-weight:800; font-size:.92rem; cursor:pointer; font-family:'Nunito',sans-serif; display:flex; align-items:center; justify-content:center; gap:.5rem; transition:transform .15s; }
    .modal-submit:hover { transform:translateY(-1px); }
    .success-icon { width:60px; height:60px; border-radius:16px; background:rgba(14,182,71,.12); color:var(--green); display:flex; align-items:center; justify-content:center; margin:0 auto 1.1rem; font-size:2rem; }
    .success-state { display:none; }

    /* ─── ANIMATIONS ─── */
    @keyframes revealUp { from { opacity:0; transform:translateY(32px); } to { opacity:1; transform:translateY(0); } }
    .reveal { opacity:0; }
    .reveal.visible { animation:revealUp .6s cubic-bezier(0.22,1,0.36,1) forwards; }
    .reveal-delay-1 { animation-delay:.08s !important; }
    .reveal-delay-2 { animation-delay:.16s !important; }
    .reveal-delay-3 { animation-delay:.24s !important; }
  </style>
</head>
<body>

<!-- NAV -->
<nav id="navbar">
  <div class="nav-inner">
    <a href="/" class="nav-logo">
      <img src="/assets/logo/logo-dark-full.png" alt="GoalChaser.co" class="logo-light" />
      <img src="/assets/logo/logo-light-full.png" alt="GoalChaser.co" class="logo-dark" />
    </a>
    <ul class="nav-links">
      <li><a href="#wf">How It Works</a></li>
      <li><a href="/goalchaser-for-textile">For Textile</a></li>
      <li><a href="/goalchaser-for-it">For IT</a></li>
    </ul>
    <div class="nav-actions">
      <a href="/login" class="btn-ghost">Sign in</a>
      <a href="/login" class="btn-primary">Get Started →</a>
    </div>
    <button class="nav-hamburger" id="hamburger" aria-label="Open menu">
      <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round">
        <line x1="3" y1="7" x2="21" y2="7"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="17" x2="21" y2="17"/>
      </svg>
    </button>
  </div>
  <div class="mobile-menu" id="mobileMenu">
    <a href="#wf">How It Works</a>
    <a href="/goalchaser-for-textile">For Textile</a>
    <a href="/goalchaser-for-it">For IT</a>
    <div class="mobile-actions">
      <a href="/login" class="btn-ghost">Sign in</a>
      <a href="/login" class="btn-primary">Get Started →</a>
    </div>
  </div>
</nav>

<!-- HERO -->
<section class="hero" id="hero-section">
  <div class="hero-overlay"></div>
  <div class="hero-grid-bg"></div>
  <div class="hero-glow1"></div>
  <div class="hero-glow2"></div>

  <div class="hero-inner">
    <div class="hero-copy">
      <h1 class="hero-h1">Keep your team <span class="c1">moving.</span></h1>
      <p class="hero-sub">AI follows up on work, understands progress, and keeps management informed.</p>
      <div class="hero-actions">
        <a href="#wf" class="btn-primary">See How It Works <span class="material-symbols-outlined" style="font-size:18px;">arrow_forward</span></a>
        <button class="btn-ghost" onclick="openModal(event)">Talk to Us</button>
      </div>
      <div class="hero-shorthand">
        <span>Tasks</span>
        <span class="hs-dot"><span class="material-symbols-outlined" style="font-size:12px;">arrow_forward</span></span>
        <span>Conversations</span>
        <span class="hs-dot"><span class="material-symbols-outlined" style="font-size:12px;">arrow_forward</span></span>
        <span>Progress</span>
        <span class="hs-dot"><span class="material-symbols-outlined" style="font-size:12px;">arrow_forward</span></span>
        <b>Insights</b>
      </div>
    </div>

    <div class="hero-visual">
      <div class="hf">
        <div class="hf-node c1">
          <div class="hf-ico"><span class="material-symbols-outlined">task_alt</span></div>
          <div><div class="hf-label">Tasks &amp; Sprint</div><div class="hf-sub">Work, deadlines &amp; priorities</div></div>
          <div class="hf-step">1</div>
        </div>
        <div class="hf-arrow"><span class="material-symbols-outlined">expand_more</span></div>
        <div class="hf-node c2 hub">
          <div class="hf-ico"><span class="material-symbols-outlined">smart_toy</span></div>
          <div><div class="hf-label">AI Follow-up</div><div class="hf-sub">Voice check-ins, auto follow-ups</div></div>
          <div class="hf-step">2</div>
        </div>
        <div class="hf-arrow"><span class="material-symbols-outlined">expand_more</span></div>
        <div class="hf-node c3">
          <div class="hf-ico"><span class="material-symbols-outlined">build</span></div>
          <div><div class="hf-label">Blockers Surfaced</div><div class="hf-sub">Detected with full context</div></div>
          <div class="hf-step">3</div>
        </div>
        <div class="hf-arrow"><span class="material-symbols-outlined">expand_more</span></div>
        <div class="hf-node c4">
          <div class="hf-ico"><span class="material-symbols-outlined">insights</span></div>
          <div><div class="hf-label">Insights &amp; Reports</div><div class="hf-sub">Sprint reports, exec visibility</div></div>
          <div class="hf-step">4</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- INTEGRATIONS (existing tools) -->
<section class="section int-bg" id="integrations">
  <div class="sec-inner">
    <div class="sec-head reveal">
      <div class="eyebrow" style="background:#fff;"><span class="material-symbols-outlined">extension</span>Existing Tools</div>
      <h2 class="sec-h2">Connects with your <span>existing tools</span></h2>
      <p class="sec-sub cx">Seamlessly connect with your existing tools. GoalChaser sits on top of the task management and communication platforms your team already uses — no need to change how you work.</p>
    </div>
    <div class="int-grid reveal">
      <div class="int-card"><div class="ilogo"><svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><path d="M24 5 8 21l16 16 16-16L24 5z" fill="#2684FF"/><path d="M24 18l-6 6 6 6 6-6-6-6z" fill="#0052CC"/><path d="M24 24.4l-1.4-1.4 1.4-1.4 1.4 1.4-1.4 1.4z" fill="#fff"/></svg></div><div class="int-name">Jira</div></div>
      <div class="int-card"><div class="ilogo"><svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><rect x="5" y="5" width="38" height="38" rx="8" fill="#0079BF"/><rect x="12" y="14" width="11" height="19" rx="2" fill="#fff"/><rect x="26" y="14" width="11" height="12" rx="2" fill="#fff"/></svg></div><div class="int-name">Trello</div></div>
      <div class="int-card"><div class="ilogo"><svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><circle cx="24" cy="14" r="6.5" fill="#F06A6A"/><circle cx="14.5" cy="33" r="6.5" fill="#F8A31B"/><circle cx="33.5" cy="33" r="6.5" fill="#F15822"/></svg></div><div class="int-name">Asana</div></div>
      <div class="int-card"><div class="ilogo"><svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><path d="M24 6 42 28H28L24 42 20 28H6L24 6z" fill="#7B68EE"/><circle cx="24" cy="30" r="4" fill="#fff"/></svg></div><div class="int-name">ClickUp</div></div>
      <div class="int-card"><div class="ilogo"><svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><rect x="8" y="8" width="32" height="32" rx="8" fill="#111"/><text x="24" y="33" font-family="Nunito,Arial,sans-serif" font-size="22" font-weight="900" fill="#fff" text-anchor="middle">N</text></svg></div><div class="int-name">Notion</div></div>
      <div class="int-card"><div class="ilogo"><svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><g fill="none"><path d="M24 10 22 14l-4-2 2 4h-6v4h6l2 6-4 4 4 4 4-6 6 6-4-4 4-4-4-4v-4h6v-4h-8l2-4-4 2-4-2z" fill="#1A73E8"/></g></svg></div><div class="int-name">Monday.com</div></div>
      <div class="int-card"><div class="ilogo"><svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><rect x="5" y="5" width="18" height="18" rx="4" fill="#5059C9"/><rect x="25" y="5" width="18" height="18" rx="4" fill="#7B83EB"/><rect x="5" y="25" width="18" height="18" rx="4" fill="#464EB8"/><rect x="25" y="25" width="18" height="18" rx="4" fill="#7B83EB"/><path d="M29 31c-2.2 0-4 1.8-4 4s1.8 4 4 4h4l3-3-3-3h-4c-.6 0-1-.4-1-1s.4-1 1-1h6l2-2-3-3h-5z" fill="#fff"/></svg></div><div class="int-name">Teams</div></div>
      <div class="int-card"><div class="ilogo"><svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><path d="M24 4C13 4 4 13 4 24c0 8.8 5.7 16.3 13.7 18.9 1 .2 1.4-.4 1.4-.9v-3.4c-5.6 1.2-6.8-2.7-6.8-2.7-.9-2.3-2.2-2.9-2.2-2.9-1.8-1.2.1-1.2.1-1.2 2 .1 3 2 3 2 1.8 3 4.6 2.2 5.7 1.7.2-1.3.7-2.2 1.3-2.7-4.4-.5-9-2.2-9-9.7 0-2.1.8-3.9 2-5.2-.2-.5-.9-2.5.2-5.2 0 0 1.6-.5 5.3 2 1.5-.4 3.2-.6 4.8-.6s3.3.2 4.8.6c3.7-2.5 5.3-2 5.3-2 1.1 2.7.4 4.7.2 5.2 1.2 1.3 2 3.1 2 5.2 0 7.6-4.6 9.2-9 9.7.7.6 1.4 1.9 1.4 3.8v5.6c0 .5.4 1.1 1.4.9C38.3 40.3 44 32.8 44 24 44 13 35 4 24 4z" fill="#181717"/></svg></div><div class="int-name">GitHub</div></div>
      <div class="int-card"><div class="ilogo"><svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><rect x="5" y="8" width="38" height="32" rx="7" fill="#1A73E8"/><text x="24" y="31" font-family="Nunito,Arial,sans-serif" font-size="18" font-weight="800" fill="#fff" text-anchor="middle">31</text><rect x="9" y="12" width="30" height="4" rx="2" fill="#fff"/></svg></div><div class="int-name">Google Calendar</div></div>
      <div class="int-card"><div class="ilogo"><svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><path d="M20 5 9 18h6l-2 14 14-14h-5l4-13z" fill="#E01E5A"/><path d="M26 10l-8 8h5l-2 12 14-12h-5l2-8z" fill="#36C5F0"/><path d="M24 5l-7 7h5l-3 14 14-14h-6l3-7z" fill="#2EB67D"/><circle cx="31" cy="35" r="7" fill="#ECB22E"/></svg></div><div class="int-name">Slack</div></div>
      <div class="int-card"><div class="ilogo"><svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="8" width="34" height="32" rx="8" fill="#0B5CFF"/><path d="M29 24l-11 7V17l11 7z" fill="#fff"/></svg></div><div class="int-name">Zoom</div></div>
      <div class="int-card"><div class="ilogo"><svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><path d="M24 6 13 22h5l-6 20 16-20h-5l1-16z" fill="#8CC63F"/><path d="M24 18 16 30h4l-4 12 12-12h-4l0-12z" fill="#4F9E43"/><path d="M24 32l-3 4 3 4 3-4-3-4z" fill="#2E7D32"/></svg></div><div class="int-name">Wrike</div></div>
    </div>
  </div>
</section>

<!-- PRIMARY WORKFLOW -->
<section class="section bg-soft" id="wf" data-spy="0">
  <div class="sec-inner">
    <div class="sec-head reveal">
      <div class="eyebrow"><span class="material-symbols-outlined">account_tree</span>How GoalChaser Works</div>
      <h2 class="sec-h2">From task to progress, <span>automatically.</span></h2>
      <p class="sec-sub">GoalChaser connects the work your team is already doing with the conversations and follow-ups needed to keep it moving.</p>
    </div>

    <div class="workflow reveal">
      <div class="wf-step work" data-num="01">
        <div class="wf-row">
          <div class="wf-ico"><span class="material-symbols-outlined">link</span></div>
          <div class="wf-copy"><div class="wf-title">Connect with existing tools</div><div class="wf-sub">GoalChaser links to the task tools your team already uses.</div></div>
          <div class="wf-note"><span class="material-symbols-outlined">extension</span>Connect</div>
        </div>
      </div>
      <div class="wf-step right done" data-num="02">
        <div class="wf-row ai">
          <div class="wf-ico"><span class="material-symbols-outlined">psychology</span></div>
          <div class="wf-copy"><div class="wf-title">Reads tasks</div><div class="wf-sub">It knows what needs to happen — tasks, priorities, deadlines, assignments.</div></div>
          <div class="wf-note"><span class="material-symbols-outlined">auto_awesome</span>Understand</div>
        </div>
      </div>
      <div class="wf-step done" data-num="03">
        <div class="wf-row ai">
          <div class="wf-ico"><span class="material-symbols-outlined">call</span></div>
          <div class="wf-copy"><div class="wf-title">Makes follow-ups</div><div class="wf-sub">AI checks in through natural voice conversations and keeps work moving.</div></div>
          <div class="wf-note"><span class="material-symbols-outlined">record_voice_over</span>Talk</div>
        </div>
      </div>
      <div class="wf-step right warn" data-num="04">
        <div class="wf-row">
          <div class="wf-ico"><span class="material-symbols-outlined">healing</span></div>
          <div class="wf-copy"><div class="wf-title">Resolves blockers</div><div class="wf-sub">Blockers are surfaced, followed up, and resolved or escalated automatically.</div></div>
          <div class="wf-note"><span class="material-symbols-outlined">flag</span>Resolve</div>
        </div>
      </div>
      <div class="wf-step done" data-num="05">
        <div class="wf-row ai">
          <div class="wf-ico"><span class="material-symbols-outlined">summarize</span></div>
          <div class="wf-copy"><div class="wf-title">Prepares reports</div><div class="wf-sub">Tasks + conversations + outcomes become structured insight.</div></div>
          <div class="wf-note"><span class="material-symbols-outlined">bar_chart</span>Report</div>
        </div>
      </div>
      <div class="wf-step right human" data-num="06">
        <div class="wf-row">
          <div class="wf-ico"><span class="material-symbols-outlined">support_agent</span></div>
          <div class="wf-copy"><div class="wf-title">Alerts management</div><div class="wf-sub">Only employees who need attention are surfaced to managers.</div></div>
          <div class="wf-note"><span class="material-symbols-outlined">real_estate_agent</span>Attention</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- OUTCOME -->
<section class="section outcome-bg">
  <div class="outcome-inner reveal">
    <div class="eyebrow" style="background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.14);color:var(--cyan);">The System in One Line</div>
    <h2 class="outcome-h">Work → Talk → Follow Up → <span>Report</span></h2>
    <p class="cta-sub" style="max-width:560px;">GoalChaser connects your team's existing work to AI conversations, continuous follow-ups, blocker detection, and management reporting.</p>
    <div class="chain-x">
      <span class="cx-item"><span class="material-symbols-outlined">task_alt</span>Work</span>
      <span class="cx-arrow">→</span>
      <span class="cx-item hl"><span class="material-symbols-outlined">call</span>Talk</span>
      <span class="cx-arrow">→</span>
      <span class="cx-item"><span class="material-symbols-outlined">visibility</span>Understand</span>
      <span class="cx-arrow">→</span>
      <span class="cx-item"><span class="material-symbols-outlined">sync</span>Follow up</span>
      <span class="cx-arrow">→</span>
      <span class="cx-item"><span class="material-symbols-outlined">bar_chart</span>Report</span>
    </div>
  </div>
</section>

<!-- REAL EXAMPLE -->
<section class="section bg-white" id="example">
  <div class="sec-inner">
    <div class="sec-head reveal">
      <div class="eyebrow">A Simple Example</div>
      <h2 class="sec-h2">What happens when a developer <span>gets blocked?</span></h2>
    </div>

    <div class="workflow reveal">
      <div class="wf-step work" data-num="01">
        <div class="wf-row">
          <div class="wf-ico"><span class="material-symbols-outlined">task_alt</span></div>
          <div class="wf-copy"><div class="wf-title">Jira task — API Integration</div><div class="wf-sub">Due Friday</div></div>
          <div class="wf-note"><span class="material-symbols-outlined">extension</span>Existing work</div>
        </div>
      </div>
      <div class="wf-step right done" data-num="02">
        <div class="wf-row ai">
          <div class="wf-ico"><span class="material-symbols-outlined">call</span></div>
          <div class="wf-chat ai"><div class="who"><span class="material-symbols-outlined" style="font-size:14px;">smart_toy</span>GoalChaser</div><div class="msg">"How is the API integration going?"</div></div>
          <div class="wf-note"><span class="material-symbols-outlined">record_voice_over</span>AI call</div>
        </div>
      </div>
      <div class="wf-step done" data-num="03">
        <div class="wf-row done">
          <div class="wf-ico"><span class="material-symbols-outlined">person</span></div>
          <div class="wf-chat emp"><div class="who"><span class="material-symbols-outlined" style="font-size:14px;">person</span>Employee</div><div class="msg">"Backend is complete. I'm waiting <b>for staging credentials</b>."</div></div>
          <div class="wf-note"><span class="material-symbols-outlined">favorite</span>Progress</div>
        </div>
      </div>
      <div class="wf-step right warn" data-num="04">
        <div class="wf-row">
          <div class="wf-ico"><span class="material-symbols-outlined">warning</span></div>
          <div class="wf-chat warn"><div class="who"><span class="material-symbols-outlined" style="font-size:14px;">psychology</span>GoalChaser</div><div class="msg">Blocker identified — the dependency is missing.</div></div>
          <div class="wf-note"><span class="material-symbols-outlined">flag</span>Blocker</div>
        </div>
      </div>
      <div class="wf-step done" data-num="05">
        <div class="wf-row ai">
          <div class="wf-ico"><span class="material-symbols-outlined">sync</span></div>
          <div class="wf-copy"><div class="wf-title">Follow-up</div><div class="wf-sub">Staging credentials requested automatically.</div></div>
          <div class="wf-note"><span class="material-symbols-outlined">schedule</span>Follow-up</div>
        </div>
      </div>
      <div class="wf-step right human" data-num="06">
        <div class="wf-row">
          <div class="wf-ico"><span class="material-symbols-outlined">real_estate_agent</span></div>
          <div class="wf-chat human"><div class="who"><span class="material-symbols-outlined" style="font-size:14px;">support_agent</span>Manager</div><div class="msg">Sees the blocker and its full context.</div></div>
          <div class="wf-note"><span class="material-symbols-outlined">eye</span>Attention</div>
        </div>
      </div>
      <div class="wf-step done" data-num="07">
        <div class="wf-row done">
          <div class="wf-ico"><span class="material-symbols-outlined">check_circle</span></div>
          <div class="wf-copy"><div class="wf-title">Result</div><div class="wf-sub">Issue resolved before the deadline.</div></div>
          <div class="wf-note"><span class="material-symbols-outlined">done_all</span>Resolved</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- AI VOICE -->
<section class="section bg-white" id="voice" data-spy="1">
  <div class="sec-inner">
    <div class="zoom">
      <div class="zoom-copy reveal">
        <div class="zoom-step">Step <b>03</b> &nbsp;·&nbsp; Talk</div>
        <h3>AI understands what's happening.</h3>
        <p>Voice conversations turn updates and blockers into useful context.</p>
      </div>
      <div class="zoom-media reveal">
        <div class="ui">
          <div class="ui-hd"><span class="material-symbols-outlined">call</span><b>AI Check-in</b><span class="uist">Calling</span></div>
          <div class="ui-line"><div class="ui-ic"><span class="material-symbols-outlined">person</span></div><div><div class="t">Dev — Priya</div><div class="s">"Shipping today, one blocker on QA"</div></div><span class="st acc">Live</span></div>
          <div class="ui-line"><div class="ui-ic"><span class="material-symbols-outlined">rules</span></div><div><div class="t">Parsed to tasks</div><div class="s">Task · Priority · Deadline</div></div><span class="st done">Done</span></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- BLOCKERS -->
<section class="section bg-soft" id="blockers" data-spy="2">
  <div class="sec-inner">
    <div class="zoom">
      <div class="zoom-copy reveal">
        <div class="zoom-step">Step <b>04–05</b> &nbsp;·&nbsp; Understand &amp; Keep Moving</div>
        <h3>Conversations reveal what's slowing progress.</h3>
        <p>Blockers are surfaced and followed up until work resumes.</p>
      </div>
      <div class="zoom-media right reveal">
        <div class="ui">
          <div class="ui-hd"><span class="material-symbols-outlined">flag</span><b>Blocker</b><span class="uist">Active</span></div>
          <div class="ui-line"><div class="ui-ic"><span class="material-symbols-outlined">warning</span></div><div><div class="t">Staging credentials</div><div class="s">Waiting on DevOps</div></div><span class="st warn">Blocked</span></div>
          <div class="ui-line"><div class="ui-ic"><span class="material-symbols-outlined">schedule</span></div><div><div class="t">Follow-up set</div><div class="s">Automatic retry in 2h</div></div><span class="st acc">Watching</span></div>
          <div class="ui-line"><div class="ui-ic"><span class="material-symbols-outlined">check_circle</span></div><div><div class="t">Escalated if needed</div><div class="s">Surfaces to manager</div></div><span class="st slate">Auto</span></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- EMPLOYEE REPORTS -->
<section class="section bg-white" id="reports" data-spy="3">
  <div class="sec-inner">
    <div class="zoom">
      <div class="zoom-copy reveal">
        <div class="zoom-step">Step <b>06</b> &nbsp;·&nbsp; Report</div>
        <h3>Progress becomes visible.</h3>
        <p>Every conversation turns into structured productivity insight.</p>
      </div>
      <div class="zoom-media reveal">
        <div class="ui">
          <div class="ui-hd"><span class="material-symbols-outlined">summarize</span><b>Daily Report</b><span class="uist">Auto</span></div>
          <div class="ui-line"><div class="ui-ic"><span class="material-symbols-outlined">check_circle</span></div><div><div class="t">Tasks completed</div><div class="s">5 of 7 done</div></div><span class="st done">Done</span></div>
          <div class="ui-line"><div class="ui-ic"><span class="material-symbols-outlined">schedule</span></div><div><div class="t">Hours tracked</div><div class="s">From calls, not timesheets</div></div><span class="st acc">Auto</span></div>
          <div class="ui-line"><div class="ui-ic"><span class="material-symbols-outlined">flag</span></div><div><div class="t">Blocker surfaced</div><div class="s">With full context</div></div><span class="st warn">1</span></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- MANAGEMENT INTELLIGENCE -->
<section class="section bg-soft" id="mgt" data-spy="4">
  <div class="sec-inner">
    <div class="zoom">
      <div class="zoom-copy reveal">
        <div class="zoom-step">Step <b>07</b> &nbsp;·&nbsp; Attention</div>
        <h3>Managers see where intervention is needed.</h3>
        <p>Only situations requiring human judgment are surfaced.</p>
      </div>
      <div class="zoom-media right reveal">
        <div class="ui">
          <div class="ui-hd"><span class="material-symbols-outlined">insights</span><b>Executive Pulse</b><span class="uist">Live</span></div>
          <div class="ui-line"><div class="ui-ic"><span class="material-symbols-outlined">trending_up</span></div><div><div class="t">Sprint on track</div><div class="s">92% of commitments met</div></div><span class="st done">On track</span></div>
          <div class="ui-line"><div class="ui-ic"><span class="material-symbols-outlined">warning</span></div><div><div class="t">Needs attention</div><div class="s">1 escalation, 1 decision</div></div><span class="st warn">Act</span></div>
          <div class="ui-line"><div class="ui-ic"><span class="material-symbols-outlined">auto_awesome</span></div><div><div class="t">AI recommendation</div><div class="s">Context included — you decide</div></div><span class="st slate">Humans</span></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="section cta-bg">
  <div class="sec-inner cta-inner reveal">
    <h2 class="cta-h2">Give your IT team a <span>moving workflow.</span></h2>
    <p class="cta-sub">Deploy GoalChaser across your engineering and technology organizations with a plan that scales to every team.</p>
    <div class="cta-actions">
      <button class="btn-primary" onclick="openModal(event)"><span class="material-symbols-outlined" style="font-size:20px;">headset_mic</span>Talk to Us</button>
      <a href="/login" class="btn-ghost">Get Started Free →</a>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="footer-inner">
    <div class="footer-grid">
      <div class="footer-brand">
        <a href="/" class="footer-brand-name">Goal<span>Chaser</span></a>
        <p>The active AI project manager that calls your team — schedules tasks, resolves blockers, monitors performance, and keeps leadership informed automatically.</p>
        <div class="footer-social">
          <a href="mailto:support@goalchaser.co" aria-label="Email"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg></a>
          <a href="https://egeniuscare.com" target="_blank" aria-label="Website"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;"><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg></a>
        </div>
      </div>
      <div class="footer-col"><h5>Product</h5><ul><li><a href="#wf">How It Works</a></li><li><a href="#example">Example</a></li><li><a href="/mobile-app">Mobile App</a></li></ul></div>
      <div class="footer-col"><h5>Solutions</h5><ul><li><a href="/goalchaser-for-it">For Corporate IT</a></li><li><a href="/goalchaser-for-textile">For Textile</a></li><li><a href="/">All Features</a></li></ul></div>
      <div class="footer-col"><h5>Company</h5><ul><li><a href="#">About</a></li><li><a href="#">Careers</a></li></ul></div>
      <div class="footer-col"><h5>Contact</h5><ul><li><a href="mailto:support@goalchaser.co">Email Support</a></li><li><a href="mailto:sales@goalchaser.co">Sales</a></li></ul></div>
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
      <h3>Talk to Us</h3>
      <p>Share your business email and our team will reach out to scale GoalChaser across your organization.</p>
      <input type="email" id="waitlist-email" placeholder="Enter your business email" />
      <button class="modal-submit" onclick="submitWaitlist()">Send Message <span class="material-symbols-outlined" style="font-size:18px;">send</span></button>
    </div>
    <div class="success-state" id="modal-success">
      <div class="success-icon"><span class="material-symbols-outlined">check_circle</span></div>
      <h3 style="font-family:'Nunito',sans-serif;">Message Sent!</h3>
      <p style="font-size:.9rem;color:#64748B;">Our team will reach out to you within 24 hours.</p>
      <button onclick="closeModal()" style="margin-top:1.5rem;background:none;border:none;cursor:pointer;font-weight:800;color:var(--cyan);font-family:inherit;">Close</button>
    </div>
  </div>
</div>

<script>
  const navbar = document.getElementById('navbar');
  const hamburger = document.getElementById('hamburger');
  const mobileMenu = document.getElementById('mobileMenu');

  window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 40);
  }, {passive:true});

  hamburger.addEventListener('click', () => { mobileMenu.classList.toggle('open'); });
  mobileMenu.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => mobileMenu.classList.remove('open'));
  });

  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const target = document.querySelector(a.getAttribute('href'));
      if (target) { e.preventDefault(); target.scrollIntoView({ behavior:'smooth', block:'start' }); }
    });
  });

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) { entry.target.classList.add('visible'); observer.unobserve(entry.target); }
    });
  }, { threshold:0.12, rootMargin:'0px 0px -40px 0px' });
  document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

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
