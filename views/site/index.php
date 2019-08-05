<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Welcome to Project eSport\'s';

$this->registerLinkTag(['rel' => 'canonical', 'href' => 'https://project-esport.gg' . Yii::$app->request->url]);

Yii::$app->MetaClass->writeMetaIndex($this, $this->title);

?>

<div class="site-index">
    <main>

        <div class="col-lg-9 welcome">

            <?php // wunsch von Niyari, immer hier oben lassen ?>
            <div>
                <img src="https://cdn.discordapp.com/attachments/600965985540898816/602973085087563776/Pesp_Masters_1_RL.png" alt="" style="width: 100%;">
            </div>
            <?php // wunsch von Niyari, immer hier oben lassen ?>

            <div class="newsContainer">
                <div class="containerHeader">
                    <span class="headerKategorie"><img src="../images/PeSpLogos/pesp.png">Website</span>
                    <span class="headerTitle">Finaly the Bug is Fixed</span>
                    <span class="headerDate">05.08.2019</span>
                </div>
                <div class="containerBody clearfix">
                    <div class="containerImage col-lg-3"><img src="../images/news/technic.webp" alt="" style="width: 100%; padding-top: 60px;"></div>
                    <div class="containerText col-lg-9">
                        It's done!!!<br>                  
                        The password forgotten function is live again and works.<br>
                        <br>
                        We apologize for this inconvenience and hope that all players will be able to log in again.
                        <br>
                    </div>
                    <div class="containerAuthor">Birnchen</div>
                </div>
            </div>

            <div class="newsContainer">
                <div class="containerHeader">
                    <span class="headerKategorie"><img src="../images/gameLogos/1.webp">Rocket League</span>
                    <span class="headerTitle">Gerta Cup Season 3 3v3 Day 6</span>
                    <span class="headerDate">04.08.2019</span>
                </div>
                <div class="containerBody clearfix">
                    <div class="containerImage col-lg-3"><img src="../images/news/gerta-cup.webp" alt="" style="width: 100%; padding-top: 50px;"></div>
                    <div class="containerText col-lg-9">
                        Congratulations to <?= Html::a('Team Aspire', ['/teams/sub-team-details', 'id' => '66']); ?> for this win today. First they must beat three other participating Teams to get to the Finals.<br>Then, after <strong>three</strong>
                        realy close Games against <?= Html::a('Stealth7 eSports', ['/teams/sub-team-details', 'id' => '7']); ?> they secured this hard win for the Day.
                    </div>
                    <div class="containerAuthor">Birnchen</div>
                </div>
            </div>

            <div class="newsContainer">
                <div class="containerHeader">
                    <span class="headerKategorie"><img src="../images/gameLogos/1.webp">Rocket League</span>
                    <span class="headerTitle">Gerta Cup Season 3 2v2 Day 6</span>
                    <span class="headerDate">03.08.2019</span>
                </div>
                <div class="containerBody clearfix">
                    <div class="containerImage col-lg-3"><img src="../images/news/gerta-cup.webp" alt="" style="width: 100%;     padding-top: 40px;"></div>
                    <div class="containerText col-lg-9">
                        Congratulations to <?= Html::a('Stealth7 eSports', ['/teams/sub-team-details', 'id' => '9']); ?> for this win Today.<br>
                        They beat One other participating Teams on the last Day of the new Season.<br>
                        After three great Games against <?= Html::a('Robotic Elite Clan ', ['/teams/sub-team-details', 'id' => '1']); ?> they secured his win for this Day.
                    </div>
                    <div class="containerAuthor">Birnchen</div>
                </div>
            </div>

            <div class="newsContainer">
                <div class="containerHeader">
                    <span class="headerKategorie"><img src="../images/gameLogos/1.webp">Rocket League</span>
                    <span class="headerTitle">Gerta Cup Season 3 1v1 Day 6</span>
                    <span class="headerDate">02.08.2019</span>
                </div>
                <div class="containerBody clearfix">
                    <div class="containerImage col-lg-3"><img src="../images/news/gerta-cup.webp" alt="" style="width: 100%;     padding-top: 33px;"></div>
                    <div class="containerText col-lg-9">
                        Congratulations to <?= Html::a('Cordae', ['/user/details', 'id' => '161']); ?> for the win Today in 1v1. He beat three other participating Players on the fourth Day.<br>
                        After <strong>five</strong> fantastic Games against <?= Html::a('FlowZ ', ['/user/details', 'id' => '201']); ?>, he secured<br>
                        his win in this season.
                    </div>
                    <div class="containerAuthor">Birnchen</div>
                </div>
            </div>

            <div class="newsContainer">
                <div class="containerHeader">
                    <span class="headerKategorie"><img src="../images/gameLogos/1.webp">Rocket League</span>
                    <span class="headerTitle">Gerta Cup Season 3 3v3 Day 5</span>
                    <span class="headerDate">21.07.2019</span>
                </div>
                <div class="containerBody clearfix">
                    <div class="containerImage col-lg-3"><img src="../images/news/gerta-cup.webp" alt="" style="width: 100%; padding-top: 50px;"></div>
                    <div class="containerText col-lg-9">
                        Congratulations to <?= Html::a('Team Aspire', ['/teams/sub-team-details', 'id' => '7']); ?> for this win today. First they must beat four other participating Teams to get to the Finals.<br>Then, after <strong>three</strong>
                        realy close Games against <?= Html::a('Esport BERG', ['/teams/sub-team-details', 'id' => '23']); ?> they secured this win for the Day.
                    </div>
                    <div class="containerAuthor">Birnchen</div>
                </div>
            </div>

            <div class="newsContainer">
                <div class="containerHeader">
                    <span class="headerKategorie"><img src="../images/gameLogos/1.webp">Rocket League</span>
                    <span class="headerTitle">Gerta Cup Season 3 2v2 Day 5</span>
                    <span class="headerDate">20.07.2019</span>
                </div>
                <div class="containerBody clearfix">
                    <div class="containerImage col-lg-3"><img src="../images/news/gerta-cup.webp" alt="" style="width: 100%;     padding-top: 40px;"></div>
                    <div class="containerText col-lg-9">
                        Congratulations to <?= Html::a('Stealth7 eSports', ['/teams/sub-team-details', 'id' => '9']); ?> for this win Today.<br>
                        They beat three other participating Teams on the fourth Day of the new Season.<br>
                        After three great Games against <?= Html::a('Captain Viper ', ['/teams/sub-team-details', 'id' => '3']); ?> they secured his win for this Day.
                    </div>
                    <div class="containerAuthor">Birnchen</div>
                </div>
            </div>

            <div class="newsContainer">
                <div class="containerHeader">
                    <span class="headerKategorie"><img src="../images/gameLogos/1.webp">Rocket League</span>
                    <span class="headerTitle">Gerta Cup Season 3 1v1 Day 5</span>
                    <span class="headerDate">19.07.2019</span>
                </div>
                <div class="containerBody clearfix">
                    <div class="containerImage col-lg-3"><img src="../images/news/gerta-cup.webp" alt="" style="width: 100%;     padding-top: 33px;"></div>
                    <div class="containerText col-lg-9">
                        Congratulations to <?= Html::a('xer02rl', ['/user/details', 'id' => '156']); ?> for a fourth amazing win Today in 1v1. He beat two other participating Players on the fourth Day.<br>
                        After <strong>four</strong> fantastic Games against <?= Html::a('P1st0lpr0 ', ['/user/details', 'id' => '22']); ?>, he secured<br>
                        his fourth win in this season.
                    </div>
                    <div class="containerAuthor">Birnchen</div>
                </div>
            </div>

            <div class="newsContainer">
                <div class="containerHeader">
                    <span class="headerKategorie"><img src="../images/gameLogos/1.webp">Rocket League</span>
                    <span class="headerTitle">Gerta Cup Season 3 3v3 Day 4</span>
                    <span class="headerDate">07.07.2019</span>
                </div>
                <div class="containerBody clearfix">
                    <div class="containerImage col-lg-3"><img src="../images/news/gerta-cup.webp" alt="" style="width: 100%; padding-top: 50px;"></div>
                    <div class="containerText col-lg-9">
                        Congratulations to <?= Html::a('Stealth7 eSports', ['/teams/sub-team-details', 'id' => '7']); ?> for this win today. First they must beat six other participating Teams to get to the Finals.<br>Then, after <strong>10</strong>
                        realy close Games against <?= Html::a('Esport BERG', ['/teams/sub-team-details', 'id' => '23']); ?> and a Bracket reset, they secured this hard win for the Day.
                    </div>
                    <div class="containerAuthor">Birnchen</div>
                </div>
            </div>

            <div class="newsContainer">
                <div class="containerHeader">
                    <span class="headerKategorie"><img src="../images/gameLogos/1.webp">Rocket League</span>
                    <span class="headerTitle">Gerta Cup Season 3 2v2 Day 4</span>
                    <span class="headerDate">06.07.2019</span>
                </div>
                <div class="containerBody clearfix">
                    <div class="containerImage col-lg-3"><img src="../images/news/gerta-cup.webp" alt="" style="width: 100%;     padding-top: 40px;"></div>
                    <div class="containerText col-lg-9">
                        Congratulations to <?= Html::a('Stealth7 eSports', ['/teams/sub-team-details', 'id' => '9']); ?> for this win Today.<br>
                        They beat four other participating Teams on the fourth Day of the new Season.<br>
                        After four great Games against <?= Html::a('FreezeUnit 2v2 ', ['/teams/sub-team-details', 'id' => '69']); ?> they secured his win for this Day.
                    </div>
                    <div class="containerAuthor">Birnchen</div>
                </div>
            </div>

            <div class="newsContainer">
                <div class="containerHeader">
                    <span class="headerKategorie"><img src="../images/gameLogos/1.webp">Rocket League</span>
                    <span class="headerTitle">Gerta Cup Season 3 1v1 Day 4</span>
                    <span class="headerDate">05.07.2019</span>
                </div>
                <div class="containerBody clearfix">
                    <div class="containerImage col-lg-3"><img src="../images/news/gerta-cup.webp" alt="" style="width: 100%;     padding-top: 33px;"></div>
                    <div class="containerText col-lg-9">
                        Congratulations to <?= Html::a('xer02rl', ['/user/details', 'id' => '156']); ?> for a third amazing win Today in 1v1. He beat two other participating Players on the fourth Day.<br>
                        After <strong>four</strong> fantastic Games against <?= Html::a('FlowZ ', ['/user/details', 'id' => '201']); ?>, he secured<br>
                        his third win in this season.
                    </div>
                    <div class="containerAuthor">Birnchen</div>
                </div>
            </div>

            <div class="newsContainer">
                <div class="containerHeader">
                    <span class="headerKategorie"><img src="../images/gameLogos/1.webp">Rocket League</span>
                    <span class="headerTitle">Gerta Cup Season 3 3v3 Day 3</span>
                    <span class="headerDate">23.06.2019</span>
                </div>
                <div class="containerBody clearfix">
                    <div class="containerImage col-lg-3"><img src="../images/news/gerta-cup.webp" alt="" style="width: 100%; padding-top: 50px;"></div>
                    <div class="containerText col-lg-9">
                        Congratulations to <?= Html::a('Team Aspire', ['/teams/sub-team-details', 'id' => '66']); ?> for this win today. First they must beat six other participating Teams to get to the Finals.<br>Then, after <strong>three</strong>
                        realy close Games against <?= Html::a('Stealth7 eSports', ['/teams/sub-team-details', 'id' => '66']); ?> they secured his win for this Day.
                    </div>
                    <div class="containerAuthor">Birnchen</div>
                </div>
            </div>

            <div class="newsContainer">
                <div class="containerHeader">
                    <span class="headerKategorie"><img src="../images/gameLogos/1.webp">Rocket League</span>
                    <span class="headerTitle">Gerta Cup Season 3 2v2 Day 3</span>
                    <span class="headerDate">22.06.2019</span>
                </div>
                <div class="containerBody clearfix">
                    <div class="containerImage col-lg-3"><img src="../images/news/gerta-cup.webp" alt="" style="width: 100%;     padding-top: 40px;"></div>
                    <div class="containerText col-lg-9">
                        Congratulations to <?= Html::a('Stealth7 eSports', ['/teams/sub-team-details', 'id' => '9']); ?> for this win Today.<br>
                        Unfortunately only one other team made it to the check-in today.<br>
                        After three great Games against <?= Html::a('Captain Viper ', ['/teams/sub-team-details', 'id' => '3']); ?> they secured his win for this Day.
                    </div>
                    <div class="containerAuthor">Birnchen</div>
                </div>
            </div>

            <div class="newsContainer">
                <div class="containerHeader">
                    <span class="headerKategorie"><img src="../images/gameLogos/1.webp">Rocket League</span>
                    <span class="headerTitle">Gerta Cup Season 3 1v1 Day 3</span>
                    <span class="headerDate">21.06.2019</span>
                </div>
                <div class="containerBody clearfix">
                    <div class="containerImage col-lg-3"><img src="../images/news/gerta-cup.webp" alt="" style="width: 100%;     padding-top: 33px;"></div>
                    <div class="containerText col-lg-9">
                        Congratulations to <?= Html::a('FlowZ', ['/user/details', 'id' => '201']); ?> for a second amazing win Today in 1v1. He beat three other participating Players on the third Day.<br>
                        After <strong>three</strong> fantastic Games against <?= Html::a('Captain Salty ', ['/user/details', 'id' => '4']); ?>, he secured<br>
                        the first victory in this season.
                    </div>
                    <div class="containerAuthor">Birnchen</div>
                </div>
            </div>

            <div class="newsContainer">
                <div class="containerHeader">
                    <span class="headerKategorie"><img src="../images/gameLogos/1.webp">Rocket League</span>
                    <span class="headerTitle">Gerta Cup Season 3 3v3 Day 2</span>
                    <span class="headerDate">09.06.2019</span>
                </div>
                <div class="containerBody clearfix">
                    <div class="containerImage col-lg-3"><img src="../images/news/gerta-cup.webp" alt="" style="width: 100%; padding-top: 50px;"></div>
                    <div class="containerText col-lg-9">
                        Congratulations to <?= Html::a('Stealth7 eSports', ['/teams/sub-team-details', 'id' => '7']); ?> for the hardest win they ever had in our Seasons. First they must beat 7 other participating Teams to get to the Finals.<br>Then they must play <strong>nine</strong>
                        realy hard Games against <?= Html::a('Team Aspire', ['/teams/sub-team-details', 'id' => '66']); ?> to get her first 20 Points.<br>
                        Nice Job!!
                        <br><br>
                        Second Place: <?= Html::a('Team Aspire', ['/teams/sub-team-details', 'id' => '66']); ?> with 17 Points<br>
                        Third Place: <?= Html::a('FreezeUnit Team B', ['/teams/sub-team-details', 'id' => '57']); ?> with 15 Points<br>
                    </div>
                    <div class="containerAuthor">Birnchen</div>
                </div>
            </div>

            <div class="newsContainer">
                <div class="containerHeader">
                    <span class="headerKategorie"><img src="../images/gameLogos/1.webp">Rocket League</span>
                    <span class="headerTitle">Gerta Cup Season 3 2v2 Day 2</span>
                    <span class="headerDate">08.06.2019</span>
                </div>
                <div class="containerBody clearfix">
                    <div class="containerImage col-lg-3"><img src="../images/news/gerta-cup.webp" alt="" style="width: 100%;     padding-top: 40px;"></div>
                    <div class="containerText col-lg-9">
                        Congratulations to <?= Html::a('FreezeUnit 2v2', ['/teams/sub-team-details', 'id' => '69']); ?> for this win Today.<br>
                        They beat seven other participating Teams on the second Day of the new Season.<br>
                        After three great Games against <?= Html::a('Timeout Gaming by S7 ', ['/teams/sub-team-details', 'id' => '10']); ?> they secured<br>
                        the first victory in this season, and has now 20 Points
                        <br><br>
                        Second Place: <?= Html::a('Timeout Gaming by S7 ', ['/teams/sub-team-details', 'id' => '10']); ?> with 17 Points<br>
                        Third Place: <?= Html::a('ILV | Titanium White', ['/teams/sub-team-details', 'id' => '42']); ?> with 15 Points<br>
                    </div>
                    <div class="containerAuthor">Birnchen</div>
                </div>
            </div>

            <div class="newsContainer">
                <div class="containerHeader">
                    <span class="headerKategorie"><img src="../images/gameLogos/1.webp">Rocket League</span>
                    <span class="headerTitle">Gerta Cup Season 3 1v1 Day 2</span>
                    <span class="headerDate">07.06.2019</span>
                </div>
                <div class="containerBody clearfix">
                    <div class="containerImage col-lg-3"><img src="../images/news/gerta-cup.webp" alt="" style="width: 100%;     padding-top: 33px;"></div>
                    <div class="containerText col-lg-9">
                        Congratulations to <?= Html::a('xer02rl', ['/user/details', 'id' => '156']); ?> for a second amazing win Today in 1v1. He beat six other participating Players on the second Day.<br>
                        After <strong>nine</strong> fantastic Games against <?= Html::a('FlowZ ', ['/user/details', 'id' => '201']); ?>, he secured<br>
                        the second victory in this season, and has now 40 Points
                        <br><br>
                        Second Place: <?= Html::a('FlowZ ', ['/user/details', 'id' => '201']); ?> with 17 Points<br>
                        Third Place: <?= Html::a('P1st0lpr0 ', ['/user/details', 'id' => '22']); ?> with 15 Points<br>
                    </div>
                    <div class="containerAuthor">Birnchen</div>
                </div>
            </div>

            <div class="newsContainer">
                <div class="containerHeader">
                    <span class="headerKategorie"><img src="../images/gameLogos/1.webp">Rocket League</span>
                    <span class="headerTitle">Gerta Cup Season 3 3v3 Day 1</span>
                    <span class="headerDate">26.05.2019</span>
                </div>
                <div class="containerBody clearfix">
                    <div class="containerImage col-lg-3"><img src="../images/news/gerta-cup.webp" alt="" style="width: 100%; padding-top: 50px;"></div>
                    <div class="containerText col-lg-9">
                        Congratulations to <?= Html::a('Wind and Rain', ['/teams/sub-team-details', 'id' => '58']); ?> for this hardly fighted win Today in 3v3.<br>
                        They beat 14 other participating Teams on the first Day of the new Season.<br>
                        After a realy long Fight over two B05's they gets the First 20 Points for the 600€ Season Price Pool, and are 20 Points closer to Qualify for the PeSp Masters 2019 in Cologne.
                        <br><br>
                        Second Place: <?= Html::a('FreezeUnit Team B', ['/teams/sub-team-details', 'id' => '57']); ?> with 17 Points<br>
                        Third Place: <?= Html::a('Esport BERG', ['/teams/sub-team-details', 'id' => '23']); ?> with 15 Points<br>
                    </div>
                    <div class="containerAuthor">Birnchen</div>
                </div>
            </div>

            <div class="newsContainer">
                <div class="containerHeader">
                    <span class="headerKategorie"><img src="../images/gameLogos/1.webp">Rocket League</span>
                    <span class="headerTitle">Gerta Cup Season 3 2v2 Day 1</span>
                    <span class="headerDate">25.05.2019</span>
                </div>
                <div class="containerBody clearfix">
                    <div class="containerImage col-lg-3"><img src="../images/news/gerta-cup.webp" alt="" style="width: 100%;     padding-top: 40px;"></div>
                    <div class="containerText col-lg-9">
                        Congratulations to <?= Html::a('Stealth 7 eSports', ['/teams/sub-team-details', 'id' => '9']); ?> for this amazing win Today in 2v2.<br>
                        They beat eight other participating Teams on the first Day of the new Season.<br>
                        After a long Fight they gets the First 20 Points for the 600€ Season Price Pool.
                        <br><br>
                        Second Place: <?= Html::a('ILV | Titanium White', ['/teams/sub-team-details', 'id' => '42']); ?> with 17 Points<br>
                        Third Place: <?= Html::a('WarKidZ eSports', ['/teams/sub-team-details', 'id' => '37']); ?> with 15 Points<br>
                    </div>
                    <div class="containerAuthor">Birnchen</div>
                </div>
            </div>

            <div class="newsContainer">
                <div class="containerHeader">
                    <span class="headerKategorie"><img src="../images/PeSpLogos/pesp.png">Website</span>
                    <span class="headerTitle">Team up and get Ready</span>
                    <span class="headerDate">25.05.2019</span>
                </div>
                <div class="containerBody clearfix">
                    <div class="containerImage col-lg-3"><img src="../images/news/technic.webp" alt="" style="width: 100%; padding-top: 60px;"></div>
                    <div class="containerText col-lg-9">
                        It's done!!!<br>                  
                        Players and teams can finally manage themselves.<br>
                        <br>
                        Team Captains:<br>
                        Go to your account and click on the button next to Main Team. Congratulations you have created your first own team with us.<br>
                        <br>
                        Teams:<br>
                        Go to your Main Team (via Account) and click on the button next to Sub Teams. Congratulations you have created your first own sub team with us.
                        <br>
                    </div>
                    <div class="containerAuthor">Birnchen</div>
                </div>
            </div>

            <div class="newsContainer">
                <div class="containerHeader">
                    <span class="headerKategorie"><img src="../images/gameLogos/1.webp">Rocket League</span>
                    <span class="headerTitle">Gerta Cup Season 3 1v1 Day 1</span>
                    <span class="headerDate">24.05.2019</span>
                </div>
                <div class="containerBody clearfix">
                    <div class="containerImage col-lg-3"><img src="../images/news/gerta-cup.webp" alt="" style="width: 100%;     padding-top: 33px;"></div>
                    <div class="containerText col-lg-9">
                        Congratulations to <?= Html::a('xer02rl', ['/user/details', 'id' => '156']); ?> for this amazing win Today in 1v1.<br>
                        He beat 15 other participating Players on the first Day of the new Season.<br>
                        After a long Night he gets the First 20 Points for the 600€ Season Price Pool.
                        <br><br>
                        Second Place: <?= Html::a('Dongiii', ['/user/details', 'id' => '162']); ?> with 17 Points<br>
                        Third Place: <?= Html::a('NoAvian', ['/user/details', 'id' => '38']); ?> with 15 Points<br>
                    </div>
                    <div class="containerAuthor">Birnchen</div>
                </div>
            </div>
        </div>



        <div class="col-lg-3">
            <?= Html::a('Tweets by project-eSport', 'https://twitter.com/' . 'esport_project' . '?ref_src=twsrc%5Etfw', ['class' => 'twitter-timeline', 'target' => '_blank', 'rel' =>'noopener', 'aria-label' => 'twitter-timeline', 'label' => 'twitter-timeline', 'data-lang' => 'en', 'data-height' => '400', 'data-theme' => 'light']); ?>
        </div>

        <div class="col-lg-3">
            
        </div>

    </main>
</div>