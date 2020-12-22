<?php
require('header.php');
require('footer.php');

date_default_timezone_set("Europe/Vilnius");
$cwd = getcwd();
$fsndirs = scandir($cwd);

print('<h3>Directory contents: ' . $_SERVER['REQUEST_URI'] . '</h3>');

print('<br/>');
print('<table><thead><th>Name</th><th>Type</th><th>Last Modified On</th><th>Actions</th></thead>');

foreach ($fsndirs as $fanddir) {
    if ($fanddir != "." && $fanddir != "..") {
        print('<tr><td>' . $fanddir . '<br>' . '</td>');
        print('<td>' . filetype($fanddir) . '</td>');
        print('<td>' . @date('F d, Y, H:i:s', filemtime($fanddir)) . '</td>');
        print('<td class="last_td">');
        filetype($fanddir) != 'file' ? ' ' :
            print('<input type="button" value="Download">&nbsp &nbsp<input type="button" value="Delete">');
        print('</td>');
    }
}

print("</table>");


