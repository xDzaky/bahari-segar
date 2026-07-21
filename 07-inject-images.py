#!/usr/bin/env python3
"""
Bahari Segar - Inject Elementor Image Data
Langsung ke MySQL, menghindari masalah PHP string escaping
"""
import json, sys
try:
    import pymysql
except ImportError:
    import subprocess
    subprocess.run([sys.executable, "-m", "pip", "install", "pymysql", "-q"], check=True)
    import pymysql

# ─── Koneksi DB ─────────────────────────────────────────────────────────────
conn = pymysql.connect(host='localhost', user='root', password='gggaming21',
                       db='db_wordpress', charset='utf8mb4',
                       cursorclass=pymysql.cursors.DictCursor)
cur = conn.cursor()

# Load page IDs
import os
page_ids_path = os.path.join(os.path.dirname(__file__), 'page_ids.json')
with open(page_ids_path) as f:
    IDS = json.load(f)

WA = "https://wa.me/6281234567890"

# ─── Unsplash Images ────────────────────────────────────────────────────────
IMGS = {
    "hero_bg":        "https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=1600&q=85&auto=format&fit=crop",
    "ikan_segar":     "https://images.unsplash.com/photo-1534482421-64566f976cfa?w=1200&q=85&auto=format&fit=crop",
    "proses":         "https://images.unsplash.com/photo-1607083206968-13611e3d76db?w=1200&q=85&auto=format&fit=crop",
    "cold_chain":     "https://images.unsplash.com/photo-1570042225831-d98fa7577f1e?w=1200&q=85&auto=format&fit=crop",
    "fish_market":    "https://images.unsplash.com/photo-1559060017-445fb9722f2a?w=1600&q=85&auto=format&fit=crop",
    "seafood":        "https://images.unsplash.com/photo-1615141982883-c7ad0e69fd62?w=1200&q=85&auto=format&fit=crop",
    "pelabuhan":      "https://images.unsplash.com/photo-1504472478235-9bc48ba4d60f?w=1600&q=85&auto=format&fit=crop",
    "tentang_bg":     "https://images.unsplash.com/photo-1598515213692-bb2fe38a4df6?w=1600&q=85&auto=format&fit=crop",
    "cta_bg":         "https://images.unsplash.com/photo-1505118380757-91f5f5632de0?w=1600&q=85&auto=format&fit=crop",
    "udang":          "https://images.unsplash.com/photo-1565680018434-b513d5e5fd47?w=800&q=85&auto=format&fit=crop",
    "cumi":           "https://images.unsplash.com/photo-1604709178681-2b6f0d5c7800?w=800&q=85&auto=format&fit=crop",
}

def set_meta(post_id, key, value):
    cur.execute("SELECT meta_id FROM wp_postmeta WHERE post_id=%s AND meta_key=%s", (post_id, key))
    row = cur.fetchone()
    if row:
        cur.execute("UPDATE wp_postmeta SET meta_value=%s WHERE post_id=%s AND meta_key=%s",
                    (value, post_id, key))
    else:
        cur.execute("INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (%s,%s,%s)",
                    (post_id, key, value))

def make_section(sid, bg_color=None, bg_image=None, padding=None, height=None, elements=None, custom_id=None):
    s = {"id": sid, "elType": "section", "settings": {}, "elements": elements or []}
    if bg_color:
        s["settings"]["background_background"] = "classic"
        s["settings"]["background_color"] = bg_color
    if bg_image:
        s["settings"]["background_background"] = "classic"
        s["settings"]["background_image"] = {"url": bg_image, "id": ""}
        s["settings"]["background_size"] = "cover"
        s["settings"]["background_position"] = "center center"
    if padding:
        s["settings"]["padding"] = {"unit": "px", "top": str(padding[0]), "right": str(padding[1]),
                                     "bottom": str(padding[2]), "left": str(padding[3]), "isLinked": False}
    if height:
        s["settings"]["height"] = "min-height"
        s["settings"]["custom_height"] = {"size": height, "unit": "px"}
    if custom_id:
        s["settings"]["custom_id"] = custom_id
    return s

def make_col(cid, size, padding=None, position="top", elements=None):
    c = {"id": cid, "elType": "column",
         "settings": {"_column_size": size, "content_position": position},
         "elements": elements or []}
    if padding:
        c["settings"]["padding"] = {"unit": "px", "top": str(padding[0]), "right": str(padding[1]),
                                      "bottom": str(padding[2]), "left": str(padding[3]), "isLinked": False}
    return c

def make_html(wid, html):
    return {"id": wid, "elType": "widget", "widgetType": "text-editor",
            "settings": {"editor": html}}

def make_heading(wid, text, size=52, color="#F3EFE4", weight="800", tag="h2"):
    return {"id": wid, "elType": "widget", "widgetType": "heading",
            "settings": {
                "title": text, "header_size": tag, "align": "left",
                "title_color": color,
                "typography_typography": "custom",
                "typography_font_family": "Oswald",
                "typography_font_size": {"unit": "px", "size": size},
                "typography_font_weight": weight,
                "typography_line_height": {"unit": "em", "size": 0.95},
                "typography_letter_spacing": {"unit": "px", "size": -2},
            }}

# ═══════════════════════════════════════════════════════════════════════
# BERANDA
# ═══════════════════════════════════════════════════════════════════════
print("\n[1/4] Building Beranda with images...")

hero_html = f"""
<div style="position:relative;min-height:100vh;display:flex;align-items:center;background-image:url('{IMGS["hero_bg"]}');background-size:cover;background-position:center;">
  <div style="position:absolute;inset:0;background:linear-gradient(105deg,rgba(13,19,22,0.96) 0%,rgba(13,19,22,0.85) 45%,rgba(13,19,22,0.5) 100%);"></div>
  <div style="position:relative;z-index:1;display:grid;grid-template-columns:62fr 38fr;width:100%;min-height:100vh;">

    <!-- LEFT -->
    <div style="display:flex;flex-direction:column;justify-content:center;padding:120px 60px 120px 80px;">
      <span style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#C2401C;letter-spacing:0.18em;text-transform:uppercase;border:1px solid #C2401C;padding:5px 12px;display:inline-block;margin-bottom:28px;width:fit-content;">TANGKAPAN HARI INI &middot; 04:00 WIB</span>
      <h1 style="font-family:Oswald,sans-serif;font-weight:800;font-size:clamp(2.5rem,5.5vw,4.5rem);color:#F3EFE4;line-height:0.95;letter-spacing:-0.025em;margin:0 0 28px;">Ditimbang Jam 4 Pagi, Sampai Dapur Anda Sebelum Jam Makan Siang.</h1>
      <p style="font-family:'IBM Plex Sans',sans-serif;font-size:17px;color:rgba(243,239,228,0.6);line-height:1.65;max-width:520px;margin-bottom:40px;">Bahari Segar memasok ikan, udang, cumi, kerang, dan olahan hasil laut langsung dari pelelangan ke dapur hotel dan restoran &mdash; bukan dari gudang beku berbulan-bulan.</p>
      <div style="display:flex;gap:16px;flex-wrap:wrap;align-items:center;">
        <a href="{WA}?text=Halo%20Bahari%20Segar%2C%20cek%20ketersediaan%20hari%20ini" target="_blank" rel="noopener" style="display:inline-block;background:#C2401C;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:14px;letter-spacing:0.1em;text-transform:uppercase;padding:16px 32px;text-decoration:none;">Cek Ketersediaan Hari Ini</a>
        <a href="#manifest" style="display:inline-block;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:600;font-size:14px;letter-spacing:0.08em;text-transform:uppercase;padding:16px 0;text-decoration:none;border-bottom:2px solid rgba(243,239,228,0.3);">Lihat Kategori Produk &#8595;</a>
      </div>
    </div>

    <!-- RIGHT: Tiket Manifest -->
    <div style="display:flex;align-items:center;padding:80px 60px 80px 40px;">
      <div style="border:2px dashed #2E4A4A;padding:36px 32px;position:relative;background:rgba(13,19,22,0.85);backdrop-filter:blur(8px);width:100%;">
        <div style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:28px;padding-bottom:16px;border-bottom:1px dashed #2E4A4A;">MANIFEST PENGIRIMAN &middot; BATCH #BS-TODAY</div>
        <div style="margin-bottom:24px;">
          <div style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#7A8481;letter-spacing:0.15em;text-transform:uppercase;margin-bottom:6px;">TANGKAPAN HARI INI</div>
          <div style="font-family:'IBM Plex Mono',monospace;font-size:32px;color:#F3EFE4;font-weight:500;">04:00 WIB</div>
          <div style="font-family:'IBM Plex Sans',sans-serif;font-size:12px;color:#7A8481;margin-top:4px;">Langsung dari TPI &amp; nelayan lokal</div>
        </div>
        <div style="margin-bottom:24px;">
          <div style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#7A8481;letter-spacing:0.15em;text-transform:uppercase;margin-bottom:6px;">SUHU RANTAI DINGIN</div>
          <div style="font-family:'IBM Plex Mono',monospace;font-size:32px;color:#F3EFE4;font-weight:500;">0&#8211;2&deg;C</div>
          <div style="font-family:'IBM Plex Sans',sans-serif;font-size:12px;color:#7A8481;margin-top:4px;">Es curah + box styrofoam sealed</div>
        </div>
        <div style="margin-bottom:32px;">
          <div style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#7A8481;letter-spacing:0.15em;text-transform:uppercase;margin-bottom:6px;">RADIUS KIRIM</div>
          <div style="font-family:'IBM Plex Mono',monospace;font-size:32px;color:#F3EFE4;font-weight:500;">50 KM</div>
          <div style="font-family:'IBM Plex Sans',sans-serif;font-size:12px;color:#7A8481;margin-top:4px;">Jabodetabek &amp; sekitarnya</div>
        </div>
        <div style="padding-top:20px;border-top:1px dashed #2E4A4A;">
          <div style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#7A8481;letter-spacing:0.1em;text-transform:uppercase;">ESTIMASI TIBA DI DAPUR</div>
          <div style="font-family:'IBM Plex Mono',monospace;font-size:20px;color:#C2401C;font-weight:500;margin-top:4px;">Sebelum 11:00 WIB</div>
        </div>
        <!-- Grade A badge -->
        <div style="position:absolute;top:-20px;right:24px;width:72px;height:72px;background:#C2401C;border-radius:50%;display:flex;flex-direction:column;align-items:center;justify-content:center;transform:rotate(3deg);box-shadow:0 4px 16px rgba(194,64,28,0.5);">
          <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:8px;color:#F3EFE4;letter-spacing:0.15em;text-transform:uppercase;">GRADE</div>
          <div style="font-family:Oswald,sans-serif;font-weight:900;font-size:26px;color:#F3EFE4;line-height:1;">A</div>
        </div>
      </div>
    </div>
  </div>
</div>
"""

stats_html = """
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:24px;align-items:center;padding:36px 80px;">
  <div style="text-align:center;">
    <div style="font-family:Oswald,sans-serif;font-weight:800;font-size:42px;color:#12181B;line-height:1;">50+</div>
    <div style="font-family:'IBM Plex Sans',sans-serif;font-size:11px;color:#7A8481;margin-top:6px;letter-spacing:0.08em;text-transform:uppercase;">Mitra Hotel &amp; Restoran</div>
  </div>
  <div style="text-align:center;border-left:1px solid #D0C8B8;border-right:1px solid #D0C8B8;">
    <div style="font-family:Oswald,sans-serif;font-weight:800;font-size:42px;color:#12181B;line-height:1;">2 Ton</div>
    <div style="font-family:'IBM Plex Sans',sans-serif;font-size:11px;color:#7A8481;margin-top:6px;letter-spacing:0.08em;text-transform:uppercase;">Kapasitas Suplai/Hari</div>
  </div>
  <div style="text-align:center;border-right:1px solid #D0C8B8;">
    <div style="font-family:Oswald,sans-serif;font-weight:800;font-size:42px;color:#12181B;line-height:1;">04:00</div>
    <div style="font-family:'IBM Plex Sans',sans-serif;font-size:11px;color:#7A8481;margin-top:6px;letter-spacing:0.08em;text-transform:uppercase;">Mulai Operasional WIB</div>
  </div>
  <div style="text-align:center;">
    <div style="font-family:Oswald,sans-serif;font-weight:800;font-size:42px;color:#C2401C;line-height:1;">0&#8211;2&deg;C</div>
    <div style="font-family:'IBM Plex Sans',sans-serif;font-size:11px;color:#7A8481;margin-top:6px;letter-spacing:0.08em;text-transform:uppercase;">Suhu Cold-Chain Terjaga</div>
  </div>
</div>
"""

img_strip_html = f"""
<div id="manifest" style="background:#0D1316;padding:0;">
  <div style="padding:60px 80px 40px;">
    <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:16px;">DAFTAR MANIFEST PRODUK</div>
    <h2 style="font-family:Oswald,sans-serif;font-weight:700;font-size:52px;color:#F3EFE4;line-height:0.95;letter-spacing:-0.02em;margin:0 0 40px;">Empat Kategori Pengiriman</h2>
  </div>
  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:2px;margin:0;padding:0;">
    <a href="/produk" style="display:block;position:relative;height:440px;overflow:hidden;text-decoration:none;">
      <img src="{IMGS["ikan_segar"]}" alt="Ikan Segar Bahari Segar" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;transition:transform 0.7s ease;" />
      <div style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(13,19,22,0.05) 0%,rgba(13,19,22,0.9) 100%);"></div>
      <div style="position:absolute;inset:0;display:flex;flex-direction:column;justify-content:flex-end;padding:36px 32px;">
        <div style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:12px;">01 / IKAN SEGAR</div>
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:30px;color:#F3EFE4;line-height:1;margin-bottom:10px;">Ikan Segar</div>
        <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:rgba(243,239,228,0.6);line-height:1.5;margin-bottom:18px;">Kakap, kerapu, tenggiri, bawal, tuna &mdash; dari TPI jam 4 pagi</div>
        <span style="font-family:Oswald,sans-serif;font-size:12px;color:#F3EFE4;letter-spacing:0.12em;text-transform:uppercase;border-bottom:1px solid rgba(243,239,228,0.35);padding-bottom:4px;display:inline-block;width:fit-content;">Tanya Ketersediaan &#8594;</span>
      </div>
    </a>
    <a href="/produk" style="display:block;position:relative;height:440px;overflow:hidden;text-decoration:none;">
      <img src="{IMGS["udang"]}" alt="Udang Seafood Bahari Segar" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;" />
      <div style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(13,19,22,0.05) 0%,rgba(13,19,22,0.9) 100%);"></div>
      <div style="position:absolute;inset:0;display:flex;flex-direction:column;justify-content:flex-end;padding:36px 32px;">
        <div style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#7A8481;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:12px;">02 / UDANG &amp; SEAFOOD BEKU</div>
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:30px;color:#F3EFE4;line-height:1;margin-bottom:10px;">Udang &amp; Seafood Beku</div>
        <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:rgba(243,239,228,0.6);line-height:1.5;margin-bottom:18px;">Vaname IQF, Tiger, Galah &mdash; size 16/20 hingga 61/70</div>
        <span style="font-family:Oswald,sans-serif;font-size:12px;color:#F3EFE4;letter-spacing:0.12em;text-transform:uppercase;border-bottom:1px solid rgba(243,239,228,0.35);padding-bottom:4px;display:inline-block;width:fit-content;">Tanya Ketersediaan &#8594;</span>
      </div>
    </a>
    <a href="/produk" style="display:block;position:relative;height:440px;overflow:hidden;text-decoration:none;">
      <img src="{IMGS["cumi"]}" alt="Cumi Kepiting Bahari Segar" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;" />
      <div style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(13,19,22,0.05) 0%,rgba(13,19,22,0.9) 100%);"></div>
      <div style="position:absolute;inset:0;display:flex;flex-direction:column;justify-content:flex-end;padding:36px 32px;">
        <div style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#7A8481;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:12px;">03 / CUMI, KERANG &amp; KEPITING</div>
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:30px;color:#F3EFE4;line-height:1;margin-bottom:10px;">Cumi, Kerang &amp; Kepiting</div>
        <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:rgba(243,239,228,0.6);line-height:1.5;margin-bottom:18px;">Cumi segar, kepiting bakau, kerang hijau, rajungan</div>
        <span style="font-family:Oswald,sans-serif;font-size:12px;color:#F3EFE4;letter-spacing:0.12em;text-transform:uppercase;border-bottom:1px solid rgba(243,239,228,0.35);padding-bottom:4px;display:inline-block;width:fit-content;">Tanya Ketersediaan &#8594;</span>
      </div>
    </a>
  </div>
  <div style="text-align:center;padding:48px;">
    <a href="/produk" style="display:inline-block;background:transparent;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:13px;letter-spacing:0.12em;text-transform:uppercase;padding:14px 40px;text-decoration:none;border:2px solid rgba(243,239,228,0.3);">Lihat Katalog Lengkap &#8594;</a>
  </div>
</div>
"""

zigzag_html = f"""
<div style="display:grid;grid-template-columns:1fr 1fr;min-height:560px;background:#F3EFE4;">
  <div style="position:relative;overflow:hidden;">
    <img src="{IMGS["proses"]}" alt="Proses penimbangan Bahari Segar" style="width:100%;height:100%;object-fit:cover;min-height:560px;filter:brightness(0.85) contrast(1.1);" />
  </div>
  <div style="display:flex;align-items:center;padding:80px 80px 80px 60px;">
    <div>
      <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:20px;">PROSES RANTAI SUPLAI</div>
      <h2 style="font-family:Oswald,sans-serif;font-weight:800;font-size:48px;color:#12181B;line-height:0.95;letter-spacing:-0.025em;margin:0 0 28px;">Dari Pelelangan ke Dapur Anda, Tanpa Jeda Freezer.</h2>
      <p style="font-family:'IBM Plex Sans',sans-serif;font-size:16px;color:#7A8481;line-height:1.7;margin-bottom:36px;">Tim kami tiba di TPI sebelum kapal nelayan bersandar. Setiap batch dicatat jam tangkap, berat, kondisi grading. Tidak ada yang masuk ke kendaraan tanpa lolos pemeriksaan.</p>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:40px;">
        <div style="border-top:3px solid #C2401C;padding-top:16px;">
          <div style="font-family:'IBM Plex Mono',monospace;font-size:24px;color:#C2401C;margin-bottom:6px;">03:00</div>
          <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:16px;color:#12181B;margin-bottom:4px;">Berangkat ke TPI</div>
          <div style="font-family:'IBM Plex Sans',sans-serif;font-size:12px;color:#7A8481;">Grading langsung di TPI</div>
        </div>
        <div style="border-top:3px solid #D0C8B8;padding-top:16px;">
          <div style="font-family:'IBM Plex Mono',monospace;font-size:24px;color:#12181B;margin-bottom:6px;">05:30</div>
          <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:16px;color:#12181B;margin-bottom:4px;">Pengiriman Dimulai</div>
          <div style="font-family:'IBM Plex Sans',sans-serif;font-size:12px;color:#7A8481;">Armada berpendingin 0&#8211;2&deg;C</div>
        </div>
      </div>
      <a href="/tentang-kami" style="display:inline-block;background:#12181B;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:13px;letter-spacing:0.1em;text-transform:uppercase;padding:16px 32px;text-decoration:none;">Tentang Kami &#8594;</a>
    </div>
  </div>
</div>
"""

testimonial_html = f"""
<div style="position:relative;min-height:480px;overflow:hidden;">
  <img src="{IMGS["fish_market"]}" alt="Pasar ikan Bahari Segar" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;" />
  <div style="position:absolute;inset:0;background:linear-gradient(105deg,rgba(13,19,22,0.95) 40%,rgba(13,19,22,0.5) 100%);"></div>
  <div style="position:relative;z-index:1;padding:80px;max-width:600px;">
    <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:20px;">TESTIMONI MITRA</div>
    <div style="font-family:Oswald,sans-serif;font-weight:800;font-size:64px;color:#C2401C;line-height:0.7;margin-bottom:20px;">&ldquo;</div>
    <blockquote style="font-family:Oswald,sans-serif;font-weight:700;font-size:28px;color:#F3EFE4;line-height:1.2;letter-spacing:-0.01em;margin:0 0 32px;border:none;padding:0;">Chef kami tidak perlu cek kondisi ikan setiap pagi &mdash; kami sudah tahu Bahari Segar tidak pernah kirim yang tidak layak.</blockquote>
    <div style="display:flex;align-items:center;gap:16px;">
      <div style="width:48px;height:48px;background:#C2401C;border-radius:50%;display:flex;flex-direction:column;align-items:center;justify-content:center;transform:rotate(-3deg);flex-shrink:0;">
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:7px;color:#F3EFE4;letter-spacing:0.1em;">GRADE</div>
        <div style="font-family:Oswald,sans-serif;font-weight:900;font-size:18px;color:#F3EFE4;line-height:1;">A</div>
      </div>
      <div>
        <div style="font-family:'IBM Plex Sans',sans-serif;font-weight:600;font-size:14px;color:#F3EFE4;">Executive Chef Bambang S.</div>
        <div style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#7A8481;margin-top:3px;letter-spacing:0.08em;">Hotel Bintang 5 &middot; Jakarta Selatan &middot; Mitra sejak 2021</div>
      </div>
    </div>
  </div>
</div>
"""

cta_bottom_html = f"""
<div style="background:#C2401C;padding:80px;">
  <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:40px;">
    <div>
      <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:rgba(243,239,228,0.55);letter-spacing:0.2em;text-transform:uppercase;margin-bottom:12px;">MULAI KERJASAMA HARI INI</div>
      <h2 style="font-family:Oswald,sans-serif;font-weight:800;font-size:44px;color:#F3EFE4;line-height:0.95;letter-spacing:-0.025em;margin:0;">Siap Suplai Dapur Anda<br>Besok Pagi?</h2>
    </div>
    <div style="display:flex;gap:16px;flex-wrap:wrap;">
      <a href="{WA}?text=Halo%20Bahari%20Segar%2C%20saya%20tertarik%20kerjasama" target="_blank" rel="noopener" style="display:inline-block;background:#F3EFE4;color:#C2401C;font-family:Oswald,sans-serif;font-weight:700;font-size:14px;letter-spacing:0.08em;text-transform:uppercase;padding:18px 36px;text-decoration:none;">Chat WhatsApp Sekarang</a>
      <a href="/kerjasama-b2b" style="display:inline-block;background:transparent;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:14px;letter-spacing:0.08em;text-transform:uppercase;padding:18px 36px;text-decoration:none;border:2px solid rgba(243,239,228,0.4);">Isi Form Kerjasama</a>
    </div>
  </div>
</div>
"""

beranda_data = [
    make_section("bs-hero-s", elements=[make_col("bs-hero-c", 100, elements=[make_html("bs-hero-w", hero_html)])]),
    make_section("bs-stats-s", bg_color="#F3EFE4", padding=[0,0,0,0], elements=[make_col("bs-stats-c", 100, elements=[make_html("bs-stats-w", stats_html)])]),
    make_section("bs-strip-s", bg_color="#0D1316", padding=[0,0,0,0], elements=[make_col("bs-strip-c", 100, elements=[make_html("bs-strip-w", img_strip_html)])]),
    make_section("bs-zig-s", bg_color="#F3EFE4", padding=[0,0,0,0], elements=[make_col("bs-zig-c", 100, elements=[make_html("bs-zig-w", zigzag_html)])]),
    make_section("bs-testi-s", bg_color="#0D1316", padding=[0,0,0,0], elements=[make_col("bs-testi-c", 100, elements=[make_html("bs-testi-w", testimonial_html)])]),
    make_section("bs-cta-s", bg_color="#C2401C", padding=[0,0,0,0], elements=[make_col("bs-cta-c", 100, elements=[make_html("bs-cta-w", cta_bottom_html)])]),
]

beranda_json = json.dumps(beranda_data, ensure_ascii=False)
set_meta(IDS["beranda"], "_elementor_data", beranda_json)
set_meta(IDS["beranda"], "_elementor_edit_mode", "builder")
set_meta(IDS["beranda"], "_wp_page_template", "elementor_canvas")
print(f"  OK Beranda updated ({len(beranda_json)} chars)")

# ═══════════════════════════════════════════════════════════════════════
# TENTANG KAMI
# ═══════════════════════════════════════════════════════════════════════
print("\n[2/4] Building Tentang Kami...")

tentang_hero_html = f"""
<div style="position:relative;min-height:600px;overflow:hidden;">
  <img src="{IMGS["tentang_bg"]}" alt="Tentang Bahari Segar" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;filter:brightness(0.7);" />
  <div style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(13,19,22,0.3) 0%,rgba(13,19,22,0.97) 70%);"></div>
  <div style="position:relative;z-index:1;min-height:600px;display:flex;flex-direction:column;justify-content:flex-end;padding:60px 80px 80px;">
    <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:16px;">TENTANG KAMI</div>
    <h1 style="font-family:Oswald,sans-serif;font-weight:800;font-size:clamp(2.5rem,6vw,5rem);color:#F3EFE4;line-height:0.95;letter-spacing:-0.025em;margin:0 0 24px;max-width:800px;">Bukan Sekadar Suplier.<br>Kami Bagian dari Dapur Anda.</h1>
    <p style="font-family:'IBM Plex Sans',sans-serif;font-size:17px;color:rgba(243,239,228,0.55);max-width:580px;line-height:1.65;margin:0;">Bahari Segar berdiri dari satu keresahan: sulit mendapat pasokan seafood segar yang konsisten dan terdokumentasi.</p>
  </div>
</div>
"""

tentang_body_html = f"""
<div style="background:#12181B;padding:100px 80px;">
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:start;">
    <!-- Kiri: Teks -->
    <div>
      <p style="font-family:'IBM Plex Sans',sans-serif;font-size:18px;color:#F3EFE4;line-height:1.75;margin-bottom:28px;">Kami membangun hubungan langsung dengan nelayan dan TPI. Setiap batch yang kami ambil dicatat: jam tangkap, berat, ukuran, kondisi saat grading. Tidak ada yang masuk ke kendaraan tanpa lolos pemeriksaan tim kami.</p>
      <p style="font-family:'IBM Plex Sans',sans-serif;font-size:16px;color:#7A8481;line-height:1.75;margin-bottom:48px;">Mitra kami &mdash; chef di hotel bintang lima hingga restoran seafood independen &mdash; tidak perlu khawatir soal kualitas. Mereka tahu, sebelum jam 11 pagi, produk kami sudah di tangan mereka.</p>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:1px;background:#1E2A2A;">
        <div style="background:#0D1316;padding:32px 28px;">
          <div style="font-family:'IBM Plex Mono',monospace;font-size:36px;color:#C2401C;margin-bottom:8px;">2018</div>
          <div style="font-family:'IBM Plex Sans',sans-serif;font-size:11px;color:#7A8481;text-transform:uppercase;letter-spacing:0.08em;">Berdiri sejak</div>
        </div>
        <div style="background:#0D1316;padding:32px 28px;">
          <div style="font-family:'IBM Plex Mono',monospace;font-size:36px;color:#F3EFE4;margin-bottom:8px;">50+</div>
          <div style="font-family:'IBM Plex Sans',sans-serif;font-size:11px;color:#7A8481;text-transform:uppercase;letter-spacing:0.08em;">Mitra aktif</div>
        </div>
        <div style="background:#0D1316;padding:32px 28px;">
          <div style="font-family:'IBM Plex Mono',monospace;font-size:36px;color:#F3EFE4;margin-bottom:8px;">2 Ton</div>
          <div style="font-family:'IBM Plex Sans',sans-serif;font-size:11px;color:#7A8481;text-transform:uppercase;letter-spacing:0.08em;">Kapasitas/hari</div>
        </div>
        <div style="background:#0D1316;padding:32px 28px;">
          <div style="font-family:'IBM Plex Mono',monospace;font-size:36px;color:#C2401C;margin-bottom:8px;">03:00</div>
          <div style="font-family:'IBM Plex Sans',sans-serif;font-size:11px;color:#7A8481;text-transform:uppercase;letter-spacing:0.08em;">Mulai operasi</div>
        </div>
      </div>
    </div>
    <!-- Kanan: Gambar -->
    <div style="position:relative;">
      <img src="{IMGS["cold_chain"]}" alt="Cold chain Bahari Segar" style="width:100%;height:500px;object-fit:cover;display:block;" />
      <div style="position:absolute;bottom:0;left:0;right:0;background:linear-gradient(180deg,transparent,rgba(13,19,22,0.85));padding:28px 24px;">
        <div style="font-family:'IBM Plex Mono',monospace;font-size:10px;color:#C2401C;letter-spacing:0.15em;text-transform:uppercase;margin-bottom:6px;">COLD CHAIN TERJAGA</div>
        <div style="font-family:'IBM Plex Mono',monospace;font-size:18px;color:#F3EFE4;">0&#8211;2&deg;C dari TPI ke dapur Anda</div>
      </div>
      <div style="position:absolute;top:20px;right:20px;width:68px;height:68px;background:#C2401C;border-radius:50%;display:flex;flex-direction:column;align-items:center;justify-content:center;transform:rotate(3deg);">
        <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:7px;color:#F3EFE4;letter-spacing:0.12em;">GRADE</div>
        <div style="font-family:Oswald,sans-serif;font-weight:900;font-size:24px;color:#F3EFE4;line-height:1;">A</div>
      </div>
    </div>
  </div>
</div>
"""

tentang_cta_html = f"""
<div style="background:#C2401C;padding:80px;">
  <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:32px;">
    <div>
      <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:rgba(243,239,228,0.55);letter-spacing:0.2em;text-transform:uppercase;margin-bottom:12px;">MULAI KERJASAMA</div>
      <h2 style="font-family:Oswald,sans-serif;font-weight:800;font-size:40px;color:#F3EFE4;line-height:1;margin:0;">Jadi Mitra Bahari Segar</h2>
    </div>
    <div style="display:flex;gap:16px;">
      <a href="{WA}?text=Halo%20Bahari%20Segar%2C%20saya%20ingin%20jadi%20mitra" target="_blank" rel="noopener" style="display:inline-block;background:#F3EFE4;color:#C2401C;font-family:Oswald,sans-serif;font-weight:700;font-size:13px;letter-spacing:0.08em;text-transform:uppercase;padding:16px 32px;text-decoration:none;">Chat WhatsApp &#8594;</a>
      <a href="/kerjasama-b2b" style="display:inline-block;background:transparent;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:13px;letter-spacing:0.08em;text-transform:uppercase;padding:16px 32px;text-decoration:none;border:2px solid rgba(243,239,228,0.4);">Form Kerjasama</a>
    </div>
  </div>
</div>
"""

tentang_data = [
    make_section("ta-hero", bg_color="#0D1316", padding=[0,0,0,0], elements=[make_col("ta-hero-c", 100, elements=[make_html("ta-hero-w", tentang_hero_html)])]),
    make_section("ta-body", bg_color="#12181B", padding=[0,0,0,0], elements=[make_col("ta-body-c", 100, elements=[make_html("ta-body-w", tentang_body_html)])]),
    make_section("ta-cta", bg_color="#C2401C", padding=[0,0,0,0], elements=[make_col("ta-cta-c", 100, elements=[make_html("ta-cta-w", tentang_cta_html)])]),
]

tentang_json = json.dumps(tentang_data, ensure_ascii=False)
set_meta(IDS["tentang"], "_elementor_data", tentang_json)
set_meta(IDS["tentang"], "_elementor_edit_mode", "builder")
set_meta(IDS["tentang"], "_wp_page_template", "elementor_canvas")
print(f"  OK Tentang Kami updated ({len(tentang_json)} chars)")

# ═══════════════════════════════════════════════════════════════════════
# PRODUK
# ═══════════════════════════════════════════════════════════════════════
print("\n[3/4] Building Produk page...")

produk_hero_html = f"""
<div style="position:relative;min-height:500px;overflow:hidden;">
  <img src="{IMGS["ikan_segar"]}" alt="Katalog Produk Bahari Segar" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;filter:brightness(0.75);" />
  <div style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(13,19,22,0.2) 0%,rgba(13,19,22,0.97) 70%);"></div>
  <div style="position:relative;z-index:1;min-height:500px;display:flex;flex-direction:column;justify-content:flex-end;padding:60px 80px 70px;">
    <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:16px;">KATALOG PRODUK</div>
    <h1 style="font-family:Oswald,sans-serif;font-weight:800;font-size:clamp(2.5rem,6vw,5rem);color:#F3EFE4;line-height:0.95;letter-spacing:-0.025em;margin:0 0 20px;">Ikan Segar, Udang, Cumi<br>&amp; Olahan Hasil Laut.</h1>
    <p style="font-family:'IBM Plex Sans',sans-serif;font-size:16px;color:rgba(243,239,228,0.55);max-width:520px;line-height:1.65;margin:0;">Semua dipilih langsung dari TPI jam 4 pagi. Harga grosir untuk hotel dan restoran.</p>
  </div>
</div>
"""

cat_ikan_html = f"""
<div style="background:#12181B;padding:80px;">
  <div style="display:flex;align-items:baseline;gap:20px;margin-bottom:40px;padding-bottom:24px;border-bottom:1px solid #1E2A2A;">
    <span style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#C2401C;letter-spacing:0.2em;text-transform:uppercase;">01</span>
    <h2 style="font-family:Oswald,sans-serif;font-weight:700;font-size:40px;color:#F3EFE4;line-height:1;margin:0;">Ikan Segar</h2>
    <span style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#7A8481;letter-spacing:0.1em;text-transform:uppercase;margin-left:auto;">Tersedia sepanjang tahun</span>
  </div>
  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:2px;margin-bottom:2px;">
    <div style="background:#0D1316;padding:32px 28px;border-top:3px solid #C2401C;">
      <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:22px;color:#F3EFE4;margin-bottom:12px;">Kakap Merah</div>
      <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:#7A8481;line-height:1.6;margin-bottom:20px;">Grade A: sisik utuh, mata jernih, insang merah cerah. Ukuran 300g&ndash;2kg/ekor. Kemasan es curah &amp; box styrofoam.</div>
      <a href="{WA}?text=Tanya%20stok%20Kakap%20Merah" target="_blank" style="display:inline-block;background:#C2401C;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:11px;letter-spacing:0.1em;text-transform:uppercase;padding:10px 20px;text-decoration:none;">Tanya Ketersediaan</a>
    </div>
    <div style="background:#0D1316;padding:32px 28px;border-top:3px solid #2E4A4A;">
      <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:22px;color:#F3EFE4;margin-bottom:12px;">Kerapu Segar</div>
      <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:#7A8481;line-height:1.6;margin-bottom:20px;">Kerapu macan, tikus, bebek. Kualitas ekspor, 400g&ndash;3kg/ekor. Ketersediaan musiman &mdash; konfirmasi stok.</div>
      <a href="{WA}?text=Tanya%20stok%20Kerapu" target="_blank" style="display:inline-block;background:transparent;color:#C2401C;font-family:Oswald,sans-serif;font-weight:700;font-size:11px;letter-spacing:0.1em;text-transform:uppercase;padding:10px 20px;text-decoration:none;border:1px solid #C2401C;">Tanya Ketersediaan</a>
    </div>
    <div style="background:#0D1316;padding:32px 28px;border-top:3px solid #2E4A4A;">
      <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:22px;color:#F3EFE4;margin-bottom:12px;">Tuna Segar</div>
      <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:#7A8481;line-height:1.6;margin-bottom:20px;">Utuh dan loin siap olah. Grading standar ekspor Jepang. 2&ndash;30kg/ekor.</div>
      <a href="{WA}?text=Tanya%20stok%20Tuna" target="_blank" style="display:inline-block;background:transparent;color:#C2401C;font-family:Oswald,sans-serif;font-weight:700;font-size:11px;letter-spacing:0.1em;text-transform:uppercase;padding:10px 20px;text-decoration:none;border:1px solid #C2401C;">Tanya Ketersediaan</a>
    </div>
  </div>
  <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:2px;">
    <div style="background:#0D1316;padding:32px 28px;border-top:3px solid #2E4A4A;">
      <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:22px;color:#F3EFE4;margin-bottom:12px;">Tenggiri Segar</div>
      <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:#7A8481;line-height:1.6;margin-bottom:20px;">Ideal untuk ikan bakar, pepes, dapur hotel. 500g&ndash;4kg/ekor.</div>
      <a href="{WA}?text=Tanya%20stok%20Tenggiri" target="_blank" style="display:inline-block;background:transparent;color:#C2401C;font-family:Oswald,sans-serif;font-weight:700;font-size:11px;letter-spacing:0.1em;text-transform:uppercase;padding:10px 20px;text-decoration:none;border:1px solid #C2401C;">Tanya Ketersediaan</a>
    </div>
    <div style="background:#0D1316;padding:32px 28px;border-top:3px solid #2E4A4A;">
      <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:22px;color:#F3EFE4;margin-bottom:12px;">Bawal Segar</div>
      <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:#7A8481;line-height:1.6;margin-bottom:20px;">Bawal putih &amp; hitam. 200g&ndash;1kg/ekor. Populer untuk Chinese restaurant.</div>
      <a href="{WA}?text=Tanya%20stok%20Bawal" target="_blank" style="display:inline-block;background:transparent;color:#C2401C;font-family:Oswald,sans-serif;font-weight:700;font-size:11px;letter-spacing:0.1em;text-transform:uppercase;padding:10px 20px;text-decoration:none;border:1px solid #C2401C;">Tanya Ketersediaan</a>
    </div>
  </div>
</div>
"""

cat_udang_html = f"""
<div style="background:#0D1316;padding:80px;">
  <div style="display:flex;align-items:baseline;gap:20px;margin-bottom:40px;padding-bottom:24px;border-bottom:1px solid #1E2A2A;">
    <span style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#7A8481;letter-spacing:0.2em;text-transform:uppercase;">02</span>
    <h2 style="font-family:Oswald,sans-serif;font-weight:700;font-size:40px;color:#F3EFE4;line-height:1;margin:0;">Udang &amp; Seafood Beku</h2>
    <span style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#7A8481;letter-spacing:0.1em;text-transform:uppercase;margin-left:auto;">Stok sepanjang tahun</span>
  </div>
  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:2px;">
    <div style="background:#12181B;padding:32px 28px;border-top:3px solid #C2401C;">
      <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:22px;color:#F3EFE4;margin-bottom:12px;">Udang Vaname IQF</div>
      <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:#7A8481;line-height:1.6;margin-bottom:20px;">Size 16/20 hingga 61/70. Head-on, headless, P&amp;D. Stok terlengkap. Kemasan vakum 1kg &amp; 5kg.</div>
      <a href="{WA}?text=Tanya%20stok%20Udang%20Vaname%20IQF" target="_blank" style="display:inline-block;background:#C2401C;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:11px;letter-spacing:0.1em;text-transform:uppercase;padding:10px 20px;text-decoration:none;">Tanya Ketersediaan</a>
    </div>
    <div style="background:#12181B;padding:32px 28px;border-top:3px solid #2E4A4A;">
      <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:22px;color:#F3EFE4;margin-bottom:12px;">Udang Tiger / Windu</div>
      <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:#7A8481;line-height:1.6;margin-bottom:20px;">Premium jumbo, U5&ndash;U12. Head-on segar dan beku IQF. Musiman &mdash; konfirmasi stok.</div>
      <a href="{WA}?text=Tanya%20stok%20Udang%20Tiger" target="_blank" style="display:inline-block;background:transparent;color:#C2401C;font-family:Oswald,sans-serif;font-weight:700;font-size:11px;letter-spacing:0.1em;text-transform:uppercase;padding:10px 20px;text-decoration:none;border:1px solid #C2401C;">Tanya Ketersediaan</a>
    </div>
    <div style="background:#12181B;padding:32px 28px;border-top:3px solid #2E4A4A;">
      <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:22px;color:#F3EFE4;margin-bottom:12px;">Udang Galah</div>
      <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:#7A8481;line-height:1.6;margin-bottom:20px;">Air tawar segar dari tambak lokal. 100&ndash;400g/ekor. Musiman &mdash; konfirmasi stok.</div>
      <a href="{WA}?text=Tanya%20stok%20Udang%20Galah" target="_blank" style="display:inline-block;background:transparent;color:#C2401C;font-family:Oswald,sans-serif;font-weight:700;font-size:11px;letter-spacing:0.1em;text-transform:uppercase;padding:10px 20px;text-decoration:none;border:1px solid #C2401C;">Tanya Ketersediaan</a>
    </div>
  </div>
</div>
"""

cat_rest_html = f"""
<div style="background:#12181B;padding:80px;">
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:64px;">
    <!-- Cumi, Kerang, Kepiting -->
    <div>
      <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#7A8481;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:12px;">03</div>
      <h2 style="font-family:Oswald,sans-serif;font-weight:700;font-size:36px;color:#F3EFE4;line-height:1;margin:0 0 32px;">Cumi, Kerang &amp; Kepiting</h2>
      <div style="display:flex;flex-direction:column;gap:2px;">
        <div style="background:#0D1316;padding:24px;border-left:3px solid #C2401C;">
          <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:18px;color:#F3EFE4;margin-bottom:8px;">Cumi-Cumi Segar</div>
          <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:#7A8481;margin-bottom:12px;">100&ndash;500g/ekor. Whole &amp; cleaned. Puncak April&ndash;September.</div>
          <a href="{WA}?text=Tanya%20stok%20Cumi" target="_blank" style="font-family:Oswald,sans-serif;font-size:11px;color:#C2401C;letter-spacing:0.1em;text-transform:uppercase;text-decoration:none;">Tanya Ketersediaan &#8594;</a>
        </div>
        <div style="background:#0D1316;padding:24px;">
          <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:18px;color:#F3EFE4;margin-bottom:8px;">Kepiting Bakau</div>
          <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:#7A8481;margin-bottom:12px;">300&ndash;800g/ekor. Jantan &amp; betina. Diikat, box + es.</div>
          <a href="{WA}?text=Tanya%20stok%20Kepiting%20Bakau" target="_blank" style="font-family:Oswald,sans-serif;font-size:11px;color:#C2401C;letter-spacing:0.1em;text-transform:uppercase;text-decoration:none;">Tanya Ketersediaan &#8594;</a>
        </div>
        <div style="background:#0D1316;padding:24px;">
          <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:18px;color:#F3EFE4;margin-bottom:8px;">Kerang Hijau &amp; Rajungan</div>
          <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:#7A8481;margin-bottom:12px;">Kerang hijau in-shell. Rajungan 100&ndash;300g/ekor.</div>
          <a href="{WA}?text=Tanya%20stok%20Kerang%20Rajungan" target="_blank" style="font-family:Oswald,sans-serif;font-size:11px;color:#C2401C;letter-spacing:0.1em;text-transform:uppercase;text-decoration:none;">Tanya Ketersediaan &#8594;</a>
        </div>
      </div>
    </div>
    <!-- Olahan -->
    <div>
      <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:#7A8481;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:12px;">04</div>
      <h2 style="font-family:Oswald,sans-serif;font-weight:700;font-size:36px;color:#F3EFE4;line-height:1;margin:0 0 32px;">Olahan Hasil Laut</h2>
      <div style="display:flex;flex-direction:column;gap:2px;">
        <div style="background:#0D1316;padding:24px;">
          <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:18px;color:#F3EFE4;margin-bottom:8px;">Ikan Asin Kering</div>
          <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:#7A8481;margin-bottom:12px;">Teri nasi, gabus, jambal roti, layur. Vakum 500g &amp; 1kg.</div>
          <a href="{WA}?text=Tanya%20stok%20Ikan%20Asin" target="_blank" style="font-family:Oswald,sans-serif;font-size:11px;color:#C2401C;letter-spacing:0.1em;text-transform:uppercase;text-decoration:none;">Tanya Ketersediaan &#8594;</a>
        </div>
        <div style="background:#0D1316;padding:24px;">
          <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:18px;color:#F3EFE4;margin-bottom:8px;">Ebi &amp; Terasi Premium</div>
          <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:#7A8481;margin-bottom:12px;">Grade A, vakum 250g &amp; 500g. Dari produsen lokal.</div>
          <a href="{WA}?text=Tanya%20stok%20Ebi%20Terasi" target="_blank" style="font-family:Oswald,sans-serif;font-size:11px;color:#C2401C;letter-spacing:0.1em;text-transform:uppercase;text-decoration:none;">Tanya Ketersediaan &#8594;</a>
        </div>
        <div style="background:#0D1316;padding:24px;border-left:3px solid #C2401C;">
          <div style="font-family:Oswald,sans-serif;font-weight:700;font-size:18px;color:#F3EFE4;margin-bottom:8px;">Pempek &amp; Otak-Otak</div>
          <div style="font-family:'IBM Plex Sans',sans-serif;font-size:13px;color:#7A8481;margin-bottom:12px;">Tanpa pengawet, dari tenggiri segar. Order H-2.</div>
          <a href="{WA}?text=Tanya%20stok%20Pempek%20Otak-otak" target="_blank" style="font-family:Oswald,sans-serif;font-size:11px;color:#C2401C;letter-spacing:0.1em;text-transform:uppercase;text-decoration:none;">Tanya Ketersediaan &#8594;</a>
        </div>
      </div>
    </div>
  </div>
</div>
"""

produk_cta_html = f"""
<div style="background:#C2401C;padding:60px 80px;">
  <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:32px;">
    <div>
      <div style="font-family:'IBM Plex Mono',monospace;font-size:11px;color:rgba(243,239,228,0.55);letter-spacing:0.2em;text-transform:uppercase;margin-bottom:8px;">HARGA GROSIR B2B</div>
      <h2 style="font-family:Oswald,sans-serif;font-weight:800;font-size:36px;color:#F3EFE4;line-height:1;margin:0;">Hubungi Kami untuk Penawaran Harga Volume</h2>
    </div>
    <div style="display:flex;gap:16px;flex-wrap:wrap;">
      <a href="{WA}?text=Halo%20Bahari%20Segar%2C%20saya%20ingin%20harga%20grosir" target="_blank" rel="noopener" style="display:inline-block;background:#F3EFE4;color:#C2401C;font-family:Oswald,sans-serif;font-weight:700;font-size:13px;letter-spacing:0.08em;text-transform:uppercase;padding:16px 32px;text-decoration:none;">Chat WhatsApp &#8594;</a>
      <a href="/kerjasama-b2b" style="display:inline-block;background:transparent;color:#F3EFE4;font-family:Oswald,sans-serif;font-weight:700;font-size:13px;letter-spacing:0.08em;text-transform:uppercase;padding:16px 32px;text-decoration:none;border:2px solid rgba(243,239,228,0.4);">Ajukan Kerjasama</a>
    </div>
  </div>
</div>
"""

produk_data = [
    make_section("pr-hero", bg_color="#0D1316", padding=[0,0,0,0], elements=[make_col("pr-hero-c", 100, elements=[make_html("pr-hero-w", produk_hero_html)])]),
    make_section("pr-cat1", bg_color="#12181B", padding=[0,0,0,0], elements=[make_col("pr-cat1-c", 100, elements=[make_html("pr-cat1-w", cat_ikan_html)])]),
    make_section("pr-cat2", bg_color="#0D1316", padding=[0,0,0,0], elements=[make_col("pr-cat2-c", 100, elements=[make_html("pr-cat2-w", cat_udang_html)])]),
    make_section("pr-cat34", bg_color="#12181B", padding=[0,0,0,0], elements=[make_col("pr-cat34-c", 100, elements=[make_html("pr-cat34-w", cat_rest_html)])]),
    make_section("pr-cta", bg_color="#C2401C", padding=[0,0,0,0], elements=[make_col("pr-cta-c", 100, elements=[make_html("pr-cta-w", produk_cta_html)])]),
]

produk_json = json.dumps(produk_data, ensure_ascii=False)
set_meta(IDS["produk"], "_elementor_data", produk_json)
set_meta(IDS["produk"], "_elementor_edit_mode", "builder")
set_meta(IDS["produk"], "_wp_page_template", "elementor_canvas")
# Remove WooCommerce shop page
cur.execute("DELETE FROM wp_options WHERE option_name='woocommerce_shop_page_id'")
print(f"  OK Produk updated ({len(produk_json)} chars)")

# ═══════════════════════════════════════════════════════════════════════
# CLEAR CACHE
# ═══════════════════════════════════════════════════════════════════════
print("\n[4/4] Clearing caches...")
cur.execute("DELETE FROM wp_options WHERE option_name LIKE '_elementor_css_%'")
cur.execute("DELETE FROM wp_options WHERE option_name LIKE '_transient_elementor%'")
cur.execute("DELETE FROM wp_options WHERE option_name LIKE '_transient_timeout_elementor%'")
cur.execute("DELETE FROM wp_options WHERE option_name LIKE '_transient_wp_theme%'")
conn.commit()
conn.close()

print("\n" + "="*60)
print("  DONE: Images injected to all pages!")
print("  Beranda    : http://localhost/wordpress/")
print("  Tentang    : http://localhost/wordpress/tentang-kami/")
print("  Produk     : http://localhost/wordpress/produk/")
print("="*60 + "\n")
