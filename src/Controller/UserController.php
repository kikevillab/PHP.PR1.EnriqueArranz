<?php
namespace MiW16\Results\Controller;

use MiW16\Results\Entity\User;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;
/**
 * Created by PhpStorm.
 * User: Enrique
 * Date: 05/12/2016
 * Time: 17:46
 */
class UserController
{

    protected $routes;
    protected $urlGenerator;

    public function __construct($routes)
    {
        $this->routes = $routes;
        $this->urlGenerator = new UrlGenerator($this->routes, new RequestContext('/public'));
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

    public function addUserAction()
    {
        if(empty($_POST)){
            include(VIEW_DIR . '/add_user_form.phtml');
            exit;
        }

        /** @var User $user */
        $user = new User();
        $user->setUsername( $_POST['username']);
        $user->setEmail( $_POST['email']);
        $user->setPassword( $_POST['password']);

        $entityManager = getEntityManager();
        $entityManager->persist($user);
        $entityManager->flush();

        echo "Usuario ". $_POST['username'] ." creado correctamente";
        sleep(2);
        header("Location: ".$this->urlGenerator->generate('list_users'));
        exit;
    }

    public function removeUserAction($idUser)
    {

        $entityManager = getEntityManager();
        $userRepository = $entityManager->getRepository('MiW16\Results\Entity\User');
        $user = $userRepository->findOneById($idUser);

        if(!$user){
            echo "Usuario no encontrado";
            exit;
        }

        $entityManager->remove($user);
        $entityManager->flush();

        echo "Usuario borrado correctamente";
        sleep(2);
        header("Location: ".$this->urlGenerator->generate('list_users'));
        exit;

    }

    public function updateUserAction($idUser)
    {

        $entityManager = getEntityManager();
        $userRepository = $entityManager->getRepository('MiW16\Results\Entity\User');
        /**@var User $user */
        $user = $userRepository->findOneById($idUser);

        $user->setEmail( $_POST['email']);
        $user->setPassword( $_POST['password']);
        $user->setEnabled($_POST['enabled']);

        $entityManager->persist($user);
        $entityManager->flush();

        echo "Usuario actualizado correctamente";
        sleep(2);
        header("Location: ".$this->urlGenerator->generate('list_users'));
        exit;
    }
}