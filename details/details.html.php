<?php if (!isset($_SESSION['loggedIn']) or $_SESSION['loggedIn'] == FALSE): ?>
    <div class="alert alert-danger">
        <h4>Log In Error</h4>
        You must be logged in to use this page
    </div>
<?php else : ?>
    <form role="form">
    <h2 class="form-login-heading">Update your details</h2>
    <div class="form-group">
      <label for="firstName">First Name</label>
      <input type="text" class="form-control" id="firstName" name="firstName"
        value="<?php if (isset($_SESSION['firstName'])) echo($_SESSION['firstName']); ?>">
    </div>
    <div class="form-group">
      <label for="lastName">Last Name</label>
      <input type="text" class="form-control" id="lastName" name="lastName"
        value="<?php if (isset($_SESSION['lastName'])) echo($_SESSION['lastName']); ?>">
    </div>
    <div class="form-group">
      <label for="displayName">Display Name</label>
      <input type="text" class="form-control" id="displayName" name="displayName"
        value="<?php if (isset($_SESSION['displayName'])) echo($_SESSION['displayName']); ?>">
    </div>
    <hr>
    <div class="form-group">
      <label for="email">E-mail Address</label>
      <input type="text" class="form-control" id="email" name="email"
        value="<?php if (isset($_SESSION['email'])) echo($_SESSION['email']); ?>">
    </div>
    <hr>
    <div class="form-group">
      <label for="tPassord">Password</label>
      <input type="text" class="form-control" id="tPassord" name="pwd">
    </div>
    <div class="form-group">
      <label for="tPassord2">Reconfirm Password</label>
      <input type="text" class="form-control" id="tPassord2"  name="pwd2">
    </div>
    <div id="updateMessage"></div>
    <button class="btn btn-lg btn-primary btn-block" type="submit" id="updateBtn">Update</button>
    </form>
<?php endif; ?>