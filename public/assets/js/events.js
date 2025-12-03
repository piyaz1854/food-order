// events.js
// События: поиск, bling, Bigger Pimpin', сортировка, hover и keydown

document.addEventListener("DOMContentLoaded", () => {
  const searchInput   = document.querySelector("#menu-search");
  const biggerBtn     = document.querySelector("#bigger-pimpin-btn");
  const blingCheckbox = document.querySelector("#bling-checkbox");
  const sortBtn       = document.querySelector("#sort-price-btn");
  const cards         = FoodData.getProductsFromDOM();
  const menuContainer = document.querySelector(".menu");

  // вспомогательный toast
  const showToast = message => {
    const toast = document.createElement("div");
    toast.textContent = message;

    toast.style.position = "fixed";
    toast.style.bottom = "20px";
    toast.style.right = "20px";
    toast.style.background = "#facc15";
    toast.style.color = "#111827";
    toast.style.padding = "8px 12px";
    toast.style.borderRadius = "999px";
    toast.style.fontSize = "13px";
    toast.style.boxShadow = "0 4px 12px rgba(0,0,0,0.4)";
    toast.style.zIndex = "9999";

    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 2000);
  };

  // === 1) input + keydown (filter) ===
  if (searchInput) {
    // input (фильтр)
    searchInput.addEventListener("input", e => {
      const query = e.target.value.toLowerCase().trim();
      const items = FoodData.getProductsFromDOM();
      const matching = items.filter(item =>
        item.name.toLowerCase().includes(query)
      );

      items.forEach(item => {
        const isMatch = matching.includes(item) || query === "";
        item.element.style.display = isMatch ? "" : "none";
      });

      searchInput.style.borderColor = query ? "#facc15" : "#4b5563";
    });

    // keydown (Escape очищает поиск, Enter показывает toast)
    searchInput.addEventListener("keydown", e => {
      if (e.key === "Escape") {
        searchInput.value = "";
        const items = FoodData.getProductsFromDOM();
        items.forEach(item => {
          item.element.style.display = "";
        });
        searchInput.style.borderColor = "#4b5563";
      }
      if (e.key === "Enter") {
        e.preventDefault();
        showToast("Searching for: " + searchInput.value);
      }
    });
  }

  // === 2) Bigger Pimpin' Button (click) ===
  if (biggerBtn) {
    let scale = 1;

    biggerBtn.addEventListener("click", () => {
      scale *= 1.05; // +5% каждый клик
      biggerBtn.style.transform = `scale(${scale})`;
      biggerBtn.style.transformOrigin = "center";
    });
  }

  // === 3) Bling Checkbox (click) ===
  if (blingCheckbox) {
    blingCheckbox.addEventListener("click", () => {
      // берём все блюда и считаем среднюю цену
      const stats = FoodData.getStats();
      const threshold = stats.avgPrice;
      const products = FoodData.getProductsFromDOM();

      if (blingCheckbox.checked) {
        document.body.classList.add("bling-mode");

        // дорогие (цена > средней) подсвечиваем
        products.forEach(p => {
          if (!p.element) return;
          if (p.price > threshold) {
            p.element.classList.add("card-expensive");
          } else {
            p.element.classList.remove("card-expensive");
          }
        });
      } else {
        document.body.classList.remove("bling-mode");

        // при выключении блеска — убираем подсветку у всех
        products.forEach(p => {
          if (!p.element) return;
          p.element.classList.remove("card-expensive");
        });
      }
    });
  }


  // === 4) Sort by price (click) ===
  if (sortBtn && menuContainer) {
    let ascending = true;

    sortBtn.addEventListener("click", () => {
      const items = FoodData.getProductsFromDOM();

      const sorted = [...items].sort((a, b) =>
        ascending ? a.price - b.price : b.price - a.price
      );

      sorted.forEach(item => {
        if (item.element) {
          menuContainer.appendChild(item.element);
        }
      });

      sortBtn.textContent = ascending
        ? "Sort by price ↓"
        : "Sort by price ↑";

      ascending = !ascending;
    });
  }

  // === 5) mouseover / mouseout для карточек ===
  cards.forEach(item => {
    if (!item.element) return;

    item.element.addEventListener("mouseover", () => {
      item.element.classList.add("card-hover");
    });

    item.element.addEventListener("mouseout", () => {
      item.element.classList.remove("card-hover");
    });
  });

  // маленький эффект на всех кнопках (mousedown / mouseup)
  const buttons = Array.from(document.querySelectorAll("button, .btn"));
  buttons.forEach(btn => {
    btn.addEventListener("mousedown", () => {
      btn.classList.add("btn-pressed");
    });
    ["mouseup", "mouseleave"].forEach(ev =>
      btn.addEventListener(ev, () => btn.classList.remove("btn-pressed"))
    );
  });

    // === Web Service v1: load catalog via fetch and show preview ===
  const wsPreview = document.querySelector("#ws-catalog-preview");
  if (wsPreview) {
    FoodService.loadCatalog()
      .then(data => {
        if (data.status !== "ok" || !Array.isArray(data.items)) {
          wsPreview.textContent = "Could not load catalog via Web Service.";
          return;
        }

        // возьмём 3 самых дешевых блюда
        const sorted = [...data.items]
          .filter(item => typeof item.price === "number" || !isNaN(Number(item.price)))
          .sort((a, b) => Number(a.price) - Number(b.price))
          .slice(0, 3);

        if (!sorted.length) {
          wsPreview.textContent = "No items in catalog (from Web Service).";
          return;
        }

        const text = sorted
          .map(item => `${item.name} (${item.price} ₸)`)
          .join(" · ");

        wsPreview.innerHTML = `Loaded from Web Service v1: <strong>${text}</strong>`;
      })
      .catch(err => {
        console.error(err);
        wsPreview.textContent = "Error loading catalog via Web Service.";
      });
  }


    // === Web Service v2: feedback form via fetch (no reload) ===
  const feedbackForm   = document.querySelector("#feedback-form");
  const feedbackName   = document.querySelector("#feedback-name");
  const feedbackMsg    = document.querySelector("#feedback-message");
  const feedbackStatus = document.querySelector("#feedback-status");

  if (feedbackForm && feedbackName && feedbackMsg && feedbackStatus) {
    feedbackForm.addEventListener("submit", async (e) => {
      e.preventDefault(); // 🔥 не даём форме перезагрузить страницу

      const payload = {
        name: feedbackName.value.trim(),
        message: feedbackMsg.value.trim()
      };

      if (!payload.name || !payload.message) {
        feedbackStatus.textContent = "Please fill in both fields.";
        return;
      }

      feedbackStatus.textContent = "Sending...";

      try {
        const response = await FoodService.sendFeedback(payload);
        if (response.status === "ok") {
          feedbackStatus.textContent = "Thanks! Your feedback was saved.";
          feedbackName.value = "";
          feedbackMsg.value = "";
        } else {
          feedbackStatus.textContent = "Error: " + (response.message || "unknown error");
        }
      } catch (err) {
        console.error(err);
        feedbackStatus.textContent = "Error sending feedback via Web Service.";
      }
    });
  }



    // === Maze mini-challenge ===
  const maze       = document.querySelector("#pizza-maze");
  const mazeStart  = maze ? maze.querySelector(".maze-start") : null;
  const mazeEnd    = maze ? maze.querySelector(".maze-end") : null;
  const mazeWalls  = maze ? Array.from(maze.querySelectorAll(".maze-wall")) : [];
  const mazeStatus = document.querySelector("#maze-status");
  const mazeRestartBtn = document.querySelector("#maze-restart-btn");

  let mazeActive = false;
  let mazeFailed = false;

  const resetMaze = () => {
    mazeActive = false;
    mazeFailed = false;
    mazeWalls.forEach(w => w.classList.remove("maze-wall-hit"));
    if (mazeStatus) {
      mazeStatus.textContent = "Move mouse from START to PIZZA without touching walls.";
    }
  };

  if (maze && mazeStart && mazeEnd && mazeStatus && mazeRestartBtn) {
    // начальное состояние
    resetMaze();

    // начинаем попытку при входе в START
    mazeStart.addEventListener("mouseenter", () => {
      mazeActive = true;
      mazeFailed = false;
      mazeWalls.forEach(w => w.classList.remove("maze-wall-hit"));
      mazeStatus.textContent = "Careful... don't touch the slime walls!";
    });

    // если задели стенку
    mazeWalls.forEach(wall => {
      wall.addEventListener("mouseenter", () => {
        if (!mazeActive) return;
        mazeFailed = true;
        wall.classList.add("maze-wall-hit");
        mazeStatus.textContent = "You hit the wall! Click restart to try again.";
      });
    });

    // дошли до конца
    mazeEnd.addEventListener("mouseenter", () => {
      if (!mazeActive) return;

      if (!mazeFailed) {
        mazeActive = false;
        mazeStatus.textContent = "Nice! You passed the maze – secret slice unlocked!";
        // нотификация (у тебя уже есть showToast)
        if (typeof showToast === "function") {
          showToast("Maze completed! 🍕");
        }
      } else {
        mazeStatus.textContent = "You reached PIZZA, but you touched the walls. Restart.";
      }
    });

    // выход мыши за пределы лабиринта – сбрасываем активную попытку
    maze.addEventListener("mouseleave", () => {
      if (mazeActive && !mazeFailed) {
        mazeStatus.textContent = "You left the maze area. Start again from START.";
      }
      mazeActive = false;
    });

    // кнопка перезапуска
    mazeRestartBtn.addEventListener("click", () => {
      resetMaze();
    });
  }



});
