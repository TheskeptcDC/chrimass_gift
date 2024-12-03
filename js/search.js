// toggle functionality 
document.addEventListener('DOMContentLoaded', function () {
    const cartToggleButton = document.querySelector('.search-toggle');
    const cartElement = document.querySelector('.search-bar');

    cartToggleButton.addEventListener('click', function () {
        if (cartElement.style.display === 'none' || cartElement.style.display === '') {
            cartElement.style.display = 'block';
        } else {
            cartElement.style.display = 'none';
        }
    });
});