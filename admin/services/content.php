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
    $('#smtp-form').on('submit', function(e) {
        e.preventDefault(); 
        
        // Disable the button and show loading spinner
        var $button = $('.ajax-submit');
        $button.prop('disabled', true);
        $button.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

        // $.ajax({
        //     url: "./services/owner_smtp_form.php",
        //     method: 'POST',
        //     data: $(this).serialize(),
        //     success: function(response) {
        //         if (response.success) {
        //             $('#alert-box').html('<div class="alert alert-success" role="alert">Settings updated successfully!</div>');
        //         } else {
        //             $('#alert-box').html('<div class="alert alert-danger" role="alert">Failed to update settings.</div>');
        //         }
        //     },
        //     error: function(xhr, status, error) {
        //         $('#alert-box').html('<div class="alert alert-danger" role="alert">An error occurred. Please try again.</div>');
        //     }
        // });

        $.ajax({
            url: "./services/owner_smtp_ajax.php",
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#alert-box').html('<div class="alert alert-success" role="alert">Settings updated successfully!</div>');
                } else {
                    $('#alert-box').html('<div class="alert alert-danger" role="alert">Failed to update settings.</div>');
                }
            },
            error: function(xhr, status, error) {
                $('#alert-box').html('<div class="alert alert-danger" role="alert">An error occurred. Please try again.</div>');
            },
            complete: function() {
                // Re-enable the button and reset the text after AJAX is complete
                $button.prop('disabled', false);
                $button.html('Save');
            }
        });
    });
});

</script>

<?php
    // Fetch data from 'owner_smtp' table
    $query = "SELECT * FROM owner_smtp WHERE id = 1"; // assuming you want to get the first row
    $stmt = $db->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the row exists
    $host = $row['host'] ?? '';
    $port = $row['port'] ?? '';
    $username = $row['username'] ?? '';
    $password = $row['password'] ?? '';
    $setfrom = $row['setfrom'] ?? '';
    $replyto = $row['replyto'] ?? '';
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
                            <p class="text-primary mb-0 hover-cursor">Services</p>
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
                    <div class="col-md-12" style="padding:50px;" ></div>
                </div>

                <div class="row" style="padding-left:20px; font-size:10px;  transform: scale(0.8)!important; transform-origin: top left; top: -80px; position: relative;" >
                    <div class="col-md-4">
                        <div class="card">
                            <h4 style="padding:10px;">SMTP</h4>
                            <div class="card-body">
                                <!-- Alert box for displaying response messages -->
                                <div id="alert-box"></div>
                                
                                <!-- Added an id attribute to the form -->
                                <form class="forms-sample" id="smtp-form" method="POST">
                                    <div class="form-group">
                                        <label for="host">Host</label>
                                        <input type="text" name="host" class="form-control" placeholder="smtp-relay.brevo.com" value="<?= htmlspecialchars($host) ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="port">Port</label>
                                        <input type="text" name="port" class="form-control" placeholder="587" value="<?= htmlspecialchars($port) ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" name="username" class="form-control" placeholder="7d778a001@smtp-brevo.com" value="<?= htmlspecialchars($username) ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="text" name="password" class="form-control" placeholder="TWpv5k3PU1NVBz8E" value="<?= htmlspecialchars($password) ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="setfrom">Set From</label>
                                        <input type="text" name="setfrom" class="form-control" placeholder="test@mailer.com" value="<?= htmlspecialchars($setfrom) ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="replyto">Reply to</label>
                                        <input type="text" name="replyto" class="form-control" placeholder="test@support.com" value="<?= htmlspecialchars($replyto) ?>">
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary ajax-submit">Save</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>