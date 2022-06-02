<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Type[]|\Cake\Collection\CollectionInterface $types
 */
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Claim Types</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<?= $this->Form->create() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Claim Types
            <a class="btn btn-warning" style="float:right" href="<?= ROOT_DIREC ?>/types/add">New</a>
        </div>
    <div class="panel-body articles-container">
        <div class="table-responsive">
            <table class="table table-stripped datatable">
                <thead> 
                    <th>Name</th>
                    <th class="text-center">Color</th>
                    <th class="text-center">Is Deductible</th>
                    <th class="text-center"></th>
                </thead>
            <tbody> 
            <?php foreach($types as $type) : ?>
                <tr>
                    <td><?= $type->name ?></td>
                    <td class="text-center"><div style="height:20px;width:20px;background-color:<?= $type->color ?>;margin:auto;border:1px solid black;border-radius:3px"></div></td>

                    <td class="text-center"><input type="radio" value="<?= $type->id ?>" class="is_deductible" name="is_deductible" <?= ($type->is_deductible == 1) ? "checked" : "" ?>></td>
                    <td class="text-right">
                        <a href="<?= ROOT_DIREC ?>/types/edit/<?= $type->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                        <?php if(empty($type->claims_types)) : ?>
                        <a href="<?= ROOT_DIREC ?>/types/delete/<?= $type->id ?>" onclick="return confirm('Are you sure you would like to delete the type <?= $type->name ?>')" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a>
                    <?php   endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table></div>
            <!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->
<?= $this->Form->end() ?>

<?php 
echo '<script> var ROOT_DIREC = "'.ROOT_DIREC.'";</script>'
?>

<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({

    } );

    $(".is_deductible").change(function(){
        var token =  $('input[name="_csrfToken"]').val();
        var type = $(this).val();
        $.ajax({
             url : ROOT_DIREC+'/types/deductible',
             type : 'POST',
             data : {type_id : type},
             headers : {
                'X-CSRF-Token': token 
             },
             dataType : 'json',
             success : function(data, statut){
                console.log("deductible type changed successfully")
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
