<?php 

declare(strict_types = 1);

namespace VirtuaGym\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VirtuaGym\Template\FrontendRenderer;
use VirtuaGym\MyPDO;

use VirtuaGym\Models\DayExercise;

class AppDayExerciseController
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
        $this->model = new DayExercise($myPDO);
    }

    public function list()
    {
        $data['dayexercises']['id'] = $this->request->get('id');
        $data['dayexercises']['list'] = json_decode($this->model->getByDayId($this->request->get('id')), true);
        $html = $this->renderer->render('DayExercises', $data);
        $this->response->setContent($html);
    }

    public function form()
    {
        $data['dayexercise']['day'] = json_decode($this->model->getDayById($this->request->get('id')), true);
        $data['dayexercise']['exercises'] = json_decode($this->model->getExercises(), true);
        $html = $this->renderer->render('DayExerciseForm', $data);
        $this->response->setContent($html);
    }
}
