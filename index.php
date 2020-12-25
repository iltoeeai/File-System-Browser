<?php
require('login_logout.php');
require('header.php'); // adds required file. The same like include just require stops reading the code if there is a mistake
require('footer.php'); // include would still read the code even if there was a mistake

if (isset($_POST['delete'])) {
    $file_del = './' . $_GET["path"] . $_POST['delete'];
    // print_r($file_del);
    $file_del1 = str_replace("&nbsp;", " ", htmlspecialchars($file_del, null, 'utf-8'));
    if ($file_del1 != "." && $file_del1 != ".." && is_file($file_del1)) {
        unlink($file_del1);
    }
}

if (isset($_POST['download'])) {
    $file = './' . $_GET["path"] . $_POST['download'];                              // get File path
    $file_path = str_replace("&nbsp;", " ", htmlspecialchars($file, null, 'utf-8'));
    // process download
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file_path));
    flush();                                                                        // function requests the server to send its currently buffered output to the browser
    readfile($file_path);
    exit;
}

date_default_timezone_set("Europe/Vilnius");    // sets timezone
$cwd = getcwd();                                // gets the current working directory
$path = './' . $_GET["path"];                   // $_GET an associative array of variables passed to the current script via the URL query string( part that goes after ?path= )
$fsndirs = scandir($path);                      // returns an array of files and directories from the directory.

// print $cwd;          in this case it prints: C:\Ampps\www\Homework\SPRINT
// print_r($fsndirs);      prints an array: Array ( [0] => . [1] => .. [2] => .git [3] => css [4] => folder_test [5] => footer.php [6] => header.php [7] => index.php [8] => test1.txt )

if(!$_SESSION['valid'] == true){
    print('<div class="container form-signin"><div class="container">');
    print('<form class="form-signin" role="form" action=' . htmlspecialchars($_SERVER['PHP_SELF']) . '  method="post">');
    print('<h4 class="form-signin-heading">'. $msg .'</h4>');
    print('<input type="text" class="form-control" name="username" placeholder="username = tadas" required autofocus></br>');
    print('<input type="password" class="form-control" name="password" placeholder="password = 1234" required>');
    print('<button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Login</button></form>');
    print('</div>');
    die();
}

print('<h3>Directory contents: ' . $_SERVER['REQUEST_URI'] . '</h3>');          /// $_SERVER['REQUEST_URI'] prints Homework/SPRINT/index.php

print('<br/>');
print('<table><thead><th>Name</th><th>Type</th><th>Last Modified On</th><th>Actions</th></thead>');

foreach ($fsndirs as $fanddir) {
    if ($fanddir != "." && $fanddir != "..") {
        print('<tr><td>' . (is_dir($path . $fanddir)
            ? '<a href="' . (isset($_GET['path'])                                       // isset - determines if a variable is declared and is different than NULL, returns bool
                ? $_SERVER['REQUEST_URI'] . '/' . $fanddir . '/'                        //The URI which was given in order to access this page 'index.php'
                : $_SERVER['REQUEST_URI'] . '?path=' . $fanddir . '/') . '">' . $fanddir . '</a>'
            : $fanddir) . '</td>');
        print('<td>' . (is_dir($path . $fanddir) ? "Directory" : "File") . '</td>');
        print('<td>' . @date('F d, Y, H:i:s', filemtime($path . $fanddir)) . '</td>');
        print('<td class="last_td">' .
            (is_dir($path . $fanddir)
                ? ''                                                                    // str_replace: prints out "value=header.php>", removes spaces
                : '<form style="display: inline-block" action="" method="post">
                <input type="hidden" name="delete" value=' . str_replace(' ', '&nbsp;', $fanddir) . '>  
                <input type="submit" value="Delete">
               </form>
               <form style="display: inline-block" action="" method="post">
                <input type="hidden" name="download" value=' . str_replace(' ', '&nbsp;', $fanddir) . '>
                <input type="submit" value="Download">
               </form>')
            . "</form></td>");
        print('</tr>');
    }
}
print("</table>");
print('Click here to <a href = "index.php?action=logout"> logout.');


