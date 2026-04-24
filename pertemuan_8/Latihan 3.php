<?php
function repeat($text, $num = 10)
{
    echo "<ol>\n";
    for ($i = 0; $i < $num; $i++)
    {
        echo "<li>$text</li>\n";
    }
    echo "</ol>";
}

// pemanggilan function
repeat("I'm the best", 15);
repeat("You're the man");
?>