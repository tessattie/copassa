<?php
declare(strict_types=1);

namespace App\Controller;

use FPDF;

/**
 * Policies Controller
 *
 * @property \App\Model\Table\PoliciesTable $Policies
 * @method \App\Model\Entity\Policy[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PoliciesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->savelog(200, "Accessed policies page", 1, 3, "", "");
        $filter_country = $this->session->read("filter_country");
        if(!empty($filter_country)){
           $policies = $this->Policies->find("all", array("conditions" => array("pending_business" => 2, 'Policies.tenant_id' => $this->Auth->user()['tenant_id'])))->contain(['Companies', 'Options', 'Customers' => ['Countries']])->matching('Customers', function ($q) use ($filter_country) {
                return $q->where(['Customers.country_id' => $filter_country]);
            }); 
        }else{
           $policies = $this->Policies->find("all", array("conditions" => array("pending_business" => 2, 'Policies.tenant_id' => $this->Auth->user()['tenant_id'])))->contain(['Companies', 'Options', 'Customers' => ['Countries']]); 
        }

        $this->set(compact('policies'));
    }


    public function pendingbusiness()
    {
        $this->savelog(200, "Accessed Pending Business page", 1, 3, "", "");
        $filter_country = $this->session->read("filter_country");
        if(!empty($filter_country)){
           $policies = $this->Policies->find("all", array("conditions" => array("pending_business" => 1)))->contain(['Companies', 'Options', 'Customers' => ['Countries']])->matching('Customers', function ($q) use ($filter_country) {
                return $q->where(['Customers.country_id' => $filter_country]);
            }); 
        }else{
           $policies = $this->Policies->find("all", array("conditions" => array("pending_business" => 1)))->contain(['Companies', 'Options', 'Customers' => ['Countries']]); 
        }

        $this->set(compact('policies'));
    }

    public function dashboard(){
        $this->loadModel("Newborns");
        $newborns = $this->Newborns->find('all', array("conditions" => array("Newborns.status" => 1, 'Newborns.tenant_id' => $this->Auth->user()['tenant_id']), "order" => array('Newborns.created ASC')))->contain(['Policies' => ['Customers' => ['Countries'], 'Companies', 'Options'], 'Users']);

        $this->loadModel("Pendings");

        $pendings = $this->Pendings->find("all", array("conditions" => array("Pendings.tenant_id" => $this->Auth->user()['tenant_id'])))->contain(['Companies', 'Options', 'Countries', 'Users']);
        $all_birthdays = $this->Policies->Customers->find("all", array("conditions" => array("Customers.tenant_id" => $this->Auth->user()['tenant_id'])))->contain(['Policies']);
        $birthdays = array();
        foreach($all_birthdays as $bd){
            if(!empty($bd->dob)){
                if($bd->dob->month == date("m") && $bd->dob->day == date('d')){
                array_push($birthdays, $bd);
            }
            }
            
        }

        $this->set(compact('newborns', 'birthdays', 'pendings'));
    }

    /**
     * View method
     *
     * @param string|null $id Policy id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->loadModel('Riders');
        
        if($this->request->is(['patch', 'put', 'post'])){
            $this->updateriders($this->request->getData()['policy_id'], $this->request->getData()['has_rider']);
        }

        $policy = $this->Policies->get($id, [
            'contain' => ['Companies', 'Options', 'Customers', 'Users', 'Payments', 'Dependants', 'PoliciesRiders' => ['Riders']],
        ]);
        $riders = $this->Riders->find("all");
        $dependant = $this->Policies->Dependants->newEmptyEntity();

        $this->set(compact('policy', 'dependant', 'riders'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($customer_id = false)
    {
        $policy = $this->Policies->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $certificate = $this->request->getData('certificate');
            $name = $certificate->getClientFilename();
            $type = $certificate->getClientMediaType();
            $targetPath = WWW_ROOT. 'img'. DS . 'certificates'. DS. $name;
            if (!empty($name)) {
                if ($certificate->getSize() > 0 && $certificate->getError() == 0) {
                    $certificate->moveTo($targetPath); 
                    $data['certificate'] = $name;
                }
            }else{
                $data['certificate'] = '';
            }
            $policy = $this->Policies->patchEntity($policy, $data);
            $policy->user_id = $this->Auth->user()['id'];
            $policy->paid_until = date("Y-m-d");
            $policy->tenant_id = $this->Auth->user()['tenant_id'];
            $customer = $this->Policies->Customers->get($policy->customer_id);
            if ($this->Policies->save($policy)) {
                $this->savelog(200, "Created policy for customer: ".$customer->name, 1, 1, "", json_encode($policy));
                $this->Flash->success(__('The policy has been saved.'));
                return $this->redirect(['controller' => 'Customers', 'action' => 'edit', $policy->customer_id]);
            }
            $this->savelog(500, "Tempted to create policy for customer: ".$customer->name, 0, 1, "", json_encode($policy));
            $this->Flash->error(__('The policy could not be saved. Please, try again.'));
        }
        $companies = $this->Policies->Companies->find('list', ['order' => ['name ASC'], 'conditions' => ['tenant_id' => $this->Auth->user()['tenant_id']]]);
        $customers = $this->Policies->Customers->find('list', ['order' => ['name ASC'], 'conditions' => ['tenant_id' => $this->Auth->user()['tenant_id']]]);
        $this->set(compact('policy', 'companies', 'customers', 'customer_id'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Policy id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $policy = $this->Policies->get($id, [
            'contain' => [],
        ]);
        $old_data = json_encode($policy);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $certificate = $this->request->getData('certificate');
            $name = $certificate->getClientFilename();
            $type = $certificate->getClientMediaType();
            $targetPath = WWW_ROOT. 'img'. DS . 'certificates'. DS. $name;
            if (!empty($name)) {
                if ($certificate->getSize() > 0 && $certificate->getError() == 0) {
                    $certificate->moveTo($targetPath); 
                    $data['certificate'] = $name;
                }else{
                        $data['certificate'] = $policy->certificate;
                }
            }else{
                $data['certificate'] = $policy->certificate;
            }
            $policy = $this->Policies->patchEntity($policy, $data);
            if ($this->Policies->save($policy)) {
                $this->savelog(200, "Edited policy : ".$policy->policy_number, 1, 2, $old_data, json_encode($policy));
                $this->Flash->success(__('The policy has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->savelog(500, "Tempted to edit policy : ".$policy->policy_number, 0, 2, $old_data, json_encode($policy));
            $this->Flash->error(__('The policy could not be saved. Please, try again.'));
        }
        $companies = $this->Policies->Companies->find('list', ['limit' => 200]);
        $options = $this->Policies->Options->find('list', [
            'keyField' => 'id',
            'valueField' => function ($option) {
                return $option->get('full');
            }, 
            'conditions' => array('company_id' => $policy->company_id)
        ]);
        $customers = $this->Policies->Customers->find('list', array("order" => array("name ASC")));
        $users = $this->Policies->Users->find('list');
        $this->set(compact('policy', 'companies', 'options', 'customers', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Policy id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $policy = $this->Policies->get($id);
        if ($this->Policies->delete($policy)) {
            $this->Flash->success(__('The policy has been deleted.'));
        } else {
            $this->Flash->error(__('The policy could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function report(){
        // Set Dates
        $from = $this->session->read("from"); 
        $to = $this->session->read("to");
        $type_filter="9999";
        $company_filter = "9999";
        // Get each company 
        $comps = $this->Policies->Companies->find("list", array("conditions" => array("Companies.tenant_id" => $this->Auth->user()['tenant_id'])));
        
        if($this->request->is(['patch', 'put', 'post'])){
            if(!empty($this->request->getData()['type'])){
                $type_filter = $this->request->getData()['type'];
            }
            if(!empty($this->request->getData()['company_id'])){
                $company_filter = $this->request->getData()['company_id'];
            }
            $companies = $this->getPolicies($this->request->getData()['type'], $this->request->getData()['company_id']);
        }else{
            $companies = $this->Policies->Companies->find("all", array("conditions" => array("Companies.tenant_id" => $this->Auth->user()['tenant_id']), "order" => array("Companies.name ASC")))->contain(['Countries']);
            foreach($companies as $company){
                $filter_country = $this->session->read("filter_country");
                
                if(!empty($filter_country)){
                    $company->policies = $this->Policies->find("all", array("conditions" => array("Policies.company_id" => $company->id, 'Policies.tenant_id' => $this->Auth->user()['tenant_id'], 'pending_business' => 2, "OR" => array("last_renewal >= '". $from."' AND last_renewal <= '". $to."'", "next_renewal >= '". $from."' AND next_renewal <= '". $to."'")), "order" => array("paid_until ASC")))->contain(['Customers', 'Options', 'Payments'])->matching('Customers', function ($q) use ($filter_country) {
                        return $q->where(['Customers.country_id' => $filter_country]);
                    });
                }else{
                    $company->policies = $this->Policies->find("all", array("conditions" => array("Policies.company_id" => $company->id, 'Policies.tenant_id' => $this->Auth->user()['tenant_id'], 'pending_business' => 2, "OR" => array("last_renewal >= '". $from."' AND last_renewal <= '". $to."'", "next_renewal >= '". $from."' AND next_renewal <= '". $to."'")), "order" => array("paid_until ASC")))->contain(['Customers', 'Options', 'Payments']);
                }
                
            }
        }
        
        $this->set(compact("companies", 'comps', 'type_filter', 'company_filter', 'from'));
    }

    public function alerts(){
        
    }


    public function renewals(){
        $policies = $this->Policies->find("all", array("conditions" => array("tenant_id" => $this->Auth->user()['tenant_id'])));
        foreach($policies as $policy){
            $paid_until = $policy->paid_until->year."-".$policy->paid_until->month."-".$policy->paid_until->day;
            if($paid_until >= date("Y-m-d")){
                // next renewal = paid until
                $policy->next_renewal = $policy->paid_until;
                // calculate last renewal thanks to paid until

                $date = new \Datetime($paid_until);
                $months = $policy->mode; 
                $date->modify('-'.$months.' month');
                $policy->last_renewal = $date;
            }else{
                // last_renewal = paid_until
                $policy->last_renewal = $paid_until;
                $date = new \Datetime($paid_until);
                $months = $policy->mode; 
                $date->modify('+'.$months.' month');
                $policy->next_renewal = $date; 
                // calculate next renewal 
            }
            $this->Policies->save($policy);
        }

        die("done");
    }

    private function updateriders($policy, $riders){
        $this->loadModel('PoliciesRiders'); 
        // delete old riders
        $pr = $this->PoliciesRiders->find("all", array('conditions' => array("policy_id" => $policy))); 
        foreach($pr as $p){
            $this->PoliciesRiders->delete($p);
        }
        // create new entity for the riders and save them
        foreach($riders as $key => $rider){
            $new = $this->PoliciesRiders->newEmptyEntity();
            $new->policy_id = $policy; 
            $new->rider_id = $rider;
            $this->PoliciesRiders->save($new);
        }
    }

    public function export($type, $company_id){
        $from = $this->session->read("from"); 
        $to = $this->session->read("to"); 
        if($type == '9999'){
            $type = false;
        }

        if($company_id == '9999'){
            $company_id = false;
        }

        $companies = $this->getPolicies($type, $company_id);


        require_once(ROOT . DS . 'vendor' . DS  . 'fpdf'  . DS . 'fpdf.php');
        
        $fpdf = new FPDF();
        $fpdf->AddPage("L");
        $fpdf->SetFont('Arial','B',9);
        $fpdf->Cell(200,0,"Renewals Report",0,0, 'L');
        $fpdf->Cell(75,0,"From " . date("M d Y", strtotime($from)) . " to " . date("M d Y", strtotime($to)) ,0,0, 'R');
        $fpdf->Ln(7);
        $fpdf->Cell(275,0,"",'B',0, 'R');
        $fpdf->Ln(5);
        $filter_country = $this->session->read("filter_country");
        // do export
        foreach($companies as $company){
            if($company->policies->count() > 0){
                $fpdf->SetFont('Arial','B',8);
                $fpdf->SetFillColor(220,220,220);
                $fpdf->Cell(275,7,$company->name,"T-L-R",0, 'L', 1);
                $fpdf->SetFillColor(255,255,255);
                $fpdf->Ln(7);
                $fpdf->Cell(64,7,"Insured Name",'T-L-B',0, 'L');
                $fpdf->Cell(10,7,"Age",'T-L-B',0, 'C');
                $fpdf->Cell(29,7,"Policy",'T-L-B',0, 'C');
                $fpdf->Cell(55,7,"Plan",'T-L-B',0, 'C');
                $fpdf->Cell(10,7,"Mode",'T-L-B',0, 'C');
                $fpdf->Cell(25,7,"L Premium",'T-L-B',0, 'C');
                $fpdf->Cell(25,7,"Premium",'T-L-B',0, 'C');
                $fpdf->Cell(15,7,"%",'T-L-B',0, 'C');
                $fpdf->Cell(22,7,"Effective Date",'T-L-B',0, 'C');
                $fpdf->Cell(20,7,"Due Date",'T-L-R-B',0, 'C');
                $fpdf->Ln(7);
                $fpdf->SetFont('Arial','',8);
                foreach($company->policies as $policy){
                    $percentage = ""; 
                    if(!empty($policy->last_premium)){
                        $percentage = ($policy->premium - $policy->last_premium)*100/$policy->last_premium;
                        $percentage = number_format($percentage, 2, ".",",");
                        $percentage .="%";
                    }
                    $paid_until = $policy->paid_until->year."-".$policy->paid_until->month."-".$policy->paid_until->day;
                    $effective_date = $policy->effective_date->year."-".$policy->effective_date->month."-".$policy->effective_date->day;
                    $next_renewal = $policy->next_renewal->year."-".$policy->next_renewal->month."-".$policy->next_renewal->day;
                    $last_renewal = $policy->last_renewal->year."-".$policy->last_renewal->month."-".$policy->last_renewal->day;
                    $age = "";
                    if(!empty($policy->customer->dob)){
                        $dob = $policy->customer->dob->year."-".$policy->customer->dob->month."-".$policy->customer->dob->day;
                        $today = date("Y-m-d");
                        $diff = date_diff(date_create($dob), date_create($today));
                        $age = $diff->format('%y');
                    }
                    if(date("Y-m-d", strtotime($next_renewal)) >= $to){
                        $fpdf->SetFillColor(255,250,205);
                    }else{
                        $fpdf->SetFillColor(255,255,255);
                    }

                    $fpdf->Cell(64,7,$policy->customer->name,'T-L-B',0, 'L',1);
                    $fpdf->Cell(10,7,$age,'T-L-B',0, 'C',1);
                    $fpdf->Cell(29,7,$policy->policy_number,'T-L-B',0, 'C',1);
                    $fpdf->Cell(55,7,$policy->option->name." / ".$policy->option->option_name,'T-L-B',0, 'C',1);
                    $fpdf->Cell(10,7,$this->modes[$policy->mode],'T-L-B',0, 'C',1);
                    $fpdf->Cell(25,7,number_format(($policy->last_premium+$policy->fee), 2, ".", ",") ."USD",'T-L-B',0, 'C',1);
                    $fpdf->Cell(25,7,number_format(($policy->premium+$policy->fee), 2, ".", ",") ."USD",'T-L-B',0, 'C',1);
                    $fpdf->Cell(15,7,$percentage,'T-L-B',0, 'C',1);
                    $fpdf->Cell(22,7,date('M d Y', strtotime($effective_date)),'T-L-B',0, 'C',1);
                    $fpdf->Cell(20,7,date('M d Y', strtotime($next_renewal)),'T-L-R-B',0, 'C',1);
                    $fpdf->Ln(7);
                }
            }
            $fpdf->Ln(7); 
        }
        $fpdf->Output('I');
        die();
    }

    private function getPolicies($type = false, $company_id = false){
        $filter_country = $this->session->read("filter_country");
        $from = $this->session->read("from"); 
        $from = date("Y-m-d", strtotime($from." -1 day"));
        $to = $this->session->read("to");
        $to = date("Y-m-d", strtotime($to." -1 day"));
        if(!empty($type)){
            if(!empty($company_id)){
                $company_filter = $this->request->getData()['company_id'];
                $companies = $this->Policies->Companies->find("all", array("conditions" => array("type" => $type, "id" => $company_id, "tenant_id" => $this->Auth->user()['tenant_id']), "order" => array("name ASC")));
            }else{
                $companies = $this->Policies->Companies->find("all", array("conditions" => array("type" => $type, 'tenant_id' => $this->Auth->user()['tenant_id']), "order" => array("name ASC")));
            }
        }else{
            if(!empty($company_id)){
                $companies = $this->Policies->Companies->find("all", array("conditions" => array("id" => $company_id, 'tenant_id' => $this->Auth->user()['tenant_id']), "order" => array("name ASC")));
            }else{
                $companies = $this->Policies->Companies->find("all", array("conditions" => array('tenant_id' => $this->Auth->user()['tenant_id']), "order" => array("name ASC")));
            }
        }

        foreach($companies as $company){
            if(!empty($filter_country)){
                    $company->policies = $this->Policies->find("all", array("conditions" => array("Policies.company_id" => $company->id, "Policies.tenant_id" => $this->Auth->user()['tenant_id'], 'pending_business' => 2, "OR" => array("last_renewal >= '". $from."' AND last_renewal <= '". $to."'", "next_renewal >= '". $from."' AND next_renewal <= '". $to."'")), "order" => array("paid_until ASC")))->contain(['Customers', 'Options', 'Payments'])->matching('Customers', function ($q) use ($filter_country) {
                        return $q->where(['Customers.country_id' => $filter_country]);
                    });
                }else{
                    $company->policies = $this->Policies->find("all", array("conditions" => array("Policies.company_id" => $company->id, "Policies.tenant_id" => $this->Auth->user()['tenant_id'], 'pending_business' => 2, "OR" => array("last_renewal >= '". $from."' AND last_renewal <= '". $to."'", "next_renewal >= '". $from."' AND next_renewal <= '". $to."'")), "order" => array("paid_until ASC")))->contain(['Customers', 'Options', 'Payments']);
                }
        }
        return $companies;
    }


    public function update(){
        $this->savelog(200, "Accessed policies update page", 1, 3, "", "");

        if($this->request->is(['patch', 'put', 'post'])){
            // debug($this->request->getData()); die();
            $data = $this->request->getData();
            foreach($data['policy_id'] as $i => $id){
                $policy = $this->Policies->get($id); 
                $policy->last_premium = $data['last_premium'][$i]; 
                $policy->premium = $data['premium'][$i];
                $policy->last_renewal = $data['last_renewal'][$i];
                $policy->next_renewal = $data['next_renewal'][$i];
                $this->Policies->save($policy);
            }

            unset($this->request->getData()['last_renewal']);
            unset($this->request->getData()['next_renewal']);
            unset($this->request->getData()['last_premium']);
            unset($this->request->getData()['premium']);
            unset($this->request->getData()['policy_id']);
        }
        
        $companies = $this->Policies->Companies->find("all");
        $policies = $this->Policies->find("all", array("conditions" => array("Policies.tenant_id" => $this->Auth->user()['tenant_id']), "order" => array("Policies.company_id ASC")))->contain(['Companies', 'Options', 'Customers', 'Users']);

        $this->set(compact('policies', 'companies'));
    }


    public function list(){
        if($this->request->is(['ajax'])){
            $policies = $this->Policies->find("all", array("conditions" => array("tenant_id" => $this->Auth->user()['tenant_id'], "customer_id" => $this->request->getData()['customer_id'])));
            echo json_encode($policies->toArray()); 
        }
        die();
    }
}
