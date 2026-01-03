<?php
function compruebaEspacios($email): bool
{
    $emailSinEspacios=trim($email);

    $validar=false;

    if(strpos($emailSinEspacios," ") === false){

        $validar=true;
    }
    return $validar;
}

function compruebaDominio($email): bool
{
    $emailSinEspacios=trim($email);
    $posicion_arroba = strpos($emailSinEspacios, "@");
    $posicion_punto = strpos($emailSinEspacios, ".", $posicion_arroba);

    $validar=false;

    if ($posicion_arroba !== false && $posicion_punto !== false) {
        $validar = true;
    }

    return $validar;
}

function validarMailCompleto($email): bool
{
    $validar=false;

    if(compruebaEspacios($email) && compruebaDominio($email) ){
        $validar=true;
    }
    return $validar;
}

function validarNumDni($numDni): bool
{

    $arrayDNI = str_split($numDni);

    $validar=true;

    for ($i = 0; $i <= 7; $i++) {
        $compruebaNum = ord($arrayDNI[$i]);

        if ($compruebaNum < 48 || $compruebaNum > 57) {
            $validar = false;
            break;
        }
    }
    return $validar;
}


function validarLetraDNI($numDni): bool {

    $dni=strtoupper($numDni);
    $arrayDNI=str_split($dni);

    $ultimoCaracter=ord($arrayDNI[count($arrayDNI)-1]);

    $validar=true;

    if($ultimoCaracter< 65 || $ultimoCaracter > 90){
        $validar=false;
    }
    return $validar;
}


function validarLetraCorrecta($numDni): bool {

    $soloNumero=substr($numDni,0,8);

    $soloLetra=strtoupper(substr($numDni,-1));

    $letrasCorrectas="TRWAGMYFPDXBNJZSQVHLCKE";

    $arrayLetras=str_split($letrasCorrectas);

    $modulo=$soloNumero % 23;

    $letraModulo=$letrasCorrectas[$modulo];

    $validar=true;

    if ($soloLetra != $letraModulo) {
        $validar=false;
    }

    return $validar;

}

function validarDNIcompleto($numDni): bool
{

    if (strlen($numDni) !== 9) return false;

    $validar=false;

    if(validarLetraDNI($numDni) && validarNumDni($numDni) && validarLetraCorrecta($numDni)){
        $validar=true;
    }
    return $validar;
}