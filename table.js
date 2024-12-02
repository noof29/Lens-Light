document.addEventListener("DOMContentLoaded", function () {
    // Define the services as objects in an array
    const services = [
        {
            name: "Portrait Photography", // Name of the service
            description: "Personalized portrait sessions capturing individual or family essence.", // Description of the service
            duration: "1-2 hours", // Duration of the service
            price: "20 OMR", // Price of the service
            id: "portrait" // Unique identifier for the service
        },
        {
            name: "Event Photography", // Name of the service
            description: "Full coverage of events like weddings, parties, and corporate events.", // Description of the service
            duration: "Varies", // Duration of the service
            price: "25 OMR", // Price of the service
            id: "event" // Unique identifier for the service
        },
        {
            name: "Commercial Photography", // Name of the service
            description: "High-quality images for branding, advertising, and product showcases.", // Description of the service
            duration: "Project-based", // Duration of the service
            price: "30 OMR", // Price of the service
            id: "commercial" // Unique identifier for the service
        }
    ];

    // Elements from the DOM that will be interacted with
    const serviceSelect = document.getElementById("service-select"); // Dropdown to select a service
    const searchBtn = document.getElementById("search-btn"); // Search button to filter results
    const tableBody = document.getElementById("table-body"); // Table body where services will be displayed
    const table = document.getElementById("service-table"); // Table itself that will show the service details

    // Disable the search button initially, as no service is selected by default
    searchBtn.disabled = true;

    // Enable the search button when a valid service is selected from the dropdown
    serviceSelect.addEventListener("change", function () {
        // If the user selects a service, the button becomes enabled, otherwise, it's disabled
        searchBtn.disabled = serviceSelect.value === "";
    });

    // Handle the search button click to show the selected service details
    searchBtn.addEventListener("click", function () {
        // Get the selected service ID from the dropdown
        const selectedService = serviceSelect.value;

        // Clear the previous table content to avoid stacking of data
        tableBody.innerHTML = "";

        // Find the service object that matches the selected ID
        const service = services.find(s => s.id === selectedService);

        if (service) {
            // If a valid service is found, create a new row to display its details in the table
            const row = document.createElement("tr"); // Create a new row element
            row.innerHTML = ` 
                <td>${service.name}</td> <!-- Display the name of the service -->
                <td>${service.description}</td> <!-- Display the description of the service -->
                <td>${service.duration}</td> <!-- Display the duration of the service -->
                <td>${service.price}</td> <!-- Display the price of the service -->
            `;
            tableBody.appendChild(row); // Append the new row to the table body
            table.style.display = "table"; // Make sure the table is visible
        } else {
            // If no service is found (though this case shouldn't happen), hide the table
            table.style.display = "none"; // Hide the table
        }
    });
});
