document.addEventListener('DOMContentLoaded', function() {
    fetchOrders(); // Fetch orders when the DOM is fully loaded

    // Attach event listeners to search input and button
    var searchInput = document.querySelector('.main-search-input-item input');
    var searchButton = document.querySelector('.main-search-button');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            // Trigger search functionality
            searchOrders(this.value);
        });
        searchInput.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                searchOrders(this.value);
            }
        });
    }

    if (searchButton) {
        searchButton.addEventListener('click', function(event) {
            event.preventDefault();
            searchOrders(searchInput.value);
        });
    }

    // Event delegation for dynamically added "Update Order" buttons
    document.querySelector('#orders-list tbody').addEventListener('click', function(event) {
        if (event.target.classList.contains('update-btn')) {
            const orderId = event.target.dataset.orderId;
            const orderRow = event.target.closest('tr');
            const orderNumber = orderRow.querySelector('td').textContent;
            const currentStatus = orderRow.querySelector('td:nth-child(3)').textContent;
            confirmUpdate(orderId, orderNumber, currentStatus, orderRow);
        }
    });
});

function fetchOrders() {
    fetch('getorders.php')
    .then(response => response.json())
    .then(data => {
        const tableBody = document.querySelector('#orders-list tbody');
        tableBody.innerHTML = ''; // Clear existing rows
        data.forEach(order => {
            const rowClass = order.Status === 'Delivered' ? 'delivered-row' : 'pending-row'; // Choose class based on status
            const row = `
                <tr class="${rowClass}">
                    <td> Order# ${order.OrderID}</td>
                    <td>${order.Username}</td>
                    <td>${order.Status}</td>
                    <td>$${order.Amount}</td>
                    <td>
                        <button class="update-btn" data-order-id="${order.OrderID}">
                            Update Order
                        </button>
                    </td>
                </tr>
            `;
            tableBody.innerHTML += row;
        });
    })
    .catch(error => {
        console.error('Failed to fetch orders:', error);
    });
}

function confirmUpdate(orderId, orderNumber, currentStatus, orderRow) {
    const confirmed = confirm(`Do you want to update ${orderNumber}'s status?`);
    if (confirmed) {
        const newStatus = currentStatus === 'Delivered' ? 'Pending' : 'Delivered';
        updateOrderStatus(orderId, newStatus, orderRow);
    }
}

function updateOrderStatus(orderId, newStatus, orderRow) {
    let formData = new FormData();
    formData.append('order_id', orderId);
    formData.append('new_status', newStatus);

    fetch('updateorder.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert('Error: ' + data.error);
        } else {
            alert(`Order #${orderId} status updated to ${newStatus}.`);
            // Update the UI immediately
            orderRow.querySelector('td:nth-child(3)').textContent = newStatus;
            orderRow.className = newStatus === 'Delivered' ? 'delivered-row' : 'pending-row';
        }
    })
    .catch(error => {
        alert('Failed to update order: ' + error.message);
    });
}

function searchOrders(query) {
    const searchText = query.toLowerCase(); // Get the search query and convert to lowercase
    const rows = document.querySelectorAll('#orders-list tbody tr'); // Select all rows in the orders table

    rows.forEach(row => {
        const usernameCell = row.querySelector('td:nth-child(2)'); // Get the username cell, assuming it's the second column
        const username = usernameMatches(usernameCell, searchText);

        row.style.display = username ? '' : 'none'; // Display row if username matches, hide otherwise
    });
}

function usernameMatches(cell, searchText) {
    return cell.textContent.toLowerCase().includes(searchText); // Check if the username includes the search text
}
