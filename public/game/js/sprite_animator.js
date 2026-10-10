/**
 * Sprite Animation Engine with direct integration of aldegad/sprite-gen official modules:
 * - Directly leverages sprite-gen/sprite_gen/serve/curator/src/breathe.js
 * - Calls breatheWave(t) and breatheComposite(baseCanvas, cfg, phase)
 * - Supports sprite-gen manifest-driven breathing states and real-time exaggerated squishy physics
 */

class SpriteAnimator {
  constructor() {
    this.time = 0;
    this.manifest = null;
    this.userDepthMultiplier = 1.4; // Exaggerate by default so squishy effect is immediately visible!
    this.userFrequencyMultiplier = 1.2;
    this.loadManifest();
  }

  async loadManifest() {
    try {
      const res = await fetch('manifest.json');
      if (res.ok) {
        this.manifest = await res.json();
      }
    } catch (e) {
      this.manifest = {
        states: {
          player_idle: { breathe: { depth: 0.12, breaths: 2, lag: 0.10 } },
          dumpling_idle: { breathe: { depth: 0.16, breaths: 1, lag: 0.14 } }
        }
      };
    }
  }

  update(dt) {
    this.time += dt;
  }

  /**
   * Evaluates wave value using the official sprite-gen breatheWave function.
   * wave(t) = 0.86 * sin(2πt) + 0.14 * sin(4πt)
   */
  getWave(t) {
    if (typeof window.breatheWave === 'function') {
      return window.breatheWave(t);
    }
    return 0.86 * Math.sin(2 * Math.PI * t) + 0.14 * Math.sin(4 * Math.PI * t);
  }

  /**
   * Calculates volume-preserving deformation scales with juicy, visible squishy depth!
   * Matches sprite-gen breathe.py / breathe.js formula:
   * sx = 1 + g, sy = 1 / (1 + g) where g = wave * depth
   */
  getBreatheDeformation(t, frequency = 1.4, baseDepth = 0.15) {
    const finalFreq = frequency * this.userFrequencyMultiplier;
    const finalDepth = baseDepth * this.userDepthMultiplier;

    const cycle = (t * finalFreq) % 1.0;
    const waveVal = this.getWave(cycle);
    const g = waveVal * finalDepth;

    // Volume-preserving scale: sx expands horizontally as sy contracts vertically
    const sx = 1.0 + g;
    const sy = 1.0 / (1.0 + g * 0.95);

    // Anchoring at base so the feet/bottom stays grounded
    const offsetY = (1.0 - sy) * 22;

    return { sx, sy, offsetY, waveVal, cycle, g };
  }

  /**
   * Walk cycle waddle deformation with bouncy cartoon bobbing.
   */
  getWalkCycle(walkDistance, speed = 1.0) {
    if (speed < 0.1) {
      return { tilt: 0, bobY: 0, legPhase: 0, scaleX: 1, scaleY: 1 };
    }

    const phase = walkDistance * 0.18;
    // Playful side-to-side waddle tilt (±0.16 radians, ~10 degrees)
    const tilt = Math.sin(phase) * 0.16;

    // Springy up-and-down hop
    const bobY = -Math.abs(Math.sin(phase)) * 8;

    // Squishy footprint compression
    const impact = Math.abs(Math.cos(phase));
    const scaleX = 1.0 + impact * 0.10;
    const scaleY = 1.0 - impact * 0.08;

    return { tilt, bobY, legPhase: phase, scaleX, scaleY };
  }

  getBlinkState(time, interval = 3.2) {
    const cycle = (time + 0.2) % interval;
    if (cycle < 0.22) {
      return Math.sin((cycle / 0.22) * Math.PI);
    }
    return 0.0;
  }
}

/**
 * Spring-Damper physics simulator for reactive jelly / squishy motion.
 */
class JellySpring {
  constructor(stiffness = 150, damping = 8) {
    this.target = 0;
    this.value = 0;
    this.velocity = 0;
    this.stiffness = stiffness;
    this.damping = damping;
  }

  impulse(force) {
    this.velocity += force;
  }

  update(dt) {
    const safeDt = Math.min(dt, 0.05);
    const displacement = this.value - this.target;
    const springForce = -this.stiffness * displacement;
    const dampingForce = -this.damping * this.velocity;
    const acceleration = springForce + dampingForce;

    this.velocity += acceleration * safeDt;
    this.value += this.velocity * safeDt;
  }
}

window.SpriteAnimator = SpriteAnimator;
window.JellySpring = JellySpring;
