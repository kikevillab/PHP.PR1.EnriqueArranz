<?php

require_once __DIR__ . '/../../bootstrap.php';

if($argc != 2){
    echo "$argv[0] <id_result>". PHP_EOL;
    exit;
}

if(!intval($argv[1])){
    echo "El id_result debe ser un numero entero" . PHP_EOL;
    exit;
}

$em = getEntityManager();
/** @var \MiW16\Results\Entity\Result $result */
$result = $em
    ->getRepository('\MiW16\Results\Entity\Result')
    ->findOneById($argv[1]);

if(!$result){
    echo 'Resultado no encontrado' . PHP_EOL;
    exit;
}
$option = '';
while($option != 'exit') {
    echo "Indica el atributo que deseas modificar :" . PHP_EOL
        . "   [0] Result " . PHP_EOL
        . "   [1] Time " . PHP_EOL
        . "   [2] User " . PHP_EOL
        . "Para guardar el resultado (s/save)". PHP_EOL
        . "Si no deseas modificar nada (e/exit)". PHP_EOL;

    $option = trim(fgets(STDIN));
    switch($option){
        case '0':
            echo "Introduzca nuevo result: ";
            $result->setResult(trim(fgets(STDIN)));
            break;
        case '1':
            echo "Introduzca la nueva fecha: ";
            $fecha = trim(fgets(STDIN));
            echo 'Introduzca el formato de la fecha, (defecto: d-m-Y): ';
            $formato = !empty(trim(fgets(STDIN))) ? trim(fgets(STDIN)) : 'd-m-Y';
            $result->setTime(DateTime::createFromFormat($formato, $fecha));
            break;
        case '2':
            echo 'Seleccione el usuario al que pertenece el resultado: '.PHP_EOL;
            $users = $em->getRepository('\MiW16\Results\Entity\User')->findAll();
            foreach($users as $i => $user){
                echo "[".$i."] " .$user->getUsername() .PHP_EOL;
            }

            $result->setUser($users[trim(fgets(STDIN))]);
            break;

        case 's':
        case 'save':
            echo $result . PHP_EOL;
            echo 'Desea aplicar estos cambios?(y/n):';

            if(trim(fgets(STDIN)) == 'y') {
                $em->persist($result);
                $em->flush();
                echo 'Resultado actualizado correctamente' . PHP_EOL;
            }
            exit;
        case 'e':
        case 'exit':
            exit;
        default:
            echo 'Opcion introducida incorrecta.';

    }
}

