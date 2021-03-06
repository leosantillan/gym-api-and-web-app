<?php 

declare(strict_types = 1);

namespace VirtuaGym\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VirtuaGym\MyPDO;

use VirtuaGym\Models\PlanDay;

class PlanDayController
{
    private $request;
    private $response;
    private $model;

    public function __construct(Request $request, Response $response, MyPDO $myPDO)
    {
        $this->request = $request;
        $this->response = $response;
        $this->model = new PlanDay($myPDO);
    }

    public function index()
    {
        try {
            $result = $this->model->getAll();
            $this->response->setContent($result);
            $this->response->setStatusCode(Response::HTTP_OK);
            $this->response->headers->set('Content-Type', 'application/json');
        } catch (Exception $e) {
            $this->response->setContent($e->getMessage());
            $this->response->setStatusCode(500);
        }
    }

    public function store()
    {
        try {
            $data = json_decode($this->request->getContent(), true);
            $result = $this->model->add($data);

            /** 
             * Email sending (NOT IMPLEMENTED)
             * 
             * For simplicity sake, a Helper was used but in real environments
             * this could be a service sending tasks to a queue.
             */
            $emails = json_decode($this->model->getEmailUsersByPlanId($data['id_plan']), true);
            $plan = json_decode($this->model->getPlanById($data['id_plan']), true);print_r($plan);exit;
            MailHelper::notify($emails, 'We got news!', 'Your plan ' . $plan[0]['name']. 'has changed!');

            $this->response->setContent($result);
            $this->response->setStatusCode(Response::HTTP_CREATED);
            $this->response->headers->set('Content-Type', 'application/json');
        } catch (Exception $e) {
            $this->response->setContent($e->getMessage());
            $this->response->setStatusCode(500);
        }
    }

    public function delete()
    {
        try {
            $id = $this->request->get('id');
            $result = $this->model->delete($id);
            $this->response->setContent($result);
            $this->response->setStatusCode(Response::HTTP_NO_CONTENT);
        } catch (Exception $e) {
            $this->response->setContent($e->getMessage());
            $this->response->setStatusCode(500);
        }
    }
}
