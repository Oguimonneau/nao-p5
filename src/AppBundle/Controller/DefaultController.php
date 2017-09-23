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
        $nom = $email = $sujet = $message =  NULL;
        $contact_error_firstnamemin = NULL;
        $form = $this->createFormBuilder()
 
            ->add('nom', TextType::class, array('constraints' => array(new NotBlank(array(//'message' => 'contact.error.nom'
            ))
            ,new Length(array('min' => 3,
                    'max' => 30,

            )))))        
            ->add('email', TextType::class,  array('constraints' => array(new Assert\Email(array('checkMX' => true)),
                new NotBlank(),)))
            ->add('sujet', ChoiceType::class, array('choices' => array('' => '','Demande' => "Demande",'Bug' => "Bug",'Autre' => "Autre" )),
                array('constraints' => array(new Length(array('min' => 3)))))
            ->add('message', TextareaType::class, array('constraints' => array(new NotBlank(array(//'message' => 'contact.error.messagenotblank'
            ))
            ,new Length(array('min' => 3,
                    'max' => 350,

                )))))
            ->add('send', SubmitType::class, array('label' => 'Envoyer', 'attr' => array('class' => 'btn-send')))
            ->add('reset', ResetType::class , array('label' => 'Annuler'))
            ->getForm();


        $form->handleRequest($request);
        if ( $form->isValid() ){
            if ( $request->isMethod('POST') ){
                $request = Request::createFromGlobals();
                $nom = $form["nom"]->getData();
                $email = $form["email"]->getData();
                $sujet = $form["sujet"]->getData();
                $message = $form["message"]->getData();
                $message = (new \Swift_Message('Contact NAO'))
                    ->setFrom(array($email))
                    ->setTo('contact-nao@gmail.com')
                    ->setCharset('utf-8')
                    ->setContentType('text/html')
                    ->setBody($this->container->get('templating')->render('SwiftMailer/email.html.twig', array(
                        'nom'       => $nom,
                        'email'     => $email,
                        'sujet'    => $sujet,
                        'message'   => $message)));
                $this->get('mailer')->send($message);
                $this->addFlash('success','Ok');
                $this->addFlash('sent','Ok');
            } else{$this->addFlash('error','Cant be reached like this');}
        } else if (($form->isValid() === FALSE ) && ($request->isMethod('POST'))) {
            $this->addFlash('error','Cant be reached like this');
            $this->addFlash('pas envoyer','Non OK');}





        return $this->render('default/contact.html.twig', array('form'    => $form->createView(),
            'mom'       => $nom,
            'email'     => $email,
            'sujet'     => $sujet,
            'message'   => $message));


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

