console.log("coucou");

document.addEventListener("DOMContentLoaded", () => {
  // Votre code existant pour la gestion du mode sombre, du footer, etc.

  // Sélection des éléments du DOM
  const body = document.body;
  const darkModeToggle = document.getElementById("js-darkMode");

  const moonIcon = document.getElementById("js-moonIcon");
  const sunIcon = document.getElementById("js-sunIcon");

  const footer = document.querySelector(".footer");
  const sections = document.querySelectorAll(
    ".hook, .gallery, .card, .end-page, .about__story, .about__main, .about__title, .about__main-p, .about__lifeStyle, .about__taste, .contact-info__block "
  );
  const footerLegalLinks = document.querySelectorAll(".footer__legal a");
  const instaIcon = document.getElementById("js-insta");
  const facebookIcon = document.getElementById("js-facebook");
  const burgerMenu = document.getElementById("burger-menu");
  const navLinks = document.getElementById("navLinks");
  const darkModeToggleMobile = document.getElementById("js-darkModeMobile");
  const moonIconMobile = document.getElementById("js-moonIconMobile");
  const sunIconMobile = document.getElementById("js-sunIconMobile");
  const upButtonLink = document.getElementById("up-button-link");
  const galleryInner = document.querySelector(".gallery__inner");
  const containers = document.querySelectorAll(".gallery__container");

  // Fonction pour activer/désactiver le mode sombre
  const toggleDarkMode = () => {
    const isDarkMode = body.classList.toggle("dark-mode");
    body.classList.toggle("light-mode", !isDarkMode);
    updateIcons();
    updateFooterBackground();
    updateFooterLegalLinks();
    updateSectionsBackground();
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
    sections.forEach((section) =>
      section.classList.toggle("dark-mode", isDarkMode)
    );
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

  window.addEventListener("scroll", () => {
    upButtonLink.style.display = window.scrollY > 300 ? "block" : "none";
  });

  upButtonLink?.addEventListener("click", (e) => {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: "smooth" });
  });

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
  }

  // Initialisation de la carte
  const initMap = () => {
    const lat = 48.501518;
    const lng = -2.769251;
    const zoomLvl = 18;

    // Vérifiez que Leaflet est disponible
    if (typeof L === "undefined") {
      console.error("Leaflet library is not loaded");
      return;
    }

    const map = L.map("map").setView([lat, lng], zoomLvl);

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      attribution:
        '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    }).addTo(map);

    L.marker([lat, lng])
      .addTo(map)
      .bindPopup("<b>Maï Restaurant.</b>")
      .openPopup();
  };

  // Appel de la fonction d'initialisation de la carte
  initMap();

  // === AJOUT : Gestion de la modale des plats ===
  const modal = document.getElementById("dish-modal");
  const modalTitle = document.getElementById("modal-title");
  const modalImage = document.getElementById("modal-image");
  const modalDescription = document.getElementById("modal-description");
  const modalComposition = document.getElementById("modal-composition");
  const modalPrice = document.getElementById("modal-price");
  const closeModal = document.getElementById("close-modal");

  document.querySelectorAll(".dish-item").forEach((item) => {
    item.addEventListener("click", function () {
      const name = this.querySelector("p").textContent.split(" - ")[0];
      const image = this.querySelector("img").src;
      const price = this.querySelector("p.price").textContent;
      const description = this.getAttribute("data-description");
      const vegetarian =
        this.getAttribute("data-vegetarian") === "true"
          ? "Végétarien"
          : "Non Végétarien";

      modalTitle.textContent = name;
      modalImage.src = image;
      modalPrice.textContent = "Prix : " + price;
      modalDescription.textContent = description;
      modalComposition.textContent = vegetarian;
      modal.style.display = "flex";
    });
  });

  closeModal.addEventListener("click", function () {
    modal.style.display = "none";
  });

  window.addEventListener("click", function (event) {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  });

  // === Filtrage végétarien ===
  document.getElementById("filter-vegetarian").addEventListener("click", () => {
    document.querySelectorAll(".dish-item").forEach((item) => {
      const isVegetarian = item.getAttribute("data-vegetarian") === "true";
      item.style.display = isVegetarian ? "block" : "none";
    });
  });
});
