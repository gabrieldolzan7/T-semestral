<?php
function sanitizar($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function validarEntrada($entrada) {
    return is_numeric($entrada) && $entrada >= 0 && $entrada <= 10;
}
?>
