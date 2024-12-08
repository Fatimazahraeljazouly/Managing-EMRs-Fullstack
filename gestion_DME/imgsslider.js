let slideIndex = 0;
const slides = document.querySelectorAll('.slider img');
const totalSlides = slides.length;
let intervalId;

// Function to change slide
function changeSlide(n) {
    slideIndex += n;
    showSlide();
}

// Function to show slide
function showSlide() {
    if (slideIndex >= totalSlides) {
        slideIndex = 0;
    } else if (slideIndex < 0) {
        slideIndex = totalSlides - 1;
    }

    const offset = -slideIndex * 100;
    document.querySelector('.slider').style.transform = `translateX(${offset}%)`;
}

// Auto slide function
function autoSlide() {
    intervalId = setInterval(() => {
        slideIndex++;
        showSlide();
    }, 3000); // Change image every 3 seconds (adjust as needed)
}

// Start auto sliding
autoSlide();

// Pause auto sliding on mouseover
document.querySelector('.slider-container').addEventListener('mouseover', () => {
    clearInterval(intervalId);
});

// Resume auto sliding on mouseout
document.querySelector('.slider-container').addEventListener('mouseout', () => {
    autoSlide();
});
