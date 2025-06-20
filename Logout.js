document.addEventListener("DOMContentLoaded", function () { 
  
    const logoutBtn = document.getElementById("log-out");
    if (logoutBtn) {
        logoutBtn.addEventListener('click', async function (e) {
            e.preventDefault(); 
            try {
                const response = await fetch('/Logout.php');
                const data = await response.json();
                if (response.ok) {
                    alert(data.message);
                    location.reload(); // osiguraj refresh
                } else {
                    alert(data.error);
                }
            } catch (error) {
                console.error("Error during logout:", error);
                alert("An error occurred. Please try again.");
            }
        });
    }
});


