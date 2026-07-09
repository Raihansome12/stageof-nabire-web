<style>
    @page {
        margin: 134px 45px 54px 45px;
    }

    * { box-sizing: border-box; }

    body {
        font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;
        font-size: 11pt;
        color: #1a1a1a;
        line-height: 1.35;
    }

    /* ── Kop surat (fixed header, repeats on every page) ── */
    .kop-header {
        position: fixed;
        top: -134px;      
        left: -45px;      
        right: -45px;     
        height: 108px;    
        overflow: hidden;
        padding-left: 45px;  
        padding-right: 45px; 
        padding-top: 16px;   
        background-color: #b5b5b5; 
        border-bottom: 3px solid #1a1a1a; 
    }
    .kop-table { width: 100%; border-collapse: collapse; }
    .kop-table td { vertical-align: middle; padding-top: 8px; padding-bottom: 8px; }
    .kop-logo { width: 78px; padding-right: 14px; }
    .kop-logo img { width: 68px; height: 84px; }
    .kop-text { text-align: center; padding-right: 15px }
    .kop-title-1 { font-size: 14pt; font-weight: bold; text-transform: uppercase; line-height: 1.25; }
    .kop-title-2 { font-size: 15pt; font-weight: bold; text-transform: uppercase; line-height: 1.25; }
    .kop-sub { font-size: 9.5pt; font-weight: bold; margin-top: 1px; }

    /* ── Footer (fixed, repeats on every page) ── */
    footer {
        position: fixed;
        bottom: -40px;    /* -FH, see note above */
        left: 0;
        right: 0;
        height: 40px;
        font-size: 8pt;
        color: #555;
        border-top: 1px solid #999;
        padding-top: 4px;
        text-align: left;
    }
    footer .footer-title { font-weight: bold; color: #333; margin-bottom: 1px; }

    /* ── Judul dokumen ── */
    .doc-title { text-align: center; font-size: 12.5pt; font-weight: bold; text-decoration: underline; margin-top: 25px; margin-bottom: 2px; }
    .doc-subtitle { text-align: center; font-size: 10.5pt; margin-bottom: 12px; }
    .doc-nomor { text-align: left; font-size: 10.5pt; margin-bottom: 14px; padding-left: 30%; }
    .doc-nomor-1 { text-align: center; font-size: 10.5pt; margin-bottom: 14px;}

    .align-right { text-align: right; }
    .mb-10 { margin-bottom: 10px; }
    .mb-14 { margin-bottom: 14px; }
    .mb-18 { margin-bottom: 18px; }

    /* ── Info / definisi ── */
    table.info-table { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
    table.info-table td { padding: 3px 0; vertical-align: top; font-size: 11pt; }
    table.info-table td.label { width: 150px; color: #333; }
    table.info-table td.colon { width: 12px; }

    /* ── Tabel data ── */
    table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
    table.data-table th, table.data-table td {
        border: 1px solid #444;
        padding: 6px 8px;
        font-size: 10.5pt;
        vertical-align: top;
    }
    table.data-table th { text-align: center; font-weight: bold; background-color: #f2f2f2; }
    table.data-table td.center { text-align: center; }

    .section-title { font-size: 11.5pt; font-weight: bold; text-transform: uppercase; margin-top: 14px; margin-bottom: 6px; border-bottom: 1px solid #ccc; padding-bottom: 3px; }

    .badge {
        display: inline-block;
        padding: 2px 8px;
        border: 1px solid #444;
        border-radius: 3px;
        font-size: 9.5pt;
        font-weight: bold;
    }

    /* ── Tanda tangan ── */
    .ttd-block { width: 40%; margin-left: 60%; margin-top: 50px; font-size: 11pt; }
    .ttd-space { height: 100px; }
    /* .ttd-name { text-decoration: underline; font-weight: bold; } */
    .ttd-nip { margin-top: 2px; }
</style>