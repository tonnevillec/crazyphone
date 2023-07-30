<?php

namespace App\Controller;

use App\Entity\About;
use App\Entity\ContactInformations;
use App\Entity\Galerie;
use App\Entity\Openings;
use App\Entity\Promotions;
use App\Entity\Services;
use App\Entity\SocialNetworks;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly ParameterBagInterface $param,
        private readonly MailerInterface $mailer
    ){}

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $openings = $this->em->getRepository(Openings::class)->findAll();
        $services = $this->em->getRepository(Services::class)->findBy([], ['position' => 'ASC']);
        $networks = $this->em->getRepository(SocialNetworks::class)->findAll();
        $contacts = $this->em->getRepository(ContactInformations::class)->findAll();
        $promotions = $this->em->getRepository(Promotions::class)->findBy([], ['id' => 'desc'], 2);

        return $this->render('app/index.html.twig', [
            'openings' => $openings,
            'services' => $services,
            'networks' => $networks,
            'contacts' => $contacts,
            'promotions' => $promotions,
        ]);
    }

    #[Route('/shop', name: 'app_shop')]
    public function shop(): Response
    {
        return $this->render('app/shop.html.twig');
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        $about = $this->em->find(About::class, 1);
        $pictures = $this->em->getRepository(Galerie::class)->findBy([], ['ordre' => 'asc']);

        return $this->render('app/about.html.twig', [
            'about' => $about,
            'pictures' => $pictures
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        $openings = $this->em->getRepository(Openings::class)->findAll();
        $networks = $this->em->getRepository(SocialNetworks::class)->findAll();

        return $this->render('app/contact.html.twig', [
            'networks' => $networks,
            'openings' => $openings,
        ]);
    }

    #[Route('/send', name: 'app_contact_send', methods: ['POST'])]
    public function send(Request $request): RedirectResponse|Response
    {
        $datas = $request->request;
        $return = true;

        if ($datas->has('contact_robot') && !empty($datas->get('contact_robot'))) {
            $this->addFlash('error', 'Une erreur est survenue lors de l\'envoie du message');
            $return = false;
        }

        if (!$datas->has('contact_mail') || '' === $datas->get('contact_mail')) {
            $this->addFlash('error', 'Une erreur est survenue lors de l\'envoie du message : mail manquant');
            $return = false;
        }

        if (!$datas->has('contact_nom') || '' === $datas->get('contact_nom')) {
            $this->addFlash('error', 'Une erreur est survenue lors de l\'envoie du message : nom manquant');
            $return = false;
        }

        if (!$datas->has('contact_message') || '' === $datas->get('contact_message') || strlen(trim($datas->get('contact_message'))) < 10) {
            $this->addFlash('error', 'Une erreur est survenue lors de l\'envoie du message : message trop court');
            $return = false;
        }

        if (!$return) {
            $openings = $this->em->getRepository(Openings::class)->findAll();
            $networks = $this->em->getRepository(SocialNetworks::class)->findAll();

            return $this->render('app/contact.html.twig', [
                'networks' => $networks,
                'openings' => $openings,
                'contact_devis' => $datas->get('contact_devis'),
                'contact_nom' => $datas->get('contact_nom'),
                'contact_mail' => $datas->get('contact_mail'),
                'contact_message' => trim($datas->get('contact_message')),
            ]);
        }

        $mail = (new TemplatedEmail())
            ->to(new Address($this->param->get('mailer_to')))
            ->from(new Address($this->param->get('mailer_from')))
            ->subject('Contact depuis le site')
            ->htmlTemplate("mail/contact.html.twig")
            ->context([
                'contact_nom' => $datas->get('contact_nom'),
                'contact_devis' => $datas->get('contact_devis'),
                'contact_mail' => $datas->get('contact_mail'),
                'contact_message' => $datas->get('contact_message'),
            ]);
        try {
            $this->mailer->send($mail);
        } catch (TransportExceptionInterface $e) {
            dump($e->getMessage());
        }

        $this->addFlash('success', 'Votre message a été envoyé');

        return $this->redirectToRoute('app_contact');
    }
}
