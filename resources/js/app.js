// Mobile menu functionality
document.addEventListener('DOMContentLoaded', function() {
  const toggle = document.getElementById('mobile-menu-toggle');
  const nav = document.getElementById('mobile-nav');
  const overlay = document.getElementById('mobile-overlay');
  const closeBtn = document.getElementById('mobile-nav-close');

  const closeMenu = () => {
    if (!toggle || !nav || !overlay) return;
    toggle.classList.remove('active');
    nav.classList.remove('is-open');
    overlay.classList.remove('is-visible');
    document.body.style.overflow = '';
    toggle.setAttribute('aria-expanded', 'false');
  };

  const openMenu = () => {
    if (!toggle || !nav || !overlay) return;
    nav.classList.add('is-open');
    overlay.classList.add('is-visible');
    toggle.classList.add('active');
    document.body.style.overflow = 'hidden';
    toggle.setAttribute('aria-expanded', 'true');
  };

  if (toggle && nav && overlay) {
    toggle.addEventListener('click', function() {
      if (nav.classList.contains('is-open')) {
        closeMenu();
      } else {
        openMenu();
      }
    });

    overlay.addEventListener('click', closeMenu);

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

    // Auto hide on resize to desktop
    const mq = window.matchMedia('(min-width: 960px)');
    const handleResize = () => {
      if (mq.matches) {
        closeMenu();
      }
    };
    if (mq.addEventListener) {
      mq.addEventListener('change', handleResize);
    } else {
      mq.addListener(handleResize);
    }
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
  const slides = document.querySelectorAll('.hero-slide');
  const prev = document.querySelector('.hero-prev');
  const next = document.querySelector('.hero-next');

  if (slider && track && slides.length > 1) {
    let index = 0;
    const total = slides.length;
    let timer = null;

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
/*=============== SHOW MODAL ===============*/
const openBtn = document.querySelector(".share__modal_btn");
const modal = document.querySelector(".share__modal");

if (openBtn && modal) {
  openBtn.addEventListener("click", () => {
    modal.classList.add("show-modal");
  });
}

/*=============== CLOSE MODAL ===============*/
const closeBtn = document.querySelector(".close_modal_btn");

function closeModal() {
  modal.classList.remove("show-modal");
}
closeBtn.addEventListener("click", closeModal);

/*====== ESC BUTTON TO CLOSE MODAL ======*/
document.addEventListener("keydown", (e) => {
  if (e.key === "Escape") {
    closeModal();
  }
});