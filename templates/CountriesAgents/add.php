<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CountriesAgent $countriesAgent
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Countries Agents'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="countriesAgents form content">
            <?= $this->Form->create($countriesAgent) ?>
            <fieldset>
                <legend><?= __('Add Countries Agent') ?></legend>
                <?php
                    echo $this->Form->control('country_id', ['options' => $countries]);
                    echo $this->Form->control('agent_id', ['options' => $agents]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
