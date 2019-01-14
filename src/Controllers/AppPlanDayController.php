<?php 

declare(strict_types = 1);

namespace VirtuaGym\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VirtuaGym\Template\FrontendRenderer;
use VirtuaGym\MyPDO;

use VirtuaGym\Models\PlanDay;

class AppPlanDayController
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
        $this->model = new PlanDay($myPDO);
    }

    public function list()
    {
        $data['plandays']['id'] = $this->request->get('id');
        $data['plandays']['list'] = json_decode($this->model->getByPlanId($this->request->get('id')), true);
        $html = $this->renderer->render('PlanDays', $data);
        $this->response->setContent($html);
    }

    public function form()
    {
        $data['planday']['plan'] = json_decode($this->model->getPlanById($this->request->get('id')), true);
        $data['planday']['days'] = json_decode($this->model->getDays(), true);
        $html = $this->renderer->render('PlanDayForm', $data);
        $this->response->setContent($html);
    }
}
