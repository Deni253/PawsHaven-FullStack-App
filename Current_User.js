async function fetchUsername() {
    try {
        const response = await fetch('/Current_User.php');
        const data = await response.json();

        if (data.username) {
            const userInfoDiv = document.getElementById('user-info');
            userInfoDiv.className = 'alert alert-success flex-fill';
            userInfoDiv.style.marginLeft = '35rem';
            userInfoDiv.setAttribute('role', 'alert');
            userInfoDiv.innerHTML = `Logged in as: ${data.username}`;
        }
    } catch (error) {
        console.error('Error fetching username:', error);
    }
}
fetchUsername();