<?php
/**
 * Script 04: Create WooCommerce Products (Catalog Mode)
 * Run: php 04-create-products.php
 */

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'gggaming21');
define('DB_NAME', 'db_wordpress');
$WA_NUMBER = '6281234567890';

$pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4", DB_USER, DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "\n=== Bahari Segar Build: Step 04 - WooCommerce Products ===\n\n";

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

function create_product_category($pdo, $name, $slug, $description = '') {
    // Check existing
    $check = $pdo->prepare("SELECT t.term_id FROM wp_terms t JOIN wp_term_taxonomy tt ON t.term_id = tt.term_id WHERE t.slug = ? AND tt.taxonomy = 'product_cat'");
    $check->execute([$slug]);
    $existing = $check->fetch(PDO::FETCH_ASSOC);
    if ($existing) {
        echo "  ↺ Category exists: $name\n";
        return $existing['term_id'];
    }

    $pdo->prepare("INSERT INTO wp_terms (name, slug, term_group) VALUES (?, ?, 0)")->execute([$name, $slug]);
    $term_id = $pdo->lastInsertId();
    $pdo->prepare("INSERT INTO wp_term_taxonomy (term_id, taxonomy, description, parent, count) VALUES (?, 'product_cat', ?, 0, 0)")->execute([$term_id, $description]);
    echo "  ✓ Created category: $name (ID: $term_id)\n";
    return $term_id;
}

function create_product($pdo, $name, $slug, $description, $short_description, $category_id, $featured = false, $wa_number = '6281234567890') {
    $check = $pdo->prepare("SELECT ID FROM wp_posts WHERE post_name = ? AND post_type = 'product' AND post_status != 'trash'");
    $check->execute([$slug]);
    $existing = $check->fetch(PDO::FETCH_ASSOC);

    $now = date('Y-m-d H:i:s');
    $content = $description;
    $excerpt = $short_description;

    if ($existing) {
        $stmt = $pdo->prepare("UPDATE wp_posts SET post_title=?, post_content=?, post_excerpt=?, post_modified=?, post_modified_gmt=? WHERE ID=?");
        $stmt->execute([$name, $content, $excerpt, $now, $now, $existing['ID']]);
        $id = $existing['ID'];
        echo "  ↺ Updated product: $name (ID: $id)\n";
    } else {
        $stmt = $pdo->prepare("INSERT INTO wp_posts 
            (post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt, post_status, post_name, post_type, post_modified, post_modified_gmt, comment_status, ping_status, to_ping, pinged, post_content_filtered)
            VALUES (1, ?, ?, ?, ?, ?, 'publish', ?, 'product', ?, ?, 'closed', 'closed', '', '', '')");
        $stmt->execute([$now, $now, $content, $name, $excerpt, $slug, $now, $now]);
        $id = $pdo->lastInsertId();
        echo "  ✓ Created product: $name (ID: $id)\n";
    }

    // WooCommerce product meta
    set_post_meta($pdo, $id, '_price', '0');
    set_post_meta($pdo, $id, '_regular_price', '0');
    set_post_meta($pdo, $id, '_sale_price', '');
    set_post_meta($pdo, $id, '_stock_status', 'instock');
    set_post_meta($pdo, $id, '_manage_stock', 'no');
    set_post_meta($pdo, $id, '_visibility', 'visible');
    set_post_meta($pdo, $id, '_virtual', 'no');
    set_post_meta($pdo, $id, '_downloadable', 'no');
    set_post_meta($pdo, $id, '_product_attributes', serialize([]));
    set_post_meta($pdo, $id, '_button_text', 'Tanya Ketersediaan');
    set_post_meta($pdo, $id, '_add_to_cart_button_text', 'Tanya Ketersediaan');
    set_post_meta($pdo, $id, 'total_sales', '0');
    if ($featured) set_post_meta($pdo, $id, '_featured', 'yes');

    // Assign category
    $tt = $pdo->prepare("SELECT term_taxonomy_id FROM wp_term_taxonomy WHERE term_id = ? AND taxonomy = 'product_cat'");
    $tt->execute([$category_id]);
    $tt_row = $tt->fetch(PDO::FETCH_ASSOC);
    if ($tt_row) {
        $tt_id = $tt_row['term_taxonomy_id'];
        $rel_check = $pdo->prepare("SELECT * FROM wp_term_relationships WHERE object_id = ? AND term_taxonomy_id = ?");
        $rel_check->execute([$id, $tt_id]);
        if (!$rel_check->fetch()) {
            $pdo->prepare("INSERT INTO wp_term_relationships (object_id, term_taxonomy_id) VALUES (?, ?)")->execute([$id, $tt_id]);
            $pdo->prepare("UPDATE wp_term_taxonomy SET count = count + 1 WHERE term_taxonomy_id = ?")->execute([$tt_id]);
        }
    }

    // Also assign 'product' taxonomy type
    $product_tt = $pdo->query("SELECT term_taxonomy_id FROM wp_term_taxonomy WHERE taxonomy = 'product_type' AND (SELECT term_id FROM wp_terms WHERE name='simple' LIMIT 1) = term_id LIMIT 1")->fetch(PDO::FETCH_ASSOC);
    // Simple assignment of product type
    $simple_term = $pdo->query("SELECT t.term_id, tt.term_taxonomy_id FROM wp_terms t JOIN wp_term_taxonomy tt ON t.term_id = tt.term_id WHERE t.name = 'simple' AND tt.taxonomy = 'product_type' LIMIT 1")->fetch(PDO::FETCH_ASSOC);
    if ($simple_term) {
        $rel_chk = $pdo->prepare("SELECT * FROM wp_term_relationships WHERE object_id = ? AND term_taxonomy_id = ?");
        $rel_chk->execute([$id, $simple_term['term_taxonomy_id']]);
        if (!$rel_chk->fetch()) {
            $pdo->prepare("INSERT INTO wp_term_relationships (object_id, term_taxonomy_id) VALUES (?, ?)")->execute([$id, $simple_term['term_taxonomy_id']]);
        }
    }

    return $id;
}

// ─── CREATE PRODUCT CATEGORIES ────────────────────────────────────────────────
echo "[1/3] Creating product categories...\n";
$cat_ikan    = create_product_category($pdo, 'Ikan Segar', 'ikan-segar', 'Ikan segar langsung dari TPI, tersedia setiap hari');
$cat_udang   = create_product_category($pdo, 'Udang & Seafood Beku', 'udang-seafood-beku', 'Udang dan seafood beku berkualitas IQF');
$cat_cumi    = create_product_category($pdo, 'Cumi, Kerang & Kepiting', 'cumi-kerang-kepiting', 'Cumi segar, kerang, dan kepiting bakau');
$cat_olahan  = create_product_category($pdo, 'Olahan Hasil Laut', 'olahan-hasil-laut', 'Produk olahan seafood kemasan vakum');

// ─── CREATE PRODUCTS ──────────────────────────────────────────────────────────
echo "\n[2/3] Creating products...\n";

// Ikan Segar
create_product($pdo, 'Kakap Merah Segar', 'kakap-merah-segar',
    '<p style="font-family:\'IBM Plex Sans\',sans-serif;"><strong>Kakap merah segar</strong> langsung dari TPI. Grading A: sisik utuh, mata jernih, insang merah cerah. Tersedia ukuran 300g–2kg/ekor.</p>
    <ul><li>Ukuran: 300g – 2kg/ekor</li><li>Kemasan: Es curah atau box styrofoam</li><li>Ketersediaan: Sepanjang tahun</li><li>Kode batch tersedia per pengiriman</li></ul>
    <p><strong>Harga:</strong> <a href="https://wa.me/6281234567890">Hubungi untuk rate grosir</a></p>',
    'Kakap merah grade A, 300g–2kg/ekor, es curah. Langsung dari TPI, ditimbang jam 4 pagi.',
    $cat_ikan, true);

create_product($pdo, 'Kerapu Segar', 'kerapu-segar',
    '<p>Kerapu segar kualitas ekspor. Ukuran 400g–3kg/ekor. Tersedia: kerapu macan, kerapu tikus, kerapu bebek (tergantung musim).</p>
    <ul><li>Ukuran: 400g – 3kg/ekor</li><li>Kemasan: Es curah</li><li>Ketersediaan: Musiman (konfirmasi stok)</li></ul>
    <p><strong>Harga:</strong> Hubungi untuk rate grosir</p>',
    'Kerapu segar grade A, 400g–3kg/ekor. Tersedia kerapu macan, tikus, bebek.',
    $cat_ikan, true);

create_product($pdo, 'Tenggiri Segar', 'tenggiri-segar',
    '<p>Tenggiri segar pilihan, ideal untuk menu ikan bakar, pepes, dan olahan dapur hotel. Ukuran 500g–4kg/ekor.</p>
    <ul><li>Ukuran: 500g – 4kg/ekor</li><li>Kemasan: Es curah</li><li>Ketersediaan: Sepanjang tahun</li></ul>
    <p><strong>Harga:</strong> Hubungi untuk rate grosir</p>',
    'Tenggiri segar 500g–4kg/ekor, cocok untuk ikan bakar dan pepes.',
    $cat_ikan);

create_product($pdo, 'Tuna Segar (Loin & Utuh)', 'tuna-segar',
    '<p>Tuna segar tersedia dalam bentuk utuh dan loin siap olah. Digrading sesuai standar ekspor Jepang.</p>
    <ul><li>Ukuran: 2kg – 30kg/ekor (utuh); 500g – 3kg (loin)</li><li>Kemasan: Box styrofoam + es curah</li><li>Ketersediaan: Sepanjang tahun</li></ul>
    <p><strong>Harga:</strong> Hubungi untuk rate grosir</p>',
    'Tuna segar loin & utuh, grading ekspor. Tersedia sepanjang tahun.',
    $cat_ikan);

create_product($pdo, 'Bawal Segar', 'bawal-segar',
    '<p>Bawal putih dan bawal hitam segar. Ukuran 200g–1kg/ekor. Populer untuk menu Chinese restaurant dan hotel bintang.</p>
    <ul><li>Ukuran: 200g – 1kg/ekor</li><li>Kemasan: Es curah</li><li>Ketersediaan: Sepanjang tahun</li></ul>
    <p><strong>Harga:</strong> Hubungi untuk rate grosir</p>',
    'Bawal putih & hitam segar, 200g–1kg/ekor.',
    $cat_ikan);

// Udang & Seafood Beku
create_product($pdo, 'Udang Vaname IQF', 'udang-vaname-iqf',
    '<p>Udang vaname IQF (Individually Quick Frozen). Size 16/20, 21/25, 31/40, 41/50, 51/60. Tersedia head-on, headless, dan peeled & deveined.</p>
    <ul><li>Size: 16/20 hingga 61/70</li><li>Kemasan: Box 1kg & 5kg vacuum</li><li>Ketersediaan: Sepanjang tahun</li></ul>
    <p><strong>Harga:</strong> Hubungi untuk rate grosir</p>',
    'Udang vaname IQF, size 16/20–61/70, head-on/headless/P&D.',
    $cat_udang, true);

create_product($pdo, 'Udang Tiger (Windu)', 'udang-tiger',
    '<p>Udang tiger/windu premium. Ukuran jumbo hingga extra jumbo. Tersedia head-on segar dan beku IQF.</p>
    <ul><li>Size: U5, U8, U10, U12</li><li>Kemasan: Box 1kg vacuum</li><li>Ketersediaan: Musiman</li></ul>
    <p><strong>Harga:</strong> Hubungi untuk rate grosir</p>',
    'Udang tiger/windu premium, size U5–U12.',
    $cat_udang);

create_product($pdo, 'Udang Galah Segar', 'udang-galah',
    '<p>Udang galah air tawar segar langsung dari tambak lokal. Ukuran 100–400g/ekor.</p>
    <ul><li>Ukuran: 100g – 400g/ekor</li><li>Kemasan: Es curah atau box styrofoam</li><li>Ketersediaan: Musiman</li></ul>
    <p><strong>Harga:</strong> Hubungi untuk rate grosir</p>',
    'Udang galah air tawar segar, 100–400g/ekor.',
    $cat_udang);

// Cumi, Kerang, Kepiting
create_product($pdo, 'Cumi-Cumi Segar', 'cumi-cumi-segar',
    '<p>Cumi-cumi segar ukuran medium hingga jumbo. Tersedia whole dan cleaned (sudah dibersihkan). Ideal untuk restoran dan hotel.</p>
    <ul><li>Ukuran: 100g – 500g/ekor</li><li>Kemasan: Es curah</li><li>Ketersediaan: Musiman (puncak: April–September)</li></ul>
    <p><strong>Harga:</strong> Hubungi untuk rate grosir</p>',
    'Cumi-cumi segar 100–500g/ekor, whole dan cleaned.',
    $cat_cumi, true);

create_product($pdo, 'Kepiting Bakau Segar', 'kepiting-bakau',
    '<p>Kepiting bakau segar dari tambak dan tangkapan liar. Ukuran 300g–800g/ekor. Tersedia jantan (berisi) dan betina (bertelur).</p>
    <ul><li>Ukuran: 300g – 800g/ekor</li><li>Kemasan: Diikat, box styrofoam + es</li><li>Ketersediaan: Musiman</li></ul>
    <p><strong>Harga:</strong> Hubungi untuk rate grosir</p>',
    'Kepiting bakau segar 300–800g/ekor, jantan dan betina.',
    $cat_cumi);

create_product($pdo, 'Kerang Hijau Segar', 'kerang-hijau',
    '<p>Kerang hijau segar (green mussel) dari perairan lokal. Tersedia in-shell dan setengah cangkang (half-shell).</p>
    <ul><li>Kemasan: Karung 5kg atau box 1kg (half-shell)</li><li>Ketersediaan: Sepanjang tahun</li></ul>
    <p><strong>Harga:</strong> Hubungi untuk rate grosir</p>',
    'Kerang hijau segar, in-shell dan half-shell.',
    $cat_cumi);

create_product($pdo, 'Rajungan Segar', 'rajungan-segar',
    '<p>Rajungan segar dari perairan Jawa. Ukuran medium hingga jumbo. Ideal untuk olahan kepiting saus padang dan menu seafood premium.</p>
    <ul><li>Ukuran: 100g – 300g/ekor</li><li>Kemasan: Es curah</li><li>Ketersediaan: Musiman</li></ul>
    <p><strong>Harga:</strong> Hubungi untuk rate grosir</p>',
    'Rajungan segar 100–300g/ekor, perairan Jawa.',
    $cat_cumi);

// Olahan Hasil Laut
create_product($pdo, 'Ikan Asin Kering (Mix)', 'ikan-asin-kering',
    '<p>Ikan asin kering berkualitas: teri nasi, ikan asin gabus, ikan asin jambal roti, dan ikan asin layur. Dikemas vakum untuk daya tahan maksimal.</p>
    <ul><li>Kemasan: Vakum 500g & 1kg</li><li>Ketersediaan: Sepanjang tahun</li><li>Shelf life: 3–6 bulan</li></ul>
    <p><strong>Harga:</strong> Hubungi untuk rate grosir</p>',
    'Ikan asin kering vakum: teri nasi, gabus, jambal roti, layur.',
    $cat_olahan);

create_product($pdo, 'Ebi & Terasi Premium', 'ebi-terasi-premium',
    '<p>Ebi (udang kering) grade A dan terasi udang premium dari produsen lokal berpengalaman. Cocok untuk bumbu dasar masakan Indonesia.</p>
    <ul><li>Kemasan: Vakum 250g & 500g (ebi); 200g & 500g (terasi)</li><li>Ketersediaan: Sepanjang tahun</li></ul>
    <p><strong>Harga:</strong> Hubungi untuk rate grosir</p>',
    'Ebi grade A dan terasi udang premium, kemasan vakum.',
    $cat_olahan);

create_product($pdo, 'Pempek & Otak-Otak Segar', 'pempek-otak-otak',
    '<p>Pempek Palembang dan otak-otak ikan tenggiri buatan sendiri. Tanpa pengawet, dibuat dari ikan segar. Cocok sebagai menu snack atau appetizer hotel.</p>
    <ul><li>Kemasan: Vakum 500g (12–15 pcs)</li><li>Ketersediaan: Produksi harian, order minimal H-2</li></ul>
    <p><strong>Harga:</strong> Hubungi untuk rate grosir</p>',
    'Pempek & otak-otak segar tanpa pengawet dari ikan tenggiri.',
    $cat_olahan);

echo "\n[3/3] Updating category product counts...\n";
// Update product counts per category
$cats = [$cat_ikan, $cat_udang, $cat_cumi, $cat_olahan];
foreach ($cats as $cat_id) {
    $count = $pdo->query("SELECT COUNT(*) FROM wp_term_relationships tr 
        JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id 
        WHERE tt.term_id = $cat_id AND tt.taxonomy = 'product_cat'")->fetchColumn();
    $pdo->prepare("UPDATE wp_term_taxonomy SET count = ? WHERE term_id = ? AND taxonomy = 'product_cat'")->execute([$count, $cat_id]);
    echo "  ✓ Category $cat_id: $count products\n";
}

// Set WooCommerce shop page
$shop_page = $pdo->query("SELECT ID FROM wp_posts WHERE post_name = 'produk' AND post_type = 'page' LIMIT 1")->fetch(PDO::FETCH_ASSOC);
if ($shop_page) {
    $check = $pdo->prepare("SELECT option_id FROM wp_options WHERE option_name = 'woocommerce_shop_page_id'");
    $check->execute();
    if ($check->fetch()) {
        $pdo->prepare("UPDATE wp_options SET option_value = ? WHERE option_name = 'woocommerce_shop_page_id'")->execute([$shop_page['ID']]);
    } else {
        $pdo->prepare("INSERT INTO wp_options (option_name, option_value, autoload) VALUES ('woocommerce_shop_page_id', ?, 'yes')")->execute([$shop_page['ID']]);
    }
    echo "  ✓ WooCommerce shop page set to ID: {$shop_page['ID']}\n";
}

echo "\n✅ Step 04 Complete: WooCommerce products created.\n\n";
