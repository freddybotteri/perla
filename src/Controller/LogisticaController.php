<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Events;
use App\Form\CommentType;
use App\Repository\PostRepository;
use App\Repository\TagRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller used to manage blog contents in the public part of the site.
 *
 * @Route("/logistica")
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class LogisticaController extends AbstractController
{
    /**
     * @Route("/", defaults={"page": "1", "_format"="html"}, methods={"GET"}, name="logistica_index")
     * @Route("/rss.xml", defaults={"page": "1", "_format"="xml"}, methods={"GET"}, name="logistica_rss")
     * @Route("/page/{page<[1-9]\d*>}", defaults={"_format"="html"}, methods={"GET"}, name="logistica_index_paginated")
     * @Cache(smaxage="10")
     *
     * NOTE: For standard formats, Symfony will also automatically choose the best
     * Content-Type header for the response.
     * See https://symfony.com/doc/current/quick_tour/the_controller.html#using-formats
     */
    public function index(Request $request): Response
    {
        // Every template name also has two extensions that specify the format and
        // engine for that template.
        // See https://symfony.com/doc/current/templating.html#template-suffix

        /*
            ITEMS
        */

        $items = [
                 [
                    "id"=> 1,
                    "name"=> "Corona",
                    "description"=> "La Corona Extra, è una birra Pale lager messicana, prodotta dal birrificio Cerveceria Modelo e, limitatamente alla produzione destinata all'esportazione nel territorio statunitense, dalla Constellation Brands",
                    "country"=> "Messico"
                 ],
                 [
                    "id"=> 2,
                    "name"=> "Birra Moretti",
                    "description"=> "Birra Moretti è stata un'azienda specializzata nella produzione di birra. Nasce nel 1859 a Udine con il nome di Fabbrica di Birra e Ghiaccio. Fu fondata da Luigi Moretti, un imprenditore, la cui famiglia era dedita al commercio e all'ingrosso di bevande e generi alimentari, il marchio è stato acquisito dalla società olandese Heineken nel 1996.",
                    "country"=> "Italia"
                 ],
                 [
                    "id"=> 3,
                    "name"=> "Beck's",
                    "description"=> "Beck's (ufficialmente \"Brauerei Beck & Co KG\") è un birrificio tedesco",
                    "country"=> "Germania"
                 ],
                 [
                    "id"=> 4,
                    "name"=> "Forst",
                    "description"=> "Birra Forst (in tedesco Spezialbier-Brauerei Forst) è il maggiore produttore italiano indipendente[1] di birra. Detentore anche del marchio Menabrea.",
                    "country"=> "Italia"
                 ],
                 [
                    "id"=> 5,
                    "name"=> "Tabucchi",
                    "description"=> "Birra italiana prodotta artigianalmente, molto maltata",
                    "country"=> "Italia"
                 ]
                ];

       
        return $this->render('logistica/index.html.twig',['items' => $items]);
    }



    
    /**
     * @Route("/prod/{prodid}/{prodname}/{prodcita}", methods={"GET"}, name="logistica_prod")
     * @ParamConverter("post", options={"mapping": {"prodid": "prodid","prodname": "prodname","prodcita": "prodcita"}})
     *
     * See https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/converters.html#doctrine-converter
     */
    public function prod(Request $request,$prodid = null,$prodname = null,$prodcita = null): Response
    {
        // Every template name also has two extensions that specify the format and
        // engine for that template.
        // See https://symfony.com/doc/current/templating.html#template-suffix

        /*
            
        */
         $store = [
                  [
                    "id"=> 1,
                    "name"=> "Pisa",
                    "distance"=> 5,
                    "items"=> [
                      [
                        "id"=> 1,
                        "qty"=> 15,
                        "minQty"=> 10
                      ],
                      [
                        "id"=> 2,
                        "qty"=> 5,
                        "minQty"=> 7
                      ],
                      [
                        "id"=> 5,
                        "qty"=> 11,
                        "minQty"=> 20
                      ]
                    ]
                  ],
                  [
                    "id"=> 2,
                    "name"=> "Milano",
                    "distance"=> 20,
                    "items"=> [
                      [
                        "id"=> 2,
                        "qty"=> 5,
                        "minQty"=> 10
                      ],
                      [
                        "id"=> 5,
                        "qty"=> 10,
                        "minQty"=> 25
                      ]
                    ]
                  ],
                  [
                    "id"=> 3,
                    "name"=> "Tirana",
                    "distance"=> 120,
                    "items"=> [
                      [
                        "id"=> 3,
                        "qty"=> 30,
                        "minQty"=> 50
                      ],
                      [
                        "id"=> 4,
                        "qty"=> 35,
                        "minQty"=> 50
                      ],
                      [
                        "id"=> 5,
                        "qty"=> 25,
                        "minQty"=> 20
                      ]
                    ]
                  ]
                ];

         $id = $prodid;
         $name = $prodname;
         $cita = $prodcita;
      
       
        return $this->render('logistica/prod.html.twig',["id"=>$id,"name"=>$name,"cita"=>$cita,'store'=>$store]);
    }




    
}
