<?php
for($i = 1; $i < 11; $i++) {
    if ($i % 2 == 0) {
        continue; // Jika genap, lompat ke iterasi berikutnya 
    } else {
        echo $i; // Hanya mencetak angka ganjil 
    }
}
?>