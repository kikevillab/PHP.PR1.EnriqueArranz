<?php   // src/scripts/listResults.php

require_once __DIR__ . '/../../bootstrap.php';

use \MiW16\Results\Entity\Result;

$entityManager = getEntityManager();

$resultRepository = $entityManager->getRepository('MiW16\Results\Entity\Result');

if($argc == 1 || ($argc == 2 && in_array('--json', $argv))) {
    $results = $resultRepository->findAll();

}elseif($argc >= 2){
    if(!intval($argv[1])){
        echo "El id_result debe ser un numero entero".PHP_EOL;
        exit;
    }

    $results = $resultRepository->findBy(array('id' => $argv[1]));

}else{
    echo "$argv[0] [<id_result>] [--json]".PHP_EOL;
    exit;
}

if (in_array('--json', $argv)) {
    echo json_encode($results, JSON_PRETTY_PRINT);
} else {
    $items = 0;
    echo PHP_EOL . sprintf("  %2d: %20s %30s %7s\n", 'Id', 'Result:', 'Time:', 'User:');
    /** @var Result $result */
    foreach ($results as $result) {
        echo sprintf(
            '- %2d: %20s %30s %7s',
            $result->getId(),
            $result->getResult(),
            $result->getTime()->format('d-m-Y H:m:i'),
            $result->getUser()
        ),
        PHP_EOL;
        $items++;
    }

    echo "\nTotal: $items results.\n\n";
}