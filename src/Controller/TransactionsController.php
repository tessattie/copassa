<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Transactions Controller
 *
 * @property \App\Model\Table\TransactionsTable $Transactions
 * @method \App\Model\Entity\Transaction[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TransactionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Employees', 'Businesses', 'Groupings', 'Users', 'Renewals'],
        ];
        $transactions = $this->paginate($this->Transactions);

        $this->set(compact('transactions'));
    }

    /**
     * View method
     *
     * @param string|null $id Transaction id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $transaction = $this->Transactions->get($id, [
            'contain' => ['Employees', 'Businesses', 'Groupings', 'Users', 'Renewals'],
        ]);

        $this->set(compact('transaction'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $transaction = $this->Transactions->newEmptyEntity();
        if ($this->request->is('post')) {
            $transaction = $this->Transactions->patchEntity($transaction, $this->request->getData());
            if ($this->Transactions->save($transaction)) {
                $this->Flash->success(__('The transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The transaction could not be saved. Please, try again.'));
        }
        $employees = $this->Transactions->Employees->find('list', ['limit' => 200]);
        $businesses = $this->Transactions->Businesses->find('list', ['limit' => 200]);
        $groups = $this->Transactions->Groupings->find('list', ['limit' => 200]);
        $users = $this->Transactions->Users->find('list', ['limit' => 200]);
        $renewals = $this->Transactions->Renewals->find('list', ['limit' => 200]);
        $this->set(compact('transaction', 'employees', 'businesses', 'groups', 'users', 'renewals'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Transaction id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $transaction = $this->Transactions->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $transaction = $this->Transactions->patchEntity($transaction, $this->request->getData());
            if ($this->Transactions->save($transaction)) {
                $this->Flash->success(__('The transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The transaction could not be saved. Please, try again.'));
        }
        $employees = $this->Transactions->Employees->find('list', ['limit' => 200]);
        $businesses = $this->Transactions->Businesses->find('list', ['limit' => 200]);
        $groups = $this->Transactions->Groupings->find('list', ['limit' => 200]);
        $users = $this->Transactions->Users->find('list', ['limit' => 200]);
        $renewals = $this->Transactions->Renewals->find('list', ['limit' => 200]);
        $this->set(compact('transaction', 'employees', 'businesses', 'groups', 'users', 'renewals'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Transaction id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $transaction = $this->Transactions->get($id);
        $renewal_id = $transaction->renewal_id;
        $this->Transactions->delete($transaction);
        return $this->redirect(['controller' => 'renewals', 'action' => 'view', $renewal_id]);
    }

    public function cancel($id){
        $transaction = $this->Transactions->get($id); 
        if($transaction){
            $new = $this->Transactions->newEmptyEntity();
            $new->type = 3;
            $new->employee_id = $transaction->employee_id;
            $new->family_id = $transaction->family_id; 
            $new->debit = $transaction->credit; 
            $new->credit = $transaction->debit;
            $new->renewal_id = $transaction->renewal_id; 
            $new->business_id = $transaction->business_id; 
            $new->grouping_id = $transaction->grouping_id;
            $new->user_id = $this->Auth->user()['id']; 
            debug($new); die();
            if($this->Transactions->save($new){
                $member = $this->Transactions->Families->get($transaction->family_id);
                $member->status = 0;
                $this->Transactions->Families->save($member);
            }
        }
        $this->redirect(['controller' => 'Renewals', 'action' => 'view', $transaction->renewal_id]);
    }
}
