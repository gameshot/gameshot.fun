//Get the form to test it on submit
let form = document.querySelector('form');
let restart = document.getElementById('restartButton');
let restartButton = document.getElementById('restart');

//The information we get from the form in order to add them to the game
let playerImg;
let platImg;
let bgImg;
let itemImg;
let enemyImg;

//Event listener on submit for the form
form.addEventListener('submit', checkForm);

restartButton.addEventListener('click', function () {
   window.location.reload();
});

//Function to be launched on form submitting
function checkForm(e) {
    form.style.display = "none";
    restart.style.display = "inherit";
    //Remove the first canvas created if any field modification
    if (document.querySelector('canvas') !== null) {
        document.querySelector('canvas').remove();
    }
    //Stop submitting for test
    e.preventDefault();

    //Grab the value of the player radio
    let pathPlayer = document.querySelector('input[name="player"]:checked+label>img').src;
    window.playerImg = pathPlayer.substr(0, pathPlayer.indexOf('_')+1);
    window.playerImg += 'tilesheet.png';

    //Grab values of the different radio groups, one for each info we need from the form
    window.platImg = document.querySelector('input[name="platform"]:checked+label>img').src;

    window.bgImg = document.querySelector('input[name="background"]:checked+label>img').src;

    window.itemImg = document.querySelector('input[name="item"]:checked+label>img').src;

    window.enemyImg = document.querySelector('input[name="enemy"]:checked+label>img').src;

    //Config for the game
    const config = {
        type: Phaser.AUTO,
        width: 800,
        height: 600,
        parent: 'phaser',
        physics: {
            default: 'arcade',
            arcade: {
                gravity: {
                    y: 300
                },
                debug: false
            }
        },
        scene: {
            preload: preload,
            create: create,
            update: update
        }
    };

    //Variables for the game
    let items;
    let player;
    let platforms;
    let cursors;
    let enemies;
    let score = 0;
    let gameOver = false;
    let scoreText;
    let lastScoreText;

    //Create a new GameObject
    let game = new Phaser.Game(config);

    //First function for the game - Preload the assets we need
    function preload() {
        this.load.image('background', window.bgImg);
        this.load.spritesheet('dude', window.playerImg, {frameWidth: 80, frameHeight: 111});
        this.load.image('ground', window.platImg);
        this.load.image('item', window.itemImg);
        this.load.image('enemy', window.enemyImg);
    }

    //Second function for the game - Placing the assets on the canvas and adding some animation/restrictions (collision)
    function create() {
        //Background added first
        this.add.tileSprite(400, 300, 800, 600, 'background');

        //Adding the player sprite
        player = this.physics.add.sprite(100, 450, 'dude');
        player.setBounce(0.2);
        player.setCollideWorldBounds(true);

        //Creating some animations for the player
        this.anims.create({
            key: 'idle',
            frames: this.anims.generateFrameNames('dude', { frames: [0]}),
            frameRate: 0.5,
            repeat: -1
        });
        this.anims.create({
            key: 'left',
            frames: this.anims.generateFrameNames('dude', { frames : [0, 9, 10] }),
            frameRate: 10,
            repeat: -1
        });
        this.anims.create({
            key: 'right',
            frames: this.anims.generateFrameNames('dude', { frames: [0, 9, 10] }),
            frameRate: 10,
            repeat: -1
        });

        //Grabbing the keyboard keys that are pressed - Will be used to move the player around
        cursors = this.input.keyboard.createCursorKeys();

        //Adding the platforms
        platforms = this.physics.add.staticGroup();
        let xIncPlat = 64;
        platforms.create(600, 400, 'ground');
        for (let x = 0; x <= 2; x++) {
            platforms.create(50 + xIncPlat * x, 250, 'ground');
        }
        for (let x = 0; x <= 15; x++) {
            platforms.create(30 + xIncPlat * x, 620, 'ground');
        }
        platforms.create(750, 220, 'ground');

        //Creating collision between the player and the platforms
        this.physics.add.collider(player, platforms);
        //Inputting the amount of items the creator wants to collect
        let itemsAmount = +(document.getElementById('itemsAmount').value)-1;
        //Adding the amount of items, for the steps the items should be apart a little calculation is done to seperate them evenly
        items = this.physics.add.group({
            key: 'item',
            repeat: itemsAmount,
            setXY: { x: 50, y: 10, stepX: 1/itemsAmount * 700 }
        });
        items.children.iterate(function (child) {
            //  Give each star a slightly different bounce
            child.setBounceY(Phaser.Math.FloatBetween(0.4, 0.8));
        });
        this.physics.add.collider(items, platforms);

        this.physics.add.overlap(player, items, collectItem, null, this);

        enemies = this.physics.add.group();
        if (document.getElementById('enemyCollision').checked) {
            this.physics.add.collider(enemies, platforms);
        }
        this.physics.add.collider(player, enemies, hitEnemy, null, this);

        scoreText = this.add.text(16, 16, 'Score: 0', { fontSize: '32px', fill: '#ff6600' });
    }

    // This function is a loop called by the game that checks for different events happening
    function update() {
        // Test for game over, make the score bigger with a game over message
        if (gameOver) {
            lastScoreText = scoreText.text;
            scoreText.setPosition(150, 40);
            scoreText.setFill('red');
            scoreText.setFontSize(100);
            scoreText.setText(lastScoreText + '\nGame over');
            this.scene.pause('default');
        } // Check if the player got the amount of points selected in the form -> Win
        else if (score >= document.getElementById('winScore').value) {
            player.setTint(0x008000);
            lastScoreText = scoreText.text;
            scoreText.setPosition(150, 40);
            scoreText.setFill('green');
            scoreText.setFontSize(100);
            scoreText.setText(lastScoreText + '\nYou won!!');
            this.scene.pause('default');
        }

        // Check if space or up arrow are pressed and the player is on the floor to perform a jump
        if ((cursors.space.isDown || cursors.up.isDown) && player.body.onFloor())
        {
            player.body.setVelocityY(-400); // jump up
        }
        // Checking if the left arrow key is pressed
        if (cursors.left.isDown) {
            player.body.setVelocityX(-200); // move left
            player.flipX= true; // flip the sprite to the left
            if (player.body.onFloor()) {
                player.anims.play('left', true); // play walk animation
            }
        } // Check if the right arrow key is pressed
        else if (cursors.right.isDown) {
            player.body.setVelocityX(200); // move right
            player.flipX = false; // use the original sprite looking to the right
            if (player.body.onFloor()) {
                player.anims.play('right', true); // play walk animation
            }
        } else {
            // Checks if the player is not moving anymore to stop the movement
            player.body.setVelocityX(0);
            player.anims.play('idle', true);
        }
    }

    // Event to check every time the window is resized -> Responsivness
    window.addEventListener("resize", resize, false);

    // Function called on window resize event
    function resize() {
        // Div containing the generated canvas of the game
        let div = document.getElementById("phaser");
        // The generated game canvas
        let canvas = document.querySelector("canvas");
        // Grabbing the values of the window height and width
        let windowWidth = window.innerWidth-20;
        let windowHeight = window.innerHeight-150;
        // Calculating the window ratio to adapt the frame
        let windowRatio = windowWidth / windowHeight;
        // Calculating the game ratio to adapt it to the window
        let gameRatio = game.config.width / game.config.height;
        // Adapting the sizes with the ratios
        if(windowRatio < gameRatio){
            canvas.style.width = windowWidth + "px";
            canvas.style.height = (windowWidth / gameRatio) + "px";
            div.style.width = windowWidth + "px";
            div.style.height = (windowWidth / gameRatio) + "px";
        }
        else{
            canvas.style.width = (windowHeight * gameRatio) + "px";
            canvas.style.height = windowHeight + "px";
            div.style.width = (windowHeight * gameRatio) + "px";
            div.style.height = windowHeight + "px";
        }
    }

    // Function called when a player touches an item in the game
    function collectItem (player, item)
    {
        // First the item gets removed from the game
        item.disableBody(true, true);
        // Increase the score
        score++;
        // Add it to the score text displayed in the game
        scoreText.setText('Score: ' + score);

        // Grabbed this line from the Phaser library example to place the items in different heights
        let x = (player.x < 400) ? Phaser.Math.Between(400, 800) : Phaser.Math.Between(0, 400);

        // Checking if all item have been collected
        if (items.countActive(true) === 0) {
            items.children.iterate(function (child) {

                child.enableBody(true, child.x, 0, true, true);

            });
            // Adding the enemy to a random x value at the top of the screen
            let enemy = enemies.create(x, 16, 'enemy');
            enemy.setBounce(1);
            enemy.setCollideWorldBounds(true);
            // The velocity of the enemy is 'randomized'
            enemy.setVelocity(Phaser.Math.Between(-200, 200), 20);
            // Enemy has no gravity so it can bounce around the world
            enemy.allowGravity = false;
        }
    }

    // Function called when the player touches the enemy
    function hitEnemy (player, enemy)
    {
        // Pause the game so the player can't move anymore
        this.physics.pause();
        // Set the player tint as red
        player.setTint(0xff0000);

        gameOver = true;
    }
}
