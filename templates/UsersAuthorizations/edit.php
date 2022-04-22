<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UsersAuthorization $usersAuthorization
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $usersAuthorization->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $usersAuthorization->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Users Authorizations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="usersAuthorizations form content">
            <?= $this->Form->create($usersAuthorization) ?>
            <fieldset>
                <legend><?= __('Edit Users Authorization') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('authorization_id', ['options' => $authorizations]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
