((Drupal, drupalSettings) => {
  const messages = new Drupal.Message();
  messages.clear();

  // Number of elements.
  const elementCount = document.querySelectorAll("*:not(#toolbar-administration, #node-preview-form-select)").length;

  // Number of requests.
  const resources = performance.getEntriesByType("resource");
  const requestCount = resources.length;

  // Total size (KB).
  const totalSizeKB = resources.reduce((total, resource) => total + resource.transferSize, 0) / 1024;

  // Get EcoIndex score.
  const ecoIndex = computeEcoIndex(elementCount, requestCount, totalSizeKB);
  const score = Math.round(Number(ecoIndex));
  const grade = getEcoIndexGrade(score);
  messages.add(`EcoIndex ${score} - Grade ${grade}`);

  // Get minimum score if exists.
  const minimumScore = drupalSettings.ecoindex.minimum_score;
  if (minimumScore > 0 && score < minimumScore) {
    messages.add(`Minimum score ${minimumScore}`, { type: "warning" });
  }

  // Get EcoIndex fieldname.
  const ecoindexFieldname = drupalSettings.ecoindex.ecoindex_fieldname;

  async function fetchToken() {
    const url = "/session/token";
    try {
      const response = await fetch(url);
      if (!response.ok) {
        throw new Error(`Response status: ${response.status}`);
      }
      return response.text();
    } catch (error) {
      console.error(error.message);
      throw error;
    }
  }

  function updateEcoIndexField(token) {
    const headers = new Headers({
      "Content-Type": "application/json",
      "X-CSRF-Token": token,
    });

    const body = JSON.stringify({
      type: [{ target_id: drupalSettings.ecoindex.content_type }],
      ecoindexFieldname: [{ score: score, grade: grade }],
    });

    const requestOptions = {
      method: "PATCH",
      headers: headers,
      body: body,
      redirect: "follow",
    };

    const url = `/node/${drupalSettings.ecoindex.nid}?_format=json`;

    fetch(url, requestOptions)
      .then((response) => response.text())
      .then((result) => console.log(result))
      .catch((error) => console.error("error", error));
  }

  async function updateEcoIndex() {
    try {
      const token = await fetchToken();
      updateEcoIndexField(token);
    } catch (error) {
      console.error("Failed to update EcoIndex field", error);
    }
  }

  updateEcoIndex();
})(Drupal, drupalSettings);
