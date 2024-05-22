document.addEventListener("DOMContentLoaded", () => {
    const openFormBtn = document.getElementById("openFormBtn");
    const personalInfoForm = document.getElementById("personalInfoForm");
    const infoForm = document.getElementById("infoForm");

    openFormBtn.addEventListener("click", () => {
        personalInfoForm.style.display = "flex";
    });

    infoForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const fname = document.getElementById("fname").value;
        const lname = document.getElementById("lname").value;
        const email = document.getElementById("email").value;
        const phone = document.getElementById("phone").value;

        if (fname && lname && email && phone) {
            alert("Personal information updated successfully!");
            personalInfoForm.style.display = "none";
        } else {
            alert("Please fill out all required fields.");
        }
    });
});