<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Newborn $newborn
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Newborn'), ['action' => 'edit', $newborn->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Newborn'), ['action' => 'delete', $newborn->id], ['confirm' => __('Are you sure you want to delete # {0}?', $newborn->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Newborns'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Newborn'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="newborns view content">
            <h3><?= h($newborn->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Policy') ?></th>
                    <td><?= $newborn->has('policy') ? $this->Html->link($newborn->policy->id, ['controller' => 'Policies', 'action' => 'view', $newborn->policy->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $newborn->has('user') ? $this->Html->link($newborn->user->name, ['controller' => 'Users', 'action' => 'view', $newborn->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($newborn->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $this->Number->format($newborn->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Due Date') ?></th>
                    <td><?= h($newborn->due_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($newborn->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($newborn->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
