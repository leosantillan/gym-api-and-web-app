<?php 

declare(strict_types = 1);

namespace VirtuaGym\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VirtuaGym\Template\FrontendRenderer;
use VirtuaGym\MyPDO;

use VirtuaGym\Models\UserPlan;

class AppPlanUserController
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
        $this->model = new UserPlan($myPDO);
    }

    public function list()
    {
        $data['planusers']['id'] = $this->request->get('id');
        $data['planusers']['list'] = json_decode($this->model->getByUserId($this->request->get('id')), true);
        $html = $this->renderer->render('PlanUsers', $data);
        $this->response->setContent($html);
    }

    public function form()
    {
        $data['planuser']['plan'] = json_decode($this->model->getPlanById($this->request->get('id')), true);
        $data['planuser']['users'] = json_decode($this->model->getUsers(), true);
        $html = $this->renderer->render('PlanUserForm', $data);
        $this->response->setContent($html);
    }
}
