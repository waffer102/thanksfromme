    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li <?php echo admin_sidebar_active("index.php"); ?>><a href="index.php">Dashboard</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li <?php echo admin_sidebar_active("user_management.php", "add_user.php", "edit_user.php", "import_users.php") ?>><a href="user_management.php">Users</a></li>
            <li <?php echo admin_sidebar_active("businessunit_management.php", "add_businessunit.php", "edit_businessunit.php"); ?>><a href="businessunit_management.php">Business Units</a></li>
            <li <?php echo admin_sidebar_active("department_management.php", "add_department.php", "edit_department.php"); ?>><a href="department_management.php">Departments</a></li>
            <li <?php echo admin_sidebar_active("category_management.php", "add_category.php", "edit_category.php"); ?>><a href="category_management.php">Recognition Categories</a></li>
            <li <?php echo admin_sidebar_active("reward_management.php", "add_reward.php", "edit_reward.php"); ?>><a href="reward_management.php">Rewards</a></li>
            <li <?php echo admin_sidebar_active("service_management.php", "award_service.php", "add_service.php", "config_service.php"); ?>><a href="service_management.php">Service Awards</a></li>
            <li <?php echo admin_sidebar_active("role_management.php", "add_role.php", "edit_role.php"); ?>><a href="role_management.php">Roles</a></li>
            <li <?php echo admin_sidebar_active("approval_management.php"); ?>><a href="approval_management.php">Approvals</a></li>
            <li <?php echo admin_sidebar_active("report_management.php"); ?>><a href="report_management.php">Reports</a></li>
          </ul>
        </div>