<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClaimsType $claimsType
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Claims Type'), ['action' => 'edit', $claimsType->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Claims Type'), ['action' => 'delete', $claimsType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $claimsType->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Claims Types'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Claims Type'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="claimsTypes view content">
            <h3><?= h($claimsType->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('Claim') ?></th>
                    <td><?= $claimsType->has('claim') ? $this->Html->link($claimsType->claim->title, ['controller' => 'Claims', 'action' => 'view', $claimsType->claim->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= $claimsType->has('type') ? $this->Html->link($claimsType->type->name, ['controller' => 'Types', 'action' => 'view', $claimsType->type->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($claimsType->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Attachment') ?></th>
                    <td><?= h($claimsType->attachment) ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $claimsType->has('user') ? $this->Html->link($claimsType->user->name, ['controller' => 'Users', 'action' => 'view', $claimsType->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Tenant') ?></th>
                    <td><?= $claimsType->has('tenant') ? $this->Html->link($claimsType->tenant->id, ['controller' => 'Tenants', 'action' => 'view', $claimsType->tenant->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($claimsType->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Amount') ?></th>
                    <td><?= $this->Number->format($claimsType->amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($claimsType->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($claimsType->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($claimsType->description)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
