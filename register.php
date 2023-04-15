<form action="new_account.php"
      method = "post">

    <!-- first name -->

    <label for="fname">First Name:</label>
    <input type="text"
           id="fname"
           name="fname"
           placeholder="First Name...">

    <!-- last name -->
    <br><br>
    <label for="lname">Last Name:</label>
    <input type="text"
           id="lname"
           name="lname"
           placeholder="Last Name...">

    <!-- phone -->
    <br><br>
    <label for="phone">Phone #:&nbsp&nbsp&nbsp</label>
    <input type="tel"
           id="phone"
           name="phone"
           placeholder="123456789...">

    <!-- username -->
    <br><br>
    <label for="username">Username: </label>
    <input type="text"
           id="username"
           name="username"
           placeholder="Username...">

    <!-- password -->
    <br><br>
    <label for="password">Password: </label>
    <input type="password"
           id="password"
           name="password"
           placeholder="Password...">

    <!-- submit button -->
    <br><br>
    <button class="submit" type="submit" value="new_account">Submit</button>
    <br><br>
</form>