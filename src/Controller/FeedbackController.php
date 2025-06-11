<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FeedbackController extends AbstractController
{
    #[Route('/feedback', name: 'app_feedback')]
    public function index(Request $request): Response
    {
        $feedback = null;

        if ($request->isMethod('POST')) {
            $feedback = $request->request->get('feedback');
        }

        return $this->render('feedback/index.html.twig', [
            'feedback' => $feedback,
        ]);
    }
}
