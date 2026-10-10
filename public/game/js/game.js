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
      carriedEgg: null,
      carriedDumpling: null,
      isCaught: false,
      dizzyAngle: 0
    };

    // Level 1: Sunlit Meadow Garden (3 mysterious eggs, 1 curious vanilla bunny)
    if (levelIndex === 0) {
      this.obstacles = [
        { x: 260, y: 140, w: 180, h: 60, type: 'planter' },
        { x: 500, y: 320, w: 150, h: 70, type: 'mushroom' },
        { x: 300, y: 400, w: 50, h: 50, type: 'honey_pot' }
      ];

      this.eggs = [
        {
          id: 1,
          name: '루비 알',
          type: 'ruby',
          homeX: 720,
          homeY: 100,
          x: 720,
          y: 100,
          isCarried: false,
          isDelivered: false,
          isHatching: false,
          isHatched: false,
          hatchTimer: 3.5,
          hatchDuration: 3.5,
          cracks: 0,
          timeOffset: 0.1,
          spring: new JellySpring(200, 10),
          colors: { top: '#FF6B6B', bottom: '#C9184A', pattern: '#FFE66D', border: '#A0153E' },
          glowColor: 'rgba(255, 77, 109, 0.22)',
          baby: null
        },
        {
          id: 2,
          name: '골든 알',
          type: 'gold',
          homeX: 420,
          homeY: 90,
          x: 420,
          y: 90,
          isCarried: false,
          isDelivered: false,
          isHatching: false,
          isHatched: false,
          hatchTimer: 3.5,
          hatchDuration: 3.5,
          cracks: 0,
          timeOffset: 0.5,
          spring: new JellySpring(200, 10),
          colors: { top: '#FFE066', bottom: '#F77F00', pattern: '#FFFBEA', border: '#D47A00' },
          glowColor: 'rgba(255, 215, 0, 0.22)',
          baby: null
        },
        {
          id: 3,
          name: '에메랄드 알',
          type: 'emerald',
          homeX: 710,
          homeY: 480,
          x: 710,
          y: 480,
          isCarried: false,
          isDelivered: false,
          isHatching: false,
          isHatched: false,
          hatchTimer: 3.5,
          hatchDuration: 3.5,
          cracks: 0,
          timeOffset: 0.9,
          spring: new JellySpring(200, 10),
          colors: { top: '#52B788', bottom: '#1B4332', pattern: '#D8F3DC', border: '#0F2C1F' },
          glowColor: 'rgba(82, 183, 136, 0.22)',
          baby: null
        }
      ];
      this.dumplings = this.eggs;

      this.npcs = [
        {
          id: 'bunny1',
          role: 'bunny',
          name: '바닐라 버니',
          bunnyType: 'vanilla',
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
    // Level 2: Enchanted Garden Path (Vanilla & Cocoa Bunnies)
    else if (levelIndex === 1) {
      this.obstacles = [
        { x: 220, y: 120, w: 160, h: 50, type: 'planter' },
        { x: 440, y: 240, w: 180, h: 50, type: 'mushroom' },
        { x: 240, y: 380, w: 180, h: 60, type: 'stump' },
        { x: 620, y: 440, w: 50, h: 50, type: 'honey_pot' }
      ];

      this.eggs = [
        {
          id: 1,
          name: '루비 알',
          type: 'ruby',
          homeX: 710,
          homeY: 100,
          x: 710,
          y: 100,
          isCarried: false,
          isDelivered: false,
          isHatching: false,
          isHatched: false,
          hatchTimer: 3.5,
          hatchDuration: 3.5,
          cracks: 0,
          timeOffset: 0.2,
          spring: new JellySpring(200, 10),
          colors: { top: '#FF6B6B', bottom: '#C9184A', pattern: '#FFE66D', border: '#A0153E' },
          glowColor: 'rgba(255, 77, 109, 0.22)',
          baby: null
        },
        {
          id: 2,
          name: '골든 알',
          type: 'gold',
          homeX: 430,
          homeY: 170,
          x: 430,
          y: 170,
          isCarried: false,
          isDelivered: false,
          isHatching: false,
          isHatched: false,
          hatchTimer: 3.5,
          hatchDuration: 3.5,
          cracks: 0,
          timeOffset: 0.6,
          spring: new JellySpring(200, 10),
          colors: { top: '#FFE066', bottom: '#F77F00', pattern: '#FFFBEA', border: '#D47A00' },
          glowColor: 'rgba(255, 215, 0, 0.22)',
          baby: null
        },
        {
          id: 3,
          name: '에메랄드 알',
          type: 'emerald',
          homeX: 720,
          homeY: 340,
          x: 720,
          y: 340,
          isCarried: false,
          isDelivered: false,
          isHatching: false,
          isHatched: false,
          hatchTimer: 3.5,
          hatchDuration: 3.5,
          cracks: 0,
          timeOffset: 1.0,
          spring: new JellySpring(200, 10),
          colors: { top: '#52B788', bottom: '#1B4332', pattern: '#D8F3DC', border: '#0F2C1F' },
          glowColor: 'rgba(82, 183, 136, 0.22)',
          baby: null
        },
        {
          id: 4,
          name: '무지개 알',
          type: 'rainbow',
          homeX: 520,
          homeY: 500,
          x: 520,
          y: 500,
          isCarried: false,
          isDelivered: false,
          isHatching: false,
          isHatched: false,
          hatchTimer: 3.5,
          hatchDuration: 3.5,
          cracks: 0,
          timeOffset: 1.4,
          spring: new JellySpring(200, 10),
          colors: { top: '#CDB4DB', bottom: '#7B2CBF', pattern: '#E0AAFF', border: '#5A189A' },
          glowColor: 'rgba(168, 85, 247, 0.22)',
          baby: null
        }
      ];
      this.dumplings = this.eggs;

      this.npcs = [
        {
          id: 'bunny1',
          role: 'bunny',
          name: '바닐라 버니',
          bunnyType: 'vanilla',
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
          id: 'bunny2',
          role: 'bunny',
          name: '초코 버니',
          bunnyType: 'cocoa',
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
    // Level 3: Fairytale Secret Meadow (Vanilla, Cocoa & Berry Bunnies)
    else {
      this.obstacles = [
        { x: 220, y: 100, w: 140, h: 50, type: 'planter' },
        { x: 440, y: 100, w: 140, h: 50, type: 'mushroom' },
        { x: 240, y: 250, w: 120, h: 60, type: 'stump' },
        { x: 500, y: 250, w: 150, h: 60, type: 'planter' },
        { x: 340, y: 420, w: 180, h: 55, type: 'mushroom' },
        { x: 680, y: 440, w: 45, h: 45, type: 'honey_pot' }
      ];

      this.eggs = [
        {
          id: 1,
          name: '루비 알',
          type: 'ruby',
          homeX: 390,
          homeY: 70,
          x: 390,
          y: 70,
          isCarried: false,
          isDelivered: false,
          isHatching: false,
          isHatched: false,
          hatchTimer: 3.5,
          hatchDuration: 3.5,
          cracks: 0,
          timeOffset: 0.1,
          spring: new JellySpring(200, 10),
          colors: { top: '#FF6B6B', bottom: '#C9184A', pattern: '#FFE66D', border: '#A0153E' },
          glowColor: 'rgba(255, 77, 109, 0.22)',
          baby: null
        },
        {
          id: 2,
          name: '골든 알',
          type: 'gold',
          homeX: 710,
          homeY: 80,
          x: 710,
          y: 80,
          isCarried: false,
          isDelivered: false,
          isHatching: false,
          isHatched: false,
          hatchTimer: 3.5,
          hatchDuration: 3.5,
          cracks: 0,
          timeOffset: 0.4,
          spring: new JellySpring(200, 10),
          colors: { top: '#FFE066', bottom: '#F77F00', pattern: '#FFFBEA', border: '#D47A00' },
          glowColor: 'rgba(255, 215, 0, 0.22)',
          baby: null
        },
        {
          id: 3,
          name: '에메랄드 알',
          type: 'emerald',
          homeX: 720,
          homeY: 280,
          x: 720,
          y: 280,
          isCarried: false,
          isDelivered: false,
          isHatching: false,
          isHatched: false,
          hatchTimer: 3.5,
          hatchDuration: 3.5,
          cracks: 0,
          timeOffset: 0.7,
          spring: new JellySpring(200, 10),
          colors: { top: '#52B788', bottom: '#1B4332', pattern: '#D8F3DC', border: '#0F2C1F' },
          glowColor: 'rgba(82, 183, 136, 0.22)',
          baby: null
        },
        {
          id: 4,
          name: '무지개 알',
          type: 'rainbow',
          homeX: 620,
          homeY: 480,
          x: 620,
          y: 480,
          isCarried: false,
          isDelivered: false,
          isHatching: false,
          isHatched: false,
          hatchTimer: 3.5,
          hatchDuration: 3.5,
          cracks: 0,
          timeOffset: 1.1,
          spring: new JellySpring(200, 10),
          colors: { top: '#CDB4DB', bottom: '#7B2CBF', pattern: '#E0AAFF', border: '#5A189A' },
          glowColor: 'rgba(168, 85, 247, 0.22)',
          baby: null
        },
        {
          id: 5,
          name: '스타 알',
          type: 'star',
          homeX: 430,
          homeY: 340,
          x: 430,
          y: 340,
          isCarried: false,
          isDelivered: false,
          isHatching: false,
          isHatched: false,
          hatchTimer: 3.5,
          hatchDuration: 3.5,
          cracks: 0,
          timeOffset: 1.5,
          spring: new JellySpring(200, 10),
          colors: { top: '#4CC9F0', bottom: '#3A0CA3', pattern: '#F72585', border: '#1A0066' },
          glowColor: 'rgba(76, 201, 240, 0.22)',
          baby: null
        }
      ];
      this.dumplings = this.eggs;

      this.npcs = [
        {
          id: 'bunny1',
          role: 'bunny',
          name: '바닐라 버니',
          bunnyType: 'vanilla',
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
          id: 'bunny2',
          role: 'bunny',
          name: '초코 버니',
          bunnyType: 'cocoa',
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
          id: 'bunny3',
          role: 'bunny',
          name: '베리 버니',
          bunnyType: 'berry',
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

    const eggs = this.eggs || this.dumplings || [];
    const hatchedCount = eggs.filter(e => e.isHatched).length;
    const deliveredCount = eggs.filter(e => e.isDelivered || e.isHatched).length;
    const totalCount = eggs.length;

    const dumplingCounter = document.getElementById('dumplingCounter');
    if (dumplingCounter) dumplingCounter.innerText = `${hatchedCount} / ${totalCount} 부화`;

    const guideMsg = document.getElementById('guideMsg');
    if (guideMsg) {
      const carried = this.player && (this.player.carriedEgg || this.player.carriedDumpling);
      if (carried) {
        guideMsg.innerText = `🏃 [운반 중!] 꼬마 여우 루루가 ${carried.name}을 소중히 품고 있어요! 둥지로 안전하게 돌아오세요!`;
      } else if (eggs.some(e => e.isHatching)) {
        guideMsg.innerText = `🐣 [부화 진행 중!] 둥지 안에서 꼬물꼬물 아기 생물이 깨어나고 있어요! 톡톡!`;
      } else {
        guideMsg.innerText = `🦊 꼬마 여우 루루: 귀여운 토끼 순찰대의 랜턴 빛을 피해 신비한 알을 둥지로 데려오세요!`;
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

    // Update Springs for eggs
    const eggs = this.eggs || this.dumplings || [];
    eggs.forEach(egg => {
      if (egg.spring) egg.spring.update(dt);
    });

    if (this.state === STATE.CAUGHT) {
      this.handleCaughtAnimation(dt);
      return;
    }

    this.handlePlayerMovement(dt);
    this.handleEggInteractions();
    this.handleEggIncubation(dt);
    this.handleBabyWander(dt);
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
      const isCarrying = p.carriedEgg || p.carriedDumpling;
      const speedModifier = isCarrying ? 0.85 : 1.0;
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

  handleEggInteractions() {
    const p = this.player;
    const eggs = this.eggs || this.dumplings || [];

    // 1. Picking up Egg (if player is not currently carrying one)
    if (!p.carriedEgg && !p.carriedDumpling) {
      for (const egg of eggs) {
        if (!egg.isDelivered && !egg.isCarried && !egg.isHatched) {
          const dist = Math.hypot(p.x - egg.x, p.y - egg.y);
          if (dist < 32) {
            p.carriedEgg = egg;
            p.carriedDumpling = egg;
            egg.isCarried = true;
            if (egg.spring) egg.spring.impulse(75);

            window.soundEngine.playSquish();
            this.updateHUD();

            // Joy sparkles
            for (let i = 0; i < 8; i++) {
              this.renderer.addParticle({
                x: egg.x,
                y: egg.y,
                vx: (Math.random() - 0.5) * 90,
                vy: (Math.random() - 0.5) * 90,
                size: 6,
                sizeChange: -4,
                color: egg.colors ? egg.colors.top : '#FFD700',
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

    // 2. Delivering Egg to Nest Base (starts incubation countdown)
    const carried = p.carriedEgg || p.carriedDumpling;
    if (carried) {
      const distToBase = Math.hypot(p.x - this.base.x, p.y - this.base.y);
      if (distToBase < this.base.radius) {
        const egg = carried;
        egg.isCarried = false;
        egg.isDelivered = true;
        egg.isHatching = true;
        egg.hatchTimer = egg.hatchDuration || 3.5;
        egg.cracks = 0;
        p.carriedEgg = null;
        p.carriedDumpling = null;

        // Position inside nest circle
        const deliveredSoFar = eggs.filter(item => item.isDelivered || item.isHatched).length;
        const angle = (deliveredSoFar * (Math.PI * 2 / 5));
        egg.x = this.base.x + Math.cos(angle) * 22;
        egg.y = this.base.y + Math.sin(angle) * 20;

        window.soundEngine.playDeliver();
        this.score += 100;
        this.updateHUD();

        // Celebration hearts & stars
        for (let i = 0; i < 14; i++) {
          this.renderer.addParticle({
            x: this.base.x,
            y: this.base.y,
            vx: (Math.random() - 0.5) * 120,
            vy: -40 - Math.random() * 80,
            size: 8 + Math.random() * 6,
            sizeChange: -3,
            color: i % 2 === 0 ? (egg.colors ? egg.colors.top : '#FF6584') : '#FFD166',
            life: 0.8,
            maxLife: 0.8,
            type: i % 2 === 0 ? 'heart' : 'star'
          });
        }
      }
    }
  }

  handleEggIncubation(dt) {
    const eggs = this.eggs || this.dumplings || [];

    eggs.forEach(egg => {
      if (egg.isDelivered && egg.isHatching && !egg.isHatched) {
        egg.hatchTimer -= dt;
        const duration = egg.hatchDuration || 3.5;
        const progress = 1 - Math.max(0, egg.hatchTimer / duration);

        // Crack progression at 33%, 66%, 88%
        if (progress >= 0.33 && egg.cracks === 0) {
          egg.cracks = 1;
          if (egg.spring) egg.spring.impulse(45);
          window.soundEngine.playCrack();
          this.spawnCrackParticles(egg.x, egg.y, egg.colors ? egg.colors.border : '#883344');
        } else if (progress >= 0.66 && egg.cracks === 1) {
          egg.cracks = 2;
          if (egg.spring) egg.spring.impulse(60);
          window.soundEngine.playCrack();
          this.spawnCrackParticles(egg.x, egg.y, egg.colors ? egg.colors.border : '#883344');
        } else if (progress >= 0.88 && egg.cracks === 2) {
          egg.cracks = 3;
          if (egg.spring) egg.spring.impulse(80);
          window.soundEngine.playCrack();
          this.spawnCrackParticles(egg.x, egg.y, egg.colors ? egg.colors.border : '#883344');
        }

        // Hatch completed!
        if (egg.hatchTimer <= 0) {
          egg.isHatching = false;
          egg.isHatched = true;
          egg.hatchTimer = 0;
          window.soundEngine.playHatch();
          this.score += 200;

          // Instantiate baby creature to wander happily inside the nest
          egg.baby = {
            x: egg.x,
            y: egg.y,
            wanderAngle: Math.random() * Math.PI * 2,
            wanderSpeed: 25 + Math.random() * 20,
            pauseTimer: 0.3 + Math.random() * 0.8,
            moveTimer: 1.2 + Math.random() * 1.5
          };

          this.spawnHatchParticles(egg.x, egg.y, egg.colors);
          this.updateHUD();
        }
      }
    });
  }

  spawnCrackParticles(x, y, color) {
    for (let i = 0; i < 6; i++) {
      this.renderer.addParticle({
        x: x + (Math.random() - 0.5) * 12,
        y: y + (Math.random() - 0.5) * 12,
        vx: (Math.random() - 0.5) * 60,
        vy: -20 - Math.random() * 40,
        size: 3 + Math.random() * 3,
        sizeChange: -2,
        color: color || '#A0153E',
        life: 0.45,
        maxLife: 0.45
      });
    }
  }

  spawnHatchParticles(x, y, colors) {
    const topColor = colors ? colors.top : '#FFD700';
    for (let i = 0; i < 22; i++) {
      this.renderer.addParticle({
        x: x,
        y: y,
        vx: (Math.random() - 0.5) * 160,
        vy: -40 - Math.random() * 100,
        size: 7 + Math.random() * 7,
        sizeChange: -4,
        color: i % 3 === 0 ? topColor : (i % 3 === 1 ? '#FFF' : '#FF6584'),
        life: 0.9,
        maxLife: 0.9,
        type: i % 2 === 0 ? 'star' : 'heart'
      });
    }
  }

  handleBabyWander(dt) {
    const eggs = this.eggs || this.dumplings || [];
    const maxNestRadius = this.base.radius - 14;

    eggs.forEach(egg => {
      if (egg.isHatched && egg.baby) {
        const baby = egg.baby;

        if (baby.pauseTimer > 0) {
          baby.pauseTimer -= dt;
          if (baby.pauseTimer <= 0) {
            baby.wanderAngle = Math.random() * Math.PI * 2;
            baby.moveTimer = 1.0 + Math.random() * 1.8;
          }
        } else {
          baby.moveTimer -= dt;
          const nextX = baby.x + Math.cos(baby.wanderAngle) * baby.wanderSpeed * dt;
          const nextY = baby.y + Math.sin(baby.wanderAngle) * baby.wanderSpeed * dt;

          // Confine inside nest boundary
          const distFromBase = Math.hypot(nextX - this.base.x, nextY - this.base.y);
          if (distFromBase <= maxNestRadius) {
            baby.x = nextX;
            baby.y = nextY;
          } else {
            // Turn softly back toward nest center
            baby.wanderAngle = Math.atan2(this.base.y - baby.y, this.base.x - baby.x) + (Math.random() - 0.5) * 0.8;
          }

          if (baby.moveTimer <= 0) {
            baby.pauseTimer = 0.6 + Math.random() * 1.5;
          }
        }
      }
    });
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

    // If carrying an egg, it pops back to its home spot!
    const carried = this.player.carriedEgg || this.player.carriedDumpling;
    if (carried) {
      carried.isCarried = false;
      carried.x = carried.homeX;
      carried.y = carried.homeY;
      if (carried.spring) carried.spring.impulse(60);
      this.player.carriedEgg = null;
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
    const eggs = this.eggs || this.dumplings || [];
    const allHatched = eggs.every(e => e.isHatched);
    if (allHatched && eggs.length > 0) {
      this.state = STATE.STAGE_CLEAR;
      window.soundEngine.playVictory();
      this.updateOverlayUI();
    }
  }

  render() {
    this.renderer.clear();
    const w = this.canvas.width;
    const h = this.canvas.height;

    // 1. Fairytale Meadow Floor (2D grass, clover & cobblestone)
    this.renderer.drawEnvironment(w, h);

    // 2. Garden Obstacles (Planters, Mushrooms, Stumps, Honey Pots)
    this.obstacles.forEach(obs => this.renderer.drawObstacle(obs));

    // 3. Home Base (Cozy Golden Nest & Incubator)
    const eggs = this.eggs || this.dumplings || [];
    const hatchedCount = eggs.filter(e => e.isHatched).length;
    this.renderer.drawBase(this.base, hatchedCount, eggs.length, this.gameTime);

    // 4. Bunny Lantern Warm Vision Cones
    this.npcs.forEach(npc => this.renderer.drawNPCVisionCone(npc));

    // 5. Mysterious Eggs (Field, or Incubating/Cracking in Nest)
    eggs.forEach(egg => {
      this.renderer.drawEgg(egg, this.player, this.gameTime);
    });

    // 6. Super Cute Hatched Baby Creatures Hopping & Waddling in the Nest
    eggs.forEach(egg => {
      if (egg.isHatched && egg.baby) {
        this.renderer.drawBabyCreature(egg, this.gameTime);
      }
    });

    // 7. Cute Bunny Guards (Chaser NPCs with Bouncing Ears & Lanterns)
    this.npcs.forEach(npc => this.renderer.drawBunnyNPC(npc, this.gameTime));

    // 8. Cute 2D Fox Hero (Player with Bushy Tail & Sparkling Eyes)
    this.renderer.drawFoxPlayer(this.player, this.gameTime);

    // 9. Dynamic Particles (Steam, Stars, Hearts, Dust, Shell Fragments)
    this.renderer.drawParticles();

    // 10. Real-time Wave & Breathe Oscilloscope
    this.renderer.drawBreatheMonitor(this.gameTime);

    // 11. Clean up any stale DOM sprites
    this.renderer.syncDOMSprites(this.player, eggs, this.npcs, this.gameTime);
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
