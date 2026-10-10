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

  // Draw warm kitchen checkerboard flooring
  drawEnvironment(width, height) {
    const ctx = this.ctx;
    const tileSize = 48;
    for (let y = 0; y < height; y += tileSize) {
      for (let x = 0; x < width; x += tileSize) {
        const isLight = ((x / tileSize) + (y / tileSize)) % 2 === 0;
        ctx.fillStyle = isLight ? '#FFFDF5' : '#FFF3DE';
        ctx.fillRect(x, y, tileSize, tileSize);

        ctx.strokeStyle = 'rgba(235, 215, 190, 0.45)';
        ctx.lineWidth = 1;
        ctx.strokeRect(x, y, tileSize, tileSize);
      }
    }
  }

  // Draw Safe Base (Bamboo Steamer)
  drawBase(base, totalCollected, gameTime) {
    const ctx = this.ctx;
    const x = base.x;
    const y = base.y;
    const r = base.radius;

    ctx.save();
    // Drop shadow
    ctx.beginPath();
    ctx.arc(x, y + 6, r + 4, 0, Math.PI * 2);
    ctx.fillStyle = 'rgba(0, 0, 0, 0.08)';
    ctx.fill();

    // Bamboo outer ring
    ctx.beginPath();
    ctx.arc(x, y, r, 0, Math.PI * 2);
    ctx.fillStyle = '#E8C798';
    ctx.fill();
    ctx.strokeStyle = '#C99E64';
    ctx.lineWidth = 8;
    ctx.stroke();

    // Bamboo inner weave
    ctx.beginPath();
    ctx.arc(x, y, r - 6, 0, Math.PI * 2);
    ctx.fillStyle = '#F4DEB9';
    ctx.fill();

    // Weave lattice lines
    ctx.strokeStyle = 'rgba(180, 135, 80, 0.25)';
    ctx.lineWidth = 2;
    for (let i = -r + 15; i < r - 15; i += 12) {
      const span = Math.sqrt(Math.max(0, (r - 10) ** 2 - i ** 2));
      ctx.beginPath();
      ctx.moveTo(x - span, y + i);
      ctx.lineTo(x + span, y + i);
      ctx.stroke();
    }

    // Glowing rim
    const pulse = 0.5 + 0.5 * Math.sin(gameTime * 3);
    ctx.beginPath();
    ctx.arc(x, y, r + 2, 0, Math.PI * 2);
    ctx.strokeStyle = `rgba(100, 210, 120, ${0.4 + pulse * 0.35})`;
    ctx.lineWidth = 4;
    ctx.stroke();

    // Badge
    ctx.fillStyle = '#2E7D32';
    ctx.font = 'bold 12px "Fredoka", sans-serif';
    ctx.textAlign = 'center';
    ctx.fillText('🧺 아지트 찜기 (HOME)', x, y + r + 18);

    // Steam particles
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

  // Draw kitchen furniture obstacles
  drawObstacle(obs) {
    const ctx = this.ctx;
    ctx.save();

    // Drop shadow
    ctx.fillStyle = 'rgba(0, 0, 0, 0.08)';
    ctx.fillRect(obs.x + 4, obs.y + 6, obs.w, obs.h);

    if (obs.type === 'cutting_board') {
      ctx.fillStyle = '#E3B278';
      this.roundRect(ctx, obs.x, obs.y, obs.w, obs.h, 12);
      ctx.fill();
      ctx.strokeStyle = '#B88247';
      ctx.lineWidth = 3;
      ctx.stroke();

      // Handle hole
      ctx.beginPath();
      ctx.arc(obs.x + 16, obs.y + obs.h / 2, 6, 0, Math.PI * 2);
      ctx.fillStyle = '#FFF5E4';
      ctx.fill();
      ctx.stroke();

      // Sliced carrot
      ctx.beginPath();
      ctx.arc(obs.x + obs.w - 24, obs.y + obs.h / 2, 10, 0, Math.PI * 2);
      ctx.fillStyle = '#FF7A30';
      ctx.fill();
      ctx.strokeStyle = '#D65612';
      ctx.lineWidth = 2;
      ctx.stroke();
    } else if (obs.type === 'teacup') {
      ctx.beginPath();
      ctx.arc(obs.x + obs.w / 2, obs.y + obs.h / 2, obs.w / 2, 0, Math.PI * 2);
      ctx.fillStyle = '#89CFF0';
      ctx.fill();
      ctx.strokeStyle = '#5AA0D4';
      ctx.lineWidth = 3;
      ctx.stroke();

      ctx.beginPath();
      ctx.arc(obs.x + obs.w / 2, obs.y + obs.h / 2, obs.w / 2 - 6, 0, Math.PI * 2);
      ctx.fillStyle = '#98D8AA';
      ctx.fill();
    } else {
      ctx.fillStyle = '#D4A373';
      this.roundRect(ctx, obs.x, obs.y, obs.w, obs.h, 8);
      ctx.fill();
      ctx.strokeStyle = '#9C6644';
      ctx.lineWidth = 3;
      ctx.stroke();

      ctx.fillStyle = 'rgba(255, 255, 255, 0.25)';
      ctx.fillRect(obs.x + 3, obs.y + 3, obs.w - 6, 6);
    }

    ctx.restore();
  }

  // Draw NPC Vision Light Cone
  drawNPCVisionCone(npc) {
    const ctx = this.ctx;
    ctx.save();
    ctx.translate(npc.x, npc.y);

    const coneAngle = npc.visionAngle || Math.PI / 3;
    const coneDist = npc.visionDistance || 145;
    const facing = npc.facingAngle || 0;

    ctx.beginPath();
    ctx.moveTo(0, 0);
    ctx.arc(0, 0, coneDist, facing - coneAngle / 2, facing + coneAngle / 2);
    ctx.closePath();

    if (npc.isAlerted) {
      ctx.fillStyle = 'rgba(255, 59, 48, 0.32)';
      ctx.strokeStyle = 'rgba(255, 59, 48, 0.7)';
    } else {
      ctx.fillStyle = 'rgba(255, 215, 0, 0.22)';
      ctx.strokeStyle = 'rgba(255, 215, 0, 0.55)';
    }
    ctx.fill();
    ctx.lineWidth = 2;
    ctx.stroke();

    ctx.restore();
  }

  // Draw Dumpling Aura on the ground
  drawDumplingAura(d, gameTime) {
    const ctx = this.ctx;
    const breathe = this.animator.getBreatheDeformation(gameTime + d.timeOffset, 1.4, 0.16);
    const pulse = (breathe.waveVal + 1) * 0.5;

    ctx.save();
    ctx.translate(d.x, d.y);

    // Ground shadow
    ctx.beginPath();
    ctx.ellipse(0, 16, 20 * breathe.sx, 8, 0, 0, Math.PI * 2);
    ctx.fillStyle = 'rgba(0, 0, 0, 0.15)';
    ctx.fill();

    // Breathing wave aura
    ctx.beginPath();
    ctx.arc(0, 6, 26 + pulse * 8, 0, Math.PI * 2);
    ctx.fillStyle = `rgba(255, 230, 160, ${0.12 + pulse * 0.18})`;
    ctx.fill();

    // Name label
    ctx.fillStyle = '#5D4037';
    ctx.font = 'bold 11px "Fredoka", sans-serif';
    ctx.textAlign = 'center';
    ctx.fillText(`🥟 ${d.name}`, 0, 32);

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
   * Synchronizes 2D animated sprites from aldegad/sprite-gen with game entity states.
   */
  syncDOMSprites(player, dumplings, npcs, gameTime) {
    if (!this.spriteLayer) return;

    // Automatically synchronize scale with canvas responsive display size
    if (this.canvas.clientWidth > 0 && this.canvas.width > 0) {
      const scale = this.canvas.clientWidth / this.canvas.width;
      this.spriteLayer.style.transform = `scale(${scale})`;
      this.spriteLayer.style.transformOrigin = 'top left';
      this.spriteLayer.style.width = `${this.canvas.width}px`;
      this.spriteLayer.style.height = `${this.canvas.height}px`;
    }

    // 1. Sync Player: attack-fox-hood.gif
    if (player) {
      const pSprite = this.getOrCreateSprite('player', 'sprite-gen/docs/assets/attack-fox-hood.gif');
      if (pSprite) {
        const isMoving = player.speed > 5;
        const walkAnim = isMoving ? this.animator.getWalkCycle(player.walkDistance, player.speed) : { tilt: 0, bobY: 0, scaleX: 1, scaleY: 1 };
        const breathe = isMoving ? { sx: 1, sy: 1 } : this.animator.getBreatheDeformation(gameTime, 1.4, 0.08);

        const w = 72;
        const h = 68;
        pSprite.style.width = `${w}px`;
        pSprite.style.height = `${h}px`;
        pSprite.style.left = `${player.x - w / 2}px`;
        pSprite.style.top = `${player.y - h + 16}px`;

        const flip = player.facing === 'left' ? -1 : 1;
        const rot = player.isCaught ? player.dizzyAngle : walkAnim.tilt;

        pSprite.style.transform = `scaleX(${flip}) translateY(${walkAnim.bobY}px) scale(${walkAnim.scaleX * breathe.sx}, ${walkAnim.scaleY * breathe.sy}) rotate(${rot}rad)`;
        pSprite.style.display = 'block';
      }
    }

    // 2. Sync Dumplings: attack-slime.gif with unique color themes
    dumplings.forEach((d, idx) => {
      const dSprite = this.getOrCreateSprite(`dumpling_${d.id}`, 'sprite-gen/docs/assets/attack-slime.gif');
      if (dSprite) {
        const breathe = this.animator.getBreatheDeformation(gameTime + d.timeOffset, 1.4, 0.16);
        const springVal = d.spring ? d.spring.value : 0;
        const finalSx = breathe.sx * (1 + springVal * 0.04);
        const finalSy = breathe.sy * (1 - springVal * 0.04);

        const w = 54;
        const h = 50;
        dSprite.style.width = `${w}px`;
        dSprite.style.height = `${h}px`;

        // Color themes
        if (d.type === 'berry') {
          dSprite.style.filter = 'hue-rotate(90deg) saturate(1.4) drop-shadow(0 4px 8px rgba(244, 63, 94, 0.4))';
        } else if (d.type === 'goldie') {
          dSprite.style.filter = 'hue-rotate(185deg) saturate(1.6) drop-shadow(0 4px 8px rgba(234, 179, 8, 0.45))';
        } else if (d.type === 'matcha') {
          dSprite.style.filter = 'hue-rotate(275deg) saturate(1.3) drop-shadow(0 4px 8px rgba(34, 197, 94, 0.4))';
        } else if (d.type === 'choco') {
          dSprite.style.filter = 'sepia(1) saturate(2.2) hue-rotate(-30deg) drop-shadow(0 4px 8px rgba(139, 69, 19, 0.4))';
        } else {
          dSprite.style.filter = 'drop-shadow(0 4px 8px rgba(56, 189, 248, 0.45))';
        }

        if (d.isCarried && player) {
          // Riding on top of player's head!
          const jiggle = Math.sin(gameTime * 14) * 4;
          dSprite.style.left = `${player.x - w / 2}px`;
          dSprite.style.top = `${player.y - h - 42 + jiggle}px`;
          dSprite.style.transform = `scale(${finalSx * 1.05}, ${finalSy * 1.05}) rotate(${Math.sin(gameTime * 8) * 0.12}rad)`;
        } else {
          // Placed in field or in base
          dSprite.style.left = `${d.x - w / 2}px`;
          dSprite.style.top = `${d.y - h + 14}px`;
          dSprite.style.transform = `scale(${finalSx}, ${finalSy})`;
        }

        dSprite.style.display = 'block';
      }
    });

    // 3. Sync Patrolling Guard NPCs: attack-paladin.gif & attack-claudecy-samurai.gif
    npcs.forEach((npc, idx) => {
      const src = npc.role === 'dog' ? 'sprite-gen/docs/assets/attack-claudecy-samurai.gif' : 'sprite-gen/docs/assets/attack-paladin.gif';
      const nSprite = this.getOrCreateSprite(`npc_${npc.id}`, src);
      if (nSprite) {
        const w = 68;
        const h = 76;
        nSprite.style.width = `${w}px`;
        nSprite.style.height = `${h}px`;
        nSprite.style.left = `${npc.x - w / 2}px`;
        nSprite.style.top = `${npc.y - h + 18}px`;

        const flip = Math.cos(npc.facingAngle) < 0 ? -1 : 1;
        const alertPulse = npc.isAlerted ? 'drop-shadow(0 0 12px rgba(255, 59, 48, 0.9))' : 'drop-shadow(0 4px 8px rgba(0, 0, 0, 0.25))';
        nSprite.style.filter = alertPulse;

        nSprite.style.transform = `scaleX(${flip})`;
        nSprite.style.display = 'block';
      }
    });
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
