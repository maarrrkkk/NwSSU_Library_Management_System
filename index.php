<?php
require_once 'components/header.php'; 
?>

<div class="item">
    <div class="main-content">
        <?php
        require_once 'components/profile.php'; 
        ?>
        <div class="list-section">
            <div class="top-list">
                <input type="text" class="search-input" placeholder="Search borrower...">
                <button class="add-button" id="openModal">+ Add Borrower</button>
                <?php
                require_once 'components/add-borrower-modal.php'; 
                ?>
            </div>

            <div class="list-container">
                
            <!-- fetching data from the borrower table -->
             
            <?php
            include './includes/connection.php'; // This file should set up your $conn or $pdo connection

            $query = "SELECT * FROM borrowers";
            $result = $conn->query($query); // Change to $pdo->query(...) if you're using PDO

            while ($row = $result->fetch_assoc()) {
                $status = ucfirst($row['status']);
                $studentId = $row['student_id'] ?: 'N/A';
                $bookCount = $row['number_of_books'] . ' book' . ($row['number_of_books'] != 1 ? 's' : '');
            
                echo "
                <a href='borrower.php?id={$row['id']}' class='list-link'>
                <div class='list-item' data-id='{$row['id']}'>
                    <div class='list-info'>
                        <div class='name'>{$row['name']}</div>
                        <div class='details'>
                            <span class='student-indicator'><b>{$status}</b></span>
                            <span class='student-id'>{$studentId}</span>
                            <span class='book-count'>{$bookCount}</span>
                        </div>
                    </div>
                    <div class='actions'>
                        <button class='icon delete' title='Delete' onclick='deleteBorrower(event, {$row['id']})'></button>
                        <button class='icon message' title='Message'></button>
                        <button class='icon email' title='Email'></button>
                    </div>
                </div>
            </a>";
            }
            ?>


            </div>
        </div>
    </div>

    <!-- No div end for the class item here its inside the footer -->

    

<?php
require_once 'components/footer.php'; 
?>