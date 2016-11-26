<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Buses'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="buses form large-9 medium-8 columns content">
    <?= $this->Form->create($bus) ?>
    <fieldset>
        <legend><?= __('Add Bus') ?></legend>
        <?php
            echo $this->Form->input('code');
            echo $this->Form->input('company');
            echo $this->Form->input('photo');
            echo $this->Form->input('dir');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
