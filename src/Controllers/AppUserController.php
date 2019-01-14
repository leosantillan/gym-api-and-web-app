<?php 

declare(strict_types = 1);

namespace VirtuaGym\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VirtuaGym\Template\FrontendRenderer;
use VirtuaGym\MyPDO;

use VirtuaGym\Models\User;

class AppUserController
{
    private $request;
    private $response;
    private $renderer;
    private $model;

    public function __construct(Request $request, Response $response, FrontendRenderer $renderer, MyPDO $myPDO)
    {
        $this->request = $request;
        $this->response = $response;
        $this->renderer = $renderer;
        $this->model = new User($myPDO);
    }

    public function list()
    {
        $data['users'] = json_decode($this->model->getAll(), true);
        $html = $this->renderer->render('Users', $data);
        $this->response->setContent($html);
    }

    public function form()
    {
        $id = $this->request->get('id');
        $data['user'] = ($id) ? json_decode($this->model->getOne($id), true) : [];
        $html = $this->renderer->render('UserForm', $data);
        $this->response->setContent($html);
    }
}
