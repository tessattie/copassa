<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Customer'), ['action' => 'edit', $customer->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Customer'), ['action' => 'delete', $customer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customer->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Customers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Customer'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="customers view content">
            <h3><?= h($customer->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($customer->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($customer->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Home Area Code') ?></th>
                    <td><?= h($customer->home_area_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Home Phone') ?></th>
                    <td><?= h($customer->home_phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cell Area Code') ?></th>
                    <td><?= h($customer->cell_area_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cell Phone') ?></th>
                    <td><?= h($customer->cell_phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Other Area Code') ?></th>
                    <td><?= h($customer->other_area_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Other Phone') ?></th>
                    <td><?= h($customer->other_phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $customer->has('user') ? $this->Html->link($customer->user->name, ['controller' => 'Users', 'action' => 'view', $customer->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Address') ?></th>
                    <td><?= h($customer->address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($customer->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $this->Number->format($customer->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($customer->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($customer->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Payments') ?></h4>
                <?php if (!empty($customer->payments)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Policy Id') ?></th>
                            <th><?= __('Amount') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Rate Id') ?></th>
                            <th><?= __('Daily Rate') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->payments as $payments) : ?>
                        <tr>
                            <td><?= h($payments->id) ?></td>
                            <td><?= h($payments->customer_id) ?></td>
                            <td><?= h($payments->policy_id) ?></td>
                            <td><?= h($payments->amount) ?></td>
                            <td><?= h($payments->status) ?></td>
                            <td><?= h($payments->user_id) ?></td>
                            <td><?= h($payments->rate_id) ?></td>
                            <td><?= h($payments->daily_rate) ?></td>
                            <td><?= h($payments->created) ?></td>
                            <td><?= h($payments->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Payments', 'action' => 'view', $payments->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Payments', 'action' => 'edit', $payments->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Payments', 'action' => 'delete', $payments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payments->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Policies') ?></h4>
                <?php if (!empty($customer->policies)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Option Id') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Policy Number') ?></th>
                            <th><?= __('Mode') ?></th>
                            <th><?= __('Effective Date') ?></th>
                            <th><?= __('Paid Until') ?></th>
                            <th><?= __('Premium') ?></th>
                            <th><?= __('Fee') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Active') ?></th>
                            <th><?= __('Lapse') ?></th>
                            <th><?= __('Pending') ?></th>
                            <th><?= __('Grace Period') ?></th>
                            <th><?= __('Canceled') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->policies as $policies) : ?>
                        <tr>
                            <td><?= h($policies->id) ?></td>
                            <td><?= h($policies->company_id) ?></td>
                            <td><?= h($policies->option_id) ?></td>
                            <td><?= h($policies->customer_id) ?></td>
                            <td><?= h($policies->policy_number) ?></td>
                            <td><?= h($policies->mode) ?></td>
                            <td><?= h($policies->effective_date) ?></td>
                            <td><?= h($policies->paid_until) ?></td>
                            <td><?= h($policies->premium) ?></td>
                            <td><?= h($policies->fee) ?></td>
                            <td><?= h($policies->user_id) ?></td>
                            <td><?= h($policies->active) ?></td>
                            <td><?= h($policies->lapse) ?></td>
                            <td><?= h($policies->pending) ?></td>
                            <td><?= h($policies->grace_period) ?></td>
                            <td><?= h($policies->canceled) ?></td>
                            <td><?= h($policies->created) ?></td>
                            <td><?= h($policies->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Policies', 'action' => 'view', $policies->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Policies', 'action' => 'edit', $policies->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Policies', 'action' => 'delete', $policies->id], ['confirm' => __('Are you sure you want to delete # {0}?', $policies->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
