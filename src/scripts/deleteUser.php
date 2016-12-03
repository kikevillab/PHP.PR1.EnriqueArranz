<?php

require_once __DIR__ . '/../../bootstrap.php';

if($argc != 2){
    echo "$argv[0] <id_user>". PHP_EOL;
    exit;
}

if(!intval($argv[1])){
    echo "El id_user debe ser un numero entero" . PHP_EOL;
    exit;
}

$em = getEntityManager();
$user = $em
    ->getRepository('\MiW16\Results\Entity\User')
    ->findOneById($argv[1]);

if(!$user){
    echo 'Usuario no encontrado' . PHP_EOL;
    exit;
}

$em->remove($user);
$em->flush();

echo 'Usuario eliminado correctamente' . PHP_EOL;