document.addEventListener("DOMContentLoaded", function () {
	const logoutLink = document.getElementById("logoutLink");

	logoutLink.addEventListener("click", function (event) {
		event.preventDefault();
		window.location.href = "../controllers/logout.php";
	});
});
