<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dialer.best — Voice Infrastructure & AI Automation</title>
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
      height: 72px;
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
    }
    @media (max-width: 900px) {
      .overview-grid { grid-template-columns: 1fr; }
      .product-block { grid-template-columns: 1fr; gap: 2.5rem; }
      .product-block .flow-card-col { order: -1; }
      .process-timeline { grid-template-columns: 1fr 1fr; }
      .process-timeline::before { display: none; }
      .footer-grid { grid-template-columns: 1fr 1fr; }
      .hero-stats { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 640px) {
      section { padding: 4rem 0; }
      .services-grid { grid-template-columns: repeat(2, 1fr); }
      .solutions-grid { grid-template-columns: repeat(2, 1fr); }
      .why-grid { grid-template-columns: 1fr 1fr; }
      .process-timeline { grid-template-columns: 1fr; }
      .footer-grid { grid-template-columns: 1fr; gap: 2rem; }
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
</svg>

<!-- ══ NAV ══ -->
<nav id="navbar">
  <div class="nav-inner">
    <a href="#" class="nav-logo">Dialer<span>.best</span></a>
    <ul class="nav-links">
      <li><a href="#products">Products</a></li>
      <li><a href="#services">Services</a></li>
      <li><a href="#solutions">Solutions</a></li>
      <li><a href="#about">About</a></li>
      <li><a href="#cta">Contact</a></li>
    </ul>
    <div class="nav-actions">
      <a href="#" class="btn-ghost">Sign in</a>
      <a href="#cta" class="btn-primary">Book Demo →</a>
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
    <a href="#products">Products</a>
    <a href="#services">Services</a>
    <a href="#solutions">Solutions</a>
    <a href="#about">About</a>
    <a href="#cta">Contact</a>
    <div class="mobile-actions">
      <a href="#" class="btn-outline">Sign in</a>
      <a href="#cta" class="btn-primary btn-lg">Book Demo →</a>
    </div>
  </div>
</nav>

<!-- ══ HERO ══ -->
<section id="hero">
  <div class="container">
    <div class="hero-grid">
      <div>
        <h1 class="hero-h1 reveal reveal-delay-1">
          The operating system for <span class="accent">voice-driven</span> businesses
        </h1>
        <p class="hero-lead reveal reveal-delay-2">
          Deploy cloud dialers, AI voice agents, workforce automation, and business communication infrastructure from a single platform.
        </p>
        <div class="hero-cta reveal reveal-delay-3">
          <a href="#cta" class="btn-primary btn-lg btn-accent">Book a Demo →</a>
          <a href="#products" class="btn-outline btn-lg">Explore Products</a>
        </div>
        <div class="hero-stats reveal">
          <div>
            <div class="hero-stat-value">Enterprise</div>
            <div class="hero-stat-label">Infrastructure</div>
          </div>
          <div>
            <div class="hero-stat-value accent">AI</div>
            <div class="hero-stat-label">Automation</div>
          </div>
          <div>
            <div class="hero-stat-value">Global</div>
            <div class="hero-stat-label">Voice Network</div>
          </div>
          <div>
            <div class="hero-stat-value blue">24/7</div>
            <div class="hero-stat-label">Support</div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ══ OVERVIEW ══ -->
<section id="overview">
  <div class="container">
    <div class="section-header">
      <div class="eyebrow">Overview</div>
      <h2 class="section-title">More than a <span class="accent">dialer company</span></h2>
      <p class="section-sub">Telecom infrastructure, AI-powered voice automation, and workforce productivity systems — unified in one ecosystem.</p>
    </div>
    <div class="overview-grid">
      <div class="overview-card reveal">
        <div class="overview-icon accent"><svg class="icon"><use href="#icon-antenna"/></svg></div>
        <h3>Voice Infrastructure</h3>
        <p>Reliable communication systems built for scale. Cloud PBX, SIP trunking, and enterprise dialer platforms that handle millions of calls.</p>
      </div>
      <div class="overview-card reveal reveal-delay-1">
        <div class="overview-icon blue"><svg class="icon"><use href="#icon-ai"/></svg></div>
        <h3>AI Automation</h3>
        <p>AI-powered voice agents, intelligent call routing, and workflow automation that transform how your team communicates and operates.</p>
      </div>
      <div class="overview-card reveal reveal-delay-2">
        <div class="overview-icon mixed"><svg class="icon"><use href="#icon-chart"/></svg></div>
        <h3>Workforce Intelligence</h3>
        <p>Real-time visibility into productivity and execution. AI-driven reporting, task management, and performance tracking for modern teams.</p>
      </div>
    </div>
  </div>
</section>

<!-- ══ PRODUCTS ══ -->
<section id="products">
  <div class="container">
    <div class="section-header">
      <div class="eyebrow">Products</div>
      <h2 class="section-title">AI products built for <span class="blue">execution</span></h2>
      <p class="section-sub">Purpose-built tools designed to improve accountability, productivity, and business performance.</p>
    </div>

    <!-- Product 01: AI task planner -->
    <div class="product-block">
      <div class="reveal">
        <span class="product-tag">Product 01</span>
        <div class="product-name">AI <span class="accent">task </span>planner</div>
        <div class="product-tagline">Your AI accountability partner</div>
        <p class="product-desc">AI task planner uses AI voice interactions to keep users focused on priorities, follow through on commitments, and maintain daily productivity — without the noise.</p>
        <ul class="feature-list">
          <li>Voice follow-ups</li>
          <li>Daily planning</li>
          <li>Task accountability</li>
          <li>Habit reinforcement</li>
          <li>Performance insights</li>
        </ul>
        <a href="#" class="btn-primary btn-accent">Learn More →</a>
      </div>
      <div class="flow-card-col reveal reveal-delay-1">
        <div class="flow-card accent-top">
          <div class="flow-step">
            <div class="flow-step-num num-accent">1</div>
            <div class="flow-step-text">
              <div class="flow-step-title">User creates tasks</div>
              <div class="flow-step-sub">Voice or text input</div>
            </div>
            <span class="flow-step-icon"><svg class="icon"><use href="#icon-check"/></svg></span>
          </div>
          <div class="flow-step">
            <div class="flow-step-num num-ink">2</div>
            <div class="flow-step-text">
              <div class="flow-step-title">AI schedules follow-up calls</div>
              <div class="flow-step-sub">Intelligent timing</div>
            </div>
            <span class="flow-step-icon"><svg class="icon"><use href="#icon-calendar"/></svg></span>
          </div>
          <div class="flow-step">
            <div class="flow-step-num num-blue">3</div>
            <div class="flow-step-text">
              <div class="flow-step-title">AI checks progress</div>
              <div class="flow-step-sub">Natural voice conversations</div>
            </div>
            <span class="flow-step-icon"><svg class="icon"><use href="#icon-phone"/></svg></span>
          </div>
          <div class="flow-step">
            <div class="flow-step-num num-accent">4</div>
            <div class="flow-step-text">
              <div class="flow-step-title">Task completion increases</div>
              <div class="flow-step-sub">Accountability loop</div>
            </div>
            <span class="flow-step-icon"><svg class="icon"><use href="#icon-chart"/></svg></span>
          </div>
          <div class="flow-step">
            <div class="flow-step-num num-ink">5</div>
            <div class="flow-step-text">
              <div class="flow-step-title">Reports and insights</div>
              <div class="flow-step-sub">Performance analytics</div>
            </div>
            <span class="flow-step-icon"><svg class="icon"><use href="#icon-chart"/></svg></span>
          </div>
        </div>
      </div>
    </div>

    <!-- Product 02: AI Team Manager -->
    <div class="product-block">
      <div class="flow-card-col reveal">
        <div class="flow-card blue-top">
          <div class="flow-step">
            <div class="flow-step-num num-blue">1</div>
            <div class="flow-step-text">
              <div class="flow-step-title">Manager creates objectives</div>
              <div class="flow-step-sub">Define goals and KPIs</div>
            </div>
            <span class="flow-step-icon"><svg class="icon"><use href="#icon-target"/></svg></span>
          </div>
          <div class="flow-step">
            <div class="flow-step-num num-ink">2</div>
            <div class="flow-step-text">
              <div class="flow-step-title">AI distributes tasks</div>
              <div class="flow-step-sub">Intelligent assignment</div>
            </div>
            <span class="flow-step-icon"><svg class="icon"><use href="#icon-check"/></svg></span>
          </div>
          <div class="flow-step">
            <div class="flow-step-num num-accent">3</div>
            <div class="flow-step-text">
              <div class="flow-step-title">AI calls employees</div>
              <div class="flow-step-sub">Automated check-ins</div>
            </div>
            <span class="flow-step-icon"><svg class="icon"><use href="#icon-phone"/></svg></span>
          </div>
          <div class="flow-step">
            <div class="flow-step-num num-accent">4</div>
            <div class="flow-step-text">
              <div class="flow-step-title">Updates collected</div>
              <div class="flow-step-sub">Real-time status</div>
            </div>
            <span class="flow-step-icon"><svg class="icon"><use href="#icon-refresh"/></svg></span>
          </div>
          <div class="flow-step">
            <div class="flow-step-num num-blue">5</div>
            <div class="flow-step-text">
              <div class="flow-step-title">Progress analyzed</div>
              <div class="flow-step-sub">AI-driven insights</div>
            </div>
            <span class="flow-step-icon"><svg class="icon"><use href="#icon-search"/></svg></span>
          </div>
          <div class="flow-step">
            <div class="flow-step-num num-ink">6</div>
            <div class="flow-step-text">
              <div class="flow-step-title">Executive dashboard</div>
              <div class="flow-step-sub">Full visibility</div>
            </div>
            <span class="flow-step-icon"><svg class="icon"><use href="#icon-monitor"/></svg></span>
          </div>
        </div>
      </div>
      <div class="reveal reveal-delay-1">
        <span class="product-tag blue-tag">Product 02</span>
        <div class="product-name">AI <span class="blue">Team</span> Manager</div>
        <div class="product-tagline">AI workforce management platform</div>
        <p class="product-desc">AI Team Manager automates team follow-ups, task assignments, employee reporting, and productivity monitoring through intelligent AI voice interactions.</p>
        <ul class="feature-list blue-checks">
          <li>Automated check-ins</li>
          <li>AI task assignment</li>
          <li>Productivity analytics</li>
          <li>Executive reporting</li>
          <li>Department workflows</li>
          <li>Performance tracking</li>
        </ul>
        <a href="#" class="btn-primary btn-accent">Learn More →</a>
      </div>
    </div>
  </div>
</section>

<!-- ══ SERVICES ══ -->
<section id="services">
  <div class="container">
    <div class="section-header">
      <div class="eyebrow">Services</div>
      <h2 class="section-title">Voice infrastructure &amp; <span class="accent">telecom services</span></h2>
      <p class="section-sub">Enterprise-grade communication infrastructure and managed telecom services.</p>
    </div>
    <div class="services-grid">
      <div class="service-card reveal">
        <div class="service-card-icon accent"><svg class="icon"><use href="#icon-phone"/></svg></div>
        <h4>Hosted VICIdial</h4>
        <p>Enterprise dialer platform with full support.</p>
        <span class="badge-ribbon ribbon-1">Coming Soon</span>
      </div>
      <div class="service-card reveal reveal-delay-1">
        <div class="service-card-icon b"><svg class="icon"><use href="#icon-zap"/></svg></div>
        <h4>Predictive Dialers</h4>
        <p>AI-powered predictive calling algorithms.</p>
        <span class="badge-ribbon ribbon-2">Coming Soon</span>
      </div>
      <div class="service-card reveal reveal-delay-2">
        <div class="service-card-icon accent"><svg class="icon"><use href="#icon-rocket"/></svg></div>
        <h4>Power Dialers</h4>
        <p>High-velocity dialing for maximum connects.</p>
        <span class="badge-ribbon ribbon-3">Coming Soon</span>
      </div>
      <div class="service-card reveal reveal-delay-3">
        <div class="service-card-icon b"><svg class="icon"><use href="#icon-zap"/></svg></div>
        <h4>Progressive Dialers</h4>
        <p>Agent-based progressive call distribution.</p>
        <span class="badge-ribbon ribbon-4">Coming Soon</span>
      </div>
      <div class="service-card reveal">
        <div class="service-card-icon accent"><svg class="icon"><use href="#icon-eye"/></svg></div>
        <h4>Preview Dialers</h4>
        <p>Agent review before connecting calls.</p>
        <span class="badge-ribbon ribbon-5">Coming Soon</span>
      </div>
      <div class="service-card reveal reveal-delay-1">
        <div class="service-card-icon b"><svg class="icon"><use href="#icon-cloud"/></svg></div>
        <h4>Cloud PBX</h4>
        <p>Full-featured cloud phone system.</p>
        <span class="badge-ribbon ribbon-6">Coming Soon</span>
      </div>
      <div class="service-card reveal reveal-delay-2">
        <div class="service-card-icon accent"><svg class="icon"><use href="#icon-link"/></svg></div>
        <h4>SIP Trunking</h4>
        <p>Scalable SIP connectivity worldwide.</p>
        <span class="badge-ribbon ribbon-7">Coming Soon</span>
      </div>
      <div class="service-card reveal reveal-delay-3">
        <div class="service-card-icon b"><svg class="icon"><use href="#icon-antenna"/></svg></div>
        <h4>VoIP Termination</h4>
        <p>High-quality VoIP termination routes.</p>
        <span class="badge-ribbon ribbon-8">Coming Soon</span>
      </div>
      <div class="service-card reveal">
        <div class="service-card-icon accent"><svg class="icon"><use href="#icon-megaphone"/></svg></div>
        <h4>Voice Broadcasting</h4>
        <p>Mass notification and broadcast system.</p>
        <span class="badge-ribbon ribbon-9">Coming Soon</span>
      </div>
      <div class="service-card reveal reveal-delay-1">
        <div class="service-card-icon b"><svg class="icon"><use href="#icon-zap"/></svg></div>
        <h4>Click-to-Call</h4>
        <p>One-click calling from any platform.</p>
        <span class="badge-ribbon ribbon-10">Coming Soon</span>
      </div>
      <div class="service-card reveal reveal-delay-2">
        <div class="service-card-icon accent"><svg class="icon"><use href="#icon-ai"/></svg></div>
        <h4>AI Voice Agents</h4>
        <p>Intelligent AI-powered voice assistants.</p>
        <span class="badge-ribbon ribbon-11">Coming Soon</span>
      </div>
      <div class="service-card reveal reveal-delay-3">
        <div class="service-card-icon b"><svg class="icon"><use href="#icon-link"/></svg></div>
        <h4>CRM Integrations</h4>
        <p>Seamless CRM and tool integrations.</p>
        <span class="badge-ribbon ribbon-12">Coming Soon</span>
      </div>
      <div class="service-card reveal">
        <div class="service-card-icon accent"><svg class="icon"><use href="#icon-tools"/></svg></div>
        <h4>Custom Solutions</h4>
        <p>Tailored telecom solutions for your needs.</p>
        <span class="badge-ribbon ribbon-13">Coming Soon</span>
      </div>
      <div class="service-card reveal reveal-delay-1">
        <div class="service-card-icon b"><svg class="icon"><use href="#icon-monitor"/></svg></div>
        <h4>Managed Infrastructure</h4>
        <p>Fully managed voice infrastructure.</p>
        <span class="badge-ribbon ribbon-14">Coming Soon</span>
      </div>
      <div class="service-card reveal reveal-delay-2">
        <div class="service-card-icon accent"><svg class="icon"><use href="#icon-antenna"/></svg></div>
        <h4>Carrier Services</h4>
        <p>Direct carrier relationships and routes.</p>
        <span class="badge-ribbon ribbon-15">Coming Soon</span>
      </div>
      <div class="service-card reveal reveal-delay-3">
        <div class="service-card-icon b"><svg class="icon"><use href="#icon-headset"/></svg></div>
        <h4>Technical Support</h4>
        <p>24/7 expert technical support team.</p>
      </div>
    </div>
  </div>
</section>

<!-- ══ SOLUTIONS ══ -->
<section id="solutions">
  <div class="container">
    <div class="section-header">
      <div class="eyebrow">Solutions</div>
      <h2 class="section-title">Built for <span class="blue">every team</span></h2>
    </div>
    <div class="solutions-grid">
      <div class="solution-card reveal">
        <div class="icon"><svg class="icon"><use href="#icon-phone"/></svg></div>
        <h4>Call Centers</h4>
        <p>Enterprise dialer solutions for high-volume operations.</p>
      </div>
      <div class="solution-card reveal reveal-delay-1">
        <div class="icon"><svg class="icon"><use href="#icon-briefcase"/></svg></div>
        <h4>Sales Teams</h4>
        <p>Power dialers and CRM integration for sales productivity.</p>
      </div>
      <div class="solution-card reveal reveal-delay-2">
        <div class="icon"><svg class="icon"><use href="#icon-plus"/></svg></div>
        <h4>Healthcare</h4>
        <p>HIPAA-compliant voice and communication infrastructure.</p>
      </div>
      <div class="solution-card reveal reveal-delay-3">
        <div class="icon"><svg class="icon"><use href="#icon-shield"/></svg></div>
        <h4>Insurance</h4>
        <p>Automated dialing and compliance-ready solutions.</p>
      </div>
      <div class="solution-card reveal">
        <div class="icon"><svg class="icon"><use href="#icon-home"/></svg></div>
        <h4>Real Estate</h4>
        <p>Voice broadcasting and lead management systems.</p>
      </div>
      <div class="solution-card reveal reveal-delay-1">
        <div class="icon"><svg class="icon"><use href="#icon-search"/></svg></div>
        <h4>Recruitment</h4>
        <p>AI-powered candidate outreach and follow-up automation.</p>
      </div>
      <div class="solution-card reveal reveal-delay-2">
        <div class="icon"><svg class="icon"><use href="#icon-globe"/></svg></div>
        <h4>BPO Companies</h4>
        <p>Scalable infrastructure for global BPO operations.</p>
      </div>
      <div class="solution-card reveal reveal-delay-3">
        <div class="icon"><svg class="icon"><use href="#icon-cloud"/></svg></div>
        <h4>SaaS Companies</h4>
        <p>Voice API integration and communication platforms.</p>
      </div>
      <div class="solution-card reveal">
        <div class="icon"><svg class="icon"><use href="#icon-building"/></svg></div>
        <h4>Remote Teams</h4>
        <p>Cloud PBX and collaboration tools for distributed teams.</p>
      </div>
      <div class="solution-card reveal reveal-delay-1">
        <div class="icon"><svg class="icon"><use href="#icon-megaphone"/></svg></div>
        <h4>Marketing Agencies</h4>
        <p>Voice broadcasting and campaign management tools.</p>
      </div>
    </div>
  </div>
</section>

<!-- ══ WHY US ══ -->
<section id="why">
  <div class="container">
    <div class="section-header">
      <div class="eyebrow">Why Choose Us</div>
      <h2 class="section-title">Built for scale. Designed for <span class="accent">productivity</span></h2>
    </div>
    <div class="why-grid">
      <div class="why-card reveal">
        <div class="why-icon accent"><svg class="icon"><use href="#icon-mic"/></svg></div>
        <h4>Voice first</h4>
        <p>Natural voice interactions drive everything we build.</p>
      </div>
      <div class="why-card reveal reveal-delay-1">
        <div class="why-icon b"><svg class="icon"><use href="#icon-zap"/></svg></div>
        <h4>AI native</h4>
        <p>Built from the ground up with AI at the core.</p>
      </div>
      <div class="why-card reveal reveal-delay-2">
        <div class="why-icon accent"><svg class="icon"><use href="#icon-check"/></svg></div>
        <h4>Enterprise ready</h4>
        <p>Security, compliance, and reliability built in.</p>
      </div>
      <div class="why-card reveal reveal-delay-3">
        <div class="why-icon b"><svg class="icon"><use href="#icon-globe"/></svg></div>
        <h4>Global reach</h4>
        <p>Worldwide voice network and global coverage.</p>
      </div>
      <div class="why-card reveal">
        <div class="why-icon accent"><svg class="icon"><use href="#icon-sliders"/></svg></div>
        <h4>Customizable</h4>
        <p>Tailored solutions for any workflow.</p>
      </div>
      <div class="why-card reveal reveal-delay-1">
        <div class="why-icon b"><svg class="icon"><use href="#icon-chart"/></svg></div>
        <h4>Actionable insights</h4>
        <p>Data-driven decisions with real analytics.</p>
      </div>
      <div class="why-card reveal reveal-delay-2">
        <div class="why-icon accent"><svg class="icon"><use href="#icon-rocket"/></svg></div>
        <h4>Fast deployment</h4>
        <p>Get up and running in days, not months.</p>
      </div>
      <div class="why-card reveal reveal-delay-3">
        <div class="why-icon b"><svg class="icon"><use href="#icon-shield"/></svg></div>
        <h4>99.9% uptime</h4>
        <p>Enterprise-grade reliability you can count on.</p>
      </div>
    </div>
  </div>
</section>

<!-- ══ PROCESS ══ -->
<section id="process">
  <div class="container">
    <div class="section-header">
      <div class="eyebrow">Process</div>
      <h2 class="section-title">From infrastructure to <span class="blue">automation</span></h2>
    </div>
    <div class="process-timeline">
      <div class="process-step reveal">
        <div class="process-step-num"><svg class="icon"><use href="#icon-search"/></svg></div>
        <div class="process-step-label">Step 01</div>
        <h4>Discover</h4>
        <p>Understand business requirements and identify the right solutions.</p>
      </div>
      <div class="process-step reveal reveal-delay-1">
        <div class="process-step-num"><svg class="icon"><use href="#icon-rocket"/></svg></div>
        <div class="process-step-label">Step 02</div>
        <h4>Deploy</h4>
        <p>Configure voice systems, AI workflows, and team integrations.</p>
      </div>
      <div class="process-step reveal reveal-delay-2">
        <div class="process-step-num"><svg class="icon"><use href="#icon-chart"/></svg></div>
        <div class="process-step-label">Step 03</div>
        <h4>Optimize</h4>
        <p>Improve productivity and communication with AI-driven insights.</p>
      </div>
      <div class="process-step reveal reveal-delay-3">
        <div class="process-step-num"><svg class="icon"><use href="#icon-link"/></svg></div>
        <div class="process-step-label">Step 04</div>
        <h4>Scale</h4>
        <p>Expand operations confidently with reliable infrastructure.</p>
      </div>
    </div>
  </div>
</section>

<!-- ══ VISION ══ -->
<section id="vision">
  <div class="container">
    <div class="vision-inner reveal">
      <div class="vision-eyebrow">Vision</div>
      <h2 class="vision-title">
        The future of business communication<br>
        is <span class="accent">autonomous</span>
      </h2>
      <p class="vision-lead">Businesses should not depend on endless meetings, manual follow-ups, or constant supervision.</p>
      <p class="vision-highlight">Dialer.best is building a future where voice, AI, and automation work together to drive productivity, accountability, and growth.</p>
      <a href="#cta" class="btn-white">Join the Future →</a>
    </div>
  </div>
</section>

<!-- ══ ABOUT ══ -->
<section id="about">
  <div class="container">
    <div class="section-header">
      <div class="eyebrow">About</div>
      <h2 class="section-title">Powered by <span class="accent">eGeniusCare</span></h2>
      <p class="section-sub">Dialer.best is the communications and automation division of eGeniusCare, focused on building innovative voice technologies, telecom infrastructure, and AI-driven productivity platforms.</p>
    </div>
    <div class="ecosystem reveal">
      <div class="eco-node top">eGeniusCare</div>
      <div class="eco-arrow"></div>
      <div class="eco-node mid">Dialer.best</div>
      <div class="eco-arrow"></div>
      <div class="eco-leaves">
        <span class="eco-leaf accent">AI task planner</span>
        <span class="eco-leaf b">AI Team Manager</span>
        <span class="eco-leaf i">Voice Infra</span>
        <span class="eco-leaf accent">AI Agents</span>
        <span class="eco-leaf b">Telecom Services</span>
      </div>
    </div>
  </div>
</section>

<!-- ══ CTA ══ -->
<section id="cta">
  <div class="container">
    <div class="cta-inner reveal">
      <div class="eyebrow" style="margin: 0 auto 1.5rem;">Get Started</div>
      <h2 class="cta-title">Ready to modernize your<br><span class="accent">business operations?</span></h2>
      <p class="cta-lead">Cloud dialers, telecom infrastructure, AI voice agents, workforce automation, and productivity systems — all under one ecosystem.</p>
      <div class="cta-actions">
        <a href="#" class="btn-primary btn-lg btn-accent">Book a Demo →</a>
        <a href="#" class="btn-outline btn-lg">Talk to an Expert</a>
      </div>
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

    @if (session('success'))
      <div class="form-success show">
        <div class="check">✓</div>
        <h3>Thank you!</h3>
        <p>{{ session('success') }}</p>
      </div>
    @endif

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
          <label for="service">Service Interested In</label>
          <select name="service" id="service">
            <option value="">— Select a service —</option>
            <option value="Hosted VICIdial" @selected(old('service') === 'Hosted VICIdial')>Hosted VICIdial</option>
            <option value="Predictive Dialers" @selected(old('service') === 'Predictive Dialers')>Predictive Dialers</option>
            <option value="Cloud PBX" @selected(old('service') === 'Cloud PBX')>Cloud PBX</option>
            <option value="SIP Trunking" @selected(old('service') === 'SIP Trunking')>SIP Trunking</option>
            <option value="AI Voice Agents" @selected(old('service') === 'AI Voice Agents')>AI Voice Agents</option>
            <option value="Technical Support" @selected(old('service') === 'Technical Support')>Technical Support</option>
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
        <a href="#" class="footer-brand-name">Dialer<span>.best</span></a>
        <p>Voice Infrastructure &amp; AI Automation Platform. Cloud dialers, AI agents, workforce automation, and telecom solutions — all under one ecosystem.</p>
        <div class="footer-social">
          <a href="#" aria-label="Website"><svg class="icon"><use href="#icon-globe"/></svg></a>
          <a href="#" aria-label="Email"><svg class="icon"><use href="#icon-mail"/></svg></a>
          <a href="#" aria-label="LinkedIn"><svg class="icon"><use href="#icon-briefcase"/></svg></a>
        </div>
      </div>
      <div class="footer-col">
        <h4>Products</h4>
        <ul>
          <li><a href="#">AI task planner</a></li>
          <li><a href="#">AI Team Manager</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Services</h4>
        <ul>
          <li><a href="#">Hosted VICIdial</a></li>
          <li><a href="#">Cloud PBX</a></li>
          <li><a href="#">SIP Trunking</a></li>
          <li><a href="#">AI Voice Agents</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Company</h4>
        <ul>
          <li><a href="#">About</a></li>
          <li><a href="#">Contact</a></li>
          <li><a href="#">Privacy</a></li>
          <li><a href="#">Terms</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© 2026 Dialer.best. All rights reserved.</p>
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
  if (formSuccess) {
    setTimeout(() => {
      formSuccess.style.transition = 'opacity 0.5s';
      formSuccess.style.opacity = '0';
      setTimeout(() => formSuccess.classList.remove('show'), 500);
    }, 5000);
  }
</script>
</body>
</html>
