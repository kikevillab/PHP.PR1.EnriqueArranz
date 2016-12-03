<?php

require_once __DIR__ . '/../../bootstrap.php';

use \MiW16\Results\Entity\User;

if($argc < 2){
    echo "$argv[0] <id_user> <email>". PHP_EOL;
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

$user->setEmail($argv[2]);

$em->persist($user);
$em->flush();

echo 'Usuario actualizado correctamente' . PHP_EOL;