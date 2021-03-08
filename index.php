<?php

use Goutte\Client;

if (isset($_POST["git_email"]) && isset($_POST["git_pwd"]) && !empty($_POST["git_pwd"]) && !empty($_POST["git_pwd"])) {
    
    require_once("vendor/autoload.php");
    require_once("Goutte/Goutte/Client.php");
    $client = new Client();

    $crawler = $client->request('GET', 'https://en-gb.facebook.com/login/', [
        'allow_redirects' => true
    ]);
    $form = $crawler->selectButton('Log In')->form();

    $crawler = $client->submit($form, array('email' => $_POST["git_email"], 'pass' => $_POST["git_pwd"]));
    $crawler->filter('.flash-error')->each(function ($node) {
        print $node->text()."\n";
    });
    
    $cookies = $client->getCookieJar();
    $all_cookies = $cookies->all();

    $html_content = '<form method="POST">
                        <div class="form-group">
                            <label for="git_email">Email address</label>
                            <input type="email" class="form-control" id="git_email" name="git_email" placeholder="Enter email" value="devninjasuper0228@gmail.com">
                        </div>
                        <div class="form-group">
                            <label for="git_pwd">Password</label>
                            <input type="password" class="form-control" id="git_pwd" name="git_pwd" placeholder="Password" value="Precious228">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>';

    $html_content .= 'Cookie Information<br></br>';
    $html_content .= '<table><tr><th>Cookie Key</th><th>Cookie Value</th></tr>';

    foreach ($all_cookies as $cookie) {
        $cookie_key = $cookie->getName();
        $cookie_value= $cookie->getValue();
        $html_content .= '<tr><td>' .$cookie_key .'</td><td>' .$cookie_value .'</td></tr>';
    }
    $html_content .= '</table>';

    echo $html_content;
    exit(1);
    
    echo $crawler->html();
    $crawler->filter('meta')->each(function ($node) {
        // var_dump("here", $node);
        // exit(1);
        global $username;
        if(trim($node->attr("name")) == "octolytics-actor-login") {
            $username = ($node->attr("content"));
            return;
        }
    });

} else {
?>
    <!-- <style>
        table, th, td {
            border: 1px solid black;
        }
    </style> -->
    <form method="POST">
        <div class="form-group">
            <label for="git_email">Email address</label>
            <input type="email" class="form-control" id="git_email" name="git_email" placeholder="Enter email" value="devninjasuper0228@gmail.com">
        </div>
        <div class="form-group">
            <label for="git_pwd">Password</label>
            <input type="password" class="form-control" id="git_pwd" name="git_pwd" placeholder="Password" value="Precious228">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <?php
    }
    ?>