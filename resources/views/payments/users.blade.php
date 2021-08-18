<form action="payment" method="post">
@csrf

<input type="text" name="username">

<input type="password" name="pass">

<input type="text" name="email" placeholder="email"/>
<input type="submit">
</form>