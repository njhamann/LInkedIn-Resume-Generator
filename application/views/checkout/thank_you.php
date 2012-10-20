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
                <h4>Thank you for your purchase</h4>
                <form id="download_resume_form" method="post" action="<?php echo site_url('checkout/download/'.$resumeId); ?>" target="_blank">
                    <input id="resume_markup_input" type="hidden" name="markup" />
                    <button id="download_resume_button" class="btn btn-primary" type="submit">Download Resume</button>
                </form>
            </div><!--span3-->
        </div><!--row-->
    </div> <!-- /container -->
    
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

