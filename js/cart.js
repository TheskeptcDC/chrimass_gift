        // Shopping Cart Logic
        const cart = JSON.parse(localStorage.getItem('cart')) || [];

        const addToCartButtons = document.querySelectorAll('.add-to-cart');
        const cartItemsList = document.getElementById('cart-items');
        const cartTotal = document.getElementById('cart-total');

        function renderCart() {
            cartItemsList.innerHTML = '';
            if (cart.length === 0) {
                cartItemsList.innerHTML = '<li class="list-group-item text-muted">Your cart is empty</li>';
                cartTotal.innerText = '0';
                return;
            }

            let total = 0;
            cart.forEach((item, index) => {
                const listItem = document.createElement('li');
                listItem.className = 'list-group-item d-flex justify-content-between align-items-center';
                listItem.innerHTML = `
                    ${item.name} - K${item.price} x ${item.quantity}
                    <button class="btn btn-danger btn-sm remove-from-cart" data-index="${index}">
                        <i class="bi bi-trash"></i>
                    </button>
                `;
                cartItemsList.appendChild(listItem);
                total += item.price * item.quantity;
            });
            cartTotal.innerText = total;

            // Add event listeners for remove buttons
            document.querySelectorAll('.remove-from-cart').forEach(button => {
                button.addEventListener('click', removeFromCart);
            });
        }

        function addToCart(event) {
            const button = event.target;
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const price = parseInt(button.getAttribute('data-price'));

            // Check if the product already exists in the cart
            const existingProduct = cart.find(item => item.id === id);
            if (existingProduct) {
                existingProduct.quantity += 1;
            } else {
                cart.push({ id, name, price, quantity: 1 });
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
        }

        function removeFromCart(event) {
            const index = event.target.getAttribute('data-index');
            cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
        }

        // Attach event listeners
        addToCartButtons.forEach(button => button.addEventListener('click', addToCart));

        // Initial render
        renderCart();


        // toggle functionality 
        document.addEventListener('DOMContentLoaded', function () {
            const cartToggleButton = document.querySelector('.cart-toggle');
            const cartElement = document.querySelector('.cart');
        
            cartToggleButton.addEventListener('click', function () {
                if (cartElement.style.display === 'none' || cartElement.style.display === '') {
                    cartElement.style.display = 'block';
                } else {
                    cartElement.style.display = 'none';
                }
            });
        });
        

        // NEW IMPLEMENTATION 
        // Load Lenco Pay script
const script = document.createElement('script');
script.src = "https://pay.lenco.co/js/v1/inline.js";
document.head.appendChild(script);

// Shopping Cart Logic
// const cart = JSON.parse(localStorage.getItem('cart')) || [];
// const cartItemsList = document.getElementById('cart-items');
// const cartTotal = document.getElementById('cart-total');

function renderCart() {
    cartItemsList.innerHTML = '';
    if (cart.length === 0) {
        cartItemsList.innerHTML = '<li class="list-group-item text-muted">Your cart is empty</li>';
        cartTotal.innerText = '0';
        return;
    }
    let total = 0;
    cart.forEach((item, index) => {
        const listItem = document.createElement('li');
        listItem.className = 'list-group-item d-flex justify-content-between align-items-center';
        listItem.innerHTML = `
            ${item.name} - K${item.price} x ${item.quantity}
            <button class="btn btn-danger btn-sm remove-from-cart" data-index="${index}">❌</button>
        `;
        cartItemsList.appendChild(listItem);
        total += item.price * item.quantity;
    });
    cartTotal.innerText = total;
    document.querySelectorAll('.remove-from-cart').forEach(button => {
        button.addEventListener('click', removeFromCart);
    });
}

function addToCart(event) {
    const button = event.target;
    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const price = parseInt(button.getAttribute('data-price'));
    const existingProduct = cart.find(item => item.id === id);
    if (existingProduct) {
        existingProduct.quantity += 1;
    } else {
        cart.push({ id, name, price, quantity: 1 });
    }
    localStorage.setItem('cart', JSON.stringify(cart));
    renderCart();
}

function removeFromCart(event) {
    const index = event.target.getAttribute('data-index');
    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    renderCart();
}

// Initialize cart display
renderCart();

// Payment with Lenco
function getPaidWithLenco() {
    const mobileMoneyNumber = document.getElementById('mobile-money-number').value.trim();
    if (!mobileMoneyNumber || !/^(\+?260|0)[0-9]{9}$/.test(mobileMoneyNumber)) {
        alert('Please enter a valid Mobile Money number in the correct format.');
        return;
    }
    const totalAmount = parseInt(cartTotal.innerText);
    if (totalAmount <= 0) {
        alert('Your cart is empty. Add items before proceeding to payment.');
        return;
    }
    
    const productsList = cart.map(item => `${item.name} (x${item.quantity})`).join(', ');
    
    LencoPay.getPaid({
        key: 'pub-8ecfe298bfd5e189e0f9161b32924a23210211dc66c1e58c',
        reference: 'ref-' + Date.now(),
        email: 'customer@email.com', // You can dynamically fetch this
        amount: totalAmount , // * 100, // 
        currency: "ZMW",
        channels: ["mobile-money"],
        customer: {
            firstName: "John",
            lastName: "Doe",
            phone: mobileMoneyNumber,
        },
        metadata: {
            items: productsList
        },
        onSuccess: function (response) {
            alert('Payment successful! Reference: ' + response.reference);
            localStorage.removeItem('cart');
            renderCart();
            document.getElementById('mobile-money-number').value = '';
        },
        onClose: function () {
            alert('Payment was not completed, window closed.');
        },
        onConfirmationPending: function () {
            alert('Your payment is being processed. Please wait.');
        },
    });
}
