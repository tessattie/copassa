<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tenant $tenant
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Tenant'), ['action' => 'edit', $tenant->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Tenant'), ['action' => 'delete', $tenant->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tenant->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Tenants'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Tenant'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="tenants view content">
            <h3><?= h($tenant->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Full Name') ?></th>
                    <td><?= h($tenant->full_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($tenant->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone') ?></th>
                    <td><?= h($tenant->phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Identification') ?></th>
                    <td><?= h($tenant->identification) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= h($tenant->company) ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $tenant->has('user') ? $this->Html->link($tenant->user->name, ['controller' => 'Users', 'action' => 'view', $tenant->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($tenant->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $this->Number->format($tenant->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($tenant->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($tenant->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
