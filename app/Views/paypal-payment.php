<!DOCTYPE html>
<html>
<head>
    <title>Pay with PayPal</title>
    <script src="https://www.paypal.com/sdk/js?client-id=YOUR_CLIENT_ID"></script>
</head>
<body>
    <div id="paypal-button-container"></div>

   <script>
    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '<?= number_format(session('grand_total'), 2, '.', '') ?>'
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                window.location.href = "<?= base_url('place-order') ?>";
            });
        }
    }).render('#paypal-button-container');
</script>

</body>
</html>
