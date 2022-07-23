<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Companies Controller
 *
 * @property \App\Model\Table\CompaniesTable $Companies
 * @method \App\Model\Entity\Company[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CompaniesController extends AppController
{

    public function beforeFilter(EventInterface $event){
        parent::beforeFilter($event);
    }


    public function authorize(){
        if($this->Auth->user()['role_id'] == 2){

            if($this->request->getParam('action') == 'index' && ($this->authorizations[10] || $this->authorizations[12])){
                return true;
            }

            if($this->request->getParam('action') == 'add' && $this->authorizations[12]){
                return true;
            }

            if($this->request->getParam('action') == 'edit' && $this->authorizations[12]){
                return true;
            }

            if($this->request->getParam('action') == 'delete' && $this->authorizations[12]){
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
        $this->savelog(200, "Accessed company page", 1, 3, "", "");
        $companies = $this->Companies->find("all", array("conditions" => array("Companies.tenant_id" => $this->Auth->user()['tenant_id'])))->contain(['Users', 'Options', 'Policies', 'Countries']);

        $this->set(compact('companies'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $company = $this->Companies->newEmptyEntity();
        if ($this->request->is('post')) {
            $company = $this->Companies->patchEntity($company, $this->request->getData());
            $company->user_id = $this->Auth->user()['id'];
            $company->country_id = 1;
            $company->tenant_id = $this->Auth->user()['tenant_id'];
            if ($this->Companies->save($company)) {
                $this->savelog(200, "Created company", 1, 1, "", json_encode($company));
                $this->Flash->success(__('The company has been saved.'));

                return $this->redirect(['action' => 'edit', $company->id]);
            }else{
                $this->savelog(500, "Tempted to create company", 0, 1, "", json_encode($company));
            }
            $this->Flash->error(__('The company could not be saved. Please, try again.'));
        }
        $countries = $this->Companies->Countries->find("list");
        $this->set(compact('company', 'countries'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Company id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $company = $this->Companies->get($id, [
            'contain' => ['Options' => ['Users', 'Policies']],
        ]);
        $old_data = json_encode($company);
        $option = $this->Companies->Options->newEmptyEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $company = $this->Companies->patchEntity($company, $this->request->getData());
            if ($this->Companies->save($company)) {
                $this->savelog(200, "Edited company", 1, 2, $old_data, json_encode($company));
                $this->Flash->success(__('The company has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->savelog(500, "Tempted to edit company", 0, 2, $old_data, json_encode($company));
            $this->Flash->error(__('The company could not be saved. Please, try again.'));
        }
        $countries = $this->Companies->Countries->find("list");
        $this->set(compact('company', 'option', 'countries'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Company id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $company = $this->Companies->get($id);
        if ($this->Companies->delete($company)) {
            $this->Flash->success(__('The company has been deleted.'));
        } else {
            $this->Flash->error(__('The company could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function options(){
        if($this->request->is(['ajax'])){
            $options = $this->Companies->Options->find("all", array("conditions" => array("company_id" => $this->request->getData()['company_id'])));
            echo json_encode($options->toArray()); 
        }
        die();
    }


    public function option(){
        if($this->request->is(['ajax'])){
            $option = $this->Companies->Options->get($this->request->getData()['option_id']);
            echo json_encode($option); 
        }
        die();
    }
}
