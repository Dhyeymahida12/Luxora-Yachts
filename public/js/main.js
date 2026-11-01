(() => {
  // Solid navbar after scrolling past the top
  const nav = document.getElementById('nav');
  const onScroll = () => nav.classList.toggle('is-solid', window.scrollY > 60);
  onScroll();
  window.addEventListener('scroll', onScroll, { passive: true });

  // Compact navigation panel
  const drawer = document.getElementById('drawer');
  const menuButton = document.getElementById('menuBtn');
  const closeButton = document.getElementById('drawerClose');
  const toggle = (open, restoreFocus = true) => {
    drawer.classList.toggle('is-open', open);
    drawer.setAttribute('aria-hidden', String(!open));
    drawer.inert = !open;
    menuButton.setAttribute('aria-expanded', String(open));

    if (open) {
      closeButton.focus();
    } else if (restoreFocus) {
      menuButton.focus();
    }
  };
  menuButton.addEventListener('click', () => toggle(true));
  closeButton.addEventListener('click', () => toggle(false));
  document.addEventListener('click', (event) => {
    if (drawer.classList.contains('is-open')
      && !drawer.contains(event.target)
      && !menuButton.contains(event.target)) {
      toggle(false, false);
    }
  });
  document.addEventListener('keydown', (event) => {
    if (drawer.classList.contains('is-open') && event.key === 'Escape') toggle(false);
  });

  // Blur + slide reveal when the image scrolls into view
  const io = new IntersectionObserver((entries) => {
    entries.forEach((en) => {
      if (en.isIntersecting) { en.target.classList.add('is-in'); io.unobserve(en.target); }
    });
  }, { threshold: 0.25 });
  document.querySelectorAll('.blur-reveal').forEach((el) => io.observe(el));
})();
