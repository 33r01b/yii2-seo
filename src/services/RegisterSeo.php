<?php
namespace zeroonebeatz\seo\services;

use yii\helpers\Url;
use yii\web\Controller;
use yii\db\ActiveRecord;

class RegisterSeo
{
    private $page;
    private $controller;

    function __construct(ActiveRecord $model, Controller $controller)
    {
        $this->page = $model;
        $this->controller = $controller;
    }

    public function register()
    {
        $this->registerTitle();
        $this->registerH1();
        $this->registerDescription();
        $this->registerKeywords();
        $this->registerCanonical();
    }

    protected function registerTitle()
    {
        $this->controller->view->title = $this->page->seo && !empty($this->page->seo->title)
            ? $this->page->seo->title
            : $this->page->title
        ;
    }

    protected function registerH1()
    {
        $this->controller->view->params['h1'] = $this->page->seo && !empty($this->page->seo->h1)
            ? $this->page->seo->h1
            : $this->page->title
        ;
    }

    protected function registerDescription()
    {
        $this->controller->view->registerMetaTag([
            'name' => 'description',
            'content' => $this->page->seo ? $this->page->seo->description : ''
        ]);
    }

    protected function registerKeywords()
    {
        $this->controller->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $this->page->seo ? $this->page->seo->keywords : ''
        ]);
    }

    protected function registerCanonical()
    {
        $this->controller->view->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()]);
    }
}