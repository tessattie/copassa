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
        <li class="active">Profile</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default articles">
                <div class="panel-heading">
                    Your Profile
                </div>
            <div class="panel-body articles-container">
                            <table class="table table-striped">
                        <tr>
                            <th><?= __('Name') ?></th>
                            <td class="text-right"><?= h($user->name) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Username') ?></th>
                            <td class="text-right"><?= h($user->username) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Company') ?></th>
                            <td class="text-right"><?= h($user->tenant->company) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Account Number') ?></th>
                            <td class="text-right"><?= h($user->tenant->identification) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Status') ?></th>
                            <?php if($user->status == 1) : ?>
                                <td class="text-right">  <span class="label label-success"> <?= $status[$user->status] ?></span></td>
                            <?php else : ?>
                                <td class="text-right">  <span class="label label-danger"> <?= $status[$user->status] ?></span></td>
                            <?php endif; ?>
                        </tr>
                    </table>
                </div>
                
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="panel panel-default articles">
                <div class="panel-heading">
                    Reset Your Password
                </div>
                <div class="panel-body articles-container">
                    <?= $this->Form->create() ?>
                        <div class="row">
                        <div class="col-md-12"><?= $this->Form->control('old_password', array('class' => 'form-control', "label" => "Old password *", "required" => true, "placeholder" => "Old Password", 'type' => "password")); ?></div>
                            
                        </div>
                        <hr>
                        <div class="row">
                        <div class="col-md-12"><?= $this->Form->control('new_password', array('class' => 'form-control', "label" => "New Password *", "required" => true, "placeholder" => "New Password", 'type' => "password")); ?></div>
                            
                        </div>
                        <hr>
                        <div class="row">
                        <div class="col-md-12"><?= $this->Form->control('confirm_new_password', array('class' => 'form-control', "label" => "Confirm New Password *", "required" => true, "placeholder" => "Confirm New Password", 'type' => "password")); ?></div>
                            
                        </div>
                        <div class="row">
                            <div class="col-md-12"><?= $this->Form->button(__('Update Password'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
                        </div>  


                    <?= $this->Form->end() ?>
                </div>
                
            </div>
        </div>
    </div>
    
</div><!--End .articles-->