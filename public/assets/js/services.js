const FoodService = (() => {
  const loadCatalog = async () => {
    const res = await fetch("ws_catalog.php");
    if (!res.ok) {
      throw new Error("Failed to load catalog");
    }
    return res.json();
  };
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