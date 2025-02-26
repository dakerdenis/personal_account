document.addEventListener("DOMContentLoaded", function () {
    // Create the popup container dynamically
    const popupContainer = document.createElement("div");
    popupContainer.id = "register-doctor-popup";
    popupContainer.className = "popup";
    popupContainer.style.display = "none"; // Initially hidden
    popupContainer.innerHTML = `
        <div class="popup-content">
            <h2>Həkimə Qeydiyyat</h2>
            <p>Zəhmət olmasa tibbi sığorta polisiniz seçin:</p>
            <ul id="policy-list"></ul>
            <button id="confirm-registration">Təsdiqlə</button>
            <button id="close-popup">Bağla</button>
        </div>
    `;
    document.body.appendChild(popupContainer);

    const closePopup = document.getElementById("close-popup");
    closePopup.addEventListener("click", function () {
        popupContainer.style.display = "none";
    });

    document.getElementById("confirm-registration").addEventListener("click", async function () {
        const selectedPolicy = document.querySelector("input[name='selectedPolicy']:checked");
        if (!selectedPolicy) {
            alert("Zəhmət olmasa bir polis seçin.");
            return;
        }

        // Get selected policy number
        const cardNumber = selectedPolicy.value;
        console.log("Selected policy for registration:", cardNumber);

        // Ensure doctorId is passed correctly
        if (!popupContainer.dataset.doctorId) {
            console.error("Doctor ID is missing");
            return;
        }

        const doctorId = popupContainer.dataset.doctorId;
        console.log("Registering for Doctor ID:", doctorId);

        // Send request to backend to process SOAP request
        await registerForDoctor(doctorId, cardNumber);
    });
});

// Function to open popup and fetch session policies
async function openRegisterDoctorPopup(doctorId) {
    console.log("openRegisterDoctorPopup called for doctor ID:", doctorId);

    try {
        const response = await fetch("./vendor/GetSessionPolicies.php");
        const data = await response.json();

        console.log("Session policies received:", data);

        if (!data || data.length === 0) {
            alert("Tibbi sığorta polisləriniz tapılmadı.");
            return;
        }

        const policyListContainer = document.getElementById("policy-list");
        policyListContainer.innerHTML = ""; // Clear old data

        data.forEach(policyNumber => {
            const listItem = document.createElement("li");
            listItem.innerHTML = `<input type="radio" name="selectedPolicy" value="${policyNumber}"> ${policyNumber}`;
            policyListContainer.appendChild(listItem);
        });

        // Store doctorId in dataset to access it later
        document.getElementById("register-doctor-popup").dataset.doctorId = doctorId;
        document.getElementById("register-doctor-popup").style.display = "block";
    } catch (error) {
        console.error("Error fetching session policies:", error);
    }
}

// Function to send registration request to backend
async function registerForDoctor(doctorId, cardNumber) {
    console.log(`Sending registration request - Doctor ID: ${doctorId}, Card Number: ${cardNumber}`);

    try {
        const response = await fetch("./vendor/RegisterForDoctor.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `doctorId=${encodeURIComponent(doctorId)}&cardNumber=${encodeURIComponent(cardNumber)}`,
        });

        const data = await response.json();
        console.log("Doctor Registration Response:", data);

        if (data.success) {
            alert("Siz uğurla həkimə qeydiyyatdan keçdiniz.");
            document.getElementById("register-doctor-popup").style.display = "none"; // Hide popup after success
        } else {
            alert("Qeydiyyat uğursuz oldu. Zəhmət olmasa bir az sonra yenidən cəhd edin.");
            console.error("Error:", data.error || "Unknown error");
        }
    } catch (error) {
        console.error("Error registering for doctor:", error);
        alert("Həkimə qeydiyyatdan keçərkən bir xəta baş verdi. Zəhmət olmasa bir az sonra yenidən cəhd edin.");
    }
}
