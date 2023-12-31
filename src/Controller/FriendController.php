<?php

namespace App\Controller;

use App\Entity\Profile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class FriendController extends AbstractController
{
    #[Route('/{id}/friends', methods:['GET'])]
    public function indexFriends(Profile $profile): Response
    {
        $friends = $profile->getFriendList();
        return $this->json($friends, 200, [],['groups'=>'show_friends']);
    }
}
