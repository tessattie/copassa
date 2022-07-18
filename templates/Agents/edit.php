<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Agent $agent
 */
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/agents">
            Agents
        </a></li>
        <li>Edit</li>
        <li><?= $agent->name ?></li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="container-fluid"> 
            <?= $this->Form->create($agent) ?>
            <div class="panel panel-default articles">
                <div class="panel-heading">
                    Edit Agent : <?= $agent->name ?>
                    <a class="btn btn-info" style="float:right" href="<?= ROOT_DIREC ?>/agents"><em class="fa fa-arrow-left"></em></a>
                </div>
            <div class="panel-body articles-container">       
                    <div class="row">
                        <div class="col-md-4"><?= $this->Form->control('name', array('class' => 'form-control', "label" => "Name *", "placeholder" => "Name")); ?></div>
                        <div class="col-md-4"><?= $this->Form->control('phone', array('class' => 'form-control', "placeholder" => 'Phone', "label" => "Phone")); ?></div>
                        <div class="col-md-4"><?= $this->Form->control('email', array('class' => 'form-control', "placeholder" => 'Email', "label" => "Email")); ?></div> 
                    </div>
                </div>
                
            </div>

            <div class="panel panel-default articles">
                <div class="panel-heading">
                    Countries
                </div>
                <div class="panel-body articles-container" style="height:400px;overflow-y:scroll">       
                    <table class="table">
                        <tbody>
                            <?php $i=0; foreach($countries as $country) : ?>
                                <?php  
                                    $checked = false;
                                    foreach($agent->countries_agents as $ca){
                                        if($ca->country_id == $country->id){
                                            $checked = true;
                                        }
                                    }
                                ?>
                                <tr>
                                    <td><?= $country->name ?></td>
                                    <td class="text-right">
                                        <?= $this->Form->checkbox('countries._ids.'.$i, array("value" => $country->id, 'checked' => $checked)) ?>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    
                </div>
                <div class="panel-footer">
                    <div class="row">
                            <div class="col-md-12"><?= $this->Form->button(__('Update'), array('class'=>'btn btn-success', "style"=>"float:right")) ?></div>
                        </div> 
                </div>
                
            </div>
            <?= $this->Form->end() ?>
        </div><!--End .articles-->
    </div>
</div>





<style type="text/css">
    @media only screen and (max-width: 600px) {
      .input label, #cell-phone, #home-phone, #other-phone, .col-md-4 label{
        margin-top: 15px;
      }

      
    }
</style>
