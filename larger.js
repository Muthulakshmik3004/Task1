const images = [
    "digital-art/12.jpg",
    "digital-art/2.jpg",
    "digital-art/3.jpg",
    "digital-art/13.jpg",
    "digital-art/8.jpg",
    "digital-art/6.jpg",
    "digital-art/19.jpg",
    "digital-art/9.jpg",
    "digital-art/15.jpg",
    "digital-art/11.jpg"

];

let currentIndex = 0;
let isZoomed = false;

// Select image element
const currentImage = document.getElementById("currentImage");

// Function to navigate images
function changeImage(index) {
    currentIndex = index;
    updateImage();
}

function nextImage() {
    currentIndex = (currentIndex + 1) % images.length;
    updateImage();
}

function prevImage() {
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    updateImage();
}

function updateImage() {
    currentImage.src = images[currentIndex];
}

// Toggle Zoom Effect
function toggleZoom() {
    isZoomed = !isZoomed;
    currentImage.style.transform = isZoomed ? "scale(1.5)" : "scale(1)";
}