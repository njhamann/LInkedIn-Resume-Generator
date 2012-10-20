<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('partials/head'); ?>
  </head>

  <body>
    <div class="container">
        <?php $this->load->view('partials/header'); ?>
        <div class="row">
            <div id="resume_container" class="span9 example-resume">
            </div>
            <div class="span3">
                <h4>The one minute resume</h4>
                <p>The easiest way to create a new beautiful resume using your LinkedIn account.</p>
                <?php if(!$isLoggedIn) { ?>
                    <form id="linkedin_connect_form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="get">
                        <input type="hidden" name="<?php echo LINKEDIN::_GET_TYPE;?>" id="<?php echo LINKEDIN::_GET_TYPE;?>" value="initiate" />
                        <button type="submit" class="btn btn-primary btn-block">Login with LinkedIn</button> 
                    </form>
                <?php }else{ ?>
                    <form id="linkedin_revoke_form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="get">
                      <input type="hidden" name="<?php echo LINKEDIN::_GET_TYPE;?>" id="<?php echo LINKEDIN::_GET_TYPE;?>" value="revoke" />
                      <input type="submit" value="Revoke Authorization" />
                    </form>
                <?php } ?>
              
            </div><!--span3-->
        </div><!--row-->
    </div> <!-- /container -->

    </script>
    <script type="text/html" id="resume_layout_1">
        <?php $this->load->view('partials/resume'); ?>
    </script>
    <script>
        var resumeData = <?php echo $json_data ?>;
    </script>
    <?php $this->load->view('partials/footer'); ?>
    <?php $this->load->view('partials/javascript'); ?>
  </body>
</html>

