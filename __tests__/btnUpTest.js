import { toggleDarkMode } from "../assets/styles/js/main.js";

describe("up button functionality", () => {
  let upButtonLink;

  beforeEach(() => {
    // Créez le bouton de retour en haut dans le DOM
    document.body.innerHTML = `<a id="up-button-link" style="display: none;"></a>`;
    upButtonLink = document.getElementById("up-button-link");

    // Ajoutez l'écouteur d'événements pour le défilement
    if (upButtonLink) {
      window.addEventListener("scroll", () => {
        upButtonLink.style.display = window.scrollY > 300 ? "block" : "none";
      });
    }
  });

  test("should display the up button when scrolled down", () => {
    // Simulez le défilement
    window.scrollY = 400; // Simulez un défilement de 400 pixels
    const event = new Event("scroll");
    window.dispatchEvent(event); // Déclenchez l'événement de défilement

    expect(upButtonLink.style.display).toBe("block");
  });

  test("should hide the up button when at the top", () => {
    // Remettez le défilement à 0 pixels
    window.scrollY = 0;
    const event = new Event("scroll");
    window.dispatchEvent(event); // Déclenchez l'événement de défilement

    expect(upButtonLink.style.display).toBe("none");
  });
});
