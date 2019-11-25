<?php use Cake\Core\Configure; ?>
<nav class="navbar navbar-static-top">

  <?php if (isset($layout) && $layout == 'top'): ?>
  <div class="container">

    <div class="navbar-header">
      <a href="<?php echo $this->Url->build('/'); ?>" class="navbar-brand"><?php echo Configure::read('Theme.logo.large') ?></a>
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
        <i class="fa fa-bars"></i>
      </button>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
        <li><a href="#">Link</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li class="divider"></li>
            <li><a href="#">Separated link</a></li>
            <li class="divider"></li>
            <li><a href="#">One more separated link</a></li>
          </ul>
        </li>
      </ul>
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
        </div>
      </form>
    </div>
    <!-- /.navbar-collapse -->
  <?php else: ?>

    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a>

  <?php endif; ?>



  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <!-- Notifications: style can be found in dropdown.less -->
      <li class="dropdown notifications-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <i class="fa fa-bell-o"></i>
          <span class="label label-warning" id="notice_count"></span>
        </a>
        <ul class="dropdown-menu">
          <li class="header">お知らせリスト（処理待ちタスク）</li>
          <li>
            <!-- inner menu: contains the actual data -->
            <ul class="menu">
              <li class="dropdown-header text-blue" id="unconfirmed_order_list"><i class="fa fa-phone"></i>　間近の未確定注文</li>           
              <li class="dropdown-header text-green" id="unfinished_work_list"><i class="fa fa-briefcase"></i>　期間終了未完了作業</li>
              <li class="dropdown-header text-orange" id="unbilled_order_list"><i class="fa fa-credit-card"></i>　完了未請求注文</li>
              <li class="dropdown-header text-red" id="unpaid_bill_list"><i class="fa fa-money"></i>　締切後未回収請求</li>
            </ul>
          </li>
          <li class="footer"></li>
        </ul>
      </li>

      <!-- configurations -->
      <?php if($Auth->user('role') == 'admin'): ?>
      <li class="dropdown configurations-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <i class="fa fa-cog"></i>
        </a>
        <ul class="dropdown-menu">
          <li class="header">設定</li>
          <li>
            <!-- inner menu: contains the actual data -->
            <ul class="menu">
              <li>
                <a href="<?php 
                echo $this->Url->build(['controller'=>'users', 'action'=>'index']); ?>">
                  <i class="fa fa-users text-aqua"></i> ユーザー一覧
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </li>
      <?php endif; ?>

      <!-- User Account: style can be found in dropdown.less -->
      <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <?php echo $this->Html->image('user.png', array('class' => 'user-image', 'alt' => 'User Image')); ?>
          <span class="hidden-xs"><?=$Auth->user('formal_name')  ?></span>
        </a>
        <ul class="dropdown-menu">
          <!-- User image -->
          <li class="user-header">
            <?php echo $this->Html->image('user.png', array('class' => 'img-circle', 'alt' => 'User Image')); ?>

            <p>
            <?=$Auth->user('formal_name')  ?>
              <small class="text-bold">--　<?=$Auth->user('role')  ?>　--</small>
            </p>
          </li>
          <!-- Menu Footer-->
          <li class="user-footer">
            <div class="pull-left">
              
              <!-- <a href="#" class="btn btn-default btn-flat">ユーザー情報</a> -->
              <?= $this->Html->link( __('ユーザー情報'), ['controller' => 'users', 'action' => 'view',$Auth->user('id')],
                    ['class' => 'btn btn-default btn-flat']) ?>              
            </div>
            <div class="pull-right">
              <?= $this->Html->link( __('ログアウト'), ['controller' => 'users', 'action' => 'logout'],
                    ['class' => 'btn btn-default btn-flat']) ?>
            </div>
          </li>
        </ul>
      </li>
      <!-- Control Sidebar Toggle Button -->
      <?php if (!isset($layout)): ?>
      <!-- <li>
        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
      </li> -->
      <?php endif; ?>
    </ul>
  </div>

  <?php if (isset($layout) && $layout == 'top'): ?>
  </div>
  <?php endif; ?>
</nav>
<!-- notifications -->
<?php echo $this->Html->script('notifications'); ?>