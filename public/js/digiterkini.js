/**
 * Digiterkini News Portal - JavaScript Controller
 */

(function () {
  'use strict';

  // 1. Dark Mode Toggle
  const DARK_MODE_KEY = 'bk-darkmode';
  const html = document.documentElement;
  const darkModeBtn = document.getElementById('darkModeBtn');
  const drawerDarkModeBtn = document.getElementById('drawerDarkModeBtn');

  function initDarkMode() {
    const isDark = localStorage.getItem(DARK_MODE_KEY) === '1';
    if (isDark) {
      html.classList.add('dark-mode');
      updateDarkModeIcons(true);
    }
  }

  function toggleDarkMode() {
    const isDark = html.classList.toggle('dark-mode');
    localStorage.setItem(DARK_MODE_KEY, isDark ? '1' : '0');
    updateDarkModeIcons(isDark);
  }

  function updateDarkModeIcons(isDark) {
    const iconClass = isDark ? 'fa-sun' : 'fa-moon';
    if (darkModeBtn) {
      const icon = darkModeBtn.querySelector('i');
      if (icon) {
        icon.className = `fas ${iconClass}`;
      }
    }
    if (drawerDarkModeBtn) {
      const icon = drawerDarkModeBtn.querySelector('i');
      if (icon) {
        icon.className = `fas ${iconClass}`;
      }
    }
  }

  if (darkModeBtn) {
    darkModeBtn.addEventListener('click', toggleDarkMode);
  }
  if (drawerDarkModeBtn) {
    drawerDarkModeBtn.addEventListener('click', toggleDarkMode);
  }

  initDarkMode();

  // 2. Mobile Sidebar Drawer
  const menuToggle = document.getElementById('menuToggle');
  const mobileNavToggle = document.getElementById('mobileNavToggle');
  const sidebarOverlay = document.getElementById('sidebarOverlay');
  const sidebarDrawer = document.getElementById('sidebarDrawer');
  const sidebarClose = document.getElementById('sidebarClose');

  function openSidebar() {
    if (sidebarOverlay) sidebarOverlay.classList.add('active');
    if (sidebarDrawer) sidebarDrawer.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeSidebar() {
    if (sidebarOverlay) sidebarOverlay.classList.remove('active');
    if (sidebarDrawer) sidebarDrawer.classList.remove('active');
    document.body.style.overflow = '';
  }

  if (menuToggle) menuToggle.addEventListener('click', openSidebar);
  if (mobileNavToggle) mobileNavToggle.addEventListener('click', openSidebar);
  if (sidebarClose) sidebarClose.addEventListener('click', closeSidebar);
  if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeSidebar();
  });

  // 3. Font Size Resizer (Single Article)
  const articleBody = document.getElementById('articleBody');
  const fontDecrease = document.getElementById('fontDecrease');
  const fontReset = document.getElementById('fontReset');
  const fontIncrease = document.getElementById('fontIncrease');
  const fontBtns = [fontDecrease, fontReset, fontIncrease];

  if (articleBody) {
    const defaultFontSize = 16.5; // in px
    let currentFontSize = defaultFontSize;

    function setFontSize(size, activeBtn) {
      currentFontSize = size;
      articleBody.style.fontSize = size + 'px';
      fontBtns.forEach((btn) => btn && btn.classList.remove('font-resizer__btn--active'));
      if (activeBtn) activeBtn.classList.add('font-resizer__btn--active');
    }

    if (fontDecrease) {
      fontDecrease.addEventListener('click', function () {
        setFontSize(14.5, fontDecrease);
      });
    }
    if (fontReset) {
      fontReset.addEventListener('click', function () {
        setFontSize(defaultFontSize, fontReset);
      });
    }
    if (fontIncrease) {
      fontIncrease.addEventListener('click', function () {
        setFontSize(19.5, fontIncrease);
      });
    }
  }

  // 4. Copy Link Button with Modal Toast
  const copyBtns = document.querySelectorAll('.js-copy-link');
  const copyModal = document.getElementById('copyModal');
  let copyTimeout = null;

  copyBtns.forEach((btn) => {
    btn.addEventListener('click', function () {
      const url = this.getAttribute('data-url') || window.location.href;
      if (navigator.clipboard) {
        navigator.clipboard.writeText(url).then(showCopyToast);
      } else {
        // Fallback
        const dummy = document.createElement('input');
        document.body.appendChild(dummy);
        dummy.value = url;
        dummy.select();
        document.execCommand('copy');
        document.body.removeChild(dummy);
        showCopyToast();
      }
    });
  });

  function showCopyToast() {
    if (!copyModal) return;
    copyModal.classList.add('active');
    if (copyTimeout) clearTimeout(copyTimeout);
    copyTimeout = setTimeout(() => {
      copyModal.classList.remove('active');
    }, 3000);
  }

  // 5. Back to Top Button
  const backToTop = document.getElementById('backToTop');
  if (backToTop) {
    window.addEventListener('scroll', function () {
      if (window.scrollY > 400) {
        backToTop.classList.add('show');
      } else {
        backToTop.classList.remove('show');
      }
    });

    backToTop.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  // 6. AJAX Load More Articles
  const btnLoadMore = document.getElementById('btnLoadMore');
  const articleList = document.getElementById('articleList');

  if (btnLoadMore && articleList) {
    let currentPage = parseInt(btnLoadMore.getAttribute('data-page') || '1', 10);
    let isLoading = false;

    btnLoadMore.addEventListener('click', function () {
      if (isLoading) return;
      isLoading = true;
      btnLoadMore.disabled = true;
      const originalText = btnLoadMore.innerHTML;
      btnLoadMore.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memuat...';

      const nextPage = currentPage + 1;
      const url = `/?page=${nextPage}`;

      fetch(url, {
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
        },
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.html) {
            articleList.insertAdjacentHTML('beforeend', data.html);
            currentPage = nextPage;
            btnLoadMore.setAttribute('data-page', currentPage);

            if (!data.hasMore) {
              btnLoadMore.parentElement.remove();
            } else {
              btnLoadMore.disabled = false;
              btnLoadMore.innerHTML = originalText;
            }
          } else {
            btnLoadMore.parentElement.remove();
          }
          isLoading = false;
        })
        .catch(() => {
          btnLoadMore.disabled = false;
          btnLoadMore.innerHTML = originalText;
          isLoading = false;
        });
    });
  }

  // 7. AJAX Comment Submission (Single Article)
  const commentForm = document.getElementById('commentForm');
  const commentList = document.getElementById('commentList');

  if (commentForm) {
    commentForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const submitBtn = commentForm.querySelector('button[type="submit"]');
      const originalBtnText = submitBtn.innerHTML;
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';

      const formData = new FormData(commentForm);
      const actionUrl = commentForm.getAttribute('action');

      fetch(actionUrl, {
        method: 'POST',
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: formData,
      })
        .then((res) => res.json())
        .then((data) => {
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalBtnText;

          if (data.success) {
            commentForm.reset();
            const alertBox = document.getElementById('commentAlert');
            if (alertBox) {
              alertBox.style.display = 'block';
              alertBox.innerText = data.message;
              setTimeout(() => { alertBox.style.display = 'none'; }, 4000);
            }

            if (data.comment && commentList) {
              const newCommentHtml = `
                <div class="comment-item">
                  <div class="comment-item__head">
                    <span class="comment-item__author"><i class="fas fa-user-circle"></i> ${data.comment.name}</span>
                    <span class="comment-item__date">${data.comment.created_at}</span>
                  </div>
                  <p class="comment-item__text">${data.comment.comment}</p>
                </div>
              `;
              commentList.insertAdjacentHTML('afterbegin', newCommentHtml);
            }
          }
        })
        .catch(() => {
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalBtnText;
          alert('Terjadi kesalahan saat mengirim komentar. Silakan coba lagi.');
        });
    });
  }
})();
