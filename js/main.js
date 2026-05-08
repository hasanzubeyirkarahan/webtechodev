/* ===========================
   MAIN.JS - Ana JavaScript Dosyası
   Web Teknolojileri Projesi 2025-2026
   =========================== */

/* ---- Hamburger Menü ---- */
document.addEventListener("DOMContentLoaded", function () {
  const hamburger = document.getElementById("hamburger");
  const navLinks = document.getElementById("navLinks");
  if (hamburger && navLinks) {
    hamburger.addEventListener("click", function () {
      navLinks.classList.toggle("open");
    });
  }

  // Aktif menü linki
  const currentPage = window.location.pathname.split("/").pop() || "index.html";
  document.querySelectorAll(".nav-links a").forEach((link) => {
    if (link.getAttribute("href") === currentPage) link.classList.add("active");
  });

  // Skill bar animasyonu
  const skillBars = document.querySelectorAll(".skill-bar-fill");
  if (skillBars.length > 0) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.style.width = entry.target.dataset.width;
          observer.unobserve(entry.target);
        }
      });
    });
    skillBars.forEach((bar) => {
      bar.style.width = "0";
      observer.observe(bar);
    });
  }
});

/* ---- Slider ---- */
function initSlider(containerId) {
  const container = document.getElementById(containerId);
  if (!container) return;
  const track = container.querySelector(".slider-track");
  const slides = container.querySelectorAll(".slide");
  const dotsContainer = container.querySelector(".slider-dots");
  let current = 0;
  const total = slides.length;

  // Dot oluştur
  slides.forEach((_, i) => {
    const dot = document.createElement("button");
    dot.className = "slider-dot" + (i === 0 ? " active" : "");
    dot.addEventListener("click", () => goTo(i));
    dotsContainer.appendChild(dot);
  });

  function goTo(index) {
    current = (index + total) % total;
    track.style.transform = `translateX(-${current * 100}%)`;
    container.querySelectorAll(".slider-dot").forEach((d, i) => {
      d.classList.toggle("active", i === current);
    });
  }

  container
    .querySelector(".slider-prev")
    ?.addEventListener("click", () => goTo(current - 1));
  container
    .querySelector(".slider-next")
    ?.addEventListener("click", () => goTo(current + 1));

  // Otomatik geçiş
  setInterval(() => goTo(current + 1), 4500);

  // Dokunma desteği
  let startX = 0;
  track.addEventListener("touchstart", (e) => {
    startX = e.touches[0].clientX;
  });
  track.addEventListener("touchend", (e) => {
    const diff = startX - e.changedTouches[0].clientX;
    if (Math.abs(diff) > 50) goTo(current + (diff > 0 ? 1 : -1));
  });
}

/* ---- Native JS Form Doğrulama ---- */
function validateFormNative() {
  let valid = true;
  const form = document.getElementById("contactForm");
  if (!form) return;

  // Reset
  form.querySelectorAll(".form-control").forEach((el) => {
    el.classList.remove("error", "success");
  });
  form
    .querySelectorAll(".form-error")
    .forEach((el) => el.classList.remove("show"));

  // Ad Soyad
  const adSoyad = document.getElementById("adSoyad");
  if (adSoyad) {
    if (!adSoyad.value.trim() || adSoyad.value.trim().length < 3) {
      showError(adSoyad, "adSoyadErr", "Ad Soyad en az 3 karakter olmalıdır.");
      valid = false;
    } else {
      adSoyad.classList.add("success");
    }
  }

  // Email
  const email = document.getElementById("email");
  if (email) {
    const emailReg = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailReg.test(email.value.trim())) {
      showError(email, "emailErr", "Geçerli bir e-posta adresi giriniz.");
      valid = false;
    } else {
      email.classList.add("success");
    }
  }

  // Telefon
  const telefon = document.getElementById("telefon");
  if (telefon) {
    const telReg = /^[0-9]{10,11}$/;
    if (!telReg.test(telefon.value.replace(/\s/g, ""))) {
      showError(
        telefon,
        "telefonErr",
        "Telefon numarası sadece rakam içermeli ve 10-11 haneli olmalıdır.",
      );
      valid = false;
    } else {
      telefon.classList.add("success");
    }
  }

  // Konu
  const konu = document.getElementById("konu");
  if (konu) {
    if (!konu.value) {
      showError(konu, "konuErr", "Lütfen bir konu seçiniz.");
      valid = false;
    } else {
      konu.classList.add("success");
    }
  }

  // Mesaj
  const mesaj = document.getElementById("mesaj");
  if (mesaj) {
    if (mesaj.value.trim().length < 10) {
      showError(mesaj, "mesajErr", "Mesajınız en az 10 karakter olmalıdır.");
      valid = false;
    } else {
      mesaj.classList.add("success");
    }
  }

  // Checkbox (kvkk)
  const kvkk = document.getElementById("kvkk");
  if (kvkk && !kvkk.checked) {
    const kvkkErr = document.getElementById("kvkkErr");
    if (kvkkErr) {
      kvkkErr.classList.add("show");
      kvkkErr.style.display = "block";
    }
    valid = false;
  } else {
    const kvkkErr = document.getElementById("kvkkErr");
    if (kvkkErr) {
      kvkkErr.classList.remove("show");
      kvkkErr.style.display = "none";
    }
  }

  const alertEl = document.getElementById("formAlert");
  if (alertEl) {
    alertEl.style.display = "block";
    alertEl.className =
      "alert " + (valid ? "alert-success show" : "alert-error show");
    alertEl.innerHTML = valid
      ? "✅ Form başarıyla doğrulandı (Native JS). Gönderiliyor..."
      : "❌ Lütfen hataları düzeltin.";
    if (valid) {
      setTimeout(() => {
        form.submit();
      }, 1000);
    }
  }

  return valid;
}

/* ---- Vue.js Form Doğrulama ---- */
function initVueValidation() {
  if (typeof Vue === "undefined") return;

  const app = Vue.createApp({
    data() {
      return {
        fields: {
          adSoyad: "",
          email: "",
          telefon: "",
          konu: "",
          mesaj: "",
          kvkk: false,
        },
        errors: {},
        submitted: false,
        isValid: false,
      };
    },
    methods: {
      validate() {
        this.errors = {};
        let valid = true;

        if (
          !this.fields.adSoyad.trim() ||
          this.fields.adSoyad.trim().length < 3
        ) {
          this.errors.adSoyad = "Ad Soyad en az 3 karakter olmalıdır.";
          valid = false;
        }
        const emailReg = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailReg.test(this.fields.email.trim())) {
          this.errors.email = "Geçerli bir e-posta adresi giriniz.";
          valid = false;
        }
        const telReg = /^[0-9]{10,11}$/;
        if (!telReg.test(this.fields.telefon.replace(/\s/g, ""))) {
          this.errors.telefon = "Telefon sadece rakam olmalı (10-11 hane).";
          valid = false;
        }
        if (!this.fields.konu) {
          this.errors.konu = "Lütfen bir konu seçiniz.";
          valid = false;
        }
        if (this.fields.mesaj.trim().length < 10) {
          this.errors.mesaj = "Mesajınız en az 10 karakter olmalıdır.";
          valid = false;
        }
        if (!this.fields.kvkk) {
          this.errors.kvkk = "KVKK onayı gereklidir.";
          valid = false;
        }

        this.isValid = valid;
        this.submitted = true;

        if (valid) {
          // Form senkronize et ve gönder
          syncFormFromVue(this.fields);
          setTimeout(() => {
            document.getElementById("contactForm").submit();
          }, 1000);
        }
      },
    },
  });

  const vueMount = document.getElementById("vueForm");
  if (vueMount) {
    // Vue uygulamasını pencere değişkenine ata ki HTML'deki buton erişebilsin
    window.__vueApp = app.mount("#vueForm");
  }
}

function syncFormFromVue(fields) {
  Object.keys(fields).forEach((key) => {
    const el = document.getElementById(key);
    if (el) {
      if (el.type === "checkbox") el.checked = fields[key];
      else el.value = fields[key];
    }
  });
}

function showError(inputEl, errId, msg) {
  inputEl.classList.add("error");
  const errEl = document.getElementById(errId);
  if (errEl) {
    errEl.textContent = msg;
    errEl.classList.add("show");
  }
}

/* ---- Login Doğrulama ---- */
function validateLogin() {
  let valid = true;
  const username = document.getElementById("loginUser");
  const password = document.getElementById("loginPass");
  const usernameErr = document.getElementById("loginUserErr");
  const passwordErr = document.getElementById("loginPassErr");

  [usernameErr, passwordErr].forEach((el) => {
    if (el) {
      el.classList.remove("show");
    }
  });
  [username, password].forEach((el) => {
    if (el) el.classList.remove("error", "success");
  });

  // Email formatı kontrolü
  const emailReg = /^[^\s@]+@sakarya\.edu\.tr$/i;
  if (!username || !username.value.trim()) {
    if (usernameErr) {
      usernameErr.textContent = "Bu alan boş bırakılamaz.";
      usernameErr.classList.add("show");
    }
    if (username) username.classList.add("error");
    valid = false;
  } else if (!emailReg.test(username.value.trim())) {
    if (usernameErr) {
      usernameErr.textContent =
        "Geçerli bir @sakarya.edu.tr e-posta adresi giriniz.";
      usernameErr.classList.add("show");
    }
    if (username) username.classList.add("error");
    valid = false;
  } else {
    if (username) username.classList.add("success");
  }

  if (!password || !password.value.trim()) {
    if (passwordErr) {
      passwordErr.textContent = "Bu alan boş bırakılamaz.";
      passwordErr.classList.add("show");
    }
    if (password) password.classList.add("error");
    valid = false;
  } else {
    if (password) password.classList.add("success");
  }

  return valid;
}
