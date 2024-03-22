<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Payment;
use App\Form\CommandeType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class LandingPageController extends AbstractController
{
    #[Route('/', name: 'landing_page')]
    public function index(Request $request, EntityManagerInterface $entityManager, ProductRepository $productRepository): Response
    {
        // Création d'une nouvelle instance de Commande (une commande vide)
        $commande = new Commande();

        // Création du formulaire de commande à partir de la classe CommandeType
        // Ce formulaire sera associé à la commande créée précédemment
        $formCommande = $this->createForm(CommandeType::class, $commande);

        // Gestion de la soumission du formulaire
        $formCommande->handleRequest($request);

        // Récupération de tous les produits depuis le repository des produits
        $products = $productRepository->findAll();

        // Traitement lorsque le formulaire est soumis et valide
        if ($formCommande->isSubmitted() && $formCommande->isValid()) {
            // Récupération des données de livraison depuis le formulaire
            $delivery = $formCommande->get('deliveryLocations')->getData();

            // Récupération de l'identifiant du produit depuis la requête
            // On suppose que l'identifiant est dans le tableau associatif 'order' de la requête
            // et est stocké dans le premier élément du tableau 'cart_products'
            
            $productId = $request->get('order')['cart']['cart_products'][0];

            
            // Récupération de la méthode de paiement depuis la requête
            // On suppose que la méthode de paiement est également dans le tableau 'order' de la requête
            $paymentMethod = $request->get('order')['payment_method'];

            // Recherche du produit correspondant à l'identifiant récupéré
            $product = $productRepository->find($productId);

            // Association du produit sélectionné à la commande
            $commande->setProduct($product);

            // Création d'une nouvelle instance de Payment (paiement)
            $payment = new Payment();
            // Définition du statut initial du paiement (0 pour en attente)
            $payment->setStatus(0);
            // Définition du montant du paiement basé sur le prix du produit sélectionné
            $payment->setAmount($commande->getProduct()->getPrice());
            // Définition de la date de création du paiement
            $payment->setCreatedAt(new DateTimeImmutable());

            // Association du paiement à la commande
            $commande->setPayment($payment);

            // Persistance des entités (Commande, Paiement, Livraison) dans la base de données
            $entityManager->persist($commande);
            $entityManager->persist($payment);
            $entityManager->persist($delivery);
            // Exécution des opérations de persistance
            $entityManager->flush();

            // Envoi d'une requête API pour notifier un système externe de la nouvelle commande
            $this->sendApiRequest($commande);

            // Redirection vers la page de confirmation après soumission réussie du formulaire
            return $this->redirectToRoute('confirmation');
        }

        // Rendu de la vue du formulaire de commande avec la liste des produits disponibles
        return $this->render('landing_page/index_new.html.twig', [
            'form' => $formCommande->createView(),
            'products' => $products,
        ]);
    }

    #[Route('/confirmation', name: 'confirmation')]
    public function confirmation(): Response
    {
        // Rendu de la vue de confirmation de commande
        return $this->render('landing_page/confirmation.html.twig');
    }

    // Méthode pour envoyer une requête API
    public function sendApiRequest(Commande $commande)
    {
        // Création d'un client Guzzle pour effectuer une requête HTTP
        $client = new \GuzzleHttp\Client();

        // Envoi d'une requête POST à l'API avec les détails de la commande
        $client->request('POST', 'https://api-commerce.simplon-roanne.com/order', [
            // En-têtes de la requête avec le jeton d'autorisation
            'headers' => [
                'Authorization' => "Bearer mJxTXVXMfRzLg6ZdhUhM4F6Eutcm1ZiPk4fNmvBMxyNR4ciRsc8v0hOmlzA0vTaX"
            ],
            // Corps de la requête contenant les détails de la commande au format JSON
            'json' => [
                "order" => [
                    // Identifiant de la commande
                    "id" => $commande->getId(),
                    // Nom du produit commandé
                    "product" => $commande->getProduct()->getName(),
                    // Méthode de paiement utilisée
                    "payment_method" => "stripe", // On pourrait utiliser la méthode de paiement fournie par la requête, mais ici, on utilise "stripe" par défaut
                    // Statut de la commande (dans cet exemple, toujours "WAITING" pour en attente)
                    "status" => "WAITING",
                    // Détails du client
                    "client" => [
                        "firstname" => $commande->getFirstName(),
                        "lastname" => $commande->getLastName(),
                        "email" => $commande->getEmail(),
                    ],
                    // Adresses de facturation et de livraison
                    "addresses" => [
                        // Détails de l'adresse de facturation
                        "billing" => [
                            "address_line1" => $commande->getAdress(),
                            "address_line2" => $commande->getAdressSup(),
                            "city" => $commande->getCity(),
                            "zipcode" => $commande->getCp(),
                            "country" => $commande->getCountry(),
                            "phone" => $commande->getPhone(),
                        ],
                        // Détails de l'adresse de livraison
                        "shipping" => [
                            "address_line1" => $commande->getDeliveryLocations()->getAdress(),
                            "address_line2" => $commande->getDeliveryLocations()->getAddressSupp(),
                            "city" => $commande->getDeliveryLocations()->getCity(),
                            "zipcode" => $commande->getDeliveryLocations()->getCp(),
                            "country" => $commande->getDeliveryLocations()->getCountry(),
                            "phone" => $commande->getDeliveryLocations()->getPhone(),
                        ]
                    ]
                ]
            ]
        ]); 
    }
}
