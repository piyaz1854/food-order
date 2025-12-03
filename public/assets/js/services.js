// services.js
// Модуль для работы с PHP web services

const FoodService = (() => {
  // Web Service v1 – загрузка каталога
  const loadCatalog = async () => {
    const res = await fetch("ws_catalog.php"); // относительный путь от pages/
    if (!res.ok) {
      throw new Error("Failed to load catalog");
    }
    return res.json();
  };

  // Web Service v2 – отправка feedback
  const sendFeedback = async (payload) => {
    const res = await fetch("ws_feedback.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify(payload)
    });

    if (!res.ok) {
      throw new Error("Failed to send feedback");
    }

    return res.json();
  };

  return {
    loadCatalog,
    sendFeedback
  };
})();
