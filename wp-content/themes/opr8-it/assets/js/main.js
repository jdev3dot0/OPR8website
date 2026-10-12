(function () {
  var toggle = document.querySelector("[data-nav-toggle]");
  var nav = document.querySelector("[data-primary-nav]");
  if (toggle && nav) {
    toggle.addEventListener("click", function () {
      var open = nav.classList.toggle("is-open");
      toggle.setAttribute("aria-expanded", open ? "true" : "false");
    });
  }

  var hero = document.querySelector("[data-hero]");
  if (!hero) return;

  var slides = Array.prototype.slice.call(hero.querySelectorAll(".hero-slide"));
  var dotsWrap = hero.querySelector("[data-hero-dots]");
  var dots = dotsWrap
    ? Array.prototype.slice.call(dotsWrap.querySelectorAll("button"))
    : [];
  var index = 0;
  var timer;

  function show(i) {
    index = (i + slides.length) % slides.length;
    slides.forEach(function (slide, n) {
      slide.classList.toggle("is-active", n === index);
    });
    dots.forEach(function (dot, n) {
      dot.classList.toggle("is-active", n === index);
    });
  }

  function next() {
    show(index + 1);
  }

  function start() {
    stop();
    timer = window.setInterval(next, 5500);
  }

  function stop() {
    if (timer) window.clearInterval(timer);
  }

  dots.forEach(function (dot, n) {
    dot.addEventListener("click", function () {
      show(n);
      start();
    });
  });

  hero.addEventListener("mouseenter", stop);
  hero.addEventListener("mouseleave", start);
  start();
})();
