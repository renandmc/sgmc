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
        $menu = $factory->createItem('root', array('navbar' => true, 'pull-rigth' => true));
        $menu->addChild('Página inicial', array('icon' => 'home', 'route' => 'home'));
        $menu->addChild('Sobre', array('icon' => 'info-sign', 'route' => 'sobre'));
        $menu->addChild('Admin', array('icon' => 'lock', 'route' => 'admin_home'));
        $menu['Admin']->addChild('Cursos', array('route' => 'admin_cursos_index'));
        $menu['Admin']->addChild('Turmas', array('route' => 'admin_turmas_index'));
        $menu['Admin']->addChild('Setores', array('route' => 'admin_setores_index'));
        $menu['Admin']->addChild('Equipamentos', array('route' => 'admin_equipamentos_index'));
        $menu['Admin']->addChild('Usuários', array('route' => 'admin_usuarios_index'));
        $menu['Admin']->addChild('Ordens', array('route' => 'admin_ordens_index'));
        return $menu;
    }

    public function userMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array('navbar' => true, 'pull-left' => true));

    }

    public function sidebarMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(''));
    }

}