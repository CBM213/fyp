function searchOrders() {
    var searchText = document.querySelector('.main-search-input-item input').value.toLowerCase();
    var orders = document.querySelectorAll('.category-row');

    orders.forEach(function(order) {
        var orderText = order.textContent.toLowerCase();
        if (searchText === '' || orderText.includes(searchText)) {
            order.style.display = '';
        } else {
            order.style.display = 'none';
        }
    });
}


// Function to fetch and render orders
function fetchOrders() {
    fetch('getCustomers.php')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        if (data.error) {
            console.error('Error fetching orders:', data.error);
            return;
        }
        const tableBody = document.querySelector('#customers-list tbody');
        if (!tableBody) {
            console.error('Table body not found');
            return;
        }
        tableBody.innerHTML = '';
        data.forEach(customers => {
            const tr = document.createElement('tr');
            tr.classList.add('category-row'); // Add class to each row
            tr.innerHTML = `
            <td>${customers.Username}</td>
            <td>${customers.City}/${customers.Street}/${customers.Building}/${customers.Floor}/${customers.Apartment}</td>
            `;
            tableBody.appendChild(tr);
        });
    })
    .catch(error => {
        console.error('Failed to fetch orders:', error);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    fetchOrders(); // Fetch orders when the DOM is fully loaded

    var searchInput = document.querySelector('.main-search-input-item input');
    var searchButton = document.querySelector('.main-search-button');

    if (searchInput) {
        // Listen for input event to trigger search automatically
        searchInput.addEventListener('input', function() {
            searchOrders();
        });

        // Listen for Enter key press to prevent form submission
        searchInput.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Prevent the default Enter key behavior
            }
        });
    }

    if (searchButton) {
        searchButton.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default button behavior
            searchOrders();
        });
    }

    // ... rest of the code ...
});