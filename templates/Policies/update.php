<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li>Policy Updates</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <?= $this->Form->create() ?>
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Policy Updates
            <?= $this->Form->button(__('Submit Changes'), array('class'=>'btn btn-success', "style"=>"margin-top:0px;float:right;height:46px")) ?>
            <select class="form-control company_filter_js" style="width:200px;float:right;margin-right:10px">
                <option value = ''>-- Filter by company --</option>
                <?php foreach($companies as $company) : ?>
                    <option value="<?= $company->id ?>"><?= $company->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    <div class="panel-body articles-container">
        <div style="">
            
            <table class="table table-striped datatable">
                <thead> 
                    <th class="text-left">Policy</th>
                    <th class="text-center">Mode</th>
                    <th class="text-center">LP</th>
                    <th class="text-center">P</th>
                    <th class="text-center">LR</th>
                    <th class="text-center">NR</th>
                </thead>
            <tbody> 
            <?php foreach($policies as $policy) : ?>
                <?php if($policy->company->country_id == $filter_country || empty($filter_country)) : ?>
                <tr class="<?= $policy->company_id ?>">
                    <?= $this->Form->control('policy_id[]', array("type" => "hidden", "value" => $policy->id)) ?>
                    <td class="text-left"><?= $policy->policy_number ?> - <?= $policy->customer->name ?> - <?= $policy->company->name . " / ".  $policy->option->name ?></td>
                    <td class="text-center"><?= $modes[$policy->mode] ?></td>
                    <?php if(!empty($policy->last_premium)) : ?>
                    <td class="text-center"><?= $this->Form->control('last_premium[]', array('class' => 'form-control', "label" => false, 'style' => "height:35px;width:90px", 'placeholder' => "LP", 'value' => $policy->last_premium)); ?></td>
                    <?php else : ?>
                        <td class="text-center"><?= $this->Form->control('last_premium[]', array('class' => 'form-control', "label" => false, 'style' => "height:35px;width:90px", 'placeholder' => "LP", 'value' => '')); ?></td>
                    <?php endif; ?>
                    <td class="text-center">
                        <?= $this->Form->control('premium[]', array('class' => 'form-control', "label" => false, 'style' => "height:35px;width:90px", 'placeholder' => "P", 'value' => $policy->premium)); ?></td>
                    
                    <td class="text-center"><?= $this->Form->control('last_renewal[]', array('class' => 'form-control', "label" => false, 'style' => "height:35px;width:175px", 'type' => "date", 'value' => $policy->last_renewal)); ?></td>
                    <td class="text-center"><?= $this->Form->control('next_renewal[]', array('class' => 'form-control', "label" => false, 'style' => "height:35px;width:175px", 'type' => "date", 'value' => $policy->next_renewal)); ?></td>
                </tr>
            <?php endif; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
        
            </div><!--End .article-->
        </div>
        
    </div>
    <?= $this->Form->end() ?>
</div><!--End .articles-->

<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({
        'paging' : false
    } );

    $(".company_filter_js").change(function(){
        // alert($(this).val());
        var to_keep = $(this).val();
        $('tbody > tr').not("."+to_keep).each(function(){
            $(this).hide(); 
        });

        $('tbody > tr.'+to_keep).each(function(){
            $(this).show(); 
        });
    })
} );

</script>

<style>
    .dt-button{
        padding:5px;
        background:black;
        border:2px solid black;
        border-radius:2px;;
        color:white;
        margin-bottom:-10px;
    }
    .dt-buttons{
        margin-bottom:-25px;
    }

    td{
        vertical-align: middle!important;
    }
</style>
