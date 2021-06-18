<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Dependant[]|\Cake\Collection\CollectionInterface $dependants
 */
?>
<div class="dependants index content">
    <?= $this->Html->link(__('New Dependant'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Dependants') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('relation') ?></th>
                    <th><?= $this->Paginator->sort('dob') ?></th>
                    <th><?= $this->Paginator->sort('sexe') ?></th>
                    <th><?= $this->Paginator->sort('policy_id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dependants as $dependant): ?>
                <tr>
                    <td><?= $this->Number->format($dependant->id) ?></td>
                    <td><?= $this->Number->format($dependant->relation) ?></td>
                    <td><?= h($dependant->dob) ?></td>
                    <td><?= $this->Number->format($dependant->sexe) ?></td>
                    <td><?= $dependant->has('policy') ? $this->Html->link($dependant->policy->id, ['controller' => 'Policies', 'action' => 'view', $dependant->policy->id]) : '' ?></td>
                    <td><?= $dependant->has('user') ? $this->Html->link($dependant->user->name, ['controller' => 'Users', 'action' => 'view', $dependant->user->id]) : '' ?></td>
                    <td><?= h($dependant->created) ?></td>
                    <td><?= h($dependant->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $dependant->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $dependant->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $dependant->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dependant->id)]) ?>
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
