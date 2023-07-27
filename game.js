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
    count = 88;
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
  }