<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\File $file
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
            <h3 style="padding-bottom:10px">Editer le fichier : <?= $file->name ?></h3>
        </div>
    </div>
    <?= $this->Form->create($file, ['enctype' => 'multipart/form-data']) ?>
    <fieldset>
        <?php
            echo $this->Form->control('name', array('label' => "Nom",'Placeholder' => "Nom du fichier"));
            echo $this->Form->control('description', array('label' => "Description",'Placeholder' => "Description Courte"));
            echo $this->Form->control('extension', array('label' => "Extension", "options" => ['PDF', 'DOC', 'EXCEL', 'PPT', "IMG", "AUTRE"]));
            echo $this->Form->control('folders._ids', ['options' => $folders, "style" => "width:100%;height:150px", "label" => "Répertoire"]);

        ?>
        <hr>
        <div class="form-group">
            <label for="exampleInputFile">Chargez un fichier PDF</label>
            <input type="file" name="location">
            <p class="help-block">Pour changer le fichier sauvegardé, chargez un nouveau fichier ici</p>
          </div>
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
