/* ============================================================
   SAFFRON GRILL — Premium Cinematic Popup
   GSAP-driven glass panel materialization
   ============================================================ */
(function () {
  "use strict";

  var CONFIG = {
    openDelay:       2800,   // ms after page load
    linePause:       0.18,   // s pause while showing the laser line
    growDuration:    0.95,   // s panel expansion
    contentStagger:  0.10,   // s stagger between content items
    parallaxPx:      9,      // max px translation from mouse
    tiltDeg:         3.5,    // max degrees 3D tilt from mouse
  };

  var overlay    = document.getElementById("sgPopup");
  if (!overlay) return;

  var backdrop   = overlay.querySelector(".sgp-backdrop");
  var panel      = overlay.querySelector(".sgp-panel");
  var inner      = overlay.querySelector(".sgp-inner");
  var closeBtn   = overlay.querySelector(".sgp-close");
  var shine      = overlay.querySelector(".sgp-shine");
  var ctaLinks   = overlay.querySelectorAll("a.btn");

  var ITEMS;   // populated after GSAP confirms available

  function resolveItems() {
    ITEMS = Array.prototype.slice.call(
      inner.querySelectorAll(".sgp-eyebrow, .sgp-title, .sgp-divider, .sgp-body, .sgp-note, .sgp-actions")
    );
  }

  /* ------ open / close ------ */

  function lockScroll()   { document.body.classList.add("sgp-noscroll"); }
  function unlockScroll() { document.body.classList.remove("sgp-noscroll"); }

  function open() {
    resolveItems();
    lockScroll();
    overlay.removeAttribute("aria-hidden");
    overlay.style.display = "flex";

    // --- initial GSAP states ---
    gsap.set(overlay,   { autoAlpha: 0 });
    gsap.set(backdrop,  { opacity: 0 });
    gsap.set(panel,     {
      scaleY: 0.0035,
      borderRadius: "120px",
      opacity: 1,
      boxShadow: "0 0 32px rgba(200,148,63,0.95), 0 0 8px rgba(255,255,255,0.7)",
    });
    gsap.set(ITEMS,     { opacity: 0, clipPath: "inset(0 0 100% 0)", y: 14 });
    gsap.set(closeBtn,  { opacity: 0, scale: 0.7 });

    var tl = gsap.timeline({ onComplete: bindParallax });

    // 1 — show overlay
    tl.to(overlay, { autoAlpha: 1, duration: 0.01 });

    // 2 — fade in dark backdrop
    tl.to(backdrop, { opacity: 1, duration: 0.45, ease: "power2.inOut" });

    // 3 — brief pause on the laser line
    tl.to(panel, {
      duration: CONFIG.linePause,
      onStart: function () { backdrop.classList.add("sgp-blur"); }
    });

    // 4 — grow panel from line to full height
    tl.to(panel, {
      scaleY: 1,
      borderRadius: "14px",
      boxShadow: "0 0 0 1px rgba(255,255,255,0.04) inset, 0 1px 0 rgba(255,255,255,0.1) inset, 0 70px 130px -30px rgba(0,0,0,0.9), 0 0 70px rgba(200,148,63,0.07)",
      duration: CONFIG.growDuration,
      ease: "power4.out",
      onStart: function () { panel.classList.add("sgp-glass"); }
    });

    // 5 — reveal content with clip-path stagger
    tl.to(ITEMS, {
      opacity: 1,
      clipPath: "inset(0 0 0% 0)",
      y: 0,
      stagger: CONFIG.contentStagger,
      duration: 0.65,
      ease: "power3.out"
    }, "-=0.15");

    // 6 — pop in close button
    tl.to(closeBtn, { opacity: 1, scale: 1, duration: 0.28, ease: "back.out(1.5)" }, "-=0.35");

    tl.add(function () { trapFocus(overlay); closeBtn.focus(); });
  }

  function close() {
    unbindParallax();
    unlockScroll();

    // snap tilt back
    gsap.to(panel, { rotationX: 0, rotationY: 0, x: 0, y: 0, duration: 0.3, ease: "power2.out" });

    gsap.timeline({
      onComplete: function () {
        overlay.setAttribute("aria-hidden", "true");
        overlay.style.display = "none";
        backdrop.classList.remove("sgp-blur");
        panel.classList.remove("sgp-glass");
      }
    })
    .to(closeBtn,  { opacity: 0, scale: 0.7, duration: 0.2 })
    .to(ITEMS,     { opacity: 0, y: -10, stagger: 0.04, duration: 0.28, ease: "power2.in" }, "-=0.05")
    .to(panel,     { scaleY: 0.0035, borderRadius: "120px", duration: 0.42, ease: "power4.in" }, "-=0.15")
    .to(backdrop,  { opacity: 0, duration: 0.3 }, "-=0.25")
    .to(overlay,   { autoAlpha: 0, duration: 0.2 });
  }

  /* ------ parallax / tilt ------ */

  var _parallaxBound = null;

  function onMouseMove(e) {
    var cx  = e.clientX / window.innerWidth  - 0.5;  // -0.5 → 0.5
    var cy  = e.clientY / window.innerHeight - 0.5;

    gsap.to(panel, {
      rotationX:         cy * -CONFIG.tiltDeg,
      rotationY:         cx *  CONFIG.tiltDeg,
      x:                 cx *  CONFIG.parallaxPx,
      y:                 cy *  CONFIG.parallaxPx,
      transformPerspective: 1000,
      duration: 0.75,
      ease: "power2.out",
    });

    if (shine) {
      gsap.to(shine, {
        x:       cx * 50,
        y:       cy * 30,
        opacity: 0.08 + Math.abs(cx) * 0.09,
        duration: 0.5,
        ease: "power2.out",
      });
    }
  }

  function bindParallax() {
    _parallaxBound = onMouseMove;
    document.addEventListener("mousemove", _parallaxBound, { passive: true });
  }

  function unbindParallax() {
    if (_parallaxBound) {
      document.removeEventListener("mousemove", _parallaxBound);
      _parallaxBound = null;
    }
  }

  /* ------ focus trap ------ */

  function trapFocus(root) {
    var focusable = Array.prototype.slice.call(
      root.querySelectorAll("a[href], button:not([disabled]), [tabindex]:not([tabindex='-1'])")
    );
    var first = focusable[0];
    var last  = focusable[focusable.length - 1];

    function handler(e) {
      if (e.key === "Escape")  { close(); root.removeEventListener("keydown", handler); return; }
      if (e.key !== "Tab") return;
      if (e.shiftKey) {
        if (document.activeElement === first) { e.preventDefault(); last.focus(); }
      } else {
        if (document.activeElement === last)  { e.preventDefault(); first.focus(); }
      }
    }
    root.addEventListener("keydown", handler);
  }

  /* ------ event bindings ------ */

  closeBtn.addEventListener("click", close);
  backdrop.addEventListener("click", close);
  ctaLinks.forEach(function (a) { a.addEventListener("click", close); });

  /* ------ boot ------ */

  // Only open once per session
  if (typeof gsap === "undefined") return;
  if (sessionStorage.getItem("sgp_seen")) return;

  setTimeout(function () {
    sessionStorage.setItem("sgp_seen", "1");
    open();
  }, CONFIG.openDelay);

})();
