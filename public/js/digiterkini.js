/**
 * SmartNews Portal - Interactive JavaScript & Animations
 */

document.addEventListener('DOMContentLoaded', () => {

    /* ==========================================================================
       1. HERO SLIDER SWIPER INITIALIZATION
       ========================================================================== */
    if (typeof Swiper !== 'undefined' && document.getElementById('heroSwiper')) {
        new Swiper('#heroSwiper', {
            slidesPerView: 1,
            spaceBetween: 18,
            loop: true,
            speed: 700,
            autoplay: {
                delay: 4500,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 18,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                }
            },
            navigation: {
                nextEl: '.hero-swiper__next',
                prevEl: '.hero-swiper__prev',
            },
            pagination: {
                el: '.hero-swiper__pagination',
                clickable: true,
            },
        });
    }

    /* ==========================================================================
       2. DARK / LIGHT THEME TOGGLE WITH LOGO SWITCH
       ========================================================================== */
    const darkModeBtn = document.getElementById('darkModeBtn');
    const drawerDarkModeBtn = document.getElementById('drawerDarkModeBtn');
    const html = document.documentElement;

    function applyTheme(isDark) {
        if (isDark) {
            html.classList.add('dark-mode');
            localStorage.setItem('smartnews_theme', 'dark');
            updateDarkModeIcons(true);
            switchLogo(true);
        } else {
            html.classList.remove('dark-mode');
            localStorage.setItem('smartnews_theme', 'light');
            updateDarkModeIcons(false);
            switchLogo(false);
        }
    }

    function updateDarkModeIcons(isDark) {
        const iconClass = isDark ? 'fa-sun' : 'fa-moon';
        if (darkModeBtn) {
            darkModeBtn.innerHTML = `<i class="fas ${iconClass}"></i>`;
        }
        if (drawerDarkModeBtn) {
            drawerDarkModeBtn.innerHTML = `<i class="fas ${iconClass}"></i>`;
        }
    }

    function switchLogo(isDark) {
        const siteLogos = document.querySelectorAll('.site-logo-main, .site-logo-img');
        siteLogos.forEach(logo => {
            const lightSrc = logo.getAttribute('data-logo-light') || logo.src;
            const darkSrc = logo.getAttribute('data-logo-dark') || lightSrc;
            logo.src = isDark ? darkSrc : lightSrc;
        });
    }

    // Initialize Theme from localStorage or system preference
    const savedTheme = localStorage.getItem('smartnews_theme');
    if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        applyTheme(true);
    } else {
        applyTheme(false);
    }

    if (darkModeBtn) {
        darkModeBtn.addEventListener('click', () => {
            const isDark = html.classList.contains('dark-mode');
            applyTheme(!isDark);
        });
    }

    if (drawerDarkModeBtn) {
        drawerDarkModeBtn.addEventListener('click', () => {
            const isDark = html.classList.contains('dark-mode');
            applyTheme(!isDark);
        });
    }

    /* ==========================================================================
       3. OFFCANVAS MOBILE DRAWER & BACKDROP
       ========================================================================== */
    const menuToggle = document.getElementById('menuToggle');
    const mobileNavToggle = document.getElementById('mobileNavToggle');
    const sidebarDrawer = document.getElementById('sidebarDrawer');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const sidebarClose = document.getElementById('sidebarClose');

    function openDrawer() {
        if (sidebarDrawer && sidebarOverlay) {
            sidebarDrawer.classList.add('active');
            sidebarOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeDrawer() {
        if (sidebarDrawer && sidebarOverlay) {
            sidebarDrawer.classList.remove('active');
            sidebarOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    if (menuToggle) menuToggle.addEventListener('click', openDrawer);
    if (mobileNavToggle) mobileNavToggle.addEventListener('click', openDrawer);
    if (sidebarClose) sidebarClose.addEventListener('click', closeDrawer);
    if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeDrawer);

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && sidebarDrawer && sidebarDrawer.classList.contains('active')) {
            closeDrawer();
        }
    });

    /* ==========================================================================
       4. BACK TO TOP BUTTON
       ========================================================================== */
    const backToTop = document.getElementById('backToTop');
    if (backToTop) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 350) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });

        backToTop.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    /* ==========================================================================
       5. DYNAMIC FONT RESIZER (SINGLE ARTICLE)
       ========================================================================== */
    const articleBody = document.getElementById('articleBody');
    const fontDecrease = document.getElementById('fontDecrease');
    const fontReset = document.getElementById('fontReset');
    const fontIncrease = document.getElementById('fontIncrease');
    const resizerBtns = [fontDecrease, fontReset, fontIncrease];

    if (articleBody && fontReset) {
        const sizes = {
            small: '14.5px',
            default: '16.5px',
            large: '19.5px'
        };

        function setFontSize(sizeKey, activeBtn) {
            articleBody.style.fontSize = sizes[sizeKey];
            resizerBtns.forEach(btn => btn && btn.classList.remove('font-resizer__btn--active'));
            if (activeBtn) activeBtn.classList.add('font-resizer__btn--active');
        }

        if (fontDecrease) fontDecrease.addEventListener('click', () => setFontSize('small', fontDecrease));
        if (fontReset) fontReset.addEventListener('click', () => setFontSize('default', fontReset));
        if (fontIncrease) fontIncrease.addEventListener('click', () => setFontSize('large', fontIncrease));
    }

    /* ==========================================================================
       6. COPY LINK TO CLIPBOARD MODAL TOAST
       ========================================================================== */
    const copyBtns = document.querySelectorAll('.js-copy-link');
    const copyModal = document.getElementById('copyModal');
    let copyModalTimeout = null;

    copyBtns.forEach(btn => {
        btn.addEventListener('click', async (e) => {
            e.preventDefault();
            const urlToCopy = btn.getAttribute('data-url') || window.location.href;

            try {
                if (navigator.clipboard && window.isSecureContext) {
                    await navigator.clipboard.writeText(urlToCopy);
                } else {
                    const tempInput = document.createElement('input');
                    tempInput.value = urlToCopy;
                    document.body.appendChild(tempInput);
                    tempInput.select();
                    document.execCommand('copy');
                    document.body.removeChild(tempInput);
                }

                showCopyToast();
            } catch (err) {
                console.error('Failed to copy text: ', err);
            }
        });
    });

    function showCopyToast() {
        if (!copyModal) return;
        copyModal.classList.add('active');

        if (copyModalTimeout) clearTimeout(copyModalTimeout);
        copyModalTimeout = setTimeout(() => {
            copyModal.classList.remove('active');
        }, 3000);
    }

    /* ==========================================================================
       7. AJAX LOAD MORE NEWS FEED
       ========================================================================== */
    const btnLoadMore = document.getElementById('btnLoadMore');
    const articleList = document.getElementById('articleList');

    if (btnLoadMore && articleList) {
        btnLoadMore.addEventListener('click', async () => {
            let currentPage = parseInt(btnLoadMore.getAttribute('data-page') || 1);
            let nextPage = currentPage + 1;

            btnLoadMore.disabled = true;
            btnLoadMore.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memuat...';

            try {
                const response = await fetch(`/?page=${nextPage}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) throw new Error('Network error');

                const data = await response.json();

                if (data.html) {
                    articleList.insertAdjacentHTML('beforeend', data.html);
                    btnLoadMore.setAttribute('data-page', nextPage);

                    // Observe newly appended feed items
                    if (window.observeNewFadeUpElements) {
                        window.observeNewFadeUpElements(articleList);
                    }
                }

                if (!data.hasMore) {
                    btnLoadMore.parentElement.innerHTML = '<p style="color: var(--text-muted); font-size: 13.5px; font-weight: 600;">Semua berita telah dimuat.</p>';
                } else {
                    btnLoadMore.disabled = false;
                    btnLoadMore.innerHTML = '<i class="fas fa-sync-alt"></i> Muat Lainnya';
                }
            } catch (err) {
                console.error('Error loading more articles:', err);
                btnLoadMore.disabled = false;
                btnLoadMore.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Gagal, coba lagi';
            }
        });
    }

    /* ==========================================================================
       8. AJAX COMMENT SUBMISSION
       ========================================================================== */
    const commentForm = document.getElementById('commentForm');
    const commentList = document.getElementById('commentList');
    const commentAlert = document.getElementById('commentAlert');

    if (commentForm && commentList) {
        commentForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const submitBtn = commentForm.querySelector('.btn-submit');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';

            const formData = new FormData(commentForm);
            const actionUrl = commentForm.getAttribute('action');

            try {
                const response = await fetch(actionUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    commentAlert.style.display = 'block';
                    commentAlert.style.backgroundColor = '#d1fae5';
                    commentAlert.style.color = '#065f46';
                    commentAlert.innerHTML = `<i class="fas fa-check-circle"></i> ${data.message}`;

                    // Prepend new comment to list
                    if (data.comment) {
                        const newCommentHtml = `
                            <div class="comment-item fade-up-init fade-up-in">
                                <div class="comment-item__head">
                                    <span class="comment-item__author"><i class="fas fa-user-circle"></i> ${data.comment.name}</span>
                                    <span class="comment-item__date">Baru saja</span>
                                </div>
                                <p class="comment-item__text">${data.comment.comment}</p>
                            </div>
                        `;
                        commentList.insertAdjacentHTML('afterbegin', newCommentHtml);
                    }

                    commentForm.reset();
                } else {
                    commentAlert.style.display = 'block';
                    commentAlert.style.backgroundColor = '#fee2e2';
                    commentAlert.style.color = '#991b1b';
                    commentAlert.innerHTML = `<i class="fas fa-exclamation-circle"></i> Terjadi kesalahan dalam mengirim komentar.`;
                }
            } catch (err) {
                console.error(err);
                commentAlert.style.display = 'block';
                commentAlert.style.backgroundColor = '#fee2e2';
                commentAlert.style.color = '#991b1b';
                commentAlert.innerHTML = `<i class="fas fa-exclamation-circle"></i> Gagal menghubungi server.`;
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        });
    }

    /* ==========================================================================
       9. READING SCROLL PROGRESS METER (RED INDICATOR)
       ========================================================================== */
    const scrollProgressBar = document.getElementById('scrollProgressBar');
    if (scrollProgressBar) {
        window.addEventListener('scroll', () => {
            const winScroll = document.documentElement.scrollTop || document.body.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = height > 0 ? (winScroll / height) * 100 : 0;
            scrollProgressBar.style.width = scrolled + '%';
        }, { passive: true });
    }

    /* ==========================================================================
       10. SCROLL FADE UP ANIMATION OBSERVER
       ========================================================================== */
    const animTargets = document.querySelectorAll(
        '.featured-article, .article-card, .feed-item, .sidebar-widget, .section-head, .single-content, .comments-section, .footer-col'
    );

    if ('IntersectionObserver' in window) {
        const fadeUpObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-up-in');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            root: null,
            threshold: 0.08,
            rootMargin: '0px 0px -30px 0px'
        });

        animTargets.forEach(el => {
            el.classList.add('fade-up-init');
            fadeUpObserver.observe(el);
        });

        // Function for newly loaded AJAX feed items
        window.observeNewFadeUpElements = function(container) {
            if (container) {
                container.querySelectorAll('.feed-item:not(.fade-up-init)').forEach(el => {
                    el.classList.add('fade-up-init');
                    fadeUpObserver.observe(el);
                });
            }
        };
    } else {
        animTargets.forEach(el => el.classList.add('fade-up-in'));
    }

});
