<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GoalChaser — AI-Powered Productivity for Individuals &amp; Teams</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --accent: #00aff0;
      --accent-light: #E6F7FF;
      --accent-border: #99E6FF;
      --secondary: #0eb647;
      --secondary-light: #E6F7EA;
      --secondary-border: #A8E6B8;
      --ink: #2D3748;
      --slate: #475569;
      --muted: #64748B;
      --dim: #94A3B8;
      --border: #E2E8F0;
      --surface: #F1F5F9;
      --white: #FFFFFF;
      --radius-sm: 8px;
      --radius-md: 12px;
      --radius-lg: 18px;
      --radius-xl: 24px;
    }

    html { font-size: 16px; }
    body {
      font-family: 'Nunito', sans-serif;
      color: var(--ink);
      background: var(--white);
      -webkit-font-smoothing: antialiased;
    }

    svg.icon { width: 1em; height: 1em; display: inline-block; vertical-align: -0.125em; }

    /* ── NAV ── */
    nav {
      position: fixed;
      top: 0; left: 0; right: 0;
      z-index: 100;
      padding: 0 2rem;
      background: rgba(255,255,255,0);
      transition: background 0.3s, border-color 0.3s, box-shadow 0.3s;
      border-bottom: 1px solid transparent;
    }
    nav .nav-logo { color: var(--white); }
    nav .nav-logo span { color: #00aff0; }
    nav .nav-links a {
      color: rgba(255,255,255,0.75);
      font-size: 0.875rem;
      font-weight: 700;
      text-decoration: none;
      transition: color 0.2s;
    }
    nav .nav-links a:hover { color: var(--white); }
    nav .btn-ghost {
      color: rgba(255,255,255,0.75);
      font-size: 0.875rem;
      font-weight: 700;
      transition: color 0.2s;
    }
    nav .btn-ghost:hover { color: var(--white); }
    nav .btn-primary {
      background: var(--white);
      color: var(--ink);
    }
    nav .btn-primary:hover { background: #f1f5f9; }
    nav .nav-hamburger svg { stroke: var(--white); }
    nav.scrolled {
      background: rgba(255,255,255,0.97);
      border-bottom-color: var(--border);
      box-shadow: 0 1px 16px rgba(45,55,72,0.05);
      backdrop-filter: blur(12px);
    }
    nav.scrolled .nav-logo { color: var(--ink); }
    nav.scrolled .nav-logo span { color: var(--accent); }
    nav.scrolled .nav-links a {
      color: var(--slate);
      font-size: 0.875rem;
      font-weight: 700;
      text-decoration: none;
      transition: color 0.2s;
    }
    nav.scrolled .nav-links a:hover { color: var(--accent); }
    nav.scrolled .btn-ghost {
      color: var(--slate);
      font-size: 0.875rem;
      font-weight: 700;
      transition: color 0.2s;
    }
    nav.scrolled .btn-ghost:hover { color: var(--accent); }
    nav.scrolled .btn-primary {
      background: var(--ink);
      color: var(--white);
    }
    nav.scrolled .btn-primary:hover { background: var(--accent); }
    nav.scrolled .nav-hamburger svg { stroke: var(--ink); }
    .nav-inner {
      max-width: 1200px;
      margin: 0 auto;
      height: 56px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .nav-logo {
      font-size: 1.375rem;
      font-weight: 900;
      text-decoration: none;
      letter-spacing: -0.5px;
    }
    .nav-links {
      display: flex;
      align-items: center;
      gap: 2rem;
      list-style: none;
    }
    .nav-actions {
      display: flex;
      align-items: center;
      gap: 1rem;
    }
    .btn-ghost {
      font-family: 'Nunito', sans-serif;
      font-size: 0.875rem;
      font-weight: 700;
      background: none;
      border: none;
      cursor: pointer;
      text-decoration: none;
      transition: color 0.2s;
    }
    .btn-primary {
      font-family: 'Nunito', sans-serif;
      font-size: 0.875rem;
      font-weight: 800;
      color: var(--white);
      background: var(--ink);
      border: none;
      padding: 0.625rem 1.375rem;
      border-radius: var(--radius-sm);
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      transition: background 0.2s, transform 0.15s;
    }
    .btn-primary:hover { background: var(--accent); transform: translateY(-1px); }
    .btn-outline {
      font-family: 'Nunito', sans-serif;
      font-size: 0.875rem;
      font-weight: 800;
      color: var(--ink);
      background: none;
      border: 1.5px solid var(--border);
      padding: 0.625rem 1.375rem;
      border-radius: var(--radius-sm);
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      transition: border-color 0.2s, transform 0.15s;
    }
    .btn-outline:hover { border-color: var(--ink); transform: translateY(-1px); }
    .nav-hamburger {
      display: none;
      background: none;
      border: none;
      cursor: pointer;
      padding: 0.25rem;
    }
    .nav-hamburger svg { width: 24px; height: 24px; stroke: var(--ink); }
    .mobile-menu {
      display: none;
      flex-direction: column;
      gap: 1rem;
      padding: 1.5rem 2rem;
      background: var(--white);
      border-top: 1px solid var(--border);
    }
    .mobile-menu a {
      font-weight: 700;
      font-size: 0.9375rem;
      color: var(--slate);
      text-decoration: none;
    }
    .mobile-menu a:hover { color: var(--accent); }
    .mobile-menu .mobile-actions {
      display: flex;
      flex-direction: column;
      gap: 0.75rem;
      padding-top: 0.75rem;
      border-top: 1px solid var(--border);
    }
    .mobile-menu .btn-primary, .mobile-menu .btn-outline { justify-content: center; }
    @media (max-width: 900px) {
      .nav-links, .nav-actions { display: none; }
      .nav-hamburger { display: block; }
    }
    @media (max-width: 900px) {
      .mobile-menu.open { display: flex; }
    }

    /* ── LAYOUT ── */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 2rem;
    }
    section { padding: 6rem 0; }

    /* ── EYEBROW ── */
    .eyebrow {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 0.6875rem;
      font-weight: 800;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--muted);
      background: var(--surface);
      border: 1px solid var(--border);
      padding: 0.375rem 0.875rem;
      border-radius: 100px;
      margin-bottom: 1.5rem;
    }

    /* ── HERO ── */
    #hero {
      padding-top: 10rem;
      padding-bottom: 7rem;
      background: url('/assets/background.png'), linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
      background-size: cover, auto;
      background-position: center, center;
      position: relative;
      overflow: hidden;
    }
    #hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(15,23,42,0.88) 0%, rgba(15,23,42,0.6) 100%);
      z-index: 0;
    }
    .hero-grid {
      position: relative;
      z-index: 1;
      max-width: 720px;
    }
    .hero-eyebrow {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 0.6875rem;
      font-weight: 800;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: #00aff0;
      background: rgba(0,175,240,0.1);
      border: 1px solid rgba(0,175,240,0.3);
      padding: 0.375rem 0.875rem;
      border-radius: 100px;
      margin-bottom: 1.5rem;
    }
    .hero-tagline {
      margin-top: 1.5rem;
      font-size: 0.9375rem;
      font-weight: 800;
      color: rgba(255,255,255,0.55);
    }
    .hero-h1 {
      font-size: clamp(2.5rem, 5vw, 3.75rem);
      font-weight: 900;
      line-height: 1.07;
      letter-spacing: -1.5px;
      color: var(--white);
      margin-bottom: 1.5rem;
    }
    .hero-h1 .accent { color: #00aff0; }
    .hero-lead {
      font-size: 1.0625rem;
      font-weight: 500;
      color: rgba(255,255,255,0.7);
      line-height: 1.7;
      max-width: 480px;
      margin-bottom: 2.25rem;
    }
    .hero-cta {
      display: flex;
      align-items: center;
      gap: 1rem;
      flex-wrap: wrap;
    }
    .btn-lg {
      font-size: 1rem;
      padding: 0.875rem 1.75rem;
    }
    .hero-stats {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1.5rem;
      margin-top: 3.5rem;
      padding-top: 2.5rem;
      border-top: 1px solid rgba(255,255,255,0.1);
    }
    .hero-stat-label {
      font-size: 0.6875rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: rgba(255,255,255,0.4);
      margin-top: 0.25rem;
    }
    .hero-stat-value {
      font-size: 1.25rem;
      font-weight: 900;
      color: var(--white);
      letter-spacing: -0.5px;
    }
    .hero-stat-sub {
      font-size: 0.75rem;
      font-weight: 600;
      color: rgba(255,255,255,0.55);
      margin-top: 0.25rem;
    }
    .hero-stat-value.accent { color: #00aff0; }
    .hero-stat-value.blue { color: var(--secondary); }
    #hero .btn-outline {
      color: var(--white);
      border-color: rgba(255,255,255,0.25);
    }
    #hero .btn-outline:hover { border-color: var(--white); }

    /* ── SECTION HEADERS ── */
    .section-header {
      text-align: center;
      margin-bottom: 4rem;
    }
    .section-title {
      font-size: clamp(2rem, 4vw, 2.875rem);
      font-weight: 900;
      letter-spacing: -1px;
      line-height: 1.1;
      color: var(--ink);
      margin-bottom: 1rem;
    }
    .section-title .accent { color: var(--accent); }
    .section-title .blue { color: var(--secondary); }
    .section-sub {
      font-size: 1.0625rem;
      font-weight: 500;
      color: var(--muted);
      max-width: 560px;
      margin: 0 auto;
      line-height: 1.65;
    }

    /* ── OVERVIEW CARDS ── */
    #overview { background: var(--surface); }
    .overview-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.5rem;
    }
    .overview-card {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: var(--radius-lg);
      padding: 2rem;
      transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
    }
    .overview-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 32px rgba(45,55,72,0.07);
      border-color: #CBD5E1;
    }
    .overview-icon {
      width: 48px;
      height: 48px;
      border-radius: var(--radius-sm);
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1.25rem;
      font-size: 1.375rem;
    }
    .overview-icon.accent { background: var(--accent-light); }
    .overview-icon.mixed { background: var(--secondary-light); }
    .overview-card h3 {
      font-size: 1.0625rem;
      font-weight: 800;
      color: var(--ink);
      margin-bottom: 0.5rem;
    }
    .overview-card p {
      font-size: 0.9375rem;
      font-weight: 500;
      color: var(--muted);
      line-height: 1.6;
    }

    /* ── PRODUCTS ── */
    #products { background: var(--white); }
    .product-block {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 5rem;
      align-items: center;
      margin-bottom: 6rem;
    }
    .product-block:last-child { margin-bottom: 0; }
    .product-tag {
      display: inline-block;
      font-size: 0.6875rem;
      font-weight: 900;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--white);
      background: var(--ink);
      padding: 0.3rem 0.75rem;
      border-radius: 4px;
      margin-bottom: 1.25rem;
    }
    .product-tag.blue-tag { background: var(--secondary); }
    .product-name {
      font-size: clamp(2rem, 3.5vw, 2.75rem);
      font-weight: 900;
      letter-spacing: -1px;
      color: var(--ink);
      line-height: 1.05;
    }
    .product-name .accent { color: var(--accent); }
    .product-name .blue { color: var(--secondary); }
    .product-tagline {
      font-size: 1rem;
      font-weight: 600;
      color: var(--muted);
      margin-top: 0.5rem;
      margin-bottom: 1.25rem;
    }
    .product-desc {
      font-size: 1rem;
      font-weight: 500;
      color: var(--muted);
      line-height: 1.7;
      margin-bottom: 1.75rem;
    }
    .feature-list {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 0.625rem;
      margin-bottom: 2rem;
    }
    .feature-list li {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      font-size: 0.9375rem;
      font-weight: 700;
      color: var(--slate);
    }
    .feature-list li::before {
      content: '';
      width: 18px;
      height: 18px;
      border-radius: 50%;
      background: var(--accent-light);
      border: 1.5px solid var(--accent-border);
      flex-shrink: 0;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 18 18' fill='none'%3E%3Cpath d='M4.5 9l3 3 6-6' stroke='%2300aff0' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
      background-size: cover;
    }
    .feature-list.blue-checks li::before {
      background-color: var(--secondary-light);
      border-color: var(--secondary-border);
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 18 18' fill='none'%3E%3Cpath d='M4.5 9l3 3 6-6' stroke='%230eb647' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
    }
    .btn-accent {
      background: var(--accent);
      color: var(--white);
    }
    .btn-accent:hover { background: #0088c0; }

    /* ── FLOW CARD ── */
    .flow-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius-xl);
      padding: 2rem;
      position: relative;
      overflow: hidden;
    }
    .flow-card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 3px;
    }
    .flow-card.accent-top::before { background: var(--accent); }
    .flow-card.blue-top::before { background: var(--secondary); }
    .flow-step {
      display: flex;
      align-items: flex-start;
      gap: 1rem;
      padding: 0.875rem 0;
    }
    .flow-step + .flow-step {
      border-top: 1px solid var(--border);
    }
    .flow-step-num {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.75rem;
      font-weight: 900;
      color: var(--white);
      flex-shrink: 0;
    }
    .num-accent { background: var(--accent); }
    .num-blue { background: var(--secondary); }
    .num-ink { background: var(--ink); }
    .flow-step-text { flex: 1; }
    .flow-step-title {
      font-size: 0.875rem;
      font-weight: 800;
      color: var(--ink);
    }
    .flow-step-sub {
      font-size: 0.75rem;
      font-weight: 600;
      color: var(--dim);
      margin-top: 0.125rem;
    }
    .flow-step-icon {
      font-size: 1.125rem;
      flex-shrink: 0;
    }

    /* ── SERVICES ── */
    #services { background: var(--surface); }
    .services-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1rem;
    }
    .service-card {
      position: relative;
      overflow: hidden;
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: var(--radius-md);
      padding: 1.25rem;
      cursor: pointer;
      transition: transform 0.2s, border-color 0.2s, box-shadow 0.2s;
    }
    .service-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 24px rgba(45,55,72,0.06);
      border-color: var(--border);
    }
    .service-card-icon {
      width: 38px;
      height: 38px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      margin-bottom: 0.875rem;
    }
    .service-card-icon.accent { background: var(--accent-light); }
    .service-card-icon.b { background: var(--secondary-light); }
    .service-card h4 {
      font-size: 0.8125rem;
      font-weight: 800;
      color: var(--ink);
      margin-bottom: 0.25rem;
    }
    .service-card p {
      font-size: 0.75rem;
      font-weight: 600;
      color: var(--dim);
      line-height: 1.5;
    }
    .badge-ribbon {
      position: absolute;
      top: 0;
      right: 0;
      font-size: 0.5rem;
      font-weight: 900;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      color: var(--white);
      padding: 0.25rem 0.75rem 0.25rem 0.6rem;
      border-radius: 0 0 0 var(--radius-sm);
      z-index: 1;
    }
    .ribbon-1 { background: #0eb647; }
    .ribbon-2 { background: #00aff0; }
    .ribbon-3 { background: #7C3AED; }
    .ribbon-4 { background: #F59E0B; }
    .ribbon-5 { background: #EC4899; }
    .ribbon-6 { background: #14B8A6; }
    .ribbon-7 { background: #EF4444; }
    .ribbon-8 { background: #6366F1; }
    .ribbon-9 { background: #D97706; }
    .ribbon-10 { background: #06B6D4; }
    .ribbon-11 { background: #65A30D; }
    .ribbon-12 { background: #F43F5E; }
    .ribbon-13 { background: #8B5CF6; }
    .ribbon-14 { background: #059669; }
    .ribbon-15 { background: #0284C7; }

    /* ── ARCH DIAGRAM ── */
    .arch-box {
      margin-top: 3rem;
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: var(--radius-xl);
      padding: 3rem;
    }
    .arch-box-title {
      text-align: center;
      font-size: 0.6875rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.12em;
      color: var(--dim);
      margin-bottom: 2rem;
    }
    .arch-flow {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 1rem;
    }
    .arch-pill {
      padding: 0.75rem 2.5rem;
      border-radius: var(--radius-sm);
      font-weight: 900;
      font-size: 1rem;
      letter-spacing: -0.25px;
    }
    .arch-pill.dark { background: var(--ink); color: var(--white); }
    .arch-pill.bordered {
      border: 1.5px solid var(--border);
      color: var(--ink);
      background: var(--surface);
    }
    .arch-arrow { color: var(--dim); font-size: 1.125rem; }
    .arch-layer {
      width: 100%;
      max-width: 600px;
      border: 1.5px dashed #CBD5E1;
      border-radius: var(--radius-md);
      padding: 1.5rem;
      text-align: center;
      background: #FAFBFF;
    }
    .arch-layer-label {
      font-size: 0.75rem;
      font-weight: 800;
      color: var(--muted);
      text-transform: uppercase;
      letter-spacing: 0.08em;
      margin-bottom: 1rem;
    }
    .arch-tags {
      display: flex;
      flex-wrap: wrap;
      gap: 0.5rem;
      justify-content: center;
    }
    .arch-tag {
      padding: 0.375rem 0.875rem;
      border-radius: 6px;
      font-size: 0.75rem;
      font-weight: 800;
      color: var(--white);
    }
    .arch-tag.accent { background: var(--accent); }
    .arch-tag.b { background: var(--secondary); }
    .arch-tag.i { background: var(--ink); }

    /* ── SOLUTIONS ── */
    #solutions { background: var(--white); }
    .solutions-grid {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 1rem;
    }
    .solution-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius-md);
      padding: 1.5rem 1rem;
      text-align: center;
      cursor: pointer;
      transition: transform 0.2s, border-color 0.2s, box-shadow 0.2s;
    }
    .solution-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 24px rgba(45,55,72,0.06);
      border-color: var(--border);
    }
    .solution-card .icon { font-size: 1.75rem; margin-bottom: 0.75rem; }
    .solution-card h4 { font-size: 0.8125rem; font-weight: 800; color: var(--ink); margin-bottom: 0.25rem; }
    .solution-card p { font-size: 0.6875rem; font-weight: 600; color: var(--dim); line-height: 1.5; }

    /* ── WHY US ── */
    #why { background: var(--surface); }
    .why-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1rem;
    }
    .why-card {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: var(--radius-md);
      padding: 1.5rem;
      text-align: center;
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .why-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 24px rgba(45,55,72,0.06);
    }
    .why-icon {
      width: 44px;
      height: 44px;
      border-radius: var(--radius-sm);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1rem;
      font-size: 1.25rem;
    }
    .why-icon.accent { background: var(--accent-light); }
    .why-icon.b { background: var(--secondary-light); }
    .why-card h4 { font-size: 0.875rem; font-weight: 800; color: var(--ink); margin-bottom: 0.375rem; }
    .why-card p { font-size: 0.8125rem; font-weight: 600; color: var(--muted); line-height: 1.5; }

    /* ── HOW IT WORKS ── */
    #process { background: var(--white); }
    .process-timeline {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1.5rem;
      position: relative;
    }
    .process-timeline::before {
      content: '';
      position: absolute;
      top: 36px;
      left: calc(12.5% + 18px);
      right: calc(12.5% + 18px);
      height: 1.5px;
      background: var(--border);
    }
    .process-step { text-align: center; position: relative; }
    .process-step-num {
      width: 56px;
      height: 56px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.25rem;
      font-size: 1.25rem;
      position: relative;
      z-index: 1;
      border: 2px solid var(--border);
      background: var(--white);
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .process-step:hover .process-step-num {
      border-color: var(--accent);
      box-shadow: 0 0 0 4px var(--accent-light);
    }
    .process-step:nth-child(even):hover .process-step-num {
      border-color: var(--secondary);
      box-shadow: 0 0 0 4px var(--secondary-light);
    }
    .process-step-label {
      font-size: 0.6875rem;
      font-weight: 900;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--accent);
      margin-bottom: 0.5rem;
    }
    .process-step:nth-child(even) .process-step-label { color: var(--secondary); }
    .process-step h4 {
      font-size: 1.0625rem;
      font-weight: 900;
      color: var(--ink);
      margin-bottom: 0.5rem;
    }
    .process-step p {
      font-size: 0.875rem;
      font-weight: 600;
      color: var(--muted);
      line-height: 1.6;
      max-width: 200px;
      margin: 0 auto;
    }

    /* ── VISION ── */
    #vision {
      background: var(--ink);
      position: relative;
      overflow: hidden;
    }
    #vision::before {
      content: '';
      position: absolute;
      top: -200px; right: -200px;
      width: 500px; height: 500px;
      border-radius: 50%;
      background: rgba(0,175,240,0.06);
    }
    #vision::after {
      content: '';
      position: absolute;
      bottom: -150px; left: -150px;
      width: 400px; height: 400px;
      border-radius: 50%;
      background: rgba(0,175,240,0.04);
    }
    .vision-inner {
      text-align: center;
      max-width: 720px;
      margin: 0 auto;
      position: relative;
      z-index: 1;
    }
    .vision-eyebrow {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 0.6875rem;
      font-weight: 800;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: rgba(255,255,255,0.4);
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(255,255,255,0.1);
      padding: 0.375rem 0.875rem;
      border-radius: 100px;
      margin-bottom: 1.75rem;
    }
    .vision-title {
      font-size: clamp(2.25rem, 4.5vw, 3.5rem);
      font-weight: 900;
      letter-spacing: -1.5px;
      line-height: 1.1;
      color: var(--white);
      margin-bottom: 1.75rem;
    }
    .vision-title .accent { color: var(--accent); }
    .vision-lead {
      font-size: 1.0625rem;
      font-weight: 500;
      color: rgba(255,255,255,0.55);
      line-height: 1.7;
      margin-bottom: 0.75rem;
    }
    .vision-highlight {
      font-size: 1.0625rem;
      font-weight: 700;
      color: rgba(255,255,255,0.85);
      line-height: 1.7;
      margin-bottom: 2.5rem;
    }
    .btn-white {
      background: var(--white);
      color: var(--ink);
      font-family: 'Nunito', sans-serif;
      font-size: 1rem;
      font-weight: 800;
      padding: 0.875rem 1.875rem;
      border-radius: var(--radius-sm);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      transition: background 0.2s, transform 0.15s;
    }
    .btn-white:hover { background: #F1F5F9; transform: translateY(-1px); }

    /* ── ABOUT ── */
    #about { background: var(--surface); }
    .ecosystem {
      max-width: 560px;
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 1rem;
    }
    .eco-node {
      padding: 1rem 3rem;
      border-radius: var(--radius-sm);
      font-weight: 900;
      font-size: 1.0625rem;
      letter-spacing: -0.25px;
    }
    .eco-node.top { background: var(--ink); color: var(--white); }
    .eco-node.mid { background: var(--accent); color: var(--white); }
    .eco-arrow {
      width: 1px;
      height: 32px;
      background: var(--border);
      position: relative;
    }
    .eco-arrow::after {
      content: '▼';
      position: absolute;
      bottom: -2px;
      left: 50%;
      transform: translateX(-50%);
      font-size: 0.5rem;
      color: var(--dim);
    }
    .eco-leaves {
      display: flex;
      flex-wrap: wrap;
      gap: 0.75rem;
      justify-content: center;
      width: 100%;
    }
    .eco-leaf {
      padding: 0.75rem 1.25rem;
      border-radius: var(--radius-sm);
      font-size: 0.875rem;
      font-weight: 800;
      color: var(--white);
    }
    .eco-leaf.accent { background: var(--accent); }
    .eco-leaf.b { background: var(--secondary); }
    .eco-leaf.i { background: var(--ink); }

    /* ── CTA ── */
    #cta { background: var(--white); }
    .cta-inner {
      text-align: center;
      max-width: 640px;
      margin: 0 auto;
    }
    .cta-title {
      font-size: clamp(2rem, 4vw, 3rem);
      font-weight: 900;
      letter-spacing: -1px;
      color: var(--ink);
      line-height: 1.1;
      margin-bottom: 1.25rem;
    }
    .cta-title .accent { color: var(--accent); }
    .cta-lead {
      font-size: 1.0625rem;
      font-weight: 500;
      color: var(--muted);
      line-height: 1.7;
      margin-bottom: 2.25rem;
    }
    .cta-actions {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 1rem;
      flex-wrap: wrap;
    }
    .cta-support {
      margin-top: 1.5rem;
      font-size: 0.8125rem;
      font-weight: 700;
      color: var(--dim);
    }

    /* ── FOOTER ── */
    footer {
      background: var(--white);
      border-top: 1px solid var(--border);
      padding: 4rem 0 2rem;
    }
    .footer-grid {
      display: grid;
      grid-template-columns: 2fr 1fr 1fr 1fr;
      gap: 3rem;
      margin-bottom: 3rem;
    }
    .footer-brand-name {
      font-size: 1.25rem;
      font-weight: 900;
      color: var(--ink);
      letter-spacing: -0.5px;
      text-decoration: none;
      display: block;
      margin-bottom: 1rem;
    }
    .footer-brand-name span { color: var(--accent); }
    .footer-brand p {
      font-size: 0.875rem;
      font-weight: 500;
      color: var(--muted);
      line-height: 1.65;
      max-width: 280px;
      margin-bottom: 1.5rem;
    }
    .footer-social {
      display: flex;
      gap: 0.75rem;
    }
    .footer-social a {
      width: 36px;
      height: 36px;
      border-radius: var(--radius-sm);
      border: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--muted);
      text-decoration: none;
      font-size: 1rem;
      transition: border-color 0.2s, color 0.2s;
    }
    .footer-social a:hover { border-color: var(--accent); color: var(--accent); }
    .footer-col h4 {
      font-size: 0.8125rem;
      font-weight: 900;
      color: var(--ink);
      margin-bottom: 1rem;
      text-transform: uppercase;
      letter-spacing: 0.06em;
    }
    .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 0.625rem; }
    .footer-col ul li a {
      font-size: 0.875rem;
      font-weight: 600;
      color: var(--muted);
      text-decoration: none;
      transition: color 0.2s;
    }
    .footer-col ul li a:hover { color: var(--accent); }
    .footer-bottom {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-top: 2rem;
      border-top: 1px solid var(--border);
      font-size: 0.8125rem;
      font-weight: 600;
      color: var(--dim);
    }
    .footer-bottom a { color: var(--accent); text-decoration: none; font-weight: 700; }
    .footer-bottom a:hover { text-decoration: underline; }

    /* ── AI VOICE VISUAL ── */
    #voice { background: var(--white); }
    .voice-visual {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius-xl);
      padding: 2rem;
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }
    .voice-call-head {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid var(--border);
    }
    .voice-avatar {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      background: var(--accent);
      color: var(--white);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.25rem;
      flex-shrink: 0;
    }
    .voice-call-head .vc-name { font-size: 0.9375rem; font-weight: 900; color: var(--ink); }
    .voice-call-head .vc-status {
      font-size: 0.6875rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: var(--accent);
    }
    .voice-call-head .vc-time { margin-left: auto; font-size: 0.8125rem; font-weight: 700; color: var(--dim); }
    .chat-msg { display: flex; gap: 0.625rem; max-width: 92%; }
    .chat-msg.ai { align-self: flex-start; }
    .chat-msg.user { align-self: flex-end; flex-direction: row-reverse; }
    .chat-bubble {
      padding: 0.75rem 1rem;
      border-radius: var(--radius-md);
      font-size: 0.8125rem;
      font-weight: 600;
      line-height: 1.5;
    }
    .chat-msg.ai .chat-bubble {
      background: var(--white);
      border: 1px solid var(--border);
      color: var(--ink);
    }
    .chat-msg.user .chat-bubble {
      background: var(--ink);
      color: var(--white);
    }
    .chat-meta { font-size: 0.6875rem; font-weight: 700; color: var(--dim); }
    .chat-label {
      font-size: 0.625rem;
      font-weight: 900;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: var(--accent);
      margin-bottom: 0.25rem;
    }
    .voice-closing {
      text-align: center;
      font-size: 1.125rem;
      font-weight: 900;
      color: var(--ink);
      margin-top: 0.5rem;
    }
    .voice-closing span { color: var(--accent); }

    /* ── MANAGEMENT INTELLIGENCE DASHBOARD ── */
    #intelligence { background: var(--surface); }
    .dash-preview {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: var(--radius-xl);
      overflow: hidden;
      box-shadow: 0 16px 40px rgba(45,55,72,0.08);
    }
    .dash-top {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 1rem 1.5rem;
      border-bottom: 1px solid var(--border);
    }
    .dash-top .dt-title { font-size: 0.8125rem; font-weight: 900; color: var(--ink); }
    .dash-top .dt-sub { font-size: 0.6875rem; font-weight: 700; color: var(--dim); }
    .dash-top .dt-badge {
      font-size: 0.625rem;
      font-weight: 900;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      color: var(--accent);
      background: var(--accent-light);
      padding: 0.25rem 0.625rem;
      border-radius: 100px;
    }
    .dash-grid {
      display: grid;
      grid-template-columns: 1.4fr 1fr;
      gap: 1.25rem;
      padding: 1.5rem;
    }
    .dash-overall { border-right: 1px solid var(--border); padding-right: 1.25rem; }
    .dash-overall .do-ring {
      width: 128px;
      height: 128px;
      border-radius: 50%;
      background: conic-gradient(var(--accent) 0 68%, var(--surface) 68% 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1rem;
    }
    .dash-overall .do-ring-inner {
      width: 92px;
      height: 92px;
      border-radius: 50%;
      background: var(--white);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }
    .do-ring-inner .do-num { font-size: 1.5rem; font-weight: 900; color: var(--ink); }
    .do-ring-inner .do-cap { font-size: 0.625rem; font-weight: 800; text-transform: uppercase; color: var(--dim); }
    .do-label { font-size: 0.8125rem; font-weight: 900; color: var(--ink); margin-bottom: 0.25rem; }
    .do-sub { font-size: 0.75rem; font-weight: 600; color: var(--muted); }
    .dash-cols { display: flex; flex-direction: column; gap: 0.875rem; }
    .dash-mini {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius-md);
      padding: 0.875rem 1rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .dash-mini .dm-label { font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.06em; color: var(--dim); }
    .dash-mini .dm-value { font-size: 0.9375rem; font-weight: 900; color: var(--ink); }
    .dash-mini .dm-bar {
      width: 90px;
      height: 6px;
      border-radius: 3px;
      background: var(--border);
      overflow: hidden;
      margin-top: 0.375rem;
    }
    .dash-mini .dm-bar span { display: block; height: 100%; border-radius: 3px; background: var(--accent); }
    .dash-mini .dm-bar span.green { background: var(--secondary); }
    .dash-mini .dm-bar span.amber { background: #F59E0B; }
    .dash-rows { grid-column: 1 / -1; border-top: 1px solid var(--border); padding-top: 1.25rem; }
    .dash-rows .dr-title { font-size: 0.75rem; font-weight: 900; color: var(--ink); margin-bottom: 0.75rem; }
    .dr-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0.5rem 0;
      font-size: 0.8125rem;
      font-weight: 700;
      color: var(--slate);
    }
    .dr-item + .dr-item { border-top: 1px solid var(--surface); }
    .dr-item .dr-status {
      font-size: 0.625rem;
      font-weight: 900;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      padding: 0.2rem 0.5rem;
      border-radius: 100px;
    }
    .dr-item .dr-status.on { background: var(--secondary-light); color: var(--secondary); }
    .dr-item .dr-status.warn { background: #FEF3C7; color: #D97706; }

    /* ── AI EMPLOYEE ANALYSIS CARD ── */
    #analysis { background: var(--white); }
    .analysis-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius-xl);
      padding: 2rem;
      max-width: 480px;
      margin: 0 auto;
    }
    .analysis-head {
      display: flex;
      align-items: center;
      gap: 1rem;
      padding-bottom: 1.25rem;
      border-bottom: 1px solid var(--border);
      margin-bottom: 1.25rem;
    }
    .analysis-avatar { width: 48px; height: 48px; border-radius: 50%; background: var(--ink); color: var(--white); display: flex; align-items: center; justify-content: center; font-weight: 900; }
    .analysis-name { font-size: 0.9375rem; font-weight: 900; color: var(--ink); }
    .analysis-role { font-size: 0.75rem; font-weight: 600; color: var(--muted); }
    .analysis-status {
      margin-left: auto;
      font-size: 0.625rem;
      font-weight: 900;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      color: var(--secondary);
      background: var(--secondary-light);
      padding: 0.3rem 0.7rem;
      border-radius: 100px;
    }
    .analysis-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0.75rem 0;
    }
    .analysis-row + .analysis-row { border-top: 1px solid var(--border); }
    .analysis-row .ar-label { font-size: 0.8125rem; font-weight: 700; color: var(--slate); }
    .analysis-row .ar-value { font-size: 0.9375rem; font-weight: 900; color: var(--ink); }
    .analysis-row .ar-pill {
      font-size: 0.625rem;
      font-weight: 900;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      padding: 0.25rem 0.625rem;
      border-radius: 100px;
      background: #FEF3C7;
      color: #D97706;
    }
    .analysis-attn {
      margin-top: 1.25rem;
      background: #FEF3C7;
      border: 1px solid #FDE68A;
      border-radius: var(--radius-md);
      padding: 0.875rem 1rem;
      font-size: 0.8125rem;
      font-weight: 800;
      color: #92400E;
      text-align: center;
    }

    /* ── MANAGERS TIME ── */
    #managers { background: var(--surface); }
    .compare-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 3rem; }
    .compare-box {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: var(--radius-lg);
      padding: 1.75rem;
    }
    .compare-box .cb-title { font-size: 0.8125rem; font-weight: 900; color: var(--ink); margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.06em; }
    .compare-box.dim { opacity: 0.6; }
    .cb-flow { display: flex; flex-direction: column; align-items: center; gap: 0.5rem; }
    .cb-node {
      font-size: 0.8125rem;
      font-weight: 800;
      padding: 0.625rem 1.25rem;
      border-radius: var(--radius-sm);
      background: var(--surface);
      border: 1px solid var(--border);
      color: var(--ink);
      text-align: center;
    }
    .cb-node.hot { background: var(--secondary-light); border-color: var(--secondary-border); color: var(--secondary); }
    .cb-node.dark { background: var(--ink); color: var(--white); }
    .cb-node.accent { background: var(--accent); color: var(--white); }
    .cb-arrow { color: var(--dim); font-size: 0.875rem; line-height: 1; }
    .cb-note { font-size: 0.6875rem; font-weight: 700; color: var(--dim); margin-top: 0.5rem; }

    /* ── BUILT FOR ── */
    #built-for { background: var(--white); }
    .industry-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; }
    .industry-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius-xl);
      padding: 2rem;
      display: flex;
      flex-direction: column;
      gap: 1.25rem;
    }
    .industry-card .ic-icon { width: 48px; height: 48px; border-radius: var(--radius-sm); background: var(--accent-light); color: var(--accent); display: flex; align-items: center; justify-content: center; font-size: 1.375rem; }
    .industry-card .ic-icon.green { background: var(--secondary-light); color: var(--secondary); }
    .industry-card h4 { font-size: 1.25rem; font-weight: 900; color: var(--ink); }
    .industry-card .ic-tag { font-size: 0.8125rem; font-weight: 800; color: var(--muted); }
    .industry-card p { font-size: 0.9375rem; font-weight: 500; color: var(--muted); line-height: 1.6; }
    .ic-flow {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: var(--radius-md);
      padding: 1rem;
      display: flex;
      flex-direction: column;
      gap: 0.375rem;
    }
    .ic-flow-step {
      display: flex;
      align-items: center;
      gap: 0.625rem;
      font-size: 0.75rem;
      font-weight: 700;
      color: var(--slate);
    }
    .ic-flow-step .ifs-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--accent); flex-shrink: 0; }
    .ic-flow-step.green .ifs-dot { background: var(--secondary); }
    .ic-flow-step .ifs-arrow { color: var(--dim); font-size: 0.625rem; }
    .ic-uses { list-style: none; display: flex; flex-direction: column; gap: 0.5rem; }
    .ic-uses li { display: flex; align-items: center; gap: 0.625rem; font-size: 0.8125rem; font-weight: 700; color: var(--slate); }
    .ic-uses li::before { content: ''; width: 16px; height: 16px; border-radius: 50%; background: var(--accent-light); border: 1.5px solid var(--accent-border); flex-shrink: 0; }
    .ic-uses.green li::before { background: var(--secondary-light); border-color: var(--secondary-border); }

    .ic-visual { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-md); padding: 1rem 1rem 0.6rem; display: flex; flex-direction: column; gap: 0.3rem; }
    .ic-visual .vnode { display: flex; align-items: center; gap: 0.6rem; background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 0.5rem 0.6rem; font-size: 0.78rem; font-weight: 800; color: var(--ink); }
    .ic-visual .vnode .vnic { width: 26px; height: 26px; border-radius: 8px; background: var(--accent-light); color: var(--accent); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .ic-visual .vnode .vnic svg { width: 15px; height: 15px; }
    .ic-visual.green .vnode .vnic { background: var(--secondary-light); color: var(--secondary); }
    .ic-visual .vnode .vst { margin-left: auto; font-size: 0.58rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.04em; color: var(--dim); background: var(--surface); border: 1px solid var(--border); padding: 0.15rem 0.5rem; border-radius: 999px; }
    .ic-visual .varrow { text-align: center; color: var(--dim); line-height: 0; font-size: 0.6rem; padding: 0.05rem 0; }
    .btn-green { background: var(--secondary); }
    .btn-green:hover { background: #0a9a3b; }

    /* ── PRODUCTIVITY LOOP ── */
    #loop { background: var(--surface); }
    .loop-wrap {
      max-width: 760px;
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      gap: 1rem;
      position: relative;
    }
    .loop-step {
      display: flex;
      align-items: center;
      gap: 1.25rem;
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: var(--radius-lg);
      padding: 1.25rem 1.5rem;
    }
    .loop-step .ls-phase { font-size: 0.625rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.1em; color: var(--accent); width: 110px; flex-shrink: 0; }
    .loop-step .ls-phase.green { color: var(--secondary); }
    .loop-step .ls-icon { width: 40px; height: 40px; border-radius: 50%; background: var(--accent-light); color: var(--accent); display: flex; align-items: center; justify-content: center; font-size: 1.125rem; flex-shrink: 0; }
    .loop-step .ls-icon.green { background: var(--secondary-light); color: var(--secondary); }
    .loop-step .ls-title { font-size: 0.9375rem; font-weight: 900; color: var(--ink); }
    .loop-step .ls-text { font-size: 0.8125rem; font-weight: 600; color: var(--muted); }
    .loop-arrow { align-self: center; color: var(--dim); font-size: 1rem; line-height: 1; }
    .loop-return {
      margin: 1rem auto 0;
      font-size: 0.75rem;
      font-weight: 900;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: var(--accent);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }

    /* ── INTEGRATIONS ── */
    #integrations { background: var(--white); }
    .integrations-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1rem;
      max-width: 760px;
      margin: 0 auto;
    }
    .integration-chip {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius-md);
      padding: 0.875rem 1rem;
      font-size: 0.8125rem;
      font-weight: 800;
      color: var(--slate);
    }

    /* ── ANIMATIONS ── */
    @keyframes revealUp {
      from { opacity: 0; transform: translateY(32px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .reveal { opacity: 0; }
    .reveal.visible { animation: revealUp 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards; }
    .reveal-delay-1 { animation-delay: 0.08s !important; }
    .reveal-delay-2 { animation-delay: 0.16s !important; }
    .reveal-delay-3 { animation-delay: 0.24s !important; }



    /* ── RESPONSIVE ── */
    @media (max-width: 1080px) {
      .services-grid { grid-template-columns: repeat(3, 1fr); }
      .solutions-grid { grid-template-columns: repeat(3, 1fr); }
      .why-grid { grid-template-columns: repeat(2, 1fr); }
      .industry-grid { grid-template-columns: 1fr; }
      .integrations-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 900px) {
      .overview-grid { grid-template-columns: 1fr; }
      .product-block { grid-template-columns: 1fr; gap: 2.5rem; }
      .product-block .flow-card-col { order: -1; }
      .process-timeline { grid-template-columns: 1fr 1fr; }
      .process-timeline::before { display: none; }
      .footer-grid { grid-template-columns: 1fr 1fr; }
      .hero-stats { grid-template-columns: repeat(2, 1fr); }
      .compare-grid { grid-template-columns: 1fr; }
      .dash-grid { grid-template-columns: 1fr; }
      .dash-overall { border-right: none; padding-right: 0; border-bottom: 1px solid var(--border); padding-bottom: 1.25rem; }
      .integrations-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 640px) {
      section { padding: 4rem 0; }
      .services-grid { grid-template-columns: repeat(2, 1fr); }
      .solutions-grid { grid-template-columns: repeat(2, 1fr); }
      .why-grid { grid-template-columns: 1fr 1fr; }
      .process-timeline { grid-template-columns: 1fr; }
      .footer-grid { grid-template-columns: 1fr; gap: 2rem; }
      .integrations-grid { grid-template-columns: 1fr 1fr; }
      .industry-card { padding: 1.5rem; }
    }

    /* ── MODAL ── */
    .modal-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(15,23,42,0.6);
      backdrop-filter: blur(4px);
      z-index: 200;
      align-items: center;
      justify-content: center;
    }
    .modal-overlay.open { display: flex; }
    .modal-box {
      background: var(--white);
      border-radius: var(--radius-lg);
      padding: 2.5rem 2rem;
      max-width: 380px;
      width: 90%;
      text-align: center;
      position: relative;
      animation: modalIn 0.25s ease-out;
    }
    @keyframes modalIn {
      from { opacity: 0; transform: scale(0.92) translateY(12px); }
      to { opacity: 1; transform: scale(1) translateY(0); }
    }
    .modal-close {
      position: absolute;
      top: 0.75rem;
      right: 1rem;
      background: none;
      border: none;
      font-size: 1.5rem;
      color: var(--dim);
      cursor: pointer;
      line-height: 1;
    }
    .modal-close:hover { color: var(--ink); }
    .modal-icon {
      font-size: 2.5rem;
      margin-bottom: 1rem;
    }
    .modal-box h3 {
      font-size: 1.25rem;
      font-weight: 900;
      color: var(--ink);
      margin-bottom: 0.5rem;
    }
    .modal-box p {
      font-size: 0.9375rem;
      font-weight: 500;
      color: var(--muted);
      line-height: 1.6;
    }

    /* ── CONTACT FORM ── */
    #contact { background: var(--surface); }
    .contact-form {
      max-width: 580px;
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      gap: 1.25rem;
    }
    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.25rem;
    }
    .contact-form label {
      font-size: 0.8125rem;
      font-weight: 800;
      color: var(--ink);
      display: block;
      margin-bottom: 0.375rem;
    }
    .contact-form input,
    .contact-form select,
    .contact-form textarea {
      width: 100%;
      font-family: 'Nunito', sans-serif;
      font-size: 0.9375rem;
      font-weight: 600;
      color: var(--ink);
      background: var(--white);
      border: 1.5px solid var(--border);
      border-radius: var(--radius-sm);
      padding: 0.75rem 1rem;
      outline: none;
      transition: border-color 0.2s;
    }
    .contact-form input:focus,
    .contact-form select:focus,
    .contact-form textarea:focus {
      border-color: var(--accent);
    }
    .contact-form textarea {
      resize: vertical;
      min-height: 120px;
    }
    .contact-form .btn-primary {
      align-self: flex-start;
    }
    .form-success {
      display: none;
      text-align: center;
      padding: 2rem;
    }
    .form-success.show { display: block; }
    .form-success .check {
      font-size: 3rem;
      margin-bottom: 1rem;
    }
    .form-success h3 {
      font-size: 1.5rem;
      font-weight: 900;
      color: var(--ink);
      margin-bottom: 0.5rem;
    }
    .form-success p {
      font-size: 1rem;
      color: var(--muted);
    }

    /* Scrollbar */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: var(--surface); }
    ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }
    ::-webkit-scrollbar-thumb:hover { background: var(--muted); }
  </style>
</head>
<body>

<svg xmlns="http://www.w3.org/2000/svg" style="display:none">
  <!-- Overview icons -->
  <symbol id="icon-antenna" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M12 2v4"/><path d="M8 12a4 4 0 0 1 8 0"/><path d="M6 16a7 7 0 0 1 12 0"/><path d="M4 20a10 10 0 0 1 16 0"/><circle cx="12" cy="18" r="1"/>
  </symbol>
  <symbol id="icon-ai" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <rect x="3" y="3" width="18" height="18" rx="4"/><path d="M9 12h6"/><path d="M12 9v6"/>
  </symbol>
  <symbol id="icon-chart" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M3 3v18h18"/><path d="M7 16l4-8 4 4 4-6"/>
  </symbol>
  <!-- Communication icons -->
  <symbol id="icon-phone" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
  </symbol>
  <symbol id="icon-zap" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
  </symbol>
  <symbol id="icon-cloud" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M17.5 19H9a7 7 0 1 1 6.71-9h1.79a4.5 4.5 0 1 1 0 9z"/>
  </symbol>
  <symbol id="icon-link" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
  </symbol>
  <symbol id="icon-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
  </symbol>
  <symbol id="icon-megaphone" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
  </symbol>
  <symbol id="icon-headset" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M4 14v-3a8 8 0 0 1 16 0v3"/><path d="M18 18a2 2 0 0 1-2 2h-1a1 1 0 0 1-1-1v-5a1 1 0 0 1 1-1h3z"/><path d="M6 18a2 2 0 0 0 2 2h1a1 1 0 0 0 1-1v-5a1 1 0 0 0-1-1H6z"/>
  </symbol>
  <symbol id="icon-rocket" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/><path d="M12 15l-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/>
  </symbol>
  <symbol id="icon-shield" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
  </symbol>
  <symbol id="icon-globe" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
  </symbol>
  <symbol id="icon-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
  </symbol>
  <symbol id="icon-target" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>
  </symbol>
  <symbol id="icon-mic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><path d="M12 19v3"/>
  </symbol>
  <symbol id="icon-tools" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
  </symbol>
  <symbol id="icon-mail" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
  </symbol>
  <symbol id="icon-building" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <rect x="4" y="2" width="16" height="20" rx="2"/><path d="M9 6h1"/><path d="M14 6h1"/><path d="M9 10h1"/><path d="M14 10h1"/><path d="M9 14h1"/><path d="M14 14h1"/><path d="M9 18h6"/>
  </symbol>
  <symbol id="icon-briefcase" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
  </symbol>
  <symbol id="icon-sliders" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/>
  </symbol>
  <symbol id="icon-calendar" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
  </symbol>
  <symbol id="icon-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <polyline points="20 6 9 17 4 12"/>
  </symbol>
  <symbol id="icon-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
  </symbol>
  <symbol id="icon-refresh" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
  </symbol>
  <symbol id="icon-monitor" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>
  </symbol>
  <symbol id="icon-home" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
  </symbol>
  <symbol id="icon-heart" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
  </symbol>
  <symbol id="icon-user" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
  </symbol>
</svg>

<!-- ══ NAV ══ -->
<nav id="navbar">
  <div class="nav-inner">
    <a href="#" class="nav-logo">Goal<span>Chaser</span></a>
    <ul class="nav-links">
      <li><a href="#how-it-works">How It Works</a></li>
      <li><a href="/goalchaser-for-textile">For Textile</a></li>
      <li><a href="/goalchaser-for-it">For IT</a></li>
    </ul>
    <div class="nav-actions">
      <a href="#" class="btn-ghost">Sign In</a>
      <a href="#cta" class="btn-primary">Get Started →</a>
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
    <div class="mobile-actions">
      <a href="#" class="btn-outline">Sign In</a>
      <a href="#cta" class="btn-primary btn-lg">Get Started →</a>
    </div>
  </div>
</nav>

<!-- ══ HERO ══ -->
<section id="hero">
  <div class="container">
    <div class="hero-grid">
      <div>
        <div class="hero-eyebrow reveal reveal-delay-1">AI-Powered Productivity</div>
        <h1 class="hero-h1 reveal reveal-delay-1">
          Productivity that <span class="accent">doesn't wait for you</span>
        </h1>
        <p class="hero-lead reveal reveal-delay-2">
          GoalChaser helps individuals and teams stay focused, accountable, and productive through intelligent task management, AI voice follow-ups, blocker detection, and real-time progress reporting.
        </p>
        <div class="hero-cta reveal reveal-delay-3">
          <a href="#cta" class="btn-primary btn-lg btn-accent">Get Started →</a>
          <a href="#how-it-works" class="btn-outline btn-lg">See How It Works</a>
        </div>
        <div class="hero-tagline reveal reveal-delay-3">Plan. Follow Up. Resolve. Report. Improve.</div>
        <div class="hero-stats reveal">
          <div>
            <div class="hero-stat-value">Personal</div>
            <div class="hero-stat-label">Productivity</div>
            <div class="hero-stat-sub">Stay focused on what matters</div>
          </div>
          <div>
            <div class="hero-stat-value accent">AI Voice</div>
            <div class="hero-stat-label">Follow-ups</div>
            <div class="hero-stat-sub">Conversations that keep work moving</div>
          </div>
          <div>
            <div class="hero-stat-value">Team</div>
            <div class="hero-stat-label">Productivity</div>
            <div class="hero-stat-sub">Accountability without micromanagement</div>
          </div>
          <div>
            <div class="hero-stat-value blue">Intelligent</div>
            <div class="hero-stat-label">Reporting</div>
            <div class="hero-stat-sub">Clear visibility into real progress</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ══ PRODUCTIVITY GAP ══ -->
<section id="gap">
  <div class="container">
    <div class="section-header">
      <div class="eyebrow">The Productivity Gap</div>
      <h2 class="section-title">Knowing what needs to be done <span class="accent">isn't the same as getting it done</span></h2>
      <p class="section-sub">Tasks get forgotten. Follow-ups get missed. Blockers stay hidden. Managers spend valuable time chasing updates instead of focusing on growth.</p>
    </div>
    <div class="overview-grid">
      <div class="overview-card reveal">
        <div class="overview-icon accent"><svg class="icon"><use href="#icon-home"/></svg></div>
        <h3>Personal Productivity</h3>
        <p>Turn intentions into consistent execution. Organize priorities, receive intelligent follow-ups, and build accountability around the work that matters most.</p>
      </div>
      <div class="overview-card reveal reveal-delay-1">
        <div class="overview-icon blue"><svg class="icon"><use href="#icon-briefcase"/></svg></div>
        <h3>Team Productivity</h3>
        <p>Keep your team moving without constant supervision. GoalChaser communicates with employees, follows up on tasks, identifies blockers, and helps teams stay aligned with their objectives.</p>
      </div>
      <div class="overview-card reveal reveal-delay-2">
        <div class="overview-icon mixed"><svg class="icon"><use href="#icon-monitor"/></svg></div>
        <h3>Management Visibility</h3>
        <p>Know what's actually happening. Get continuous, structured reporting on progress, blockers, productivity patterns, and areas that need human attention.</p>
      </div>
    </div>
  </div>
</section>

<!-- ══ HOW IT WORKS ══ -->
<section id="how-it-works">
  <div class="container">
    <div class="section-header">
      <div class="eyebrow">How It Works</div>
      <h2 class="section-title">From daily tasks to <span class="accent">measurable progress</span></h2>
      <p class="section-sub">GoalChaser creates a continuous productivity loop that helps people execute and gives management the visibility they need.</p>
    </div>
    <div class="loop-wrap">
      <div class="loop-step reveal">
        <div class="ls-phase">01 · Plan</div>
        <div class="ls-icon"><svg class="icon"><use href="#icon-target"/></svg></div>
        <div>
          <div class="ls-title">Set goals and priorities</div>
          <div class="ls-text">Define what needs to be accomplished and when.</div>
        </div>
      </div>
      <div class="loop-arrow">▼</div>
      <div class="loop-step reveal reveal-delay-1">
        <div class="ls-phase green">02 · Communicate</div>
        <div class="ls-icon green"><svg class="icon"><use href="#icon-phone"/></svg></div>
        <div>
          <div class="ls-title">GoalChaser checks in</div>
          <div class="ls-text">AI voice conversations keep individuals and teams connected to their commitments.</div>
        </div>
      </div>
      <div class="loop-arrow">▼</div>
      <div class="loop-step reveal reveal-delay-2">
        <div class="ls-phase">03 · Follow Up</div>
        <div class="ls-icon"><svg class="icon"><use href="#icon-refresh"/></svg></div>
        <div>
          <div class="ls-title">Keep work moving</div>
          <div class="ls-text">GoalChaser checks progress, asks the right questions, and follows up when tasks need attention.</div>
        </div>
      </div>
      <div class="loop-arrow">▼</div>
      <div class="loop-step reveal reveal-delay-3">
        <div class="ls-phase green">04 · Resolve</div>
        <div class="ls-icon green"><svg class="icon"><use href="#icon-check"/></svg></div>
        <div>
          <div class="ls-title">Surface and address blockers</div>
          <div class="ls-text">Employees can explain what's holding them back, allowing GoalChaser to identify blockers and help move work forward.</div>
        </div>
      </div>
      <div class="loop-arrow">▼</div>
      <div class="loop-step reveal">
        <div class="ls-phase">05 · Report</div>
        <div class="ls-icon"><svg class="icon"><use href="#icon-chart"/></svg></div>
        <div>
          <div class="ls-title">Turn conversations into intelligence</div>
          <div class="ls-text">Progress, blockers, productivity patterns, and outcomes become clear reports for the people responsible for managing them.</div>
        </div>
      </div>
      <div class="loop-return reveal">↺ Back to Plan — the loop repeats</div>
    </div>
  </div>
</section>

<!-- ══ AI VOICE ══ -->
<section id="voice">
  <div class="container">
    <div class="product-block">
      <div class="reveal">
        <div class="eyebrow">Flagship Feature</div>
        <div class="product-name">Your productivity assistant can <span class="accent">actually talk to you</span></div>
        <p class="product-desc">GoalChaser uses intelligent voice conversations to make productivity proactive rather than passive.</p>
        <p class="voice-closing">Less manual updating. <span>More actual communication.</span></p>
      </div>
      <div class="voice-visual reveal reveal-delay-1">
        <div class="voice-call-head">
          <div class="voice-avatar"><svg class="icon"><use href="#icon-mic"/></svg></div>
          <div>
            <div class="vc-name">GoalChaser AI</div>
            <div class="vc-status">AI Voice Check-in</div>
          </div>
          <div class="vc-time">Morning</div>
        </div>
        <div class="chat-msg ai">
          <div>
            <div class="chat-label">AI Call</div>
            <div class="chat-bubble">"Good morning. What are your priorities today?"</div>
            <div class="chat-meta">GoalChaser helps establish the day's priorities.</div>
          </div>
        </div>
        <div class="chat-msg user">
          <div>
            <div class="chat-label">Employee</div>
            <div class="chat-bubble">"Finishing the client proposal, then the team report."</div>
          </div>
        </div>
        <div class="chat-msg ai">
          <div>
            <div class="chat-label">During the Day</div>
            <div class="chat-bubble">"How is the client proposal progressing?"</div>
            <div class="chat-meta">Checks progress without another dashboard update.</div>
          </div>
        </div>
        <div class="chat-msg user">
          <div>
            <div class="chat-label">Blocker</div>
            <div class="chat-bubble">"I'm waiting on the final pricing from finance."</div>
            <div class="chat-meta">The conversation identifies a problem.</div>
          </div>
        </div>
        <div class="chat-msg ai">
          <div>
            <div class="chat-label">Follow-up</div>
            <div class="chat-bubble">"Were you able to resolve the issue?"</div>
            <div class="chat-meta">GoalChaser automatically follows up.</div>
          </div>
        </div>
        <div class="chat-msg ai">
          <div>
            <div class="chat-label">Evening</div>
            <div class="chat-bubble">"Let's review what you completed today."</div>
            <div class="chat-meta">The conversation becomes structured productivity data.</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ══ PERSONAL PRODUCTIVITY ══ -->
<section id="individuals">
  <div class="container">
    <div class="product-block">
      <div class="reveal">
        <span class="product-tag">For Individuals</span>
        <div class="product-name">Stay accountable to <span class="accent">your own goals</span></div>
        <div class="product-tagline">Your personal productivity partner</div>
        <p class="product-desc">GoalChaser acts as your personal productivity partner, helping you plan your day, maintain focus, follow through on commitments, and reflect on your progress.</p>
        <ul class="feature-list">
          <li>Daily Planning — start each day with clear priorities</li>
          <li>Intelligent Follow-ups — reminded at the right time</li>
          <li>Voice Accountability — talk through your progress</li>
          <li>Habit &amp; Consistency — build better execution patterns</li>
          <li>Progress Insights — understand your time and attention</li>
          <li>Daily Reflection — review and prepare for what's next</li>
        </ul>
        <a href="#cta" class="btn-primary btn-accent">Improve My Productivity →</a>
      </div>
      <div class="flow-card-col reveal reveal-delay-1">
        <div class="flow-card accent-top">
          <div class="flow-step">
            <div class="flow-step-num num-accent">1</div>
            <div class="flow-step-text">
              <div class="flow-step-title">Plan the day</div>
              <div class="flow-step-sub">Set clear priorities</div>
            </div>
            <span class="flow-step-icon"><svg class="icon"><use href="#icon-calendar"/></svg></span>
          </div>
          <div class="flow-step">
            <div class="flow-step-num num-ink">2</div>
            <div class="flow-step-text">
              <div class="flow-step-title">AI voice check-in</div>
              <div class="flow-step-sub">Talk through your plan</div>
            </div>
            <span class="flow-step-icon"><svg class="icon"><use href="#icon-mic"/></svg></span>
          </div>
          <div class="flow-step">
            <div class="flow-step-num num-blue">3</div>
            <div class="flow-step-text">
              <div class="flow-step-title">Intelligent follow-ups</div>
              <div class="flow-step-sub">At the right time</div>
            </div>
            <span class="flow-step-icon"><svg class="icon"><use href="#icon-phone"/></svg></span>
          </div>
          <div class="flow-step">
            <div class="flow-step-num num-accent">4</div>
            <div class="flow-step-text">
              <div class="flow-step-title">Blockers surfaced</div>
              <div class="flow-step-sub">Nothing stays hidden</div>
            </div>
            <span class="flow-step-icon"><svg class="icon"><use href="#icon-check"/></svg></span>
          </div>
          <div class="flow-step">
            <div class="flow-step-num num-ink">5</div>
            <div class="flow-step-text">
              <div class="flow-step-title">Daily reflection</div>
              <div class="flow-step-sub">Review and improve</div>
            </div>
            <span class="flow-step-icon"><svg class="icon"><use href="#icon-chart"/></svg></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ══ TEAM PRODUCTIVITY ══ -->
<section id="teams">
  <div class="container">
    <div class="product-block">
      <div class="flow-card-col reveal">
        <div class="flow-card blue-top">
          <div class="flow-step">
            <div class="flow-step-num num-blue">1</div>
            <div class="flow-step-text">
              <div class="flow-step-title">Manager sets objectives</div>
              <div class="flow-step-sub">Goals, tasks, expectations defined</div>
            </div>
            <span class="flow-step-icon"><svg class="icon"><use href="#icon-target"/></svg></span>
          </div>
          <div class="flow-step">
            <div class="flow-step-num num-ink">2</div>
            <div class="flow-step-text">
              <div class="flow-step-title">GoalChaser communicates</div>
              <div class="flow-step-sub">AI check-ins and follow-ups</div>
            </div>
            <span class="flow-step-icon"><svg class="icon"><use href="#icon-phone"/></svg></span>
          </div>
          <div class="flow-step">
            <div class="flow-step-num num-accent">3</div>
            <div class="flow-step-text">
              <div class="flow-step-title">Progress is collected</div>
              <div class="flow-step-sub">What's done, what's blocking</div>
            </div>
            <span class="flow-step-icon"><svg class="icon"><use href="#icon-refresh"/></svg></span>
          </div>
          <div class="flow-step">
            <div class="flow-step-num num-accent">4</div>
            <div class="flow-step-text">
              <div class="flow-step-title">Blockers are identified</div>
              <div class="flow-step-sub">Issues that need attention</div>
            </div>
            <span class="flow-step-icon"><svg class="icon"><use href="#icon-search"/></svg></span>
          </div>
          <div class="flow-step">
            <div class="flow-step-num num-blue">5</div>
            <div class="flow-step-text">
              <div class="flow-step-title">Follow-ups continue</div>
              <div class="flow-step-sub">Until work progresses</div>
            </div>
            <span class="flow-step-icon"><svg class="icon"><use href="#icon-check"/></svg></span>
          </div>
          <div class="flow-step">
            <div class="flow-step-num num-ink">6</div>
            <div class="flow-step-text">
              <div class="flow-step-title">Management gets visibility</div>
              <div class="flow-step-sub">Reports without asking everyone</div>
            </div>
            <span class="flow-step-icon"><svg class="icon"><use href="#icon-monitor"/></svg></span>
          </div>
        </div>
      </div>
      <div class="reveal reveal-delay-1">
        <span class="product-tag blue-tag">For Teams</span>
        <div class="product-name">Productivity management without <span class="blue">constant chasing</span></div>
        <div class="product-tagline">Your AI accountability layer</div>
        <p class="product-desc">GoalChaser takes repetitive follow-up work away from managers while keeping teams accountable and management informed.</p>
        <ul class="feature-list blue-checks">
          <li>AI check-ins and follow-ups</li>
          <li>Automated task accountability</li>
          <li>Blocker identification</li>
          <li>Real-time progress collection</li>
          <li>Executive reporting</li>
        </ul>
        <p class="voice-closing" style="text-align:left">Your managers should manage people and decisions, not spend their day asking, "What's the status?"</p>
        <a href="#cta" class="btn-primary btn-accent">Improve Team Productivity →</a>
      </div>
    </div>
  </div>
</section>

<!-- ══ MANAGEMENT INTELLIGENCE ══ -->
<section id="intelligence">
  <div class="container">
    <div class="section-header">
      <div class="eyebrow">Management Intelligence</div>
      <h2 class="section-title">Know what's happening without <span class="blue">asking everyone</span></h2>
      <p class="section-sub">GoalChaser continuously turns tasks, conversations, follow-ups, and progress into a clear picture of your team's productivity.</p>
    </div>
    <div class="overview-grid">
      <div class="overview-card reveal">
        <div class="overview-icon accent"><svg class="icon"><use href="#icon-eye"/></svg></div>
        <h3>Progress Visibility</h3>
        <p>See what has been completed, what is still pending, and where progress is slowing down.</p>
      </div>
      <div class="overview-card reveal reveal-delay-1">
        <div class="overview-icon blue"><svg class="icon"><use href="#icon-search"/></svg></div>
        <h3>Blocker Intelligence</h3>
        <p>Identify recurring blockers and the people, projects, or processes affected by them.</p>
      </div>
      <div class="overview-card reveal reveal-delay-2">
        <div class="overview-icon mixed"><svg class="icon"><use href="#icon-chart"/></svg></div>
        <h3>Productivity Analysis</h3>
        <p>Understand individual and team productivity patterns over time instead of relying only on manual status updates.</p>
      </div>
    </div>
    <div class="dash-preview reveal">
      <div class="dash-top">
        <div>
          <div class="dt-title">Team Productivity</div>
          <div class="dt-sub">Live overview · this week</div>
        </div>
        <div class="dt-badge">AI Intelligence</div>
      </div>
      <div class="dash-grid">
        <div class="dash-overall">
          <div class="do-ring"><div class="do-ring-inner"><div class="do-num">68%</div><div class="do-cap">On Track</div></div></div>
          <div class="do-label">Overall team progress</div>
          <div class="do-sub">Completed vs pending tasks across the team.</div>
        </div>
        <div class="dash-cols">
          <div class="dash-mini">
            <div><div class="dm-label">Completed</div><div class="dm-value">46 tasks</div></div>
            <div class="dm-bar"><span class="green" style="width:72%"></span></div>
          </div>
          <div class="dash-mini">
            <div><div class="dm-label">Pending</div><div class="dm-value">22 tasks</div></div>
            <div class="dm-bar"><span class="amber" style="width:34%"></span></div>
          </div>
          <div class="dash-mini">
            <div><div class="dm-label">Active Blockers</div><div class="dm-value">3</div></div>
            <div class="dm-bar"><span class="amber" style="width:12%"></span></div>
          </div>
        </div>
        <div class="dash-rows">
          <div class="dr-title">Employees requiring attention</div>
          <div class="dr-item">Sarah M. <span class="dr-status warn">Review</span></div>
          <div class="dr-item">James T. <span class="dr-status on">On Track</span></div>
          <div class="dr-item">Amina R. <span class="dr-status on">On Track</span></div>
          <div class="dr-item">Omar K. <span class="dr-status warn">Follow-up</span></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ══ AI EMPLOYEE ANALYSIS ══ -->
<section id="analysis">
  <div class="container">
    <div class="section-header">
      <div class="eyebrow">AI Productivity Analysis</div>
      <h2 class="section-title">Know when someone <span class="accent">needs your attention</span></h2>
      <p class="section-sub">GoalChaser doesn't replace management judgment. It helps management know where that judgment is needed.</p>
    </div>
    <div class="analysis-card reveal">
      <div class="analysis-head">
        <div class="analysis-avatar">SM</div>
        <div>
          <div class="analysis-name">Sarah M.</div>
          <div class="analysis-role">Operations · Team Lead</div>
        </div>
        <div class="analysis-status">On Track</div>
      </div>
      <div class="analysis-row"><span class="ar-label">Task Completion</span><span class="ar-value">82%</span></div>
      <div class="analysis-row"><span class="ar-label">Follow-up Status</span><span class="ar-value">3 completed</span></div>
      <div class="analysis-row"><span class="ar-label">Blockers</span><span class="ar-value">1 active</span></div>
      <div class="analysis-row"><span class="ar-label">AI Confidence</span><span class="ar-pill">Low</span></div>
      <div class="analysis-attn">Management Attention Recommended</div>
    </div>
    <div class="section-header" style="margin-top:3rem; margin-bottom:2rem;">
      <h3 style="font-size:1.375rem; font-weight:900; color:var(--ink); margin-bottom:1rem;">How the analysis is formed</h3>
      <div class="loop-wrap" style="text-align:left;">
        <div class="loop-step reveal">
          <div class="ls-icon"><svg class="icon"><use href="#icon-search"/></svg></div>
          <div>
            <div class="ls-title">GoalChaser observes patterns</div>
            <div class="ls-text">Task completion, follow-up conversations, blockers, commitments, and progress.</div>
          </div>
        </div>
        <div class="loop-arrow">▼</div>
        <div class="loop-step reveal reveal-delay-1">
          <div class="ls-icon green"><svg class="icon"><use href="#icon-ai"/></svg></div>
          <div>
            <div class="ls-title">AI analyzes the context</div>
            <div class="ls-text">It compares current progress against expected work and historical patterns.</div>
          </div>
        </div>
        <div class="loop-arrow">▼</div>
        <div class="loop-step reveal reveal-delay-2">
          <div class="ls-icon"><svg class="icon"><use href="#icon-check"/></svg></div>
          <div>
            <div class="ls-title">Confidence matters</div>
            <div class="ls-text">With enough context, progress is reported normally. If unclear, GoalChaser flags it for human review.</div>
          </div>
        </div>
        <div class="loop-arrow">▼</div>
        <div class="loop-step reveal reveal-delay-3">
          <div class="ls-icon green"><svg class="icon"><use href="#icon-user"/></svg></div>
          <div>
            <div class="ls-title">Manager decides</div>
            <div class="ls-text">"This employee may need a direct conversation."</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ══ GIVE MANAGERS THEIR TIME BACK ══ -->
<section id="managers">
  <div class="container">
    <div class="section-header">
      <div class="eyebrow">For Business Owners</div>
      <h2 class="section-title">Spend less time chasing progress. <span class="blue">More time growing the business</span></h2>
      <p class="section-sub">Managers and business owners shouldn't need to interrupt their teams throughout the day just to understand what's happening.</p>
    </div>
    <div class="overview-grid">
      <div class="overview-card reveal">
        <div class="overview-icon accent"><svg class="icon"><use href="#icon-check"/></svg></div>
        <h3>Less Follow-up</h3>
        <p>GoalChaser handles routine progress checks and reminders.</p>
      </div>
      <div class="overview-card reveal reveal-delay-1">
        <div class="overview-icon blue"><svg class="icon"><use href="#icon-shield"/></svg></div>
        <h3>Fewer Unnecessary Interruptions</h3>
        <p>Employees can stay focused instead of constantly responding to manual status requests.</p>
      </div>
      <div class="overview-card reveal reveal-delay-2">
        <div class="overview-icon mixed"><svg class="icon"><use href="#icon-chart"/></svg></div>
        <h3>Better Decisions</h3>
        <p>Management receives structured intelligence instead of fragmented updates.</p>
      </div>
    </div>
    <div class="compare-grid">
      <div class="compare-box dim reveal">
        <div class="cb-title">Without GoalChaser</div>
        <div class="cb-flow">
          <div class="cb-node dark">Manager</div>
          <div class="cb-arrow">→</div>
          <div class="cb-node">Employee</div>
          <div class="cb-arrow">→</div>
          <div class="cb-node">Employee</div>
          <div class="cb-arrow">→</div>
          <div class="cb-node">Employee</div>
          <div class="cb-arrow">→</div>
          <div class="cb-node hot">Status Updates</div>
          <div class="cb-note">Asking everyone, one by one.</div>
        </div>
      </div>
      <div class="compare-box reveal reveal-delay-1">
        <div class="cb-title">With GoalChaser</div>
        <div class="cb-flow">
          <div class="cb-node dark">Manager</div>
          <div class="cb-arrow">→</div>
          <div class="cb-node accent">GoalChaser</div>
          <div class="cb-arrow">→</div>
          <div class="cb-node">Team</div>
          <div class="cb-arrow">↓</div>
          <div class="cb-node hot">Progress Intelligence</div>
          <div class="cb-note">Automated, continuous, structured.</div>
        </div>
      </div>
    </div>
    <p class="voice-closing reveal" style="margin-top:3rem;">Your team keeps working. <span>GoalChaser keeps you informed.</span></p>
  </div>
</section>

<!-- ══ BUILT FOR ══ -->
<section id="built-for">
  <div class="container">
    <div class="section-header">
      <div class="eyebrow">Built For Real Workplaces</div>
      <h2 class="section-title">From the factory floor to the sprint board, <span class="accent">one layer keeps everyone moving</span></h2>
      <p class="section-sub">GoalChaser sits on top of how you already work. It keeps people executing and management informed — no matter the industry.</p>
    </div>
    <div class="industry-grid">
      <div class="industry-card reveal">
        <div class="ic-icon green"><svg class="icon"><use href="#icon-building"/></svg></div>
        <h4>Textile Operations</h4>
        <div class="ic-tag">Keep production moving — without chasing anyone.</div>
        <p>AI calls every unit and shift for updates, surfaces exceptions early, coordinates recovery, and hands management a clear, up-to-date picture from purchase order to delivery.</p>
        <div class="ic-visual green">
          <div class="vnode"><span class="vnic"><svg class="icon"><use href="#icon-check"/></svg></span>Order enters<span class="vst">Plan</span></div>
          <div class="varrow">▼</div>
          <div class="vnode"><span class="vnic"><svg class="icon"><use href="#icon-ai"/></svg></span>AI plans &amp; flags risk<span class="vst">AI</span></div>
          <div class="varrow">▼</div>
          <div class="vnode"><span class="vnic"><svg class="icon"><use href="#icon-phone"/></svg></span>AI calls every team<span class="vst">Follow up</span></div>
          <div class="varrow">▼</div>
          <div class="vnode"><span class="vnic"><svg class="icon"><use href="#icon-shield"/></svg></span>Blockers resolved fast<span class="vst">Recover</span></div>
          <div class="varrow">▼</div>
          <div class="vnode"><span class="vnic"><svg class="icon"><use href="#icon-chart"/></svg></span>Management sees everything<span class="vst">Report</span></div>
        </div>
        <ul class="ic-uses green">
          <li>Shift-by-shift follow-up calls</li>
          <li>Early blocker &amp; machine-exception detection</li>
          <li>Recovery coordination, not fire drills</li>
          <li>Approvals that stay tracked, not chased</li>
          <li>Live dashboards and daily briefings</li>
        </ul>
        <a href="/goalchaser-for-textile" class="btn-primary btn-green">See Textile Operations →</a>
      </div>
      <div class="industry-card reveal reveal-delay-1">
        <div class="ic-icon"><svg class="icon"><use href="#icon-monitor"/></svg></div>
        <h4>Corporate IT</h4>
        <div class="ic-tag">Keep technology teams moving — automatically.</div>
        <p>AI follows up on tasks and deadlines by voice, surfaces the blockers only humans can solve, and gives managers a live view of sprint and delivery progress.</p>
        <div class="ic-visual">
          <div class="vnode"><span class="vnic"><svg class="icon"><use href="#icon-target"/></svg></span>Work &amp; goals enter<span class="vst">Plan</span></div>
          <div class="varrow">▼</div>
          <div class="vnode"><span class="vnic"><svg class="icon"><use href="#icon-ai"/></svg></span>AI builds follow-ups<span class="vst">AI</span></div>
          <div class="varrow">▼</div>
          <div class="vnode"><span class="vnic"><svg class="icon"><use href="#icon-mic"/></svg></span>AI talks to developers<span class="vst">Talk</span></div>
          <div class="varrow">▼</div>
          <div class="vnode"><span class="vnic"><svg class="icon"><use href="#icon-tools"/></svg></span>Blockers surface early<span class="vst">Escalate</span></div>
          <div class="varrow">▼</div>
          <div class="vnode"><span class="vnic"><svg class="icon"><use href="#icon-chart"/></svg></span>Sprint progress, reported<span class="vst">Report</span></div>
        </div>
        <ul class="ic-uses">
          <li>Voice check-ins instead of status meetings</li>
          <li>Blocker detection with full context</li>
          <li>Humans step in only when needed</li>
          <li>Auto-written sprint reports &amp; retros</li>
          <li>Executive visibility into every team</li>
        </ul>
        <a href="/goalchaser-for-it" class="btn-primary btn-accent">See Corporate IT →</a>
      </div>
    </div>
  </div>
</section>

<!-- ══ PRODUCTIVITY LOOP ══ -->
<section id="loop">
  <div class="container">
    <div class="section-header">
      <div class="eyebrow">A Continuous Productivity Loop</div>
      <h2 class="section-title">Productivity doesn't end when the <span class="accent">task is created</span></h2>
    </div>
    <div class="loop-wrap">
      <div class="loop-step reveal">
        <div class="ls-phase">Morning · PLAN</div>
        <div class="ls-icon"><svg class="icon"><use href="#icon-calendar"/></svg></div>
        <div>
          <div class="ls-title">Start with priorities</div>
          <div class="ls-text">Clear expectations for the day.</div>
        </div>
      </div>
      <div class="loop-arrow">▼</div>
      <div class="loop-step reveal reveal-delay-1">
        <div class="ls-phase green">Midday · FOLLOW UP</div>
        <div class="ls-icon green"><svg class="icon"><use href="#icon-phone"/></svg></div>
        <div>
          <div class="ls-title">Check progress</div>
          <div class="ls-text">Identify what's getting in the way.</div>
        </div>
      </div>
      <div class="loop-arrow">▼</div>
      <div class="loop-step reveal reveal-delay-2">
        <div class="ls-phase">Evening · REFLECT</div>
        <div class="ls-icon"><svg class="icon"><use href="#icon-check"/></svg></div>
        <div>
          <div class="ls-title">Review completed work</div>
          <div class="ls-text">Missed commitments and blockers.</div>
        </div>
      </div>
      <div class="loop-arrow">▼</div>
      <div class="loop-step reveal reveal-delay-3">
        <div class="ls-phase green">Management · UNDERSTAND</div>
        <div class="ls-icon green"><svg class="icon"><use href="#icon-chart"/></svg></div>
        <div>
          <div class="ls-title">Turn activity into intelligence</div>
          <div class="ls-text">Actionable productivity insights.</div>
        </div>
      </div>
      <div class="loop-return reveal">Plan → Work → Follow Up → Resolve → Report → Plan Again</div>
    </div>
  </div>
</section>

<!-- ══ WHY GOALCHASER ══ -->
<section id="why">
  <div class="container">
    <div class="section-header">
      <div class="eyebrow">Why GoalChaser</div>
      <h2 class="section-title">Built around people, not <span class="accent">dashboards</span></h2>
    </div>
    <div class="why-grid">
      <div class="why-card reveal">
        <div class="why-icon accent"><svg class="icon"><use href="#icon-mic"/></svg></div>
        <h4>Voice First</h4>
        <p>Communicate naturally instead of constantly updating screens.</p>
      </div>
      <div class="why-card reveal reveal-delay-1">
        <div class="why-icon b"><svg class="icon"><use href="#icon-zap"/></svg></div>
        <h4>Proactive</h4>
        <p>GoalChaser follows up instead of waiting for updates.</p>
      </div>
      <div class="why-card reveal reveal-delay-2">
        <div class="why-icon accent"><svg class="icon"><use href="#icon-user"/></svg></div>
        <h4>Personal</h4>
        <p>Productivity insights adapt to individual working patterns.</p>
      </div>
      <div class="why-card reveal reveal-delay-3">
        <div class="why-icon b"><svg class="icon"><use href="#icon-check"/></svg></div>
        <h4>Accountable</h4>
        <p>Commitments don't disappear after they're created.</p>
      </div>
      <div class="why-card reveal">
        <div class="why-icon accent"><svg class="icon"><use href="#icon-ai"/></svg></div>
        <h4>Intelligent</h4>
        <p>AI understands conversations, context, and progress.</p>
      </div>
      <div class="why-card reveal reveal-delay-1">
        <div class="why-icon b"><svg class="icon"><use href="#icon-eye"/></svg></div>
        <h4>Transparent</h4>
        <p>Management sees meaningful progress without micromanaging.</p>
      </div>
      <div class="why-card reveal reveal-delay-2">
        <div class="why-icon accent"><svg class="icon"><use href="#icon-search"/></svg></div>
        <h4>Actionable</h4>
        <p>Blockers and risks are surfaced when human intervention matters.</p>
      </div>
      <div class="why-card reveal reveal-delay-3">
        <div class="why-icon b"><svg class="icon"><use href="#icon-target"/></svg></div>
        <h4>Focused</h4>
        <p>Less administrative work means more time for actual work.</p>
      </div>
    </div>
  </div>
</section>

<!-- ══ INTEGRATIONS ══ -->
<section id="integrations">
  <div class="container">
    <div class="section-header">
      <div class="eyebrow">Work With Your Workflow</div>
      <h2 class="section-title">GoalChaser works with the tools <span class="blue">your team already uses</span></h2>
      <p class="section-sub">Keep the project management, communication, and collaboration tools your team already relies on. GoalChaser adds an intelligent productivity layer on top.</p>
    </div>
    <div class="integrations-grid">
      <div class="integration-chip reveal">Slack</div>
      <div class="integration-chip reveal reveal-delay-1">Microsoft Teams</div>
      <div class="integration-chip reveal reveal-delay-2">Google Calendar</div>
      <div class="integration-chip reveal reveal-delay-3">Zapier</div>
      <div class="integration-chip reveal">Trello</div>
      <div class="integration-chip reveal reveal-delay-1">Asana</div>
      <div class="integration-chip reveal reveal-delay-2">Outlook</div>
      <div class="integration-chip reveal reveal-delay-3">HubSpot</div>
    </div>
  </div>
</section>

<!-- ══ VISION ══ -->
<section id="vision">
  <div class="container">
    <div class="vision-inner reveal">
      <div class="vision-eyebrow">Our Vision</div>
      <h2 class="vision-title">
        A more productive workplace starts with<br>
        <span class="accent">better accountability</span>
      </h2>
      <p class="vision-lead">Productivity shouldn't depend on managers constantly checking in, employees constantly updating dashboards, or business owners constantly asking for status.</p>
      <p class="vision-highlight">GoalChaser combines tasks, communication, AI, and intelligent reporting to create a workplace where people know what they need to accomplish, teams stay accountable, and management always has a clearer picture of what's happening.</p>
      <a href="#cta" class="btn-white">Build a More Productive Team →</a>
    </div>
  </div>
</section>

<!-- ══ ABOUT ══ -->
<section id="about">
  <div class="container">
    <div class="section-header">
      <div class="eyebrow">About</div>
      <h2 class="section-title">Powered by <span class="accent">eGeniusCare</span></h2>
      <p class="section-sub">GoalChaser is the AI productivity platform from eGeniusCare, built to help individuals and teams stay accountable through intelligent task management, AI voice communication, blocker detection, and productivity reporting.</p>
    </div>
    <div class="ecosystem reveal">
      <div class="eco-node top">eGeniusCare</div>
      <div class="eco-arrow"></div>
      <div class="eco-node mid">GoalChaser</div>
      <div class="eco-arrow"></div>
      <div class="eco-leaves">
        <span class="eco-leaf accent">Personal Productivity</span>
        <span class="eco-leaf b">Team Productivity</span>
        <span class="eco-leaf i">AI Voice</span>
        <span class="eco-leaf accent">Reporting</span>
        <span class="eco-leaf b">Built For</span>
      </div>
    </div>
  </div>
</section>

<!-- ══ CTA ══ -->
<section id="cta">
  <div class="container">
    <div class="cta-inner reveal">
      <div class="eyebrow" style="margin: 0 auto 1.5rem;">Start Chasing Better Productivity</div>
      <h2 class="cta-title">Give your team an <span class="accent">AI productivity partner</span></h2>
      <p class="cta-lead">Keep people focused. Reduce unnecessary follow-ups. Resolve blockers faster. And know what's really happening across your organization.</p>
      <div class="cta-actions">
        <a href="#" class="btn-primary btn-lg btn-accent">Get Started →</a>
        <a href="#contact" class="btn-outline btn-lg">Talk to Us</a>
      </div>
      <p class="cta-support">Built for individuals, teams, and growing organizations.</p>
    </div>
  </div>
</section>

<!-- ══ CONTACT ══ -->
<section id="contact">
  <div class="container">
    <div class="section-header">
      <div class="eyebrow">Contact Us</div>
      <h2 class="section-title">Have a question? <span class="blue">Reach out</span></h2>
      <p class="section-sub">Fill out the form below and our team will get back to you within 24 hours.</p>
    </div>

    <div class="form-success @if(session('success')) show @endif" id="formSuccess">
      <div class="check">✓</div>
      <h3>Thank you!</h3>
      <p id="formSuccessMessage">{{ session('success') ?? 'Thank you for your inquiry! We will get back to you soon.' }}</p>
    </div>

    <form method="POST" action="{{ route('contact.store') }}" class="contact-form" id="contactForm">
      @csrf
      <div class="form-row">
        <div>
          <label for="name">Full Name</label>
          <input type="text" name="name" id="name" required placeholder="John Doe" value="{{ old('name') }}">
        </div>
        <div>
          <label for="email">Email</label>
          <input type="email" name="email" id="email" required placeholder="john@example.com" value="{{ old('email') }}">
        </div>
      </div>
      <div class="form-row">
        <div>
          <label for="phone">Phone</label>
          <input type="tel" name="phone" id="phone" placeholder="+1 (555) 000-0000" value="{{ old('phone') }}">
        </div>
        <div>
          <label for="service">I'm Interested In</label>
          <select name="service" id="service">
            <option value="">— Select an option —</option>
            <option value="Personal Productivity" @selected(old('service') === 'Personal Productivity')>Personal Productivity</option>
            <option value="Team Productivity" @selected(old('service') === 'Team Productivity')>Team Productivity</option>
            <option value="AI Voice" @selected(old('service') === 'AI Voice')>AI Voice</option>
            <option value="Reporting" @selected(old('service') === 'Reporting')>Reporting</option>
            <option value="Other" @selected(old('service') === 'Other')>Other</option>
          </select>
        </div>
      </div>
      <div>
        <label for="message">Message</label>
        <textarea name="message" id="message" required placeholder="Tell us about your needs...">{{ old('message') }}</textarea>
      </div>
      <button type="submit" class="btn-primary btn-lg">Send Inquiry →</button>
    </form>
  </div>
</section>

<!-- ══ FOOTER ══ -->
<footer>
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <a href="#" class="footer-brand-name">Goal<span>Chaser</span></a>
        <p>AI-powered productivity for individuals and teams. Intelligent task management, voice accountability, team follow-ups, blocker detection, and productivity reporting.</p>
        <div class="footer-social">
          <a href="#" aria-label="Website"><svg class="icon"><use href="#icon-globe"/></svg></a>
          <a href="#" aria-label="Email"><svg class="icon"><use href="#icon-mail"/></svg></a>
          <a href="#" aria-label="LinkedIn"><svg class="icon"><use href="#icon-briefcase"/></svg></a>
        </div>
      </div>
      <div class="footer-col">
        <h4>Product</h4>
        <ul>
          <li><a href="#individuals">Personal Productivity</a></li>
          <li><a href="#teams">Team Productivity</a></li>
          <li><a href="#voice">AI Voice</a></li>
          <li><a href="#intelligence">Reporting</a></li>
          <li><a href="#built-for">Built For</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Company</h4>
        <ul>
          <li><a href="#about">About</a></li>
          <li><a href="#contact">Contact</a></li>
          <li><a href="#">Privacy</a></li>
          <li><a href="#">Terms</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Account</h4>
        <ul>
          <li><a href="#">Sign In</a></li>
          <li><a href="#cta">Get Started</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© 2026 GoalChaser. All rights reserved.</p>
      <p>Powered by <a href="https://egeniuscare.com" target="_blank">eGeniusCare</a></p>
    </div>
  </div>
</footer>

<div class="modal-overlay" id="comingSoonModal">
  <div class="modal-box">
    <button class="modal-close" id="modalClose">&times;</button>
    <div class="modal-icon">🚀</div>
    <h3>Coming Soon</h3>
    <p>This service is currently in development. We'll announce it here as soon as it launches!</p>
  </div>
</div>

<script>
  const navbar = document.getElementById('navbar');
  const hamburger = document.getElementById('hamburger');
  const mobileMenu = document.getElementById('mobileMenu');

  window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 40);
  });

  hamburger.addEventListener('click', () => {
    mobileMenu.classList.toggle('open');
  });

  mobileMenu.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => mobileMenu.classList.remove('open'));
  });

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

  document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const target = document.querySelector(a.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  const modal = document.getElementById('comingSoonModal');
  const modalClose = document.getElementById('modalClose');

  document.querySelectorAll('.service-card').forEach(card => {
    card.addEventListener('click', function(e) {
      if (this.querySelector('.badge-ribbon')) {
        e.preventDefault();
        modal.classList.add('open');
      }
    });
  });

  modal.addEventListener('click', function(e) {
    if (e.target === this || e.target === modalClose) {
      this.classList.remove('open');
    }
  });

  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') modal.classList.remove('open');
  });

  const techSupport = document.querySelector('.service-card:last-child');
  if (techSupport) {
    techSupport.style.cursor = 'pointer';
    techSupport.addEventListener('click', function() {
      const contact = document.getElementById('contact');
      if (contact) contact.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
  }

  const formSuccess = document.querySelector('.form-success');
  if (formSuccess && formSuccess.classList.contains('show')) {
    setTimeout(() => {
      formSuccess.style.transition = 'opacity 0.5s';
      formSuccess.style.opacity = '0';
      setTimeout(() => formSuccess.classList.remove('show'), 500);
    }, 5000);
  }

  const contactForm = document.getElementById('contactForm');
  if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const formData = new FormData(this);
      const submitBtn = this.querySelector('button[type="submit"]');
      submitBtn.disabled = true;
      submitBtn.textContent = 'Sending...';
      fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
      })
        .then(r => r.json().then(data => ({ ok: r.ok, status: r.status, data })))
        .then(({ ok, status, data }) => {
          if (ok) {
            this.style.display = 'none';
            formSuccess.classList.add('show');
            formSuccess.style.opacity = '1';
            document.getElementById('formSuccessMessage').textContent = data.message;
          } else if (status === 422 && data.errors) {
            let msg = Object.values(data.errors).flat().join('\n');
            alert(msg);
          } else {
            alert('Something went wrong. Please try again.');
          }
        })
        .catch(() => alert('Network error. Please try again.'))
        .finally(() => {
          submitBtn.disabled = false;
          submitBtn.textContent = 'Send Inquiry →';
        });
    });
  }
</script>
</body>
</html>
