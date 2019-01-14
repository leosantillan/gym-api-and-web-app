<?php 

declare(strict_types = 1);

namespace VirtuaGym\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VirtuaGym\Template\FrontendRenderer;
use VirtuaGym\MyPDO;

use VirtuaGym\Models\Exercise;

class AppExerciseController
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
        $this->model = new Exercise($myPDO);
    }

    public function list()
    {
        $data['exercises'] = json_decode($this->model->getAll(), true);
        $html = $this->renderer->render('Exercises', $data);
        $this->response->setContent($html);
    }

    public function form()
    {
        $id = $this->request->get('id');
        $data['exercise'] = ($id) ? json_decode($this->model->getOne($id), true) : [];
        $html = $this->renderer->render('ExerciseForm', $data);
        $this->response->setContent($html);
    }
}
