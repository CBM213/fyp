<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/signin.css">
    <title>Sign in</title>
</head>
<body>

    <header id="header">
        <img id="logo" src="images/quickbuy logo.png" alt="quickbuy logo">
    </header>
    <div id="div">
        <form id="form" action="admin.php" method="POST">
            <h4>Sign in</h4>
            <label id="label" for="email">Email</label>
            <br><br>
            <input type="email" id="email" name="email" placeholder="Enter email">
            <br><br>    
            <label id="label" for="password">Password</label>
            <br><br>  
            <input type="password" id="password" name="password" placeholder="Enter Password">
            <br><br>

            <p>By continuing, you agree to QuickBuy's 
            Conditions of Use and Privacy Notice.</p>
            <br>
            <input type="submit" value="sign in" id="submit">
        </form>
        <h5 id="new">New to QuickBuy?</h5>  
        <input type="button" value="sign up for free" id="signup" onclick="signUp()">
    </div>
    <footer id="footer">
        <a id="ConditionsOfUse" href="ConditionsOfUse.html">Conditions OF Use</a>
        <a id="privacy" href="PrivacyNotice.php">Privacy Notice</a>
        <p>© 2023, QuickBuy.com, Inc. or its affiliates</p>
</footer>
<script src="signin.js"></script>

</body>
</html>
