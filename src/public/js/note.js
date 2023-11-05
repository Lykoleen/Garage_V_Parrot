let selectedScore = 0;

const stars = document.querySelectorAll(".star");

stars.forEach((star) => {
  star.addEventListener("click", (event) => {
    const clickedStar = event.currentTarget;
    const rating = clickedStar.getAttribute("data-rating");

    // Réinitialise toutes les étoiles
    stars.forEach((s) => s.classList.remove("checked"));

    // Marque les étoiles jusqu'à la note sélectionnée
    for (let i = 0; i < rating; i++) {
      stars[i].classList.add("checked");
      stars[i].classList.add(`star-${i + 1}`);
    }

    selectedScore = rating;

    // Met à jour la valeur du score dans le formulaire
    document.getElementById("score").value = selectedScore;
  });
});
