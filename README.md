# Web Teknolojileri Projesi 2025-2026 Bahar Dönemi

## 📌 Proje Yapısı

```
web_odevi/
├── index.html          → Hakkımda (Giriş) Sayfası
├── ozgecmis.html       → Özgeçmiş (CV) Sayfası  [Semantic HTML]
├── sehrim.html         → Şehrim Sayfası          [4'lü Slider]
├── miras.html          → Mirasımız Sayfası
├── ilgialanlarim.html  → İlgi Alanlarım          [TMDB API]
├── iletisim.html       → İletişim Formu          [Native JS + Vue.js]
├── login.html          → Login Sayfası           [JS Validasyon]
├── css/
│   └── style.css       → Tüm stiller (harici CSS dosyası)
├── js/
│   └── main.js         → Ana JavaScript dosyası
├── php/
│   ├── login_kontrol.php  → Login POST işleyici
│   ├── hosgeldiniz.php    → Başarılı giriş sayfası
│   ├── form_isle.php      → İletişim formu POST işleyici
│   └── cikis.php          → Session temizleme
└── images/             → Resimlerinizi buraya ekleyin
```

---

## 🚀 Kurulum

### 1. Yerel Test (XAMPP / WAMP / MAMP)
1. `web_odevi` klasörünü `htdocs` (XAMPP) veya `www` (WAMP) içine kopyalayın
2. XAMPP Apache'yi başlatın
3. Tarayıcıda `http://localhost/web_odevi/index.html` adresine gidin

### 2. Canlı Yayın (InfinityFree / 000webhost)
1. Hesap oluşturun: https://infinityfree.net veya https://www.000webhost.com
2. Tüm dosyaları FTP ile `htdocs/public_html` klasörüne yükleyin
3. Siteniz hazır!

---

## ⚙️ Yapılandırma

### Öğrenci No Güncelleme
`php/login_kontrol.php` dosyasında:
```php
$ogrenci_no = "b2412100001"; // Kendi öğrenci numaranızı girin
```

### TMDB API Anahtarı
`ilgialanlarim.html` dosyasında:
1. https://www.themoviedb.org adresine kayıt olun
2. https://www.themoviedb.org/settings/api adresinden ücretsiz API anahtarı alın
3. Şu satırı güncelleyin:
```javascript
const TMDB_API_KEY = 'BURAYA_API_ANAHTARINIZI_GIRIN';
```

### Kişisel Bilgileri Güncelleme
Tüm HTML dosyalarında `Ad Soyad`, `bXXXXXXXXXX` ve `kullanici_adi` ifadelerini kendi bilgilerinizle değiştirin.

---

## 🎯 Teknik Özellikler

| Özellik | Teknoloji |
|---------|-----------|
| **Responsive Tasarım** | Bootstrap 5.3 + Özel CSS |
| **Stil Yönetimi** | Harici CSS (`css/style.css`) |
| **Slider** | Vanilla JS (4+ resim, dokunma desteği) |
| **API Entegrasyonu** | TMDB (The Movie Database) - Film verileri |
| **Form Doğrulama 1** | Native JavaScript |
| **Form Doğrulama 2** | Vue.js 3 |
| **Sunucu Tarafı** | PHP (POST işleme, Session yönetimi) |
| **Semantic HTML** | header, section, article, main, footer |
| **Login** | PHP Session + JavaScript doğrulama |

---

## 🔐 Demo Giriş Bilgileri
- **Kullanıcı:** `b2412100001@sakarya.edu.tr`
- **Şifre:** `b2412100001`

---

## 📸 Resim Ekleme
`images/` klasörüne kendi resimlerinizi ekleyip HTML dosyalarındaki 
emoji placeholder'ları `<img>` etiketiyle değiştirin:
```html
<!-- Eskisi: -->
<div style="...font-size:6rem;">🌊</div>

<!-- Yenisi: -->
<img src="images/sakarya_nehri.jpg" alt="Sakarya Nehri">
```

---

## 📋 GitHub Push Gereksinimleri
Ödev için farklı günlerde en az 10 push gereklidir. Örnek plan:
- Gün 1: Proje yapısı oluştur
- Gün 2: index.html tamamla
- Gün 3: ozgecmis.html tamamla
- Gün 4: sehrim.html + slider ekle
- Gün 5: miras.html tamamla
- Gün 6: ilgialanlarim.html + API entegrasyonu
- Gün 7: iletisim.html + Native JS doğrulama
- Gün 8: Vue.js doğrulaması ekle
- Gün 9: PHP dosyaları + login sistemi
- Gün 10: Son düzenlemeler + responsive test

---

## 📄 Raporun Kapak Sayfasında Olması Gerekenler
- Ders: Web Teknolojileri
- Dönem: 2025-2026 Bahar
- Öğrenci Adı, Numarası
- GitHub linki: `https://github.com/KULLANICI/web_odevi`
- Canlı site linki: `https://SITENIZ.infinityfree.net`
