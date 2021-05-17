<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Logs Controller
 *
 * @property \App\Model\Table\LogsTable $Logs
 * @method \App\Model\Entity\Log[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LogsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        
        $users = $this->Logs->Users->find("list", array("order" => array("name ASC")));

        $status = ""; 
        $user_id = ""; 
        $type = "";
        $condition = array("Logs.created >=" => $this->from, 'Logs.created <=' => $this->to);

        if($this->request->is(['patch', 'put', 'post'])){
            if(!empty($this->request->getData()['status']) || $this->request->getData()['status'] == 0 ){
                $status = $this->request->getData()['status'];
                $array = array('Logs.status' => $status);
                array_push($condition, $array);
            }
            if(!empty($this->request->getData()['type'])){
                $type = $this->request->getData()['type'];
                $array = array('Logs.type' => $type);
                array_push($condition, $array);
            }
            if(!empty($this->request->getData()['user_id'])){
                $user_id = $this->request->getData()['user_id'];
                $array = array('Logs.user_id' => $user_id);
                array_push($condition, $array);
            }
        }

        $logs = $this->Logs->find("all", array("conditions" => $condition, 'order' => array('Logs.created DESC')))->contain(['Users']);

        // debug($this->Logs->lastQuery()); 

        // die(); 

        $this->set(compact('logs', 'users', 'status', 'user_id', 'type'));
    }
}
