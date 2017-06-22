<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;


class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $postfix = '';
        $menu = $factory->createItem('root');

        $menu->addChild('Home', ['route' => 'homepage'])->setExtra('routes', ['homepage', 'homepage.locale']);

        $menu->addChild('Form', ['route' => 'form'])->setExtra('routes', ['form', 'form.locale']);
        $menu['Form']->addChild('Ajax form', ['route' => 'ajax-form'])->setExtra('routes', ['ajax-form', 'ajax-form.locale']);

        // create another menu item
        /*$menu->addChild('About Me', ['route' => 'about']);
        // you can also add sub level's to your menu's as follows
        $menu['About Me']->addChild('about child', array('route' => 'about_child'));*/

        // ... add more children

        return $menu;
    }
}