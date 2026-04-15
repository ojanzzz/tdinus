// Mobile menu functionality
document.documentElement.classList.add('js');
document.addEventListener('DOMContentLoaded', function() {
  const toggle = document.getElementById('mobile-menu-toggle');
  const nav = document.getElementById('mobile-nav');
  const overlay = document.getElementById('mobile-overlay');
  const closeBtn = document.getElementById('mobile-nav-close');

  const hasMenu = !!(toggle && nav);

  if (nav) {
    nav.setAttribute('aria-hidden', 'true');
  }

  if (toggle) {
    toggle.setAttribute('aria-expanded', 'false');
  }

  // Ensure body styles are clean on load
  document.body.style.overflow = '';
  document.body.style.position = '';
  document.body.style.width = '';

  const closeMenu = () => {
    if (!hasMenu) return;
    toggle.classList.remove('active');
    nav.classList.remove('is-open');
    if (overlay) overlay.classList.remove('is-visible');
    toggle.setAttribute('aria-expanded', 'false');
    nav.setAttribute('aria-hidden', 'true');
  };

  const openMenu = () => {
    if (!hasMenu) return;
    nav.classList.add('is-open');
    if (overlay) overlay.classList.add('is-visible');
    toggle.classList.add('active');
    toggle.setAttribute('aria-expanded', 'true');
    nav.setAttribute('aria-hidden', 'false');
  };

  if (hasMenu) {
    toggle.addEventListener('click', function() {
      if (nav.classList.contains('is-open')) {
        closeMenu();
      } else {
        openMenu();
      }
    });

    if (overlay) {
      overlay.addEventListener('click', closeMenu);
    }

    if (closeBtn) {
      closeBtn.addEventListener('click', closeMenu);
    }

    // Close on escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        closeMenu();
      }
    });

    // Close on link click (mobile)
    const mobileLinks = nav.querySelectorAll('a');
    mobileLinks.forEach(link => {
      link.addEventListener('click', closeMenu);
    });

    // Auto hide on resize to desktop (updated breakpoint)
    const mq = window.matchMedia('(min-width: 769px)');
    const handleResize = () => {
      if (mq.matches) {
        closeMenu();
      }
    };
    window.addEventListener('resize', handleResize);
    window.addEventListener('orientationchange', handleResize);

    // Ensure clean state on load
    closeMenu();
  }

  // Swipe to close gesture
  let startX = 0;
  let startY = 0;
  let isSwiping = false;

  const handleTouchStart = (e) => {
    if (!nav.classList.contains('is-open')) return;
    startX = e.touches[0].clientX;
    startY = e.touches[0].clientY;
    isSwiping = true;
  };

  const handleTouchMove = (e) => {
    if (!isSwiping) return;
    const currentX = e.touches[0].clientX;
    const diffX = currentX - startX;
    if (Math.abs(diffX) > 50 && Math.abs(diffX) > Math.abs(e.touches[0].clientY - startY)) {
      if (diffX > 0) { // Swipe right to close
        nav.style.transform = `translateX(${Math.min(diffX, 100)}px)`;
      }
    }
  };

  const handleTouchEnd = (e) => {
    if (!isSwiping) return;
    const endX = e.changedTouches[0].clientX;
    const diffX = endX - startX;
    isSwiping = false;
    nav.style.transform = '';
    
    if (diffX > 100) { // Threshold for close
      closeMenu();
    }
  };

  if (nav) {
    nav.addEventListener('touchstart', handleTouchStart, { passive: true });
    nav.addEventListener('touchmove', handleTouchMove, { passive: false });
    nav.addEventListener('touchend', handleTouchEnd, { passive: true });
  }

  // Focus trap for accessibility
  const trapFocus = (e) => {
    if (!nav.classList.contains('is-open')) return;
    const focusable = nav.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
    const first = focusable[0];
    const last = focusable[focusable.length - 1];

    if (e.key === 'Tab') {
      if (e.shiftKey) {
        if (document.activeElement === first) {
          e.preventDefault();
          last.focus();
        }
      } else {
        if (document.activeElement === last) {
          e.preventDefault();
          first.focus();
        }
      }
    }
  };

  if (toggle && nav) {
    toggle.addEventListener('keydown', trapFocus);
    document.addEventListener('keydown', trapFocus);
  }



  // Smooth internal link scrolling
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });

  // Hero slider
  const slider = document.querySelector('.hero-slider');
  const track = document.querySelector('.hero-slider-track');
  let slides = Array.from(document.querySelectorAll('.hero-slide'));
  const prev = document.querySelector('.hero-prev');
  const next = document.querySelector('.hero-next');

  if (slider && track && slides.length) {
    // If only one slide, clone it so slider still moves
    if (slides.length === 1) {
      const clone = slides[0].cloneNode(true);
      track.appendChild(clone);
      slides = Array.from(track.querySelectorAll('.hero-slide'));
    }

    let index = 0;
    const total = slides.length;
    let timer = null;

    track.style.width = `${total * 100}%`;

    const goTo = (i) => {
      index = (i + total) % total;
      track.style.transform = `translateX(-${index * 100}%)`;
    };

    const startAuto = () => {
      timer = setInterval(() => {
        goTo(index + 1);
      }, 5000);
    };

    const stopAuto = () => {
      if (timer) clearInterval(timer);
    };

    if (prev) {
      prev.addEventListener('click', () => {
        stopAuto();
        goTo(index - 1);
        startAuto();
      });
    }

    if (next) {
      next.addEventListener('click', () => {
        stopAuto();
        goTo(index + 1);
        startAuto();
      });
    }

    slider.addEventListener('mouseenter', stopAuto);
    slider.addEventListener('mouseleave', startAuto);

    startAuto();
  }
});




















