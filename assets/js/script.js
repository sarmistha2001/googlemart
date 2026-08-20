document.addEventListener("DOMContentLoaded", function () {
  // Product catalog shared by all product carousels (same data as New Arrivals)
  const catalog = [
    { img: "https://images.unsplash.com/photo-1586075010923-2dd4570fb338?w=400&q=80", icon: "printer", name: "Digital Print", desc: "Book • Poster • Cert ₹10 • Letterhead ₹5" },
    { img: "https://images.unsplash.com/photo-1512820790803-83ca734da794?w=400&q=80", icon: "book-open", name: "Binding", desc: "Thesis • Leather • Spiral • Wiro" },
    { img: "https://images.unsplash.com/photo-1561070791-2526d30994b5?w=400&q=80", icon: "image", name: "Flex Print", desc: "Vinyl • Canvas • Sunboard • Banner" },
    { img: "https://images.unsplash.com/photo-1587613865763-4b8b0d19e8ab?w=400&q=80", icon: "copy", name: "Digital Xerox", desc: "A4 / A3 • A0 / A1 / A2" },
    { img: "https://images.unsplash.com/photo-1494172961521-33799ddd43a5?w=400&q=80", icon: "scroll", name: "Plan Xerox", desc: "A0 • A1 • A2 — B/W & Colour" },
    { img: "https://images.unsplash.com/photo-1452860606245-08befc0ff44b?w=400&q=80", icon: "scissors", name: "Die Cutting", desc: "Round • Rect • Any Shape • Creasing" },
    { img: "https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=400&q=80", icon: "utensils", name: "Menu Print", desc: "Leather • Hard • Wiro • Lamination" },
    { img: "https://images.unsplash.com/photo-1586717791821-3f44a563fa4c?w=400&q=80", icon: "contact", name: "Visiting Card", desc: "Matte • Velvet • Foil • PVC • Metal" },
    { img: "https://images.unsplash.com/photo-1521791136064-7986c2920216?w=400&q=80", icon: "badge-check", name: "ID Card / Lanyard", desc: "PVC • Hooks • Lanyard • Yo-yo" },
    { img: "https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?w=400&q=80", icon: "award", name: "Badge", desc: "58mm • 44mm • Ribbon • Magnetic" },
    { img: "https://images.unsplash.com/photo-1586953208448-b95a79798f07?w=400&q=80", icon: "receipt", name: "Bill Book", desc: "A4 • A5 • Receipt • Challan" },
    { img: "https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&q=80", icon: "shirt", name: "T-Shirt", desc: "PP 100 • Dot 180 • Dry-fit • Cap" },
    { img: "https://images.unsplash.com/photo-1513519245088-0e12902e5a38?w=400&q=80", icon: "frame", name: "Photo Frame", desc: "12×18 • A4 • LED • Aluminium" },
    { img: "https://images.unsplash.com/photo-1514228742587-6b1558fcca3d?w=400&q=80", icon: "coffee", name: "Mug Print", desc: "White • Beer • Magic • Metallic" },
    { img: "https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=400&q=80", icon: "zap", name: "Laser Engraving", desc: "Photo & Video Engraving" },
    { img: "https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=400&q=80", icon: "pen-tool", name: "Office & Art", desc: "Paper • Canvas • pens • Boards" },
    { img: "https://images.unsplash.com/photo-1513885535751-8b9238bd345a?w=400&q=80", icon: "briefcase", name: "Corporate Gift", desc: "On request — custom gifting" },
    { img: "https://images.unsplash.com/photo-1549465220-1a8b9238cd48?w=400&q=80", icon: "gift", name: "Gift", desc: "Mugs • Frames • Keepsakes" }
  ];

  // Build one slide for a catalog item (New Arrivals card markup)
  const slideHtml = (p) =>
    '<div class="swiper-slide"><a href="category.html" class="card h-100 shadow-soft text-decoration-none p-2">' +
    '<img src="' + p.img + '" class="rounded-4 object-cover w-100" style="aspect-ratio:1/1" alt="' + p.name + '" loading="lazy" onerror="this.style.display=\'none\'">' +
    '<div class="card-body p-2"><div class="small fw-semibold text-dark d-flex align-items-center gap-1"><i data-lucide="' + p.icon + '" style="width:14px;height:14px"></i> ' + p.name + '</div>' +
    '<div class="small text-secondary" style="font-size:11px;line-height:1.4">' + p.desc + '</div></div></a></div>';

  const fillCarousel = (selector) => {
    const wrapper = document.querySelector(selector + " .swiper-wrapper");
    if (wrapper) wrapper.innerHTML = catalog.map(slideHtml).join("");
  };

  ["trendSwiper", "printStationerySwiper", "apparelSwiper", "photoGiftsSwiper", "packagingSwiper", "corporateSwiper", "digitalOffsetSwiper", "homeDecorSwiper", "newLaunchesSwiper"].forEach(fillCarousel);

  // Best Sellers — image-only cards (portrait 3:4)
  const bestSellers = [
    { img: "https://images.unsplash.com/photo-1586717791821-3f44a563fa4c?w=600&q=80", name: "Classic Visiting Cards — Matte 350 GSM" },
    { img: "https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=600&q=80", name: "Premium Polo T-Shirt — Custom Print" },
    { img: "https://images.unsplash.com/photo-1514228742587-6b1558fcca3d?w=600&q=80", name: "Custom Photo Mug — White Gloss 325ml" },
    { img: "https://images.unsplash.com/photo-1513519245088-0e12902e5a38?w=600&q=80", name: "Canvas Wrap — 12×18 Premium Print" },
    { img: "https://images.unsplash.com/photo-1521791136064-7986c2920216?w=600&q=80", name: "Custom ID Cards — PVC with Lanyard" },
    { img: "https://images.unsplash.com/photo-1512820790803-83ca734da794?w=600&q=80", name: "Hardbound Thesis Binding — Premium" },
    { img: "https://images.unsplash.com/photo-1586953208448-b95a79798f07?w=600&q=80", name: "Custom Bill Books — A4 / A5" },
    { img: "https://images.unsplash.com/photo-1549465220-1a8b9238cd48?w=600&q=80", name: "Photo Gifts — Custom Mugs & Frames" }
  ];
  const bestSellerHtml = (p) =>
    '<div class="swiper-slide"><a href="product.html" class="card h-100 shadow-soft text-decoration-none p-2">' +
    '<img src="' + p.img + '" class="rounded-4 object-cover w-100" style="aspect-ratio:3/4;height:400px;max-height:400px" alt="' + p.name + '" loading="lazy" onerror="this.style.display=\'none\'">' +
    '</a></div>';
  const bestWrapper = document.querySelector(".bestSellersSwiper .swiper-wrapper");
  if (bestWrapper) bestWrapper.innerHTML = bestSellers.map(bestSellerHtml).join("");

  if (typeof Swiper !== "undefined") {
    new Swiper(".catSwiper", {
      slidesPerView: 3.5,
      spaceBetween: 4,
      grabCursor: true,
      loop: true,
      autoplay: { delay: 2500, disableOnInteraction: false, pauseOnMouseEnter: true },
      navigation: { nextEl: ".cat-next", prevEl: ".cat-prev" },
      pagination: { el: ".cat-pagination", clickable: true },
      breakpoints: {
        480: { slidesPerView: 4.5, spaceBetween: 4 },
        768: { slidesPerView: 6, spaceBetween: 6 },
        992: { slidesPerView: 7, spaceBetween: 6 },
        1200: { slidesPerView: 10, spaceBetween: 8 }
      }
    });
    new Swiper(".relatedSwiper", {
    slidesPerView: 2,
    spaceBetween: 12,
    grabCursor: true,
    loop: true,
    autoplay: { delay: 2500, disableOnInteraction: false, pauseOnMouseEnter: true },
    pagination: {
        el: ".related-pagination",
        clickable: true
    },

    breakpoints: {
        576: {
            slidesPerView: 3,
            spaceBetween: 12
        },
        768: {
            slidesPerView: 4,
            spaceBetween: 14
        },
        992: {
            slidesPerView: 5,
            spaceBetween: 14
        },
        1200: {
            slidesPerView: 5,
            spaceBetween: 16
        }
    }
});
    new Swiper(".newArrivalSwiper", {
      slidesPerView: 2,
      spaceBetween: 12,
      grabCursor: true,
      loop: true,
      autoplay: { delay: 2500, disableOnInteraction: false, pauseOnMouseEnter: true },
      navigation: { nextEl: ".newArrival-next", prevEl: ".newArrival-prev" },
      pagination: { el: ".newArrival-pagination", clickable: true },
      breakpoints: {
        576: { slidesPerView: 3, spaceBetween: 12 },
        768: { slidesPerView: 4, spaceBetween: 12 },
        992: { slidesPerView: 5, spaceBetween: 14 },
        1200: { slidesPerView: 6, spaceBetween: 14 }
      }
    });
    // Product carousels — Best Sellers (4 per row), Trending + category highlights (same config as New Arrivals)
    ["bestSellers"].forEach(function (key) {
      new Swiper("." + key + "Swiper", {
        slidesPerView: 1,
        spaceBetween: 12,
        grabCursor: true,
        loop: true,
        autoplay: { delay: 2500, disableOnInteraction: false, pauseOnMouseEnter: true },
        navigation: { nextEl: "." + key + "-next", prevEl: "." + key + "-prev" },
        pagination: { el: "." + key + "-pagination", clickable: true },
        breakpoints: {
          576: { slidesPerView: 2, spaceBetween: 12 },
          768: { slidesPerView: 3, spaceBetween: 12 },
          992: { slidesPerView: 4, spaceBetween: 14 },
          1200: { slidesPerView: 4, spaceBetween: 14 }
        }
      });
    });
    ["trend", "printStationery", "apparel", "photoGifts", "packaging", "corporate", "digitalOffset", "homeDecor", "newLaunches"].forEach(function (key) {
      new Swiper("." + key + "Swiper", {
        slidesPerView: 2,
        spaceBetween: 12,
        grabCursor: true,
        loop: true,
        autoplay: { delay: 2500, disableOnInteraction: false, pauseOnMouseEnter: true },
        navigation: { nextEl: "." + key + "-next", prevEl: "." + key + "-prev" },
        pagination: { el: "." + key + "-pagination", clickable: true },
        breakpoints: {
          576: { slidesPerView: 3, spaceBetween: 12 },
          768: { slidesPerView: 4, spaceBetween: 12 },
          992: { slidesPerView: 5, spaceBetween: 14 },
          1200: { slidesPerView: 6, spaceBetween: 14 }
        }
      });
    });
  }
  const megaLinks = document.querySelectorAll("[data-mega]");
  const panels = document.querySelectorAll("[data-panel]");
  const hideAll = () => panels.forEach(p=>p.classList.add("d-none"));
  megaLinks.forEach(a=>{
    a.addEventListener("mouseenter", ()=>{
      hideAll();
      megaLinks.forEach(x=>x.parentElement.classList.remove("active"));
      a.parentElement.classList.add("active");
      const p = document.querySelector(`[data-panel="${a.dataset.mega}"]`);
      if(p) p.classList.remove("d-none");
    });
  });
  document.querySelector(".mega-panels")?.addEventListener("mouseleave", ()=>{ hideAll(); megaLinks.forEach(x=>x.parentElement.classList.remove("active")); });
  document.addEventListener("click", e=>{ if(!e.target.closest(".mega-item") && !e.target.closest(".mega-panel")) { hideAll(); megaLinks.forEach(x=>x.parentElement.classList.remove("active")); }});
  document.querySelectorAll("[data-open]").forEach(btn=>{
    btn.addEventListener("click", ()=>{
      const id = btn.dataset.open;
      const el = document.getElementById(`m-${id}`);
      if(el && !el.classList.contains("show")){
        const b = document.querySelector(`[data-bs-target="#m-${id}"]`);
        if(b) new bootstrap.Collapse(el, {toggle:true});
      }
    });
  });
  if (window.lucide) lucide.createIcons();
});
function setMainImg(btn) {
  const newSrc = btn.getAttribute('data-img');
  if (!newSrc) return;

  const mainImg = document.getElementById('mainImg');
  mainImg.src = newSrc;

  // toggle active state on thumb buttons
  document.querySelectorAll('.thumb-btn').forEach(function (el) {
    el.classList.remove('active');
  });
  btn.classList.add('active');
}

// ---------- Open zoom modal with a given image src ----------
function openZoom(src) {
  if (!src) return;
  const zoomImg = document.getElementById('zoomImg');
  zoomImg.src = src;

  const modalEl = document.getElementById('photoZoomModal');
  const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
  modal.show();
}

// ---------- Pick an image from the gallery modal ----------
function pickFromGallery(imgEl) {
  if (!imgEl || !imgEl.src) return;

  // update the main product image
  const mainImg = document.getElementById('mainImg');
  mainImg.src = imgEl.src;

  // sync active state on visible thumbnails, if this src matches one
  document.querySelectorAll('.thumb-btn').forEach(function (el) {
    el.classList.toggle('active', el.getAttribute('data-img') === imgEl.src);
  });

  // close the gallery modal
  const galleryModalEl = document.getElementById('galleryModal');
  const galleryModal = bootstrap.Modal.getInstance(galleryModalEl);
  if (galleryModal) galleryModal.hide();
}

document.addEventListener('DOMContentLoaded', function () {
  const enquiryModalEl = document.getElementById('enquiryModal');
  if (enquiryModalEl) {
    enquiryModalEl.addEventListener('show.bs.modal', function () {
      const mainImgSrc = document.getElementById('mainImg')?.src;
      const enqImg = document.getElementById('enqImg');
      if (mainImgSrc && enqImg) enqImg.src = mainImgSrc;
    });
  }
});