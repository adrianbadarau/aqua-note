<?php

namespace AppBundle\Controller;

use AppBundle\Form\LoginFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecurityController extends Controller
{

    /**
     * @Route("/login", name="security_login")
     **/
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $form = $this->createForm(LoginFormType::class, [
            '_username' => $lastUsername
        ]);
        return $this->render('AppBundle:security:login.html.twig', array(
            'error' => $error,
            'loginForm' => $form->createView()
        ));
    }
}
