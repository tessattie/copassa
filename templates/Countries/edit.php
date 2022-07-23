<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/countries">
            Countries
        </a></li>
        <li>Edit</li>
        <li><?= substr($country->name, 0, 15) ?>...</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="container-fluid"> 
            <?= $this->Form->create($country) ?>
            <div class="panel panel-default articles">
                <div class="panel-heading">
                    Edit Country : <?= $country->name ?>
                    <a class="btn btn-info" style="float:right" href="<?= ROOT_DIREC ?>/countries"><em class="fa fa-arrow-left"></em></a>
                </div>
            <div class="panel-body articles-container">       
                    <div class="row">
                        <div class="col-md-12"><?= $this->Form->control('name', array('class' => 'form-control', "label" => "Name *", "placeholder" => "Name")); ?></div>
                    </div>
                    <?php if($user_connected['role_id'] == 2  && !$auths[62]) : ?>
                    <div class="row" style="margin-top:20px">
                        <div class="col-md-12"><?= $this->Form->button(__('Update'), array('class'=>'btn btn-success', "style"=>"float:right")) ?></div>
                    </div> 
                <?php endif; ?>
                </div>
                
            </div>
            <?php if($user_connected['role_id'] != 2  || $auths[62]) : ?>
            <div class="panel panel-default articles">
                <div class="panel-heading">
                    Agents
                </div>
                <div class="panel-body articles-container" style="height:400px;overflow-y:scroll">       
                    <table class="table">
                        <tbody>
                            <?php $i=0; foreach($agents as $agent) : ?>
                                <?php  
                                    $checked = false;
                                    foreach($country->countries_agents as $ca){
                                        if($ca->agent_id == $agent->id){
                                            $checked = true;
                                        }
                                    }
                                ?>
                                <tr>
                                    <td><?= $agent->name ?></td>
                                    <td class="text-right">
                                        <?= $this->Form->checkbox('agents._ids.'.$i, array("value" => $agent->id, 'checked' => $checked)) ?>
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
        <?php endif; ?>
            <?= $this->Form->end() ?>
        </div><!--End .articles-->
    </div>
</div>

<style type="text/css">
    @media only screen and (max-width: 600px) {
      

      
    }
</style>