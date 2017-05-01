    <div class="modal fade" id="feedback" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Enter your feedback, suggestions, or report a bug:</h4>
                </div>
            
                <div class="modal-body">
                    
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
            
    <footer class="footer">
      <div class="container">
          <p class="logo_left"><strong><a href="http://www.thanksfrom.me" target="_blank">thanksfrom.me</a></strong></p>
          <p class="links_right"><a href="#" feed-href="feedback.php" data-toggle="modal" data-target="#feedback">Feedback | Report a Bug</a></p>
          <div style="clear: both"></div>
      </div>
    </footer>
<script>
    $("#feedback").on("show.bs.modal", function(e) {
    var link = $(e.relatedTarget);
    $(this).find(".modal-body").load(link.attr("feed-href"));
    });
</script>
  </body>
</html>
<?php if(isset($database)) { $database->close_connection(); } ?>