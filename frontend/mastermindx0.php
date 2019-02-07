
<!doctype html>
<html>

    <?php
        session_start();

        // $server = "localhost";
        // $server = "192.168.2.6";  // De Knolle -- PC
        // $server = "192.168.2.9";  // De Knolle -- laptop
        // $server = "192.168.2.12"; // De Ljurk  -- laptop
        $server = "192.168.2.84";    // EmmaState -- laptop
        $pad = "MasterMind";
        $database = "OudHollandsGamen";
    ?>
    
    <head>
        <meta charset=utf-8>
        <title>MasterMind_OHG</title>
        <script src="https://code.jquery.com/jquery-3.1.1.js"></script>
        
        <?php
            echo '<script src="' . $pad . '/JS-MM_142.js"></script>';
            echo '<script src="' . $pad . '/JS-MMfuncties_042.js"></script>';
            echo '<script src="' . $pad . '/JQuery-MM_042.js"></script>';
            echo '<link rel="stylesheet" href="' . $pad . '/CSS-MM_042.css">';
            require_once "MasterMind/php-MMfuncties.php";
            require_once "MensErgerJeNiet/includes/mejn_php-functies.php";
        ?>
    </head>

    <body>
        <h1 id="turns">Wacht s.v.p. op uw beurt...</h1>
        <?php echo '<script src="http://' . $server . ':3000/socket.io/socket.io.js"></script>' ?>
        <!-- <script src="http://localhost:3000/socket.io/socket.io.js"></script> -->
        <!-- <button onclick="makeMove('testing moves')">Send test move</button> -->

<!-- *********************************************************************************************************** -->


        <?php
            if (isset($_POST["start_spel"])) {
                $gebr = detSpelerNaam($database, $_POST["speler"]);
                sessie_init($gebr);

                $actspelid = $_POST["act_spel"];
                $spelerid = $_POST["speler"];
                $rol = $_POST["rol"];

                $spelnaam = fetch_spel_alias($database, $actspelid);
                $spelerids = fetch_speler_ids($database, $actspelid);

                $nsplr = 2;
                for ($i = 1; $i <= $nsplr; $i++ ) {
                    $spelerx[$i] = detSpelerNaam($database, $spelerids[$i]);
                }
            }
        ?>

        <div id="server" style="display:none"><?php echo $server ?></div>
        <div id="kamer" style="display:none"><?php echo $actspelid ?></div>
        <div id="spelnaam" style="display:none"><?php echo $spelnaam ?></div>
        <div id="spelerid" style="display:none"><?php echo $spelerid ?></div>
        <div id="gebrvoornaam" style="display:none"><?php echo $gebr['voornaam'] ?></div>
        <div id="gebrnaam" style="display:none"><?php echo $gebr['naam'] ?></div>
        <div id="rol" style="display:none"><?php echo $rol ?></div>

        <?php
            for ($i = 1; $i<=$nsplr; $i++) {
                $idx = $spelerx[$i]['id'];
                $vnx = $spelerx[$i]['voornaam'];
                echo '<div id="spelerid' . $i . '" style="display:none">' . $idx . '</div>';
                echo '<div id="spelervn' . $i . '" style="display:none">' . $vnx . '</div>';
            }
        ?>

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
        </div>

        <div id="nieuwspel">
            <p><input type="button" id="nwspelknop"value="Nog een spel" onClick="window.location.reload()"></p>
        </div>


<!-- *********************************************************************************************************** -->

        <script>
            server = document.getElementById("server").innerHTML;
            room = document.getElementById("kamer").innerHTML;
            game = document.getElementById("spelnaam").innerHTML;
            user = document.getElementById("spelerid").innerHTML;
            voornaam = document.getElementById("gebrvoornaam").innerHTML;
            naam = document.getElementById("gebrnaam").innerHTML;
            rol = document.getElementById("rol").innerHTML;
            user += "%" + rol;      

            document.getElementById("turns").innerHTML = "Welkom " + voornaam + ",<br/>wacht s.v.p. op uw beurt...";
            document.getElementById("turns").style = "height:36px";

            var socket = io('http://' + server + ':3000/game');
            var gameData = {room: room, game: game, user: user};
            socket.emit('join room', gameData);


// ***********************************************************************************************************


            socket.on('game init', function(init){
                console.log(init);
            });

// -----------------------------------------------------------------------------------------------------------

            socket.on('game state', function(gamestate){
                npos = 5;

                console.log("gamestate  = " + gamestate);
                console.log("statusArr2(1) = " + statusArr2);
                console.log("gamestate[0][0] = " + gamestate[0][0]);
                if (gamestate[0][0] >= 1 && gamestate[0][0] <=4) {
                    statusArr2 = gamestate;
                    console.log("statusArr2(2) = " + statusArr2);
                }

                l = gamestate.length - 1;
                ygsi = splitGamestate(gamestate, l);
                brt = (ygis['beurt'] == undefined) ? 0 : ygsi['beurt'];
                rol = document.getElementById("rol").innerHTML;

                if (brt == 0) {
                    document.getElementById("kleurenpalet").style = "margin-top: 450px";
                } else {
                    mt = 40 * brt;
                    document.getElementById("kleurenpalet").style = "margin-top: " + mt + "px";                   
                }

                if (brt == 0 && rol == "codemaster" || brt > 0 && rol == "codekraker") {
                    document.getElementById("kleurenpalet").style.visibility = "visible";
                    document.getElementById("pinnen").style.visibility = "hidden";                  
                } else {
                    document.getElementById("kleurenpalet").style.visibility = "hidden";
                    document.getElementById("pinnen").style.visibility = "visible";                       
                }
                if (brt == 0) {
                    document.getElementById("pinnen").style.visibility = "hidden";
                    if (rol == "codemaster") {
                        document.getElementById("knop0").style.visibility = "visible";
                    } else {
                        document.getElementById("knop0").style.visibility = "hidden";                        
                    }
                } 

                if (rol == "codemaster") {
                    document.getElementById("cover").style.visibility="hidden"; 
                } else {
                    document.getElementById("cover").style.visibility="visible";
                }

                console.log ("type = " + ygsi['type']);
                console.log ("pos1 = " + ygsi['pos1']);
                console.log ("pos2 = " + ygsi['pos2']);
                console.log ("pos3 = " + ygsi['pos3']);
                console.log ("pos4 = " + ygsi['pos4']);
                console.log ("pos5 = " + ygsi['pos5']);
                console.log ("socketon2: beurt, rol = " + brt + ", " + rol);
                
                verwijderrij(npos, brt);
                for (j = 1; j <= npos; j++) {
                    ij = (brt == 0) ? "0" + j : 10 * brt + j;
                    xkl = ygsi['pos' + j];
                    if (xkl > 0) {
                        knopje = document.getElementById("dragid" + xkl);
                        dropje = document.getElementById("dropid" + ij);
                        knopkloon = knopje.cloneNode(true);
                        dropje.appendChild(knopkloon);                               
                    }
                }
            });

// -----------------------------------------------------------------------------------------------------------

            socket.on('game turn', function(turn){
                try{
                    procesturn(turn);
                } catch(e) {
                    console.log(e)
                }
                if(turn == 1){
                    document.getElementById("turns").innerHTML = voornaam + ", u bent aan zet..."
                } else if (turn == 0) {
                    document.getElementById("turns").innerHTML = voornaam + ", wacht s.v.p. op uw beurt..."
                } else if (turn == 2) {
                    document.getElementById("turns").innerHTML = "Einde spel."
                }
                document.getElementById("turns").style = "height:36px";
            });

// -----------------------------------------------------------------------------------------------------------

            function makeMove(moveData) {
                socket.emit('game move', moveData)
            };
        </script>
        
    </body>
</html>


<!-- *********************************************************************************************************** -->


<script>
    function splitGamestate(gamestate, l) {
        var ygs = new Array;

        ygs['type'] = gamestate[l][0];
        ygs['beurt'] = gamestate[l][1];
        ygs['pos1'] = gamestate[l][2];
        ygs['pos2'] = gamestate[l][3];
        ygs['pos3'] = gamestate[l][4];
        ygs['pos4'] = gamestate[l][5];
        ygs['pos5'] = gamestate[l][6];
        ygs['pos6'] = gamestate[l][7];
        ygs['nzw'] = gamestate[l][8];
        ygs['nwi'] = gamestate[l][9];
        ygs['delstat'] = gamestate[l][10];

        return ygs;
    }

    function verwijderrij(ni, i) {
        for (j = 1; j <= ni; j++) {
            ij = (i == 0) ? "0" + j : 10 * i + j;
            $("#dropid" + ij).empty();
        }
    }

    function procesturn(turn) {
        console.log("procesturn: statusArr2 = " + statusArr2);
        rol = document.getElementById("rol").innerHTML;

        l = statusArr2.length - 1;

        if (l >= 0) {
            tp = statusArr2[l][0];
            beurt = statusArr2[l][1];

            if (beurt == 0) {
                if (rol == "codemaster") {
                    document.getElementById("knop0").style.visibility = "hidden";
                    document.getElementById("kleurenpalet").style.visibility = "hidden";
                } else {
                    document.getElementById("knop1").style.visibility = "visible";
                    document.getElementById("kleurenpalet").style.visibility = "visible";
                    document.getElementById("kleurenpalet").style = "margin-top:0";
                }
            } else {
                h = 45 * beurt;
                bvis = (rol == "codemaster") ? "visible" : "hidden";
                bhid = (rol == "codemaster") ? "hidden" : "visible";
                if (rol == "codemaster") {
                    if (tp == 1) {
                        document.getElementById("knop" + beurt).style.visibility = "visible";
                    } else {

                    }
                } else
                    if (beurt < 10) {
                    document.getElementById("knop" + beurt + 1).style.visibility = "visible";
                }
                document.getElementById("kleurenpalet").style.visibility = bhid;
                document.getElementById("kleurenpalet").style = "margin-top:" + h + "px";
                document.getElementById("pinnen").style.visibility = bvis;
                document.getElementById("pinnen").style = "margin-top:" + h + "px";
            }
            if (rol == "codemaster") {
                rol = "codekraker";
                beurt = beurt + 1;
            } else {
                rol = "codemaster";
            }
            document.getElementById("rol").innerHTML = rol;
            // statusArr2[l][1] = beurt;
        }
    }
    
</script>
