<?php //src/scripts/addUser.php
require_once __DIR__ . '/../../bootstrap.php';

use \MiW16\Results\Entity\User;

if($argc < 4){
    echo "$argv[0] <username> <email> <password> [<enabled>]". PHP_EOL;
    exit;
}

/** @var User $user */
$user = new User();
$user->setUsername($argv[1]);
$user->setEmail($argv[2]);
$user->setPassword($argv[3]);
if(isset($argv[4]))
    $user->setEnabled($argv[4]);


$em = getEntityManager();
$em->persist($user);
$em->flush();

echo "Usuario $argv[1] creado correctamente";
