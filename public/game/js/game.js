/**
 * Main Game Controller for Squishy Dumpling Heist.
 * Manages game state, player movement, NPC patrol/chase AI,
 * dumpling interactions, level transitions, and input handlers.
 */

const STATE = {
  TITLE: 'TITLE',
  PLAYING: 'PLAYING',
  CAUGHT: 'CAUGHT',
  STAGE_CLEAR: 'STAGE_CLEAR',
  ALL_CLEAR: 'ALL_CLEAR'
};

class DumplingGame {
  constructor(canvas) {
    this.canvas = canvas;
    this.renderer = new GameRenderer(canvas);
    this.state = STATE.TITLE;

    this.currentLevel = 0;
    this.totalLevels = 3;
    this.score = 0;
    this.gameTime = 0;

    // Input state
    this.keys = {};
    this.touchVector = { x: 0, y: 0 };
    this.lastStepSoundTime = 0;

    // Entities
    this.player = null;
    this.dumplings = [];
    this.npcs = [];
    this.obstacles = [];
    this.base = { x: 90, y: 510, radius: 55 };

    this.setupInputs();
    this.setupUI();
    this.loadLevel(0);
  }

  setupInputs() {
    window.addEventListener('keydown', e => {
      this.keys[e.key.toLowerCase()] = true;
      window.soundEngine.init();
    });

    window.addEventListener('keyup', e => {
      this.keys[e.key.toLowerCase()] = false;
    });

    // Touch controls setup (virtual joystick/buttons)
    this.setupVirtualControls();
  }

  setupVirtualControls() {
    const bindBtn = (id, keyName) => {
      const btn = document.getElementById(id);
      if (!btn) return;

      const press = e => {
        e.preventDefault();
        window.soundEngine.init();
        this.keys[keyName] = true;
      };
      const release = e => {
        e.preventDefault();
        this.keys[keyName] = false;
      };

      btn.addEventListener('touchstart', press, { passive: false });
      btn.addEventListener('touchend', release, { passive: false });
      btn.addEventListener('mousedown', press);
      btn.addEventListener('mouseup', release);
      btn.addEventListener('mouseleave', release);
    };

    bindBtn('btnUp', 'arrowup');
    bindBtn('btnDown', 'arrowdown');
    bindBtn('btnLeft', 'arrowleft');
    bindBtn('btnRight', 'arrowright');
  }

  setupUI() {
    const soundToggle = document.getElementById('soundToggle');
    if (soundToggle) {
      soundToggle.addEventListener('click', () => {
        const muted = window.soundEngine.toggleMute();
        soundToggle.innerText = muted ? '🔇 Sound: OFF' : '🔊 Sound: ON';
      });
    }

    const squishSlider = document.getElementById('squishSlider');
    const squishVal = document.getElementById('squishVal');
    if (squishSlider) {
      squishSlider.addEventListener('input', e => {
        const val = parseFloat(e.target.value);
        this.renderer.animator.userDepthMultiplier = val;
        if (squishVal) squishVal.innerText = `${val.toFixed(1)}x`;
      });
    }

    const startBtn = document.getElementById('startBtn');
    if (startBtn) {
      startBtn.addEventListener('click', () => {
        window.soundEngine.init();
        window.soundEngine.startBGM();
        this.startGame();
      });
    }

    const nextStageBtn = document.getElementById('nextStageBtn');
    if (nextStageBtn) {
      nextStageBtn.addEventListener('click', () => {
        this.currentLevel++;
        if (this.currentLevel >= this.totalLevels) {
          this.state = STATE.ALL_CLEAR;
          this.updateOverlayUI();
        } else {
          this.loadLevel(this.currentLevel);
          this.state = STATE.PLAYING;
          this.updateOverlayUI();
        }
      });
    }

    const restartBtn = document.getElementById('restartBtn');
    if (restartBtn) {
      restartBtn.addEventListener('click', () => {
        this.currentLevel = 0;
        this.score = 0;
        this.loadLevel(0);
        this.state = STATE.PLAYING;
        this.updateOverlayUI();
      });
    }
  }

  startGame() {
    this.currentLevel = 0;
    this.score = 0;
    this.loadLevel(0);
    this.state = STATE.PLAYING;
    this.updateOverlayUI();
  }

  loadLevel(levelIndex) {
    this.gameTime = 0;
    this.renderer.clearDOMSprites();
    const w = this.canvas.width;
    const h = this.canvas.height;

    // Reset Player
    this.player = {
      x: this.base.x,
      y: this.base.y,
      speed: 0,
      maxSpeed: 175,
      facing: 'right',
      walkDistance: 0,
      carriedDumpling: null,
      isCaught: false,
      dizzyAngle: 0
    };

    // Level 1: Beginner Kitchen (3 dumplings, 1 slow chef)
    if (levelIndex === 0) {
      this.obstacles = [
        { x: 260, y: 140, w: 180, h: 60, type: 'counter' },
        { x: 500, y: 320, w: 150, h: 70, type: 'cutting_board' },
        { x: 300, y: 400, w: 50, h: 50, type: 'teacup' }
      ];

      this.dumplings = [
        {
          id: 1,
          name: 'Xiao-Long',
          type: 'classic',
          homeX: 720,
          homeY: 100,
          x: 720,
          y: 100,
          isCarried: false,
          isDelivered: false,
          timeOffset: 0.1,
          spring: new JellySpring(200, 10),
          colors: { body: '#FFFDF9', shadow: '#E8D2B5', blush: '#FF8A80' }
        },
        {
          id: 2,
          name: 'Berry Bao',
          type: 'berry',
          homeX: 420,
          homeY: 90,
          x: 420,
          y: 90,
          isCarried: false,
          isDelivered: false,
          timeOffset: 0.5,
          spring: new JellySpring(200, 10),
          colors: { body: '#FFE4E6', shadow: '#FDA4AF', blush: '#F43F5E' }
        },
        {
          id: 3,
          name: 'Goldie',
          type: 'goldie',
          homeX: 710,
          homeY: 480,
          x: 710,
          y: 480,
          isCarried: false,
          isDelivered: false,
          timeOffset: 0.9,
          spring: new JellySpring(200, 10),
          colors: { body: '#FEF08A', shadow: '#EAB308', blush: '#F97316' }
        }
      ];

      this.npcs = [
        {
          id: 'chef1',
          role: 'chef',
          x: 400,
          y: 240,
          facingAngle: 0,
          patrolSpeed: 60,
          chaseSpeed: 110,
          visionAngle: Math.PI / 3, // 60 deg
          visionDistance: 150,
          isAlerted: false,
          isSuspicious: false,
          walkDistance: 0,
          waypoints: [
            { x: 220, y: 240 },
            { x: 620, y: 240 }
          ],
          currentWp: 0
        }
      ];
    }
    // Level 2: Two Guards (Chef & Pug)
    else if (levelIndex === 1) {
      this.obstacles = [
        { x: 220, y: 120, w: 160, h: 50, type: 'counter' },
        { x: 440, y: 240, w: 180, h: 50, type: 'cutting_board' },
        { x: 240, y: 380, w: 180, h: 60, type: 'counter' },
        { x: 620, y: 440, w: 50, h: 50, type: 'teacup' }
      ];

      this.dumplings = [
        {
          id: 1,
          name: 'Xiao-Long',
          type: 'classic',
          homeX: 710,
          homeY: 100,
          x: 710,
          y: 100,
          isCarried: false,
          isDelivered: false,
          timeOffset: 0.2,
          spring: new JellySpring(200, 10),
          colors: { body: '#FFFDF9', shadow: '#E8D2B5', blush: '#FF8A80' }
        },
        {
          id: 2,
          name: 'Berry Bao',
          type: 'berry',
          homeX: 430,
          homeY: 170,
          x: 430,
          y: 170,
          isCarried: false,
          isDelivered: false,
          timeOffset: 0.6,
          spring: new JellySpring(200, 10),
          colors: { body: '#FFE4E6', shadow: '#FDA4AF', blush: '#F43F5E' }
        },
        {
          id: 3,
          name: 'Goldie',
          type: 'goldie',
          homeX: 720,
          homeY: 340,
          x: 720,
          y: 340,
          isCarried: false,
          isDelivered: false,
          timeOffset: 1.0,
          spring: new JellySpring(200, 10),
          colors: { body: '#FEF08A', shadow: '#EAB308', blush: '#F97316' }
        },
        {
          id: 4,
          name: 'Matcha Mochi',
          type: 'matcha',
          homeX: 520,
          homeY: 500,
          x: 520,
          y: 500,
          isCarried: false,
          isDelivered: false,
          timeOffset: 1.4,
          spring: new JellySpring(200, 10),
          colors: { body: '#DCFCE7', shadow: '#4ADE80', blush: '#16A34A' }
        }
      ];

      this.npcs = [
        {
          id: 'chef1',
          role: 'chef',
          x: 300,
          y: 200,
          facingAngle: 0,
          patrolSpeed: 65,
          chaseSpeed: 115,
          visionAngle: Math.PI / 3,
          visionDistance: 145,
          isAlerted: false,
          walkDistance: 0,
          waypoints: [
            { x: 180, y: 200 },
            { x: 380, y: 200 },
            { x: 380, y: 90 },
            { x: 180, y: 90 }
          ],
          currentWp: 0
        },
        {
          id: 'dog1',
          role: 'dog',
          x: 600,
          y: 360,
          facingAngle: Math.PI,
          patrolSpeed: 75,
          chaseSpeed: 125,
          visionAngle: Math.PI / 2.8,
          visionDistance: 160,
          isAlerted: false,
          walkDistance: 0,
          waypoints: [
            { x: 680, y: 200 },
            { x: 680, y: 460 },
            { x: 480, y: 460 },
            { x: 480, y: 340 }
          ],
          currentWp: 0
        }
      ];
    }
    // Level 3: Kitchen Master Grand Heist (Chef, Dog & Sleepy Panda)
    else {
      this.obstacles = [
        { x: 220, y: 100, w: 140, h: 50, type: 'counter' },
        { x: 440, y: 100, w: 140, h: 50, type: 'cutting_board' },
        { x: 240, y: 250, w: 120, h: 60, type: 'counter' },
        { x: 500, y: 250, w: 150, h: 60, type: 'cutting_board' },
        { x: 340, y: 420, w: 180, h: 55, type: 'counter' },
        { x: 680, y: 440, w: 45, h: 45, type: 'teacup' }
      ];

      this.dumplings = [
        {
          id: 1,
          name: 'Xiao-Long',
          type: 'classic',
          homeX: 390,
          homeY: 70,
          x: 390,
          y: 70,
          isCarried: false,
          isDelivered: false,
          timeOffset: 0.1,
          spring: new JellySpring(200, 10),
          colors: { body: '#FFFDF9', shadow: '#E8D2B5', blush: '#FF8A80' }
        },
        {
          id: 2,
          name: 'Berry Bao',
          type: 'berry',
          homeX: 710,
          homeY: 80,
          x: 710,
          y: 80,
          isCarried: false,
          isDelivered: false,
          timeOffset: 0.4,
          spring: new JellySpring(200, 10),
          colors: { body: '#FFE4E6', shadow: '#FDA4AF', blush: '#F43F5E' }
        },
        {
          id: 3,
          name: 'Goldie',
          type: 'goldie',
          homeX: 720,
          homeY: 280,
          x: 720,
          y: 280,
          isCarried: false,
          isDelivered: false,
          timeOffset: 0.7,
          spring: new JellySpring(200, 10),
          colors: { body: '#FEF08A', shadow: '#EAB308', blush: '#F97316' }
        },
        {
          id: 4,
          name: 'Matcha Mochi',
          type: 'matcha',
          homeX: 620,
          homeY: 480,
          x: 620,
          y: 480,
          isCarried: false,
          isDelivered: false,
          timeOffset: 1.1,
          spring: new JellySpring(200, 10),
          colors: { body: '#DCFCE7', shadow: '#4ADE80', blush: '#16A34A' }
        },
        {
          id: 5,
          name: 'Choco Bao',
          type: 'choco',
          homeX: 430,
          homeY: 340,
          x: 430,
          y: 340,
          isCarried: false,
          isDelivered: false,
          timeOffset: 1.5,
          spring: new JellySpring(200, 10),
          colors: { body: '#EDD5BE', shadow: '#8B5A2B', blush: '#D2691E' }
        }
      ];

      this.npcs = [
        {
          id: 'chef1',
          role: 'chef',
          x: 320,
          y: 180,
          facingAngle: 0,
          patrolSpeed: 70,
          chaseSpeed: 120,
          visionAngle: Math.PI / 3,
          visionDistance: 150,
          isAlerted: false,
          walkDistance: 0,
          waypoints: [
            { x: 180, y: 180 },
            { x: 620, y: 180 }
          ],
          currentWp: 0
        },
        {
          id: 'dog1',
          role: 'dog',
          x: 650,
          y: 360,
          facingAngle: Math.PI,
          patrolSpeed: 80,
          chaseSpeed: 130,
          visionAngle: Math.PI / 2.7,
          visionDistance: 165,
          isAlerted: false,
          walkDistance: 0,
          waypoints: [
            { x: 700, y: 160 },
            { x: 700, y: 460 },
            { x: 550, y: 360 }
          ],
          currentWp: 0
        },
        {
          id: 'panda1',
          role: 'panda',
          x: 240,
          y: 360,
          facingAngle: 0,
          patrolSpeed: 55,
          chaseSpeed: 105,
          visionAngle: Math.PI / 2.5,
          visionDistance: 140,
          isAlerted: false,
          walkDistance: 0,
          waypoints: [
            { x: 180, y: 360 },
            { x: 300, y: 360 },
            { x: 240, y: 480 }
          ],
          currentWp: 0
        }
      ];
    }

    this.updateHUD();
  }

  updateHUD() {
    const stageTitle = document.getElementById('stageTitle');
    if (stageTitle) stageTitle.innerText = `Level ${this.currentLevel + 1}`;

    const deliveredCount = this.dumplings.filter(d => d.isDelivered).length;
    const totalCount = this.dumplings.length;

    const dumplingCounter = document.getElementById('dumplingCounter');
    if (dumplingCounter) dumplingCounter.innerText = `${deliveredCount} / ${totalCount}`;

    const guideMsg = document.getElementById('guideMsg');
    if (guideMsg) {
      if (this.player && this.player.carriedDumpling) {
        guideMsg.innerText = `🏃 [운반 중!] ${this.player.carriedDumpling.name} 만두가 춤추고 있어요! 찜기로 안전하게 복귀하세요!`;
      } else {
        guideMsg.innerText = `🥟 [숨바꼭질!] 셰프의 시야를 피해 잠든 스퀴시 만두를 업어오세요!`;
      }
    }
  }

  updateOverlayUI() {
    const startOverlay = document.getElementById('startOverlay');
    const stageClearOverlay = document.getElementById('stageClearOverlay');
    const allClearOverlay = document.getElementById('allClearOverlay');

    if (startOverlay) startOverlay.style.display = this.state === STATE.TITLE ? 'flex' : 'none';
    if (stageClearOverlay) stageClearOverlay.style.display = this.state === STATE.STAGE_CLEAR ? 'flex' : 'none';
    if (allClearOverlay) allClearOverlay.style.display = this.state === STATE.ALL_CLEAR ? 'flex' : 'none';
  }

  update(dt) {
    this.gameTime += dt;
    this.renderer.animator.update(dt);
    this.renderer.updateParticles(dt);

    if (this.state !== STATE.PLAYING && this.state !== STATE.CAUGHT) {
      return;
    }

    // Update Springs for dumplings
    this.dumplings.forEach(d => {
      if (d.spring) d.spring.update(dt);
    });

    if (this.state === STATE.CAUGHT) {
      this.handleCaughtAnimation(dt);
      return;
    }

    this.handlePlayerMovement(dt);
    this.handleDumplingInteractions();
    this.handleNPCAI(dt);
    this.checkStageClear();
  }

  handlePlayerMovement(dt) {
    const p = this.player;
    let dx = 0;
    let dy = 0;

    if (this.keys['arrowup'] || this.keys['w']) dy -= 1;
    if (this.keys['arrowdown'] || this.keys['s']) dy += 1;
    if (this.keys['arrowleft'] || this.keys['a']) dx -= 1;
    if (this.keys['arrowright'] || this.keys['d']) dx += 1;

    // Normalize diagonal speed
    const len = Math.hypot(dx, dy);
    if (len > 0) {
      dx /= len;
      dy /= len;

      if (dx < 0) p.facing = 'left';
      else if (dx > 0) p.facing = 'right';

      // Carrying slows down slightly
      const speedModifier = p.carriedDumpling ? 0.85 : 1.0;
      const targetSpeed = p.maxSpeed * speedModifier;

      p.speed = targetSpeed;
      const newX = p.x + dx * targetSpeed * dt;
      const newY = p.y + dy * targetSpeed * dt;

      // Obstacle & boundary collision
      if (!this.checkObstacleCollision(newX, p.y, 14)) {
        p.x = Math.max(20, Math.min(this.canvas.width - 20, newX));
      }
      if (!this.checkObstacleCollision(p.x, newY, 14)) {
        p.y = Math.max(20, Math.min(this.canvas.height - 20, newY));
      }

      p.walkDistance += targetSpeed * dt;

      // Footstep sound & dust particles
      if (this.gameTime - this.lastStepSoundTime > 0.28) {
        window.soundEngine.playFootstep();
        this.lastStepSoundTime = this.gameTime;

        this.renderer.addParticle({
          x: p.x,
          y: p.y + 16,
          vx: -dx * 15 + (Math.random() - 0.5) * 10,
          vy: -dy * 15 + (Math.random() - 0.5) * 10,
          size: 4,
          sizeChange: -3,
          color: 'rgba(210, 190, 170, 0.4)',
          life: 0.35,
          maxLife: 0.35
        });
      }
    } else {
      p.speed = 0;
    }
  }

  checkObstacleCollision(x, y, radius) {
    for (const obs of this.obstacles) {
      // Circle vs Box collision
      const nearestX = Math.max(obs.x, Math.min(x, obs.x + obs.w));
      const nearestY = Math.max(obs.y, Math.min(y, obs.y + obs.h));
      const dist = Math.hypot(x - nearestX, y - nearestY);
      if (dist < radius) return true;
    }
    return false;
  }

  handleDumplingInteractions() {
    const p = this.player;

    // 1. Stealing Dumpling (if player is not currently carrying one)
    if (!p.carriedDumpling) {
      for (const d of this.dumplings) {
        if (!d.isDelivered && !d.isCarried) {
          const dist = Math.hypot(p.x - d.x, p.y - d.y);
          if (dist < 32) {
            // Pick up dumpling!
            p.carriedDumpling = d;
            d.isCarried = true;
            if (d.spring) d.spring.impulse(75); // Strong, juicy squish & bounce impulse!

            window.soundEngine.playSquish();
            this.updateHUD();

            // Joy sparkles
            for (let i = 0; i < 8; i++) {
              this.renderer.addParticle({
                x: d.x,
                y: d.y,
                vx: (Math.random() - 0.5) * 90,
                vy: (Math.random() - 0.5) * 90,
                size: 6,
                sizeChange: -4,
                color: '#FFD700',
                life: 0.5,
                maxLife: 0.5,
                type: 'star'
              });
            }
            break;
          }
        }
      }
    }

    // 2. Delivering Dumpling to Home Base
    if (p.carriedDumpling) {
      const distToBase = Math.hypot(p.x - this.base.x, p.y - this.base.y);
      if (distToBase < this.base.radius) {
        const d = p.carriedDumpling;
        d.isCarried = false;
        d.isDelivered = true;
        p.carriedDumpling = null;

        // Position inside steamer
        const deliveredSoFar = this.dumplings.filter(item => item.isDelivered).length;
        const angle = (deliveredSoFar * (Math.PI * 2 / 5));
        d.x = this.base.x + Math.cos(angle) * 22;
        d.y = this.base.y + Math.sin(angle) * 20;

        window.soundEngine.playDeliver();
        this.score += 100;
        this.updateHUD();

        // Celebration hearts & stars
        for (let i = 0; i < 12; i++) {
          this.renderer.addParticle({
            x: this.base.x,
            y: this.base.y,
            vx: (Math.random() - 0.5) * 120,
            vy: -40 - Math.random() * 80,
            size: 8 + Math.random() * 6,
            sizeChange: -3,
            color: i % 2 === 0 ? '#FF6584' : '#FFD166',
            life: 0.8,
            maxLife: 0.8,
            type: i % 2 === 0 ? 'heart' : 'star'
          });
        }
      }
    }
  }

  handleNPCAI(dt) {
    const p = this.player;
    const playerInBase = Math.hypot(p.x - this.base.x, p.y - this.base.y) < this.base.radius + 15;

    for (const npc of this.npcs) {
      const distToPlayer = Math.hypot(p.x - npc.x, p.y - npc.y);
      const angleToPlayer = Math.atan2(p.y - npc.y, p.x - npc.x);

      // Angle difference normalized to [-PI, PI]
      let angleDiff = angleToPlayer - npc.facingAngle;
      while (angleDiff > Math.PI) angleDiff -= Math.PI * 2;
      while (angleDiff < -Math.PI) angleDiff += Math.PI * 2;

      // Vision check: player not in base sanctuary, inside vision arc & distance
      const inVisionCone = Math.abs(angleDiff) <= npc.visionAngle / 2 && distToPlayer <= npc.visionDistance;

      if (!playerInBase && inVisionCone) {
        if (!npc.isAlerted) {
          npc.isAlerted = true;
          window.soundEngine.playAlert();
        }

        // Chase Player
        npc.facingAngle = angleToPlayer;
        const moveDist = npc.chaseSpeed * dt;
        npc.x += Math.cos(angleToPlayer) * moveDist;
        npc.y += Math.sin(angleToPlayer) * moveDist;
        npc.walkDistance += moveDist;

        // Caught check
        if (distToPlayer < 28) {
          this.triggerCaught();
          break;
        }
      } else {
        // Return to calm patrol
        if (npc.isAlerted) {
          npc.isAlerted = false;
          npc.isSuspicious = true;
          setTimeout(() => { npc.isSuspicious = false; }, 1800);
        }

        // Follow waypoints
        const targetWp = npc.waypoints[npc.currentWp];
        const distToWp = Math.hypot(targetWp.x - npc.x, targetWp.y - npc.y);

        if (distToWp < 10) {
          npc.currentWp = (npc.currentWp + 1) % npc.waypoints.length;
        } else {
          const wpAngle = Math.atan2(targetWp.y - npc.y, targetWp.x - npc.x);
          npc.facingAngle = wpAngle;

          const moveDist = npc.patrolSpeed * dt;
          npc.x += Math.cos(wpAngle) * moveDist;
          npc.y += Math.sin(wpAngle) * moveDist;
          npc.walkDistance += moveDist;
        }
      }
    }
  }

  triggerCaught() {
    this.state = STATE.CAUGHT;
    this.player.isCaught = true;
    this.player.dizzyAngle = 0;
    this.caughtTimer = 0;

    window.soundEngine.playCaught();

    // If carrying a dumpling, it pops back to its home spot!
    if (this.player.carriedDumpling) {
      const d = this.player.carriedDumpling;
      d.isCarried = false;
      d.x = d.homeX;
      d.y = d.homeY;
      if (d.spring) d.spring.impulse(60);
      this.player.carriedDumpling = null;
    }

    this.updateHUD();
  }

  handleCaughtAnimation(dt) {
    this.caughtTimer += dt;
    this.player.dizzyAngle += dt * 10; // Comical spin!

    if (this.caughtTimer > 1.2) {
      // Warp safely back to home base
      this.player.x = this.base.x;
      this.player.y = this.base.y;
      this.player.isCaught = false;
      this.player.dizzyAngle = 0;
      this.state = STATE.PLAYING;

      // Reset NPC alert states
      this.npcs.forEach(n => { n.isAlerted = false; });
      this.updateHUD();
    }
  }

  checkStageClear() {
    const allDelivered = this.dumplings.every(d => d.isDelivered);
    if (allDelivered && this.dumplings.length > 0) {
      this.state = STATE.STAGE_CLEAR;
      window.soundEngine.playVictory();
      this.updateOverlayUI();
    }
  }

  render() {
    this.renderer.clear();
    const w = this.canvas.width;
    const h = this.canvas.height;

    // 1. Kitchen Tile Flooring
    this.renderer.drawEnvironment(w, h);

    // 2. Obstacles
    this.obstacles.forEach(obs => this.renderer.drawObstacle(obs));

    // 3. Home Base (Bamboo Steamer)
    const deliveredCount = this.dumplings.filter(d => d.isDelivered).length;
    this.renderer.drawBase(this.base, deliveredCount, this.gameTime);

    // 4. Guard NPC Vision Cones on the ground
    this.npcs.forEach(npc => this.renderer.drawNPCVisionCone(npc));

    // 5. Dumpling Breathing Auras on the ground
    this.dumplings.forEach(d => {
      if (!d.isCarried) {
        this.renderer.drawDumplingAura(d, this.gameTime);
      }
    });

    // 6. Dynamic Particles (Steam, Stars, Hearts, Dust)
    this.renderer.drawParticles();

    // 7. Real-time sprite-gen Wave & Breathe Oscilloscope
    this.renderer.drawBreatheMonitor(this.gameTime);

    // 8. Synchronize and Render High-Resolution 2D Animated Sprites from sprite-gen
    this.renderer.syncDOMSprites(this.player, this.dumplings, this.npcs, this.gameTime);
  }
}

// Start game loop when DOM is ready
window.addEventListener('DOMContentLoaded', () => {
  const canvas = document.getElementById('gameCanvas');
  const game = new DumplingGame(canvas);

  let lastTime = performance.now();
  function gameLoop(now) {
    const dt = Math.min((now - lastTime) / 1000, 0.1);
    lastTime = now;

    game.update(dt);
    game.render();

    requestAnimationFrame(gameLoop);
  }

  requestAnimationFrame(gameLoop);
});
