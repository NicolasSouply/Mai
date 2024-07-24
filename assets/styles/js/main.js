document.addEventListener("DOMContentLoaded", function () {
  // Récupération des éléments pour le mode sombre
  const darkModeToggle = document.getElementById("js-darkMode");
  const moonIcon = document.getElementById("js-moonIcon");
  const sunIcon = document.getElementById("js-sunIcon");
  const body = document.body;
  const footer = document.querySelector(".footer");
  const sections = document.querySelectorAll(
    ".hook, .gallery, .card, .end-page"
  );
  const footerLegalLinks = document.querySelectorAll(".footer__legal a");
  const instaIcon = document.getElementById("js-insta");
  const facebookIcon = document.getElementById("js-facebook");

  // Gestion du menu burger
  const burgerMenu = document.getElementById("burger-menu");
  const navLinks = document.getElementById("navLinks");

  // Gestion du mode sombre pour la version mobile
  const darkModeToggleMobile = document.getElementById("js-darkModeMobile");
  const moonIconMobile = document.getElementById("js-moonIconMobile");
  const sunIconMobile = document.getElementById("js-sunIconMobile");

  // Affichage du bouton retour en haut
  const upButtonLink = document.getElementById("up-button-link");

  // Gestion de la galerie d'images
  const galleryInner = document.querySelector(".gallery__inner");
  const containers = document.querySelectorAll(".gallery__container");

  // Fonction pour activer/désactiver le mode sombre
  const toggleDarkMode = () => {
    body.classList.toggle("dark-mode");
    body.classList.toggle("light-mode");
    updateIcons();
    updateFooterBackground();
    updateFooterLegalLinks();
    updateSectionsBackground(); // Ajout pour mettre à jour les sections
  };

  // Met à jour les icônes de mode sombre
  const updateIcons = () => {
    const isDarkMode = body.classList.contains("dark-mode");
    moonIcon?.classList.toggle("js-hidden", isDarkMode);
    sunIcon?.classList.toggle("js-hidden", !isDarkMode);
    moonIconMobile?.classList.toggle("js-hidden", isDarkMode);
    sunIconMobile?.classList.toggle("js-hidden", !isDarkMode);
    facebookIcon.src = isDarkMode
      ? "./assets/images/icons/facebook-cream.webp"
      : "./assets/images/icons/facebook-blue.webp";
    instaIcon.src = isDarkMode
      ? "./assets/images/icons/instagram-cream.webp"
      : "./assets/images/icons/instagram-blue.webp";
  };

  // Met à jour l'arrière-plan du footer
  const updateFooterBackground = () => {
    const isDarkMode = body.classList.contains("dark-mode");
    footer.style.backgroundColor = isDarkMode ? "#213F7D" : "#f0e9e1";
    footer.style.color = isDarkMode ? "#fff" : "#213F7D";
  };

  // Met à jour les fonds des sections
  const updateSectionsBackground = () => {
    const isDarkMode = body.classList.contains("dark-mode");
    sections.forEach((section) => {
      section.classList.toggle("dark-mode", isDarkMode);
    });
  };

  // Met à jour les liens légaux du footer
  const updateFooterLegalLinks = () => {
    const isDarkMode = body.classList.contains("dark-mode");
    footerLegalLinks.forEach((link) => {
      link.style.color = isDarkMode ? "#fff" : "#213F7D";
    });
  };

  // Ajout des écouteurs d'événements
  darkModeToggle?.addEventListener("click", toggleDarkMode);
  darkModeToggleMobile?.addEventListener("click", toggleDarkMode);
  burgerMenu?.addEventListener("click", () => {
    navLinks?.classList.toggle("show");
  });

  // Affiche le bouton retour en haut au scroll
  window.addEventListener("scroll", () => {
    upButtonLink.style.display = window.scrollY > 300 ? "block" : "none";
  });

  // Ajoute un comportement de retour en haut du bouton
  upButtonLink?.addEventListener("click", (e) => {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: "smooth" });
  });

  // Ajuster la largeur du conteneur de la galerie d'images
  const totalWidth = containers.length * (containers[0].offsetWidth + 10); // Largeur totale des éléments + espace
  galleryInner.style.width = `${totalWidth}px`;
});
