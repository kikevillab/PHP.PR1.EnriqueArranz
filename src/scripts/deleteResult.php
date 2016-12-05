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
$result = $em
    ->getRepository('\MiW16\Results\Entity\Result')
    ->findOneById($argv[1]);

if(!$result){
    echo 'Resultado no encontrado' . PHP_EOL;
    exit;
}

$em->remove($result);
$em->flush();

echo 'Resultado eliminado correctamente' . PHP_EOL;