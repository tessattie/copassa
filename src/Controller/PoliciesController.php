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
           $policies = $this->Policies->find("all", array("conditions" => array('Policies.tenant_id' => $this->Auth->user()['tenant_id'])))->contain(['Companies', 'Options', 'Customers' => ['Countries'], 'Prenewals', 'Dependants'])->matching('Customers', function ($q) use ($filter_country) {
                return $q->where(['Customers.country_id' => $filter_country]);
            }); 
        }else{
           $policies = $this->Policies->find("all", array("conditions" => array("pending_business" => 2, 'Policies.tenant_id' => $this->Auth->user()['tenant_id'])))->contain(['Companies', 'Options', 'Customers' => ['Countries'], 'Prenewals', 'Dependants']); 
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
        $this->loadModel("Newborns");$this->loadModel("Pendings");$this->loadModel("Transactions");$this->loadModel("Claims");

        $new_business_date = date("Y-m-d", strtotime("-1 year")); 

        $claims = $this->Claims->find("all", array("conditions" => array("Claims.tenant_id" => $this->Auth->user()['tenant_id'], 'Claims.status' => 1)))->contain(['Policies' => ['Customers'], 'ClaimsTypes']);

        $newborns = $this->Newborns->find('all', array("conditions" => array("Newborns.status" => 1, 'Newborns.tenant_id' => $this->Auth->user()['tenant_id']), "order" => array('Newborns.created ASC')))->contain(['Policies' => ['Customers' => ['Countries'], 'Companies', 'Options'], 'Users']);

        $pendings = $this->Pendings->find("all", array("conditions" => array("Pendings.tenant_id" => $this->Auth->user()['tenant_id'], 'Pendings.status' => 1)))->contain(['Companies', 'Options', 'Countries', 'Users']);

        $newBusiness = $this->Policies->find("all", array("conditions" => array('Policies.tenant_id' => $this->Auth->user()['tenant_id'], 'effective_date >=' => $new_business_date)))->contain(['Customers' => ['Countries'], 'Companies', 'Options']);

        $transactions = $this->Transactions->find("all", array("conditions" => array("Transactions.status" => 1, 'Transactions.tenant_id' => $this->Auth->user()['tenant_id'])))->contain(['Employees', 'Families', 'Groupings', 'Renewals' => ['Businesses']]);

        $all_birthdays = $this->Policies->Customers->find("all", array("conditions" => array("Customers.tenant_id" => $this->Auth->user()['tenant_id'])))->contain(['Policies']);

        $birthdays = array();
        
        foreach($all_birthdays as $bd){
            if(!empty($bd->dob)){
                if($bd->dob->month == date("m") && $bd->dob->day == date('d')){
                array_push($birthdays, $bd);
            }
            }
            
        }
        $this->set(compact('newborns', 'birthdays', 'pendings', 'transactions', 'newBusiness', 'claims'));
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
            'contain' => ['Companies', 'Options', 'Customers', 'Users', 'Payments', 'Dependants', 'Prenewals', 'Claims' => ['ClaimsTypes'], 'PoliciesRiders' => ['Riders']],
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

    public function adddependant(){
        if($this->request->is(['patch', 'put', 'post'])){
            $this->loadModel("Newborns");
            // update newborn status
            $newborn = $this->Newborns->get($this->request->getData()['newborn_id']);
            $newborn->status = 2; 
            $this->Newborns->save($newborn); 

            $this->loadmodel('Dependants'); 
            $dependant = $this->Dependants->newEmptyEntity(); 
            $dependant->name = $this->request->getData()['name'];
            $dependant->tenant_id = $this->Auth->user()['tenant_id'];
            $dependant->sexe = $this->request->getData()['sexe'];
            $dependant->relation = $this->request->getData()['relation'];
            $dependant->dob = $this->request->getData()['dob'];
            $dependant->limitations = $this->request->getData()['limitations'];
            $dependant->policy_id = $this->request->getData()['policy_id'];
            $dependant->user_id = $this->Auth->user()['id'];
            $this->Dependants->save($dependant);
            // add dependant
        }

        return $this->redirect(['action' => 'dashboard']);
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
        $comps = $this->Policies->Companies->find("list", array("order" => array("name ASC"), "conditions" => array("Companies.tenant_id" => $this->Auth->user()['tenant_id'])));
        $companies = $this->Policies->Companies->find("all", array("order" => array("name ASC"), "conditions" => array("Companies.tenant_id" => $this->Auth->user()['tenant_id'])));
        if($this->request->is(['patch', 'put', 'post'])){
            if(!empty($this->request->getData()['type'])){
                $type_filter = $this->request->getData()['type'];
                $companies->where(['type' => $type_filter]);
            }
            if(!empty($this->request->getData()['company_id'])){
                $company_filter = $this->request->getData()['company_id'];
                $companies->where(['id' => $company_filter]);
            }
            // $companies = $this->getPolicies($this->request->getData()['type'], $this->request->getData()['company_id']);
        }

        $renewals = $this->Policies->Prenewals->find("all", array("conditions" => array("renewal_date >=" => $from, "renewal_date <=" => $to,"Prenewals.tenant_id" => $this->Auth->user()['tenant_id'])))->contain(['Policies' => ['Companies', 'Options', 'Customers']]);
        foreach($renewals as $renewal){
            $renewal->last_renewal = $this->Policies->Prenewals->find("all", array("order" => array("renewal_date DESC"), "conditions" => array("Prenewals.tenant_id" => $this->Auth->user()['tenant_id'], "Prenewals.id <>" => $renewal->id, 'Prenewals.policy_id' => $renewal->policy_id)))->first();
        }
        
        $this->set(compact("renewals", 'comps', 'type_filter', 'company_filter', 'from', 'companies'));
    }

    public function alerts(){
        
    }

    public function listing(){
        $this->savelog(200, "Accessed policies page", 1, 3, "", "");

        $type = 'ZZZZ';
        $country_id = 'ZZZZ';
        $company_id = 'ZZZZ';
        $mode = 'ZZZZ';
        $young_policies = 0;

        $policies = $this->Policies->find("all", array("conditions" => array("pending_business" => 2, 'Policies.tenant_id' => $this->Auth->user()['tenant_id'])))->contain(['Companies', 'Options', 'Customers' => ['Countries'], 'Prenewals', 'Dependants']); 

        if($this->request->is(['patch', 'put', 'post'])){
            // country
            if(!empty($this->request->getData()['country_id'])){
                $country_id = $this->request->getData()['country_id'];
                $policies->matching('Customers', function ($q) use ($country_id) {
                    return $q->where(['Customers.country_id' => $country_id]);
                });
            }

            // type
            if(!empty($this->request->getData()['type'])){
                $type = $this->request->getData()['type'];
                $policies->matching('Companies', function ($q) use ($type) {
                    return $q->where(['Companies.type' => $type]);
                });
            }

            // company
            if(!empty($this->request->getData()['company_id'])){
                $company_id = $this->request->getData()['company_id'];
                $policies->where(['Policies.company_id' => $company_id]);
            }

            // young policies
            if(!empty($this->request->getData()['young_policies'])){
                $young_policies = $this->request->getData()['young_policies'];
                $policies->where(['Policies.effective_date >' => date("Y-m-d", strtotime("-1 year"))]);
            }

            // mode
            if(!empty($this->request->getData()['mode'])){
                $mode = $this->request->getData()['mode'];
                $policies->where(['Policies.mode' => $mode]);
            }
        }
        

        $companies = $this->Policies->Companies->find("list", array("order" => array("name ASC"), "conditions" => array("Companies.tenant_id" => $this->Auth->user()['tenant_id'])));

        $this->set(compact('policies', 'companies', 'type', 'company_id', 'mode', 'country_id', 'young_policies'));
    }

    public function exportlisting($country_id, $company_id, $type, $mode, $young_policies){

        $modes = array(12 => "A", 6 => "SA", 4 => "T", 3 => 'Q', 1 => 'M');

        $policies = $this->Policies->find("all", array("conditions" => array("pending_business" => 2, 'Policies.tenant_id' => $this->Auth->user()['tenant_id'])))->contain(['Companies', 'Options', 'Customers' => ['Countries'], 'Prenewals', 'Dependants']); 
        // country
        if($country_id != 'ZZZZ'){
            $policies->matching('Customers', function ($q) use ($country_id) {
                return $q->where(['Customers.country_id' => $country_id]);
            });
        }

        // type
        if($type != 'ZZZZ'){
            $policies->matching('Companies', function ($q) use ($type) {
                return $q->where(['Companies.type' => $type]);
            });
        }

        // company
        if($company_id != 'ZZZZ'){
            $policies->where(['Policies.company_id' => $company_id]);
        }

        // mode
        if($mode != 'ZZZZ'){
            $policies->where(['Policies.mode' => $mode]);
        }

        // young policies
        if($young_policies == 1){
            $policies->where(['Policies.effective_date >' => date("Y-m-d", strtotime("-1 year"))]);
        }


        // start PDF export

        require_once(ROOT . DS . 'vendor' . DS  . 'fpdf'  . DS . 'fpdf.php');
        
        $fpdf = new FPDF();
        $fpdf->AddPage("L");
        $fpdf->SetFont('Arial','B',9);
        $fpdf->Cell(275,0,"Policies Report",0,0, 'L');
        $fpdf->Ln(5);
        $fpdf->Cell(275,0,"",'B',0, 'R');
        $fpdf->Ln();

        $fpdf->Cell(40,7,"Number",'L-R-B',0, 'C');

        $fpdf->Cell(80,7,"Holder",'L-R-B',0, 'C');
        $fpdf->Cell(20,7,"Country",'L-R-B',0, 'C');
        $fpdf->Cell(75,7,"Company",'L-R-B',0, 'C');
        $fpdf->Cell(25,7,"Premium",'L-R-B',0, 'C');
        $fpdf->Cell(15,7,"Mode",'L-R-B',0, 'C');
        $fpdf->Cell(20,7,"Effective",'L-R-B',0, 'C');
        $fpdf->SetFont('Arial','',7);
        foreach($policies as $policy){
            $fpdf->Ln();
            $fpdf->Cell(40,6,utf8_decode($policy->policy_number),'L-R-B',0, 'C');
            $fpdf->Cell(80,6,utf8_decode($policy->customer->name),'L-R-B',0, 'C');
            $fpdf->Cell(20,6,utf8_decode(substr($policy->customer->country->name, 0, 5)),'L-R-B',0, 'C');
            if(!empty($policy->company)){
                if(!empty($policy->option)){
                    $fpdf->Cell(75,6,utf8_decode($policy->company->name . " / ".  $policy->option->name),'L-R-B',0, 'C');
                }else{
                    $fpdf->Cell(75,6,utf8_decode($policy->company->name),'L-R-B',0, 'C');
                }
            }else{
                if(!empty($policy->option)){
                    $fpdf->Cell(75,6,utf8_decode($policy->option->name),'L-R-B',0, 'C');
                }else{
                    $fpdf->Cell(75,6,"",'L-R-B',0, 'C');
                }
            }
            $fpdf->Cell(25,6,number_format($policy->premium,2,".",","),'L-R-B',0, 'C');
            $fpdf->Cell(15,6,$modes[$policy->mode] ,'L-R-B',0, 'C');
            $fpdf->Cell(20,6,date('M d Y', strtotime($policy->effective_date->i18nFormat('yyyy-MM-dd'))) ,'L-R-B',0, 'C');
        }


        $fpdf->Output('I', 'policies_report');
        die();




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

        $companies = $this->Policies->Companies->find("all", array("order" => array("name ASC"), "conditions" => array("Companies.tenant_id" => $this->Auth->user()['tenant_id'])));

        if($company_id != '9999'){
            $companies->where(['id' => $company_id]);
        }

        if($type != '9999'){
            $companies->where(['type' => $type]);
        }

        $renewals = $this->Policies->Prenewals->find("all", array("conditions" => array("renewal_date >=" => $from, "renewal_date <=" => $to,"Prenewals.tenant_id" => $this->Auth->user()['tenant_id'])))->contain(['Policies' => ['Companies', 'Options', 'Customers' => ['Countries']]]);
        foreach($renewals as $renewal){
            $renewal->last_renewal = $this->Policies->Prenewals->find("all", array("order" => array("renewal_date DESC"), "conditions" => array("Prenewals.tenant_id" => $this->Auth->user()['tenant_id'], "Prenewals.id <>" => $renewal->id, 'Prenewals.policy_id' => $renewal->policy_id)))->first();
        }


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
            $fpdf->SetFont('Arial','B',8);
            $fpdf->SetFillColor(220,220,220);
            $fpdf->Cell(275,7,utf8_decode($company->name),"T-L-R",0, 'L', 1);
            $fpdf->SetFillColor(255,255,255);
            $fpdf->Ln(7);
            $fpdf->Cell(59,7,"Insured Name",'T-L-B',0, 'L');
            $fpdf->Cell(10,7,"Age",'T-L-B',0, 'C');
            $fpdf->Cell(24,7,"Policy",'T-L-B',0, 'C');
            $fpdf->Cell(50,7,"Plan",'T-L-B',0, 'C');
            $fpdf->Cell(15,7,"Country",'T-L-B',0, 'C');
            $fpdf->Cell(10,7,"Mode",'T-L-B',0, 'C');
            $fpdf->Cell(25,7,"L Premium",'T-L-B',0, 'C');
            $fpdf->Cell(25,7,"Premium",'T-L-B',0, 'C');
            $fpdf->Cell(15,7,"%",'T-L-B',0, 'C');
            $fpdf->Cell(22,7,"Effective Date",'T-L-B',0, 'C');
            $fpdf->Cell(20,7,"Due Date",'T-L-R-B',0, 'C');
            $fpdf->Ln(7);
            $fpdf->SetFont('Arial','',8);
            foreach($renewals as $renewal){
                if($renewal->policy->company_id == $company->id){
                    if(empty($filter_country) || $filter_country  == $renewal->policy->customer->country_id){
                $policy = $renewal->policy;
                $percentage = ""; 
                if(!empty($renewal->last_renewal)){
                    $percentage = ($renewal->premium - $renewal->last_renewal->premium)*100/$renewal->last_renewal->premium;
                    $percentage = number_format($percentage, 2, ".",",");
                    $percentage .="%";
                }    
                $age = "N/A";
                if(!empty($policy->customer->dob)){
                    $dob = $policy->customer->dob->year."-".$policy->customer->dob->month."-".$policy->customer->dob->day;
                    $today = date("Y-m-d");
                    $diff = date_diff(date_create($dob), date_create($today));
                    $age = $diff->format('%y');
                }
                if(!empty($renewal->payment_date) || $renewal->status == 2){
                    $fpdf->SetFillColor(255,250,205);
                }else{
                    $fpdf->SetFillColor(255,255,255);
                }

                $fpdf->Cell(59,7,utf8_decode($policy->customer->name),'T-L-B',0, 'L',1);
                if(!empty($age)){
                    $fpdf->Cell(10,7,$age,'T-L-B',0, 'C',1);
                }else{
                    $fpdf->Cell(10,7,"N/A",'T-L-B',0, 'C',1);
                }
                
                $fpdf->Cell(24,7,$policy->policy_number,'T-L-B',0, 'C',1);

                if(!empty($policy->option->name)){
                    if(!empty($policy->option->option_name)){
                        $fpdf->Cell(50,7,$policy->option->name." / ".$policy->option->option_name,'T-L-B',0, 'C',1);
                    }else{
                        $fpdf->Cell(50,7,$policy->option->name,'T-L-B',0, 'C',1);
                    }
                }else{
                    if(!empty($policy->option->option_name)){
                        $fpdf->Cell(50,7,$policy->option->option_name,'T-L-B',0, 'C',1);
                    }else{
                        $fpdf->Cell(50,7,"",'T-L-B',0, 'C',1); 
                    }
                }
                
                $fpdf->Cell(15,7,substr($policy->customer->country->name, 0, 3),'T-L-B',0, 'C',1);
                $fpdf->Cell(10,7,$this->modes[$policy->mode],'T-L-B',0, 'C',1);
                if(!empty($renewal->last_renewal)){
                    $fpdf->Cell(25,7,number_format(($renewal->last_renewal->premium+$renewal->last_renewal->fee), 2, ".", ",") ."USD",'T-L-B',0, 'C',1);
                }else{
                    $fpdf->Cell(25,7,"",'T-L-B',0, 'C',1);
                }
                
                $fpdf->Cell(25,7,number_format(($renewal->premium+$renewal->fee), 2, ".", ",") ."USD",'T-L-B',0, 'C',1);
                $fpdf->Cell(15,7,$percentage,'T-L-B',0, 'C',1);
                $fpdf->Cell(22,7,date('M d Y', strtotime($policy->effective_date->i18nFormat('yyyy-MM-dd'))),'T-L-B',0, 'C',1);
                $fpdf->Cell(20,7,date('M d Y', strtotime($renewal->renewal_date->i18nFormat('yyyy-MM-dd'))),'T-L-R-B',0, 'C',1);
                $fpdf->Ln(7);
            }
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
                    $company->policies = $this->Policies->find("all", array("conditions" => array("Policies.company_id" => $company->id, "Policies.tenant_id" => $this->Auth->user()['tenant_id'], 'pending_business' => 2, "OR" => array("last_renewal >= '". $from."' AND last_renewal <= '". $to."'", "next_renewal >= '". $from."' AND next_renewal <= '". $to."'")), "order" => array("paid_until ASC")))->contain(['Customers' => ['Countries'], 'Options', 'Payments'])->matching('Customers', function ($q) use ($filter_country) {
                        return $q->where(['Customers.country_id' => $filter_country]);
                    });
                }else{
                    $company->policies = $this->Policies->find("all", array("conditions" => array("Policies.company_id" => $company->id, "Policies.tenant_id" => $this->Auth->user()['tenant_id'], 'pending_business' => 2, "OR" => array("last_renewal >= '". $from."' AND last_renewal <= '". $to."'", "next_renewal >= '". $from."' AND next_renewal <= '". $to."'")), "order" => array("paid_until ASC")))->contain(['Customers' => ['Countries'], 'Options', 'Payments']);
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

    

    public function generaterenewals(){
        if($this->request->is(['patch', 'put', 'post'])){
            $policy = $this->Policies->get($this->request->getData()['policy_id']);
            $this->setrenewals($policy, $this->request->getData()['year']) ; 
        }

        return $this->redirect($this->referer());
    }

    
}
