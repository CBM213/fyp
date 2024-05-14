document.addEventListener('DOMContentLoaded', function() {
    fetchProducts(); // Fetch products when the DOM is fully loaded

    const searchInput = document.querySelector('.main-search-input-item input');
    const searchButton = document.querySelector('.main-search-button');

    if (searchInput) {
        // Listen for input event to trigger search automatically
        searchInput.addEventListener('input', searchOrders);

        // Listen for Enter key press to prevent form submission
        searchInput.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Prevent the default Enter key behavior
                searchOrders();
            }
        });
    }

    if (searchButton) {
        searchButton.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default button behavior
            searchOrders();
        });
    }
});

// Function to fetch and render products
function fetchProducts() {
    fetch('getProducts.php')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.json();
    })
    .then(result => {
        if (result.error) {
            console.error('Error fetching products:', result.error);
            return;
        }
        if (!Array.isArray(result.data)) { // Accessing the array via result.data
            console.error('Expected an array but received:', result.data);
            return;
        }
        renderProducts(result.data); // Pass the actual data array to renderProducts
    })
    .catch(error => {
        console.error('Failed to fetch products:', error);
    });
}

// Function to render products to the table
function renderProducts(data) {
    const tableBody = document.querySelector('#products-list tbody');
    if (!tableBody) {
        console.error('Table body not found');
        return;
    }
    tableBody.innerHTML = ''; // Clear existing rows
    data.forEach(product => {
        const price = product.DiscountedPrice !== undefined ? parseFloat(product.DiscountedPrice).toFixed(2) : 'Not Available';

        const tr = document.createElement('tr');
        tr.classList.add('category-row'); // Add class for styling or selection
        tr.innerHTML = `
            <td>${product.ProdName}</td>
            <td>${product.CatName}</td>
            <td>$${price}</td>
            <td>${product.Quantity}</td>
        `;
        tableBody.appendChild(tr);
    });
}

// Function to handle search filtering
function searchOrders() {
    const searchText = document.querySelector('.main-search-input-item input').value.toLowerCase();
    const orders = document.querySelectorAll('.category-row');

    orders.forEach(order => {
        const orderText = order.textContent.toLowerCase();
        order.style.display = (searchText === '' || orderText.includes(searchText)) ? '' : 'none';
    });
}
