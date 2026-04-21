(function () {
  'use strict';

  const slider = document.getElementById('heroSlider');
  if (!slider) return;

  const slides = slider.querySelectorAll('.hero__slide');
  if (slides.length <= 1) return;

  let current = 0;
  const INTERVAL = 5000;

  setInterval(() => {
    slides[current].classList.remove('is-active');
    current = (current + 1) % slides.length;
    slides[current].classList.add('is-active');
  }, INTERVAL);
})();
