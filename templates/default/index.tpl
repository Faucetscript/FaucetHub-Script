{include file="header.tpl"}
 <!-- Portfolio Grid Section -->
    <section id="faucet">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div id="advertisement">
                        {$spaceleft}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h2>Login or signup to enter</h2>
                            <hr class="star-primary">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Login</h4>
                                </div>
                                <div class="panel-body">
                                    {if isset($resultSignIn)}
                                        {$resultSignIn}
                                    {/if}
                                    <form action="index.php?route=auth/login" method="POST">
                                        <input type="text" class="form-control" name="address" placeholder="Enter your FaucetHUB Address" required="required"><br />
                                        <input type="password" class="form-control" name="password" placeholder="Enter your password" required="required"><br />
                                        <button class="btn btn-success pull-left" name="submit">Login</button>
                                        {$csrf_field}
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 text-center">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Signup</h4>
                                </div>
                                <div class="panel-body">
                                    {if isset($resultSignUp)}
                                        {$resultSignUp}
                                    {/if}
                                    <form action="index.php?route=auth/signup" method="POST">
                                        <input type="text" class="form-control" name="address"  placeholder="Enter your FaucetHUB Address">
                                        <br />
                                        <input type="password" class="form-control" name="password"  placeholder="Enter your password">
                                        <br />
                                        <input type="password" class="form-control" name="password2" placeholder="Enter your password again">
                                        <br />
                                        <center><div class="g-recaptcha" data-sitekey="{$reCapPubkey}"></div></center>
                                        <button class="btn btn-success pull-left" name="request_signup">Signup</button>
                                        {$csrf_field}
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div id="advertisement">
                        {$spaceright}
                    </div>
                </div>
        </div>
    </section>
{include file="footer.tpl"}
