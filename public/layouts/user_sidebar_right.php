 <?php
    global $session;
    $picture_id = User::get_picture_id($session->userid);
    $right_stats = Appreciation::sidebar_user_stats_right($session->userid);
 ?>
 
    <div class="fh">

      <div class="rp agk ayf">
        <div class="rq">
        <h4 class="agd">Points</h4>
        <ul class="bqf bqg">
          <li class="tu afw">
            <div class="tv">
              Available to redeem by me: <strong><?php echo $right_stats[0]; ?></strong>
            </div>
          </li>
          <li class="tu afw">
            <div class="tv">
              Mine last week: <strong><?php echo $right_stats[1]; ?></strong>
            </div>
          </li>
          <li class="tu afw">
            <div class="tv">
              Company average last week: <strong><?php echo $right_stats[2]; ?></strong>
            </div>
          </li>
          <li class="tu afw">
            <div class="tv">
              My total all time: <strong><?php echo $right_stats[3]; ?></strong>
            </div>
          </li>
        </ul>
        </div>
      </div>

      <div class="rp agk ayf">
        <div class="rq">
        <h4 class="agd">Top receivers this month</h4>
        <ul class="bqf bqg">
          <?php foreach($right_stats[4] as $top_rec) {
              $rec = get_full_name($top_rec->receiver_id);
              $number = $top_rec->number;
              $picture = User::get_picture_id($top_rec->receiver_id);
              echo "
              <li class=\"tu afw\">
                <img class=\"bqb wp yy agc\" src=\"pictures/".$picture."\">
                <div class=\"tv\">
                  <strong>".$rec."</strong>
                  <div class=\"bqj\">
                    ".$number." appreciation received
                  </div>
                </div>
              </li>
              ";
            }
            ?>
        </ul>
        </div>
      </div>
      
      <div class="rp agk ayf">
        <div class="rq">
        <h4 class="agd">Top senders this month</h4>
        <ul class="bqf bqg">
          <?php foreach($right_stats[5] as $top_giv) {
              $give = get_full_name($top_giv->giver_id);
              $number = $top_giv->number;
              $picture = User::get_picture_id($top_giv->giver_id);
              echo "
              <li class=\"tu afw\">
                <img class=\"bqb wp yy agc\" src=\"pictures/".$picture."\">
                <div class=\"tv\">
                  <strong>".$give."</strong>
                  <div class=\"bqj\">
                    ".$number." appreciation given
                  </div>
                </div>
              </li>
              ";
            }
            ?>
        </ul>
        </div>
      </div>

    </div>