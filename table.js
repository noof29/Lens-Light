// Wait for the DOM content to be fully loaded before running the script
document.addEventListener("DOMContentLoaded", function () {
    // Define the services as an array of objects, where each object represents a service
    const services = [
        {
            name: "Portrait Photography",  // The name of the service
            description: "Personalized portrait sessions capturing individual or family essence.",  // A description of the service
            duration: "1-2 hours",  // The typical duration of the service
            price: "20 OMR",  // The starting price of the service
            id: "portrait"  // Unique identifier for the service, used to match with the selected service
        },
        {
            name: "Event Photography",
            description: "Full coverage of events like weddings, parties, and corporate events.",
            duration: "Varies",  // Duration may vary based on event type
            price: "25 OMR",
            id: "event"  // Unique identifier for event photography
        },
        {
            name: "Commercial Photography",
            description: "High-quality images for branding, advertising, and product showcases.",
            duration: "Project-based",  // Duration depends on the project
            price: "30 OMR",
            id: "commercial"  // Unique identifier for commercial photography
        }
    ];

    // Add event listener for the "Search" button to trigger the search functionality
    document.getElementById("search-btn").addEventListener("click", function () {
        // Get the selected service value from the dropdown menu
        const selectedService = document.getElementById("service-select").value;
        // Get the table body where the result rows will be inserted
        const tableBody = document.getElementById("table-body");
        // Get the table element to control its visibility
        const table = document.getElementById("service-table");

        // Clear any previous search results by emptying the table body
        tableBody.innerHTML = "";

        // Find the selected service from the services array using the selected ID
        const service = services.find(s => s.id === selectedService);

        // If a matching service is found, create a row and display it
        if (service) {
            // Create a new table row with the details of the selected service
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${service.name}</td>  <!-- Service Name -->
                <td>${service.description}</td>  <!-- Service Description -->
                <td>${service.duration}</td>  <!-- Service Duration -->
                <td>${service.price}</td>  <!-- Service Price -->
            `;
            // Append the new row to the table body
            tableBody.appendChild(row);
            // Make the table visible by changing its display style to "table"
            table.style.display = "table";
        } else {
            // If no matching service is found, hide the table
            table.style.display = "none";
        }
    });
});
