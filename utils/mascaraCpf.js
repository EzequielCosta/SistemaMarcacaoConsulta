function mascara(id)
{
    value = document.getElementById(id).value;
    const cnpjCpf = value.replace(/\D/g, '');
    document.getElementById(id).value = cnpjCpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/g, "\$1.\$2.\$3-\$4");


}
function desmascara(value) {
    return replace('/[^0-9]/is', '', value);
}