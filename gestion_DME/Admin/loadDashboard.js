document.addEventListener("DOMContentLoaded", function() {
    const dashboardContainer = document.getElementById("dashboard-container");
    
    if (dashboardContainer) {
        fetch("dashboard.php")
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.text();
            })
            .then(data => {
                dashboardContainer.innerHTML = data;
            })
            .catch(error => {
                console.error('There has been a problem with your fetch operation:', error);
            });
    } else {
        console.error("Element with id 'dashboard-container' not found");
    }
});
