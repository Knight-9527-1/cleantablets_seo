(function () {
  var toggle = document.querySelector("[data-bunjoin-menu-toggle]");
  var menu = document.getElementById("bunjoin-primary-menu");

  if (!toggle || !menu) {
    return;
  }

  function setOpen(isOpen) {
    toggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
    menu.classList.toggle("is-open", isOpen);
    document.body.classList.toggle("bunjoin-menu-open", isOpen);
  }

  toggle.addEventListener("click", function () {
    setOpen(toggle.getAttribute("aria-expanded") !== "true");
  });

  menu.addEventListener("click", function (event) {
    if (event.target && event.target.tagName === "A") {
      setOpen(false);
    }
  });

  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
      setOpen(false);
    }
  });
})();
