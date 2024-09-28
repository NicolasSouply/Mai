document.addEventListener("DOMContentLoaded", () => {
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

  // Appel de la fonction d'initialisation de la carte après chargement complet
  window.onload = initMap;
});
