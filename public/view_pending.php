<?php
require_once("../includes/initialize.php");

//check if logged in and redirect if not
if (!$session->is_logged_in()) {
    redirect_to("login.php");
}

//check to see if something was canceled, if so, update the database
if (isset($_POST['submit'])) {
    if (!is_null($_POST['appreciation_id'])) {
        if (Appreciation::cancel_appreciation($_POST['appreciation_id'], $session->userid)) {
            $session->set_message("Appreciation was successfully canceled.", "success");
            redirect_to("view_pending.php");
        } else {
            $session->set_message("An error occured canceling your appreciation.", "danger");
            redirect_to("view_pending.php");
        }
    }
}

//get current logged in user and load their information
$user = User::find_by_id($session->userid);

//load pending appreciation for a user
$pending_appreciations = Appreciation::find_by_sql("SELECT * FROM appreciation WHERE giver_id = ".$session->userid." AND status_id = 3 ORDER BY date_given");
?>

<?php include_layout_template("header.php"); ?>
<?php echo output_message($session->get_message(), $session->get_alert_type()); ?>
<div class="container-fluid">
<div class="row">
<!-- left sidebar column -->
<?php include_layout_template("user_sidebar.php"); ?>

<!-- right main column -->
    <div class="col-md-9">
        <div class="fk">
            <ul class="ca bqf bqg agk">
                
                <li class="tu b ahx">
                    <h2>Appreciation Pending Approval</h2>
                </li>
                
                <li class="tu b ahx">
            
            <div class="modal fade" id="confirm-cancel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Cancel Confirmation</h4>
                        </div>
                    
                        <div class="modal-body">
                            
                            <form method="POST" action="view_pending.php">
                                <div class="form-group">
                                    <label for="deny_description">Are you sure you want to cancel this appreciation?</label>
                                    <input id="appreciation_id" type="hidden" value="" name="appreciation_id">
                                </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            <input type="submit" class="btn btn-primary btn-ok" name="submit" value="Yes"></form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if (empty($pending_appreciations)) {
                echo output_message("There is nothing to show here!", "success");
            } else { ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Given To</th>
                            <th>Date Given</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Point Value</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($pending_appreciations as $pending_appreciation) { ?>
                        <tr>
                            <td><?php echo get_full_name($pending_appreciation->receiver_id); ?></td>
                            <td><?php echo $pending_appreciation->date_given; ?></td>
                            <td><?php echo get_category_name($pending_appreciation->category_id); ?></td>
                            <td><?php echo $pending_appreciation->description; ?></td>
                            <td><?php echo $pending_appreciation->point_value; ?></td>
                            <td><a href="#" data-href="<?php echo $pending_appreciation->id; ?>" data-toggle="modal" data-target="#confirm-cancel"><button type="button" class="btn btn-primary">Cancel</button></a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
            </li>
            </ul>
        </div>
    </div>
</div>
</div>

<script>
    $('#confirm-cancel').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        $('input#appreciation_id').val($(this).find('.btn-ok').attr('href'))
    });
</script>
<?php include_layout_template("footer.php"); ?>