<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('partials/head'); ?>
  </head>

  <body>
    <div class="container">
        <?php $this->load->view('partials/header'); ?>
        <div class="row">
            <div class="span4">
            </div>
            <div class="span4">
                <?php if(!$message_sent){ ?>
                <form action="<?php echo site_url('marketing/contact') ?>" method="post">
                    <legend>Contact</legend>
                    <label>Name</label>
                    <input class="span4" type="text" name="name" placeholder="Enter your full name...">
                    <label>Email</label>
                    <input class="span4" type="text" name="email" placeholder="Enter your email...">
                    <label>Type</label>
                    <select class="span4" name="type" name="type">
                        <option value="question">Question</option>
                        <option value="bug">Bug Report</option>
                    </select> 
                    <label>Message</label>
                    <textarea class="span4" name="message" placeholder="Enter a message...">
                    </textarea>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>    
                <?php }else{ ?>
                    <div class="well">
                        <p>Thank you for your message. We will get back to you shortly.</p>
                    </div>
                <?php } ?>
            </div>
            <div class="span4">
            </div><!--span3-->
        </div><!--row-->
    </div> <!-- /container -->
    <?php $this->load->view('partials/footer'); ?>
    <?php $this->load->view('partials/javascript'); ?>
  </body>
</html>

