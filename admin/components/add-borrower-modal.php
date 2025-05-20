<div class="modal-overlay" id="modalOverlay">
  <div class="modal">
    <h2>Add Borrower</h2>

    <form class="modal-form" id="borrowerForm" method="POST" action="./../includes/process-add-borrower.php">
      <label>Name:</label>
      <input type="text" name="name" required>

      <label>Age:</label>
      <input type="number" name="age" required>

      <label>Status:</label>
      <select id="statusSelect" name="status">
        <option value="Student">Student</option>
        <option value="Teacher">Teacher</option>
        <option value="Graduated">Graduated</option>
      </select>

      <div id="studentIdField">
        <label>Student ID:</label>
        <input type="text" name="student_id" placeholder="Enter Student ID">
      </div>

      <div id="teacherIdField">
        <label>Teacher ID:</label>
        <input type="text" name="teacher_id" placeholder="Enter Teacher ID">
      </div>

      <label>Email:</label>
      <input type="email" name="email">

      <label>Phone Number:</label>
      <input type="text" name="phone">

      <div class="modal-actions">
        <button type="submit">Submit</button>
        <button type="button" id="closeModal">Cancel</button>
      </div>
    </form>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  function toggleIdFields() {
    const status = $('#statusSelect').val();
    if (status === 'Student') {
      $('#studentIdField').show();
      $('#teacherIdField').hide();
    } else if (status === 'Teacher') {
      $('#teacherIdField').show();
      $('#studentIdField').hide();
    } else {
      $('#studentIdField').hide();
      $('#teacherIdField').hide();
    }
  }

  $(document).ready(function() {
    toggleIdFields(); // initial check

    $('#statusSelect').on('change', function() {
      toggleIdFields();
    });
  });
</script>