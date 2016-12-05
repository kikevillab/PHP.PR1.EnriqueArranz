<?php   // src/scripts/list_users.php

require_once __DIR__ . '/../../bootstrap.php';

$entityManager = getEntityManager();

$userRepository = $entityManager->getRepository('MiW16\Results\Entity\User');

if($argc == 1 || ($argc == 2 && in_array('--json', $argv))) {
    $users = $userRepository->findAll();

}elseif($argc >= 2){
    if(!intval($argv[1])){
        echo "El id_user debe ser un numero entero".PHP_EOL;
        exit;
    }

    $users = $userRepository->findBy(array('id' => $argv[1]));

}else{
    echo "$argv[0] [<id_user>] [--json]".PHP_EOL;
    exit;
}

if (in_array('--json', $argv)) {
    echo json_encode($users);
} else {
    $items = 0;
    echo PHP_EOL . sprintf("  %2d: %20s %30s %7s\n", 'Id', 'Username:', 'Email:', 'Enabled:');
    /** @var \MiW16\Results\Entity\User $user */
    foreach ($users as $user) {
        echo sprintf(
            '- %2d: %20s %30s %7s',
            $user->getId(),
            $user->getUsername(),
            $user->getEmail(),
            $user->isEnabled()
        ),
        PHP_EOL;
        $items++;
    }

    echo "\nTotal: $items users.\n\n";
}

