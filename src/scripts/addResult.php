<?php //src/scripts/addResult.php
require_once __DIR__ . '/../../bootstrap.php';

use \MiW16\Results\Entity\User;
use \MiW16\Results\Entity\Result;

if($argc < 3){
    echo "$argv[0] <result> <id_user> [<time> <formatTime>]". PHP_EOL;
    exit;
}

$em = getEntityManager();

/** @var User $user */
$user = $em
    ->getRepository('\MiW16\Results\Entity\User')
    ->findOneById($argv[2]);

if(!$user){
    echo "No se ha encontrado el usuario".PHP_EOL;
    exit;
}

if(isset($argv[4])){
    if(!isset($argv[5])){
        echo "Debe indicar el formato de tiempo introducido";
        exit;
    }

    $date = DateTime::createFromFormat($argv[5], $argv[4]);
}else{
    $date = new DateTime();
}

$result = new Result($argv[1], $user, $date);
$em->persist($result);
$em->flush();

echo "Resultado creado correctamente";
