<?php

require_once __DIR__ . '/../../bootstrap.php';

if($argc != 3){
    echo "$argv[0] <id_result> <result>". PHP_EOL;
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
$result->setResult($argv[2]);
$em->persist($result);
$em->flush();

echo 'Resultado actualizado correctamente' . PHP_EOL;