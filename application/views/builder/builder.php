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
                <h4>Customize Your Resume</h4>
                <form method="post" action="<?php echo site_url("builder/save_config") ?>">
                    <input type="hidden" name="resume_id" value="<?php echo $user_id ?>" />
                    <label>Font</label>
                    <input type="radio" name="font" value="0" <?php echo $resume_config->font == 0 ? 'checked' : ''; ?>> Font 1
                    <input type="radio" name="font" value="1" <?php echo $resume_config->font == 1 ? 'checked' : ''; ?>> Font 2
                    <label>Layout</label>
                    <input type="radio" name="layout" value="0" <?php echo $resume_config->layout == 0 ? 'checked' : ''; ?>> Layout 1
                    <input type="radio" name="layout" value="1" <?php echo $resume_config->layout == 1 ? 'checked' : ''; ?>> Layout 2
                    <input type="radio" name="layout" value="2" <?php echo $resume_config->layout == 2 ? 'checked' : ''; ?>> Layout 3
                    <input type="radio" name="layout" value="3" <?php echo $resume_config->layout == 3 ? 'checked' : ''; ?>> Layout 4
                    <label>Color Scheme</label>
                    <input type="radio" name="color_scheme" value="0" <?php echo $resume_config->color_scheme == 0 ? 'checked' : ''; ?>> Color Scheme 1
                    <input type="radio" name="color_scheme" value="1" <?php echo $resume_config->color_scheme == 1 ? 'checked' : ''; ?>> Color Scheme 2
                    <input type="radio" name="color_scheme" value="2" <?php echo $resume_config->color_scheme == 2 ? 'checked' : ''; ?>> Color Scheme 3
                    <input type="radio" name="color_scheme" value="3" <?php echo $resume_config->color_scheme == 3 ? 'checked' : ''; ?>> Color Scheme 4
                    <button type="submit" class="btn btn-primary">Save Configuration</button>
                </form>
            </div><!--span3-->
        </div><!--row-->
    </div> <!-- /container -->
    
    <script>
        var resumeData = <?php echo $json_data ?>;
    </script>
    <script type="text/html" id="resume_layout_1">
        <?php $this->load->view('partials/resume'); ?>
    </script>
    <?php $this->load->view('partials/footer'); ?>
    <?php $this->load->view('partials/javascript'); ?>
  </body>
</html>

