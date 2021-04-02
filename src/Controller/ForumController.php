<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\VarDumper\VarDumper;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Topic;
use App\Repository\TopicRepository;

use App\Entity\Message;
use App\Repository\MessageRepository;

use App\Form\NewTopicType;
use App\Form\NewMessageType;

use App\Service\UserFunctions;

class ForumController extends AbstractController
{
    /**
     * @Route("/forum", name="forum")
     */
    public function index(TopicRepository $topicRepository,Topic $topic, MessageRepository $messageRepository)
    {
//        $topics = $topicRepository->getTopicsData();
$topics=$topicRepository->findAll();
         $lastMessage = $messageRepository->getLastMessage($topic->getId());

//        foreach ($topics as $key => $value) {
//            $countMessage = $messageRepository->getCountMessage($topics[$key]['id']);
//            $topics[$key]['countMessage'] = $countMessage;
//            $lastMessage = $messageRepository->getLastMessage($topics[$key]['id']);
//            $topics[$key]['lastMessage'] = $lastMessage;
//d
//        }

        return $this->render('forum/index.html.twig', [
            'topics' => $topics,

        ]);
    }

 

    /**
     * @Route("/forum/newTopic", name="newTopic", methods={"GET","POST"})
     */
    public function newTopic(UserInterface $user,Request $request, EntityManagerInterface $manager,UserRepository $userRepository)
{
//        $form = $this->createForm(AssociationType::class,$association);

//        $form = $this->createForm(NewTopicType::class, ['role' => $this->getUser()->getRoles()  ]);
        $form = $this->createForm(NewTopicType::class );
//$User=$userRepository->findOneBy($this->getUser()->getId());
//dd($User);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $topic = new Topic();
            $topic->setName($form->get('name')->getData());
//$id=$user->getId();
//dd($id);
//dd($user);
//            $topic->setAuthor($this->getUser()->getId());
            $topic->setAuthor($user);

            $topic->setCreationDate(date_create(date('Y-m-d')));
            

            $manager->persist($topic);
            $manager->flush();

            $message = new Message();
//           $message->setIdTopic($topic->getId());
            $message->setIdTopic($topic);

            $message->setIdUser($user);
            $message->setPublicationDate(date_create(date('Y-m-d H:i:s')));
            $message->setContent($form->get('content')->getData());
         

            $manager->persist($message);
            $manager->flush();

            return $this->redirectToRoute('topic', ['id' => $topic->getId()]);
        }

        return $this->render('forum/newTopic.html.twig', [
            'form'  =>  $form->createView()
        ]);
    }

    /**
     * @Route("/forum/topic/{id}", name="topiccc")
     */
    public function topic($id,Topic $topic = null,UserInterface $user,TopicRepository $topicRepository, MessageRepository $messageRepository, Request $request, EntityManagerInterface $manager)
    {          $messages = $messageRepository->getMessages($topic->getId());

//        if (empty($topic)) {
//            return $this->render('exceptions/404.html.twig', [
//                'reason' => 'topic'
//            ]);
//        }
//        else {
//            $messages = $messageRepository->getMessages($topic->getId());
//            foreach ($messages as $key => $value) {
//                $messages[$key]['roles'] = $functions->roleStr(end($messages[$key]['roles']));
//            }

            $form = $this->createForm(NewMessageType::class);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                if ($form->get('Publier')->isClicked()){
                $message = new Message();
                $message->setIdTopic($topic);

                $message->setIdUser($user);
                $message->setPublicationDate(date_create(date('Y-m-d H:i:s')));
                $message->setContent($form->get('content')->getData());
              

                $manager->persist($message);
                $manager->flush();
            //actualiser
                return $this->redirectToRoute('topic', ['id' => $topic->getId()]);

                }
               
            }

            
            return $this->render('forum/index.html.twig', [
                'topics' => $topic,
                'messages' => $messages,
                'form'  =>  $form->createView()
            ]);
        }


    /**
     * @Route("/forum/editMessage/{id}", name="editMessage")
     */
    public function editMessage(Message $message, MessageRepository $messageRepository , Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(NewMessageType::class,$message);
        $form->handleRequest($request);
        $topic = $messageRepository->getTopicData($message->getIdTopic());

        if($form->isSubmitted() && $form->isValid()){
            $message->setContent($form->get('content')->getData());
          
            $manager->persist($message);
            $manager->flush();

            return $this->redirectToRoute('topic', ['id' => $message->getIdTopic()]);
        }

        return $this->render('forum/editMessage.html.twig', [
            'topic' => $topic,
            'message' => $message,
            'form'  =>  $form->createView()
        ]);
    }


/**
     * @Route("/suppforum/{id}", name="suppforum")
     */
    public function supprofil($id,Topic $topic, Request $request,TopicRepository $topicRepository , EntityManagerInterface $manager, UserFunctions $userFunctions)
    {
        if( $this->isGranted('ROLE_ADMIN')){
            
            $x = $topicRepository->find($id);
            $manager->remove($x);
           $manager->flush();

            return $this->render('home/index.html.twig', [
        
                ]);
            }


            else{
                return $this->render('home/index.html.twig', [
            
                    ]);
                
            }
        }
      


/////////////////////////////////////////////////////Mouna USer////////////


    /**
     * @Route("/forums", name="forums")
     */
    public function indexM(UserInterface $user,Topic $topic = null,TopicRepository $topicRepository,MessageRepository $messageRepository)
    {

//$topics=$topicRepository->find($user);
$topics=$topicRepository->findAll();


        return $this->render('forum/all.html.twig',['topics'=>$topics]);
    }
    /**
     * @Route("/forums/topics/{id}", name="topic")
     */
    public function topics($id,Topic $topic = null,UserInterface $user,TopicRepository $topicRepository, MessageRepository $messageRepository, Request $request, EntityManagerInterface $manager)
    {
        $messages=$messageRepository->findAll();
//        $messages = $messageRepository->getMessages($topic->getId());
//$messages=$messageRepository->findAll();
//$messages=$messageRepository->find($topic->getId())

        $form = $this->createForm(NewMessageType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if ($form->get('Publier')->isClicked()){
                $message = new Message();
                $message->setIdTopic($topic);

                $message->setIdUser($user);
                $message->setPublicationDate(date_create(date('Y-m-d H:i:s')));
                $message->setContent($form->get('content')->getData());


                $manager->persist($message);
                $manager->flush();
                //actualiser
                return $this->redirectToRoute('topic', ['id' => $topic->getId()]);

            }

        }


        return $this->render('messages.html.twig', [
            'topic' => $topic,
            'messages' => $messages,
            'form'  =>  $form->createView()
        ]);
    }
//////////////////////////////Consultant//////////////////////
    /**
     * @Route("/forumsAll", name="forumsall")
     */
    public function indexFALL(TopicRepository $topicRepository)
    {

//$topics=$topicRepository->find($user);
        $topics=$topicRepository->findAll();


        return $this->render('consultant/chats.html.twig',['topics'=>$topics]);
    }


//    /**
//     * @Route("/f", name="f")
//     */
//    public function indexF(TopicRepository $topicRepository)
//    {
//
////$topics=$topicRepository->find($user);
//        $topics=$topicRepository->findAll();
//
//
//        return $this->render('consultant/chats.html.twig',['topics'=>$topics]);
//    }

}
