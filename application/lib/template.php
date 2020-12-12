<?php

namespace Framework\lib;


class Template
{
    private $controller;
    private $action;
    private $title;
    private $description;
    private $og = array();
    private $view;
    private $views = array();
    private $data = array();

    public function __construct($controller, $action)
    {
        if (($action == FrontController::NOT_FOUND_ACTION)) {
            $this->view = VIEWS_DIR . 'notfound' . DS . 'notfound';
            $action = 'notfound';
        } else {
            $this->view = VIEWS_DIR . $controller . DS . $action;
        }

        $this->controller = $controller;
        $this->action = $action;
    }

    public function SetTitle($title)
    {
        if (!empty($title) && null !== $title) {
            $this->title = $title;
        }
        return $this;
    }

//    public function SetDescription($description)
//    {
//        if (!empty($description) && null !== $description) {
//            $this->description = $description;
//        }
//        return $this;
//    }

    public function SetData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function SetViews($views)
    {
        $this->views = $views;
        return $this;
    }

    public function Render()
    {
        if (!empty($this->views)) {
            if (!$this->title) {
                $this->title = ($this->controller == 'index' && $this->action == 'default') ? WEBSITE_NAME : WEBSITE_NAME . ' - ' . ucfirst($this->action);
            }
            if (!$this->og) {
                $this->og = array(
                    'description' => 'To give those who have lost someone for Coronavirus the opportunity to preserve their loved one\'s memory and tell stories by creating a free online memorial.',
                    'image' => IMG_PATH . 'fb-og.png'
                );
            }

            if ($this->data) { extract($this->data); }

            $head = ($this->controller == 'admin') ? 'admin-head.php' : 'head.php';
            $footer = ($this->controller == 'admin') ? 'admin-footer.php' : 'footer.php';

            require_once TEMPLATES_DIR . $head;
            foreach ($this->views as $value) {
                if ($value !== 'view') {
                    if (file_exists(TEMPLATES_DIR . $value . '.php')) {
                        require_once TEMPLATES_DIR . $value . '.php';
                    }
                } else {
                    if (file_exists($this->view . '.php')) {
                        require_once $this->view . '.php';
                    } else {
                        require_once VIEWS_DIR . 'notfound' . DS . 'notfound.php';
                    }
                }
            }
            require_once TEMPLATES_DIR . $footer;
        }
    }

    public function Highlight($menu)
    {
        if ($this->action == $menu) echo "active";
    }
}