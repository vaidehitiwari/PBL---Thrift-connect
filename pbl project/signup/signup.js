const inputs = document.querySelectorAll(".input-field");
const toggle_btn = document.querySelectorAll(".toggle");
const main = document.querySelector("main");
const bullets = document.querySelectorAll(".bullets span");
const images = document.querySelectorAll(".image");

let currentIndex = 0;
let intervalId;

// Function to update the slider
function updateSlider(index) {
  currentIndex = index;

  images.forEach((img, i) => {
    img.classList.toggle("show", i === currentIndex);
  });

  const textSlider = document.querySelector(".text-group");
  textSlider.style.transform = `translateY(${-currentIndex * 2.2}rem)`;

  bullets.forEach((bullet, i) => {
    bullet.classList.toggle("active", i === currentIndex);
  });
}

// Function to move to the next image
function nextImage() {
  currentIndex = (currentIndex + 1) % images.length;
  updateSlider(currentIndex);
}

// Start the auto-animation
function startAutoAnimation() {
  intervalId = setInterval(nextImage, 3000);
}

// Stop the auto-animation
function stopAutoAnimation() {
  clearInterval(intervalId);
}

// Bullet click event listener
bullets.forEach((bullet, index) => {
  bullet.addEventListener("click", () => {
    stopAutoAnimation(); // Stop the auto-animation
    updateSlider(index); // Manually update the slider
    startAutoAnimation(); // Restart the auto-animation
  });
});

// Start the auto-animation when the page loads
startAutoAnimation();

// Input focus and blur animations
inputs.forEach((inp) => {
  inp.addEventListener("focus", () => {
    inp.classList.add("active");
  });
  inp.addEventListener("blur", () => {
    if (inp.value != "") return;
    inp.classList.remove("active");
  });
});

// Toggle between sign-in and sign-up forms
toggle_btn.forEach((btn) => {
  btn.addEventListener("click", () => {
    main.classList.toggle("sign-up-mode");
  });
});

const togglePassword = document.querySelectorAll(".toggle-password");

const passwordField = document.getElementById('password');
const eyeClose = document.getElementById('eye-close');
const eyeOpen = document.getElementById('eye-open');

document.querySelector('.toggle-password').addEventListener('click', function () {
  const isPasswordVisible = passwordField.type === 'text';

  if (isPasswordVisible) {
    passwordField.type = 'password';
    eyeClose.style.display = 'block';
    eyeOpen.style.display = 'none';
  } else {
    passwordField.type = 'text';
    eyeClose.style.display = 'none';
    eyeOpen.style.display = 'block';
  }
});