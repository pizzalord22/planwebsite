<?php
require_once('php/database_Class.php');
/*
 * menu example
 * look at the first link
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - planningen</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/menu.css">
</head>
<body>
<div class="menuWrapper">
    <ul class="menu">
        <li>
            <a href="php/testFile.php?page=overzichtProjecten" class="menuItem">Overzicht projecten en taken</a>
        </li>
        <li>
            <a href="php/testFile.php?page=newProject" class="menuItem">Nieuw project</a>
        </li>
        <li>
            <a href="php/testFile.php?page=newTask" class="menuItem">Nieuwe taak</a>
        </li>
        <li>
            <a href="#" class="menuItem">Logout</a>
        </li>
    </ul>
</div>
<div class="container">
    <div class="row">
        <form class="form" method="post" action="php/login.php">
            <table>
                <tr>
                    <td><label for="Username">Username</label></td>
                    <td><input id="Username" name="Username" type="text" placeholder="Username" required></td>
                </tr>
                <tr>
                    <td><label for="Password">Password</label></td>
                    <td><input placeholder="Password" id="Password" name="Password" type="password" required>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Submit"></td>
                </tr>
            </table>
        </form>
    </div>
</div>
<section>
    <div class="container">
        <div class="footer">
            <div class="credits">@copy made by Mark</div>
            <div class="info"><a href="#infolink.html"></a></div>
        </div>
    </div>
</section>
</body>
</html>