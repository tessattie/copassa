<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Help Controller
 *
 * @property \App\Model\Table\GroupingsTable $Groupings
 * @method \App\Model\Entity\Grouping[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HelpController extends AppController
{
    public function index($active = 1){
        $this->loadModel("Categories"); $this->loadModel("Elements"); 
        $categories = $this->Categories->find("all", array("order" => array("position ASC"))); 
        $elements = [];
        if($active != false){
            $elements = $this->Elements->find("all", array("order" => array("position ASC"), "conditions" => array("category_id" => $active)));
        }
        $this->set(compact('categories', 'elements', 'active'));
    }

}

