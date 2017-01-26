<?php
/**
 * Created by PhpStorm.
 * User: adiba
 * Date: 26-Jan-17
 * Time: 08:16
 */

namespace AppBundle\Security;


use AppBundle\Form\LoginFormType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var RouterInterface
     */
    private $router;


    /**
     * LoginFormAuthenticator constructor.
     * @param FormFactoryInterface $formFactory
     * @param EntityManager $entityManager
     * @param RouterInterface $router
     */
    public function __construct(FormFactoryInterface $formFactory, EntityManager $entityManager, RouterInterface $router)
    {
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->router = $router;
    }

    public function getCredentials(Request $request)
    {
        $isLoginSubmit = $request->getPathInfo() == '/login' && $request->isMethod(Request::METHOD_POST);
        if(!$isLoginSubmit){
            return null;
        }

        $form = $this->formFactory->create(LoginFormType::class);
        $form->handleRequest($request);

        $data = $form->getData();

        return $data;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $userName = $credentials['_username'];

        $user = $this->entityManager->getRepository('AppBundle:User')->findOneBy(['email' => $userName]);

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $password = $credentials['_password'];

        return $password === 'Gigel';
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('security_login');
    }

    protected function getDefaultSuccessRedirectUrl()
    {
        return $this->router->generate('homepage');
    }


}