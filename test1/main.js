// script.js

// DOMContentLoaded ensures the script runs after the document is fully loaded
document.addEventListener('DOMContentLoaded', function() {
  // Smooth scrolling for internal anchor links
  const navLinks = document.querySelectorAll('a[href^="#"]');
  navLinks.forEach(link => {
    link.addEventListener('click', event => {
      event.preventDefault();
      const targetId = link.getAttribute('href').substring(1);
      const targetSection = document.getElementById(targetId);
      if (targetSection) {
        targetSection.scrollIntoView({ behavior: 'smooth' });
      }
    });
  });

  // Simple contact form validation and feedback
  const contactForm = document.querySelector('.contact-form');
  if (contactForm) {
    contactForm.addEventListener('submit', function(event) {
      event.preventDefault();

      const nameInput = contactForm.querySelector('#name');
      const phoneInput = contactForm.querySelector('#phone');
      const emailInput = contactForm.querySelector('#email');
      let valid = true;

      // Basic validation
      if (!nameInput.value.trim()) {
        valid = false;
        alert('Будь ласка, введіть ваше ім\'я.');
      } else if (!phoneInput.value.trim()) {
        valid = false;
        alert('Будь ласка, введіть ваш телефон.');
      }

      // If valid, simulate submission
      if (valid) {
        // Here you could send data via AJAX
        alert('Дякуємо за вашу заявку! Ми зв\'яжемося з вами найближчим часом.');
        contactForm.reset();
      }
    });
  }
});