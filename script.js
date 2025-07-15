document.addEventListener("DOMContentLoaded", () => {
    const slides = document.querySelectorAll('.slideshow-inner .slide');
    let currentSlide = 0;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            if (i === index) {
                slide.classList.add('active');
            } else {
                slide.classList.remove('active');
            }
        });
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }

    // Initial display
    if (slides.length > 0) {
        showSlide(currentSlide);
        setInterval(nextSlide, 3000); // Change slide every 3 seconds
    }

    // ✅ Load droplist on page load if visible
    if (document.getElementById('droplistResults')) {
      searchDropList();
    }

    // ✅ Load top rankings on page load
    fetch("toprank.php")
      .then(res => res.text())
      .then(data => {
        document.getElementById("topRankings").innerHTML = data;
      });
});

function toggleForm(id) {
    const sections = ['loginForm', 'registerForm', 'droplist', 'download', 'discord', 'toprank', 'rules', 'imageSlideshow'];
    const form = document.getElementById(id);

    // If the clicked form is already visible, hide it
    if (form && !form.classList.contains('hidden')) {
        form.classList.add('hidden');
        return; // Exit the function after hiding
    }

    sections.forEach(sec => {
      const el = document.getElementById(sec);
      if (el) {
        el.classList.add('hidden');
      }
    });

    if (form) {
      form.classList.remove('hidden');
      form.scrollIntoView({ behavior: 'smooth' });

      // Show image slideshow if rules section is active
      if (id === 'rules') {
        document.getElementById('imageSlideshow').classList.remove('hidden');
      } else {
        document.getElementById('imageSlideshow').classList.add('hidden');
      }
    }
  }

  function searchDropList() {
  const results = document.getElementById('droplistResults');
  results.innerHTML = "<p class='text-gray-300'>Loading drop list...</p>";

  const searchInput = document.getElementById('searchInput');
  const search = searchInput ? searchInput.value : '';
  fetch(`droplist.php?search=${encodeURIComponent(search)}`)
    .then(response => response.text())
    .then(data => {
      results.innerHTML = data;
    });
}
  document.addEventListener("DOMContentLoaded", () => {
    // ✅ Load droplist on page load if visible
    if (document.getElementById('droplistResults')) {
      searchDropList();
    }

    // ✅ Load top rankings on page load
    fetch("toprank.php")
      .then(res => res.text())
      .then(data => {
        document.getElementById("topRankings").innerHTML = data;
      });

    // Handle video playback on visibility change
    const video = document.querySelector('video');
    if (video) {
      document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
          video.pause();
        } else {
          video.play();
        }
      });
    }

    // Custom Image Slideshow Logic
    const customSlides = document.querySelectorAll('.slideshow-inner-custom .slide-custom');
    const customSlideshowInner = document.querySelector('.slideshow-inner-custom');
    let currentCustomSlide = 0;

    function showCustomSlide(index) {
        const offset = -index * 100;
        customSlideshowInner.style.transform = `translateX(${offset}%)`;
    }

    function nextCustomSlide() {
        currentCustomSlide = (currentCustomSlide + 1) % customSlides.length;
        showCustomSlide(currentCustomSlide);
    }

    if (customSlides.length > 0) {
        showCustomSlide(currentCustomSlide);
        setInterval(nextCustomSlide, 5000); // Change slide every 5 seconds
    }
});
