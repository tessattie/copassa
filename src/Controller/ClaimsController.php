<?php
declare(strict_types=1);

namespace App\Controller;
use FPDF;

/**
 * Claims Controller
 *
 * @property \App\Model\Table\ClaimsTable $Claims
 * @method \App\Model\Entity\Claim[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ClaimsController extends AppController
{

    public function authorize(){
        if($this->Auth->user()['role_id'] == 2){

            if($this->request->getParam('action') == 'index' && ($this->authorizations[52] || $this->authorizations[53] || $this->authorizations[55])){
                return true;
            }

            if($this->request->getParam('action') == 'add' && $this->authorizations[53]){
                return true;
            }

            if($this->request->getParam('action') == 'edit' && $this->authorizations[53]){
                return true;
            }

            if($this->request->getParam('action') == 'delete' && $this->authorizations[53]){
                return true;
            }

            if($this->request->getParam('action') == 'addct' && $this->authorizations[53]){
                return true;
            }

            if($this->request->getParam('action') == 'deductible' && $this->authorizations[53]){
                return true;
            }

            if($this->request->getParam('action') == 'view' && $this->authorizations[52]){
                return true;
            }

            if($this->request->getParam('action') == 'export' && $this->authorizations[55]){
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
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        $claims = $this->Claims->find("all", array("order" => array("Claims.created DESC"), 'conditions' => array("Claims.tenant_id" => $this->Auth->user()['tenant_id'])))->contain(['Policies' => ['Customers'], 'Dependants', 'ClaimsTypes']);
        $this->set(compact('claims'));
    }

    /**
     * View method
     *
     * @param string|null $id Claim id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        $claim = $this->Claims->get($id, [
            'contain' => ['Policies' => ['Customers', 'Companies', 'Options'], 'Dependants', 'Files' => ['Users'], 'Users', 'ClaimsTypes' => ['Types', 'Users', 'sort' => ['ClaimsTypes.created ASC']]],
        ]);

        if($this->Auth->user()['tenant_id'] != $claim->tenant_id){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        $this->loadModel("Folders");
        $claims_types = $this->Claims->ClaimsTypes->Types->find('list', ['order' => ['name ASC'], 'conditions' => ['tenant_id' => $this->Auth->user()['tenant_id']]]);
        $folder_id = $this->Folders->find("all", array("conditions" => array("tenant_id" => $this->Auth->user()['tenant_id'], 'is_claims' => 2)))->first()->id;

        $this->set(compact('claim', 'claims_types', 'folder_id'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        $claim = $this->Claims->newEmptyEntity();
        if ($this->request->is('post')) {
            $claim = $this->Claims->patchEntity($claim, $this->request->getData());
            $claim->tenant_id = $this->Auth->user()['tenant_id'];
            $claim->user_id = $this->Auth->user()['id'];
            $claim->status = 1;
            if ($this->Claims->save($claim)) {
                $this->Flash->success(__('The claim has been saved.'));

                return $this->redirect(['action' => 'view', $claim->id]);
            }
            $this->Flash->error(__('The claim could not be saved. Please, try again.'));
        }
        $customers = $this->Claims->Policies->Customers->find('list', ['order' => ['name ASC'], 'conditions' => ['Customers.tenant_id' => $this->Auth->user()['tenant_id']]]);
        $policies = [];
        $this->set(compact('claim', 'policies', 'customers'));
    }


    public function export($claim_id){
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        require_once(ROOT . DS . 'vendor' . DS  . 'fpdf'  . DS . 'fpdf.php');

        $claim = $this->Claims->get($claim_id, [
            'contain' => ['Policies' => ['Customers', 'Companies', 'Options'], 'Dependants', 'Users', 'ClaimsTypes' => ['Types', 'Users', 'sort' => ['ClaimsTypes.created ASC']]],
        ]);

        if($this->Auth->user()['tenant_id'] != $claim->tenant_id){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }

        $age = "N/A";
        if(!empty($claim->policy->customer->dob)){
            $dob = $claim->policy->customer->dob->year."-".$claim->policy->customer->dob->month."-".$claim->policy->customer->dob->day;
            $today = date("Y-m-d");
            $diff = date_diff(date_create($dob), date_create($today));
            $age = $diff->format('%y');
        }
        
        $fpdf = new FPDF();
        $fpdf->AddPage('L');
        $fpdf->SetFont('Arial','B',11);
        $fpdf->Cell(75,0,"Claim Details",0,0, 'L');
        $fpdf->Cell(200,0,$claim->policy->customer->name." - ". $claim->policy->policy_number,0,0, 'R');
        $fpdf->Ln(7);
        $fpdf->Cell(275,0,"",'B',0, 'R');
        $fpdf->SetFont('Arial','',10);
        $fpdf->Ln(1);
        if(!empty($claim->dependant_id)){
            $fpdf->SetFillColor(243,243,243);
        }else{
            $fpdf->SetFillColor(255,255,255);
        }
        
        $fpdf->Cell(75,7,"Policy Holder",0,0, 'L',1);
        $fpdf->Cell(200,7,$claim->policy->customer->name,0,0, 'R',1);
        $fpdf->Ln();
        if(!empty($claim->dependant_id)){
            $fpdf->SetFillColor(255,255,255);
            $fpdf->Cell(75,7,"Dependant",0,0, 'L',1);
            $fpdf->Cell(200,7,$claim->dependant->name,0,0, 'R',1);
            $fpdf->Ln();
        }
        $fpdf->SetFillColor(243,243,243);
        $fpdf->Cell(75,7,"Policy Number",0,0, 'L',1);
        $fpdf->Cell(200,7,$claim->policy->policy_number,0,0, 'R',1);
        $fpdf->Ln();
        $fpdf->SetFillColor(255,255,255);
        $fpdf->Cell(75,7,"DOB",0,0, 'L',1);
        $fpdf->Cell(200,7,date("M d Y", strtotime($claim->policy->customer->dob->i18nFormat('yyyy-MM-dd'))),0,0, 'R',1);
        $fpdf->Ln();
        $fpdf->SetFillColor(243,243,243);
        $fpdf->Cell(75,7,"Age",0,0, 'L',1);
        $fpdf->Cell(200,7,$age,0,0, 'R',1);
        $fpdf->Ln();
        $fpdf->SetFillColor(255,255,255);
        $fpdf->Cell(75,7,"Company",0,0, 'L',1);
        $fpdf->Cell(200,7,$claim->policy->company->name,0,0, 'R',1);
        $fpdf->Ln();
        $fpdf->SetFillColor(243,243,243);
        $fpdf->Cell(75,7,"Option",0,0, 'L',1);
        $fpdf->Cell(200,7,$claim->policy->option->name,0,0, 'R',1);
        $fpdf->Ln();
        $fpdf->SetFillColor(255,255,255);
        $fpdf->Cell(75,7,"Outside USA Deductible",0,0, 'L',1);
        $fpdf->Cell(200,7,number_format($claim->policy->deductible, 2, ".", ","),0,0, 'R',1);
        $fpdf->Ln();
        $fpdf->SetFillColor(243,243,243);
        $fpdf->Cell(75,7,"USA Deductible",0,0, 'L',1);
        $fpdf->Cell(200,7,number_format($claim->policy->usa_deductible, 2, ".", ","),0,0, 'R',1);
        $fpdf->Ln();
        $fpdf->SetFillColor(255,255,255);
        $fpdf->Cell(75,7,"Max Coverage",0,0, 'L',1);
        $fpdf->Cell(200,7,number_format($claim->policy->max_coverage, 2, ".", ","),0,0, 'R',1);
        $fpdf->Ln();
        $fpdf->SetFillColor(243,243,243);
        $fpdf->Cell(75,7,"Status",0,0, 'L',1);
        if($claim->status == 1){
            $fpdf->Cell(200,7,"Open",0,0, 'R',1);
        }else{
            $fpdf->Cell(200,7,"Closed",0,0, 'R',1);
        }

        $fpdf->Ln();
        $fpdf->SetFillColor(255,255,255);
        $fpdf->Cell(75,7,"Effective Date",0,0, 'L',1);
        $fpdf->Cell(200,7,date("M d Y", strtotime($claim->policy->effective_date->i18nFormat('yyyy-MM-dd'))),0,0, 'R',1);
        
        $fpdf->Ln(15);

        $fpdf->SetFillColor(255,255,255);
        $fpdf->SetFont('Arial','B',10);
        $fpdf->Cell(275,7,$claim->title,'T-L-R',0, 'C',1);
        $fpdf->Ln();
        $fpdf->SetFont('Arial','',10);
        $fpdf->Cell(275,7,$claim->description,'L-R-B',0, 'C',1);
        $fpdf->SetFont('Arial','B',8);
        $fpdf->Ln();
        $fpdf->Cell(155,7,'Provider / Service / Contact Info','T-L-R-B',0, 'L',1);
        $fpdf->Cell(30,7,'Type','T-L-R-B',0, 'C',1);
        $fpdf->Cell(20,7,'Received','T-L-R-B',0, 'C',1);
        $fpdf->Cell(20,7,'Serviced','T-L-R-B',0, 'C',1);
        $fpdf->Cell(20,7,'Processed','T-L-R-B',0, 'C',1);
        $fpdf->Cell(30,7,'Amount','T-L-R-B',0, 'C',1);
        $fpdf->SetFont('Arial','',8);
        $total = 0;
        foreach($claim->claims_types as $ct){
            $hex = $ct->type->color;
            list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");    
            $fpdf->SetFillColor($r,$g,$b);        
            $total = $total + $ct->amount;
            $fpdf->Ln();
            $fpdf->Cell(155,7,$ct->title." - ".$ct->description,'T-L-R-B',0, 'L',1);
            $fpdf->Cell(30,7,$ct->type->name,'T-L-R-B',0, 'C',1);
            if(!empty($ct->received_date)) {
                $fpdf->Cell(20,7,date('M d Y', strtotime($ct->received_date->i18nFormat('yyyy-MM-dd'))),'T-L-R-B',0, 'C',1);
            }else{
                $fpdf->Cell(20,7,'','T-L-R-B',0, 'C',1);
            }

            if(!empty($ct->service_date)) {
                $fpdf->Cell(20,7,date('M d Y', strtotime($ct->service_date->i18nFormat('yyyy-MM-dd'))),'T-L-R-B',0, 'C',1);
            }else{
                $fpdf->Cell(20,7,'','T-L-R-B',0, 'C',1);
            }

            if(!empty($ct->processed_date)) {
                $fpdf->Cell(20,7,date('M d Y', strtotime($ct->processed_date->i18nFormat('yyyy-MM-dd'))),'T-L-R-B',0, 'C',1);
            }else{
               $fpdf->Cell(20,7,'','T-L-R-B',0, 'C',1); 
            }
            
            
            $fpdf->Cell(30,7,number_format($ct->amount, 2, ".", ",") ,'T-L-R-B',0, 'C',1); 
        }

        $fpdf->Ln();
        $fpdf->SetFont('Arial','B',10);
        $fpdf->SetFillColor(255,255,255);
        $fpdf->Cell(245,7,'Total','T-L-R-B',0, 'L',1);

        $fpdf->Cell(30,7,number_format($total, 2, ".", ","),'T-L-R-B',0, 'C',1);


        $fpdf->Output('I');
        die();
    }


    /**
     * Add Claim Type method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function addct()
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        $claimsType = $this->Claims->ClaimsTypes->newEmptyEntity();
        if ($this->request->is(['post', 'patch', 'put'])) {
            $data = $this->request->getData();
            $this->loadModel('Folders');
            $folder = $this->Folders->find("all", array("conditions" => array("tenant_id" => $this->Auth->user()['tenant_id'], 'is_claims' => 2)))->first()->id;
            $uploaded_file = $this->request->getData('attachment');
            $name = $uploaded_file->getClientFilename();
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $document_name = rand(1000,500000).".".$extension;
            $type = $uploaded_file->getClientMediaType();
            $path = $uploaded_file->getStream()->getMetadata('uri');

            if(!empty($name)){
                $data['attachment'] = $this->upload_s3_file($path, $document_name, "/claims/");
                $file = $this->Folders->Files->newEmptyEntity(); 
                $file->user_id = $this->Auth->user()['id']; 
                $file->tenant_id = $this->Auth->user()['tenant_id'];
                $file->location = $data['attachment'];
                $file->name = $data['title'];
                $file->folder_id = $folder;
                $file->description = $data['description'];
                $file->claim_id = $data['claim_id'];
                $this->Folders->Files->save($file);
            }

            
            $claimsType = $this->Claims->ClaimsTypes->patchEntity($claimsType, $data);
            $claimsType->tenant_id = $this->Auth->user()['tenant_id'];
            $claimsType->user_id = $this->Auth->user()['id'];

            if ($ident = $this->Claims->ClaimsTypes->save($claimsType)) {
                $ct = $this->Claims->ClaimsTypes->get($ident['id']);

                $this->Claims->ClaimsTypes->save($ct);

                $this->Flash->success(__('The claims type has been saved.'));

                return $this->redirect(['action' => 'view', $claimsType->claim_id]);
            }
            $this->Flash->error(__('The new information could not be added. Please contact administrator'));
            return $this->redirect(['action' => 'view', $claim->id]);
        }
    }


    public function deductible($claim_id, $ct){
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        $this->loadModel("Types");
        $types = $this->Types->find("all", array("conditions" => array("tenant_id" => $this->Auth->user()['tenant_id'], 'is_deductible' => 1) ));
        $claim = $this->Claims->get($claim_id, ['contain' => ['Policies']]);

        if($this->Auth->user()['tenant_id'] != $claim->tenant_id){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        
        $type_id = 0; 
        foreach($types as $type){
            $type_id = $type->id;
        }
        $claimType = $this->Claims->ClaimsTypes->newEmptyEntity(); 
        $claimType->claim_id = $claim_id;
        $claimType->type_id = $type_id;
        $claimType->title = "Deductible"; 
        $claimType->description = "Applied deductible on claim"; 
        $claimType->tenant_id = $this->Auth->user()['tenant_id'];
        $claimType->user_id = $this->Auth->user()['id'];
        $claimType->service_date = date("Y-m-d");
        $claimType->processed_date = date("Y-m-d");
        $claimType->received_date = date("Y-m-d");
        if($ct == 1){
            $claimType->amount = -$claim->policy->deductible;
            // apply full deductible
        }else{
            // 0 deductible
            $claimType->amount = 0;
        }
        $this->Claims->ClaimsTypes->save($claimType);

        return $this->redirect(['action' => 'view', $claim->id]);
    }


    /**
     * Edit method
     *
     * @param string|null $id Claim id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        $claim = $this->Claims->get($id, ['contain' => ['Policies']]);

        if($this->Auth->user()['tenant_id'] != $claim->tenant_id){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $claim = $this->Claims->patchEntity($claim, $this->request->getData());
            if ($this->Claims->save($claim)) {
                $this->Flash->success(__('The claim has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The claim could not be saved. Please, try again.'));
        }
        $policies = $this->Claims->Policies->find('list', ['order' => ['policy_number ASC'], 'conditions' => ['Policies.tenant_id' => $this->Auth->user()['tenant_id'], 'Policies.customer_id' => $claim->policy->customer_id]]);
        $types = $this->Claims->ClaimsTypes->Types->find('list', ['limit' => 200]);
        $customers = $this->Claims->Policies->Customers->find('list', ['order' => ['name ASC'], 'conditions' => ['Customers.tenant_id' => $this->Auth->user()['tenant_id']]]);
        $this->set(compact('claim', 'policies', 'customers', 'types'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Claim id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        if(!$this->authorize()){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }
        $this->request->allowMethod(['post', 'delete', 'get']);
        $claim = $this->Claims->get($id);

        if($this->Auth->user()['tenant_id'] != $claim->tenant_id){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }

        if ($this->Claims->delete($claim)) {
            $this->Flash->success(__('The claim has been deleted.'));
        } else {
            $this->Flash->error(__('The claim could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
