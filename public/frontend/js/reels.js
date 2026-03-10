
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


