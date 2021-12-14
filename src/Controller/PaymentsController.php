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
            $policies = $this->Payments->Policies->find("all")->contain(['Customers', 'Companies'])->matching('Customers', function ($q) use ($filter_country) {
                return $q->where(['Customers.country_id' => $filter_country]);
            });
            
        }else{
            $policies = $this->Payments->Policies->find("all")->contain(['Customers', 'Companies']);
        }
        
        if(!empty($policy_id)){
            $policy = $this->Payments->Policies->get($policy_id, ['contain' => ['Customers']]);
            $this->savelog(200, "Accessed payments for policy #".$policy->policy_number, 1, 3, "", "");
            $payments = $this->Payments->find("all", array('order' => array('Payments.created DESC'), "conditions" => array('Payments.created >=' => $this->from, 'Payments.created <=' => $this->to, 'Payments.policy_id' => $policy_id)))->contain(['Rates', 'Users']);
        }else{
            $this->savelog(200, "Accessed payments page", 1, 3, "", "");
            $policy = '';
            $payments = '';
        }

        $this->set(compact('policies', 'policy_id', 'policy', 'payments'));
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
                $payment->rate_id = $this->request->getData()['rate_id']; 
                $payment->daily_rate = $this->request->getData()['daily_rate']; 
                $payment->confirmed = 0;
                $payment->customer_id = $policy->customer_id;
                $payment->policy_id = $policy->id;
                $payment->user_id = $this->Auth->user()['id'];
                $payment->status = 1;
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
            $payments = $this->Payments->find("all", array('order' => array('Payments.created ASC'), "conditions" => array('Payments.created >=' => $this->from, 'Payments.created <=' => $this->to)))->contain(['Rates', 'Users', 'Customers', 'Policies' => ['Companies', 'Options']])->matching('Customers', function ($q) use ($filter_country) {
                        return $q->where(['Customers.country_id' => $filter_country]);
                    });
        }else{
           $payments = $this->Payments->find("all", array('order' => array('Payments.created ASC'), "conditions" => array('Payments.created >=' => $this->from, 'Payments.created <=' => $this->to)))->contain(['Rates', 'Users', 'Customers', 'Policies' => ['Companies', 'Options']]); 
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
            $payments = $this->Payments->find("all", array('order' => array('Payments.created ASC'), "conditions" => array('Payments.created >=' => $this->from, 'Payments.created <=' => $this->to)))->contain(['Rates', 'Users', 'Customers', 'Policies' => ['Companies', 'Options']])->matching('Customers', function ($q) use ($filter_country) {
                        return $q->where(['Customers.country_id' => $filter_country]);
                    });
        }else{
           $payments = $this->Payments->find("all", array('order' => array('Payments.created ASC'), "conditions" => array('Payments.created >=' => $this->from, 'Payments.created <=' => $this->to)))->contain(['Rates', 'Users', 'Customers', 'Policies' => ['Companies', 'Options']]); 
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
        $fpdf->Image(ROOT.'/webroot/img/logo.png',10,4,50);
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

        $fpdf->Image(ROOT.'/webroot/img/footer.png',10,270,190);
        $fpdf->Output('I');

        die();
    }
}
