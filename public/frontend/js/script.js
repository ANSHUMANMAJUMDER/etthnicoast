(function () {
  const elements = document.querySelectorAll(".scroll-lift");
  elements.forEach((el, index) => {
    const grid = el.closest(
      ".products-grid, .new-arrivals-grid, .bestsellers-grid, .reels-grid, .gender-grid"
    );
    if (grid) {
      el.style.setProperty("--delay", `${(index % 10) * 70}ms`);
    }
  });

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-visible");
        } else {
          entry.target.classList.remove("is-visible");
        }
      });
    },
    { threshold: 0.15, rootMargin: "0px 0px -10% 0px" }
  );
  elements.forEach((el) => observer.observe(el));
})();


// ── Search ────────────────────────────────────────────────────────
const searchToggle  = document.getElementById('searchToggle');
const searchOverlay = document.getElementById('searchOverlay');
const searchClose   = document.getElementById('searchClose');
const searchInput   = document.getElementById('searchInput');

searchToggle.addEventListener('click', (e) => {
  e.preventDefault();
  searchOverlay.classList.add('active');
  setTimeout(() => searchInput.focus(), 400);
});
searchClose.addEventListener('click', () => {
  searchOverlay.classList.remove('active');
  searchInput.value = '';
});
searchOverlay.addEventListener('click', (e) => {
  if (e.target === searchOverlay) {
    searchOverlay.classList.remove('active');
    searchInput.value = '';
  }
});


// ── Navbar scroll + logo swap ─────────────────────────────────────
if (!document.body.classList.contains('no-navbar-scroll')) {

  const navbar  = document.getElementById('navbar');
  const navLogo = document.getElementById('navLogo');
  let isHovering     = false;
  let isScrolledState = false;

  const logoTop     = new Image(); logoTop.src     = './public/assets/etthnicoast.png';
  const logoScrolled = new Image(); logoScrolled.src = './public/assets/logo_new_1.png';

  function setLogo(src) {
    if (!navLogo) return;
    if (navLogo.getAttribute('data-src') === src) return;
    navLogo.style.opacity = '0';
    setTimeout(() => {
      navLogo.src = src;
      navLogo.setAttribute('data-src', src);
      requestAnimationFrame(() => { navLogo.style.opacity = '1'; });
    }, 120);
  }

  function setNavbarState(scrolled) {
    if (!navbar || !navLogo) return;
    if (scrolled === isScrolledState) return;
    isScrolledState = scrolled;
    navbar.classList.toggle('scrolled', scrolled);
    if (!isHovering) {
      setLogo(scrolled ? './public/assets/logo_new_1.png' : './public/assets/etthnicoast.png');
    }
  }

  setNavbarState(window.scrollY > 50);
  window.addEventListener('scroll', () => setNavbarState(window.scrollY > 50), { passive: true });

  navbar.addEventListener('mouseenter', () => {
    isHovering = true;
    if (window.scrollY <= 50) setLogo('./public/assets/logo_new_1.png');
  });
  navbar.addEventListener('mouseleave', () => {
    isHovering = false;
    setLogo(window.scrollY > 50 ? './public/assets/logo_new_1.png' : './public/assets/etthnicoast.png');
  });
}


// ── Hamburger ─────────────────────────────────────────────────────
const hamburger         = document.getElementById('hamburger');
const navLinksContainer = document.getElementById('navLinksContainer');

hamburger.addEventListener('click', () => {
  hamburger.classList.toggle('active');
  navLinksContainer.classList.toggle('active');
});
document.querySelectorAll('.nav-links a').forEach(link => {
  link.addEventListener('click', () => {
    if (!link.parentElement.classList.contains('dropdown')) {
      hamburger.classList.remove('active');
      navLinksContainer.classList.remove('active');
    }
  });
});
document.addEventListener('click', (e) => {
  if (!e.target.closest('.nav-container')) {
    hamburger.classList.remove('active');
    navLinksContainer.classList.remove('active');
  }
});
window.addEventListener('resize', () => {
  if (window.innerWidth > 768) {
    hamburger.classList.remove('active');
    navLinksContainer.classList.remove('active');
    document.querySelectorAll('.dropdown').forEach(d => d.classList.remove('active'));
  }
});


// ── Hero Slider ───────────────────────────────────────────────────
let currentSlide = 0;
const slides      = document.querySelectorAll('.slide');
const dots        = document.querySelectorAll('.dot');
const totalSlides = slides.length;

function showSlide(index) {
  slides.forEach(s => s.classList.remove('active'));
  dots.forEach(d => d.classList.remove('active'));
  slides[index].classList.add('active');
  dots[index].classList.add('active');
}
function changeSlide(direction) {
  currentSlide = (currentSlide + direction + totalSlides) % totalSlides;
  showSlide(currentSlide);
}
function goToSlide(index) { currentSlide = index; showSlide(index); }
setInterval(() => changeSlide(1), 6000);
showSlide(0);


// ── Collection cards drag scroll ──────────────────────────────────
(function () {
  const wrapper = document.querySelector(".collection-cards-wrapper");
  if (!wrapper) return;
  let isDown = false, startX = 0, scrollLeft = 0;
  wrapper.addEventListener("mousedown", (e) => {
    isDown = true;
    wrapper.classList.add("dragging");
    startX = e.pageX - wrapper.offsetLeft;
    scrollLeft = wrapper.scrollLeft;
  });
  window.addEventListener("mouseup", () => { isDown = false; wrapper.classList.remove("dragging"); });
  wrapper.addEventListener("mouseleave", () => { isDown = false; wrapper.classList.remove("dragging"); });
  wrapper.addEventListener("mousemove", (e) => {
    if (!isDown) return;
    e.preventDefault();
    wrapper.scrollLeft = scrollLeft - ((e.pageX - wrapper.offsetLeft) - startX) * 1.2;
  });
})();


// ── Swiper ────────────────────────────────────────────────────────
var swiper = new Swiper(".mySwiper", {
  effect: "coverflow",
  grabCursor: true,
  centeredSlides: true,
  slidesPerView: "auto",
  coverflowEffect: { rotate: 15, stretch: 0, depth: 300, modifier: 1, slideShadows: true },
  navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
  loop: true,
});


// ── Jewelry Shots Slider ──────────────────────────────────────────
const jewelryShotsGrid    = document.getElementById('jewelryShotsGrid');
const jewelryShotsPrev    = document.getElementById('jewelryShotsPrev');
const jewelryShotsNext    = document.getElementById('jewelryShotsNext');
const jewelryShotsWrapper = document.querySelector('.jewelry-shots-slider-wrapper');

if (jewelryShotsGrid && jewelryShotsWrapper) {
  let jsCurrentIndex = 0, jsVisibleCount = 3, jsStep = 0, jsMaxIndex = 0;

  function recalcJewelryShotsGeometry() {
    const cards = jewelryShotsGrid.querySelectorAll('.jewelry-shot-card');
    if (!cards.length) return;
    const gap = cards[1]
      ? Math.max(0, Math.round(cards[1].getBoundingClientRect().left - cards[0].getBoundingClientRect().right))
      : 0;
    jsStep = cards[0].offsetWidth + gap;
    jsVisibleCount = window.innerWidth <= 480 ? 1 : window.innerWidth <= 1024 ? 2 : 3;
    jsMaxIndex = Math.max(0, cards.length - jsVisibleCount);
    if (jsCurrentIndex > jsMaxIndex) jsCurrentIndex = jsMaxIndex;
  }

  function updateJSButtons() {
    if (!jewelryShotsPrev || !jewelryShotsNext) return;
    jewelryShotsPrev.style.opacity       = jsCurrentIndex <= 0 ? '0.4' : '1';
    jewelryShotsPrev.style.pointerEvents = jsCurrentIndex <= 0 ? 'none' : 'auto';
    jewelryShotsNext.style.opacity       = jsCurrentIndex >= jsMaxIndex ? '0.4' : '1';
    jewelryShotsNext.style.pointerEvents = jsCurrentIndex >= jsMaxIndex ? 'none' : 'auto';
  }

  function updateJSPosition() {
    jewelryShotsGrid.style.transform = `translateX(${-(jsCurrentIndex * jsStep)}px)`;
    updateJSButtons();
  }

  jewelryShotsNext?.addEventListener('click', () => {
    if (jsCurrentIndex < jsMaxIndex) {
      jsCurrentIndex = Math.min(jsCurrentIndex + jsVisibleCount, jsMaxIndex);
      updateJSPosition();
    }
  });
  jewelryShotsPrev?.addEventListener('click', () => {
    if (jsCurrentIndex > 0) {
      jsCurrentIndex = Math.max(jsCurrentIndex - jsVisibleCount, 0);
      updateJSPosition();
    }
  });

  recalcJewelryShotsGeometry();
  updateJSPosition();
  window.addEventListener('resize', () => { recalcJewelryShotsGeometry(); updateJSPosition(); });
}


// ── Bestsellers scroll buttons ────────────────────────────────────
const bsGrid     = document.querySelector(".bestsellers-grid");
const bsLeftBtn  = document.querySelector(".scroll-btn.left");
const bsRightBtn = document.querySelector(".scroll-btn.right");

if (bsGrid && bsLeftBtn && bsRightBtn) {
  const bsCardWidth = () => (bsGrid.querySelector(".bestseller-card")?.offsetWidth || 300) + 20;
  bsRightBtn.addEventListener("click", () => bsGrid.scrollBy({ left:  bsCardWidth(), behavior: "smooth" }));
  bsLeftBtn.addEventListener("click",  () => bsGrid.scrollBy({ left: -bsCardWidth(), behavior: "smooth" }));
}


// ── Scroll animations (bestsellers & reels) ───────────────────────
const scrollAnimObserver = new IntersectionObserver(
  (entries) => entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('animate'); }),
  { threshold: 0.1, rootMargin: '0px 0px -100px 0px' }
);
document.querySelectorAll('.bestseller-card.scroll-animate, .insta-reel-card.scroll-animate')
  .forEach(el => scrollAnimObserver.observe(el));


// ── Instagram Reels ───────────────────────────────────────────────
// document.addEventListener("DOMContentLoaded", () => {
//   const track   = document.querySelector(".insta-reels-track");
//   const cards   = document.querySelectorAll(".insta-reel-card");
//   const prevBtn = document.querySelector(".reels-prev");
//   const nextBtn = document.querySelector(".reels-next");
//   const videos  = document.querySelectorAll(".reel-video");
//   if (!track) return;

//   const scrollAmount = () => {
//     const c = cards[0];
//     if (!c) return 300;
//     const s = window.getComputedStyle(c);
//     return c.offsetWidth + parseFloat(s.marginLeft) + parseFloat(s.marginRight);
//   };
//   prevBtn.addEventListener("click", () => track.scrollBy({ left: -scrollAmount(), behavior: "smooth" }));
//   nextBtn.addEventListener("click", () => track.scrollBy({ left:  scrollAmount(), behavior: "smooth" }));

//   const cardObserver = new IntersectionObserver(
//     (entries) => entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add("animate"); cardObserver.unobserve(e.target); } }),
//     { threshold: 0.2 }
//   );
//   cards.forEach(c => cardObserver.observe(c));

//   const videoObserver = new IntersectionObserver(
//     (entries) => entries.forEach(e => { e.isIntersecting ? e.target.play().catch(()=>{}) : e.target.pause(); }),
//     { threshold: 0.6 }
//   );
//   videos.forEach(v => videoObserver.observe(v));
// });


// // ── JM Reels Modal ────────────────────────────────────────────────
// const jmProducts = {
//   1: { video:'videos/jewellery1.mp4', image:'images/product1.jpg', name:'Elegant Diamond Necklace Set',  price:'₹24,999', description:'Suitable for: All occasions. Premium quality stones set in pure gold.' },
//   2: { video:'videos/jewellery2.mp4', image:'images/product2.jpg', name:'Traditional Gold Earrings',     price:'₹18,499', description:'Suitable for: Daily wear. 22K gold with intricate detailing.' },
//   3: { video:'videos/jewellery3.mp4', image:'images/product3.jpg', name:'Pearl & Crystal Bracelet',      price:'₹12,999', description:'Suitable for: Parties. Genuine pearls and sparkling crystals.' },
//   4: { video:'videos/jewellery4.mp4', image:'images/product4.jpg', name:'Designer Diamond Ring',         price:'₹32,499', description:'Suitable for: Engagements. Conflict-free diamonds in platinum.' },
//   5: { video:'videos/jewellery5.mp4', image:'images/product5.jpg', name:'Royal Choker Set',              price:'₹45,999', description:'Suitable for: Weddings. Includes matching earrings.' },
// };

// const jmTrack   = document.querySelector('.jm-reels-track');
// const jmPrevBtn = document.querySelector('.jm-reels-prev');
// const jmNextBtn = document.querySelector('.jm-reels-next');
// jmPrevBtn?.addEventListener('click', () => jmTrack.scrollBy({ left: -300, behavior: 'smooth' }));
// jmNextBtn?.addEventListener('click', () => jmTrack.scrollBy({ left:  300, behavior: 'smooth' }));

// const jmModal              = document.getElementById('jmModal');
// const jmModalCloseBtn      = document.getElementById('jmModalClose');
// const jmModalVideo         = document.getElementById('jmModalVideo');
// const jmModalProductImage  = document.getElementById('jmModalProductImage');
// const jmModalTitle         = document.getElementById('jmModalTitle');
// const jmModalPrice         = document.getElementById('jmModalPrice');
// const jmModalDescription   = document.getElementById('jmModalDescription');
// const jmModalPrev          = document.querySelector('.jm-modal-prev');
// const jmModalNext          = document.querySelector('.jm-modal-next');
// const jmCards              = Array.from(document.querySelectorAll('.jm-reel-card'));
// let jmCurrentIndex         = 0;
// let touchStartY = 0, touchEndY = 0;

// function jmOpenProductByIndex(index) {
//   if (index < 0) index = jmCards.length - 1;
//   if (index >= jmCards.length) index = 0;
//   jmCurrentIndex = index;
//   const product = jmProducts[jmCards[jmCurrentIndex].getAttribute('data-product')];
//   if (!product) return;
//   jmModalVideo.pause();
//   jmModalVideo.src = product.video;
//   jmModalVideo.muted = false;
//   jmModalVideo.load();
//   jmModalVideo.play();
//   jmModalProductImage.src         = product.image;
//   jmModalProductImage.alt         = product.name;
//   jmModalTitle.textContent        = product.name;
//   jmModalPrice.textContent        = product.price;
//   jmModalDescription.textContent  = product.description;
//   jmModal.classList.add('active');
//   document.body.style.overflow = 'hidden';
// }

// function jmCloseProductModal() {
//   jmModal.classList.remove('active');
//   jmModalVideo.pause();
//   jmModalVideo.muted = true;
//   jmModalVideo.currentTime = 0;
//   document.body.style.overflow = 'auto';
// }

// jmCards.forEach((card, i) => card.addEventListener('click', () => jmOpenProductByIndex(i)));
// jmModalPrev?.addEventListener('click', (e) => { e.stopPropagation(); jmOpenProductByIndex(jmCurrentIndex - 1); });
// jmModalNext?.addEventListener('click', (e) => { e.stopPropagation(); jmOpenProductByIndex(jmCurrentIndex + 1); });
// jmModalCloseBtn?.addEventListener('click', (e) => { e.stopPropagation(); jmCloseProductModal(); });
// jmModal?.addEventListener('click', (e) => { if (e.target === jmModal) jmCloseProductModal(); });

// jmModal?.addEventListener('touchstart', (e) => { touchStartY = e.touches[0].clientY; }, { passive: true });
// jmModal?.addEventListener('touchend',   (e) => {
//   touchEndY = e.changedTouches[0].clientY;
//   const dist = touchStartY - touchEndY;
//   if (Math.abs(dist) > 50) jmOpenProductByIndex(jmCurrentIndex + (dist > 0 ? 1 : -1));
// }, { passive: true });

// document.querySelector('.jm-btn-add-cart')?.addEventListener('click', () => alert('Product added to cart!'));
// document.querySelector('.jm-btn-cart-icon')?.addEventListener('click', () => alert('Added to wishlist!'));
// document.querySelector('.jm-btn-more-info')?.addEventListener('click', () => alert('Redirecting to product page...'));

// ── JM Reels Modal ────────────────────────────────────────────────
const jmTrack   = document.querySelector('.jm-reels-track');
const jmPrevBtn = document.querySelector('.jm-reels-prev');
const jmNextBtn = document.querySelector('.jm-reels-next');
jmPrevBtn?.addEventListener('click', () => jmTrack?.scrollBy({ left: -300, behavior: 'smooth' }));
jmNextBtn?.addEventListener('click', () => jmTrack?.scrollBy({ left:  300, behavior: 'smooth' }));

const jmModal             = document.getElementById('jmModal');
const jmModalCloseBtn     = document.getElementById('jmModalClose');
const jmModalVideo        = document.getElementById('jmModalVideo');
const jmModalProductImage = document.getElementById('jmModalProductImage');
const jmModalTitle        = document.getElementById('jmModalTitle');
const jmModalPrice        = document.getElementById('jmModalPrice');
const jmModalDescription  = document.getElementById('jmModalDescription');
const jmModalPrev         = document.querySelector('.jm-modal-prev');
const jmModalNext         = document.querySelector('.jm-modal-next');
const jmCards             = Array.from(document.querySelectorAll('.jm-reel-card'));
let jmCurrentIndex        = 0;
let jmTouchStartY = 0;

// ── Build data from data-attributes (no static object needed) ─────
function jmGetData(card) {
    return {
        video       : card.dataset.video       || '',
        image       : card.dataset.image       || '',
        name        : card.dataset.name        || '',
        price       : card.dataset.price       || '',
        description : card.dataset.description || '',
        url         : card.dataset.url         || '#',
    };
}

function jmOpenProductByIndex(index) {
    if (!jmCards.length) return;
    if (index < 0) index = jmCards.length - 1;
    if (index >= jmCards.length) index = 0;
    jmCurrentIndex = index;

    const d = jmGetData(jmCards[jmCurrentIndex]);

    // swap video
    jmModalVideo.pause();
    jmModalVideo.src   = d.video;
    jmModalVideo.muted = false;
    jmModalVideo.load();
    jmModalVideo.play().catch(() => {});

    // fill details
    jmModalProductImage.src        = d.image;
    jmModalProductImage.alt        = d.name;
    jmModalTitle.textContent       = d.name;
    jmModalPrice.textContent       = d.price;
    jmModalDescription.textContent = d.description;

    // store url on "More info" button
    const moreInfoBtn = document.querySelector('.jm-btn-more-info');
    if (moreInfoBtn) moreInfoBtn.dataset.url = d.url;

    jmModal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function jmCloseProductModal() {
    jmModal?.classList.remove('active');
    jmModalVideo?.pause();
    if (jmModalVideo) { jmModalVideo.muted = true; jmModalVideo.currentTime = 0; }
    document.body.style.overflow = 'auto';
}

// card clicks
jmCards.forEach((card, i) => {
    card.addEventListener('click', () => jmOpenProductByIndex(i));
});

// modal controls
jmModalPrev?.addEventListener('click',     (e) => { e.stopPropagation(); jmOpenProductByIndex(jmCurrentIndex - 1); });
jmModalNext?.addEventListener('click',     (e) => { e.stopPropagation(); jmOpenProductByIndex(jmCurrentIndex + 1); });
jmModalCloseBtn?.addEventListener('click', (e) => { e.stopPropagation(); jmCloseProductModal(); });
jmModal?.addEventListener('click',         (e) => { if (e.target === jmModal) jmCloseProductModal(); });

// swipe
jmModal?.addEventListener('touchstart', (e) => { jmTouchStartY = e.touches[0].clientY; }, { passive: true });
jmModal?.addEventListener('touchend',   (e) => {
    const dist = jmTouchStartY - e.changedTouches[0].clientY;
    if (Math.abs(dist) > 50) jmOpenProductByIndex(jmCurrentIndex + (dist > 0 ? 1 : -1));
}, { passive: true });

// action buttons
document.querySelector('.jm-btn-add-cart')?.addEventListener('click', () => {
    alert('Product added to cart!');
});
document.querySelector('.jm-btn-cart-icon')?.addEventListener('click', () => {
    alert('Added to wishlist!');
});
document.querySelector('.jm-btn-more-info')?.addEventListener('click', function () {
    const url = this.dataset.url;
    if (url && url !== '#') window.location.href = url;
});
// ── Hotspot Shop The Look ─────────────────────────────────────────
(function () {
  const hotspots        = document.querySelectorAll('.hotspot');
  if (!hotspots.length) return;

  const lookImage       = document.getElementById('lookImage');
  const lookBadge       = document.getElementById('lookBadge');
  const lookTitle       = document.getElementById('lookTitle');
  const lookCategory    = document.getElementById('lookCategory');
  const lookDescription = document.getElementById('lookDescription');
  const lookPrice       = document.getElementById('lookPrice');
  const lookShopBtn     = document.getElementById('lookShopBtn');
  const hotspotModal    = document.getElementById('hotspotModal');
  const modalClose      = document.getElementById('modalClose');
  const modalImage      = document.getElementById('modalImage');
  const modalBadge      = document.getElementById('modalBadge');
  const modalTitle      = document.getElementById('modalTitle');
  const modalCategory   = document.getElementById('modalCategory');
  const modalDescription= document.getElementById('modalDescription');
  const modalPrice      = document.getElementById('modalPrice');
  const modalShopBtn    = document.getElementById('modalShopBtn');

  function getData(h) {
    return {
      image       : h.dataset.image       || '',
      badge       : h.dataset.badge       || 'Featured Look',
      title       : h.dataset.title       || '',
      category    : h.dataset.category    || '',
      description : h.dataset.description || '',
      price       : h.dataset.price       || '',
      url         : h.dataset.url         || '#',
    };
  }

  function fillPanel(d) {
    if (lookImage)        lookImage.src                = d.image;
    if (lookBadge)        lookBadge.textContent        = d.badge;
    if (lookTitle)        lookTitle.textContent        = d.title;
    if (lookCategory)     lookCategory.textContent     = d.category;
    if (lookDescription)  lookDescription.textContent  = d.description;
    if (lookPrice)        lookPrice.textContent        = d.price;
    if (lookShopBtn)      lookShopBtn.href             = d.url;
  }

  function fillModal(d) {
    if (modalImage)       modalImage.src               = d.image;
    if (modalBadge)       modalBadge.textContent       = d.badge;
    if (modalTitle)       modalTitle.textContent       = d.title;
    if (modalCategory)    modalCategory.textContent    = d.category;
    if (modalDescription) modalDescription.textContent = d.description;
    if (modalPrice)       modalPrice.textContent       = d.price;
    if (modalShopBtn)     modalShopBtn.href            = d.url;
  }

  function openModal(d) {
    fillModal(d);
    hotspotModal.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeModal() {
    hotspotModal.classList.remove('active');
    document.body.style.overflow = '';
  }

  function setActive(h) {
    hotspots.forEach(x => x.classList.remove('active'));
    h.classList.add('active');
  }

  hotspots.forEach(function (h) {
    // click — update panel + open modal
    h.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      setActive(h);
      const d = getData(h);
      fillPanel(d);
      openModal(d);
    });
    // hover — only update side panel
    h.addEventListener('mouseenter', function () {
      setActive(h);
      fillPanel(getData(h));
    });
  });

  modalClose?.addEventListener('click', closeModal);
  hotspotModal?.addEventListener('click', e => { if (e.target === hotspotModal) closeModal(); });
  window.addEventListener('resize', () => { if (window.innerWidth > 768) closeModal(); });

  // auto-activate first
  setActive(hotspots[0]);
  fillPanel(getData(hotspots[0]));
})();


// ── Global keydown (search + jm modal + hotspot modal) ────────────
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') {
    // search
    if (searchOverlay?.classList.contains('active')) {
      searchOverlay.classList.remove('active');
      searchInput.value = '';
    }
    // jm modal
    if (jmModal?.classList.contains('active')) {
      jmCloseProductModal();
    }
    // hotspot modal — handled inside IIFE via its own listener
  }
  // jm modal arrow keys
  if (jmModal?.classList.contains('active')) {
    if (e.key === 'ArrowLeft')  jmOpenProductByIndex(jmCurrentIndex - 1);
    if (e.key === 'ArrowRight') jmOpenProductByIndex(jmCurrentIndex + 1);
  }
});