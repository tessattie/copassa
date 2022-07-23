<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use PHPExcel; 
use PHPExcel_IOFactory;
use PHPExcel_Style_Border;
use PHPExcel_Worksheet_PageSetup;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Fill;
use PHPExcel_Cell_DataValidation;
use PHPExcel_Writer_Excel7;

/**
 * Customers Controller
 *
 * @property \App\Model\Table\CustomersTable $Customers
 * @method \App\Model\Entity\Customer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CustomersController extends AppController
{

    public function beforeFilter(EventInterface $event){
        parent::beforeFilter($event);
        $this->set('area_codes', $this->Customers->area_codes);
    }

    public function authorize(){
        if($this->Auth->user()['role_id'] == 2){

            if($this->request->getParam('action') == 'index' && ($this->authorizations[23] || $this->authorizations[24])){
                return true;
            }

            if($this->request->getParam('action') == 'view' && ($this->authorizations[23] || $this->authorizations[24])){
                return true;
            }

            if($this->request->getParam('action') == 'add' && $this->authorizations[24]){
                return true;
            }

            if($this->request->getParam('action') == 'edit' && $this->authorizations[24]){
                return true;
            }

            if($this->request->getParam('action') == 'delete' && $this->authorizations[24]){
                return true;
            }

            return false;

        }else{

            return true;

        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->savelog(200, "Accessed policy holder page", 1, 3, "", "");
        $filter_country = $this->session->read("filter_country");
          $customers = $this->Customers->find("all", array('conditions' => array('Customers.tenant_id' => $this->Auth->user()['tenant_id'])))->contain(['Users', 'Countries', 'Notes', 'Policies' => 'Companies']);  

        $this->set(compact('customers', 'filter_country'));
    }

    /**
     * View method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $customer = $this->Customers->get($id, [
            'contain' => ['Notes' => ['sort' => 'Notes.created DESC', 'Users'], 'Countries', 'Users', 'Payments' => ['Users', 'Rates', 'Policies'], 'Policies' => ['Companies', 'Options', 'Users', 'Claims' => ['ClaimsTypes']]],
        ]);
        $note = $this->Customers->Notes->newEmptyEntity();
        $policies = $this->Customers->Policies->find("list", array("conditions" => array("tenant_id" => $this->Auth->user()['tenant_id'], 'customer_id' => $id)));

        $this->set(compact('customer', 'note', 'policies'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $customer = $this->Customers->newEmptyEntity();
        if ($this->request->is('post')) {
            $customer = $this->Customers->patchEntity($customer, $this->request->getData());
            $customer->user_id = $this->Auth->user()['id'];
            $customer->tenant_id = $this->Auth->user()['tenant_id'];
            if ($ident = $this->Customers->save($customer)) {
                $this->savelog(200, "Created policy holder", 1, 1, "", json_encode($customer));
                $this->Flash->success(__('The policy holder has been saved.'));

                return $this->redirect(['controller' => 'policies', 'action' => 'add', $ident['id']]);
            }
            $this->savelog(500, "Tempted to create policy holder", 0, 1, "", json_encode($customer));
            $this->Flash->error(__('The policy holder could not be saved. Please, try again.'));
        }
        $countries = $this->Countries->find("list", array("order" => array("name ASC")));
        $this->set(compact('customer', 'countries'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $customer = $this->Customers->get($id, [
            'contain' => ['Policies' => ['Users', 'Companies', 'Options']]
        ]);
        $old_data = json_encode($customer);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customer = $this->Customers->patchEntity($customer, $this->request->getData());
            if ($this->Customers->save($customer)){
                $this->savelog(200, "Edited policy holder", 1, 2, $old_data, json_encode($customer));
                $this->Flash->success(__('The customer has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->savelog(500, "Tempted to edit policy holder", 0, 2, $old_data, json_encode($customer));
            $this->Flash->error(__('The customer could not be saved. Please, try again.'));
        }
        $countries = $this->Countries->find("list");
        $agents = $this->Customers->Agents->find("all", array("order" => array("name ASC"), "conditions" => array("Agents.tenant_id" => $this->Auth->user()['tenant_id'])))->contain(['CountriesAgents']);
            $result = [];
            foreach($agents as $agent){
                foreach($agent->countries_agents as $ca){
                    if($ca->country_id == $customer->country_id){
                        $result[$agent->id] = $agent->name;
                    }
                }
            }
        $this->set(compact('customer', 'countries'));$this->set('agents', $result);
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $customer = $this->Customers->get($id);
        if ($this->Customers->delete($customer)) {
            $this->Flash->success(__('The customer has been deleted.'));
        } else {
            $this->Flash->error(__('The customer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    

    public function report(){
        
    }

    public function import(){

    }

    public function generate(){
        require_once(ROOT . DS . 'vendor' . DS  . 'PHPExcel'  . DS . 'Classes' . DS . 'PHPExcel.php');
        require_once(ROOT . DS . 'vendor' . DS  . 'PHPExcel'  . DS . 'Classes' . DS . 'PHPExcel' . DS . 'IOFactory.php');

        $excel = new PHPExcel();
        
        $excel->setActiveSheetIndex(0);
        $excel->getActiveSheet()->setTitle('Policies');

        // // Area Codes
        // $excel->createSheet(1);
        // $excel->setActiveSheetIndex(1);
        // $excel->getActiveSheet()->setTitle('Area Codes');

        $sheet = $excel->getActiveSheet();
        $area_codes = $this->Customers->area_codes;
        $i = 1;

        $area_codes_config = ''; 

        foreach($area_codes as $code){
            $area_codes_config.= $code.', ';
        }

        $area_codes_config = trim($area_codes_config, ", ");

        // debug($area_codes_config); die();

        $configs = 'A,B,C,D';

        $sheet->setCellValue('B5', "SELECT")
            ;

        $cell = $sheet->getCell('B5')->getDataValidation();
        $cell->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
        $cell->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
        $cell->setAllowBlank(false);
        $cell->setShowInputMessage(true);
        $cell->setShowErrorMessage(true);
        $cell->setShowDropDown(true);
        $cell->setErrorTitle('Input error');
        $cell->setError('Value is not in list.');
        $cell->setPromptTitle('Pick from list');
        $cell->setPrompt('Please pick a value from the drop-down list.');
        $cell->setFormula1('"'.$area_codes_config.'"');

        $file = 'import_template.xlsx';
        $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$file.'"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        die();
    }
}
