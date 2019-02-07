
<!doctype html>
<html>

    <?php
        session_start();

        // $server = "localhost";
        // $server = "192.168.2.6";  // De Knolle -- PC
        $server = "192.168.2.9";  // De Knolle -- laptop
        // $server = "192.168.2.12"; // De Ljurk  -- laptop
        // $server = "192.168.2.84";    // EmmaState -- laptop
        $pad = "MasterMind";
        $database = "OudHollandsGamen";
    ?>
    
    <head>
        <meta charset=utf-8>
        <title>MasterMind_OHG</title>
        <script src="https://code.jquery.com/jquery-3.1.1.js"></script>
        
        <?php
            echo '<script src="' . $pad . '/JS-MM_OHG.js"></script>';
            echo '<script src="' . $pad . '/JS-MM_242.js"></script>';
            echo '<script src="' . $pad . '/JS-MMfuncties_042.js"></script>';
            echo '<script src="' . $pad . '/JQuery-MM_042.js"></script>';
            echo '<link rel="stylesheet" href="' . $pad . '/CSS-MM_042.css">';
            // require_once "MasterMind/php-MMfuncties.php";
            require_once "MensErgerJeNiet/includes/mejn_php-functies.php";
        ?>
    </head>

    <body>
        <h1 id="turns">Wacht s.v.p. op uw beurt...</h1>
        <?php echo '<script src="http://' . $server . ':3000/socket.io/socket.io.js"></script>' ?>

<!-- *********************************************************************************************************** -->


        <?php include "MasterMind/setGameParametersMM.php" ?>

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
            npos = 5;

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


// ***********************************************************************************************************

            var socket = io('http://' + server + ':3000/game');
            var gameData = {room: room, game: game, user: user};
            socket.emit('join room', gameData);

// -----------------------------------------------------------------------------------------------------------

            socket.on('game init', function(init){
                console.log(init);
            });

// -----------------------------------------------------------------------------------------------------------

            socket.on('game state', function(gamestate){
                console.log("socket.on: gamestate =");
                console.log(gamestate);

                // kopieer gamestate naar (globale) array "StatusArr2[][]"
                if (gamestate[0][0] >= 1 && gamestate[0][0] <=4) {
                    console.log("socket.on: statusArr2 =");
                    console.log(statusArr2);
                }

                // converteer laatste (rij-) element van gamestate (array) 
                // naar associatieve array ygsi[];
                l = gamestate.length - 1;
                ygsi = splitGamestate(gamestate, l);
                brt = (ygsi['beurt'] == undefined) ? 0 : ygsi['beurt'];

                // visHide(brt, rol);

                // consoleLog(ygsi);

                vulrijenSpeelbord(npos, brt, ygsi);
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
