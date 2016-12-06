<?php
/**
 * Created by PhpStorm.
 * User: Enrique
 * Date: 06/12/2016
 * Time: 13:17
 */

namespace MiW16\Results\Controller;


use MiW16\Results\Entity\Result;

class ResultController extends AbstractController
{
    public function showAllAction()
    {

        $entityManager = getEntityManager();
        $resultRepository = $entityManager->getRepository('MiW16\Results\Entity\Result');
        $results = $resultRepository->findAll();

        include(VIEW_DIR . '/result/list_results.phtml');
    }

    public function showOneAction($idResult)
    {

        $entityManager = getEntityManager();
        $resultRepository = $entityManager->getRepository('MiW16\Results\Entity\Result');
        $result = $resultRepository->findOneById($idResult);

        include(VIEW_DIR . '/result/list_one.phtml');
    }

    public function addResultAction()
    {
        $entityManager = getEntityManager();
        $userRepository = $entityManager->getRepository('MiW16\Results\Entity\User');

        if(empty($_POST)){
            $users = $userRepository->findAll();
            include(VIEW_DIR . '/result/add_form.phtml');
            exit;
        }


        $date = isset($_POST['time']) && !empty($_POST['time']) ? \DateTime::createFromFormat('Y-m-d', $_POST['time']) : new \DateTime();
        $user = $userRepository->findOneById($_POST['user']);
        if(!$user){
            echo "No se ha encontrado el usuario".PHP_EOL;
            exit;
        }


        $result = new Result($_POST['result'], $user, $date);

        $entityManager->persist($result);
        $entityManager->flush();

        echo "Resultado creado correctamente";
        sleep(2);
        $this->toRoute('list_results');
    }

    public function removeResultAction($idResult)
    {

        $entityManager = getEntityManager();
        $resultRepository = $entityManager->getRepository('MiW16\Results\Entity\Result');
        $result = $resultRepository->findOneById($idResult);

        if(!$result){
            echo "Resultado no encontrado";
            exit;
        }

        $entityManager->remove($result);
        $entityManager->flush();

        echo "Resultado borrado correctamente";
        sleep(2);
        $this->toRoute('list_results');

    }

    public function updateResultAction($idResult)
    {

        $entityManager = getEntityManager();
        $resultRepository = $entityManager->getRepository('MiW16\Results\Entity\Result');
        /**@var Result $result */
        $result = $resultRepository->findOneById($idResult);

        $result->setResult($_POST['result']);

        $entityManager->persist($result);
        $entityManager->flush();

        echo "Resultado actualizado correctamente";
        sleep(2);
        $this->toRoute('list_results');
    }
}