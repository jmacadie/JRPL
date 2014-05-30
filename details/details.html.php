<h1>Change your details</h1><br />
<?php if (!isset($_SESSION['loggedIn']) or $_SESSION['loggedIn'] == FALSE): ?>
    <div class="alert alert-error alert-block">
        <h4 class="alert-heading">Log In Error</h4>
        You must be logged in to use this page
    </div>
<?php else : ?>
    <form class="form-horizontal" action="" method="post">
        <fieldset>
            <div class="control-group">
                <label class="control-label" for="firstName">First Name</label>
                <div class="controls">
                    <input type="text" class="input-xlarge" id="firstName" name="firstName"
                        value="<?php if (isset($_SESSION['firstName'])) echo($_SESSION['firstName']); ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="lastName">Last Name</label>
                <div class="controls">
                    <input type="text" class="input-xlarge" id="lastName" name="lastName"
                        value="<?php if (isset($_SESSION['lastName'])) echo($_SESSION['lastName']); ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="displayName">Display Name</label>
                <div class="controls">
                    <input type="text" class="input-xlarge" id="displayName" name="displayName"
                        value="<?php if (isset($_SESSION['displayName'])) echo($_SESSION['displayName']); ?>">
                </div>
            </div>
            <hr>
            <div class="control-group">
                <label class="control-label" for="email">E-mail Address</label>
                <div class="controls">
                    <input type="text" class="input-xlarge" id="email" name="email"
                        value="<?php if (isset($_SESSION['email'])) echo($_SESSION['email']); ?>">
                </div>
            </div>
            <hr>
            <div class="control-group">
                <label class="control-label" for="tPassord">Password</label>
                <div class="controls">
                    <input type="text" class="input-xlarge" id="tPassord" name="pwd">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="tPassord2">Reconfirm Password</label>
                <div class="controls">
                    <input type="text" class="input-xlarge" id="tPassord2"  name="pwd2">
                </div>
            </div>
            <?php if (isset($loginError)): ?>
                <div class="alert alert-error">
                    <a class="close" data-dismiss="alert" href="#">&times;</a>
                    <?php echo htmlout($loginError); ?>
                </div>
            <?php endif; ?>
            <input type="hidden" name="action" value="update" />
            <div class="form-actions">
                <!-- <button type="submit" class="btn btn-primary">Update Details</button>-->
                <input type="submit" class="btn btn-primary" value="Update Details" />
            </div>
        </fieldset>
    </form>
<?php endif; ?>