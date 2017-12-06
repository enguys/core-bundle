<?php

namespace Enguys\CoreBundle\Controller;

use Enguys\CoreBundle\Entity\Media;
use Enguys\CoreBundle\Form\MediaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MediaController extends Controller
{
    /**
     * @param string $type
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function uploadAction(string $type, Request $request)
    {
        $media = new Media();
        $form = $this->createForm(MediaType::class, $media);
        $form->handleRequest($request);
        if (!$form->isValid()) {
            return $this->json(['error' => $form->getErrors()[0]->getMessage()], 400);
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($media);
        $em->flush();
        $response = [
            'id' => $media->getId(),
            'html' => $this->render(
                '@EnguysCore/Media/_item.html.twig',
                ['media' => $media, 'type' => $type]
            )->getContent(),
        ];

        return $this->json($response, 200);
    }
}
