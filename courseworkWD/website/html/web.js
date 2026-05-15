// Select all images in the gallery
const images = document.querySelectorAll('.gallery-row img');

// Reference to the modal and its components
const modal = document.getElementById('imageModal');
const modalImage = document.getElementById('modalImage');
const closeButton = modal.querySelector('.close');

// Add click event listeners to each image
images.forEach((img) => {
    img.addEventListener('click', () => {
        modal.style.display = 'block'; // Show modal
        modalImage.src = img.src; // Set clicked image in the modal
    });
});

// Add click event to close the modal
closeButton.addEventListener('click', () => {
    modal.style.display = 'none'; // Hide modal
});

// Close modal when clicking outside the image
modal.addEventListener('click', (e) => {
    if (e.target === modal) {
        modal.style.display = 'none';
    }
});
