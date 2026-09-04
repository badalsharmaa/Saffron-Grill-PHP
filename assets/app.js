/* ============================================================
   SAFFRON GRILL — interactions
   ============================================================ */
(function () {
  "use strict";

  /* ---------- year ---------- */
  var yr = document.getElementById("year");
  if (yr) yr.textContent = new Date().getFullYear();

  /* ---------- nav scroll state ---------- */
  var nav = document.getElementById("nav");
  var scrollCue = document.querySelector(".scroll-cue");
  var lastScrollY = window.scrollY;
  function onScroll() {
    var currentScrollY = window.scrollY;
    
    if (currentScrollY > 40) nav.classList.add("scrolled");
    else nav.classList.remove("scrolled");

    if (currentScrollY > lastScrollY && currentScrollY > 150) {
      nav.classList.add("nav-hidden");
    } else {
      nav.classList.remove("nav-hidden");
    }

    if (scrollCue) {
      if (currentScrollY > 20) {
        scrollCue.classList.add("hidden");
      } else {
        scrollCue.classList.remove("hidden");
      }
    }
    
    lastScrollY = currentScrollY;
  }
  window.addEventListener("scroll", onScroll, { passive: true });
  onScroll();

  /* ---------- mobile menu ---------- */
  var toggle = document.getElementById("navToggle");
  var menu = document.getElementById("mobileMenu");
  if (toggle && menu) {
    toggle.addEventListener("click", function () {
      menu.classList.toggle("open");
    });
    menu.querySelectorAll("a").forEach(function (a) {
      a.addEventListener("click", function () { menu.classList.remove("open"); });
    });
  }

  /* ---------- open now state ---------- */
  (function openState() {
    var el = document.getElementById("openState");
    if (!el) return;
    var now = new Date();
    var day = now.getDay(); // 0 Sun .. 6 Sat
    var mins = now.getHours() * 60 + now.getMinutes();
    var weekend = (day === 0 || day === 6);
    // ranges in minutes
    var lunch = weekend ? [12 * 60, 15 * 60 + 30] : [11 * 60 + 30, 15 * 60];
    var dinner = [17 * 60, 22 * 60];
    var open = (mins >= lunch[0] && mins < lunch[1]) || (mins >= dinner[0] && mins < dinner[1]);
    var dot = el.parentElement.querySelector(".dot");
    if (open) {
      var closeAt = (mins < lunch[1]) ? lunch[1] : dinner[1];
      el.textContent = "Open now · until " + fmt(closeAt);
    } else {
      var next = mins < lunch[0] ? lunch[0] : (mins < dinner[0] ? dinner[0] : null);
      el.textContent = next != null ? ("Opens at " + fmt(next)) : "Closed · opens tomorrow";
      if (dot) { dot.classList.remove("live"); }
    }
    function fmt(m) {
      var h = Math.floor(m / 60), mm = m % 60;
      var ap = h >= 12 ? "PM" : "AM";
      var hh = h % 12; if (hh === 0) hh = 12;
      return hh + (mm ? ":" + (mm < 10 ? "0" + mm : mm) : "") + " " + ap;
    }
  })();

  /* ---------- scroll reveal ---------- */
  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (e) {
      if (e.isIntersecting) { e.target.classList.add("in"); io.unobserve(e.target); }
    });
  }, { threshold: 0.12, rootMargin: "0px 0px -8% 0px" });
  document.querySelectorAll(".reveal").forEach(function (el) { io.observe(el); });

  /* ---------- scroll-spy active nav link ---------- */
  (function scrollSpy() {
    var links = Array.prototype.slice.call(document.querySelectorAll(".nav-links a"));
    var map = {};
    links.forEach(function (a) {
      var href = a.getAttribute("href");
      if (href.indexOf("#") !== -1) {
        var id = href.split("#")[1];
        if (id) map[id] = a;
      } else {
        var path = window.location.pathname;
        var page = path.substring(path.lastIndexOf('/') + 1);
        if (page === href || (href === "index.html" && (page === "" || page === "index.html"))) {
          a.classList.add("active");
        }
      }
    });
    var sections = Object.keys(map).map(function (id) { return document.getElementById(id); }).filter(Boolean);
    if (!sections.length) return;
    var spy = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) {
          links.forEach(function (l) {
            var href = l.getAttribute("href");
            if (href.indexOf("#") !== -1) {
              l.classList.remove("active");
            }
          });
          var a = map[e.target.id];
          if (a) a.classList.add("active");
        }
      });
    }, { rootMargin: "-45% 0px -50% 0px", threshold: 0 });
    sections.forEach(function (s) { spy.observe(s); });
  })();

  /* ---------- stat count-up ---------- */
  (function countUp() {
    var nums = document.querySelectorAll(".stat .num");
    if (!nums.length) return;
    var cObs = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (!e.isIntersecting) return;
        cObs.unobserve(e.target);
        animate(e.target);
      });
    }, { threshold: 0.6 });
    nums.forEach(function (n) { cObs.observe(n); });
    function animate(el) {
      var html = el.innerHTML;
      var m = html.match(/^(\d+)(.*)$/s); // leading integer + suffix (e.g. 20+, 100%)
      if (!m) return;
      var target = parseInt(m[1], 10), suffix = m[2];
      if (window.matchMedia && window.matchMedia("(prefers-reduced-motion: reduce)").matches) return;
      var dur = 1300, start = null;
      function step(ts) {
        if (start === null) start = ts;
        var p = Math.min((ts - start) / dur, 1);
        var eased = 1 - Math.pow(1 - p, 3);
        el.innerHTML = Math.round(target * eased) + suffix;
        if (p < 1) requestAnimationFrame(step);
        else el.innerHTML = target + suffix;
      }
      el.innerHTML = "0" + suffix;
      requestAnimationFrame(step);
    }
  })();

  /* ---------- hero mandala parallax ---------- */
  var mandalas = document.querySelectorAll(".hero-mandala");
  var ticking = false;
  window.addEventListener("scroll", function () {
    if (ticking) return;
    ticking = true;
    requestAnimationFrame(function () {
      var y = window.scrollY;
      mandalas.forEach(function (m) {
        m.style.transform = "translate(-50%, calc(-50% + " + (y * 0.06) + "px))";
      });
      ticking = false;
    });
  }, { passive: true });

  /* ---------- signature dishes ---------- */
  var DISHES = {
    tandoori: [
      ["Tandoori Chicken", "nonveg", "Yogurt &amp; spice marinated, charred in the clay oven, finished with lime.", "Chef's Pick", "assets/dishes/tandoori_chicken.webp"],
      ["Seekh Kebab", "nonveg", "Hand-minced lamb skewers, ginger, green chilli &amp; warm garam masala.", null, "assets/dishes/seekh_kebab.webp"],
      ["Paneer Tikka", "veg", "Cottage cheese &amp; peppers in tandoori marinade, smoky off the grill.", null, "assets/dishes/paneer_tikka.webp"],
      ["Tandoori Prawns", "nonveg", "Jumbo prawns, ajwain &amp; saffron, kissed by the tandoor flame.", "Seasonal", "assets/dishes/tandoori_prawns.webp"],
      ["Malai Broccoli", "veg", "Creamy cashew-marinated florets, gently charred.", null, "assets/dishes/malai_broccoli.webp"],
      ["Garlic Naan", "veg", "Pillowy clay-oven bread brushed with garlic &amp; butter.", null, "assets/dishes/garlic_naan.webp"]
    ],
    veg: [
      ["Paneer Butter Masala", "veg", "Cottage cheese in a velvety tomato, cashew &amp; fenugreek gravy.", "Favourite", "assets/dishes/paneer_tikka_masala.webp"],
      ["Dal Makhani", "veg", "Black lentils simmered overnight with cream &amp; butter.", null, "assets/dishes/dal_makhani.webp"],
      ["Chana Masala", "veg", "Chickpeas in a tangy onion-tomato masala, finished with herbs.", null, "assets/dishes/chana_masala.webp"],
      ["Palak Paneer", "veg", "Silky spinach with house cheese &amp; gentle spice.", null, "assets/dishes/palak_paneer.webp"],
      ["Veg Biryani", "veg", "Saffron basmati layered with seasonal vegetables &amp; whole spice.", null, "assets/dishes/veg_biryani.webp"],
      ["Aloo Gobi", "veg", "Potato &amp; cauliflower, turmeric, cumin &amp; ginger.", null, "assets/dishes/aloo_gobi.webp"]
    ],
    nonveg: [
      ["Butter Chicken", "nonveg", "Tandoori chicken in a rich tomato, butter &amp; cream sauce.", "Signature", "assets/dishes/butter_chicken.webp"],
      ["Chicken Tikka Masala", "nonveg", "Char-grilled chicken in a fragrant spiced gravy.", null, "assets/dishes/chicken_tikka_masala.webp"],
      ["Lamb Rogan Josh", "spice", "Slow-cooked lamb in Kashmiri chillies &amp; aromatic spice.", null, "assets/dishes/lamb_rogan_josh.webp"],
      ["Goat Curry", "spice", "Bone-in goat braised until tender in a robust home-style masala.", null, "assets/dishes/goat_curry.webp"],
      ["Chicken Biryani", "nonveg", "Layered saffron basmati &amp; spiced chicken, sealed &amp; steamed.", null, "assets/dishes/chicken_biryani.webp"],
      ["Fish Curry", "spice", "Coastal-style fish in coconut, curry leaf &amp; tamarind.", null, "assets/dishes/fish_curry.webp"]
    ],
    dessert: [
      ["Gulab Jamun", "veg", "Warm milk dumplings soaked in rose &amp; cardamom syrup.", "Loved", "assets/dishes/gulab_jamun.webp"],
      ["Gajar Halwa", "veg", "Slow-cooked carrot, milk, ghee &amp; nuts.", null, "assets/dishes/gajar_halwa.webp"],
      ["Rasmalai", "veg", "Soft cheese discs in saffron-cardamom milk.", null, "assets/dishes/rasmalai.webp"],
      ["Kheer", "veg", "Creamy rice pudding with cardamom &amp; pistachio.", null, "assets/dishes/kheer.webp"],
      ["Mango Kulfi", "veg", "Dense Indian ice cream, real mango.", "Seasonal", "assets/dishes/mango_kulfi.webp"],
      ["Masala Chai", "veg", "Spiced black tea simmered with milk — the perfect finish.", null, "assets/dishes/masala_chai.webp"]
    ]
  };

  var grid = document.getElementById("dishGrid");
  var tabsEl = document.getElementById("tabs");
  function tagClass(t) { return t === "veg" ? "tag-veg" : (t === "spice" ? "tag-spice" : "tag-nonveg"); }
  function tagLabel(t) { return t === "veg" ? "Veg" : (t === "spice" ? "Spicy" : "Non-Veg"); }
  function renderDishes(cat) {
    if (!grid) return;
    var items = DISHES[cat] || [];
    grid.innerHTML = items.map(function (d, i) {
      var name = d[0], type = d[1], desc = d[2], badge = d[3], img = d[4];
      var slotId = "dish-" + cat + "-" + i;
      var srcAttr = img ? ' src="' + img + '"' : '';
      return '' +
        '<article class="dish reveal' + (i % 3 ? " d" + (i % 3) : "") + '">' +
          '<div class="media"><image-slot id="' + slotId + '" placeholder="' + name + '"' + srcAttr + '></image-slot></div>' +
          '<div class="body">' +
            '<div class="row"><h3>' + name + '</h3><span class="tag ' + tagClass(type) + '">' + tagLabel(type) + '</span></div>' +
            '<p>' + desc + '</p>' +
          '</div>' +
        '</article>';
    }).join("");
    // observe new reveals
    grid.querySelectorAll(".reveal").forEach(function (el) {
      requestAnimationFrame(function () { el.classList.add("in"); });
    });
    if (window.customElements && customElements.get("image-slot")) {
      // slots auto-upgrade
    }
  }
  if (tabsEl) {
    tabsEl.addEventListener("click", function (e) {
      var btn = e.target.closest(".tab");
      if (!btn || btn.classList.contains("active")) return;
      tabsEl.querySelectorAll(".tab").forEach(function (t) { t.classList.remove("active"); });
      btn.classList.add("active");
      // smooth crossfade between categories
      grid.classList.add("swapping");
      setTimeout(function () {
        renderDishes(btn.dataset.cat);
        requestAnimationFrame(function () { grid.classList.remove("swapping"); });
      }, 260);
    });
    renderDishes("tandoori");
  }

  /* ---------- menu ---------- */
  var MENU = [
    ["Salads &amp; Appetizers", [
      ["Amritsari Fish", "$12.99", "Crispy batter fried basa with gram flour, carom seeds, cumin, ginger, and garlic"],
      ["Gobi Manchurian", "$10.99", "Crispy cauliflower tossed in garlic, ginger, green onion, and tangy tomato sauce"],
      ["Potato and Peas Samosa", "$8.99", "Cumin flavored potato and peas filled in flaky pastry"]
    ]],
    ["Tandoor Clay Oven", [
      ["Panch Pooran Paneer Tikka", "$14.99", "Toasted five spice cottage cheese kabab"],
      ["Lemongrass Chicken Tikka", "$17.99", "Boneless chicken breast marinated in mild creamy sauce and lemongrass flavor"],
      ["Mustard Shrimp", "$19.99", "Jumbo shrimp marinated in yogurt, mustard, ginger, and garlic"]
    ]],
    ["Vegetable Entrees", [
      ["Palak Paneer", "$13.99", "Cottage cheese cubes in spinach and garlic"],
      ["Dal Makhni", "$14.99", "Black lentils and red kidney beans slow cooked in a creamy tomato-based gravy"],
      ["Kadhi Paneer", "$13.99", "Cottage cheese cubes cooked with onion, bell peppers, cumin, and coriander seeds"]
    ]],
    ["Non-Vegetarian Entrees", [
      ["Butter Chicken", "$15.99", "Roasted and shredded chicken thigh in creamy tomato sauce"],
      ["Chicken Tikka Masala", "$16.99", "Tandoor roasted chicken thigh with onion, ginger, garlic, green pepper, and fresh tomato sauce"],
      ["Lamb Rogan Josh", "$17.99", "Tender slow-braised lamb chunks with fennel seeds, brown onion, and fresh tomato sauce"]
    ]],
    ["Rice &amp; Biryani", [
      ["Chicken Biryani", "$16.99", "Boneless chicken thigh pieces blended with aromatic sauce and cooked with aged basmati rice"],
      ["Mutton (Goat) Biryani", "$18.99", "Traditionally spiced bone-in mutton with saffron-scented basmati rice, slow steamed to perfection"],
      ["Vegetable Biryani", "$14.99", "Aged basmati rice cooked with spices and seasonal vegetables"]
    ]],
    ["Breads From Tandoor", [
      ["Garlic Naan", "$4.99", "All-purpose flour bread with garlic and cilantro"],
      ["Plain Naan", "$3.99", "All-purpose flour bread"],
      ["Pesto Naan", "$5.99", "Naan topped with pesto"]
    ]],
    ["Desserts &amp; Sides", [
      ["Gulab Jamun", "$7.99", "Soft golden brown sweet milk dumplings"],
      ["Rasmalai", "$5.99", "Velvety cottage cheese discs poached in delicate sweetened saffron milk"],
      ["Gajjar Halwa", "$7.99", "Decadent carrot pudding with sweetened milk, clarified butter, cardamom, and nuts"]
    ]],
    ["Drinks", [
      ["Mango Lassi", "$5.99", "Mango-flavored yogurt drink"],
      ["Chai", "$2.99", "Indian spiced tea"],
      ["Strawberry Lassi", "$5.99", "Strawberry-flavored yogurt drink"]
    ]]
  ];
  /* ---------- menu tags mapping ---------- */
  var ITEM_TAGS = {
    "amritsari fish": ["nonveg"],
    "salt and pepper calamari": ["nonveg"],
    "ginger crab": ["nonveg"],
    "nimbu chicken": ["nonveg"],
    "malai soya chop": ["veg"],
    "three cheese and asparagus kabab": ["nonveg"],
    "tofu and sago kabab": ["veg", "spice"],
    "aloo tikki chaat": ["veg"],
    "roasted sweet potato and peanut chaat": ["veg"],
    "gobi manchurian": ["veg", "spice"],
    "cauliflower kurchan": ["veg"],
    "potato and peas samosa": ["veg"],
    "arugula salad": ["veg"],
    "panch pooran paneer tikka": ["nonveg"],
    "tandoori cauliflower": ["veg"],
    "lemongrass chicken tikka": ["nonveg"],
    "tandoori chicken (full)": ["nonveg"],
    "tawa masala chap": ["nonveg"],
    "apricot and walnut chicken kabab": ["nonveg"],
    "lime and olive oil salmon": ["nonveg"],
    "kalmi fish": ["nonveg"],
    "mustard shrimp": ["nonveg"],
    "tandoori chicken (half)": ["nonveg"],
    "trio of chicken": ["nonveg"],
    "banjara chicken tikka": ["nonveg"],
    "anari (pomegranate) chicken tikka": ["nonveg"],
    "yellow dal palak": ["veg"],
    "palak paneer": ["veg"],
    "chana masala": ["veg"],
    "mushroom amchuri": ["veg", "spice"],
    "mirch or baingan ka salan": ["veg", "spice"],
    "masaledar bhindi": ["veg"],
    "baingan bhartha": ["veg"],
    "subz korma": ["veg"],
    "subz malabar": ["veg"],
    "handi subz": ["veg"],
    "gobi musallam": ["veg"],
    "sun dried tomato kofta": ["veg"],
    "kadhi paneer": ["veg", "spice"],
    "malai paneer": ["veg"],
    "dal makhni": ["veg"],
    "karavali shrimp": ["nonveg"],
    "butter chicken": ["nonveg"],
    "bombay fish masala": ["nonveg", "spice"],
    "kolhapuri chicken curry": ["nonveg", "spice"],
    "achari chicken curry": ["nonveg", "spice"],
    "malai methi chicken korma": ["nonveg"],
    "chicken tikka masala": ["nonveg"],
    "kadhi chicken": ["nonveg", "spice"],
    "lamb rogan josh": ["nonveg", "spice"],
    "rara gosht": ["nonveg"],
    "lamb vindaloo": ["nonveg", "spice"],
    "nalli nihari gosht": ["nonveg"],
    "mutton (goat) curry": ["nonveg", "spice"],
    "shrimp ambotik": ["nonveg", "spice"],
    "basmati rice": ["veg"],
    "tarkari pulao": ["veg"],
    "vegetable biryani": ["veg"],
    "chicken biryani": ["nonveg"],
    "lamb biryani": ["nonveg"],
    "mutton (goat) biryani": ["nonveg", "spice"],
    "pesto naan": ["veg"],
    "bread basket": ["veg"],
    "paratha": ["veg"],
    "stuffed naan": ["veg"],
    "garlic naan": ["veg"],
    "roti": ["veg"],
    "plain naan": ["veg"],
    "butter naan": ["veg"],
    "gulab jamun": ["veg"],
    "rasmalai": ["veg"],
    "moong dal halwa": ["veg"],
    "ginger brulee": ["veg"],
    "lychee panna cotta": ["veg"],
    "gajjar halwa": ["veg"],
    "plain yogurt": ["veg"],
    "raita": ["veg"],
    "green salad": ["veg"],
    "papad": ["veg"],
    "mango lassi": ["veg"],
    "strawberry lassi": ["veg"],
    "chai": ["veg"],
    "soda": [],
    "iced tea": ["veg"]
  };

  function renderTags(tags) {
    if (!tags) return "";
    return tags.map(function (t) {
      if (t === "veg") return '<span class="tag tag-veg">Veg</span>';
      if (t === "nonveg") return '<span class="tag tag-nonveg">Non-Veg</span>';
      if (t === "spice") return '<span class="tag tag-spice">Spicy</span>';
      return "";
    }).join("");
  }

  var HIGHLIGHT_NAMES = [
    "amritsari fish", "gobi manchurian", "potato and peas samosa",
    "panch pooran paneer tikka", "lemongrass chicken tikka", "mustard shrimp",
    "palak paneer", "dal makhni", "kadhai paneer", "kadhi paneer", "kadhi chicken", "kadhai chicken",
    "butter chicken", "chicken tikka masala", "lamb rogan josh",
    "chicken biryani", "mutton (goat) biryani", "vegetable biryani",
    "garlic naan", "plain naan", "pesto naan",
    "gulab jamun", "rasmalai", "gajjar halwa", "gajar ka halwa",
    "mango lassi", "chai", "strawberry lassi"
  ];

  var HIGHLIGHT_CAT_MAP = {
    "Salads & Appetizers": "Salads & Appetizers",
    "Tandoor Clay Oven Appetizers": "Tandoor Clay Oven",
    "Veg Entrées": "Vegetable Entrees",
    "Non-Veg Entrées": "Non-Vegetarian Entrees",
    "Rice & Biryani": "Rice & Biryani",
    "Breads from Tandoor": "Breads From Tandoor",
    "Sides": "Desserts & Sides",
    "Desserts": "Desserts & Sides",
    "Drinks": "Drinks"
  };

  var TARGET_COLS = [
    "Salads & Appetizers",
    "Tandoor Clay Oven",
    "Vegetable Entrees",
    "Non-Vegetarian Entrees",
    "Rice & Biryani",
    "Breads From Tandoor",
    "Desserts & Sides",
    "Drinks"
  ];

  var menuGrid = document.getElementById("menuGrid");
  if (menuGrid) {
    fetch("menu/Saffron_Grill_Menu.json")
      .then(function (res) { return res.json(); })
      .then(function (data) {
        if (menuGrid.getAttribute("data-static") === "true") {
          // Render full menu dynamically
          menuGrid.innerHTML = data.categories.map(function (cat, i) {
            var itemsHtml = [];
            cat.items.forEach(function (item) {
              var nameLower = item.name.toLowerCase();
              if (typeof item.price === 'object') {
                // Split Tandoori Chicken half/full
                var tagsHalf = ITEM_TAGS[nameLower + ' (half)'] || ITEM_TAGS[nameLower] || [];
                itemsHtml.push(
                  '<div class="menu-item">' +
                    '<div class="top">' +
                      '<span class="name">' + item.name + ' (Half) ' + renderTags(tagsHalf) + '</span>' +
                      '<span class="leader"></span>' +
                      '<span class="price">$' + item.price.half + '</span>' +
                    '</div>' +
                    (item.description ? '<div class="desc">' + item.description + '</div>' : '') +
                  '</div>'
                );
                var tagsFull = ITEM_TAGS[nameLower + ' (full)'] || ITEM_TAGS[nameLower] || [];
                itemsHtml.push(
                  '<div class="menu-item">' +
                    '<div class="top">' +
                      '<span class="name">' + item.name + ' (Full) ' + renderTags(tagsFull) + '</span>' +
                      '<span class="leader"></span>' +
                      '<span class="price">$' + item.price.full + '</span>' +
                    '</div>' +
                    (item.description ? '<div class="desc">' + item.description + '</div>' : '') +
                  '</div>'
                );
              } else {
                var tags = ITEM_TAGS[nameLower] || [];
                itemsHtml.push(
                  '<div class="menu-item">' +
                    '<div class="top">' +
                      '<span class="name">' + item.name + ' ' + renderTags(tags) + '</span>' +
                      '<span class="leader"></span>' +
                      '<span class="price">$' + item.price + '</span>' +
                    '</div>' +
                    (item.description ? '<div class="desc">' + item.description + '</div>' : '') +
                  '</div>'
                );
              }
            });
            return '<div class="menu-col reveal' + (i % 2 ? " d1" : "") + '"><h3>' + cat.name + '</h3>' + itemsHtml.join('') + '</div>';
          }).join("");
          menuGrid.querySelectorAll(".reveal").forEach(function (el) { io.observe(el); });
        } else {
          // Render highlights dynamically
          var highlightsMap = {};
          TARGET_COLS.forEach(function (col) { highlightsMap[col] = []; });
          
          data.categories.forEach(function (cat) {
            var targetCat = HIGHLIGHT_CAT_MAP[cat.name];
            if (!targetCat) return;
            
            cat.items.forEach(function (item) {
              var nameLower = item.name.toLowerCase();
              var isMatch = HIGHLIGHT_NAMES.indexOf(nameLower) !== -1 || (nameLower === 'tandoori chicken' && HIGHLIGHT_NAMES.indexOf('tandoori chicken') !== -1);
              if (isMatch) {
                if (typeof item.price === 'object') {
                  highlightsMap[targetCat].push([item.name + " (Full)", "$" + item.price.full, item.description || ""]);
                } else {
                  highlightsMap[targetCat].push([item.name, "$" + item.price, item.description || ""]);
                }
              }
            });
          });
          
          menuGrid.innerHTML = TARGET_COLS.map(function (col, i) {
            var rows = highlightsMap[col].map(function (it) {
              return '' +
                '<div class="menu-item">' +
                  '<div class="top"><span class="name">' + it[0] + '</span><span class="leader"></span><span class="price">' + it[1] + '</span></div>' +
                  '<div class="desc">' + it[2] + '</div>' +
                '</div>';
            }).join("");
            return '<div class="menu-col reveal' + (i % 2 ? " d1" : "") + '"><h3>' + col + '</h3>' + rows + '</div>';
          }).join("");
          menuGrid.querySelectorAll(".reveal").forEach(function (el) { io.observe(el); });
        }
      })
      .catch(function (err) {
        console.warn("Could not fetch menu JSON, falling back to static/hardcoded menu:", err);
        if (!menuGrid.getAttribute("data-static")) {
          // Fallback highlights rendering
          menuGrid.innerHTML = MENU.map(function (col, i) {
            var rows = col[1].map(function (it) {
              return '' +
                '<div class="menu-item">' +
                  '<div class="top"><span class="name">' + it[0] + '</span><span class="leader"></span><span class="price">' + it[1] + '</span></div>' +
                  '<div class="desc">' + it[2] + '</div>' +
                '</div>';
            }).join("");
            return '<div class="menu-col reveal' + (i % 2 ? " d1" : "") + '"><h3>' + col[0] + '</h3>' + rows + '</div>';
          }).join("");
          menuGrid.querySelectorAll(".reveal").forEach(function (el) { io.observe(el); });
        }
      });
  }

  /* ---------- text stagger splitting ---------- */
  function splitTextNodes(el, baseDelay) {
    if (!el) return;
    var stagger = 0.04;
    var charCount = 0;
    
    function recurse(node) {
      if (node.nodeType === 3) {
        var text = node.textContent;
        var fragment = document.createDocumentFragment();
        var words = text.split(' ');
        for (var w = 0; w < words.length; w++) {
          var wordSpan = document.createElement('span');
          wordSpan.style.whiteSpace = 'nowrap';
          for (var i = 0; i < words[w].length; i++) {
            var span = document.createElement('span');
            span.textContent = words[w][i];
            span.className = 'char-anim';
            span.style.animationDelay = (baseDelay + charCount * stagger) + 's';
            span.style.transitionDelay = (baseDelay + charCount * stagger) + 's';
            wordSpan.appendChild(span);
            charCount++;
          }
          fragment.appendChild(wordSpan);
          if (w < words.length - 1) {
            var spaceSpan = document.createElement('span');
            spaceSpan.innerHTML = '&nbsp;';
            fragment.appendChild(spaceSpan);
            charCount++;
          }
        }
        node.parentNode.replaceChild(fragment, node);
      } else if (node.nodeType === 1 && node.nodeName !== 'BR') {
        Array.from(node.childNodes).forEach(recurse);
      }
    }
    Array.from(el.childNodes).forEach(recurse);
  }

  // Hero section staggered text — l1 uses CSS animation (background-clip:text
  // breaks when child spans have filter applied, so no splitTextNodes on l1)
  var l2Heading = document.querySelector('.hero h1 .l2, .hero.subpage h1 .l2');
  if (l2Heading) {
    splitTextNodes(l2Heading, 0.9);
  }

  // Other headings removed due to rendering bugs with nested opacity and background-clip

  /* ---------- background video carousel controller ---------- */
  (function initHeroCarousel() {
    var slides = document.querySelectorAll(".hero-bg-slide");
    if (slides.length <= 1) return;
    
    var videoSources = [
      "assets/hero.webm",
      "assets/hero2.webm",
      "assets/hero3.webm"
    ];
    
    var currentIdx = 0;
    var startDelay = 1500; // Delay video playback for page assets loading
    
    // Set video src for slides
    slides.forEach(function(slide, idx) {
      var video = slide.querySelector("video");
      if (video) {
        var source = document.createElement("source");
        source.src = videoSources[idx];
        source.type = "video/webm";
        video.appendChild(source);
      }
    });

    function playVideo(idx) {
      var activeSlide = slides[idx];
      if (!activeSlide) return;
      var video = activeSlide.querySelector("video");
      if (!video) return;
      
      video.currentTime = 0;
      video.play().then(function() {
        video.classList.add("playing");
      }).catch(function(err) {
        console.warn("Hero video playback failed:", err);
      });
      
      video.onended = function() {
        video.classList.remove("playing");
        transitionToNext();
      };
    }

    function transitionToNext() {
      slides[currentIdx].classList.remove("active");
      currentIdx = (currentIdx + 1) % slides.length;
      slides[currentIdx].classList.add("active");
      playVideo(currentIdx);
    }

    // Initialize with a smooth delay
    setTimeout(function() {
      playVideo(0);
    }, startDelay);
  })();

  /* ---------- dynamic reservation modal controller ---------- */
  (function initReservationModal() {
    var modalHtml = '' +
      '<div id="reservationModal" class="sgp-overlay" role="dialog" aria-modal="true" aria-hidden="true" style="display: none;">' +
      '  <div class="sgp-backdrop"></div>' +
      '  <div class="sgp-panel" style="width: min(580px, 95%); max-height: 90vh; overflow-y: auto;">' +
      '    <div class="sgp-shine" aria-hidden="true"></div>' +
      '    <div class="sgp-inner" style="padding: clamp(24px, 4vw, 40px) clamp(20px, 3.5vw, 36px);">' +
      '      <span class="sgp-eyebrow eyebrow on-dark center">Book a Table</span>' +
      '      <h2 class="sgp-title gold-text center" style="text-align: center; margin-top: 4px; font-size: clamp(28px, 4vw, 36px);">Reservations</h2>' +
      '      <div class="sgp-divider" aria-hidden="true" style="margin: 12px auto 16px;">' +
      '        <img src="assets/divider.png" alt="" style="width: 140px; margin: 0 auto; display: block;" />' +
      '      </div>' +
      '      ' +
      '      <div class="reserve-card" style="background: none; border: none; padding: 0; box-shadow: none; margin-top: 10px;">' +
      '        <form id="modalReserveForm" novalidate>' +
      '          <div class="form-grid" style="gap: 14px 16px;">' +
      '            <div class="field">' +
      '              <label for="mr-name">Name</label>' +
      '              <input id="mr-name" name="name" type="text" placeholder="Your name" autocomplete="name" />' +
      '              <span class="err"></span>' +
      '            </div>' +
      '            <div class="field">' +
      '              <label for="mr-phone">Phone</label>' +
      '              <input id="mr-phone" name="phone" type="tel" placeholder="(925) 000-0000" autocomplete="tel" />' +
      '              <span class="err"></span>' +
      '            </div>' +
      '            <div class="field">' +
      '              <label for="mr-date">Date</label>' +
      '              <input id="mr-date" name="date" type="date" />' +
      '              <span class="err"></span>' +
      '            </div>' +
      '            <div class="field">' +
      '              <label for="mr-time">Time</label>' +
      '              <input id="mr-time" name="time" type="time" />' +
      '              <span class="err"></span>' +
      '            </div>' +
      '            <div class="field">' +
      '              <label for="mr-party">Party size</label>' +
      '              <select id="mr-party" name="party">' +
      '                <option value="">Select…</option>' +
      '                <option>1 guest</option><option>2 guests</option><option>3 guests</option>' +
      '                <option>4 guests</option><option>5 guests</option><option>6 guests</option>' +
      '                <option>7–10 guests</option><option>10+ (catering)</option>' +
      '              </select>' +
      '              <span class="err"></span>' +
      '            </div>' +
      '            <div class="field">' +
      '              <label for="mr-occasion">Occasion <span style="opacity:.5">(optional)</span></label>' +
      '              <select id="mr-occasion" name="occasion">' +
      '                <option value="">—</option>' +
      '                <option>Family dining</option><option>Birthday</option><option>Anniversary</option>' +
      '                <option>Business lunch</option><option>Catering inquiry</option>' +
      '              </select>' +
      '              <span class="err"></span>' +
      '            </div>' +
      '            <div class="field full">' +
      '              <label for="mr-note">Notes <span style="opacity:.5">(optional)</span></label>' +
      '              <input id="mr-note" name="note" type="text" placeholder="Dietary needs, high chair, big party…" />' +
      '              <span class="err"></span>' +
      '            </div>' +
      '          </div>' +
      '          <div class="reserve-actions" style="margin-top: 24px;">' +
      '            <button type="submit" class="btn btn-gold">Reserve Now</button>' +
      '            <span class="or">or call</span>' +
      '            <a class="tel" href="tel:+19258463077">+1 (925) 846-3077</a>' +
      '          </div>' +
      '        </form>' +
      '        <div class="reserve-success hidden" id="modalReserveSuccess" style="text-align: center; padding-block: 20px;">' +
      '          <div class="check">✓</div>' +
      '          <h3 class="h-sub gold-text">Request received</h3>' +
      '          <p class="body-text on-dark" style="margin:12px auto 0; max-width: 320px;">Thank you, <span id="modalSuccessName">friend</span>. We\'ll call to confirm your table shortly. Looking forward to hosting you at Saffron Grill.</p>' +
      '          <button class="btn btn-ghost" style="margin-top:24px" id="modalReserveReset">Make another request</button>' +
      '        </div>' +
      '      </div>' +
      '    </div>' +
      '    <button class="sgp-close" id="mrClose" aria-label="Close" style="top: 15px; right: 15px;">' +
      '      <svg width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true">' +
      '        <line x1="1" y1="1" x2="11" y2="11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>' +
      '        <line x1="11" y1="1" x2="1" y2="11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>' +
      '      </svg>' +
      '    </button>' +
      '  </div>' +
      '</div>';

    // Append to body
    var div = document.createElement("div");
    div.innerHTML = modalHtml;
    var modalEl = div.firstElementChild;
    document.body.appendChild(modalEl);

    var backdrop = modalEl.querySelector(".sgp-backdrop");
    var panel = modalEl.querySelector(".sgp-panel");
    var closeBtn = modalEl.querySelector("#mrClose");
    var form = modalEl.querySelector("#modalReserveForm");
    var successCard = modalEl.querySelector("#modalReserveSuccess");
    var resetBtn = modalEl.querySelector("#modalReserveReset");

    var dateInput = form.querySelector("#mr-date");
    if (dateInput) {
      dateInput.min = new Date().toISOString().split("T")[0];
    }

    // GSAP Open / Close
    function openModal() {
      document.body.classList.add("sgp-noscroll");
      modalEl.removeAttribute("aria-hidden");
      modalEl.style.display = "flex";

      if (typeof gsap !== "undefined") {
        gsap.set(modalEl, { autoAlpha: 0 });
        gsap.set(backdrop, { opacity: 0 });
        gsap.set(panel, { scale: 0.9, opacity: 0 });

        var tl = gsap.timeline();
        tl.to(modalEl, { autoAlpha: 1, duration: 0.1 })
          .to(backdrop, { opacity: 1, duration: 0.35, ease: "power2.out" }, "-=0.1")
          .to(panel, { scale: 1, opacity: 1, duration: 0.45, ease: "back.out(1.2)" }, "-=0.25");
      } else {
        modalEl.style.opacity = "1";
        backdrop.style.opacity = "1";
        panel.style.transform = "scale(1)";
        panel.style.opacity = "1";
      }
    }

    function closeModal() {
      document.body.classList.remove("sgp-noscroll");
      if (typeof gsap !== "undefined") {
        var tl = gsap.timeline({
          onComplete: function() {
            modalEl.setAttribute("aria-hidden", "true");
            modalEl.style.display = "none";
          }
        });
        tl.to(panel, { scale: 0.9, opacity: 0, duration: 0.3, ease: "power2.in" })
          .to(backdrop, { opacity: 0, duration: 0.25, ease: "power2.in" }, "-=0.15")
          .to(modalEl, { autoAlpha: 0, duration: 0.1 }, "-=0.1");
      } else {
        modalEl.style.display = "none";
      }
    }

    // Intercept clicks on any "Reserve a Table" or related anchors
    document.addEventListener("click", function(e) {
      var target = e.target.closest("a");
      if (!target) return;
      
      var href = target.getAttribute("href") || "";
      var text = (target.textContent || "").trim().toLowerCase();
      var isReserveText = text.indexOf("reserve") !== -1 || text.indexOf("reservation") !== -1;
      
      var isCta = target.classList.contains("nav-cta") || target.classList.contains("btn-gold-slide") || target.classList.contains("btn-gold") || target.classList.contains("btn");
      
      if (isCta && (isReserveText || href.indexOf("#reserve") !== -1 || href.indexOf("contact.html#reserve") !== -1)) {
        e.preventDefault();
        openModal();
      }
    });

    closeBtn.addEventListener("click", closeModal);
    backdrop.addEventListener("click", closeModal);

    // Escape key listener
    window.addEventListener("keydown", function(e) {
      if (e.key === "Escape" && modalEl.style.display === "flex") {
        closeModal();
      }
    });

    // Form Validation Helper
    function setModalErr(field, msg) {
      var f = field.closest(".field");
      var e = f.querySelector(".err");
      if (msg) {
        f.classList.add("error");
        e.textContent = msg;
      } else {
        f.classList.remove("error");
        e.textContent = "";
      }
      return !msg;
    }

    form.addEventListener("submit", function (ev) {
      ev.preventDefault();
      var ok = true;
      var name = form.querySelector("#mr-name");
      var phone = form.querySelector("#mr-phone");
      var date = form.querySelector("#mr-date");
      var time = form.querySelector("#mr-time");
      var party = form.querySelector("#mr-party");

      ok = setModalErr(name, name.value.trim().length < 2 ? "Please tell us your name" : "") && ok;
      var digits = phone.value.replace(/\D/g, "");
      ok = setModalErr(phone, digits.length < 10 ? "A valid phone number, please" : "") && ok;
      ok = setModalErr(date, !date.value ? "Pick a date" : "") && ok;
      ok = setModalErr(time, !time.value ? "Pick a time" : "") && ok;
      ok = setModalErr(party, !party.value ? "How many guests?" : "") && ok;

      if (!ok) {
        var firstErr = form.querySelector(".field.error input, .field.error select");
        if (firstErr) firstErr.focus();
        return;
      }
      modalEl.querySelector("#modalSuccessName").textContent = name.value.trim().split(" ")[0];
      form.classList.add("hidden");
      successCard.classList.remove("hidden");
    });

    // clear error on input
    form.querySelectorAll("input, select").forEach(function (el) {
      el.addEventListener("input", function () {
        setModalErr(el, "");
      });
    });

    resetBtn.addEventListener("click", function () {
      form.reset();
      successCard.classList.add("hidden");
      form.classList.remove("hidden");
    });
  })();

  /* ---------- Contact Form Handling ---------- */
  (function initContactForm() {
    var cForm = document.getElementById("contactForm");
    if (!cForm) return;

    var successCard = document.getElementById("contactSuccess");
    var resetBtn = document.getElementById("contactReset");

    function setContactErr(field, msg) {
      var f = field.closest(".field");
      var e = f.querySelector(".err");
      if (msg) {
        f.classList.add("error");
        e.textContent = msg;
      } else {
        f.classList.remove("error");
        e.textContent = "";
      }
      return !msg;
    }

    cForm.addEventListener("submit", function(ev) {
      ev.preventDefault();
      var ok = true;
      var name = cForm.querySelector("#c-name");
      var phone = cForm.querySelector("#c-phone");
      var email = cForm.querySelector("#c-email");
      var subject = cForm.querySelector("#c-subject");
      var message = cForm.querySelector("#c-message");

      ok = setContactErr(name, name.value.trim().length < 2 ? "Please tell us your name" : "") && ok;
      
      var digits = phone.value.replace(/\D/g, "");
      ok = setContactErr(phone, digits.length < 10 ? "A valid phone number, please" : "") && ok;
      
      var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      ok = setContactErr(email, !emailRegex.test(email.value.trim()) ? "Please enter a valid email address" : "") && ok;
      
      ok = setContactErr(subject, !subject.value ? "Please select a subject" : "") && ok;
      ok = setContactErr(message, message.value.trim().length < 10 ? "Please write a message (min. 10 characters)" : "") && ok;

      if (!ok) {
        var firstErr = cForm.querySelector(".field.error input, .field.error select, .field.error textarea");
        if (firstErr) firstErr.focus();
        return;
      }

      document.getElementById("contactSuccessName").textContent = name.value.trim().split(" ")[0];
      cForm.classList.add("hidden");
      successCard.classList.remove("hidden");
    });

    cForm.querySelectorAll("input, select, textarea").forEach(function(el) {
      el.addEventListener("input", function() {
        setContactErr(el, "");
      });
    });

    resetBtn.addEventListener("click", function() {
      cForm.reset();
      successCard.classList.add("hidden");
      cForm.classList.remove("hidden");
    });
  })();
})();
