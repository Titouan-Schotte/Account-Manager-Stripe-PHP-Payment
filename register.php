<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Stripe Paiement/Creating Account</title>
</head>
<body>
    <center>
        <h1 style="margin-top: 100px">Enregistrez vous !</h1>
        <form action="payment.php" id="payment_form" method="POST">
            <!-- Profil Informations -->
            <input class="input" type="text" name="username" placeholder="Votre Pseudo" required><br><br>
            <input class="input" type="email" name="email" placeholder="Your email" data-stripe="email"
                   required><br><br>
            <input class="input" type="password" name="password" id="password" placeholder="Your password"
                   required><br><br>
            <input class="input" type="password" name="password-confirm" id="password-confirm"
                   placeholder="Retype password" required><br><br><br><br>
            <!-- Paiement Informations -->
            <input class="input" type="text" placeholder="Code de carte bleue" data-stripe="number" required value="4242 4242 4242 4242"><br><br>
            <input class="input" type="text" placeholder="MM" data-stripe="exp_month" required value="12"><br><br>
            <input  class="input" type="text" placeholder="YY" data-stripe="exp_year" required value="22"><br><br>
            <input class="input" type="text" placeholder="CVC" data-stripe="cvc" required value="777"><br><br>
            <button class="button-sca" type="submit">S'enregistrer</button>
        </form>
    </center>
</body>

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="https://js.stripe.com/v2/"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<?php $data = include "config.php"?>
<script>
    var stripe = "<?php echo $data[3];?>";
    Stripe.setPublishableKey(stripe)
    var $form = $('#payment_form')
    $form.submit(function (e) {
            e.preventDefault()
            $form.find('.button').attr('disabled', true)
            Stripe.card.createToken($form, function (status, response) {
                if (response.error) {
                    $form.prepend('<div><p style="color: red">' + response.error.message + '</div></p>')
                } else if ($('#password').val() !== $('#password-confirm').val()) {
                    $form.prepend('<div><p style="color: red">Mots de Passe différents !</div></p>')
                } else {
                    var token = response.id
                    $form.append($('<input type="hidden" style="overflow: hidden" name="stripeToken">').val(token))
                    $form.get(0).submit()

                }
            })
    })
</script>
</html>
