document.addEventListener("DOMContentLoaded", function () {
  // Utility function to open a modal
  function openModalHandler(modalOverlay) {
    if (modalOverlay) modalOverlay.style.display = "flex";
  }

  // Utility function to close a modal
  function closeModalHandler(modalOverlay) {
    if (modalOverlay) modalOverlay.style.display = "none";
  }

  // General Escape key handler for all modals
  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") {
      document.querySelectorAll(".modal-overlay").forEach((modal) => {
        modal.style.display = "none";
      });
    }
  });

  // Modal: Add Borrower
  const openModal = document.getElementById("openModal");
  const closeModal = document.getElementById("closeModal");
  const modalOverlay = document.getElementById("modalOverlay");

  openModal?.addEventListener("click", () => openModalHandler(modalOverlay));
  closeModal?.addEventListener("click", () => closeModalHandler(modalOverlay));

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") {
      const allModals = document.querySelectorAll(
        ".modal-overlay, .add-book-overlay"
      );
      allModals.forEach((modal) => {
        modal.style.display = "none";
      });
    }
  });

  // Conditional student ID field toggle
  const statusSelect = document.getElementById("statusSelect");
  const studentIdField = document.getElementById("studentIdField");

  statusSelect?.addEventListener("change", () => {
    if (studentIdField) {
      studentIdField.style.display =
        statusSelect.value === "Student" ? "block" : "none";
    }
  });

  if (statusSelect && studentIdField) {
    studentIdField.style.display =
      statusSelect.value === "Student" ? "block" : "none";
  }

  // Modal: Add Book
  const openAddBookModal = document.querySelector(".add-book-button");
  const closeAddBookModal = document.getElementById("closeAddBookModal");
  const addBookModalOverlay = document.getElementById("addBookModalOverlay");

  openAddBookModal?.addEventListener("click", () =>
    openModalHandler(addBookModalOverlay)
  );
  closeAddBookModal?.addEventListener("click", () =>
    closeModalHandler(addBookModalOverlay)
  );

  addBookModalOverlay?.addEventListener("click", (e) => {
    if (e.target === addBookModalOverlay)
      closeModalHandler(addBookModalOverlay);
  });

  // Borrower Form Submission
  document
    .getElementById("borrowerForm")
    .addEventListener("submit", function (e) {
      e.preventDefault();

      const form = e.target;
      const formData = new FormData(form);

      fetch("includes/process-add-borrower.php", {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((response) => {
          if (response.status === "success") {
            form.reset();
            showToast("✅ Borrower added successfully!");
          } else if (response.status === "exists") {
            showToast("⚠️ Borrower already exists.");
          } else {
            showToast("❌ Error adding borrower.");
            console.error(response.message);
          }
        })
        .catch((error) => {
          showToast("❌ Server error.");
          console.error("Error:", error);
        });
    });

  // Book Form Submission
  const addBookForm = document.getElementById("addBookForm");

  if (addBookForm) {
    addBookForm.addEventListener("submit", function (e) {
      e.preventDefault();

      const formData = new FormData(addBookForm);
      const borrowerId = new URLSearchParams(window.location.search).get("id");
      if (borrowerId) {
        formData.set("borrower_id", borrowerId);
      }

      fetch("includes/process-add-book.php", {
        method: "POST",
        body: formData,
      })
        .then((res) => res.text())
        .then((response) => {
          if (response.includes("✅")) {
            showToast("✅ Book added successfully!");
            addBookForm.reset();
            closeModalHandler(addBookModalOverlay);
            setTimeout(() => {
              location.reload();
            }, 1000);
          } else if (response.includes("❌")) {
            showToast(response); // Show the custom message from PHP
          } else {
            showToast("❌ Error adding book.");
            console.error(response);
          }
        })
        .catch((error) => {
          showToast("❌ Server error.");
          console.error("Error:", error);
        });
    });
  }

  // Toast Message
  function showToast(message) {
    const toast = document.getElementById("toast");
    if (!toast) return;

    toast.textContent = message;
    toast.classList.remove("hidden");

    setTimeout(() => {
      toast.classList.add("hidden");
    }, 4000);
  }

  // DELETE Borrower
  window.deleteBorrower = function (event, name) {
    event.preventDefault();

    if (confirm("Are you sure you want to delete this borrower?")) {
      fetch("includes/delete_borrower.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "id=" + encodeURIComponent(name),
      })
        .then((response) => response.text())
        .then((result) => {
          if (result === "success") {
            const listItem = event.target.closest(".list-item");
            listItem.remove();
            showToast("✅ Borrower deleted successfully!");
          } else {
            showToast("❌ Failed to delete borrower.");
            console.error(result);
          }
        })
        .catch((error) => {
          showToast("❌ An error occurred while deleting.");
          console.error(error);
        });
    }
  };

  // 🔍 Search Borrowers (Client-Side Filter)
  const searchInput = document.getElementById("borrowerSearch");
  const borrowerList = document.getElementById("borrowerList");

  if (searchInput && borrowerList) {
    const borrowerItems = borrowerList.querySelectorAll(".list-link");

    searchInput.addEventListener("input", function () {
      const searchTerm = searchInput.value.toLowerCase();

      borrowerItems.forEach(function (item) {
        const name =
          item.querySelector(".name")?.textContent.toLowerCase() || "";
        const studentId =
          item.querySelector(".student-id")?.textContent.toLowerCase() || "";
        const status =
          item.querySelector(".student-indicator")?.textContent.toLowerCase() ||
          "";

        const matches =
          name.includes(searchTerm) ||
          studentId.includes(searchTerm) ||
          status.includes(searchTerm);

        item.style.display = matches ? "block" : "none";
      });
    });
  }
});
