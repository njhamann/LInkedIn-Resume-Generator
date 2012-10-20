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
                <h4>Checkout</h4>
            <form action="<?php echo site_url('checkout/submit_payment') ?>" method="POST" id="payment-form">
              <div class="form-row">
                <input placeholder="Credit Card Number" value="4242424242424242" type="text" size="20" autocomplete="off" class="card-number"/>
              </div>
              <div class="form-row">
                <input placeholder="MM" type="text" size="2" class="card-expiry-month span1"/>
                <span> / </span>
                <input placeholder="YYYY" type="text" size="4" class="card-expiry-year span1"/>
              </div>
              <div class="form-row">
                <input placeholder="CVC" type="text" size="4" autocomplete="off" class="card-cvc span1"/>
              </div>
              <button type="submit" class="submit-button btn btn-primary">Submit Payment</button>
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
    <script type="text/javascript" src="https://js.stripe.com/v1/"></script>
    <script type="text/javascript">
        Stripe.setPublishableKey('pk_Oz2Rfz97V2ueWyj5JvjxHqGQaJUFy');
        function stripeResponseHandler(status, response) {
            if (response.error) {
                // show the errors on the form
                $(".payment-errors").text(response.error.message);
                $(".submit-button").removeAttr("disabled");
            } else {
                var form$ = $("#payment-form");
                // token contains id, last4, and card type
                var token = response['id'];
                // insert the token into the form so it gets submitted to the server
                form$.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                // and submit
                form$.get(0).submit();
            }
        }
        $(document).ready(function() {
            $("#payment-form").submit(function(event) {
                // disable the submit button to prevent repeated clicks
                $('.submit-button').attr("disabled", "disabled");

                Stripe.createToken({
                    number: $('.card-number').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val()
                }, stripeResponseHandler);

                // prevent the form from submitting with the default action
                return false;
            });
        });    
    </script>
  </body>
</html>

