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

        if($this->Auth->user()['tenant_id'] != $transaction->tenant_id){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }

        $renewal_id = $transaction->renewal_id;
        $this->Transactions->delete($transaction);
        return $this->redirect(['controller' => 'renewals', 'action' => 'view', $renewal_id]);
    }

    public function cancel($id){
        $transaction = $this->Transactions->get($id); 

        if($this->Auth->user()['tenant_id'] != $transaction->tenant_id){
            return $this->redirect(['controller' => 'users', 'action' => 'authorization']);
        }

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
            if($this->Transactions->save($new)){
                $member = $this->Transactions->Families->get($transaction->family_id);
                $member->status = 0;
                $this->Transactions->Families->save($member);
            }
        }
        $this->redirect(['controller' => 'Renewals', 'action' => 'view', $transaction->renewal_id]);
    }
}
