<!DOCTYPE html>
<html>
<head>
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/vragg.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="57x57" href="../img/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="../img/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../img/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../img/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../img/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../img/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../img/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../img/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../img/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="../img/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../img/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon-16x16.png">
    <link rel="manifest" href="../img/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="../css/game.css">
    <meta charset="utf-8" />
    <title>Gamedev Canvas Workshop - lesson 10: finishing up</title>
    <style>* { padding: 0; margin: 0; } canvas { background: #eee; display: block; margin: 0 auto; }</style>
</head>
<body>

<video autoplay muted loop id="myVideo">
  <source src="../img/media/vidio.mp4" type="video/mp4">
</video>

<?php include 'navbar.php'; ?>

    <h1 id="naam">gemaakt door Thomas dekker</h1>
    <br>

    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-adtest="on"
     data-ad-client="ca-pub-0000000000000000"
     data-ad-slot="0000000000"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<div class="game">
    <canvas id="myCanvas" width="815" height="600"></canvas>
    

            <script>
                //stetings voor de gamepjes van thomas
                var canvas = document.getElementById("myCanvas");
                var ctx = canvas.getContext("2d");
                var ballRadius = 15;
                var x = canvas.width/2;
                var y = canvas.height-30;
                var dx = 5;
                var dy = -2;
                var paddleHeight = 10;
                var paddleWidth = 75;
                var paddleX = (canvas.width-paddleWidth)/2;
                var rightPressed = false;
                var leftPressed = false;
                var brickRowCount = 9;
                var brickColumnCount = 3;
                var brickWidth = 75;
                var brickHeight = 20;
                var brickPadding = 10;
                var brickOffsetTop = 30;
                var brickOffsetLeft = 30;
                var score = 0;
                var lives = 3;

                var bricks = [];
                for(var c=0; c<brickColumnCount; c++) {
                    bricks[c] = [];
                    for(var r=0; r<brickRowCount; r++) {
                        bricks[c][r] = { x: 0, y: 0, status: 1 };
                    }
                }

                document.addEventListener("keydown", keyDownHandler, false);
                document.addEventListener("keyup", keyUpHandler, false);
                document.addEventListener("mousemove", mouseMoveHandler, false);

                function keyDownHandler(e) {
                    if(e.code  == "ArrowRight") {
                        rightPressed = true;
                    }
                    else if(e.code == 'ArrowLeft') {
                        leftPressed = true;
                    }
                }
                function keyUpHandler(e) {
                    if(e.code == 'ArrowRight') {
                        rightPressed = false;
                    }
                    else if(e.code == 'ArrowLeft') {
                        leftPressed = false;
                    }
                }
                function mouseMoveHandler(e) {
                    var relativeX = e.clientX - canvas.offsetLeft;
                    if(relativeX > 0 && relativeX < canvas.width) {
                        paddleX = relativeX - paddleWidth/2;
                    }
                }
                function collisionDetection() {
                    for(var c=0; c<brickColumnCount; c++) {
                        for(var r=0; r<brickRowCount; r++) {
                            var b = bricks[c][r];
                            if(b.status == 1) {
                                if(x > b.x && x < b.x+brickWidth && y > b.y && y < b.y+brickHeight) {
                                    dy = -dy;
                                    b.status = 0;
                                    score++;
                                    if(score == brickRowCount*brickColumnCount) {
                                        alert("YOU WIN, CONGRATS!");
                                    }
                                }
                            }
                        }
                    }
                }

                function drawBall() {
                    ctx.beginPath();
                    ctx.arc(x, y, ballRadius, 0, Math.PI*2);
                    ctx.fillStyle = "#0095DD";
                    ctx.fill();
                    ctx.closePath();
                }
                function drawPaddle() {
                    ctx.beginPath();
                    ctx.rect(paddleX, canvas.height-paddleHeight, paddleWidth, paddleHeight);
                    ctx.fillStyle = "#0095DD";
                    ctx.fill();
                    ctx.closePath();
                }
                function drawBricks() {
                    for(var c=0; c<brickColumnCount; c++) {
                        for(var r=0; r<brickRowCount; r++) {
                            if(bricks[c][r].status == 1) {
                                var brickX = (r*(brickWidth+brickPadding))+brickOffsetLeft;
                                var brickY = (c*(brickHeight+brickPadding))+brickOffsetTop;
                                bricks[c][r].x = brickX;
                                bricks[c][r].y = brickY;
                                ctx.beginPath();
                                ctx.rect(brickX, brickY, brickWidth, brickHeight);
                                ctx.fillStyle = "#0095DD";
                                ctx.fill();
                                ctx.closePath();
                            }
                        }
                    }
                }
                function drawScore() {
                    ctx.font = "16px Arial";
                    ctx.fillStyle = "#0095DD";
                    ctx.fillText("Score: "+score, 8, 20);
                }
                function drawLives() {
                    ctx.font = "16px Arial";
                    ctx.fillStyle = "#0095DD";
                    ctx.fillText("Lives: "+lives, canvas.width-65, 20);
                }

                function draw() {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    drawBricks();
                    drawBall();
                    drawPaddle();
                    drawScore();
                    drawLives();
                    collisionDetection();

                    if(x + dx > canvas.width-ballRadius || x + dx < ballRadius) {
                        dx = -dx;
                    }
                    if(y + dy < ballRadius) {
                        dy = -dy;
                    }
                    else if(y + dy > canvas.height-ballRadius) {
                        if(x > paddleX && x < paddleX + paddleWidth) {
                            dy = -dy;
                        }
                        else {
                            lives--;
                            if(!lives) {
                                alert("GAME OVER");
                            }
                            else {
                                x = canvas.width/2;
                                y = canvas.height-30;
                                dx = 2;
                                dy = -2;
                                paddleX = (canvas.width-paddleWidth)/2;
                            }
                        }
                    }

                    if(rightPressed && paddleX < canvas.width-paddleWidth) {
                        paddleX += 7;
                    }
                    else if(leftPressed && paddleX > 0) {
                        paddleX -= 7;
                    }

                    x += dx;
                    y += dy;
                    requestAnimationFrame(draw);
                }

                draw();
                // dit is de man die mij heeft geholpen document.location.reload();
            </script>
    </div>



</body>
</html>