<?php
// Include header file
require('../../Layout/admin_layout.php');

// Include database connection file
$link = mysqli_connect("localhost", "root", "", "web_eng");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}

// Handle delete request
if (isset($_GET['del'])) {
    $STU_studentID = $_GET['del'];
    $delQuery = "DELETE FROM student WHERE STU_studentID = ?";
    $stmt = $link->prepare($delQuery);
    $stmt->bind_param("i", $STU_studentID);
    
    if ($stmt->execute()) {
        $deleteMessage = "<div class='alert alert-success' role='alert'>User deleted successfully!</div>";
    } else {
        $deleteMessage = "<div class='alert alert-danger' role='alert'>Error: " . $stmt->error . "</div>";
    }
    
    // Close the statement
    $stmt->close();
}
?>
<link rel="stylesheet" href="manageUser.css">
<div id="content-wrapper">
    <div class="container-fluid mt-4">
        <!-- Breadcrumbs -->
        <div class="row justify-content-center">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">User</a>
                    </li>
                    <li class="breadcrumb-item active">Manage Users</li>
                </ol>
            </div>
        </div>

        <!-- DataTables Example -->
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-users"></i>
                        Registered Users
                    </div>
                    <div class="card-body">
                        <?php
                        // Display delete message if set
                        if (isset($deleteMessage)) {
                            echo $deleteMessage;
                        }
                        ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th style="width: 15%;">Name</th>
                                        <th style="width: 10%;">ID</th>
                                        <th style="width: 15%;">Phone Number</th>
                                        <th style="width: 20%;">Email</th>
                                        <th style="width: 15%;">Level Of Study</th>
                                        <th style="width: 10%;">Year Of Study</th>
                                        <th style="width: 10%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT * FROM student ORDER BY RAND() LIMIT 1000";
                                    $stmt = $link->prepare($ret);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    $cnt = 1;
                                    while ($row = $res->fetch_object()) {
                                    ?>
                                        <tr>
                                            <td><?php echo $cnt; ?></td>
                                            <td><?php echo $row->STU_name; ?></td>
                                            <td><?php echo $row->STU_studentID; ?></td>
                                            <td><?php echo $row->STU_phoneNum; ?></td>
                                            <td><?php echo $row->STU_email; ?></td>
                                            <td><?php echo $row->STU_type; ?></td>
                                            <td><?php echo $row->STU_yearStudy; ?></td>
                                            <td>
                                                <a href="admin-edit-user.php?u_id=<?php echo $row->STU_studentID; ?>" class="badge bg-success text-white"><i class="fas fa-user-edit"></i> Update</a>
                                                <a href="manageUser.php?del=<?php echo $row->STU_studentID; ?>" class="badge bg-danger text-white" onclick="return confirm('Are you sure you want to delete this user?');"><i class="fas fa-trash-alt"></i> Delete</a>
                                            </td>
                                        </tr>
                                    <?php
                                        $cnt = $cnt + 1;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer small text-muted">
                        <?php
                        date_default_timezone_set("Asia/Kuala_Lumpur");
                        echo "Generated : " . date("h:i:sa");
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    <!-- Footer -->
