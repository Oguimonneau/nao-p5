<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Regex;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class DefaultController extends Controller
{
    const NB_PER_PAGE = 3;

    /**
     * @Route("/", name ="NAO_home")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Observation');

        $validatedList = $repository->findObservations(1, self::NB_PER_PAGE, 1);

        return $this->render('default/index.html.twig', array(
            'validatedList' => $validatedList
        ));
    }


    /**
     * @Route("/contact", name ="NAO_contact")
     * @Method({"GET","POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */




    public function contactAction(Request $request)
    {
        $firstname = $lastname = $email = $object = $message =  NULL;
        $contact_error_firstnamemin = NULL;
        $form = $this->createFormBuilder()
            ->add('firstname', TextType::class, array('constraints' => array(new NotBlank(array(//'message' => 'contact.error.firstname'
            ))
            ,new Length(array('min' => 3,
                    'max' => 10,

                )))))
            ->add('lastname', TextType::class, array('constraints' => array(new NotBlank(array(//'message' => 'contact.error.lastname'
            ))
            ,new Length(array('min' => 3,
                    'max' => 10,

                )))))
            ->add('email', TextType::class,  array('constraints' => array(new Assert\Email(array('checkMX' => true)),
                new NotBlank(),)))
//
            ->add('object', ChoiceType::class, array('choices' => array('' => '','Autre' => "Autre",'Bug' => "Bug", 'Demande' => "Demande")),
                array('constraints' => array(new Length(array('min' => 3)))))
            ->add('message', TextareaType::class, array('constraints' => array(new NotBlank(array(//'message' => 'contact.error.messagenotblank'
            ))
            ,new Length(array('min' => 3,
                    'max' => 350,

                )))))
            ->add('send', SubmitType::class , array('label' => 'Envoyer'))
            ->add('reset', ResetType::class , array('label' => 'Annuler'))
            ->getForm();


        $form->handleRequest($request);
        if ( $form->isValid() ){
            if ( $request->isMethod('POST') ){
                $request = Request::createFromGlobals();
                $firstname = $form["firstname"]->getData();
                $lastname = $form["lastname"]->getData();
                $email = $form["email"]->getData();
                $object = $form["object"]->getData();
                $message = $form["message"]->getData();
                $message = (new \Swift_Message('My important subject here'))
                    ->setFrom(array($email))
                    ->setTo('contact@kahilom.com')
                    ->setCharset('utf-8')
                    ->setContentType('text/html')
                    ->setBody($this->container->get('templating')->render('SwiftMailer/email.html.twig', array('firstname' => $firstname,
                        'lastname'  => $lastname,
                        'email'     => $email,
                        'object'    => $object,
                        'message'   => $message)));
                $this->get('mailer')->send($message);
                $this->addFlash('success','Ok');
                $this->addFlash('sent','Ok');
            } else{$this->addFlash('error','Cant be reached like this');}
        } else if (($form->isValid() === FALSE ) && ($request->isMethod('POST'))) {
            $this->addFlash('error','Cant be reached like this');
            $this->addFlash('pas envoyer','Non OK');}





        return $this->render('Default/contact.html.twig', array('form'    => $form->createView(),
            'firstname'  => $firstname,
            'lastname'   => $lastname,
            'email'      => $email,
            'object'     => $object,
            'message'    => $message));


    }


    /**
     * @Route("/about", name ="NAO_about")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */


    public function aboutAction(Request $request)
    {

        return $this->render('default/about.html.twig');
    }


    public function backAction(Request $request)
    {
        return $this->render('default/back.html.twig');
    }

    public function mentionsAction(Request $request)
    {
        return $this->render('default/mentions.html.twig');
    }

    public function conditionsAction(Request $request)
    {
        return $this->render('default/conditions.html.twig');
    }
    

}

