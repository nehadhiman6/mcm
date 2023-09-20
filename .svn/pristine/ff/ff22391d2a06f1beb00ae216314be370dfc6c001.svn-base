<html>
<head>
<title>Transaction</title>
</head>
<body>
	<center><h1>Please do not refresh this page...</h1></center>
		<form method="post" action="{{ config('services.paytm.trnurl') }}" name="f1">
        @foreach($data as $name => $value) 
            <input type="hidden" name="{{ $name }}" value="{!! $value !!}">
        @endforeach
        <input type="hidden" name="CHECKSUMHASH" value="{!! $checkSum !!}">
		<script type="text/javascript">
			document.f1.submit();
		</script>
	</form>
</body>
</html>