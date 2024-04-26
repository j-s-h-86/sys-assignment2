<?php
function oneOf($sortCol, $arrayOfValid, $default)
{
    if ($sortCol === null) {
        return $default;
    }

    foreach ($arrayOfValid as $a) {
        if (strcasecmp($a, $sortCol) == 0) {
            return $a;
        }
    }
    return $default;
}
?>