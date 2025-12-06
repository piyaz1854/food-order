const FoodUI = (() => {
  const renderMenuStats = stats => {
    const statsEl = document.querySelector("#menu-stats");
    if (!statsEl || !stats) return;

    const categoryParts = Object.entries(stats.byCategory)
      .map(([cat, count]) => `${cat}: ${count}`)
      .join(" · ");

    statsEl.innerHTML = `
      <strong>${stats.total}</strong> dishes ·
      average price <strong>${stats.avgPrice} ₸</strong><br>
      <span>${categoryParts}</span>
    `;
  };
  const markExpensiveDishes = stats => {
    if (!stats) return;
    const threshold = stats.avgPrice;
    const cards = FoodData.getProductsFromDOM();

    cards.forEach(item => {
      if (!item.element) return;
      item.element.classList.toggle("card-expensive", item.price > threshold);
    });
  };
  const clearExpensiveHighlights = () => {
    const cards = FoodData.getProductsFromDOM();
    cards.forEach(item => {
      if (!item.element) return;
      item.element.classList.remove("card-expensive");
    });
  };

  const createDynamicTips = stats => {
    const section = document.querySelector(".home-section");
    if (!section || !stats) return;

    const tipsContainer = document.createElement("div");
    tipsContainer.className = "dynamic-tips";

    const tips = [
      "Tip: use categories to find pizza faster.",
      `We have ${stats.total} dishes in total.`,
      `Average dish price is around ${stats.avgPrice} ₸.`
    ];

    tips.forEach(text => {
      const badge = document.createElement("span");
      badge.className = "tip-badge";
      badge.textContent = text;
      tipsContainer.appendChild(badge);
    });

    section.insertBefore(tipsContainer, section.querySelector(".menu"));
  };

  return {
    renderMenuStats,
    markExpensiveDishes,
    clearExpensiveHighlights,
    createDynamicTips
  };
})();
document.addEventListener("DOMContentLoaded", () => {
  if (!document.querySelector("[data-product]")) return;

  const stats = FoodData.getStats();
  FoodUI.renderMenuStats(stats);
  FoodUI.createDynamicTips(stats);
});