#!/bin/bash
# ══════════════════════════════════════════════════════════
# RUN ALL — Bahari Segar WordPress Build
# Menjalankan semua build scripts secara berurutan
# ══════════════════════════════════════════════════════════

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PHP=/usr/bin/php
LOG="$SCRIPT_DIR/build.log"

echo ""
echo "╔══════════════════════════════════════════════════╗"
echo "║   BAHARI SEGAR — WordPress Build System          ║"
echo "║   B2B Seafood Supplier Website                   ║"
echo "╚══════════════════════════════════════════════════╝"
echo ""
echo "  Log file: $LOG"
echo ""

# Clear log
> "$LOG"

run_script() {
    local script="$1"
    local label="$2"
    echo "──────────────────────────────────────────────────"
    echo "  ▶ $label"
    echo "──────────────────────────────────────────────────"
    $PHP "$SCRIPT_DIR/$script" 2>&1 | tee -a "$LOG"
    local exit_code=${PIPESTATUS[0]}
    if [ $exit_code -ne 0 ]; then
        echo ""
        echo "  ✗ FAILED: $script (exit code: $exit_code)"
        echo "  Check $LOG for details."
        exit $exit_code
    fi
    echo ""
}

run_script "01-setup-astra-theme.php"    "Step 01: Astra Theme Setup"
run_script "02-create-pages.php"         "Step 02: Create Pages & Nav Menu"
run_script "03-inject-elementor.php"     "Step 03: Inject Elementor Content"
run_script "04-create-products.php"      "Step 04: Create WooCommerce Products"
run_script "05-inject-css.php"           "Step 05: Inject Custom CSS + Child Theme"
run_script "06-finalize.php"             "Step 06: WPForms, LiteSpeed, SEO, Finalize"

echo "══════════════════════════════════════════════════════"
echo ""
echo "  ✅ BUILD COMPLETE — Bahari Segar Website"
echo ""
echo "  🌐 View site:  http://localhost/wordpress"
echo "  🔧 WP Admin:   http://localhost/wordpress/wp-admin"
echo "  👤 Login:      admin / admin123"
echo ""
echo "  Halaman:"
echo "    ● Beranda:      http://localhost/wordpress/"
echo "    ● Tentang Kami: http://localhost/wordpress/tentang-kami/"
echo "    ● Produk:       http://localhost/wordpress/produk/"
echo "    ● Kerjasama B2B: http://localhost/wordpress/kerjasama-b2b/"
echo "    ● Kontak:       http://localhost/wordpress/kontak/"
echo ""
echo "══════════════════════════════════════════════════════"
