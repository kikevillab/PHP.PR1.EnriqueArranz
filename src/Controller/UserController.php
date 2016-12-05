<?php
namespace MiW16\Results\Controller;
/**
 * Created by PhpStorm.
 * User: Enrique
 * Date: 05/12/2016
 * Time: 17:46
 */
class UserController
{

    protected $routes;

    public function __construct($routes)
    {
        $this->routes = $routes;
    }

    public function showAllAction()
    {

        $entityManager = getEntityManager();
        $userRepository = $entityManager->getRepository('MiW16\Results\Entity\User');
        $users = $userRepository->findAll();

        include(VIEW_DIR . '/list_users.phtml');
    }

    public function showOneAction($idUser)
    {

        $entityManager = getEntityManager();
        $userRepository = $entityManager->getRepository('MiW16\Results\Entity\User');
        $user = $userRepository->findOneById($idUser);

        include(VIEW_DIR . '/list_one_user.phtml');
    }

    public function removeUserAction($idUser)
    {

        $entityManager = getEntityManager();
        $userRepository = $entityManager->getRepository('MiW16\Results\Entity\User');
        $user = $userRepository->findOneById($idUser);

        include(VIEW_DIR . '/list_one_user.phtml');
    }
}