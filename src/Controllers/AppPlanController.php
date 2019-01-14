<?php 

declare(strict_types = 1);

namespace VirtuaGym\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VirtuaGym\Template\FrontendRenderer;
use VirtuaGym\MyPDO;

use VirtuaGym\Models\Plan;

class AppPlanController
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
        $this->model = new Plan($myPDO);
    }

    public function list()
    {
        $data['plans'] = json_decode($this->model->getAll(), true);
        $html = $this->renderer->render('Plans', $data);
        $this->response->setContent($html);
    }

    public function form()
    {
        $id = $this->request->get('id');
        $data['plan'] = json_decode($this->model->getOne($id), true);
        $html = $this->renderer->render('PlanForm', $data);
        $this->response->setContent($html);
    }
}
