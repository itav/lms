<?php

namespace Optomedia\Tools;

use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\XliffFileLoader;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Extension\Csrf\CsrfExtension;
use Symfony\Component\Security\Csrf\TokenStorage\SessionTokenStorage;
use Symfony\Component\Security\Csrf\TokenGenerator\UriSafeTokenGenerator;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;

class AbstractController {

    private $container;

    public function __construct() {
        $this->container = new \Pimple\Container();
        $this->container['translator'] = function($c) {
            $translator = new Translator('en');
            $translator->addLoader('xlf', new XliffFileLoader());
            $translator->addResource(
                    'xlf', __DIR__ . '/../messages.en.xlf', 'en'
            );
            return $translator;
        };

        $this->container['form_default_theme'] = 'form_div_layout.html.twig';
        $this->container['vendor_dir'] = realpath(__DIR__ . '/../../vendor');

        $this->container['app_variable_reflection'] = function($c) {
            return new \ReflectionClass('\Symfony\Bridge\Twig\AppVariable');
        };
        $this->container['vendor_twig_bridge_dir'] = function($c){
            return dirname($c['app_variable_reflection']->getFileName());
        };

        $this->container['views_dir'] = $viewsDir = realpath(__DIR__ . '/../');

        $this->container['twig'] = function($c) {
            return new \Twig_Environment(new \Twig_Loader_Filesystem(array(
                $c['views_dir'],
                $c['vendor_twig_bridge_dir'] . '/Resources/views/Form',
            )));
        };
        
        $this->container['form_engine'] = function($c){
            $formEngine = new TwigRendererEngine(array($c['form_default_theme']));
            $formEngine->setEnvironment($c['twig']);
            return $formEngine;
        };

        $this->container['twig']->addExtension(new FormExtension(new TwigRenderer($this->container['form_engine'], null)));
        $this->container['twig']->addExtension(new TranslationExtension($this->container['translator']));

        $this->container['form_factory'] = function($c){
            return Forms::createFormFactoryBuilder()
                ->addExtension(new HttpFoundationExtension())
                ->getFormFactory();
        };
    }

    public function get($index) {
        return $this->container[$index];
    }

}
