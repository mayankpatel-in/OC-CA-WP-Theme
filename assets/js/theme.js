/**
 * OC CA Theme - Interaction Logic
 *
 * Ported from the ANBCA prototype script.js.
 * Handles: sticky header, mobile menu, stats counter,
 * service slideshow, accordions, review carousel,
 * quote modal, form submissions, newsletter.
 *
 * @package OC_CA_Theme
 */

document.addEventListener('DOMContentLoaded', () => {

    /* ==========================================================================
       1. STICKY HEADER & SCROLL STATE
       ========================================================================== */
    const mainHeader = document.getElementById('mainHeader');

    if (mainHeader) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                mainHeader.classList.add('scrolled');
            } else {
                mainHeader.classList.remove('scrolled');
            }
        });
    }

    /* ==========================================================================
       2. MOBILE MENU & RESPONSIVE DROPDOWNS
       ========================================================================== */
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const navMenu = document.getElementById('navMenu');

    if (mobileMenuBtn && navMenu) {
        mobileMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            navMenu.classList.toggle('active');

            const icon = mobileMenuBtn.querySelector('i');
            const isOpen = navMenu.classList.contains('active');
            if (icon) {
                icon.className = isOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars';
            }
            mobileMenuBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!navMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                navMenu.classList.remove('active');
                const icon = mobileMenuBtn.querySelector('i');
                if (icon) icon.className = 'fa-solid fa-bars';
                mobileMenuBtn.setAttribute('aria-expanded', 'false');
            }
        });
    }

    // Mobile Dropdowns — click behavior instead of hover
    const dropdownItems = document.querySelectorAll('.nav-item.has-dropdown');

    dropdownItems.forEach(item => {
        const link = item.querySelector('.nav-link');
        if (link) {
            link.addEventListener('click', (e) => {
                if (window.innerWidth <= 1024) {
                    e.preventDefault();
                    e.stopPropagation();

                    dropdownItems.forEach(otherItem => {
                        if (otherItem !== item) {
                            otherItem.classList.remove('active');
                        }
                    });

                    item.classList.toggle('active');

                    const chevron = link.querySelector('i');
                    if (chevron) {
                        chevron.style.transform = item.classList.contains('active') ? 'rotate(180deg)' : '';
                    }
                }
            });
        }
    });

    /* ==========================================================================
       3. INCREMENT STATS COUNTER ANIMATION
       ========================================================================== */
    const stats = document.querySelectorAll('.stat-number');
    const statsContainer = document.getElementById('statsContainer');
    let counted = false;

    const countUp = () => {
        stats.forEach(stat => {
            const target = parseInt(stat.getAttribute('data-target'), 10);
            const duration = 2000;
            const increment = target > 100 ? Math.ceil(target / 100) : 1;
            let current = 0;

            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    stat.innerText = target;
                    clearInterval(timer);
                } else {
                    stat.innerText = current;
                }
            }, target > 100 ? 20 : Math.abs(Math.floor(duration / target)));
        });
    };

    if (statsContainer && 'IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !counted) {
                    countUp();
                    counted = true;
                    observer.unobserve(statsContainer);
                }
            });
        }, { threshold: 0.2 });

        observer.observe(statsContainer);
    } else if (statsContainer) {
        countUp();
    }

    /* ==========================================================================
       4. INTERACTIVE SERVICE SLIDER TABS
       ========================================================================== */
    const sliderTabs = document.querySelectorAll('.slider-tab');
    const sliderItems = document.querySelectorAll('.slider-item');

    sliderTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const slideIndex = tab.getAttribute('data-slide');

            sliderTabs.forEach(t => t.classList.remove('active'));
            sliderItems.forEach(item => item.classList.remove('active'));

            tab.classList.add('active');
            const targetSlide = document.getElementById(`slide-${slideIndex}`);
            if (targetSlide) {
                targetSlide.classList.add('active');
            }
        });
    });

    /* ==========================================================================
       5. ACCORDION (SEO CONTENT & FAQS)
       ========================================================================== */
    const setupAccordion = (itemSelector, headerSelector, contentSelector) => {
        const items = document.querySelectorAll(itemSelector);

        items.forEach(item => {
            const header = item.querySelector(headerSelector);
            const content = item.querySelector(contentSelector);
            if (!header || !content) return;

            header.addEventListener('click', () => {
                const isActive = item.classList.contains('active');
                item.classList.toggle('active');

                if (!isActive) {
                    content.style.maxHeight = content.scrollHeight + 'px';
                } else {
                    content.style.maxHeight = '0px';
                }
            });

            if (item.classList.contains('active')) {
                content.style.maxHeight = content.scrollHeight + 'px';
            }
        });
    };

    setupAccordion('.accordion-item', '.accordion-header', '.accordion-content');
    setupAccordion('.faq-item', '.faq-header', '.faq-content');

    /* ==========================================================================
       6. GOOGLE REVIEWS CAROUSEL
       ========================================================================== */
    const revTrack = document.getElementById('revTrack');
    const revPrev = document.getElementById('revPrev');
    const revNext = document.getElementById('revNext');
    const reviewSlides = document.querySelectorAll('.review-slide');

    if (revTrack && reviewSlides.length > 0) {
        let currentIndex = 0;
        let slideInterval;

        const updateCarousel = () => {
            revTrack.style.transform = `translateX(-${currentIndex * 100}%)`;
        };

        const nextSlide = () => {
            currentIndex = (currentIndex + 1) % reviewSlides.length;
            updateCarousel();
        };

        const prevSlide = () => {
            currentIndex = (currentIndex - 1 + reviewSlides.length) % reviewSlides.length;
            updateCarousel();
        };

        const startInterval = () => {
            slideInterval = setInterval(nextSlide, 5000);
        };

        const resetInterval = () => {
            clearInterval(slideInterval);
            startInterval();
        };

        if (revNext) revNext.addEventListener('click', () => { nextSlide(); resetInterval(); });
        if (revPrev) revPrev.addEventListener('click', () => { prevSlide(); resetInterval(); });

        revTrack.addEventListener('mouseenter', () => clearInterval(slideInterval));
        revTrack.addEventListener('mouseleave', startInterval);

        // Swipe gestures
        let startX = 0;
        revTrack.addEventListener('touchstart', (e) => { startX = e.touches[0].clientX; }, { passive: true });
        revTrack.addEventListener('touchend', (e) => {
            const endX = e.changedTouches[0].clientX;
            if (startX - endX > 50) { nextSlide(); resetInterval(); }
            else if (endX - startX > 50) { prevSlide(); resetInterval(); }
        }, { passive: true });

        startInterval();
    }

    /* ==========================================================================
       7. QUOTE MODAL OPEN / CLOSE
       ========================================================================== */
    const quoteModal = document.getElementById('quoteModal');

    const openModal = () => {
        if (quoteModal) {
            quoteModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    };

    const closeModal = () => {
        if (quoteModal) {
            quoteModal.classList.remove('active');
            document.body.style.overflow = '';
            const form = document.getElementById('modalQuoteForm');
            const successMsg = document.getElementById('modalSuccess');
            if (form && successMsg) {
                form.style.display = 'block';
                successMsg.style.display = 'none';
                form.reset();
            }
        }
    };

    // Open modal triggers
    document.querySelectorAll('#openQuoteModalBtn, .btn-quote').forEach(btn => {
        btn.addEventListener('click', openModal);
    });

    const closeBtn = document.getElementById('closeQuoteModalBtn');
    if (closeBtn) closeBtn.addEventListener('click', closeModal);

    if (quoteModal) {
        quoteModal.addEventListener('click', (e) => {
            if (e.target === quoteModal) closeModal();
        });
    }

    // Escape key closes modal
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeModal();
    });

    // Quick quote buttons on service cards
    document.querySelectorAll('.quick-quote-service').forEach(btn => {
        btn.addEventListener('click', openModal);
    });

    // Hero callback button scrolls to CTA section
    const heroCallbackBtn = document.getElementById('heroCallbackBtn');
    if (heroCallbackBtn) {
        heroCallbackBtn.addEventListener('click', () => {
            const ctaSection = document.querySelector('.cta-banner-section');
            if (ctaSection) {
                ctaSection.scrollIntoView({ behavior: 'smooth' });
                setTimeout(() => {
                    const nameInput = document.getElementById('cbName');
                    if (nameInput) nameInput.focus();
                }, 800);
            }
        });
    }

    /* ==========================================================================
       8. FORM SUBMISSION (CLIENT-SIDE DEMO ANIMATION)
       ========================================================================== */
    const setupFormSubmission = (formId, successId) => {
        const form = document.getElementById(formId);
        const successMsg = document.getElementById(successId);

        if (form && successMsg) {
            form.addEventListener('submit', (e) => {
                e.preventDefault();

                form.style.transition = 'opacity 0.3s ease';
                form.style.opacity = '0';

                setTimeout(() => {
                    form.style.display = 'none';
                    successMsg.style.display = 'block';
                    successMsg.style.opacity = '0';
                    successMsg.style.transition = 'opacity 0.3s ease';
                    successMsg.offsetHeight; // Force reflow
                    successMsg.style.opacity = '1';
                }, 300);
            });
        }
    };

    setupFormSubmission('heroQuoteForm', 'heroFormSuccess');
    setupFormSubmission('callbackForm', 'cbSuccess');
    setupFormSubmission('modalQuoteForm', 'modalSuccess');
    setupFormSubmission('subpageHeroQuoteForm', 'subpageHeroSuccess');
    setupFormSubmission('sidebarConsultForm', 'sidebarConsultSuccess');

    // Footer newsletter
    const newsletterForm = document.getElementById('newsletterForm');
    const newsletterSuccess = document.getElementById('newsletterSuccess');
    if (newsletterForm && newsletterSuccess) {
        newsletterForm.addEventListener('submit', (e) => {
            e.preventDefault();
            newsletterForm.style.display = 'none';
            newsletterSuccess.style.display = 'block';
        });
    }
});
