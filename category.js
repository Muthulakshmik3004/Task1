document.addEventListener("DOMContentLoaded", () => {
    const categoryItems = document.querySelectorAll(".categories li");
    const artworkItems = document.querySelectorAll(".artwork-item");
  
    categoryItems.forEach(category => {
      category.addEventListener("click", () => {
        // Set active class on selected category
        categoryItems.forEach(item => item.classList.remove("active"));
        category.classList.add("active");
  
        // Get selected category
        const selectedCategory = category.getAttribute("data-category");
  
        // Filter artwork items
        artworkItems.forEach(artwork => {
          const artworkCategory = artwork.getAttribute("data-category");
  
          if (selectedCategory === "all" || selectedCategory === artworkCategory) {
            artwork.style.display = "block";
          } else {
            artwork.style.display = "none";
          }
        });
      });
    });
  });