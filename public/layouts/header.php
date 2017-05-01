<?php
global $database;
global $session;
$permissions = Role_Perm::get_role_perms($session->roleid);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>thanksfrom.me</title>
    
    <!-- Javascript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="<?php echo include_js("bootstrap.min.js"); ?>"></script>
    <?php if (strcmp(basename($_SERVER['PHP_SELF']),"recognize.php")==0) { echo "<script src=\"".include_js("selectize.min.js")."\"></script>"; } ?>
    <?php if (strcmp(basename($_SERVER['PHP_SELF']),"reward.php")==0) { echo "<script src=\"".include_js("selectize.min.js")."\"></script>"; } ?>
    <?php if (strcmp(basename($_SERVER['PHP_SELF']),"edit_appreciation.php")==0) { echo "<script src=\"".include_js("selectize.min.js")."\"></script>"; } ?>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo include_css("bootstrap.min.css"); ?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo include_css("admin-css.css"); ?>" rel="stylesheet">
    <?php if (strcmp(basename($_SERVER['PHP_SELF']),"main.php")==0) { echo "<link href=\"".include_css("main.css")."\" rel=\"stylesheet\">"; } ?>
    <?php if (strcmp(basename($_SERVER['PHP_SELF']),"recognize.php")==0) { echo "<link href=\"".include_css("main.css")."\" rel=\"stylesheet\">"; } ?>
    <?php if (strcmp(basename($_SERVER['PHP_SELF']),"reward.php")==0) { echo "<link href=\"".include_css("main.css")."\" rel=\"stylesheet\">"; } ?>
    <?php if (strcmp(basename($_SERVER['PHP_SELF']),"my_profile.php")==0) { echo "<link href=\"".include_css("main.css")."\" rel=\"stylesheet\">"; } ?>
    <?php if (strcmp(basename($_SERVER['PHP_SELF']),"my_configuration.php")==0) { echo "<link href=\"".include_css("main.css")."\" rel=\"stylesheet\">"; } ?>
    <?php if (strcmp(basename($_SERVER['PHP_SELF']),"my_appreciation.php")==0) { echo "<link href=\"".include_css("main.css")."\" rel=\"stylesheet\">"; } ?>
    <?php if (strcmp(basename($_SERVER['PHP_SELF']),"view_pending.php")==0) { echo "<link href=\"".include_css("main.css")."\" rel=\"stylesheet\">"; } ?>
    <?php if (strcmp(basename($_SERVER['PHP_SELF']),"help.php")==0) { echo "<link href=\"".include_css("main.css")."\" rel=\"stylesheet\">"; } ?>
    <?php if (strcmp(basename($_SERVER['PHP_SELF']),"release_notes.php")==0) { echo "<link href=\"".include_css("main.css")."\" rel=\"stylesheet\">"; } ?>
    <link href="<?php echo include_css("footer.css"); ?>" rel="stylesheet">
    <?php if (strcmp(basename($_SERVER['PHP_SELF']),"login.php")==0) { echo "<link href=\"".include_css("signin.css")."\" rel=\"stylesheet\">"; } ?>
    <?php if (strcmp(basename($_SERVER['PHP_SELF']),"recognize.php")==0) { echo "<link href=\"".include_css("selectize.min.css")."\" rel=\"stylesheet\">"; } ?>
    <?php if (strcmp(basename($_SERVER['PHP_SELF']),"recognize.php")==0) { echo "<link href=\"".include_css("selectize.bootstrap.css")."\" rel=\"stylesheet\">"; } ?>
    <?php if (strcmp(basename($_SERVER['PHP_SELF']),"reward.php")==0) { echo "<link href=\"".include_css("selectize.min.css")."\" rel=\"stylesheet\">"; } ?>
    <?php if (strcmp(basename($_SERVER['PHP_SELF']),"reward.php")==0) { echo "<link href=\"".include_css("selectize.bootstrap.css")."\" rel=\"stylesheet\">"; } ?>
    <?php if (strcmp(basename($_SERVER['PHP_SELF']),"edit_appreciation.php")==0) { echo "<link href=\"".include_css("selectize.min.css")."\" rel=\"stylesheet\">"; } ?>
    <?php if (strcmp(basename($_SERVER['PHP_SELF']),"edit_appreciation.php")==0) { echo "<link href=\"".include_css("selectize.bootstrap.css")."\" rel=\"stylesheet\">"; } ?>
    <?php if (strcmp(basename($_SERVER['PHP_SELF']),"my_profile.php")==0) { echo "<link href=\"".include_css("selectize.min.css")."\" rel=\"stylesheet\">"; } ?>
    <?php if (strcmp(basename($_SERVER['PHP_SELF']),"my_profile.php")==0) { echo "<link href=\"".include_css("selectize.bootstrap.css")."\" rel=\"stylesheet\">"; } ?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo DS.'main.php'; ?>"><img src="<?php echo DS.'bus_unit_picture'.DS.'nstarlogo.png'; ?>"></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <?php if ($permissions->permissions['Give Appreciation']){ ?>
            <li><a href="<?php echo DS.'recognize.php'; ?>">Recognize Someone</a></li>
            <?php } ?>
            <?php if ($permissions->permissions['Request Rewards']){ ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Request Rewards <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <?php 
                        $sql = "SELECT DISTINCT category.id, category.category_name FROM user JOIN user_role ON user_role.user_id = user.id JOIN category_perm_bu ON category_perm_bu.bu_id = user.business_unit_id JOIN category_perm_role ON category_perm_role.role_id = user_role.role_id JOIN category ON category.id = category_perm_role.category_id WHERE user.id = ".$session->userid." AND category.is_reward = 1"; 
                        $query = $database->query($sql);
                        while($row = $database->fetch_array($query)) {
                          $id = $row['id'];
                          $name = $row['category_name'];
                          
                          echo "<li><a href=\"".DS."reward.php?id=".$id."\">".$name."</a></li>";
                        }
                ?>
              </ul>
            </li>
            <?php } ?>
            <li><a href="<?php echo DS.'help.php'; ?>">Help</a></li>
            <?php
            if ($permissions->permissions['Admin Menu']){ ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo DS.'admin'.DS.'index.php'; ?>">Dashboard</a></li>
                <li><a href="<?php echo DS.'admin'.DS.'user_management.php'; ?>">Users</a></li>
                <li><a href="<?php echo DS.'admin'.DS.'businessunit_management.php'; ?>">Business Units</a></li>
                <li><a href="<?php echo DS.'admin'.DS.'department_management.php'; ?>">Departments</a></li>
                <li><a href="<?php echo DS.'admin'.DS.'category_management.php'; ?>">Recognition Categories</a></li>
                <li><a href="<?php echo DS.'admin'.DS.'reward_management.php'; ?>">Rewards</a></li>
                <li><a href="<?php echo DS.'admin'.DS.'service_management.php'; ?>">Service Awards</a></li>
                <li><a href="<?php echo DS.'admin'.DS.'role_management.php'; ?>">Roles</a></li>
                <li><a href="<?php echo DS.'admin'.DS.'approval_management.php'; ?>">Approvals</a></li>
                <li><a href="<?php echo DS.'admin'.DS.'report_management.php'; ?>">Reports</a></li>
              </ul>
            <?php }
            ?>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo get_full_name($session->userid); ?> <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo DS.'my_profile.php'; ?>">My Profile</a></li>
                  <li><a href="<?php echo DS.'my_appreciation.php'; ?>">My Recognition/Rewards</a></li>
                  <li><a href="<?php echo DS.'view_pending.php'; ?>">View Pending</a></li>
                  <li><a href="<?php echo DS.'my_configuration.php'; ?>">Configuration</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="<?php echo DS.'logout.php'; ?>">Log Out</a></li>
                </ul>
              </li>
          </ul>
        </div>
      </div>
    </nav>