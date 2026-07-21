<?php
/**
 * Script 01: Setup Astra Theme - Global Colors, Typography, WooCommerce Catalog Mode
 * Run: php 01-setup-astra-theme.php
 */

define('ABSPATH', '/home/dzaky/Documents/htdocs/wordpress/');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'gggaming21');
define('DB_NAME', 'db_wordpress');

$pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4", DB_USER, DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function set_option($pdo, $name, $value, $autoload = 'yes') {
    $check = $pdo->prepare("SELECT option_id FROM wp_options WHERE option_name = ?");
    $check->execute([$name]);
    if ($check->fetch()) {
        $stmt = $pdo->prepare("UPDATE wp_options SET option_value = ?, autoload = ? WHERE option_name = ?");
        $stmt->execute([$value, $autoload, $name]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO wp_options (option_name, option_value, autoload) VALUES (?, ?, ?)");
        $stmt->execute([$name, $value, $autoload]);
    }
    echo "  ✓ Set option: $name\n";
}

echo "\n=== Bahari Segar Build: Step 01 - Astra Theme Setup ===\n\n";

// 1. Activate Astra theme
set_option($pdo, 'template', 'astra');
set_option($pdo, 'stylesheet', 'astra');
echo "\n[1/6] Astra theme activated.\n";

// 2. Site title & tagline
set_option($pdo, 'blogname', 'Bahari Segar');
set_option($pdo, 'blogdescription', 'Suplier Hasil Laut Segar untuk Hotel & Restoran');
echo "\n[2/6] Site title set.\n";

// 3. Astra Global Colors & Typography
$astra_settings = [
    // Global colors
    'astra-color-1'      => '#12181B',
    'astra-color-2'      => '#F3EFE4',
    'astra-color-3'      => '#C2401C',
    'astra-color-4'      => '#7A8481',
    'astra-color-5'      => '#2E4A4A',

    // Text
    'text-color'         => '#F3EFE4',
    'link-color'         => '#C2401C',
    'link-h-color'       => '#E05012',
    'theme-color'        => '#C2401C',

    // Body background
    'body-bg-obj'        => json_encode(['desktop' => '#12181B', 'tablet' => '#12181B', 'mobile' => '#12181B']),

    // Body font
    'body-font-family'        => 'IBM Plex Sans',
    'body-font-weight'        => '400',
    'body-font-size'          => json_encode(['desktop' => '16', 'tablet' => '15', 'mobile' => '14', 'desktop-unit' => 'px', 'tablet-unit' => 'px', 'mobile-unit' => 'px']),
    'body-line-height'        => '1.6',
    'body-font-variant'       => 'normal',

    // Heading font
    'headings-font-family'    => 'Oswald',
    'headings-font-weight'    => '700',
    'headings-line-height'    => '0.95',
    'headings-font-variant'   => 'normal',

    // H1
    'font-size-h1'       => json_encode(['desktop' => '80', 'tablet' => '56', 'mobile' => '40', 'desktop-unit' => 'px', 'tablet-unit' => 'px', 'mobile-unit' => 'px']),
    'h1-color'           => '#F3EFE4',
    // H2
    'font-size-h2'       => json_encode(['desktop' => '52', 'tablet' => '36', 'mobile' => '28', 'desktop-unit' => 'px', 'tablet-unit' => 'px', 'mobile-unit' => 'px']),
    'h2-color'           => '#F3EFE4',
    // H3
    'font-size-h3'       => json_encode(['desktop' => '32', 'tablet' => '24', 'mobile' => '20', 'desktop-unit' => 'px', 'tablet-unit' => 'px', 'mobile-unit' => 'px']),
    'h3-color'           => '#F3EFE4',

    // Header bg
    'header-bg-color'    => '#0D1316',
    'site-layout'        => 'full-width',
    'content-layout'     => 'plain-container',

    // Disable header transparency
    'transparent-header-enable' => '0',

    // Button
    'button-bg-color'        => '#C2401C',
    'button-color'           => '#F3EFE4',
    'button-border-radius'   => json_encode(['desktop' => '2', 'tablet' => '2', 'mobile' => '2', 'desktop-unit' => 'px', 'tablet-unit' => 'px', 'mobile-unit' => 'px']),
    'button-font-family'     => 'Oswald',
    'button-font-weight'     => '700',

    // Footer
    'footer-bg-color'        => '#0D1316',
    'footer-color'           => '#7A8481',
    'footer-link-color'      => '#F3EFE4',
];

$astra_settings_json = json_encode($astra_settings);
set_option($pdo, 'astra-settings', $astra_settings_json, 'yes');
echo "\n[3/6] Astra global colors & typography set.\n";

// 4. Google Fonts in Astra
$custom_fonts = [
    'Oswald'       => ['700', '800', '900'],
    'IBM Plex Sans'=> ['400', '500'],
    'IBM Plex Mono'=> ['400', '500'],
];
set_option($pdo, 'astra-google-fonts', json_encode($custom_fonts), 'yes');
echo "\n[4/6] Google Fonts configured.\n";

// 5. WooCommerce catalog mode (hide add-to-cart)
set_option($pdo, 'woocommerce_cart_redirect_after_add', 'no');
set_option($pdo, 'woocommerce_enable_checkout_login_reminder', 'no');
set_option($pdo, 'woocommerce_catalog_mode', 'yes');

// WooCommerce shop settings
set_option($pdo, 'woocommerce_shop_page_display', '');
set_option($pdo, 'woocommerce_category_archive_display', '');
set_option($pdo, 'woocommerce_default_catalog_orderby', 'menu_order');
set_option($pdo, 'woocommerce_shop_page_title', 'Katalog Produk');

// Currency (IDR display)
set_option($pdo, 'woocommerce_currency', 'IDR');
set_option($pdo, 'woocommerce_currency_pos', 'left');

echo "\n[5/6] WooCommerce set to catalog mode.\n";

// 6. General WordPress settings
set_option($pdo, 'timezone_string', 'Asia/Jakarta');
set_option($pdo, 'date_format', 'j F Y');
set_option($pdo, 'time_format', 'H:i');
set_option($pdo, 'permalink_structure', '/%postname%/');
set_option($pdo, 'show_on_front', 'page'); // Set front page to static

echo "\n[6/6] General settings configured.\n";

echo "\n✅ Step 01 Complete: Astra theme setup done.\n\n";
