<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Entity\AjaxTask;
use AppBundle\Form\AjaxTaskType;
use AppBundle\Form\TaskType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\Translator;

class FormController extends Controller
{
    public function indexAction(Request $request)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task, [
            'action' => '/form/',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            // запись и тп

            //return $this->redirectToRoute('homepage');
        }
        // replace this example code with whatever you need
        return $this->render('form/index.html.twig', [
            'request' => json_encode($request->get('task'), 256 + 128),
            'locale' => $request->getLocale(),
            'form' => $form->createView(),
        ]);
    }

    public function ajaxFormAction(Request $request)
    {
        $ajaxTask = new AjaxTask();
        $form = $this->createForm(AjaxTaskType::class, $ajaxTask, [
            'attr' => [
                'ng-controller' => 'ctrlForm',
                'ng-submit' => 'submit()',
            ],
            'action' => '',
        ]);
        return $this->render('form/ajaxForm.html.twig', [
            'locale' => $request->getLocale(),
            'form' => $form->createView(),
            'session' => json_encode($request->getSession()->all(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
        ]);
    }

    public function ajaxRouterAction($slug = '')
    {
        print_r($slug);
        return $this->json([
            'method' => $slug,
            'request' => '',
        ], 200);
    }

    public function ajaxFormProcessingAction(Request $request)
    {
        // преобразуем request от angularjs
        $data = json_decode($request->getContent(), true);
        unset($data['ajax_task']['task']);
        $request->request->replace($data);
        /*
        // если не указывать в routing
        if (!$request->isXmlHttpRequest()) {
            return $this->json([
                'success' => $success,
                'isXmlHttpRequest' => $request->isXmlHttpRequest(),
            ], 400);
        }

        // если нужна проверка метода
        if ($request->getMethod() == 'POST') { ... }
        */


        $ajaxTask = new AjaxTask();
        $form = $this->createForm(AjaxTaskType::class, $ajaxTask, [

        ]);
        $form->handleRequest($request);
        $success = false;
        if ($form->isValid()) {
            $ajaxTask = $form->getData();
            // запись и тп
            //return $this->redirectToRoute('homepage');

            $success = true;
            return $this->json([
                'success' => $success,
                'data' => $data,
                'errors' => $form->getErrors(),
            ], 200);
        }
        $ajaxTask = $form->getData();
        $validator = $this->get('validator');
        $errors = $validator->validate($ajaxTask);
        $errorsMsg = [];
        $countError = $errors->count();
        if ($countError) {
            $translator = $this->get('translator');
            for ($i = 0; $i < $countError; ++$i) {
                $errorsMsg[] = [
                    'error' => $translator->trans($errors->get($i)->getMessage()),
                    'name' => $errors->get($i)->getPropertyPath(),
                    'value' => $errors->get($i)->getInvalidValue(),
                ];
            }
        }

        return $this->json([
            'request' => $request->request->all(),
            'errors' => $errorsMsg,
            'data' => $data,
            'success' => $success,
            'session' => $ajaxTask->getDueDate(),
        ], 400);
    }
}