// main.js

// 1. Динамічно підставляємо поточний рік у футер
document.getElementById('year').textContent = new Date().getFullYear();

// 2. Ініціалізуємо ScrollSpy для підсвічування пунктів меню при скролі
bootstrap.ScrollSpy.getOrCreateInstance(document.body, {
  target: '#mainNav',
  offset: 120
});

// 3. Плавна поява секцій (fade-up, fade-right, zoom-in)
document.querySelectorAll('.fade-up, .fade-right, .zoom-in').forEach(el => {
  new IntersectionObserver((entries, obs) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('animate');
        obs.unobserve(entry.target);
      }
    });
  }, {
    threshold: 0.2
  }).observe(el);
});

// 4. Показуємо блок карток "Про компанію" із Bootstrap collapse + fade
document.addEventListener('DOMContentLoaded', () => {
  const aboutEl = document.getElementById('aboutCards');
  if (aboutEl) {
    // Ініціалізуємо collapse (без автоматичного toggle)
    const bsCollapse = new bootstrap.Collapse(aboutEl, { toggle: false });
    // Даємо невелику паузу, щоб спрацювала CSS-анімація fade
    setTimeout(() => bsCollapse.show(), 200);
  }
});