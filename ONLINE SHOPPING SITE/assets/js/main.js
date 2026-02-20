/**
 * ADIEYEFEH ONLINE SHOPPING - JavaScript
 */

// Add to cart function
function addToCart(productId) {
    fetch('cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'add_to_cart=1&product_id=' + productId + '&quantity=1'
    })
    .then(response => response.text())
    .then(data => {
        alert('Product added to cart!');
        location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Filter products by category
function filterProducts(category) {
    const products = document.querySelectorAll('.product-card');
    
    products.forEach(product => {
        if (category === 'all') {
            product.style.display = 'block';
        } else {
            if (product.dataset.category === category) {
                product.style.display = 'block';
            } else {
                product.style.display = 'none';
            }
        }
    });
    
    // Update active button
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
        if (btn.dataset.filter === category) {
            btn.classList.add('active');
        }
    });
}

// Filter by category card
function filterCategory(category) {
    document.getElementById('shop').scrollIntoView({ behavior: 'smooth' });
    setTimeout(() => {
        filterProducts(category);
    }, 300);
}

// Search products
function searchProducts() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const products = document.querySelectorAll('.product-card');
    
    products.forEach(product => {
        const name = product.querySelector('.product-title').textContent.toLowerCase();
        const category = product.querySelector('.product-category').textContent.toLowerCase();
        
        if (name.includes(searchTerm) || category.includes(searchTerm)) {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Search button click
    const searchBtn = document.getElementById('searchBtn');
    if (searchBtn) {
        searchBtn.addEventListener('click', searchProducts);
    }
    
    // Search input enter key
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchProducts();
            }
        });
    }
});
