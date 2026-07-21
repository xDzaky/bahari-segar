<?php
/**
 * Script 06: Create WPForms B2B Form & Miscellaneous Settings
 * - Create WPForms Kerjasama B2B form
 * - Enable LiteSpeed Cache
 * - Set Yoast global SEO settings
 * - Activate plugins
 * Run: php 06-finalize.php
 */

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'gggaming21');
define('DB_NAME', 'db_wordpress');

$pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4", DB_USER, DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "\n=== Bahari Segar Build: Step 06 - Finalize ===\n\n";

function set_option($pdo, $name, $value, $autoload = 'yes') {
    $check = $pdo->prepare("SELECT option_id FROM wp_options WHERE option_name = ?");
    $check->execute([$name]);
    if ($check->fetch()) {
        $pdo->prepare("UPDATE wp_options SET option_value = ?, autoload = ? WHERE option_name = ?")->execute([$value, $autoload, $name]);
    } else {
        $pdo->prepare("INSERT INTO wp_options (option_name, option_value, autoload) VALUES (?, ?, ?)")->execute([$name, $value, $autoload]);
    }
    echo "  ✓ $name\n";
}

// ─── 1. WPForms - Create B2B Cooperation Form ─────────────────────────────────
echo "[1/5] Creating WPForms B2B form...\n";

$form_data = [
    'id' => 1,
    'fields' => [
        1 => [
            'id' => '1',
            'type' => 'text',
            'label' => 'Nama Usaha',
            'required' => '1',
            'size' => 'large',
            'placeholder' => 'Contoh: Hotel Grand Mentari',
            'description' => '',
        ],
        2 => [
            'id' => '2',
            'type' => 'select',
            'label' => 'Jenis Usaha',
            'required' => '1',
            'size' => 'large',
            'choices' => [
                ['label' => 'Hotel', 'value' => 'Hotel', 'selected' => false],
                ['label' => 'Restoran', 'value' => 'Restoran', 'selected' => false],
                ['label' => 'Katering', 'value' => 'Katering', 'selected' => false],
                ['label' => 'Lainnya', 'value' => 'Lainnya', 'selected' => false],
            ],
        ],
        3 => [
            'id' => '3',
            'type' => 'text',
            'label' => 'Estimasi Kebutuhan per Minggu',
            'required' => '1',
            'size' => 'large',
            'placeholder' => 'Contoh: 50 kg ikan segar, 20 kg udang',
            'description' => 'Perkiraan total kebutuhan seafood per minggu',
        ],
        4 => [
            'id' => '4',
            'type' => 'phone',
            'label' => 'Nomor WhatsApp',
            'required' => '1',
            'size' => 'large',
            'placeholder' => '08xx-xxxx-xxxx',
            'description' => 'Tim kami akan menghubungi via WhatsApp',
            'format' => 'smart',
        ],
        5 => [
            'id' => '5',
            'type' => 'textarea',
            'label' => 'Catatan Tambahan',
            'required' => '0',
            'size' => 'large',
            'placeholder' => 'Informasi tambahan: lokasi pengiriman, jadwal yang diinginkan, produk spesifik, dll.',
            'rows' => 4,
        ],
    ],
    'settings' => [
        'form_title' => 'Form Kerjasama B2B — Bahari Segar',
        'form_desc' => 'Isi form ini dan tim kami akan menghubungi Anda dalam 1×24 jam kerja.',
        'submit_text' => 'Kirim Permohonan Kerjasama',
        'submit_text_processing' => 'Mengirim...',
        'form_class' => 'bs-b2b-form',
        'ajax_submit' => '1',
        'notification' => [
            'email' => 'dzkyazhar29@gmail.com',
            'subject' => 'Permohonan Kerjasama Baru: {field_id="1"}',
            'sender_name' => 'Bahari Segar Website',
            'sender_address' => '{admin_email}',
            'message' => "Permohonan kerjasama baru masuk:\n\nNama Usaha: {field_id=\"1\"}\nJenis Usaha: {field_id=\"2\"}\nEstimasi Kebutuhan: {field_id=\"3\"}\nNomor WhatsApp: {field_id=\"4\"}\nCatatan: {field_id=\"5\"}\n\nWaktu: {date_time}",
        ],
        'confirmations' => [
            1 => [
                'type' => 'message',
                'message' => '<p style="font-family:IBM Plex Sans,sans-serif;color:#12181B;"><strong>Terima kasih!</strong> Permohonan kerjasama Anda telah kami terima. Tim Bahari Segar akan menghubungi Anda melalui WhatsApp dalam 1×24 jam kerja.</p>',
                'message_scroll' => '1',
            ],
        ],
    ],
    'meta' => [
        'template' => '',
        'created' => time(),
        'status' => 'active',
    ],
];

// Check if form exists
$form_check = $pdo->query("SELECT ID FROM wp_posts WHERE post_type = 'wpforms' AND post_status = 'publish' LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$now = date('Y-m-d H:i:s');

if ($form_check) {
    $form_id = $form_check['ID'];
    $form_data['id'] = $form_id;
    $pdo->prepare("UPDATE wp_posts SET post_content = ?, post_modified = ?, post_modified_gmt = ? WHERE ID = ?")
        ->execute([json_encode($form_data, JSON_UNESCAPED_UNICODE), $now, $now, $form_id]);
    echo "  ↺ Updated WPForms form (ID: $form_id)\n";
} else {
    $pdo->prepare("INSERT INTO wp_posts (post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt, post_status, post_name, post_type, post_modified, post_modified_gmt, comment_status, ping_status, to_ping, pinged, post_content_filtered)
        VALUES (1, ?, ?, ?, 'Form Kerjasama B2B — Bahari Segar', '', 'publish', 'form-kerjasama-b2b', 'wpforms', ?, ?, 'closed', 'closed', '', '', '')")
        ->execute([$now, $now, json_encode($form_data, JSON_UNESCAPED_UNICODE), $now, $now]);
    $form_id = $pdo->lastInsertId();
    $form_data['id'] = $form_id;
    $pdo->prepare("UPDATE wp_posts SET post_content = ? WHERE ID = ?")->execute([json_encode($form_data, JSON_UNESCAPED_UNICODE), $form_id]);
    echo "  ✓ Created WPForms form (ID: $form_id)\n";
}

// Update kerjasama page Elementor data with real form ID
$ids_file = __DIR__ . '/page_ids.json';
$ids = json_decode(file_get_contents($ids_file), true);
$ids['wpforms_id'] = $form_id;
file_put_contents($ids_file, json_encode($ids, JSON_PRETTY_PRINT));

// Update the kerjasama elementor data to replace FORM_ID_PLACEHOLDER
$meta = $pdo->prepare("SELECT meta_value FROM wp_postmeta WHERE post_id = ? AND meta_key = '_elementor_data'");
$meta->execute([$ids['kerjasama']]);
$el_data = $meta->fetchColumn();
if ($el_data) {
    $el_data = str_replace('FORM_ID_PLACEHOLDER', $form_id, $el_data);
    $pdo->prepare("UPDATE wp_postmeta SET meta_value = ? WHERE post_id = ? AND meta_key = '_elementor_data'")->execute([$el_data, $ids['kerjasama']]);
    echo "  ✓ Updated Kerjasama page with form ID: $form_id\n";
}

// ─── 2. LiteSpeed Cache Settings ──────────────────────────────────────────────
echo "\n[2/5] Configuring LiteSpeed Cache...\n";

$ls_settings = [
    'enabled'          => 1,
    'cache_browser'    => 1,
    'cache_object'     => 0,
    'lazyload_images'  => 1,
    'lazyload_iframes' => 1,
    'css_minify'       => 1,
    'js_minify'        => 1,
    'html_minify'      => 1,
    'dns_prefetch'     => 1,
    'cache_ttl_pub'    => 604800, // 7 days
    'cache_ttl_priv'   => 1800,   // 30 min
    'image_lazy_placeholder' => 1,
];

set_option($pdo, 'litespeed', serialize($ls_settings));

// ─── 3. Yoast SEO Global Settings ─────────────────────────────────────────────
echo "\n[3/5] Configuring Yoast SEO...\n";

$yoast_options = [
    'website_name'              => 'Bahari Segar',
    'alternate_website_name'    => 'Bahari Segar Seafood',
    'company_or_person'         => 'company',
    'company_name'              => 'Bahari Segar',
    'title_separator'           => 'sc-dash',
    'breadcrumbs-enable'        => true,
    'breadcrumbs-home'          => 'Beranda',
    'opengraph'                 => true,
    'twitter'                   => true,
    'googlesitekit'             => false,
];
set_option($pdo, 'wpseo', serialize($yoast_options));

$yoast_titles = [
    'title-home-wpseo'     => 'Bahari Segar — Suplier Seafood Segar untuk Hotel & Restoran',
    'metadesc-home-wpseo'  => 'Bahari Segar memasok ikan, udang, cumi, dan olahan hasil laut langsung dari pelelangan ke dapur hotel dan restoran. Ditimbang jam 4 pagi, tiba sebelum jam makan siang.',
    'title-product'        => '%%title%% — Katalog Seafood Bahari Segar',
    'metadesc-product'     => '%%excerpt%%',
    'title-product_cat'    => '%%term_title%% — Kategori Produk Bahari Segar',
    'noindex-product'      => false,
    'noindex-product_cat'  => false,
];
set_option($pdo, 'wpseo_titles', serialize($yoast_titles));

// ─── 4. Activate Required Plugins ─────────────────────────────────────────────
echo "\n[4/5] Activating plugins...\n";

$active_plugins = [
    'elementor/elementor.php',
    'essential-addons-for-elementor-lite/essential_adons_for_elementor.php',
    'woocommerce/woocommerce.php',
    'wpforms-lite/wpforms.php',
    'wordpress-seo/wp-seo.php',
    'litespeed-cache/litespeed-cache.php',
];

set_option($pdo, 'active_plugins', serialize($active_plugins));

// Check actual plugin files exist and fix paths
$plugins_dir = '/home/dzaky/Documents/htdocs/wordpress/wp-content/plugins';
$found_plugins = [];
foreach ($active_plugins as $plugin) {
    $path = $plugins_dir . '/' . $plugin;
    if (file_exists($path)) {
        $found_plugins[] = $plugin;
        echo "  ✓ Plugin found: $plugin\n";
    } else {
        // Try to find alternate main file
        $plugin_dir = dirname($path);
        if (is_dir($plugin_dir)) {
            $files = glob($plugin_dir . '/*.php');
            foreach ($files as $f) {
                $content = file_get_contents($f);
                if (strpos($content, 'Plugin Name:') !== false) {
                    $alt_slug = basename($plugin_dir) . '/' . basename($f);
                    $found_plugins[] = $alt_slug;
                    echo "  ✓ Plugin found (alt path): $alt_slug\n";
                    break;
                }
            }
        } else {
            echo "  ⚠ Plugin dir not found: $plugin\n";
        }
    }
}
set_option($pdo, 'active_plugins', serialize(array_unique($found_plugins)));

// ─── 5. Additional WP Settings ────────────────────────────────────────────────
echo "\n[5/5] Final WordPress settings...\n";

// Rewrite/permalink
set_option($pdo, 'permalink_structure', '/%postname%/');
set_option($pdo, 'rewrite_rules', '');

// Disable comments globally
set_option($pdo, 'default_comment_status', 'closed');
set_option($pdo, 'default_ping_status', 'closed');

// Media
set_option($pdo, 'thumbnail_size_w', '400');
set_option($pdo, 'thumbnail_size_h', '300');
set_option($pdo, 'medium_size_w', '800');
set_option($pdo, 'medium_size_h', '600');
set_option($pdo, 'large_size_w', '1400');
set_option($pdo, 'large_size_h', '1050');

// Elementor global settings
set_option($pdo, 'elementor_global_image_lightbox', '');
set_option($pdo, 'elementor_cpt_support', serialize(['page', 'post', 'product']));
set_option($pdo, 'elementor_allow_tracking', 'no');
set_option($pdo, 'elementor_experiment-page_transitions', 'inactive');

// WooCommerce hide notices
set_option($pdo, 'woocommerce_store_notice_id', '');
set_option($pdo, 'woocommerce_store_notice', '');
set_option($pdo, 'woocommerce_show_marketplace_suggestions', 'no');
set_option($pdo, 'woocommerce_allow_tracking', 'no');

// Site URL confirm
$site_url = 'http://localhost/wordpress';
set_option($pdo, 'siteurl', $site_url);
set_option($pdo, 'home', $site_url);

// Flush transients
$pdo->exec("DELETE FROM wp_options WHERE option_name LIKE '_transient_%'");
$pdo->exec("DELETE FROM wp_options WHERE option_name LIKE '_site_transient_%'");
echo "  ✓ Transients cleared\n";

echo "\n✅ Step 06 Complete: All finalization done.\n";
echo "   WPForms form ID: $form_id (use [wpforms id=\"$form_id\"] in Kerjasama page)\n\n";
