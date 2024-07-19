document.addEventListener("DOMContentLoaded", function () {
  const darkModeToggle = document.getElementById("js-darkMode");
  const moonIcon = document.getElementById("js-moonIcon");
  const sunIcon = document.getElementById("js-sunIcon");
  const body = document.body;
  const footer = document.querySelector(".footer");
  const instaIcon = document.getElementById("js-insta");
  const facebookIcon = document.getElementById("js-facebook");

  darkModeToggle.addEventListener("click", function () {
    body.classList.toggle("js-darkMode");
    updateIcons();
    updateFooterBackground();
    updateBackgroundImage();
  });

  function updateIcons() {
    if (body.classList.contains("js-darkMode")) {
      moonIcon.classList.add("js-hidden");
      sunIcon.classList.remove("js-hidden");
      facebookIcon.src = "./assets/images/icons/facebook-cream.webp"; // Image en mode sombre
      instaIcon.src = "./assets/images/icons/instagram-cream.webp";
    } else {
      moonIcon.classList.remove("js-hidden");
      sunIcon.classList.add("js-hidden");
      facebookIcon.src = "./assets/images/icons/facebook-blue.webp"; // Image en mode clair
      instaIcon.src = "./assets/images/icons/instagram-blue.webp";
    }
  }

  function updateFooterBackground() {
    if (body.classList.contains("js-darkMode")) {
      footer.style.backgroundColor = "#213F7D"; // Couleur de fond en mode sombre
      footer.style.color = "#fff"; // Couleur de texte en mode sombre
    } else {
      footer.style.backgroundColor = "#f0e9e1"; // Couleur de fond en mode clair
      footer.style.color = "#213F7D"; // Couleur de texte en mode clair
    }
  }

  function updateBackgroundImage() {
    if (body.classList.contains("js-darkMode")) {
      body.style.backgroundImage = 'url("./assets/images/angkor-wat2.webp")'; // Assurez-vous que le chemin est correct
    } else {
      body.style.backgroundImage = 'url("./assets/images/angkor-wat.webp")'; // Assurez-vous que le chemin est correct
    }
  }
});
