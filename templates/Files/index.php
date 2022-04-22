<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\File[]|\Cake\Collection\CollectionInterface $files
 */
?>

<section>

                    <!-- Begin Users Profile -->
                    <div class="card">
                        <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 style="padding-bottom:10px">Fichiers</h3>
                            </div>
                        </div>
                  
                                    <a href="<?= ROOT_DIREC ?>/files/add" style="color:white"><button type="button" class="btn btn-primary" style="float:right;margin-top:-52px">
                                         Nouveau Fichier
                                    </button></a>
       
                            <div class="card-dashboard">
                                <div class="table-responsive">
                                    <table class="table zero-configuration" id="check-slct">
                                        <thead>
                                            <tr class="text-uppercase">
                                                <th class="text-left">Nom</th>
                                                <th class="text-center">Utilisateur</th>
                                                <th class="text-center">Dernière Modification</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $extensions = array("pdf.png", "word.png", "excel.png", "ppt.png", "image.png") ?>
                                            <?php foreach($files as $file) : ?>
                                                <tr>
                                                    <td><img src="<?= ROOT_DIREC ?>/img/<?= $extensions[$file->extension] ?>" style="width:25px">   <?= $file->name ?></td>
                                                    <td class="text-center"><?= $file->user->first_name." ".$file->user->last_name ?></td>
                                                    <td class="text-center"><?= $file->modified ?></td>
                                    
                                                    <td class="text-right"><a href="<?= ROOT_DIREC ?>/files/edit/<?= $file->id ?>"><i class="m-1 feather icon-edit-2"></i></a>
                                                        <a href="<?= ROOT_DIREC ?>/files/delete2/<?= $file->id ?>"><i class="feather icon-trash"></i></a></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Users Profile -->
                </section>
                <!-- User Table
        </div>
      </div>
    </div>
    <!-- END: Content-->

