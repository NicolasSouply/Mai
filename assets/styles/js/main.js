document.addEventListener("DOMContentLoaded", () => {
  // Sélection des éléments du DOM
  const body = document.body;
  const burgerMenu = document.getElementById("burger-menu");
  const navLinks = document.getElementById("navLinks");
  const darkModeToggle = document.getElementById("js-darkMode");
  const darkModeToggleMobile = document.getElementById("js-darkModeMobile");
  const upButtonLink = document.getElementById("up-button-link");
  const deleteUserModal = document.getElementById("deleteUserModal");
  const footer = document.querySelector(".footer");
  const sections = document.querySelectorAll(
    ".hook, .gallery, .card, .end-page, .about__story, .about__main, .about__title, .about__main-p, .about__lifeStyle, .about__taste, .contact-info__block"
  );
  const footerLegalLinks = document.querySelectorAll(".footer__legal a");
  const instaIcon = document.getElementById("js-insta");
  const facebookIcon = document.getElementById("js-facebook");
  const moonIcon = document.getElementById("js-moonIcon");
  const sunIcon = document.getElementById("js-sunIcon");
  const moonIconMobile = document.getElementById("js-moonIconMobile");
  const sunIconMobile = document.getElementById("js-sunIconMobile");
  const galleryInner = document.querySelector(".gallery__inner");
  const containers = document.querySelectorAll(".gallery__container");
  const discoverMenuButton = document.getElementById("discover-menu");
  const cgvSections = document.querySelectorAll(
    ".cgv__content h2, .cgv__content p"
  );

  const toggleDarkMode = () => {
    const isDarkMode = body.classList.toggle("dark-mode");
    body.classList.toggle("light-mode", !isDarkMode);
    updateIcons(isDarkMode);
    updateFooterBackground(isDarkMode);
    updateFooterLegalLinks(isDarkMode);
    updateSectionsBackground(isDarkMode);
    updateCgvSections(isDarkMode);
    localStorage.setItem("dark-mode", isDarkMode ? "enabled" : "disabled");
  };

  const updateIcons = (isDarkMode) => {
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

  const updateFooterBackground = (isDarkMode) => {
    footer.style.backgroundColor = isDarkMode ? "#213F7D" : "#f0e9e1";
    footer.style.color = isDarkMode ? "#fff" : "#213F7D";
  };

  const updateSectionsBackground = (isDarkMode) => {
    sections.forEach((section) => {
      section.classList.toggle("dark-mode", isDarkMode);
    });
    const darkColor = document.querySelector(
      ".privacy-policy, .legals, .cgv, .reservation__container, .editDishe__container, .container__confirmation, .dishes-list, .connexion__container, .reservation__container,.register__container, .error404__container, .error404__title"
    );
    if (darkColor) {
      darkColor.classList.toggle("dark-mode", isDarkMode);
      console.log("Privacy Policy dark mode:", isDarkMode);
    }
  };

  const updateCgvSections = (isDarkMode) => {
    cgvSections.forEach((section) => {
      section.classList.toggle("dark-mode", isDarkMode);
    });
  };

  const updateFooterLegalLinks = (isDarkMode) => {
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
    updateIcons(true);
    updateFooterBackground(true);
    updateFooterLegalLinks(true);
    updateSectionsBackground(true);
    updateCgvSections(true);
  }
  // boutton redirection vers la page "card"
  if (discoverMenuButton) {
    discoverMenuButton.addEventListener("click", () => {
      window.location.href = "index.php?route=card"; // Redirection vers la page souhaitée
    });
  }
  // Modale de suppression d'utilisateur
  if (deleteUserModal) {
    deleteUserModal.addEventListener("show.bs.modal", function (event) {
      const button = event.relatedTarget;
      const userEmail = button.getAttribute("data-bs-user");
      const userId = button.getAttribute("data-bs-id");
      const modalBody = deleteUserModal.querySelector(".modal-body p");
      modalBody.textContent = ` ${userEmail} `;
      const deleteButton = deleteUserModal.querySelector(".btn-danger");
      deleteButton.onclick = function () {
        window.location.href = `index.php?route=admin-delete-user&user_id=${userId}`;
      };
    });
  }
});
