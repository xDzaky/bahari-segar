<?php
// 08-inject-body.php -- HTML sections for Bahari Segar pages

// ───── BERANDA ─────────────────────────────────────────────────────────────
echo "[1/3] Beranda...\n";

$hero = <<<NOWDOC
<div style="position:relative;min-height:100vh;display:flex;align-items:center;overflow:hidden;">
  <img src="https://images.unsplash.com/photo-1615141982883-c7ad0e69fd62?ixid=M3wxMDAzMzMxfDB8MXxzZWFyY2h8MXx8c2VhZm9vZCUyMGZpc2glMjBtYXJrZXQlMjBmcmVzaHxlbnwwfDB8fHwxNzg0NjE0OTUwfDA&ixlib=rb-4.1.0&w=1600&q=85&fm=jpg&fit=crop" alt="Pasar ikan pelelangan dini hari" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;" />
  <div style="position:absolute;inset:0;background:linear-gradient(105deg,rgba(13,19,22,0.96) 0%,rgba(13,19,22,0.85) 45%,rgba(13,19,22,0.5) 100%);"></div>
  <div style="position:relative;z-index:1;display:grid;grid-template-columns:62fr 38fr;width:100%;min-height:100vh;">
    <div style="display:flex;flex-direction:column;justify-content:center;padding:120px 60px 120px 80px;">
      <span style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#C2401C;letter-spacing:0.18em;text-transform:uppercase;border:1px solid #C2401C;padding:5px 12px;display:inline-block;margin-bottom:28px;width:fit-content;">TANGKAPAN HARI INI &middot; 04:00 WIB</span>
      <h1 style="font-family:Oswald,sans-serif;font-weight:800;font-size:clamp(2.5rem,5.5vw,4.5rem);color:#E7E9E1;line-height:0.95;letter-spacing:-0.025em;margin:0 0 28px;">Ditimbang Jam 4 Pagi, Sampai Dapur Anda Sebelum Jam Makan Siang.</h1>
      <p style="font-family:'IBM Plex Sans',sans-serif;font-size:17px;color:rgba(231,233,225,0.6);line-height:1.65;max-width:520px;margin-bottom:40px;">Bahari Segar memasok ikan, udang, cumi, kerang, dan olahan hasil laut langsung dari pelelangan ke dapur hotel dan restoran &mdash; bukan dari gudang beku berbulan-bulan.</p>
      <div style="display:flex;gap:16px;flex-wrap:wrap;align-items:center;">
        <a href="https://wa.me/6281234567890?text=Halo%20Bahari%20Segar%2C%20cek%20ketersediaan%20hari%20ini" target="_blank" rel="noopener" style="display:inline-block;background:#C2401C;color:#E7E9E1;font-family:Oswald,sans-serif;font-weight:700;font-size:14px;letter-spacing:0.1em;text-transform:uppercase;padding:16px 32px;text-decoration:none;">Cek Ketersediaan Hari Ini</a>
        <a href="#manifest" style="color:#E7E9E1;font-family:Oswald,sans-serif;font-weight:600;font-size:14px;letter-spacing:0.08em;text-transform:uppercase;padding:16px 0;text-decoration:none;border-bottom:2px solid rgba(231,233,225,0.3);">Lihat Kategori Produk &#8595;</a>
      </div>
    </div>
    <div style="display:flex;align-items:center;padding:80px 60px 80px 40px;">
      <div style="border:2px dashed #2E4A4A;padding:36px 32px;position:relative;background:rgba(13,19,22,0.85);backdrop-filter:blur(8px);width:100%;">
        <div style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:28px;padding-bottom:16px;border-bottom:1px dashed #2E4A4A;">MANIFEST PENGIRIMAN &middot; BATCH #BS-TODAY</div>
        <div style="margin-bottom:24px;">
          <div style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#7A8481;letter-spacing:0.15em;text-transform:uppercase;margin-bottom:6px;">TANGKAPAN HARI INI</div>
          <div style="font-family:'IBM Plex Mono',monospace;font-size:32px;color:#E7E9E1;font-weight:500;">04:00 WIB</div>
          <div style="font-family:'IBM Plex Sans',sans-serif;font-size:12px;color:#7A8481;margin-top:4px;">Langsung dari TPI &amp; nelayan lokal</div>
        </div>
        <div style="margin-bottom:24px;">
          <div style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#7A8481;letter-spacing:0.15em;text-transform:uppercase;margin-bottom:6px;">SUHU RANTAI DINGIN</div>
          <div style="font-family:'IBM Plex Mono',monospace;font-size:32px;color:#E7E9E1;font-weight:500;">0&#8211;2&deg;C</div>
          <div style="font-family:'IBM Plex Sans',sans-serif;font-size:12px;color:#7A8481;margin-top:4px;">Es curah + box styrofoam sealed</div>
        </div>
        <div style="margin-bottom:32px;">
          <div style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#7A8481;letter-spacing:0.15em;text-transform:uppercase;margin-bottom:6px;">RADIUS KIRIM</div>
          <div style="font-family:'IBM Plex Mono',monospace;font-size:32px;color:#E7E9E1;font-weight:500;">50 KM</div>
          <div style="font-family:'IBM Plex Sans',sans-serif;font-size:12px;color:#7A8481;margin-top:4px;">Jabodetabek &amp; sekitarnya</div>
        </div>
        <div style="padding-top:20px;border-top:1px dashed #2E4A4A;">
          <div style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#7A8481;letter-spacing:0.1em;text-transform:uppercase;">ESTIMASI TIBA DI DAPUR</div>
          <div style="font-family:'IBM Plex Mono',monospace;font-size:20px;color:#C2401C;font-weight:500;margin-top:4px;">Sebelum 11:00 WIB</div>
        </div>
        <div style="position:absolute;top:-20px;right:24px;width:72px;height:72px;background:#C2401C;border-radius:50%;display:flex;flex-direction:column;align-items:center;justify-content:center;transform:rotate(3deg);box-shadow:0 4px 16px rgba(194,64,28,0.5);">
          <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:8px;color:#E7E9E1;letter-spacing:0.15em;text-transform:uppercase;">GRADE</div>
          <div style="font-family:Oswald,sans-serif;font-weight:900;font-size:26px;color:#E7E9E1;line-height:1;">A</div>
        </div>
      </div>
    </div>
  </div>
</div>
NOWDOC;

$stats = <<<NOWDOC
<div style="display:grid;grid-template-columns:repeat(4,1fr);align-items:center;padding:36px 80px;background:#E7E9E1;">
  <div style="text-align:center;"><div style="font-family:Oswald,sans-serif;font-weight:800;font-size:42px;color:#12181B;line-height:1;">50+</div><div style="font-family:'IBM Plex Sans',sans-serif;font-size:11px;color:#7A8481;margin-top:6px;letter-spacing:0.08em;text-transform:uppercase;">Mitra Hotel &amp; Restoran</div></div>
  <div style="text-align:center;border-left:1px solid #C8CBC3;border-right:1px solid #C8CBC3;"><div style="font-family:Oswald,sans-serif;font-weight:800;font-size:42px;color:#12181B;line-height:1;">2 Ton</div><div style="font-family:'IBM Plex Sans',sans-serif;font-size:11px;color:#7A8481;margin-top:6px;letter-spacing:0.08em;text-transform:uppercase;">Kapasitas Suplai/Hari</div></div>
  <div style="text-align:center;border-right:1px solid #C8CBC3;"><div style="font-family:Oswald,sans-serif;font-weight:800;font-size:42px;color:#12181B;line-height:1;">04:00</div><div style="font-family:'IBM Plex Sans',sans-serif;font-size:11px;color:#7A8481;margin-top:6px;letter-spacing:0.08em;text-transform:uppercase;">Mulai Operasional WIB</div></div>
  <div style="text-align:center;"><div style="font-family:Oswald,sans-serif;font-weight:800;font-size:42px;color:#C2401C;line-height:1;">0&#8211;2&deg;C</div><div style="font-family:'IBM Plex Sans',sans-serif;font-size:11px;color:#7A8481;margin-top:6px;letter-spacing:0.08em;text-transform:uppercase;">Suhu Cold-Chain Terjaga</div></div>
</div>
NOWDOC;

$strip = <<<NOWDOC
<div id="manifest" style="background:#0D1316;padding:60px 80px 0;">
  <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:16px;">DAFTAR MANIFEST PRODUK</div>
  <h2 style="font-family:Oswald,sans-serif;font-weight:700;font-size:52px;color:#E7E9E1;line-height:0.95;letter-spacing:-0.02em;margin:0 0 48px;">Empat Kategori Pengiriman</h2>
</div>
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:2px;background:#0D1316;">
  <a href="/wordpress/produk" style="display:block;position:relative;height:440px;overflow:hidden;text-decoration:none;">
    <img src="https://images.unsplash.com/photo-1615141982883-c7ad0e69fd62?ixid=M3wxMDAzMzMxfDB8MXxzZWFyY2h8MXx8ZnJlc2glMjByYXclMjBmaXNoJTIwaWNlJTIwbWFya2V0fGVufDB8MHx8fDE3ODQ2MTQ5NTF8MA&ixlib=rb-4.1.0&w=1600&q=85&fm=jpg&fit=crop" alt="Ikan Segar TPI" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;" />
    <div style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(13,19,22,0.05) 0%,rgba(13,19,22,0.9) 100%);"></div>
    <div style="position:absolute;bottom:0;left:0;right:0;padding:36px 32px;">
      <div style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:12px;">01 / IKAN SEGAR</div>
      <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:30px;color:#E7E9E1;line-height:1;margin-bottom:10px;">Ikan Segar</div>
      <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:rgba(231,233,225,0.6);line-height:1.5;margin-bottom:18px;">Kakap, kerapu, tenggiri, bawal, tuna &mdash; dari TPI jam 4 pagi</div>
      <span style="font-family:Oswald,sans-serif;font-size:12px;color:#E7E9E1;letter-spacing:0.12em;text-transform:uppercase;border-bottom:1px solid rgba(231,233,225,0.35);padding-bottom:4px;">Tanya Ketersediaan &#8594;</span>
    </div>
  </a>
  <a href="/wordpress/produk" style="display:block;position:relative;height:440px;overflow:hidden;text-decoration:none;">
    <img src="https://images.unsplash.com/photo-1504309250229-4f08315f3b5c?ixid=M3wxMDAzMzMxfDB8MXxzZWFyY2h8MXx8ZnJlc2glMjBzaHJpbXAlMjBwcmF3biUyMHJhd3xlbnwwfDB8fHwxNzg0NjE0OTYwfDA&ixlib=rb-4.1.0&w=1600&q=85&fm=jpg&fit=crop" alt="Udang Seafood" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;" />
    <div style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(13,19,22,0.05) 0%,rgba(13,19,22,0.9) 100%);"></div>
    <div style="position:absolute;bottom:0;left:0;right:0;padding:36px 32px;">
      <div style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#7A8481;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:12px;">02 / UDANG &amp; SEAFOOD BEKU</div>
      <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:30px;color:#E7E9E1;line-height:1;margin-bottom:10px;">Udang &amp; Seafood Beku</div>
      <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:rgba(231,233,225,0.6);line-height:1.5;margin-bottom:18px;">Vaname IQF, Tiger, Galah &mdash; size 16/20 hingga 61/70</div>
      <span style="font-family:Oswald,sans-serif;font-size:12px;color:#E7E9E1;letter-spacing:0.12em;text-transform:uppercase;border-bottom:1px solid rgba(231,233,225,0.35);padding-bottom:4px;">Tanya Ketersediaan &#8594;</span>
    </div>
  </a>
  <a href="/wordpress/produk" style="display:block;position:relative;height:440px;overflow:hidden;text-decoration:none;">
    <img src="https://images.unsplash.com/photo-1760047558843-e8c72b494c0d?ixid=M3wxMDAzMzMxfDB8MXxzZWFyY2h8MXx8ZnJlc2glMjBzcXVpZCUyMHJhdyUyMHNlYWZvb2R8ZW58MHwwfHx8MTc4NDYxNDk1N3ww&ixlib=rb-4.1.0&w=1600&q=85&fm=jpg&fit=crop" alt="Cumi Kepiting" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;" />
    <div style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(13,19,22,0.05) 0%,rgba(13,19,22,0.9) 100%);"></div>
    <div style="position:absolute;bottom:0;left:0;right:0;padding:36px 32px;">
      <div style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#7A8481;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:12px;">03 / CUMI, KERANG &amp; KEPITING</div>
      <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:30px;color:#E7E9E1;line-height:1;margin-bottom:10px;">Cumi, Kerang &amp; Kepiting</div>
      <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:rgba(231,233,225,0.6);line-height:1.5;margin-bottom:18px;">Cumi segar, kepiting bakau, kerang hijau, rajungan</div>
      <span style="font-family:Oswald,sans-serif;font-size:12px;color:#E7E9E1;letter-spacing:0.12em;text-transform:uppercase;border-bottom:1px solid rgba(231,233,225,0.35);padding-bottom:4px;">Tanya Ketersediaan &#8594;</span>
    </div>
  </a>
</div>
<div style="background:#0D1316;text-align:center;padding:48px;">
  <a href="/wordpress/produk" style="display:inline-block;background:transparent;color:#E7E9E1;font-family:Oswald,sans-serif;font-weight:700;font-size:13px;letter-spacing:0.12em;text-transform:uppercase;padding:14px 40px;text-decoration:none;border:2px solid rgba(231,233,225,0.3);">Lihat Katalog Lengkap &#8594;</a>
</div>
NOWDOC;

$zigzag = <<<NOWDOC
<div style="display:grid;grid-template-columns:1fr 1fr;min-height:560px;">
  <div style="position:relative;overflow:hidden;">
    <img src="https://images.unsplash.com/photo-1576668919998-78ce5ffc3bd7?ixid=M3wxMDAzMzMxfDB8MXxzZWFyY2h8MXx8ZmlzaCUyMHdlaWdoaW5nJTIwc2NhbGUlMjB3b3JrZXJ8ZW58MHwwfHx8MTc4NDYxNDk1NHww&ixlib=rb-4.1.0&w=1600&q=85&fm=jpg&fit=crop" alt="Proses grading dan penimbangan ikan di TPI" style="width:100%;height:100%;object-fit:cover;min-height:560px;filter:brightness(0.85) contrast(1.1);" />
  </div>
  <div style="display:flex;align-items:center;padding:80px 80px 80px 60px;background:#E7E9E1;">
    <div>
      <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:20px;">PROSES RANTAI SUPLAI</div>
      <h2 style="font-family:Oswald,sans-serif;font-weight:800;font-size:48px;color:#12181B;line-height:0.95;letter-spacing:-0.025em;margin:0 0 28px;">Dari Pelelangan ke Dapur Anda, Tanpa Jeda Freezer.</h2>
      <p style="font-family:'IBM Plex Sans',sans-serif;font-size:16px;color:#4A5250;line-height:1.7;margin-bottom:36px;">Tim kami tiba di TPI sebelum kapal nelayan bersandar. Setiap batch dicatat jam tangkap, berat, dan kondisi grading. Tidak ada yang masuk ke kendaraan tanpa lolos pemeriksaan.</p>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:40px;">
        <div style="border-top:3px solid #C2401C;padding-top:16px;">
          <div style="font-family:'IBM Plex Mono',monospace;font-size:24px;color:#C2401C;margin-bottom:6px;">03:00</div>
          <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:16px;color:#12181B;margin-bottom:4px;">Berangkat ke TPI</div>
          <div style="font-family:'IBM Plex Sans',sans-serif;font-size:12px;color:#4A5250;">Grading langsung di TPI</div>
        </div>
        <div style="border-top:3px solid #B8BDB8;padding-top:16px;">
          <div style="font-family:'IBM Plex Mono',monospace;font-size:24px;color:#12181B;margin-bottom:6px;">05:30</div>
          <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:16px;color:#12181B;margin-bottom:4px;">Pengiriman Dimulai</div>
          <div style="font-family:'IBM Plex Sans',sans-serif;font-size:12px;color:#4A5250;">Armada berpendingin 0&#8211;2&deg;C</div>
        </div>
      </div>
      <a href="/wordpress/tentang-kami" style="display:inline-block;background:#12181B;color:#E7E9E1;font-family:Oswald,sans-serif;font-weight:700;font-size:13px;letter-spacing:0.1em;text-transform:uppercase;padding:16px 32px;text-decoration:none;">Tentang Kami &#8594;</a>
    </div>
  </div>
</div>
NOWDOC;

$testi = <<<NOWDOC
<div style="position:relative;min-height:480px;overflow:hidden;">
  <img src="https://images.unsplash.com/photo-1597409244351-79ff2d5da5ee?ixid=M3wxMDAzMzMxfDB8MXxzZWFyY2h8MXx8ZmlzaCUyMG1hcmtldCUyMHZlbmRvcnxlbnwwfDB8fHwxNzg0NjE0OTU4fDA&ixlib=rb-4.1.0&w=1600&q=85&fm=jpg&fit=crop" alt="Mitra pasar ikan Bahari Segar" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;" />
  <div style="position:absolute;inset:0;background:linear-gradient(105deg,rgba(13,19,22,0.95) 40%,rgba(13,19,22,0.5) 100%);"></div>
  <div style="position:relative;z-index:1;padding:80px;max-width:620px;">
    <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:20px;">TESTIMONI MITRA</div>
    <div style="font-family:Oswald,sans-serif;font-weight:800;font-size:64px;color:#C2401C;line-height:0.7;margin-bottom:20px;">&ldquo;</div>
    <blockquote style="font-family:Oswald,sans-serif;font-weight:700;font-size:28px;color:#E7E9E1;line-height:1.2;letter-spacing:-0.01em;margin:0 0 32px;border:none;padding:0;">Chef kami tidak perlu cek kondisi ikan setiap pagi &mdash; kami sudah tahu Bahari Segar tidak pernah kirim yang tidak layak.</blockquote>
    <div style="display:flex;align-items:center;gap:16px;">
      <div style="width:48px;height:48px;background:#C2401C;border-radius:50%;display:flex;flex-direction:column;align-items:center;justify-content:center;transform:rotate(-3deg);flex-shrink:0;">
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:7px;color:#E7E9E1;letter-spacing:0.1em;">GRADE</div>
        <div style="font-family:Oswald,sans-serif;font-weight:900;font-size:18px;color:#E7E9E1;line-height:1;">A</div>
      </div>
      <div>
        <div style="font-family:'IBM Plex Sans',sans-serif;font-weight:600;font-size:14px;color:#E7E9E1;">Executive Chef Bambang S.</div>
        <div style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#7A8481;margin-top:3px;letter-spacing:0.08em;">Hotel Bintang 5 &middot; Jakarta Selatan &middot; Mitra sejak 2021</div>
      </div>
    </div>
  </div>
</div>
NOWDOC;

$cta_b = <<<NOWDOC
<div style="background:#C2401C;padding:80px;">
  <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:40px;">
    <div>
      <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:rgba(231,233,225,0.55);letter-spacing:0.2em;text-transform:uppercase;margin-bottom:12px;">MULAI KERJASAMA HARI INI</div>
      <h2 style="font-family:Oswald,sans-serif;font-weight:800;font-size:44px;color:#E7E9E1;line-height:0.95;letter-spacing:-0.025em;margin:0;">Siap Suplai Dapur Anda<br>Besok Pagi?</h2>
    </div>
    <div style="display:flex;gap:16px;flex-wrap:wrap;">
      <a href="https://wa.me/6281234567890?text=Halo%20Bahari%20Segar" target="_blank" rel="noopener" style="display:inline-block;background:#E7E9E1;color:#C2401C;font-family:Oswald,sans-serif;font-weight:700;font-size:14px;letter-spacing:0.08em;text-transform:uppercase;padding:18px 36px;text-decoration:none;">Chat WhatsApp Sekarang</a>
      <a href="/wordpress/kerjasama-b2b" style="display:inline-block;background:transparent;color:#E7E9E1;font-family:Oswald,sans-serif;font-weight:700;font-size:14px;letter-spacing:0.08em;text-transform:uppercase;padding:18px 36px;text-decoration:none;border:2px solid rgba(231,233,225,0.4);">Isi Form Kerjasama</a>
    </div>
  </div>
</div>
NOWDOC;

// Replace PLACEHOLDER values with actual constants
foreach(['hero'=>'H','stats'=>'','strip'=>'','zigzag'=>'','testi'=>'','cta_b'=>''] as $var=>$_) {
    // Apply str_replace for all placeholders in each variable
}
$sections_b = [
    sc('bs-hero',  '#0D1316', [cl('bs-hc',100,[ht('bs-hw',$hero)])]),
    sc('bs-stats', SL,        [cl('bs-sc',100,[ht('bs-sw',$stats)])]),
    sc('bs-strip', '#0D1316', [cl('bs-tc',100,[ht('bs-tw',$strip)])]),
    sc('bs-zig',   SL,        [cl('bs-zc',100,[ht('bs-zw',$zigzag)])]),
    sc('bs-testi', '#0D1316', [cl('bs-xc',100,[ht('bs-xw',$testi)])]),
    sc('bs-cta',   '#C2401C', [cl('bs-cc',100,[ht('bs-cw',$cta_b)])]),
];
up($pdo,$ids['beranda'],'_elementor_data',json_encode($sections_b,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
up($pdo,$ids['beranda'],'_elementor_edit_mode','builder');
up($pdo,$ids['beranda'],'_wp_page_template','elementor_canvas');
echo "  OK Beranda\n";

// ───── TENTANG KAMI ─────────────────────────────────────────────────────────
echo "[2/3] Tentang Kami...\n";

$ta_hero = <<<NOWDOC
<div style="position:relative;min-height:600px;overflow:hidden;">
  <img src="https://images.unsplash.com/photo-1505441716189-50b06af1f43b?ixid=M3wxMDAzMzMxfDB8MXxzZWFyY2h8MXx8ZmlzaGVybWFuJTIwYm9hdCUyMGhhcmJvciUyMG1vcm5pbmd8ZW58MHwwfHx8MTc4NDYxNDk1OXww&ixlib=rb-4.1.0&w=1600&q=85&fm=jpg&fit=crop" alt="Nelayan dan kapal di pelabuhan dini hari" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;filter:brightness(0.72);" />
  <div style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(13,19,22,0.3) 0%,rgba(13,19,22,0.97) 70%);"></div>
  <div style="position:relative;z-index:1;min-height:600px;display:flex;flex-direction:column;justify-content:flex-end;padding:60px 80px 80px;">
    <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:16px;">TENTANG KAMI</div>
    <h1 style="font-family:Oswald,sans-serif;font-weight:800;font-size:clamp(2.5rem,6vw,5rem);color:#E7E9E1;line-height:0.95;letter-spacing:-0.025em;margin:0 0 24px;max-width:800px;">Bukan Sekadar Suplier.<br>Kami Bagian dari Dapur Anda.</h1>
    <p style="font-family:'IBM Plex Sans',sans-serif;font-size:17px;color:rgba(231,233,225,0.55);max-width:580px;line-height:1.65;margin:0;">Bahari Segar berdiri dari satu keresahan: sulit mendapat pasokan seafood segar yang konsisten dan terdokumentasi.</p>
  </div>
</div>
NOWDOC;

$ta_body = <<<NOWDOC
<div style="background:#12181B;padding:100px 80px;">
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:start;">
    <div>
      <p style="font-family:'IBM Plex Sans',sans-serif;font-size:18px;color:#E7E9E1;line-height:1.75;margin-bottom:28px;">Kami membangun hubungan langsung dengan nelayan dan TPI. Setiap batch yang kami ambil dicatat: jam tangkap, berat, ukuran, kondisi saat grading.</p>
      <p style="font-family:'IBM Plex Sans',sans-serif;font-size:16px;color:#7A8481;line-height:1.75;margin-bottom:48px;">Mitra kami &mdash; chef di hotel bintang lima hingga restoran seafood independen &mdash; tidak perlu khawatir soal kualitas. Sebelum jam 11 pagi, produk kami sudah di tangan mereka.</p>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:1px;background:#1E2A2A;">
        <div style="background:#0D1316;padding:32px 28px;"><div style="font-family:'IBM Plex Mono',monospace;font-size:36px;color:#C2401C;margin-bottom:8px;">2018</div><div style="font-family:'IBM Plex Sans',sans-serif;font-size:11px;color:#7A8481;text-transform:uppercase;letter-spacing:0.08em;">Berdiri sejak</div></div>
        <div style="background:#0D1316;padding:32px 28px;"><div style="font-family:'IBM Plex Mono',monospace;font-size:36px;color:#E7E9E1;margin-bottom:8px;">50+</div><div style="font-family:'IBM Plex Sans',sans-serif;font-size:11px;color:#7A8481;text-transform:uppercase;letter-spacing:0.08em;">Mitra aktif</div></div>
        <div style="background:#0D1316;padding:32px 28px;"><div style="font-family:'IBM Plex Mono',monospace;font-size:36px;color:#E7E9E1;margin-bottom:8px;">2 Ton</div><div style="font-family:'IBM Plex Sans',sans-serif;font-size:11px;color:#7A8481;text-transform:uppercase;letter-spacing:0.08em;">Kapasitas/hari</div></div>
        <div style="background:#0D1316;padding:32px 28px;"><div style="font-family:'IBM Plex Mono',monospace;font-size:36px;color:#C2401C;margin-bottom:8px;">03:00</div><div style="font-family:'IBM Plex Sans',sans-serif;font-size:11px;color:#7A8481;text-transform:uppercase;letter-spacing:0.08em;">Mulai operasi</div></div>
      </div>
    </div>
    <div style="position:relative;">
      <img src="https://images.unsplash.com/photo-1498654200943-1088dd4438ae?ixid=M3wxMDAzMzMxfDB8MXxzZWFyY2h8Mnx8ZmlzaCUyMGljZSUyMGNvbGQlMjBzdG9yYWdlfGVufDB8MHx8fDE3ODQ2MTQ5NTZ8MA&ixlib=rb-4.1.0&w=1600&q=85&fm=jpg&fit=crop" alt="Cold chain penyimpanan seafood" style="width:100%;height:500px;object-fit:cover;display:block;" />
      <div style="position:absolute;bottom:0;left:0;right:0;background:linear-gradient(180deg,transparent,rgba(13,19,22,0.88));padding:28px 24px;">
        <div style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#C2401C;letter-spacing:0.15em;text-transform:uppercase;margin-bottom:6px;">COLD CHAIN TERJAGA</div>
        <div style="font-family:'IBM Plex Mono',monospace;font-size:18px;color:#E7E9E1;">0&#8211;2&deg;C dari TPI ke dapur Anda</div>
      </div>
      <div style="position:absolute;top:20px;right:20px;width:68px;height:68px;background:#C2401C;border-radius:50%;display:flex;flex-direction:column;align-items:center;justify-content:center;transform:rotate(3deg);box-shadow:0 4px 16px rgba(194,64,28,0.45);">
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:7px;color:#E7E9E1;letter-spacing:0.12em;">GRADE</div>
        <div style="font-family:Oswald,sans-serif;font-weight:900;font-size:24px;color:#E7E9E1;line-height:1;">A</div>
      </div>
    </div>
  </div>
</div>
NOWDOC;

$ta_cta = <<<NOWDOC
<div style="background:#C2401C;padding:80px;">
  <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:32px;">
    <div>
      <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:rgba(231,233,225,0.55);letter-spacing:0.2em;text-transform:uppercase;margin-bottom:12px;">MULAI KERJASAMA</div>
      <h2 style="font-family:Oswald,sans-serif;font-weight:800;font-size:40px;color:#E7E9E1;line-height:1;margin:0;">Jadi Mitra Bahari Segar</h2>
    </div>
    <div style="display:flex;gap:16px;">
      <a href="https://wa.me/6281234567890?text=Halo%20Bahari%20Segar%2C%20saya%20ingin%20jadi%20mitra" target="_blank" style="display:inline-block;background:#E7E9E1;color:#C2401C;font-family:Oswald,sans-serif;font-weight:700;font-size:13px;letter-spacing:0.08em;text-transform:uppercase;padding:16px 32px;text-decoration:none;">Chat WhatsApp &#8594;</a>
      <a href="/wordpress/kerjasama-b2b" style="display:inline-block;background:transparent;color:#E7E9E1;font-family:Oswald,sans-serif;font-weight:700;font-size:13px;letter-spacing:0.08em;text-transform:uppercase;padding:16px 32px;text-decoration:none;border:2px solid rgba(231,233,225,0.4);">Form Kerjasama</a>
    </div>
  </div>
</div>
NOWDOC;

$sections_t = [
    sc('ta-hero','#0D1316',[cl('ta-hc',100,[ht('ta-hw',$ta_hero)])]),
    sc('ta-body','#12181B',[cl('ta-bc',100,[ht('ta-bw',$ta_body)])]),
    sc('ta-cta', '#C2401C',[cl('ta-cc',100,[ht('ta-cw',$ta_cta)])]),
];
up($pdo,$ids['tentang'],'_elementor_data',json_encode($sections_t,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
up($pdo,$ids['tentang'],'_elementor_edit_mode','builder');
up($pdo,$ids['tentang'],'_wp_page_template','elementor_canvas');
echo "  OK Tentang Kami\n";

// ───── PRODUK ─────────────────────────────────────────────────────────────
echo "[3/3] Produk (card photos + GRADE A badges)...\n";

$pr_hero = <<<NOWDOC
<div style="position:relative;min-height:500px;overflow:hidden;">
  <img src="https://images.unsplash.com/photo-1597409244351-79ff2d5da5ee?ixid=M3wxMDAzMzMxfDB8MXxzZWFyY2h8MXx8ZmlzaCUyMG1hcmtldCUyMHZlbmRvcnxlbnwwfDB8fHwxNzg0NjE0OTU4fDA&ixlib=rb-4.1.0&w=1600&q=85&fm=jpg&fit=crop" alt="Katalog produk ikan segar pelelangan" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;filter:brightness(0.68);" />
  <div style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(13,19,22,0.2) 0%,rgba(13,19,22,0.97) 70%);"></div>
  <div style="position:relative;z-index:1;min-height:500px;display:flex;flex-direction:column;justify-content:flex-end;padding:60px 80px 70px;">
    <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:16px;">KATALOG PRODUK</div>
    <h1 style="font-family:Oswald,sans-serif;font-weight:800;font-size:clamp(2.5rem,6vw,5rem);color:#E7E9E1;line-height:0.95;letter-spacing:-0.025em;margin:0 0 20px;">Ikan Segar, Udang, Cumi<br>&amp; Olahan Hasil Laut.</h1>
    <p style="font-family:'IBM Plex Sans',sans-serif;font-size:16px;color:rgba(231,233,225,0.55);max-width:520px;line-height:1.65;margin:0;">Semua dipilih langsung dari TPI jam 4 pagi. Harga grosir untuk hotel dan restoran.</p>
  </div>
</div>
NOWDOC;

$pr_cards = <<<NOWDOC
<div style="background:#12181B;padding:80px;">
  <div style="display:flex;align-items:baseline;gap:20px;margin-bottom:40px;padding-bottom:24px;border-bottom:1px solid #1E2A2A;">
    <span style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;">01</span>
    <h2 style="font-family:Oswald,sans-serif;font-weight:700;font-size:40px;color:#E7E9E1;line-height:1;margin:0;">Ikan Segar</h2>
    <span style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#7A8481;letter-spacing:0.1em;text-transform:uppercase;margin-left:auto;">Tersedia sepanjang tahun</span>
  </div>
  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:2px;margin-bottom:2px;">

    <div style="background:#0D1316;border-top:3px solid #C2401C;overflow:hidden;">
      <div style="position:relative;aspect-ratio:4/5;overflow:hidden;">
        <img src="https://images.unsplash.com/photo-1764345704514-7bf2934f360b?ixid=M3wxMDAzMzMxfDB8MXxzZWFyY2h8MXx8cmVkJTIwc25hcHBlciUyMGZpc2glMjBmcmVzaHxlbnwwfDF8fHwxNzg0NjE0OTYxfDA&ixlib=rb-4.1.0&w=600&h=750&q=85&fm=jpg&fit=crop" alt="Kakap Merah Segar Grade A" style="width:100%;height:100%;object-fit:cover;filter:brightness(0.9);" />
        <div style="position:absolute;top:12px;right:12px;width:52px;height:52px;background:#C2401C;border-radius:50%;display:flex;flex-direction:column;align-items:center;justify-content:center;transform:rotate(4deg);box-shadow:0 3px 10px rgba(194,64,28,0.5);">
          <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:6px;color:#E7E9E1;letter-spacing:0.12em;line-height:1;">GRADE</div>
          <div style="font-family:Oswald,sans-serif;font-weight:900;font-size:18px;color:#E7E9E1;line-height:1;">A</div>
        </div>
      </div>
      <div style="padding:28px;">
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:22px;color:#E7E9E1;margin-bottom:10px;">Kakap Merah</div>
        <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:#7A8481;line-height:1.6;margin-bottom:18px;">Sisik utuh, mata jernih, insang merah cerah. 300g&ndash;2kg/ekor.</div>
        <a href="https://wa.me/6281234567890?text=Tanya%20stok%20Kakap%20Merah" target="_blank" style="display:inline-block;background:#C2401C;color:#E7E9E1;font-family:Oswald,sans-serif;font-weight:700;font-size:11px;letter-spacing:0.1em;text-transform:uppercase;padding:10px 20px;text-decoration:none;">Tanya Ketersediaan</a>
      </div>
    </div>

    <div style="background:#0D1316;border-top:3px solid #2E4A4A;overflow:hidden;">
      <div style="position:relative;aspect-ratio:4/5;overflow:hidden;">
        <img src="https://images.unsplash.com/photo-1682045284951-d2dce9ff24a5?ixid=M3wxMDAzMzMxfDB8MXxzZWFyY2h8MXx8Z3JvdXBlciUyMGZpc2glMjBmcmVzaCUyMHdob2xlfGVufDB8MXx8fDE3ODQ2MTQ5NjJ8MA&ixlib=rb-4.1.0&w=600&h=750&q=85&fm=jpg&fit=crop" alt="Kerapu Segar Grade A" style="width:100%;height:100%;object-fit:cover;filter:brightness(0.9);" />
        <div style="position:absolute;top:12px;right:12px;width:52px;height:52px;background:#C2401C;border-radius:50%;display:flex;flex-direction:column;align-items:center;justify-content:center;transform:rotate(-3deg);box-shadow:0 3px 10px rgba(194,64,28,0.5);">
          <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:6px;color:#E7E9E1;letter-spacing:0.12em;line-height:1;">GRADE</div>
          <div style="font-family:Oswald,sans-serif;font-weight:900;font-size:18px;color:#E7E9E1;line-height:1;">A</div>
        </div>
      </div>
      <div style="padding:28px;">
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:22px;color:#E7E9E1;margin-bottom:10px;">Kerapu Segar</div>
        <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:#7A8481;line-height:1.6;margin-bottom:18px;">Kerapu macan, tikus, bebek. Kualitas ekspor, 400g&ndash;3kg/ekor.</div>
        <a href="https://wa.me/6281234567890?text=Tanya%20stok%20Kerapu" target="_blank" style="display:inline-block;background:transparent;color:#C2401C;font-family:Oswald,sans-serif;font-weight:700;font-size:11px;letter-spacing:0.1em;text-transform:uppercase;padding:10px 20px;text-decoration:none;border:1px solid #C2401C;">Tanya Ketersediaan</a>
      </div>
    </div>

    <div style="background:#0D1316;border-top:3px solid #2E4A4A;overflow:hidden;">
      <div style="position:relative;aspect-ratio:4/5;overflow:hidden;">
        <img src="https://images.unsplash.com/photo-1682457569891-53e4f6ef9271?ixid=M3wxMDAzMzMxfDB8MXxzZWFyY2h8MXx8ZnJlc2glMjB0dW5hJTIwZmlzaCUyMHdob2xlfGVufDB8MXx8fDE3ODQ2MTQ5NjN8MA&ixlib=rb-4.1.0&w=600&h=750&q=85&fm=jpg&fit=crop" alt="Tuna Segar Grade A" style="width:100%;height:100%;object-fit:cover;filter:brightness(0.9);" />
        <div style="position:absolute;top:12px;right:12px;width:52px;height:52px;background:#C2401C;border-radius:50%;display:flex;flex-direction:column;align-items:center;justify-content:center;transform:rotate(3deg);box-shadow:0 3px 10px rgba(194,64,28,0.5);">
          <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:6px;color:#E7E9E1;letter-spacing:0.12em;line-height:1;">GRADE</div>
          <div style="font-family:Oswald,sans-serif;font-weight:900;font-size:18px;color:#E7E9E1;line-height:1;">A</div>
        </div>
      </div>
      <div style="padding:28px;">
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:22px;color:#E7E9E1;margin-bottom:10px;">Tuna Segar</div>
        <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:#7A8481;line-height:1.6;margin-bottom:18px;">Utuh dan loin siap olah. Grading standar ekspor Jepang. 2&ndash;30kg/ekor.</div>
        <a href="https://wa.me/6281234567890?text=Tanya%20stok%20Tuna" target="_blank" style="display:inline-block;background:transparent;color:#C2401C;font-family:Oswald,sans-serif;font-weight:700;font-size:11px;letter-spacing:0.1em;text-transform:uppercase;padding:10px 20px;text-decoration:none;border:1px solid #C2401C;">Tanya Ketersediaan</a>
      </div>
    </div>
  </div>

  <div style="display:grid;grid-template-columns:1fr 1fr;gap:2px;">
    <div style="background:#0D1316;border-top:3px solid #2E4A4A;overflow:hidden;display:grid;grid-template-columns:5fr 7fr;">
      <div style="position:relative;overflow:hidden;min-height:220px;">
        <img src="https://images.unsplash.com/photo-1735053671690-97833aac117a?ixid=M3wxMDAzMzMxfDB8MXxzZWFyY2h8MXx8bWFja2VyZWwlMjBmaXNoJTIwZnJlc2glMjByYXd8ZW58MHwxfHx8MTc4NDYxNDk2NHww&ixlib=rb-4.1.0&w=600&h=750&q=85&fm=jpg&fit=crop" alt="Tenggiri Segar Grade A" style="width:100%;height:100%;object-fit:cover;filter:brightness(0.88);" />
        <div style="position:absolute;top:10px;right:10px;width:44px;height:44px;background:#C2401C;border-radius:50%;display:flex;flex-direction:column;align-items:center;justify-content:center;transform:rotate(4deg);">
          <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:5px;color:#E7E9E1;letter-spacing:0.1em;">GRADE</div>
          <div style="font-family:Oswald,sans-serif;font-weight:900;font-size:14px;color:#E7E9E1;line-height:1;">A</div>
        </div>
      </div>
      <div style="padding:24px 28px;display:flex;flex-direction:column;justify-content:center;">
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:20px;color:#E7E9E1;margin-bottom:10px;">Tenggiri Segar</div>
        <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:#7A8481;line-height:1.6;margin-bottom:16px;">Ideal untuk ikan bakar, pepes, dapur hotel. 500g&ndash;4kg/ekor.</div>
        <a href="https://wa.me/6281234567890?text=Tanya%20stok%20Tenggiri" target="_blank" style="display:inline-block;background:transparent;color:#C2401C;font-family:Oswald,sans-serif;font-weight:700;font-size:11px;letter-spacing:0.1em;text-transform:uppercase;padding:8px 16px;text-decoration:none;border:1px solid #C2401C;width:fit-content;">Tanya Stok</a>
      </div>
    </div>

    <div style="background:#0D1316;border-top:3px solid #2E4A4A;overflow:hidden;display:grid;grid-template-columns:5fr 7fr;">
      <div style="position:relative;overflow:hidden;min-height:220px;">
        <img src="https://images.unsplash.com/photo-1706167754870-54c07a883197?ixid=M3wxMDAzMzMxfDB8MXxzZWFyY2h8MXx8c2lsdmVyJTIwZmlzaCUyMGZyZXNoJTIwd2hvbGUlMjByYXd8ZW58MHwxfHx8MTc4NDYxNDk2Nnww&ixlib=rb-4.1.0&w=600&h=750&q=85&fm=jpg&fit=crop" alt="Bawal Segar Grade A" style="width:100%;height:100%;object-fit:cover;filter:brightness(0.88);" />
        <div style="position:absolute;top:10px;right:10px;width:44px;height:44px;background:#C2401C;border-radius:50%;display:flex;flex-direction:column;align-items:center;justify-content:center;transform:rotate(-4deg);">
          <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:5px;color:#E7E9E1;letter-spacing:0.1em;">GRADE</div>
          <div style="font-family:Oswald,sans-serif;font-weight:900;font-size:14px;color:#E7E9E1;line-height:1;">A</div>
        </div>
      </div>
      <div style="padding:24px 28px;display:flex;flex-direction:column;justify-content:center;">
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:20px;color:#E7E9E1;margin-bottom:10px;">Bawal Segar</div>
        <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:#7A8481;line-height:1.6;margin-bottom:16px;">Bawal putih &amp; hitam. 200g&ndash;1kg/ekor. Chinese restaurant.</div>
        <a href="https://wa.me/6281234567890?text=Tanya%20stok%20Bawal" target="_blank" style="display:inline-block;background:transparent;color:#C2401C;font-family:Oswald,sans-serif;font-weight:700;font-size:11px;letter-spacing:0.1em;text-transform:uppercase;padding:8px 16px;text-decoration:none;border:1px solid #C2401C;width:fit-content;">Tanya Stok</a>
      </div>
    </div>
  </div>
</div>
NOWDOC;

$pr_cta = <<<NOWDOC
<div style="background:#C2401C;padding:60px 80px;">
  <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:32px;">
    <div>
      <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:rgba(231,233,225,0.55);letter-spacing:0.2em;text-transform:uppercase;margin-bottom:8px;">HARGA GROSIR B2B</div>
      <h2 style="font-family:Oswald,sans-serif;font-weight:800;font-size:36px;color:#E7E9E1;line-height:1;margin:0;">Hubungi Kami untuk Penawaran Volume</h2>
    </div>
    <div style="display:flex;gap:16px;flex-wrap:wrap;">
      <a href="https://wa.me/6281234567890?text=Halo%20Bahari%20Segar%2C%20saya%20ingin%20harga%20grosir" target="_blank" style="display:inline-block;background:#E7E9E1;color:#C2401C;font-family:Oswald,sans-serif;font-weight:700;font-size:13px;letter-spacing:0.08em;text-transform:uppercase;padding:16px 32px;text-decoration:none;">Chat WhatsApp &#8594;</a>
      <a href="/wordpress/kerjasama-b2b" style="display:inline-block;background:transparent;color:#E7E9E1;font-family:Oswald,sans-serif;font-weight:700;font-size:13px;letter-spacing:0.08em;text-transform:uppercase;padding:16px 32px;text-decoration:none;border:2px solid rgba(231,233,225,0.4);">Ajukan Kerjasama</a>
    </div>
  </div>
</div>
NOWDOC;

$sections_p = [
    sc('pr-hero','#0D1316',[cl('pr-hc',100,[ht('pr-hw',$pr_hero)])]),
    sc('pr-cards','#12181B',[cl('pr-kc',100,[ht('pr-kw',$pr_cards)])]),
    sc('pr-cta', '#C2401C',[cl('pr-cc',100,[ht('pr-cw',$pr_cta)])]),
];
up($pdo,$ids['produk'],'_elementor_data',json_encode($sections_p,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
up($pdo,$ids['produk'],'_elementor_edit_mode','builder');
up($pdo,$ids['produk'],'_wp_page_template','elementor_canvas');
$pdo->exec("DELETE FROM wp_options WHERE option_name='woocommerce_shop_page_id'");
echo "  OK Produk (with card photos + GRADE A badges)\n";

// ───── CLEAR CACHE ─────────────────────────────────────────────────────────
echo "\nClearing Elementor cache...\n";
$pdo->exec("DELETE FROM wp_options WHERE option_name LIKE '_elementor_css_%'");
$pdo->exec("DELETE FROM wp_options WHERE option_name LIKE '_transient_elementor%'");
$pdo->exec("DELETE FROM wp_options WHERE option_name LIKE '_transient_timeout_elementor%'");

echo "\n============================================\n";
echo "DONE! Surface: #F3EFE4 -> #E7E9E1\n";
echo "Verify: http://localhost/wordpress/\n";
echo "============================================\n\n";
