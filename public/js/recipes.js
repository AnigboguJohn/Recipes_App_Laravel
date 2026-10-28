/* My Recipes Book: small enhancements. Every page also works without JavaScript. */
(function () {
  "use strict";
  var token = (document.querySelector('meta[name="csrf-token"]') || {}).content;

  // Save (heart) buttons: save without reloading the page.
  document.addEventListener("submit", function (e) {
    var form = e.target.closest(".save-form");
    if (!form || !window.fetch) return;
    e.preventDefault();
    var btn = form.querySelector(".heart");
    fetch(form.action, {
      method: "POST",
      headers: { "X-CSRF-TOKEN": token, Accept: "application/json", "X-Requested-With": "XMLHttpRequest" },
      credentials: "same-origin",
    })
      .then(function (r) { if (!r.ok) throw r; return r.json(); })
      .then(function (d) {
        document.querySelectorAll('.save-form[action="' + form.action + '"] .heart').forEach(function (h) {
          h.classList.toggle("on", d.saved);
          h.setAttribute("aria-pressed", String(d.saved));
          h.setAttribute("aria-label", d.saved ? "Remove from saved" : "Save recipe");
        });
        btn.classList.remove("pop"); void btn.offsetWidth; btn.classList.add("pop");
      })
      .catch(function () { form.submit(); });
  });

  // Photo previews on the recipe form and the profile form.
  function preview(input, img) {
    if (!input || !img) return;
    input.addEventListener("change", function () {
      var f = input.files && input.files[0];
      if (!f) return;
      img.src = URL.createObjectURL(f);
      img.hidden = false;
    });
  }
  preview(document.getElementById("image"), document.querySelector(".drop-preview"));
  preview(document.getElementById("avatar"), document.querySelector(".avatar-preview"));

  // Login: fill in the demo account.
  var demo = document.getElementById("useDemo");
  if (demo) demo.addEventListener("click", function () {
    document.getElementById("email").value = "demo@recipes.test";
    document.getElementById("password").value = "demo12345";
    demo.closest(".auth-card").querySelector("form").requestSubmit();
  });

  // Cooking mode: one step at a time, with a timer when the step mentions minutes.
  var cook = document.getElementById("cook");
  if (cook) {
    var cards = cook.querySelectorAll(".cook-step");
    var dots = cook.querySelectorAll(".dots i");
    var total = Number(cook.dataset.steps);
    var prev = document.getElementById("prevStep");
    var next = document.getElementById("nextStep");
    var now = document.getElementById("stepNow");
    var at = 0;
    function show(i) {
      at = Math.max(0, Math.min(total, i));
      cards.forEach(function (c, n) { c.hidden = n !== at; });
      dots.forEach(function (d, n) { d.className = n === at ? "on" : n < at ? "done" : ""; });
      now.textContent = at < total ? "Step " + (at + 1) : "Done";
      prev.disabled = at === 0;
      next.hidden = at >= total;
      next.innerHTML = at === total - 1 ? "Finish ✓" : next.dataset.label;
      window.scrollTo({ top: 0, behavior: "smooth" });
    }
    next.dataset.label = next.innerHTML;
    prev.addEventListener("click", function () { show(at - 1); });
    next.addEventListener("click", function () { show(at + 1); });
    document.addEventListener("keydown", function (e) {
      if (e.key === "ArrowRight" && !next.hidden) show(at + 1);
      if (e.key === "ArrowLeft" && at > 0) show(at - 1);
    });
    now.textContent = "Step 1";

    cook.querySelectorAll(".timer").forEach(function (t) {
      var full = Number(t.dataset.seconds), left = full, tick = null;
      var face = t.querySelector(".timer-face"), go = t.querySelector(".timer-go"), reset = t.querySelector(".timer-reset");
      var goLabel = go.innerHTML;
      function draw() {
        var m = Math.floor(left / 60), s = left % 60;
        face.textContent = String(m).padStart(2, "0") + ":" + String(s).padStart(2, "0");
      }
      function stop() { clearInterval(tick); tick = null; go.innerHTML = goLabel; }
      go.addEventListener("click", function () {
        if (tick) { stop(); go.innerHTML = "Resume"; return; }
        if (left <= 0) left = full;
        t.classList.remove("done");
        go.innerHTML = "Pause";
        tick = setInterval(function () {
          left -= 1; draw();
          if (left <= 0) {
            stop(); t.classList.add("done"); face.textContent = "Done!";
            if (navigator.vibrate) navigator.vibrate([300, 150, 300]);
          }
        }, 1000);
      });
      reset.addEventListener("click", function () { stop(); left = full; t.classList.remove("done"); draw(); });
    });
  }
})();
