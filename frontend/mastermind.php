
<!doctype html>
<html>
    
    <script>
        host = "localhost";
        host = "192.168.2.84"; // CodeGorilla
        host = "192.168.2.9";  // De Knolle
        host = "192.168.2.12"; // De Ljurk
    </script>
    
    <head>
            <meta charset=utf-8>
            <title>MasterMind_OHG</title>
            <script src="https://code.jquery.com/jquery-3.1.1.js"></script>
            
            <script src="http://192.168.2.84/mijnprojecten/OHGSockets/frontend/MasterMind/JS-MM_042.js"></script>
            <script src="http://192.168.2.84/mijnprojecten/OHGSockets/frontend/MasterMind/JS-MMfuncties_042.js"></script>
            <script src="http://192.168.2.84/mijnprojecten/OHGSockets/frontend/MasterMind/JQuery-MM_042.js"></script>
            <link rel="stylesheet" href="http://192.168.2.84/mijnprojecten/OHGSockets/frontend/MasterMind/CSS-MM_042.css">
            <?php require_once "MasterMind/php-MMfuncties.php"; ?>
    </head>

    <body>
        <h1 id="turns">Wacht s.v.p. op uw beurt...</h1>
        <script src="http://192.168.2.84:3000/socket.io/socket.io.js"></script>
        <!-- <button onclick="makeMove('testing moves')">Send test move</button> -->

<!-- *********************************************************************************************************** -->

<?php

        // include "includes/readPars1.php";
        // include "includes/initGame.php";

?>



        <script>
            // console.log("gamestatus_000 = " + gamestatus);
            // if (typeof(gamestatus) == "undefined") { alert ("Beginnuh...!"); }

            speltype = "handmatig"; /* auto, handmatig */
        </script>

        <!-- <script>
            var statusstring = new Array(10);
            initStatusStrings();
        </script> -->

        <div id="spelbord">
            <div id="gaatjes1"><script>drawrondjes();</script></div>
            <div id="gaatjes2"><script>drawpinnetjes();</script></div>
            <div id="cover"></div>
            <div id="covertgl"></div>
        </div>
        <div id="knoppen"><script>drawbuttons();</script></div>
        <div id="doosjes">
            <div id="kleurenpalet"> <div id="hulppalet"><script>drawcolors();</script></div></div>
            <div id="pinnen"><script>drawblackwhite();</script></div>


            <div id="speldata">
                <p>spelinvoerdata:<span id="initdata"></span></p>
                <p>spelstatusdata:</p><p id="statusdata"></p>
            </div>

        </div>


        <!-- <form id="formulier" name="formulier" method="POST" action="#"> -->
<!--
        <div>
                <span style="font-size:14px">your name:</span><input type="text" id="naam" name="naam">
            </div>
            <div>
                <span style="font-size:14px">email-adress:</span><input type="text" id="pmail" name="pmail">
            </div>
            <br/><hr/>
-->
            <!-- <p><u><i>Spel parameters</i></u></p> -->
            <!-- <table>

                <tr class="rij">
                    <td class="kolom1">aantal posities:</td>
                    <td class="kolom2">
                        <select required  name="npos">
                            <option value="4pos" <?php echo $sel_4pos ?>>4</option>
                            <option value="5pos" <?php echo $sel_5pos ?>>5</option>
                            <option value="6pos" <?php echo $sel_6pos ?>>6</option>
                        </select>
                    </td>
                </tr>
                <tr class="rij">
                    <td class="kolom1">aantal kleuren:</td>
                    <td class="kolom2">
                        <select required  name="nkleur">
                            <option value="6kleur" <?php echo $sel_6kleur ?>>6</option>
                            <option value="7kleur" <?php echo $sel_7kleur ?>>7</option>
                            <option value="8kleur" <?php echo $sel_8kleur ?>>8</option>
                            <option value="9kleur" <?php echo $sel_9kleur ?>>9</option>
                        </select>
                    </td>
                </tr>


            
                <tr class="rij"><td class="kolom1">lege postities toegestaan</td><td class="kolom2"><input type="checkbox"  name="legepos" value="legepos" <?php echo $chk_legepos ?>></td></tr>
                <tr class="rij"><td class="kolom1">kleur mag meer dan 1x voorkomen</td><td class="kolom2"><input type="checkbox"  name="multkleur" value="multkleur" <?php echo $chk_multkleur ?>></td></tr>
                <tr class="rij"><td class="kolom1">handmatige controle</td><td class="kolom2"><input type="checkbox"  name="handcheck" value="handcheck" <?php echo $chk_handcheck ?> ></td></tr>

                <tr style="font-size:14px"><td><u>Ik ben:</u></td></tr>
                <tr class="rij" style="font-size:14px">
                    <td colspan="2"><input type="radio" name="spelrol" value="master" <?php echo $chk_master ?>>bedenker van de code</td>
                </tr>
                <tr class="rij" style="font-size:14px">
                    <td colspan="2"><input type="radio" name="spelrol" value="kraker" <?php echo $chk_kraker ?>>kraker van de code</td>
                </td></tr>
            </table>

            <hr/>
            <input type="submit" id="invoeren" name="invoeren" value="Submit"> -->
        <!-- </form> -->
        <div id="nieuwspel">
            <p><input type="button" id="nwspelknop"value="Another Game" onClick="window.location.reload()"></p>
        </div>
    </body>

    <?php
        if (isset($_POST["invoeren"])) {
            echo "<script>vulinitdata('$arg')</script>";
        }
    ?>

<!-- *********************************************************************************************************** -->


        <!-- <script>
            x = document.getElementById("formulier");
            vis = x.style.visibility;
            // x.style.visibility = "hidden";
            vis = x.style.visibility;
            alert ("vis = " + vis);
        </script> -->

    <?php
        if (isset($_POST["invoeren"])) {       // || $userid[1] != $gebr_id) {
    ?>

            <script>
                x = document.getElementById("formulier");
                x.style.visibility = "hidden";

                x = document.getElementById("doosjes");
                x.style.visibility = "visible";

                x = document.getElementById("pinnen");
                x.style.visibility = "hidden";
            </script>

    <?php
            if ($spelrol == 0) {
                console.log("CodeMaster");
            } else {
                console.log("CodeKraker");
            }
    ?>

    <?php
            // unset($_POST["invoeren"]);
        }
    ?>

        <script>
            
            setupspel_id = document.getElementById('spelkamer').innerHTML;
            spel_naam = document.getElementById('spelnaam').innerHTML;
            gebr_naam = document.getElementById('speler').innerHTML;
            naam = document.getElementById('naam').innerHTML;
            rang = document.getElementById('rang').innerHTML;

            document.getElementById("turns").innerHTML = "Welkom " + naam + ",<br/>Wacht s.v.p. op uw beurt...";
            document.getElementById("turns").style = "height:36px";

            var room = setupspel_id;
            var user = gebr_naam;
            var game = spel_naam;
            // alert ("room, game, user: " + room + ", " + game + ", " + user);        
            var socket = io('http://192.168.2.84:3000');
            var gameData = {room: room, game: game, user: user};
            socket.emit('join room', gameData);
            
            socket.on('game state', function(gamestate){
                npos = 5;
                l = gamestate.length - 1;
                brt = gamestate[l][1];
                ijdel = gamestate[l][10];
                console.log("ijdel = " + ijdel);

                for (j=1; j<=npos; j++) {
                    ij = 10 * brt + j; 

                    xkl = gamestate[l][j+1];
                    if (xkl > 0) {
                        knopje = document.getElementById("dragid" + xkl);
                        ouderfrom = knopje.parentNode.id.replace("dropid", "");
                        dropje = document.getElementById("dropid" + ij);
                        knopkloon = knopje.cloneNode(true);
                        console.log("j, ouderfrom = " + j + ", " + ouderfrom);
                        deleterondje (ij);
                        dropje.appendChild(knopkloon);
                        if (ouderfrom[0] > 0 && ouderfrom[1] != j) {
                            deleterondje (ouderfrom);
                        }
                    }
                    if (ijdel > 0) {
                        deleterondje(ijdel);
                    }
                }
            
            });


        // alert ("goeie...");
        x = document.getElementById("doosjes");
        // x.style.visibility = "visible";
        // alert ("hoi...");

        alert ("goeie...");
        pinvis = document.getElementById("pinnen");
        pinvis.style.visibility = "hidden";


            socket.on('game turn', function(turn){
                if(turn == 1){
                    document.getElementById("turns").innerHTML = "U bent aan zet..."
                } else if (turn == 0) {
                    document.getElementById("turns").innerHTML = "Wacht s.v.p. op uw beurt..."
                } else if (turn == 2) {
                    document.getElementById("turns").innerHTML = "Einde spel."
                }
                document.getElementById("turns").style = "height:24px";
            });

            function makeMove(moveData) {
                socket.emit('game move', moveData)
            };
        </script>
        
    </body>
</html>
