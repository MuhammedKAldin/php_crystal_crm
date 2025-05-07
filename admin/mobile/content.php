<?php
    include_once '../config/database.php';

    // Database connection
    $database = new Database();
    $db = $database->getConnection();

    if ($db === null) {
        $_SESSION['error'] = "Database connection failed.";
        header("Location: {$prevUrl}");
        exit;
    }
?>

<!-- Services - Form -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Services - AJAX -->
<script>
$(document).ready(function() {

    // When the delete button is clicked
    $('.delete').on('click', function() {
        var rowId = $(this).data('id'); // Get the id of the row
        var $row = $('#row-' + rowId); // Get the row element to remove it later

        if (confirm('Are you sure you want to delete this entry?')) {
            $.ajax({
                url: "./mobile/delete_application_ajax.php",
                type: 'POST',
                data: { id: rowId }, // Send the row id to the PHP file
                success: function(response) {
                    response = JSON.parse(response);

                    // If deletion was successful
                    if (response.success) {
                        $row.remove(); // Remove the row from the table
                    } else {
                        alert(response.error || 'Failed to delete entry.'); // Show error message
                    }
                },
                error: function() {
                    alert('An error occurred. Please try again.');
                }
            });
        }
    });

    // When the status is changed
    $('select[name="status"]').on('change', function() {
        var rowId = $(this).closest('tr').attr('id').split('-')[1]; // Get the row ID
        var status = $(this).val(); // Get the selected status
        var status_ar, status_en;

        // Assign values for status_ar and status_en based on the selected status
        if (status == 2) {
            status_ar = 'قبول';
            status_en = 'Accepted';
        } else if (status == 1) {
            status_ar = 'رفض';
            status_en = 'Rejected';
        } else {
            status_ar = 'منتظر';
            status_en = 'Pending';
        }

        // Update the displayed status in the table (both Arabic and English columns)
        $(this).closest('tr').find('td:nth-child(4)').text(status_ar); // Update the Arabic status
        $(this).closest('tr').find('td:nth-child(5)').text(status_en); // Update the English status

        // AJAX request to update the status in the database
        $.ajax({
            url: "./mobile/update_status_ajax.php", // Your PHP script to handle the update
            type: 'POST',
            data: {
                id: rowId,
                status_ar: status_ar,
                status_en: status_en,
                status: status // Send the integer status as well
            },
            success: function(response) {
                response = JSON.parse(response);
                if (response.success) {
                    alert('Status updated successfully!');
                } else {
                    alert('Failed to update status.');
                }
            },
            error: function() {
                alert('An error occurred. Please try again.');
            }
        });
    });
});
</script>


<?php
    // Fetch data from 'applications' table
    $query = "SELECT * FROM applications"; 
    $stmt = $db->prepare($query);
    $stmt->execute();
    $applications = $stmt->fetchAll(PDO::FETCH_ASSOC); 
?>

<!-- partial -->
<div class="main-panel" style="background-color: #f3f3f3;">
    <div class="content-wrapper">
        <div class="row" style="font-size:10px; top: -40px;position: relative;" >
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between flex-wrap">
                    <div class="d-flex align-items-end flex-wrap">
                        <div class="d-flex">
                            <i class="mdi mdi-home text-muted hover-cursor"></i>
                            <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;</p>
                            <p class="text-primary mb-0 hover-cursor"> Mobile Requests </p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-end flex-wrap" style="visibility:hidden;">
                        <button type="button" class="btn btn-light bg-white btn-icon mr-3 d-none d-md-block ">
                            <i class="mdi mdi-download text-muted"></i>
                        </button>
                        <button type="button" class="btn btn-light bg-white btn-icon mr-3 mt-2 mt-xl-0">
                            <i class="mdi mdi-clock-outline text-muted"></i>
                        </button>
                        <button type="button" class="btn btn-light bg-white btn-icon mr-3 mt-2 mt-xl-0">
                            <i class="mdi mdi-plus text-muted"></i>
                        </button>
                        <button class="btn btn-primary mt-2 mt-xl-0">Generate report</button>
                    </div>
                </div>

                <!-- New Content -->
                <div class="row" >
                    <div class="col-md-12" style="padding:20px;" ></div>
                </div>

                <div class="table-responsive card" style="padding:15px;">
                    <div class="table-wrapper">
                        <div class="table-title">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h2>Incoming <b>Requests</b></h2>
                                </div>
                            </div>
                        </div>
                        
                        <table class="table table-striped table-hover card-body">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status (AR)</th>
                                    <th>Status (EN)</th>
                                    <th>Status</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($applications as $row): ?>
                                    <tr id="row-<?php echo htmlspecialchars($row['id']); ?>">
                                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                        <td> 
                                            <?php 
                                            if ($row['status'] == 2) {
                                                echo 'قبول';
                                            } else if ($row['status'] == 1) {
                                                echo 'رفض';
                                            } else {
                                                echo 'منتظر';
                                            } 
                                            ?> 
                                        </td>
                                        <td> 
                                            <?php 
                                            if ($row['status'] == 2) {
                                                echo 'Accepted';
                                            } else if ($row['status'] == 1) {
                                                echo 'Rejected';
                                            } else {
                                                echo 'Pending';
                                            } 
                                            ?> 
                                        </td>
                                        <td>
                                            <select name="status" data-id="<?php echo htmlspecialchars($row['id']); ?>" style="position: relative;border-radius: 7px!important;padding: 7px!important;">
                                                <option value="0" <?php if ($row['status'] == 0) echo 'selected'; ?>>Pending</option>
                                                <option value="1" <?php if ($row['status'] == 1) echo 'selected'; ?>>Rejected</option>
                                                <option value="2" <?php if ($row['status'] == 2) echo 'selected'; ?>>Accepted</option>
                                            </select>                                      
                                        </td>
                                        <td>
                                            <a href="#deleteEmployeeModal" class="delete" data-toggle="modal" data-id="<?php echo htmlspecialchars($row['id']); ?>">
                                                <i style="font-size:30px;" class="mdi mdi-cancel menu-icon"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
