console.log("coucou");

document.addEventListener("DOMContentLoaded", () => {
  // Sélection des éléments du DOM
  const body = document.body;
  const burgerMenu = document.getElementById("burger-menu");
  const navLinks = document.getElementById("navLinks");
  const darkModeToggle = document.getElementById("js-darkMode");

  const moonIcon = document.getElementById("js-moonIcon");
  const sunIcon = document.getElementById("js-sunIcon");

  const footer = document.querySelector(".footer");
  const sections = document.querySelectorAll(
    ".hook, .gallery, .card, .end-page, .about__story, .about__main, .about__title, .about__main-p, .about__lifeStyle, .about__taste, .contact-info__block"
  );
  const footerLegalLinks = document.querySelectorAll(".footer__legal a");

  const instaIcon = document.getElementById("js-insta");
  const facebookIcon = document.getElementById("js-facebook");

  const darkModeToggleMobile = document.getElementById("js-darkModeMobile");
  const moonIconMobile = document.getElementById("js-moonIconMobile");
  const sunIconMobile = document.getElementById("js-sunIconMobile");
  const upButtonLink = document.getElementById("up-button-link");
  const galleryInner = document.querySelector(".gallery__inner");
  const containers = document.querySelectorAll(".gallery__container");

  // Sélection spécifique à la page des CGV
  const cgvSections = document.querySelectorAll(
    ".cgv__content h2, .cgv__content p"
  );

  // Fonction pour activer/désactiver le mode sombre
  const toggleDarkMode = () => {
    const isDarkMode = body.classList.toggle("dark-mode");
    body.classList.toggle("light-mode", !isDarkMode);
    updateIcons();
    updateFooterBackground();
    updateFooterLegalLinks();
    updateSectionsBackground();
    updateCgvSections(); // Ajout spécifique pour CGV
    localStorage.setItem("dark-mode", isDarkMode ? "enabled" : "disabled");
  };

  // Mise à jour des icônes en fonction du mode sombre
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

  // Mise à jour de la couleur de fond du pied de page
  const updateFooterBackground = () => {
    const isDarkMode = body.classList.contains("dark-mode");
    footer.style.backgroundColor = isDarkMode ? "#213F7D" : "#f0e9e1";
    footer.style.color = isDarkMode ? "#fff" : "#213F7D";
  };

  // Mise à jour du fond des sections
  const updateSectionsBackground = () => {
    const isDarkMode = body.classList.contains("dark-mode");
    sections.forEach((section) => {
      section.classList.toggle("dark-mode", isDarkMode);
    });

    const darkColor = document.querySelector(
      ".privacy-policy, .legals, .cgv, .form-container, .editDishe__container, .container__confirmation"
    );
    if (darkColor) {
      darkColor.classList.toggle("dark-mode", isDarkMode);
      console.log("Privacy Policy dark mode:", isDarkMode);
    }
  };

  // Mise à jour spécifique aux sections CGV
  const updateCgvSections = () => {
    const isDarkMode = body.classList.contains("dark-mode");
    cgvSections.forEach((section) => {
      section.classList.toggle("dark-mode", isDarkMode);
    });
  };

  // Mise à jour des liens légaux du pied de page
  const updateFooterLegalLinks = () => {
    const isDarkMode = body.classList.contains("dark-mode");
    footerLegalLinks.forEach(
      (link) => (link.style.color = isDarkMode ? "#fff" : "#213F7D")
    );
  };

  // Gestion des événements
  darkModeToggle?.addEventListener("click", toggleDarkMode);
  darkModeToggleMobile?.addEventListener("click", toggleDarkMode);
  burgerMenu?.addEventListener("click", () =>
    navLinks?.classList.toggle("show")
  );

  if (upButtonLink) {
    window.addEventListener("scroll", () => {
      upButtonLink.style.display = window.scrollY > 300 ? "block" : "none";
    });

    upButtonLink.addEventListener("click", (e) => {
      e.preventDefault();
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  } else {
    console.error('L\'élément "up-button" est introuvable.');
  }

  // Gestion de la largeur de la galerie
  if (containers.length > 0 && galleryInner) {
    const containerWidth = containers[0].offsetWidth + 10; // Largeur d'un conteneur + marge
    const totalWidth = containers.length * containerWidth;
    galleryInner.style.width = `${totalWidth * 2}px`; // Largeur totale pour le défilement infini
  }

  // Récupération du mode sombre depuis localStorage
  if (localStorage.getItem("dark-mode") === "enabled") {
    body.classList.add("dark-mode");
    body.classList.remove("light-mode");
    updateIcons();
    updateFooterBackground();
    updateFooterLegalLinks();
    updateSectionsBackground();
    updateCgvSections(); // Ajout spécifique pour CGV
  }
});
