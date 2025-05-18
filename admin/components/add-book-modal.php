<div class="add-book-overlay" id="addBookModalOverlay" style="display: none;">
  <div class="add-book-modal">
    <div class="modal-header">
      <h2>Add New Book</h2>
    </div>
    <form class="add-book-form" id="addBookForm" method="POST" action="borrower.php?id=<?= $currentBorrowerId ?>">
      <input type="hidden" name="borrower_id" id="borrowerIdInput" value="<?= $currentBorrowerId ?>" />

      <label>Book Title:</label>
      <input type="text" name="book_title" placeholder="Enter book title" required />

      <label>Book ID:</label>
      <input type="text" name="book_id" placeholder="Enter book ID" required />

      <label>Borrowed Date:</label>
      <input type="date" name="borrow_date" required />

      <label>Return Date:</label>
      <input type="date" name="return_date" required />

      <div class="modal-actions">
        <button type="submit">Add</button>
        <button type="button" id="closeAddBookModal">Cancel</button>
      </div>
    </form>
  </div>
</div>
