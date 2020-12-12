<?php

namespace Framework\lib;

use Framework\models\FeedbackModel;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;


//Load Composer's autoloader
require APPLICATION_DIR . 'vendor/autoload.php';

/**
 * Class AbstractController
 *
 * @package Framework\lib
 *
 * All the controllers classes extend this abstract controller which will contain the main methods needed by
 * the other controllers to operate.
 *
 * @author Shrief Mohamed
 */
class AbstractController
{
    /**
     * @var _controller
     * the name of the controller that got instantiated.
     */
    protected $_controller;
    /**
     * @var _action
     * the name of the action the user requested in the url.
     */
    protected $_action;
    /**
     * @var _params
     * the parameters passed in the url to be used later in the controller.
     */
    protected $_params;
    /**
     * @var _template
     *
     * Holds the new template object so we can access that object later at any controller and render some views
     */
    protected $_template;
    /**
     * @var visitor
     *
     * holds the visitor geo info to be able to access it anywhere in the controllers
     */
    protected $_visitor;

    protected $_language;

    public $logger;

    public function __construct()
    {
        // Set Log
        $dateFormat = "Y-m-d H:i:s a";
        $output = "[%datetime%] %channel%.%level_name%: %message% %context%*\n";
        $formatter = new LineFormatter($output, $dateFormat);

        $stream = new StreamHandler(LOG_FILE, Logger::DEBUG);
        $stream->setFormatter($formatter);

        $this->logger = new Logger('logs.Framework');
        $this->logger->pushHandler($stream);
        $this->logger->pushHandler(new FirePHPHandler());

        $this->SetLanguage_Texts();
    }

    /**
     * Method  NotFoundAction
     *
     * When we encounter an unknown class name (controller) or unknown action name we take the user to this method
     * to display a 404 not found.
     *
     * @author Shrief Mohamed
     */
    public function NotFoundAction()
    {
        $this->_template->SetViews(['header', 'view'])
            ->Render();
    }

    /**
     * Method  SetContActParam
     *
     * @param $controllerName
     * @param $action
     * @param $params
     *
     * inside of the front controller class where we first got the controller name and action name and params,
     * we use this method to:
     *  set these variables (the name of the controller and action and parameters)
     *  in case of we needed to use them here or inside any controller class,
     *  and of course inside the controller class we don't have access
     *  to the front controller class so this is the perfect way to parse these values from there to here, and
     *  to every controller we create.
     * after setting the controller and action and params, we call the method "initializeTemplate" in order to
     * create a new object from the class template, and place that object in the class property "_template" so it
     * would be accessible at any controller.
     *
     * @author Shrief Mohamed
     */
    public function SetContActParam($controllerName, $action, $params)
    {
        $this->_controller = $controllerName;
        $this->_action = $action;
        $this->_params = $params;

        $this->InitializeTemplate();
    }

    /**
     * Method  InitializeTemplate
     *
     *
     * Creates a new object from the class template, and place that object in the class property "_template" so it
     * would be accessible at any controller.
     *
     * @author Shrief Mohamed
     */
    public function InitializeTemplate()
    {
        $this->_template = new Template($this->_controller, $this->_action);
    }

    private function SetLanguage_Texts()
    {
        if (Session::CookieExists('language')) {
            // The lang is set, means user already has chosen lang.
            $this->_language = Session::GetCookie('language');
        } else {
            // Get browser language
            $lang = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : 'en';
            // If the language is supported, use it. Else use English as default.
            if (file_exists(CONFIG_DIR . $lang . '.php')) {
                Session::SetCookie('language', $lang, 2400);
                $this->_language = $lang;
            } else {
                // We do not have support for the browser language, use default EN
                Session::SetCookie('language', 'en', 2400);
                $this->_language = 'en';
            }
        }
        new Text($this->_language);
    }

    private function LogVisit()
    {
        $visit = new Geolocation;
        $visit->Initialize();
        $this->_visitor = $visit;

        if (!Session::CookieExists('visit')) {
            $logMessage = "visitor location details:: ";
            if ($this->_visitor->status !== 'success') {
                $logMessage .= "failed to get visitor location. ip: " . $this->_visitor->query . ' & message: ' . $this->_visitor->message;
            } else {
                foreach ($this->_visitor as $key => $value) {
                    $logMessage .= $key . ': ' . $value . ', ';
                }
            }
            $this->logger->info($logMessage);
            Session::SetCookie('visit', time(), 0.05);
        }


    }
}