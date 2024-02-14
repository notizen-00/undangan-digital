<?php

namespace App\Controllers;

use Core\Routing\Controller;
use Core\Http\Request;
use App\Repositories\CommentContract;
use App\Repositories\LikeContract;
use App\Request\InsertCommentRequest;
use App\Response\JsonResponse;
use Core\Auth\Auth;
use Core\Database\DB;
use Core\Routing\Controller;
use Core\Http\Request;
use Core\Http\Respond;
class WelcomeController extends Controller
{

    
    public function __construct(CommentContract $comment, JsonResponse $json)
    {
        $this->json = $json;
        $this->comment = $comment;
    }

    public function __invoke(): \Core\View\View
    {
        return $this->view('welcome', [
            'data' => 'UCUP LOVE HILMY',
            'check' => $this->comment->get()
        ]);
    }
}
