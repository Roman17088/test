<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Csrf\CsrfToken;

class AjaxController extends Controller
{
    public function randNumberAction(Request $request, $maxNumber = 1e3)
    {
        return $this->render('ajax/randNumber.html.twig', [
            'locale' => $request->getLocale(),
            'rand' => rand(0, $maxNumber),
        ]);
    }

    public function formAction(Request $request, $show = false)
    {
        $csrf = $this->container->get('security.csrf.token_manager');
        //new CsrfTokenManager();
        if ($show) {
            $task = new Task();
            $task->setEmail('email@email.ru');

            $form = $this->createFormBuilder($task)
                ->add('task', TextType::class)
                ->add('dueDate', DateType::class)
                ->add('save', SubmitType::class, array('label' => 'Create Post'))
                ->getForm();

            return $this->render('default/new.html.twig', array(
                'form' => $form->createView(),
            ));
            /* $request->getSession()->set('show', true);
             return $this->render('default/esi_form.html.twig', array(
                 'locale' => $request->getLocale(),
                 'rand' => rand(0, 1000),
                 '_token' => $csrf->getToken('test')->getValue(),
             ));*/
        }
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        $token = $request->request->get('_token');
        $success = $this->isCsrfTokenValid('test', $token);

        $objToken = new CsrfToken('test', $token);

        // replace this example code with whatever you need
        return $this->json([
            'name' => $request->request->all(),
            'token' => $token,
            '_token' => $csrf->getToken('test')->getValue(),
            'success' => $success,
            'test' => 'dd',
        ]);
    }
}