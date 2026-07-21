<?php
/**
 * Script 07: Inject Images to Elementor pages + upgrade visual dengan foto dokumenter
 * Menggunakan Unsplash photos dengan keyword: fish market, seafood, fishing, ice crates
 * Treatment: background-blend-mode + CSS filter untuk duotone graphite sesuai brief
 */

define('ABSPATH', '/home/dzaky/Documents/htdocs/wordpress/');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'gggaming21');
define('DB_NAME', 'db_wordpress');

$pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4", DB_USER, DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$WA = 'https://wa.me/6281234567890';
$ids = json_decode(file_get_contents(__DIR__ . '/page_ids.json'), true);

echo "\n=== Step 07: Inject Images + Upgrade Visual ===\n\n";

// ─── Unsplash foto dokumenter seafood/ikan/pasar ─────────────────────────────
// Format: ?w=1600&q=85&auto=format&fit=crop
$IMGS = [
    // Pasar ikan dini hari - suasana gelap dramatis
    'hero_bg'       => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=1600&q=85&auto=format&fit=crop',
    // Ikan segar di atas es - close up
    'ikan_segar'    => 'https://images.unsplash.com/photo-1534482421-64566f976cfa?w=1200&q=85&auto=format&fit=crop',
    // Nelayan / tangan memilih ikan
    'proses_timbang'=> 'https://images.unsplash.com/photo-1607083206968-13611e3d76db?w=1200&q=85&auto=format&fit=crop',
    // Krat es + seafood  
    'cold_chain'    => 'https://images.unsplash.com/photo-1570042225831-d98fa7577f1e?w=1200&q=85&auto=format&fit=crop',
    // Pasar ikan / market
    'fish_market'   => 'https://images.unsplash.com/photo-1559060017-445fb9722f2a?w=1600&q=85&auto=format&fit=crop',
    // Seafood variety - udang, cumi dll
    'seafood_variety'=> 'https://images.unsplash.com/photo-1615141982883-c7ad0e69fd62?w=1200&q=85&auto=format&fit=crop',
    // Kapal nelayan / pelabuhan dini hari
    'pelabuhan'     => 'https://images.unsplash.com/photo-1504472478235-9bc48ba4d60f?w=1600&q=85&auto=format&fit=crop',
    // Tentang kami - close up tangan memilah ikan
    'tentang_bg'    => 'https://images.unsplash.com/photo-1598515213692-bb2fe38a4df6?w=1600&q=85&auto=format&fit=crop',
    // CTA background - gelap dramatis laut
    'cta_bg'        => 'https://images.unsplash.com/photo-1505118380757-91f5f5632de0?w=1600&q=85&auto=format&fit=crop',
    // Produk - ikan kakap
    'kakap'         => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?w=800&q=85&auto=format&fit=crop',
    // Produk - udang
    'udang'         => 'https://images.unsplash.com/photo-1565680018434-b513d5e5fd47?w=800&q=85&auto=format&fit=crop',
    // Produk - cumi
    'cumi'          => 'https://images.unsplash.com/photo-1604709178681-2b6f0d5c7800?w=800&q=85&auto=format&fit=crop',
];

function set_post_meta($pdo, $post_id, $meta_key, $meta_value) {
    $check = $pdo->prepare("SELECT meta_id FROM wp_postmeta WHERE post_id = ? AND meta_key = ?");
    $check->execute([$post_id, $meta_key]);
    if ($check->fetch()) {
        $pdo->prepare("UPDATE wp_postmeta SET meta_value = ? WHERE post_id = ? AND meta_key = ?")->execute([$meta_value, $post_id, $meta_key]);
    } else {
        $pdo->prepare("INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (?, ?, ?)")->execute([$post_id, $meta_key, $meta_value]);
    }
}

// ─── BERANDA — Upgrade dengan background images ───────────────────────────────
echo "[1/4] Upgrading Beranda with images...\n";

$beranda_data = [
    // SECTION 1: HERO — Full-bleed image background + split manifest
    [
        'id' => 'bs-hero-img',
        'elType' => 'section',
        'settings' => [
            'layout' => 'full_width',
            'height' => 'full',
            'background_background' => 'classic',
            'background_image' => [
                'url' => $IMGS['hero_bg'],
                'id' => '',
            ],
            'background_size' => 'cover',
            'background_position' => 'center center',
            'background_repeat' => 'no-repeat',
            'padding' => ['unit'=>'px','top'=>'0','right'=>'0','bottom'=>'0','left'=>'0','isLinked'=>false],
            'custom_css' => '
.elementor-element-bs-hero-img > .elementor-background-overlay {
    background: linear-gradient(105deg, rgba(13,19,22,0.95) 0%, rgba(13,19,22,0.85) 45%, rgba(13,19,22,0.5) 100%);
}',
        ],
        'elements' => [
            // Left: Headline
            [
                'id' => 'bs-hero-left-img',
                'elType' => 'column',
                'settings' => [
                    '_column_size' => 62,
                    'content_position' => 'middle',
                    'padding' => ['unit'=>'px','top'=>'120','right'=>'60','bottom'=>'120','left'=>'80','isLinked'=>false],
                    'padding_tablet' => ['unit'=>'px','top'=>'80','right'=>'32','bottom'=>'80','left'=>'32','isLinked'=>false],
                    'padding_mobile' => ['unit'=>'px','top'=>'80','right'=>'24','bottom'=>'60','left'=>'24','isLinked'=>false],
                ],
                'elements' => [
                    [
                        'id' => 'bs-pre-badge-img',
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => [
                            'editor' => '<span style="font-family:\'IBM Plex Mono\',monospace;font-size:11px;color:#C2401C;letter-spacing:0.18em;text-transform:uppercase;border:1px solid #C2401C;padding:5px 12px;display:inline-block;margin-bottom:28px;">TANGKAPAN HARI INI · 04:00 WIB</span>',
                        ],
                    ],
                    [
                        'id' => 'bs-hl-img',
                        'elType' => 'widget',
                        'widgetType' => 'heading',
                        'settings' => [
                            'title' => 'Ditimbang Jam 4 Pagi, Sampai Dapur Anda Sebelum Jam Makan Siang.',
                            'header_size' => 'h1',
                            'align' => 'left',
                            'title_color' => '#F3EFE4',
                            'typography_typography' => 'custom',
                            'typography_font_family' => 'Oswald',
                            'typography_font_size' => ['unit'=>'px','size'=>72],
                            'typography_font_size_tablet' => ['unit'=>'px','size'=>48],
                            'typography_font_size_mobile' => ['unit'=>'px','size'=>36],
                            'typography_font_weight' => '800',
                            'typography_line_height' => ['unit'=>'em','size'=>0.95],
                            'typography_letter_spacing' => ['unit'=>'px','size'=>-2],
                            'margin' => ['unit'=>'px','top'=>'0','right'=>'0','bottom'=>'28','left'=>'0','isLinked'=>false],
                        ],
                    ],
                    [
                        'id' => 'bs-sub-img',
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => [
                            'editor' => '<p style="font-family:\'IBM Plex Sans\',sans-serif;font-size:17px;color:rgba(243,239,228,0.65);line-height:1.65;max-width:500px;margin-bottom:40px;">Bahari Segar memasok ikan, udang, cumi, kerang, dan olahan hasil laut langsung dari pelelangan ke dapur hotel dan restoran — bukan dari gudang beku berbulan-bulan.</p>',
                        ],
                    ],
                    [
                        'id' => 'bs-ctas-img',
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => [
                            'editor' => '<div style="display:flex;gap:16px;flex-wrap:wrap;align-items:center;">
<a href="'.$WA.'?text=Halo%20Bahari%20Segar%2C%20saya%20ingin%20cek%20ketersediaan%20hari%20ini" target="_blank" rel="noopener" style="display:inline-block;background:#C2401C;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:14px;letter-spacing:0.1em;text-transform:uppercase;padding:16px 32px;text-decoration:none;transition:opacity 0.2s;">Cek Ketersediaan Hari Ini</a>
<a href="#manifest-produk" style="display:inline-block;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:600;font-size:14px;letter-spacing:0.08em;text-transform:uppercase;padding:16px 0;text-decoration:none;border-bottom:2px solid rgba(243,239,228,0.3);">Lihat Kategori Produk ↓</a>
</div>',
                        ],
                    ],
                ],
            ],
            // Right: Tiket Manifest
            [
                'id' => 'bs-hero-right-img',
                'elType' => 'column',
                'settings' => [
                    '_column_size' => 38,
                    'content_position' => 'middle',
                    'padding' => ['unit'=>'px','top'=>'80','right'=>'60','bottom'=>'80','left'=>'40','isLinked'=>false],
                    'padding_mobile' => ['unit'=>'px','top'=>'40','right'=>'24','bottom'=>'60','left'=>'24','isLinked'=>false],
                ],
                'elements' => [
                    [
                        'id' => 'bs-manifest-img',
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => [
                            'editor' => '
<div class="bs-manifest-ticket" style="border:2px dashed #2E4A4A;padding:36px 32px;position:relative;background:rgba(13,19,22,0.85);backdrop-filter:blur(8px);">
    <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:28px;padding-bottom:16px;border-bottom:1px dashed #2E4A4A;">
        MANIFEST PENGIRIMAN · BATCH #BS-TODAY
    </div>
    <div style="margin-bottom:24px;">
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#7A8481;letter-spacing:0.15em;text-transform:uppercase;margin-bottom:6px;">TANGKAPAN HARI INI</div>
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:28px;color:#F3EFE4;font-weight:500;">04:00 WIB</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:12px;color:#7A8481;margin-top:4px;">Langsung dari TPI & nelayan lokal</div>
    </div>
    <div style="margin-bottom:24px;">
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#7A8481;letter-spacing:0.15em;text-transform:uppercase;margin-bottom:6px;">SUHU RANTAI DINGIN</div>
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:28px;color:#F3EFE4;font-weight:500;">0–2°C</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:12px;color:#7A8481;margin-top:4px;">Es curah + box styrofoam sealed</div>
    </div>
    <div style="margin-bottom:32px;">
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#7A8481;letter-spacing:0.15em;text-transform:uppercase;margin-bottom:6px;">RADIUS KIRIM</div>
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:28px;color:#F3EFE4;font-weight:500;">50 KM</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:12px;color:#7A8481;margin-top:4px;">Jabodetabek & sekitarnya</div>
    </div>
    <div style="padding-top:20px;border-top:1px dashed #2E4A4A;">
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#7A8481;letter-spacing:0.1em;text-transform:uppercase;">ESTIMASI TIBA DI DAPUR</div>
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:20px;color:#C2401C;font-weight:500;margin-top:4px;">Sebelum 11:00 WIB</div>
    </div>
    <div class="bs-grade-stamp" style="position:absolute;top:-18px;right:24px;width:72px;height:72px;background:#C2401C;border-radius:50%;display:flex;flex-direction:column;align-items:center;justify-content:center;transform:rotate(3deg);box-shadow:inset 0 0 0 3px rgba(255,255,255,0.15),0 4px 12px rgba(194,64,28,0.4);cursor:pointer;">
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:8px;color:#F3EFE4;letter-spacing:0.15em;text-transform:uppercase;line-height:1;">GRADE</div>
        <div style="font-family:Oswald,sans-serif;font-weight:900;font-size:24px;color:#F3EFE4;line-height:1;margin-top:2px;">A</div>
    </div>
</div>',
                        ],
                    ],
                ],
            ],
        ],
    ],

    // SECTION 2: STATS BAR (paper ivory)
    [
        'id' => 'bs-stats-s',
        'elType' => 'section',
        'settings' => [
            'background_background' => 'classic',
            'background_color' => '#F3EFE4',
            'padding' => ['unit'=>'px','top'=>'36','right'=>'80','bottom'=>'36','left'=>'80','isLinked'=>false],
            'padding_mobile' => ['unit'=>'px','top'=>'32','right'=>'24','bottom'=>'32','left'=>'24','isLinked'=>false],
        ],
        'elements' => [[
            'id'=>'bs-stats-col','elType'=>'column','settings'=>['_column_size'=>100],
            'elements' => [[
                'id'=>'bs-stats-w','elType'=>'widget','widgetType'=>'text-editor',
                'settings' => ['editor' => '<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:24px;align-items:center;">
<div style="text-align:center;">
    <div style="font-family:Oswald,sans-serif;font-weight:800;font-size:40px;color:#12181B;line-height:1;letter-spacing:-0.02em;">50+</div>
    <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:11px;color:#7A8481;margin-top:6px;letter-spacing:0.08em;text-transform:uppercase;">Mitra Hotel & Restoran</div>
</div>
<div style="text-align:center;border-left:1px solid #D0C8B8;border-right:1px solid #D0C8B8;padding:0 16px;">
    <div style="font-family:Oswald,sans-serif;font-weight:800;font-size:40px;color:#12181B;line-height:1;letter-spacing:-0.02em;">2 Ton</div>
    <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:11px;color:#7A8481;margin-top:6px;letter-spacing:0.08em;text-transform:uppercase;">Kapasitas Suplai/Hari</div>
</div>
<div style="text-align:center;border-right:1px solid #D0C8B8;padding:0 16px;">
    <div style="font-family:Oswald,sans-serif;font-weight:800;font-size:40px;color:#12181B;line-height:1;letter-spacing:-0.02em;">04:00</div>
    <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:11px;color:#7A8481;margin-top:6px;letter-spacing:0.08em;text-transform:uppercase;">Mulai Operasional WIB</div>
</div>
<div style="text-align:center;">
    <div style="font-family:Oswald,sans-serif;font-weight:800;font-size:40px;color:#C2401C;line-height:1;letter-spacing:-0.02em;">0–2°C</div>
    <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:11px;color:#7A8481;margin-top:6px;letter-spacing:0.08em;text-transform:uppercase;">Suhu Cold-Chain Terjaga</div>
</div>
</div>'],
            ]],
        ]],
    ],

    // SECTION 3: IMAGE STRIP — 3 foto full-bleed kategori produk
    [
        'id' => 'bs-img-strip',
        'elType' => 'section',
        'settings' => [
            'layout' => 'full_width',
            'background_background' => 'classic',
            'background_color' => '#0D1316',
            'padding' => ['unit'=>'px','top'=>'0','right'=>'0','bottom'=>'0','left'=>'0','isLinked'=>false],
            'custom_id' => 'manifest-produk',
        ],
        'elements' => [[
            'id'=>'bs-strip-col','elType'=>'column','settings'=>['_column_size'=>100],
            'elements' => [
                [
                    'id'=>'bs-strip-label','elType'=>'widget','widgetType'=>'text-editor',
                    'settings' => ['editor' => '<div style="padding:60px 80px 40px;font-family:\'IBM Plex Mono\',monospace;font-size:11px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;">DAFTAR MANIFEST PRODUK</div>',
                        'margin' => ['unit'=>'px','top'=>'0','right'=>'0','bottom'=>'0','left'=>'0','isLinked'=>false]],
                ],
                [
                    'id'=>'bs-strip-title','elType'=>'widget','widgetType'=>'heading',
                    'settings' => [
                        'title' => 'Empat Kategori Pengiriman',
                        'header_size' => 'h2',
                        'align' => 'left',
                        'title_color' => '#F3EFE4',
                        'typography_typography' => 'custom',
                        'typography_font_family' => 'Oswald',
                        'typography_font_weight' => '700',
                        'typography_font_size' => ['unit'=>'px','size'=>52],
                        'typography_font_size_tablet' => ['unit'=>'px','size'=>36],
                        'typography_line_height' => ['unit'=>'em','size'=>0.95],
                        'padding' => ['unit'=>'px','top'=>'0','right'=>'80','bottom'=>'40','left'=>'80','isLinked'=>false],
                    ],
                ],
                // Image strip 3-col (Pattern 2 dari skill)
                [
                    'id'=>'bs-strip-grid','elType'=>'widget','widgetType'=>'text-editor',
                    'settings' => ['editor' => '
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:2px;margin-bottom:2px;">
    <!-- Card 01 Ikan Segar -->
    <a href="/produk" style="display:block;position:relative;height:420px;overflow:hidden;text-decoration:none;">
        <div style="position:absolute;inset:0;background-image:url(\''.$IMGS['ikan_segar'].'\');background-size:cover;background-position:center;transition:transform 0.7s ease;"></div>
        <div style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(13,19,22,0.1) 0%,rgba(13,19,22,0.85) 100%);"></div>
        <div style="position:absolute;inset:0;display:flex;flex-direction:column;justify-content:flex-end;padding:32px 28px;">
            <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:12px;">01 / IKAN SEGAR</div>
            <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:28px;color:#F3EFE4;line-height:1;margin-bottom:8px;">Ikan Segar</div>
            <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:13px;color:rgba(243,239,228,0.6);line-height:1.5;margin-bottom:16px;">Kakap merah, kerapu, tenggiri, bawal, tuna — dari TPI jam 4 pagi</div>
            <span style="font-family:Oswald,sans-serif;font-size:12px;color:#F3EFE4;letter-spacing:0.12em;text-transform:uppercase;border-bottom:1px solid rgba(243,239,228,0.4);padding-bottom:4px;display:inline-block;width:fit-content;">Tanya Ketersediaan →</span>
        </div>
    </a>
    <!-- Card 02 Udang & Seafood Beku -->
    <a href="/produk" style="display:block;position:relative;height:420px;overflow:hidden;text-decoration:none;">
        <div style="position:absolute;inset:0;background-image:url(\''.$IMGS['udang'].'\');background-size:cover;background-position:center;transition:transform 0.7s ease;"></div>
        <div style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(13,19,22,0.1) 0%,rgba(13,19,22,0.88) 100%);"></div>
        <div style="position:absolute;inset:0;display:flex;flex-direction:column;justify-content:flex-end;padding:32px 28px;">
            <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#7A8481;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:12px;">02 / UDANG & SEAFOOD BEKU</div>
            <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:28px;color:#F3EFE4;line-height:1;margin-bottom:8px;">Udang & Seafood Beku</div>
            <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:13px;color:rgba(243,239,228,0.6);line-height:1.5;margin-bottom:16px;">Vaname IQF, Tiger, Galah — size 16/20 hingga 61/70</div>
            <span style="font-family:Oswald,sans-serif;font-size:12px;color:#F3EFE4;letter-spacing:0.12em;text-transform:uppercase;border-bottom:1px solid rgba(243,239,228,0.4);padding-bottom:4px;display:inline-block;width:fit-content;">Tanya Ketersediaan →</span>
        </div>
    </a>
    <!-- Card 03 Cumi & Kepiting -->
    <a href="/produk" style="display:block;position:relative;height:420px;overflow:hidden;text-decoration:none;">
        <div style="position:absolute;inset:0;background-image:url(\''.$IMGS['cumi'].'\');background-size:cover;background-position:center;transition:transform 0.7s ease;"></div>
        <div style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(13,19,22,0.1) 0%,rgba(13,19,22,0.88) 100%);"></div>
        <div style="position:absolute;inset:0;display:flex;flex-direction:column;justify-content:flex-end;padding:32px 28px;">
            <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#7A8481;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:12px;">03 / CUMI, KERANG & KEPITING</div>
            <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:28px;color:#F3EFE4;line-height:1;margin-bottom:8px;">Cumi, Kerang & Kepiting</div>
            <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:13px;color:rgba(243,239,228,0.6);line-height:1.5;margin-bottom:16px;">Cumi segar, kepiting bakau, kerang hijau, rajungan</div>
            <span style="font-family:Oswald,sans-serif;font-size:12px;color:#F3EFE4;letter-spacing:0.12em;text-transform:uppercase;border-bottom:1px solid rgba(243,239,228,0.4);padding-bottom:4px;display:inline-block;width:fit-content;">Tanya Ketersediaan →</span>
        </div>
    </a>
</div>
<div style="text-align:center;padding:48px;">
    <a href="/produk" style="display:inline-block;background:transparent;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:13px;letter-spacing:0.12em;text-transform:uppercase;padding:14px 36px;text-decoration:none;border:2px solid rgba(243,239,228,0.3);">Lihat Katalog Lengkap →</a>
</div>
'],
                ],
            ],
        ]],
    ],

    // SECTION 4: ZIGZAG — Proses (image kiri, text kanan)
    [
        'id' => 'bs-zigzag-1',
        'elType' => 'section',
        'settings' => [
            'layout' => 'full_width',
            'background_background' => 'classic',
            'background_color' => '#F3EFE4',
            'padding' => ['unit'=>'px','top'=>'0','right'=>'0','bottom'=>'0','left'=>'0','isLinked'=>false],
        ],
        'elements' => [
            // Col kiri: gambar pasar/penimbangan
            [
                'id' => 'bs-zig-img-col',
                'elType' => 'column',
                'settings' => [
                    '_column_size' => 50,
                    'padding' => ['unit'=>'px','top'=>'0','right'=>'0','bottom'=>'0','left'=>'0','isLinked'=>false],
                ],
                'elements' => [[
                    'id'=>'bs-zig-img-w','elType'=>'widget','widgetType'=>'text-editor',
                    'settings' => ['editor' => '<div style="position:relative;height:560px;overflow:hidden;"><img src="'.$IMGS['proses_timbang'].'" alt="Proses penimbangan ikan segar Bahari Segar" style="width:100%;height:100%;object-fit:cover;filter:brightness(0.85) contrast(1.1);" /></div>'],
                ]],
            ],
            // Col kanan: text proses
            [
                'id' => 'bs-zig-text-col',
                'elType' => 'column',
                'settings' => [
                    '_column_size' => 50,
                    'content_position' => 'middle',
                    'padding' => ['unit'=>'px','top'=>'80','right'=>'80','bottom'=>'80','left'=>'60','isLinked'=>false],
                    'padding_tablet' => ['unit'=>'px','top'=>'60','right'=>'40','bottom'=>'60','left'=>'40','isLinked'=>false],
                ],
                'elements' => [[
                    'id'=>'bs-zig-text-w','elType'=>'widget','widgetType'=>'text-editor',
                    'settings' => ['editor' => '
<div style="font-family:\'IBM Plex Mono\',monospace;font-size:11px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:20px;">PROSES RANTAI SUPLAI</div>
<h2 style="font-family:Oswald,sans-serif;font-weight:800;font-size:48px;color:#12181B;line-height:0.95;letter-spacing:-0.02em;margin-bottom:32px;">Dari Pelelangan ke Dapur Anda, Tanpa Jeda Freezer.</h2>
<p style="font-family:\'IBM Plex Sans\',sans-serif;font-size:16px;color:#7A8481;line-height:1.7;margin-bottom:36px;">Tim kami tiba di TPI sebelum kapal nelayan bersandar. Setiap batch dicatat jam tangkap, berat, kondisi grading. Tidak ada yang masuk ke kendaraan tanpa lolos pemeriksaan.</p>
<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:40px;">
    <div style="border-top:2px solid #C2401C;padding-top:16px;">
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:24px;color:#C2401C;margin-bottom:6px;">03:00</div>
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:16px;color:#12181B;margin-bottom:4px;">Berangkat ke TPI</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:12px;color:#7A8481;">Grading mutu dilakukan langsung di TPI</div>
    </div>
    <div style="border-top:2px solid #D0C8B8;padding-top:16px;">
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:24px;color:#12181B;margin-bottom:6px;">05:30</div>
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:16px;color:#12181B;margin-bottom:4px;">Pengiriman Dimulai</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:12px;color:#7A8481;">Armada berpendingin 0–2°C berangkat</div>
    </div>
</div>
<a href="/tentang-kami" style="display:inline-block;background:#12181B;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:13px;letter-spacing:0.1em;text-transform:uppercase;padding:16px 32px;text-decoration:none;">Tentang Kami →</a>
'],
                ]],
            ],
        ],
    ],

    // SECTION 5: FULL-BLEED IMAGE CTA — background foto gelap pasar ikan
    [
        'id' => 'bs-img-cta-full',
        'elType' => 'section',
        'settings' => [
            'layout' => 'full_width',
            'height' => 'min-height',
            'custom_height' => ['size'=>450,'unit'=>'px'],
            'background_background' => 'classic',
            'background_image' => ['url' => $IMGS['fish_market'], 'id' => ''],
            'background_size' => 'cover',
            'background_position' => 'center center',
            'padding' => ['unit'=>'px','top'=>'0','right'=>'0','bottom'=>'0','left'=>'0','isLinked'=>false],
        ],
        'elements' => [[
            'id'=>'bs-imgcta-col','elType'=>'column','settings'=>['_column_size'=>100,'content_position'=>'middle'],
            'elements' => [[
                'id'=>'bs-imgcta-w','elType'=>'widget','widgetType'=>'text-editor',
                'settings' => ['editor' => '
<div style="position:relative;padding:80px;background:linear-gradient(105deg,rgba(13,19,22,0.9) 40%,rgba(13,19,22,0.4) 100%);min-height:450px;display:flex;align-items:center;">
    <div style="max-width:520px;">
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:11px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:20px;">TESTIMONI MITRA</div>
        <div style="font-family:Oswald,sans-serif;font-weight:800;font-size:56px;color:#C2401C;line-height:0.8;margin-bottom:20px;">&ldquo;</div>
        <blockquote style="font-family:Oswald,sans-serif;font-weight:700;font-size:28px;color:#F3EFE4;line-height:1.2;letter-spacing:-0.01em;margin:0 0 28px;border:none;padding:0;">
            Chef kami tidak perlu cek kondisi ikan setiap pagi — kami sudah tahu Bahari Segar tidak pernah kirim yang tidak layak.
        </blockquote>
        <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;background:#C2401C;border-radius:50%;display:flex;flex-direction:column;align-items:center;justify-content:center;transform:rotate(-3deg);flex-shrink:0;">
                <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:6px;color:#F3EFE4;letter-spacing:0.1em;line-height:1;">GRADE</div>
                <div style="font-family:Oswald,sans-serif;font-weight:900;font-size:15px;color:#F3EFE4;line-height:1;">A</div>
            </div>
            <div>
                <div style="font-family:\'IBM Plex Sans\',sans-serif;font-weight:500;font-size:13px;color:#F3EFE4;">Executive Chef Bambang S.</div>
                <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#7A8481;margin-top:2px;letter-spacing:0.08em;">Hotel Bintang 5 · Jakarta Selatan · Mitra sejak 2021</div>
            </div>
        </div>
    </div>
</div>
'],
                ],
            ]],
        ]],
    ],

    // SECTION 6: CTA BOTTOM
    [
        'id' => 'bs-cta-b-img',
        'elType' => 'section',
        'settings' => [
            'background_background' => 'classic',
            'background_color' => '#C2401C',
            'padding' => ['unit'=>'px','top'=>'80','right'=>'80','bottom'=>'80','left'=>'80','isLinked'=>false],
            'padding_mobile' => ['unit'=>'px','top'=>'60','right'=>'24','bottom'=>'60','left'=>'24','isLinked'=>false],
        ],
        'elements' => [[
            'id'=>'bs-ctab-col','elType'=>'column','settings'=>['_column_size'=>100],
            'elements' => [[
                'id'=>'bs-ctab-w','elType'=>'widget','widgetType'=>'text-editor',
                'settings' => ['editor' => '
<div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:40px;">
    <div>
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:11px;color:rgba(243,239,228,0.55);letter-spacing:0.2em;text-transform:uppercase;margin-bottom:12px;">MULAI KERJASAMA HARI INI</div>
        <h2 style="font-family:Oswald,sans-serif;font-weight:800;font-size:44px;color:#F3EFE4;line-height:0.95;letter-spacing:-0.02em;margin:0;">Siap Suplai Dapur Anda<br>Besok Pagi?</h2>
    </div>
    <div style="display:flex;gap:16px;flex-wrap:wrap;">
        <a href="'.$WA.'?text=Halo%20Bahari%20Segar%2C%20saya%20tertarik%20kerjasama%20suplai%20seafood" target="_blank" rel="noopener" style="display:inline-block;background:#F3EFE4;color:#C2401C;font-family:Oswald,sans-serif;font-weight:700;font-size:14px;letter-spacing:0.08em;text-transform:uppercase;padding:18px 36px;text-decoration:none;">Chat WhatsApp Sekarang</a>
        <a href="/kerjasama-b2b" style="display:inline-block;background:transparent;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:14px;letter-spacing:0.08em;text-transform:uppercase;padding:18px 36px;text-decoration:none;border:2px solid rgba(243,239,228,0.4);">Isi Form Kerjasama</a>
    </div>
</div>'],
            ]],
        ]],
    ],
];

// Inject Beranda
$beranda_json = json_encode($beranda_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
set_post_meta($pdo, $ids['beranda'], '_elementor_data', $beranda_json);
echo "  ✓ Beranda upgraded with images\n";

// ─── TENTANG KAMI — Upgrade dengan foto dokumenter ───────────────────────────
echo "\n[2/4] Upgrading Tentang Kami with images...\n";

$tentang_data = [
    // Hero: full-bleed image dengan teks overlay
    [
        'id' => 'bs-ta-hero-img',
        'elType' => 'section',
        'settings' => [
            'layout' => 'full_width',
            'height' => 'min-height',
            'custom_height' => ['size'=>620,'unit'=>'px'],
            'background_background' => 'classic',
            'background_image' => ['url' => $IMGS['tentang_bg'], 'id' => ''],
            'background_size' => 'cover',
            'background_position' => 'center center',
            'padding' => ['unit'=>'px','top'=>'0','right'=>'0','bottom'=>'0','left'=>'0','isLinked'=>false],
        ],
        'elements' => [[
            'id'=>'bs-ta-col','elType'=>'column','settings'=>['_column_size'=>100,'content_position'=>'bottom'],
            'elements' => [[
                'id'=>'bs-ta-content','elType'=>'widget','widgetType'=>'text-editor',
                'settings' => ['editor' => '
<div style="background:linear-gradient(180deg,transparent 0%,rgba(13,19,22,0.97) 60%);padding:100px 80px 80px;position:relative;">
    <div style="font-family:\'IBM Plex Mono\',monospace;font-size:11px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:16px;">TENTANG KAMI</div>
    <h1 style="font-family:Oswald,sans-serif;font-weight:800;font-size:clamp(2.5rem,6vw,5rem);color:#F3EFE4;line-height:0.95;letter-spacing:-0.02em;margin:0 0 24px;max-width:800px;">Bukan Sekadar Suplier.<br>Kami Bagian dari Dapur Anda.</h1>
    <p style="font-family:\'IBM Plex Sans\',sans-serif;font-size:17px;color:rgba(243,239,228,0.55);max-width:580px;line-height:1.65;">Bahari Segar berdiri dari satu keresahan: sulit mendapat pasokan seafood segar yang konsisten dan terdokumentasi.</p>
</div>'],
            ]],
        ]],
    ],

    // Konten utama: zigzag foto + teks
    [
        'id' => 'bs-ta-body',
        'elType' => 'section',
        'settings' => [
            'background_background' => 'classic',
            'background_color' => '#12181B',
            'padding' => ['unit'=>'px','top'=>'100','right'=>'80','bottom'=>'100','left'=>'80','isLinked'=>false],
            'padding_mobile' => ['unit'=>'px','top'=>'60','right'=>'24','bottom'=>'60','left'=>'24','isLinked'=>false],
        ],
        'elements' => [
            [
                'id'=>'bs-ta-left','elType'=>'column','settings'=>['_column_size'=>55,'content_position'=>'top'],
                'elements' => [[
                    'id'=>'bs-ta-txt','elType'=>'widget','widgetType'=>'text-editor',
                    'settings' => ['editor' => '
<p style="font-family:\'IBM Plex Sans\',sans-serif;font-size:18px;color:#F3EFE4;line-height:1.7;margin-bottom:28px;">Kami membangun hubungan langsung dengan nelayan dan TPI. Setiap batch yang kami ambil dicatat: jam tangkap, berat, ukuran, kondisi saat grading. Tidak ada yang masuk ke kendaraan tanpa lolos pemeriksaan tim kami.</p>
<p style="font-family:\'IBM Plex Sans\',sans-serif;font-size:16px;color:#7A8481;line-height:1.7;margin-bottom:28px;">Hasilnya: mitra kami — chef di hotel bintang lima hingga restoran seafood independen — tidak perlu khawatir soal kualitas. Mereka tahu, sebelum jam 11 pagi, produk kami sudah di tangan mereka.</p>
<div style="display:grid;grid-template-columns:repeat(2,1fr);gap:1px;background:#1E2A2A;margin-top:48px;">
    <div style="background:#0D1316;padding:28px 24px;">
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:32px;color:#C2401C;margin-bottom:8px;">2018</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:12px;color:#7A8481;text-transform:uppercase;letter-spacing:0.08em;">Berdiri sejak</div>
    </div>
    <div style="background:#0D1316;padding:28px 24px;">
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:32px;color:#F3EFE4;margin-bottom:8px;">50+</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:12px;color:#7A8481;text-transform:uppercase;letter-spacing:0.08em;">Mitra aktif</div>
    </div>
    <div style="background:#0D1316;padding:28px 24px;">
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:32px;color:#F3EFE4;margin-bottom:8px;">2 Ton</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:12px;color:#7A8481;text-transform:uppercase;letter-spacing:0.08em;">Kapasitas/hari</div>
    </div>
    <div style="background:#0D1316;padding:28px 24px;">
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:32px;color:#C2401C;margin-bottom:8px;">03:00</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:12px;color:#7A8481;text-transform:uppercase;letter-spacing:0.08em;">Mulai operasi</div>
    </div>
</div>'],
                ]],
            ],
            [
                'id'=>'bs-ta-right','elType'=>'column','settings'=>['_column_size'=>45,'content_position'=>'top','padding'=>['unit'=>'px','top'=>'0','right'=>'0','bottom'=>'0','left'=>'40','isLinked'=>false]],
                'elements' => [[
                    'id'=>'bs-ta-img-w','elType'=>'widget','widgetType'=>'text-editor',
                    'settings' => ['editor' => '
<div style="position:relative;">
    <img src="'.$IMGS['cold_chain'].'" alt="Proses cold chain Bahari Segar" style="width:100%;height:480px;object-fit:cover;filter:brightness(0.9) contrast(1.05);" />
    <div style="position:absolute;bottom:0;left:0;right:0;background:linear-gradient(180deg,transparent,rgba(13,19,22,0.8));padding:24px 20px;">
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#C2401C;letter-spacing:0.15em;text-transform:uppercase;margin-bottom:4px;">COLD CHAIN TERJAGA</div>
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:18px;color:#F3EFE4;">0–2°C dari TPI ke dapur Anda</div>
    </div>
    <div style="position:absolute;top:20px;right:20px;width:64px;height:64px;background:#C2401C;border-radius:50%;display:flex;flex-direction:column;align-items:center;justify-content:center;transform:rotate(3deg);">
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:7px;color:#F3EFE4;letter-spacing:0.15em;">GRADE</div>
        <div style="font-family:Oswald,sans-serif;font-weight:900;font-size:22px;color:#F3EFE4;line-height:1;">A</div>
    </div>
</div>'],
                ]],
            ],
        ],
    ],
];

$tentang_json = json_encode($tentang_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
set_post_meta($pdo, $ids['tentang'], '_elementor_data', $tentang_json);
echo "  ✓ Tentang Kami upgraded\n";

// ─── PRODUK — Full katalog page dengan image grid ────────────────────────────
echo "\n[3/4] Upgrading Produk page...\n";

$produk_data = [
    // Hero
    [
        'id' => 'bs-pr-hero',
        'elType' => 'section',
        'settings' => [
            'layout' => 'full_width',
            'height' => 'min-height',
            'custom_height' => ['size'=>480,'unit'=>'px'],
            'background_background' => 'classic',
            'background_image' => ['url' => $IMGS['ikan_segar'], 'id' => ''],
            'background_size' => 'cover',
            'background_position' => 'center center',
            'padding' => ['unit'=>'px','top'=>'0','right'=>'0','bottom'=>'0','left'=>'0','isLinked'=>false],
        ],
        'elements' => [[
            'id'=>'bs-pr-col','elType'=>'column','settings'=>['_column_size'=>100,'content_position'=>'bottom'],
            'elements' => [[
                'id'=>'bs-pr-h','elType'=>'widget','widgetType'=>'text-editor',
                'settings' => ['editor' => '
<div style="background:linear-gradient(180deg,transparent 0%,rgba(13,19,22,0.95) 65%);padding:120px 80px 60px;">
    <div style="font-family:\'IBM Plex Mono\',monospace;font-size:11px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:16px;">KATALOG PRODUK</div>
    <h1 style="font-family:Oswald,sans-serif;font-weight:800;font-size:clamp(2.5rem,6vw,5rem);color:#F3EFE4;line-height:0.95;letter-spacing:-0.02em;margin:0 0 20px;">Ikan Segar, Udang, Cumi<br>& Olahan Hasil Laut.</h1>
    <p style="font-family:\'IBM Plex Sans\',sans-serif;font-size:16px;color:rgba(243,239,228,0.55);max-width:520px;line-height:1.6;">Semua produk dipilih langsung dari TPI jam 4 pagi. Harga grosir untuk hotel dan restoran — hubungi kami untuk penawaran volume.</p>
</div>'],
            ]],
        ]],
    ],

    // Kategori 01: Ikan Segar
    [
        'id' => 'bs-pr-cat1',
        'elType' => 'section',
        'settings' => [
            'background_background' => 'classic',
            'background_color' => '#12181B',
            'padding' => ['unit'=>'px','top'=>'80','right'=>'80','bottom'=>'80','left'=>'80','isLinked'=>false],
            'padding_mobile' => ['unit'=>'px','top'=>'60','right'=>'24','bottom'=>'60','left'=>'24','isLinked'=>false],
        ],
        'elements' => [[
            'id'=>'bs-pr-cat1-col','elType'=>'column','settings'=>['_column_size'=>100],
            'elements' => [[
                'id'=>'bs-pr-cat1-w','elType'=>'widget','widgetType'=>'text-editor',
                'settings' => ['editor' => '
<div style="margin-bottom:40px;padding-bottom:24px;border-bottom:1px solid #1E2A2A;display:flex;align-items:baseline;gap:20px;">
    <div style="font-family:\'IBM Plex Mono\',monospace;font-size:11px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;">01</div>
    <h2 style="font-family:Oswald,sans-serif;font-weight:700;font-size:40px;color:#F3EFE4;line-height:1;letter-spacing:-0.01em;margin:0;">Ikan Segar</h2>
    <span style="font-family:\'IBM Plex Mono\',monospace;font-size:11px;color:#7A8481;letter-spacing:0.12em;text-transform:uppercase;margin-left:auto;">Tersedia sepanjang tahun</span>
</div>
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:2px;">
    <div style="background:#0D1316;padding:32px 28px;border-top:3px solid #C2401C;">
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:22px;color:#F3EFE4;margin-bottom:12px;">Kakap Merah</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:13px;color:#7A8481;line-height:1.6;margin-bottom:16px;">Grade A: sisik utuh, mata jernih, insang merah cerah. Ukuran 300g–2kg/ekor.</div>
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#2E4A4A;margin-bottom:16px;">KEMASAN: Es curah / box styrofoam</div>
        <a href="'.$WA.'?text=Saya%20ingin%20tanya%20stok%20Kakap%20Merah" target="_blank" style="display:inline-block;background:#C2401C;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:11px;letter-spacing:0.1em;text-transform:uppercase;padding:10px 20px;text-decoration:none;">Tanya Ketersediaan</a>
    </div>
    <div style="background:#0D1316;padding:32px 28px;border-top:3px solid #2E4A4A;">
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:22px;color:#F3EFE4;margin-bottom:12px;">Kerapu Segar</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:13px;color:#7A8481;line-height:1.6;margin-bottom:16px;">Kerapu macan, tikus, bebek. Kualitas ekspor, 400g–3kg/ekor. Ketersediaan musiman.</div>
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#2E4A4A;margin-bottom:16px;">KEMASAN: Es curah</div>
        <a href="'.$WA.'?text=Saya%20ingin%20tanya%20stok%20Kerapu" target="_blank" style="display:inline-block;background:transparent;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:11px;letter-spacing:0.1em;text-transform:uppercase;padding:10px 20px;text-decoration:none;border:1px solid rgba(243,239,228,0.25);">Tanya Ketersediaan</a>
    </div>
    <div style="background:#0D1316;padding:32px 28px;border-top:3px solid #2E4A4A;">
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:22px;color:#F3EFE4;margin-bottom:12px;">Tuna Segar</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:13px;color:#7A8481;line-height:1.6;margin-bottom:16px;">Utuh dan loin siap olah. Grading standar ekspor Jepang. 2–30kg/ekor utuh.</div>
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#2E4A4A;margin-bottom:16px;">KEMASAN: Box styrofoam + es curah</div>
        <a href="'.$WA.'?text=Saya%20ingin%20tanya%20stok%20Tuna" target="_blank" style="display:inline-block;background:transparent;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:11px;letter-spacing:0.1em;text-transform:uppercase;padding:10px 20px;text-decoration:none;border:1px solid rgba(243,239,228,0.25);">Tanya Ketersediaan</a>
    </div>
</div>
<div style="display:grid;grid-template-columns:repeat(2,1fr);gap:2px;margin-top:2px;">
    <div style="background:#0D1316;padding:32px 28px;border-top:3px solid #2E4A4A;">
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:22px;color:#F3EFE4;margin-bottom:12px;">Tenggiri Segar</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:13px;color:#7A8481;line-height:1.6;margin-bottom:16px;">Ideal untuk ikan bakar, pepes, dan olahan dapur hotel. 500g–4kg/ekor.</div>
        <a href="'.$WA.'?text=Saya%20ingin%20tanya%20stok%20Tenggiri" target="_blank" style="display:inline-block;background:transparent;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:11px;letter-spacing:0.1em;text-transform:uppercase;padding:10px 20px;text-decoration:none;border:1px solid rgba(243,239,228,0.25);">Tanya Ketersediaan</a>
    </div>
    <div style="background:#0D1316;padding:32px 28px;border-top:3px solid #2E4A4A;">
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:22px;color:#F3EFE4;margin-bottom:12px;">Bawal Segar</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:13px;color:#7A8481;line-height:1.6;margin-bottom:16px;">Bawal putih & hitam. 200g–1kg/ekor. Populer untuk Chinese restaurant dan hotel.</div>
        <a href="'.$WA.'?text=Saya%20ingin%20tanya%20stok%20Bawal" target="_blank" style="display:inline-block;background:transparent;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:11px;letter-spacing:0.1em;text-transform:uppercase;padding:10px 20px;text-decoration:none;border:1px solid rgba(243,239,228,0.25);">Tanya Ketersediaan</a>
    </div>
</div>'],
            ]],
        ]],
    ],

    // Perforated divider
    [
        'id' => 'bs-pr-div1',
        'elType' => 'section',
        'settings' => ['background_background'=>'classic','background_color'=>'#12181B','padding'=>['unit'=>'px','top'=>'0','right'=>'0','bottom'=>'0','left'=>'0','isLinked'=>false]],
        'elements' => [[
            'id'=>'bs-div-col','elType'=>'column','settings'=>['_column_size'=>100],
            'elements' => [['id'=>'bs-div-w','elType'=>'widget','widgetType'=>'text-editor','settings'=>['editor'=>'<div style="height:20px;background:repeating-linear-gradient(90deg,#F3EFE4 0,#F3EFE4 10px,transparent 10px,transparent 18px);opacity:0.1;"></div>']]],
        ]],
    ],

    // Kategori 02: Udang & Seafood Beku
    [
        'id' => 'bs-pr-cat2',
        'elType' => 'section',
        'settings' => [
            'background_background' => 'classic',
            'background_color' => '#0D1316',
            'padding' => ['unit'=>'px','top'=>'80','right'=>'80','bottom'=>'80','left'=>'80','isLinked'=>false],
        ],
        'elements' => [[
            'id'=>'bs-pr-cat2-col','elType'=>'column','settings'=>['_column_size'=>100],
            'elements' => [[
                'id'=>'bs-pr-cat2-w','elType'=>'widget','widgetType'=>'text-editor',
                'settings' => ['editor' => '
<div style="margin-bottom:40px;padding-bottom:24px;border-bottom:1px solid #1E2A2A;display:flex;align-items:baseline;gap:20px;">
    <div style="font-family:\'IBM Plex Mono\',monospace;font-size:11px;color:#7A8481;letter-spacing:0.2em;text-transform:uppercase;">02</div>
    <h2 style="font-family:Oswald,sans-serif;font-weight:700;font-size:40px;color:#F3EFE4;line-height:1;margin:0;">Udang & Seafood Beku</h2>
    <span style="font-family:\'IBM Plex Mono\',monospace;font-size:11px;color:#7A8481;letter-spacing:0.12em;text-transform:uppercase;margin-left:auto;">Stok sepanjang tahun</span>
</div>
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:2px;">
    <div style="padding:32px 28px;border-top:3px solid #C2401C;background:#12181B;">
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:22px;color:#F3EFE4;margin-bottom:12px;">Udang Vaname IQF</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:13px;color:#7A8481;line-height:1.6;margin-bottom:16px;">Size 16/20 hingga 61/70. Head-on, headless, P&D. Stok terlengkap sepanjang tahun.</div>
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#2E4A4A;margin-bottom:16px;">KEMASAN: Box 1kg & 5kg vacuum</div>
        <a href="'.$WA.'?text=Saya%20ingin%20tanya%20stok%20Udang%20Vaname%20IQF" target="_blank" style="display:inline-block;background:#C2401C;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:11px;letter-spacing:0.1em;text-transform:uppercase;padding:10px 20px;text-decoration:none;">Tanya Ketersediaan</a>
    </div>
    <div style="padding:32px 28px;border-top:3px solid #2E4A4A;background:#12181B;">
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:22px;color:#F3EFE4;margin-bottom:12px;">Udang Tiger / Windu</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:13px;color:#7A8481;line-height:1.6;margin-bottom:16px;">Premium jumbo, U5–U12. Head-on segar dan beku IQF. Musiman — konfirmasi stok.</div>
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#2E4A4A;margin-bottom:16px;">KEMASAN: Box 1kg vacuum</div>
        <a href="'.$WA.'?text=Saya%20ingin%20tanya%20stok%20Udang%20Tiger" target="_blank" style="display:inline-block;background:transparent;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:11px;letter-spacing:0.1em;text-transform:uppercase;padding:10px 20px;text-decoration:none;border:1px solid rgba(243,239,228,0.25);">Tanya Ketersediaan</a>
    </div>
    <div style="padding:32px 28px;border-top:3px solid #2E4A4A;background:#12181B;">
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:22px;color:#F3EFE4;margin-bottom:12px;">Udang Galah</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:13px;color:#7A8481;line-height:1.6;margin-bottom:16px;">Air tawar segar dari tambak lokal. 100–400g/ekor. Musiman.</div>
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#2E4A4A;margin-bottom:16px;">KEMASAN: Es curah / box styrofoam</div>
        <a href="'.$WA.'?text=Saya%20ingin%20tanya%20stok%20Udang%20Galah" target="_blank" style="display:inline-block;background:transparent;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:11px;letter-spacing:0.1em;text-transform:uppercase;padding:10px 20px;text-decoration:none;border:1px solid rgba(243,239,228,0.25);">Tanya Ketersediaan</a>
    </div>
</div>'],
            ]],
        ]],
    ],

    // Kategori 03 & 04: Cumi + Olahan (side by side)
    [
        'id' => 'bs-pr-cat34',
        'elType' => 'section',
        'settings' => [
            'background_background' => 'classic',
            'background_color' => '#12181B',
            'padding' => ['unit'=>'px','top'=>'80','right'=>'80','bottom'=>'80','left'=>'80','isLinked'=>false],
        ],
        'elements' => [
            [
                'id'=>'bs-cat3-col','elType'=>'column','settings'=>['_column_size'=>50,'padding'=>['unit'=>'px','top'=>'0','right'=>'24','bottom'=>'0','left'=>'0','isLinked'=>false]],
                'elements' => [[
                    'id'=>'bs-cat3-w','elType'=>'widget','widgetType'=>'text-editor',
                    'settings' => ['editor' => '
<div style="font-family:\'IBM Plex Mono\',monospace;font-size:11px;color:#7A8481;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:12px;">03 / CUMI, KERANG & KEPITING</div>
<h2 style="font-family:Oswald,sans-serif;font-weight:700;font-size:36px;color:#F3EFE4;line-height:1;margin-bottom:32px;">Cumi, Kerang & Kepiting</h2>
<div style="display:flex;flex-direction:column;gap:2px;">
    <div style="background:#0D1316;padding:24px;border-left:3px solid #C2401C;">
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:18px;color:#F3EFE4;margin-bottom:8px;">Cumi-Cumi Segar</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:13px;color:#7A8481;margin-bottom:12px;">100–500g/ekor. Whole & cleaned. Puncak: April–September.</div>
        <a href="'.$WA.'?text=Tanya%20stok%20Cumi" target="_blank" style="font-family:Oswald,sans-serif;font-size:11px;color:#C2401C;letter-spacing:0.1em;text-transform:uppercase;text-decoration:none;">Tanya Ketersediaan →</a>
    </div>
    <div style="background:#0D1316;padding:24px;">
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:18px;color:#F3EFE4;margin-bottom:8px;">Kepiting Bakau Segar</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:13px;color:#7A8481;margin-bottom:12px;">300–800g/ekor. Jantan & betina. Diikat, box + es.</div>
        <a href="'.$WA.'?text=Tanya%20stok%20Kepiting%20Bakau" target="_blank" style="font-family:Oswald,sans-serif;font-size:11px;color:#C2401C;letter-spacing:0.1em;text-transform:uppercase;text-decoration:none;">Tanya Ketersediaan →</a>
    </div>
    <div style="background:#0D1316;padding:24px;">
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:18px;color:#F3EFE4;margin-bottom:8px;">Kerang Hijau & Rajungan</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:13px;color:#7A8481;margin-bottom:12px;">Kerang hijau in-shell & half-shell. Rajungan 100–300g/ekor.</div>
        <a href="'.$WA.'?text=Tanya%20stok%20Kerang%20dan%20Rajungan" target="_blank" style="font-family:Oswald,sans-serif;font-size:11px;color:#C2401C;letter-spacing:0.1em;text-transform:uppercase;text-decoration:none;">Tanya Ketersediaan →</a>
    </div>
</div>'],
                ]],
            ],
            [
                'id'=>'bs-cat4-col','elType'=>'column','settings'=>['_column_size'=>50,'padding'=>['unit'=>'px','top'=>'0','right'=>'0','bottom'=>'0','left'=>'24','isLinked'=>false]],
                'elements' => [[
                    'id'=>'bs-cat4-w','elType'=>'widget','widgetType'=>'text-editor',
                    'settings' => ['editor' => '
<div style="font-family:\'IBM Plex Mono\',monospace;font-size:11px;color:#7A8481;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:12px;">04 / OLAHAN HASIL LAUT</div>
<h2 style="font-family:Oswald,sans-serif;font-weight:700;font-size:36px;color:#F3EFE4;line-height:1;margin-bottom:32px;">Olahan Hasil Laut</h2>
<div style="display:flex;flex-direction:column;gap:2px;">
    <div style="background:#0D1316;padding:24px;">
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:18px;color:#F3EFE4;margin-bottom:8px;">Ikan Asin Kering</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:13px;color:#7A8481;margin-bottom:12px;">Teri nasi, gabus, jambal roti, layur. Kemasan vakum 500g & 1kg.</div>
        <a href="'.$WA.'?text=Tanya%20stok%20Ikan%20Asin" target="_blank" style="font-family:Oswald,sans-serif;font-size:11px;color:#C2401C;letter-spacing:0.1em;text-transform:uppercase;text-decoration:none;">Tanya Ketersediaan →</a>
    </div>
    <div style="background:#0D1316;padding:24px;">
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:18px;color:#F3EFE4;margin-bottom:8px;">Ebi & Terasi Premium</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:13px;color:#7A8481;margin-bottom:12px;">Grade A, vakum 250g & 500g. Dari produsen lokal berpengalaman.</div>
        <a href="'.$WA.'?text=Tanya%20stok%20Ebi%20dan%20Terasi" target="_blank" style="font-family:Oswald,sans-serif;font-size:11px;color:#C2401C;letter-spacing:0.1em;text-transform:uppercase;text-decoration:none;">Tanya Ketersediaan →</a>
    </div>
    <div style="background:#0D1316;padding:24px;border-left:3px solid #C2401C;">
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:18px;color:#F3EFE4;margin-bottom:8px;">Pempek & Otak-Otak</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:13px;color:#7A8481;margin-bottom:12px;">Tanpa pengawet, dari ikan tenggiri segar. Produksi harian, order H-2.</div>
        <a href="'.$WA.'?text=Tanya%20stok%20Pempek%20dan%20Otak-otak" target="_blank" style="font-family:Oswald,sans-serif;font-size:11px;color:#C2401C;letter-spacing:0.1em;text-transform:uppercase;text-decoration:none;">Tanya Ketersediaan →</a>
    </div>
</div>'],
                ]],
            ],
        ],
    ],

    // CTA: hubungi
    [
        'id' => 'bs-pr-cta',
        'elType' => 'section',
        'settings' => [
            'background_background' => 'classic',
            'background_color' => '#C2401C',
            'padding' => ['unit'=>'px','top'=>'60','right'=>'80','bottom'=>'60','left'=>'80','isLinked'=>false],
        ],
        'elements' => [[
            'id'=>'bs-prcta-col','elType'=>'column','settings'=>['_column_size'=>100],
            'elements' => [[
                'id'=>'bs-prcta-w','elType'=>'widget','widgetType'=>'text-editor',
                'settings' => ['editor' => '
<div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:32px;">
    <div>
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:11px;color:rgba(243,239,228,0.55);letter-spacing:0.2em;text-transform:uppercase;margin-bottom:8px;">HARGA GROSIR B2B</div>
        <h2 style="font-family:Oswald,sans-serif;font-weight:800;font-size:36px;color:#F3EFE4;line-height:1;margin:0;">Hubungi Kami untuk Penawaran Harga Volume</h2>
    </div>
    <div style="display:flex;gap:16px;flex-wrap:wrap;">
        <a href="'.$WA.'?text=Halo%20Bahari%20Segar%2C%20saya%20ingin%20mengetahui%20harga%20grosir%20produk" target="_blank" rel="noopener" style="display:inline-block;background:#F3EFE4;color:#C2401C;font-family:Oswald,sans-serif;font-weight:700;font-size:13px;letter-spacing:0.08em;text-transform:uppercase;padding:16px 32px;text-decoration:none;">Chat WhatsApp →</a>
        <a href="/kerjasama-b2b" style="display:inline-block;background:transparent;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:13px;letter-spacing:0.08em;text-transform:uppercase;padding:16px 32px;text-decoration:none;border:2px solid rgba(243,239,228,0.4);">Ajukan Kerjasama</a>
    </div>
</div>'],
            ]],
        ]],
    ],
];

$produk_json = json_encode($produk_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
set_post_meta($pdo, $ids['produk'], '_elementor_data', $produk_json);
// Make sure it's NOT the WooCommerce shop page
$pdo->prepare("DELETE FROM wp_options WHERE option_name = 'woocommerce_shop_page_id'")->execute();
echo "  ✓ Produk page upgraded (WooCommerce shop designation removed)\n";

echo "\n[4/4] Clearing Elementor & WP caches...\n";
// Clear Elementor CSS cache
$pdo->exec("DELETE FROM wp_options WHERE option_name LIKE '_elementor_css_%'");
$pdo->exec("DELETE FROM wp_options WHERE option_name LIKE '_transient_elementor%'");
$pdo->exec("DELETE FROM wp_options WHERE option_name LIKE '_transient_timeout_elementor%'");
// Clear WP transients
$pdo->exec("DELETE FROM wp_options WHERE option_name LIKE '_transient_%'");
echo "  ✓ Caches cleared\n";

echo "\n✅ Step 07 Complete!\n";
echo "   All pages upgraded with documentary-style images from Unsplash\n";
echo "   Produk page fixed (no longer WooCommerce shop page)\n\n";
