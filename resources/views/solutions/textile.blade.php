<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GoalChaser for Textile — Your AI Project Manager</title>
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
    nav.scrolled .nav-links a:hover { color:var(--green); }
    .nav-actions { display:flex; align-items:center; gap:1rem; }
    .nav-actions .btn-ghost { font-family:'Nunito',sans-serif; font-size:.875rem; font-weight:700; background:none; border:none; cursor:pointer; text-decoration:none; transition:color .2s; color:rgba(255,255,255,.75); }
    nav.scrolled .nav-actions .btn-ghost { color:var(--s6); }
    .nav-actions .btn-ghost:hover { color:var(--white); }
    nav.scrolled .nav-actions .btn-ghost:hover { color:var(--green); }
    .nav-actions .btn-primary { font-family:'Nunito',sans-serif; font-size:.875rem; font-weight:800; background:var(--green); border:none; padding:.625rem 1.375rem; border-radius:8px; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:.5rem; transition:background .2s,transform .15s; box-shadow:0 4px 14px rgba(14,182,71,.3); color:#fff; }
    nav.scrolled .nav-actions .btn-primary { background:var(--s9); color:#fff; box-shadow:none; }
    nav.scrolled .nav-actions .btn-primary:hover { background:var(--green); }
    .nav-actions .btn-primary:hover { background:var(--green2); transform:translateY(-1px); }
    .nav-hamburger { display:none; background:none; border:none; cursor:pointer; color:#fff; }
    nav.scrolled .nav-hamburger { color:var(--s9); }
    .nav-hamburger svg { width:28px; height:28px; }
    @media(max-width:900px){ .nav-links, .nav-actions .btn-ghost { display:none; } .nav-hamburger { display:block; } }
    .mobile-menu { display:none; background:#fff; border-top:1px solid var(--s3); box-shadow:0 10px 30px rgba(0,0,0,.08); }
    .mobile-menu.open { display:flex; flex-direction:column; padding:1rem 0; }
    .mobile-menu a { padding:.9rem 2rem; text-decoration:none; color:var(--s7); font-weight:700; font-size:.95rem; border-bottom:1px solid var(--s2); }
    .mobile-actions { display:flex; gap:.75rem; padding:1.25rem 2rem; }
    .mobile-actions .btn-primary { background:var(--green); color:#fff; padding:.75rem; border-radius:12px; font-weight:800; display:flex; align-items:center; justify-content:center; gap:.5rem; text-decoration:none; font-family:'Nunito',sans-serif; font-size:.875rem; flex:1; }
    .mobile-actions .btn-ghost { background:var(--s2); color:var(--s7); padding:.75rem; border-radius:12px; font-weight:700; display:flex; align-items:center; justify-content:center; gap:.5rem; text-decoration:none; font-family:'Nunito',sans-serif; font-size:.875rem; flex:1; }

    /* ─── HERO (compact) ─── */
    .hero { position:relative; min-height:88vh; display:flex; align-items:center; overflow:hidden; margin-top:-110px; padding-top:110px; padding-bottom:110px; background-color:#0b1511; }
    .hero-overlay { position:absolute; inset:0; background:
      radial-gradient(900px 500px at 20% 15%, rgba(14,182,71,.18), transparent 60%),
      radial-gradient(800px 500px at 85% 85%, rgba(0,175,240,.12), transparent 60%),
      linear-gradient(135deg,#0B1410 0%,#0c1a14 50%,#0a1511 100%); }
    .hero-grid-bg { position:absolute; inset:0; opacity:.5; background-image:linear-gradient(rgba(14,182,71,.06) 1px,transparent 1px),linear-gradient(90deg,rgba(14,182,71,.06) 1px,transparent 1px); background-size:44px 44px; -webkit-mask-image:radial-gradient(circle at center,black,transparent 75%); mask-image:radial-gradient(circle at center,black,transparent 75%); }
    .hero-glow1 { position:absolute; top:20%; left:15%; width:360px; height:360px; border-radius:50%; background:radial-gradient(circle,rgba(14,182,71,.16),transparent 70%); filter:blur(40px); pointer-events:none; }
    .hero-glow2 { position:absolute; bottom:15%; right:18%; width:320px; height:320px; border-radius:50%; background:radial-gradient(circle,rgba(0,175,240,.12),transparent 70%); filter:blur(40px); pointer-events:none; }

    .hero-inner { height:100vh;max-width:1240px; margin:0 auto; padding:4rem 2rem; width:100%; position:relative; z-index:1; display:grid; grid-template-columns:56% 44%; gap:2.5rem; align-items:center; }
    .hero-eyebrow { display:inline-flex; align-items:center; gap:.5rem; padding:.35rem .9rem; border:1px solid rgba(14,182,71,.35); background:rgba(14,182,71,.1); border-radius:999px; font-size:.68rem; font-weight:800; letter-spacing:.1em; text-transform:uppercase; color:var(--green); margin-bottom:1.25rem; }
    .hero-h1 { font-family:'Nunito',sans-serif; font-size:clamp(2.2rem,4.4vw,3.3rem); font-weight:900; color:#fff; line-height:1.08; letter-spacing:-.04em; margin-bottom:1rem; }
    .hero-h1 .c1 { color:var(--green); }
    .hero-sub { color:rgba(255,255,255,.65); font-size:1.05rem; max-width:500px; line-height:1.7; margin-bottom:1.75rem; }
    .hero-actions { display:flex; gap:1rem; flex-wrap:wrap; margin-bottom:1.5rem; }
    .btn-primary { display:inline-flex; align-items:center; gap:.5rem; padding:.85rem 2rem; background:linear-gradient(135deg,var(--green),var(--green2)); color:#fff; font-weight:800; font-size:.95rem; border-radius:12px; text-decoration:none; border:none; cursor:pointer; box-shadow:0 6px 24px rgba(14,182,71,.35); transition:transform .2s,box-shadow .2s; font-family:inherit; }
    .btn-primary:hover { transform:translateY(-2px); box-shadow:0 10px 32px rgba(14,182,71,.45); }
    .btn-ghost { display:inline-flex; align-items:center; gap:.75rem; padding:.85rem 2rem; background:rgba(255,255,255,.07); border:1px solid rgba(255,255,255,.18); color:#fff; font-weight:700; font-size:.95rem; border-radius:12px; text-decoration:none; cursor:pointer; backdrop-filter:blur(8px); transition:background .2s; font-family:inherit; }
    .btn-ghost:hover { background:rgba(255,255,255,.13); }
    .hero-shorthand { display:flex; align-items:center; gap:.55rem; flex-wrap:wrap; font-size:.8rem; font-weight:700; color:rgba(255,255,255,.5); }
    .hero-shorthand b { color:var(--green); font-weight:800; }
    .hero-shorthand .hs-dot { width:20px; height:20px; border-radius:50%; background:rgba(14,182,71,.16); color:var(--green); display:inline-flex; align-items:center; justify-content:center; font-size:11px; }

    .hf { display:flex; flex-direction:column; gap:.6rem; max-width:360px; }
    .hf-node { display:flex; align-items:center; gap:.85rem; background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.12); border-radius:15px; padding:.75rem .9rem; position:relative; transition:border-color .3s,background .3s; }
    .hf-node.hub { background:rgba(255,255,255,.06); border-color:rgba(255,255,255,.22); }
    .hf-ico { width:40px; height:40px; border-radius:11px; display:flex; align-items:center; justify-content:center; flex-shrink:0; color:#fff; }
    .hf-node.c1 .hf-ico { background:linear-gradient(135deg,#FBBF24,#F59E0B); box-shadow:0 6px 14px rgba(251,191,36,.32); }
    .hf-node.c2 .hf-ico { background:linear-gradient(135deg,#0EB647,#0A9A3B); box-shadow:0 6px 14px rgba(14,182,71,.32); }
    .hf-node.c3 .hf-ico { background:linear-gradient(135deg,#A78BFA,#8B5CF6); box-shadow:0 6px 14px rgba(167,139,250,.32); }
    .hf-node.c4 .hf-ico { background:linear-gradient(135deg,#38BDF8,#0EA5E9); box-shadow:0 6px 14px rgba(56,189,248,.32); }
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
    .sec-head { max-width:760px; margin:0 auto 2.5rem; text-align:center; }
    .eyebrow { display:inline-flex; align-items:center; gap:.5rem; padding:.35rem .9rem; background:#fff; border:1px solid var(--s3); border-radius:8px; font-size:.68rem; font-weight:800; letter-spacing:.1em; text-transform:uppercase; color:var(--green); margin-bottom:1.25rem; box-shadow:0 1px 4px rgba(0,0,0,.06); }
    .sec-h2 { font-family:'Nunito',sans-serif; font-size:clamp(1.9rem,3.6vw,2.8rem); font-weight:900; letter-spacing:-.04em; color:var(--s9); margin-bottom:1rem; }
    .sec-h2 span { color:var(--green); }
    .sec-h2 .sp2 { color:var(--cyan); }
    .sec-sub { font-size:1.05rem; color:var(--s6); line-height:1.7; }

    /* ─── PRIMARY WORKFLOW (alternating spine) ─── */
    .workflow { position:relative; max-width:980px; margin:0 auto; }
    .workflow::before { content:''; position:absolute; top:36px; bottom:36px; left:50%; transform:translateX(-50%); width:3px; border-radius:3px; background:linear-gradient(180deg,var(--s4) 0%,var(--cyan) 45%,var(--green) 100%); opacity:.7; }
    .wf-step { position:relative; width:50%; padding:1rem 3.25rem 1rem 0; }
    .wf-step.right { margin-left:50%; padding:1rem 0 1rem 3.25rem; }
    .wf-step::before { content:attr(data-num); position:absolute; top:50%; transform:translateY(-50%); width:48px; height:48px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:900; color:#fff; background:var(--cyan); border:4px solid #fff; box-shadow:0 4px 14px rgba(0,175,240,.35); z-index:1; }
    .wf-step.work::before, .wf-step.start::before, .wf-step.human::before { background:var(--s9); box-shadow:0 4px 14px rgba(51,65,85,.3); }
    .wf-step.done::before { background:var(--green); box-shadow:0 4px 14px rgba(14,182,71,.35); }
    .wf-step.warn::before { background:var(--amber); box-shadow:0 4px 14px rgba(245,158,11,.3); }
    .wf-step:not(.right)::before { right:-24px; }
    .wf-step.right::before { left:-24px; }
    .wf-row { margin:1.4rem 0; background:#fff; border:1px solid var(--s3); border-radius:18px; padding:1.15rem 1.4rem; display:flex; align-items:center; gap:1.25rem; transition:transform .3s,box-shadow .3s,border-color .3s; }
    .wf-row:hover { box-shadow:0 12px 30px rgba(0,0,0,.06); border-color:rgba(14,182,71,.35); }
    .wf-step:not(.right) .wf-row:hover { transform:translateX(-4px); }
    .wf-step.right .wf-row:hover { transform:translateX(4px); }
    .wf-row.ai { background:linear-gradient(0deg,rgba(14,182,71,.05),rgba(14,182,71,.02)); border-color:rgba(14,182,71,.28); }
    .wf-ico { width:42px; height:42px; border-radius:11px; background:rgba(14,182,71,.12); color:var(--green); display:flex; align-items:center; justify-content:center; flex-shrink:0; font-size:1.3rem; }
    .wf-row.ai .wf-ico { background:var(--green); color:#fff; }
    .wf-row.done .wf-ico { background:rgba(0,175,240,.12); color:var(--cyan); }
    .wf-copy { flex:1; min-width:0; }
    .wf-title { font-size:1.08rem; font-weight:900; color:var(--s9); }
    .wf-sub { font-size:.85rem; color:var(--s6); margin-top:2px; }
    .wf-note { font-size:.72rem; font-weight:800; letter-spacing:.05em; text-transform:uppercase; color:var(--s5); flex-shrink:0; display:flex; align-items:center; gap:.4rem; }
    .wf-note .material-symbols-outlined { font-size:16px; }
    @media(max-width:900px){
      .workflow::before { left:24px; transform:none; top:36px; bottom:36px; }
      .wf-step, .wf-step.right { width:100%; margin-left:0; padding:1rem 0 1rem 64px; }
      .wf-step::before, .wf-step.right::before { left:0; right:auto; width:48px; height:48px; }
    }

    /* ─── AI + HUMAN ROLES ─── */
    .roles { max-width:980px; margin:0 auto; display:grid; grid-template-columns:repeat(3,1fr); gap:1.25rem; align-items:stretch; }
    .role-card { background:#fff; border:1px solid var(--s3); border-radius:18px; padding:1.6rem 1.5rem; text-align:center; transition:transform .3s,box-shadow .3s,border-color .3s; }
    .role-card:hover { transform:translateY(-4px); box-shadow:0 14px 34px rgba(0,0,0,.07); }
    .role-card.highlight { background:var(--navy); border-color:var(--navy); color:#fff; }
    .role-ico { width:52px; height:52px; border-radius:14px; background:rgba(14,182,71,.12); color:var(--green); display:flex; align-items:center; justify-content:center; margin:0 auto 1rem; font-size:1.5rem; }
    .role-card.highlight .role-ico { background:var(--green); color:#fff; box-shadow:0 8px 20px rgba(14,182,71,.35); }
    .role-name { font-size:1rem; font-weight:900; color:var(--s9); margin-bottom:.4rem; }
    .role-card.highlight .role-name { color:#fff; }
    .role-verbs { display:flex; flex-wrap:wrap; gap:.4rem; justify-content:center; }
    .role-verbs span { font-size:.72rem; font-weight:800; letter-spacing:.03em; color:var(--s7); background:var(--s2); border:1px solid var(--s3); border-radius:999px; padding:.28rem .7rem; }
    .role-card.highlight .role-verbs span { background:rgba(255,255,255,.1); border-color:rgba(255,255,255,.16); color:#fff; }
    @media(max-width:760px){ .roles { grid-template-columns:1fr; max-width:420px; } }

    /* ─── MINI FLOW (scenario step-down) ─── */
    .mini { display:flex; flex-direction:column; max-width:820px; margin:0 auto; }
    .mini-item { display:flex; align-items:center; gap:1.1rem; background:#fff; border:1px solid var(--s3); border-radius:14px; padding:1rem 1.3rem; }
    .mini-ico { width:40px; height:40px; border-radius:11px; display:flex; align-items:center; justify-content:center; flex-shrink:0; background:rgba(14,182,71,.12); color:var(--green); }
    .mini-item.tool .mini-ico { background:#F1F5F9; color:var(--s9); }
    .mini-item.ai .mini-ico { background:var(--green); color:#fff; }
    .mini-item.emp .mini-ico { background:rgba(0,175,240,.14); color:var(--cyan); }
    .mini-item.warn .mini-ico { background:rgba(245,158,11,.14); color:var(--amber); }
    .mini-item.done .mini-ico { background:rgba(14,182,71,.14); color:var(--green); }
    .mini-item.human .mini-ico { background:#EEF2F7; color:var(--s9); }
    .mini-label { font-weight:800; color:var(--s9); font-size:.95rem; }
    .mini-desc { font-size:.78rem; color:var(--s6); margin-top:2px; font-weight:600; }
    .mini-tag { font-size:.7rem; font-weight:800; text-transform:uppercase; letter-spacing:.05em; color:var(--s5); margin-left:auto; flex-shrink:0; display:flex; align-items:center; gap:.35rem; }
    .mini-arrow { text-align:center; color:var(--green); line-height:0; padding:.25rem 0; opacity:.7; }

    /* ─── PO DOC → GOALCHASER (step 01) ─── */
    .po-wrap { max-width:820px; margin:0 auto; display:flex; align-items:center; gap:1.5rem; }
    .po-doc { flex:1; background:#fff; border:1px solid var(--s3); border-radius:16px; padding:1.4rem; box-shadow:0 14px 34px rgba(0,0,0,.06); }
    .po-hd { display:flex; align-items:center; justify-content:space-between; margin-bottom:1.1rem; }
    .po-hd b { font-size:.95rem; color:var(--s9); font-weight:900; }
    .po-hd .ph { font-size:.68rem; font-weight:800; text-transform:uppercase; color:var(--s5); }
    .po-row { display:flex; justify-content:space-between; padding:.55rem 0; border-top:1px dashed var(--s3); font-size:.85rem; color:var(--s7); font-weight:700; }
    .po-row b { color:var(--s9); font-size:.82rem; }
    .gc-core { width:160px; flex-shrink:0; background:var(--navy); border-radius:16px; padding:1.3rem 1.1rem; text-align:center; color:#fff; position:relative; }
    .gc-core .gci { width:46px; height:46px; border-radius:12px; background:var(--green); display:flex; align-items:center; justify-content:center; margin:0 auto .6rem; }
    .gc-core b { display:block; font-size:.9rem; font-weight:900; }
    .gc-core p { font-size:.68rem; color:rgba(255,255,255,.6); margin-top:.15rem; }
    .po-extract { flex:1; display:flex; flex-direction:column; gap:.6rem; }
    .po-chip { display:flex; align-items:center; gap:.6rem; background:#fff; border:1px solid var(--s3); border-radius:12px; padding:.7rem 1rem; font-size:.82rem; font-weight:800; color:var(--s9); }
    .po-chip .material-symbols-outlined { color:var(--green); font-size:1.15rem; }
    .po-chip b { margin-left:auto; color:var(--green); font-size:.72rem; text-transform:uppercase; }
    @media(max-width:900px){ .po-wrap { flex-direction:column; align-items:stretch; } .gc-core { width:100%; } .po-extract { flex-direction:row; flex-wrap:wrap; } .po-chip { flex:1; min-width:150px; } }

    /* ─── HIERARCHY TREE (plan + approval) ─── */
    .tree { max-width:520px; margin:0 auto; display:flex; flex-direction:column; align-items:center; }
    .tree-node { display:flex; align-items:center; gap:.75rem; min-width:240px; background:#fff; border:1px solid var(--s3); border-radius:13px; padding:.8rem 1.2rem; font-weight:800; color:var(--s9); font-size:.9rem; position:relative; }
    .tree-node .tn-ico { width:36px; height:36px; border-radius:10px; background:rgba(14,182,71,.12); color:var(--green); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .tree-node.human .tn-ico { background:#EEF2F7; color:var(--s9); }
    .tree-node .tn-appr { margin-left:auto; width:22px; height:22px; border-radius:50%; background:rgba(14,182,71,.15); color:var(--green); display:flex; align-items:center; justify-content:center; font-size:13px; flex-shrink:0; }
    .tree-life { width:2px; height:24px; background:var(--s3); }
    .tree-arrow { color:var(--green); line-height:0; padding:.15rem 0; }

    /* ─── DAILY CYCLE (step 05) ─── */
    .cycle { max-width:720px; margin:0 auto; position:relative; }
    .cycle-group { display:grid; grid-template-columns:1fr 1fr 1fr; gap:1.25rem; }
    .cyc { background:#fff; border:1px solid var(--s3); border-radius:18px; padding:1.6rem 1.4rem; text-align:center; }
    .cyc-ico { width:50px; height:50px; border-radius:50%; background:var(--green); color:#fff; display:flex; align-items:center; justify-content:center; margin:0 auto .9rem; box-shadow:0 8px 20px rgba(14,182,71,.3); }
    .cyc-ico.c2 { background:var(--cyan); box-shadow:0 8px 20px rgba(0,175,240,.3); }
    .cyc-ico.c3 { background:var(--s9); box-shadow:0 8px 20px rgba(51,65,85,.3); }
    .cyc-label { font-size:.72rem; font-weight:800; text-transform:uppercase; letter-spacing:.06em; color:var(--cyan); margin-bottom:.35rem; }
    .cyc-time { font-size:1rem; font-weight:900; color:var(--s9); margin-bottom:.45rem; }
    .cyc-act { font-size:.85rem; font-weight:800; color:var(--s9); margin-bottom:.2rem; }
    .cyc-desc { font-size:.78rem; color:var(--s6); line-height:1.5; }
    .cycle-loop { display:flex; align-items:center; justify-content:center; gap:.6rem; margin-top:1.5rem; color:var(--green); font-weight:800; font-size:.85rem; }
    .cycle-loop .material-symbols-outlined { animation:spin 6s linear infinite; font-size:1.2rem; }
    @keyframes spin { to { transform:rotate(360deg); } }
    @media(max-width:760px){ .cycle-group { grid-template-columns:1fr; } }

    /* ─── BRANCH / ESCALATION (step 07) ─── */
    .branch { max-width:760px; margin:0 auto; display:flex; flex-direction:column; align-items:center; }
    .brk-top { display:flex; flex-direction:column; align-items:center; gap:.5rem; }
    .brk-node { display:flex; align-items:center; gap:.75rem; background:#fff; border:1px solid var(--s3); border-radius:14px; padding:.85rem 1.3rem; font-weight:900; color:var(--s9); font-size:.92rem; min-width:220px; justify-content:center; }
    .brk-node .material-symbols-outlined { color:var(--cyan); }
    .brk-node.warn { border-color:rgba(245,158,11,.5); background:#fffbf0; }
    .brk-node.warn .material-symbols-outlined { color:var(--amber); }
    .brk-node.ai { background:var(--navy); color:#fff; border-color:var(--navy); }
    .brk-node.ai .material-symbols-outlined { color:var(--green); }
    .brk-split { display:grid; grid-template-columns:1fr 1fr; gap:1.25rem; width:100%; margin-top:.75rem; }
    .brk-a { text-align:center; position:relative; }
    .brk-a::before { content:''; position:absolute; top:0; left:-.7rem; right:50%; height:2px; background:var(--s3); }
    @media(min-width:761px){ .brk-split { margin-top:1.4rem; } }
    .brk-a h5 { font-size:.78rem; font-weight:800; text-transform:uppercase; letter-spacing:.06em; margin:.4rem 0 .8rem; color:var(--s6); }
    .brk-a .brk-node { justify-content:center; margin:0 auto .5rem; }
    .brk-a .mat { font-size:.72rem; font-weight:700; color:var(--s5); }
    .brk-a.good .material-symbols-outlined { color:var(--green); }
    .brk-a.human .material-symbols-outlined { color:var(--s7); }
    @media(max-width:700px){ .brk-split { grid-template-columns:1fr; } .brk-a::before{ display:none; } }

    /* ─── DASHBOARD (step 08) ─── */
    .dash { max-width:800px; margin:0 auto; }
    .dash-grid { display:grid; grid-template-columns:repeat(5,1fr); gap:1rem; margin-bottom:1rem; }
    .dash-cell { background:#fff; border:1px solid var(--s3); border-radius:16px; padding:1.4rem 1rem; text-align:center; }
    .dash-val { font-size:2rem; font-weight:900; color:var(--s9); }
    .dash-val .u { font-size:1rem; color:var(--s6); }
    .dash-val.green { color:var(--green); }
    .dash-val.cyan { color:var(--cyan); }
    .dash-val.amber { color:var(--amber); }
    .dash-lab { font-size:.78rem; font-weight:800; color:var(--s6); margin-top:.25rem; }
    .dash-tag { font-size:.62rem; font-weight:800; text-transform:uppercase; letter-spacing:.05em; color:var(--s5); margin-top:.2rem; }
    .dash-ai { background:var(--navy); border-radius:14px; padding:1.1rem 1.4rem; display:flex; align-items:center; gap:1rem; color:#fff; }
    .dash-ai .material-symbols-outlined { color:var(--green); font-size:1.6rem; flex-shrink:0; }
    .dash-ai b { font-size:.9rem; font-weight:800; display:block; margin-bottom:.15rem; }
    .dash-ai p { font-size:.8rem; color:rgba(255,255,255,.65); }
    @media(max-width:760px){ .dash-grid { grid-template-columns:repeat(2,1fr); } }

    /* ─── ZOOM IN COMPONENT ROWS ─── */
    .zoom { display:grid; grid-template-columns:1fr 1fr; gap:3rem; align-items:center; max-width:1080px; margin:0 auto 4rem; }
    .zoom:last-child { margin-bottom:0; }
    .zoom-step { display:inline-flex; align-items:center; gap:.45rem; padding:.32rem .85rem; border:1px solid var(--s3); border-radius:999px; background:#fff; font-size:.72rem; font-weight:800; color:var(--s6); letter-spacing:.04em; margin-bottom:1rem; }
    .zoom-step b { color:var(--green); }
    .zoom h3 { font-size:1.6rem; font-weight:900; color:var(--s9); letter-spacing:-.02em; margin-bottom:.6rem; }
    .zoom p { color:var(--s6); font-size:.97rem; line-height:1.65; max-width:420px; }
    @media(max-width:900px){ .zoom { grid-template-columns:1fr; gap:2rem; } }

    /* ─── AI CALL / PHONE MOCKUP ─── */
    .phone { width:280px; margin:0 auto; background:#0e1a17; border:6px solid #223; border-radius:38px; padding:10px; box-shadow:0 30px 70px rgba(0,0,0,.35); }
    .phone-screen { background:radial-gradient(120% 100% at 20% 0%, #123b2b 0%, #0b1714 55%, #081210 100%); border-radius:30px; overflow:hidden; position:relative; color:#fff; display:flex; flex-direction:column; padding:1.6rem 1.3rem 1.4rem; min-height:440px; }
    .phone-notch { position:absolute; top:10px; left:50%; transform:translateX(-50%); width:110px; height:22px; background:#0a1411; border-radius:999px; }
    .call-top { text-align:center; margin-top:1.1rem; }
    .call-avatar { width:92px; height:92px; margin:0 auto .9rem; border-radius:26px; background:linear-gradient(135deg,var(--green),#0a6); display:flex; align-items:center; justify-content:center; box-shadow:0 14px 34px rgba(14,182,71,.45); }
    .call-avatar .material-symbols-outlined { font-size:2.4rem; color:#fff; }
    .call-name { font-size:1.15rem; font-weight:900; }
    .call-sub { font-size:.72rem; color:rgba(255,255,255,.55); margin-top:.15rem; }
    .call-status { display:inline-flex; align-items:center; gap:.4rem; margin-top:.35rem; font-size:.7rem; font-weight:800; color:var(--cyan); background:rgba(0,175,240,.12); border:1px solid rgba(0,175,240,.35); padding:.25rem .7rem; border-radius:999px; }
    .call-status .pulse { width:8px; height:8px; border-radius:50%; background:var(--cyan); animation:blink 1.2s infinite; }
    @keyframes blink { 0%,100% { opacity:1; } 50% { opacity:.25; } }
    .call-bar { height:2px; background:rgba(255,255,255,.1); border-radius:2px; margin:1.3rem 0; overflow:hidden; }
    .call-bar span { display:block; height:100%; width:65%; background:linear-gradient(90deg,var(--cyan),var(--green)); animation:callwave 2.4s ease-in-out infinite; }
    @keyframes callwave { 0% { transform:translateX(-100%); } 100% { transform:translateX(160%); } }
    .call-transcript { flex:1; display:flex; flex-direction:column; gap:.55rem; }
    .ct-line { display:flex; gap:.5rem; font-size:.74rem; line-height:1.45; }
    .ct-line .who { flex-shrink:0; font-weight:900; color:var(--green); font-size:.62rem; text-transform:uppercase; letter-spacing:.05em; }
    .ct-line.ai .who { color:var(--cyan); }
    .ct-line p { color:rgba(255,255,255,.72); margin:0; }
    .ct-ai b { color:#fff; }
    .call-controls { display:flex; justify-content:space-between; gap:.6rem; margin-top:1.2rem; }
    .cc-btn { flex:1; display:flex; align-items:center; justify-content:center; gap:.4rem; padding:.6rem; border-radius:12px; font-size:.68rem; font-weight:800; background:rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.12); color:#fff; }
    .cc-btn.accept { background:var(--green); border-color:var(--green); }
    .cc-btn.decline { background:var(--amber); border-color:var(--amber); color:#fff; }
    .cc-btn .material-symbols-outlined { font-size:1.05rem; }
    .call-float { position:absolute; top:1.5rem; right:1.3rem; width:34px; height:34px; border-radius:50%; background:var(--cyan); color:#fff; display:flex; align-items:center; justify-content:center; font-size:18px; box-shadow:0 6px 16px rgba(0,175,240,.4); }

    /* mobile / mini UI card */
    .ui { background:var(--s1); border:1px solid var(--s3); border-radius:18px; padding:1.5rem; box-shadow:0 16px 40px rgba(0,0,0,.06); }
    .ui-hd { display:flex; align-items:center; gap:.6rem; margin-bottom:1.1rem; }
    .ui-hd .material-symbols-outlined { color:var(--green); font-size:1.4rem; }
    .ui-hd b { font-size:.9rem; font-weight:900; color:var(--s9); }
    .ui-line { display:flex; align-items:center; gap:.75rem; background:#fff; border:1px solid var(--s3); border-radius:12px; padding:.75rem .9rem; margin-bottom:.6rem; }
    .ui-line:last-child { margin-bottom:0; }
    .ui-ic { width:34px; height:34px; border-radius:9px; background:rgba(14,182,71,.12); color:var(--green); display:flex; align-items:center; justify-content:center; font-size:1.05rem; flex-shrink:0; }
    .ui-line .t { font-size:.8rem; font-weight:800; color:var(--s9); }
    .ui-line .s { font-size:.72rem; color:var(--s6); }

    /* audit + mobile simple bands */
    .audit { max-width:820px; margin:0 auto; display:flex; flex-wrap:wrap; gap:1rem; justify-content:center; }
    .audit-chip { display:flex; align-items:center; gap:.7rem; background:#fff; border:1px solid var(--s3); border-radius:14px; padding:.9rem 1.3rem; font-weight:800; color:var(--s9); font-size:.9rem; }
    .audit-chip .material-symbols-outlined { color:var(--green); }
    .audit-chip b { color:var(--s5); font-size:.72rem; text-transform:uppercase; letter-spacing:.05em; margin-left:.5rem; }

    /* ─── SIGNATURE WORKFLOW (final) ─── */
    .sig { max-width:520px; margin:0 auto; text-align:center; }
    .sig-step { display:inline-flex; align-items:center; gap:.6rem; padding:.8rem 1.5rem; border-radius:999px; background:#fff; border:1px solid var(--s3); font-weight:800; font-size:.88rem; color:var(--s9); }
    .sig-step.ai { background:var(--navy); color:#fff; border-color:var(--navy); }
    .sig-step.ai .material-symbols-outlined { color:var(--green); }
    .sig-step.green { border-color:rgba(14,182,71,.4); background:rgba(14,182,71,.08); color:var(--green2); }
    .sig-step.amber { border-color:rgba(245,158,11,.4); background:#fffbf0; color:var(--amber); }
    .sig-step .material-symbols-outlined { font-size:1.05rem; }
    .sig-line { height:26px; width:2px; background:var(--s3); margin:0 auto; }
    .sig-split { display:grid; grid-template-columns:1fr 1fr; gap:1.5rem; }
    .sig-fork { display:flex; flex-direction:column; align-items:center; }
    .sig-fork .sig-line { height:22px; background:var(--s3); }
    .sig-join { height:26px; width:2px; background:var(--s3); margin:0 auto; }
    @media(max-width:520px){ .sig-split { grid-template-columns:1fr; } }

    /* ─── OUTCOME ─── */
    .outcome-bg { background:linear-gradient(160deg,var(--navy),var(--navy2)); position:relative; overflow:hidden; text-align:center; }
    .outcome-bg::before { content:''; position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); width:640px; height:640px; background:radial-gradient(circle,rgba(14,182,71,.14),transparent 70%); pointer-events:none; }
    .outcome-inner { position:relative; z-index:1; }
    .outcome-h { font-size:clamp(1.8rem,3.4vw,2.6rem); font-weight:900; color:#fff; letter-spacing:-.03em; margin-bottom:.75rem; }
    .outcome-h span { color:var(--green); }
    .chain-x { display:flex; align-items:center; justify-content:center; flex-wrap:wrap; gap:.6rem; margin:1.75rem auto 0; }
    .chain-x .cx-item { display:flex; align-items:center; gap:.5rem; background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.14); border-radius:999px; padding:.55rem 1.2rem; color:#fff; font-weight:800; font-size:.85rem; }
    .chain-x .cx-item .material-symbols-outlined { color:var(--green); }
    .chain-x .cx-arrow { color:rgba(255,255,255,.5); }
    .chain-x .cx-item.hl { background:var(--green); border-color:var(--green); }
    .chain-x .cx-item.warnhl { background:var(--amber); border-color:var(--amber); color:#fff; }
    .chain-x .cx-item.hl .material-symbols-outlined, .chain-x .cx-item.warnhl .material-symbols-outlined { color:#fff; }

    /* ─── FOOTER ─── */
    footer { background:var(--navy); color:rgba(255,255,255,.7); border-top:1px solid rgba(255,255,255,.08); padding:4rem 2rem 2rem; }
    .footer-inner { max-width:1240px; margin:0 auto; }
    .footer-grid { display:grid; grid-template-columns:2fr 1fr 1fr 1fr 1fr; gap:2.5rem; margin-bottom:3rem; }
    .footer-brand-name { font-size:1.35rem; font-weight:900; color:#fff; letter-spacing:-.5px; text-decoration:none; display:block; margin-bottom:1rem; }
    .footer-brand-name span { color:var(--green); }
    .footer-brand p { font-size:.88rem; line-height:1.7; margin-top:1.25rem; max-width:340px; color:rgba(255,255,255,.6); }
    .footer-social { display:flex; gap:.75rem; margin-top:1.5rem; }
    .footer-social a { width:38px; height:38px; border-radius:10px; border:1px solid rgba(255,255,255,.14); display:flex; align-items:center; justify-content:center; color:rgba(255,255,255,.7); transition:all .2s; }
    .footer-social a:hover { border-color:var(--green); color:var(--green); }
    .footer-col h5 { font-size:.78rem; font-weight:800; text-transform:uppercase; letter-spacing:.08em; color:#fff; margin-bottom:1.1rem; }
    .footer-col ul { list-style:none; display:flex; flex-direction:column; gap:.6rem; }
    .footer-col a { color:rgba(255,255,255,.6); text-decoration:none; font-size:.88rem; transition:color .2s; }
    .footer-col a:hover { color:var(--green); }
    .footer-bottom { border-top:1px solid rgba(255,255,255,.1); padding-top:1.75rem; display:flex; justify-content:space-between; flex-wrap:wrap; gap:1rem; font-size:.82rem; color:rgba(255,255,255,.5); }
    .footer-bottom a { color:rgba(255,255,255,.7); text-decoration:none; }
    @media(max-width:900px){ .footer-grid { grid-template-columns:1fr 1fr; } .footer-brand{ grid-column:1/-1; } }
    @media(max-width:640px){ .footer-grid { grid-template-columns:1fr; } .section { padding:4rem 1.25rem; } }

    /* ─── CTA ─── */
    .cta-bg { background:var(--navy); text-align:center; position:relative; overflow:hidden; }
    .cta-bg::before { content:''; position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); width:600px; height:600px; background:radial-gradient(circle,rgba(14,182,71,.14),transparent 70%); pointer-events:none; }
    .cta-inner { position:relative; z-index:1; }
    .cta-h2 { font-family:'Nunito',sans-serif; font-size:clamp(2rem,4vw,3.1rem); font-weight:900; color:#fff; letter-spacing:-.04em; margin-bottom:1rem; }
    .cta-h2 span { color:var(--green); }
    .cta-sub { font-size:1.05rem; color:rgba(255,255,255,.6); max-width:620px; margin:0 auto 2.5rem; line-height:1.7; }
    .cta-actions { display:flex; gap:1rem; justify-content:center; flex-wrap:wrap; }

    /* ─── MODAL ─── */
    .modal-overlay { position:fixed; inset:0; z-index:200; display:flex; align-items:center; justify-content:center; padding:1rem; background:rgba(15,23,42,.6); backdrop-filter:blur(4px); opacity:0; pointer-events:none; transition:opacity .3s; }
    .modal-overlay.open { opacity:1; pointer-events:auto; }
    .modal { position:relative; max-width:440px; width:100%; background:#fff; border-radius:20px; padding:2.25rem; text-align:center; transform:translateY(20px); transition:transform .3s; box-shadow:0 30px 80px rgba(0,0,0,.3); }
    .modal-overlay.open .modal { transform:translateY(0); }
    .modal-close { position:absolute; top:1rem; right:1rem; background:none; border:none; cursor:pointer; color:var(--s6); }
    .modal-icon { width:60px; height:60px; border-radius:16px; background:rgba(14,182,71,.1); color:var(--green); display:flex; align-items:center; justify-content:center; margin:0 auto 1.1rem; font-size:2rem; }
    .modal h3 { font-size:1.5rem; font-weight:900; color:var(--s9); margin-bottom:.5rem; font-family:'Nunito',sans-serif; }
    .modal p { font-size:.9rem; color:var(--s6); line-height:1.6; margin-bottom:1.5rem; }
    .modal input { width:100%; padding:.85rem 1rem; border:1px solid var(--s3); border-radius:12px; font-size:.9rem; font-family:'Nunito',sans-serif; margin-bottom:.9rem; outline:none; transition:border-color .2s; }
    .modal input:focus { border-color:var(--green); }
    .modal-submit { width:100%; padding:.9rem; border:none; border-radius:12px; background:linear-gradient(135deg,var(--green),var(--green2)); color:#fff; font-weight:800; font-size:.92rem; cursor:pointer; font-family:'Nunito',sans-serif; display:flex; align-items:center; justify-content:center; gap:.5rem; transition:transform .15s; }
    .modal-submit:hover { transform:translateY(-1px); }
    .success-icon { width:60px; height:60px; border-radius:16px; background:rgba(0,175,240,.12); color:var(--cyan); display:flex; align-items:center; justify-content:center; margin:0 auto 1.1rem; font-size:2rem; }
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
      <li><a href="#po">Workflow</a></li>
      <li><a href="#daily">Follow-up</a></li>
      <li><a href="#report">Reporting</a></li>
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
    <a href="#po">Workflow</a>
    <a href="#daily">Follow-up</a>
    <a href="#report">Reporting</a>
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

      <h1 class="hero-h1">Keep operations moving. <span class="c1">Without chasing anyone.</span></h1>
      <p class="hero-sub">AI calls your team, surfaces blockers, and keeps management informed.</p>
      <div class="hero-actions">
        <a href="#wf" class="btn-primary">See How It Works <span class="material-symbols-outlined" style="font-size:18px;">arrow_forward</span></a>
        <button class="btn-ghost" onclick="openModal(event)">Talk to Us</button>
      </div>
      <div class="hero-shorthand">
        <span>Plan</span>
        <span class="hs-dot"><span class="material-symbols-outlined" style="font-size:12px;">arrow_forward</span></span>
        <span>Communicate</span>
        <span class="hs-dot"><span class="material-symbols-outlined" style="font-size:12px;">arrow_forward</span></span>
        <span>Follow Up</span>
        <span class="hs-dot"><span class="material-symbols-outlined" style="font-size:12px;">arrow_forward</span></span>
        <b>Report</b>
      </div>
    </div>

    <div class="hero-visual">
      <div class="hf">
        <div class="hf-node c1">
          <div class="hf-ico"><span class="material-symbols-outlined">receipt_long</span></div>
          <div><div class="hf-label">Purchase Order</div><div class="hf-sub">Production plan &amp; targets set</div></div>
          <div class="hf-step">1</div>
        </div>
        <div class="hf-arrow"><span class="material-symbols-outlined">expand_more</span></div>
        <div class="hf-node c2 hub">
          <div class="hf-ico"><span class="material-symbols-outlined">smart_toy</span></div>
          <div><div class="hf-label">GoalChaser AI</div><div class="hf-sub">Calls every shift &amp; unit</div></div>
          <div class="hf-step">2</div>
        </div>
        <div class="hf-arrow"><span class="material-symbols-outlined">expand_more</span></div>
        <div class="hf-node c3">
          <div class="hf-ico"><span class="material-symbols-outlined">shield</span></div>
          <div><div class="hf-label">Blockers &amp; Recovery</div><div class="hf-sub">Exceptions surfaced, fixed fast</div></div>
          <div class="hf-step">3</div>
        </div>
        <div class="hf-arrow"><span class="material-symbols-outlined">expand_more</span></div>
        <div class="hf-node c4">
          <div class="hf-ico"><span class="material-symbols-outlined">monitor</span></div>
          <div><div class="hf-label">Management View</div><div class="hf-sub">Live dashboards &amp; reports</div></div>
          <div class="hf-step">4</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- AI CALLS YOUR TEAM -->
<section class="section bg-white" id="calls">
  <div class="sec-inner">
    <div class="zoom">
      <div class="zoom-copy reveal">
        <div class="zoom-step"><span class="material-symbols-outlined" style="font-size:15px;color:var(--green);">call</span>Always-on <b>follow-up</b></div>
        <h3 style="font-size:clamp(2rem,3.4vw,2.7rem);">GoalChaser calls your team — so they never have to be chased.</h3>
        <p>The AI calls people, asks what's done, stuck and next, then updates the plan automatically.</p>
        <div class="call-float" style="position:static;width:34px;height:34px;border-radius:50%;background:var(--cyan);color:#fff;display:inline-flex;align-items:center;justify-content:center;font-size:18px;margin:1rem 0 0;"><span class="material-symbols-outlined">auto_awesome</span></div>
      </div>
      <div class="reveal">
        <div class="phone">
          <div class="phone-screen">
            <div class="phone-notch"></div>
            <div class="call-top">
              <div class="call-avatar"><span class="material-symbols-outlined">auto_awesome</span></div>
              <div class="call-name">GoalChaser AI</div>
              <div class="call-sub">Unit Manager · Shift check-in</div>
              <div class="call-status"><span class="pulse"></span>Live conversation</div>
            </div>
            <div class="call-bar"><span></span></div>
            <div class="call-transcript">
              <div class="ct-line ai"><span class="who">AI</span><p class="ct-ai"><b>"Hi, how's line 4 looking today?"</b></p></div>
              <div class="ct-line"><span class="who">Team</span><p>"Running at 60% — stitching is 2 days ahead."</p></div>
              <div class="ct-line ai"><span class="who">AI</span><p class="ct-ai"><b>"Noted. Any blockers?"</b></p></div>
              <div class="ct-line"><span class="who">Team</span><p>"Unit B feeder is slow, but manageable."</p></div>
            </div>
            <div class="call-controls">
              <div class="cc-btn decline"><span class="material-symbols-outlined">call_end</span>End</div>
              <div class="cc-btn accept"><span class="material-symbols-outlined">check</span>Log Update</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- PRIMARY WORKFLOW -->
<section class="section bg-soft" id="wf">
  <div class="sec-inner">
    <div class="sec-head reveal">
      <div class="eyebrow"><span class="material-symbols-outlined">account_tree</span>How It Works</div>
      <h2 class="sec-h2">From purchase order <span>to production.</span></h2>
      <p class="sec-sub">GoalChaser connects planning, execution, communication, recovery, and reporting into one continuous workflow.</p>
    </div>

    <div class="workflow reveal">
      <div class="wf-step start" data-num="01">
        <div class="wf-row">
          <div class="wf-ico"><span class="material-symbols-outlined">receipt_long</span></div>
          <div class="wf-copy"><div class="wf-title">Purchase order arrives</div><div class="wf-sub">Buyer PO is uploaded — every field read in minutes.</div></div>
          <div class="wf-note"><span class="material-symbols-outlined">inbox</span>Start</div>
        </div>
      </div>
      <div class="wf-step right done" data-num="02">
        <div class="wf-row ai">
          <div class="wf-ico"><span class="material-symbols-outlined">route</span></div>
          <div class="wf-copy"><div class="wf-title">AI plans &amp; assesses risk</div><div class="wf-sub">Task plans and a risk assessment are ready to review.</div></div>
          <div class="wf-note"><span class="material-symbols-outlined">auto_awesome</span>Plan</div>
        </div>
      </div>
      <div class="wf-step human" data-num="03">
        <div class="wf-row">
          <div class="wf-ico"><span class="material-symbols-outlined">how_to_reg</span></div>
          <div class="wf-copy"><div class="wf-title">Approval chain</div><div class="wf-sub">CEO → AVP → GM → Manager → Unit Incharge — tracked, not chased.</div></div>
          <div class="wf-note"><span class="material-symbols-outlined">group</span>Approve</div>
        </div>
      </div>
      <div class="wf-step right done" data-num="04">
        <div class="wf-row ai">
          <div class="wf-ico"><span class="material-symbols-outlined">call</span></div>
          <div class="wf-copy"><div class="wf-title">AI daily follow-up calls</div><div class="wf-sub">Every shift, every unit — updates logged, exceptions surfaced.</div></div>
          <div class="wf-note"><span class="material-symbols-outlined">record_voice_over</span>Follow up</div>
        </div>
      </div>
      <div class="wf-step warn" data-num="05">
        <div class="wf-row">
          <div class="wf-ico"><span class="material-symbols-outlined">healing</span></div>
          <div class="wf-copy"><div class="wf-title">Exceptions &amp; blockers resolved</div><div class="wf-sub">Machine issue → manager alerted → overtime authorized in minutes.</div></div>
          <div class="wf-note"><span class="material-symbols-outlined">flag</span>Resolve</div>
        </div>
      </div>
      <div class="wf-step right done" data-num="06">
        <div class="wf-row ai">
          <div class="wf-ico"><span class="material-symbols-outlined">auto_awesome</span></div>
          <div class="wf-copy"><div class="wf-title">AI flags &amp; creates tasks</div><div class="wf-sub">QC rework is drafted, approved, and assigned automatically.</div></div>
          <div class="wf-note"><span class="material-symbols-outlined">add_task</span>Auto-task</div>
        </div>
      </div>
      <div class="wf-step done" data-num="07">
        <div class="wf-row ai">
          <div class="wf-ico"><span class="material-symbols-outlined">summarize</span></div>
          <div class="wf-copy"><div class="wf-title">Daily briefing &amp; reports</div><div class="wf-sub">GM briefing call + dashboards compiled into shareable reports.</div></div>
          <div class="wf-note"><span class="material-symbols-outlined">bar_chart</span>Report</div>
        </div>
      </div>
      <div class="wf-step right human" data-num="08">
        <div class="wf-row">
          <div class="wf-ico"><span class="material-symbols-outlined">local_shipping</span></div>
          <div class="wf-copy"><div class="wf-title">Dispatch &amp; audit trail</div><div class="wf-sub">Checklist completed, shipment closed, full timestamped audit.</div></div>
          <div class="wf-note"><span class="material-symbols-outlined">verified</span>Dispatch</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- AI + HUMAN -->
<section class="section bg-white" id="roles">
  <div class="sec-inner">
    <div class="sec-head reveal">
      <div class="eyebrow"><span class="material-symbols-outlined">people_alt</span>The Goal</div>
      <h2 class="sec-h2">AI handles the follow-up. <span>You handle the decisions.</span></h2>
      <p class="sec-sub">GoalChaser plans, calls, asks, understands and reports. People approve, decide, and step in when it matters.</p>
    </div>
    <div class="roles reveal">
      <div class="role-card highlight">
        <div class="role-ico"><span class="material-symbols-outlined">auto_awesome</span></div>
        <div class="role-name">GoalChaser AI</div>
        <div class="role-verbs"><span>Calls</span><span>Checks</span><span>Understands</span><span>Reports</span></div>
      </div>
      <div class="role-card">
        <div class="role-ico"><span class="material-symbols-outlined">groups</span></div>
        <div class="role-name">Your Team</div>
        <div class="role-verbs"><span>Executes</span><span>Updates</span><span>Resolves</span></div>
      </div>
      <div class="role-card">
        <div class="role-ico"><span class="material-symbols-outlined">real_estate_agent</span></div>
        <div class="role-name">Management</div>
        <div class="role-verbs"><span>Reviews</span><span>Decides</span><span>Steps in</span></div>
      </div>
    </div>
  </div>
</section>

<!-- STEP 01 PURCHASE ORDER -->
<section class="section bg-white" id="po">
  <div class="sec-inner">
    <div class="sec-head reveal">
      <div class="eyebrow"><span class="material-symbols-outlined">factory</span>Built Around Your Operation</div>
      <h2 class="sec-h2">For textile production, work starts with <span>the order.</span></h2>
      <p class="sec-sub">GoalChaser connects the people responsible for turning a purchase order into completed production — keeping every level updated along the way.</p>
    </div>
    <div class="po-wrap reveal">
      <div class="po-doc">
        <div class="po-hd"><b>Purchase Order</b><span class="ph">PO-1023</span></div>
        <div class="po-row"><span>Quantity</span><b>12,000 units</b></div>
        <div class="po-row"><span>Shipment</span><b>Sea freight</b></div>
        <div class="po-row"><span>Deadline</span><b>Dec 18</b></div>
        <div class="po-row"><span>Requirements</span><b>Combed cotton</b></div>
      </div>
      <div class="gc-core">
        <div class="gci"><span class="material-symbols-outlined">route</span></div>
        <b>GoalChaser AI</b>
        <p>reads the order</p>
        <div class="tree-arrow" style="padding-top:.6rem;"><span class="material-symbols-outlined">expand_more</span></div>
      </div>
      <div class="po-extract">
        <div class="po-chip"><span class="material-symbols-outlined">category</span>Quantity<b>Read</b></div>
        <div class="po-chip"><span class="material-symbols-outlined">local_shipping</span>Shipment<b>Read</b></div>
        <div class="po-chip"><span class="material-symbols-outlined">event</span>Deadline<b>Read</b></div>
        <div class="po-chip"><span class="material-symbols-outlined">checklist</span>Requirements<b>Read</b></div>
      </div>
    </div>
  </div>
</section>

<!-- STEP 05 DAILY COORDINATION -->
<section class="section bg-white" id="daily">
  <div class="sec-inner">
    <div class="sec-head reveal">
      <div class="eyebrow">Daily Operations · One continuous loop</div>
      <h2 class="sec-h2">One continuous <span>coordination loop.</span></h2>
      <p class="sec-sub">Not a single automated call — an operational loop that runs every shift.</p>
    </div>
    <div class="cycle reveal">
      <div class="cycle-group">
        <div class="cyc">
          <div class="cyc-ico"><span class="material-symbols-outlined">wb_sunny</span></div>
          <div class="cyc-label">Start Shift</div>
          <div class="cyc-time">Align</div>
          <div class="cyc-act">Targets + priorities</div>
        </div>
        <div class="cyc">
          <div class="cyc-ico c2"><span class="material-symbols-outlined">wb_cloudy</span></div>
          <div class="cyc-label">Mid Shift</div>
          <div class="cyc-time">Check</div>
          <div class="cyc-act">Progress + blockers</div>
        </div>
        <div class="cyc">
          <div class="cyc-ico c3"><span class="material-symbols-outlined">nightlight</span></div>
          <div class="cyc-label">End Shift</div>
          <div class="cyc-time">Report</div>
          <div class="cyc-act">Results + next steps</div>
        </div>
      </div>
      <div class="cycle-loop"><span class="material-symbols-outlined">sync</span>Repeat every shift</div>
    </div>
  </div>
</section>

<!-- STEP 06 BLOCKER RECOVERY -->
<section class="section bg-soft" id="recovery">
  <div class="sec-inner">
    <div class="sec-head reveal">
      <div class="eyebrow"><span class="material-symbols-outlined">build</span>Exception · Machine Issue</div>
      <h2 class="sec-h2">When something goes wrong, GoalChaser <span>keeps the operation moving.</span></h2>
      <p class="sec-sub">A blocker doesn't have to become a management fire drill. GoalChaser captures the issue, coordinates the response and keeps everyone working from the latest plan.</p>
    </div>
    <div class="mini reveal">
      <div class="mini-item warn"><div class="mini-ico"><span class="material-symbols-outlined">warning</span></div><div><div class="mini-label">Machine breakdown</div><div class="mini-desc">Unit 4 — stitching line</div></div></div>
      <div class="mini-arrow"><span class="material-symbols-outlined">expand_more</span></div>
      <div class="mini-item emp"><div class="mini-ico"><span class="material-symbols-outlined">person</span></div><div><div class="mini-label">Unit manager reports</div><div class="mini-desc">During the follow-up call</div></div></div>
      <div class="mini-arrow"><span class="material-symbols-outlined">expand_more</span></div>
      <div class="mini-item ai"><div class="mini-ico"><span class="material-symbols-outlined">psychology</span></div><div><div class="mini-label">AI understands impact</div><div class="mini-desc">What slips, by how much</div></div></div>
      <div class="mini-arrow"><span class="material-symbols-outlined">expand_more</span></div>
      <div class="mini-item ai"><div class="mini-ico"><span class="material-symbols-outlined">healing</span></div><div><div class="mini-label">Recovery plan</div><div class="mini-desc">Redistribute the missing target</div></div></div>
      <div class="mini-arrow"><span class="material-symbols-outlined">expand_more</span></div>
      <div class="mini-item"><div class="mini-ico"><span class="material-symbols-outlined">groups</span></div><div><div class="mini-label">Affected teams contacted</div><div class="mini-desc">New targets set</div></div></div>
      <div class="mini-arrow"><span class="material-symbols-outlined">expand_more</span></div>
      <div class="mini-item human"><div class="mini-ico"><span class="material-symbols-outlined">how_to_reg</span></div><div><div class="mini-label">Manager approval</div><div class="mini-desc">One tap</div></div></div>
      <div class="mini-arrow"><span class="material-symbols-outlined">expand_more</span></div>
      <div class="mini-item done"><div class="mini-ico"><span class="material-symbols-outlined">check_circle</span></div><div><div class="mini-label">Production continues</div><div class="mini-desc">Back on track</div></div></div>
    </div>
  </div>
</section>

<!-- STEP 07 ESCALATION -->
<section class="section bg-white" id="escalate">
  <div class="sec-inner">
    <div class="sec-head reveal">
      <div class="eyebrow">Decisions · Only when needed</div>
      <h2 class="sec-h2">Problems move upward only <span>when they need to.</span></h2>
    </div>
    <div class="branch reveal">
      <div class="brk-top">
        <div class="brk-node warn"><span class="material-symbols-outlined">warning</span>Blocker</div>
        <div class="tree-arrow"><span class="material-symbols-outlined">expand_more</span></div>
        <div class="brk-node ai"><span class="material-symbols-outlined">psychology</span>AI Analysis</div>
      </div>
      <div class="brk-split">
        <div class="brk-a good">
          <div class="tree-line" style="height:2px;background:var(--s3);max-width:120px;margin:0 auto;"></div>
          <h5><span class="material-symbols-outlined" style="font-size:14px;vertical-align:-2px;">task_alt</span> Resolvable</h5>
          <div class="brk-node"><span class="material-symbols-outlined">healing</span>AI coordinates</div>
          <div class="tree-arrow"><span class="material-symbols-outlined">expand_more</span></div>
          <div class="brk-node" style="background:rgba(14,182,71,.08);border-color:rgba(14,182,71,.4);color:var(--green2);"><span class="material-symbols-outlined">check_circle</span>Resolved</div>
        </div>
        <div class="brk-a human">
          <div class="tree-line" style="height:2px;background:var(--s3);max-width:120px;margin:0 auto;"></div>
          <h5><span class="material-symbols-outlined" style="font-size:14px;vertical-align:-2px;">rule</span> Needs decision</h5>
          <div class="brk-node" style="background:#EEF2F7;border-color:var(--s4);"><span class="material-symbols-outlined">real_estate_agent</span>Management</div>
          <div class="tree-arrow"><span class="material-symbols-outlined">expand_more</span></div>
          <div class="brk-node human" style="background:var(--navy);color:#fff;border-color:var(--navy);"><span class="material-symbols-outlined">gavel</span>Decision</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- STEP 08 MANAGEMENT REPORTING -->
<section class="section bg-soft" id="report">
  <div class="sec-inner">
    <div class="sec-head reveal">
      <div class="eyebrow"><span class="material-symbols-outlined">monitoring</span>Management · Visibility</div>
      <h2 class="sec-h2">Instead of asking <span>"What's happening?"</span></h2>
      <p class="sec-sub">Management sees what happened, why, what's at risk, and what should happen next — without chasing people for updates.</p>
    </div>
    <div class="dash reveal">
      <div class="dash-grid">
        <div class="dash-cell"><div class="dash-val green">92<div class="u">%</div></div><div class="dash-lab">Production progress</div><div class="dash-tag">On schedule</div></div>
        <div class="dash-cell"><div class="dash-val amber">3</div><div class="dash-lab">Active blockers</div><div class="dash-tag">Being handled</div></div>
        <div class="dash-cell"><div class="dash-val cyan">2</div><div class="dash-lab">Delayed tasks</div><div class="dash-tag">Recovery set</div></div>
        <div class="dash-cell"><div class="dash-val">4</div><div class="dash-lab">Recovery actions</div><div class="dash-tag">In motion</div></div>
        <div class="dash-cell"><div class="dash-val amber">1</div><div class="dash-lab">Decisions required</div><div class="dash-tag">For managers</div></div>
      </div>
      <div class="dash-ai">
        <span class="material-symbols-outlined">auto_awesome</span>
        <div><b>AI recommendation</b><p>Unit 4 delay detected. Redistribute 8% of its target to Unit 5.</p></div>
      </div>
    </div>
  </div>
</section>

<!-- OUTCOME -->
<section class="section outcome-bg">
  <div class="outcome-inner reveal">
    <div class="eyebrow" style="background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.14);color:var(--green);">The Result</div>
    <h2 class="outcome-h">Less chasing. <span>More control.</span></h2>
    <p class="cta-sub" style="max-width:600px;">GoalChaser turns everyday follow-ups into a continuous flow of progress, insight and accountability.</p>
    <div class="chain-x">
      <span class="cx-item"><span class="material-symbols-outlined">call_end</span>Less Follow-up</span>
      <span class="cx-arrow">→</span>
      <span class="cx-item"><span class="material-symbols-outlined">precision_manufacturing</span>More Execution</span>
      <span class="cx-arrow">→</span>
      <span class="cx-item hl"><span class="material-symbols-outlined">visibility</span>Better Visibility</span>
      <span class="cx-arrow">→</span>
      <span class="cx-item warnhl"><span class="material-symbols-outlined">speed</span>Faster Decisions</span>
      <span class="cx-arrow">→</span>
      <span class="cx-item"><span class="material-symbols-outlined">trending_up</span>More Time for Growth</span>
    </div>
  </div>
</section>

<!-- AUDIT TRAIL -->
<section class="section bg-white" id="audit">
  <div class="sec-inner">
    <div class="sec-head reveal">
      <div class="eyebrow">Traceability · Audit Trail</div>
      <h2 class="sec-h2">Every action is <span>traceable.</span></h2>
      <p class="sec-sub">From order to outcome, the full record is kept — calls, decisions, and changes.</p>
    </div>
    <div class="audit reveal">
      <div class="audit-chip"><span class="material-symbols-outlined">phone_in_talk</span>Calls logged <b>Full transcript</b></div>
      <div class="audit-chip"><span class="material-symbols-outlined">history</span>History <b>Every change</b></div>
      <div class="audit-chip"><span class="material-symbols-outlined">verified</span>Approvals <b>Who &amp; when</b></div>
      <div class="audit-chip"><span class="material-symbols-outlined">summarize</span>Reports <b>Auto-archived</b></div>
    </div>
  </div>
</section>

<!-- MOBILE OPERATIONS -->
<section class="section bg-soft" id="mobile">
  <div class="sec-inner">
    <div class="zoom">
      <div class="zoom-copy reveal">
        <div class="zoom-step">On the floor · <b>Mobile</b></div>
        <h3>Coordination happens where the work happens.</h3>
        <p>AI calls run inside the app — no numbers, no logins. Workers answer, managers approve, from anywhere.</p>
      </div>
      <div class="reveal">
        <div class="ui" style="margin-left:auto;max-width:380px;background:#fff;border:1px solid var(--s3);border-radius:18px;padding:1.5rem;">
          <div class="ui-hd"><span class="material-symbols-outlined" style="color:var(--green);">call</span><b>Shift check-in</b><span style="margin-left:auto;font-size:.62rem;font-weight:800;color:var(--cyan);background:rgba(0,175,240,.12);border:1px solid rgba(0,175,240,.3);padding:.15rem .6rem;border-radius:999px;">Incoming</span></div>
          <div class="ui-line" style="background:var(--s1);"><div class="ui-ic" style="background:rgba(14,182,71,.12);color:var(--green);"><span class="material-symbols-outlined">person</span></div><div><div class="t">Unit 4 — Worker</div><div class="s">"Line running, target at 60%"</div></div><span class="st acc" style="color:var(--cyan);">Live</span></div>
          <div class="ui-line" style="background:var(--s1);"><div class="ui-ic" style="background:rgba(0,175,240,.12);color:var(--cyan);"><span class="material-symbols-outlined">approval</span></div><div><div class="t">Recovery approval</div><div class="s">Manager — one tap</div></div><span class="st done" style="color:var(--green);">Approved</span></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SIGNATURE WORKFLOW -->
<section class="section bg-white" id="sig">
  <div class="sec-inner">
    <div class="sec-head reveal">
      <div class="eyebrow">The System at a Glance</div>
      <h2 class="sec-h2">One view, <span>the whole operation.</span></h2>
      <p class="sec-sub">See only this diagram and understand what GoalChaser does.</p>
    </div>
    <div class="sig reveal">
      <div class="sig-step"><span class="material-symbols-outlined">receipt_long</span>Purchase Order</div>
      <div class="sig-line"></div>
      <div class="sig-step ai"><span class="material-symbols-outlined">route</span>AI Creates Plan</div>
      <div class="sig-line"></div>
      <div class="sig-step"><span class="material-symbols-outlined">group</span>Approvals</div>
      <div class="sig-line"></div>
      <div class="sig-step"><span class="material-symbols-outlined">precision_manufacturing</span>Production</div>
      <div class="sig-line"></div>
      <div class="sig-step ai"><span class="material-symbols-outlined">call</span>AI Daily Follow-up</div>
      <div class="sig-line"></div>
      <div class="sig-split">
        <div class="sig-fork">
          <div class="sig-line"></div>
          <div class="sig-step green"><span class="material-symbols-outlined">trending_up</span>On Track</div>
          <div class="sig-line"></div>
          <div class="sig-step"><span class="material-symbols-outlined">play_arrow</span>Continue</div>
        </div>
        <div class="sig-fork">
          <div class="sig-line"></div>
          <div class="sig-step amber"><span class="material-symbols-outlined">warning</span>Blocked</div>
          <div class="sig-line"></div>
          <div class="sig-step"><span class="material-symbols-outlined">healing</span>Recovery Plan</div>
        </div>
      </div>
      <div class="sig-join"></div>
      <div class="sig-step"><span class="material-symbols-outlined">summarize</span>Management Report</div>
      <div class="sig-line"></div>
      <div class="sig-step ai"><span class="material-symbols-outlined">ads_click</span>Next Decision</div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="section cta-bg">
  <div class="sec-inner cta-inner reveal">
    <h2 class="cta-h2">Bring your operation into <span>one workflow.</span></h2>
    <p class="cta-sub">Deploy GoalChaser across your plants and teams with a plan that scales to every line, site, and shift.</p>
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
      <div class="footer-col"><h5>Product</h5><ul><li><a href="#wf">How It Works</a></li><li><a href="#po">Workflow</a></li><li><a href="/mobile-app">Mobile App</a></li></ul></div>
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
      <p>Share your business email and our team will reach out to scale GoalChaser across your operation.</p>
      <input type="email" id="waitlist-email" placeholder="Enter your business email" />
      <button class="modal-submit" onclick="submitWaitlist()">Send Message <span class="material-symbols-outlined" style="font-size:18px;">send</span></button>
    </div>
    <div class="success-state" id="modal-success">
      <div class="success-icon"><span class="material-symbols-outlined">check_circle</span></div>
      <h3 style="font-family:'Nunito',sans-serif;">Message Sent!</h3>
      <p style="font-size:.9rem;color:#64748B;">Our team will reach out to you within 24 hours.</p>
      <button onclick="closeModal()" style="margin-top:1.5rem;background:none;border:none;cursor:pointer;font-weight:800;color:var(--green);font-family:inherit;">Close</button>
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
