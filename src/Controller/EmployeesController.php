<?php
declare(strict_types=1);

namespace App\Controller;

use FPDF;
use PHPExcel; 
use PHPExcel_IOFactory;
use PHPExcel_Style_Border;
use PHPExcel_Worksheet_PageSetup;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Fill;
use PHPExcel_Cell_DataValidation;
use PHPExcel_Writer_Excel7;

/**
 * Employees Controller
 *
 * @property \App\Model\Table\EmployeesTable $Employees
 * @method \App\Model\Entity\Employee[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmployeesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $employees = $this->Employees->find("all", array('conditions' => array('Employees.tenant_id' => $this->Auth->user()['tenant_id'])))->contain(['Businesses', 'Groupings' => ['Companies'], 'Transactions']);

        $this->set(compact('employees'));
    }

    public function report($group_id = false){
        $employees = array();
        $business_id = "ZZZZ";
        $grouping_id = "ZZZZ";
        $groupings = [];
        $employees = $this->Employees->find("all")->contain(['Businesses', 'Families' => ['sort' => ['relationship DESC']], 'Groupings' => ['Companies']]); 
        $employees->where(['Employees.tenant_id' => $this->Auth->user()['tenant_id']]);
        if($this->request->is(['patch', 'put', 'post'])){
            if(!empty($this->request->getData()['business_id'])){
                $business_id = $this->request->getData()['business_id'];
                $groupings = $this->Employees->Groupings->find('list', ['conditions' => array('tenant_id' => $this->Auth->user()['tenant_id'], 'business_id' => $business_id), 'order' => 'grouping_number ASC']);
                $employees->where(['Employees.business_id' => $this->request->getData()['business_id']]);
            }
            if(!empty($this->request->getData()['grouping_id'])){
                $grouping_id = $this->request->getData()['grouping_id'];
                $employees->where(['Employees.grouping_id' => $this->request->getData()['grouping_id']]);
            }
        }

         $businesses = $this->Employees->Businesses->find('list', ['conditions' => array('tenant_id' => $this->Auth->user()['tenant_id']), 'order' => 'name ASC']);
        $this->set(compact('employees', 'businesses', 'business_id', 'grouping_id', 'groupings'));
    }

    public function exportexcel($business_id = 'ZZZZ', $grouping_id = 'ZZZZ'){
        $employees = $this->Employees->find("all")->contain(['Businesses', 'Families' => ['sort' => ['relationship DESC']], 'Groupings' => ['Companies']]); 
        $employees->where(['Employees.tenant_id' => $this->Auth->user()['tenant_id']]);
        $business = false;
        $relationships = array(1 => "Spouse", 2 => "Child", 3  => "Other", 4 => "Employee");
        $genders = array(1 => "Male", 2 => "Female", 3 => "Other");
        $group = false;
        if($business_id != 'ZZZZ'){
            $business = $this->Employees->Businesses->get($business_id);
            $employees->where(['Employees.business_id' => $business_id]);
        }

        if($grouping_id != 'ZZZZ'){
            $group = $this->Employees->Groupings->get($grouping_id);
            $employees->where(['Employees.grouping_id' => $grouping_id]);
        }

        require_once(ROOT . DS . 'vendor' . DS  . 'PHPExcel'  . DS . 'Classes' . DS . 'PHPExcel.php');
        require_once(ROOT . DS . 'vendor' . DS  . 'PHPExcel'  . DS . 'Classes' . DS . 'PHPExcel' . DS . 'IOFactory.php');

        $excel = new PHPExcel();
        
        $excel->getProperties()->setCreator("AR")
             ->setLastModifiedBy("AR System")
             ->setTitle("AR Exports")
             ->setSubject("AR Exports")
             ->setDescription("AR Exports");
        $excel->setActiveSheetIndex(0);
        $excel->getActiveSheet()->mergeCells('A1:I1');
        $sheet = $excel->getActiveSheet();
        $sheet->setTitle('Corporate Groups');
        if(!empty($business)){
            if(!empty($group)){
                $sheet->SetCellValue('A1', "Corporate Groups Report - ".$business->name." - ".$group->grouping_number);
            }else{
                $sheet->SetCellValue("A1", "Corporate Groups Report - ".$business->name); 
            }
        }else{
            if(!empty($group)){
                $sheet->SetCellValue("A1", "Corporate Groups Report - ".$group->grouping_number); 
            }else{
                $sheet->SetCellValue("A1", "Corporate Groups Report - All Corporate Groups included"); 
            }
        }
        
        

        // fill report here
        
        $sheet->SetCellValue('A2', '#');
        $sheet->SetCellValue('B2', 'Last Name');
        $sheet->SetCellValue('C2', 'First Name');
        $sheet->SetCellValue('D2', 'DOB');
        $sheet->SetCellValue('E2', 'Age');
        $sheet->SetCellValue('F2', 'Gender');
        $sheet->SetCellValue('G2', 'Residence');
        $sheet->SetCellValue('H2', 'Relationship');
        $sheet->SetCellValue('I2', 'Premium');

        $sheet->getColumnDimension('A')->setWidth(25);
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(12);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(12);

        $row = 3; $i=1;$real_total=0;

        foreach($employees as $employee){
            if($i % 2 == 0){
                $background = 'f2f2f2'; 
            }else{
                 $background = 'ffffff';
            }
            $i++;

            foreach($employee->families as $family){

                $age = "N/A";
                $dob = "N/A";
                
                if(!empty($family->dob)){
                    $dob = $family->dob->i18nFormat('yyyy-MM-dd');
                    $today = date("Y-m-d");
                    $diff = date_diff(date_create($dob), date_create($today));
                    $age = $diff->format('%y');
                }

                $sheet->SetCellValue('A'.$row, $employee->membership_number);
                $sheet->SetCellValue('B'.$row, $family->last_name);
                $sheet->SetCellValue('C'.$row, $family->first_name);

                if($dob != "N/A"){
                    $sheet->SetCellValue('D'.$row, date('m/d/Y', strtotime($dob)));
                }else{
                    $sheet->SetCellValue('D'.$row, $dob);
                }
                
                $sheet->SetCellValue('E'.$row, $age);
                $sheet->SetCellValue('F'.$row, $genders[$family->gender]);
                $sheet->SetCellValue('G'.$row, $family->country);
                $sheet->SetCellValue('H'.$row, $relationships[$family->relationship ]);
                $sheet->SetCellValue('I'.$row, number_format($family->premium, 2, ".", ","));
                $sheet->getStyle('A'.$row.":I".$row)->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => $background)
                        )
                        )
                    );

                $row++;
            }
        }

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

        $sheet->getStyle('A1:I'.($row-1))->applyFromArray($styleArray);

        $file = 'corporate_groups.xlsx';
        $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$file.'"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        die();
    }

    public function export($business_id = 'ZZZZ', $grouping_id = 'ZZZZ'){
        $employees = $this->Employees->find("all")->contain(['Businesses', 'Families' => ['sort' => ['relationship DESC']], 'Groupings' => ['Companies']]); 
        $employees->where(['Employees.tenant_id' => $this->Auth->user()['tenant_id']]);
        $business = false;
        $relationships = array(1 => "Spouse", 2 => "Child", 3  => "Other", 4 => "Employee");
        $genders = array(1 => "Male", 2 => "Female", 3 => "Other");
        $group = false;
        if($business_id != 'ZZZZ'){
            $business = $this->Employees->Businesses->get($business_id);
            $employees->where(['Employees.business_id' => $business_id]);
        }

        if($grouping_id != 'ZZZZ'){
            $group = $this->Employees->Groupings->get($grouping_id);
            $employees->where(['Employees.grouping_id' => $grouping_id]);
        }


        require_once(ROOT . DS . 'vendor' . DS  . 'fpdf'  . DS . 'fpdf.php');
        $fpdf = new FPDF();
        $fpdf->AddPage("L");
        $fpdf->SetFont('Arial','B',9);
        if(!empty($business)){
            if(!empty($group)){
                $fpdf->Cell(200,0,"Corporate Groups Report [ ".$business->name." - ".$group->grouping_number." ]",0,0, 'L');
            }else{
                $fpdf->Cell(200,0,"Corporate Groups Report [ ".$business->name." ]",0,0, 'L');
            }
        }else{
            if(!empty($group)){
                $fpdf->Cell(200,0,"Corporate Groups Report [ ".$group->grouping_number." ]",0,0, 'L');
            }else{
                $fpdf->Cell(200,0,"Corporate Groups Report [ All Corporate Groups included ]",0,0, 'L');
            }
        }
        $fpdf->Ln(7);
        $fpdf->Cell(275,0,"",'B',0, 'R');
        $fpdf->Ln(5);

        $fpdf->SetFont('Arial','B',8);
        $fpdf->SetFillColor(220,220,220);
        $fpdf->Cell(275,7,"Employees","T-L-R",0, 'L', 1);
        
        $fpdf->Ln(7);
        $fpdf->Cell(35,7,"#",'T-L-B',0, 'C');
        
        $fpdf->Cell(50,7,"Last Name",'T-L-B',0, 'C');
        $fpdf->Cell(50,7,"First Name",'T-L-B',0, 'C');
        $fpdf->Cell(25,7,"DOB",'T-L-B',0, 'C');
        
        $fpdf->Cell(17,7,"Age",'T-L-B',0, 'C');
        $fpdf->Cell(25,7,"Gender",'T-L-B-R',0, 'C');
        $fpdf->Cell(25,7,"Residence",'T-L-B',0, 'C');
        $fpdf->Cell(25,7,"Relationship",'T-L-B-R',0, 'C');
        $fpdf->Cell(23,7,"Premium",'T-L-B-R',0, 'C');
        
        $fpdf->Ln(7);
        $fpdf->SetFont('Arial','',7);

        $i=1; $real_total = 0; 
        foreach($employees as $employee){
            if($i % 2 == 0){
                $fpdf->SetFillColor(236,236,236);
            }else{
                $fpdf->SetFillColor(255,255,255);
            }
            $i++;
            foreach($employee->families as $family) {
                $age = "N/A";
                $dob = "N/A";
                if(!empty($family->dob)){
                    $dob = $family->dob->i18nFormat('yyyy-MM-dd');
                    $today = date("Y-m-d");
                    $diff = date_diff(date_create($dob), date_create($today));
                    $age = $diff->format('%y');
                }

                $fpdf->Cell(35,7,$employee->membership_number,'T-L-B',0, 'C',1);
        
                $fpdf->Cell(50,7,$family->last_name,'T-L-B',0, 'C',1);
                $fpdf->Cell(50,7,$family->first_name,'T-L-B',0, 'C',1);
                if($dob != "N/A"){
                    $fpdf->Cell(25,7,date('m/d/Y', strtotime($dob)) ,'T-L-B',0, 'C',1);
                }else{
                    $fpdf->Cell(25,7,$dob ,'T-L-B',0, 'C',1);
                }
                
                
                $fpdf->Cell(17,7,$age,'T-L-B',0, 'C',1);
                $fpdf->Cell(25,7,$genders[$family->gender],'T-L-B-R',0, 'C',1);
                $fpdf->Cell(25,7,$family->country,'T-L-B',0, 'C',1);
                $fpdf->Cell(25,7,$relationships[$family->relationship ],'T-L-B-R',0, 'C',1);
                $fpdf->Cell(23,7,number_format($family->premium, 2, ".", ","),'T-L-B-R',0, 'C',1);
                
                $fpdf->Ln(7);
            }
        }

        $fpdf->Output('I');
        die();
    }

    /**
     * View method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $employee = $this->Employees->get($id, [
            'contain' => ['Businesses', 'Groupings', 'Families'],
        ]);

        $this->set(compact('employee'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $employee = $this->Employees->newEmptyEntity();
        if ($this->request->is('post')) {
            $employee = $this->Employees->patchEntity($employee, $this->request->getData());
            $employee->tenant_id = $this->Auth->user()['tenant_id'];
            if ($ident = $this->Employees->save($employee)) {
                $this->Flash->success(__('The employee has been saved.'));
                    $this->loadModel("Families");
                    $family = $this->Families->newEmptyEntity(); 
                    $family->first_name = $ident['first_name'];
                    $family->last_name = $ident['last_name'];
                    $family->relationship = 4;
                    $family->tenant_id = $this->Auth->user()['tenant_id'];
                    $family->dob = $this->request->getData()['dob'];
                    $family->premium = $this->request->getData()['premium']; 
                    $family->employee_id = $ident['id']; 
                    $family->gender = $this->request->getData()['gender']; 
                    $family->country = $this->request->getData()['country'];
                    $family->status = 1 ;
                    $this->Families->save($family);

                return $this->redirect(['action' => 'view', $employee->id]);
            }
            $this->Flash->error(__('The employee could not be saved. Please, try again.'));
        }
        $businesses = $this->Employees->Businesses->find('list', ['order' => ['name ASC'], 'conditions' => ['tenant_id' => $this->Auth->user()['tenant_id']]]);
        $this->set(compact('employee', 'businesses'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function addfamily()
    {
        $family = $this->Employees->Families->newEmptyEntity();
        if ($this->request->is('post')) {
            $family = $this->Employees->Families->patchEntity($family, $this->request->getData());
            $family->tenant_id = $this->Auth->user()['tenant_id'];
            if ($this->Employees->Families->save($family)) {
                return $this->redirect(['action' => 'view', $family->employee_id]);
            }
        }

        return $this->redirect($this->referer());
    }

    /**
     * Edit method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $employee = $this->Employees->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $employee = $this->Employees->patchEntity($employee, $this->request->getData());
            if ($this->Employees->save($employee)) {
                $this->Flash->success(__('The employee has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee could not be saved. Please, try again.'));
        }
        $businesses = $this->Employees->Businesses->find('list', ['limit' => 200]);
        $groupings = $this->Employees->Groupings->find('list', ['limit' => 200, 'conditions' => ['business_id' => $employee->business_id]]);
        $this->set(compact('employee', 'businesses', 'groupings'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $employee = $this->Employees->get($id);
        $families = $this->Employees->Families->find("all", array("conditions" => array('employee_id' => $employee->id)));
        foreach($families as $family){
            $this->Employees->Families->delete($family);
        }
        if ($this->Employees->delete($employee)) {
            $this->Flash->success(__('The employee has been deleted.'));
        } else {
            $this->Flash->error(__('The employee could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function list(){
        if($this->request->is(['ajax'])){
            $employees = $this->Employees->find("all", array('order' => ['last_name ASC'], "conditions" => array("grouping_id" => $this->request->getData()['group_id'], 'tenant_id' => $this->Auth->user()['tenant_id'])));
            echo json_encode($employees->toArray()); 
        }
        die();
    }
}
