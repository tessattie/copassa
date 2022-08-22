<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
$types = array(1 => "Reminders", 2 => "Reports", 3 => "Insurance Companies", 4 => "Network", 5 => "Policies", 6 => "Pending New Business", 7 => "Maternity Reminders", 8 => "Individual Policies Renewals", 9 => "Corporate Groups", 10 => "Ressources", 11 => "Users", 12 => "Riders", 13 => "Claims");
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Authorizations</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="row">
        <div class="col-md-3">
            <table class="table table-bordered">
            <tbody> 
            <?php foreach($users as $user) : ?>
                
                    <?php if($user_id == $user->id) : ?>
                        <tr style="background:#f2f2f2">
                        <?php else : ?>
                            <tr>
                        <?php endif; ?>
                    <td><a style="color:black" href="<?= ROOT_DIREC ?>/authorizations/index/<?= $user->id ?>"><?= h($user->name) ?></a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        <div class="col-md-9">
            <div class="panel panel-default articles">
        <div class="panel-heading">
            Authorizations
        </div>
    <div class="panel-body articles-container"  style="height:450px;overflow-y:scroll">
        <?php if(!empty($user_id)) : ?>
        <?= $this->Form->create() ?>
        <?= $this->Form->control('user_id', array('type' => 'hidden', 'value' => $user_id, "id" => "user_id")); ?> 
        
            <table class="table table-bordered">
            <tbody> 
            <?php $type =0; foreach($authorizations as $authorization) : ?>
                <?php if($type != $authorization->type) : ?>
                    <tr style="background:#f2f2f2"><td colspan="2"><?= $types[$authorization->type] ?></td></tr>
                    <?php $type = $authorization->type; ?>
                <?php endif; ?>
                <tr>
                    <td><?= h($authorization->name) ?></td>
                    <td class="text-center">
                        <?php $condition = false; if(!empty($user_authorizations)) : ?>
                            <?php  
                                foreach($user_authorizations as $ua){
                                    if($ua->authorization_id == $authorization->id){
                                        $condition = true;
                                    }
                                }
                            ?>
                        <?php endif; ?>
                        <?php if($condition) : ?>
                            <input type="checkbox" name="authorization_id" class="edit_auth" checked value="<?= $authorization->id ?>">
                        <?php else : ?>
                            <input type="checkbox" name="authorization_id" class="edit_auth" value="<?= $authorization->id ?>">
                        <?php endif; ?>
                        
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?= $this->Form->end() ?>
        <?php else: ?>
            <p class="bg-info" style="padding:10px;text-align:center">Choose user to see authorizations</p>
        <?php endif; ?>
            <!--End .article-->
        </div>
        
    </div>
        </div>
    </div>
    
</div><!--End .articles-->

<?php 
echo '<script> var ROOT_DIREC = "'.ROOT_DIREC.'";</script>'
?>

<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({
        "ordering":false
    } );

    $(".edit_auth").change(function(){
        var authorization_id = $(this).val()
        var checked = $(this).is(":checked")
        var user_id = $("#user_id").val();
        var token =  $('input[name="_csrfToken"]').val();
        $.ajax({
             url : ROOT_DIREC+'/authorizations/update',
             type : 'POST',
             data : {authorization_id : authorization_id, checked: checked, user_id: user_id},
             headers : {
                'X-CSRF-Token': token 
             },
             dataType : 'json',
             success : function(data, statut){
                  console.log('updated');
             },
             error : function(resultat, statut, erreur){
              console.log(erreur)
             }, 
             complete : function(resultat, statut){
                console.log(resultat)
             }
        });
    })
} );</script>

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
</style>