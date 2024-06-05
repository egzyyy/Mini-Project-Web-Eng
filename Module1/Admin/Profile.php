<?php
// Include header file
require('../../Layout/admin_layout.php');

$link = mysqli_connect("localhost", "root", "");

if (!$link) {
    die('Error connecting to the server: ' . mysqli_connect_error());
}
// Include database connection file
mysqli_select_db($link, "web_eng");
?>
<body>
<link rel="stylesheet" href="Profile.css">
<div class="main">
        <h2>IDENTITY</h2>
        <div class="card">
            <div class="card-body">
                <i class="fa fa-pen fa-xs edit"></i>
                <table>
                    <tbody>
                        <tr>
                            <td><b>Name</b></td>
                            <td>:</td>
                            <td>ImDezCode</td>
                        </tr>
                        <tr>
                            <td><b>Email</b></td>
                            <td>:</td>
                            <td>imdezcode@gmail.com</td>
                        </tr>
                        <tr>
                            <td><b>Address</b></td>
                            <td>:</td>
                            <td>Bali, Indonesia</td>
                        </tr>
                        <tr>
                            <td><b>Hobbies</b></td>
                            <td>:</td>
                            <td>Diving, Reading Book</td>
                        </tr>
                        <tr>
                            <td><b>Job</b></td>
                            <td>:</td>
                            <td>Web Developer</td>
                        </tr>
                        <tr>
                            <td><b>Skill</b></td>
                            <td>:</td>
                            <td>PHP, HTML, CSS, Java</td>
                        </tr>
                        <tr>
                        <td>
                                <button class="btn btn-edit" >Edit</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <h2>EDUCATIONAL BACKGROUND</h2>
        <div class="card">
            <div class="card-body">
                <i class="fa fa-pen fa-xs edit"></i>
                <table>
                    <tbody>
                        <tr>
                            <td><b>Name</b></td>
                            <td>:</td>
                            <td>ImDezCode</td>
                        </tr>
                        <tr>
                            <td><b>Email</b></td>
                            <td>:</td>
                            <td>imdezcode@gmail.com</td>
                        </tr>
                        <tr>
                            <td><b>Address</b></td>
                            <td>:</td>
                            <td>Bali, Indonesia</td>
                        </tr>
                        <tr>
                            <td><b>Hobbies</b></td>
                            <td>:</td>
                            <td>Diving, Reading Book</td>
                        </tr>
                        <tr>
                            <td><b>Job</b></td>
                            <td>:</td>
                            <td>Web Developer</td>
                        </tr>
                        <tr>
                            <td><b>Skill</b></td>
                            <td>:</td>
                            <td>PHP, HTML, CSS, Java</td>
                        </tr>
                        <tr>
                        <td>
                                <button class="btn btn-edit" >Edit</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
<?php
// Include footer and scripts
include('../../footer/footer.php');
?>