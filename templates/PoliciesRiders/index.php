<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PoliciesRider[]|\Cake\Collection\CollectionInterface $policiesRiders
 */
?>
<div class="policiesRiders index content">
    <?= $this->Html->link(__('New Policies Rider'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Policies Riders') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('policy_id') ?></th>
                    <th><?= $this->Paginator->sort('rider_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($policiesRiders as $policiesRider): ?>
                <tr>
                    <td><?= $this->Number->format($policiesRider->id) ?></td>
                    <td><?= $policiesRider->has('policy') ? $this->Html->link($policiesRider->policy->id, ['controller' => 'Policies', 'action' => 'view', $policiesRider->policy->id]) : '' ?></td>
                    <td><?= $policiesRider->has('rider') ? $this->Html->link($policiesRider->rider->name, ['controller' => 'Riders', 'action' => 'view', $policiesRider->rider->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $policiesRider->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $policiesRider->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $policiesRider->id], ['confirm' => __('Are you sure you want to delete # {0}?', $policiesRider->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
