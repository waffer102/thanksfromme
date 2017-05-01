<?php
require_once("../includes/initialize.php");

if (!$session->is_logged_in()) {
    redirect_to("login.php");
}
?>

<?php include_layout_template("header.php"); ?>
<?php echo output_message($session->get_message(), $session->get_alert_type()); ?>
    <div class="container-fluid">
        <div class="row">
            <!-- left sidebar column -->
            <?php include_layout_template("user_sidebar.php"); ?>
            <!-- right main column -->
            <div class="col-md-6">
                <div class="fk">

                    <ul class="ca bqf bqg agk">

                        <li class="tu b ahx">
                            <h3 class="agd">Recent Appreciation</h3>
                        </li>

                        <?php
                        $live_feeds = Appreciation::find_for_livefeed(10);

                        foreach ($live_feeds as $live_feed) {
                            $giver = get_full_name($live_feed->giver_id);
                            $receiver = get_full_name($live_feed->receiver_id);
                            $category = get_category_name($live_feed->category_id);
                            $picture = User::get_picture_id($live_feed->receiver_id);
                            echo "
                <li class=\"tu b ahx\">
                  <img
                    class=\"bqb wp yy agc\"
                    src=\"pictures/" . $picture . "\">
                  <div class=\"tv\">
                    <div class=\"bqm\">
                      <div class=\"bqk\">
                        <small class=\"aec axr\">By " . $giver . " on " . date('m/d/Y g:i a', strtotime($live_feed->date_approved)) . ".</small>
                        <h6><strong>" . $receiver . "</strong> was recognized for <strong>" . $category . "</strong>!</h6>
                      </div>
                      <p>
                        " . $live_feed->description . "
                      </p>
                    </div>
                  </div>
                </li>";
                        }
                        ?>
                    </ul>

                </div>

            </div>

            <div class="col-md-3">
                <?php include_layout_template("user_sidebar_right.php"); ?>
            </div>

        </div>
    </div>
<?php include_layout_template("footer.php"); ?>