<?php
declare(strict_types=1);

namespace App\Controller;

use FPDF;

/**
 * Payments Controller
 *
 * @property \App\Model\Table\PaymentsTable $Payments
 * @method \App\Model\Entity\Payment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PaymentsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($policy_id = false)
    {
        $filter_country = $this->session->read("filter_country");
        if(!empty($filter_country)){
            $policies = $this->Payments->Policies->find("all", array("conditions" => array("Policies.tenant_id" => $this->Auth->user()['tenant_id'])))->contain(['Customers', 'Companies'])->matching('Customers', function ($q) use ($filter_country) {
                return $q->where(['Customers.country_id' => $filter_country]);
            });
            
        }else{
            $policies = $this->Payments->Policies->find("all", array("conditions" => array("Policies.tenant_id" => $this->Auth->user()['tenant_id'])))->contain(['Customers', 'Companies']);
        }
        
        if(!empty($policy_id)){
            $policy = $this->Payments->Policies->get($policy_id, ['contain' => ['Customers']]);
            $this->savelog(200, "Accessed payments for policy #".$policy->policy_number, 1, 3, "", "");
            $payments = $this->Payments->find("all", array('order' => array('Payments.created DESC'), "conditions" => array('Payments.created >=' => $this->from, 'Payments.tenant_id' => $this->Auth->user()['tenant_id'], 'Payments.created <=' => $this->to, 'Payments.policy_id' => $policy_id)))->contain(['Rates', 'Users']);
        }else{
            $this->savelog(200, "Accessed payments page", 1, 3, "", "");
            $policy = '';
            $payments = '';
        }

        $this->set(compact('policies', 'policy_id', 'policy', 'payments'));
    }

    public function renewals(){
        $this->loadModel('Policies');
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
                    $company->policies = $this->Policies->find("all", array("conditions" => array("Policies.company_id" => $company->id,'Policies.tenant_id' => $this->Auth->user()['tenant_id'], 'pending_business' => 2, "OR" => array("last_renewal >= '". $from."' AND last_renewal <= '". $to."'", "next_renewal >= '". $from."' AND next_renewal <= '". $to."'")), "order" => array("paid_until ASC")))->contain(['Customers', 'Options', 'Payments']);
                }

                foreach($company->policies as $policy){
                    $policy->last_payment = $this->Payments->find("all", array("order" => array("created DESC"), "conditions" => array("policy_id" => $policy->id, 'tenant_id' => $this->Auth->user()['tenant_id'])))->first();
                }
                
            }
        }
        
        $this->set(compact("companies", 'comps', 'type_filter', 'company_filter', 'from'));
    }

    private function getPolicies($type = false, $company_id = false){
        $this->loadModel('Policies');
        $filter_country = $this->session->read("filter_country");
        $from = $this->session->read("from"); 
        $from = date("Y-m-d", strtotime($from." -1 day"));
        $to = $this->session->read("to");
        $to = date("Y-m-d", strtotime($to." -1 day"));
        if(!empty($type)){
            if(!empty($company_id)){
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
                $company->policies = $this->Policies->find("all", array("conditions" => array("Policies.company_id" => $company->id,'Policies.tenant_id' => $this->Auth->user()['tenant_id'], 'pending_business' => 2, "OR" => array("last_renewal >= '". $from."' AND last_renewal <= '". $to."'", "next_renewal >= '". $from."' AND next_renewal <= '". $to."'")), "order" => array("paid_until ASC")))->contain(['Customers', 'Options', 'Payments'])->matching('Customers', function ($q) use ($filter_country) {
                    return $q->where(['Customers.country_id' => $filter_country]);
                });
            }else{
                $company->policies = $this->Policies->find("all", array("conditions" => array("Policies.company_id" => $company->id,'Policies.tenant_id' => $this->Auth->user()['tenant_id'], 'pending_business' => 2, "OR" => array("last_renewal >= '". $from."' AND last_renewal <= '". $to."'", "next_renewal >= '". $from."' AND next_renewal <= '". $to."'")), "order" => array("paid_until ASC")))->contain(['Customers', 'Options', 'Payments']);
            }

            foreach($company->policies as $policy){
                $policy->last_payment = $this->Payments->find("all", array("order" => array("created DESC"), "conditions" => array("policy_id" => $policy->id, 'tenant_id' => $this->Auth->user()['tenant_id'])))->first();
            }
        }

        

        return $companies;
    }


    public function exportrenewals($type, $company_id){
        $this->loadModel('Policies');
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
        $fpdf->Cell(200,0,"Copassa Renewals Report",0,0, 'L');
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
                $fpdf->Cell(64,7,"Name",'T-L-B',0, 'L');
                $fpdf->Cell(10,7,"Age",'T-L-B',0, 'C');
                $fpdf->Cell(19,7,"Policy",'T-L-B',0, 'C');
                $fpdf->Cell(55,7,"Plan",'T-L-B',0, 'C');
                $fpdf->Cell(10,7,"Mode",'T-L-B',0, 'C');
                $fpdf->Cell(20,7,"LP",'T-L-B',0, 'C');
                $fpdf->Cell(20,7,"Premium",'T-L-B',0, 'C');
                $fpdf->Cell(10,7,"%",'T-L-B',0, 'C');
                $fpdf->Cell(22,7,"Effective",'T-L-B',0, 'C');
                $fpdf->Cell(20,7,"Due",'T-L-R-B',0, 'C');
                $fpdf->Cell(25,7,"Last Payment",'T-L-R-B',0, 'C');
                $fpdf->Ln(7);
                $fpdf->SetFont('Arial','',8);
                foreach($company->policies as $policy){
                    $percentage = ""; 
                    if(!empty($policy->last_premium)){
                        $percentage = ($policy->premium - $policy->last_premium)*100/$policy->last_premium;
                        $percentage = number_format($percentage, 2, ".",",");
                    }
                    $paid_until = $policy->paid_until->year."-".$policy->paid_until->month."-".$policy->paid_until->day;
                    $effective_date = $policy->effective_date->year."-".$policy->effective_date->month."-".$policy->effective_date->day;
                    $next_renewal = $policy->next_renewal->year."-".$policy->next_renewal->month."-".$policy->next_renewal->day;
                    if(!empty($policy->last_payment)){
                        $last_payment_date = $policy->last_payment->created->year."-".$policy->last_payment->created->month."-".$policy->last_payment->created->day;
                    }
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
                    $fpdf->Cell(19,7,$policy->policy_number,'T-L-B',0, 'C',1);
                    $fpdf->Cell(55,7,$policy->option->name." / ".$policy->option->option_name,'T-L-B',0, 'C',1);
                    $fpdf->Cell(10,7,$this->modes[$policy->mode],'T-L-B',0, 'C',1);
                    $fpdf->Cell(20,7,number_format(($policy->last_premium+$policy->fee), 2, ".", ","),'T-L-B',0, 'C',1);
                    $fpdf->Cell(20,7,number_format(($policy->premium+$policy->fee), 2, ".", ","),'T-L-B',0, 'C',1);
                    $fpdf->Cell(10,7,$percentage,'T-L-B',0, 'C',1);
                    $fpdf->Cell(22,7,date('M d Y', strtotime($effective_date)),'T-L-B',0, 'C',1);
                    $fpdf->Cell(20,7,date('M d Y', strtotime($next_renewal)),'T-L-R-B',0, 'C',1);
                    if(!empty($policy->last_payment)){
                        $fpdf->Cell(25,7,date('M d Y', strtotime($last_payment_date)),'T-L-R-B',0, 'C',1); 
                   }else{
                        $fpdf->Cell(25,7,'','T-L-R-B',0, 'C',1); 
                   }
                    
                    $fpdf->Ln(7);
                }
            }
            $fpdf->Ln(7); 
        }
        $fpdf->Output('I');
        die();
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($policy_id = false)
    {
        $payment = $this->Payments->newEmptyEntity();
        $policy = '';

        if(!empty($policy_id)){
            $policy = $this->Payments->Policies->get($policy_id, ['contain' => ['Customers']]);
        }
        
        if ($this->request->is(["patch", "put", 'post'])){
            if(!empty($this->request->getData()['amount'])){
                $data = $this->request->getData();
                $certificate = $this->request->getData('certificate');
                $name = $certificate->getClientFilename();
                $type = $certificate->getClientMediaType();
                $targetPath = WWW_ROOT. 'img'. DS . 'payments'. DS. $name;
                    if (!empty($name)) {
                        if ($certificate->getSize() > 0 && $certificate->getError() == 0) {
                            $certificate->moveTo($targetPath); 
                            $data['certificate'] = $name;
                        }else{
                                $data['certificate'] = '';
                        }
                    }else{
                        $data['certificate'] = '';
                    }
                $payment = $this->Payments->newEmptyEntity();
                $payment->amount = $this->request->getData()['amount']; 
                $payment->memo = $this->request->getData()['memo'];  
                $payment->rate_id = 2; 
                $payment->daily_rate = 1; 
                $payment->created = $this->request->getData()['created']." ".date("H:i:s"); 
                $payment->confirmed = 0;
                $payment->customer_id = $policy->customer_id;
                $payment->policy_id = $policy->id;
                $payment->user_id = $this->Auth->user()['id'];
                $payment->status = 1;
                $payment->tenant_id = $this->Auth->user()['tenant_id'];
                $payment->path_to_photo = $data['certificate'];
                if($pm = $this->Payments->save($payment)){
                    $this->update_paid_until($policy);
                    $this->update_next_renewal($policy, $this->request->getData()['next_renewal'], $this->request->getData()['premium']);
                    $this->savelog(200, "Created payment for policy: ".$policy->policy_number, 1, 1, "", json_encode($payment));
                }else{
                    $this->savelog(500, "Tempted to create payment for policy: ".$policy->policy_number, 0, 1, "", json_encode($payment));
                }
                return $this->redirect(['action' => "index", $pm['policy_id']]);
            }
        }
        $this->set(compact('payment', 'policy'));
    }

    private function update_paid_until($policy){
        $paid_until = $policy->paid_until->year."-".$policy->paid_until->month."-".$policy->paid_until->day;
        $date = new \Datetime($paid_until);
        $months = $policy->mode; 
        $date->add(new \DateInterval("P".$months."M")); 
        $policy->paid_until = $date;
        $this->Payments->Policies->save($policy);
    }

    private function update_next_renewal($policy, $next_renewal, $premium){
        if(!empty($premium)){
            $policy->last_premium = $policy->premium; 
            $policy->premium = $premium;
        }

        if(!empty($next_renewal)){
            $policy->last_renewal = $policy->next_renewal;
            $policy->next_renewal = $next_renewal;
        }

        $this->Payments->Policies->save($policy);
    }

    /**
     * Edit method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $payment = $this->Payments->get($id, [
            'contain' => ['Policies', 'Customers'],
        ]);
        $old_data = json_encode($payment);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $certificate = $this->request->getData('certificate');
            $name = $certificate->getClientFilename();
            $type = $certificate->getClientMediaType();
            $targetPath = WWW_ROOT. 'img'. DS . 'payments'. DS. $name;
                if (!empty($name)) {
                    if ($certificate->getSize() > 0 && $certificate->getError() == 0) {
                        $certificate->moveTo($targetPath); 
                        $data['certificate'] = $name;
                    }else{
                            $data['certificate'] = '';
                    }
                }else{
                    $data['certificate'] = '';
                }
            $payment = $this->Payments->patchEntity($payment, $data);
            if ($this->Payments->save($payment)) {
                $this->savelog(200, "Edited payment for policy: ".$payment->policy->policy_number, 1, 2, $old_data, json_encode($payment));
                $this->Flash->success(__('The payment has been saved.'));

                return $this->redirect(['action' => 'index', $payment->policy_id]);
            }
            $this->savelog(500, "Tempted to edit payment for policy: ".$payment->policy->policy_number, 0, 2, $old_data, json_encode($payment));
            $this->Flash->error(__('The payment could not be saved. Please, try again.'));
        }
        $customers = $this->Payments->Customers->find('list', ['limit' => 200]);
        $policies = $this->Payments->Policies->find('list', ['limit' => 200]);
        $users = $this->Payments->Users->find('list', ['limit' => 200]);
        $rates = $this->Payments->Rates->find('list', ['limit' => 200]);
        $this->set(compact('payment', 'customers', 'policies', 'users', 'rates'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $payment = $this->Payments->get($id);
        if ($this->Payments->delete($payment)) {
            $this->Flash->success(__('The payment has been deleted.'));
        } else {
            $this->Flash->error(__('The payment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function report(){
        $this->savelog(200, "Accessed payments page", 1, 3, "", "");
        $filter_country = $this->session->read("filter_country");
        if(!empty($filter_country)){
            $payments = $this->Payments->find("all", array('order' => array('Payments.created ASC'), "conditions" => array('Payments.tenant_id' => $this->Auth->user()['tenant_id'], 'Payments.created >=' => $this->from, 'Payments.created <=' => $this->to)))->contain(['Rates', 'Users', 'Customers', 'Policies' => ['Companies', 'Options']])->matching('Customers', function ($q) use ($filter_country) {
                        return $q->where(['Customers.country_id' => $filter_country]);
                    });
        }else{
           $payments = $this->Payments->find("all", array('order' => array('Payments.created ASC'), "conditions" => array('Payments.tenant_id' => $this->Auth->user()['tenant_id'], 'Payments.created >=' => $this->from, 'Payments.created <=' => $this->to)))->contain(['Rates', 'Users', 'Customers', 'Policies' => ['Companies', 'Options']]); 
        }
        
        $this->set(compact('payments'));
    }

    public function export(){
        $this->savelog(200, "Payment Exports Done", 1, 3, "", "");
        require_once(ROOT . DS . 'vendor' . DS  . 'fpdf'  . DS . 'fpdf.php');
        $from = $this->session->read("from"); 
        $to = $this->session->read("to"); 
        $filter_country = $this->session->read("filter_country");
        if(!empty($filter_country)){
            $payments = $this->Payments->find("all", array('order' => array('Payments.created ASC'), "conditions" => array('Payments.tenant_id' => $this->Auth->user()['tenant_id'], 'Payments.created >=' => $this->from, 'Payments.created <=' => $this->to)))->contain(['Rates', 'Users', 'Customers', 'Policies' => ['Companies', 'Options']])->matching('Customers', function ($q) use ($filter_country) {
                        return $q->where(['Customers.country_id' => $filter_country]);
                    });
        }else{
           $payments = $this->Payments->find("all", array('order' => array('Payments.created ASC'), "conditions" => array('Payments.tenant_id' => $this->Auth->user()['tenant_id'], 'Payments.created >=' => $this->from, 'Payments.created <=' => $this->to)))->contain(['Rates', 'Users', 'Customers', 'Policies' => ['Companies', 'Options']]); 
        }

        $fpdf = new FPDF();
        $fpdf->AddPage("L");
        $fpdf->SetFont('Arial','B',9);
        $fpdf->Cell(200,0,"Copassa Payments Report",0,0, 'L');
        $fpdf->Cell(75,0,"From " . date("M d Y", strtotime($from)) . " to " . date("M d Y", strtotime($to)) ,0,0, 'R');
        $fpdf->Ln(7);
        $fpdf->Cell(275,0,"",'B',0, 'R');
        $fpdf->Ln(5);

        $fpdf->SetFont('Arial','B',8);
        $fpdf->SetFillColor(220,220,220);
        $fpdf->Cell(275,7,"Payments","T-L-R",0, 'L', 1);
        
        $fpdf->Ln(7);
        $fpdf->Cell(10,7,"#",'T-L-B',0, 'C');
        $fpdf->Cell(17,7,"Date",'T-L-B-R',0, 'C');
        $fpdf->Cell(60,7,"Customer",'T-L-B',0, 'C');
        $fpdf->Cell(35,7,"Company",'T-L-B',0, 'C');
        $fpdf->Cell(25,7,"Policy",'T-L-B',0, 'C');
        $fpdf->Cell(25,7,"Amount",'T-L-B',0, 'C');
        $fpdf->Cell(25,7,"Due Date",'T-L-B',0, 'C');
        $fpdf->Cell(78,7,"Memo",'T-L-B-R',0, 'C');
        
        $fpdf->Ln(7);
        $fpdf->SetFont('Arial','',7);

        foreach($payments as $p){
            if($p->policy->company->country_id == $filter_country || empty($filter_country)){
                $date = $p->created->year."-".$p->created->month."-".$p->created->day;
                $due_date = $p->policy->last_renewal->year."-".$p->policy->last_renewal->month."-".$p->policy->last_renewal->day;
                $fpdf->Cell(10,7,(4000+$p->id),'T-L-B',0, 'C');
                $fpdf->Cell(17,7,date('d M Y', strtotime($date)),'T-L-B-R',0, 'C');
                $fpdf->Cell(60,7,$p->customer->name,'T-L-B',0, 'L');
                $fpdf->Cell(35,7,$p->policy->company->name,'T-L-B',0, 'L');
                $fpdf->Cell(25,7,$p->policy->policy_number,'T-L-B',0, 'L');
                $fpdf->Cell(25,7,(number_format($p->amount, 2, ".", ",")." ".$p->rate->name),'T-L-B',0, 'C');
                $fpdf->Cell(25,7,date('d M Y', strtotime($due_date)),'T-L-B-R',0, 'C');
                $fpdf->Cell(78,7,$p->memo,'T-L-B-R',0, 'C');            
                $fpdf->Ln(7);
            }
        }

        $fpdf->Output('I');
        die();
    }

    public function receipt($id){

        require_once(ROOT . DS . 'vendor' . DS  . 'fpdf'  . DS . 'fpdf.php');

        $payment = $this->Payments->get($id, ['contain' => ['Customers', 'Policies']]);
        $this->savelog(200, "Generated receipt for payment : ".$payment->id." and policy : ".$payment->policy->policy_number, 1, 4, "", "");
        $created = $payment->created->month."/".$payment->created->day."/".$payment->created->year;
        
        $effective_date = $payment->policy->effective_date->month."/".$payment->policy->effective_date->day."/".$payment->policy->effective_date->year;
        
        $paid_until = $payment->policy->paid_until->month."/".$payment->policy->paid_until->day."/".$payment->policy->paid_until->year;
        
        $fpdf = new FPDF();
        $fpdf->AddPage();
        $fpdf->SetFont('Arial','B',11);
        $fpdf->Cell(190,0,date('F j Y'),0,0, 'R');
        $fpdf->Ln(7);
        $fpdf->SetFont('Arial','BU',11);

        $fpdf->Ln(15);
        $fpdf->Cell(190,0,utf8_decode("OFFICIAL RECEIPT / RECIBIO OFICIAL"),0,0, 'C');
        $fpdf->Ln(15);
        $fpdf->SetFont('Arial','',11);
        $fpdf->Cell(190,0,utf8_decode($payment->customer->name),0,0, 'L');
        $fpdf->Ln(7);
        $fpdf->Cell(190,0,utf8_decode($payment->customer->address),0,0, 'L');
        $fpdf->Ln(7);
        $fpdf->Cell(190,0,utf8_decode("(".$payment->customer->home_area_code.') '.$payment->customer->home_phone),0,0, 'L');

        $fpdf->Ln(15);
        $fpdf->SetFont('Arial','B',11);
        $fpdf->Cell(95,0,utf8_decode("Date / Fecha "),0,0, 'L');
        $fpdf->SetFont('Arial','',11);
        $fpdf->Cell(95,0,date('m/d/Y', strtotime($created)),0,0, 'R');

        $fpdf->Ln(12);
        $fpdf->SetFont('Arial','B',11);
        $fpdf->Cell(95,0,utf8_decode("Policy number / Número de la póliza "),0,0, 'L');
        $fpdf->SetFont('Arial','',11);
        $fpdf->Cell(95,0,utf8_decode($payment->policy->policy_number),0,0, 'R');

        $fpdf->Ln(12);
        $fpdf->SetFont('Arial','B',11);
        $fpdf->Cell(95,0,utf8_decode("Amount Received / Cantidad Recibida "),0,0, 'L');
        $fpdf->SetFont('Arial','',11);
        $fpdf->Cell(95,0,number_format($payment->amount, 2, ".", ","),0,0, 'R');

        $fpdf->Ln(12);
        $fpdf->SetFont('Arial','B',11);
        $fpdf->Cell(95,0,utf8_decode("Date Received / Fecha recibida"),0,0, 'L');
        $fpdf->SetFont('Arial','',11);
        $fpdf->Cell(95,0,date('m/d/Y', strtotime($created)),0,0, 'R');

        $fpdf->Ln(12);
        $fpdf->SetFont('Arial','B',11);
        $fpdf->Cell(95,0,utf8_decode("Mode of payment / Forma de pago "),0,0, 'L');
        $fpdf->SetFont('Arial','',11);
        $fpdf->Cell(95,0,$this->modes[$payment->policy->mode],0,0, 'R');

        $fpdf->Ln(12);
        $fpdf->SetFont('Arial','B',11);
        $fpdf->Cell(95,0,utf8_decode("Policy Effective date / Fecha efectiva de la póliza "),0,0, 'L');
        $fpdf->SetFont('Arial','',11);
        $fpdf->Cell(95,0,date('m/d/Y', strtotime($effective_date)),0,0, 'R');

        $fpdf->Ln(12);
        $fpdf->SetFont('Arial','B',11);
        $fpdf->Cell(95,0,utf8_decode("Paid until / Pagado hasta "),0,0, 'L');
        $fpdf->SetFont('Arial','',11);
        $fpdf->Cell(95,0,date('m/d/Y', strtotime($paid_until)),0,0, 'R');

        $fpdf->Ln(12);
        $fpdf->SetFont('Arial','B',11);
        $fpdf->Cell(95,0,utf8_decode("Payment applied to / Pago aplicado a "),0,0, 'L');
        $fpdf->SetFont('Arial','',11);
        $fpdf->Cell(95,0,utf8_decode($payment->policy->policy_number),0,0, 'R');

        $fpdf->Output('I');

        die();
    }
}
