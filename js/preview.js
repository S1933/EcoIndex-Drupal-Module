((Drupal, drupalSettings) => {
  // Number of elements.
  const elementCount = document.querySelectorAll(
    '*:not(#toolbar-administration, #node-preview-form-select)',
  ).length;

  // Number of requests.
  const resources = performance.getEntriesByType('resource');
  const requestCount = resources.length;

  // Total size (KB).
  const totalSizeKB =
    resources.reduce((total, resource) => total + resource.transferSize, 0) /
    1024;

  // Get EcoIndex score.
  const ecoIndex = computeEcoIndex(elementCount, requestCount, totalSizeKB);
  const score = Math.round(Number(ecoIndex));
  const grade = getEcoIndexGrade(score);

  // Send messages.
  const messages = new Drupal.Message();
  messages.add(`EcoIndex: Score ${score} - Grade ${grade}.`);

  const minimumScore = drupalSettings.ecoindex.minimum_score;
  if (minimumScore > 0 && score < minimumScore) {
    messages.add(
      `You have not reached the minimum score(${minimumScore}) defined.`,
      { type: 'warning' },
    );
  }

  const currentScore = Math.round(Number(drupalSettings.ecoindex.score));
  const diff = Math.abs(score - currentScore);
  if (diff > 2) {
    // Save score and grade value with localStorage.
    const nid = drupalSettings.ecoindex.nid;
    localStorage.setItem(`ecoindex.score.en.${nid}`, score);
    localStorage.setItem(`ecoindex.grade.en.${nid}`, grade);
  }
})(Drupal, drupalSettings);
