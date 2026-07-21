# Bahari Segar — Design Fix & Consistency Audit
### Patch untuk `07b-inject-images-nowdoc.php` (dan turunannya) — tempel ke Codex CLI

---

## 1. Diagnosis

Semua gambar di `$IMGS` (dalam `07b-inject-images-nowdoc.php`) adalah **Unsplash photo ID yang diketik manual/ditebak**, bukan hasil pencarian yang diverifikasi. Photo ID Unsplash itu hash acak — gak bisa ditebak dari nama query, harus dicari lewat API dan diverifikasi URL-nya beneran menampilkan apa. Ini yang bikin sebagian foto nyasar total:

| Key | Dipakai di | Harusnya | Yang muncul sekarang |
|---|---|---|---|
| `cold` | Tentang Kami — box cold chain | gudang dingin / es / box seafood | **foto sapi di padang rumput** |
| `proses` | Beranda — section "Proses Rantai Suplai" | proses timbang/grading di TPI | **grafis tag "SALE" merah**, gak nyambung sama sekali |
| `cumi` | Beranda — kartu Cumi/Kerang/Kepiting | foto cumi/kerang/kepiting | **broken image** (URL mati/gak valid) |
| `ikan` | Beranda + hero halaman Produk (dipakai 2x, sama persis) | ikan segar mentah di atas es | foto piring sashimi jadi — bukan raw catch |

`market` dan `tentang` kemungkinan aman tapi perlu dicek manual di browser sebelum publish (overlay gelapnya terlalu pekat buat dipastikan dari screenshot).

**Masalah kedua:** warna surface terang yang jalan sekarang (`#F3EFE4`) nyaris identik sama pola default "krem hangat + aksen terracotta" yang justru mau kita hindari sejak brief pertama — itu jadi salah satu ciri paling gampang dikenali sebagai output AI generic.

**Masalah ketiga:** kartu produk di halaman Produk (Kakap Merah, Kerapu, Tuna, Tenggiri, Bawal) sama sekali belum ada foto — cuma teks. Motif "Stempel Kesegaran" yang jadi signature element brief pertama belum kepakai di sini.

---

## 2. Token Spec — FINAL (dikunci, bukan diganti lagi)

Font & warna dasar yang sudah jalan di 5 halaman **sudah bagus dan konsisten** — jangan diubah, cukup dikunci sebagai spec resmi:

```
Display   : Oswald (700/800) — kondensasi tegas, cocok nuansa manifest/industrial
Body      : IBM Plex Sans (400)
Data/angka: IBM Plex Mono (400/500)

--surface-dark   : #0D1316 / #12181B   (gelap, sudah bagus)
--accent         : #C2401C             (merah-bata, sudah bagus, JANGAN diganti ke terracotta generik)

--surface-light  : #F3EFE4  →  GANTI KE  #E7E9E1   ← satu-satunya perubahan warna
  (abu-hijau pucat, kesan es/beton basah — bukan krem hangat generik)
```

Cari-ganti `#F3EFE4` di seluruh file (`07b-inject-images-nowdoc.php`, `theme/style.css`, dan file CSS lain di `theme/`) jadi `#E7E9E1`.

---

## 3. Perbaikan Gambar — pakai Unsplash API asli, bukan tebak ID

**Jangan** pakai `source.unsplash.com` — layanan itu sudah resmi dimatikan Unsplash sejak Juni 2024, gak akan jalan.

Pakai Unsplash API biasa (`api.unsplash.com/search/photos`) dengan Access Key gratis (daftar di unsplash.com/developers, langsung aktif, limit 50 request/jam mode demo — cukup buat ±13 gambar). Ini memastikan hasil foto **diverifikasi lewat search**, bukan ditebak dari memori.

```python
import requests

UNSPLASH_ACCESS_KEY = "ISI_ACCESS_KEY_DI_SINI"

def get_verified_image(query, orientation="landscape"):
    r = requests.get(
        "https://api.unsplash.com/search/photos",
        params={"query": query, "per_page": 1, "orientation": orientation},
        headers={"Authorization": f"Client-ID {UNSPLASH_ACCESS_KEY}"},
    )
    r.raise_for_status()
    results = r.json()["results"]
    if not results:
        raise ValueError(f"Gak ada hasil untuk query: {query}")
    return results[0]["urls"]["regular"], results[0]["links"]["html"]  # url + link buat verifikasi manual
```

### Query pengganti per slot yang salah:

| Key | Query pencarian (English lebih akurat di Unsplash) |
|---|---|
| `hero` | `"fish market dawn ice crates"` |
| `ikan` | `"fresh whole fish market ice"` *(ganti dari foto sashimi — ini raw catch, bukan hidangan jadi)* |
| `proses` | `"fish grading weighing scale worker"` |
| `cold` | `"cold storage seafood ice boxes"` |
| `cumi` | `"fresh squid crab seafood market"` |

Untuk `market` dan `tentang`: buka dulu URL yang ada sekarang di browser, kalau memang gak relevan pakai query `"fish market vendor"` dan `"fisherman boat dock morning"`.

### Tambahan baru — foto per jenis ikan di halaman Produk:

| Kartu | Query |
|---|---|
| Kakap Merah | `"red snapper fish fresh"` |
| Kerapu Segar | `"grouper fish market fresh"` |
| Tuna Segar | `"fresh tuna fish whole"` |
| Tenggiri Segar | `"spanish mackerel fish fresh"` |
| Bawal Segar | `"pomfret fish fresh"` |

Tambahkan `<img>` kecil (rasio 4:5, filter `brightness(0.9)`) di tiap kartu `pr_ikan_html`, plus badge lingkaran "GRADE A" pojok kanan atas seperti yang sudah dipakai di hero & Tentang Kami — biar konsisten sama motif Stempel Kesegaran di seluruh situs.

**Penting:** setiap URL hasil `get_verified_image()` harus dibuka manual sekali di browser sebelum dipakai final — API search bisa salah juga kalau query ambigu, jadi tetap perlu cek visual terakhir, bukan percaya buta ke hasil pertama.

---

## 4. Prompt siap tempel ke Codex CLI

```
Perbaiki repo bahari-segar (WordPress lokal, Elementor) sesuai temuan berikut:

1. WARNA: cari-ganti semua kemunculan #F3EFE4 menjadi #E7E9E1 di 
   07b-inject-images-nowdoc.php, theme/style.css, dan file CSS lain di theme/.
   Jangan ubah warna lain (#0D1316, #12181B, #C2401C sudah final).

2. GAMBAR SALAH: di array $IMGS dalam 07b-inject-images-nowdoc.php, 4 URL ini 
   nyasar dari tema (sapi, tag SALE, broken link, foto salah konteks):
   - cold, proses, cumi, ikan
   
   Jangan tebak ulang Unsplash photo ID secara manual. Sebagai gantinya:
   a. Daftar Unsplash API Access Key gratis di unsplash.com/developers
   b. Buat/lengkapi 07-inject-images.py untuk fetch gambar via 
      GET https://api.unsplash.com/search/photos dengan query per key 
      sesuai tabel di bagian 3 dokumen ini
   c. Sebelum dipakai, buka tiap URL hasil fetch di browser dan pastikan 
      isinya benar-benar sesuai (foto sapi/SALE tag TIDAK BOLEH lolos lagi)
   d. Update $IMGS di 07b-inject-images-nowdoc.php dengan URL yang sudah 
      diverifikasi, lalu jalankan ulang: php 07b-inject-images-nowdoc.php

3. GAMBAR BARU: tambahkan foto (rasio 4:5) + badge "GRADE A" pojok kanan atas 
   di tiap kartu produk halaman Produk (Kakap Merah, Kerapu Segar, Tuna Segar, 
   Tenggiri Segar, Bawal Segar) — fetch via cara yang sama, query sesuai 
   tabel bagian 3.

4. Setelah semua gambar & warna diupdate, clear Elementor cache 
   (DELETE FROM wp_options WHERE option_name LIKE '_transient_elementor%') 
   dan screenshot ulang ke-5 halaman untuk verifikasi visual final.

Font (Oswald/IBM Plex Sans/IBM Plex Mono) dan struktur layout SUDAH FINAL — 
jangan diubah, cuma warna surface-light dan gambar-gambar di atas yang perlu di-fix.
```
