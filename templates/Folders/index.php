<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Folder[]|\Cake\Collection\CollectionInterface $folders
 */
?>

<section>

                    <!-- Begin Users Profile -->
                    <div class="card">
                        <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 style="padding-bottom:10px">Répertoires</h3>
                            </div>
                        </div>
                  
                                    <a href="<?= ROOT_DIREC ?>/folders/add" style="color:white"><button type="button" class="btn btn-primary" style="float:right;margin-top:-52px">
                                         Nouveau Répertoire
                                    </button></a>
       
                            <div class="card-dashboard">
                                <div class="table-responsive">
                                    <table class="table zero-configuration" id="check-slct">
                                        <thead>
                                            <tr class="text-uppercase">
                                                <th class="text-left">Nom</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($folders as $id => $name) : ?>
                                            <?php if($id != 1) : ?>
                                            <?php $i = substr_count($name, '_'); $p=10; ?>
                                            <tr>
                                            <?php if($i <= 1) : ?>
                                                <td style="padding-left:<?= $p ?>px!important"><?= str_replace("_", "", $name) ?></td>
                                            <?php else : ?>
                                                <td style="padding-left:<?= $p + $i*20 ?>px!important"><?= str_replace("_", "", $name) ?></td>
                                            <?php endif; ?>
                                                
                                                 <td class="text-right"><a href="<?= ROOT_DIREC ?>/folders/edit/<?= $id ?>"><i class="m-1 feather icon-edit-2"></i></a>

                                                   <a href="<?= ROOT_DIREC ?>/folders/delete2/<?= $id ?>"><i class="feather icon-trash"></i></a></td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Users Profile -->
                </section>
