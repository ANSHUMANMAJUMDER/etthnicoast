

  (function () {
    
    const elements = document.querySelectorAll(".scroll-lift");

    /* stagger like Pandora */
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
            entry.target.classList.remove("is-visible"); // 👈 THIS is the key
          }
        });
      },
      {
        threshold: 0.15,
        rootMargin: "0px 0px -10% 0px"
      }
    );

    elements.forEach((el) => observer.observe(el));
  })();

  
        /* ========================================================
           MOBILE MENU TOGGLE
           ======================================================== */
          const searchToggle = document.getElementById('searchToggle');
        const searchOverlay = document.getElementById('searchOverlay');
        const searchClose = document.getElementById('searchClose');
        const searchInput = document.getElementById('searchInput');

        searchToggle.addEventListener('click', (e) => {
            e.preventDefault();
            searchOverlay.classList.add('active');
            setTimeout(() => searchInput.focus(), 400);
        });

        searchClose.addEventListener('click', () => {
            searchOverlay.classList.remove('active');
            searchInput.value = '';
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && searchOverlay.classList.contains('active')) {
                searchOverlay.classList.remove('active');
                searchInput.value = '';
            }
        });

        searchOverlay.addEventListener('click', (e) => {
            if (e.target === searchOverlay) {
                searchOverlay.classList.remove('active');
                searchInput.value = '';
            }
        });
 if (!document.body.classList.contains('no-navbar-scroll')) {

        let isHovering = false;
        
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            const navLogo = document.getElementById('navLogo');

            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
                if (navLogo && !isHovering) {
                    navLogo.src = './public/assets/logo_new_1.png';
                }
            } else {
                navbar.classList.remove('scrolled');
                if (navLogo && !isHovering) {
                    navLogo.src = './public/assets/etthnicoast.png';
                }
            }
        });

       
        // When scrolling DOWN (past 50px):

const navbar = document.getElementById('navbar');
const navLogo = document.getElementById('navLogo');


let isScrolledState = false; // track state to avoid repeating swaps

// preload both logos so no “late image load” flash
const logoTop = new Image();
logoTop.src = './public/assets/etthnicoast.png';

const logoScrolled = new Image();
logoScrolled.src = './public/assets/logo_new_1.png';

function setLogo(src){
  if (!navLogo) return;
  if (navLogo.getAttribute('data-src') === src) return; // already showing

  navLogo.style.opacity = '0';
  // swap while invisible
  setTimeout(() => {
    navLogo.src = src;
    navLogo.setAttribute('data-src', src);
    requestAnimationFrame(() => {
      navLogo.style.opacity = '1';
    });
  }, 120);
}

function setNavbarState(scrolled){
  if (!navbar || !navLogo) return;

  if (scrolled === isScrolledState) return; // nothing changed
  isScrolledState = scrolled;

  // 1) apply background state first
  navbar.classList.toggle('scrolled', scrolled);

  // 2) swap logo (unless user is hovering)
  if (!isHovering){
    setLogo(scrolled ? './public/assets/logo_new_1.png' : './public/assets/etthnicoast.png');
  }
}

// initial state on load
setNavbarState(window.scrollY > 50);

// on scroll
window.addEventListener('scroll', () => {
  setNavbarState(window.scrollY > 50);
}, { passive: true });

// hover behavior (keep your logic, but use setLogo)
navbar.addEventListener('mouseenter', () => {
  isHovering = true;
  if (window.scrollY <= 50) setLogo('./public/assets/logo_new_1.png');
});

navbar.addEventListener('mouseleave', () => {
  isHovering = false;
  setLogo(window.scrollY > 50 ? './public/assets/logo_new_1.png' : './public/assets/etthnicoast.png');
});
}


        const hamburger = document.getElementById('hamburger');
        const navLinksContainer = document.getElementById('navLinksContainer');

        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            navLinksContainer.classList.toggle('active');
        });

        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', (e) => {
                if (!link.parentElement.classList.contains('dropdown')) {
                    hamburger.classList.remove('active');
                    navLinksContainer.classList.remove('active');
                }
            });
        });

        function toggleDropdown(e) {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                const dropdown = e.target.closest('.dropdown');
                dropdown.classList.toggle('active');
            }
        }

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

        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.dot');
        const totalSlides = slides.length;

        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));
            slides[index].classList.add('active');
            dots[index].classList.add('active');
        }

        function changeSlide(direction) {
            currentSlide += direction;
            if (currentSlide >= totalSlides) {
                currentSlide = 0;
            } else if (currentSlide < 0) {
                currentSlide = totalSlides - 1;
            }
            showSlide(currentSlide);
        }

        function goToSlide(index) {
            currentSlide = index;
            showSlide(currentSlide);
        }

        setInterval(() => {
            changeSlide(1);
        }, 6000);

        showSlide(0);

       

         (function () {
    const wrapper = document.querySelector(".collection-cards-wrapper");
    if (!wrapper) return;

    let isDown = false;
    let startX = 0;
    let scrollLeft = 0;

    wrapper.addEventListener("mousedown", (e) => {
      isDown = true;
      wrapper.classList.add("dragging");
      startX = e.pageX - wrapper.offsetLeft;
      scrollLeft = wrapper.scrollLeft;
    });

    window.addEventListener("mouseup", () => {
      isDown = false;
      wrapper.classList.remove("dragging");
    });

    wrapper.addEventListener("mouseleave", () => {
      isDown = false;
      wrapper.classList.remove("dragging");
    });

    wrapper.addEventListener("mousemove", (e) => {
      if (!isDown) return;
      e.preventDefault();
      const x = e.pageX - wrapper.offsetLeft;
      const walk = (x - startX) * 1.2; // drag speed
      wrapper.scrollLeft = scrollLeft - walk;
    });
  })();


        var swiper = new Swiper(".mySwiper", {
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: "auto",
            coverflowEffect: {
                rotate: 15,
                stretch: 0,
                depth: 300,
                modifier: 1,
                slideShadows: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            loop: true,
        });
    
        /* ========================================================
           JEWELRY SHOTS VIDEO SLIDER
           ======================================================== */

const jewelryShotsGrid = document.getElementById('jewelryShotsGrid');
const jewelryShotsPrev = document.getElementById('jewelryShotsPrev');
const jewelryShotsNext = document.getElementById('jewelryShotsNext');
const jewelryShotsWrapper = document.querySelector('.jewelry-shots-slider-wrapper');

if (jewelryShotsGrid && jewelryShotsWrapper) {
    let jewelryShotsCurrentIndex = 0;
    let jewelryShotsVisibleCount = 3;
    let jewelryShotsStep = 0;
    let jewelryShotsMaxIndex = 0;

    function recalcJewelryShotsGeometry() {
        const cards = jewelryShotsGrid.querySelectorAll('.jewelry-shot-card');
        if (!cards.length) return;

        const firstCard = cards[0];
        const secondCard = cards[1];

        const cardWidth = firstCard.offsetWidth;
        let gap = 0;

        if (secondCard) {
            const rect1 = firstCard.getBoundingClientRect();
            const rect2 = secondCard.getBoundingClientRect();
            gap = Math.max(0, Math.round(rect2.left - rect1.right));
        }

        jewelryShotsStep = cardWidth + gap;

        const wrapperWidth = jewelryShotsWrapper.offsetWidth;

        if (window.innerWidth <= 480) {
            jewelryShotsVisibleCount = 1;
        } else if (window.innerWidth <= 1024) {
            jewelryShotsVisibleCount = 2;
        } else {
            jewelryShotsVisibleCount = 3;
        }

        const totalCards = cards.length;
        jewelryShotsMaxIndex = Math.max(0, totalCards - jewelryShotsVisibleCount);

        if (jewelryShotsCurrentIndex > jewelryShotsMaxIndex) {
            jewelryShotsCurrentIndex = jewelryShotsMaxIndex;
        }
    }

    function updateJewelryShotsButtons() {
        if (!jewelryShotsPrev || !jewelryShotsNext) return;

        const atStart = jewelryShotsCurrentIndex <= 0;
        const atEnd = jewelryShotsCurrentIndex >= jewelryShotsMaxIndex;

        jewelryShotsPrev.style.opacity = atStart ? '0.4' : '1';
        jewelryShotsPrev.style.pointerEvents = atStart ? 'none' : 'auto';

        jewelryShotsNext.style.opacity = atEnd ? '0.4' : '1';
        jewelryShotsNext.style.pointerEvents = atEnd ? 'none' : 'auto';
    }

    function updateJewelryShotsPosition() {
        const translateX = -(jewelryShotsCurrentIndex * jewelryShotsStep);
        jewelryShotsGrid.style.transform = `translateX(${translateX}px)`;
        updateJewelryShotsButtons();
    }

    if (jewelryShotsNext) {
        jewelryShotsNext.addEventListener('click', () => {
            if (jewelryShotsCurrentIndex < jewelryShotsMaxIndex) {
                jewelryShotsCurrentIndex = Math.min(
                    jewelryShotsCurrentIndex + jewelryShotsVisibleCount,
                    jewelryShotsMaxIndex
                );
                updateJewelryShotsPosition();
            }
        });
    }

    if (jewelryShotsPrev) {
        jewelryShotsPrev.addEventListener('click', () => {
            if (jewelryShotsCurrentIndex > 0) {
                jewelryShotsCurrentIndex = Math.max(
                    jewelryShotsCurrentIndex - jewelryShotsVisibleCount,
                    0
                );
                updateJewelryShotsPosition();
            }
        });
    }

    // Initialize on load
    recalcJewelryShotsGeometry();
    updateJewelryShotsPosition();

    // Recalculate on resize
    window.addEventListener('resize', () => {
        recalcJewelryShotsGeometry();
        updateJewelryShotsPosition();
    });
}

        /* ========================================================
           SCROLL ANIMATIONS (BESTSELLERS & REELS)
           ======================================================== */
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate');
                }
            });
        }, observerOptions);

        // Observe all bestseller cards
        document.querySelectorAll('.bestseller-card.scroll-animate').forEach(card => {
            observer.observe(card);
        });

        // Observe all Instagram reel cards
        document.querySelectorAll('.insta-reel-card.scroll-animate').forEach(card => {
            observer.observe(card);
        });
  
document.addEventListener("DOMContentLoaded", () => {
    const track = document.querySelector(".insta-reels-track");
    const cards = document.querySelectorAll(".insta-reel-card");
    const prevBtn = document.querySelector(".reels-prev");
    const nextBtn = document.querySelector(".reels-next");
    const videos = document.querySelectorAll(".reel-video");

    if (!track) return;

    // Scroll by one card width on arrow click
    const scrollAmount = () => {
        const firstCard = cards[0];
        if (!firstCard) return 300;
        const style = window.getComputedStyle(firstCard);
        const cardWidth = firstCard.offsetWidth +
            parseFloat(style.marginLeft) +
            parseFloat(style.marginRight);
        return cardWidth;
    };

    prevBtn.addEventListener("click", () => {
        track.scrollBy({ left: -scrollAmount(), behavior: "smooth" });
    });

    nextBtn.addEventListener("click", () => {
        track.scrollBy({ left: scrollAmount(), behavior: "smooth" });
    });

    // Animate cards in when they enter viewport
    const cardObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("animate");
                    cardObserver.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.2 }
    );

    cards.forEach(card => cardObserver.observe(card));

    // Autoplay / pause videos based on visibility (optional but nice)
    const videoObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach(entry => {
                const video = entry.target;
                if (entry.isIntersecting) {
                    video.play().catch(() => {});
                } else {
                    video.pause();
                }
            });
        },
        { threshold: 0.6 }
    );

    videos.forEach(video => videoObserver.observe(video));
});




// Hotspot video script
//  const hotspots = document.querySelectorAll('.hotspot');
//         const lookBadge = document.getElementById('lookBadge');
//         const lookTitle = document.getElementById('lookTitle');
//         const lookCategory = document.getElementById('lookCategory');
//         const lookDescription = document.getElementById('lookDescription');
//         const lookPrice = document.getElementById('lookPrice');
//         const lookImage = document.getElementById('lookImage');
//         const hotspotModal = document.getElementById('hotspotModal');
//         const modalClose = document.getElementById('modalClose');
//         const modalImage = document.getElementById('modalImage');
//         const modalBadge = document.getElementById('modalBadge');
//         const modalTitle = document.getElementById('modalTitle');
//         const modalCategory = document.getElementById('modalCategory');
//         const modalDescription = document.getElementById('modalDescription');
//         const modalPrice = document.getElementById('modalPrice');

//         function activateHotspot(hotspot) {
//             hotspots.forEach(h => h.classList.remove('active'));
//             hotspot.classList.add('active');

//             const title = hotspot.dataset.title || '';
//             const badge = hotspot.dataset.badge || 'Featured Look';
//             const category = hotspot.dataset.category || '';
//             const description = hotspot.dataset.description || '';
//             const price = hotspot.dataset.price || '';
//             const image = hotspot.dataset.image || '';

//             if (lookBadge) lookBadge.textContent = badge;
//             if (lookTitle) lookTitle.textContent = title;
//             if (lookCategory) lookCategory.textContent = category;
//             if (lookDescription) lookDescription.textContent = description;
//             if (lookPrice) lookPrice.textContent = price;
//             if (lookImage && image) lookImage.src = image;
//             if (window.innerWidth <= 768) {
//                 if (modalImage) modalImage.src = image;
//                 if (modalBadge) modalBadge.textContent = badge;
//                 if (modalTitle) modalTitle.textContent = title;
//                 if (modalCategory) modalCategory.textContent = category;
//                 if (modalDescription) modalDescription.textContent = description;
//                 if (modalPrice) modalPrice.textContent = price;
//                  if (lookImage && image) lookImage.src = image; // NEW
//                 hotspotModal.classList.add('active');
//                 document.body.style.overflow = 'hidden';
//             }
//         }

//         function closeModal() {
//             hotspotModal.classList.remove('active');
//             document.body.style.overflow = '';
//         }

//         hotspots.forEach(hotspot => {
//             hotspot.addEventListener('click', (e) => {
//                 e.preventDefault();
//                 activateHotspot(hotspot);
//             });

//             if (window.innerWidth > 768) {
//                 hotspot.addEventListener('mouseenter', () => {
//                     activateHotspot(hotspot);
//                 });
//             }
//         });

//         if (modalClose) {
//             modalClose.addEventListener('click', closeModal);
//         }

//         if (hotspotModal) {
//             hotspotModal.addEventListener('click', (e) => {
//                 if (e.target === hotspotModal) {
//                     closeModal();
//                 }
//             });
//         }

//         document.addEventListener('keydown', (e) => {
//             if (e.key === 'Escape' && hotspotModal.classList.contains('active')) {
//                 closeModal();
//             }
//         });

//         if (window.innerWidth > 768) {
//             const defaultHotspot = document.querySelector('.hotspot[data-product="necklace"]') || hotspots[0];
//             if (defaultHotspot) {
//                 hotspots.forEach(h => h.classList.remove('active'));
//                 defaultHotspot.classList.add('active');
                
//                 const title = defaultHotspot.dataset.title || '';
//                 const badge = defaultHotspot.dataset.badge || 'Featured Look';
//                 const category = defaultHotspot.dataset.category || '';
//                 const description = defaultHotspot.dataset.description || '';
//                 const price = defaultHotspot.dataset.price || '';
//                  const image = defaultHotspot.dataset.image || ''; // NE
//                 if (lookBadge) lookBadge.textContent = badge;
//                 if (lookTitle) lookTitle.textContent = title;
//                 if (lookCategory) lookCategory.textContent = category;
//                 if (lookDescription) lookDescription.textContent = description;
//                  if (lookImage && image) lookImage.src = image; // NEW
//             }
//         }

//         window.addEventListener('resize', () => {
//             if (window.innerWidth > 768 && hotspotModal.classList.contains('active')) {
//                 closeModal();
//             }
//         });

// Add these two lines with the other element selectors
const lookShopBtn  = document.getElementById('lookShopBtn');
const modalShopBtn = document.getElementById('modalShopBtn');
console.log('lookShopBtn:', lookShopBtn);
console.log('modalShopBtn:', modalShopBtn);

function activateHotspot(hotspot) {
    hotspots.forEach(h => h.classList.remove('active'));
    hotspot.classList.add('active');

    const title       = hotspot.dataset.title       || '';
    const badge       = hotspot.dataset.badge       || 'Featured Look';
    const category    = hotspot.dataset.category    || '';
    const description = hotspot.dataset.description || '';
    const price       = hotspot.dataset.price       || '';
    const image       = hotspot.dataset.image       || '';
    const url         = hotspot.dataset.url         || '#';   // ← ADD

    if (lookBadge)    lookBadge.textContent    = badge;
    if (lookTitle)    lookTitle.textContent    = title;
    if (lookCategory) lookCategory.textContent = category;
    if (lookDescription) lookDescription.textContent = description;
    if (lookPrice)    lookPrice.textContent    = price;
    if (lookImage && image) lookImage.src      = image;
    if (lookShopBtn)  lookShopBtn.href         = url;         // ← ADD

    if (window.innerWidth <= 768) {
        if (modalImage)    modalImage.src            = image;
        if (modalBadge)    modalBadge.textContent    = badge;
        if (modalTitle)    modalTitle.textContent    = title;
        if (modalCategory) modalCategory.textContent = category;
        if (modalDescription) modalDescription.textContent = description;
        if (modalPrice)    modalPrice.textContent    = price;
        if (modalShopBtn)  modalShopBtn.href         = url;   // ← ADD
        hotspotModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

    const grid = document.querySelector(".bestsellers-grid");
    const leftBtn = document.querySelector(".scroll-btn.left");
    const rightBtn = document.querySelector(".scroll-btn.right");

    rightBtn.addEventListener("click", () => {
        grid.scrollBy({
            left: grid.querySelector(".bestseller-card").offsetWidth + 20,
            behavior: "smooth"
        });
    });

    leftBtn.addEventListener("click", () => {
        grid.scrollBy({
            left: -(grid.querySelector(".bestseller-card").offsetWidth + 20),
            behavior: "smooth"
        });
    });

 
  
        // Product data
        const jmProducts = {
            1: {
                video: 'videos/jewellery1.mp4',
                image: 'images/product1.jpg',
                name: 'Elegant Diamond Necklace Set',
                price: '₹24,999',
                description: 'Suitable for: All occasions and celebrations. This stunning diamond necklace set features premium quality stones set in pure gold. Perfect for weddings, parties, and special occasions. The intricate design showcases traditional craftsmanship with a modern touch.'
            },
            2: {
                video: 'videos/jewellery2.mp4',
                image: 'images/product2.jpg',
                name: 'Traditional Gold Earrings',
                price: '₹18,499',
                description: 'Suitable for: Daily wear and special occasions. Beautifully crafted traditional gold earrings that complement any outfit. Made from 22K gold with intricate detailing. Lightweight and comfortable for all-day wear.'
            },
            3: {
                video: 'videos/jewellery3.mp4',
                image: 'images/product3.jpg',
                name: 'Pearl & Crystal Bracelet',
                price: '₹12,999',
                description: 'Suitable for: Parties and evening events. Elegant bracelet featuring genuine pearls and sparkling crystals. The perfect accessory to add sophistication to your look. Adjustable clasp for comfortable fit.'
            },
            4: {
                video: 'videos/jewellery4.mp4',
                image: 'images/product4.jpg',
                name: 'Designer Diamond Ring',
                price: '₹32,499',
                description: 'Suitable for: Engagements and special moments. Exquisite designer diamond ring with a unique contemporary design. Features conflict-free diamonds set in platinum. A timeless piece that symbolizes eternal love.'
            },
            5: {
                video: 'videos/jewellery5.mp4',
                image: 'images/product5.jpg',
                name: 'Royal Choker Set',
                price: '₹45,999',
                description: 'Suitable for: Weddings and grand celebrations. Luxurious royal choker set adorned with premium stones and intricate gold work. Includes matching earrings. Perfect for brides and special occasions requiring regal elegance.'
            }
        };

        // Arrow navigation for main reel track
        const jmTrack = document.querySelector('.jm-reels-track');
        const jmPrevBtn = document.querySelector('.jm-reels-prev');
        const jmNextBtn = document.querySelector('.jm-reels-next');

        jmPrevBtn.addEventListener('click', () => {
            jmTrack.scrollBy({ left: -300, behavior: 'smooth' });
        });

        jmNextBtn.addEventListener('click', () => {
            jmTrack.scrollBy({ left: 300, behavior: 'smooth' });
        });

        // Modal functionality
        const jmModal = document.getElementById('jmModal');
        const jmModalCloseBtn = document.getElementById('jmModalClose');
        const jmModalVideo = document.getElementById('jmModalVideo');
        const jmModalProductImage = document.getElementById('jmModalProductImage');
        const jmModalTitle = document.getElementById('jmModalTitle');
        const jmModalPrice = document.getElementById('jmModalPrice');
        const jmModalDescription = document.getElementById('jmModalDescription');

        const jmModalPrev = document.querySelector('.jm-modal-prev');
        const jmModalNext = document.querySelector('.jm-modal-next');

        const jmCards = Array.from(document.querySelectorAll('.jm-reel-card'));
        let jmCurrentIndex = 0;

        // Touch/swipe handling for mobile
        let touchStartY = 0;
        let touchEndY = 0;
        const swipeThreshold = 50;

        function jmOpenProductByIndex(index) {
            if (index < 0) index = jmCards.length - 1;
            if (index >= jmCards.length) index = 0;
            jmCurrentIndex = index;

            const productId = jmCards[jmCurrentIndex].getAttribute('data-product');
            const product = jmProducts[productId];
            if (!product) return;

            jmModalVideo.pause();
            jmModalVideo.src = product.video;
            jmModalVideo.muted = false; // Enable sound for modal
            jmModalVideo.load();
            jmModalVideo.play();

            jmModalProductImage.src = product.image;
            jmModalProductImage.alt = product.name;
            jmModalTitle.textContent = product.name;
            jmModalPrice.textContent = product.price;
            jmModalDescription.textContent = product.description;

            jmModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        jmCards.forEach((card, index) => {
            card.addEventListener('click', () => jmOpenProductByIndex(index));
        });

        jmModalPrev.addEventListener('click', (e) => {
            e.stopPropagation();
            jmOpenProductByIndex(jmCurrentIndex - 1);
        });

        jmModalNext.addEventListener('click', (e) => {
            e.stopPropagation();
            jmOpenProductByIndex(jmCurrentIndex + 1);
        });

        // Touch events for swipe navigation
        jmModal.addEventListener('touchstart', (e) => {
            touchStartY = e.touches[0].clientY;
        }, { passive: true });

        jmModal.addEventListener('touchend', (e) => {
            touchEndY = e.changedTouches[0].clientY;
            handleSwipe();
        }, { passive: true });

        function handleSwipe() {
            const swipeDistance = touchStartY - touchEndY;
            
            if (Math.abs(swipeDistance) > swipeThreshold) {
                if (swipeDistance > 0) {
                    // Swiped up - next video
                    jmOpenProductByIndex(jmCurrentIndex + 1);
                } else {
                    // Swiped down - previous video
                    jmOpenProductByIndex(jmCurrentIndex - 1);
                }
            }
        }

        function jmCloseProductModal() {
            jmModal.classList.remove('active');
            jmModalVideo.pause();
            jmModalVideo.muted = true; // Mute again when closed
            jmModalVideo.currentTime = 0;
            document.body.style.overflow = 'auto';
        }

        jmModalCloseBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            jmCloseProductModal();
        });

        jmModal.addEventListener('click', (e) => {
            if (e.target === jmModal) {
                jmCloseProductModal();
            }
        });

        document.addEventListener('keydown', (e) => {
            if (!jmModal.classList.contains('active')) return;

            if (e.key === 'Escape') {
                jmCloseProductModal();
            } else if (e.key === 'ArrowLeft') {
                jmOpenProductByIndex(jmCurrentIndex - 1);
            } else if (e.key === 'ArrowRight') {
                jmOpenProductByIndex(jmCurrentIndex + 1);
            }
        });

        document.querySelector('.jm-btn-add-cart').addEventListener('click', () => {
            alert('Product added to cart!');
        });

        document.querySelector('.jm-btn-cart-icon').addEventListener('click', () => {
            alert('Added to wishlist!');
        });

        document.querySelector('.jm-btn-more-info').addEventListener('click', () => {
            alert('Redirecting to product page...');
        });
   