<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $this->load->view('partials/head'); ?>
        <style>
            body{
                background: #f5f5f5; 
            }
        </style>
    </head>
  <body>
    <div class="container">
        <div class="row">
            <div id="resume_container" class="span12 example-resume">
            </div>
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

