<div class="user-panel">
    <div class="pull-left image">
        <?php echo $this->Html->image('user.png', array('class' => 'img-circle', 'alt' => 'User Image')); ?>
    </div>
    <div class="pull-left info">
        <p><?=$Auth->user('formal_name')  ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> <?=$Auth->user('role')  ?></a>
    </div>
</div>