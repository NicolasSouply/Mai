document.addEventListener("DOMContentLoaded", function () {
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
  const burgerMenu = document.getElementById("burger-menu");
  const navLinks = document.getElementById("navLinks");
  const darkModeToggleMobile = document.getElementById("js-darkModeMobile");
  const moonIconMobile = document.getElementById("js-moonIconMobile");
  const sunIconMobile = document.getElementById("js-sunIconMobile");
  const upButtonLink = document.getElementById("up-button-link");
  const galleryInner = document.querySelector(".gallery__inner");
  const containers = document.querySelectorAll(".gallery__container");

  const toggleDarkMode = () => {
    const isDarkMode = body.classList.toggle("dark-mode");
    body.classList.toggle("light-mode", !isDarkMode);
    console.log("Dark mode active:", isDarkMode); // Debug

    updateIcons();
    updateFooterBackground();
    updateFooterLegalLinks();
    updateSectionsBackground();

    localStorage.setItem("dark-mode", isDarkMode ? "enabled" : "disabled");
  };

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

  const updateFooterBackground = () => {
    const isDarkMode = body.classList.contains("dark-mode");
    footer.style.backgroundColor = isDarkMode ? "#213F7D" : "#f0e9e1";
    footer.style.color = isDarkMode ? "#fff" : "#213F7D";
  };

  const updateSectionsBackground = () => {
    const isDarkMode = body.classList.contains("dark-mode");
    sections.forEach((section) => {
      section.classList.toggle("dark-mode", isDarkMode);
    });
  };

  const updateFooterLegalLinks = () => {
    const isDarkMode = body.classList.contains("dark-mode");
    footerLegalLinks.forEach((link) => {
      link.style.color = isDarkMode ? "#fff" : "#213F7D";
    });
  };

  darkModeToggle?.addEventListener("click", toggleDarkMode);
  darkModeToggleMobile?.addEventListener("click", toggleDarkMode);
  burgerMenu?.addEventListener("click", () => {
    navLinks?.classList.toggle("show");
  });

  window.addEventListener("scroll", () => {
    upButtonLink.style.display = window.scrollY > 300 ? "block" : "none";
  });

  upButtonLink?.addEventListener("click", (e) => {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: "smooth" });
  });

  if (containers.length > 0 && galleryInner) {
    const totalWidth = containers.length * (containers[0].offsetWidth + 10);
    galleryInner.style.width = `${totalWidth}px`;
  }

  if (localStorage.getItem("dark-mode") === "enabled") {
    body.classList.add("dark-mode");
    body.classList.remove("light-mode");
    console.log("Loaded dark mode from localStorage"); // Debug
    updateIcons();
    updateFooterBackground();
    updateFooterLegalLinks();
    updateSectionsBackground();
  }
});
