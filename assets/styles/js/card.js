document.addEventListener("DOMContentLoaded", () => {
  // Gestion du filtrage des plats végétariens
  const filterButton = document.getElementById("filter-vegetarian");
  let isFilteringVegetarian = false;

  filterButton?.addEventListener("click", () => {
    isFilteringVegetarian = !isFilteringVegetarian;
    const dishes = document.querySelectorAll(".dish-item");

    dishes.forEach((dish) => {
      if (dish instanceof HTMLElement) {
        const isVegetarian = dish.dataset.vegetarian === "true";
        dish.style.display =
          isFilteringVegetarian && !isVegetarian ? "none" : "block";
      }
    });

    filterButton.textContent = isFilteringVegetarian
      ? "Afficher tous les plats"
      : "Filtrer pour les plats végétariens";
  });

  // Gestion des modales
  function toggleModal(modal, show) {
    if (show) {
      modal.classList.add("show");
      document.body.style.overflow = "hidden";
    } else {
      modal.classList.remove("show");
      document.body.style.overflow = "";
    }
  }

  document.querySelectorAll(".details-button").forEach((button) => {
    button.addEventListener("click", () => {
      const target = document.querySelector(button.dataset.target);
      toggleModal(target, true);
    });
  });

  document.querySelectorAll(".close-button").forEach((button) => {
    button.addEventListener("click", () => {
      const target = document.querySelector(button.dataset.target);
      toggleModal(target, false);
    });
  });

  window.addEventListener("click", (event) => {
    const cartModal = document.getElementById("cartModal");
    if (event.target === cartModal) {
      toggleModal(cartModal, false);
    }
  });

  // Gestion du panier
  const cartItems = [];
  let cartTotal = 0;

  document.querySelectorAll(".add-button").forEach((button) => {
    button.addEventListener("click", (e) => {
      const dishElement = e.target.closest(".dish-item");
      const dishName = dishElement.querySelector("strong").innerText;
      const dishPrice = parseFloat(
        dishElement
          .querySelector("p:nth-child(2)")
          .innerText.replace("Prix : ", "")
          .replace("€", "")
      );

      // Vérifier si l'article est déjà dans le panier
      const existingItem = cartItems.find((item) => item.name === dishName);
      if (existingItem) {
        existingItem.quantity += 1;
        cartTotal += dishPrice;
      } else {
        cartItems.push({ name: dishName, price: dishPrice, quantity: 1 });
        cartTotal += dishPrice;
      }

      updateCartModal(cartItems, cartTotal);
    });
  });

  function updateCartModal(items, total) {
    const cartModalElement = document.getElementById("cartModal");
    const cartItemsContainer = cartModalElement.querySelector("#cartItems");
    const cartTotalElement = cartModalElement.querySelector("#cartTotal");

    // Construire le HTML des articles du panier
    const itemsHtml = items
      .map(
        (item, index) => `
      <div class="cart-item">
        <p>${item.name} - ${item.price.toFixed(2)} € x ${item.quantity}
        <span class="remove-item" data-index="${index}">&times;</span></p>
      </div>
      `
      )
      .join("");

    cartItemsContainer.innerHTML = itemsHtml;
    cartModalElement.querySelector(
      "h4"
    ).innerHTML = `Votre panier (${items.length} article(s))`;
    cartTotalElement.innerText = `${total.toFixed(2)} €`;

    // Gestion de l'état de la modale (dépliée/repliée)
    const toggleCart = document.getElementById("toggleCart");
    let isCollapsed = false; // État de la modale

    toggleCart.addEventListener("click", () => {
      isCollapsed = !isCollapsed; // Inverser l'état
      cartItemsContainer.classList.toggle("hidden", isCollapsed); // Ajouter ou enlever la classe hidden
      toggleCart.textContent = isCollapsed ? "▲" : "▼"; // Changer la flèche
    });

    // Ajouter les gestionnaires d'événements pour les croix
    document.querySelectorAll(".remove-item").forEach((removeButton) => {
      removeButton.addEventListener("click", (e) => {
        const index = e.target.dataset.index;
        const itemPrice = cartItems[index].price;
        const itemQuantity = cartItems[index].quantity;

        // Supprimer l'article du tableau
        cartItems.splice(index, 1);
        cartTotal -= itemPrice * itemQuantity;
        updateCartModal(cartItems, cartTotal);
      });
    });

    // Afficher la modale
    cartModalElement.style.display = "block";
  }

  // Envoi de la commande lorsqu'on clique sur "Commander"
  const orderButton = document.getElementById("checkoutButton");
  const cartItemsInput = document.getElementById("cartItemsInput");
  const cartTotalInput = document.getElementById("cartTotalInput");

  if (orderButton && cartItemsInput && cartTotalInput) {
    orderButton.addEventListener("click", function (event) {
      event.preventDefault(); // Empêche la soumission automatique du formulaire

      if (cartItems.length === 0) {
        alert("Votre panier est vide !");
        return; // Ne pas soumettre le formulaire si le panier est vide
      }

      // Remplissez les champs du formulaire avec les données du panier
      cartItemsInput.value = JSON.stringify(cartItems);
      cartTotalInput.value = cartTotal.toFixed(2);

      // Soumettez le formulaire après avoir vérifié que tout est bien rempli
      document.getElementById("orderForm").submit();
    });
  }
});
