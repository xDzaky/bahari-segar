<?php
/**
 * 07b-inject-images-nowdoc.php
 * Inject Elementor data dengan NOWDOC (zero escaping issues)
 */

$pdo = new PDO("mysql:host=localhost;dbname=db_wordpress;charset=utf8mb4",
               "root", "gggaming21");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$ids  = json_decode(file_get_contents(__DIR__ . '/page_ids.json'), true);
$WA   = 'https://wa.me/6281234567890';

$IMGS = [
    'hero'     => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=1600&q=85&auto=format&fit=crop',
    'ikan'     => 'https://images.unsplash.com/photo-1534482421-64566f976cfa?w=1200&q=85&auto=format&fit=crop',
    'proses'   => 'https://images.unsplash.com/photo-1607083206968-13611e3d76db?w=1200&q=85&auto=format&fit=crop',
    'cold'     => 'https://images.unsplash.com/photo-1570042225831-d98fa7577f1e?w=1200&q=85&auto=format&fit=crop',
    'market'   => 'https://images.unsplash.com/photo-1559060017-445fb9722f2a?w=1600&q=85&auto=format&fit=crop',
    'tentang'  => 'https://images.unsplash.com/photo-1598515213692-bb2fe38a4df6?w=1600&q=85&auto=format&fit=crop',
    'udang'    => 'https://images.unsplash.com/photo-1565680018434-b513d5e5fd47?w=800&q=85&auto=format&fit=crop',
    'cumi'     => 'https://images.unsplash.com/photo-1604709178681-2b6f0d5c7800?w=800&q=85&auto=format&fit=crop',
];

function upsert_meta($pdo, $post_id, $key, $value) {
    $r = $pdo->prepare("SELECT meta_id FROM wp_postmeta WHERE post_id=? AND meta_key=?");
    $r->execute([$post_id, $key]);
    if ($r->fetch()) {
        $pdo->prepare("UPDATE wp_postmeta SET meta_value=? WHERE post_id=? AND meta_key=?")->execute([$value, $post_id, $key]);
    } else {
        $pdo->prepare("INSERT INTO wp_postmeta (post_id,meta_key,meta_value) VALUES (?,?,?)")->execute([$post_id, $key, $value]);
    }
}

function el_section($id, array $settings, array $cols) {
    return ['id'=>$id,'elType'=>'section','settings'=>$settings,'elements'=>$cols];
}
function el_col($id, $size, array $widgets, array $extra=[]) {
    $s = array_merge(['_column_size'=>$size], $extra);
    return ['id'=>$id,'elType'=>'column','settings'=>$s,'elements'=>$widgets];
}
function el_html($id, $html) {
    return ['id'=>$id,'elType'=>'widget','widgetType'=>'text-editor','settings'=>['editor'=>$html]];
}

echo "\n=== Step 07b: Inject Images via PHP NOWDOC ===\n\n";

// ────────────────────────────────────────────────────────────────────────────
// 1. BERANDA
// ────────────────────────────────────────────────────────────────────────────
echo "[1/3] Beranda...\n";

$hero_img  = $IMGS['hero'];
$ikan_img  = $IMGS['ikan'];
$proses_img= $IMGS['proses'];
$market_img= $IMGS['market'];
$udang_img = $IMGS['udang'];
$cumi_img  = $IMGS['cumi'];

// NOWDOC: tidak ada escaping sama sekali
$hero_html = <<<'NOWDOC'
<div style="position:relative;min-height:100vh;display:flex;align-items:center;">
NOWDOC;
$hero_html .= <<<NOWDOC
  <img src="{$hero_img}" alt="Pasar ikan dini hari Bahari Segar" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;" />
  <div style="position:absolute;inset:0;background:linear-gradient(105deg,rgba(13,19,22,0.96) 0%,rgba(13,19,22,0.85) 45%,rgba(13,19,22,0.5) 100%);"></div>
  <div style="position:relative;z-index:1;display:grid;grid-template-columns:62fr 38fr;width:100%;min-height:100vh;">
    <div style="display:flex;flex-direction:column;justify-content:center;padding:120px 60px 120px 80px;">
      <span style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#C2401C;letter-spacing:0.18em;text-transform:uppercase;border:1px solid #C2401C;padding:5px 12px;display:inline-block;margin-bottom:28px;width:fit-content;">TANGKAPAN HARI INI &middot; 04:00 WIB</span>
      <h1 style="font-family:Oswald,sans-serif;font-weight:800;font-size:clamp(2.5rem,5.5vw,4.5rem);color:#F3EFE4;line-height:0.95;letter-spacing:-0.025em;margin:0 0 28px;">Ditimbang Jam 4 Pagi, Sampai Dapur Anda Sebelum Jam Makan Siang.</h1>
      <p style="font-family:'IBM Plex Sans',sans-serif;font-size:17px;color:rgba(243,239,228,0.6);line-height:1.65;max-width:520px;margin-bottom:40px;">Bahari Segar memasok ikan, udang, cumi, kerang, dan olahan hasil laut langsung dari pelelangan ke dapur hotel dan restoran &mdash; bukan dari gudang beku berbulan-bulan.</p>
      <div style="display:flex;gap:16px;flex-wrap:wrap;align-items:center;">
        <a href="{$WA}?text=Halo%20Bahari%20Segar%2C%20cek%20ketersediaan%20hari%20ini" target="_blank" rel="noopener" style="display:inline-block;background:#C2401C;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:14px;letter-spacing:0.1em;text-transform:uppercase;padding:16px 32px;text-decoration:none;">Cek Ketersediaan Hari Ini</a>
        <a href="#manifest" style="color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:600;font-size:14px;letter-spacing:0.08em;text-transform:uppercase;padding:16px 0;text-decoration:none;border-bottom:2px solid rgba(243,239,228,0.3);">Lihat Kategori Produk &#8595;</a>
      </div>
    </div>
    <div style="display:flex;align-items:center;padding:80px 60px 80px 40px;">
      <div style="border:2px dashed #2E4A4A;padding:36px 32px;position:relative;background:rgba(13,19,22,0.85);backdrop-filter:blur(8px);width:100%;">
        <div style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:28px;padding-bottom:16px;border-bottom:1px dashed #2E4A4A;">MANIFEST PENGIRIMAN &middot; BATCH #BS-TODAY</div>
        <div style="margin-bottom:24px;">
          <div style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#7A8481;letter-spacing:0.15em;text-transform:uppercase;margin-bottom:6px;">TANGKAPAN HARI INI</div>
          <div style="font-family:'IBM Plex Mono',monospace;font-size:32px;color:#F3EFE4;font-weight:500;">04:00 WIB</div>
          <div style="font-family:'IBM Plex Sans',sans-serif;font-size:12px;color:#7A8481;margin-top:4px;">Langsung dari TPI &amp; nelayan lokal</div>
        </div>
        <div style="margin-bottom:24px;">
          <div style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#7A8481;letter-spacing:0.15em;text-transform:uppercase;margin-bottom:6px;">SUHU RANTAI DINGIN</div>
          <div style="font-family:'IBM Plex Mono',monospace;font-size:32px;color:#F3EFE4;font-weight:500;">0&#8211;2&deg;C</div>
          <div style="font-family:'IBM Plex Sans',sans-serif;font-size:12px;color:#7A8481;margin-top:4px;">Es curah + box styrofoam sealed</div>
        </div>
        <div style="margin-bottom:32px;">
          <div style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#7A8481;letter-spacing:0.15em;text-transform:uppercase;margin-bottom:6px;">RADIUS KIRIM</div>
          <div style="font-family:'IBM Plex Mono',monospace;font-size:32px;color:#F3EFE4;font-weight:500;">50 KM</div>
          <div style="font-family:'IBM Plex Sans',sans-serif;font-size:12px;color:#7A8481;margin-top:4px;">Jabodetabek &amp; sekitarnya</div>
        </div>
        <div style="padding-top:20px;border-top:1px dashed #2E4A4A;">
          <div style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#7A8481;letter-spacing:0.1em;text-transform:uppercase;">ESTIMASI TIBA DI DAPUR</div>
          <div style="font-family:'IBM Plex Mono',monospace;font-size:20px;color:#C2401C;font-weight:500;margin-top:4px;">Sebelum 11:00 WIB</div>
        </div>
        <div style="position:absolute;top:-20px;right:24px;width:72px;height:72px;background:#C2401C;border-radius:50%;display:flex;flex-direction:column;align-items:center;justify-content:center;transform:rotate(3deg);box-shadow:0 4px 16px rgba(194,64,28,0.5);">
          <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:8px;color:#F3EFE4;letter-spacing:0.15em;text-transform:uppercase;">GRADE</div>
          <div style="font-family:Oswald,sans-serif;font-weight:900;font-size:26px;color:#F3EFE4;line-height:1;">A</div>
        </div>
      </div>
    </div>
  </div>
</div>
NOWDOC;

$stats_html = <<<'NOWDOC'
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:24px;align-items:center;padding:36px 80px;background:#F3EFE4;">
  <div style="text-align:center;">
    <div style="font-family:Oswald,sans-serif;font-weight:800;font-size:42px;color:#12181B;line-height:1;">50+</div>
    <div style="font-family:'IBM Plex Sans',sans-serif;font-size:11px;color:#7A8481;margin-top:6px;letter-spacing:0.08em;text-transform:uppercase;">Mitra Hotel &amp; Restoran</div>
  </div>
  <div style="text-align:center;border-left:1px solid #D0C8B8;border-right:1px solid #D0C8B8;">
    <div style="font-family:Oswald,sans-serif;font-weight:800;font-size:42px;color:#12181B;line-height:1;">2 Ton</div>
    <div style="font-family:'IBM Plex Sans',sans-serif;font-size:11px;color:#7A8481;margin-top:6px;letter-spacing:0.08em;text-transform:uppercase;">Kapasitas Suplai/Hari</div>
  </div>
  <div style="text-align:center;border-right:1px solid #D0C8B8;">
    <div style="font-family:Oswald,sans-serif;font-weight:800;font-size:42px;color:#12181B;line-height:1;">04:00</div>
    <div style="font-family:'IBM Plex Sans',sans-serif;font-size:11px;color:#7A8481;margin-top:6px;letter-spacing:0.08em;text-transform:uppercase;">Mulai Operasional WIB</div>
  </div>
  <div style="text-align:center;">
    <div style="font-family:Oswald,sans-serif;font-weight:800;font-size:42px;color:#C2401C;line-height:1;">0&#8211;2&deg;C</div>
    <div style="font-family:'IBM Plex Sans',sans-serif;font-size:11px;color:#7A8481;margin-top:6px;letter-spacing:0.08em;text-transform:uppercase;">Suhu Cold-Chain Terjaga</div>
  </div>
</div>
NOWDOC;

$strip_html = <<<NOWDOC
<div id="manifest" style="background:#0D1316;padding:60px 80px 0;">
  <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:16px;">DAFTAR MANIFEST PRODUK</div>
  <h2 style="font-family:Oswald,sans-serif;font-weight:700;font-size:52px;color:#F3EFE4;line-height:0.95;letter-spacing:-0.02em;margin:0 0 48px;">Empat Kategori Pengiriman</h2>
</div>
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:2px;background:#0D1316;">
  <a href="/wordpress/produk" style="display:block;position:relative;height:440px;overflow:hidden;text-decoration:none;">
    <img src="{$ikan_img}" alt="Ikan Segar" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;" />
    <div style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(13,19,22,0.05) 0%,rgba(13,19,22,0.9) 100%);"></div>
    <div style="position:absolute;bottom:0;left:0;right:0;padding:36px 32px;">
      <div style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:12px;">01 / IKAN SEGAR</div>
      <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:30px;color:#F3EFE4;line-height:1;margin-bottom:10px;">Ikan Segar</div>
      <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:rgba(243,239,228,0.6);line-height:1.5;margin-bottom:18px;">Kakap, kerapu, tenggiri, bawal, tuna &mdash; dari TPI jam 4 pagi</div>
      <span style="font-family:Oswald,sans-serif;font-size:12px;color:#F3EFE4;letter-spacing:0.12em;text-transform:uppercase;border-bottom:1px solid rgba(243,239,228,0.35);padding-bottom:4px;">Tanya Ketersediaan &#8594;</span>
    </div>
  </a>
  <a href="/wordpress/produk" style="display:block;position:relative;height:440px;overflow:hidden;text-decoration:none;">
    <img src="{$udang_img}" alt="Udang Seafood" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;" />
    <div style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(13,19,22,0.05) 0%,rgba(13,19,22,0.9) 100%);"></div>
    <div style="position:absolute;bottom:0;left:0;right:0;padding:36px 32px;">
      <div style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#7A8481;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:12px;">02 / UDANG &amp; SEAFOOD BEKU</div>
      <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:30px;color:#F3EFE4;line-height:1;margin-bottom:10px;">Udang &amp; Seafood Beku</div>
      <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:rgba(243,239,228,0.6);line-height:1.5;margin-bottom:18px;">Vaname IQF, Tiger, Galah &mdash; size 16/20 hingga 61/70</div>
      <span style="font-family:Oswald,sans-serif;font-size:12px;color:#F3EFE4;letter-spacing:0.12em;text-transform:uppercase;border-bottom:1px solid rgba(243,239,228,0.35);padding-bottom:4px;">Tanya Ketersediaan &#8594;</span>
    </div>
  </a>
  <a href="/wordpress/produk" style="display:block;position:relative;height:440px;overflow:hidden;text-decoration:none;">
    <img src="{$cumi_img}" alt="Cumi Kepiting" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;" />
    <div style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(13,19,22,0.05) 0%,rgba(13,19,22,0.9) 100%);"></div>
    <div style="position:absolute;bottom:0;left:0;right:0;padding:36px 32px;">
      <div style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#7A8481;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:12px;">03 / CUMI, KERANG &amp; KEPITING</div>
      <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:30px;color:#F3EFE4;line-height:1;margin-bottom:10px;">Cumi, Kerang &amp; Kepiting</div>
      <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:rgba(243,239,228,0.6);line-height:1.5;margin-bottom:18px;">Cumi segar, kepiting bakau, kerang hijau, rajungan</div>
      <span style="font-family:Oswald,sans-serif;font-size:12px;color:#F3EFE4;letter-spacing:0.12em;text-transform:uppercase;border-bottom:1px solid rgba(243,239,228,0.35);padding-bottom:4px;">Tanya Ketersediaan &#8594;</span>
    </div>
  </a>
</div>
<div style="background:#0D1316;text-align:center;padding:48px;">
  <a href="/wordpress/produk" style="display:inline-block;background:transparent;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:13px;letter-spacing:0.12em;text-transform:uppercase;padding:14px 40px;text-decoration:none;border:2px solid rgba(243,239,228,0.3);">Lihat Katalog Lengkap &#8594;</a>
</div>
NOWDOC;

$zigzag_html = <<<NOWDOC
<div style="display:grid;grid-template-columns:1fr 1fr;min-height:560px;">
  <div style="position:relative;overflow:hidden;">
    <img src="{$proses_img}" alt="Proses penimbangan Bahari Segar" style="width:100%;height:100%;object-fit:cover;min-height:560px;filter:brightness(0.85) contrast(1.1);" />
  </div>
  <div style="display:flex;align-items:center;padding:80px 80px 80px 60px;background:#F3EFE4;">
    <div>
      <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:20px;">PROSES RANTAI SUPLAI</div>
      <h2 style="font-family:Oswald,sans-serif;font-weight:800;font-size:48px;color:#12181B;line-height:0.95;letter-spacing:-0.025em;margin:0 0 28px;">Dari Pelelangan ke Dapur Anda, Tanpa Jeda Freezer.</h2>
      <p style="font-family:'IBM Plex Sans',sans-serif;font-size:16px;color:#7A8481;line-height:1.7;margin-bottom:36px;">Tim kami tiba di TPI sebelum kapal nelayan bersandar. Setiap batch dicatat jam tangkap, berat, dan kondisi grading.</p>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:40px;">
        <div style="border-top:3px solid #C2401C;padding-top:16px;">
          <div style="font-family:'IBM Plex Mono',monospace;font-size:24px;color:#C2401C;margin-bottom:6px;">03:00</div>
          <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:16px;color:#12181B;margin-bottom:4px;">Berangkat ke TPI</div>
          <div style="font-family:'IBM Plex Sans',sans-serif;font-size:12px;color:#7A8481;">Grading langsung di TPI</div>
        </div>
        <div style="border-top:3px solid #D0C8B8;padding-top:16px;">
          <div style="font-family:'IBM Plex Mono',monospace;font-size:24px;color:#12181B;margin-bottom:6px;">05:30</div>
          <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:16px;color:#12181B;margin-bottom:4px;">Pengiriman Dimulai</div>
          <div style="font-family:'IBM Plex Sans',sans-serif;font-size:12px;color:#7A8481;">Armada berpendingin 0&#8211;2&deg;C</div>
        </div>
      </div>
      <a href="/wordpress/tentang-kami" style="display:inline-block;background:#12181B;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:13px;letter-spacing:0.1em;text-transform:uppercase;padding:16px 32px;text-decoration:none;">Tentang Kami &#8594;</a>
    </div>
  </div>
</div>
NOWDOC;

$testi_html = <<<NOWDOC
<div style="position:relative;min-height:480px;overflow:hidden;">
  <img src="{$market_img}" alt="Pasar ikan Bahari Segar" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;" />
  <div style="position:absolute;inset:0;background:linear-gradient(105deg,rgba(13,19,22,0.95) 40%,rgba(13,19,22,0.5) 100%);"></div>
  <div style="position:relative;z-index:1;padding:80px;max-width:620px;">
    <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:20px;">TESTIMONI MITRA</div>
    <div style="font-family:Oswald,sans-serif;font-weight:800;font-size:64px;color:#C2401C;line-height:0.7;margin-bottom:20px;">&ldquo;</div>
    <blockquote style="font-family:Oswald,sans-serif;font-weight:700;font-size:28px;color:#F3EFE4;line-height:1.2;letter-spacing:-0.01em;margin:0 0 32px;border:none;padding:0;">Chef kami tidak perlu cek kondisi ikan setiap pagi &mdash; kami sudah tahu Bahari Segar tidak pernah kirim yang tidak layak.</blockquote>
    <div style="display:flex;align-items:center;gap:16px;">
      <div style="width:48px;height:48px;background:#C2401C;border-radius:50%;display:flex;flex-direction:column;align-items:center;justify-content:center;transform:rotate(-3deg);flex-shrink:0;">
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:7px;color:#F3EFE4;letter-spacing:0.1em;">GRADE</div>
        <div style="font-family:Oswald,sans-serif;font-weight:900;font-size:18px;color:#F3EFE4;line-height:1;">A</div>
      </div>
      <div>
        <div style="font-family:'IBM Plex Sans',sans-serif;font-weight:600;font-size:14px;color:#F3EFE4;">Executive Chef Bambang S.</div>
        <div style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#7A8481;margin-top:3px;letter-spacing:0.08em;">Hotel Bintang 5 &middot; Jakarta Selatan &middot; Mitra sejak 2021</div>
      </div>
    </div>
  </div>
</div>
NOWDOC;

$cta_html = <<<NOWDOC
<div style="background:#C2401C;padding:80px;">
  <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:40px;">
    <div>
      <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:rgba(243,239,228,0.55);letter-spacing:0.2em;text-transform:uppercase;margin-bottom:12px;">MULAI KERJASAMA HARI INI</div>
      <h2 style="font-family:Oswald,sans-serif;font-weight:800;font-size:44px;color:#F3EFE4;line-height:0.95;letter-spacing:-0.025em;margin:0;">Siap Suplai Dapur Anda<br>Besok Pagi?</h2>
    </div>
    <div style="display:flex;gap:16px;flex-wrap:wrap;">
      <a href="{$WA}?text=Halo%20Bahari%20Segar" target="_blank" rel="noopener" style="display:inline-block;background:#F3EFE4;color:#C2401C;font-family:Oswald,sans-serif;font-weight:700;font-size:14px;letter-spacing:0.08em;text-transform:uppercase;padding:18px 36px;text-decoration:none;">Chat WhatsApp Sekarang</a>
      <a href="/wordpress/kerjasama-b2b" style="display:inline-block;background:transparent;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:14px;letter-spacing:0.08em;text-transform:uppercase;padding:18px 36px;text-decoration:none;border:2px solid rgba(243,239,228,0.4);">Isi Form Kerjasama</a>
    </div>
  </div>
</div>
NOWDOC;

$beranda = [
    el_section('bs-hero',   ['background_color'=>'#0D1316','padding'=>['unit'=>'px','top'=>'0','right'=>'0','bottom'=>'0','left'=>'0','isLinked'=>false]],
               [el_col('bs-hero-c', 100, [el_html('bs-hero-w', $hero_html)])]),
    el_section('bs-stats',  ['background_color'=>'#F3EFE4','padding'=>['unit'=>'px','top'=>'0','right'=>'0','bottom'=>'0','left'=>'0','isLinked'=>false]],
               [el_col('bs-stats-c', 100, [el_html('bs-stats-w', $stats_html)])]),
    el_section('bs-strip',  ['background_color'=>'#0D1316','padding'=>['unit'=>'px','top'=>'0','right'=>'0','bottom'=>'0','left'=>'0','isLinked'=>false]],
               [el_col('bs-strip-c', 100, [el_html('bs-strip-w', $strip_html)])]),
    el_section('bs-zig',    ['background_color'=>'#F3EFE4','padding'=>['unit'=>'px','top'=>'0','right'=>'0','bottom'=>'0','left'=>'0','isLinked'=>false]],
               [el_col('bs-zig-c', 100, [el_html('bs-zig-w', $zigzag_html)])]),
    el_section('bs-testi',  ['background_color'=>'#0D1316','padding'=>['unit'=>'px','top'=>'0','right'=>'0','bottom'=>'0','left'=>'0','isLinked'=>false]],
               [el_col('bs-testi-c', 100, [el_html('bs-testi-w', $testi_html)])]),
    el_section('bs-cta',    ['background_color'=>'#C2401C','padding'=>['unit'=>'px','top'=>'0','right'=>'0','bottom'=>'0','left'=>'0','isLinked'=>false]],
               [el_col('bs-cta-c', 100, [el_html('bs-cta-w', $cta_html)])]),
];

$beranda_json = json_encode($beranda, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
upsert_meta($pdo, $ids['beranda'], '_elementor_data', $beranda_json);
upsert_meta($pdo, $ids['beranda'], '_elementor_edit_mode', 'builder');
upsert_meta($pdo, $ids['beranda'], '_wp_page_template', 'elementor_canvas');
echo "  OK Beranda (" . number_format(strlen($beranda_json)) . " chars)\n";

// ────────────────────────────────────────────────────────────────────────────
// 2. TENTANG KAMI
// ────────────────────────────────────────────────────────────────────────────
echo "\n[2/3] Tentang Kami...\n";

$tentang_img = $IMGS['tentang'];
$cold_img    = $IMGS['cold'];

$ta_hero_html = <<<NOWDOC
<div style="position:relative;min-height:600px;overflow:hidden;">
  <img src="{$tentang_img}" alt="Tentang Bahari Segar" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;filter:brightness(0.7);" />
  <div style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(13,19,22,0.3) 0%,rgba(13,19,22,0.97) 70%);"></div>
  <div style="position:relative;z-index:1;min-height:600px;display:flex;flex-direction:column;justify-content:flex-end;padding:60px 80px 80px;">
    <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:16px;">TENTANG KAMI</div>
    <h1 style="font-family:Oswald,sans-serif;font-weight:800;font-size:clamp(2.5rem,6vw,5rem);color:#F3EFE4;line-height:0.95;letter-spacing:-0.025em;margin:0 0 24px;max-width:800px;">Bukan Sekadar Suplier.<br>Kami Bagian dari Dapur Anda.</h1>
    <p style="font-family:'IBM Plex Sans',sans-serif;font-size:17px;color:rgba(243,239,228,0.55);max-width:580px;line-height:1.65;margin:0;">Bahari Segar berdiri dari satu keresahan: sulit mendapat pasokan seafood segar yang konsisten dan terdokumentasi.</p>
  </div>
</div>
NOWDOC;

$ta_body_html = <<<NOWDOC
<div style="background:#12181B;padding:100px 80px;">
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:start;">
    <div>
      <p style="font-family:'IBM Plex Sans',sans-serif;font-size:18px;color:#F3EFE4;line-height:1.75;margin-bottom:28px;">Kami membangun hubungan langsung dengan nelayan dan TPI. Setiap batch yang kami ambil dicatat: jam tangkap, berat, ukuran, kondisi saat grading.</p>
      <p style="font-family:'IBM Plex Sans',sans-serif;font-size:16px;color:#7A8481;line-height:1.75;margin-bottom:48px;">Mitra kami &mdash; chef di hotel bintang lima hingga restoran seafood independen &mdash; tidak perlu khawatir soal kualitas. Sebelum jam 11 pagi, produk kami sudah di tangan mereka.</p>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:1px;background:#1E2A2A;">
        <div style="background:#0D1316;padding:32px 28px;">
          <div style="font-family:'IBM Plex Mono',monospace;font-size:36px;color:#C2401C;margin-bottom:8px;">2018</div>
          <div style="font-family:'IBM Plex Sans',sans-serif;font-size:11px;color:#7A8481;text-transform:uppercase;letter-spacing:0.08em;">Berdiri sejak</div>
        </div>
        <div style="background:#0D1316;padding:32px 28px;">
          <div style="font-family:'IBM Plex Mono',monospace;font-size:36px;color:#F3EFE4;margin-bottom:8px;">50+</div>
          <div style="font-family:'IBM Plex Sans',sans-serif;font-size:11px;color:#7A8481;text-transform:uppercase;letter-spacing:0.08em;">Mitra aktif</div>
        </div>
        <div style="background:#0D1316;padding:32px 28px;">
          <div style="font-family:'IBM Plex Mono',monospace;font-size:36px;color:#F3EFE4;margin-bottom:8px;">2 Ton</div>
          <div style="font-family:'IBM Plex Sans',sans-serif;font-size:11px;color:#7A8481;text-transform:uppercase;letter-spacing:0.08em;">Kapasitas/hari</div>
        </div>
        <div style="background:#0D1316;padding:32px 28px;">
          <div style="font-family:'IBM Plex Mono',monospace;font-size:36px;color:#C2401C;margin-bottom:8px;">03:00</div>
          <div style="font-family:'IBM Plex Sans',sans-serif;font-size:11px;color:#7A8481;text-transform:uppercase;letter-spacing:0.08em;">Mulai operasi</div>
        </div>
      </div>
    </div>
    <div style="position:relative;">
      <img src="{$cold_img}" alt="Cold chain Bahari Segar" style="width:100%;height:500px;object-fit:cover;display:block;" />
      <div style="position:absolute;bottom:0;left:0;right:0;background:linear-gradient(180deg,transparent,rgba(13,19,22,0.85));padding:28px 24px;">
        <div style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#C2401C;letter-spacing:0.15em;text-transform:uppercase;margin-bottom:6px;">COLD CHAIN TERJAGA</div>
        <div style="font-family:'IBM Plex Mono',monospace;font-size:18px;color:#F3EFE4;">0&#8211;2&deg;C dari TPI ke dapur Anda</div>
      </div>
      <div style="position:absolute;top:20px;right:20px;width:68px;height:68px;background:#C2401C;border-radius:50%;display:flex;flex-direction:column;align-items:center;justify-content:center;transform:rotate(3deg);">
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:7px;color:#F3EFE4;letter-spacing:0.12em;">GRADE</div>
        <div style="font-family:Oswald,sans-serif;font-weight:900;font-size:24px;color:#F3EFE4;line-height:1;">A</div>
      </div>
    </div>
  </div>
</div>
NOWDOC;

$ta_cta_html = <<<NOWDOC
<div style="background:#C2401C;padding:80px;">
  <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:32px;">
    <div>
      <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:rgba(243,239,228,0.55);letter-spacing:0.2em;text-transform:uppercase;margin-bottom:12px;">MULAI KERJASAMA</div>
      <h2 style="font-family:Oswald,sans-serif;font-weight:800;font-size:40px;color:#F3EFE4;line-height:1;margin:0;">Jadi Mitra Bahari Segar</h2>
    </div>
    <div style="display:flex;gap:16px;">
      <a href="{$WA}?text=Halo%20Bahari%20Segar%2C%20saya%20ingin%20jadi%20mitra" target="_blank" style="display:inline-block;background:#F3EFE4;color:#C2401C;font-family:Oswald,sans-serif;font-weight:700;font-size:13px;letter-spacing:0.08em;text-transform:uppercase;padding:16px 32px;text-decoration:none;">Chat WhatsApp &#8594;</a>
      <a href="/wordpress/kerjasama-b2b" style="display:inline-block;background:transparent;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:13px;letter-spacing:0.08em;text-transform:uppercase;padding:16px 32px;text-decoration:none;border:2px solid rgba(243,239,228,0.4);">Form Kerjasama</a>
    </div>
  </div>
</div>
NOWDOC;

$tentang = [
    el_section('ta-hero', ['background_color'=>'#0D1316','padding'=>['unit'=>'px','top'=>'0','right'=>'0','bottom'=>'0','left'=>'0','isLinked'=>false]],
               [el_col('ta-hero-c', 100, [el_html('ta-hero-w', $ta_hero_html)])]),
    el_section('ta-body', ['background_color'=>'#12181B','padding'=>['unit'=>'px','top'=>'0','right'=>'0','bottom'=>'0','left'=>'0','isLinked'=>false]],
               [el_col('ta-body-c', 100, [el_html('ta-body-w', $ta_body_html)])]),
    el_section('ta-cta',  ['background_color'=>'#C2401C','padding'=>['unit'=>'px','top'=>'0','right'=>'0','bottom'=>'0','left'=>'0','isLinked'=>false]],
               [el_col('ta-cta-c', 100, [el_html('ta-cta-w', $ta_cta_html)])]),
];

$tentang_json = json_encode($tentang, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
upsert_meta($pdo, $ids['tentang'], '_elementor_data', $tentang_json);
upsert_meta($pdo, $ids['tentang'], '_elementor_edit_mode', 'builder');
upsert_meta($pdo, $ids['tentang'], '_wp_page_template', 'elementor_canvas');
echo "  OK Tentang Kami (" . number_format(strlen($tentang_json)) . " chars)\n";

// ────────────────────────────────────────────────────────────────────────────
// 3. PRODUK
// ────────────────────────────────────────────────────────────────────────────
echo "\n[3/3] Produk...\n";

$pr_hero_html = <<<NOWDOC
<div style="position:relative;min-height:500px;overflow:hidden;">
  <img src="{$ikan_img}" alt="Katalog Produk Bahari Segar" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;filter:brightness(0.7);" />
  <div style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(13,19,22,0.2) 0%,rgba(13,19,22,0.97) 70%);"></div>
  <div style="position:relative;z-index:1;min-height:500px;display:flex;flex-direction:column;justify-content:flex-end;padding:60px 80px 70px;">
    <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:16px;">KATALOG PRODUK</div>
    <h1 style="font-family:Oswald,sans-serif;font-weight:800;font-size:clamp(2.5rem,6vw,5rem);color:#F3EFE4;line-height:0.95;letter-spacing:-0.025em;margin:0 0 20px;">Ikan Segar, Udang, Cumi<br>&amp; Olahan Hasil Laut.</h1>
    <p style="font-family:'IBM Plex Sans',sans-serif;font-size:16px;color:rgba(243,239,228,0.55);max-width:520px;line-height:1.65;margin:0;">Semua dipilih langsung dari TPI jam 4 pagi. Harga grosir untuk hotel dan restoran.</p>
  </div>
</div>
NOWDOC;

$pr_ikan_html = <<<NOWDOC
<div style="background:#12181B;padding:80px;">
  <div style="display:flex;align-items:baseline;gap:20px;margin-bottom:40px;padding-bottom:24px;border-bottom:1px solid #1E2A2A;">
    <span style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;">01</span>
    <h2 style="font-family:Oswald,sans-serif;font-weight:700;font-size:40px;color:#F3EFE4;line-height:1;margin:0;">Ikan Segar</h2>
    <span style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#7A8481;letter-spacing:0.1em;text-transform:uppercase;margin-left:auto;">Tersedia sepanjang tahun</span>
  </div>
  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:2px;margin-bottom:2px;">
    <div style="background:#0D1316;padding:32px 28px;border-top:3px solid #C2401C;">
      <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:22px;color:#F3EFE4;margin-bottom:12px;">Kakap Merah</div>
      <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:#7A8481;line-height:1.6;margin-bottom:20px;">Grade A: sisik utuh, mata jernih, insang merah cerah. Ukuran 300g&ndash;2kg/ekor. Kemasan es curah &amp; box styrofoam.</div>
      <a href="{$WA}?text=Tanya%20stok%20Kakap%20Merah" target="_blank" style="display:inline-block;background:#C2401C;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:11px;letter-spacing:0.1em;text-transform:uppercase;padding:10px 20px;text-decoration:none;">Tanya Ketersediaan</a>
    </div>
    <div style="background:#0D1316;padding:32px 28px;border-top:3px solid #2E4A4A;">
      <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:22px;color:#F3EFE4;margin-bottom:12px;">Kerapu Segar</div>
      <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:#7A8481;line-height:1.6;margin-bottom:20px;">Kerapu macan, tikus, bebek. Kualitas ekspor, 400g&ndash;3kg/ekor. Musiman &mdash; konfirmasi stok.</div>
      <a href="{$WA}?text=Tanya%20stok%20Kerapu" target="_blank" style="display:inline-block;background:transparent;color:#C2401C;font-family:Oswald,sans-serif;font-weight:700;font-size:11px;letter-spacing:0.1em;text-transform:uppercase;padding:10px 20px;text-decoration:none;border:1px solid #C2401C;">Tanya Ketersediaan</a>
    </div>
    <div style="background:#0D1316;padding:32px 28px;border-top:3px solid #2E4A4A;">
      <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:22px;color:#F3EFE4;margin-bottom:12px;">Tuna Segar</div>
      <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:#7A8481;line-height:1.6;margin-bottom:20px;">Utuh dan loin siap olah. Grading standar ekspor Jepang. 2&ndash;30kg/ekor.</div>
      <a href="{$WA}?text=Tanya%20stok%20Tuna" target="_blank" style="display:inline-block;background:transparent;color:#C2401C;font-family:Oswald,sans-serif;font-weight:700;font-size:11px;letter-spacing:0.1em;text-transform:uppercase;padding:10px 20px;text-decoration:none;border:1px solid #C2401C;">Tanya Ketersediaan</a>
    </div>
  </div>
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:2px;">
    <div style="background:#0D1316;padding:32px 28px;border-top:3px solid #2E4A4A;">
      <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:22px;color:#F3EFE4;margin-bottom:12px;">Tenggiri Segar</div>
      <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:#7A8481;line-height:1.6;margin-bottom:20px;">Ideal untuk ikan bakar, pepes, dapur hotel. 500g&ndash;4kg/ekor.</div>
      <a href="{$WA}?text=Tanya%20stok%20Tenggiri" target="_blank" style="display:inline-block;background:transparent;color:#C2401C;font-family:Oswald,sans-serif;font-weight:700;font-size:11px;letter-spacing:0.1em;text-transform:uppercase;padding:10px 20px;text-decoration:none;border:1px solid #C2401C;">Tanya Ketersediaan</a>
    </div>
    <div style="background:#0D1316;padding:32px 28px;border-top:3px solid #2E4A4A;">
      <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:22px;color:#F3EFE4;margin-bottom:12px;">Bawal Segar</div>
      <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:#7A8481;line-height:1.6;margin-bottom:20px;">Bawal putih &amp; hitam. 200g&ndash;1kg/ekor. Populer untuk Chinese restaurant.</div>
      <a href="{$WA}?text=Tanya%20stok%20Bawal" target="_blank" style="display:inline-block;background:transparent;color:#C2401C;font-family:Oswald,sans-serif;font-weight:700;font-size:11px;letter-spacing:0.1em;text-transform:uppercase;padding:10px 20px;text-decoration:none;border:1px solid #C2401C;">Tanya Ketersediaan</a>
    </div>
  </div>
</div>
NOWDOC;

$pr_cta_html = <<<NOWDOC
<div style="background:#C2401C;padding:60px 80px;">
  <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:32px;">
    <div>
      <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:rgba(243,239,228,0.55);letter-spacing:0.2em;text-transform:uppercase;margin-bottom:8px;">HARGA GROSIR B2B</div>
      <h2 style="font-family:Oswald,sans-serif;font-weight:800;font-size:36px;color:#F3EFE4;line-height:1;margin:0;">Hubungi Kami untuk Penawaran Volume</h2>
    </div>
    <div style="display:flex;gap:16px;flex-wrap:wrap;">
      <a href="{$WA}?text=Halo%20Bahari%20Segar%2C%20saya%20ingin%20harga%20grosir" target="_blank" style="display:inline-block;background:#F3EFE4;color:#C2401C;font-family:Oswald,sans-serif;font-weight:700;font-size:13px;letter-spacing:0.08em;text-transform:uppercase;padding:16px 32px;text-decoration:none;">Chat WhatsApp &#8594;</a>
      <a href="/wordpress/kerjasama-b2b" style="display:inline-block;background:transparent;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:13px;letter-spacing:0.08em;text-transform:uppercase;padding:16px 32px;text-decoration:none;border:2px solid rgba(243,239,228,0.4);">Ajukan Kerjasama</a>
    </div>
  </div>
</div>
NOWDOC;

$produk = [
    el_section('pr-hero',  ['background_color'=>'#0D1316','padding'=>['unit'=>'px','top'=>'0','right'=>'0','bottom'=>'0','left'=>'0','isLinked'=>false]],
               [el_col('pr-hero-c', 100, [el_html('pr-hero-w', $pr_hero_html)])]),
    el_section('pr-ikan',  ['background_color'=>'#12181B','padding'=>['unit'=>'px','top'=>'0','right'=>'0','bottom'=>'0','left'=>'0','isLinked'=>false]],
               [el_col('pr-ikan-c', 100, [el_html('pr-ikan-w', $pr_ikan_html)])]),
    el_section('pr-cta',   ['background_color'=>'#C2401C','padding'=>['unit'=>'px','top'=>'0','right'=>'0','bottom'=>'0','left'=>'0','isLinked'=>false]],
               [el_col('pr-cta-c', 100, [el_html('pr-cta-w', $pr_cta_html)])]),
];

$produk_json = json_encode($produk, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
upsert_meta($pdo, $ids['produk'], '_elementor_data', $produk_json);
upsert_meta($pdo, $ids['produk'], '_elementor_edit_mode', 'builder');
upsert_meta($pdo, $ids['produk'], '_wp_page_template', 'elementor_canvas');
// Pastikan bukan WooCommerce shop page
$pdo->exec("DELETE FROM wp_options WHERE option_name='woocommerce_shop_page_id'");
echo "  OK Produk (" . number_format(strlen($produk_json)) . " chars)\n";

// ────────────────────────────────────────────────────────────────────────────
// CLEAR CACHE
// ────────────────────────────────────────────────────────────────────────────
echo "\nClearing caches...\n";
$pdo->exec("DELETE FROM wp_options WHERE option_name LIKE '_elementor_css_%'");
$pdo->exec("DELETE FROM wp_options WHERE option_name LIKE '_transient_elementor%'");
$pdo->exec("DELETE FROM wp_options WHERE option_name LIKE '_transient_timeout_elementor%'");

echo "\n========================================\n";
echo "DONE! Open:\n";
echo "  Beranda   : http://localhost/wordpress/\n";
echo "  Tentang   : http://localhost/wordpress/tentang-kami/\n";
echo "  Produk    : http://localhost/wordpress/produk/\n";
echo "========================================\n\n";
