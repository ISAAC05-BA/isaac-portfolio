/* ============================================
   ADIEYEFEH ONLINE SHOPPING - JavaScript
   ============================================ */

// Product Data - Updated with new categories
const products = [
    // Men's Wear
    {
        id: 1,
        name: "Men's Formal Shirt",
        category: "men",
        price: 150,
        description: "Classic fit cotton formal shirt",
        image: "https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=400"
    },
    {
        id: 2,
        name: "Men's Winter Coat",
        category: "men",
        price: 450,
        description: "Warm wool blend winter coat",
        image: "https://images.unsplash.com/photo-1544923246-77307dd628b5?w=400"
    },
    {
        id: 3,
        name: "Men's Business Suit",
        category: "men",
        price: 850,
        description: "Elegant two-piece formal suit",
        image: "https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=400"
    },
    // Women's Wear
    {
        id: 4,
        name: "Women's Casual Shirt",
        category: "women",
        price: 120,
        description: "Comfortable cotton casual shirt",
        image: "https://images.unsplash.com/photo-1598554747436-c9293d6a588f?w=400"
    },
    {
        id: 5,
        name: "Women's Winter Coat",
        category: "women",
        price: 420,
        description: "Stylish wool blend winter coat",
        image: "https://images.unsplash.com/photo-1539533018447-63fcce2678e3?w=400"
    },
    // Children's Wear
    {
        id: 6,
        name: "Kids Sneakers",
        category: "children",
        price: 180,
        description: "Comfortable sneakers for kids",
        image: "https://images.unsplash.com/photo-1560769629-975ec94e6a86?w=400"
    },
    {
        id: 7,
        name: "Children's Casual Wear",
        category: "children",
        price: 95,
        description: "Comfy casual outfit for children",
        image: "https://images.unsplash.com/photo-1621452773781-0f992ee03591?w=400"
    },
    // Footwear - Shoes
    {
        id: 8,
        name: "Men's Formal Shoes",
        category: "shoes",
        price: 320,
        description: "Classic leather formal shoes",
        image: "https://images.unsplash.com/photo-1614252369475-531eba835eb1?w=400"
    },
    {
        id: 9,
        name: "Men's Casual Shoes",
        category: "shoes",
        price: 250,
        description: "Stylish casual shoes for everyday",
        image: "https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?w=400"
    },
    {
        id: 10,
        name: "Women's Formal Shoes",
        category: "shoes",
        price: 280,
        description: "Elegant formal heels for women",
        image: "https://images.unsplash.com/photo-1543163521-1bf539c55dd2?w=400"
    },
    {
        id: 11,
        name: "Women's Casual Shoes",
        category: "shoes",
        price: 200,
        description: "Comfortable casual footwear",
        image: "https://images.unsplash.com/photo-1549298916-b41d501d3772?w=400"
    },
    {
        id: 12,
        name: "Children's Shoes",
        category: "shoes",
        price: 150,
        description: "Durable shoes for kids",
        image: "https://images.unsplash.com/photo-1595341888016-a392ef81b7de?w=400"
    },
    // Bags
    {
        id: 13,
        name: "Men's Leather Bag",
        category: "bags",
        price: 380,
        description: "Premium leather messenger bag",
        image: "https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400"
    },
    {
        id: 14,
        name: "Men's Backpack",
        category: "bags",
        price: 220,
        description: "Durable backpack for daily use",
        image: "https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400"
    },
    {
        id: 15,
        name: "Women's Handbag",
        category: "bags",
        price: 280,
        description: "Elegant designer handbag",
        image: "https://images.unsplash.com/photo-1584917865442-de89df76afd3?w=400"
    },
    {
        id: 16,
        name: "Women's Tote Bag",
        category: "bags",
        price: 180,
        description: "Spacious tote for everyday use",
        image: "https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=400"
    }
];

// Cart State
let cart = [];

// Currency symbol
const currencySymbol = "₵";

// DOM Elements
const productsGrid = document.getElementById('productsGrid');
const allProductsGrid = document.getElementById('allProductsGrid');
const cartIcon = document.getElementById('cartIcon');
const cartPanel = document.getElementById('cartPanel');
const cartOverlay = document.getElementById('cartOverlay');
const closeCart = document.getElementById('closeCart');
const cartItems = document.getElementById('cartItems');
const cartCount = document.getElementById('cartCount');
const cartTotal = document.getElementById('cartTotal');
const notification = document.getElementById('notification');
const notificationMessage = document.getElementById('notificationMessage');
const hamburger = document.getElementById('hamburger');
const mobileMenu = document.getElementById('mobileMenu');
const searchInput = document.getElementById('searchInput');
const searchBtn = document.getElementById('searchBtn');
const filterBtns = document.querySelectorAll('.filter-btn');
const categoryCards = document.querySelectorAll('.category-card');
const contactForm = document.getElementById('contactForm');
const scrollToTopBtn = document.getElementById('scrollToTop');
const navbar = document.querySelector('.navbar');

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    renderFeaturedProducts();
    renderAllProducts();
    setupEventListeners();
    setupScrollFeatures();
});

// Scroll to Top and Navbar Scroll Effects
function setupScrollFeatures() {
    window.addEventListener('scroll', () => {
        // Scroll to top button visibility
        if (window.scrollY > 300) {
            scrollToTopBtn.classList.add('visible');
        } else {
            scrollToTopBtn.classList.remove('visible');
        }

        // Navbar scroll effect
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Scroll to top button click
    scrollToTopBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// Render Featured Products (First 6)
function renderFeaturedProducts() {
    const featuredProducts = products.slice(0, 6);
    productsGrid.innerHTML = featuredProducts.map(product => createProductCard(product)).join('');
}

// Render All Products
function renderAllProducts(filteredProducts = products) {
    allProductsGrid.innerHTML = filteredProducts.map(product => createProductCard(product)).join('');
}

// Create Product Card HTML
function createProductCard(product) {
    return `
        <div class="product-card" data-category="${product.category}">
            <img src="${product.image}" alt="${product.name}" class="product-image">
            <div class="product-info">
                <div class="product-category">${product.category}</div>
                <h3 class="product-title">${product.name}</h3>
                <p class="product-description">${product.description}</p>
                <div class="product-price">${currencySymbol}${product.price.toFixed(2)}</div>
                <button class="add-to-cart" onclick="addToCart(${product.id})">
                    <i class="fas fa-shopping-cart"></i>
                    Add to Cart
                </button>
            </div>
        </div>
    `;
}

// Add to Cart
function addToCart(productId) {
    const product = products.find(p => p.id === productId);
    if (!product) return;

    const existingItem = cart.find(item => item.id === productId);

    if (existingItem) {
        existingItem.quantity++;
    } else {
        cart.push({
            ...product,
            quantity: 1
        });
    }

    updateCartUI();
    showNotification(`${product.name} added to cart!`);
}

// Remove from Cart
function removeFromCart(productId) {
    cart = cart.filter(item => item.id !== productId);
    updateCartUI();
}

// Update Quantity
function updateQuantity(productId, change) {
    const item = cart.find(item => item.id === productId);
    if (!item) return;

    item.quantity += change;

    if (item.quantity <= 0) {
        removeFromCart(productId);
    } else {
        updateCartUI();
    }
}

// Update Cart UI
function updateCartUI() {
    // Update cart count
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    cartCount.textContent = totalItems;

    // Update cart items
    if (cart.length === 0) {
        cartItems.innerHTML = '<p class="empty-cart">Your cart is empty</p>';
    } else {
        cartItems.innerHTML = cart.map(item => `
            <div class="cart-item">
                <img src="${item.image}" alt="${item.name}" class="cart-item-image">
                <div class="cart-item-details">
                    <h4 class="cart-item-title">${item.name}</h4>
                    <div class="cart-item-price">${currencySymbol}${item.price.toFixed(2)}</div>
                    <div class="quantity-selector">
                        <button class="quantity-btn" onclick="updateQuantity(${item.id}, -1)">-</button>
                        <span class="quantity-value">${item.quantity}</span>
                        <button class="quantity-btn" onclick="updateQuantity(${item.id}, 1)">+</button>
                        <button class="remove-item" onclick="removeFromCart(${item.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    }

    // Update total
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    cartTotal.textContent = `${currencySymbol}${total.toFixed(2)}`;
}

// Show Notification
function showNotification(message) {
    notificationMessage.textContent = message;
    notification.classList.add('show');

    setTimeout(() => {
        notification.classList.remove('show');
    }, 3000);
}

// Setup Event Listeners
function setupEventListeners() {
    // Cart toggle
    cartIcon.addEventListener('click', () => {
        cartPanel.classList.add('active');
        cartOverlay.classList.add('active');
    });

    closeCart.addEventListener('click', closeCartPanel);
    cartOverlay.addEventListener('click', closeCartPanel);

    // Mobile menu toggle
    hamburger.addEventListener('click', () => {
        mobileMenu.classList.toggle('active');
    });

    // Close mobile menu when clicking a link
    mobileMenu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu.classList.remove('active');
        });
    });

    // Search functionality
    searchBtn.addEventListener('click', performSearch);
    searchInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            performSearch();
        }
    });

    // Filter buttons
    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            filterProducts(btn.dataset.filter);
        });
    });

    // Category cards click
    categoryCards.forEach(card => {
        card.addEventListener('click', () => {
            const category = card.dataset.category;
            document.getElementById('shop').scrollIntoView({ behavior: 'smooth' });
            setTimeout(() => {
                filterBtns.forEach(b => b.classList.remove('active'));
                document.querySelector(`[data-filter="${category}"]`).classList.add('active');
                filterProducts(category);
            }, 300);
        });
    });

    // Contact form
    contactForm.addEventListener('submit', (e) => {
        e.preventDefault();
        showNotification('Message sent successfully!');
        contactForm.reset();
    });

    // Smooth scroll for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
}

// Close Cart Panel
function closeCartPanel() {
    cartPanel.classList.remove('active');
    cartOverlay.classList.remove('active');
}

// Perform Search
function performSearch() {
    const searchTerm = searchInput.value.toLowerCase().trim();

    if (!searchTerm) {
        renderAllProducts();
        return;
    }

    const filtered = products.filter(product =>
        product.name.toLowerCase().includes(searchTerm) ||
        product.category.toLowerCase().includes(searchTerm) ||
        product.description.toLowerCase().includes(searchTerm)
    );

    renderAllProducts(filtered);

    // Scroll to products section
    document.querySelector('.all-products').scrollIntoView({ behavior: 'smooth' });
}

// Filter Products
function filterProducts(category) {
    if (category === 'all') {
        renderAllProducts();
    } else {
        const filtered = products.filter(product => product.category === category);
        renderAllProducts(filtered);
    }
}

// Checkout button
document.getElementById('checkoutBtn').addEventListener('click', () => {
    if (cart.length === 0) {
        showNotification('Your cart is empty!');
        return;
    }
    showNotification('Proceeding to checkout...');
    closeCartPanel();
});

// Make functions globally available
window.addToCart = addToCart;
window.removeFromCart = removeFromCart;
window.updateQuantity = updateQuantity;
