<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css(['normalize.min', 'milligram.min', 'cake']) ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="top-nav">
        <div class="top-nav-title">
            <a href="<?= $this->Url->build('/') ?>">
                <?= $this->Html->image('Untitled.png', ['alt' => 'Logo' , 'width' => '50', 'height' => '50']) ?>
            </a>
        </div>
        <div class="top-nav-links">
            <?php if ($identity): ?>
                <span><?= __('Hello, {0} {1}', h($identity->prenom), h($identity->nom)) ?></span>
                <?= $this->Form->postLink(__('Logout'), ['controller' => 'Users', 'action' => 'logout'], ['confirm' => __('Are you sure you want to logout?')]) ?>
            <?php else: ?>
                <?= $this->Html->link(__('Login'), ['controller' => 'Users', 'action' => 'login']) ?>
            <?php endif; ?>
        </div>
    </nav>
    <main class="main">
        <div class="container">
            <div class="row">
/*                <div class="column column-20" id="menu">
                    <h4><?= __('Menu') ?></h4>
                    <ul>
                        <?php
                        $menusTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Menus');
                        $menus = $menusTable->find('all', ['order' => ['ordre' => 'ASC']])->toArray();
                        foreach ($menus as $menu): ?>
                            <li><?= $this->Html->link($menu->intitule, $menu->lien) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="column column-80">
                    <?= $this->Flash->render() ?>
                    <?= $this->fetch('content') ?>
                </div>
            </div>
        </div>
    </main>
    <footer>
    </footer>
</body>
</html>
