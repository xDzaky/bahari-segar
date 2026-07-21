<?php
/**
 * Script 02: Create all pages with Elementor content (HTML-based)
 * Run: php 02-create-pages.php
 * 
 * Pages: Beranda, Tentang Kami, Produk, Kerjasama B2B, Kontak
 */

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'gggaming21');
define('DB_NAME', 'db_wordpress');
$WA_NUMBER = '6281234567890'; // Ganti dengan nomor WA Bahari Segar

$pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4", DB_USER, DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ─── Helpers ──────────────────────────────────────────────────────────────────

function get_author_id($pdo) {
    $stmt = $pdo->query("SELECT ID FROM wp_users ORDER BY ID LIMIT 1");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? $row['ID'] : 1;
}

function upsert_page($pdo, $slug, $title, $content, $author_id) {
    // Check existing
    $check = $pdo->prepare("SELECT ID FROM wp_posts WHERE post_name = ? AND post_type = 'page' AND post_status != 'trash'");
    $check->execute([$slug]);
    $existing = $check->fetch(PDO::FETCH_ASSOC);

    $now = date('Y-m-d H:i:s');

    if ($existing) {
        $stmt = $pdo->prepare("UPDATE wp_posts SET post_title=?, post_content=?, post_modified=?, post_modified_gmt=? WHERE ID=?");
        $stmt->execute([$title, $content, $now, $now, $existing['ID']]);
        $id = $existing['ID'];
        echo "  ↺ Updated page: '$title' (ID: $id)\n";
    } else {
        $stmt = $pdo->prepare("INSERT INTO wp_posts 
            (post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt, post_status, post_name, post_type, post_modified, post_modified_gmt, comment_status, ping_status, to_ping, pinged, post_content_filtered)
            VALUES (?, ?, ?, ?, ?, '', 'publish', ?, 'page', ?, ?, 'closed', 'closed', '', '', '')");
        $stmt->execute([$author_id, $now, $now, $content, $title, $slug, $now, $now]);
        $id = $pdo->lastInsertId();
        echo "  ✓ Created page: '$title' (ID: $id)\n";
    }
    return $id;
}

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

function set_option($pdo, $name, $value) {
    $check = $pdo->prepare("SELECT option_id FROM wp_options WHERE option_name = ?");
    $check->execute([$name]);
    if ($check->fetch()) {
        $stmt = $pdo->prepare("UPDATE wp_options SET option_value = ? WHERE option_name = ?");
        $stmt->execute([$value, $name]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO wp_options (option_name, option_value, autoload) VALUES (?, ?, 'yes')");
        $stmt->execute([$name, $value]);
    }
}

function make_elementor_id() {
    return substr(md5(uniqid()), 0, 7);
}

$author_id = get_author_id($pdo);
echo "\n=== Bahari Segar Build: Step 02 - Create Pages ===\n\n";

// ─── PAGE 1: BERANDA ──────────────────────────────────────────────────────────
// We use raw HTML content — Elementor will display it if not built with Elementor
// But we'll mark it as Elementor page and inject proper elementor data via postmeta

$beranda_html = '';  // Content set via Elementor meta below

$beranda_id = upsert_page($pdo, 'beranda', 'Beranda', $beranda_html, $author_id);

// Elementor meta - mark as elementor page
set_post_meta($pdo, $beranda_id, '_elementor_edit_mode', 'builder');
set_post_meta($pdo, $beranda_id, '_elementor_template_type', 'wp-page');
set_post_meta($pdo, $beranda_id, '_elementor_version', '3.24.0');
set_post_meta($pdo, $beranda_id, '_wp_page_template', 'elementor_canvas');

// Yoast SEO
set_post_meta($pdo, $beranda_id, '_yoast_wpseo_title', 'Bahari Segar — Suplier Ikan & Seafood Segar untuk Hotel & Restoran');
set_post_meta($pdo, $beranda_id, '_yoast_wpseo_metadesc', 'Bahari Segar memasok ikan, udang, cumi, kerang, dan olahan hasil laut langsung dari pelelangan ke dapur hotel dan restoran. Ditimbang jam 4 pagi, sampai sebelum jam makan siang.');

echo "  → Beranda ID: $beranda_id\n";

// ─── PAGE 2: TENTANG KAMI ─────────────────────────────────────────────────────
$tentang_id = upsert_page($pdo, 'tentang-kami', 'Tentang Kami', '', $author_id);
set_post_meta($pdo, $tentang_id, '_elementor_edit_mode', 'builder');
set_post_meta($pdo, $tentang_id, '_elementor_template_type', 'wp-page');
set_post_meta($pdo, $tentang_id, '_elementor_version', '3.24.0');
set_post_meta($pdo, $tentang_id, '_wp_page_template', 'elementor_canvas');
set_post_meta($pdo, $tentang_id, '_yoast_wpseo_title', 'Tentang Kami — Bahari Segar, Suplier Seafood Langsung dari Pelelangan');
set_post_meta($pdo, $tentang_id, '_yoast_wpseo_metadesc', 'Kenali proses Bahari Segar: dari pengambilan di TPI dini hari, cold-chain ketat, hingga pengiriman ke dapur hotel dan restoran Anda sebelum jam makan siang.');
echo "  → Tentang Kami ID: $tentang_id\n";

// ─── PAGE 3: PRODUK ───────────────────────────────────────────────────────────
$produk_id = upsert_page($pdo, 'produk', 'Produk', '', $author_id);
set_post_meta($pdo, $produk_id, '_elementor_edit_mode', 'builder');
set_post_meta($pdo, $produk_id, '_elementor_template_type', 'wp-page');
set_post_meta($pdo, $produk_id, '_elementor_version', '3.24.0');
set_post_meta($pdo, $produk_id, '_wp_page_template', 'elementor_canvas');
set_post_meta($pdo, $produk_id, '_yoast_wpseo_title', 'Katalog Produk — Ikan Segar, Udang, Cumi & Seafood Bahari Segar');
set_post_meta($pdo, $produk_id, '_yoast_wpseo_metadesc', 'Katalog lengkap produk Bahari Segar: Ikan Segar, Udang & Seafood Beku, Cumi/Kerang/Kepiting, dan Olahan Hasil Laut. Harga grosir, pesan via WhatsApp.');
echo "  → Produk ID: $produk_id\n";

// ─── PAGE 4: KERJASAMA B2B ────────────────────────────────────────────────────
$kerjasama_id = upsert_page($pdo, 'kerjasama-b2b', 'Kerjasama B2B', '', $author_id);
set_post_meta($pdo, $kerjasama_id, '_elementor_edit_mode', 'builder');
set_post_meta($pdo, $kerjasama_id, '_elementor_template_type', 'wp-page');
set_post_meta($pdo, $kerjasama_id, '_elementor_version', '3.24.0');
set_post_meta($pdo, $kerjasama_id, '_wp_page_template', 'elementor_canvas');
set_post_meta($pdo, $kerjasama_id, '_yoast_wpseo_title', 'Kerjasama B2B — Jadi Mitra Suplai Seafood Bahari Segar');
set_post_meta($pdo, $kerjasama_id, '_yoast_wpseo_metadesc', 'Daftarkan usaha Anda sebagai mitra rutin Bahari Segar. Minimum order, area kirim, opsi pembayaran tempo, dan form kerjasama untuk hotel, restoran, dan katering.');
echo "  → Kerjasama B2B ID: $kerjasama_id\n";

// ─── PAGE 5: KONTAK ───────────────────────────────────────────────────────────
$kontak_id = upsert_page($pdo, 'kontak', 'Kontak', '', $author_id);
set_post_meta($pdo, $kontak_id, '_elementor_edit_mode', 'builder');
set_post_meta($pdo, $kontak_id, '_elementor_template_type', 'wp-page');
set_post_meta($pdo, $kontak_id, '_elementor_version', '3.24.0');
set_post_meta($pdo, $kontak_id, '_wp_page_template', 'elementor_canvas');
set_post_meta($pdo, $kontak_id, '_yoast_wpseo_title', 'Kontak — Hubungi Bahari Segar via WhatsApp');
set_post_meta($pdo, $kontak_id, '_yoast_wpseo_metadesc', 'Hubungi Bahari Segar untuk informasi produk, penawaran harga grosir, dan kerjasama suplai seafood. Respons cepat via WhatsApp, operasional mulai pukul 03.00 WIB.');
echo "  → Kontak ID: $kontak_id\n";

// ─── Set front page & posts page ─────────────────────────────────────────────
set_option($pdo, 'show_on_front', 'page');
set_option($pdo, 'page_on_front', $beranda_id);
echo "\n  ✓ Front page set to Beranda (ID: $beranda_id)\n";

// ─── Create nav menu ──────────────────────────────────────────────────────────
// Check if menu exists
$menu_check = $pdo->query("SELECT term_id FROM wp_terms WHERE name = 'Menu Utama' LIMIT 1")->fetch(PDO::FETCH_ASSOC);

if (!$menu_check) {
    // Create term
    $pdo->prepare("INSERT INTO wp_terms (name, slug) VALUES ('Menu Utama', 'menu-utama')")->execute();
    $menu_term_id = $pdo->lastInsertId();
    // Create term taxonomy
    $pdo->prepare("INSERT INTO wp_term_taxonomy (term_id, taxonomy, description, parent, count) VALUES (?, 'nav_menu', '', 0, 5)")->execute([$menu_term_id]);
    $menu_taxonomy_id = $pdo->lastInsertId();
    echo "  ✓ Created nav menu 'Menu Utama' (term_id: $menu_term_id)\n";
} else {
    $menu_term_id = $menu_check['term_id'];
    $tt_check = $pdo->prepare("SELECT term_taxonomy_id FROM wp_term_taxonomy WHERE term_id = ? AND taxonomy = 'nav_menu'")->execute([$menu_term_id]);
    $tt_row = $pdo->query("SELECT term_taxonomy_id FROM wp_term_taxonomy WHERE term_id = $menu_term_id AND taxonomy = 'nav_menu'")->fetch(PDO::FETCH_ASSOC);
    $menu_taxonomy_id = $tt_row['term_taxonomy_id'];
    echo "  ↺ Menu already exists (term_id: $menu_term_id)\n";
}

// Menu items
$menu_pages = [
    ['Beranda', $beranda_id, 1],
    ['Tentang Kami', $tentang_id, 2],
    ['Produk', $produk_id, 3],
    ['Kerjasama B2B', $kerjasama_id, 4],
    ['Kontak', $kontak_id, 5],
];

// Delete old menu items for this menu
$pdo->prepare("DELETE FROM wp_posts WHERE post_type = 'nav_menu_item' AND ID IN (
    SELECT object_id FROM wp_term_relationships WHERE term_taxonomy_id = ?
)")->execute([$menu_taxonomy_id]);
$pdo->prepare("DELETE FROM wp_term_relationships WHERE term_taxonomy_id = ?")->execute([$menu_taxonomy_id]);

$now = date('Y-m-d H:i:s');
foreach ($menu_pages as [$label, $page_id, $order]) {
    $pdo->prepare("INSERT INTO wp_posts (post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt, post_status, post_name, post_type, post_modified, post_modified_gmt, comment_status, ping_status, to_ping, pinged, post_content_filtered, menu_order)
        VALUES (?, ?, ?, '', ?, '', 'publish', ?, 'nav_menu_item', ?, ?, 'closed', 'closed', '', '', '', ?)")
        ->execute([1, $now, $now, $label, 'menu-item-'.strtolower(str_replace(' ', '-', $label)), $now, $now, $order]);
    $item_id = $pdo->lastInsertId();

    // meta
    set_post_meta($pdo, $item_id, '_menu_item_type', 'post_type');
    set_post_meta($pdo, $item_id, '_menu_item_menu_item_parent', '0');
    set_post_meta($pdo, $item_id, '_menu_item_object_id', $page_id);
    set_post_meta($pdo, $item_id, '_menu_item_object', 'page');
    set_post_meta($pdo, $item_id, '_menu_item_target', '');
    set_post_meta($pdo, $item_id, '_menu_item_classes', 'a:1:{i:0;s:0:"";}');
    set_post_meta($pdo, $item_id, '_menu_item_xfn', '');
    set_post_meta($pdo, $item_id, '_menu_item_url', '');

    // term relationship
    $pdo->prepare("INSERT INTO wp_term_relationships (object_id, term_taxonomy_id) VALUES (?, ?)")
        ->execute([$item_id, $menu_taxonomy_id]);

    echo "  ✓ Menu item: $label\n";
}

// Register menu location
set_option($pdo, 'nav_menu_locations', serialize(['primary' => (int)$menu_term_id]));
echo "\n  ✓ Nav menu registered to 'primary' location.\n";

// ─── Store page IDs for use by next scripts ───────────────────────────────────
$page_ids = [
    'beranda'     => $beranda_id,
    'tentang'     => $tentang_id,
    'produk'      => $produk_id,
    'kerjasama'   => $kerjasama_id,
    'kontak'      => $kontak_id,
    'wa_number'   => $WA_NUMBER,
];
file_put_contents(__DIR__ . '/page_ids.json', json_encode($page_ids, JSON_PRETTY_PRINT));
echo "\n  ✓ Page IDs saved to page_ids.json\n";

echo "\n✅ Step 02 Complete: All pages created.\n\n";
