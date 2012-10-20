<div class="navbar navbar-inverse navbar-fixed-top">

  <div class="navbar-inner">
    <div class="container">
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <a class="brand" href="#">LinkedIn Toolkit</a>
      <div class="nav-collapse collapse">
        <ul class="nav">
          <li class="active"><a href="<?php echo site_url('marketing') ?>">Resume Builder</a></li>
          <li><a href="<?php echo site_url('marketing/contact') ?>">Contact</a></li>
        </ul>
        <?php if(!is_logged_in()){ ?>
        <ul class="nav pull-right">
          <li><a href="<?php echo site_url('marketing/logout') ?>">Logout</a></li>
        </ul>
        <?php } ?>
        </ul>
      </div>
    </div>
  </div>
</div>
<!--
<div class="row header-row">
    <div class="span10">
        <h1 class="page-title">Resume Builder</h1>
    </div>
</div>
-->
