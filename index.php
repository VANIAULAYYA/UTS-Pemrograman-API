<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="description" content="Platform API untuk mengelola data pasien, dokter, dan appointment secara real-time">
    <title>Hospital Management System - API Hub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            padding: 20px;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, #1a73e8, #0d5bbf);
            padding: 15px 30px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar h1 {
            color: white;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-dashboard-header {
            background: white;
            padding: 20px 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            flex-wrap: wrap;
            gap: 15px;
        }

        .user-dashboard-profile {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            font-size: 35px;
            background: #f0f4f8;
            border-radius: 50%;
            height: 60px;
            width: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-details {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .user-greeting {
            font-size: 1.15rem;
            font-weight: 600;
            color: #333;
        }

        .user-meta {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .role-badge {
            background: #e8f0fe;
            color: #1a73e8;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .api-key-badge {
            background: #f1f3f4;
            color: #5f6368;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-family: monospace;
            border: 1px solid #dadce0;
            cursor: pointer;
            transition: 0.2s;
        }

        .api-key-badge:hover {
            background: #e4e6e8;
            border-color: #bdc1c6;
            color: #202124;
        }

        .logout-btn-new {
            background: #ffeeee;
            color: #d93025;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.2s;
            border: 1px solid #fad2cf;
            display: inline-block;
        }

        .logout-btn-new:hover {
            background: #fad2cf;
        }

        /* ===================== LANDING PAGE (FULL SCREEN) ===================== */
        #landingPage {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #1a73e8, #0d5bbf);
            padding: 60px 20px;
            margin: -20px -20px 0 -20px;
            width: calc(100% + 40px);
        }

        .landing-inner {
            margin: auto;
            max-width: 960px;
            width: 100%;
            text-align: center;
            animation: landingFadeIn 1s ease-out;
        }

        @keyframes landingFadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .landing-emoji {
            font-size: 4rem;
            margin-bottom: 10px;
            display: block;
            animation: floatEmoji 3s ease-in-out infinite;
        }

        @keyframes floatEmoji {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }

        .landing-inner h1 {
            font-size: 2.8rem;
            font-weight: 900;
            color: #ffffff;
            margin-bottom: 14px;
            line-height: 1.15;
            letter-spacing: -0.5px;
        }

        .landing-inner h1 span {
            color: #ffffff;
            -webkit-text-fill-color: #ffffff;
        }

        .landing-subtitle {
            font-size: 1.15rem;
            color: rgba(255,255,255,0.9);
            margin-bottom: 10px;
            font-weight: 400;
            line-height: 1.7;
        }

        .landing-desc {
            font-size: 0.95rem;
            color: rgba(255,255,255,0.75);
            margin-bottom: 35px;
            line-height: 1.7;
            max-width: 680px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Info Cards Grid */
        .landing-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 35px;
        }

        .landing-card {
            background: white;
            border: 1px solid #eef2f6;
            border-radius: 18px;
            padding: 28px 18px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: default;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .landing-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(26,115,232,0.15);
        }

        .landing-card .card-icon {
            font-size: 2.2rem;
            margin-bottom: 12px;
            display: block;
        }

        .landing-card h3 {
            color: #333;
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .landing-card p {
            color: #5f6368;
            font-size: 0.82rem;
            line-height: 1.4;
        }

        /* Access Box */
        .landing-access-box {
            background: #fff4e5;
            border-left: 5px solid #ffa000;
            border-radius: 12px;
            padding: 20px 28px;
            margin-bottom: 35px;
            color: #663c00;
            font-size: 0.92rem;
            line-height: 1.7;
            display: inline-block;
            text-align: left;
        }

        .landing-access-box strong {
            color: #663c00;
        }

        /* CTA Buttons */
        .landing-cta {
            display: flex;
            justify-content: center;
            gap: 18px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .cta-login {
            padding: 16px 48px;
            background: white;
            color: #1a73e8;
            border: none;
            border-radius: 50px;
            font-size: 1.05rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.25s, box-shadow 0.25s;
            letter-spacing: 0.3px;
        }

        .cta-login:hover {
            transform: scale(1.06);
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
        }

        .cta-register {
            padding: 16px 48px;
            background: transparent;
            color: #ffffff;
            border: 2px solid rgba(255,255,255,0.6);
            border-radius: 50px;
            font-size: 1.05rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.25s, background 0.25s, border-color 0.25s;
            letter-spacing: 0.3px;
        }

        .cta-register:hover {
            transform: scale(1.06);
            background: rgba(255,255,255,0.15);
            border-color: #ffffff;
        }

        /* API Preview */
        .landing-preview {
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 14px;
            padding: 22px 28px;
            text-align: left;
            max-width: 520px;
            margin: 0 auto;
        }

        .landing-preview h4 {
            color: rgba(255,255,255,0.7);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 14px;
        }

        .preview-line {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 0;
            font-family: 'Monaco', 'Menlo', 'Consolas', monospace;
            font-size: 0.82rem;
        }

        .preview-method {
            padding: 3px 10px;
            border-radius: 6px;
            font-size: 0.68rem;
            font-weight: 700;
            color: #fff;
            min-width: 55px;
            text-align: center;
        }

        .preview-method.get    { background: #2da44e; }
        .preview-method.post   { background: #cf222e; }
        .preview-method.put    { background: #e36209; }
        .preview-method.delete { background: #6e40c9; }

        .preview-path {
            color: rgba(255,255,255,0.85);
        }

        /* Responsive Landing */
        @media (max-width: 900px) {
            .landing-cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 520px) {
            .landing-inner h1 {
                font-size: 1.8rem;
            }
            .landing-cards {
                grid-template-columns: 1fr;
            }
            .cta-login, .cta-register {
                padding: 14px 32px;
                font-size: 0.95rem;
            }
        }

        /* OLD Landing page classes (kept for backward compatibility) */
        #landing-page { max-width: 1100px; margin: 50px auto; padding: 20px; animation: fadeIn 0.8s ease-out; display: none; }
        .hero-box { background: white; padding: 60px 40px; border-radius: 24px; text-align: center; box-shadow: 0 15px 35px rgba(0,0,0,0.05); border: 1px solid #eef2f6; }
        .hero-box h1 { font-size: 2.8rem; color: #1a73e8; margin-bottom: 20px; font-weight: 800; }
        .hero-box p { font-size: 1.1rem; color: #5f6368; margin-bottom: 30px; line-height: 1.6; }
        .api-alert { background: #fff4e5; border-left: 5px solid #ffa000; color: #663c00; padding: 20px; border-radius: 12px; margin-bottom: 35px; display: inline-block; text-align: left; }
        .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px; margin-top: 40px; }
        .f-card { background: white; padding: 30px; border-radius: 18px; border: 1px solid #eef2f6; transition: 0.3s; text-align: center; }
        .f-card:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(26,115,232,0.1); }
        .f-card i { font-size: 2.5rem; margin-bottom: 15px; display: block; }
        .cta-group { display: flex; justify-content: center; gap: 15px; }
        .btn-main { padding: 15px 40px; background: #1a73e8; color: white; border: none; border-radius: 50px; font-weight: 600; cursor: pointer; transition: 0.3s; font-size: 1rem; }
        .btn-main:hover { background: #174ea6; transform: scale(1.05); }
        .btn-alt { padding: 15px 40px; background: white; color: #1a73e8; border: 2px solid #1a73e8; border-radius: 50px; font-weight: 600; cursor: pointer; transition: 0.3s; }

        /* Tab Navigation */
        .tab-container {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            flex-wrap: wrap;
            width: 100%;
        }

        .tab-btn {
            flex: 1;
            padding: 12px 24px;
            background: white;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            color: #555;
            transition: 0.3s;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            min-width: 150px;
        }

        .tab-btn:hover {
            background: #e8f0fe;
            color: #1a73e8;
        }

        .tab-btn.active {
            background: #1a73e8;
            color: white;
            box-shadow: 0 4px 12px rgba(26,115,232,0.3);
        }

        /* Stats Cards */
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        .stat-card h2 {
            font-size: 2rem;
            margin-bottom: 5px;
        }

        .stat-card p {
            color: #777;
            font-size: 0.8rem;
        }

        /* Warna berbeda tiap stat card */
        .stat-card.patients { border-top: 4px solid #1a73e8; }
        .stat-card.patients h2 { color: #1a73e8; }
        
        .stat-card.doctors { border-top: 4px solid #e36209; }
        .stat-card.doctors h2 { color: #e36209; }
        
        .stat-card.endpoints { border-top: 4px solid #2da44e; }
        .stat-card.endpoints h2 { color: #2da44e; }
        
        .stat-card.methods { border-top: 4px solid #cf222e; }
        .stat-card.methods h2 { color: #cf222e; }
        
        .stat-card.resources { border-top: 4px solid #6e40c9; }
        .stat-card.resources h2 { color: #6e40c9; }

        /* Main Section */
        .section {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .section-title {
            margin-bottom: 20px;
            color: #333;
            font-size: 1.3rem;
            padding-bottom: 10px;
            border-bottom: 2px solid #eef2f6;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        /* Search Box */
        .search-box {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .search-box input {
            padding: 8px 16px;
            border: 1px solid #ddd;
            border-radius: 25px;
            font-size: 13px;
            width: 220px;
            outline: none;
            transition: 0.2s;
        }

        .search-box input:focus {
            border-color: #1a73e8;
            box-shadow: 0 0 0 2px rgba(26,115,232,0.2);
        }

        .search-box button, .refresh-btn {
            padding: 8px 16px;
            background: #eef2f6;
            color: #333;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            transition: 0.2s;
        }

        .search-box button:hover, .refresh-btn:hover {
            background: #1a73e8;
            color: white;
        }

        /* Table */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f8f9fa;
            padding: 14px 16px;
            text-align: left;
            font-size: 0.8rem;
            font-weight: 600;
            color: #555;
            border-bottom: 2px solid #e0e4e8;
        }

        td {
            padding: 12px 16px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 0.85rem;
            color: #333;
        }

        tr:hover {
            background: #f5f9ff;
        }

        /* Badge */
        .badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            white-space: nowrap;
            display: inline-block;
        }

        .badge-male {
            background: #e3f2fd;
            color: #1a73e8;
        }

        .badge-female {
            background: #fce4ec;
            color: #e91e63;
        }

        /* Loading & Empty */
        .loading, .empty {
            text-align: center;
            padding: 40px;
            color: #aaa;
            font-size: 0.9rem;
        }

        /* Endpoint Card */
        .endpoints-container {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .endpoint-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            background: #fafbfc;
            border-radius: 12px;
            border: 1px solid #eef2f6;
            transition: all 0.2s;
        }

        .endpoint-card:hover {
            background: white;
            border-color: #d0d7de;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }

        .method {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            color: white;
            min-width: 65px;
            text-align: center;
            letter-spacing: 0.5px;
        }

        .method.get { background: #2da44e; }
        .method.post { background: #cf222e; }
        .method.put { background: #e36209; }
        .method.delete { background: #6e40c9; }

        .url {
            flex: 1;
            font-family: 'Monaco', 'Menlo', monospace;
            font-size: 0.75rem;
            color: #57606a;
            word-break: break-all;
        }

        .highlight-search {
            background-color: #ffe066;
            color: #111;
            padding: 1px 3px;
            border-radius: 4px;
            font-weight: 700;
        }

        .desc {
            color: #6e7781;
            font-size: 0.7rem;
            min-width: 140px;
        }

        .copy-btn, .try-btn {
            padding: 5px 12px;
            background: #eef2f6;
            color: #1f2328;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.7rem;
            font-weight: 500;
            transition: 0.2s;
        }

        .copy-btn:hover {
            background: #1a73e8;
            color: white;
        }

        .try-btn:hover {
            background: #e36209;
            color: white;
        }

        .resource-group {
            margin-bottom: 35px;
        }

        .resource-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e0e4e8;
            flex-wrap: wrap;
        }

        .resource-icon {
            font-size: 28px;
        }

        .resource-header h3 {
            font-size: 1.1rem;
            color: #2c3e50;
        }

        .resource-count {
            background: #e8f0fe;
            color: #1a73e8;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
        }

        /* Try It Out Panel */
        .tryit-panel {
            background: #fafbfc;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
            border: 1px solid #eef2f6;
        }

        .tryit-panel h4 {
            margin-bottom: 15px;
            color: #1a73e8;
        }

        .tryit-row {
            display: flex;
            gap: 12px;
            margin-bottom: 15px;
            flex-wrap: wrap;
            align-items: center;
        }

        .tryit-row select, .tryit-row input {
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-family: monospace;
            font-size: 0.8rem;
        }

        .tryit-row select {
            background: white;
            cursor: pointer;
        }

        .tryit-url {
            flex: 1;
            min-width: 250px;
        }

        .json-editor {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-family: monospace;
            font-size: 0.75rem;
            resize: vertical;
            min-height: 150px;
            background: #1e1e1e;
            color: #d4d4d4;
        }

        .response-viewer {
            margin-top: 20px;
            border-top: 1px solid #eef2f6;
            padding-top: 20px;
        }

        .response-status {
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .response-status.success {
            background: #d4edda;
            color: #155724;
        }

        .response-status.error {
            background: #f8d7da;
            color: #721c24;
        }

        .response-body {
            background: #1e1e1e;
            color: #d4d4d4;
            padding: 15px;
            border-radius: 8px;
            font-family: monospace;
            font-size: 0.75rem;
            overflow-x: auto;
            white-space: pre-wrap;
            word-break: break-all;
            max-height: 400px;
            overflow-y: auto;
        }

        .send-btn {
            padding: 10px 20px;
            background: #2da44e;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .send-btn:hover {
            background: #22863a;
        }

        .loading-spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #1a73e8;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 8px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Quick Examples */
        .examples-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 20px 0;
        }

        .example-btn {
            padding: 6px 14px;
            background: #eef2f6;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.7rem;
            font-weight: 500;
        }

        .example-btn:hover {
            background: #1a73e8;
            color: white;
        }

        /* Ringkasan Methods */
        .methods-summary {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 25px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 12px;
            align-items: center;
        }

        .method-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .method-badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            color: white;
        }

        .method-badge.get { background: #2da44e; }
        .method-badge.post { background: #cf222e; }
        .method-badge.put { background: #e36209; }
        .method-badge.delete { background: #6e40c9; }

        .total-info {
            margin-left: auto;
            font-size: 13px;
            background: white;
            padding: 6px 15px;
            border-radius: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
            padding: 20px;
            overflow-y: auto;
        }

        .modal-content {
            background: white;
            padding: 35px 30px;
            border-radius: 20px;
            width: 480px;
            max-width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            margin: auto;
        }

        /* Custom thin scrollbar for modal */
        .modal-content::-webkit-scrollbar {
            width: 6px;
        }
        .modal-content::-webkit-scrollbar-track {
            background: transparent;
            margin: 15px 0; /* Keep scrollbar away from the rounded corners */
        }
        .modal-content::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        .modal-content::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .modal-content h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #1a73e8;
            font-size: 1.4rem;
        }

        .modal-content input, .modal-content select {
            width: 100%;
            padding: 12px 14px;
            margin: 6px 0;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-sizing: border-box;
        }

        .password-wrapper {
            position: relative;
            width: 100%;
            margin: 6px 0;
        }
        
        .password-wrapper input {
            margin: 0 !important;
            padding-right: 40px !important;
        }
        
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888;
            font-size: 16px;
            user-select: none;
            transition: color 0.2s;
        }

        .password-toggle:hover {
            color: #333;
        }

        .modal-content input:focus, .modal-content select:focus {
            border-color: #1a73e8;
            box-shadow: 0 0 0 3px rgba(26,115,232,0.15);
        }

        .modal-content button {
            width: 100%;
            padding: 12px;
            background: #1a73e8;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            margin-top: 10px;
            transition: background 0.2s, transform 0.15s;
        }

        .modal-content button:hover {
            background: #1557b0;
            transform: translateY(-1px);
        }

        .modal-content button.secondary {
            background: #f0f2f5;
            color: #555;
            font-weight: 500;
            margin-top: 8px;
        }

        .modal-content button.secondary:hover {
            background: #e0e3e8;
        }

        .error-msg {
            color: #cf222e;
            font-size: 12px;
            text-align: center;
            margin-top: 12px;
        }

        .success-msg {
            color: #2da44e;
            font-size: 12px;
            text-align: center;
            margin-top: 12px;
        }

        .switch-form {
            text-align: center;
            margin-top: 15px;
            font-size: 13px;
            color: #666;
        }

        .switch-form a {
            color: #1a73e8;
            text-decoration: none;
            cursor: pointer;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            color: #888;
            font-size: 12px;
        }

        /* Tab Content */
        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Hide stats by default */
        .tab-stats {
            display: none;
        }

        .tab-stats.active {
            display: grid;
        }

        @media (max-width: 768px) {
            body {
                padding: 12px;
            }
            
            .navbar {
                flex-direction: column;
                text-align: center;
            }
            
            .endpoint-card {
                flex-wrap: wrap;
            }
            
            .method {
                min-width: 55px;
            }
            
            .desc {
                width: 100%;
                margin-left: 77px;
            }
            
            .copy-btn, .try-btn {
                margin-left: auto;
            }
            
            .tryit-row {
                flex-direction: column;
                align-items: stretch;
            }
            
            .methods-summary {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .total-info {
                margin-left: 0;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>

<div class="navbar" id="main-navbar" style="display: none;">
    <h1>🏥 Hospital Management System</h1>
</div>

<!-- 🎯 LANDING PAGE (FULL SCREEN - PROFESSIONAL) -->
<div id="landingPage">
    <div class="landing-inner">
        <span class="landing-emoji">🏥</span>
        <h1>Hospital Management System <span>API Hub</span></h1>
        <p class="landing-subtitle">Platform API untuk mengelola data pasien, dokter, dan appointment secara real-time</p>
        <p class="landing-desc">Gunakan berbagai endpoint API untuk melakukan operasi CRUD dengan mudah. Untuk mengakses API, silakan login atau daftar terlebih dahulu untuk mendapatkan API KEY.</p>

        <!-- 4 Info Cards -->
        <div class="landing-cards">
            <div class="landing-card">
                <span class="card-icon">📊</span>
                <h3>12 API Endpoints</h3>
                <p>Endpoint lengkap untuk semua resource</p>
            </div>
            <div class="landing-card">
                <span class="card-icon">⚡</span>
                <h3>GET, POST, PUT, DELETE</h3>
                <p>Mendukung semua metode HTTP</p>
            </div>
            <div class="landing-card">
                <span class="card-icon">🔐</span>
                <h3>Secure API Key</h3>
                <p>Autentikasi aman dengan API Key</p>
            </div>
            <div class="landing-card">
                <span class="card-icon">📡</span>
                <h3>Real-time Database</h3>
                <p>Data terupdate secara langsung</p>
            </div>
        </div>

        <!-- Access Box -->
        <div class="landing-access-box">
            🔑 <strong>Anda harus login terlebih dahulu untuk mendapatkan API KEY.</strong><br>
            API KEY digunakan untuk mengakses semua endpoint dalam sistem ini.
        </div>

        <!-- CTA Buttons -->
        <div class="landing-cta">
            <button class="cta-login" onclick="showLoginModal()">🔐 Login</button>
            <button class="cta-register" onclick="openRegisterDirectly()">📝 Daftar</button>
        </div>

        <!-- API Preview -->
        <div class="landing-preview">
            <h4>📋 Preview Endpoints</h4>
            <div class="preview-line">
                <span class="preview-method get">GET</span>
                <span class="preview-path">/patients</span>
            </div>
            <div class="preview-line">
                <span class="preview-method post">POST</span>
                <span class="preview-path">/doctors</span>
            </div>
            <div class="preview-line">
                <span class="preview-method put">PUT</span>
                <span class="preview-path">/appointments</span>
            </div>
            <div class="preview-line">
                <span class="preview-method delete">DELETE</span>
                <span class="preview-path">/patients/{id}</span>
            </div>
        </div>
    </div>
</div>

<!-- OLD landing page (hidden, kept for backward compatibility) -->
<div id="landing-page" style="display:none;"></div>

<!-- Stats Container yang akan berubah per tab -->
<div id="dashboard-container" style="display: none;">

    <!-- User Profile Header terpisah dari Navbar -->
    <div class="user-dashboard-header" id="userDashboardHeader">
        <div class="user-dashboard-profile">
            <div class="user-avatar">👤</div>
            <div class="user-details">
                <div class="user-greeting">Selamat datang, <span id="username"></span>!</div>
                <div class="user-meta">
                    <span id="userRoleDisplay" class="role-badge"></span>
                    <span id="apiKeyDisplay" class="api-key-badge" onclick="copyApiKey()" title="Klik untuk menyalin"></span>
                </div>
            </div>
        </div>
        <div class="user-dashboard-actions">
            <a href="javascript:void(0)" onclick="logout()" class="logout-btn-new">🚪 Logout</a>
        </div>
    </div>

<div id="stats-container"></div>

<!-- Tab Navigation -->
<div class="tab-container">
    <button class="tab-btn active" onclick="showTab('patients')">👤 Data Pasien</button>
    <button class="tab-btn" onclick="showTab('doctors')">👨‍⚕️ Data Dokter</button>
    <button class="tab-btn" onclick="showTab('api')">🔌 API Documentation</button>
    <button class="tab-btn" onclick="showTab('tryit')">🔥 Try It Out</button>
</div>

<!-- Tab: Data Pasien -->
<div id="tab-patients" class="tab-content active">
    <div class="section">
        <div class="section-title">
            <span>👤 Daftar Pasien</span>
            <div class="search-box">
                <input type="text" id="search-input" placeholder="Cari nama / NIK..." onkeyup="searchPatient()">
                <button onclick="loadPatients()">🔄 Refresh</button>
            </div>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Tanggal Lahir</th>
                        <th>Gender</th>
                        <th>No. Telepon</th>
                        <th>Alamat</th>
                    </tr>
                </thead>
                <tbody id="patients-table">
                    <tr><td colspan="7" class="loading">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tab: Data Dokter -->
<div id="tab-doctors" class="tab-content">
    <div class="section">
        <div class="section-title">
            <span>👨‍⚕️ Daftar Dokter</span>
            <div class="search-box">
                <input type="text" id="search-doctor-input" placeholder="Cari nama / spesialisasi..." onkeyup="searchDoctor()">
                <button onclick="loadDoctors()">🔄 Refresh</button>
            </div>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Dokter</th>
                        <th>Spesialisasi</th>
                        <th>No. Telepon</th>
                    </tr>
                </thead>
                <tbody id="doctors-table">
                    <tr><td colspan="4" class="loading">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tab: API Documentation -->
<div id="tab-api" class="tab-content">
    <div class="section">
        <h2 class="section-title">📡 API Endpoints</h2>
        
        <!-- Ringkasan Methods yang Tersedia -->
        <div class="methods-summary">
            <div class="method-item">
                <span class="method-badge get">GET</span>
                <span style="font-size: 13px; color: #555;">Mengambil data</span>
            </div>
            <div class="method-item">
                <span class="method-badge post">POST</span>
                <span style="font-size: 13px; color: #555;">Menambah data</span>
            </div>
            <div class="method-item">
                <span class="method-badge put">PUT</span>
                <span style="font-size: 13px; color: #555;">Mengupdate data</span>
            </div>
            <div class="method-item">
                <span class="method-badge delete">DELETE</span>
                <span style="font-size: 13px; color: #555;">Menghapus data</span>
            </div>
            <div class="total-info">
                📊 <strong>12 Endpoints</strong> | 4 Methods | 3 Resources
            </div>
        </div>

        <!-- Patients API -->
        <div class="resource-group">
            <div class="resource-header">
                <span class="resource-icon">👤</span>
                <h3>Patients</h3>
                <span class="resource-count">6 endpoints</span>
                <span style="font-size: 11px; color: #888; margin-left: 8px;">(GET: 3, POST: 1, PUT: 1, DELETE: 1)</span>
            </div>
            <div class="endpoints-container">
                <div class="endpoint-card">
                    <span class="method get">GET</span>
                    <span class="url">http://localhost/ETS_PEMAPI/patients/index.php</span>
                    <span class="desc">Ambil semua pasien</span>
                    <button class="copy-btn" data-url="http://localhost/ETS_PEMAPI/patients/index.php">Copy</button>
                    <button class="try-btn" onclick="tryThisEndpoint('GET', 'http://localhost/ETS_PEMAPI/patients/index.php', null)">🔥 Try</button>
                </div>
                <div class="endpoint-card">
                    <span class="method get">GET</span>
                    <span class="url">http://localhost/ETS_PEMAPI/patients/detail.php?id=1</span>
                    <span class="desc">Ambil pasien by ID</span>
                    <button class="copy-btn" data-url="http://localhost/ETS_PEMAPI/patients/detail.php?id=1">Copy</button>
                    <button class="try-btn" onclick="tryThisEndpoint('GET', 'http://localhost/ETS_PEMAPI/patients/detail.php', 'id=1')">🔥 Try</button>
                </div>
                <div class="endpoint-card">
                    <span class="method get">GET</span>
                    <span class="url">http://localhost/ETS_PEMAPI/patients/index.php?search=nama</span>
                    <span class="desc">Search pasien</span>
                    <button class="copy-btn" data-url="http://localhost/ETS_PEMAPI/patients/index.php?search=nama">Copy</button>
                    <button class="try-btn" onclick="tryThisEndpoint('GET', 'http://localhost/ETS_PEMAPI/patients/index.php', 'search=nama')">🔥 Try</button>
                </div>
                <div class="endpoint-card">
                    <span class="method post">POST</span>
                    <span class="url">http://localhost/ETS_PEMAPI/patients/index.php</span>
                    <span class="desc">Tambah pasien baru</span>
                    <button class="copy-btn" data-url="http://localhost/ETS_PEMAPI/patients/index.php">Copy</button>
                    <button class="try-btn" onclick="tryThisEndpoint('POST', 'http://localhost/ETS_PEMAPI/patients/index.php', null, '{\n    "name": "Pasien Baru",\n    "nik": "1234567890123456",\n    "birth_date": "1995-05-15",\n    "gender": "Laki-laki",\n    "phone": "08123456789",\n    "address": "Jl. Contoh No. 123"\n}')">🔥 Try</button>
                </div>
                <div class="endpoint-card">
                    <span class="method put">PUT</span>
                    <span class="url">http://localhost/ETS_PEMAPI/patients/detail.php?id=1</span>
                    <span class="desc">Update data pasien</span>
                    <button class="copy-btn" data-url="http://localhost/ETS_PEMAPI/patients/detail.php?id=1">Copy</button>
                    <button class="try-btn" onclick="tryThisEndpoint('PUT', 'http://localhost/ETS_PEMAPI/patients/detail.php', 'id=1', '{\n    "name": "Nama Update",\n    "phone": "08987654321",\n    "address": "Alamat Baru"\n}')">🔥 Try</button>
                </div>
                <div class="endpoint-card">
                    <span class="method delete">DELETE</span>
                    <span class="url">http://localhost/ETS_PEMAPI/patients/detail.php?id=1</span>
                    <span class="desc">Hapus pasien</span>
                    <button class="copy-btn" data-url="http://localhost/ETS_PEMAPI/patients/detail.php?id=1">Copy</button>
                    <button class="try-btn" onclick="tryThisEndpoint('DELETE', 'http://localhost/ETS_PEMAPI/patients/detail.php', 'id=1')">🔥 Try</button>
                </div>
            </div>
        </div>

        <!-- Doctors API -->
        <div class="resource-group">
            <div class="resource-header">
                <span class="resource-icon">👨‍⚕️</span>
                <h3>Doctors</h3>
                <span class="resource-count">3 endpoints</span>
                <span style="font-size: 11px; color: #888; margin-left: 8px;">(GET: 2, POST: 1)</span>
            </div>
            <div class="endpoints-container">
                <div class="endpoint-card">
                    <span class="method get">GET</span>
                    <span class="url">http://localhost/ETS_PEMAPI/doctors/index.php</span>
                    <span class="desc">Ambil semua dokter</span>
                    <button class="copy-btn" data-url="http://localhost/ETS_PEMAPI/doctors/index.php">Copy</button>
                    <button class="try-btn" onclick="tryThisEndpoint('GET', 'http://localhost/ETS_PEMAPI/doctors/index.php', null)">🔥 Try</button>
                </div>
                <div class="endpoint-card">
                    <span class="method get">GET</span>
                    <span class="url">http://localhost/ETS_PEMAPI/doctors/detail.php?id=1</span>
                    <span class="desc">Ambil dokter by ID</span>
                    <button class="copy-btn" data-url="http://localhost/ETS_PEMAPI/doctors/detail.php?id=1">Copy</button>
                    <button class="try-btn" onclick="tryThisEndpoint('GET', 'http://localhost/ETS_PEMAPI/doctors/detail.php', 'id=1')">🔥 Try</button>
                </div>
                <div class="endpoint-card">
                    <span class="method post">POST</span>
                    <span class="url">http://localhost/ETS_PEMAPI/doctors/index.php</span>
                    <span class="desc">Tambah dokter baru</span>
                    <button class="copy-btn" data-url="http://localhost/ETS_PEMAPI/doctors/index.php">Copy</button>
                    <button class="try-btn" onclick="tryThisEndpoint('POST', 'http://localhost/ETS_PEMAPI/doctors/index.php', null, '{\n    "name": "dr. Budi Santoso",\n    "specialization": "Umum",\n    "phone": "08123456789"\n}')">🔥 Try</button>
                </div>
            </div>
        </div>

        <!-- Appointments API -->
        <div class="resource-group">
            <div class="resource-header">
                <span class="resource-icon">📅</span>
                <h3>Appointments</h3>
                <span class="resource-count">3 endpoints</span>
                <span style="font-size: 11px; color: #888; margin-left: 8px;">(GET: 1, POST: 1, PUT: 1)</span>
            </div>
            <div class="endpoints-container">
                <div class="endpoint-card">
                    <span class="method get">GET</span>
                    <span class="url">http://localhost/ETS_PEMAPI/appointments/index.php</span>
                    <span class="desc">Ambil semua appointments</span>
                    <button class="copy-btn" data-url="http://localhost/ETS_PEMAPI/appointments/index.php">Copy</button>
                    <button class="try-btn" onclick="tryThisEndpoint('GET', 'http://localhost/ETS_PEMAPI/appointments/index.php', null)">🔥 Try</button>
                </div>
                <div class="endpoint-card">
                    <span class="method post">POST</span>
                    <span class="url">http://localhost/ETS_PEMAPI/appointments/index.php</span>
                    <span class="desc">Buat appointment baru</span>
                    <button class="copy-btn" data-url="http://localhost/ETS_PEMAPI/appointments/index.php">Copy</button>
                    <button class="try-btn" onclick="tryThisEndpoint('POST', 'http://localhost/ETS_PEMAPI/appointments/index.php', null, '{\n    "patient_id": 1,\n    "doctor_id": 1,\n    "appointment_date": "2024-12-25 10:00:00",\n    "complaint": "Demam dan batuk",\n    "status": "pending"\n}')">🔥 Try</button>
                </div>
                <div class="endpoint-card">
                    <span class="method put">PUT</span>
                    <span class="url">http://localhost/ETS_PEMAPI/appointments/detail.php?id=1</span>
                    <span class="desc">Update status appointment</span>
                    <button class="copy-btn" data-url="http://localhost/ETS_PEMAPI/appointments/detail.php?id=1">Copy</button>
                    <button class="try-btn" onclick="tryThisEndpoint('PUT', 'http://localhost/ETS_PEMAPI/appointments/detail.php', 'id=1', '{\n    "status": "done"\n}')">🔥 Try</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tab: Try It Out -->
<div id="tab-tryit" class="tab-content">
    <div class="section">
        <h2 class="section-title">🔥 Try It Out</h2>
        
        <!-- Stats ringkas di Try It Out -->
        <div class="methods-summary" style="margin-bottom: 20px;">
            <div class="method-item">
                <span class="method-badge get">GET</span>
                <span style="font-size: 13px; color: #555;">Mengambil data</span>
            </div>
            <div class="method-item">
                <span class="method-badge post">POST</span>
                <span style="font-size: 13px; color: #555;">Menambah data</span>
            </div>
            <div class="method-item">
                <span class="method-badge put">PUT</span>
                <span style="font-size: 13px; color: #555;">Mengupdate data</span>
            </div>
            <div class="method-item">
                <span class="method-badge delete">DELETE</span>
                <span style="font-size: 13px; color: #555;">Menghapus data</span>
            </div>
            <div class="total-info">
                📊 <strong>12 Endpoints</strong> | 4 Methods | 3 Resources
            </div>
        </div>
        
        <p style="margin-bottom: 20px; color: #666;">Pilih endpoint, isi parameter, dan kirim request untuk melihat response API secara langsung!</p>
        
        <div class="tryit-panel">
            <h4>⚡ Request Builder</h4>
            <div class="tryit-row">
                <select id="try-method" style="min-width: 100px;">
                    <option value="GET">GET</option>
                    <option value="POST">POST</option>
                    <option value="PUT">PUT</option>
                    <option value="DELETE">DELETE</option>
                </select>
                <input type="text" id="try-url" class="tryit-url" placeholder="URL Endpoint" value="http://localhost/ETS_PEMAPI/patients/index.php">
            </div>
            <div class="tryit-row">
                <input type="text" id="try-params" placeholder="Query Parameters (contoh: id=1&search=nama)" style="width: 100%;">
            </div>
            <div>
                <textarea id="try-body" class="json-editor" placeholder='Body JSON untuk POST/PUT request (contoh):
{
    "name": "Nama Baru",
    "specialization": "Spesialisasi"
}'></textarea>
            </div>
            <div style="margin-top: 15px;">
                <button class="send-btn" onclick="sendRequest()">🚀 Send Request</button>
            </div>
        </div>

        <div id="response-area" style="display: none;">
            <div class="tryit-panel">
                <h4>📬 Response</h4>
                <div id="response-status" class="response-status"></div>
                <div id="response-body" class="response-body"></div>
            </div>
        </div>

        <div style="margin-top: 20px;">
            <h4>📋 Quick Examples</h4>
            <div class="examples-container">
                <button class="example-btn" onclick="setExample('patients')">👤 GET All Patients</button>
                <button class="example-btn" onclick="setExample('patients_detail')">👤 GET Patient by ID</button>
                <button class="example-btn" onclick="setExample('doctors')">👨‍⚕️ GET All Doctors</button>
                <button class="example-btn" onclick="setExample('appointments')">📅 GET All Appointments</button>
                <button class="example-btn" onclick="setExample('post_patient')">➕ POST New Patient</button>
                <button class="example-btn" onclick="setExample('post_doctor')">➕ POST New Doctor</button>
            </div>
        </div>
    </div>
</div>
</div>

<div class="footer">
    <p>Hospital Management System - API Documentation & Data Management © 2026</p>
</div>

<!-- Modal Login / Register -->
<div id="authModal" class="modal">
    <div class="modal-content">
        <div id="loginForm">
            <h2>🔐 Login</h2>
            <input type="text" id="loginUsername" placeholder="Username">
            <div class="password-wrapper">
                <input type="password" id="loginPassword" placeholder="Password">
                <span class="password-toggle" onclick="togglePassword('loginPassword', this)">👁️</span>
            </div>
            <button onclick="doLogin()">Login</button>
            <div class="switch-form">
                Belum punya akun? <a onclick="showRegisterForm()">Daftar disini</a>
            </div>
            <div id="loginError" class="error-msg"></div>
        </div>
        <div id="registerForm" style="display: none;">
            <h2>📝 Daftar Akun Baru</h2>
            
            <input type="text" id="regFullname" placeholder="Nama Lengkap *" required>
            
            <input type="email" id="regEmail" placeholder="Email *" required>
            
            <input type="tel" id="regPhone" placeholder="Nomor Telepon (contoh: 08123456789)">
            
            <select id="regGender">
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="Laki-laki">👨 Laki-laki</option>
                <option value="Perempuan">👩 Perempuan</option>
            </select>
            
            <input type="text" id="regUsername" placeholder="Username *" required>
            
            <div class="password-wrapper">
                <input type="password" id="regPassword" placeholder="Password (min. 4 karakter) *" required>
                <span class="password-toggle" onclick="togglePassword('regPassword', this)">👁️</span>
            </div>
            
            <select id="regRole">
                <option value="staff">📋 Staff</option>
                <option value="doctor">👨‍⚕️ Dokter</option>
            </select>
            
            <button onclick="doRegister()">Daftar</button>
            <button class="secondary" onclick="showLoginForm()">← Kembali ke Login</button>
            <div id="registerError" class="error-msg"></div>
            <div id="registerSuccess" class="success-msg"></div>
        </div>
    </div>
</div>

<script>
    const BASE_URL = 'http://localhost/ETS_PEMAPI';

    // ============================================================
    // SATU FUNGSI UTAMA: checkLoginStatus()
    // Mengatur Landing vs Dashboard, Navbar, dan info user
    // ============================================================
    function checkLoginStatus() {
        const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';
        const landingPage = document.getElementById('landingPage');
        const dashboardContainer = document.getElementById('dashboard-container');
        const mainNavbar = document.getElementById('main-navbar');
        const apiKeyDisplay = document.getElementById('apiKeyDisplay');
        const userRoleDisplay = document.getElementById('userRoleDisplay');
        const userNameDisplay = document.getElementById('userNameDisplay');
        const loginBtn = document.getElementById('loginBtn');
        const logoutBtn = document.getElementById('logoutBtn');

        // Pastikan body selalu bisa di-scroll
        document.body.style.overflow = '';
        
        // Auto logout jika terdeteksi isLoggedIn tapi apiKey tidak ada (menyebabkan bug 401)
        if (isLoggedIn && !localStorage.getItem('apiKey')) {
            localStorage.clear();
            isLoggedIn = false;
        }

        if (isLoggedIn) {
            // === TAMPILAN DASHBOARD ===
            if (landingPage) landingPage.style.display = 'none';
            if (dashboardContainer) dashboardContainer.style.display = 'block';
            if (mainNavbar) mainNavbar.style.display = 'flex';

            // Info user di Profile Header
            const currentUser = localStorage.getItem('currentUser');
            const role = localStorage.getItem('userRole');
            const fullname = localStorage.getItem('userFullname');

            if (document.getElementById('username')) {
                document.getElementById('username').textContent = fullname || currentUser;
            }
            if (userRoleDisplay) {
                userRoleDisplay.textContent = role === 'doctor' ? '👨‍⚕️ Dokter' : (role === 'admin' ? '🛡️ Admin' : '📋 Staff');
            }

            // Load data pasien saat pertama kali
            loadPatients();
        } else {
            // === TAMPILAN LANDING PAGE ===
            if (landingPage) landingPage.style.display = 'flex';
            if (dashboardContainer) dashboardContainer.style.display = 'none';
            if (mainNavbar) mainNavbar.style.display = 'none';
        }

        // API Key display (with copy emoji)
        if (apiKeyDisplay) {
            const currentKey = localStorage.getItem('apiKey');
            if (currentKey) {
                apiKeyDisplay.innerHTML = `🔑 ${currentKey} <span>📋</span>`;
            } else {
                apiKeyDisplay.textContent = 'API KEY: -';
            }
        }
    }

    function copyApiKey() {
        const apiKey = localStorage.getItem('apiKey');
        if (apiKey) {
            navigator.clipboard.writeText(apiKey).then(() => {
                showToast('✅ API Key berhasil disalin!');
            }).catch(() => {
                showToast('❌ Gagal menyalin API Key');
            });
        }
    }

    // ============= RENDER STATS CARD BERDASARKAN TAB =============
    function renderStats(tabName) {
        const statsContainer = document.getElementById('stats-container');
        
        if (tabName === 'patients') {
            // Hanya menampilkan Total Pasien
            statsContainer.innerHTML = `
                <div class="stats">
                    <div class="stat-card patients">
                        <h2 id="total-patients">-</h2>
                        <p>👤 Total Pasien</p>
                    </div>
                </div>
            `;
            loadPatients();
        } 
        else if (tabName === 'doctors') {
            // Hanya menampilkan Total Dokter
            statsContainer.innerHTML = `
                <div class="stats">
                    <div class="stat-card doctors">
                        <h2 id="total-doctors">-</h2>
                        <p>👨‍⚕️ Total Dokter</p>
                    </div>
                </div>
            `;
            loadDoctors();
        }
        else {
            // Untuk tab API Documentation dan Try It Out: tampilkan stats endpoint, methods, resources
            statsContainer.innerHTML = `
                <div class="stats">
                    <div class="stat-card endpoints">
                        <h2>12</h2>
                        <p>🔌 Total Endpoints</p>
                    </div>
                    <div class="stat-card methods">
                        <h2>4</h2>
                        <p>⚡ HTTP Methods</p>
                    </div>
                    <div class="stat-card resources">
                        <h2>3</h2>
                        <p>📦 Total Resources</p>
                    </div>
                </div>
            `;
        }
    }

    // ============= TAB NAVIGATION =============
    function showTab(tabName) {
        document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        
        document.getElementById(`tab-${tabName}`).classList.add('active');
        event.target.classList.add('active');
        
        // Render stats berdasarkan tab yang aktif
        renderStats(tabName);
    }

    // ============= TRY IT OUT FUNCTIONS =============
    function tryThisEndpoint(method, url, params, body) {
        showTab('tryit');
        document.getElementById('try-method').value = method;
        document.getElementById('try-url').value = url;
        document.getElementById('try-params').value = params || '';
        document.getElementById('try-body').value = body ? JSON.stringify(JSON.parse(body), null, 2) : '';
        document.getElementById('response-area').style.display = 'none';
        
        setTimeout(() => {
            document.getElementById('try-body').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 100);
    }

    async function sendRequest() {
        let url = document.getElementById('try-url').value;
        const method = document.getElementById('try-method').value;
        const params = document.getElementById('try-params').value;
        let jsonBody = document.getElementById('try-body').value;
        
        if (params) {
            url += (url.includes('?') ? '&' : '?') + params;
        }
        
        const options = {
            method: method,
            headers: { 
                'Content-Type': 'application/json',
                'x-api-key': localStorage.getItem('apiKey')
            }
        };
        
        if (method !== 'GET' && jsonBody && jsonBody.trim()) {
            try {
                options.body = JSON.stringify(JSON.parse(jsonBody));
            } catch (e) {
                options.body = jsonBody;
            }
        }
        
        const responseArea = document.getElementById('response-area');
        const statusDiv = document.getElementById('response-status');
        const bodyDiv = document.getElementById('response-body');
        
        responseArea.style.display = 'block';
        statusDiv.innerHTML = '<span class="loading-spinner"></span> Mengirim request...';
        statusDiv.className = 'response-status';
        bodyDiv.textContent = '';
        
        try {
            const startTime = Date.now();
            const response = await fetch(url, options);
            const endTime = Date.now();
            const responseTime = endTime - startTime;
            
            const responseText = await response.text();
            let formattedResponse;
            try {
                const json = JSON.parse(responseText);
                formattedResponse = JSON.stringify(json, null, 2);
            } catch (e) {
                formattedResponse = responseText;
            }
            
            if (response.ok) {
                statusDiv.innerHTML = `✅ ${response.status} ${response.statusText} - ⏱️ ${responseTime}ms`;
                statusDiv.className = 'response-status success';
            } else {
                statusDiv.innerHTML = `❌ ${response.status} ${response.statusText} - ⏱️ ${responseTime}ms`;
                statusDiv.className = 'response-status error';
            }
            
            bodyDiv.textContent = formattedResponse;
        } catch (error) {
            statusDiv.innerHTML = `❌ Error: ${error.message}`;
            statusDiv.className = 'response-status error';
            bodyDiv.textContent = 'Gagal mengirim request. Periksa koneksi atau URL.';
        }
    }

    function setExample(type) {
        const examples = {
            patients: { method: 'GET', url: `${BASE_URL}/patients/index.php`, params: '', body: '' },
            patients_detail: { method: 'GET', url: `${BASE_URL}/patients/detail.php`, params: 'id=1', body: '' },
            doctors: { method: 'GET', url: `${BASE_URL}/doctors/index.php`, params: '', body: '' },
            appointments: { method: 'GET', url: `${BASE_URL}/appointments/index.php`, params: '', body: '' },
            post_patient: { method: 'POST', url: `${BASE_URL}/patients/index.php`, params: '', body: '{\n    "name": "Pasien Baru",\n    "nik": "1234567890123456",\n    "birth_date": "1995-05-15",\n    "gender": "Laki-laki",\n    "phone": "08123456789",\n    "address": "Jl. Contoh No. 123"\n}' },
            post_doctor: { method: 'POST', url: `${BASE_URL}/doctors/index.php`, params: '', body: '{\n    "name": "dr. Ahmad Fauzi",\n    "specialization": "Anak",\n    "phone": "08987654321"\n}' }
        };
        
        const ex = examples[type];
        if (ex) {
            document.getElementById('try-method').value = ex.method;
            document.getElementById('try-url').value = ex.url;
            document.getElementById('try-params').value = ex.params;
            document.getElementById('try-body').value = ex.body;
            document.getElementById('response-area').style.display = 'none';
            showTab('tryit');
        }
    }

    // ============= UTILITY: HIGHLIGHT KEREN =============
    function highlightText(text, search) {
        if (text === null || text === undefined || text === '') return '-';
        const str = String(text);
        
        // Escape basic HTML untuk mencegah XSS
        const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
        let escapedText = str.replace(/[&<>"']/g, m => map[m]);
        
        if (!search) return escapedText;

        const escSearch = String(search).replace(/[&<>"']/g, m => map[m]).replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        const regex = new RegExp(`(${escSearch})`, 'gi');
        return escapedText.replace(regex, '<mark class="highlight-search">$1</mark>');
    }

    // ============= LOAD PATIENTS =============
    async function loadPatients(search = '') {
        const tbody = document.getElementById('patients-table');
        tbody.innerHTML = '<tr><td colspan="7" class="loading">Memuat data...</td></tr>';
        try {
            let url = `${BASE_URL}/patients/index.php`;
            if (search) url += `?search=${encodeURIComponent(search)}`;
            const res = await fetch(url, {
                headers: {
                    'x-api-key': localStorage.getItem('apiKey')
                }
            });
            const data = await res.json();
            
            const totalPatientsElem = document.getElementById('total-patients');
            if (totalPatientsElem) {
                totalPatientsElem.textContent = data.data?.length || 0;
            }
            
            if (!data.data || data.data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" class="empty">Tidak ada data pasien</td></tr>';
                return;
            }
            tbody.innerHTML = data.data.map((p, i) => `
                <tr>
                    <td>${i+1}</td>
                    <td><b>${highlightText(p.name, search)}</b></td>
                    <td>${highlightText(p.nik, search)}</td>
                    <td>${highlightText(p.birth_date, search)}</td>
                    <td><span class="badge ${p.gender === 'Laki-laki' ? 'badge-male' : 'badge-female'}">${highlightText(p.gender, search)}</span></td>
                    <td>${highlightText(p.phone, search)}</td>
                    <td>${highlightText(p.address, search)}</td>
                </tr>
            `).join('');
        } catch(err) {
            tbody.innerHTML = '<tr><td colspan="7" class="empty">Gagal memuat data!</td></tr>';
        }
    }

    // ============= LOAD DOCTORS =============
    async function loadDoctors(search = '') {
        const tbody = document.getElementById('doctors-table');
        tbody.innerHTML = '<tr><td colspan="4" class="loading">Memuat data...</td></tr>';
        try {
            let url = `${BASE_URL}/doctors/index.php`;
            if (search) url += `?search=${encodeURIComponent(search)}`;
            const res = await fetch(url, {
                headers: {
                    'x-api-key': localStorage.getItem('apiKey')
                }
            });
            const data = await res.json();
            
            const totalDoctorsElem = document.getElementById('total-doctors');
            if (totalDoctorsElem) {
                totalDoctorsElem.textContent = data.data?.length || 0;
            }
            
            if (!data.data || data.data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4" class="empty">Tidak ada data dokter</td></tr>';
                return;
            }
            tbody.innerHTML = data.data.map((d, i) => `
                <tr>
                    <td>${i+1}</td>
                    <td><b>${highlightText(d.name, search)}</b></td>
                    <td>${highlightText(d.specialization, search)}</td>
                    <td>${highlightText(d.phone, search)}</td>
                </tr>
            `).join('');
        } catch(err) {
            tbody.innerHTML = '<tr><td colspan="4" class="empty">Gagal memuat data!</td></tr>';
        }
    }

    // Search functions
    let searchTimeout, searchDoctorTimeout;
    function searchPatient() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => loadPatients(document.getElementById('search-input').value), 400);
    }
    function searchDoctor() {
        clearTimeout(searchDoctorTimeout);
        searchDoctorTimeout = setTimeout(() => loadDoctors(document.getElementById('search-doctor-input').value), 400);
    }

    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/[&<>"]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }

    // ============= LOGIN SYSTEM =============

    // Buka modal + tampil form LOGIN
    function showLoginModal() {
        document.getElementById('authModal').style.display = 'flex';
        showLoginForm();
    }

    // Buka modal + tampil form REGISTER (langsung, tanpa lewat login)
    function showRegisterModal() {
        document.getElementById('authModal').style.display = 'flex';
        showRegisterForm();
    }

    // Alias: fungsi tunggal untuk tombol Daftar di Landing Page
    function openRegisterDirectly() {
        document.getElementById('authModal').style.display = 'flex';
        showRegisterForm();
    }

    function togglePassword(inputId, icon) {
        const input = document.getElementById(inputId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.textContent = '🙈';
        } else {
            input.type = 'password';
            icon.textContent = '👁️';
        }
    }

    function showLoginForm() {
        document.getElementById('loginForm').style.display = 'block';
        document.getElementById('registerForm').style.display = 'none';
        document.getElementById('loginError').textContent = '';
    }

    function showRegisterForm() {
        document.getElementById('loginForm').style.display = 'none';
        document.getElementById('registerForm').style.display = 'block';
        document.getElementById('registerError').textContent = '';
        document.getElementById('registerSuccess').textContent = '';
        // Reset semua field
        document.getElementById('regFullname').value = '';
        document.getElementById('regEmail').value = '';
        document.getElementById('regPhone').value = '';
        document.getElementById('regGender').value = '';
        document.getElementById('regUsername').value = '';
        document.getElementById('regPassword').value = '';
    }

    function closeAuthModal() {
        document.getElementById('authModal').style.display = 'none';
        // Pastikan scroll kembali normal
        document.body.style.overflow = '';
    }

    async function doLogin() {
        const username = document.getElementById('loginUsername').value.trim();
        const password = document.getElementById('loginPassword').value;
        if (!username || !password) {
            document.getElementById('loginError').textContent = 'Username dan password harus diisi!';
            return;
        }
        try {
            const response = await fetch('login_api.php', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'x-api-key': localStorage.getItem('apiKey')
                },
                body: JSON.stringify({ action: 'login', username, password })
            });
            const result = await response.json();
            if (result.success) {
                localStorage.setItem('isLoggedIn', 'true');
                localStorage.setItem('currentUser', result.user.username);
                localStorage.setItem('userRole', result.user.role);
                localStorage.setItem('userFullname', result.user.fullname);
                localStorage.setItem('apiKey', result.user.api_key);
                console.log("API KEY:", result.user.api_key);
                closeAuthModal();
                checkLoginStatus();
                renderStats('patients');
                showToast('✅ Login berhasil!');
            } else {
                document.getElementById('loginError').textContent = result.message;
            }
        } catch(err) {
            document.getElementById('loginError').textContent = 'Terjadi kesalahan';
        }
    }

    async function doRegister() {
        const fullname = document.getElementById('regFullname').value.trim();
        const email = document.getElementById('regEmail').value.trim();
        const phone = document.getElementById('regPhone').value.trim();
        const gender = document.getElementById('regGender').value;
        const username = document.getElementById('regUsername').value.trim();
        const password = document.getElementById('regPassword').value;
        const role = document.getElementById('regRole').value;
        
        // Reset error dan success
        document.getElementById('registerError').textContent = '';
        document.getElementById('registerSuccess').textContent = '';
        
        // Validasi field wajib
        if (!fullname || !email || !username || !password) {
            document.getElementById('registerError').textContent = 'Nama lengkap, email, username, dan password harus diisi!';
            return;
        }
        
        // Validasi email format
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            document.getElementById('registerError').textContent = 'Format email tidak valid! Contoh: nama@domain.com';
            return;
        }
        
        if (password.length < 4) {
            document.getElementById('registerError').textContent = 'Password minimal 4 karakter!';
            return;
        }
        
        // Validasi nomor telepon (opsional, tapi jika diisi harus angka)
        if (phone && !/^[0-9+\-\s]+$/.test(phone)) {
            document.getElementById('registerError').textContent = 'Nomor telepon hanya boleh berisi angka, +, -, dan spasi!';
            return;
        }
        
        try {
            const response = await fetch('login_api.php', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'x-api-key': localStorage.getItem('apiKey')
                },
                body: JSON.stringify({ 
                    action: 'register', 
                    fullname: fullname,
                    email: email,
                    phone: phone,
                    gender: gender,
                    username: username, 
                    password: password,
                    role: role
                })
            });
            
            const result = await response.json();
            
            if (result.success) {
                document.getElementById('registerSuccess').textContent = result.message;
                // Auto-fill ke form login
                document.getElementById('loginUsername').value = username;
                // Reset form register
                document.getElementById('regFullname').value = '';
                document.getElementById('regEmail').value = '';
                document.getElementById('regPhone').value = '';
                document.getElementById('regGender').value = '';
                document.getElementById('regUsername').value = '';
                document.getElementById('regPassword').value = '';
                // Kembali ke form login setelah 2 detik
                setTimeout(() => {
                    showLoginForm();
                    document.getElementById('loginError').textContent = '✅ Akun berhasil dibuat! Silakan login.';
                }, 2000);
            } else {
                document.getElementById('registerError').textContent = result.message;
            }
        } catch (err) {
            document.getElementById('registerError').textContent = 'Terjadi kesalahan. Silakan coba lagi.';
        }
    }

    function logout() {
        if (confirm('Apakah Anda yakin ingin logout?')) {
            localStorage.clear();
            checkLoginStatus();
            showToast('👋 Logout berhasil!');
        }
    }

    function showToast(message) {
        const toast = document.createElement('div');
        toast.textContent = message;
        toast.style.cssText = 'position:fixed;bottom:20px;right:20px;padding:12px 24px;background:#1a73e8;color:white;border-radius:12px;z-index:9999';
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    function handleCopy(btn) {
        const url = btn.getAttribute('data-url');
        navigator.clipboard.writeText(url);
        btn.textContent = '✓ Copied!';
        setTimeout(() => btn.textContent = 'Copy', 2000);
    }

    // Attach copy event
    document.querySelectorAll('.copy-btn').forEach(btn => {
        btn.addEventListener('click', function() { handleCopy(this); });
    });

    // Klik di luar modal untuk menutup
    window.onclick = (e) => { if (e.target === document.getElementById('authModal')) closeAuthModal(); };

    // ==========================================
    // JALANKAN SAAT HALAMAN DIBUKA (INITIALIZE)
    // ==========================================
    window.onload = () => {
        // 1. Cek status login (atur tampilan Landing/Dashboard/Navbar)
        checkLoginStatus();
        
        // 2. Jika sudah login, tampilkan statistik awal
        if (localStorage.getItem('isLoggedIn') === 'true') {
            renderStats('patients');
        }
    };
</script>

</body>
</html>
