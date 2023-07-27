<!DOCTYPE html>
<html>
<head>
   <title>Burpsuite Playground by Ethic Ninja</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .full-screen-nav {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px;
            background: #333;
            color: #fff;
            overflow-y: auto;
            padding: 20px;
        }

        .full-screen-nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .full-screen-nav ul li {
            margin-bottom: 10px;
        }

        .full-screen-nav ul li a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s;
        }

        .full-screen-nav ul li a:hover {
            color: #17a2b8;
        }

        .full-screen-content {
            margin-left: 250px;
            padding: 20px;
        }

        canvas {
          border: 2px solid #748c72;
          background: linear-gradient(#8fb58a, #a7d4a1, #abcfa5, #8fb58a);
          box-shadow: inset 0 0 50px rgba(0, 0, 0, 0.3);
        }

        .start-button {
          position: absolute;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
          background-color: #061138;
          color: #fff;
          border: none;
          padding: 10px 20px;
          font-size: 18px;
          cursor: pointer;
        }

        .game-over {
          display: none;
        }

        .score-display {
          color: #000;
          font-size: 24px;
          margin-bottom: 10px;
          text-align: center;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php include "navigation.php" ?>
    <?php
// Mendapatkan isi dari file scores.csv
$file = 'scores.csv';
$scores = file($file, FILE_IGNORE_NEW_LINES);

// Membuat array untuk menyimpan data skor
$data = [];

// Memisahkan data email dan skor dari setiap baris
foreach ($scores as $score) {
    $row = explode(',', $score);
    $email = $row[0];
    $score = $row[1];

    // Menyimpan data skor ke dalam array
    $data[] = [
        'email' => $email,
        'score' => $score
    ];
}
?>

    <div class="full-screen-content">
        <h1>Snake Game</h1>
    <p style="padding:10px;border:1px black solid;background:lightyellow">Goal: Dapatkan score tertinggi!.</p>
        <canvas width="400" height="400" id="game"></canvas>
        <button class="start-button">Start</button>
        <div class="game-over">
            <h2>Game Over</h2>
            <p>Final Score: <span class="score-display">0</span></p>
            <button class="start-button">Again</button>
        </div>
        <h1>List Scores</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row) : ?>
                <tr>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['score']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
        <script>
            var canvas = document.getElementById('game');
            var context = canvas.getContext('2d');

            var grid = 16;
            var count = 0;
            var score = 0;

            var snake = {
                x: 160,
                y: 160,
                dx: grid,
                dy: 0,
                cells: [],
                maxCells: 4
            };

            var apple = {
                x: 320,
                y: 320
            };

            function getRandomInt(min, max) {
                return Math.floor(Math.random() * (max - min)) + min;
            }

            var gameRunning = false;
            var gamePaused = false;
            var animationFrame;

            var startButton = document.querySelector('.start-button');
            var gameOverScreen = document.querySelector('.game-over');
            var scoreDisplay = document.querySelector('.score-display');

            startButton.addEventListener('click', function() {
                startGame();
            });

            gameOverScreen.querySelector('.start-button').addEventListener('click', function() {
                startGame();
            });

            var touchStartX = 0;
            var touchStartY = 0;

            document.addEventListener('keydown', function(e) {
                if (!gameRunning) {
                    return;
                }

                if (e.which === 37 && snake.dx === 0) {
                    snake.dx = -grid;
                    snake.dy = 0;
                } else if (e.which === 38 && snake.dy === 0) {
                    snake.dy = -grid;
                    snake.dx = 0;
                } else if (e.which === 39 && snake.dx === 0) {
                    snake.dx = grid;
                    snake.dy = 0;
                } else if (e.which === 40 && snake.dy === 0) {
                    snake.dy = grid;
                    snake.dx = 0;
                }
            });

            document.addEventListener('touchstart', function(e) {
                if (!gameRunning) {
                    return;
                }

                touchStartX = e.touches[0].clientX;
                touchStartY = e.touches[0].clientY;
            });

            document.addEventListener('touchmove', function(e) {
                if (!gameRunning) {
                    return;
                }

                var touchEndX = e.touches[0].clientX;
                var touchEndY = e.touches[0].clientY;
                var dx = touchEndX - touchStartX;
                var dy = touchEndY - touchStartY;

                // Determine the swipe direction
                if (Math.abs(dx) > Math.abs(dy)) {
                    // Horizontal swipe
                    if (dx > 0 && snake.dx === 0) {
                        snake.dx = grid;
                        snake.dy = 0;
                    } else if (dx < 0 && snake.dx === 0) {
                        snake.dx = -grid;
                        snake.dy = 0;
                    }
                } else {
                    // Vertical swipe
                    if (dy > 0 && snake.dy === 0) {
                        snake.dy = grid;
                        snake.dx = 0;
                    } else if (dy < 0 && snake.dy === 0) {
                        snake.dy = -grid;
                        snake.dx = 0;
                    }
                }
            });

            function loop() {
                if (!gameRunning || gamePaused) {
                    return;
                }

                animationFrame = requestAnimationFrame(loop);
                // slow game loop to preferred speed
                // 100 = 60 FPS
                if (++count < 100) {
                    return;
                }
                // speed of the snake
                // 85 = 85% of max speed
                count = 95;
                context.clearRect(0, 0, canvas.width, canvas.height);
                // move snake by its velocity
                snake.x += snake.dx;
                snake.y += snake.dy;
                // wrap snake position horizontally on edge of screen
                if (snake.x < 0) {
                    snake.x = canvas.width - grid;
                } else if (snake.x >= canvas.width) {
                    snake.x = 0;
                }

                if (snake.y < 0) {
                    snake.y = canvas.height - grid;
                } else if (snake.y >= canvas.height) {
                    snake.y = 0;
                }

                snake.cells.unshift({ x: snake.x, y: snake.y });

                if (snake.cells.length > snake.maxCells) {
                    snake.cells.pop();
                }

                context.fillStyle = '#5e0d0d';
                context.fillRect(apple.x, apple.y, grid - 1, grid - 1);
                // Set shadow properties
                context.shadowColor = 'rgba(0, 0, 0, 0.5)';
                context.shadowBlur = 5;
                context.shadowOffsetX = 2;
                context.shadowOffsetY = 2;
                context.fillStyle = '#061138';
                snake.cells.forEach(function(cell, index) {
                    context.fillRect(cell.x, cell.y, grid - 1, grid - 1);

                    if (cell.x === apple.x && cell.y === apple.y) {
                        snake.maxCells++;
                        score++;
                        scoreDisplay.textContent = score;

                        apple.x = getRandomInt(0, 25) * grid;
                        apple.y = getRandomInt(0, 25) * grid;
                    }

                    for (var i = index + 1; i < snake.cells.length; i++) {
                        if (cell.x === snake.cells[i].x && cell.y === snake.cells[i].y) {
                            endGame();
                        }
                    }
                });
            }

            function startGame() {
                if (gameRunning) {
                    return;
                }

                gameRunning = true;
                gamePaused = false;
                score = 0;
                snake.x = 160;
                snake.y = 160;
                snake.cells = [];
                snake.maxCells = 4;
                snake.dx = grid;
                snake.dy = 0;
                apple.x = getRandomInt(0, 25) * grid;
                apple.y = getRandomInt(0, 25) * grid;
                startButton.style.display = 'none';
                gameOverScreen.style.display = 'none';
                scoreDisplay.textContent = score;

                if (animationFrame) {
                    cancelAnimationFrame(animationFrame);
                }

                animationFrame = requestAnimationFrame(loop);
            }

            function endGame() {
                gameRunning = false;
                gamePaused = true;
                gameOverScreen.style.display = 'block';
                document.querySelector('.game-over .score-display').textContent = score;

                if (animationFrame) {
                    cancelAnimationFrame(animationFrame);
                }

                // Simpan skor ke dalam flat file
                var email = "<?php echo $_SESSION['email']; ?>";
                $.ajax({
                    type: "POST",
                    url: "save_score.php",
                    data: { email: email, score: score },
                    success: function(response) {
                        console.log("Skor disimpan.");
                    },
                    error: function(xhr, status, error) {
                        console.log("Terjadi kesalahan saat menyimpan skor: " + error);
                    }
                });
            }
        </script>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
