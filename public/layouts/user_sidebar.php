 <?php
    global $session;
    $picture_id = User::get_picture_id($session->userid);
    $bu_picture = Business_Unit::get_picture_id($session->userid);
    $left_stats = Appreciation::sidebar_user_stats_left($session->userid);
 ?>
  <div class="col-md-3">

        <div class="rp bqr agk">
          <div class="rv" style="background-image: url(bus_unit_picture/<?php echo $bu_picture; ?>);"></div>
          <div class="rq awx">
          <img src="pictures/<?php echo $picture_id; ?>" height="100" width="110" class="bqs">
          <p>Total number of recognition given and received year to date:</p>
          <ul class="bqt">
            <li class="bqu">
                Given
                <h5><strong><?php echo $left_stats[0]; ?></strong></h5>
            </li>
            <li class="bqu">
                Received
                <h5><strong><?php echo $left_stats[1]; ?></strong></h5>
            </li>
          </ul>
          </div>
      </div>
      
      
      <div class="rp brb brc agk">
        <div class="rq">
          <h4 class="agd">My last 5 recognition:</h4>
          <ul class="dc ayo">
            
            <?php foreach($left_stats[2] as $last_five) {
              $giver = get_full_name($last_five->giver_id);
              $category = get_category_name($last_five->category_id);
              $date = date('m/d/Y', strtotime($last_five->date_approved));
              echo "<li><strong>{$category}</strong> from {$giver} on {$date}</li>";
            }
            ?>
          </ul>
        </div>
      </div>

    </div>