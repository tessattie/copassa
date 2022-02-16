<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Folder $folder
 */
?>


            <div class="row">
             <div class="col-md-4 col-md-offset-4"></div>
                 <div class="col-md-4 col-md-offset-4">
                    <section> 
                        <div class="card">
    <div class="card-body">
    <div class="row">
        <div class="col-md-12">
            <h3 style="padding-bottom:10px">Editer le répertoire : <?= $folder->name ?></h3>
        </div>
    </div>
    <?= $this->Form->create($folder) ?>
    <fieldset>
        <?php
            echo $this->Form->control('name', array('label' => "Nom",'Placeholder' => "Nom du Répertoire"));
            echo $this->Form->control('parent_id', ['options' => $parentFolders, 'value' => $folder->parent_id]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Valider', array('class' => "btn btn-success"))) ?>
    <?= $this->Form->end() ?>
</div>
</div>
                    </section>
                 </div>
             </div>       <!-- Begin Users Profile -->


<style type="text/css">
    label{
        font-weight:bold;
        margin-right:20px!important;
    }
    .input {
        margin:10px 0px 10px;
    }
    input, button, select, optgroup, textarea {

    border-radius: 3px;
    height:40px;
    border: 1px solid #ddd;
    padding:5px;
}
</style>
