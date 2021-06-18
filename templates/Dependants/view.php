<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Dependant $dependant
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Dependant'), ['action' => 'edit', $dependant->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Dependant'), ['action' => 'delete', $dependant->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dependant->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Dependants'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Dependant'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="dependants view content">
            <h3><?= h($dependant->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Policy') ?></th>
                    <td><?= $dependant->has('policy') ? $this->Html->link($dependant->policy->id, ['controller' => 'Policies', 'action' => 'view', $dependant->policy->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $dependant->has('user') ? $this->Html->link($dependant->user->name, ['controller' => 'Users', 'action' => 'view', $dependant->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($dependant->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Relation') ?></th>
                    <td><?= $this->Number->format($dependant->relation) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sexe') ?></th>
                    <td><?= $this->Number->format($dependant->sexe) ?></td>
                </tr>
                <tr>
                    <th><?= __('Dob') ?></th>
                    <td><?= h($dependant->dob) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($dependant->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($dependant->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Limitations') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($dependant->limitations)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
