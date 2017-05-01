<?php
require_once("../../includes/initialize.php");

//verify user is logged in
if (!$session->is_logged_in()) {
    redirect_to("../login.php");
}
//load role permissions and check if they have access
$permissions = Role_Perm::get_role_perms($session->roleid);
if (!$permissions->permissions['Approve']){
    $session->set_message("You do not have access to do approvals.", "danger");
    redirect_to("../main.php");
}

$appreciations = Appreciation::find_by_sql("SELECT * FROM appreciation WHERE status_id=3");
?>
<?php include_layout_template("header.php"); ?>
<?php include_layout_template("admin_sidebar.php"); ?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <?php echo output_message($session->get_message(), $session->get_alert_type()); ?>
    <h2 class="sub-header">Approvals</h2>
    <div class="table-responsive">

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Deny Confirmation</h4>
            </div>
        
            <div class="modal-body">
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="deny_description">Why are you denying this appreciation?</label>
                        <textarea class="form-control" id="deny_description" name="deny_description" rows="5" cols="40" required></textarea>
                    </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <input type="submit" class="btn btn-danger btn-ok" name="submit" value="Deny"></form>
            </div>
        </div>
    </div>
</div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Received By</th>
                <th>Given By</th>
                <th>Date Given</th>
                <th>Category</th>
                <th>Description</th>
                <th>Point Value</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($appreciations as $appreciation) { ?>
            <tr>
                <td><?php echo get_full_name($appreciation->receiver_id); ?></td>
                <td><?php echo get_full_name($appreciation->giver_id); ?></td>
                <td><?php echo $appreciation->date_given; ?></td>
                <td><?php echo get_category_name($appreciation->category_id); ?></td>
                <td><?php echo $appreciation->description; ?></td>
                <td><?php echo $appreciation->point_value; ?></td>

                <td><a href="edit_appreciation.php?id=<?php echo $appreciation->id; ?>">Edit</a> | <a href="#" data-href="process_appreciation.php?id=<?php echo $appreciation->id; ?>&type=d" data-toggle="modal" data-target="#confirm-delete">Deny</a> | <a href="process_appreciation.php?id=<?php echo $appreciation->id; ?>&type=a">Approve</a></td>
            </tr>
            <?php } ?>
        </tbody>
</table>

<script>
    $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        $('form').attr('action', $(this).find('.btn-ok').attr('href'));
    });
</script>
<?php include_layout_template("admin_footer.php"); ?>