const config = {
    type: Phaser.AUTO,
    width: 800,
    height: 600,
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

let items;
let player;
let platforms;
let cursors;
let enemies;
let score = 0;
let gameOver = false;
let scoreText;
let lastScoreText;

let game = new Phaser.Game(config);

function preload() {
    this.load.spritesheet('dude', '../assets/players/player_tilesheet.png', {frameWidth: 80, frameHeight: 111});
    this.load.image('background', '../assets/backgrounds/purple.png');
    this.load.image('ground', '../assets/platforms/platformPack_tile002.png');
    this.load.image('item', '../assets/items/star_silver.png');
    this.load.image('enemy', '../assets/items/bolt_gold.png');
}

function create() {
    this.add.tileSprite(400, 300, 800, 600, 'background');

    player = this.physics.add.sprite(100, 450, 'dude');
    player.setBounce(0.2);
    player.setCollideWorldBounds(true);
    this.anims.create({
        key: 'idle',
        frames: this.anims.generateFrameNames('dude', { frames: [0]}),
        frameRate: 0.5,
        repeat: -1
    });
    this.anims.create({
        key: 'left',
        frames: this.anims.generateFrameNames('dude', { frames : [0, 9, 10] }),
        frameRate: 15,
        repeat: -1
    });
    this.anims.create({
        key: 'right',
        frames: this.anims.generateFrameNames('dude', { frames: [0, 9, 10] }),
        frameRate: 15,
        repeat: -1
    });
    cursors = this.input.keyboard.createCursorKeys();
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
    items = this.physics.add.group({
        key: 'item',
        repeat: 5,
        setXY: { x: 50, y: 10, stepX: 140 }
    });
    items.children.iterate(function (child) {

        //  Give each star a slightly different bounce
        child.setBounceY(Phaser.Math.FloatBetween(0.4, 0.8));

    });
    this.physics.add.collider(player, platforms);
    this.physics.add.collider(items, platforms);

    enemies = this.physics.add.group();
    this.physics.add.collider(enemies, platforms);
    this.physics.add.overlap(player, items, collectItem, null, this);
    this.physics.add.collider(player, enemies, hitEnemy, null, this);

    scoreText = this.add.text(16, 16, 'Score: 0', { fontSize: '32px', fill: '#000' });

}

function update() {

    if (gameOver) {
        lastScoreText = scoreText.text;
        scoreText.setPosition(150, 40);
        scoreText.setFill('red');
        scoreText.setFontSize(100);
        scoreText.setText(lastScoreText + '\nGame over');
        this.scene.pause('default');
    } else if (score >= 12) {
        player.setTint(0x008000);
        lastScoreText = scoreText.text;
        scoreText.setPosition(150, 40);
        scoreText.setFill('green');
        scoreText.setFontSize(100);
        scoreText.setText(lastScoreText + '\nYou won!!');
        this.scene.pause('default');
    }
    if ((cursors.space.isDown || cursors.up.isDown) && player.body.onFloor())
    {
        player.body.setVelocityY(-400); // jump up
    }
    if (cursors.left.isDown) {
        player.body.setVelocityX(-200); // move left
        player.flipX= true; // flip the sprite to the left
        if (player.body.onFloor()) {
            player.anims.play('left', true); // play walk animation
        }
    } else if (cursors.right.isDown) {
        player.body.setVelocityX(200); // move right
        player.flipX = false; // use the original sprite looking to the right
        if (player.body.onFloor()) {
            player.anims.play('right', true); // play walk animation
        }
    } else {
        player.body.setVelocityX(0);
        player.anims.play('idle', true);
    }
}

function collectItem (player, item)
{
    item.disableBody(true, true);
    score++;
    scoreText.setText('Score: ' + score);
    let x = (player.x < 400) ? Phaser.Math.Between(400, 800) : Phaser.Math.Between(0, 400);

    if (items.countActive(true) === 0) {
        items.children.iterate(function (child) {

            child.enableBody(true, child.x, 0, true, true);

        });
        let enemy = enemies.create(x, 16, 'enemy');
        enemy.setBounce(1);
        enemy.setCollideWorldBounds(true);
        enemy.setVelocity(Phaser.Math.Between(-200, 200), 20);
        enemy.allowGravity = false;
    }
}

function hitEnemy (player, enemy)
{
    this.physics.pause();

    player.setTint(0xff0000);

    player.anims.play('turn');

    gameOver = true;
}
