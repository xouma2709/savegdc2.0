<?php

namespace App\Controller;
use APP\Controller\ComptesController;
use APP\Controller\SearchBarController;
use App\Entity\Agents;
use App\Entity\Comptes;
use App\Entity\Contrats;
use App\Entity\Softs;
use App\Entity\TypesContrat;
use App\Form\AddAgentType;
use App\Form\EditAgentType;
use App\Form\AddCompteType;
use App\Form\AddCompteAgentType;
use App\Form\EditCompteAgentType;
use App\Form\AddContratType;
use App\Form\EditContratType;
use App\Repository\AgentsRepository;
use App\Repository\ComptesRepository;
use App\Repository\ContratsRepository;
use App\Repository\SoftsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Security\Core\User\UserInterface;


class AgentsController extends AbstractController
{


    /**
     * @Route("/agents", name="agents")
     */
    public function index(AgentsRepository $repo): Response
    {
        $agents = $repo->findBy([],['Nom' => 'ASC', 'Prenom' => 'ASC']);
        return $this->render('agents/index.html.twig', ['Agents' => $agents]);

    }

    /**
     * @Route("/agents/result", name="agents_result")
     */
    public function agentsResult(AgentsRepository $repo): Response
    {
        $agents = avancedSearch();
        return $this->render('agents/index.html.twig', ['Agents' => $agents]);

    }
    /**
     * @Route("/agents/lastcreate", name="lastcreate")
     */
    public function showDix(AgentsRepository $repo): Response
    {

        $agents = $repo->findBy([],['id' => 'DESC'],20,[]);
        return $this->render('agents/index.html.twig', ['Agents' => $agents]);


    }

    /**
     * @Route("/agents/datepassees", name="adez")
     */
    public function adez(AgentsRepository $repo, ContratsRepository $repocontrat, ComptesRepository $repocomptes): Response
    {

        $agents = $repo->findAll();

        return $this->render('agents/adez.html.twig', ['Agents' => $agents]);


    }



    /**
     * @Route("/agents/addAgent", name="addAgent")
     */
    public function addAgent(Request $request, EntityManagerInterface $em, AgentsRepository $repo, ComptesRepository $repocomptes, ContratsRepository $repocontrat): Response
    {

        $agent= new Agents();
        $form = $this->createForm(AddAgentType::class, $agent);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {


        $em ->persist($agent);
        $em->flush();

        $lastcreatedagent = $agent->getId();
        $agents = $repo->find($lastcreatedagent);
        $comptes = $repocomptes-> findBy(['agents' => $lastcreatedagent]);
        $contrats = $repocontrat->findBy(['agents' => $lastcreatedagent]);


        return $this->render('/agents/detail.html.twig', ['Agents' => $agent, 'Comptes' => $comptes, 'Contrats' => $contrats]);
    }

        return $this->render('/agents/addAgent.html.twig', [
            'form' => $form->createView()
            ]);

    }

    /**
     * @Route("/agents/{id}", name="agent")
     */
    public function Agent($id, AgentsRepository $repo, ComptesRepository $repocomptes, ContratsRepository $repocontrat): Response
    {
        $agents = $repo->find($id);
        $comptes = $repocomptes-> findBy(['agents' => $id], ['actif' => 'DESC']);
        $contrats = $repocontrat->findBy(['agents' => $id], ['dernierContrat' => 'DESC' , 'DateFin' => 'DESC']);
        return $this->render('agents/detail.html.twig', ['Agents' => $agents, 'Comptes' => $comptes, 'Contrats' => $contrats]);
    }

    /**
     * @Route("/agents/{id}/voircomptes", name="comptesparagent")
     */
    public function voirComptes($id, ComptesRepository $repo, AgentsRepository $repodeux): Response
    {
        $comptes = $repo->findBy(['agents' => $id]);
        $agent = $repodeux->find($id);
        return $this->render('agents/comptes.html.twig', ['Comptes' =>$comptes, 'Agents' => $agent ]);
    }

    /**
     * @Route("/agents/{id}/addcompteagent", name="addcompteagent")
     */
    public function addCompteAgent($id, Request $request, EntityManagerInterface $em,  AgentsRepository $repodeux, ComptesRepository $repocomptes, ContratsRepository $repocontrat, UserInterface $user): Response
    {
        $agent = $repodeux->find($id);
        $compte = new Comptes();
        $form = $this->createForm(AddCompteAgentType::class, $compte);
        $today = date('Y-m-d');
        $createur = $user->getNom().' '.$user->getPrenom();
        function passgen2($nbChar){
            return substr(str_shuffle('abcdefghijkmnopqrstuvwxyzABCEFGHIJKLMNPQRSTUVWXYZ123456789'),1, $nbChar);
            }



        $pwd = passgen2(16);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
        $compte ->setDateCreation(\DateTime::createFromFormat ('Y-m-d', $today));
        $compte ->setDateModif(\DateTime::createFromFormat ('Y-m-d', $today));
        $compte->setPwd($pwd);
        $compte->setAgents($agent);
        $compte->setCreateur($createur);
        $em ->persist($compte);
        $em->flush();
        $comptes = $repocomptes-> findBy(['agents' => $id]);
        $contrats = $repocontrat->findBy(['agents' => $id]);

        //return $this->render('agents/detail.html.twig', ['Agents' => $agent, 'Comptes' => $comptes, 'Contrats' => $contrats]);
        return $this->redirectToRoute('agent', ['id' => $id]);

        }

        return $this->render('agents/addCompte.html.twig', [
            'Agents' => $agent,
            'form' => $form->createView()

            ]);

    }

    /**
     * @Route("/agents/{id}/editcompteagent/{idcompte}", name="editcompteagent")
     */
    public function editCompteAgent($id, $idcompte, Request $request, EntityManagerInterface $em, ComptesRepository $repo, AgentsRepository $repodeux, ContratsRepository $repocontrat, UserInterface $user): Response
    {
        $agent = $repodeux->find($id);
        $compte = $repo->find($idcompte);
        $form = $this->createForm(EditCompteAgentType::class, $compte);
        $today = date('Y-m-j');
        $modif = $user->getNom().' '.$user->getPrenom();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {

        $compte ->setDateModif(\DateTime::createFromFormat ('Y-m-d', $today));
        $compte->setAgents($agent);
        $compte->setModificateur($modif);
        $em ->persist($compte);
        $em->flush();

        $comptes = $repo-> findBy(['agents' => $id]);
        $contrats = $repocontrat->findBy(['agents' => $id]);

        //return $this->render('agents/detail.html.twig', ['Agents' => $agent, 'Comptes' => $comptes, 'Contrats' => $contrats]);
        return $this->redirectToRoute('agent', ['id' => $id]);

        }

        return $this->render('agents/editCompteAgent.html.twig', [
            'Agents' => $agent,
            'Comptes' => $compte,
            'form' => $form->createView()

            ]);

    }

    /**
     * @Route("/agents/datepassees/dez/{id}", name="dezCompte")
     */

    public function dezCompte($id, EntityManagerInterface $em, ComptesRepository $repo, AgentsRepository $repoagents)
    {
      $compte = $repo->find($id);
      $actif =0;
      $compte->setActif($actif);
      $em ->persist($compte);
      $em->flush();


      $agents = $repoagents->findAll();

      return $this->redirectToRoute('adez', ['Agents' => $agents]);


    }

    /**
     * @Route("/agents/{id}/newpwd/{idcompte}", name="newPwd")
     */
    public function genererPwd($id, $idcompte, Request $request, EntityManagerInterface $em, ComptesRepository $repo, AgentsRepository $repodeux, ContratsRepository $repocontrat): Response
    {
        $agent = $repodeux->find($id);
        $compte = $repo->find($idcompte);
        function passgen2($nbChar){
            return substr(str_shuffle('abcdefghijkmnopqrstuvwxyzABCEFGHIJKLMNPQRSTUVWXYZ123456789'),1, $nbChar);
        }
        $pwd = passgen2(16);

        $compte->setPwd($pwd);
        $em ->persist($compte);
        $em->flush();
        $comptes = $repo-> findBy(['agents' => $id]);
        $contrats = $repocontrat->findBy(['agents' => $id]);

        //return $this->render('agents/detail.html.twig', ['Agents' => $agent, 'Comptes' => $comptes, 'Contrats' => $contrats]);
        return $this->redirectToRoute('agent', ['id' => $id]);

        }

    /**
     * @Route("/agents/{id}/voircontrats", name="contratsparagent")
     */
    public function voirContrats($id, ContratsRepository $repo, AgentsRepository $repodeux): Response
    {
        $contrats = $repo->findBy(['agents' => $id]);
        $agent = $repodeux->find($id);
        return $this->render('agents/contrats.html.twig', ['Contrats' =>$contrats, 'Agents' => $agent ]);
    }

    /**
     * @Route("/agents/{id}/addcontratagent", name="addcontratagent")
     */
    public function addContrat($id, Request $request, EntityManagerInterface $em,  AgentsRepository $repodeux, ComptesRepository $repo, ContratsRepository $repocontrat): Response
    {
        $agent = $repodeux->find($id);
        $contrat = new Contrats();
        $today = date('Y-m-j');
        $dernierContrat = 1;
        $annul = 0;
        $form = $this->createForm(AddContratType::class, $contrat);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $anciencontrat = $repocontrat->findBy(['agents' => $id],['id' => 'DESC'],1,[]);
            $anciencontrat[0]->setDernierContrat($annul);
            $contrat ->setDateAjout(\DateTime::createFromFormat ('Y-m-d', $today));
            $contrat->setAgents($agent);
            $contrat->setDernierContrat($dernierContrat);
        $em ->persist($contrat);
        $em->flush();

        $comptes = $repo-> findBy(['agents' => $id]);
        $contrats = $repocontrat->findBy(['agents' => $id]);

        //return $this->render('agents/detail.html.twig', ['Agents' => $agent, 'Comptes' => $comptes, 'Contrats' => $contrats]);
        return $this->redirectToRoute('agent', ['id' => $id]);

        }

        return $this->render('agents/addContrat.html.twig', [
            'Agents' => $agent,
            'form' => $form->createView()

            ]);

    }

    /**
     * @Route("/agents/{id}/editcontratagent/{idcontrat}", name="editcontratagent")
     */
    public function editContrat($id, $idcontrat, Request $request, EntityManagerInterface $em, ContratsRepository $repo, AgentsRepository $repodeux, ComptesRepository $repocomptes): Response
    {
        $agent = $repodeux->find($id);
        $contrat = $repo->find($idcontrat);
        $form = $this->createForm(EditContratType::class, $contrat);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {

            $contrat->setAgents($agent);
        $em ->persist($contrat);
        $em->flush();

        $comptes = $repocomptes-> findBy(['agents' => $id]);

        $contrats = $repo->findBy(['agents' => $id]);

        //return $this->render('agents/detail.html.twig', ['Agents' => $agent, 'Comptes' => $comptes, 'Contrats' => $contrats]);
        return $this->redirectToRoute('agent', ['id' => $id]);


        }

        return $this->render('agents/editContrat.html.twig', [
            'Agents' => $agent,
            'Contrats' => $contrat,
            'form' => $form->createView()

            ]);

    }

    /**
     * @Route("/agents/edit/{id}", name="editAgent")
     */
    public function editAgent($id, AgentsRepository $repo, Request $request, EntityManagerInterface $em, ContratsRepository $repocontrats, ComptesRepository $repocomptes): Response
    {
        $agent = $repo->find($id);
        $form = $this->createForm(EditAgentType::class, $agent);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {


        $em ->persist($agent);
        $em->flush();

        $comptes = $repocomptes-> findBy(['agents' => $id]);

        $contrats = $repocontrats->findBy(['agents' => $id]);

        //return $this->render('agents/detail.html.twig', ['Agents' => $agent, 'Comptes' => $comptes, 'Contrats' => $contrats]);
        return $this->redirectToRoute('agent', ['id' => $id]);

        }

        return $this->render('agents/editAgent.html.twig', [
            'form' => $form->createView()
            ]);

    }

    /**
     * @Route("/agents/{id}/compte/{idcompte}/maileruser", name="sendEmailInit")
     */
    public function sendEmailInit($id, $idcompte, MailerInterface $mailer, MailerInterface $mailer_mdp, AgentsRepository $repoagents, ComptesRepository $repocomptes, ContratsRepository $repocontrats, SoftsRepository $reposoft ): Response
    {
        $agent = $repoagents->find($id);
        $compte = $repocomptes-> find($idcompte);
        $idagent =$id;
        $mailagent = $agent->getMail();
        $email = (new TemplatedEmail())
            -> from('dpi@ch-calais.fr')
            -> to($mailagent)
            -> subject('[CH Calais] - Vos accès informatiques')
            -> htmlTemplate('mailer/mail_user_init.html.twig')
		-> context([
				'Agent' => $agent,
                'Compte' => $compte


				]);
        $mailer->send($email);

        $comptes = $repocomptes-> findBy(['agents' => $id]);

        $contrats = $repocontrats->findBy(['agents' => $id]);
        //return $this->render('agents/detail.html.twig', ['Agents' => $agent, 'Comptes' => $comptes, 'Contrats' => $contrats]);
        return $this->redirectToRoute('agent', ['id' => $idagent]);
    }

     /**
     * @Route("/agents/{id}/compte/{idcompte}/mailerpwd", name="sendEmailPwdInit")
     */
    public function sendEmailPwdInit($id, $idcompte, MailerInterface $mailer, MailerInterface $mailer_mdp,EntityManagerInterface $em, AgentsRepository $repoagents, ComptesRepository $repocomptes, ContratsRepository $repocontrats, SoftsRepository $reposoft ): Response
    {
        $agent = $repoagents->find($id);
        $compte = $repocomptes-> find($idcompte);
        $idagent =$id;
        $mailagent = $agent->getMail();
        $email = (new TemplatedEmail())
            -> from('dpi@ch-calais.fr')
            -> to($mailagent)
            -> subject('[CH Calais] - Vos accès informatiques')
            -> htmlTemplate('mailer/mail_user_init_pwd.html.twig')
		-> context([
				'Agent' => $agent,
                'Compte' => $compte


				]);
        $mailer->send($email);
        $compte->setPwd('NULL');
        $em ->persist($compte);
        $em->flush();

        $comptes = $repocomptes-> findBy(['agents' => $id]);

        $contrats = $repocontrats->findBy(['agents' => $id]);
        //return $this->render('agents/detail.html.twig', ['Agents' => $agent, 'Comptes' => $comptes, 'Contrats' => $contrats]);
        return $this->redirectToRoute('agent', ['id' => $idagent]);
    }



    /**
     * @Route("/agents/{id}/compte/{idcompte}/mailer/{idsoft}", name="sendEmail")
     */
    public function sendEmail($id, $idcompte, $idsoft, MailerInterface $mailer, MailerInterface $mailer_mdp, AgentsRepository $repoagents, ComptesRepository $repocomptes, ContratsRepository $repocontrats, SoftsRepository $reposoft ): Response
    {
        $agent = $repoagents->find($id);
        $compte = $repocomptes->find($idcompte);
        $soft = $reposoft->find($idsoft);
        $libellesoft = $soft->getSoftLibelle();
        $idagent =$id;
        $mailagent = $agent->getMail();
        $email = (new TemplatedEmail())
            -> from('dpi@ch-calais.fr')
            -> to($mailagent)
            -> subject('[CH Calais] - Vos accès informatiques à '.$libellesoft)
            -> htmlTemplate('mailer/mail_user.html.twig')
		-> context([
				'Agent' => $agent,
				'Soft' => $soft,
                'Compte' => $compte


				]);
        $mailer->send($email);

        $comptes = $repocomptes-> findBy(['agents' => $id]);

        $contrats = $repocontrats->findBy(['agents' => $id]);
        //return $this->render('agents/detail.html.twig', ['Agents' => $agent, 'Comptes' => $comptes, 'Contrats' => $contrats]);
        return $this->redirectToRoute('agent', ['id' => $idagent]);
    }

    /**
     * @Route("/agents/{id}/compte/{idcompte}/mailerpwd/{idsoft}", name="sendEmailPwd")
     */
    public function sendEmailPwd($id, $idcompte, $idsoft, MailerInterface $mailer, MailerInterface $mailer_mdp,EntityManagerInterface $em, AgentsRepository $repoagents, ComptesRepository $repocomptes, ContratsRepository $repocontrats, SoftsRepository $reposoft ): Response
    {
        $agent = $repoagents->find($id);
        $compte = $repocomptes->find($idcompte);
        $soft = $reposoft->find($idsoft);
        $libellesoft = $soft->getSoftLibelle();

        $mailagent = $agent->getMail();
        $email = (new TemplatedEmail())
            -> from('dpi@ch-calais.fr')
            -> to($mailagent)
            -> subject('[CH Calais] - Vos accès informatiques à '.$libellesoft)
            -> htmlTemplate('mailer/mail_pwd.html.twig')
		-> context([
				'Agent' => $agent,
				'Soft' => $soft,
                'Compte' => $compte


				]);
        $mailer->send($email);
        $compte->setPwd('NULL');
        $em ->persist($compte);
        $em->flush();

        $comptes = $repocomptes-> findBy(['agents' => $id]);

        $contrats = $repocontrats->findBy(['agents' => $id]);
        //return $this->render('agents/detail.html.twig', ['Agents' => $agent, 'Comptes' => $comptes, 'Contrats' => $contrats]);
        return $this->redirectToRoute('agent', ['id' => $id]);

    }

    /**
     * @Route("/agents/{id}/compte/{idcompte}/mailerusersms", name="sendSmsInit")
     */
    public function sendSmsInit($id, $idcompte, MailerInterface $mailer, MailerInterface $mailer_mdp, AgentsRepository $repoagents, ComptesRepository $repocomptes, ContratsRepository $repocontrats, SoftsRepository $reposoft ): Response
    {
        $agent = $repoagents->find($id);
        $compte = $repocomptes-> find($idcompte);
        $idagent =$id;
        $telagent = $agent->getTel();
        $telagentenvoi = $telagent.'@sms.chc.org';

        $email = (new TemplatedEmail())
            -> from('dpi@ch-calais.fr')
            -> to($telagentenvoi)
            -> subject('')
            -> htmlTemplate('mailer/sms_user_init.html.twig')
		-> context([
				'Agent' => $agent,
                'Compte' => $compte


				]);
        $mailer->send($email);

        $comptes = $repocomptes-> findBy(['agents' => $id]);

        $contrats = $repocontrats->findBy(['agents' => $id]);
        //return $this->render('agents/detail.html.twig', ['Agents' => $agent, 'Comptes' => $comptes, 'Contrats' => $contrats]);
        return $this->redirectToRoute('agent', ['id' => $idagent]);
    }

    /**
     * @Route("/agents/{id}/compte/{idcompte}/mailerpwdsms", name="sendSmsInitPwd")
     */
    public function sendSmsInitPwd($id, $idcompte, MailerInterface $mailer, MailerInterface $mailer_mdp,EntityManagerInterface $em, AgentsRepository $repoagents, ComptesRepository $repocomptes, ContratsRepository $repocontrats, SoftsRepository $reposoft ): Response
    {
        $agent = $repoagents->find($id);
        $compte = $repocomptes-> find($idcompte);
        $idagent =$id;
        $telagent = $agent->getTel();
        $telagentenvoi = $telagent.'@sms.chc.org';

        $email = (new TemplatedEmail())
            -> from('dpi@ch-calais.fr')
            -> to($telagentenvoi)
            -> subject('')
            -> htmlTemplate('mailer/sms_user_init_pwd.html.twig')
		-> context([
				'Agent' => $agent,
                'Compte' => $compte


				]);
        $mailer->send($email);
        $compte->setPwd('NULL');
               $em ->persist($compte);
               $em->flush();
        $comptes = $repocomptes-> findBy(['agents' => $id]);

        $contrats = $repocontrats->findBy(['agents' => $id]);
        //return $this->render('agents/detail.html.twig', ['Agents' => $agent, 'Comptes' => $comptes, 'Contrats' => $contrats]);
        return $this->redirectToRoute('agent', ['id' => $idagent]);
    }


    /**
     * @Route("/agents/{id}/compte/{idcompte}/sms/{idsoft}", name="sendSms")
     */
    public function sendSms($id, $idcompte, $idsoft, MailerInterface $mailer, MailerInterface $mailer_mdp, AgentsRepository $repoagents, ComptesRepository $repocomptes, ContratsRepository $repocontrats, SoftsRepository $reposoft ): Response
    {
        $agent = $repoagents->find($id);
        $compte = $repocomptes->find($idcompte);
        $soft = $reposoft->find($idsoft);
        $libellesoft = $soft->getSoftLibelle();

        $telagent = $agent->getTel();
        $telagentenvoi = $telagent.'@sms.chc.org';
        $email = (new TemplatedEmail())
            -> from('dpi@ch-calais.fr')
            -> to($telagentenvoi)
            -> htmlTemplate('mailer/sms_user.html.twig')
		-> context([
				'Agent' => $agent,
				'Soft' => $soft,
                'Compte' => $compte

				]);
        $mailer->send($email);

        $comptes = $repocomptes-> findBy(['agents' => $id]);

        $contrats = $repocontrats->findBy(['agents' => $id]);
        //return $this->render('agents/detail.html.twig', ['Agents' => $agent, 'Comptes' => $comptes, 'Contrats' => $contrats]);
        return $this->redirectToRoute('agent', ['id' => $id]);

    }

        /**
     * @Route("/agents/{id}/compte/{idcompte}/smspwd/{idsoft}", name="sendSmsPwd")
     */
    public function sendSmsPwd($id, $idcompte, $idsoft, MailerInterface $mailer,EntityManagerInterface $em, MailerInterface $mailer_mdp, AgentsRepository $repoagents, ComptesRepository $repocomptes, ContratsRepository $repocontrats, SoftsRepository $reposoft ): Response
    {
        $agent = $repoagents->find($id);
        $compte = $repocomptes->find($idcompte);
        $soft = $reposoft->find($idsoft);
        $libellesoft = $soft->getSoftLibelle();

        $telagent = $agent->getTel();
        $telagentenvoi = $telagent.'@sms.chc.org';
        $email = (new TemplatedEmail())
            -> from('dpi@ch-calais.fr')
            -> to($telagentenvoi)
            -> htmlTemplate('mailer/sms_pwd.html.twig')
		-> context([
				'Agent' => $agent,
				'Soft' => $soft,
                'Compte' => $compte


				]);
        $mailer->send($email);
        $compte->setPwd('NULL');
               $em ->persist($compte);
               $em->flush();
        $comptes = $repocomptes-> findBy(['agents' => $id]);

        $contrats = $repocontrats->findBy(['agents' => $id]);
        //return $this->render('agents/detail.html.twig', ['Agents' => $agent, 'Comptes' => $comptes, 'Contrats' => $contrats]);
        return $this->redirectToRoute('agent', ['id' => $id]);


    }

}
