<?php
/**
 * Script 05: Inject Custom CSS + Global Styles
 * - Google Fonts import
 * - Grain/noise texture overlay
 * - Badge stempel animation
 * - Stamp animation keyframes
 * - WooCommerce catalog mode CSS (hide cart buttons)
 * - Astra header/footer styling
 * Run: php 05-inject-css.php
 */

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'gggaming21');
define('DB_NAME', 'db_wordpress');

$pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4", DB_USER, DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "\n=== Bahari Segar Build: Step 05 - Inject Custom CSS ===\n\n";

$custom_css = <<<'CSS'
/* ═══════════════════════════════════════════════════════════════
   BAHARI SEGAR — CUSTOM GLOBAL CSS
   Design System: Graphite Market + Stamp Vermillion
   ═══════════════════════════════════════════════════════════════ */

/* --- Google Fonts --- */
@import url('https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700;800;900&family=IBM+Plex+Sans:wght@400;500&family=IBM+Plex+Mono:wght@400;500&display=swap');

/* --- Design Tokens --- */
:root {
    --surface-primary: #12181B;
    --surface-paper: #F3EFE4;
    --accent-stamp: #C2401C;
    --text-steel: #7A8481;
    --line-cold: #2E4A4A;
    --surface-deep: #0D1316;
}

/* --- Global Reset --- */
*, *::before, *::after { box-sizing: border-box; }

body {
    background-color: var(--surface-primary);
    color: var(--surface-paper);
    font-family: 'IBM Plex Sans', sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* --- Grain/Noise Overlay --- */
body::before {
    content: '';
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    pointer-events: none;
    z-index: 9999;
    opacity: 0.04;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='1'/%3E%3C/svg%3E");
    background-repeat: repeat;
    background-size: 128px 128px;
}

/* --- Typography --- */
h1, h2, h3, h4, h5, h6 {
    font-family: 'Oswald', sans-serif;
    font-weight: 700;
    line-height: 0.95;
    letter-spacing: -0.02em;
    color: var(--surface-paper);
}

h1 { font-size: clamp(2.5rem, 7vw, 6rem); font-weight: 800; }
h2 { font-size: clamp(1.8rem, 4vw, 3.5rem); }
h3 { font-size: clamp(1.3rem, 2.5vw, 2rem); }

/* --- Astra Header --- */
.site-header, .ast-site-header-wrap {
    background-color: #0D1316 !important;
    border-bottom: 1px solid #1E2A2A !important;
}
.ast-logo-img { max-height: 40px !important; }

/* Site title as text logo */
.site-title {
    font-family: 'Oswald', sans-serif !important;
    font-weight: 800 !important;
    font-size: 22px !important;
    letter-spacing: -0.01em !important;
    color: var(--surface-paper) !important;
}
.site-title a { color: var(--surface-paper) !important; text-decoration: none !important; }
.site-title a:hover { color: var(--accent-stamp) !important; }

/* Navigation */
.ast-primary-header-bar .main-navigation a,
.main-header-bar .main-navigation a,
.ast-main-navigation a {
    font-family: 'Oswald', sans-serif !important;
    font-weight: 600 !important;
    font-size: 13px !important;
    letter-spacing: 0.1em !important;
    text-transform: uppercase !important;
    color: var(--text-steel) !important;
    transition: color 0.2s ease !important;
    padding: 4px 16px !important;
}
.ast-primary-header-bar .main-navigation a:hover,
.ast-main-navigation a:hover {
    color: var(--surface-paper) !important;
}
.ast-main-navigation .current-menu-item > a,
.ast-main-navigation .current_page_item > a {
    color: var(--accent-stamp) !important;
}

/* CTA in nav */
.ast-header-custom-item a {
    background: var(--accent-stamp) !important;
    color: var(--surface-paper) !important;
    font-family: 'Oswald', sans-serif !important;
    font-weight: 700 !important;
    font-size: 12px !important;
    letter-spacing: 0.12em !important;
    text-transform: uppercase !important;
    padding: 10px 20px !important;
    text-decoration: none !important;
}

/* Mobile menu toggle */
.ast-mobile-menu-trigger span { background-color: var(--surface-paper) !important; }

/* --- Astra Footer --- */
.site-footer, .ast-small-footer {
    background-color: #0D1316 !important;
    border-top: 1px solid #1E2A2A !important;
}
.ast-small-footer .ast-footer-copyright {
    font-family: 'IBM Plex Mono', monospace !important;
    font-size: 11px !important;
    color: var(--text-steel) !important;
    letter-spacing: 0.08em !important;
}

/* --- Keyframe Animations --- */
@keyframes stampIn {
    0%   { opacity: 0; transform: scale(0.8) rotate(-8deg); }
    60%  { transform: scale(1.04) rotate(1deg); }
    100% { opacity: 1; transform: scale(1) rotate(0deg); }
}

@keyframes stampPress {
    0%   { transform: rotate(3deg) translateY(0) scale(1); box-shadow: 0 4px 12px rgba(194,64,28,0.4); }
    50%  { transform: rotate(3deg) translateY(2px) scale(0.97); box-shadow: 0 1px 4px rgba(194,64,28,0.3); }
    100% { transform: rotate(3deg) translateY(0) scale(1); box-shadow: 0 4px 12px rgba(194,64,28,0.4); }
}

/* --- Stamp Animation on Hero --- */
.bs-manifest-ticket {
    animation: stampIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) 0.3s both !important;
}

/* --- Grade Stamp Hover Effect --- */
.bs-grade-stamp {
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.bs-grade-stamp:hover {
    animation: stampPress 0.3s ease forwards !important;
}

/* --- WooCommerce Catalog Mode --- */
/* Hide all add-to-cart buttons */
.woocommerce .add_to_cart_button,
.woocommerce .single_add_to_cart_button,
.woocommerce-page .add_to_cart_button,
.woocommerce button.button.alt,
form.cart button[type="submit"],
.woocommerce .cart,
.woocommerce #respond input#submit,
.woocommerce a.button.alt,
.woocommerce-loop-add-to-cart-link,
.quantity,
.wc-proceed-to-checkout,
.woocommerce-checkout,
.woocommerce-cart,
.woocommerce .cart-collaterals,
.woocommerce .woocommerce-message .button,
.woocommerce .woocommerce-info .button {
    display: none !important;
}

/* WooCommerce product pages: dark theme */
.woocommerce-page body,
body.woocommerce {
    background-color: var(--surface-primary) !important;
}

.woocommerce div.product .product_title {
    font-family: 'Oswald', sans-serif !important;
    font-weight: 700 !important;
    color: var(--surface-paper) !important;
    font-size: 3rem !important;
    line-height: 0.95 !important;
    letter-spacing: -0.02em !important;
}

.woocommerce div.product .woocommerce-product-details__short-description p {
    font-family: 'IBM Plex Sans', sans-serif !important;
    color: var(--text-steel) !important;
}

/* Product price — hide it (B2B pricing via WA) */
.woocommerce div.product p.price,
.woocommerce div.product span.price,
.woocommerce ul.products li.product .price {
    display: none !important;
}

/* "Tanya Ketersediaan" button instead of cart */
.woocommerce div.product .woocommerce-variation-add-to-cart,
.woocommerce div.product form.cart {
    display: block !important;
}
.woocommerce div.product form.cart .single_add_to_cart_button {
    display: none !important;
}

/* WhatsApp inquiry button on product pages */
.bs-wa-button {
    display: inline-flex !important;
    align-items: center;
    gap: 10px;
    background: var(--accent-stamp) !important;
    color: var(--surface-paper) !important;
    font-family: 'Oswald', sans-serif !important;
    font-weight: 700 !important;
    font-size: 14px !important;
    letter-spacing: 0.1em !important;
    text-transform: uppercase !important;
    padding: 16px 28px !important;
    text-decoration: none !important;
    border: none !important;
    cursor: pointer !important;
    transition: opacity 0.2s ease !important;
}
.bs-wa-button:hover { opacity: 0.9 !important; }

/* Product card on shop/archive */
.woocommerce ul.products li.product {
    background: var(--surface-deep) !important;
    border-top: 3px solid var(--line-cold);
    padding: 28px 24px !important;
    transition: border-top-color 0.2s ease !important;
}
.woocommerce ul.products li.product:hover {
    border-top-color: var(--accent-stamp) !important;
}
.woocommerce ul.products li.product a.woocommerce-loop-product__link h2 {
    font-family: 'Oswald', sans-serif !important;
    font-weight: 700 !important;
    font-size: 1.3rem !important;
    color: var(--surface-paper) !important;
    line-height: 1.1 !important;
}

/* WooCommerce breadcrumb */
.woocommerce .woocommerce-breadcrumb {
    font-family: 'IBM Plex Mono', monospace !important;
    font-size: 11px !important;
    color: var(--text-steel) !important;
    letter-spacing: 0.1em !important;
    text-transform: uppercase !important;
    background: transparent !important;
}
.woocommerce .woocommerce-breadcrumb a { color: var(--accent-stamp) !important; }

/* WC shop title */
.woocommerce .woocommerce-products-header__title {
    font-family: 'Oswald', sans-serif !important;
    color: var(--surface-paper) !important;
}

/* Category headers */
.woocommerce .wc-breadcrumb .breadcrumb-trail,
.term-description {
    font-family: 'IBM Plex Sans', sans-serif !important;
    color: var(--text-steel) !important;
}

/* --- Elementor overrides for dark theme --- */
.elementor-page { background-color: var(--surface-primary) !important; }

.elementor-widget-text-editor p {
    margin-bottom: 0;
}

/* --- Perforated divider --- */
.bs-perforation {
    height: 24px;
    background: repeating-linear-gradient(
        90deg,
        var(--surface-paper) 0,
        var(--surface-paper) 12px,
        transparent 12px,
        transparent 20px
    );
    opacity: 0.12;
}

/* --- Pull-quote --- */
.bs-pullquote {
    margin-left: 12%;
    border-left: none;
    padding-left: 0;
}

/* --- Responsive --- */
@media (max-width: 768px) {
    .bs-pullquote { margin-left: 0; }
    body::before { display: none; } /* performance on mobile */
}

/* --- Reduced Motion --- */
@media (prefers-reduced-motion: reduce) {
    .bs-manifest-ticket { animation: none !important; }
    .bs-grade-stamp, .bs-grade-stamp:hover { animation: none !important; transition: none !important; }
    * { transition: none !important; }
}

/* --- Scrollbar Styling --- */
::-webkit-scrollbar { width: 6px; }
::-webkit-scrollbar-track { background: var(--surface-primary); }
::-webkit-scrollbar-thumb { background: var(--line-cold); border-radius: 3px; }
::-webkit-scrollbar-thumb:hover { background: var(--text-steel); }

CSS;

// Save to Astra's additional CSS
$check = $pdo->prepare("SELECT option_id FROM wp_options WHERE option_name = 'astra-custom-css'");
$check->execute();
if ($check->fetch()) {
    $stmt = $pdo->prepare("UPDATE wp_options SET option_value = ? WHERE option_name = 'astra-custom-css'");
    $stmt->execute([$custom_css]);
} else {
    $stmt = $pdo->prepare("INSERT INTO wp_options (option_name, option_value, autoload) VALUES ('astra-custom-css', ?, 'yes')");
    $stmt->execute([$custom_css]);
}
echo "  ✓ Saved to astra-custom-css option\n";

// Also save to WordPress custom CSS
$check2 = $pdo->prepare("SELECT option_id FROM wp_options WHERE option_name = 'wp_css'");
$check2->execute();
if ($check2->fetch()) {
    $pdo->prepare("UPDATE wp_options SET option_value = ? WHERE option_name = 'wp_css'")->execute([$custom_css]);
} else {
    $pdo->prepare("INSERT INTO wp_options (option_name, option_value, autoload) VALUES ('wp_css', ?, 'no')")->execute([$custom_css]);
}
echo "  ✓ Saved to wp_css (WordPress core custom CSS)\n";

// Write CSS file to theme as fallback
$css_path = '/home/dzaky/Documents/htdocs/wordpress/wp-content/themes/astra/bahari-segar-custom.css';
file_put_contents($css_path, $custom_css);
echo "  ✓ Saved to theme directory: $css_path\n";

// Create child theme if not exists
$child_dir = '/home/dzaky/Documents/htdocs/wordpress/wp-content/themes/astra-child';
if (!is_dir($child_dir)) {
    mkdir($child_dir, 0755, true);
    echo "  ✓ Created child theme directory\n";
}

// Child theme style.css
$child_style = '/*
Theme Name: Astra Child — Bahari Segar
Template: astra
Description: Custom child theme for Bahari Segar B2B Seafood Website
Version: 1.0.0
Author: Bahari Segar
*/
@import url("../astra/style.css");
';
file_put_contents($child_dir . '/style.css', $child_style);
echo "  ✓ Child theme style.css created\n";

// Child theme functions.php - enqueue fonts + custom CSS
$child_functions = '<?php
/**
 * Astra Child Theme Functions — Bahari Segar
 */

// Enqueue parent theme styles
add_action("wp_enqueue_scripts", "bahari_enqueue_styles", 20);
function bahari_enqueue_styles() {
    // Google Fonts
    wp_enqueue_style(
        "bahari-fonts",
        "https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700;800;900&family=IBM+Plex+Sans:wght@400;500&family=IBM+Plex+Mono:wght@400;500&display=swap",
        [],
        null
    );
    // Custom CSS
    wp_enqueue_style(
        "bahari-custom",
        get_stylesheet_directory_uri() . "/bahari-segar-custom.css",
        ["bahari-fonts"],
        "1.0.0"
    );
}

// Inject WhatsApp button on single product pages (catalog mode)
add_action("woocommerce_single_product_summary", "bahari_wa_button", 31);
function bahari_wa_button() {
    global $product;
    $wa_number = "6281234567890";
    $product_name = urlencode(get_the_title());
    $message = urlencode("Halo Bahari Segar, saya ingin menanyakan ketersediaan produk: " . get_the_title());
    $wa_link = "https://wa.me/{$wa_number}?text={$message}";
    echo \'<a href="\' . $wa_link . \'" target="_blank" rel="noopener" class="bs-wa-button" style="display:inline-flex;align-items:center;gap:10px;background:#C2401C;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:14px;letter-spacing:0.1em;text-transform:uppercase;padding:16px 28px;text-decoration:none;margin-top:16px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
        Tanya Ketersediaan via WhatsApp
    </a>\';
}

// Add WhatsApp button on product archive/loop cards
add_action("woocommerce_after_shop_loop_item", "bahari_wa_button_loop", 15);
function bahari_wa_button_loop() {
    $wa_number = "6281234567890";
    $message = urlencode("Halo Bahari Segar, saya ingin menanyakan ketersediaan produk: " . get_the_title());
    $wa_link = "https://wa.me/{$wa_number}?text={$message}";
    echo \'<a href="\' . $wa_link . \'" target="_blank" rel="noopener" style="display:block;background:#C2401C;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:11px;letter-spacing:0.1em;text-transform:uppercase;padding:12px 16px;text-decoration:none;text-align:center;margin-top:12px;">
        Tanya Ketersediaan →
    </a>\';
}

// Remove WC sidebar on single product
add_filter("woocommerce_product_tabs", "__return_empty_array");

// Disable WC checkout & cart pages (redirect to homepage)
add_action("template_redirect", "bahari_disable_checkout_cart");
function bahari_disable_checkout_cart() {
    if (is_checkout() || is_cart()) {
        wp_redirect(home_url());
        exit;
    }
}

// Remove WC admin notices on front
add_filter("woocommerce_show_admin_notice", "__return_false");
';
file_put_contents($child_dir . '/functions.php', $child_functions);
echo "  ✓ Child theme functions.php created\n";

// Copy custom CSS to child theme
file_put_contents($child_dir . '/bahari-segar-custom.css', $custom_css);
echo "  ✓ Custom CSS copied to child theme\n";

// Activate child theme
$check3 = $pdo->prepare("SELECT option_id FROM wp_options WHERE option_name = 'template'");
$check3->execute();
if ($check3->fetch()) {
    $pdo->prepare("UPDATE wp_options SET option_value = 'astra-child' WHERE option_name = 'template'")->execute();
    $pdo->prepare("UPDATE wp_options SET option_value = 'astra-child' WHERE option_name = 'stylesheet'")->execute();
} else {
    $pdo->prepare("INSERT INTO wp_options (option_name, option_value, autoload) VALUES ('template', 'astra-child', 'yes')")->execute();
    $pdo->prepare("INSERT INTO wp_options (option_name, option_value, autoload) VALUES ('stylesheet', 'astra-child', 'yes')")->execute();
}
echo "  ✓ Astra Child theme activated\n";

echo "\n✅ Step 05 Complete: Custom CSS injected + Child theme created.\n\n";
