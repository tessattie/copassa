<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pending $pending
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Pending'), ['action' => 'edit', $pending->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Pending'), ['action' => 'delete', $pending->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pending->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Pendings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Pending'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="pendings view content">
            <h3><?= h($pending->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($pending->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $pending->has('company') ? $this->Html->link($pending->company->name, ['controller' => 'Companies', 'action' => 'view', $pending->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Option') ?></th>
                    <td><?= $pending->has('option') ? $this->Html->link($pending->option->name, ['controller' => 'Options', 'action' => 'view', $pending->option->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Country') ?></th>
                    <td><?= $pending->has('country') ? $this->Html->link($pending->country->name, ['controller' => 'Countries', 'action' => 'view', $pending->country->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $pending->has('user') ? $this->Html->link($pending->user->name, ['controller' => 'Users', 'action' => 'view', $pending->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($pending->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Dependants') ?></th>
                    <td><?= $this->Number->format($pending->dependants) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $this->Number->format($pending->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($pending->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($pending->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
