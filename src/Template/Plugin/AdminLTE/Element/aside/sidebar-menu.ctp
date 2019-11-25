<ul class="sidebar-menu" data-widget="tree">
  <li class="header">MAIN Menu</li>

  <li>
        <a href="<?php echo $this->Url->build(['controller'=>'dashboards', 'action'=>'index']); ?>">
            <i class="fa fa-home"></i> <span>Top</span>
         </a>
    </li>

    <li class="treeview">
        <a href="#">
            <i class="fa fa-building-o"></i> <span>業務取引先</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $this->Url->build(['controller'=>'BusinessPartners', 'action'=>'index']); ?>"><i class="fa fa-circle-o"></i> 取引先一覧</a></li>
            <li><a href="<?php echo $this->Url->build(['controller'=>'BusinessPartners', 'action'=>'add']); ?>"><i class="fa fa-circle-o"></i> 取引先新規登録</a></li>
        </ul>
    </li>      
    <li class="treeview">
        <a href="#">
            <i class="fa fa-truck"></i> <span>装置管理</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $this->Url->build(['controller'=>'equipments', 'action'=>'index']); ?>"><i class="fa fa-circle-o"></i> 装置一覧</a></li>
            <li><a href="<?php echo $this->Url->build(['controller'=>'equipments', 'action'=>'add']); ?>"><i class="fa fa-circle-o"></i> 装置新規登録</a></li>
        </ul>
    </li>    
    <li class="treeview">
        <a href="#">
            <i class="fa fa-users"></i> <span>スタッフ</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $this->Url->build(['controller'=>'staffs', 'action'=>'index']); ?>"><i class="fa fa-circle-o"></i> スタッフ一覧</a></li>
            <li><a href="<?php echo $this->Url->build(['controller'=>'staffs', 'action'=>'add']); ?>"><i class="fa fa-circle-o"></i> スタッフ新規登録</a></li>
        </ul>
    </li>        
    <li class="treeview">
        <a href="#">
            <i class="fa fa-phone"></i> <span>注文</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $this->Url->build(['controller'=>'orders', 'action'=>'index']); ?>"><i class="fa fa-circle-o"></i> 注文一覧</a></li>
            <li><a href="<?php echo $this->Url->build(['controller'=>'orders', 'action'=>'add']); ?>"><i class="fa fa-circle-o"></i> 新規受注</a></li>
        </ul>
    </li>        
    <li class="treeview">
        <a href="#">
            <i class="fa fa-briefcase"></i> <span>作業データ</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $this->Url->build(['controller'=>'works', 'action'=>'index']); ?>"><i class="fa fa-circle-o"></i> 作業データ一覧</a></li>
        </ul>
    </li>        
    <li class="treeview">
        <a href="#">
            <i class="fa fa-jpy"></i> <span>費用管理</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $this->Url->build(['controller'=>'cost_managements', 'action'=>'index']); ?>"><i class="fa fa-circle-o"></i> 費用データ一覧</a></li>
        </ul>
    </li>        
    <li class="treeview">
        <a href="#">
            <i class="fa fa-balance-scale"></i> <span>売掛金管理</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $this->Url->build(['controller'=>'account_receivables', 'action'=>'index']); ?>"><i class="fa fa-circle-o"></i> 売掛金データ一覧</a></li>
        </ul>
    </li>        
    <li class="treeview">
        <a href="#">
            <i class="fa fa-envelope"></i> <span>請求書管理</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
        <li><a href="<?php echo $this->Url->build(['controller'=>'bills', 'action'=>'indexAll']); ?>"><i class="fa fa-circle-o"></i> 請求書一覧</a></li>

            <?php //echo $this->cell('Payermenu')->render() ?>
        </ul>
    </li>    

    <li><a href="<?php echo $this->Url->build(['controller'=>'statistics', 'action'=>'index']); ?>"><i class="fa fa-line-chart"></i> <span>統計資料</span></a></li>
    <li><a href="<?php echo $this->Url->build(['controller'=>'pages', 'action'=>'manual/tutorial']); ?>"><i class="fa fa-book"></i> <span>マニュアル</span></a></li>






<?php if($Auth->user('role') == 'admin'): ?>
    <li><a href="<?php echo $this->Url->build(['controller'=>'DataImports', 'action'=>'index']); ?>"><i class="fa fa-upload"></i> <span>データインポート</span></a></li>


  <li class="header">REFERENCES</li>
  <li class="treeview">
    <a href="#">
      <i class="fa fa-folder"></i>
      <span>SAMPLES</span>
    </a>
    <ul class="treeview-menu">
      <li class="treeview">
      <a href="#">
        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="<?php echo $this->Url->build('/'); ?>"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
        <li><a href="<?php echo $this->Url->build('/pages/home2'); ?>"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-files-o"></i>
        <span>Layout Options</span>
        <span class="pull-right-container">
          <span class="label label-primary pull-right">4</span>
        </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="<?php echo $this->Url->build('/pages/layout/top-nav'); ?>"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
        <li><a href="<?php echo $this->Url->build('/pages/layout/boxed'); ?>"><i class="fa fa-circle-o"></i> Boxed</a></li>
        <li><a href="<?php echo $this->Url->build('/pages/layout/fixed'); ?>"><i class="fa fa-circle-o"></i> Fixed</a></li>
        <li><a href="<?php echo $this->Url->build('/pages/layout/collapsed-sidebar'); ?>"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
      </ul>
    </li>
    <li>
      <a href="<?php echo $this->Url->build('/pages/widgets'); ?>">
        <i class="fa fa-th"></i> <span>Widgets</span>
        <span class="pull-right-container">
          <small class="label pull-right bg-green">new</small>
        </span>
      </a>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-pie-chart"></i>
        <span>Charts</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="<?php echo $this->Url->build('/pages/charts/chartjs'); ?>"><i class="fa fa-circle-o"></i> ChartJS</a></li>
        <li><a href="<?php echo $this->Url->build('/pages/charts/morris'); ?>"><i class="fa fa-circle-o"></i> Morris</a></li>
        <li><a href="<?php echo $this->Url->build('/pages/charts/flot'); ?>"><i class="fa fa-circle-o"></i> Flot</a></li>
        <li><a href="<?php echo $this->Url->build('/pages/charts/inline'); ?>"><i class="fa fa-circle-o"></i> Inline charts</a></li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-laptop"></i>
        <span>UI Elements</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="<?php echo $this->Url->build('/pages/ui/general'); ?>"><i class="fa fa-circle-o"></i> General</a></li>
        <li><a href="<?php echo $this->Url->build('/pages/ui/icons'); ?>"><i class="fa fa-circle-o"></i> Icons</a></li>
        <li><a href="<?php echo $this->Url->build('/pages/ui/buttons'); ?>"><i class="fa fa-circle-o"></i> Buttons</a></li>
        <li><a href="<?php echo $this->Url->build('/pages/ui/sliders'); ?>"><i class="fa fa-circle-o"></i> Sliders</a></li>
        <li><a href="<?php echo $this->Url->build('/pages/ui/timeline'); ?>"><i class="fa fa-circle-o"></i> Timeline</a></li>
        <li><a href="<?php echo $this->Url->build('/pages/ui/modals'); ?>"><i class="fa fa-circle-o"></i> Modals</a></li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-edit"></i> <span>Forms</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="<?php echo $this->Url->build('/pages/forms/general'); ?>"><i class="fa fa-circle-o"></i> General Elements</a></li>
        <li><a href="<?php echo $this->Url->build('/pages/forms/advanced'); ?>"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
        <li><a href="<?php echo $this->Url->build('/pages/forms/editors'); ?>"><i class="fa fa-circle-o"></i> Editors</a></li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-table"></i> <span>Tables</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="<?php echo $this->Url->build('/pages/tables/simple'); ?>"><i class="fa fa-circle-o"></i> Simple tables</a></li>
        <li><a href="<?php echo $this->Url->build('/pages/tables/data'); ?>"><i class="fa fa-circle-o"></i> Data tables</a></li>
      </ul>
    </li>
    <li>
      <a href="<?php echo $this->Url->build('/pages/calendar'); ?>">
        <i class="fa fa-calendar"></i> <span>Calendar</span>
        <span class="pull-right-container">
          <small class="label pull-right bg-red">3</small>
          <small class="label pull-right bg-blue">17</small>
        </span>
      </a>
    </li>
    <li>
      <a href="<?php echo $this->Url->build('/pages/mailbox/mailbox'); ?>">
        <i class="fa fa-envelope"></i> <span>Mailbox</span>
        <span class="pull-right-container">
          <small class="label pull-right bg-yellow">12</small>
          <small class="label pull-right bg-green">16</small>
          <small class="label pull-right bg-red">5</small>
        </span>
      </a>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-folder"></i> <span>Examples</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="<?php echo $this->Url->build('/pages/examples/invoice'); ?>"><i class="fa fa-circle-o"></i> Invoice</a></li>
        <li><a href="<?php echo $this->Url->build('/pages/examples/profile'); ?>"><i class="fa fa-circle-o"></i> Profile</a></li>
        <li><a href="<?php echo $this->Url->build('/pages/examples/login'); ?>"><i class="fa fa-circle-o"></i> Login</a></li>
        <li><a href="<?php echo $this->Url->build('/pages/examples/register'); ?>"><i class="fa fa-circle-o"></i> Register</a></li>
        <li><a href="<?php echo $this->Url->build('/pages/examples/lockscreen'); ?>"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
        <li><a href="<?php echo $this->Url->build('/pages/examples/404'); ?>"><i class="fa fa-circle-o"></i> 404 Error</a></li>
        <li><a href="<?php echo $this->Url->build('/pages/examples/500'); ?>"><i class="fa fa-circle-o"></i> 500 Error</a></li>
        <li><a href="<?php echo $this->Url->build('/pages/examples/blank'); ?>"><i class="fa fa-circle-o"></i> Blank Page</a></li>
        <li><a href="<?php echo $this->Url->build('/pages/examples/pace'); ?>"><i class="fa fa-circle-o"></i> Pace Page</a></li>
      </ul>
    </li>


    <li><a href="<?php echo $this->Url->build('/pages/debug'); ?>"><i class="fa fa-bug"></i> <span>Debug</span></a></li>


    </ul>
  </li>


  <?php endif; ?>
</ul>