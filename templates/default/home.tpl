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
                            {if isset($resultClaim)}
                                {$resultClaim}
                            {/if}
                            <div class="alert alert-success">
                                <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Rewards: {$minReward} to {$maxReward} satoshi every {$timer} minutes
                            </div>
                            <h3>Address</h3>
                            {$user->address}<br />
                            <h3>Your balance</h3>
                            {$user->balanceInSat} satoshis<br />
                            <br />

                            <div class="alert alert-warning">
                                <!-- Yup, this is a ref link to the developer of this script. Please keep it to support my work. -->
                                <strong>Please note:</strong> You require a Faucethub.io account to receive your payment. <a href="http://faucethub.io/r/3100552" target="_blank">Click here</a> to create one.
                                <!-- Yup, this is a ref link to the developer of this script. Please keep it to support my work. -->
                            </div>
                            <a href="index.php?route=home/withdraw" class="btn btn-primary">Withdraw to FaucetHub</a><br /><br />

                            <h1>1. Claim</h1><br />
                            {if (time() - ($timer * 60)) > $user->last_claim}
                            <form method="post" action="index.php?route=claim/verify">
                                {$csrf_field}
                                <button type="submit" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span> Next</button>
                            </form>
                            {else}
                            <button type="submit" class="btn btn-success btn-lg disabled">You can claim <span id="claimin"></span></button>
                            {/if}
                            <blockquote class="text-left">
                                <p>
                                    Your personal referral link: <code>{$user->getRefLink()}</code>
                                </p>
                                <footer>Share this link with your friends and earn {$settings['referral_percent']}% referral commission</footer>
                            </blockquote>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div id="advertisement">
                        {$spaceright}
                    </div>
                </div>
            </div>
        </div>
    </section>
{include file="footer.tpl"}
