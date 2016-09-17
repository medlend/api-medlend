<?php
/**
 * Created by PhpStorm.
 * User: abdellatif
 * Date: 14/09/16
 * Time: 15:19
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use AppBundle\Form\Type\PlaceType;
use AppBundle\Entity\Place;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class PlaceController extends Controller
{

    /**
     * @Rest\View()
     * @Rest\Put("/places/{id}")
     */
    public function updatePlaceAction(Request $request)
    {
        return $this->updatePlace($request, true);
    }

    /**
     * @Rest\View()
     * @Rest\Patch("/places/{id}")
     */
    public function patchPlaceAction(Request $request)
    {
        return $this->updatePlace($request, false);
    }

    private function updatePlace(Request $request, $clearMissing)
    {
        $place = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Place')
            ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire
        /* @var $place Place */

        if (empty($place)) {
            return \FOS\RestBundle\View\View::create(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(PlaceType::class, $place);

        // Le paramètre false dit à Symfony de garder les valeurs dans notre
        // entité si l'utilisateur n'en fournit pas une dans sa requête
        $form->submit($request->request->all(), $clearMissing);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($place);
            $em->flush();
            return $place;
        } else {
            return $form;
        }
    }


    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/places/{id}")
     */
    public function removePlaceAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $place = $em->getRepository('AppBundle:Place')
            ->find($request->get('id'));
        /* @var $place Place */

        if (!$place) {
            return;
        }

        foreach ($place->getPrices() as $price) {
            $em->remove($price);
        }
        $em->remove($place);
        $em->flush();
    }


    /**
     * @ApiDoc(
     *    description="Crée un lieu dans l'application",
     *    input={"class"=PlaceType::class, "name"=""},
     *    statusCodes = {
     *        201 = "Création avec succès",
     *        400 = "Formulaire invalide"
     *    },
     *    responseMap={
     *         201 = {"class"=Place::class, "groups"={"place"}},
     *         400 = { "class"=PlaceType::class, "form_errors"=true, "name" = ""}
     *    }
     * )
     *
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"place"})
     * @Rest\Post("/places")
     */
    
    public function postPlacesAction(Request $request)
    {
        $place = new Place();
        $form = $this->createForm(PlaceType::class, $place);

        $form->submit($request->request->all()); // Validation des données

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($place);
            $em->flush();
            return $place;
        } else {
            return $form;
        }
    }


    /**
     *
     * @ApiDoc(
     *    description="Récupère la liste des lieux de l'application",
     *    output= { "class"=Place::class, "collection"=true, "groups"={"place"} }
     * )
     * @Rest\View(serializerGroups={"place"})
     * @Rest\Get("/places")
     * @QueryParam(name="offset", requirements="\d+", default="", description="Index de début de la pagination")
     * @QueryParam(name="limit", requirements="\d+", default="", description="Nombre d'éléments à afficher")
     * @QueryParam(name="sort", requirements="(asc|desc)", nullable=true, description="Ordre de tri (basé sur le nom)")
     */
    public function getPlacesAction(Request $request, ParamFetcher $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $limit = $paramFetcher->get('limit');
        $sort = $paramFetcher->get('sort');

        $qb = $this->get('doctrine.orm.entity_manager')->createQueryBuilder();
        $qb->select('p')
            ->from('AppBundle:Place', 'p');

        if ($offset != "") {
            $qb->setFirstResult($offset);
        }

        if ($limit != "") {
            $qb->setMaxResults($limit);
        }
        if (in_array($sort, ['asc', 'desc'])) {
            $qb->orderBy('p.name', $sort);
        }

        $places = $qb->getQuery()->getResult();
/*
GET rest-api.local/places?limit=5 permet de lister cinq lieux ;
GET rest-api.local/places?offset=3 permet de lister tous les lieux en omettant les trois premiers lieux ;
GET rest-api.local/places?offset=1&limit=2 permet de lister trois lieux en omettant les deux premiers lieux dans l'application.
 */
        return $places;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/places/{id}")
     */
    public function getPlaceAction(Request $request)
    {
        $place = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Place')
            ->find($request->get('id')); // L'identifiant en tant que paramétre n'est plus nécessaire
        /* @var $place Place */

        if (empty($place)) {
            return \FOS\RestBundle\View\View::create(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }

        return $place;
    }
}