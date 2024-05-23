<?php
include('../../header/home.php');
?>
<link rel="stylesheet" href="Login.css">

<section id="home">
    <center>
        <h1>Welcome to FKPark</h1>
        <p>Manage your parking with ease.</p>
    </center>
</section>

<div id="loginModal" class="modal">
    <form class="modal-content animate" method="post" action="login.php">
        <div class="imgcontainer">
            <span onclick="document.getElementById('loginModal').style.display='none'" class="close" title="Close Modal">&times;</span>
            <img src="FKPark.jpg" alt="Avatar" class="avatar">
        </div>

        <div class="container">
            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>

            <label for="uname"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="uname" required>

            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>

            <label for="type"><b>Category</b></label>
            <select name="type" id="type" required>
                <option value="admin">Administrator</option>
                <option value="staff">Staff</option>
                <option value="student">Student</option>
            </select>

            <button type="submit" id="login">Login</button>
            <label>
                <input type="checkbox" checked="checked" name="remember"> Remember me
            </label>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <div class="psw">Forgot <a href="#">password?</a></div>
        </div>
    </form>
</div>

<?php
include('../../footer/footer.php');
?>
