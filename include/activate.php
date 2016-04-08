<?php
if(isset($_GET['vtk']) && !empty($_GET['vtk'])) {
    switch(isset($_GET['vtk']) ? $_GET['vtk'] : null) {
        default:
            break;
        case 'chinese':
            $stats->set_stat("mafia", 1);
            $stats->set_stat('dodge', '10');
            break;
        case 'russian':
            $stats->set_stat("mafia", 2);
            $stats->set_stat('attbonus', '10');
            break;
        case 'italian':
            $stats->set_stat("mafia", 3);
            $stats->set_stat('defbonus', '10');
            break;
    }
    echo "<meta http-equiv='refresh' content='0;URL=?p=home'>";
} else {
        echo "
        <div class='choosemafia'>
        </div>
        <div id='choosecenter'>
                <div id='choosecontainer'>
                        <div style='float:left;margin-left:50px;margin-top:50px;font-family:Times New Roman,arial,serif;color:#d7d3d1;font-size:32px;font-style:italic;'>
                                Congratulations.
                                <div id='italicgrey' style='color:#7d7979;width:250px;'>
                                Your account has been succesfully activated. Continue to experience the mafia world.<br><br>
                                Now you must choose a Mafia Nation.<br>
                                You will live by the rules of this Nation and fight for it, till the day you die.<br><br>
                                There are three nations. The Italian mafia, The Russian mafia and the Chinese mafia.<br>
                                Click on the images to pick your nation.
                                </div>
                        </div>
                        <div class='choosemafiabg'>
                                <div class='mafiabg1'>
                                        <div id='italian'>
                                        <a href='javascript:void(0);' id='italianlink'><img src='images/blank.png'></a>
                                        </div>
                                </div>
                                <div class='mafiabg2'>
                                        <div id='russian'>
                                        <a href='javascript:void(0);' id='russianlink'><img src='images/blank.png'></a>
                                        </div>
                                </div>
                                <div class='mafiabg3'>
                                        <div id='chinese'>
                                        <a href='javascript:void(0);' id='chineselink'><img src='images/blank.png'></a>
                                        </div>
                                </div>
                                <div style='clear:both;'></div>
                        </div>
                        <div style='clear:both;'></div>
                        <div style='height:27px;'>
                                <div id='arrow_1' style='margin-left:359px;width:83px;height:27px;background:url(images/choosearrow.png) 0 0 no-repeat;'></div>
                                <div id='arrow_2' style='margin-left:525px;width:83px;height:27px;background:url(images/choosearrow.png) 0 0 no-repeat;'></div>
                                <div id='arrow_3' style='margin-left:690px;width:83px;height:27px;background:url(images/choosearrow.png) 0 0 no-repeat;'></div>
                        </div>
                        <div style='width:759px;height:211px;background:url(images/mafiainfo.png) 0 0 no-repeat;margin: 0px auto;'>
                                <div style='width:100%;padding:8px;padding-left:11px;'>
                                        <div id='div_1'>
                                                <div style='width:33%;float:left;font-family:Times New Roman, arial, serif;font-size:22px;color:#ded9d8;font-style:italic;'>
                                                        The Italian Mafia
                                                        <div id='italicblack' style='color:#7d7979;'>
                                                        This is where it all begins. This was the first mafia ever created, and the idea has since spread to the world.<br><br>
                                                        This nation has a lot of advantages in form of knowledge of the market, and how to run a gang.
                                                        <br><br>
                                                        Look in the column, right to this to see the bonuses you gain from picking this Nation.
                                                        </div>
                                                </div>
                                                <div style='width:25%;padding-left:30px;float:left;font-family:Times New Roman, arial, serif;font-size:22px;color:#ded9d8;font-style:italic;'>
                                                        Nation bonuses
                                                        <div id='italicblack' style='color:#7d7979;'>
                                                        <b>+ 5% Armor Defense<br>
                                                        + 2% Bank Interest<br>
                                                        + 50 Extra Health Points<br></b>
                                                        </div>
                                                </div>
                                                <div style='width:32%;float:right;text-align:right;padding-right:25px;'>
                                                        <div style='height:155px;'>
                                                        </div>
                                                        <div id='picknation' style='float:right;'>
                                                        <a href='?p=front&vtk=italian'><img src='images/blank2.png'></a>
                                                        </div>
                                                        <div style='clear:both;'></div>
                                                </div>
                                                <div style='clear:both;'></div>
                                        </div>
                                        <div id='div_2'> 
                                                <div style='width:33%;float:left;font-family:Times New Roman, arial, serif;font-size:22px;color:#ded9d8;font-style:italic;'>
                                                        The Russian Mafia
                                                        <div id='italicblack' style='color:#7d7979;'>
                                                        This is the most brutal of all the Nations. The russians are very aggresive and powerfull.<br><br>
                                                        By joining this Nation, you will not just be a gangmember, but a part of the brotherhood.
                                                        <br><br>
                                                        Look in the column, right to this to see the bonuses you gain from picking this Nation.
                                                        </div>
                                                </div>
                                                <div style='width:25%;padding-left:30px;float:left;font-family:Times New Roman, arial, serif;font-size:22px;color:#ded9d8;font-style:italic;'>
                                                        Nation bonuses
                                                        <div id='italicblack' style='color:#7d7979;'>
                                                        <b>+ 5% Attack Damage<br>
                                                        + 5% More Gold Stealing<br>
                                                        + 5 Extra Energy Points<br></b>
                                                        </div>
                                                </div>
                                                <div style='width:32%;float:right;text-align:right;padding-right:25px;'>
                                                        <div style='height:155px;'>
                                                        </div>
                                                        <div id='picknation' style='float:right;'>
                                                        <a href='?p=front&vtk=russian'><img src='images/blank2.png'></a>
                                                        </div>
                                                        <div style='clear:both;'></div>
                                                </div>
                                                <div style='clear:both;'></div>
                                        </div>
                                        <div id='div_3'>
                                                <div style='width:33%;float:left;font-family:Times New Roman, arial, serif;font-size:22px;color:#ded9d8;font-style:italic;'>
                                                        The Chinese Mafia
                                                        <div id='italicblack' style='color:#7d7979;'>
                                                        This is where it all begins. This was the first mafia ever created, and the idea has since spread to the world.<br><br>
                                                        This nation has a lot of advantages in form of knowledge of the market, and how to run a gang.
                                                        <br><br>
                                                        Look in the column, right to this to see the bonuses you gain from picking this Nation.
                                                        </div>
                                                </div>
                                                <div style='width:25%;padding-left:30px;float:left;font-family:Times New Roman, arial, serif;font-size:22px;color:#ded9d8;font-style:italic;'>
                                                        Nation bonuses
                                                        <div id='italicblack' style='color:#7d7979;'>
                                                        <b>+ 5% Dodge Bonus<br>
                                                        + 2% Faster Experience<br>
                                                        + Inventory size increased by 50<br></b>
                                                        </div>
                                                </div>
                                                <div style='width:32%;float:right;text-align:right;padding-right:25px;'>
                                                        <div style='height:155px;'>
                                                        </div>
                                                        <div id='picknation' style='float:right;'>
                                                        <a href='?p=front&vtk=chinese'><img src='images/blank2.png'></a>
                                                        </div>
                                                        <div style='clear:both;'></div>
                                                </div>
                                                <div style='clear:both;'></div>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
        ";
}
?>