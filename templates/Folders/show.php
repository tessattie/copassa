<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li>
            Ressources
        </li>
    </ol>
</div>
<div class="modal fade" id="newFile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New File</h5>
      </div>
      <?= $this->Form->create($filee, ['enctype' => 'multipart/form-data']) ?>
      <div class="modal-body">
        <p>Active Folder : <?= $active_folder->name ?></p>
        <hr>    
        
    <fieldset>
        <?php
        echo $this->Form->control('type', ['type' => "hidden", "value" => 1]);
            echo $this->Form->control('name', array('label' => "Name",'Placeholder' => "File Name"));
            echo $this->Form->control('description', array('label' => "Description",'Placeholder' => "Short Description"));
            echo $this->Form->control('extension', array('label' => "Extension", "options" => ['PDF', 'DOC', 'EXCEL', 'PPT', "IMG", "AUTRE"]));
            echo $this->Form->control('folders._ids', ["type" => "hidden", "value" => $active_folder->id]);

        ?>
        <hr>
        <div class="form-group">
            <label for="exampleInputFile">Choose your file</label>
            <input type="file" name="location">
          </div>
    </fieldset>
    
    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <?= $this->Form->button(__('Add', array('class' => "btn btn-success"))) ?>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div></div>

  <div class="modal fade" id="newFolder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Folder</h5>
      </div>
      <?= $this->Form->create($folderr) ?>
      <div class="modal-body">
        <p>Active Folder : <?= $active_folder->name ?></p>
        <hr>    
        
    <fieldset>
        <?php
        echo $this->Form->control('type', ['type' => "hidden", "value" => 2]);
            echo $this->Form->control('name', array('label' => "Name",'Placeholder' => "Folder Name"));
        ?>
    </fieldset>
    
    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <?= $this->Form->button(__('Add', array('class' => "btn btn-success"))) ?>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div></div>

<section id="list-group-icons">
    <div class="row match-height">
        <div class="col-lg-3 col-md-3">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <ul class="list-group">

                        <?php foreach ($folders as $id => $name) : ?>
                            <?php if($id != 1) : ?>
                                <?php $i = substr_count($name, '_'); $p=17; ?>
                                <?php $active = "";
                                            if($active_folder->id == $id){
                                                $active = "active";
                                            }
                                         ?>
                                <?php if($i <= 1) : ?>
                                        
                            <li class="list-group-item d-flex <?= $active ?>" style="padding-left:<?= $p  + ($i)*17 ?>px!important">
                        <?php else : ?>
                            <li class="list-group-item d-flex <?= $active ?>" style="padding-left:<?= $p  + ($i)*17 ?>px!important">
                        <?php endif; ?>
                                <p class="float-left" style="margin-right:3px;margin-bottom:0px">
                                    <i class="fa fa-folder" style="vertical-align: middle;color:orange"></i><a href="<?= ROOT_DIREC ?>/folders/show/<?= $id ?>" style="vertical-align: middle;color:black;margin-left:3px"><span> <?= str_replace("_", "", $name) ?></span></a>
                                </p>
                                
                            </li>
                        <?php endif; ?>
                        <?php endforeach; ?>
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-9" style="padding-left:0px">
        <div class="card">
                <div class="d-flex justify-content-start breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb ml-1">
                                <?php   foreach ($breadcrumbs as $b) : ?>
                                    <li class="breadcrumb-item"><a href="<?= ROOT_DIREC ?>/folders/show/<?= $b->id ?>"><?= $b->name ?></a></li>
                                <?php   endforeach ; ?>
                                <button class="btn btn-primary"  data-toggle="modal" data-target="#newFile" style="height: 30px;
    width: 44px;
    float: right;
    position: absolute;
    right: 23px;
    margin-top: -5px;"><i class='fa fa-file'></i></button>  
    <button class="btn btn-warning"  data-toggle="modal" data-target="#newFolder" style="width: 44px;
    float: right;
    position: absolute;
    right: 75px;
    height: 30px;
    margin-top: -5px;"><i class='fa fa-folder'></i></button>  
                                </ol>

                            </nav>
                        </div>
                            
                        </div>
        <section id="columns" style="padding-left: 16px;padding-right:16px">
    <div class="row">
        <div class="col-12">
            <div class="card-deck-wrapper">
                <div class="row">
                <?php   foreach($active_folder->child_folders as $folder) : ?>
                    <?php if($folder->tenant_id == $user_connected['tenant_id']) : ?>
                    <div class="col-md-3">
                    <div class="card elements" style="height:170px">
                    
                        <div class="card-content text-center" style="padding-top:10px">
                        <a href="<?= ROOT_DIREC ?>/folders/show/<?= $folder->id ?>" class="showfolderslink">
                            <span class="fa fa-folder" style="font-size:30px;color:orange"></span>
                            <div class="card-body">
                                <h4 class="card-title"><?= $folder->name ?></h4>
                                <p class="card-text"><small class="text-muted">Last updated <?= $folder->modified ?></small></p>

                            </div></a>
                            <div><a href="<?= ROOT_DIREC ?>/folders/delete/<?= $folder->id ?>"><span class="fa fa-remove" style="color:white;background:red;padding:3px 5px 3px 5px;border-radius:3px;"></span></a></div>
                                                                

                        </div>
                    </div></div>
                <?php endif; ?>
                <?php   endforeach; ?>
                <?php   foreach($active_folder->files as $file) : ?>
                    <?php if($file->tenant_id == $user_connected['tenant_id']) : ?>
                    <div class="col-md-3">
                    <div class="card elements"  style="height:170px">
                    
                        <div class="card-content text-center" style="padding-top:10px">
                        <a target="_blank" href="<?= ROOT_DIREC ?>/tmp/files/<?= $file->location ?>">
                        <?php $extensions = array("pdf.png", "word.png", "excel.png", "ppt.png", "image.png") ?>
                            <img class="card-img-top img-fluid" src="<?= ROOT_DIREC ?>/img/<?= $extensions[$file->extension] ?>" style="width:30px;height:30px" alt="Card image cap" />
                            <div class="card-body">
                                <h4 class="card-title"><?= $file->name ?></h4>
                                <p class="card-text"><small class="text-muted">Last updated <?= $file->modified ?></small></p>
                                
                            </div></a>
                            <p class="float-right mb-0" style="margin-right:16px">
                                <div><a href="<?= ROOT_DIREC ?>/files/delete/<?= $file->id ?>/<?= $active_folder->id ?>"><span class="fa fa-remove" style="color:white;background:red;padding:3px 5px 3px 5px;border-radius:3px;"></span></a></div>
                                </p>
                        </div>
                    </div></div>
                <?php endif; ?>
                <?php   endforeach; ?>
                    
                    
                </div>
            </div>
        </div>
    </div>
</section>

        </div>
    </div>
</section>
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
.list-group > li.active, li.active a{
    background-color:#f2f2f2 !important;
    color:black!important;
    border-color:#ddd;
}

#list-group-icons li a{
    color:black!important;
}

.card.elements{
    background:white;
    border-radius:3px;
    margin-top:15px;
}

.showfolderslink{
    color:black!important;
    font-style:normal!important;
    text-decoration:none!important;
}
</style>

