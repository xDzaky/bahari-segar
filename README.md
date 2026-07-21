# Bahari Segar — Automated WordPress Build & Theme Generator

Project otomatisasi pembuatan dan konfigurasi website **Bahari Segar** (Supplier & Distributor Seafood B2B untuk Hotel, Restoran, dan Catering) berbasis WordPress, Elementor, dan WooCommerce.

---

## 📋 Fitur Utama
- **Automated DB & Data Injection**: Script PHP & Python untuk menginjeksi halaman Elementor, produk WooCommerce, form B2B (WPForms), dan konfigurasi site otomatis.
- **Image-Driven Design**: Halaman disesuaikan dengan standar desain visual tinggi berbasis fotografi dokumenter perairan & pelelangan ikan.
- **Astra Child Theme**: Kustomisasi CSS global (`style.css`), perbaikan typography, dan dukungan full-bleed canvas.
- **Permalink & Rewrite Automated Setup**: Konfigurasi otomatis `.htaccess` dan rewrite rules WordPress.

---

## 🛠 Struktur Repository

```text
.
├── 01-setup-site.php         # Konfigurasi dasar site title, tagline, & plugin
├── 02-create-pages.php       # Pembuatan halaman utama (Beranda, Tentang, Produk, B2B, Kontak)
├── 03-inject-elementor.php   # Injeksi data awal Elementor untuk halaman utama
├── 04-create-products.php    # Pembuatan 14 produk WooCommerce + 4 kategori
├── 05-inject-css.php         # Injeksi Custom CSS global & styling Astra Child Theme
├── 06-finalize.php           # Setup form B2B (WPForms), Yoast SEO, & rewrite rules
├── 07-inject-images.py       # Python script untuk injeksi foto dokumenter Unsplash ke Elementor
├── 07b-inject-images-nowdoc.php # PHP NOWDOC script untuk injeksi data visual tanpa escaping issue
├── run-all.sh                # Master script pembangun otomatis seluruh environment
├── page_ids.json             # Map ID halaman WordPress hasil eksekusi
└── theme/                    # Source code Astra Child Theme
    ├── style.css             # Custom styling Bahari Segar (Typography, Badges, Tables, Responsive)
    └── functions.php         # Theme setup & script/style enqueuing
```

---

## 🚀 Cara Penggunaan

1. Pastikan environment lokal WordPress (Apache/Nginx, MySQL/MariaDB, PHP) sudah aktif.
2. Edit kredensial DB pada script pembangun jika berbeda (Default: `root` / `gggaming21` / `db_wordpress`).
3. Jalankan master script pembangun:
   ```bash
   bash run-all.sh
   ```
4. Jalankan injeksi visual image-driven:
   ```bash
   php 07b-inject-images-nowdoc.php
   ```

---

## 🎨 Halaman Website

- **Beranda (`/`)**: Hero section full-bleed foto pelelangan ikan 04:00 WIB, Tiket Manifest Pengiriman, Stats Bar, 3-Column Image Strip, Zigzag Rantai Suplai, dan Testimonial.
- **Tentang Kami (`/tentang-kami/`)**: Cerita pendirian, prinsip transparansi, dan dokumentasi cold-chain.
- **Katalog Produk (`/produk/`)**: Listing produk grosir Ikan Segar, Udang, Cumi, dan Olahan Seafood.
- **Kerjasama B2B (`/kerjasama-b2b/`)**: Form pengajuan kemitraan restoran/hotel.
- **Kontak (`/kontak/`)**: Informasi operasional, lokasi, dan Kontak WhatsApp.
