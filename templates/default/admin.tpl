{include file="header.tpl"}
 <!-- Portfolio Grid Section -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Admin page</h2>
                    <hr class="star-primary">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    {if isset($results)}
                        {$results}
                        <meta http-equiv="refresh" content="2; url=index.php?route=admin/home" />
                    {/if}
                </div>
                <div class="col-lg-12 text-center">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4 class="panel-title">General settings</h4>
                        </div>
                        <div class="panel-body">
                            <form action="index.php?route=admin/update&action=general" method="POST">
                                <input type="text" class="form-control" name="faucet_name" value="{$settings['faucet_name']}"  placeholder="Enter your Faucet name">
                                <br />
                                <input type="text" class="form-control" name="faucet_slogan" value="{$settings['faucet_slogan']}"  placeholder="Enter your faucet slogan">
                                <br />
                                <input type="text" class="form-control" name="timer" value="{$settings['timer']}"  placeholder="Enter the timer (in minutes)">
                                <br />
                                <input type="text" class="form-control" name="referral_percent" value="{$settings['referral_percent']}" placeholder="Enter the % referral fee">
                                <br />
                                <input type="text" class="form-control" name="min_reward" value="{$settings['min_reward']}" placeholder="Enter the minimal reward (in satoshis)">
                                <br />
                                <input type="text" class="form-control" name="max_reward" value="{$settings['max_reward']}" placeholder="Enter the maximal reward (in satoshis)">
                                <br />
                                <input type="text" class="form-control" name="reCaptcha_privKey" value="{$settings['reCaptcha_privKey']}" placeholder="Enter your reCaptcha secret key">
                                <br />
                                <input type="text" class="form-control" name="reCaptcha_pubKey" value="{$settings['reCaptcha_pubKey']}" placeholder="Enter your reCaptcha site key">
                                <br />
                                <input type="text" class="form-control" name="faucethub_key" value="{$settings['faucethub_key']}" placeholder="Enter your FaucetHub key">
                                <br />
                                <button class="btn btn-success pull-left" name="submit">Save</button>
                                {$csrf_field}
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 text-center">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4 class="panel-title">Advertisement settings</h4>
                        </div>
                        <div class="panel-body">
                            <form action="index.php?route=admin/update&action=ads" method="POST">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Space top</label><br />
                                        <textarea name="space_top" style="width: 100%; height: 200px;">{$settings['space_top']}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Space left</label><br />
                                        <textarea name="space_left" style="width: 100%; height: 200px;">{$settings['space_left']}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Space right</label><br />
                                        <textarea name="space_right" style="width: 100%; height: 200px;">{$settings['space_right']}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Space bottom</label><br />
                                        <textarea name="space_bottom" style="width: 100%; height: 200px;">{$settings['space_bottom']}</textarea>
                                    </div>
                                </div>
                                <button class="btn btn-success pull-left" name="submit">Save</button>
                                {$csrf_field}
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

{include file="footer.tpl"}
