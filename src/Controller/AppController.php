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
use Aws\S3\S3Client;
use Aws\Exception\AwsException;

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

    public $company_types = array(1 => "Life", 2 => "Health", 3 => "Travel");

    public $types = array(1 => 'Premium', 2 => 'Payment', 3 => 'Cancelation');

    public $status = array(0 => "Inactive", 1 => "Active");

    public $modes = array(12 => "A", 6 => "SA", 4 => "T", 3 => 'Q', 1 => 'M');

    public $premium_status = array(1 => "Yes", 0 => "No");

    public $sexe = array(1 => "Male", 2 => "Female", 3 => "Other"); 

    public $relations = array(1 => "Spouse", 2 => "Child", 3  => "Other");

    public $relationships = array(1 => "Spouse", 2 => "Child", 3  => "Other", 4 => "Employee");

    public $plans = array(1 => 'Open', 2 => 'Network');

    public $genders = array(1 => "Male", 2 => "Female", 3 => "Other");

    public $subscription_plans = array(1 => "Starter", 2 => "Essentials", 3  => "Plus", 4 => "Enterprise");

    protected $authorizations = [];

    protected $plan;

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

        // define("UPLOAD_DIR", '/home/xge55gjh6t1y/public_html/admin');
        define("UPLOAD_DIR", 'C:/wamp/www/ars_admin/webroot');

        define("S3_UPLOAD_DIR", 'C:/wamp/www/copassa/webroot');

        define("EMAIL_UPLOAD_DIR", 'C:/wamp/www/copassa/webroot');

        define("SHOW_UPLOAD_DIR", '/ars_admin');

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

        $this->Auth->authError = '';

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }

    private function getAuthorizations(){
        $user_id = $this->Auth->user()['id'];
        $result = [];
        $this->loadModel("Authorizations");
        $authorizations = $this->Authorizations->find("all");
        $user_authorizations = $this->Authorizations->find("all")->contain(['UsersAuthorizations'])->matching('UsersAuthorizations', function(\Cake\ORM\Query $q){
            return $q->where(['UsersAuthorizations.user_id' => $this->Auth->user()['id']]);
        });

        foreach($authorizations as $auth){
            $result[$auth->id] = false;
            foreach($user_authorizations as $ua){
                if($ua->id == $auth->id){
                    $result[$auth->id] = true;
                }
            }
        }
        $this->authorizations = $result;
        return $result;
    }

    public function addfile()
    {
        $this->loadModel("Files");
        $file = $this->Files->newEmptyEntity();
        if ($this->request->is('post')) {
            
            $folder = $this->Files->Folders->get($this->request->getData()['folder_id']);
            $uploaded_file = $this->request->getData('file');
            $name = $uploaded_file->getClientFilename();
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $document_name = rand(1000,500000).".".$extension;
            $type = $uploaded_file->getClientMediaType();
            $path = $uploaded_file->getStream()->getMetadata('uri');

            $file = $this->Files->patchEntity($file, $this->request->getData());
            $file->location = $this->upload_s3_file($path, $document_name, "/".$folder->name."/");

            if(!empty($this->request->getData()['policy_id'])){
                $file->policy_id = $this->request->getData()['policy_id'];
            }

            if(!empty($this->request->getData()['claim_id'])){
                $file->claim_id = $this->request->getData()['claim_id'];
            }

            if(!empty($this->request->getData()['renewal_id'])){
                $file->renewal_id = $this->request->getData()['renewal_id'];
            }

            $file->tenant_id = $this->Auth->user()['tenant_id'];
            $file->user_id = $this->Auth->user()['id'];
            $this->Files->save($file);
        }
        return $this->redirect($this->referer());
    }

    private function getPlan($tenant_id){
        $this->loadModel('Tenants');
        $this->plan = $this->Tenants->get($tenant_id)->plan;
    }

    public function beforeFilter(EventInterface $event){

        $this->session = $this->getRequest()->getSession();
        
        if (!$this->Auth->user()) {
            $this->Auth->setConfig('authError', false);
            return null;
        }
        if($this->Auth->user()){
            $this->getPlan($this->Auth->user()['tenant_id']);
            $this->set('plan_type', $this->plan);
            $this->set('subscription_plans', $this->subscription_plans);
            $year = date('Y');
            $next_year = $year + 1;
            $years = array($year => $year, $next_year => $next_year);
            $this->loadModel('Countries'); $this->loadModel('Tenants');
            $this->set("auths", $this->getAuthorizations());
            $this->from = $this->session->read("from")." 00:00:00";
            $this->to = $this->session->read("to")." 23:59:59";
            $this->initializeSessionVariables();
            $this->set("filterfrom", $this->session->read("from"));
            $this->set("filterto", $this->session->read("to"));
            $this->set("filter_country", $this->session->read("filter_country"));
            $this->set('user_connected', $this->Auth->user());
            $this->set('company_types', $this->company_types);
            $this->set('status', $this->status);
            $this->set('premium_status', $this->premium_status);
            $this->set("modes", $this->modes);
            $this->set('sexe', $this->sexe);
            $this->set('types', $this->types);
            $this->set("relations", $this->relations);
            $this->set("genders", $this->genders);
            $this->set("years", $years);
            $this->set("relationships", $this->relationships);
            $this->set('plans', $this->plans);
            // debug($this->Auth->user()); die();
            $this->set('tenant', $this->Tenants->get($this->Auth->user()['tenant_id']));
        }
    }

    private function initializeSessionVariables(){
        if(empty($this->session->read("from"))){
            $this->session->write("from", date("Y-m-d"));
        }

        if(empty($this->session->read("to"))){
            $this->session->write("to", date("Y-m-d"));
        }

        if(empty($this->session->read("filter_country"))){
            $this->session->write("filter_country", '');
        }
    }

    protected function upload_s3_file($file_path, $file_name, $folder_name){
        $this->loadModel('Tenants');
        $tenant = $this->Tenants->get($this->Auth->user()['tenant_id']);
        $this->paginate = [
            'contain' => ['Users'], 
        ];
        $key = 'AKIARDN5TTMS72EFD65R'; 
        $secret = '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';
        $s3Client = new S3Client([
            'region' => 'us-east-1',
            'version' => '2006-03-01',
            'http'    => [
                'verify' => false     
            ],
            'credentials' => [
                'key' => $key,
                'secret' => $secret,
            ]
        ]);

        $bucket = 'arsfiles';


        try {
            $result = $s3Client->putObject([
                'Bucket' => $bucket,
                'Key' => $tenant->bucket.$folder_name.$file_name,
                'SourceFile' => $file_path,
            ]);
        } catch (S3Exception $e) {
            echo $e->getMessage() . "\n";
        }

        return $tenant->bucket.$folder_name.$file_name;
    }

    public function updateSessionVariables(){
        if ($this->request->is(['put', 'patch', 'post'])){
            if(!empty($this->request->getData()["from"])){
                $this->session->write("from", $this->request->getData()["from"]);
            }

            if(!empty($this->request->getData()["to"])){
                $this->session->write("to", $this->request->getData()["to"]);
            }

            $this->session->write("filter_country", $this->request->getData()["filter_country"]);
        }

        return $this->redirect($this->referer());
    }

    public function savelog($code, $comment, $status, $type, $old_data, $new_data){
        $this->loadModel('Logs'); 
        $log = $this->Logs->newEmptyEntity(); 
        if(!empty($this->Auth->user()['id'])){
            $log->user_id = $this->Auth->user()['id']; 
        }
        
        $log->comment = $comment; 
        if(!empty($this->Auth->user()['tenant_id'])){
            $log->tenant_id = $this->Auth->user()['tenant_id']; 
        }
         
        $log->code = $code; 
        $log->status = $status;
        $log->type = $type; 
        $log->old_data = $old_data; 
        $log->new_data = $new_data; 
        $this->Logs->save($log); 
    }

    public function saveCA($country_id, $agent_id){
        $this->loadModel('CountriesAgents');

        $new = $this->CountriesAgents->newEmptyEntity();

        $new->country_id = $country_id; 
        $new->agent_id = $agent_id;
         
        $this->CountriesAgents->save($new); 
    }


    protected function checkfile($file, $name, $extensionn){
        $allowed_extensions = array('pdf', "xls", "xlsx", "doc", "docx");
        if(!$file['error']){
            $extension = explode("/", $file['type'])[1];
            // $dossier = '/home/jugi71qiqj1g/public_html'.ROOT_DIREC.'/webroot/tmp/files/';
            $dossier = 'C:/wamp/www'.ROOT_DIREC.'/webroot/tmp/files/';
            if($extensionn == 2){
                if(move_uploaded_file($file['tmp_name'], $dossier . $name . ".xlsx")){
                return $name . ".xlsx";
            }else{
                return "move failed";
            }
            }else{
                if(move_uploaded_file($file['tmp_name'], $dossier . $name . "." . $extension)){
                return $name . "." . $extension;
            }else{
                return "move failed";
            }
        }
            
        }else{
            return "general error";
        }
    }
}
