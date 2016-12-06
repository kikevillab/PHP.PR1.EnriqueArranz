<?php

require_once __DIR__ . '/../../bootstrap.php';

use \MiW16\Results\Entity\User;

if($argc != 2){
    echo "$argv[0] <id_user>". PHP_EOL;
    exit;
}

if(!intval($argv[1])){
    echo "El id_user debe ser un numero entero" . PHP_EOL;
    exit;
}

$em = getEntityManager();
/** @var User $user */
$user = $em
    ->getRepository('\MiW16\Results\Entity\User')
    ->findOneById($argv[1]);

if(!$user){
    echo 'Usuario no encontrado' . PHP_EOL;
    exit;
}
$option = '';
while($option != 'exit') {
    echo "Indica el atributo que deseas modificar :" . PHP_EOL
        . "   [0] Username " . PHP_EOL
        . "   [1] Email " . PHP_EOL
        . "   [2] Password " . PHP_EOL
        . "   [3] Enabled " . PHP_EOL
        . "Para guardar el usuario (s/save)". PHP_EOL
        . "Si no deseas modificar nada (e/exit)". PHP_EOL;

    $option = trim(fgets(STDIN));
    switch($option){
        case '0':
            echo "Introduzca nuevo username: ";
            $user->setUsername(trim(fgets(STDIN)));
            break;
        case '1':
            echo "Introduzca nuevo email: ";
            $user->setEmail(trim(fgets(STDIN)));
            break;
        case '2':
            echo "Introduzca la nueva contraseña: ";
            $pass1 = trim(fgets(STDIN));
            echo "Introduzca de nuevo la contraseña: ";
            $pass2 = trim(fgets(STDIN));
            if($pass1 === $pass2){
                $user->setPassword($pass1);
            }else{
                echo "Las contraseñas introducidas no coinciden";
            }
            break;
        case '3':
            echo "Introduzca true o false para establecer si el usuario esta activo: ";
            $user->setEnabled(trim(fgets(STDIN)));
            break;
        case 's':
        case 'save':
            echo $user . PHP_EOL;
            echo "Desea aplicar estos cambios?(y/n):";

            if(trim(fgets(STDIN)) == 'y') {
                $em->persist($user);
                $em->flush();
                echo 'Usuario actualizado correctamente' . PHP_EOL;
            }
            exit;
        case 'e':
        case 'exit':
            exit;
        default:
            echo "Opcion introducida incorrecta.";

    }
}

