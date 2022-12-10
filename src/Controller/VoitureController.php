<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class VoitureController extends AbstractController
{
    /**
     * @Route("/voiture", name="list_voiture")
     */
    public function listVoiture(): Response
    {
        $em = $this -> getDoctrine() -> getManager();
        $voitures = $em -> getRepository(Voiture::class) ->findAll();

        return $this -> render("voiture/listVoiture.html.twig",
        array("listeVoitures" => $voitures)
        );
    }
    /**
     * @Route("/addVoiture", name="add-voiture")
     */

    public function  addVoiture(Request $request ){
        $voiture = new Voiture();
        $form = $this -> createForm(VoitureType::class,$voiture);
        $form->handleRequest($request);

        if( $form -> isSubmitted() and $form ->isValid()){
            $em = $this -> getDoctrine() ->getManager();
            $em -> persist($voiture);
            $em -> flush();

            return $this -> redirectToRoute('list_voiture');





        }
        return $this ->render("voiture/addVoiture.html.twig",
            [
                'formVoiture' => $form -> createView()
            ]

        );





    }

    /**
     * @Route("/deleteVoiture/{id}", name="delete-voiture")
     */

    public function  deleteVoiture($id ){
        $em = $this -> getDoctrine() -> getManager();
        $voiture = $em -> getRepository("App\Entity\Voiture") -> find($id);

        if($voiture != null){
            $em -> remove($voiture);
            $em ->flush();
        }else{
            throw new NotFoundHttpException("La voiture de l'id ".$id." n'existe pas!");
        }
        return $this -> redirectToRoute('list_voiture');



    }
    /**
     * @Route("/updateVoiture/{id}", name="update-voiture")
     */

    public function  updateVoiture(Request $request, $id ){
        $em = $this -> getDoctrine() -> getManager();
        $voiture = $em -> getRepository("App\Entity\Voiture") -> find($id);
        $editform = $this -> createForm(VoitureType::class,$voiture);
        $editform->handleRequest($request);

        if( $editform -> isSubmitted() and $editform ->isValid()){
            $em -> persist($voiture);
            $em -> flush();

            return $this -> redirectToRoute('list_voiture');
        }
        return $this -> render("voiture/updateVoiture.html.twig",[
            'editFormVoiture' => $editform -> createView()
            ]
        );

    }


    /**
     * @Route("/searchVoiture", name="voitureSearch")
     */

    public function  searchVoiture(Request $request )
    {
        $em = $this -> getDoctrine() -> getManager();
        $voitures = null;


        if( $request -> isMethod('POST')){
            $serie = $request ->request -> get("input_serie");
            $query = $em -> createQuery(
                "Select v from App\Entity\Voiture v where v.serie LIKE '%".$serie."%' ");
            $voitures = $query -> getResult();

        }
        return $this ->render("voiture/rechercheVoiture.html.twig",
            [
                'voitures' => $voitures
            ]

        );


    }




}
