<?php
include 'student_layout.php';
?>

<h2>Manage Booking</h2>
<div class="row">
    <div class="col-md-6">
        <h3>Book a Parking Space</h3>
        <form action="book_parking_action.php" method="POST">
            <div class="form-group">
                <label for="parking_space">Select Parking Space:</label>
                <select class="form-control" id="parking_space" name="parking_space">
                    <option value="A1">A1</option>
                    <option value="A2">A2</option>
                    <option value="A3">A3</option>
                    <!-- Add more parking spaces as needed -->
                </select>
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="time">Time:</label>
                <input type="time" class="form-control" id="time" name="time" required>
            </div>
            <button type="submit" class="btn btn-primary">Book Now</button>
        </form>
    </div>
    <div class="col-md-6">
        <h3>My Bookings</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Parking Space</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch bookings from database
                // Assuming $bookings is an array of bookings fetched from the database
                // Example data
                $bookings = [
                    ['space' => 'A1', 'date' => '2024-06-01', 'time' => '08:00 AM'],
                    ['space' => 'A2', 'date' => '2024-06-02', 'time' => '09:00 AM']
                ];
                foreach ($bookings as $booking) {
                    echo "<tr>
                        <td>{$booking['space']}</td>
                        <td>{$booking['date']}</td>
                        <td>{$booking['time']}</td>
                        <td>
                            <a href='cancel_booking.php?id={$booking['id']}' class='btn btn-danger btn-sm'>Cancel</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
