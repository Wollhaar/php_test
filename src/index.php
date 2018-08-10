<?php

// the for loop for output hello and world
for($i = 0; $i = 100; $i++) {
    if (!is_float($i / 3)) {
        echo 'Hello';
    }
    elseif (!is_float($i / 5)) {
        echo 'World';
    }
    else {
        echo $i;
    }
}