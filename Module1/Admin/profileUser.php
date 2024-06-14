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
        <!-- DataTables Example -->
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-users"></i>
                        <center>
                        <h2>Profile Users</h2>
                        </center>
                    </div>
                    <div class="card-footer small text-muted">
                        <center>
                        <?php
                        date_default_timezone_set("Asia/Kuala_Lumpur");
                        echo "Generated : " . date("h:i:sa");
                        ?>
                        </center>
                    </div>
                    <div class="card-body">
                        <?php
                        // Display delete message if set
                        if (isset($deleteMessage)) {
                            echo $deleteMessage;
                        }
                        ?>
                        <style>
                            /* Table styling */
                            #dataTable {
                                width: 80%;
                                border-collapse: collapse;
                                margin-top: 15px;
                                margin-bottom: 20px;
                                padding-right: 0;
                                margin-left: auto;
                                margin-right: auto;
                            }

                            #dataTable th, #dataTable td {
                                border: 1px solid #ddd;
                                padding: 8px;
                                text-align: center;
                            }

                            #dataTable th {
                                padding-top: 12px;
                                padding-bottom: 12px;
                                background-color: #f2f2f2;
                                color: black;
                            }

                            #dataTable tr:nth-child(even) {
                                background-color: #f9f9f9;
                            }

                            #dataTable tr:hover {
                                background-color: #ddd;
                            }

                            .badge {
                                padding: 5px 10px;
                                border-radius: 5px;
                                text-decoration: none;
                            }

                            .bg-success {
                                background-color: #28a745;
                            }

                            .bg-danger {
                                background-color: #dc3545;
                            }

                            .text-white {
                                color: white;
                            }

                            /* Responsive styling */
                            @media screen and (max-width: 600px) {
                                #dataTable thead {
                                    display: none;
                                }

                                #dataTable, #dataTable tbody, #dataTable tr, #dataTable td {
                                    display: block;
                                    width: 100%;
                                }

                                #dataTable tr {
                                    margin-bottom: 15px;
                                }

                                #dataTable td {
                                    text-align: right;
                                    padding-left: 50%;
                                    position: relative;
                                }

                                #dataTable td:before {
                                    content: attr(data-label);
                                    position: absolute;
                                    left: 0;
                                    width: 20%;
                                    padding-left: 15px;
                                    font-weight: bold;
                                    text-align: left;
                                }
                            }
                        </style>
                        <div class="table-responsive">
                            <table id="dataTable" style="padding-top: 15px; padding-bottom: 20px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>ID</th>
                                        <th>Phone Number</th>
                                        <th>Email</th>
                                        <th>Level Of Study</th>
                                        <th>Year Of Study</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    <?php
                                    $ret = "SELECT * FROM student ORDER BY RAND() LIMIT 1000";
                                    $stmt = $link->prepare($ret);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    $cnt = 1;
                                    while ($row = $res->fetch_object()) {
                                    ?>
                                        <tr>
                                            <td data-label="#"><?php echo $cnt; ?></td>
                                            <td data-label="Name"><?php echo $row->STU_name; ?></td>
                                            <td data-label="ID"><?php echo $row->STU_studentID; ?></td>
                                            <td data-label="Phone Number"><?php echo $row->STU_phoneNum; ?></td>
                                            <td data-label="Email"><?php echo $row->STU_email; ?></td>
                                            <td data-label="Level Of Study"><?php echo $row->STU_type; ?></td>
                                            <td data-label="Year Of Study"><?php echo $row->STU_yearStudy; ?></td>
                                            <td data-label="Action">
                                            <a href="viewProfile.php?u_id=<?php echo $row->STU_studentID; ?>" class="badge bg-success text-white"><i class="fas fa-user"></i> View</a>
                                            </td>
                                        </tr>
                                    <?php
                                        $cnt++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
    <!-- Footer -->
</div>

<!-- Include your footer and other scripts here -->

<?php
// Close the database connection
mysqli_close($link);
?>
