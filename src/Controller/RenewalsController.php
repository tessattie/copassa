<?php
declare(strict_types=1);

namespace App\Controller;
use PHPExcel; 
use PHPExcel_IOFactory;
use PHPExcel_Style_Border;
use PHPExcel_Worksheet_PageSetup;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Fill;
use PHPExcel_Cell_DataValidation;
use PHPExcel_Writer_Excel7;

/**
 * Renewals Controller
 *
 * @property \App\Model\Table\RenewalsTable $Renewals
 * @method \App\Model\Entity\Renewal[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RenewalsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $businesses = $this->Renewals->Businesses->find("list", array("conditions" => array("tenant_id" => $this->Auth->user()['tenant_id']), "order" => array("name ASC")));
        $renewals = $this->Renewals->find("all", array("conditions" => array("Renewals.tenant_id" => $this->Auth->user()['tenant_id'])))->contain(['Businesses', 'Transactions']);

        $this->set(compact('renewals', 'businesses'));
    }

    public function process($id){
        $renewal = $this->Renewals->get($id, ['contain' => ['Businesses']]);
        // debug($renewal); die();
        $this->loadModel('Employees');
        $employees = $this->Employees->find("all")->contain(['Businesses', 'Families' => ['sort' => ['relationship DESC']], 'Groupings' => ['Companies']]); 
        $employees->where(['Employees.tenant_id' => $this->Auth->user()['tenant_id']]);
        $employees->where(['Employees.business_id' => $renewal->business_id]);
        if($this->request->is(['patch', 'put', 'post'])){
            // process renewal and redirect to view page
            $this->loadModel("Transactions");$this->loadModel("Families");
            foreach($this->request->getData()['family_id'] as $i => $family_id){
                $member = $this->Families->get($family_id, ['contain' => ['Employees']]);
                $transaction = $this->Transactions->newEmptyEntity();
                $transaction->type = 1; 
                $transaction->credit = 0; 
                $transaction->debit = $member->premium; 
                $transaction->family_id = $family_id;
                $transaction->business_id = $renewal->business_id;
                $transaction->employee_id = $member->employee_id;
                $transaction->grouping_id = $member->employee->grouping_id;
                $transaction->user_id = $this->Auth->user()['id'];
                $transaction->renewal_id = $renewal->id; 
                $transaction->tenant_id = $this->Auth->user()['tenant_id'];
                $this->Transactions->save($transaction);
            }

            return $this->redirect(['action' => 'view', $renewal->id]);
        }

        $this->set(compact('renewal', 'employees'));
    }

    /**
     * View method
     *
     * @param string|null $id Renewal id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $renewal = $this->Renewals->get($id, [
            'contain' => ['Businesses' => ['Groupings'], 'Users', 'Transactions' => ['Families', 'Employees' => ['sort' => ['Employees.type ASC']], 'sort' => ['Transactions.employee_id']]],
        ]);

        $this->loadModel('Groupings');

        $groups = $this->Groupings->find("all", array("conditions" => array("tenant_id" => $this->Auth->user()['tenant_id'], 'business_id' => $renewal->business_id)));

        $groupings = $this->Groupings->find("list", array("conditions" => array("tenant_id" => $this->Auth->user()['tenant_id'], 'business_id' => $renewal->business_id)));

        $employees = $this->Renewals->Transactions->Employees->find("list", array("order" => array('last_name ASC'), "conditions" => array("tenant_id" => $this->Auth->user()['tenant_id'], "business_id" => $renewal->business_id)));

        $this->set(compact('renewal', 'groups', 'groupings', 'employees'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $renewal = $this->Renewals->newEmptyEntity();
            $renewal = $this->Renewals->patchEntity($renewal, $this->request->getData());
            $business_id = $renewal->business_id;
            $renewal->tenant_id = $this->Auth->user()['tenant_id'];
            $renewal->user_id = $this->Auth->user()['id']; 
            if ($this->Renewals->save($renewal)) {
                return $this->redirect(['action' => 'process', $renewal->id]);
            }
        }
    }

    public function addemployee()
    {
        $employee = $this->Renewals->Businesses->Groupings->Employees->newEmptyEntity();
        if ($this->request->is('post')) {
            $employee = $this->Renewals->Businesses->Groupings->Employees->patchEntity($employee, $this->request->getData());
            $employee->tenant_id = $this->Auth->user()['tenant_id'];
            if ($ident = $this->Renewals->Businesses->Groupings->Employees->save($employee)) {
                $this->loadModel("Families");
                    $family = $this->Families->newEmptyEntity(); 
                    $family->first_name = $ident['first_name'];
                    $family->last_name = $ident['last_name'];
                    $family->relationship = 4;
                    $family->dob = $this->request->getData()['dob'];
                    $family->premium = $this->request->getData()['premium']; 
                    $family->employee_id = $ident['id']; 
                    $family->tenant_id = $this->Auth->user()['tenant_id'];
                    $family->gender = $this->request->getData()['gender']; 
                    $family->country = $this->request->getData()['country'];
                    $family->status = 1 ;
                    if($fam = $this->Families->save($family)){
                        // create transaction with full premium 
                        $this->loadModel("Transactions");
                        $transaction = $this->Transactions->newEmptyEntity();
                        $transaction->type = 1; 
                        $transaction->credit = 0; 
                        $transaction->debit = $fam->premium; 
                        $transaction->family_id = $fam->id;
                        $transaction->business_id = $employee->business_id;
                        $transaction->employee_id = $employee->id;
                        $transaction->grouping_id = $employee->grouping_id;
                        $transaction->user_id = $this->Auth->user()['id'];
                        $transaction->renewal_id = $this->request->getData()['renewal_id']; 
                        $transaction->tenant_id = $this->Auth->user()['tenant_id'];
                        $this->Transactions->save($transaction);
                        // create transaction with refunded premium 
                        if($fam->premium - $this->request->getData()['debit'] != 0){
                            $transaction = $this->Transactions->newEmptyEntity();
                            $transaction->type = 4; 
                            $transaction->credit = $fam->premium - $this->request->getData()['debit']; 
                            $transaction->debit = 0; 
                            $transaction->family_id = $fam->id;
                            $transaction->business_id = $employee->business_id;
                            $transaction->employee_id = $employee->id;
                            $transaction->grouping_id = $employee->grouping_id;
                            $transaction->user_id = $this->Auth->user()['id'];
                            $transaction->renewal_id = $this->request->getData()['renewal_id']; 
                            $transaction->tenant_id = $this->Auth->user()['tenant_id'];
                            $this->Transactions->save($transaction);
                        }
                    }
                return $this->redirect(['action' => 'view', $this->request->getData()['renewal_id']]);
            }
        }

        return $this->redirect($this->referer());
    }


    public function addfamily()
    {
        $this->loadModel("Employees");
        $family = $this->Employees->Families->newEmptyEntity();
        if ($this->request->is('post')) {

            $family = $this->Employees->Families->patchEntity($family, $this->request->getData());
            $family->tenant_id = $this->Auth->user()['tenant_id'];
            if ($fam = $this->Employees->Families->save($family)) {

            $this->loadModel("Transactions");
            $transaction = $this->Transactions->newEmptyEntity();
            $transaction->type = 1; 
            $transaction->credit = 0; 
            $transaction->debit = $fam->premium; 
            $transaction->family_id = $fam->id;
            $transaction->business_id = $this->request->getData()['business_id']; 
            $transaction->employee_id = $this->request->getData()['employee_id']; 
            $transaction->grouping_id = $this->request->getData()['grouping_id']; 
            $transaction->user_id = $this->Auth->user()['id'];
            $transaction->renewal_id = $this->request->getData()['renewal_id']; 
            $transaction->tenant_id = $this->Auth->user()['tenant_id'];
            $this->Transactions->save($transaction);
            // create transaction with refunded premium 
            if($fam->premium - $this->request->getData()['debit'] != 0){
                $transaction = $this->Transactions->newEmptyEntity();
                $transaction->type = 4; 
                $transaction->credit = $fam->premium - $this->request->getData()['debit']; 
                $transaction->debit = 0; 
                $transaction->family_id = $fam->id;
                $transaction->business_id = $this->request->getData()['business_id']; 
                $transaction->employee_id = $this->request->getData()['employee_id']; 
                $transaction->grouping_id = $this->request->getData()['grouping_id']; 
                $transaction->user_id = $this->Auth->user()['id'];
                $transaction->renewal_id = $this->request->getData()['renewal_id']; 
                $transaction->tenant_id = $this->Auth->user()['tenant_id'];
                $this->Transactions->save($transaction);
            }
                
            }
        }

        return $this->redirect(['action' => 'view', $this->request->getData()['renewal_id']]);
    }

    /**
     * Edit method
     *
     * @param string|null $id Renewal id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $renewal = $this->Renewals->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $renewal = $this->Renewals->patchEntity($renewal, $this->request->getData());
            if ($this->Renewals->save($renewal)) {
                $this->Flash->success(__('The renewal has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The renewal could not be saved. Please, try again.'));
        }
        $businesses = $this->Renewals->Businesses->find('list', ['limit' => 200]);
        $groups = $this->Renewals->Groupings->find('list', ['limit' => 200]);
        $users = $this->Renewals->Users->find('list', ['limit' => 200]);
        $this->set(compact('renewal', 'businesses', 'groups', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Renewal id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $renewal = $this->Renewals->get($id);
        if ($this->Renewals->delete($renewal)) {
            $this->Flash->success(__('The renewal has been deleted.'));
        } else {
            $this->Flash->error(__('The renewal could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function addtransaction(){
        if($this->request->is(['patch', 'put', 'post'])){
            $renewal = $this->Renewals->get($this->request->getData()['renewal_id']);
            $this->loadModel('Transactions');
            $transaction = $this->Transactions->newEmptyEntity();
            if(!empty($this->request->getData()['employee_id'])){
                $employee = $this->Transactions->Employees->get($this->request->getData()['employee_id']);
                $transaction->grouping_id = $employee->grouping_id;
                $transaction->employee_id = $employee->id;
            }

            if(!empty($this->request->getData()['family_id'])){
                $family_member = $this->Transactions->Families->get($this->request->getData()['family_id']);
                $transaction->family_id = $family_member->id; 
            }
            
            
            $transaction->business_id = $renewal->business_id;
            $transaction->tenant_id = $this->Auth->user()['tenant_id'];
            
            if($this->request->getData()["operation"] == 1){
                $transaction->credit = $this->request->getData()["amount"];  
                $transaction->debit = 0;
            }else{
                $transaction->debit = $this->request->getData()["amount"];  
                $transaction->credit = 0; 
            }
            
            $transaction->type = $this->request->getData()['type'];
            $transaction->status = $this->request->getData()['status'];
            $transaction->renewal_id = $renewal->id;
            $transaction->memo = $this->request->getData()['memo'];
            $transaction->user_id = $this->Auth->user()['id'];
            $this->Transactions->save($transaction);
            return $this->redirect(['action' => 'view', $renewal->id]);
        }
        return $this->redirect($this->referer());
    }

    public function confirmtransaction(){
        if($this->request->is(['patch', 'put', 'post'])){
            $transaction = $this->Renewals->Transactions->get($this->request->getData()['transaction_id']);
            $transaction->status = 2;
            $transaction->credit = $this->request->getData()['credit'];
            $transaction->debit = $this->request->getData()['debit'];
            $transaction->memo = $this->request->getData()['memo'];
            $this->Renewals->Transactions->save($transaction);
        }

        $this->redirect($this->referer());
    }


    public function exportexcel($renewal_id){
        $renewal = $this->Renewals->get($renewal_id, [
            'contain' => ['Businesses' => ['Groupings'], 'Users', 'Transactions' => ['Families', 'Employees' => ['sort' => ['Employees.type ASC']], 'sort' => ['Transactions.employee_id']]],
        ]);

        $this->loadModel('Groupings');

        $groups = $this->Groupings->find("all", array("conditions" => array('tenant_id' => $this->Auth->user()['tenant_id'], 'business_id' => $renewal->business_id)));

        $groupings = $this->Groupings->find("list", array("conditions" => array('tenant_id' => $this->Auth->user()['tenant_id'], 'business_id' => $renewal->business_id)));

        $employees = $this->Renewals->Transactions->Employees->find("list", array( "order" => array('last_name ASC'), "conditions" => array('tenant_id' => $this->Auth->user()['tenant_id'], "business_id" => $renewal->business_id)));

        require_once(ROOT . DS . 'vendor' . DS  . 'PHPExcel'  . DS . 'Classes' . DS . 'PHPExcel.php');
        require_once(ROOT . DS . 'vendor' . DS  . 'PHPExcel'  . DS . 'Classes' . DS . 'PHPExcel' . DS . 'IOFactory.php');

        $excel = new PHPExcel();
        
        $excel->getProperties()->setCreator("Copassa")
             ->setLastModifiedBy("Copassa System")
             ->setTitle("Copassa Exports")
             ->setSubject("Copassa Exports")
             ->setDescription("Copassa Exports");
        $excel->setActiveSheetIndex(0);
        $excel->getActiveSheet()->setTitle('Summary');
        $excel->createSheet(1);
        $excel->setActiveSheetIndex(1);
            $excel->getActiveSheet()->setTitle('Transactions');
        $i=2;

        // groupings part
        $total_premiums = 0;
        foreach($groups as $group){
            $excel->createSheet($i);
            $excel->setActiveSheetIndex($i);
            $excel->getActiveSheet()->setTitle($group->grouping_number);
            $sheet = $excel->getActiveSheet();
            $sheet->SetCellValue("A1", $group->grouping_number); 
            $excel->getActiveSheet()->mergeCells('A1:I1');
            $sheet->SetCellValue('A2', '#');
            $sheet->SetCellValue('B2', 'Last Name');
            $sheet->SetCellValue('C2', 'First Name');
            $sheet->SetCellValue('D2', 'DOB');
            $sheet->SetCellValue('E2', 'Age');
            $sheet->SetCellValue('F2', 'Gender');
            $sheet->SetCellValue('G2', 'Relationship');
            $sheet->SetCellValue('H2', 'Type');
            $sheet->SetCellValue('I2', 'Premium');

            $sheet->getColumnDimension('A')->setWidth(15);
            $sheet->getColumnDimension('B')->setWidth(20);
            $sheet->getColumnDimension('C')->setWidth(20);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('E')->setWidth(10);
            $sheet->getColumnDimension('F')->setWidth(12);
            $sheet->getColumnDimension('G')->setWidth(15);
            $sheet->getColumnDimension('H')->setWidth(12);
            $sheet->getColumnDimension('I')->setWidth(12);

            $row = 3;
            $membership_number = 'sdfsdf'; $background = 'ffffff'; $total_credit = 0; $total_debit = 0;
            foreach($renewal->transactions as $transaction){
                if($transaction->grouping_id == $group->id && !empty($transaction->family_id) && $transaction->type == 1){
                    $total_credit = $total_credit + $transaction->credit;
                    $total_debit = $total_debit + $transaction->debit;
                    $age = "N/A";
                    if(!empty($transaction->family->dob)){
                        $dob = $transaction->family->dob->year."-".$transaction->family->dob->month."-".$transaction->family->dob->day;
                        $today = date("Y-m-d");
                        $diff = date_diff(date_create($dob), date_create($today));
                        $age = $diff->format('%y');
                    }

                    if($transaction->employee->membership_number != $membership_number){
                        if($background == 'ffffff'){
                            $background = 'f2f2f2'; 
                        }else{
                            $background = 'ffffff'; 
                        }
                    }

                    $sheet->getStyle('A'.$row.":I".$row)->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => $background)
                        )
                    )
                );

                    $membership_number = $transaction->employee->membership_number;


                    $sheet->SetCellValue('A'.$row, $transaction->employee->membership_number);
                    $sheet->SetCellValue('B'.$row, $transaction->family->last_name);
                    $sheet->SetCellValue('C'.$row, $transaction->family->first_name);
                    $sheet->SetCellValue('D'.$row, date('m/d/Y', strtotime($dob)));
                    $sheet->SetCellValue('E'.$row, $age);
                    $sheet->SetCellValue('F'.$row, $this->genders[$transaction->family->gender]);
                    $sheet->SetCellValue('G'.$row, $this->relationships[$transaction->family->relationship]);
                    $sheet->SetCellValue('H'.$row, 'PREMIUM');
                    $sheet->SetCellValue('I'.$row, $transaction->debit);
                    $sheet->getStyle('I'.$row)->getNumberFormat()->setFormatCode( '#,##0.00' );
                    $row++;
                }
            }
                $sheet->SetCellValue('A'.$row, "TOTAL");
                $sheet->mergeCells('A'.$row.':H'.$row);
                $sheet->SetCellValue('I'.$row, $total_debit);
                $total_premiums = $total_premiums + $total_debit;
                $sheet->getStyle('I'.$row)->getNumberFormat()->setFormatCode( '#,##0.00' );
                $sheet->getStyle( "A".$row.":I".$row )->getFont()->setBold( true );

                $styleArray = array(
                  'borders' => array(
                    'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                  ),
                  'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );

                $sheet->getStyle('A1:I'.($row))->applyFromArray($styleArray);
            $i++;
        }

        $sheet = $excel->setActiveSheetIndex(1); 

        // transactions part
        $sheet->SetCellValue("A1", 'Transactions'); 
        $excel->getActiveSheet()->mergeCells('A1:H1');
        $sheet->SetCellValue('A2', 'Date');
        $sheet->SetCellValue('B2', 'Membership');
        $sheet->SetCellValue('C2', 'Employee');
        $sheet->SetCellValue('D2', 'Family Member');
        $sheet->SetCellValue('E2', 'Type');
        $sheet->SetCellValue('F2', 'Credit');
        $sheet->SetCellValue('G2', 'Debit');
        $sheet->SetCellValue('H2', 'Memo');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(12);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(20);

        $total_credit = 0; $total_debit = 0; $row = 3; $total_payments=0; $total_cancelations =0;
        foreach($renewal->transactions as $transaction){
            if($transaction->type != 1){
                $total_credit = $total_credit + $transaction->credit; $total_debit = $total_debit + $transaction->debit;

                $sheet->SetCellValue('A'.$row, $transaction->created->month."/".$transaction->created->day."/".$transaction->created->year);
                if(!empty($transaction->employee)){
                    $sheet->SetCellValue('B'.$row, $transaction->employee->membership_number);
                }else{
                    $sheet->SetCellValue('B'.$row, '');
                }

                if(!empty($transaction->employee)){
                    $sheet->SetCellValue('C'.$row, ($transaction->employee->first_name. " ".$transaction->employee->last_name));
                }else{
                    $sheet->SetCellValue('C'.$row, '');
                }

                if(!empty($transaction->family)){
                    $sheet->SetCellValue('D'.$row, ($transaction->family->first_name. " ".$transaction->family->last_name));
                }else{
                    $sheet->SetCellValue('D'.$row, '');
                }

                if($transaction->type == 1){
                    $sheet->SetCellValue('E'.$row, 'PREMIUM');
                }elseif($transaction->type == 2){
                    $sheet->SetCellValue('E'.$row, 'PAYMENT');
                    $total_payments = $total_payments + $transaction->credit;
                }
                elseif($transaction->type == 4){
                    $sheet->SetCellValue('E'.$row, 'REFUND');
                    $total_payments = $total_payments + $transaction->credit;
                }else{
                    $sheet->SetCellValue('E'.$row, 'CANCELATION');
                    $total_cancelations = $total_cancelations + $transaction->credit;
                }

                if($transaction->credit > 0){
                    $sheet->SetCellValue('F'.$row, $transaction->credit);
                    $sheet->getStyle('F'.$row)->getNumberFormat()->setFormatCode( '#,##0.00' );
                }else{
                    $sheet->SetCellValue('F'.$row, 0);
                }


                if($transaction->debit > 0){
                    $sheet->SetCellValue('G'.$row, $transaction->debit);
                    $sheet->getStyle('G'.$row)->getNumberFormat()->setFormatCode( '#,##0.00' );
                }else{
                    $sheet->SetCellValue('G'.$row, 0);   
                }
                
                $sheet->SetCellValue('H'.$row, $transaction->memo);
                $row++;
            }
        }

        $sheet->SetCellValue('A'.$row, "TOTAL ( ".number_format(($total_debit - $total_credit), 2, ".", ",")." )");
        $sheet->mergeCells('A'.$row.':E'.$row);
        $sheet->SetCellValue('G'.$row, $total_debit);
        $sheet->SetCellValue('F'.$row, $total_credit);
        $sheet->getStyle('G'.$row)->getNumberFormat()->setFormatCode( '#,##0.00' );
        $sheet->getStyle('F'.$row)->getNumberFormat()->setFormatCode( '#,##0.00' );
        $sheet->getStyle( "A".$row.":I".$row )->getFont()->setBold( true );

        $sheet->getStyle('A1:H'.($row))->applyFromArray($styleArray);


        $sheet = $excel->setActiveSheetIndex(0);
        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->SetCellValue('A1', "Company");
        $sheet->SetCellValue('A2', "Created");
        $sheet->SetCellValue('A3', "Renewal Year");
        $sheet->SetCellValue('A4', "Groups");
        $sheet->SetCellValue('A5', "Premium");
        $sheet->SetCellValue('A6', "Payments / Refunds");
        $sheet->SetCellValue('A7', "Cancelations");
        $sheet->SetCellValue('A8', "Balance");

        $sheet->SetCellValue('B1', $renewal->business->name);
        $sheet->SetCellValue('B2', $renewal->created->month."/".$renewal->created->day."/".$renewal->created->year);
        $sheet->SetCellValue('B3', $renewal->year);
        $sheet->SetCellValue('B4', $groups->count());
        $sheet->SetCellValue('B5', $total_premiums);
        $sheet->SetCellValue('B6', $total_payments);
        $sheet->SetCellValue('B7', $total_cancelations);
        $sheet->SetCellValue('B8', ($total_premiums - $total_payments - $total_cancelations));

        $styleArray = array(
                  'borders' => array(
                    'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                  ),
                  'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );

        $sheet->getStyle('A1:A8')->applyFromArray($styleArray);
        $styleArray = array(
                  'borders' => array(
                    'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                  ),
                  'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );

        $sheet->getStyle('B1:B8')->applyFromArray($styleArray);
        $file = 'renewal_report_'.$renewal->business->name.'_'.$renewal->year.'.xlsx';
        $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$file.'"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        die();
    }


    public function exportpdf($renewal_id){

    }
}
