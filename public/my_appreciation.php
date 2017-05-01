<?php
require_once("../includes/initialize.php");

//check if logged in and redirect if not
if (!$session->is_logged_in()) {
    redirect_to("login.php");
}

//check to see if something was redeemeded, if so, update the database
if (isset($_POST['submit'])) {
    if (!is_null($_POST['appreciation_id'])) {
        if (Appreciation::redeem_appreciation($_POST['appreciation_id'])) {
            $session->set_message("Appreciation was successfully redeemed.", "success");
            redirect_to("my_appreciation.php");
        } else {
            $session->set_message("An error occured redeeming your appreciation.", "danger");
            redirect_to("my_appreciation.php");
        }
    }
}

//get current logged in user and load their information
$user = User::find_by_id($session->userid);

//load non-redeemed appreciation for a user
$redeem_appreciations = Appreciation::find_by_sql("SELECT * FROM appreciation WHERE receiver_id = ".$session->userid." AND paid_out = 0 AND status_id = 4 ORDER BY date_given");

//load all appreciation for a user, eventually add a filter option
$appreciations = Appreciation::find_by_sql("SELECT * FROM appreciation WHERE receiver_id = ".$session->userid." AND status_id = 4 ORDER BY date_given");
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
                
            <h2 class="sub-header">Available to Redeem</h2>
            <?php
            if (empty($redeem_appreciations)) {
                echo output_message("There is nothing to show here!", "success");
            } else { ?>
            <div class="modal fade" id="confirm-redeem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Redeem Confirmation</h4>
                        </div>
                    
                        <div class="modal-body">
                            
                            <form method="POST" action="my_appreciation.php">
                                <div class="form-group">
                                    <label for="deny_description">Are you sure you want to redeem this?</label>
                                    <input id="appreciation_id" type="hidden" value="" name="appreciation_id">
                                </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <input type="submit" class="btn btn-primary btn-ok" name="submit" value="Redeem"></form>
                        </div>
                    </div>
                </div>
            </div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Given By</th>
                            <th>Date Given</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Point Value</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($redeem_appreciations as $redeem_appreciation) { ?>
                        <tr>
                            <td><?php echo get_full_name($redeem_appreciation->giver_id); ?></td>
                            <td><?php echo $redeem_appreciation->date_given; ?></td>
                            <td><?php echo get_category_name($redeem_appreciation->category_id); ?></td>
                            <td><?php echo $redeem_appreciation->description; ?></td>
                            <td><?php echo $redeem_appreciation->point_value; ?></td>
                            <td><a href="#" data-href="<?php echo $redeem_appreciation->id; ?>" data-toggle="modal" data-target="#confirm-redeem"><button type="button" class="btn btn-primary">Redeem</button></a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>

        
            <h2 class="sub-header"><?php echo $user->first_name; ?>'s Recognition/Rewards</h2>
            <?php
            if (empty($appreciations)) {
                echo output_message("There is nothing to show here!", "success");
            } else { ?>
            <div class="modal fade" id="view-details" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">View Appreciation Details</h4>
                        </div>
                    
                        <div class="modal-body">
                            
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            
                <table class="table table-striped">
                    <thead>
                        <tr>
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
                            <td><?php echo get_full_name($appreciation->giver_id); ?></td>
                            <td><?php echo $appreciation->date_given; ?></td>
                            <td><?php echo get_category_name($appreciation->category_id); ?></td>
                            <td><?php echo $appreciation->description; ?></td>
                            <td><?php echo $appreciation->point_value; ?></td>
                            <td><a href="#" view-href="view_appreciation.php?id=<?php echo $appreciation->id; ?>" data-toggle="modal" data-target="#view-details"><button type="button" class="btn btn-primary">View Details</button></a></td>
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
    $('#confirm-redeem').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        $('input#appreciation_id').val($(this).find('.btn-ok').attr('href'))
    });
    
    $("#view-details").on("show.bs.modal", function(e) {
    var link = $(e.relatedTarget);
    $(this).find(".modal-body").load(link.attr("view-href"));
});
</script>
<?php include_layout_template("footer.php"); ?>