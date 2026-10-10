/**
 * High-performance 2D Sprite & Canvas Hybrid Renderer for Squishy Dumpling Heist.
 * Directly utilizes official high-resolution 2D animated sprites from aldegad/sprite-gen:
 * - Player: attack-fox-hood.gif (Agile Thief Hero BaoBao)
 * - Dumplings: attack-slime.gif (Squishy Bouncing Slime Dumplings with dynamic hue themes)
 * - Guard NPCs: attack-paladin.gif (Golden Knight Guard) & attack-claudecy-samurai.gif
 * Synced at 60 FPS with sprite-gen volume-preserving breathing and jiggle physics.
 */

class GameRenderer {
  constructor(canvas) {
    this.canvas = canvas;
    this.ctx = canvas.getContext('2d');
    this.animator = new SpriteAnimator();
    this.spriteLayer = document.getElementById('spriteLayer');

    // DOM Sprite element cache: Map<string, HTMLImageElement>
    this.domSprites = new Map();

    // Particle pool
    this.particles = [];
  }

  clear() {
    this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
  }

  addParticle(p) {
    this.particles.push(p);
  }

  updateParticles(dt) {
    for (let i = this.particles.length - 1; i >= 0; i--) {
      const p = this.particles[i];
      p.x += (p.vx || 0) * dt;
      p.y += (p.vy || 0) * dt;
      p.life -= dt;
      if (p.sizeChange) p.size = Math.max(0, p.size + p.sizeChange * dt);
      if (p.life <= 0) {
        this.particles.splice(i, 1);
      }
    }
  }

  drawParticles() {
    const ctx = this.ctx;
    this.particles.forEach(p => {
      ctx.save();
      ctx.globalAlpha = Math.max(0, Math.min(1, p.life / p.maxLife));
      ctx.fillStyle = p.color;

      if (p.type === 'steam') {
        ctx.beginPath();
        ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
        ctx.fill();
      } else if (p.type === 'star') {
        this.drawStar(p.x, p.y, 4, p.size, p.size * 0.4, p.color);
      } else if (p.type === 'heart') {
        this.drawHeart(p.x, p.y, p.size, p.color);
      } else {
        ctx.beginPath();
        ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
        ctx.fill();
      }
      ctx.restore();
    });
  }

  drawStar(cx, cy, spikes, outerRadius, innerRadius, color) {
    const ctx = this.ctx;
    let rot = (Math.PI / 2) * 3;
    let x = cx;
    let y = cy;
    const step = Math.PI / spikes;

    ctx.beginPath();
    ctx.moveTo(cx, cy - outerRadius);
    for (let i = 0; i < spikes; i++) {
      x = cx + Math.cos(rot) * outerRadius;
      y = cy + Math.sin(rot) * outerRadius;
      ctx.lineTo(x, y);
      rot += step;

      x = cx + Math.cos(rot) * innerRadius;
      y = cy + Math.sin(rot) * innerRadius;
      ctx.lineTo(x, y);
      rot += step;
    }
    ctx.lineTo(cx, cy - outerRadius);
    ctx.closePath();
    ctx.fillStyle = color;
    ctx.fill();
  }

  drawHeart(x, y, size, color) {
    const ctx = this.ctx;
    ctx.save();
    ctx.translate(x, y);
    ctx.scale(size / 15, size / 15);
    ctx.beginPath();
    ctx.moveTo(0, 0);
    ctx.bezierCurveTo(-5, -5, -10, 0, 0, 10);
    ctx.bezierCurveTo(10, 0, 5, -5, 0, 0);
    ctx.fillStyle = color;
    ctx.fill();
    ctx.restore();
  }

  // Draw cute 2D storybook garden meadow flooring with wildflowers & stepping stones
  drawEnvironment(width, height) {
    const ctx = this.ctx;
    const tileSize = 44;

    // 1. Soft Grass Checker Tiles
    for (let y = 0; y < height; y += tileSize) {
      for (let x = 0; x < width; x += tileSize) {
        const isLight = ((x / tileSize) + (y / tileSize)) % 2 === 0;
        ctx.fillStyle = isLight ? '#8CD668' : '#7EC85A';
        ctx.fillRect(x, y, tileSize, tileSize);

        ctx.strokeStyle = 'rgba(95, 175, 65, 0.28)';
        ctx.lineWidth = 1;
        ctx.strokeRect(x, y, tileSize, tileSize);
      }
    }

    // 2. Cute Cobblestone Stepping Stones winding through the garden
    const stones = [
      { x: 130, y: 460, r: 16 }, { x: 175, y: 420, r: 14 }, { x: 230, y: 390, r: 15 },
      { x: 290, y: 340, r: 17 }, { x: 370, y: 310, r: 15 }, { x: 440, y: 280, r: 18 },
      { x: 520, y: 240, r: 15 }, { x: 590, y: 190, r: 16 }, { x: 660, y: 140, r: 17 }
    ];
    stones.forEach(s => {
      ctx.beginPath();
      ctx.ellipse(s.x, s.y + 2, s.r + 2, s.r * 0.7 + 2, 0.2, 0, Math.PI * 2);
      ctx.fillStyle = 'rgba(70, 130, 40, 0.25)';
      ctx.fill();

      ctx.beginPath();
      ctx.ellipse(s.x, s.y, s.r, s.r * 0.7, 0.2, 0, Math.PI * 2);
      ctx.fillStyle = '#F4EAD4';
      ctx.fill();
      ctx.strokeStyle = '#D8C3A5';
      ctx.lineWidth = 2;
      ctx.stroke();

      // Stone highlight
      ctx.beginPath();
      ctx.ellipse(s.x - 3, s.y - 2, s.r * 0.4, s.r * 0.25, 0.2, 0, Math.PI * 2);
      ctx.fillStyle = 'rgba(255, 255, 255, 0.5)';
      ctx.fill();
    });

    // 3. Adorable Wildflowers & Clover Tufts across the meadow
    const flowers = [
      { x: 80, y: 120, type: 'daisy' }, { x: 160, y: 80, type: 'pink' },
      { x: 220, y: 530, type: 'clover' }, { x: 360, y: 80, type: 'daisy' },
      { x: 480, y: 170, type: 'blue' }, { x: 540, y: 490, type: 'pink' },
      { x: 670, y: 240, type: 'clover' }, { x: 740, y: 390, type: 'daisy' },
      { x: 750, y: 80, type: 'pink' }, { x: 430, y: 540, type: 'daisy' },
      { x: 120, y: 240, type: 'clover' }, { x: 620, y: 550, type: 'blue' }
    ];

    flowers.forEach(f => {
      if (f.type === 'clover') {
        // Little 3-leaf clover
        ctx.fillStyle = '#40916C';
        for (let a = 0; a < 3; a++) {
          const ang = a * (Math.PI * 2 / 3) - Math.PI / 2;
          ctx.beginPath();
          ctx.arc(f.x + Math.cos(ang) * 4, f.y + Math.sin(ang) * 4, 3.5, 0, Math.PI * 2);
          ctx.fill();
        }
      } else {
        // Cute 5-petal flower
        const petalColor = f.type === 'pink' ? '#FFB5A7' : (f.type === 'blue' ? '#A2D2FF' : '#FFFFFF');
        ctx.fillStyle = petalColor;
        for (let a = 0; a < 5; a++) {
          const ang = a * (Math.PI * 2 / 5);
          ctx.beginPath();
          ctx.arc(f.x + Math.cos(ang) * 4.5, f.y + Math.sin(ang) * 4.5, 3.2, 0, Math.PI * 2);
          ctx.fill();
        }
        // Center
        ctx.beginPath();
        ctx.arc(f.x, f.y, 2.5, 0, Math.PI * 2);
        ctx.fillStyle = '#FFD166';
        ctx.fill();
      }
    });
  }

  // Draw Safe Base (Cozy Golden Nest & Incubator)
  drawBase(base, totalHatched, totalEggs, gameTime) {
    const ctx = this.ctx;
    const x = base.x;
    const y = base.y;
    const r = base.radius;

    ctx.save();
    // Drop shadow
    ctx.beginPath();
    ctx.arc(x, y + 6, r + 6, 0, Math.PI * 2);
    ctx.fillStyle = 'rgba(30, 70, 20, 0.25)';
    ctx.fill();

    // Outer Straw Nest Weave Ring
    ctx.beginPath();
    ctx.arc(x, y, r + 4, 0, Math.PI * 2);
    ctx.fillStyle = '#D4A373';
    ctx.fill();
    ctx.strokeStyle = '#B07D48';
    ctx.lineWidth = 8;
    ctx.stroke();

    // Cozy Cushion Weave inside Nest
    ctx.beginPath();
    ctx.arc(x, y, r - 4, 0, Math.PI * 2);
    ctx.fillStyle = '#FFF3CD';
    ctx.fill();

    // Straw twig lattice lines
    ctx.strokeStyle = 'rgba(180, 130, 70, 0.35)';
    ctx.lineWidth = 2.5;
    for (let i = -r + 12; i < r - 12; i += 11) {
      const span = Math.sqrt(Math.max(0, (r - 8) ** 2 - i ** 2));
      ctx.beginPath();
      ctx.moveTo(x - span, y + i);
      ctx.lineTo(x + span, y + i);
      ctx.stroke();
    }

    // Warm golden incubation glow rim
    const pulse = 0.5 + 0.5 * Math.sin(gameTime * 3);
    ctx.beginPath();
    ctx.arc(x, y, r + 4, 0, Math.PI * 2);
    ctx.strokeStyle = `rgba(255, 179, 0, ${0.45 + pulse * 0.40})`;
    ctx.lineWidth = 4;
    ctx.stroke();

    // Badge Label
    ctx.fillStyle = '#6D4C41';
    ctx.font = 'bold 12px "Fredoka", sans-serif';
    ctx.textAlign = 'center';
    ctx.fillText(`🪺 아지트 둥지 (Cozy Nest) · 🐣 ${totalHatched}/${totalEggs}`, x, y + r + 20);

    // Steam & warm sparkle particles
    if (Math.random() < 0.2) {
      this.addParticle({
        x: x + (Math.random() - 0.5) * (r * 1.2),
        y: y + (Math.random() - 0.5) * (r * 1.2),
        vx: (Math.random() - 0.5) * 12,
        vy: -28 - Math.random() * 22,
        size: 5 + Math.random() * 6,
        sizeChange: 3,
        color: 'rgba(255, 255, 255, 0.45)',
        life: 1.5,
        maxLife: 1.5,
        type: 'steam'
      });
    }

    ctx.restore();
  }

  // Draw cute 2D garden obstacles (Tree Stumps, Mushroom Tables, Planters, Honey Pots)
  drawObstacle(obs) {
    const ctx = this.ctx;
    ctx.save();

    // Soft garden drop shadow
    ctx.fillStyle = 'rgba(40, 90, 30, 0.22)';
    this.roundRect(ctx, obs.x + 4, obs.y + 8, obs.w, obs.h, 14);
    ctx.fill();

    if (obs.type === 'mushroom') {
      // 🍄 Cute Red Polka-dot Mushroom Table
      // Stem
      ctx.fillStyle = '#FDF0D5';
      this.roundRect(ctx, obs.x + obs.w * 0.3, obs.y + obs.h * 0.4, obs.w * 0.4, obs.h * 0.6, 8);
      ctx.fill();
      ctx.strokeStyle = '#DDA15E';
      ctx.lineWidth = 2;
      ctx.stroke();

      // Red Cap
      ctx.beginPath();
      ctx.arc(obs.x + obs.w / 2, obs.y + obs.h * 0.45, obs.w * 0.52, Math.PI, 0);
      ctx.closePath();
      ctx.fillStyle = '#E63946';
      ctx.fill();
      ctx.strokeStyle = '#9D0208';
      ctx.lineWidth = 3;
      ctx.stroke();

      // White Polka Dots
      ctx.fillStyle = '#FFFFFF';
      ctx.beginPath();
      ctx.arc(obs.x + obs.w / 2, obs.y + obs.h * 0.22, 6, 0, Math.PI * 2);
      ctx.arc(obs.x + obs.w * 0.26, obs.y + obs.h * 0.35, 4.5, 0, Math.PI * 2);
      ctx.arc(obs.x + obs.w * 0.74, obs.y + obs.h * 0.35, 4.5, 0, Math.PI * 2);
      ctx.fill();
    } else if (obs.type === 'planter' || obs.type === 'cutting_board') {
      // 🌷 Cute Wooden Flower Planter Box
      ctx.fillStyle = '#B07D62';
      this.roundRect(ctx, obs.x, obs.y + 12, obs.w, obs.h - 12, 8);
      ctx.fill();
      ctx.strokeStyle = '#6F4E37';
      ctx.lineWidth = 2.5;
      ctx.stroke();

      // Wooden planks line
      ctx.strokeStyle = 'rgba(255, 255, 255, 0.25)';
      ctx.lineWidth = 2;
      ctx.strokeRect(obs.x + 4, obs.y + 16, obs.w - 8, 4);

      // Blooming Flowers & Leaves
      const numFlowers = Math.max(2, Math.floor(obs.w / 28));
      for (let i = 0; i < numFlowers; i++) {
        const fx = obs.x + 16 + i * 26;
        const fy = obs.y + 10;
        // Green leaves
        ctx.fillStyle = '#52B788';
        ctx.beginPath();
        ctx.ellipse(fx - 4, fy + 2, 6, 3, -0.4, 0, Math.PI * 2);
        ctx.ellipse(fx + 4, fy + 2, 6, 3, 0.4, 0, Math.PI * 2);
        ctx.fill();

        // Flower Blossom
        const colors = ['#FF4D6D', '#FFB703', '#9D4EDD', '#4CC9F0'];
        ctx.fillStyle = colors[i % colors.length];
        ctx.beginPath();
        ctx.arc(fx, fy - 2, 7, 0, Math.PI * 2);
        ctx.fill();
        ctx.fillStyle = '#FFF';
        ctx.beginPath();
        ctx.arc(fx, fy - 2, 2.5, 0, Math.PI * 2);
        ctx.fill();
      }
    } else if (obs.type === 'honey_pot' || obs.type === 'teacup') {
      // 🍯 Cute Golden Clay Honey Pot
      const cx = obs.x + obs.w / 2;
      const cy = obs.y + obs.h / 2;
      ctx.beginPath();
      ctx.arc(cx, cy, obs.w / 2 - 2, 0, Math.PI * 2);
      ctx.fillStyle = '#E76F51';
      ctx.fill();
      ctx.strokeStyle = '#9C412C';
      ctx.lineWidth = 2.5;
      ctx.stroke();

      // Honey dripping
      ctx.beginPath();
      ctx.arc(cx, cy - 4, obs.w / 2 - 5, 0, Math.PI * 2);
      ctx.fillStyle = '#FFB703';
      ctx.fill();

      // Cute Little Bee
      ctx.fillStyle = '#FFD166';
      ctx.beginPath();
      ctx.ellipse(cx + 8, cy - 14, 5, 3.5, 0.2, 0, Math.PI * 2);
      ctx.fill();
      ctx.fillStyle = '#000';
      ctx.fillRect(cx + 7, cy - 17, 1.5, 6);
    } else {
      // 🪵 Woody Tree Stump with Growth Rings & Moss
      ctx.fillStyle = '#8B5A2B';
      this.roundRect(ctx, obs.x, obs.y, obs.w, obs.h, 12);
      ctx.fill();
      ctx.strokeStyle = '#5C3A1E';
      ctx.lineWidth = 3;
      ctx.stroke();

      // Top wood cut surface
      ctx.fillStyle = '#D4A373';
      this.roundRect(ctx, obs.x + 4, obs.y + 4, obs.w - 8, obs.h - 8, 8);
      ctx.fill();

      // Growth Rings
      ctx.strokeStyle = 'rgba(140, 90, 50, 0.45)';
      ctx.lineWidth = 1.8;
      ctx.beginPath();
      ctx.ellipse(obs.x + obs.w / 2, obs.y + obs.h / 2, obs.w * 0.32, obs.h * 0.28, 0, 0, Math.PI * 2);
      ctx.stroke();
      ctx.beginPath();
      ctx.ellipse(obs.x + obs.w / 2, obs.y + obs.h / 2, obs.w * 0.16, obs.h * 0.14, 0, 0, Math.PI * 2);
      ctx.stroke();

      // Cute little green sprout leaf
      ctx.fillStyle = '#70E000';
      ctx.beginPath();
      ctx.ellipse(obs.x + 16, obs.y + 6, 6, 3, -0.6, 0, Math.PI * 2);
      ctx.fill();
    }

    ctx.restore();
  }

  // Draw Bunny Guard Lantern Light Beam
  drawNPCVisionCone(npc) {
    const ctx = this.ctx;
    ctx.save();
    ctx.translate(npc.x, npc.y);

    const coneAngle = npc.visionAngle || Math.PI / 3;
    const coneDist = npc.visionDistance || 145;
    const facing = npc.facingAngle || 0;

    // Glowing warm lantern cone gradient
    const grad = ctx.createRadialGradient(0, 0, 8, 0, 0, coneDist);
    if (npc.isAlerted) {
      grad.addColorStop(0, 'rgba(255, 77, 109, 0.65)');
      grad.addColorStop(0.7, 'rgba(255, 77, 109, 0.35)');
      grad.addColorStop(1, 'rgba(255, 77, 109, 0.02)');
      ctx.strokeStyle = 'rgba(255, 77, 109, 0.85)';
    } else {
      grad.addColorStop(0, 'rgba(255, 230, 109, 0.55)');
      grad.addColorStop(0.7, 'rgba(255, 215, 0, 0.25)');
      grad.addColorStop(1, 'rgba(255, 215, 0, 0.01)');
      ctx.strokeStyle = 'rgba(255, 215, 0, 0.7)';
    }

    ctx.beginPath();
    ctx.moveTo(0, 0);
    ctx.arc(0, 0, coneDist, facing - coneAngle / 2, facing + coneAngle / 2);
    ctx.closePath();
    ctx.fillStyle = grad;
    ctx.fill();
    ctx.lineWidth = 2;
    if (typeof ctx.setLineDash === 'function') ctx.setLineDash([6, 6]);
    ctx.stroke();
    if (typeof ctx.setLineDash === 'function') ctx.setLineDash([]);

    ctx.restore();
  }

  // Draw Squishy Egg (Field, on Player's Head, or Incubating/Cracking in Nest)
  drawEgg(egg, player, gameTime) {
    const ctx = this.ctx;

    // If already hatched, draw cute cracked eggshell pieces in the nest
    if (egg.isHatched) {
      ctx.save();
      ctx.translate(egg.x, egg.y);
      // Small ground shadow
      ctx.beginPath();
      ctx.ellipse(0, 10, 14, 5, 0, 0, Math.PI * 2);
      ctx.fillStyle = 'rgba(0, 0, 0, 0.08)';
      ctx.fill();

      // Cute cracked lower shell cup
      ctx.beginPath();
      ctx.moveTo(-14, 0);
      ctx.lineTo(-8, 6);
      ctx.lineTo(-2, 0);
      ctx.lineTo(4, 7);
      ctx.lineTo(10, 1);
      ctx.lineTo(14, 6);
      ctx.bezierCurveTo(14, 16, -14, 16, -14, 0);
      ctx.closePath();
      ctx.fillStyle = egg.colors ? egg.colors.bottom : '#FFCAD4';
      ctx.fill();
      ctx.strokeStyle = egg.colors ? egg.colors.border : '#E05780';
      ctx.lineWidth = 2;
      ctx.stroke();

      // Cute heart sparkle floating
      if (Math.random() < 0.04) {
        this.addParticle({
          x: egg.x + (Math.random() - 0.5) * 16,
          y: egg.y - 12,
          vx: (Math.random() - 0.5) * 16,
          vy: -25 - Math.random() * 20,
          size: 7,
          color: '#FF6584',
          life: 1.0,
          maxLife: 1.0,
          type: 'heart'
        });
      }
      ctx.restore();
      return;
    }

    // Position: if carried, sits atop player's head!
    let renderX = egg.x;
    let renderY = egg.y;
    if (egg.isCarried && player) {
      renderX = player.x;
      renderY = player.y - 38 + Math.sin(gameTime * 14) * 3;
    }

    const breathe = this.animator.getBreatheDeformation(gameTime + egg.timeOffset, 1.4, 0.16);
    const springVal = egg.spring ? egg.spring.value : 0;
    const sx = breathe.sx * (1 + springVal * 0.04);
    const sy = breathe.sy * (1 - springVal * 0.04);
    const pulse = (breathe.waveVal + 1) * 0.5;

    ctx.save();
    ctx.translate(renderX, renderY);

    // 1. Ground shadow & breathing aura (only when on ground/nest)
    if (!egg.isCarried) {
      ctx.beginPath();
      ctx.ellipse(0, 16, 18 * sx, 7, 0, 0, Math.PI * 2);
      ctx.fillStyle = 'rgba(0, 0, 0, 0.14)';
      ctx.fill();

      // Magical glowing ring
      ctx.beginPath();
      ctx.arc(0, 4, 24 + pulse * 6, 0, Math.PI * 2);
      ctx.fillStyle = egg.glowColor || 'rgba(255, 230, 160, 0.18)';
      ctx.fill();
    }

    // 2. Wobble rotation (intense when incubating & cracking!)
    let wobble = Math.sin(gameTime * 8) * 0.05;
    if (egg.isHatching) {
      const progress = 1 - Math.max(0, egg.hatchTimer / egg.hatchDuration);
      wobble = Math.sin(gameTime * 26) * (0.08 + progress * 0.28);
    } else if (egg.isCarried) {
      wobble = Math.sin(gameTime * 12) * 0.12;
    }
    ctx.rotate(wobble);
    ctx.scale(sx, sy);

    // 3. Egg Shell Geometry (Cute, plump egg with tapered top and wide bottom)
    ctx.beginPath();
    ctx.moveTo(0, -28);
    ctx.bezierCurveTo(19, -28, 24, -6, 24, 16);
    ctx.bezierCurveTo(24, 30, -24, 30, -24, 16);
    ctx.bezierCurveTo(-24, -6, -19, -28, 0, -28);
    ctx.closePath();

    // Vibrant gradient fill
    const grad = ctx.createLinearGradient(-12, -28, 14, 30);
    const theme = egg.colors || { top: '#FF6B6B', bottom: '#C9184A', pattern: '#FFE66D', border: '#A0153E' };
    grad.addColorStop(0, theme.top);
    grad.addColorStop(1, theme.bottom);
    ctx.fillStyle = grad;
    ctx.fill();

    // Shell border
    ctx.strokeStyle = theme.border;
    ctx.lineWidth = 2.8;
    ctx.stroke();

    // 4. Pattern Spots & Dinosaur/Fantasy Egg Ornaments
    ctx.save();
    ctx.clip(); // Clip decorative spots inside egg boundary

    ctx.fillStyle = theme.pattern;
    ctx.beginPath();
    ctx.arc(-7, -8, 6, 0, Math.PI * 2);
    ctx.arc(8, 4, 7, 0, Math.PI * 2);
    ctx.arc(-9, 15, 5, 0, Math.PI * 2);
    ctx.arc(7, -18, 4, 0, Math.PI * 2);
    ctx.fill();

    // Rainbow wave stripe if rainbow type
    if (egg.type === 'rainbow') {
      ctx.strokeStyle = 'rgba(255, 255, 255, 0.75)';
      ctx.lineWidth = 5;
      ctx.beginPath();
      ctx.moveTo(-24, 2);
      ctx.bezierCurveTo(-10, 10, 10, 10, 24, 2);
      ctx.stroke();
    }

    // 5. Glossy 3D Highlight
    ctx.beginPath();
    ctx.ellipse(-7, -14, 5, 9, -Math.PI / 6, 0, Math.PI * 2);
    ctx.fillStyle = 'rgba(255, 255, 255, 0.6)';
    ctx.fill();

    ctx.restore();

    // 6. Cracking Lines when incubating in nest!
    if (egg.isHatching && egg.cracks > 0) {
      ctx.strokeStyle = '#2B040C';
      ctx.lineWidth = 2.4;
      ctx.lineCap = 'round';
      ctx.beginPath();
      // Crack 1
      ctx.moveTo(-5, -16);
      ctx.lineTo(-1, -8);
      ctx.lineTo(-7, -2);
      ctx.lineTo(-2, 6);
      if (egg.cracks >= 2) {
        ctx.lineTo(5, 11);
        ctx.lineTo(1, 18);
      }
      if (egg.cracks >= 3) {
        ctx.moveTo(4, -12);
        ctx.lineTo(10, -5);
        ctx.lineTo(6, 3);
      }
      ctx.stroke();
    }

    ctx.restore(); // restore transform

    // 7. Incubating Countdown Badge or Field Name Label
    ctx.save();
    ctx.translate(renderX, renderY);
    if (egg.isHatching) {
      const timerStr = Math.max(0, egg.hatchTimer).toFixed(1);
      ctx.fillStyle = 'rgba(255, 255, 255, 0.95)';
      this.roundRect(ctx, -42, -52, 84, 24, 12);
      ctx.fill();
      ctx.strokeStyle = '#FF8A80';
      ctx.lineWidth = 2;
      ctx.stroke();

      ctx.fillStyle = '#D81B60';
      ctx.font = 'bold 12px "Fredoka", sans-serif';
      ctx.textAlign = 'center';
      ctx.fillText(`🐣 부화 ${timerStr}s`, 0, -36);

      // Mini incubation progress bar
      const progress = 1 - Math.max(0, egg.hatchTimer / egg.hatchDuration);
      ctx.fillStyle = '#E0E0E0';
      ctx.fillRect(-32, -30, 64, 4);
      ctx.fillStyle = '#00E676';
      ctx.fillRect(-32, -30, 64 * progress, 4);
    } else if (!egg.isCarried) {
      // Readable rounded badge
      ctx.fillStyle = 'rgba(255, 255, 255, 0.92)';
      this.roundRect(ctx, -40, 36, 80, 22, 11);
      ctx.fill();
      ctx.strokeStyle = '#E2B880';
      ctx.lineWidth = 1.5;
      ctx.stroke();

      ctx.fillStyle = '#4A3B32';
      ctx.font = 'bold 11px "Fredoka", sans-serif';
      ctx.textAlign = 'center';
      ctx.fillText(`🥚 ${egg.name}`, 0, 51);
    }
    ctx.restore();
  }

  // Draw Super Cute Baby Creature (Chick, Dragon, Dino, Fairy, Penguin)
  drawBabyCreature(egg, gameTime) {
    const baby = egg.baby;
    if (!baby) return;

    const ctx = this.ctx;
    const time = gameTime + (egg.id * 1.3);
    const breathe = this.animator.getBreatheDeformation(time, 1.6, 0.12);

    // Movement & hop animation
    const isMoving = baby.pauseTimer <= 0;
    const hopY = isMoving ? -Math.abs(Math.sin(time * 9)) * 9 : -Math.abs(Math.sin(time * 3)) * 2;
    const waddleTilt = isMoving ? Math.sin(time * 12) * 0.12 : 0;
    const facingLeft = Math.cos(baby.wanderAngle) < 0;

    // Blinking eye timer (blinks every ~3.5s for 0.15s)
    const blinkCycle = (time * 0.5) % 3.5;
    const isBlinking = blinkCycle < 0.15;

    ctx.save();
    ctx.translate(baby.x, baby.y + hopY);
    if (facingLeft) ctx.scale(-1, 1);
    ctx.rotate(waddleTilt);
    ctx.scale(breathe.sx, breathe.sy);

    // 1. Soft ground shadow
    ctx.save();
    ctx.translate(0, -hopY);
    ctx.beginPath();
    const shadowScale = 1 - Math.min(0.5, Math.abs(hopY) / 18);
    ctx.ellipse(0, 16, 14 * shadowScale, 6 * shadowScale, 0, 0, Math.PI * 2);
    ctx.fillStyle = 'rgba(0, 0, 0, 0.15)';
    ctx.fill();
    ctx.restore();

    // 2. Baby Character Body Theme by Egg Type
    const type = egg.type || 'gold';
    let bodyColor = '#FFDE59'; // Chick yellow
    let bellyColor = '#FFF5B8';
    let cheekColor = '#FF9AA2';
    let eyeColor = '#2B1B17';
    let detailColor = '#FF8C00';

    if (type === 'ruby') {
      bodyColor = '#FF758F'; // Baby Dragon pink
      bellyColor = '#FFE3E8';
      detailColor = '#C9184A';
    } else if (type === 'emerald') {
      bodyColor = '#70E000'; // Baby Dino mint green
      bellyColor = '#D8F3DC';
      detailColor = '#38B000';
    } else if (type === 'rainbow') {
      bodyColor = '#D0BCFF'; // Fairy baby lavender
      bellyColor = '#F3E8FF';
      detailColor = '#9747FF';
    } else if (type === 'star') {
      bodyColor = '#72EFDD'; // Star penguin teal
      bellyColor = '#FFFFFF';
      detailColor = '#0096C7';
    }

    // 3. Tiny Feet / Waddling Paws
    const leftFootY = isMoving ? Math.sin(time * 18) * 3 : 0;
    const rightFootY = isMoving ? -Math.sin(time * 18) * 3 : 0;
    ctx.fillStyle = type === 'ruby' || type === 'emerald' ? detailColor : '#FF9F1C';
    ctx.beginPath();
    ctx.ellipse(-6, 14 + leftFootY, 4, 3, 0, 0, Math.PI * 2);
    ctx.fill();
    ctx.beginPath();
    ctx.ellipse(6, 14 + rightFootY, 4, 3, 0, 0, Math.PI * 2);
    ctx.fill();

    // 4. Baby Creature Tail (Dragon or Dino)
    if (type === 'ruby' || type === 'emerald') {
      ctx.beginPath();
      ctx.moveTo(-10, 8);
      ctx.quadraticCurveTo(-18, 12 + Math.sin(time * 8) * 3, -16, 2);
      ctx.quadraticCurveTo(-10, 2, -6, 5);
      ctx.fillStyle = bodyColor;
      ctx.fill();
    }

    // 5. Chubby Fluffy Round Body
    ctx.beginPath();
    ctx.arc(0, 0, 16, 0, Math.PI * 2);
    ctx.fillStyle = bodyColor;
    ctx.fill();
    ctx.strokeStyle = detailColor;
    ctx.lineWidth = 1.8;
    ctx.stroke();

    // 6. Cute Tummy Cushion
    ctx.beginPath();
    ctx.ellipse(0, 4, 11, 10, 0, 0, Math.PI * 2);
    ctx.fillStyle = bellyColor;
    ctx.fill();

    // 7. Tiny Flapping Baby Wings / Arms
    const wingAngle = Math.sin(time * 16) * 0.45;
    ctx.save();
    ctx.translate(11, 2);
    ctx.rotate(wingAngle);
    ctx.beginPath();
    ctx.ellipse(4, 0, 6, 4, Math.PI / 6, 0, Math.PI * 2);
    ctx.fillStyle = bodyColor;
    ctx.fill();
    ctx.strokeStyle = detailColor;
    ctx.lineWidth = 1.4;
    ctx.stroke();
    ctx.restore();

    ctx.save();
    ctx.translate(-11, 2);
    ctx.rotate(-wingAngle);
    ctx.beginPath();
    ctx.ellipse(-4, 0, 6, 4, -Math.PI / 6, 0, Math.PI * 2);
    ctx.fillStyle = bodyColor;
    ctx.fill();
    ctx.strokeStyle = detailColor;
    ctx.lineWidth = 1.4;
    ctx.stroke();
    ctx.restore();

    // 8. Baby Eyes: Big, Sparkly Anime Eyes!
    if (isBlinking) {
      ctx.strokeStyle = eyeColor;
      ctx.lineWidth = 2.2;
      ctx.lineCap = 'round';
      ctx.beginPath();
      ctx.arc(-5, -2, 3.5, Math.PI, 0);
      ctx.stroke();
      ctx.beginPath();
      ctx.arc(5, -2, 3.5, Math.PI, 0);
      ctx.stroke();
    } else {
      // Big round baby eyes with sparkle highlights
      ctx.beginPath();
      ctx.ellipse(-5, -2, 3.5, 4.5, 0, 0, Math.PI * 2);
      ctx.fillStyle = eyeColor;
      ctx.fill();
      ctx.beginPath();
      ctx.arc(-6, -4, 1.6, 0, Math.PI * 2);
      ctx.fillStyle = '#FFFFFF';
      ctx.fill();
      ctx.beginPath();
      ctx.arc(-4, -1, 0.8, 0, Math.PI * 2);
      ctx.fill();

      ctx.beginPath();
      ctx.ellipse(5, -2, 3.5, 4.5, 0, 0, Math.PI * 2);
      ctx.fillStyle = eyeColor;
      ctx.fill();
      ctx.beginPath();
      ctx.arc(4, -4, 1.6, 0, Math.PI * 2);
      ctx.fillStyle = '#FFFFFF';
      ctx.fill();
      ctx.beginPath();
      ctx.arc(6, -1, 0.8, 0, Math.PI * 2);
      ctx.fill();
    }

    // 9. Rosy Blushing Cheeks
    ctx.beginPath();
    ctx.ellipse(-9, 3, 3, 2, 0, 0, Math.PI * 2);
    ctx.fillStyle = cheekColor;
    ctx.fill();
    ctx.beginPath();
    ctx.ellipse(9, 3, 3, 2, 0, 0, Math.PI * 2);
    ctx.fill();

    // 10. Cute Mouth / Beak
    if (type === 'gold' || type === 'star') {
      ctx.beginPath();
      ctx.moveTo(-3, 0);
      ctx.lineTo(0, 4);
      ctx.lineTo(3, 0);
      ctx.closePath();
      ctx.fillStyle = '#FF6B00';
      ctx.fill();
    } else {
      // Cute smile
      ctx.strokeStyle = '#2B1B17';
      ctx.lineWidth = 1.6;
      ctx.lineCap = 'round';
      ctx.beginPath();
      ctx.arc(-2, 3, 2.2, 0, Math.PI);
      ctx.stroke();
      ctx.beginPath();
      ctx.arc(2, 3, 2.2, 0, Math.PI);
      ctx.stroke();
    }

    // 11. Baby Dragon Horns (for ruby)
    if (type === 'ruby') {
      ctx.fillStyle = '#FFE66D';
      ctx.beginPath();
      ctx.moveTo(-7, -13);
      ctx.lineTo(-10, -20);
      ctx.lineTo(-4, -15);
      ctx.closePath();
      ctx.fill();
      ctx.beginPath();
      ctx.moveTo(7, -13);
      ctx.lineTo(10, -20);
      ctx.lineTo(4, -15);
      ctx.closePath();
      ctx.fill();
    }

    // 12. Adorable Cracked Eggshell Hat (Wearing top shell of its egg!)
    const hatTilt = Math.sin(time * 6) * 0.08;
    ctx.save();
    ctx.translate(0, -12);
    ctx.rotate(hatTilt);

    ctx.beginPath();
    ctx.moveTo(-11, 2);
    ctx.lineTo(-7, -2);
    ctx.lineTo(-3, 2);
    ctx.lineTo(1, -2);
    ctx.lineTo(5, 2);
    ctx.lineTo(9, -1);
    ctx.lineTo(11, 2);
    ctx.bezierCurveTo(12, -14, -12, -14, -11, 2);
    ctx.closePath();

    const eggColors = egg.colors || { top: '#FFE066', bottom: '#F77F00', border: '#D47A00' };
    ctx.fillStyle = eggColors.top;
    ctx.fill();
    ctx.strokeStyle = eggColors.border;
    ctx.lineWidth = 1.8;
    ctx.stroke();

    ctx.beginPath();
    ctx.ellipse(-3, -7, 2, 4, -Math.PI / 4, 0, Math.PI * 2);
    ctx.fillStyle = 'rgba(255, 255, 255, 0.65)';
    ctx.fill();

    ctx.restore();

    ctx.restore(); // restore transform

    // 13. Baby Name Label
    ctx.save();
    ctx.translate(baby.x, baby.y + hopY);
    ctx.fillStyle = '#D81B60';
    ctx.font = 'bold 10px "Fredoka", sans-serif';
    ctx.textAlign = 'center';
    const babyName = type === 'gold' ? '🐣 삐약이' : (type === 'ruby' ? '🐲 루비뇽' : (type === 'emerald' ? '🐢 롱이' : (type === 'rainbow' ? '🦄 포포' : '🐧 핑구')));
    ctx.fillText(babyName, 0, -26);
    ctx.restore();
  }

  // Draw real-time sprite-gen wave monitor on canvas
  drawBreatheMonitor(gameTime) {
    const ctx = this.ctx;
    const x = this.canvas.width - 180;
    const y = 14;
    const w = 168;
    const h = 60;

    ctx.save();
    ctx.fillStyle = 'rgba(255, 253, 245, 0.9)';
    this.roundRect(ctx, x, y, w, h, 12);
    ctx.fill();
    ctx.strokeStyle = '#E2B880';
    ctx.lineWidth = 1.5;
    ctx.stroke();

    ctx.fillStyle = '#C05621';
    ctx.font = 'bold 10px "Fredoka", sans-serif';
    ctx.fillText('⚡ sprite-gen wave(t)', x + 8, y + 14);

    const breathe = this.animator.getBreatheDeformation(gameTime, 1.4, 0.16);
    const sxStr = breathe.sx.toFixed(2);
    const syStr = breathe.sy.toFixed(2);

    const waveX = x + 8;
    const waveY = y + 28;
    const waveW = 75;
    const waveH = 18;

    ctx.beginPath();
    ctx.strokeStyle = '#ED8936';
    ctx.lineWidth = 2;
    for (let px = 0; px <= waveW; px += 2) {
      const t = (px / waveW) + (gameTime * 0.8);
      const val = this.animator.getWave(t % 1.0);
      const py = waveY + waveH / 2 - (val * (waveH * 0.45));
      if (px === 0) ctx.moveTo(waveX + px, py);
      else ctx.lineTo(waveX + px, py);
    }
    ctx.stroke();

    const currentDotX = waveX + ((breathe.cycle * waveW) % waveW);
    const currentDotY = waveY + waveH / 2 - (breathe.waveVal * (waveH * 0.45));
    ctx.beginPath();
    ctx.arc(currentDotX, currentDotY, 3.5, 0, Math.PI * 2);
    ctx.fillStyle = '#C53030';
    ctx.fill();

    ctx.fillStyle = '#4A3B32';
    ctx.font = 'bold 10px "Fredoka", sans-serif';
    ctx.fillText(`sx: ${sxStr}x`, x + 92, y + 28);
    ctx.fillText(`sy: ${syStr}x`, x + 92, y + 42);

    ctx.restore();
  }

  // ── 2D Sprite Layer Synchronizer ──────────────────────────────────────────

  getOrCreateSprite(id, src) {
    if (!this.spriteLayer) return null;
    let img = this.domSprites.get(id);
    if (!img) {
      img = document.createElement('img');
      img.className = 'game-sprite';
      img.src = src;
      this.spriteLayer.appendChild(img);
      this.domSprites.set(id, img);
    }
    return img;
  }

  clearDOMSprites() {
    if (this.spriteLayer) {
      this.spriteLayer.innerHTML = '';
    }
    this.domSprites.clear();
  }

  /**
   * Synchronizes 2D animated sprites (all characters rendered natively on Canvas 2D).
   */
  syncDOMSprites(player, eggsList, npcs, gameTime) {
    if (this.spriteLayer && this.spriteLayer.innerHTML !== '') {
      this.spriteLayer.innerHTML = '';
    }
  }

  // Draw Super Cute 2D Fox Hero (Player)
  drawFoxPlayer(player, gameTime) {
    const ctx = this.ctx;
    const isMoving = player.speed > 5;
    const runCycle = player.walkDistance * 0.16;
    const bobY = isMoving ? -Math.abs(Math.sin(runCycle)) * 7 : Math.sin(gameTime * 2.5) * 1.5;
    const tilt = isMoving ? Math.sin(runCycle) * 0.08 : 0;
    const facingLeft = player.facing === 'left';
    const breathe = this.animator.getBreatheDeformation(gameTime, 1.4, 0.08);

    // Blinking eye timer
    const blinkCycle = (gameTime * 0.6) % 3.5;
    const isBlinking = blinkCycle < 0.14;

    ctx.save();
    ctx.translate(player.x, player.y + bobY);
    if (facingLeft) ctx.scale(-1, 1);
    ctx.rotate(player.isCaught ? player.dizzyAngle : tilt);
    ctx.scale(breathe.sx, breathe.sy);

    // 1. Soft ground shadow
    ctx.save();
    ctx.translate(0, -bobY);
    ctx.beginPath();
    ctx.ellipse(0, 18, 16, 7, 0, 0, Math.PI * 2);
    ctx.fillStyle = 'rgba(30, 70, 20, 0.22)';
    ctx.fill();
    ctx.restore();

    // 2. Giant Bushy Fox Tail with White Tip
    const tailSway = isMoving ? Math.sin(runCycle * 1.2) * 0.38 - 0.2 : Math.sin(gameTime * 3) * 0.15 - 0.15;
    ctx.save();
    ctx.translate(-10, 2);
    ctx.rotate(tailSway);

    // Main orange tail
    ctx.beginPath();
    ctx.moveTo(0, 0);
    ctx.bezierCurveTo(-12, -8, -26, 4, -28, 14);
    ctx.bezierCurveTo(-26, 26, -10, 24, 0, 10);
    ctx.closePath();
    ctx.fillStyle = '#FF7A18';
    ctx.fill();
    ctx.strokeStyle = '#D95800';
    ctx.lineWidth = 1.8;
    ctx.stroke();

    // Fluffy white tip of tail
    ctx.beginPath();
    ctx.moveTo(-20, 8);
    ctx.bezierCurveTo(-26, 4, -28, 14, -22, 22);
    ctx.bezierCurveTo(-18, 18, -16, 12, -20, 8);
    ctx.closePath();
    ctx.fillStyle = '#FFFFFF';
    ctx.fill();
    ctx.restore();

    // 3. Cute Fox Feet taking steps
    const lFootY = isMoving ? Math.sin(runCycle * 2) * 4 : 0;
    const rFootY = isMoving ? -Math.sin(runCycle * 2) * 4 : 0;
    ctx.fillStyle = '#4A2810';
    ctx.beginPath();
    ctx.ellipse(-6, 16 + lFootY, 4.5, 3, 0, 0, Math.PI * 2);
    ctx.fill();
    ctx.beginPath();
    ctx.ellipse(6, 16 + rFootY, 4.5, 3, 0, 0, Math.PI * 2);
    ctx.fill();

    // 4. Round Fluffy Fox Body
    ctx.beginPath();
    ctx.arc(0, 2, 17, 0, Math.PI * 2);
    ctx.fillStyle = '#FF7A18';
    ctx.fill();
    ctx.strokeStyle = '#D95800';
    ctx.lineWidth = 2;
    ctx.stroke();

    // White Chest Bib
    ctx.beginPath();
    ctx.ellipse(0, 6, 11, 9, 0, 0, Math.PI * 2);
    ctx.fillStyle = '#FFFDF5';
    ctx.fill();

    // 5. Fox Head with Fluffy Cheek Tufts
    ctx.beginPath();
    ctx.arc(0, -6, 16, 0, Math.PI * 2);
    ctx.fillStyle = '#FF8C2B';
    ctx.fill();
    ctx.strokeStyle = '#D95800';
    ctx.lineWidth = 2;
    ctx.stroke();

    // White cheek tufts
    ctx.fillStyle = '#FFFDF5';
    ctx.beginPath();
    ctx.moveTo(-16, -4);
    ctx.lineTo(-22, -1);
    ctx.lineTo(-15, 6);
    ctx.closePath();
    ctx.fill();

    ctx.beginPath();
    ctx.moveTo(16, -4);
    ctx.lineTo(22, -1);
    ctx.lineTo(15, 6);
    ctx.closePath();
    ctx.fill();

    // 6. Pointy Triangular Fox Ears with Pink Interior & Dark Tips
    // Left ear
    ctx.beginPath();
    ctx.moveTo(-12, -16);
    ctx.lineTo(-17, -32);
    ctx.lineTo(-3, -20);
    ctx.closePath();
    ctx.fillStyle = '#FF7A18';
    ctx.fill();
    ctx.strokeStyle = '#D95800';
    ctx.lineWidth = 2;
    ctx.stroke();

    ctx.fillStyle = '#3D1E0B';
    ctx.beginPath();
    ctx.moveTo(-15, -28);
    ctx.lineTo(-17, -32);
    ctx.lineTo(-10, -25);
    ctx.closePath();
    ctx.fill();

    ctx.fillStyle = '#FFCAD4';
    ctx.beginPath();
    ctx.moveTo(-11, -17);
    ctx.lineTo(-14, -27);
    ctx.lineTo(-5, -20);
    ctx.closePath();
    ctx.fill();

    // Right ear
    ctx.beginPath();
    ctx.moveTo(3, -20);
    ctx.lineTo(17, -32);
    ctx.lineTo(12, -16);
    ctx.closePath();
    ctx.fillStyle = '#FF7A18';
    ctx.fill();
    ctx.strokeStyle = '#D95800';
    ctx.lineWidth = 2;
    ctx.stroke();

    ctx.fillStyle = '#3D1E0B';
    ctx.beginPath();
    ctx.moveTo(10, -25);
    ctx.lineTo(17, -32);
    ctx.lineTo(15, -28);
    ctx.closePath();
    ctx.fill();

    ctx.fillStyle = '#FFCAD4';
    ctx.beginPath();
    ctx.moveTo(5, -20);
    ctx.lineTo(14, -27);
    ctx.lineTo(11, -17);
    ctx.closePath();
    ctx.fill();

    // 7. Sparkling Fox Face
    if (player.isCaught) {
      // Dizzy spiral eyes
      ctx.strokeStyle = '#2B1B17';
      ctx.lineWidth = 2;
      ctx.beginPath();
      ctx.arc(-6, -6, 4, 0, Math.PI * 2);
      ctx.moveTo(-6, -6);
      ctx.lineTo(-3, -6);
      ctx.stroke();
      ctx.beginPath();
      ctx.arc(6, -6, 4, 0, Math.PI * 2);
      ctx.moveTo(6, -6);
      ctx.lineTo(9, -6);
      ctx.stroke();
    } else if (isBlinking || player.carriedEgg) {
      // Happy squint eyes: ^ ^
      ctx.strokeStyle = '#2B1B17';
      ctx.lineWidth = 2.4;
      ctx.lineCap = 'round';
      ctx.beginPath();
      ctx.arc(-6, -6, 4, Math.PI, 0);
      ctx.stroke();
      ctx.beginPath();
      ctx.arc(6, -6, 4, Math.PI, 0);
      ctx.stroke();
    } else {
      // Big sparkling anime eyes
      ctx.beginPath();
      ctx.ellipse(-6, -6, 4, 5, 0, 0, Math.PI * 2);
      ctx.fillStyle = '#2B1B17';
      ctx.fill();
      ctx.beginPath();
      ctx.arc(-7, -8, 1.8, 0, Math.PI * 2);
      ctx.fillStyle = '#FFFFFF';
      ctx.fill();
      ctx.beginPath();
      ctx.arc(-5, -4, 0.9, 0, Math.PI * 2);
      ctx.fill();

      ctx.beginPath();
      ctx.ellipse(6, -6, 4, 5, 0, 0, Math.PI * 2);
      ctx.fillStyle = '#2B1B17';
      ctx.fill();
      ctx.beginPath();
      ctx.arc(5, -8, 1.8, 0, Math.PI * 2);
      ctx.fillStyle = '#FFFFFF';
      ctx.fill();
      ctx.beginPath();
      ctx.arc(7, -4, 0.9, 0, Math.PI * 2);
      ctx.fill();
    }

    // Rosy blushing cheeks
    ctx.fillStyle = 'rgba(255, 105, 135, 0.55)';
    ctx.beginPath();
    ctx.ellipse(-10, -1, 3.5, 2.2, 0, 0, Math.PI * 2);
    ctx.fill();
    ctx.beginPath();
    ctx.ellipse(10, -1, 3.5, 2.2, 0, 0, Math.PI * 2);
    ctx.fill();

    // Cute little black button nose
    ctx.fillStyle = '#1A1A1A';
    ctx.beginPath();
    ctx.ellipse(0, -1, 2.4, 1.6, 0, 0, Math.PI * 2);
    ctx.fill();

    // Adorable cat mouth: ω
    ctx.strokeStyle = '#2B1B17';
    ctx.lineWidth = 1.6;
    ctx.lineCap = 'round';
    ctx.beginPath();
    ctx.arc(-2.2, 2.2, 2.2, 0, Math.PI);
    ctx.stroke();
    ctx.beginPath();
    ctx.arc(2.2, 2.2, 2.2, 0, Math.PI);
    ctx.stroke();

    // 8. Front Paws holding egg up if carrying
    if (player.carriedEgg) {
      ctx.fillStyle = '#4A2810';
      ctx.beginPath();
      ctx.ellipse(-8, -14, 4, 3, -0.4, 0, Math.PI * 2);
      ctx.fill();
      ctx.beginPath();
      ctx.ellipse(8, -14, 4, 3, 0.4, 0, Math.PI * 2);
      ctx.fill();
    }

    ctx.restore();
  }

  // Draw Super Cute Bunny Guard (Chaser NPC)
  drawBunnyNPC(npc, gameTime) {
    const ctx = this.ctx;
    const facingLeft = Math.cos(npc.facingAngle) < 0;
    const hopCycle = npc.walkDistance * 0.14;
    const hopY = -Math.abs(Math.sin(hopCycle)) * 9;
    const waddleTilt = Math.sin(hopCycle) * 0.08;

    // Bunny Theme Colors
    const bType = npc.bunnyType || 'vanilla';
    let furColor = '#FFFDF7';
    let innerEarColor = '#FFCAD4';
    let collarColor = '#FF6B8B';
    let eyeColor = '#2B1B17';

    if (bType === 'cocoa') {
      furColor = '#DDB892';
      innerEarColor = '#EDE0D4';
      collarColor = '#7F5539';
    } else if (bType === 'berry') {
      furColor = '#E2D4F0';
      innerEarColor = '#F3E8FF';
      collarColor = '#9D4EDD';
    }

    ctx.save();
    ctx.translate(npc.x, npc.y + hopY);
    if (facingLeft) ctx.scale(-1, 1);
    ctx.rotate(waddleTilt);

    // 1. Soft ground shadow
    ctx.save();
    ctx.translate(0, -hopY);
    ctx.beginPath();
    const shadowScale = 1 - Math.min(0.5, Math.abs(hopY) / 18);
    ctx.ellipse(0, 18, 16 * shadowScale, 7 * shadowScale, 0, 0, Math.PI * 2);
    ctx.fillStyle = 'rgba(30, 70, 20, 0.22)';
    ctx.fill();
    ctx.restore();

    // 2. Cotton-ball Bunny Tail
    ctx.beginPath();
    ctx.arc(-14, 6, 7, 0, Math.PI * 2);
    ctx.fillStyle = '#FFFFFF';
    ctx.fill();
    ctx.strokeStyle = 'rgba(0, 0, 0, 0.08)';
    ctx.lineWidth = 1.5;
    ctx.stroke();

    // 3. Cute Bunny Feet
    const lFootY = Math.sin(hopCycle * 2) * 3;
    const rFootY = -Math.sin(hopCycle * 2) * 3;
    ctx.fillStyle = furColor;
    ctx.beginPath();
    ctx.ellipse(-7, 16 + lFootY, 6, 3.5, 0, 0, Math.PI * 2);
    ctx.fill();
    ctx.beginPath();
    ctx.ellipse(7, 16 + rFootY, 6, 3.5, 0, 0, Math.PI * 2);
    ctx.fill();

    // 4. Chubby Round Bunny Body
    ctx.beginPath();
    ctx.arc(0, 2, 17, 0, Math.PI * 2);
    ctx.fillStyle = furColor;
    ctx.fill();
    ctx.strokeStyle = 'rgba(0, 0, 0, 0.12)';
    ctx.lineWidth = 2;
    ctx.stroke();

    // Soft White Belly
    ctx.beginPath();
    ctx.ellipse(0, 5, 11, 9, 0, 0, Math.PI * 2);
    ctx.fillStyle = '#FFFFFF';
    ctx.fill();

    // Cute Collar & Bell Ribbon
    ctx.fillStyle = collarColor;
    this.roundRect(ctx, -10, -7, 20, 4, 2);
    ctx.fill();
    // Little golden bell
    ctx.beginPath();
    ctx.arc(0, -4, 3, 0, Math.PI * 2);
    ctx.fillStyle = '#FFD166';
    ctx.fill();

    // 5. Cute Round Bunny Head
    ctx.beginPath();
    ctx.arc(0, -9, 15, 0, Math.PI * 2);
    ctx.fillStyle = furColor;
    ctx.fill();
    ctx.strokeStyle = 'rgba(0, 0, 0, 0.12)';
    ctx.lineWidth = 2;
    ctx.stroke();

    // 6. Long Floppy/Perky Bunny Ears
    const earBounce = npc.isAlerted ? -0.1 : Math.sin(hopCycle) * 0.25;

    // Left Ear
    ctx.save();
    ctx.translate(-7, -22);
    ctx.rotate(-0.15 + earBounce);
    ctx.beginPath();
    ctx.ellipse(0, -14, 5.5, 16, 0, 0, Math.PI * 2);
    ctx.fillStyle = furColor;
    ctx.fill();
    ctx.strokeStyle = 'rgba(0, 0, 0, 0.1)';
    ctx.lineWidth = 2;
    ctx.stroke();

    // Left Inner Ear Pink
    ctx.beginPath();
    ctx.ellipse(0, -14, 3, 12, 0, 0, Math.PI * 2);
    ctx.fillStyle = innerEarColor;
    ctx.fill();
    ctx.restore();

    // Right Ear
    ctx.save();
    ctx.translate(7, -22);
    ctx.rotate(0.15 - earBounce);
    ctx.beginPath();
    ctx.ellipse(0, -14, 5.5, 16, 0, 0, Math.PI * 2);
    ctx.fillStyle = furColor;
    ctx.fill();
    ctx.strokeStyle = 'rgba(0, 0, 0, 0.1)';
    ctx.lineWidth = 2;
    ctx.stroke();

    // Right Inner Ear Pink
    ctx.beginPath();
    ctx.ellipse(0, -14, 3, 12, 0, 0, Math.PI * 2);
    ctx.fillStyle = innerEarColor;
    ctx.fill();
    ctx.restore();

    // 7. Bunny Face: Big sparkling eyes & pink nose
    ctx.beginPath();
    ctx.ellipse(-5, -9, 3.5, 4.5, 0, 0, Math.PI * 2);
    ctx.fillStyle = eyeColor;
    ctx.fill();
    ctx.beginPath();
    ctx.arc(-6, -11, 1.6, 0, Math.PI * 2);
    ctx.fillStyle = '#FFFFFF';
    ctx.fill();

    ctx.beginPath();
    ctx.ellipse(5, -9, 3.5, 4.5, 0, 0, Math.PI * 2);
    ctx.fillStyle = eyeColor;
    ctx.fill();
    ctx.beginPath();
    ctx.arc(4, -11, 1.6, 0, Math.PI * 2);
    ctx.fillStyle = '#FFFFFF';
    ctx.fill();

    // Rosy Pink Cheeks
    ctx.fillStyle = '#FFB5A7';
    ctx.beginPath();
    ctx.ellipse(-9, -5, 3.2, 2, 0, 0, Math.PI * 2);
    ctx.fill();
    ctx.beginPath();
    ctx.ellipse(9, -5, 3.2, 2, 0, 0, Math.PI * 2);
    ctx.fill();

    // Pink Y nose & mouth
    ctx.fillStyle = '#FF758F';
    ctx.beginPath();
    ctx.ellipse(0, -5, 2.2, 1.6, 0, 0, Math.PI * 2);
    ctx.fill();

    ctx.strokeStyle = '#2B1B17';
    ctx.lineWidth = 1.4;
    ctx.beginPath();
    ctx.moveTo(0, -3.5);
    ctx.lineTo(0, -1);
    ctx.arc(-2, 0, 2, Math.PI * 1.5, 0);
    ctx.moveTo(0, -1);
    ctx.arc(2, 0, 2, Math.PI * 1.5, Math.PI);
    ctx.stroke();

    // Whiskers
    ctx.strokeStyle = 'rgba(70, 50, 40, 0.4)';
    ctx.lineWidth = 1.2;
    ctx.beginPath();
    ctx.moveTo(-7, -4); ctx.lineTo(-15, -6);
    ctx.moveTo(-7, -2); ctx.lineTo(-15, -1);
    ctx.moveTo(7, -4); ctx.lineTo(15, -6);
    ctx.moveTo(7, -2); ctx.lineTo(15, -1);
    ctx.stroke();

    // 8. Cute Lantern held in front paw
    ctx.save();
    ctx.translate(11, 2);
    ctx.fillStyle = '#B07D62';
    this.roundRect(ctx, -4, -6, 8, 12, 2);
    ctx.fill();
    ctx.fillStyle = npc.isAlerted ? '#FF4D6D' : '#FFE066';
    ctx.fillRect(-2.5, -4, 5, 8);
    ctx.restore();

    ctx.restore(); // restore transform

    // 9. Alert Bubble (Carrot or Question Mark!)
    ctx.save();
    ctx.translate(npc.x, npc.y + hopY);
    if (npc.isAlerted) {
      ctx.fillStyle = 'rgba(255, 255, 255, 0.95)';
      this.roundRect(ctx, -26, -58, 52, 22, 11);
      ctx.fill();
      ctx.strokeStyle = '#FF5722';
      ctx.lineWidth = 2;
      ctx.stroke();

      ctx.fillStyle = '#E64A19';
      ctx.font = 'bold 11px "Fredoka", sans-serif';
      ctx.textAlign = 'center';
      ctx.fillText('🥕 발견!!', 0, -43);
    } else if (npc.isSuspicious) {
      ctx.fillStyle = 'rgba(255, 255, 255, 0.9)';
      this.roundRect(ctx, -20, -56, 40, 20, 10);
      ctx.fill();
      ctx.strokeStyle = '#FFB703';
      ctx.lineWidth = 2;
      ctx.stroke();

      ctx.fillStyle = '#F57C00';
      ctx.font = 'bold 11px "Fredoka", sans-serif';
      ctx.textAlign = 'center';
      ctx.fillText('❓ 킁킁', 0, -42);
    } else {
      ctx.fillStyle = 'rgba(255, 255, 255, 0.85)';
      this.roundRect(ctx, -32, 24, 64, 18, 9);
      ctx.fill();
      ctx.strokeStyle = '#DDA15E';
      ctx.lineWidth = 1.2;
      ctx.stroke();

      ctx.fillStyle = '#5A3E2B';
      ctx.font = 'bold 10px "Fredoka", sans-serif';
      ctx.textAlign = 'center';
      ctx.fillText(`🐰 ${npc.name || '버니'}`, 0, 36);
    }
    ctx.restore();
  }

  roundRect(ctx, x, y, w, h, r) {
    if (typeof ctx.roundRect === 'function') {
      ctx.beginPath();
      ctx.roundRect(x, y, w, h, r);
      return;
    }
    ctx.beginPath();
    ctx.moveTo(x + r, y);
    ctx.arcTo(x + w, y, x + w, y + h, r);
    ctx.arcTo(x + w, y + h, x, y + h, r);
    ctx.arcTo(x, y + h, x, y, r);
    ctx.arcTo(x, y, x + w, y, r);
    ctx.closePath();
  }
}

window.GameRenderer = GameRenderer;
