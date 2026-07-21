<?php
/**
 * 09-ocean-retheme.php
 * Patch Elementor JSON di DB: orange → ocean blue palette
 * 
 * OLD → NEW
 * #C2401C (orange)    → #0077B6 (deep ocean blue)
 * #0D1316 (near-black)→ #06101F (deep navy)
 * #12181B (dark)      → #0A1628 (ocean midnight)  
 * #2E4A4A (teal-dark) → #0E2D5A (ocean dashed)
 * #E7E9E1 (warm grey) → #EAF2FB (ice blue)
 * CTA bg #C2401C      → #005F8E (deep ocean CTA)
 */

$pdo = new PDO("mysql:host=localhost;dbname=db_wordpress;charset=utf8mb4","root","gggaming21");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$ids = json_decode(file_get_contents(__DIR__.'/page_ids.json'), true);

// ─── Palet Baru ──────────────────────────────────────────────────────────────
// Accent utama: deep ocean blue
$A = '#0077B6';    // was #C2401C
$AL = 'rgba(0,119,182,0.5)';  // was rgba(194,64,28,0.5)
$A45 = 'rgba(0,119,182,0.45)'; // was rgba(194,64,28,0.45)

// Dark surfaces → navy/ocean deep
$D1 = '#06101F';   // was #0D1316
$D2 = '#0A1628';   // was #12181B

// Overlay rgba → ocean dark
// was rgba(13,19,22,...) → rgba(6,16,31,...)

// Dashed/grid separators  
$SEP = '#0E2D5A';  // was #2E4A4A
$GRID = '#0E2040'; // was #1E2A2A

// Light surface → ice blue tint
$SL = '#EAF2FB';   // was #E7E9E1
$SL2 = 'rgba(220,235,252,0.6)'; // was rgba(231,233,225,0.6)
$SL3 = 'rgba(220,235,252,0.55)'; // was rgba(231,233,225,0.55)
$SL4 = 'rgba(220,235,252,0.4)';  // was rgba(231,233,225,0.4)

// Body text on light bg
$BODY_LIGHT = '#1E3A5A'; // was #4A5250

// Border
$BORDER = '#A8C4DC'; // was #C8CBC3
$BORDER2 = '#5A8AB0'; // was #B8BDB8

// Muted text
$MUTED = '#6B809E'; // was #7A8481 (adds blue tint)

// CTA bg: deeper ocean for contrast  
$CTA_BG = '#005F8E'; // darker ocean for CTA sections

echo "\n=== 09-ocean-retheme.php ===\n\n";

$page_map = [
    'beranda'  => $ids['beranda'],
    'tentang'  => $ids['tentang'],
    'produk'   => $ids['produk'],
];

foreach ($page_map as $name => $pid) {
    $r = $pdo->prepare("SELECT meta_value FROM wp_postmeta WHERE post_id=? AND meta_key='_elementor_data'");
    $r->execute([$pid]);
    $json = $r->fetchColumn();
    if (!$json) { echo "  SKIP $name (no data)\n"; continue; }

    $old = $json;

    // ── 1. Accent orange → deep ocean blue ─────────────────────────────────
    $json = str_replace('"#C2401C"', '"'.$A.'"', $json);
    $json = str_replace("'#C2401C'", "'".$A."'", $json);
    
    // In inline CSS values inside HTML strings
    $json = str_replace('#C2401C', $A, $json);
    
    // rgba shadows → ocean blue shadows
    $json = str_replace('rgba(194,64,28,0.5)', $AL, $json);
    $json = str_replace('rgba(194,64,28,0.45)', $A45, $json);
    $json = str_replace('rgba(194,64,28,0.35)', 'rgba(0,119,182,0.35)', $json);

    // ── 2. Dark backgrounds → navy ──────────────────────────────────────────
    $json = str_replace('#0D1316', $D1, $json);
    $json = str_replace('#12181B', $D2, $json);
    
    // Section background_color values 
    $json = str_replace('"background_color":"'.$D1.'"', '"background_color":"'.$D1.'"', $json); // already replaced
    
    // Dark overlays in HTML (rgba values)
    $json = str_replace('rgba(13,19,22,0.96)', 'rgba(6,16,31,0.96)', $json);
    $json = str_replace('rgba(13,19,22,0.97)', 'rgba(6,16,31,0.97)', $json);
    $json = str_replace('rgba(13,19,22,0.95)', 'rgba(6,16,31,0.95)', $json);
    $json = str_replace('rgba(13,19,22,0.9)',  'rgba(6,16,31,0.9)',  $json);
    $json = str_replace('rgba(13,19,22,0.88)', 'rgba(6,16,31,0.88)', $json);
    $json = str_replace('rgba(13,19,22,0.85)', 'rgba(6,16,31,0.85)', $json);
    $json = str_replace('rgba(13,19,22,0.5)',  'rgba(6,16,31,0.5)',  $json);
    $json = str_replace('rgba(13,19,22,0.3)',  'rgba(6,16,31,0.3)',  $json);
    $json = str_replace('rgba(13,19,22,0.2)',  'rgba(6,16,31,0.2)',  $json);
    $json = str_replace('rgba(13,19,22,0.05)', 'rgba(6,16,31,0.05)', $json);

    // ── 3. Separator/grid dark → ocean ─────────────────────────────────────
    $json = str_replace('#2E4A4A', $SEP, $json);
    $json = str_replace('#1E2A2A', $GRID, $json);

    // ── 4. Light surface → ice blue ────────────────────────────────────────
    $json = str_replace('#E7E9E1', $SL, $json);
    $json = str_replace('rgba(231,233,225,0.6)',  $SL2, $json);
    $json = str_replace('rgba(231,233,225,0.55)', $SL3, $json);
    $json = str_replace('rgba(231,233,225,0.4)',  $SL4, $json);
    // Stats border
    $json = str_replace('#C8CBC3', $BORDER, $json);
    $json = str_replace('#B8BDB8', $BORDER2, $json);

    // ── 5. Body text on light bg ────────────────────────────────────────────
    $json = str_replace('#4A5250', $BODY_LIGHT, $json);
    $json = str_replace('#7A8481', $MUTED, $json);

    // ── 6. CTA section bg → deeper ocean (not flat orange) ─────────────────
    // Section bg_color for CTA sections was set to #C2401C (already replaced above to #0077B6)
    // But let's make CTA deeper:
    $json = str_replace('"background_color":"'.$A.'"', '"background_color":"'.$CTA_BG.'"', $json);
    // But keep accent buttons still $A — the above will only match section-level bg
    // Re-fix: only CTA section background should be $CTA_BG
    // Since we replaced $A in background_color, also need button backgrounds back to $A
    // Actually the button bg is in inline style HTML, not background_color JSON key  
    // So the above only affects Elementor section-level background_color JSON key ✓

    // ── 7. Gradient line overlays updated ───────────────────────────────────
    // linear-gradient lines with old dark colors are already fixed via rgba replacements

    // Check changes
    $changes = ($old === $json) ? 0 : substr_count($json, $A) + substr_count($json, $D1) + substr_count($json, $SL);
    
    // Write back
    $pdo->prepare("UPDATE wp_postmeta SET meta_value=? WHERE post_id=? AND meta_key='_elementor_data'")->execute([$json, $pid]);
    echo "  OK $name | approx $changes ocean-blue tokens inserted\n";
}

// ── Update CSS in DB (wp_css / additional_css) ──────────────────────────────
$css = $pdo->query("SELECT option_value FROM wp_options WHERE option_name='wp_css'")->fetchColumn();
if ($css) {
    $css = str_replace('#C2401C', $A, $css);
    $css = str_replace('#0D1316', $D1, $css);
    $css = str_replace('#12181B', $D2, $css);
    $css = str_replace('#E7E9E1', $SL, $css);
    $pdo->prepare("UPDATE wp_options SET option_value=? WHERE option_name='wp_css'")->execute([$css]);
    echo "  OK wp_css updated\n";
}

// ── Clear cache ──────────────────────────────────────────────────────────────
$pdo->exec("DELETE FROM wp_options WHERE option_name LIKE '_elementor_css_%'");
$pdo->exec("DELETE FROM wp_options WHERE option_name LIKE '_transient_elementor%'");
$pdo->exec("DELETE FROM wp_options WHERE option_name LIKE '_transient_timeout_elementor%'");
echo "\n  Cache cleared.\n";
echo "\n  PALETTE:\n";
echo "  Accent      : #C2401C → $A (deep ocean blue)\n";
echo "  Surface dark: #0D1316 → $D1 (navy)\n";
echo "  Surface mid : #12181B → $D2 (ocean midnight)\n";
echo "  Surface light: #E7E9E1 → $SL (ice blue)\n";
echo "  CTA bg      : #C2401C → $CTA_BG (deep ocean)\n";
echo "\n✅ Ocean retheme DONE!\n";
echo "Open: http://localhost/wordpress/\n\n";
