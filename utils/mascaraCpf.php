<?php

function formatCpf($value) {
    $cnpj_cpf = preg_replace("/\D/", '', $value);
    return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
}
function desformatCpf($value){
    return  preg_replace('/[^0-9]/is','', $value);
}