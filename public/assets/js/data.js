const FoodData = (() => {
  const getProductsFromDOM = () => {
    const cards = document.querySelectorAll("[data-product]");
    return Array.from(cards).map(card => ({
      name: card.dataset.name,
      category: card.dataset.category,
      price: Number(card.dataset.price) || 0,
      element: card
    }));
  };

  const groupByCategory = products =>
    products.reduce((acc, item) => {
      acc[item.category] = (acc[item.category] || 0) + 1;
      return acc;
    }, {});

  const getStats = () => {
    const products = getProductsFromDOM();
    if (!products.length) {
      return {
        total: 0,
        avgPrice: 0,
        byCategory: {},
        products
      };
    }

    const total = products.length;
    const totalPrice = products.reduce((sum, item) => sum + item.price, 0);
    const avgPrice = Math.round(totalPrice / total);
    const byCategory = groupByCategory(products);

    return { total, avgPrice, byCategory, products };
  };

  return {
    getProductsFromDOM,
    groupByCategory,
    getStats
  };
})();