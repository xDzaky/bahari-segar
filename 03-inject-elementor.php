<?php
/**
 * Script 03: Inject Elementor Data for all pages
 * Run: php 03-inject-elementor.php
 */

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'gggaming21');
define('DB_NAME', 'db_wordpress');

$pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4", DB_USER, DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$ids = json_decode(file_get_contents(__DIR__ . '/page_ids.json'), true);
$WA = $ids['wa_number'] ?? '6281234567890';
$WA_LINK = "https://wa.me/{$WA}";

echo "\n=== Bahari Segar Build: Step 03 - Inject Elementor Data ===\n\n";

function set_post_meta($pdo, $post_id, $meta_key, $meta_value) {
    $check = $pdo->prepare("SELECT meta_id FROM wp_postmeta WHERE post_id = ? AND meta_key = ?");
    $check->execute([$post_id, $meta_key]);
    if ($check->fetch()) {
        $stmt = $pdo->prepare("UPDATE wp_postmeta SET meta_value = ? WHERE post_id = ? AND meta_key = ?");
        $stmt->execute([$meta_value, $post_id, $meta_key]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (?, ?, ?)");
        $stmt->execute([$post_id, $meta_key, $meta_value]);
    }
}

// ─── BERANDA ELEMENTOR DATA ────────────────────────────────────────────────────
$beranda_data = [
    // SECTION 1: HERO — Split Asymmetric "Tiket Manifest"
    [
        'id' => 'bs-hero',
        'elType' => 'section',
        'settings' => [
            'layout' => 'full_width',
            'height' => 'full',
            'content_overflow' => 'hidden',
            'background_background' => 'classic',
            'background_color' => '#12181B',
            'padding' => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => false],
            'custom_css' => '.elementor-section.elementor-section-full_width { position: relative; }',
        ],
        'elements' => [
            // Left column - Headline
            [
                'id' => 'bs-hero-left',
                'elType' => 'column',
                'settings' => [
                    '_column_size' => 62,
                    'content_position' => 'middle',
                    'padding' => ['unit' => 'px', 'top' => '100', 'right' => '60', 'bottom' => '100', 'left' => '80', 'isLinked' => false],
                    'padding_tablet' => ['unit' => 'px', 'top' => '80', 'right' => '40', 'bottom' => '80', 'left' => '40', 'isLinked' => false],
                    'padding_mobile' => ['unit' => 'px', 'top' => '60', 'right' => '24', 'bottom' => '60', 'left' => '24', 'isLinked' => false],
                ],
                'elements' => [
                    // Pre-headline badge
                    [
                        'id' => 'bs-pre-badge',
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => [
                            'editor' => '<span style="font-family:\'IBM Plex Mono\',monospace;font-size:11px;color:#C2401C;letter-spacing:0.15em;text-transform:uppercase;border:1px solid #C2401C;padding:4px 10px;display:inline-block;margin-bottom:28px;">TANGKAPAN HARI INI · 04:00 WIB</span>',
                        ],
                    ],
                    // Main Headline
                    [
                        'id' => 'bs-headline',
                        'elType' => 'widget',
                        'widgetType' => 'heading',
                        'settings' => [
                            'title' => 'Ditimbang Jam 4 Pagi, Sampai Dapur Anda Sebelum Jam Makan Siang.',
                            'header_size' => 'h1',
                            'align' => 'left',
                            'title_color' => '#F3EFE4',
                            'typography_typography' => 'custom',
                            'typography_font_family' => 'Oswald',
                            'typography_font_size' => ['unit' => 'px', 'size' => 72],
                            'typography_font_size_tablet' => ['unit' => 'px', 'size' => 48],
                            'typography_font_size_mobile' => ['unit' => 'px', 'size' => 36],
                            'typography_font_weight' => '800',
                            'typography_line_height' => ['unit' => 'em', 'size' => 0.95],
                            'typography_letter_spacing' => ['unit' => 'px', 'size' => -2],
                            'margin' => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '32', 'left' => '0', 'isLinked' => false],
                        ],
                    ],
                    // Sub-headline
                    [
                        'id' => 'bs-subhead',
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => [
                            'editor' => '<p style="font-family:\'IBM Plex Sans\',sans-serif;font-size:17px;color:#7A8481;line-height:1.6;max-width:520px;">Bahari Segar memasok ikan, udang, cumi, kerang, dan olahan hasil laut langsung dari pelelangan ke dapur hotel dan restoran — bukan dari gudang beku berbulan-bulan.</p>',
                            'margin' => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '48', 'left' => '0', 'isLinked' => false],
                        ],
                    ],
                    // CTA Buttons
                    [
                        'id' => 'bs-cta-wrap',
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => [
                            'editor' => '<div style="display:flex;gap:16px;flex-wrap:wrap;align-items:center;">
                                <a href="'.$WA_LINK.'?text=Halo%20Bahari%20Segar%2C%20saya%20ingin%20cek%20ketersediaan%20hari%20ini" target="_blank" rel="noopener" style="display:inline-block;background:#C2401C;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:15px;letter-spacing:0.08em;text-transform:uppercase;padding:16px 32px;text-decoration:none;transition:all 0.2s ease;">
                                    Cek Ketersediaan Hari Ini
                                </a>
                                <a href="#manifest-produk" style="display:inline-block;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:15px;letter-spacing:0.08em;text-transform:uppercase;padding:16px 0;text-decoration:none;border-bottom:2px solid #7A8481;">
                                    Lihat Kategori Produk ↓
                                </a>
                            </div>',
                        ],
                    ],
                ],
            ],
            // Right column - "Tiket Manifest" box
            [
                'id' => 'bs-hero-right',
                'elType' => 'column',
                'settings' => [
                    '_column_size' => 38,
                    'content_position' => 'middle',
                    'background_background' => 'classic',
                    'background_color' => '#0D1316',
                    'padding' => ['unit' => 'px', 'top' => '80', 'right' => '60', 'bottom' => '80', 'left' => '60', 'isLinked' => false],
                    'padding_tablet' => ['unit' => 'px', 'top' => '60', 'right' => '40', 'bottom' => '60', 'left' => '40', 'isLinked' => false],
                ],
                'elements' => [
                    [
                        'id' => 'bs-manifest-box',
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => [
                            'editor' => '
<div class="bs-manifest-ticket" style="
    border: 2px dashed #2E4A4A;
    padding: 36px 32px;
    position: relative;
    animation: stampIn 0.6s cubic-bezier(0.34,1.56,0.64,1) both;
">
    <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:28px;padding-bottom:16px;border-bottom:1px dashed #2E4A4A;">
        MANIFEST PENGIRIMAN · BATCH #BS-TODAY
    </div>

    <div style="margin-bottom:24px;">
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#7A8481;letter-spacing:0.15em;text-transform:uppercase;margin-bottom:6px;">TANGKAPAN HARI INI</div>
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:28px;color:#F3EFE4;font-weight:500;letter-spacing:-0.02em;">04:00 WIB</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:12px;color:#7A8481;margin-top:4px;">Langsung dari TPI & nelayan lokal</div>
    </div>

    <div style="margin-bottom:24px;">
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#7A8481;letter-spacing:0.15em;text-transform:uppercase;margin-bottom:6px;">SUHU RANTAI DINGIN</div>
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:28px;color:#F3EFE4;font-weight:500;letter-spacing:-0.02em;">0–2°C</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:12px;color:#7A8481;margin-top:4px;">Es curah + box styrofoam sealed</div>
    </div>

    <div style="margin-bottom:32px;">
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#7A8481;letter-spacing:0.15em;text-transform:uppercase;margin-bottom:6px;">RADIUS KIRIM</div>
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:28px;color:#F3EFE4;font-weight:500;letter-spacing:-0.02em;">50 KM</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:12px;color:#7A8481;margin-top:4px;">Jabodetabek & sekitarnya</div>
    </div>

    <div style="padding-top:20px;border-top:1px dashed #2E4A4A;">
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#7A8481;letter-spacing:0.1em;text-transform:uppercase;">ESTIMASI TIBA DI DAPUR</div>
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:20px;color:#C2401C;font-weight:500;margin-top:4px;">Sebelum 11:00 WIB</div>
    </div>

    <!-- Grade A Stamp -->
    <div class="bs-grade-stamp" style="
        position:absolute;
        top:-18px;
        right:24px;
        width:72px;
        height:72px;
        background:#C2401C;
        border-radius:50%;
        display:flex;
        flex-direction:column;
        align-items:center;
        justify-content:center;
        transform:rotate(3deg);
        box-shadow: inset 0 0 0 3px rgba(255,255,255,0.15), 0 4px 12px rgba(194,64,28,0.4);
        cursor:pointer;
    ">
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:8px;color:#F3EFE4;letter-spacing:0.15em;text-transform:uppercase;line-height:1;">GRADE</div>
        <div style="font-family:Oswald,sans-serif;font-weight:900;font-size:24px;color:#F3EFE4;line-height:1;margin-top:2px;">A</div>
    </div>
</div>
',
                        ],
                    ],
                ],
            ],
        ],
    ],

    // SECTION 2: KEPERCAYAAN STATS BAR
    [
        'id' => 'bs-trust-bar',
        'elType' => 'section',
        'settings' => [
            'background_background' => 'classic',
            'background_color' => '#F3EFE4',
            'padding' => ['unit' => 'px', 'top' => '40', 'right' => '80', 'bottom' => '40', 'left' => '80', 'isLinked' => false],
        ],
        'elements' => [
            [
                'id' => 'bs-trust-col',
                'elType' => 'column',
                'settings' => ['_column_size' => 100],
                'elements' => [
                    [
                        'id' => 'bs-trust-stats',
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => [
                            'editor' => '
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:32px;align-items:center;">
    <div style="text-align:center;">
        <div style="font-family:Oswald,sans-serif;font-weight:800;font-size:40px;color:#12181B;line-height:1;letter-spacing:-0.02em;">50+</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:12px;color:#7A8481;margin-top:6px;letter-spacing:0.05em;text-transform:uppercase;">Mitra Hotel & Restoran</div>
    </div>
    <div style="text-align:center;border-left:1px solid #D0C8B8;border-right:1px solid #D0C8B8;padding:0 24px;">
        <div style="font-family:Oswald,sans-serif;font-weight:800;font-size:40px;color:#12181B;line-height:1;letter-spacing:-0.02em;">2 Ton</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:12px;color:#7A8481;margin-top:6px;letter-spacing:0.05em;text-transform:uppercase;">Kapasitas Suplai/Hari</div>
    </div>
    <div style="text-align:center;border-right:1px solid #D0C8B8;padding:0 24px;">
        <div style="font-family:Oswald,sans-serif;font-weight:800;font-size:40px;color:#12181B;line-height:1;letter-spacing:-0.02em;">04:00</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:12px;color:#7A8481;margin-top:6px;letter-spacing:0.05em;text-transform:uppercase;">Mulai Operasional (WIB)</div>
    </div>
    <div style="text-align:center;">
        <div style="font-family:Oswald,sans-serif;font-weight:800;font-size:40px;color:#C2401C;line-height:1;letter-spacing:-0.02em;">0–2°C</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:12px;color:#7A8481;margin-top:6px;letter-spacing:0.05em;text-transform:uppercase;">Suhu Cold-Chain Terjaga</div>
    </div>
</div>
',
                        ],
                    ],
                ],
            ],
        ],
    ],

    // SECTION 3: DAFTAR MANIFEST (Produk)
    [
        'id' => 'bs-manifest-section',
        'elType' => 'section',
        'settings' => [
            'background_background' => 'classic',
            'background_color' => '#12181B',
            'padding' => ['unit' => 'px', 'top' => '100', 'right' => '80', 'bottom' => '100', 'left' => '80', 'isLinked' => false],
            'custom_id' => 'manifest-produk',
        ],
        'elements' => [
            [
                'id' => 'bs-manifest-col',
                'elType' => 'column',
                'settings' => ['_column_size' => 100],
                'elements' => [
                    [
                        'id' => 'bs-manifest-label',
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => [
                            'editor' => '<div style="font-family:\'IBM Plex Mono\',monospace;font-size:11px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:16px;">DAFTAR MANIFEST PRODUK</div>',
                        ],
                    ],
                    [
                        'id' => 'bs-manifest-title',
                        'elType' => 'widget',
                        'widgetType' => 'heading',
                        'settings' => [
                            'title' => 'Empat Kategori Pengiriman',
                            'header_size' => 'h2',
                            'align' => 'left',
                            'title_color' => '#F3EFE4',
                            'typography_typography' => 'custom',
                            'typography_font_family' => 'Oswald',
                            'typography_font_weight' => '700',
                            'typography_font_size' => ['unit' => 'px', 'size' => 52],
                            'typography_font_size_tablet' => ['unit' => 'px', 'size' => 36],
                            'typography_line_height' => ['unit' => 'em', 'size' => 0.95],
                            'margin' => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '60', 'left' => '0', 'isLinked' => false],
                        ],
                    ],
                    [
                        'id' => 'bs-cat-grid',
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => [
                            'editor' => '
<div style="display:grid;grid-template-columns:repeat(2,1fr);gap:2px;">

    <!-- Category 01 -->
    <div style="background:#0D1316;padding:48px 40px;position:relative;border-top:3px solid #C2401C;">
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:11px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:20px;">01 / IKAN SEGAR</div>
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:32px;color:#F3EFE4;margin-bottom:20px;line-height:1;">Ikan Segar</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:14px;color:#7A8481;line-height:1.7;margin-bottom:24px;">
            Kakap merah, kerapu, tenggiri, bandeng, bawal, tuna, tongkol, dan jenis musiman langsung dari TPI. Ukuran: 200g–5kg/ekor. Dikemas es curah atau box styrofoam.
        </div>
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:12px;color:#2E4A4A;margin-top:auto;">
            <span style="color:#7A8481;">Harga:</span> Hubungi untuk rate grosir
        </div>
    </div>

    <!-- Category 02 -->
    <div style="background:#0D1316;padding:48px 40px;position:relative;border-top:3px solid #2E4A4A;">
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:11px;color:#7A8481;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:20px;">02 / UDANG & SEAFOOD BEKU</div>
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:32px;color:#F3EFE4;margin-bottom:20px;line-height:1;">Udang & Seafood Beku</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:14px;color:#7A8481;line-height:1.7;margin-bottom:24px;">
            Udang vaname, udang tiger, udang galah. IQF (Individually Quick Frozen), size 16/20 hingga 40/60. Tersedia head-on, headless, dan peeled. Stok tersedia sepanjang tahun.
        </div>
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:12px;color:#2E4A4A;">
            <span style="color:#7A8481;">Harga:</span> Hubungi untuk rate grosir
        </div>
    </div>

    <!-- Category 03 -->
    <div style="background:#0D1316;padding:48px 40px;position:relative;border-top:3px solid #2E4A4A;">
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:11px;color:#7A8481;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:20px;">03 / CUMI, KERANG & KEPITING</div>
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:32px;color:#F3EFE4;margin-bottom:20px;line-height:1;">Cumi, Kerang & Kepiting</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:14px;color:#7A8481;line-height:1.7;margin-bottom:24px;">
            Cumi-cumi segar (100–400g/ekor), kerang hijau, kerang darah, tiram segar, kepiting bakau, dan rajungan. Ketersediaan musiman — konfirmasi stok setiap hari.
        </div>
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:12px;color:#2E4A4A;">
            <span style="color:#7A8481;">Harga:</span> Hubungi untuk rate grosir
        </div>
    </div>

    <!-- Category 04 -->
    <div style="background:#0D1316;padding:48px 40px;position:relative;border-top:3px solid #2E4A4A;">
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:11px;color:#7A8481;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:20px;">04 / OLAHAN HASIL LAUT</div>
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:32px;color:#F3EFE4;margin-bottom:20px;line-height:1;">Olahan Hasil Laut</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:14px;color:#7A8481;line-height:1.7;margin-bottom:24px;">
            Ikan asin, teri nasi, ebi, terasi, pempek, otak-otak, dan aneka frozen seafood olahan. Tersedia dalam kemasan vakum untuk kemudahan penyimpanan dapur hotel.
        </div>
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:12px;color:#2E4A4A;">
            <span style="color:#7A8481;">Harga:</span> Hubungi untuk rate grosir
        </div>
    </div>

</div>
<div style="text-align:center;margin-top:60px;">
    <a href="/produk" style="display:inline-block;background:transparent;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:14px;letter-spacing:0.1em;text-transform:uppercase;padding:16px 40px;text-decoration:none;border:2px solid #F3EFE4;">
        Lihat Katalog Lengkap →
    </a>
</div>
',
                        ],
                    ],
                ],
            ],
        ],
    ],

    // SECTION 4: PERFORATED DIVIDER
    [
        'id' => 'bs-divider-1',
        'elType' => 'section',
        'settings' => [
            'background_background' => 'classic',
            'background_color' => '#12181B',
            'padding' => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => false],
        ],
        'elements' => [
            [
                'id' => 'bs-div-col',
                'elType' => 'column',
                'settings' => ['_column_size' => 100],
                'elements' => [
                    [
                        'id' => 'bs-perf-div',
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => [
                            'editor' => '<div class="bs-perforation" style="height:24px;background:repeating-linear-gradient(90deg,#F3EFE4 0,#F3EFE4 12px,transparent 12px,transparent 20px);opacity:0.15;margin:0;"></div>',
                        ],
                    ],
                ],
            ],
        ],
    ],

    // SECTION 5: PROSES / TENTANG SINGKAT
    [
        'id' => 'bs-proses-section',
        'elType' => 'section',
        'settings' => [
            'background_background' => 'classic',
            'background_color' => '#F3EFE4',
            'padding' => ['unit' => 'px', 'top' => '100', 'right' => '80', 'bottom' => '100', 'left' => '80', 'isLinked' => false],
        ],
        'elements' => [
            [
                'id' => 'bs-proses-col',
                'elType' => 'column',
                'settings' => ['_column_size' => 100],
                'elements' => [
                    [
                        'id' => 'bs-proses-lbl',
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => [
                            'editor' => '<div style="font-family:\'IBM Plex Mono\',monospace;font-size:11px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:16px;">PROSES RANTAI SUPLAI</div>',
                        ],
                    ],
                    [
                        'id' => 'bs-proses-title',
                        'elType' => 'widget',
                        'widgetType' => 'heading',
                        'settings' => [
                            'title' => 'Dari Pelelangan ke Dapur Anda, Tanpa Jeda Freezer.',
                            'header_size' => 'h2',
                            'align' => 'left',
                            'title_color' => '#12181B',
                            'typography_typography' => 'custom',
                            'typography_font_family' => 'Oswald',
                            'typography_font_weight' => '700',
                            'typography_font_size' => ['unit' => 'px', 'size' => 52],
                            'typography_font_size_tablet' => ['unit' => 'px', 'size' => 36],
                            'typography_line_height' => ['unit' => 'em', 'size' => 0.95],
                            'margin' => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '60', 'left' => '0', 'isLinked' => false],
                        ],
                    ],
                    [
                        'id' => 'bs-proses-steps',
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => [
                            'editor' => '
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1px;background:#D0C8B8;">
    <div style="background:#F3EFE4;padding:36px 32px;">
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:32px;font-weight:500;color:#C2401C;margin-bottom:16px;">03:00</div>
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:20px;color:#12181B;margin-bottom:12px;line-height:1.1;">Berangkat ke TPI</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:13px;color:#7A8481;line-height:1.6;">Tim Bahari Segar tiba di TPI sebelum kapal nelayan bersandar. Pilih langsung, grading mutu dilakukan di sini.</div>
    </div>
    <div style="background:#F3EFE4;padding:36px 32px;border-left:1px solid #D0C8B8;">
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:32px;font-weight:500;color:#12181B;margin-bottom:16px;">04:00</div>
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:20px;color:#12181B;margin-bottom:12px;line-height:1.1;">Timbang & Kemas</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:13px;color:#7A8481;line-height:1.6;">Setiap batch ditimbang, diberi label kode batch, dikemas dengan es curah atau box styrofoam kedap udara.</div>
    </div>
    <div style="background:#F3EFE4;padding:36px 32px;border-left:1px solid #D0C8B8;">
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:32px;font-weight:500;color:#12181B;margin-bottom:16px;">05:30</div>
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:20px;color:#12181B;margin-bottom:12px;line-height:1.1;">Pengiriman Dimulai</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:13px;color:#7A8481;line-height:1.6;">Armada berpendingin berangkat ke masing-masing titik pengiriman. Suhu dijaga 0–2°C selama perjalanan.</div>
    </div>
    <div style="background:#F3EFE4;padding:36px 32px;border-left:1px solid #D0C8B8;">
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:32px;font-weight:500;color:#12181B;margin-bottom:16px;">&lt;11:00</div>
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:20px;color:#12181B;margin-bottom:12px;line-height:1.1;">Sampai di Dapur</div>
        <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:13px;color:#7A8481;line-height:1.6;">Produk diterima chef sebelum jam makan siang. Segar, bukan thawed — langsung siap olah tanpa transit freezer.</div>
    </div>
</div>
<div style="margin-top:48px;">
    <a href="/tentang-kami" style="display:inline-block;background:#12181B;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:14px;letter-spacing:0.1em;text-transform:uppercase;padding:16px 36px;text-decoration:none;">
        Tentang Kami →
    </a>
</div>
',
                        ],
                    ],
                ],
            ],
        ],
    ],

    // SECTION 6: TESTIMONI (Pull-quote offset)
    [
        'id' => 'bs-testi-section',
        'elType' => 'section',
        'settings' => [
            'background_background' => 'classic',
            'background_color' => '#12181B',
            'padding' => ['unit' => 'px', 'top' => '100', 'right' => '80', 'bottom' => '100', 'left' => '80', 'isLinked' => false],
        ],
        'elements' => [
            [
                'id' => 'bs-testi-col',
                'elType' => 'column',
                'settings' => ['_column_size' => 100],
                'elements' => [
                    [
                        'id' => 'bs-testi-content',
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => [
                            'editor' => '
<div style="max-width:800px;margin-left:12%;">
    <div style="font-family:Oswald,sans-serif;font-weight:800;font-size:60px;color:#C2401C;line-height:0.8;margin-bottom:24px;">&ldquo;</div>
    <blockquote style="font-family:Oswald,sans-serif;font-weight:700;font-size:32px;color:#F3EFE4;line-height:1.15;letter-spacing:-0.01em;margin:0 0 32px;border:none;padding:0;">
        Chef kami tidak perlu cek kondisi ikan setiap pagi — kami sudah tahu Bahari Segar tidak pernah kirim yang tidak layak.
    </blockquote>
    <div style="display:flex;align-items:center;gap:16px;">
        <div class="bs-grade-stamp-small" style="
            width:48px;height:48px;
            background:#C2401C;border-radius:50%;
            display:flex;flex-direction:column;align-items:center;justify-content:center;
            transform:rotate(-3deg);
            flex-shrink:0;
        ">
            <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:6px;color:#F3EFE4;letter-spacing:0.1em;line-height:1;">GRADE</div>
            <div style="font-family:Oswald,sans-serif;font-weight:900;font-size:16px;color:#F3EFE4;line-height:1;">A</div>
        </div>
        <div>
            <div style="font-family:\'IBM Plex Sans\',sans-serif;font-weight:500;font-size:14px;color:#F3EFE4;">Executive Chef Bambang S.</div>
            <div style="font-family:\'IBM Plex Mono\',monospace;font-size:11px;color:#7A8481;margin-top:2px;">Hotel Bintang 5 · Jakarta Selatan · Mitra sejak 2021</div>
        </div>
    </div>
</div>
',
                        ],
                    ],
                ],
            ],
        ],
    ],

    // SECTION 7: CTA BOTTOM
    [
        'id' => 'bs-cta-bottom',
        'elType' => 'section',
        'settings' => [
            'background_background' => 'classic',
            'background_color' => '#C2401C',
            'padding' => ['unit' => 'px', 'top' => '80', 'right' => '80', 'bottom' => '80', 'left' => '80', 'isLinked' => false],
        ],
        'elements' => [
            [
                'id' => 'bs-cta-b-col',
                'elType' => 'column',
                'settings' => ['_column_size' => 100],
                'elements' => [
                    [
                        'id' => 'bs-cta-b-content',
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => [
                            'editor' => '
<div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:40px;">
    <div>
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:11px;color:rgba(243,239,228,0.6);letter-spacing:0.2em;text-transform:uppercase;margin-bottom:12px;">MULAI KERJASAMA HARI INI</div>
        <h2 style="font-family:Oswald,sans-serif;font-weight:800;font-size:44px;color:#F3EFE4;line-height:0.95;letter-spacing:-0.02em;margin:0;">Siap Suplai Dapur Anda<br>Besok Pagi?</h2>
    </div>
    <div style="display:flex;gap:16px;flex-wrap:wrap;">
        <a href="'.$WA_LINK.'?text=Halo%20Bahari%20Segar%2C%20saya%20tertarik%20untuk%20kerjasama%20suplai%20seafood" target="_blank" rel="noopener" style="display:inline-block;background:#F3EFE4;color:#C2401C;font-family:Oswald,sans-serif;font-weight:700;font-size:15px;letter-spacing:0.08em;text-transform:uppercase;padding:18px 36px;text-decoration:none;">
            Chat WhatsApp Sekarang
        </a>
        <a href="/kerjasama-b2b" style="display:inline-block;background:transparent;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:15px;letter-spacing:0.08em;text-transform:uppercase;padding:18px 36px;text-decoration:none;border:2px solid rgba(243,239,228,0.4);">
            Isi Form Kerjasama
        </a>
    </div>
</div>
',
                        ],
                    ],
                ],
            ],
        ],
    ],
];

// ─── TENTANG KAMI ELEMENTOR DATA ──────────────────────────────────────────────
$tentang_data = [
    [
        'id' => 'bs-ta-hero',
        'elType' => 'section',
        'settings' => [
            'background_background' => 'classic',
            'background_color' => '#12181B',
            'padding' => ['unit' => 'px', 'top' => '120', 'right' => '80', 'bottom' => '80', 'left' => '80', 'isLinked' => false],
        ],
        'elements' => [
            [
                'id' => 'bs-ta-col',
                'elType' => 'column',
                'settings' => ['_column_size' => 100],
                'elements' => [
                    [
                        'id' => 'bs-ta-lbl',
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => ['editor' => '<div style="font-family:\'IBM Plex Mono\',monospace;font-size:11px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:16px;">TENTANG KAMI</div>'],
                    ],
                    [
                        'id' => 'bs-ta-title',
                        'elType' => 'widget',
                        'widgetType' => 'heading',
                        'settings' => [
                            'title' => 'Bukan Sekadar Suplier. Kami Bagian dari Dapur Anda.',
                            'header_size' => 'h1',
                            'align' => 'left',
                            'title_color' => '#F3EFE4',
                            'typography_typography' => 'custom',
                            'typography_font_family' => 'Oswald',
                            'typography_font_weight' => '800',
                            'typography_font_size' => ['unit' => 'px', 'size' => 72],
                            'typography_font_size_tablet' => ['unit' => 'px', 'size' => 48],
                            'typography_line_height' => ['unit' => 'em', 'size' => 0.95],
                            'typography_letter_spacing' => ['unit' => 'px', 'size' => -2],
                            'margin' => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '48', 'left' => '0', 'isLinked' => false],
                        ],
                    ],
                    [
                        'id' => 'bs-ta-body',
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => [
                            'editor' => '
<div style="display:grid;grid-template-columns:1.2fr 1fr;gap:80px;align-items:start;">
<div>
<p style="font-family:\'IBM Plex Sans\',sans-serif;font-size:18px;color:#F3EFE4;line-height:1.7;margin-bottom:28px;">
Bahari Segar berdiri dari satu keresahan: restoran dan hotel di Jakarta sulit mendapat pasokan seafood segar yang konsisten, terpercaya, dan terdokumentasi — bukan sekadar "katanya segar".
</p>
<p style="font-family:\'IBM Plex Sans\',sans-serif;font-size:16px;color:#7A8481;line-height:1.7;margin-bottom:28px;">
Kami mulai dengan membangun hubungan langsung dengan nelayan dan TPI (Tempat Pelelangan Ikan). Setiap batch yang kami ambil dicatat: jam tangkap, berat, ukuran, kondisi saat grading. Tidak ada yang masuk ke kendaraan tanpa lolos pemeriksaan tim kami.
</p>
<p style="font-family:\'IBM Plex Sans\',sans-serif;font-size:16px;color:#7A8481;line-height:1.7;">
Hasilnya: mitra kami — chef di hotel bintang lima hingga restoran seafood independen — tidak perlu khawatir soal kualitas. Mereka tahu, sebelum jam 11 pagi, produk kami sudah di tangan mereka, dan kondisinya sudah kami jamin sejak jam 3 dini hari.
</p>
</div>
<div>
<div style="background:#0D1316;padding:40px;border-top:3px solid #C2401C;">
    <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:28px;padding-bottom:16px;border-bottom:1px dashed #2E4A4A;">DATA OPERASIONAL</div>
    <div style="margin-bottom:20px;padding-bottom:20px;border-bottom:1px solid #1E2A2A;">
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#7A8481;text-transform:uppercase;letter-spacing:0.12em;margin-bottom:6px;">Berdiri Sejak</div>
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:24px;color:#F3EFE4;">2018</div>
    </div>
    <div style="margin-bottom:20px;padding-bottom:20px;border-bottom:1px solid #1E2A2A;">
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#7A8481;text-transform:uppercase;letter-spacing:0.12em;margin-bottom:6px;">Mitra Aktif</div>
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:24px;color:#F3EFE4;">50+ Bisnis</div>
    </div>
    <div style="margin-bottom:20px;padding-bottom:20px;border-bottom:1px solid #1E2A2A;">
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#7A8481;text-transform:uppercase;letter-spacing:0.12em;margin-bottom:6px;">Kapasitas Suplai</div>
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:24px;color:#F3EFE4;">2 Ton/Hari</div>
    </div>
    <div>
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#7A8481;text-transform:uppercase;letter-spacing:0.12em;margin-bottom:6px;">Mulai Operasi</div>
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:24px;color:#C2401C;">03:00 WIB</div>
    </div>
</div>
</div>
</div>
',
                        ],
                    ],
                ],
            ],
        ],
    ],
];

// ─── KERJASAMA B2B ELEMENTOR DATA ─────────────────────────────────────────────
$kerjasama_data = [
    [
        'id' => 'bs-kb-hero',
        'elType' => 'section',
        'settings' => [
            'background_background' => 'classic',
            'background_color' => '#12181B',
            'padding' => ['unit' => 'px', 'top' => '120', 'right' => '80', 'bottom' => '100', 'left' => '80', 'isLinked' => false],
        ],
        'elements' => [
            [
                'id' => 'bs-kb-col',
                'elType' => 'column',
                'settings' => ['_column_size' => 100],
                'elements' => [
                    [
                        'id' => 'bs-kb-lbl',
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => ['editor' => '<div style="font-family:\'IBM Plex Mono\',monospace;font-size:11px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:16px;">KERJASAMA B2B</div>'],
                    ],
                    [
                        'id' => 'bs-kb-title',
                        'elType' => 'widget',
                        'widgetType' => 'heading',
                        'settings' => [
                            'title' => 'Jadilah Mitra Suplai Bahari Segar.',
                            'header_size' => 'h1',
                            'title_color' => '#F3EFE4',
                            'typography_typography' => 'custom',
                            'typography_font_family' => 'Oswald',
                            'typography_font_weight' => '800',
                            'typography_font_size' => ['unit' => 'px', 'size' => 72],
                            'typography_line_height' => ['unit' => 'em', 'size' => 0.95],
                            'typography_letter_spacing' => ['unit' => 'px', 'size' => -2],
                            'margin' => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '60', 'left' => '0', 'isLinked' => false],
                        ],
                    ],
                    [
                        'id' => 'bs-kb-content',
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => [
                            'editor' => '
<div style="display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:start;">
<div>
<h2 style="font-family:Oswald,sans-serif;font-weight:700;font-size:28px;color:#F3EFE4;margin-bottom:32px;line-height:1.1;">Syarat & Ketentuan Kerjasama</h2>
<div style="margin-bottom:24px;padding-bottom:24px;border-bottom:1px solid #1E2A2A;">
    <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#C2401C;text-transform:uppercase;letter-spacing:0.15em;margin-bottom:8px;">Minimum Order</div>
    <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:15px;color:#F3EFE4;margin-bottom:4px;">20 kg per pengiriman (mix produk)</div>
    <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:13px;color:#7A8481;">Fleksibel untuk mitra rutin dengan track record minimum 4 minggu</div>
</div>
<div style="margin-bottom:24px;padding-bottom:24px;border-bottom:1px solid #1E2A2A;">
    <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#7A8481;text-transform:uppercase;letter-spacing:0.15em;margin-bottom:8px;">Area Pengiriman</div>
    <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:15px;color:#F3EFE4;margin-bottom:4px;">Jabodetabek & radius 50 km</div>
    <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:13px;color:#7A8481;">Pengiriman ke luar area: negosiasi armada & biaya kirim</div>
</div>
<div style="margin-bottom:24px;padding-bottom:24px;border-bottom:1px solid #1E2A2A;">
    <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#7A8481;text-transform:uppercase;letter-spacing:0.15em;margin-bottom:8px;">Jadwal Kirim</div>
    <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:15px;color:#F3EFE4;margin-bottom:4px;">Senin – Sabtu, estimasi tiba sebelum 11:00 WIB</div>
    <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:13px;color:#7A8481;">Order cut-off: sehari sebelumnya pukul 18:00 WIB via WhatsApp</div>
</div>
<div style="margin-bottom:40px;padding-bottom:24px;border-bottom:1px solid #1E2A2A;">
    <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#7A8481;text-transform:uppercase;letter-spacing:0.15em;margin-bottom:8px;">Opsi Pembayaran</div>
    <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:15px;color:#F3EFE4;margin-bottom:4px;">COD atau Tempo 14 hari (mitra terverifikasi)</div>
    <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:13px;color:#7A8481;">Transfer bank, BCA/Mandiri. Invoice dikirim via WA/email.</div>
</div>
<a href="'.$WA_LINK.'?text=Halo%20Bahari%20Segar%2C%20saya%20tertarik%20menjadi%20mitra%20suplai%20seafood" target="_blank" rel="noopener" style="display:inline-block;background:#C2401C;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:14px;letter-spacing:0.1em;text-transform:uppercase;padding:16px 36px;text-decoration:none;margin-bottom:16px;">
    Mulai via WhatsApp →
</a>
</div>
<div style="background:#0D1316;padding:48px 40px;border-top:3px solid #C2401C;">
    <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:28px;padding-bottom:16px;border-bottom:1px dashed #2E4A4A;">FORM KERJASAMA B2B</div>
    <p style="font-family:\'IBM Plex Sans\',sans-serif;font-size:14px;color:#7A8481;margin-bottom:24px;line-height:1.6;">Isi form berikut dan tim kami akan menghubungi Anda dalam 1×24 jam kerja untuk membahas kebutuhan suplai dan penawaran harga grosir.</p>
    [wpforms id="FORM_ID_PLACEHOLDER"]
</div>
</div>
',
                        ],
                    ],
                ],
            ],
        ],
    ],
];

// ─── KONTAK ELEMENTOR DATA ────────────────────────────────────────────────────
$kontak_data = [
    [
        'id' => 'bs-kontak-hero',
        'elType' => 'section',
        'settings' => [
            'background_background' => 'classic',
            'background_color' => '#12181B',
            'padding' => ['unit' => 'px', 'top' => '120', 'right' => '80', 'bottom' => '100', 'left' => '80', 'isLinked' => false],
        ],
        'elements' => [
            [
                'id' => 'bs-kont-col',
                'elType' => 'column',
                'settings' => ['_column_size' => 100],
                'elements' => [
                    [
                        'id' => 'bs-kont-lbl',
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => ['editor' => '<div style="font-family:\'IBM Plex Mono\',monospace;font-size:11px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:16px;">KONTAK</div>'],
                    ],
                    [
                        'id' => 'bs-kont-title',
                        'elType' => 'widget',
                        'widgetType' => 'heading',
                        'settings' => [
                            'title' => 'Hubungi Kami.',
                            'header_size' => 'h1',
                            'title_color' => '#F3EFE4',
                            'typography_typography' => 'custom',
                            'typography_font_family' => 'Oswald',
                            'typography_font_weight' => '800',
                            'typography_font_size' => ['unit' => 'px', 'size' => 80],
                            'typography_line_height' => ['unit' => 'em', 'size' => 0.95],
                            'typography_letter_spacing' => ['unit' => 'px', 'size' => -2],
                            'margin' => ['unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '60', 'left' => '0', 'isLinked' => false],
                        ],
                    ],
                    [
                        'id' => 'bs-kont-content',
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => [
                            'editor' => '
<div style="display:grid;grid-template-columns:1fr 1fr;gap:80px;">
<div>
    <div style="margin-bottom:48px;">
        <a href="'.$WA_LINK.'" target="_blank" rel="noopener" style="display:flex;align-items:center;gap:20px;background:#C2401C;color:#F3EFE4;text-decoration:none;padding:32px 36px;transition:all 0.2s ease;">
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="#F3EFE4"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
            <div>
                <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;letter-spacing:0.15em;text-transform:uppercase;opacity:0.7;margin-bottom:4px;">WhatsApp Langsung</div>
                <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:24px;line-height:1;">Chat Sekarang →</div>
            </div>
        </a>
    </div>

    <div style="background:#0D1316;padding:40px;border-left:3px solid #2E4A4A;">
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:28px;">INFO OPERASIONAL</div>
        
        <div style="margin-bottom:20px;padding-bottom:20px;border-bottom:1px solid #1E2A2A;">
            <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#7A8481;text-transform:uppercase;letter-spacing:0.12em;margin-bottom:6px;">Jam Operasional</div>
            <div style="font-family:\'IBM Plex Mono\',monospace;font-size:16px;color:#F3EFE4;">03:00 – 12:00 WIB</div>
            <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:12px;color:#7A8481;margin-top:4px;">Senin – Sabtu (termasuk Minggu untuk order khusus)</div>
        </div>
        
        <div style="margin-bottom:20px;padding-bottom:20px;border-bottom:1px solid #1E2A2A;">
            <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#7A8481;text-transform:uppercase;letter-spacing:0.12em;margin-bottom:6px;">Cut-Off Order</div>
            <div style="font-family:\'IBM Plex Mono\',monospace;font-size:16px;color:#F3EFE4;">H-1 Pukul 18:00 WIB</div>
            <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:12px;color:#7A8481;margin-top:4px;">Order setelah pukul 18:00 diproses hari berikutnya</div>
        </div>
        
        <div>
            <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#7A8481;text-transform:uppercase;letter-spacing:0.12em;margin-bottom:6px;">Lokasi Gudang/Kantor</div>
            <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:14px;color:#F3EFE4;line-height:1.5;">Area Muara Baru, Jakarta Utara<br><span style="color:#7A8481;font-size:12px;">(Kunjungan hanya dengan janji — hubungi via WA terlebih dahulu)</span></div>
        </div>
    </div>
</div>
<div>
    <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#7A8481;letter-spacing:0.15em;text-transform:uppercase;margin-bottom:16px;">SLA PENGIRIMAN</div>
    <div style="background:#0D1316;padding:40px;border-top:3px solid #C2401C;">
        <div style="font-family:\'IBM Plex Mono\',monospace;font-size:10px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:28px;padding-bottom:16px;border-bottom:1px dashed #2E4A4A;">TIMELINE PENGIRIMAN STANDAR</div>
        <div style="position:relative;">
            <div style="position:absolute;left:0;top:6px;bottom:0;width:1px;background:#1E2A2A;"></div>
            <div style="padding-left:24px;margin-bottom:24px;position:relative;">
                <div style="position:absolute;left:-4px;top:6px;width:8px;height:8px;background:#C2401C;border-radius:50%;"></div>
                <div style="font-family:\'IBM Plex Mono\',monospace;font-size:13px;color:#C2401C;margin-bottom:4px;">H-1 · 18:00</div>
                <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:13px;color:#F3EFE4;">Cut-off penerimaan order via WhatsApp</div>
            </div>
            <div style="padding-left:24px;margin-bottom:24px;position:relative;">
                <div style="position:absolute;left:-4px;top:6px;width:8px;height:8px;background:#2E4A4A;border-radius:50%;"></div>
                <div style="font-family:\'IBM Plex Mono\',monospace;font-size:13px;color:#7A8481;margin-bottom:4px;">H · 03:00</div>
                <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:13px;color:#F3EFE4;">Tim berangkat ke TPI, seleksi & grading</div>
            </div>
            <div style="padding-left:24px;margin-bottom:24px;position:relative;">
                <div style="position:absolute;left:-4px;top:6px;width:8px;height:8px;background:#2E4A4A;border-radius:50%;"></div>
                <div style="font-family:\'IBM Plex Mono\',monospace;font-size:13px;color:#7A8481;margin-bottom:4px;">H · 04:30</div>
                <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:13px;color:#F3EFE4;">Timbang, kemas, labeling kode batch</div>
            </div>
            <div style="padding-left:24px;margin-bottom:24px;position:relative;">
                <div style="position:absolute;left:-4px;top:6px;width:8px;height:8px;background:#2E4A4A;border-radius:50%;"></div>
                <div style="font-family:\'IBM Plex Mono\',monospace;font-size:13px;color:#7A8481;margin-bottom:4px;">H · 05:30</div>
                <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:13px;color:#F3EFE4;">Armada berpendingin berangkat</div>
            </div>
            <div style="padding-left:24px;position:relative;">
                <div style="position:absolute;left:-4px;top:6px;width:8px;height:8px;background:#C2401C;border-radius:50%;"></div>
                <div style="font-family:\'IBM Plex Mono\',monospace;font-size:13px;color:#C2401C;margin-bottom:4px;">H · &lt; 11:00</div>
                <div style="font-family:\'IBM Plex Sans\',sans-serif;font-size:13px;color:#F3EFE4;">Produk diterima di dapur Anda ✓</div>
            </div>
        </div>
    </div>
</div>
</div>
',
                        ],
                    ],
                ],
            ],
        ],
    ],
];

// ─── INJECT DATA TO DB ────────────────────────────────────────────────────────
$pages = [
    ['id' => $ids['beranda'],   'data' => $beranda_data,   'name' => 'Beranda'],
    ['id' => $ids['tentang'],   'data' => $tentang_data,   'name' => 'Tentang Kami'],
    ['id' => $ids['kerjasama'], 'data' => $kerjasama_data, 'name' => 'Kerjasama B2B'],
    ['id' => $ids['kontak'],    'data' => $kontak_data,    'name' => 'Kontak'],
];

foreach ($pages as $page) {
    $json = json_encode($page['data'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    set_post_meta($pdo, $page['id'], '_elementor_data', $json);
    // Also update page content with fallback HTML
    $pdo->prepare("UPDATE wp_posts SET post_content = '' WHERE ID = ?")->execute([$page['id']]);
    echo "  ✓ Injected Elementor data: {$page['name']}\n";
}

echo "\n✅ Step 03 Complete: Elementor data injected for all pages.\n\n";
