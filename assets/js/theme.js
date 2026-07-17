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

    // Track real header height as --header-h CSS var so the mobile off-canvas
    // panel sits flush against the header bottom with zero gap.
    function syncHeaderHeight() {
        if (mainHeader) {
            const h = Math.round(mainHeader.getBoundingClientRect().height);
            document.documentElement.style.setProperty('--header-h', h + 'px');
        }
    }
    syncHeaderHeight();
    window.addEventListener('resize', syncHeaderHeight, { passive: true });

    if (mainHeader) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                mainHeader.classList.add('scrolled');
            } else {
                mainHeader.classList.remove('scrolled');
            }
            syncHeaderHeight(); // padding changes when scrolled, remeasure
        }, { passive: true });
    }

    /* ==========================================================================
       2. MOBILE MENU — DRILL-DOWN + DESKTOP HOVER CLAMP
       ========================================================================== */
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const navMenu       = document.getElementById('navMenu');
    const navList       = navMenu ? navMenu.querySelector('.nav-list') : null;

    // ── Hamburger open / close ────────────────────────────────────────────────
    function closeNav() {
        if (!navMenu) return;
        navMenu.classList.remove('active');
        const icon = mobileMenuBtn && mobileMenuBtn.querySelector('i');
        if (icon) icon.className = 'fa-solid fa-bars';
        if (mobileMenuBtn) mobileMenuBtn.setAttribute('aria-expanded', 'false');
        if (navMenu._resetDrill) navMenu._resetDrill();
    }

    if (mobileMenuBtn && navMenu) {
        mobileMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            const opening = !navMenu.classList.contains('active');
            if (opening) {
                navMenu.classList.add('active');
                mobileMenuBtn.querySelector('i').className = 'fa-solid fa-xmark';
                mobileMenuBtn.setAttribute('aria-expanded', 'true');
            } else {
                closeNav();
            }
        });

        document.addEventListener('click', (e) => {
            if (navMenu.classList.contains('active') &&
                !navMenu.contains(e.target) &&
                !mobileMenuBtn.contains(e.target)) {
                closeNav();
            }
        });
    }

    // ── Desktop mega menu — viewport edge clamping ────────────────────────────
    document.querySelectorAll('.nav-item.is-mega').forEach(item => {
        const menu = item.querySelector('.mega-menu');
        if (!menu) return;
        item.addEventListener('mouseenter', () => {
            if (window.innerWidth <= 1024) return;
            menu.style.transform = 'translateX(-50%) translateY(0)';
            const rect = menu.getBoundingClientRect();
            const margin = 16;
            if (rect.right > window.innerWidth - margin) {
                menu.style.transform = `translateX(calc(-50% - ${rect.right - window.innerWidth + margin}px)) translateY(0)`;
            } else if (rect.left < margin) {
                menu.style.transform = `translateX(calc(-50% + ${margin - rect.left}px)) translateY(0)`;
            }
        });
        item.addEventListener('mouseleave', () => { menu.style.transform = ''; });
    });

    // ── Mobile drill-down panel system ────────────────────────────────────────
    if (navList && navMenu) {
        // Wrapper holds the sliding track
        const wrapper = document.createElement('div');
        wrapper.className = 'mobile-nav-wrapper';
        const track = document.createElement('div');
        track.className = 'mobile-nav-track';
        wrapper.appendChild(track);
        // Insert before .nav-cta so CTA stays pinned at bottom
        const cta = navMenu.querySelector('.nav-cta');
        navMenu.insertBefore(wrapper, cta || null);

        let level = 0;
        const stack = []; // stack of appended panel elements

        // Extract plain text from a nav-link (ignores icon children)
        function linkText(el) {
            return Array.from(el.childNodes)
                .filter(n => n.nodeType === Node.TEXT_NODE)
                .map(n => n.textContent.trim())
                .filter(Boolean)
                .join('') || el.textContent.trim();
        }

        function makeLink(href, text) {
            const a = document.createElement('a');
            a.href = href || '#';
            a.className = 'mobile-menu-item';
            a.textContent = text;
            return a;
        }

        function makeSubBtn(text, onClick) {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'mobile-menu-item has-sub';
            const span = document.createElement('span');
            span.textContent = text;
            const icon = document.createElement('i');
            icon.className = 'fa-solid fa-chevron-right';
            icon.setAttribute('aria-hidden', 'true');
            btn.appendChild(span);
            btn.appendChild(icon);
            btn.addEventListener('click', onClick);
            return btn;
        }

        function makeHeader(title, href) {
            const header = document.createElement('div');
            header.className = 'mobile-panel-header';

            const back = document.createElement('button');
            back.type = 'button';
            back.className = 'mobile-back-btn';
            back.innerHTML = '<i class="fa-solid fa-chevron-left" aria-hidden="true"></i><span>Back</span>';
            back.addEventListener('click', popPanel);

            const titleDiv = document.createElement('div');
            titleDiv.className = 'mobile-panel-title';
            if (href && href !== '#') {
                const a = document.createElement('a');
                a.href = href;
                a.innerHTML = `${title} <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true" style="font-size:0.65em;opacity:0.75"></i>`;
                titleDiv.appendChild(a);
            } else {
                titleDiv.textContent = title;
            }

            header.appendChild(back);
            header.appendChild(titleDiv);
            return header;
        }

        function pushPanel(panelEl) {
            track.appendChild(panelEl);
            panelEl.getBoundingClientRect(); // force reflow before transition
            level++;
            track.style.transform = `translateX(${-level * 100}%)`;
            stack.push(panelEl);
        }

        function popPanel() {
            if (level <= 0) return;
            level--;
            track.style.transform = `translateX(${-level * 100}%)`;
            const removed = stack.pop();
            if (removed) {
                // Remove after the slide animation ends
                removed.addEventListener('transitionend', () => removed.remove(), { once: true });
            }
        }

        // Build the root panel from top-level .nav-item elements
        function buildRoot() {
            const panel = document.createElement('div');
            panel.className = 'mobile-panel';
            const ul = document.createElement('ul');
            ul.className = 'mobile-menu-list';

            navList.querySelectorAll(':scope > .nav-item').forEach(navItem => {
                const navLink = navItem.querySelector(':scope > .nav-link');
                if (!navLink) return;
                const label = linkText(navLink);
                const href  = navLink.getAttribute('href') || '#';
                const li    = document.createElement('li');

                if (navItem.classList.contains('is-mega') || navItem.classList.contains('has-dropdown')) {
                    li.appendChild(makeSubBtn(label, () => pushPanel(buildSub(navItem, label, href))));
                } else {
                    li.appendChild(makeLink(href, label));
                }
                ul.appendChild(li);
            });

            panel.appendChild(ul);
            return panel;
        }

        // Build a sub-panel for a mega-menu or dropdown nav item
        function buildSub(navItem, title, href) {
            const panel = document.createElement('div');
            panel.className = 'mobile-panel';
            panel.appendChild(makeHeader(title, href));
            const ul = document.createElement('ul');
            ul.className = 'mobile-menu-list';

            if (navItem.classList.contains('is-mega')) {
                // Each mega-col → either a drill-down row or a direct link
                navItem.querySelectorAll('.mega-col').forEach(col => {
                    const li = document.createElement('li');
                    if (col.classList.contains('mega-col-solo')) {
                        const a = col.querySelector('a.mega-solo-link');
                        if (a) li.appendChild(makeLink(a.getAttribute('href'), a.textContent.trim()));
                    } else {
                        const titleEl = col.querySelector('.mega-col-title');
                        const list    = col.querySelector('.mega-col-list');
                        const colName = titleEl ? titleEl.textContent.trim() : '';
                        if (list && list.querySelector('li a')) {
                            li.appendChild(makeSubBtn(colName, () => pushPanel(buildLeaves(list, colName))));
                        }
                    }
                    if (li.firstChild) ul.appendChild(li);
                });
            } else {
                // Simple dropdown — flat list of links
                navItem.querySelectorAll('.dropdown-menu ul > li > a').forEach(a => {
                    const li = document.createElement('li');
                    li.appendChild(makeLink(a.getAttribute('href'), a.textContent.trim()));
                    ul.appendChild(li);
                });
            }

            panel.appendChild(ul);
            return panel;
        }

        // Build a leaf panel from a mega-col-list
        function buildLeaves(megaColList, title) {
            const panel = document.createElement('div');
            panel.className = 'mobile-panel';
            panel.appendChild(makeHeader(title, null));
            const ul = document.createElement('ul');
            ul.className = 'mobile-menu-list';
            megaColList.querySelectorAll('li > a').forEach(a => {
                const li = document.createElement('li');
                li.appendChild(makeLink(a.getAttribute('href'), a.textContent.trim()));
                ul.appendChild(li);
            });
            panel.appendChild(ul);
            return panel;
        }

        // Reset to root (called when the menu is closed)
        function resetDrill() {
            while (stack.length > 1) {
                const p = stack.pop();
                if (p) p.remove();
            }
            level = 0;
            track.style.transition = 'none';
            track.style.transform  = 'translateX(0)';
            // Re-enable transition after reset
            requestAnimationFrame(() => { track.style.transition = ''; });
        }

        // Initialise: append root panel and expose reset
        const rootPanel = buildRoot();
        track.appendChild(rootPanel);
        stack.push(rootPanel);
        navMenu._resetDrill = resetDrill;
    }

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

    /* ==========================================================================
       9. TEAM SECTION — TAB SWITCHING
       ========================================================================== */
    const teamTabs   = document.querySelectorAll('.team-tab');
    const teamPanels = document.querySelectorAll('.team-panel');

    teamTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const id = tab.dataset.member;
            teamTabs.forEach(t => {
                t.classList.remove('active');
                t.setAttribute('aria-selected', 'false');
            });
            teamPanels.forEach(p => p.classList.remove('active'));
            tab.classList.add('active');
            tab.setAttribute('aria-selected', 'true');
            const panel = document.getElementById('member-' + id);
            if (panel) panel.classList.add('active');
        });
    });

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

    // ── Page Builder Content Compatibility ───────────────────────────────────
    // Wraps consecutive [data-anim-type] siblings in a responsive .oc-pb-grid
    // and animates them on scroll. Handles content pasted from Elementor /
    // WPBakery pages — column counts are read from parent data-*-col attributes.
    (function () {
        // Map old-site data-desktop-col values to number of columns per row
        const desktopColMap = {
            'one': 4, 'one-fourth': 4,
            'one-third': 3,
            'one-half': 2, 'two-thirds': 2,
            'full': 1,
        };
        const tabletColMap = {
            'tablet-one': 1, 'tablet-full': 1,
            'tablet-two': 2, 'tablet-half': 2,
            'tablet-three': 3,
        };
        const mobileColMap = {
            'mobile-one': 1, 'mobile-full': 1,
            'mobile-two': 2, 'mobile-half': 2,
        };

        // Collect unique parent elements that contain [data-anim-type] children
        const parents = new Set();
        document.querySelectorAll('[data-anim-type]').forEach(el => parents.add(el.parentElement));

        parents.forEach(parent => {
            const cards = Array.from(parent.children).filter(c => c.hasAttribute('data-anim-type'));
            if (cards.length < 2) return;

            // Look for column attributes on this element or the nearest ancestor
            const src = parent.closest('[data-desktop-col]') || parent;
            const dCols = desktopColMap[src.getAttribute('data-desktop-col')] || Math.min(cards.length, 4);
            const tCols = tabletColMap[src.getAttribute('data-tablet-col')]   || Math.min(dCols, 2);
            const mCols = mobileColMap[src.getAttribute('data-mobile-col')]   || 1;

            // Build grid wrapper and move cards into it
            const grid = document.createElement('div');
            grid.className = 'oc-pb-grid';
            grid.style.setProperty('--pb-cols',        dCols);
            grid.style.setProperty('--pb-cols-tablet', tCols);
            grid.style.setProperty('--pb-cols-mobile', mCols);

            parent.insertBefore(grid, cards[0]);
            cards.forEach(c => grid.appendChild(c));
        });

        // Intersection Observer — triggers fadeInUp as cards scroll into view
        const io = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('oc-anim-done');
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('[data-anim-type]').forEach(el => io.observe(el));
    }());
});
