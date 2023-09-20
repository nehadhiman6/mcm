<?php
$action = $data['trnurl'];
?>
<html>
  <head>
    <script type="text/JavaScript">
      function popUp()
      {
      document.payuForm.submit();
      }
    </script>
    <title>PayU - Thank you</title>
  </head>
  <body onload="popUp()">
    <!--<body>-->
    <form action="<?php echo $action; ?>" method="post" name="payuForm">
      <?php
      echo Form::hidden('key', $data['key']);
      echo Form::hidden('hash', $data['hash']);
      echo Form::hidden('txnid', $data['txnid']);
      echo Form::hidden('amount', $data['amount']);
      echo Form::hidden('productinfo', $data['productinfo']);
      echo Form::hidden('firstname', $data['firstname']);
      echo Form::hidden('email', $data['email']);
      echo Form::hidden('phone', $data['phone']);
      echo Form::hidden('surl', $data['surl']);
      echo Form::hidden('furl', $data['furl']);
      echo Form::hidden('service_provider', $data['service_provider']);
      //echo Form::hidden('PG', $data['pg']);
//      echo Form::hidden('enforce_paymethod', $data['enforce_paymethod']);
      //echo Form::hidden('drop_category', $data['drop_category']);
      //echo Form::hidden('service_provider', $data['service_provider']);
      ?>
    </form>
  </body>
</html>