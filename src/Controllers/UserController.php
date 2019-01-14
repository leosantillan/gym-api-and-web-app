<?php 

declare(strict_types = 1);

namespace VirtuaGym\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VirtuaGym\MyPDO;

use VirtuaGym\Models\User;

class UserController
{
    private $request;
    private $response;
    private $model;

    public function __construct(Request $request, Response $response, MyPDO $myPDO)
    {
        $this->request = $request;
        $this->response = $response;
        $this->model = new User($myPDO);
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

    public function show()
    {
        try {
            $id = $this->request->get('id');
            $result = $this->model->getOne($id);
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
            $this->response->setContent($result);
            $this->response->setStatusCode(Response::HTTP_CREATED);
            $this->response->headers->set('Content-Type', 'application/json');
        } catch (Exception $e) {
            $this->response->setContent($e->getMessage());
            $this->response->setStatusCode(500);
        }
    }

    public function update()
    {
        try {
            $id = $this->request->get('id');
            $data = json_decode($this->request->getContent(), true);
            $result = $this->model->update($data, $id);
            $this->response->setContent($result);
            $this->response->setStatusCode(Response::HTTP_OK);
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
