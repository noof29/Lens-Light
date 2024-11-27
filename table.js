document.addEventListener("DOMContentLoaded", function () {
    // Define the services as objects
    const services = [
        {
            name: "Portrait Photography",
            description: "Personalized portrait sessions capturing individual or family essence.",
            duration: "1-2 hours",
            price: "20 OMR",
            id: "portrait"
        },
        {
            name: "Event Photography",
            description: "Full coverage of events like weddings, parties, and corporate events.",
            duration: "Varies",
            price: "25 OMR",
            id: "event"
        },
        {
            name: "Commercial Photography",
            description: "High-quality images for branding, advertising, and product showcases.",
            duration: "Project-based",
            price: "30 OMR",
            id: "commercial"
        }
    ];

    // Handle search functionality
    document.getElementById("search-btn").addEventListener("click", function () {
        const selectedService = document.getElementById("service-select").value;
        const tableBody = document.getElementById("table-body");
        const table = document.getElementById("service-table");

        // Clear previous results
        tableBody.innerHTML = "";

        // Find and display the selected service
        const service = services.find(s => s.id === selectedService);

        if (service) {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${service.name}</td>
                <td>${service.description}</td>
                <td>${service.duration}</td>
                <td>${service.price}</td>
            `;
            tableBody.appendChild(row);
            table.style.display = "table"; // Show the table
        } else {
            table.style.display = "none"; // Hide the table if no service found
        }
    });
});
