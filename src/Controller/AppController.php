<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    private $company_types = array(1 => "Life", 2 => "Health");

    private $status = array(0 => "Inactive", 1 => "Active");

    private $modes = array(12 => "Annual", 6 => "Semi-Annual", 4 => "Trimestrial", 3 => 'Quarterly', 1 => 'Monthly');

    private $premium_status = array(1 => "Yes", 0 => "No");

    protected $session;

    protected $from;

    protected $to;

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        define('ROOT_DIREC', '/copassa');

        date_default_timezone_set("America/New_York");

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        $this->loadComponent('Auth', [
            'loginRedirect' => [
                'controller' => 'Policies',
                'action' => 'dashboard'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login']
        ]);

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }

    public function beforeFilter(EventInterface $event){
        $this->session = $this->getRequest()->getSession();
        if($this->Auth->user()){
            $this->from = $this->session->read("from")." 00:00:00";
            $this->to = $this->session->read("to")." 23:59:59";
            $this->initializeSessionVariables();
            $this->set("filterfrom", $this->session->read("from"));
            $this->set("filterto", $this->session->read("to"));
            $this->set('user_connected', $this->Auth->user());
            $this->set('company_types', $this->company_types);
            $this->set('status', $this->status);
            $this->set('premium_status', $this->premium_status);
            $this->set("modes", $this->modes);
        }
    }

    private function initializeSessionVariables(){
        if(empty($this->session->read("from"))){
            $this->session->write("from", date("Y-m-d"));
        }

        if(empty($this->session->read("to"))){
            $this->session->write("to", date("Y-m-d"));
        }
    }

    public function updateSessionVariables(){
        if ($this->request->is(['put', 'patch', 'post'])){
            if(!empty($this->request->getData()["from"])){
                $this->session->write("from", $this->request->getData()["from"]);
            }

            if(!empty($this->request->getData()["to"])){
                $this->session->write("to", $this->request->getData()["to"]);
            }
        }

        return $this->redirect($this->referer());
    }

    public function savelog($code, $comment, $status, $type, $old_data, $new_data){
        $this->loadModel('Logs'); 
        $log = $this->Logs->newEmptyEntity(); 
        $log->user_id = $this->Auth->user()['id']; 
        $log->comment = $comment; 
        $log->code = $code; 
        $log->status = $status;
        $log->type = $type; 
        $log->old_data = $old_data; 
        $log->new_data = $new_data; 
        $this->Logs->save($log); 
    }

}
