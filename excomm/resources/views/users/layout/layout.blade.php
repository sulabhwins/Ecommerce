<!DOCTYPE html>
<html lang="en">

<head>
  <title>Zay Shop eCommerce HTML CSS Template</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="apple-touch-icon" href="{{url('users/img/apple-icon.png')}}">
  <link rel="shortcut icon" type="image/x-icon" href="{{url('users/img/favicon.ico')}}">

  <link rel="stylesheet" href="{{url('users/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{url('users/css/templatemo.css')}}">
  <link rel="stylesheet" href="{{url('users/css/custom.css')}}">

  <!-- Load fonts style after rendering the layout styles -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
  <link rel="stylesheet" href="{{url('users/css/fontawesome.min.css')}}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!--
    
TemplateMo 559 Zay Shop

https://templatemo.com/tm-559-zay-shop

-->
</head>

<body>
  <div class="wrapper">

    @include('users.layout.header')

    <div class="container mb-4 mt-4">
      @yield('contents')

    </div>

    @include('users.layout.footer')

    <!-- Start Script -->
    <script src="{{url('users/js/jquery-1.11.0.min.js')}}"></script>
    <script src="{{url('users/js/jquery-migrate-1.2.1.min.js')}}"></script>
    <script src="{{url('users/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{url('users/js/templatemo.js')}}"></script>
    <script src="{{url('users/js/custom.js')}}"></script>

    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

    <script type="text/javascript">
      $(function() {

        var $form = $(".require-validation");

        $('form.require-validation').bind('submit', function(e) {
          var $form = $(".require-validation"),
            inputSelector = ['input[type=email]', 'input[type=password]',
              'input[type=text]', 'input[type=file]',
              'textarea'
            ].join(', '),
            $inputs = $form.find('.required').find(inputSelector),
            $errorMessage = $form.find('div.error'),
            valid = true;
          $errorMessage.addClass('hide');

          $('.has-error').removeClass('has-error');
          $inputs.each(function(i, el) {
            var $input = $(el);
            if ($input.val() === '') {
              $input.parent().addClass('has-error');
              $errorMessage.removeClass('hide');
              e.preventDefault();
            }
          });

          if (!$form.data('cc-on-file')) {
            e.preventDefault();
            Stripe.setPublishableKey($form.data('stripe-publishable-key'));
            Stripe.createToken({
              number: $('.card-number').val(),
              cvc: $('.card-cvc').val(),
              exp_month: $('.card-expiry-month').val(),
              exp_year: $('.card-expiry-year').val()
            }, stripeResponseHandler);
          }

        });

        function stripeResponseHandler(status, response) {
          if (response.error) {
            $('.error')
              .removeClass('hide')
              .find('.alert')
              .text(response.error.message);
          } else {
            /* token contains id, last4, and card type */
            var token = response['id'];

            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
          }
        }

      });
    </script>
    <!-- End Script -->
  </div>
</body>

</html>