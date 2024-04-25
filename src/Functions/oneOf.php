<?php function oneOf($sortCol, $arrayOfValid, $default)
{
    foreach ($arrayOfValid as $a) {
        if (strcasecmp($a, $sortCol) == 0) {
            return $a;
        }
    }
    return $default;
}

?>