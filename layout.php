<?php
    if(!defined('INITIALIZED'))
        exit;

    $playersOnline = $config['status']['serverStatus_players'];
    
    $cacheSec = 30;
    $cacheFile = 'cache/topplayers.tmp';
    if (file_exists($cacheFile) && filemtime($cacheFile) > (time() - $cacheSec)) {
        $topData = file_get_contents($cacheFile);
    } else {
        $topData = '';
        $i = 0;
        foreach($SQL->query("SELECT `name`, `level` FROM `players` WHERE `group_id` < 2 AND `account_id` != 1 ORDER BY `level` DESC LIMIT 5")->fetchAll() as $player) {
            $i++;
            $topData .= '<tr><td style="width: 80%"><strong>'.$i.'.</strong> <a href="?subtopic=characters&name='.urlencode($player['name']).'">'.$player['name'].'</a></td><td><span class="label label-primary label-sm">Lvl. '.$player['level'].'</span></td></tr>';
        }

        file_put_contents($cacheFile, $topData);
    }
?>

<!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml" ng-app>
        <head>
            <title><?PHP echo $title ?></title>
            <meta charset="utf-8">
            <meta http-equiv="content-language" content="en">
            <meta http-equiv="Content-Type" content="text/xhtml; charset=UTF-8" />
            <meta name="description" content="Tibia is a free massively multiplayer online role-playing game (MMORPG)">
            <meta name="keywords" content="free online rpg, free mmorpg, mmorpg, mmog, online role playing game, online multiplayer game, internet game, online rpg, rpg">

            <!-- Icons -->
            <link rel="shortcut icon" href="<?php echo $layout_name; ?>/images/favicon.gif" />

            <!-- Css -->
            <script type="text/javascript" src="<?php echo $layout_name; ?>/js/newsticker.js"></script>
            <link rel="stylesheet" type="text/css" href="<?php echo $layout_name; ?>/css/theme.css">
            <link rel="stylesheet" type="text/css" href="<?php echo $layout_name; ?>/css/style.css">
            <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
            <meta name="subtopicport" content="width=1280">
        </head>

        <body>
            <div id="main">
                <header class="navbar navbar-fixed-top bg-light">
                    <div class="navbar-branding">
                        <a class="navbar-brand" href="?subtopic=home"> <b>Legends</b>OT
                        </a>
                        <span id="toggle_sidemenu_l" class="fa fa-list"></span>
                        <ul class="nav navbar-nav pull-right hidden">
                            <li>
                                <a href="#" class="sidebar-menu-toggle">
                                    <span class="octicon octicon-ruby fs20 mr10 pull-right "></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <form class="navbar-form navbar-left navbar-search ml5" role="search" type="submit" action="?subtopic=characters" method="post">
                        <div class="form-group">
                            <input type="text" maxlength="45" name="name" class="form-control" style="max-width: 150px;" placeholder="Search character..." required />
                        </div>
                    </form>
                    <ul class="nav navbar-nav navbar-right">
                        <?php if (!$logged) { ?>
                            <li><a href="?subtopic=register"><i class="fa fa-share"></i> Criar Conta</a></li>
                            <?php if ($subtopic != 'register') { ?>
                            <li class="dropdown dropdown-item-slide">
                                <a class="dropdown-toggle pl10 pr10" data-toggle="dropdown" href="#">
                                    Login <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu dropdown-hover dropdown-persist pn w350 bg-white animated animated-shorter fadeIn" role="menu">
                                    <li class="bg-light p8">
                                        <span class="fw600 pl5 lh30"> Login</span>
                                    </li>
                                    <li>
                                        <div class="col-md-12">
                                            <form class="form" role="form" action="?subtopic=account" method="post">
                                                <div class="form-group">
                                                    <input type="password" maxlength="35" name="account_login" class="form-control" id="alloptions" placeholder="Account Name" required />
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" maxlength="35" name="password_login" class="form-control" id="alloptions" placeholder="Password" required />
                                                </div>
                                                <div class="g-recaptcha" data-sitekey="6LeAaS8UAAAAANm3obpnDEAVGt56cw7dZAF5A3Fs"></div><br>

                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                                                </div>
                                            </form>

                                            <a href="?subtopic=lostaccount" class="btn btn-danger btn-block">Account Lost?</a>
                                        </div>
                                    </li>
                                </li>
                            <?php } ?>
                            <?PHP } else { ?>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <strong><?PHP echo $account_logged->getName(); ?></strong> <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="?subtopic=account">Account Management</a></li>
                                        <li><a href="?subtopic=account&action=logout">Sign out</a></li>
                                    </ul>
                                </li>
                            <?PHP } ?>
                        </ul>
                    </ul>
                </header>

                <aside id="sidebar_left" class="nano nano-primary">
                    <div class="nano-content">
                        <!-- sidebar menu -->
                        <ul class="nav sidebar-menu">
                            <li class="sidebar-label pt20">Menu</li>
                            <li>
                                <a href="?subtopic=home">
                                    <span class="fa fa-home"></span>
                                    <span class="sidebar-title">Home</span>
                                </a>
                            </li>

                            <li>
                                <a class="accordion-toggle" href="#">
                                    <span class="fa fa-user"></span>
                                    <span class="sidebar-title">Account</span>
                                    <span class="caret"></span>
                                </a>
                                <ul class="nav sub-nav">
                                    <?php if (!$logged) { ?>
                                        <li><a href="?subtopic=register">Create Account</a></li>
                                        <li><a href="?subtopic=lostaccount">Lost Account</a></li>
                                    <?PHP } else { ?>
                                        <li><a href="?subtopic=account&action=logout">Logout</a></li>
                                    <?PHP } ?>
                                </ul>
                            </li>

                            <?php if($group_id_of_acc_logged >= $config['site']['access_admin_panel']) { ?>
                                <li>
                                    <a class="accordion-toggle" href="#">
                                        <span class="fa fa-money"></span>
                                        <span class="sidebar-title">Admin</span>
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="nav sub-nav">
                                        <li><a href="?subtopic=forum&action=new_topic&section_id=1">Add News</a></li>
                                        <li><a href="?subtopic=adminpanel">Admin Panel</a></li>
                                    </ul>
                                </li>
                            <?PHP } ?>

                            <li>
                                <a class="accordion-toggle" href="#">
                                    <span class="fa fa-users"></span>
                                    <span class="sidebar-title">Community</span>
                                    <span class="caret"></span>
                                </a>
                                <ul class="nav sub-nav">
                                    <li><a href="?subtopic=changelog">Changelog</a></li>
                                    <li><a href="?subtopic=casts">Live Casts</a></li>
                                    <li><a href="?subtopic=buychar">Buy character</a></li>
                                    <li><a href="?subtopic=online">Online</a></li>
                                    <li><a href="?subtopic=ranking">Highscores</a></li>
                                    <li><a href="?subtopic=lastdeaths">Last Deaths</a></li>
                                    <li><a href="?subtopic=houses">Houses</a></li>
                                    <li><a href="?subtopic=guilds">Guilds</a></li>
                                    <li><a href="?subtopic=wars">Guild Wars</a></li>
                                    <li><a href="?subtopic=bans">Ban List</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="?subtopic=forum">
                                    <span class="fa fa-comment"></span>
                                    <span class="sidebar-title">Forum</span>
                                </a>
                            </li>

                            <li>
                                <a class="accordion-toggle" href="#">
                                    <span class="fa fa-book"></span>
                                    <span class="sidebar-title">Library</span>
                                    <span class="caret"></span>
                                </a>
                                <ul class="nav sub-nav">
                                    <li><a href="?subtopic=info">Server Information</a></li>
                                    <li><a href="?subtopic=commands">Lista de Comandos</a></li>
                                    <li><a href="?subtopic=antientrosa">War Anti Entrosa</a></li>
                                    <li><a href="?subtopic=raids">Raids</a></li>
                                </ul>
                            </li>

                            <li>
                                <a class="accordion-toggle" href="#">
                                    <span class="fa fa-question-circle"></span>
                                    <span class="sidebar-title">Help</span>
                                    <span class="caret"></span>
                                </a>
                                <ul class="nav sub-nav">
                                    <li><a href="?subtopic=support">Support Team</a></li>
                                    <li><a href="?subtopic=rules">Server Rules</a></li>
                                </ul>
                            </li>

                            <!-- sidebar bullets -->
                            <li class="sidebar-label pt20">Shopping</li>
                            <li class="sidebar-proj">
                                <a href="?subtopic=donatecoins">
                                    <span class="fa fa-dot-circle-o text-primary"></span>
                                    <span class="sidebar-title">Donate</span>
                                </a>
                            </li>

                            <?php if ($logged) { ?>
                                <li class="sidebar-proj">
                                    <a href="?subtopic=historyshop">
                                        <span class="fa fa-dot-circle-o text-info"></span>
                                        <span class="sidebar-title">Shop History</span>
                                    </a>
                                </li>

                                <li class="sidebar-proj">
                                    <a href="?subtopic=reclaimreward">
                                        <span class="fa fa-dot-circle-o text-info"></span>
                                        <span class="sidebar-title">Reclaim Reward</span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </aside>

                <!-- Start: Content -->
                <section id="content_wrapper">
                    <header id="topbar">
                        <div class="topbar-left">
                            <ol class="breadcrumb">
                                <span class="fa fa-eye"></span> <li class="crumb-trail">Watching</li> - <?php echo ucfirst($subtopic); ?>
                            </ol>
                        </div>
                    </header>

                    <div class="tray tray-center p30 va-t posr animated-delay animated-long" data-animate='["800","fadeIn"]'>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-8">
                                    <?php if ($subtopic == '' || $subtopic == 'home') { ?>
                                    <?php } ?>

                                    <?PHP echo $main_content; ?>

                                    <?PHP $time_end = microtime_float(); $time = $time_end - $time_start; ?>
                                    <center>
                                        <font color="white">Layout modificied by Vankk 2017<br>
                                            Load time: <?PHP echo round($time, 4); ?> seconds
                                        </font>
                                    </center>
                                </div>

                                <div class="col-md-4">
                                    <div class="card my-4">
                                        <div class="panel mb10">
                                            <div class="panel-heading">
                                                <span class="panel-title text-info fw700"><i class="fa fa-cog"></i> Server Status</span>
                                            </div>
                                            <div class="panel-body text-muted p10">
                                                <table class="table table-condensed table-content table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <td colspan=1>Status:
                                                                <?php
                                                                    if($config['status']['serverStatus_online'] == 1)
                                                                        echo '<span class="label label-success pull-right label-sm">Online!</span>';
                                                                    else
                                                                        echo '<span class="label label-danger pull-right label-sm">Offline!</span>';
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><a href="?subtopic=online"><?PHP echo $playersOnline; ?> player<?php echo ($playersOnline != 1 ? 's' : ''); ?> online</a></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card my-4">
                                        <div class="panel mb10">
                                            <div class="panel-heading">
                                                <span class="panel-title text-info fw700"><i class="fa fa-info"></i> Information</span>
                                            </div>
                                            <div class="panel-body text-muted p10">
                                               <table class="table table-condensed table-content table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <td><b>IP:</b></td><td><?php echo '' . $config['server']['ipSite'] . ''; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Experience:</b></td> <td><a href="?subtopic=info">stages</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Client:</b></td><td>10.00 (MageBot 10.00A)</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Type:</b></td> <td>PvP</td>
                                                        </tr>
                                                    </tbody>
                                                </table><br>
                                                <a href="/downloads/Legends-Client.zip" class="btn btn-success form-control">Download Legend Client 10.00</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card my-4">
                                        <div class="panel mb10">
                                            <div class="panel-heading">
                                                <span class="panel-title text-info fw700"><i class="fa fa-line-chart"></i> Top 5 Level</span>
                                            </div>
                                            <div class="panel-body text-muted p10">
                                                <table class="table table-condensed table-content table-striped">
                                                    <tbody>
                                                        <?php echo $topData; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card my-4">
                                        <div class="panel mb10">
                                            <div class="panel-heading">
                                                <span class="panel-title text-info fw700"><i class="fa fa-facebook-official"></i> Follow us</span>
                                            </div>
                                            <div class="panel-body text-muted p10">
                                               <center>
                                                    <div class="fb-page" data-href="https://www.facebook.com/legendsotserver" data-height="180" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false"    data-show-facepile="false" data-show-posts="false"></div>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- jQuery -->
            <script type="text/javascript" src="<?php echo $layout_name; ?>/js/jquery/jquery-1.11.1.min.js"></script>
            <script src='https://www.google.com/recaptcha/api.js'></script>
            <script src="<?php echo $layout_name; ?>/js/mis.js"></script>
            <script src="<?php echo $layout_name; ?>/js/ajaxNews.js"></script>
            <script type="text/javascript" src="<?php echo $layout_name; ?>/js/jquery/jquery_ui/jquery-ui.min.js"></script>
            <script type="text/javascript" src="<?php echo $layout_name; ?>/js/utility/utility.js"></script>
            <script type="text/javascript" src="<?php echo $layout_name; ?>/js/main.js"></script>
            <script type="text/javascript" src="<?php echo $layout_name; ?>/js/demo.js"></script>
            <script type="text/javascript" src="<?php echo $layout_name; ?>/js/bootstrap/bootstrap.min.js"></script>
            <div id="fb-root"></div>
            <script>(function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.4&appId=1490697977879204";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
            <script type="text/javascript" src="<?php echo $layout_name; ?>/js/pages/widgets.js"></script>
            <script type="text/javascript">
                jQuery(document).ready(function() {
                    "use strict";
                    Core.init({
                        sbm: "sb-l-c",
                    });
                });
            </script>
    </body>
</html>