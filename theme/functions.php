<?php
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
    echo '<a href="' . $wa_link . '" target="_blank" rel="noopener" class="bs-wa-button" style="display:inline-flex;align-items:center;gap:10px;background:#C2401C;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:14px;letter-spacing:0.1em;text-transform:uppercase;padding:16px 28px;text-decoration:none;margin-top:16px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
        Tanya Ketersediaan via WhatsApp
    </a>';
}

// Add WhatsApp button on product archive/loop cards
add_action("woocommerce_after_shop_loop_item", "bahari_wa_button_loop", 15);
function bahari_wa_button_loop() {
    $wa_number = "6281234567890";
    $message = urlencode("Halo Bahari Segar, saya ingin menanyakan ketersediaan produk: " . get_the_title());
    $wa_link = "https://wa.me/{$wa_number}?text={$message}";
    echo '<a href="' . $wa_link . '" target="_blank" rel="noopener" style="display:block;background:#C2401C;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:11px;letter-spacing:0.1em;text-transform:uppercase;padding:12px 16px;text-decoration:none;text-align:center;margin-top:12px;">
        Tanya Ketersediaan →
    </a>';
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
