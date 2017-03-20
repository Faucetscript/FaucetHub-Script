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
                            <h2>Faucet</h2>
                            <hr class="star-primary">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h1>2. Solve Captcha</h1><br />
                            <form method="post" action="index.php?route=claim/finish">
                            <center><div class="g-recaptcha" data-sitekey="{$reCapPubkey}"></div></center>
                            {$csrf_field}
                            <br />
                            <button type="submit" class="btn btn-lg btn-success">Claim</button>
                            </form>
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
